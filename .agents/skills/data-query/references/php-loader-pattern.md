# Reference PHP JSON Loader & Query Helper

Place reusable data helpers in `includes/data.php` and `require_once __DIR__ . '/includes/data.php';` at the top of `index.php` (or any page template).

```php
<?php
declare(strict_types=1);

/**
 * HTML-escape any value for safe rendering in text nodes or attributes.
 */
function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Allow only safe URL schemes and relative local paths.
 * Returns null if the URL is empty or unsafe.
 */
function safe_url(?string $url): ?string
{
    if ($url === null) {
        return null;
    }

    $trimmed = trim($url);
    if ($trimmed === '') {
        return null;
    }

    if (
        str_starts_with($trimmed, 'https://') ||
        str_starts_with($trimmed, 'http://') ||
        str_starts_with($trimmed, 'mailto:') ||
        str_starts_with($trimmed, '#') ||
        str_starts_with($trimmed, '/') ||
        str_starts_with($trimmed, 'asset/')
    ) {
        return $trimmed;
    }

    return null;
}

/**
 * Load a JSON dataset from data/<dataset>.json safely.
 * Returns [] if the file is missing, empty, or invalid JSON.
 *
 * @return array<int, array<string, mixed>>
 */
function load_dataset(string $dataset): array
{
    $allowed = ['education', 'experience', 'photography', 'project'];
    if (!in_array($dataset, $allowed, true)) {
        return [];
    }

    $path = dirname(__DIR__) . '/data/' . $dataset . '.json';
    if (!is_file($path)) {
        return [];
    }

    $raw = @file_get_contents($path);
    if ($raw === false || trim($raw) === '') {
        return [];
    }

    $decoded = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
        return [];
    }

    return array_values(array_filter($decoded, 'is_array'));
}

/**
 * Query a dataset with optional category, featured, tag, search, sort, and limit.
 *
 * @param array<int, array<string, mixed>> $items
 * @param array{
 *   category?: string|null,
 *   featured?: bool|null,
 *   tag?: string|null,
 *   search?: string|null,
 *   sort_by?: string|null,
 *   direction?: 'asc'|'desc',
 *   limit?: int|null
 * } $options
 * @return array<int, array<string, mixed>>
 */
function query_items(array $items, array $options = []): array
{
    $result = $items;

    if (!empty($options['category'])) {
        $cat = mb_strtolower(trim((string) $options['category']));
        $result = array_filter(
            $result,
            static fn(array $item): bool => mb_strtolower((string) ($item['category'] ?? '')) === $cat
        );
    }

    if (isset($options['featured']) && is_bool($options['featured'])) {
        $want = $options['featured'];
        $result = array_filter(
            $result,
            static fn(array $item): bool => (bool) ($item['featured'] ?? false) === $want
        );
    }

    if (!empty($options['tag'])) {
        $tag = mb_strtolower(trim((string) $options['tag']));
        $result = array_filter($result, static function (array $item) use ($tag): bool {
            $tags = $item['tags'] ?? $item['skills'] ?? [];
            if (!is_array($tags)) {
                return false;
            }
            foreach ($tags as $t) {
                if (mb_strtolower((string) $t) === $tag) {
                    return true;
                }
            }
            return false;
        });
    }

    if (!empty($options['search'])) {
        $needle = mb_strtolower(trim((string) $options['search']));
        $result = array_filter($result, static function (array $item) use ($needle): bool {
            $haystack = mb_strtolower(implode(' ', array_filter([
                $item['title'] ?? '',
                $item['tagline'] ?? '',
                $item['description'] ?? '',
                $item['role'] ?? '',
                $item['organization'] ?? '',
                $item['institution'] ?? '',
                $item['caption'] ?? '',
            ], 'is_string')));
            return str_contains($haystack, $needle);
        });
    }

    $result = array_values($result);

    if (!empty($options['sort_by'])) {
        $field = (string) $options['sort_by'];
        $desc = ($options['direction'] ?? 'desc') === 'desc';

        usort($result, static function (array $a, array $b) use ($field, $desc): int {
            // Keep current or featured items prioritized when sorting chronologically
            if (in_array($field, ['start_date', 'date', 'year'], true)) {
                $curA = (int) ((bool) ($a['is_current'] ?? false));
                $curB = (int) ((bool) ($b['is_current'] ?? false));
                if ($curA !== $curB) {
                    return $curB <=> $curA;
                }
            }

            $valA = (string) ($a[$field] ?? '');
            $valB = (string) ($b[$field] ?? '');
            $cmp = strcmp($valA, $valB);
            return $desc ? -$cmp : $cmp;
        });
    }

    if (!empty($options['limit']) && $options['limit'] > 0) {
        $result = array_slice($result, 0, (int) $options['limit']);
    }

    return $result;
}

/**
 * Format an ISO date ("YYYY-MM" or "YYYY-MM-DD") for display (e.g., "Mar 2026").
 */
function format_date_label(?string $iso, bool $isCurrent = false): string
{
    if ($isCurrent || $iso === null || trim($iso) === '') {
        return $isCurrent ? 'Present' : '';
    }

    if (preg_match('/^\d{4}$/', $iso)) {
        return $iso;
    }

    $normalized = preg_match('/^\d{4}-\d{2}$/', $iso) ? $iso . '-01' : $iso;
    $dt = DateTimeImmutable::createFromFormat('Y-m-d', $normalized);
    return $dt ? $dt->format('M Y') : $iso;
}
```

## Usage Example

```php
<?php
require_once __DIR__ . '/includes/data.php';

$featuredProjects = query_items(load_dataset('project'), [
    'featured' => true,
    'sort_by' => 'year',
    'direction' => 'desc',
    'limit' => 6,
]);

$experiences = query_items(load_dataset('experience'), [
    'sort_by' => 'start_date',
    'direction' => 'desc',
]);

$education = query_items(load_dataset('education'), [
    'sort_by' => 'start_date',
    'direction' => 'desc',
]);

$photos = query_items(load_dataset('photography'), [
    'featured' => true,
    'sort_by' => 'date',
    'direction' => 'desc',
]);
```
