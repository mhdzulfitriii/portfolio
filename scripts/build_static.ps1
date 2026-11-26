<#
.SYNOPSIS
    Builds static HTML files (index.html, projects.html, experience.html, education.html,
    photography.html, volunteer.html) from the PHP templates for GitHub Pages deployment.
#>

$ErrorActionPreference = 'Stop'

$repoRoot = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
$phpCmd = Get-Command php -ErrorAction Stop

$pages = @(
    @{ Source = 'index.php';       Target = 'index.html' },
    @{ Source = 'projects.php';    Target = 'projects.html' },
    @{ Source = 'experience.php';  Target = 'experience.html' },
    @{ Source = 'education.php';   Target = 'education.html' },
    @{ Source = 'photography.php'; Target = 'photography.html' },
    @{ Source = 'volunteer.php';   Target = 'volunteer.html' }
)

$utf8NoBom = New-Object System.Text.UTF8Encoding($false)

# Ensure .nojekyll exists at repository root for GitHub Pages
$noJekyllPath = Join-Path $repoRoot '.nojekyll'
if (-not (Test-Path $noJekyllPath)) {
    [System.IO.File]::WriteAllText($noJekyllPath, '', $utf8NoBom)
    Write-Host "Created .nojekyll" -ForegroundColor Cyan
}

Push-Location $repoRoot
try {
    foreach ($p in $pages) {
        $srcPath = Join-Path $repoRoot $p.Source
        $outPath = Join-Path $repoRoot $p.Target

        $rendered = & $phpCmd.Source -d display_errors=1 -d error_reporting=E_ALL -f $srcPath 2>&1 | Out-String
        if ($LASTEXITCODE -ne 0 -or $rendered -match 'Warning:|Notice:|Fatal error:|Parse error:') {
            throw "PHP rendering error while building $($p.Source):`n$rendered"
        }

        # Rewrite internal .php page links to .html for static GitHub Pages routing
        $staticHtml = $rendered
        foreach ($linkMap in $pages) {
            $from = [regex]::Escape($linkMap.Source)
            $to   = $linkMap.Target
            $staticHtml = [regex]::Replace($staticHtml, "(?<=href=[""'])$from(?=[""'#?])", $to)
        }

        [System.IO.File]::WriteAllText($outPath, $staticHtml, $utf8NoBom)
        Write-Host "  [BUILT] $($p.Target) ($($staticHtml.Length) bytes)" -ForegroundColor Green
    }

    # Case-sensitive verification of every referenced asset/ path (critical for GitHub Pages Linux servers)
    Write-Host "`nVerifying case-exact local asset paths..." -ForegroundColor Cyan
    $allDiskAssets = @{}
    Get-ChildItem -Path (Join-Path $repoRoot 'asset') -Recurse -File | ForEach-Object {
        $rel = $_.FullName.Substring($repoRoot.Length + 1) -replace '\\', '/'
        $allDiskAssets[$rel] = $true
    }

    $caseIssues = [System.Collections.Generic.List[string]]::new()
    foreach ($p in $pages) {
        $html = Get-Content -Path (Join-Path $repoRoot $p.Target) -Raw -Encoding UTF8
        $matches = [regex]::Matches($html, 'asset/[A-Za-z0-9_./()\-\s]+?\.(?:svg|png|jpe?g|webp|gif|pdf)', 'IgnoreCase')
        foreach ($m in $matches) {
            $ref = $m.Value
            if (-not $allDiskAssets.ContainsKey($ref)) {
                $caseIssues.Add("$($p.Target) references '$ref' which does not match exact filename/casing on disk.")
            }
        }
    }

    if ($caseIssues.Count -gt 0) {
        Write-Host "`nCase/Path Issues Found:" -ForegroundColor Red
        foreach ($issue in ($caseIssues | Select-Object -Unique)) {
            Write-Host "  - $issue" -ForegroundColor Red
        }
        exit 1
    }

    Write-Host "All referenced asset paths exist with exact case sensitivity." -ForegroundColor Green
}
finally {
    Pop-Location
}
