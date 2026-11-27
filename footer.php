    <footer class="mt-auto border-t border-slate-200/80 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
                <div>
                    <a href="index.php" class="text-base font-bold tracking-tight text-slate-900">
                        ZulFitri<span class="text-indigo-600">.tech</span>
                    </a>
                    <p class="mt-1 text-sm text-slate-500">
                        &copy; <?= e(date('Y')) ?> Muhammad Zul Fitri bin Mohd Zamri. Software Development &amp; Event Photography.
                    </p>
                </div>

                <nav aria-label="Footer Navigation" class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm font-medium text-slate-600 print:hidden">
                    <a href="index.php" class="rounded-md transition-colors hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Home</a>
                    <a href="projects.php" class="rounded-md transition-colors hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Projects</a>
                    <a href="experience.php" class="rounded-md transition-colors hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Experience</a>
                    <a href="education.php" class="rounded-md transition-colors hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Education</a>
                    <a href="photography.php" class="rounded-md transition-colors hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Photography</a>
                    <a href="volunteer.php" class="rounded-md transition-colors hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Volunteer</a>
                    <a href="https://www.linkedin.com/in/mhdzulfitri" target="_blank" rel="noopener noreferrer" class="rounded-md transition-colors hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        LinkedIn<span class="sr-only"> (opens in a new tab)</span>
                    </a>
                </nav>
            </div>
        </div>
    </footer>

    <!-- Accessible Multi-Image Showcase Lightbox Modal -->
    <div
        id="showcase-lightbox"
        role="dialog"
        aria-modal="true"
        aria-labelledby="lightbox-title"
        class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-900/85 p-4 backdrop-blur-xs">
        <div class="relative w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-3.5">
                <div class="min-w-0">
                    <h3 id="lightbox-title" class="truncate text-base font-semibold text-slate-900"></h3>
                    <p id="lightbox-meta" class="truncate text-xs font-medium text-slate-500"></p>
                </div>
                <div class="flex shrink-0 items-center gap-2">
                    <span id="lightbox-counter" class="hidden rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700"></span>
                    <button
                        id="lightbox-close"
                        type="button"
                        class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        aria-label="Close image showcase">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="relative flex items-center justify-center bg-slate-950">
                <button
                    id="lightbox-prev"
                    type="button"
                    class="absolute left-3 z-10 hidden h-11 w-11 cursor-pointer items-center justify-center rounded-full bg-white/90 text-slate-900 shadow-md transition-colors hover:bg-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                    aria-label="Previous image">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <img id="lightbox-img" src="" alt="" class="max-h-[68vh] w-full object-contain">

                <button
                    id="lightbox-next"
                    type="button"
                    class="absolute right-3 z-10 hidden h-11 w-11 cursor-pointer items-center justify-center rounded-full bg-white/90 text-slate-900 shadow-md transition-colors hover:bg-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                    aria-label="Next image">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>

            <div class="px-5 py-4">
                <p id="lightbox-caption" class="text-sm leading-6 text-slate-600"></p>
            </div>
        </div>
    </div>

    <script>
        (function () {
            // Mobile navigation menu
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('icon-open');
            const iconClose = document.getElementById('icon-close');

            function setMenuOpen(open) {
                if (!menuBtn || !mobileMenu) return;
                menuBtn.setAttribute('aria-expanded', String(open));
                mobileMenu.classList.toggle('hidden', !open);
                if (iconOpen) iconOpen.classList.toggle('hidden', open);
                if (iconClose) iconClose.classList.toggle('hidden', !open);
            }

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', () => {
                    const isExpanded = menuBtn.getAttribute('aria-expanded') === 'true';
                    setMenuOpen(!isExpanded);
                });

                document.querySelectorAll('[data-mobile-nav-link]').forEach((link) => {
                    link.addEventListener('click', () => setMenuOpen(false));
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && menuBtn.getAttribute('aria-expanded') === 'true') {
                        setMenuOpen(false);
                        menuBtn.focus();
                    }
                });
            }

            // Print action
            document.querySelectorAll('[data-print-cv]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    setMenuOpen(false);
                    window.print();
                });
            });

            // Reusable accessible filter + optional search controller
            document.querySelectorAll('[data-filter-group]').forEach((group) => {
                const groupName = group.getAttribute('data-filter-group');
                const buttons = group.querySelectorAll('[data-filter-value]');
                const items = document.querySelectorAll(`[data-filter-item="${groupName}"]`);
                const searchInput = document.querySelector(`[data-filter-search="${groupName}"]`);
                const statusEl = document.querySelector(`[data-filter-status="${groupName}"]`);
                const emptyEl = document.querySelector(`[data-filter-empty="${groupName}"]`);

                let activeCategory = 'all';

                function applyFilters() {
                    const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
                    let visibleCount = 0;

                    items.forEach((item) => {
                        const itemCat = item.getAttribute('data-category') || '';
                        const searchHaystack = (item.getAttribute('data-search') || item.textContent || '').toLowerCase();
                        const catMatch = activeCategory === 'all' || itemCat === activeCategory;
                        const textMatch = query === '' || searchHaystack.includes(query);
                        const match = catMatch && textMatch;
                        item.classList.toggle('hidden', !match);
                        if (match) visibleCount++;
                    });

                    if (emptyEl) {
                        emptyEl.classList.toggle('hidden', visibleCount > 0);
                    }

                    if (statusEl) {
                        const label = activeCategory === 'all' ? 'all categories' : activeCategory;
                        const suffix = query ? ` matching "${query}"` : '';
                        statusEl.textContent = `Showing ${visibleCount} ${visibleCount === 1 ? 'item' : 'items'} in ${label}${suffix}.`;
                    }
                }

                buttons.forEach((button) => {
                    button.addEventListener('click', () => {
                        activeCategory = button.getAttribute('data-filter-value') || 'all';
                        buttons.forEach((btn) => {
                            const active = btn === button;
                            btn.setAttribute('aria-pressed', String(active));
                            btn.classList.toggle('bg-indigo-600', active);
                            btn.classList.toggle('text-white', active);
                            btn.classList.toggle('border-indigo-600', active);
                            btn.classList.toggle('bg-white', !active);
                            btn.classList.toggle('text-slate-700', !active);
                            btn.classList.toggle('border-slate-200', !active);
                        });
                        applyFilters();
                    });
                });

                if (searchInput) {
                    searchInput.addEventListener('input', applyFilters);
                }
            });

            // Copy email with visible & screen-reader feedback
            const copyEmailBtn = document.getElementById('copy-email-btn');
            const copyEmailStatus = document.getElementById('copy-email-status');
            if (copyEmailBtn) {
                copyEmailBtn.addEventListener('click', async () => {
                    const email = copyEmailBtn.getAttribute('data-copy-email') || '';
                    try {
                        await navigator.clipboard.writeText(email);
                        if (copyEmailStatus) copyEmailStatus.textContent = 'Email copied to clipboard.';
                        const original = copyEmailBtn.textContent;
                        copyEmailBtn.textContent = 'Copied!';
                        setTimeout(() => {
                            copyEmailBtn.textContent = original;
                            if (copyEmailStatus) copyEmailStatus.textContent = '';
                        }, 2200);
                    } catch {
                        if (copyEmailStatus) copyEmailStatus.textContent = 'Could not copy automatically. Email: ' + email;
                    }
                });
            }

            // Accessible Multi-Image Showcase Lightbox
            const lightbox = document.getElementById('showcase-lightbox');
            const lightboxClose = document.getElementById('lightbox-close');
            const lightboxPrev = document.getElementById('lightbox-prev');
            const lightboxNext = document.getElementById('lightbox-next');
            const lightboxCounter = document.getElementById('lightbox-counter');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxTitle = document.getElementById('lightbox-title');
            const lightboxCaption = document.getElementById('lightbox-caption');
            const lightboxMeta = document.getElementById('lightbox-meta');

            let slides = [];
            let currentIndex = 0;
            let lastTrigger = null;

            function renderSlide() {
                if (!slides.length) return;
                const slide = slides[currentIndex];
                if (lightboxImg) {
                    lightboxImg.src = slide.src || '';
                    lightboxImg.alt = slide.alt || '';
                }
                if (lightboxCaption) {
                    lightboxCaption.textContent = slide.caption || '';
                }
                const multi = slides.length > 1;
                if (lightboxPrev) {
                    lightboxPrev.classList.toggle('hidden', !multi);
                    lightboxPrev.classList.toggle('inline-flex', multi);
                }
                if (lightboxNext) {
                    lightboxNext.classList.toggle('hidden', !multi);
                    lightboxNext.classList.toggle('inline-flex', multi);
                }
                if (lightboxCounter) {
                    lightboxCounter.classList.toggle('hidden', !multi);
                    lightboxCounter.textContent = `${currentIndex + 1} / ${slides.length}`;
                }
            }

            function closeLightbox() {
                if (!lightbox || lightbox.classList.contains('hidden')) return;
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
                if (lastTrigger && typeof lastTrigger.focus === 'function') {
                    lastTrigger.focus();
                }
            }

            if (lightbox && lightboxClose) {
                document.querySelectorAll('[data-gallery-trigger]').forEach((trigger) => {
                    trigger.addEventListener('click', () => {
                        try {
                            const parsed = JSON.parse(trigger.getAttribute('data-gallery') || '[]');
                            if (!Array.isArray(parsed) || parsed.length === 0) return;
                            slides = parsed;
                        } catch {
                            return;
                        }

                        lastTrigger = trigger;
                        const requestedIndex = parseInt(trigger.getAttribute('data-gallery-index') || '0', 10);
                        currentIndex = Number.isNaN(requestedIndex) ? 0 : Math.max(0, Math.min(requestedIndex, slides.length - 1));

                        if (lightboxTitle) lightboxTitle.textContent = trigger.getAttribute('data-gallery-title') || '';
                        if (lightboxMeta) lightboxMeta.textContent = trigger.getAttribute('data-gallery-meta') || '';

                        renderSlide();
                        lightbox.classList.remove('hidden');
                        lightbox.classList.add('flex');
                        document.body.classList.add('overflow-hidden');
                        lightboxClose.focus();
                    });
                });

                if (lightboxPrev) {
                    lightboxPrev.addEventListener('click', () => {
                        if (slides.length < 2) return;
                        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                        renderSlide();
                    });
                }

                if (lightboxNext) {
                    lightboxNext.addEventListener('click', () => {
                        if (slides.length < 2) return;
                        currentIndex = (currentIndex + 1) % slides.length;
                        renderSlide();
                    });
                }

                lightboxClose.addEventListener('click', closeLightbox);
                lightbox.addEventListener('click', (event) => {
                    if (event.target === lightbox) closeLightbox();
                });
                document.addEventListener('keydown', (event) => {
                    if (lightbox.classList.contains('hidden')) return;
                    if (event.key === 'Escape') {
                        closeLightbox();
                    } else if (event.key === 'ArrowLeft' && slides.length > 1) {
                        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                        renderSlide();
                    } else if (event.key === 'ArrowRight' && slides.length > 1) {
                        currentIndex = (currentIndex + 1) % slides.length;
                        renderSlide();
                    }
                });
            }
        })();
    </script>
</body>

</html>
