<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/data.php';

$activePage = 'projects';
$pageTitle = 'Projects Showcase — Muhammad Zul Fitri';
$pageDescription = 'Software engineering and computer vision projects built by Muhammad Zul Fitri using .NET, Blazor, Laravel, Python, OpenCV, and Ultralytics.';

$projects = query_items(load_dataset('project'), [
    'sort_by' => 'order',
    'direction' => 'asc',
]);
$projectCategories = extract_categories($projects);

include __DIR__ . '/header.php';
?>

<main id="main-content">
    <!-- Page Header -->
    <section aria-labelledby="projects-page-heading" class="border-b border-slate-200/80 bg-slate-50 py-12 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-4 text-xs font-medium text-slate-500">
                <ol class="flex items-center gap-2">
                    <li><a href="index.php" class="hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Home</a></li>
                    <li aria-hidden="true">/</li>
                    <li class="text-slate-900" aria-current="page">Projects</li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Engineering Portfolio</p>
                <h1 id="projects-page-heading" class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    Projects &amp; Technical Showcase
                </h1>
                <p class="mt-3 text-base leading-relaxed text-slate-600">
                    Customer-facing enterprise systems, full-stack smart mobility platforms, and computer vision applications. Click any showcase image to inspect it in full view.
                </p>
            </div>

            <!-- Filter & Search Controls -->
            <?php if (!empty($projects)): ?>
                <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between print:hidden">
                    <div class="flex flex-wrap items-center gap-2" role="group" aria-label="Filter projects by category" data-filter-group="projects">
                        <button
                            type="button"
                            data-filter-value="all"
                            aria-pressed="true"
                            class="cursor-pointer rounded-full border border-indigo-600 bg-indigo-600 px-3.5 py-1.5 text-xs font-medium text-white transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            All (<?= e(count($projects)) ?>)
                        </button>
                        <?php foreach ($projectCategories as $cat): ?>
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
                        <label for="projects-search" class="sr-only">Search projects</label>
                        <input
                            id="projects-search"
                            type="search"
                            data-filter-search="projects"
                            placeholder="Search technologies or titles..."
                            class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-2 focus:outline-offset-0 focus:outline-indigo-600">
                    </div>
                </div>
                <p class="sr-only" aria-live="polite" data-filter-status="projects"></p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Projects Showcase Grid -->
    <section aria-label="Project list" class="bg-white py-14 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <?php if (empty($projects)): ?>
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 p-12 text-center">
                    <p class="text-sm font-medium text-slate-700">No projects added yet.</p>
                    <p class="mt-1 text-sm text-slate-500">Add entries to <code class="rounded bg-slate-200/70 px-1.5 py-0.5 text-xs text-slate-800">data/project.json</code>.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <?php foreach ($projects as $project): ?>
                        <?php
                        $title = (string) ($project['title'] ?? 'Untitled Project');
                        $cover = resolve_cover_image($project, $title);
                        $gallery = resolve_item_gallery($project, $title);
                        $tags = is_array($project['tags'] ?? null) ? $project['tags'] : [];
                        $highlights = is_array($project['highlights'] ?? null) ? $project['highlights'] : [];
                        $liveUrl = safe_url(isset($project['live_url']) ? (string) $project['live_url'] : null);
                        $repoUrl = safe_url(isset($project['repo_url']) ? (string) $project['repo_url'] : null);
                        $caseUrl = safe_url(isset($project['case_study_url']) ? (string) $project['case_study_url'] : null);
                        $meta = implode(' · ', array_filter([$project['category'] ?? '', $project['role'] ?? '', $project['year'] ?? '']));
                        $searchBlob = implode(' ', array_merge([$title, (string) ($project['description'] ?? ''), (string) ($project['category'] ?? '')], $tags));
                        ?>
                        <article
                            data-lazy-card
                            data-filter-item="projects"
                            data-category="<?= e($project['category'] ?? '') ?>"
                            data-search="<?= e($searchBlob) ?>"
                            class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs transition-shadow hover:shadow-md">
                            <?= render_card_skeleton('card', 'aspect-video', count($gallery) > 1) ?>
                            <div data-lazy-content class="flex flex-1 flex-col">
                                <?php if ($cover !== null): ?>
                                    <button
                                        type="button"
                                        data-gallery-trigger
                                        data-gallery="<?= e(json_encode($gallery, JSON_UNESCAPED_SLASHES)) ?>"
                                        data-gallery-index="0"
                                        data-gallery-title="<?= e($title) ?>"
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
                                            <span><?= count($gallery) > 1 ? e(count($gallery)) . ' Images' : 'View Showcase' ?></span>
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
                                                    data-gallery-title="<?= e($title) ?>"
                                                    data-gallery-meta="<?= e($meta) ?>"
                                                    class="lazy-media-wrap h-12 w-18 shrink-0 cursor-pointer overflow-hidden rounded-lg border border-slate-200 bg-white transition-all hover:border-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <?= render_media_skeleton('rounded-lg') ?>
                                                    <img src="<?= e($slide['src']) ?>" alt="<?= e($slide['alt']) ?>" data-lazy-img loading="lazy" decoding="async" class="h-full w-full object-cover">
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <div class="flex flex-1 flex-col p-6">
                                    <div class="flex items-center justify-between gap-2 text-xs">
                                        <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 font-semibold text-indigo-700">
                                            <?= e($project['category'] ?? 'Project') ?>
                                        </span>
                                        <span class="font-medium text-slate-500"><?= e($project['year'] ?? '') ?></span>
                                    </div>

                                    <h2 class="mt-3 text-xl font-semibold text-slate-900"><?= e($title) ?></h2>
                                    <?php if (!empty($project['role'])): ?>
                                        <p class="mt-1 text-xs font-medium text-slate-500"><?= e($project['role']) ?></p>
                                    <?php endif; ?>

                                    <p class="mt-3 text-sm leading-6 text-slate-600">
                                        <?= e($project['description'] ?? ($project['tagline'] ?? '')) ?>
                                    </p>

                                    <?php if (!empty($highlights)): ?>
                                        <ul class="mt-4 space-y-1.5 text-sm leading-6 text-slate-600">
                                            <?php foreach ($highlights as $point): ?>
                                                <li class="flex items-start gap-2">
                                                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-indigo-600" aria-hidden="true"></span>
                                                    <span><?= e($point) ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <div class="mt-auto pt-5">
                                        <?php if (!empty($tags)): ?>
                                            <ul class="flex flex-wrap gap-1.5" aria-label="Technologies used">
                                                <?php foreach ($tags as $tag): ?>
                                                    <li class="rounded-md bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700"><?= e($tag) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if ($liveUrl || $repoUrl || $caseUrl): ?>
                                            <div class="mt-4 flex flex-wrap gap-4 border-t border-slate-100 pt-4 text-xs font-semibold">
                                                <?php if ($liveUrl): ?>
                                                    <a href="<?= e($liveUrl) ?>" target="_blank" rel="noopener noreferrer" class="text-indigo-600 hover:text-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Live Demo &rarr;</a>
                                                <?php endif; ?>
                                                <?php if ($repoUrl): ?>
                                                    <a href="<?= e($repoUrl) ?>" target="_blank" rel="noopener noreferrer" class="text-slate-700 hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Source Code &rarr;</a>
                                                <?php endif; ?>
                                                <?php if ($caseUrl): ?>
                                                    <a href="<?= e($caseUrl) ?>" target="_blank" rel="noopener noreferrer" class="text-slate-700 hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Case Study &rarr;</a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div data-filter-empty="projects" class="hidden rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center">
                    <p class="text-sm font-medium text-slate-700">No projects match your current filter.</p>
                    <p class="mt-1 text-sm text-slate-500">Try clearing the search box or switching back to All categories.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
