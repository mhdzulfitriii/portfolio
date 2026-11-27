<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/data.php';

$activePage = 'home';
$pageTitle = 'Muhammad Zul Fitri — Software Developer & Event Photographer';
$pageDescription = 'Personal portfolio of Muhammad Zul Fitri bin Mohd Zamri — Software Development student at UTeM, former Junior Software Developer at HeiTech Padu Berhad, and Event Photographer.';

$projects = query_items(load_dataset('project'), ['sort_by' => 'order', 'direction' => 'asc']);
$experiences = query_items(load_dataset('experience'), ['sort_by' => 'start_date', 'direction' => 'desc']);
$educationList = query_items(load_dataset('education'), ['sort_by' => 'start_date', 'direction' => 'desc']);
$photos = query_items(load_dataset('photography'), ['sort_by' => 'date', 'direction' => 'desc']);
$volunteerPrograms = query_items(load_dataset('volunteer'), ['sort_by' => 'program_date', 'direction' => 'desc']);
$organizations = query_items(load_dataset('organization'), ['sort_by' => 'start_date', 'direction' => 'desc']);

$featuredProjects = array_slice($projects, 0, 3);
$featuredPhotos = query_items($photos, ['featured' => true, 'limit' => 3]);

$profileImage = null;
foreach (['asset/profile.webp', 'asset/profile.jpg', 'asset/profile.jpeg', 'asset/profile.png'] as $candidate) {
    if (local_asset_exists($candidate)) {
        $profileImage = $candidate;
        break;
    }
}

$contact = [
    'name' => 'Muhammad Zul Fitri bin Mohd Zamri',
    'location' => 'Bandar Saujana Putra, Selangor',
    'phone_display' => '+6018-2560 425',
    'phone_href' => 'tel:+60182560425',
    'email' => 'zul.ilhae@gmail.com',
    'linkedin_handle' => 'mhdzulfitri',
    'linkedin_url' => 'https://www.linkedin.com/in/mhdzulfitri',
];

$showcasePages = [
    [
        'title' => 'Projects Showcase',
        'href' => 'projects.php',
        'count' => count($projects) . ' Systems',
        'description' => 'Enterprise .NET/Blazor apps, Laravel smart parking platform, and Python OpenCV computer vision.',
        'cover' => !empty($projects) ? resolve_cover_image($projects[0], 'Projects') : null,
    ],
    [
        'title' => 'Work Experience',
        'href' => 'experience.php',
        'count' => count($experiences) . ' Roles',
        'description' => 'Industry software development at HeiTech Padu Berhad and official ASEAN volunteer photography.',
        'cover' => !empty($experiences) ? resolve_cover_image($experiences[0], 'Experience') : null,
    ],
    [
        'title' => 'Education & Honors',
        'href' => 'education.php',
        'count' => count($educationList) . ' Qualifications',
        'description' => 'Bachelor of CS at UTeM (YBTM KPT – PCP Scholar) and Diploma in IT at PSMZA (CGPA 3.62).',
        'cover' => !empty($educationList) ? resolve_cover_image($educationList[0], 'Education') : null,
    ],
    [
        'title' => 'Photography Showcase',
        'href' => 'photography.php',
        'count' => count($photos) . ' Events',
        'description' => 'Fast-paced event, regional ASEAN, international, and VIP protocol photography coverage.',
        'cover' => !empty($photos) ? resolve_cover_image($photos[0], 'Photography') : null,
    ],
    [
        'title' => 'Volunteer & NGO',
        'href' => 'volunteer.php',
        'count' => count($volunteerPrograms) . ' Programmes · ' . count($organizations) . ' NGO',
        'description' => 'PKPIM leadership (Penolong Setiausaha 1) and volunteer programmes across Malaysia & ASEAN.',
        'cover' => !empty($organizations) ? resolve_cover_image($organizations[0], 'Volunteer') : (!empty($volunteerPrograms) ? resolve_cover_image($volunteerPrograms[0], 'Volunteer') : null),
    ],
];

include __DIR__ . '/header.php';
?>

