<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/data.php';

$activePage = 'education';
$pageTitle = 'Education & Achievements — Muhammad Zul Fitri';
$pageDescription = 'Academic qualifications, scholarship recognition, and polytechnic excellence awards earned by Muhammad Zul Fitri bin Mohd Zamri.';

$educationList = query_items(load_dataset('education'), [
    'sort_by' => 'start_date',
    'direction' => 'desc',
]);

// Flatten academic achievements across qualifications for the dedicated honors strip
$allHonors = [];
foreach ($educationList as $edu) {
    if (!empty($edu['achievements']) && is_array($edu['achievements'])) {
        foreach ($edu['achievements'] as $award) {
            $allHonors[] = [
                'title' => (string) $award,
                'institution' => (string) ($edu['institution'] ?? ''),
            ];
        }
    }
}

include __DIR__ . '/header.php';
?>

<main id="main-content">
    <!-- Page Header -->
    <section aria-labelledby="education-page-heading" class="border-b border-slate-200/80 bg-slate-50 py-12 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-4 text-xs font-medium text-slate-500">
                <ol class="flex items-center gap-2">
                    <li><a href="index.php" class="hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Home</a></li>
                    <li aria-hidden="true">/</li>
                    <li class="text-slate-900" aria-current="page">Education</li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Academic Background</p>
                <h1 id="education-page-heading" class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    Education &amp; Academic Achievements
                </h1>
                <p class="mt-3 text-base leading-relaxed text-slate-600">
                    Software development degree at UTeM backed by a Diploma in Digital Technology (CGPA 3.62) and multiple institutional excellence awards.
                </p>
            </div>
        </div>
    </section>

    <!-- Education Visual Showcase Cards -->
    <section aria-label="Qualifications" class="bg-white py-14 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <?php if (empty($educationList)): ?>
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 p-12 text-center">
                    <p class="text-sm font-medium text-slate-700">No education entries added yet.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <?php foreach ($educationList as $edu): ?>
                        <?php
                        $degree = (string) ($edu['degree'] ?? '');
                        $institution = (string) ($edu['institution'] ?? '');
                        $dateRange = format_date_range(
                            isset($edu['start_date']) ? (string) $edu['start_date'] : null,
                            isset($edu['end_date']) ? (string) $edu['end_date'] : null,
                            (bool) ($edu['is_current'] ?? false)
                        );
                        $cover = resolve_cover_image($edu, $degree);
                        $gallery = resolve_item_gallery($edu, $degree);
                        $achievements = is_array($edu['achievements'] ?? null) ? $edu['achievements'] : [];
                        $coursework = is_array($edu['coursework'] ?? null) ? $edu['coursework'] : [];
                        $meta = implode(' · ', array_filter([$institution, $dateRange]));
                        ?>
                        <article data-lazy-card class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs transition-shadow hover:shadow-md">
                            <?= render_card_skeleton('card', 'aspect-video', count($gallery) > 1) ?>
                            <div data-lazy-content class="flex flex-1 flex-col">
                                <?php if ($cover !== null): ?>
                                    <button
                                        type="button"
                                        data-gallery-trigger
                                        data-gallery="<?= e(json_encode($gallery, JSON_UNESCAPED_SLASHES)) ?>"
                                        data-gallery-index="0"
                                        data-gallery-title="<?= e($degree) ?>"
                                        data-gallery-meta="<?= e($meta) ?>"
                                        class="lazy-media-wrap relative aspect-video w-full cursor-pointer overflow-hidden bg-slate-100 text-left focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        <?= render_media_skeleton() ?>
                                        <img
                                            src="<?= e($cover['src']) ?>"
                                            alt="<?= e($cover['alt']) ?>"
                                            data-lazy-img
                                            loading="lazy"
                                            decoding="async"
                                            class="h-full w-full object-cover transition-transform duration-300 motion-safe:group-hover:scale-105">
                                        <span class="absolute right-3 bottom-3 inline-flex items-center gap-1.5 rounded-full bg-slate-900/75 px-3 py-1 text-xs font-medium text-white backdrop-blur-xs">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                                            </svg>
                                            <span><?= count($gallery) > 1 ? e(count($gallery)) . ' Photos' : 'View Showcase' ?></span>
                                        </span>
                                    </button>

                                    <?php if (count($gallery) > 1): ?>
                                        <div class="flex gap-2 overflow-x-auto border-b border-slate-100 bg-slate-50 px-4 py-2.5">
                                            <?php foreach ($gallery as $idx => $slide): ?>
                                                <button
                                                    type="button"
                                                    data-gallery-trigger
                                                    data-gallery="<?= e(json_encode($gallery, JSON_UNESCAPED_SLASHES)) ?>"
                                                    data-gallery-index="<?= e($idx) ?>"
                                                    data-gallery-title="<?= e($degree) ?>"
                                                    data-gallery-meta="<?= e($meta) ?>"
                                                    class="lazy-media-wrap h-12 w-18 shrink-0 cursor-pointer overflow-hidden rounded-lg border border-slate-200 bg-white transition-all hover:border-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <?= render_media_skeleton('rounded-lg') ?>
                                                    <img src="<?= e($slide['src']) ?>" alt="<?= e($slide['alt']) ?>" data-lazy-img loading="lazy" decoding="async" class="h-full w-full object-cover">
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <div class="flex flex-1 flex-col p-6 sm:p-7">
                                    <div class="flex flex-wrap items-center justify-between gap-2 text-xs">
                                        <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 font-semibold text-indigo-700"><?= e($dateRange) ?></span>
                                        <?php if (!empty($edu['grade'])): ?>
                                            <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 font-semibold text-emerald-700"><?= e($edu['grade']) ?></span>
                                        <?php elseif (!empty($edu['is_current'])): ?>
                                            <span class="rounded-full bg-slate-100 px-2.5 py-0.5 font-medium text-slate-700">Currently Enrolled</span>
                                        <?php endif; ?>
                                    </div>

                                    <h2 class="mt-4 text-xl font-semibold text-slate-900"><?= e($degree) ?></h2>
                                    <p class="mt-1 text-sm font-medium text-indigo-700"><?= e($institution) ?></p>
                                    <?php if (!empty($edu['location'])): ?>
                                        <p class="mt-0.5 text-xs text-slate-500"><?= e($edu['location']) ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($achievements)): ?>
                                        <div class="mt-5 border-t border-slate-100 pt-4">
                                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Honors &amp; Scholarships</p>
                                            <ul class="mt-2.5 space-y-2 text-sm text-slate-700">
                                                <?php foreach ($achievements as $award): ?>
                                                    <li class="flex items-start gap-2">
                                                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                                                        </svg>
                                                        <span><?= e($award) ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($coursework)): ?>
                                        <div class="mt-4 border-t border-slate-100 pt-4">
                                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Relevant Coursework</p>
                                            <ul class="mt-2 flex flex-wrap gap-1.5">
                                                <?php foreach ($coursework as $course): ?>
                                                    <li class="rounded-md bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700"><?= e($course) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Honors & Awards Summary Band -->
    <?php if (!empty($allHonors)): ?>
        <section aria-labelledby="honors-heading" class="border-t border-slate-200/80 bg-slate-50 py-14 sm:py-16">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Recognition</p>
                    <h2 id="honors-heading" class="mt-2 text-2xl font-bold tracking-tight text-slate-900">
                        Scholarships &amp; Academic Honors
                    </h2>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <?php foreach ($allHonors as $honor): ?>
                        <div data-lazy-card class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs">
                            <?= render_card_skeleton('compact') ?>
                            <div data-lazy-content>
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600" aria-hidden="true">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                </span>
                                <h3 class="mt-3 text-sm font-semibold text-slate-900"><?= e($honor['title']) ?></h3>
                                <p class="mt-1 text-xs leading-5 text-slate-500"><?= e($honor['institution']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/footer.php'; ?>
