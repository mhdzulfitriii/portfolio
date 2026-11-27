<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/data.php';

$activePage = 'photography';
$pageTitle = 'Photography Showcase — Muhammad Zul Fitri';
$pageDescription = 'Event, regional ASEAN, international outreach, and VIP documentary photography showcase by Muhammad Zul Fitri bin Mohd Zamri.';

$photos = query_items(load_dataset('photography'), [
    'sort_by' => 'date',
    'direction' => 'desc',
]);
$photoCategories = extract_categories($photos);
$spotlight = !empty($photos) ? $photos[0] : null;

include __DIR__ . '/header.php';
?>

<main id="main-content">
    <!-- Page Header -->
    <section aria-labelledby="photography-page-heading" class="border-b border-slate-200/80 bg-slate-50 py-12 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-4 text-xs font-medium text-slate-500">
                <ol class="flex items-center gap-2">
                    <li><a href="index.php" class="hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Home</a></li>
                    <li aria-hidden="true">/</li>
                    <li class="text-slate-900" aria-current="page">Photography</li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Visual Storytelling</p>
                <h1 id="photography-page-heading" class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    Event &amp; Documentary Photography Showcase
                </h1>
                <p class="mt-3 text-base leading-relaxed text-slate-600">
                    Fast-paced candid and formal protocol coverage spanning national conventions, ASEAN youth dialogues, international outreach in Jakarta, and high-profile leadership forums. Click any image to open the full gallery viewer.
                </p>
            </div>
        </div>
    </section>

    <!-- Flagship Coverage Spotlight -->
    <?php if ($spotlight !== null): ?>
        <?php
        $spotTitle = (string) ($spotlight['title'] ?? '');
        $spotCover = resolve_cover_image($spotlight, $spotTitle);
        $spotGallery = resolve_item_gallery($spotlight, $spotTitle);
        $spotMeta = implode(' · ', array_filter([
            $spotlight['category'] ?? '',
            $spotlight['location'] ?? '',
            format_date_label(isset($spotlight['date']) ? (string) $spotlight['date'] : null),
        ]));
        ?>
        <section aria-labelledby="spotlight-heading" class="border-b border-slate-200/80 bg-white py-12 sm:py-16">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div data-lazy-card class="overflow-hidden rounded-3xl border border-slate-200/80 bg-slate-50/70 shadow-xs">
                    <?= render_card_skeleton('spotlight') ?>
                    <div data-lazy-content class="grid grid-cols-1 lg:grid-cols-12">
                        <div class="lg:col-span-7">
                            <?php if ($spotCover !== null): ?>
                                <button
                                    type="button"
                                    data-gallery-trigger
                                    data-gallery="<?= e(json_encode($spotGallery, JSON_UNESCAPED_SLASHES)) ?>"
                                    data-gallery-index="0"
                                    data-gallery-title="<?= e($spotTitle) ?>"
                                    data-gallery-meta="<?= e($spotMeta) ?>"
                                    class="lazy-media-wrap group relative block aspect-[16/10] h-full w-full cursor-pointer overflow-hidden bg-slate-100 text-left focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <?= render_media_skeleton() ?>
                                    <img
                                        src="<?= e($spotCover['src']) ?>"
                                        alt="<?= e($spotCover['alt']) ?>"
                                        data-lazy-img
                                        decoding="async"
                                        fetchpriority="high"
                                        class="h-full w-full object-cover transition-transform duration-300 motion-safe:group-hover:scale-105">
                                    <span class="absolute right-4 bottom-4 inline-flex items-center gap-1.5 rounded-full bg-slate-900/75 px-3.5 py-1.5 text-xs font-medium text-white backdrop-blur-xs">
                                        Open Gallery Viewer
                                    </span>
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-col justify-center p-7 sm:p-9 lg:col-span-5">
                            <span class="w-fit rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                                Flagship Coverage Spotlight
                            </span>
                            <h2 id="spotlight-heading" class="mt-4 text-2xl font-bold tracking-tight text-slate-900">
                                <?= e($spotTitle) ?>
                            </h2>
                            <p class="mt-3 text-sm leading-6 text-slate-600">
                                <?= e($spotlight['caption'] ?? '') ?>
                            </p>
                            <p class="mt-5 text-xs font-medium text-slate-500"><?= e($spotMeta) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Full Filterable Photography Showcase Grid -->
    <section aria-label="All photography assignments" class="bg-white py-14 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <?php if (!empty($photos)): ?>
                <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between print:hidden">
                    <div class="flex flex-wrap items-center gap-2" role="group" aria-label="Filter photography by category" data-filter-group="photography">
                        <button
                            type="button"
                            data-filter-value="all"
                            aria-pressed="true"
                            class="cursor-pointer rounded-full border border-indigo-600 bg-indigo-600 px-3.5 py-1.5 text-xs font-medium text-white transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            All (<?= e(count($photos)) ?>)
                        </button>
                        <?php foreach ($photoCategories as $cat): ?>
                            <button
                                type="button"
                                data-filter-value="<?= e($cat) ?>"
                                aria-pressed="false"
                                class="cursor-pointer rounded-full border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-medium text-slate-700 transition-colors hover:border-indigo-300 hover:text-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                <?= e($cat) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <div class="w-full sm:w-64">
                        <label for="photography-search" class="sr-only">Search photography events</label>
                        <input
                            id="photography-search"
                            type="search"
                            data-filter-search="photography"
                            placeholder="Search events or locations..."
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-2 focus:outline-offset-0 focus:outline-indigo-600">
                    </div>
                </div>
                <p class="sr-only" aria-live="polite" data-filter-status="photography"></p>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($photos as $photo): ?>
                        <?php
                        $title = (string) ($photo['title'] ?? '');
                        $cover = resolve_cover_image($photo, $title);
                        $gallery = resolve_item_gallery($photo, $title);
                        $metaString = implode(' · ', array_filter([
                            $photo['location'] ?? '',
                            format_date_label(isset($photo['date']) ? (string) $photo['date'] : null),
                        ]));
                        $searchBlob = implode(' ', [
                            $title,
                            (string) ($photo['caption'] ?? ''),
                            (string) ($photo['category'] ?? ''),
                            (string) ($photo['location'] ?? ''),
                        ]);
                        ?>
                        <article
                            data-lazy-card
                            data-filter-item="photography"
                            data-category="<?= e($photo['category'] ?? '') ?>"
                            data-search="<?= e($searchBlob) ?>"
                            class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs transition-shadow hover:shadow-md">
                            <?= render_card_skeleton('card', 'aspect-[4/3]', count($gallery) > 1) ?>
                            <div data-lazy-content class="flex flex-1 flex-col">
                                <?php if ($cover !== null): ?>
                                    <button
                                        type="button"
                                        data-gallery-trigger
                                        data-gallery="<?= e(json_encode($gallery, JSON_UNESCAPED_SLASHES)) ?>"
                                        data-gallery-index="0"
                                        data-gallery-title="<?= e($title) ?>"
                                        data-gallery-meta="<?= e($metaString) ?>"
                                        class="lazy-media-wrap relative aspect-[4/3] w-full cursor-pointer overflow-hidden bg-slate-100 text-left focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        <?= render_media_skeleton() ?>
                                        <img
                                            src="<?= e($cover['src']) ?>"
                                            alt="<?= e($cover['alt']) ?>"
                                            data-lazy-img
                                            loading="lazy"
                                            decoding="async"
                                            class="h-full w-full object-cover transition-transform duration-300 motion-safe:group-hover:scale-105">
                                        <span class="absolute right-3 bottom-3 inline-flex items-center gap-1 rounded-full bg-slate-900/75 px-2.5 py-1 text-[11px] font-medium text-white backdrop-blur-xs">
                                            <?= count($gallery) > 1 ? e(count($gallery)) . ' Photos' : 'Zoom' ?>
                                        </span>
                                        <span class="sr-only">Open photo showcase for <?= e($title) ?></span>
                                    </button>

                                    <?php if (count($gallery) > 1): ?>
                                        <div class="flex gap-1.5 overflow-x-auto border-b border-slate-100 bg-slate-50 px-3 py-2">
                                            <?php foreach ($gallery as $idx => $slide): ?>
                                                <button
                                                    type="button"
                                                    data-gallery-trigger
                                                    data-gallery="<?= e(json_encode($gallery, JSON_UNESCAPED_SLASHES)) ?>"
                                                    data-gallery-index="<?= e($idx) ?>"
                                                    data-gallery-title="<?= e($title) ?>"
                                                    data-gallery-meta="<?= e($metaString) ?>"
                                                    class="lazy-media-wrap h-10 w-14 shrink-0 cursor-pointer overflow-hidden rounded-md border border-slate-200 transition-all hover:border-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <?= render_media_skeleton('rounded-md') ?>
                                                    <img src="<?= e($slide['src']) ?>" alt="<?= e($slide['alt']) ?>" data-lazy-img loading="lazy" decoding="async" class="h-full w-full object-cover">
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <div class="flex flex-1 flex-col p-5">
                                    <div class="flex items-center justify-between gap-2 text-xs">
                                        <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 font-medium text-indigo-700">
                                            <?= e($photo['category'] ?? 'Event') ?>
                                        </span>
                                        <span class="text-slate-500"><?= e(format_date_label(isset($photo['date']) ? (string) $photo['date'] : null)) ?></span>
                                    </div>

                                    <h2 class="mt-3 text-base font-semibold leading-snug text-slate-900">
                                        <?= e($title) ?>
                                    </h2>
                                    <?php if (!empty($photo['caption'])): ?>
                                        <p class="mt-2 flex-1 text-sm leading-6 text-slate-600">
                                            <?= e($photo['caption']) ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if ($metaString !== ''): ?>
                                        <p class="mt-4 border-t border-slate-100 pt-3 text-xs font-medium text-slate-500">
                                            <?= e($metaString) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div data-filter-empty="photography" class="hidden rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center">
                    <p class="text-sm font-medium text-slate-700">No photography events match your current filter.</p>
                    <p class="mt-1 text-sm text-slate-500">Try clearing the search box or switching back to All categories.</p>
                </div>
            <?php else: ?>
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 p-12 text-center">
                    <p class="text-sm font-medium text-slate-700">No photography items added yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
