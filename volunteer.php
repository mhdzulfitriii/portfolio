<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/data.php';

$activePage = 'volunteer';
$pageTitle = 'Volunteer & Organizations — Muhammad Zul Fitri';
$pageDescription = 'Volunteer programmes, community contributions, and NGO / Persatuan leadership roles held by Muhammad Zul Fitri bin Mohd Zamri.';

$organizations = query_items(load_dataset('organization'), [
    'sort_by' => 'start_date',
    'direction' => 'desc',
]);

$programs = query_items(load_dataset('volunteer'), [
    'sort_by' => 'program_date',
    'direction' => 'desc',
]);
$programCategories = extract_categories($programs);

include __DIR__ . '/header.php';
?>

<main id="main-content">
    <!-- Page Header -->
    <section aria-labelledby="volunteer-page-heading" class="border-b border-slate-200/80 bg-slate-50 py-12 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-4 text-xs font-medium text-slate-500">
                <ol class="flex items-center gap-2">
                    <li><a href="index.php" class="hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Home</a></li>
                    <li aria-hidden="true">/</li>
                    <li class="text-slate-900" aria-current="page">Volunteer &amp; Organizations</li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Community &amp; Leadership</p>
                <h1 id="volunteer-page-heading" class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    Volunteer Programmes &amp; NGO Involvement
                </h1>
                <p class="mt-3 text-base leading-relaxed text-slate-600">
                    Active participation in student organizations (NGO / Persatuan) and volunteer programmes across Malaysia, ASEAN, and international outreach initiatives.
                </p>
            </div>
        </div>
    </section>

    <!-- Organizations Joined (NGO / Persatuan) Section -->
    <section id="organizations" aria-labelledby="organizations-heading" class="scroll-mt-20 border-b border-slate-200/80 bg-white py-14 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">NGO &amp; Persatuan</p>
                <h2 id="organizations-heading" class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Organizations Joined
                </h2>
                <p class="mt-2 text-base leading-relaxed text-slate-600">
                    Leadership positions and membership held in student movements and non-governmental organizations.
                </p>
            </div>

            <?php if (empty($organizations)): ?>
                <div class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 p-10 text-center">
                    <p class="text-sm font-medium text-slate-700">No organizations added yet.</p>
                    <p class="mt-1 text-sm text-slate-500">Add records to <code class="rounded bg-slate-200/70 px-1.5 py-0.5 text-xs text-slate-800">data/organization.json</code>.</p>
                </div>
            <?php else: ?>
                <div class="mt-8 space-y-6">
                    <?php foreach ($organizations as $org): ?>
                        <?php
                        $orgName = (string) ($org['organization'] ?? '');
                        $position = (string) ($org['position'] ?? '');
                        $period = format_date_range(
                            isset($org['start_date']) ? (string) $org['start_date'] : null,
                            isset($org['end_date']) ? (string) $org['end_date'] : null,
                            (bool) ($org['is_current'] ?? false)
                        );
                        $cover = resolve_cover_image($org, $orgName);
                        $gallery = resolve_item_gallery($org, $orgName);
                        $meta = implode(' · ', array_filter([$position, $period, $org['place'] ?? '']));
                        ?>
                        <article data-lazy-card class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs transition-shadow hover:shadow-md">
                            <?= render_card_skeleton('horizontal', 'aspect-[16/10]', count($gallery) > 1) ?>
                            <div data-lazy-content class="grid grid-cols-1 lg:grid-cols-12">
                                <!-- Visual Showcase Media -->
                                <div class="flex flex-col border-b border-slate-200/80 bg-slate-50 lg:col-span-5 lg:border-r lg:border-b-0">
                                    <?php if ($cover !== null): ?>
                                        <button
                                            type="button"
                                            data-gallery-trigger
                                            data-gallery="<?= e(json_encode($gallery, JSON_UNESCAPED_SLASHES)) ?>"
                                            data-gallery-index="0"
                                            data-gallery-title="<?= e($orgName) ?>"
                                            data-gallery-meta="<?= e($meta) ?>"
                                            class="lazy-media-wrap group relative aspect-[16/10] w-full flex-1 cursor-pointer overflow-hidden bg-slate-100 text-left focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 lg:aspect-auto lg:min-h-[220px]">
                                            <?= render_media_skeleton() ?>
                                            <img
                                                src="<?= e($cover['src']) ?>"
                                                alt="<?= e($cover['alt']) ?>"
                                                data-lazy-img
                                                loading="lazy"
                                                decoding="async"
                                                class="h-full w-full object-cover transition-transform duration-300 motion-safe:group-hover:scale-105">
                                            <span class="absolute right-3 bottom-3 inline-flex items-center gap-1.5 rounded-full bg-slate-900/75 px-3 py-1 text-xs font-medium text-white backdrop-blur-xs">
                                                <?= count($gallery) > 1 ? e(count($gallery)) . ' Photos' : 'View Showcase' ?>
                                            </span>
                                        </button>

                                        <?php if (count($gallery) > 1): ?>
                                            <div class="flex gap-2 overflow-x-auto border-t border-slate-200/80 bg-white px-4 py-2.5">
                                                <?php foreach ($gallery as $idx => $slide): ?>
                                                    <button
                                                        type="button"
                                                        data-gallery-trigger
                                                        data-gallery="<?= e(json_encode($gallery, JSON_UNESCAPED_SLASHES)) ?>"
                                                        data-gallery-index="<?= e($idx) ?>"
                                                        data-gallery-title="<?= e($orgName) ?>"
                                                        data-gallery-meta="<?= e($meta) ?>"
                                                        class="lazy-media-wrap h-12 w-18 shrink-0 cursor-pointer overflow-hidden rounded-lg border border-slate-200 transition-all hover:border-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                        <?= render_media_skeleton('rounded-lg') ?>
                                                        <img src="<?= e($slide['src']) ?>" alt="<?= e($slide['alt']) ?>" data-lazy-img loading="lazy" decoding="async" class="h-full w-full object-cover">
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Organization Details -->
                                <div class="flex flex-col justify-center p-6 sm:p-8 lg:col-span-7">
                                    <div class="flex flex-wrap items-center gap-2 text-xs">
                                        <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 font-semibold text-indigo-700">
                                            <?= e($org['type'] ?? 'NGO / Persatuan') ?>
                                        </span>
                                        <span class="rounded-full bg-slate-100 px-2.5 py-0.5 font-semibold text-slate-700">
                                            <?= e($period) ?>
                                        </span>
                                        <?php if (!empty($org['place'])): ?>
                                            <span class="text-slate-500"><?= e($org['place']) ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <h3 class="mt-3 text-xl font-bold tracking-tight text-slate-900">
                                        <?= e($orgName) ?>
                                    </h3>

                                    <p class="mt-1.5 text-base font-semibold text-indigo-600">
                                        <?= e($position) ?>
                                    </p>

                                    <?php if (!empty($org['summary'])): ?>
                                        <p class="mt-3 text-sm leading-6 text-slate-600">
                                            <?= e($org['summary']) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Volunteer Programmes Showcase Section -->
    <section id="programs" aria-labelledby="programs-heading" class="scroll-mt-20 bg-slate-50 py-14 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Programmes &amp; Contributions</p>
                    <h2 id="programs-heading" class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Volunteer Programmes Showcase
                    </h2>
                    <p class="mt-2 text-base leading-relaxed text-slate-600">
                        Programme name, role held, date, venue, and visual gallery for each volunteer contribution.
                    </p>
                </div>

                <?php if (!empty($programs)): ?>
                    <div class="w-full sm:w-64 print:hidden">
                        <label for="volunteer-search" class="sr-only">Search volunteer programmes</label>
                        <input
                            id="volunteer-search"
                            type="search"
                            data-filter-search="volunteer"
                            placeholder="Search programme, role, or place..."
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-2 focus:outline-offset-0 focus:outline-indigo-600">
                    </div>
                <?php endif; ?>
            </div>

            <?php if (count($programCategories) > 1): ?>
                <div class="mt-6 flex flex-wrap items-center gap-2 print:hidden" role="group" aria-label="Filter volunteer programmes by category" data-filter-group="volunteer">
                    <button
                        type="button"
                        data-filter-value="all"
                        aria-pressed="true"
                        class="cursor-pointer rounded-full border border-indigo-600 bg-indigo-600 px-3.5 py-1.5 text-xs font-medium text-white transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        All (<?= e(count($programs)) ?>)
                    </button>
                    <?php foreach ($programCategories as $cat): ?>
                        <button
                            type="button"
                            data-filter-value="<?= e($cat) ?>"
                            aria-pressed="false"
                            class="cursor-pointer rounded-full border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-medium text-slate-700 transition-colors hover:border-indigo-300 hover:text-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <?= e($cat) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <p class="sr-only" aria-live="polite" data-filter-status="volunteer"></p>
            <?php endif; ?>

            <?php if (empty($programs)): ?>
                <div class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
                    <p class="text-sm font-medium text-slate-700">No volunteer programmes added yet.</p>
                    <p class="mt-1 text-sm text-slate-500">Add records to <code class="rounded bg-slate-100 px-1.5 py-0.5 text-xs text-slate-800">data/volunteer.json</code>.</p>
                </div>
            <?php else: ?>
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($programs as $prog): ?>
                        <?php
                        $progName = (string) ($prog['program_name'] ?? '');
                        $position = (string) ($prog['position'] ?? '');
                        $progDate = format_date_label(isset($prog['program_date']) ? (string) $prog['program_date'] : null);
                        $place = (string) ($prog['place'] ?? '');
                        $cover = resolve_cover_image($prog, $progName);
                        $gallery = resolve_item_gallery($prog, $progName);
                        $highlights = is_array($prog['highlights'] ?? null) ? $prog['highlights'] : [];
                        $meta = implode(' · ', array_filter([$position, $progDate, $place]));
                        $searchBlob = implode(' ', [$progName, $position, $progDate, $place, (string) ($prog['organizer'] ?? ''), (string) ($prog['category'] ?? '')]);
                        ?>
                        <article
                            data-lazy-card
                            data-filter-item="volunteer"
                            data-category="<?= e($prog['category'] ?? '') ?>"
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
                                        data-gallery-title="<?= e($progName) ?>"
                                        data-gallery-meta="<?= e($meta) ?>"
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
                                            <?= count($gallery) > 1 ? e(count($gallery)) . ' Photos' : 'View Image' ?>
                                        </span>
                                        <span class="sr-only">Open image showcase for <?= e($progName) ?></span>
                                    </button>

                                    <?php if (count($gallery) > 1): ?>
                                        <div class="flex gap-1.5 overflow-x-auto border-b border-slate-100 bg-slate-50 px-3 py-2">
                                            <?php foreach ($gallery as $idx => $slide): ?>
                                                <button
                                                    type="button"
                                                    data-gallery-trigger
                                                    data-gallery="<?= e(json_encode($gallery, JSON_UNESCAPED_SLASHES)) ?>"
                                                    data-gallery-index="<?= e($idx) ?>"
                                                    data-gallery-title="<?= e($progName) ?>"
                                                    data-gallery-meta="<?= e($meta) ?>"
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
                                        <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 font-semibold text-indigo-700">
                                            <?= e($prog['category'] ?? 'Volunteer') ?>
                                        </span>
                                        <span class="font-medium text-slate-500"><?= e($progDate) ?></span>
                                    </div>

                                    <h3 class="mt-3 text-base font-semibold leading-snug text-slate-900">
                                        <?= e($progName) ?>
                                    </h3>

                                    <!-- Structured Programme Info (Position, Date, Place) -->
                                    <dl class="mt-3 space-y-1.5 rounded-xl bg-slate-50/80 p-3 text-xs">
                                        <div class="flex items-center justify-between gap-2">
                                            <dt class="font-medium text-slate-500">Position</dt>
                                            <dd class="font-semibold text-indigo-700"><?= e($position) ?></dd>
                                        </div>
                                        <div class="flex items-center justify-between gap-2">
                                            <dt class="font-medium text-slate-500">Date</dt>
                                            <dd class="font-medium text-slate-800"><?= e($progDate) ?></dd>
                                        </div>
                                        <div class="flex items-center justify-between gap-2">
                                            <dt class="font-medium text-slate-500">Place</dt>
                                            <dd class="text-right font-medium text-slate-800"><?= e($place) ?></dd>
                                        </div>
                                    </dl>

                                    <?php if (!empty($prog['summary'])): ?>
                                        <p class="mt-3 text-sm leading-6 text-slate-600">
                                            <?= e($prog['summary']) ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if (!empty($highlights)): ?>
                                        <ul class="mt-3 space-y-1.5 border-t border-slate-100 pt-3 text-xs leading-5 text-slate-600">
                                            <?php foreach ($highlights as $point): ?>
                                                <li class="flex items-start gap-2">
                                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-indigo-500" aria-hidden="true"></span>
                                                    <span><?= e($point) ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div data-filter-empty="volunteer" class="mt-8 hidden rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center">
                    <p class="text-sm font-medium text-slate-700">No volunteer programmes match your current filter.</p>
                    <p class="mt-1 text-sm text-slate-500">Try clearing the search input or selecting All categories.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
