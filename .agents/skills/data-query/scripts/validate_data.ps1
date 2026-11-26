<#
.SYNOPSIS
    Validates portfolio JSON datasets in data/*.json and checks PHP syntax if available.
#>

$ErrorActionPreference = 'Stop'

$repoRoot = (Resolve-Path (Join-Path $PSScriptRoot '..\..\..\..')).Path
$dataDir = Join-Path $repoRoot 'data'

$schemaRules = @{
    'project.json'      = @('id', 'title', 'tagline', 'description', 'category', 'role', 'year', 'tags', 'featured')
    'experience.json'   = @('id', 'role', 'organization', 'type', 'location', 'start_date', 'is_current', 'summary', 'highlights')
    'education.json'    = @('id', 'institution', 'degree', 'start_date', 'is_current')
    'photography.json'  = @('id', 'title', 'alt', 'src', 'category', 'date', 'featured')
    'volunteer.json'    = @('id', 'program_name', 'position', 'program_date', 'place')
    'organization.json' = @('id', 'organization', 'position', 'start_date', 'is_current')
}

$errors = [System.Collections.Generic.List[string]]::new()
$warnings = [System.Collections.Generic.List[string]]::new()

Write-Host "Validating datasets in $dataDir..." -ForegroundColor Cyan

foreach ($fileName in $schemaRules.Keys | Sort-Object) {
    $filePath = Join-Path $dataDir $fileName
    if (-not (Test-Path $filePath)) {
        $warnings.Add("Missing dataset file: data/$fileName")
        continue
    }

    $raw = Get-Content -Path $filePath -Raw -Encoding UTF8
    if ([string]::IsNullOrWhiteSpace($raw)) {
        $warnings.Add("Empty dataset file (0 records): data/$fileName — initialize with [] or add entries.")
        continue
    }

    try {
        $parsed = $raw | ConvertFrom-Json
    }
    catch {
        $errors.Add("Invalid JSON syntax in data/${fileName}: $($_.Exception.Message)")
        continue
    }

    # Ensure top-level array
    $trimmed = $raw.TrimStart()
    if (-not $trimmed.StartsWith('[')) {
        $errors.Add("data/$fileName must be a top-level JSON array [...].")
        continue
    }

    $items = @($parsed)
    $seenIds = @{}
    $requiredKeys = $schemaRules[$fileName]

    for ($i = 0; $i -lt $items.Count; $i++) {
        $item = $items[$i]
        $props = $item.PSObject.Properties.Name

        foreach ($key in $requiredKeys) {
            if ($props -notcontains $key) {
                $errors.Add("data/${fileName}[$i] is missing required key '$key'.")
            }
        }

        if ($props -contains 'id') {
            $id = [string]$item.id
            if ([string]::IsNullOrWhiteSpace($id)) {
                $errors.Add("data/${fileName}[$i] has an empty 'id'.")
            }
            elseif ($seenIds.ContainsKey($id)) {
                $errors.Add("data/${fileName} contains duplicate id '$id'.")
            }
            else {
                $seenIds[$id] = $true
            }
        }

        # Check image alt & local asset paths
        if ($props -contains 'image' -and -not [string]::IsNullOrWhiteSpace([string]$item.image)) {
            if ($props -notcontains 'image_alt' -or [string]::IsNullOrWhiteSpace([string]$item.image_alt)) {
                $errors.Add("data/${fileName}[$i] sets 'image' without non-empty 'image_alt'.")
            }
            $imgPath = [string]$item.image
            if ($imgPath.StartsWith('asset/')) {
                $fullAsset = Join-Path $repoRoot ($imgPath -replace '/', '\')
                if (-not (Test-Path $fullAsset)) {
                    $warnings.Add("data/${fileName}[$i] references missing local asset: $imgPath")
                }
            }
        }

        if ($props -contains 'src' -and -not [string]::IsNullOrWhiteSpace([string]$item.src)) {
            $srcPath = [string]$item.src
            if ($srcPath.StartsWith('asset/')) {
                $fullAsset = Join-Path $repoRoot ($srcPath -replace '/', '\')
                if (-not (Test-Path $fullAsset)) {
                    $warnings.Add("data/${fileName}[$i] references missing local asset: $srcPath")
                }
            }
        }

        if ($props -contains 'gallery' -and $null -ne $item.gallery) {
            $galleryItems = @($item.gallery)
            for ($g = 0; $g -lt $galleryItems.Count; $g++) {
                $gItem = $galleryItems[$g]
                $gProps = $gItem.PSObject.Properties.Name
                if ($gProps -notcontains 'src' -or [string]::IsNullOrWhiteSpace([string]$gItem.src)) {
                    $errors.Add("data/${fileName}[$i].gallery[$g] is missing 'src'.")
                }
                else {
                    $gSrc = [string]$gItem.src
                    if ($gSrc.StartsWith('asset/')) {
                        $fullGAsset = Join-Path $repoRoot ($gSrc -replace '/', '\')
                        if (-not (Test-Path $fullGAsset)) {
                            $warnings.Add("data/${fileName}[$i].gallery[$g] references missing local asset: $gSrc")
                        }
                    }
                }
                if ($gProps -notcontains 'alt' -or [string]::IsNullOrWhiteSpace([string]$gItem.alt)) {
                    $errors.Add("data/${fileName}[$i].gallery[$g] is missing non-empty 'alt'.")
                }
            }
        }
    }

    Write-Host "  [OK] data/$fileName ($($items.Count) item(s))" -ForegroundColor Green
}

# Optional PHP lint check if php CLI is available
$phpCmd = Get-Command php -ErrorAction SilentlyContinue
if ($phpCmd) {
    Write-Host "Running PHP syntax lint..." -ForegroundColor Cyan
    $phpFiles = Get-ChildItem -Path $repoRoot -Filter '*.php' -Recurse -File
    foreach ($pf in $phpFiles) {
        $lintOut = & $phpCmd.Source -l $pf.FullName 2>&1
        if ($LASTEXITCODE -ne 0) {
            $errors.Add("PHP syntax error in $($pf.Name): $lintOut")
        }
        else {
            Write-Host "  [OK] $($pf.Name)" -ForegroundColor Green
        }
    }
}
else {
    Write-Host "PHP CLI not found in PATH — skipped php -l check." -ForegroundColor DarkGray
}

if ($warnings.Count -gt 0) {
    Write-Host "`nWarnings ($($warnings.Count)):" -ForegroundColor Yellow
    foreach ($w in $warnings) {
        Write-Host "  - $w" -ForegroundColor Yellow
    }
}

if ($errors.Count -gt 0) {
    Write-Host "`nErrors ($($errors.Count)):" -ForegroundColor Red
    foreach ($err in $errors) {
        Write-Host "  - $err" -ForegroundColor Red
    }
    exit 1
}

Write-Host "`nValidation completed with 0 errors." -ForegroundColor Green
exit 0
