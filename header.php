<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/data.php';

$siteBaseUrl = 'https://mhdzulfitriii.github.io/portfolio/';
$siteName = 'Muhammad Zul Fitri — Portfolio';
$pageTitle = $pageTitle ?? 'Muhammad Zul Fitri — Software Developer & Event Photographer';
$pageDescription = $pageDescription ?? 'Personal portfolio of Muhammad Zul Fitri bin Mohd Zamri — Software Development student at UTeM, former Junior Software Developer at HeiTech Padu Berhad, and Event Photographer.';
$pageKeywords = $pageKeywords ?? 'Muhammad Zul Fitri, Muhammad Zul Fitri bin Mohd Zamri, ZulFitri, Software Developer Malaysia, Event Photographer Malaysia, UTeM Software Development, HeiTech Padu, .NET, Blazor, Laravel, Python OpenCV, PKPIM, Portfolio';

$activePage = $activePage ?? pathinfo((string) ($_SERVER['SCRIPT_NAME'] ?? 'index.php'), PATHINFO_FILENAME);
if ($activePage === 'index') {
    $activePage = 'home';
}

$canonicalMap = [
    'home'        => '',
    'projects'    => 'projects.html',
    'experience'  => 'experience.html',
    'education'   => 'education.html',
    'photography' => 'photography.html',
    'volunteer'   => 'volunteer.html',
];
$canonicalPath = $canonicalMap[$activePage] ?? '';
$canonicalUrl = $siteBaseUrl . $canonicalPath;

$ogImageUrl = $siteBaseUrl . 'asset/og-image.jpg';
$ogImageAlt = 'Muhammad Zul Fitri bin Mohd Zamri — Software Developer & Event Photographer Portfolio';
$ogType = $activePage === 'home' ? 'profile' : 'website';

$hasResumePdf = local_asset_exists('asset/resume.pdf');

$navItems = [
    ['id' => 'home', 'href' => 'index.php', 'label' => 'Home'],
    ['id' => 'projects', 'href' => 'projects.php', 'label' => 'Projects'],
    ['id' => 'experience', 'href' => 'experience.php', 'label' => 'Experience'],
    ['id' => 'education', 'href' => 'education.php', 'label' => 'Education'],
    ['id' => 'photography', 'href' => 'photography.php', 'label' => 'Photography'],
    ['id' => 'volunteer', 'href' => 'volunteer.php', 'label' => 'Volunteer'],
    ['id' => 'contact', 'href' => 'index.php#contact', 'label' => 'Contact'],
];

// Build JSON-LD structured data for rich search results
$jsonLdGraph = [
    [
        '@type' => 'Person',
        '@id' => $siteBaseUrl . '#person',
        'name' => 'Muhammad Zul Fitri bin Mohd Zamri',
        'alternateName' => 'ZulFitri',
        'url' => $siteBaseUrl,
        'image' => $siteBaseUrl . 'asset/profile.jpg',
        'jobTitle' => 'Software Developer & Event Photographer',
        'email' => 'mailto:zul.ilhae@gmail.com',
        'telephone' => '+6018-2560 425',
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Bandar Saujana Putra',
            'addressRegion' => 'Selangor',
            'addressCountry' => 'MY',
        ],
        'alumniOf' => [
            [
                '@type' => 'CollegeOrUniversity',
                'name' => 'Universiti Teknikal Malaysia Melaka (UTeM)',
            ],
            [
                '@type' => 'EducationalOrganization',
                'name' => 'Politeknik Sultan Mizan Zainal Abidin (PSMZA)',
            ],
        ],
        'memberOf' => [
            [
                '@type' => 'Organization',
                'name' => 'Persatuan Kebangsaan Pelajar Islam Malaysia (PKPIM)',
            ],
        ],
        'knowsAbout' => [
            'Software Development',
            '.NET',
            'Blazor',
            'Laravel',
            'Python',
            'OpenCV',
            'Ultralytics',
            'Event Photography',
            'Documentary Photography',
        ],
        'sameAs' => [
            'https://www.linkedin.com/in/mhdzulfitri',
            'https://github.com/mhdzulfitriii',
        ],
    ],
    [
        '@type' => 'WebSite',
        '@id' => $siteBaseUrl . '#website',
        'url' => $siteBaseUrl,
        'name' => $siteName,
        'description' => $pageDescription,
        'publisher' => ['@id' => $siteBaseUrl . '#person'],
        'inLanguage' => 'en-MY',
    ],
    [
        '@type' => $activePage === 'home' ? 'ProfilePage' : 'CollectionPage',
        '@id' => $canonicalUrl . '#webpage',
        'url' => $canonicalUrl,
        'name' => $pageTitle,
        'description' => $pageDescription,
        'isPartOf' => ['@id' => $siteBaseUrl . '#website'],
        'about' => ['@id' => $siteBaseUrl . '#person'],
        'primaryImageOfPage' => [
            '@type' => 'ImageObject',
            'url' => $ogImageUrl,
            'width' => 1200,
            'height' => 630,
        ],
        'inLanguage' => 'en-MY',
    ],
];

if ($activePage !== 'home') {
    $pageLabel = ucfirst($activePage);
    $jsonLdGraph[] = [
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => $siteBaseUrl,
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $pageLabel,
                'item' => $canonicalUrl,
            ],
        ],
    ];
}