<main id="main-content">
    <!-- Hero / About Section -->
    <section id="about" aria-labelledby="hero-heading" class="scroll-mt-20 bg-white py-16 sm:py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-12">
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2 rounded-full border border-indigo-200/80 bg-indigo-50 px-3.5 py-1 text-xs font-semibold text-indigo-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-600" aria-hidden="true"></span>
                        <span>Software Developer</span>
                    </div>

                    <h1 id="hero-heading" class="mt-5 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
                        Muhammad Zul Fitri
                        <span class="mt-1 block text-2xl font-semibold text-indigo-600 sm:text-3xl">
                            bin Mohd Zamri
                        </span>
                    </h1>

                    <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg sm:leading-8">
                        Motivated and detail-oriented Photographer with a strong technical foundation in software development, bringing a unique analytical approach to visual storytelling. Proven experience in event and fast-paced photography, with a sharp eye for capturing candid moments under pressure, paired with industry engineering in .NET, Blazor, Laravel, and computer vision.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a
                            href="projects.php"
                            class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-xs transition-colors hover:bg-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Projects Showcase
                        </a>
                        <a
                            href="photography.php"
                            class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Photography Showcase
                        </a>
                        <a
                            href="<?= e($contact['linkedin_url']) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 rounded-lg px-3.5 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <span>LinkedIn</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                            <span class="sr-only">(opens in a new tab)</span>
                        </a>
                    </div>
                </div>

                <!-- Profile Card -->
                <div class="lg:col-span-5">
                    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-50/70 p-6 shadow-xs sm:p-7">
                        <div class="flex items-center gap-4">
                            <?php if ($profileImage !== null): ?>
                                <img
                                    src="<?= e($profileImage) ?>"
                                    alt="Portrait of Muhammad Zul Fitri bin Mohd Zamri"
                                    class="h-20 w-20 shrink-0 rounded-2xl border border-slate-200 object-cover shadow-xs">
                            <?php else: ?>
                                <div
                                    class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-indigo-600 text-2xl font-bold tracking-tight text-white shadow-xs"
                                    aria-hidden="true">
                                    ZF
                                </div>
                            <?php endif; ?>
                            <div>
                                <p class="text-base font-semibold text-slate-900">Muhammad Zul Fitri</p>
                                <p class="text-sm text-slate-600"><?= e($contact['location']) ?></p>
                                <p class="mt-1 inline-flex items-center gap-1.5 text-xs font-medium text-indigo-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                    Open to collaborations &amp; opportunities
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4 border-t border-slate-200/80 pt-5">
                            <div class="rounded-xl border border-slate-200/80 bg-white p-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Software Development</p>
                                <p class="mt-1 text-sm leading-6 text-slate-600">
                                    Customer-facing enterprise systems, smart web platforms, and real-time computer vision.
                                </p>
                                <ul class="mt-3 flex flex-wrap gap-1.5" aria-label="Software development skills">
                                    <?php foreach (['.NET', 'Blazor', 'Laravel', 'Python', 'OpenCV', 'Ultralytics'] as $skill): ?>
                                        <li class="rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700"><?= e($skill) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- <div class="rounded-xl border border-slate-200/80 bg-white p-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Event Photography</p>
                                <p class="mt-1 text-sm leading-6 text-slate-600">
                                    Fast-paced documentary and VIP protocol coverage across Malaysia and ASEAN.
                                </p>
                                <ul class="mt-3 flex flex-wrap gap-1.5" aria-label="Photography strengths">
                                    <?php foreach (['VIP & Protocol', 'Candid Storytelling', 'Digital Editing', 'ASEAN Events'] as $skill): ?>
                                        <li class="rounded-md bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-700"><?= e($skill) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Multi-Page Portfolio Showcase Directory -->
    <section aria-labelledby="directory-heading" class="border-t border-slate-200/80 bg-slate-50 py-16 sm:py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Explore Portfolio</p>
                <h2 id="directory-heading" class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Dedicated Visual Showcases
                </h2>
                <p class="mt-3 text-base leading-relaxed text-slate-600">
                    Browse dedicated pages for projects, work experience, education, and event photography — each with interactive image galleries.
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($showcasePages as $card): ?>
                    <a
                        href="<?= e($card['href']) ?>"
                        class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs transition-all hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <?php if ($card['cover'] !== null): ?>
                            <div class="aspect-[16/10] w-full overflow-hidden bg-slate-100">
                                <img
                                    src="<?= e($card['cover']['src']) ?>"
                                    alt="<?= e($card['cover']['alt']) ?>"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition-transform duration-300 motion-safe:group-hover:scale-105">
                            </div>
                        <?php endif; ?>
                        <div class="flex flex-1 flex-col p-5">
                            <span class="text-xs font-semibold text-indigo-600"><?= e($card['count']) ?></span>
                            <h3 class="mt-1 text-base font-semibold text-slate-900 group-hover:text-indigo-700">
                                <?= e($card['title']) ?>
                            </h3>
                            <p class="mt-2 flex-1 text-sm leading-6 text-slate-600">
                                <?= e($card['description']) ?>
                            </p>
                            <span class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-indigo-600">
                                Open Showcase
                                <span aria-hidden="true" class="transition-transform motion-safe:group-hover:translate-x-0.5">&rarr;</span>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Photography & Projects Teaser -->
    <section aria-labelledby="featured-heading" class="border-t border-slate-200/80 bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Highlights</p>
                    <h2 id="featured-heading" class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Featured Photography Coverage
                    </h2>
                </div>
                <a
                    href="photography.php"
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    View all <?= e(count($photos)) ?> events &rarr;
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3">
                <?php foreach ($featuredPhotos as $photo): ?>
                    <?php
                    $cover = resolve_cover_image($photo, (string) ($photo['title'] ?? ''));
                    $gallery = resolve_item_gallery($photo, (string) ($photo['title'] ?? ''));
                    $metaString = implode(' · ', array_filter([
                        $photo['location'] ?? '',
                        format_date_label(isset($photo['date']) ? (string) $photo['date'] : null),
                    ]));
                    ?>
                    <article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs transition-shadow hover:shadow-md">
                        <?php if ($cover !== null): ?>
                            <button
                                type="button"
                                data-gallery-trigger
                                data-gallery="<?= e(json_encode($gallery, JSON_UNESCAPED_SLASHES)) ?>"
                                data-gallery-index="0"
                                data-gallery-title="<?= e($photo['title'] ?? '') ?>"
                                data-gallery-meta="<?= e($metaString) ?>"
                                class="relative aspect-[4/3] w-full cursor-pointer overflow-hidden bg-slate-100 text-left focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                <img
                                    src="<?= e($cover['src']) ?>"
                                    alt="<?= e($cover['alt']) ?>"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition-transform duration-300 motion-safe:group-hover:scale-105">
                                <span class="sr-only">Preview image for <?= e($photo['title'] ?? '') ?></span>
                            </button>
                        <?php endif; ?>
                        <div class="flex flex-1 flex-col p-5">
                            <div class="flex items-center justify-between gap-2 text-xs">
                                <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 font-medium text-indigo-700"><?= e($photo['category'] ?? '') ?></span>
                                <span class="text-slate-500"><?= e(format_date_label(isset($photo['date']) ? (string) $photo['date'] : null)) ?></span>
                            </div>
                            <h3 class="mt-3 text-base font-semibold text-slate-900"><?= e($photo['title'] ?? '') ?></h3>
                            <p class="mt-2 flex-1 text-sm leading-6 text-slate-600"><?= e($photo['caption'] ?? '') ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" aria-labelledby="contact-heading" class="scroll-mt-20 border-t border-slate-200/80 bg-slate-50 py-16 sm:py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl border border-slate-200/80 bg-white p-8 shadow-xs sm:p-10 lg:p-12">
                <div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:items-center">
                    <div class="lg:col-span-6">
                        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Let's Connect</p>
                        <h2 id="contact-heading" class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            Ready to collaborate on software or event photography?
                        </h2>
                        <p class="mt-3 text-base leading-relaxed text-slate-600">
                            Whether you are looking for a detail-oriented software developer or an experienced photographer for formal, youth, or institutional events, feel free to reach out directly.
                        </p>

                        <div class="mt-6 flex flex-wrap items-center gap-3 print:hidden">
                            <a
                                href="mailto:<?= e($contact['email']) ?>"
                                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-xs transition-colors hover:bg-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Send an Email
                            </a>
                            <button
                                id="copy-email-btn"
                                type="button"
                                data-copy-email="<?= e($contact['email']) ?>"
                                class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Copy Email
                            </button>
                            <span id="copy-email-status" class="sr-only" aria-live="polite"></span>
                        </div>
                    </div>

                    <div class="lg:col-span-6">
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4">
                                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Email</dt>
                                <dd class="mt-1.5 text-sm font-medium text-slate-900">
                                    <a href="mailto:<?= e($contact['email']) ?>" class="break-all rounded-xs hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        <?= e($contact['email']) ?>
                                    </a>
                                </dd>
                            </div>
                            <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4">
                                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Phone</dt>
                                <dd class="mt-1.5 text-sm font-medium text-slate-900">
                                    <a href="<?= e($contact['phone_href']) ?>" class="rounded-xs hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        <?= e($contact['phone_display']) ?>
                                    </a>
                                </dd>
                            </div>
                            <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4">
                                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">LinkedIn</dt>
                                <dd class="mt-1.5 text-sm font-medium text-slate-900">
                                    <a
                                        href="<?= e($contact['linkedin_url']) ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="rounded-xs hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        linkedin.com/in/<?= e($contact['linkedin_handle']) ?>
                                        <span class="sr-only">(opens in a new tab)</span>
                                    </a>
                                </dd>
                            </div>
                            <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4">
                                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Location</dt>
                                <dd class="mt-1.5 text-sm font-medium text-slate-900">
                                    <?= e($contact['location']) ?>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
