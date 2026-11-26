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
        str_starts_with($trimmed, 'tel:') ||
        str_starts_with($trimmed, '#') ||
        str_starts_with($trimmed, '/') ||
        str_starts_with($trimmed, 'asset/')
    ) {
        return $trimmed;
    }

    return null;
}

/**
 * Check if a local relative asset path (under asset/) actually exists on disk.
 */
function local_asset_exists(?string $relativePath): bool
{
    if ($relativePath === null) {
        return false;
    }

    $trimmed = trim($relativePath);
    if ($trimmed === '' || !str_starts_with($trimmed, 'asset/')) {
        return false;
    }

    $baseDir = realpath(dirname(__DIR__) . '/asset');
    if ($baseDir === false) {
        return false;
    }

    $fullPath = realpath(dirname(__DIR__) . '/' . $trimmed);
    return $fullPath !== false && str_starts_with($fullPath, $baseDir) && is_file($fullPath);
}

/**
 * Load a JSON dataset from data/<dataset>.json safely.
 * Returns [] if the file is missing, empty, or invalid JSON.
 *
 * @return array<int, array<string, mixed>>
 */
function load_dataset(string $dataset): array
{
    $allowed = ['education', 'experience', 'organization', 'photography', 'project', 'volunteer'];
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
                $item['program_name'] ?? '',
                $item['position'] ?? '',
                $item['place'] ?? '',
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
            if (in_array($field, ['start_date', 'date', 'year', 'program_date'], true)) {
                $curA = (int) ((bool) ($a['is_current'] ?? false));
                $curB = (int) ((bool) ($b['is_current'] ?? false));
                if ($curA !== $curB) {
                    return $curB <=> $curA;
                }
            }

            if ($field === 'order') {
                $valA = (int) ($a['order'] ?? PHP_INT_MAX);
                $valB = (int) ($b['order'] ?? PHP_INT_MAX);
                $cmp = $valA <=> $valB;
                return $desc ? -$cmp : $cmp;
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
 * Extract unique non-empty values for a string field in encounter order.
 *
 * @param array<int, array<string, mixed>> $items
 * @return array<int, string>
 */
function extract_field_values(array $items, string $field): array
{
    $seen = [];
    $values = [];
    foreach ($items as $item) {
        $val = trim((string) ($item[$field] ?? ''));
        if ($val !== '' && !isset($seen[mb_strtolower($val)])) {
            $seen[mb_strtolower($val)] = true;
            $values[] = $val;
        }
    }
    return $values;
}

/**
 * Extract unique non-empty categories from a dataset in encounter order.
 *
 * @param array<int, array<string, mixed>> $items
 * @return array<int, string>
 */
function extract_categories(array $items): array
{
    return extract_field_values($items, 'category');
}

/**
 * Check whether an image source is a safe external URL or an existing local asset.
 */
function is_renderable_image(?string $src): bool
{
    $safe = safe_url($src);
    if ($safe === null) {
        return false;
    }
    if (str_starts_with($safe, 'asset/')) {
        return local_asset_exists($safe);
    }
    return str_starts_with($safe, 'https://') || str_starts_with($safe, 'http://');
}

/**
 * Resolve all valid gallery images for an item (works for project, experience, education, photography).
 *
 * @param array<string, mixed> $item
 * @return array<int, array{src: string, alt: string, caption: string}>
 */
function resolve_item_gallery(array $item, string $fallbackTitle = ''): array
{
    $slides = [];
    $seen = [];

    $addSlide = static function (?string $src, string $alt, string $caption) use (&$slides, &$seen): void {
        if (!is_renderable_image($src)) {
            return;
        }
        $cleanSrc = trim((string) $src);
        if (isset($seen[$cleanSrc])) {
            return;
        }
        $seen[$cleanSrc] = true;
        $slides[] = [
            'src' => $cleanSrc,
            'alt' => $alt,
            'caption' => $caption,
        ];
    };

    $primarySrc = isset($item['src']) ? (string) $item['src'] : (isset($item['image']) ? (string) $item['image'] : '');
    $primaryAlt = (string) ($item['alt'] ?? $item['image_alt'] ?? $fallbackTitle);
    $primaryCaption = (string) ($item['caption'] ?? $item['tagline'] ?? $item['summary'] ?? '');

    if (isset($item['gallery']) && is_array($item['gallery'])) {
        foreach ($item['gallery'] as $entry) {
            if (!is_array($entry)) {
                continue;
            }
            $addSlide(
                isset($entry['src']) ? (string) $entry['src'] : null,
                (string) ($entry['alt'] ?? $primaryAlt),
                (string) ($entry['caption'] ?? $primaryCaption)
            );
        }
    }

    if (empty($slides) && $primarySrc !== '') {
        $addSlide($primarySrc, $primaryAlt, $primaryCaption);
    }

    return $slides;
}

/**
 * Resolve the primary cover image for a card, or null if none is available.
 *
 * @param array<string, mixed> $item
 * @return array{src: string, alt: string}|null
 */
function resolve_cover_image(array $item, string $fallbackTitle = ''): ?array
{
    $primarySrc = isset($item['src']) ? (string) $item['src'] : (isset($item['image']) ? (string) $item['image'] : '');
    $primaryAlt = (string) ($item['alt'] ?? $item['image_alt'] ?? $fallbackTitle);

    if (is_renderable_image($primarySrc)) {
        return ['src' => trim($primarySrc), 'alt' => $primaryAlt];
    }

    $gallery = resolve_item_gallery($item, $fallbackTitle);
    if (!empty($gallery)) {
        return ['src' => $gallery[0]['src'], 'alt' => $gallery[0]['alt']];
    }

    return null;
}

/**
 * Format an ISO date ("YYYY", "YYYY-MM", or "YYYY-MM-DD") for display.
 */
function format_date_label(?string $iso, bool $isCurrent = false): string
{
    if ($isCurrent || $iso === null || trim($iso) === '') {
        return $isCurrent ? 'Present' : '';
    }

    $trimmed = trim($iso);
    if (preg_match('/^\d{4}$/', $trimmed)) {
        return $trimmed;
    }

    $normalized = preg_match('/^\d{4}-\d{2}$/', $trimmed) ? $trimmed . '-01' : $trimmed;
    $dt = DateTimeImmutable::createFromFormat('Y-m-d', $normalized);
    return $dt ? $dt->format('M Y') : $trimmed;
}

/**
 * Format a date range cleanly (e.g., "2024 – 2025", "2025 – Present", or "2024").
 */
function format_date_range(?string $start, ?string $end, bool $isCurrent = false): string
{
    $startLabel = format_date_label($start, false);
    $endLabel = $isCurrent ? 'Present' : format_date_label($end, false);

    if ($startLabel !== '' && $endLabel !== '') {
        return $startLabel === $endLabel ? $startLabel : $startLabel . ' – ' . $endLabel;
    }

    return $startLabel !== '' ? $startLabel : $endLabel;
}