$jsonLdPayload = json_encode(
    ['@context' => 'https://schema.org', '@graph' => $jsonLdGraph],
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth motion-reduce:scroll-auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <meta name="keywords" content="<?= e($pageKeywords) ?>">
    <meta name="author" content="Muhammad Zul Fitri bin Mohd Zamri">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="theme-color" content="#4f46e5">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">

    <!-- Icons -->
    <link rel="icon" type="image/svg+xml" href="asset/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="asset/apple-touch-icon.png">

    <!-- Open Graph / WhatsApp / Facebook / LinkedIn -->
    <meta property="og:type" content="<?= e($ogType) ?>">
    <meta property="og:site_name" content="<?= e($siteName) ?>">
    <meta property="og:locale" content="en_MY">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:image" content="<?= e($ogImageUrl) ?>">
    <meta property="og:image:secure_url" content="<?= e($ogImageUrl) ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?= e($ogImageAlt) ?>">

    <!-- Twitter / X Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= e($canonicalUrl) ?>">
    <meta name="twitter:title" content="<?= e($pageTitle) ?>">
    <meta name="twitter:description" content="<?= e($pageDescription) ?>">
    <meta name="twitter:image" content="<?= e($ogImageUrl) ?>">
    <meta name="twitter:image:alt" content="<?= e($ogImageAlt) ?>">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json"><?= $jsonLdPayload ?></script>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="flex min-h-screen flex-col bg-white text-slate-900 antialiased selection:bg-indigo-100 selection:text-indigo-900">
    <!-- Accessible Skip Navigation Link -->
    <a
        href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:rounded-lg focus:bg-indigo-600 focus:px-4 focus:py-2 focus:text-sm focus:font-medium focus:text-white focus:shadow-lg focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">
        Skip to main content
    </a>

    <header class="sticky top-0 z-50 w-full border-b border-slate-200/80 bg-white/85 backdrop-blur-md print:hidden">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <!-- Brand / Logo -->
            <a
                href="index.php"
                class="rounded-md text-xl font-bold tracking-tight text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                ZulFitri<span class="text-indigo-600">.dev</span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden items-center gap-1 md:flex" aria-label="Main Navigation">
                <?php foreach ($navItems as $nav): ?>
                    <?php $isCurrent = ($activePage === $nav['id']); ?>
                    <a
                        href="<?= e($nav['href']) ?>"
                        <?= $isCurrent ? 'aria-current="page"' : '' ?>
                        class="rounded-lg px-3 py-2 text-sm transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 <?= $isCurrent ? 'bg-indigo-50 font-semibold text-indigo-700' : 'font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600' ?>">
                        <?= e($nav['label']) ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <!-- Desktop CTA -->
            <div class="hidden items-center gap-3 md:flex">
                <?php if ($hasResumePdf): ?>
                    <a
                        href="asset/resume.pdf"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="rounded-lg px-3.5 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-100 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Resume
                        <span class="sr-only">(opens PDF in a new tab)</span>
                    </a>
                <?php else: ?>
                    <button
                        type="button"
                        data-print-cv
                        class="cursor-pointer rounded-lg px-3.5 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-100 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Print Page
                    </button>
                <?php endif; ?>
                <a
                    href="index.php#contact"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-xs transition-colors hover:bg-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Get in Touch
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button
                id="mobile-menu-btn"
                type="button"
                class="inline-flex h-11 w-11 items-center justify-center rounded-lg text-slate-600 transition-colors hover:bg-slate-100 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 md:hidden"
                aria-controls="mobile-menu"
                aria-expanded="false">
                <span class="sr-only">Toggle main navigation menu</span>
                <svg id="icon-open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg id="icon-close" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white md:hidden">
            <nav aria-label="Mobile Navigation" class="space-y-1 px-4 pt-3 pb-4">
                <?php foreach ($navItems as $nav): ?>
                    <?php $isCurrent = ($activePage === $nav['id']); ?>
                    <a
                        href="<?= e($nav['href']) ?>"
                        data-mobile-nav-link
                        <?= $isCurrent ? 'aria-current="page"' : '' ?>
                        class="block rounded-lg px-3 py-2.5 text-base transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 <?= $isCurrent ? 'bg-indigo-50 font-semibold text-indigo-700' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-indigo-600' ?>">
                        <?= e($nav['label']) ?>
                    </a>
                <?php endforeach; ?>
                <div class="mt-4 flex flex-col gap-2 border-t border-slate-100 pt-4">
                    <?php if ($hasResumePdf): ?>
                        <a
                            href="asset/resume.pdf"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-center text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Resume (PDF)
                        </a>
                    <?php else: ?>
                        <button
                            type="button"
                            data-print-cv
                            class="w-full cursor-pointer rounded-lg border border-slate-200 px-4 py-2.5 text-center text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Print Page
                        </button>
                    <?php endif; ?>
                    <a
                        href="index.php#contact"
                        data-mobile-nav-link
                        class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-center text-sm font-medium text-white transition-colors hover:bg-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Get in Touch
                    </a>
                </div>
            </nav>
        </div>
    </header>
