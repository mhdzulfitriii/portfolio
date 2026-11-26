<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/data.php';

$activePage = 'experience';
$pageTitle = 'Work & Volunteer Experience — Muhammad Zul Fitri';
$pageDescription = 'Software engineering career at HeiTech Padu Berhad and volunteer event photography leadership by Muhammad Zul Fitri bin Mohd Zamri.';

$experiences = query_items(load_dataset('experience'), [
    'sort_by' => 'start_date',
    'direction' => 'desc',
]);
$experienceTypes = extract_field_values($experiences, 'type');

include __DIR__ . '/header.php';
?>

<main id="main-content">
    <!-- Page Header -->
    <section aria-labelledby="experience-page-heading" class="border-b border-slate-200/80 bg-slate-50 py-12 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-4 text-xs font-medium text-slate-500">
                <ol class="flex items-center gap-2">
                    <li><a href="index.php" class="hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Home</a></li>
                    <li aria-hidden="true">/</li>
                    <li class="text-slate-900" aria-current="page">Experience</li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Career &amp; Leadership</p>
                <h1 id="experience-page-heading" class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    Work &amp; Volunteer Experience Showcase
                </h1>
                <p class="mt-3 text-base leading-relaxed text-slate-600">
                    Combining industry software development experience at HeiTech Padu Berhad with high-profile regional event photography for WADAH Malaysia.
                </p>
            </div>

            <?php if (count($experienceTypes) > 1): ?>
                <div class="mt-8 flex flex-wrap items-center gap-2 print:hidden" role="group" aria-label="Filter experience by type" data-filter-group="experience">
                    <button
                        type="button"
                        data-filter-value="all"
                        aria-pressed="true"
                        class="cursor-pointer rounded-full border border-indigo-600 bg-indigo-600 px-3.5 py-1.5 text-xs font-medium text-white transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        All (<?= e(count($experiences)) ?>)
                    </button>
                    <?php foreach ($experienceTypes as $type): ?>
                        <button
                            type="button"
                            data-filter-value="<?= e($type) ?>"
                            aria-pressed="false"
                            class="cursor-pointer rounded-full border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-medium text-slate-700 transition-colors hover:border-indigo-300 hover:text-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <?= e($type) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <p class="sr-only" aria-live="polite" data-filter-status="experience"></p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Experience Showcase List -->
    <section aria-label="Experience timeline" class="bg-white py-14 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <?php if (empty($experiences)): ?>
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 p-12 text-center">
                    <p class="text-sm font-medium text-slate-700">No experience entries added yet.</p>
                    <p class="mt-1 text-sm text-slate-500">Add records to <code class="rounded bg-slate-200/70 px-1.5 py-0.5 text-xs text-slate-800">data/experience.json</code>.</p>
                </div>
            <?php else: ?>
                <ol class="space-y-8">
                    <?php foreach ($experiences as $exp): ?>
                        <?php
                        $role = (string) ($exp['role'] ?? '');
                        $org = (string) ($exp['organization'] ?? '');
                        $dateRange = format_date_range(
                            isset($exp['start_date']) ? (string) $exp['start_date'] : null,
                            isset($exp['end_date']) ? (string) $exp['end_date'] : null,
                            (bool) ($exp['is_current'] ?? false)
                        );
                        $cover = resolve_cover_image($exp, $role);
                        $gallery = resolve_item_gallery($exp, $role);
                        $highlights = is_array($exp['highlights'] ?? null) ? $exp['highlights'] : [];
                        $skills = is_array($exp['skills'] ?? null) ? $exp['skills'] : [];
                        $meta = implode(' · ', array_filter([$org, $dateRange, $exp['location'] ?? '']));
                        ?>
                        <li
                            data-filter-item="experience"
                            data-category="<?= e($exp['type'] ?? '') ?>"
                            class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs transition-shadow hover:shadow-md">
                            <div class="grid grid-cols-1 lg:grid-cols-12">
                                <!-- Visual Showcase Media -->
                                <div class="flex flex-col border-b border-slate-200/80 bg-slate-50 lg:col-span-5 lg:border-r lg:border-b-0">
                                    <?php if ($cover !== null): ?>
                                        <button
                                            type="button"
                                            data-gallery-trigger
                                            data-gallery="<?= e(json_encode($gallery, JSON_UNESCAPED_SLASHES)) ?>"
                                            data-gallery-index="0"
                                            data-gallery-title="<?= e($role) ?>"
                                            data-gallery-meta="<?= e($meta) ?>"
                                            class="group relative aspect-[16/10] w-full flex-1 cursor-pointer overflow-hidden bg-slate-100 text-left focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 lg:aspect-auto lg:min-h-[260px]">
                                            <img
                                                src="<?= e($cover['src']) ?>"
                                                alt="<?= e($cover['alt']) ?>"
                                                loading="lazy"
                                                class="h-full w-full object-cover transition-transform duration-300 motion-safe:group-hover:scale-105">
                                            <span class="absolute right-3 bottom-3 inline-flex items-center gap-1.5 rounded-full bg-slate-900/75 px-3 py-1 text-xs font-medium text-white backdrop-blur-xs">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                                                </svg>
                                                <span><?= count($gallery) > 1 ? e(count($gallery)) . ' Photos' : 'Inspect Image' ?></span>
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
                                                        data-gallery-title="<?= e($role) ?>"
                                                        data-gallery-meta="<?= e($meta) ?>"
                                                        class="h-12 w-18 shrink-0 cursor-pointer overflow-hidden rounded-lg border border-slate-200 transition-all hover:border-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                        <img src="<?= e($slide['src']) ?>" alt="<?= e($slide['alt']) ?>" loading="lazy" class="h-full w-full object-cover">
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Role Details -->
                                <div class="flex flex-col p-6 sm:p-8 lg:col-span-7">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <?php if (!empty($exp['type'])): ?>
                                                <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-semibold text-indigo-700">
                                                    <?= e($exp['type']) ?>
                                                </span>
                                            <?php endif; ?>
                                            <span class="text-xs font-medium text-slate-500"><?= e($dateRange) ?></span>
                                        </div>
                                        <?php if (!empty($exp['location'])): ?>
                                            <span class="text-xs font-medium text-slate-500"><?= e($exp['location']) ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <h2 class="mt-3 text-xl font-semibold text-slate-900"><?= e($role) ?></h2>
                                    <p class="mt-1 text-sm font-medium text-indigo-700"><?= e($org) ?></p>

                                    <?php if (!empty($exp['summary'])): ?>
                                        <p class="mt-4 text-sm leading-6 text-slate-600"><?= e($exp['summary']) ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($highlights)): ?>
                                        <ul class="mt-4 space-y-2 text-sm leading-6 text-slate-600">
                                            <?php foreach ($highlights as $bullet): ?>
                                                <li class="flex items-start gap-2.5">
                                                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-indigo-600" aria-hidden="true"></span>
                                                    <span><?= e($bullet) ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (!empty($skills)): ?>
                                        <ul class="mt-auto flex flex-wrap gap-1.5 border-t border-slate-100 pt-5" aria-label="Skills applied">
                                            <?php foreach ($skills as $skill): ?>
                                                <li class="rounded-md bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700"><?= e($skill) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
