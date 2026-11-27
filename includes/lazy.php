<?php
declare(strict_types=1);

/**
 * Reusable skeleton placeholder markup for lazy-loaded media and cards.
 * All skeleton layers are marked aria-hidden="true" so assistive technologies
 * ignore purely decorative loading placeholders.
 */

/**
 * Render an inline shimmer overlay for a single lazy-loaded image container.
 * Must be placed inside a container with class "lazy-media-wrap".
 */
function render_media_skeleton(string $roundedClass = ''): string
{
    $extra = $roundedClass !== '' ? ' ' . e($roundedClass) : '';
    return '<span class="lazy-media-skeleton skeleton-block' . $extra . '" aria-hidden="true"></span>';
}

/**
 * Render a matching card-level skeleton overlay placed as a direct child of
 * a [data-lazy-card] element.
 *
 * Supported variants:
 * - 'card'       : Standard vertical card (cover media + badges + title + body + footer)
 * - 'horizontal' : 12-col split card (left 5-col media + right 7-col details)
 * - 'spotlight'  : 12-col featured spotlight (left 7-col media + right 5-col details)
 * - 'compact'    : Text/icon tile with no cover media (e.g. honors & awards)
 */
function render_card_skeleton(
    string $variant = 'card',
    string $aspectClass = 'aspect-[4/3]',
    bool $hasThumbStrip = false
): string {
    if ($variant === 'compact') {
        return <<<HTML
<div data-lazy-skeleton aria-hidden="true" class="flex flex-col rounded-2xl bg-white p-5">
    <div class="skeleton-block h-9 w-9 rounded-xl"></div>
    <div class="skeleton-block mt-3 h-4 w-4/5 rounded-md"></div>
    <div class="skeleton-block mt-2 h-3 w-3/5 rounded-md"></div>
</div>
HTML;
    }

    if ($variant === 'spotlight') {
        return <<<HTML
<div data-lazy-skeleton aria-hidden="true" class="grid grid-cols-1 bg-slate-50/90 lg:grid-cols-12">
    <div class="lg:col-span-7">
        <div class="skeleton-block aspect-[16/10] h-full w-full"></div>
    </div>
    <div class="flex flex-col justify-center p-7 sm:p-9 lg:col-span-5">
        <div class="skeleton-block h-6 w-44 rounded-full"></div>
        <div class="skeleton-block mt-4 h-7 w-5/6 rounded-md"></div>
        <div class="skeleton-block mt-2 h-7 w-2/3 rounded-md"></div>
        <div class="mt-4 space-y-2.5">
            <div class="skeleton-block h-3.5 w-full rounded"></div>
            <div class="skeleton-block h-3.5 w-11/12 rounded"></div>
            <div class="skeleton-block h-3.5 w-3/4 rounded"></div>
        </div>
        <div class="skeleton-block mt-6 h-3.5 w-48 rounded"></div>
    </div>
</div>
HTML;
    }

    if ($variant === 'horizontal') {
        $thumbHtml = $hasThumbStrip
            ? '<div class="flex gap-2 border-t border-slate-200/80 bg-white px-4 py-2.5">'
                . '<div class="skeleton-block h-12 w-18 shrink-0 rounded-lg"></div>'
                . '<div class="skeleton-block h-12 w-18 shrink-0 rounded-lg"></div>'
                . '<div class="skeleton-block h-12 w-18 shrink-0 rounded-lg"></div>'
                . '</div>'
            : '';

        return <<<HTML
<div data-lazy-skeleton aria-hidden="true" class="grid grid-cols-1 bg-white lg:grid-cols-12">
    <div class="flex flex-col border-b border-slate-200/80 bg-slate-50 lg:col-span-5 lg:border-r lg:border-b-0">
        <div class="skeleton-block aspect-[16/10] w-full flex-1 lg:aspect-auto lg:min-h-[220px]"></div>
        {$thumbHtml}
    </div>
    <div class="flex flex-col p-6 sm:p-8 lg:col-span-7">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <div class="skeleton-block h-5 w-24 rounded-full"></div>
                <div class="skeleton-block h-4 w-28 rounded"></div>
            </div>
            <div class="skeleton-block h-4 w-24 rounded"></div>
        </div>
        <div class="skeleton-block mt-4 h-6 w-3/4 rounded-md"></div>
        <div class="skeleton-block mt-2 h-4 w-1/2 rounded"></div>
        <div class="mt-5 space-y-2.5">
            <div class="skeleton-block h-3.5 w-full rounded"></div>
            <div class="skeleton-block h-3.5 w-11/12 rounded"></div>
            <div class="skeleton-block h-3.5 w-5/6 rounded"></div>
            <div class="skeleton-block h-3.5 w-2/3 rounded"></div>
        </div>
        <div class="mt-auto flex flex-wrap gap-2 border-t border-slate-100 pt-5">
            <div class="skeleton-block h-5 w-16 rounded-md"></div>
            <div class="skeleton-block h-5 w-20 rounded-md"></div>
            <div class="skeleton-block h-5 w-14 rounded-md"></div>
        </div>
    </div>
</div>
HTML;
    }

    // Default vertical 'card' variant
    $safeAspect = e($aspectClass);
    $thumbHtml = $hasThumbStrip
        ? '<div class="flex gap-1.5 border-b border-slate-100 bg-slate-50 px-3 py-2">'
            . '<div class="skeleton-block h-10 w-14 shrink-0 rounded-md"></div>'
            . '<div class="skeleton-block h-10 w-14 shrink-0 rounded-md"></div>'
            . '<div class="skeleton-block h-10 w-14 shrink-0 rounded-md"></div>'
            . '</div>'
        : '';

    return <<<HTML
<div data-lazy-skeleton aria-hidden="true" class="flex flex-col bg-white">
    <div class="skeleton-block {$safeAspect} w-full shrink-0"></div>
    {$thumbHtml}
    <div class="flex flex-1 flex-col p-5 sm:p-6">
        <div class="flex items-center justify-between gap-2">
            <div class="skeleton-block h-5 w-24 rounded-full"></div>
            <div class="skeleton-block h-4 w-16 rounded"></div>
        </div>
        <div class="skeleton-block mt-3.5 h-5 w-4/5 rounded-md"></div>
        <div class="mt-3 space-y-2">
            <div class="skeleton-block h-3.5 w-full rounded"></div>
            <div class="skeleton-block h-3.5 w-11/12 rounded"></div>
            <div class="skeleton-block h-3.5 w-3/4 rounded"></div>
        </div>
        <div class="mt-auto flex items-center gap-2 pt-5">
            <div class="skeleton-block h-5 w-16 rounded-md"></div>
            <div class="skeleton-block h-5 w-20 rounded-md"></div>
            <div class="skeleton-block h-5 w-14 rounded-md"></div>
        </div>
    </div>
</div>
HTML;
}
