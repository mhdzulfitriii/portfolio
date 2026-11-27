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

            <div id="lightbox-stage" class="relative flex min-h-[260px] items-center justify-center bg-slate-950 sm:min-h-[380px]">
                <div
                    id="lightbox-skeleton"
                    aria-hidden="true"
                    class="skeleton-block-dark pointer-events-none absolute inset-0 z-[5] transition-opacity duration-300 motion-reduce:transition-none"></div>

                <button
                    id="lightbox-prev"
                    type="button"
                    class="absolute left-3 z-10 hidden h-11 w-11 cursor-pointer items-center justify-center rounded-full bg-white/90 text-slate-900 shadow-md transition-colors hover:bg-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                    aria-label="Previous image">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <img id="lightbox-img" src="" alt="" decoding="async" class="relative z-[6] max-h-[68vh] w-full object-contain opacity-0 transition-opacity duration-300 motion-reduce:transition-none">

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
            const lightboxStage = document.getElementById('lightbox-stage');
            const lightboxSkeleton = document.getElementById('lightbox-skeleton');
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
            let lightboxLoadToken = 0;

            function setLightboxLoading(isLoading) {
                if (lightboxStage) {
                    lightboxStage.setAttribute('aria-busy', String(isLoading));
                }
                if (lightboxSkeleton) {
                    lightboxSkeleton.classList.toggle('opacity-100', isLoading);
                    lightboxSkeleton.classList.toggle('opacity-0', !isLoading);
                }
                if (lightboxImg) {
                    lightboxImg.classList.toggle('opacity-0', isLoading);
                    lightboxImg.classList.toggle('opacity-100', !isLoading);
                }
            }

            function renderSlide() {
                if (!slides.length) return;
                const slide = slides[currentIndex];
                if (lightboxImg) {
                    const token = ++lightboxLoadToken;
                    const nextSrc = slide.src || '';
                    setLightboxLoading(true);
                    lightboxImg.alt = slide.alt || '';

                    const finish = () => {
                        if (token !== lightboxLoadToken) return;
                        setLightboxLoading(false);
                    };

                    lightboxImg.onload = () => {
                        if (typeof lightboxImg.decode === 'function') {
                            lightboxImg.decode().catch(() => {}).finally(finish);
                        } else {
                            finish();
                        }
                    };
                    lightboxImg.onerror = finish;
                    lightboxImg.src = nextSrc;

                    if (lightboxImg.complete && lightboxImg.naturalWidth > 0) {
                        if (typeof lightboxImg.decode === 'function') {
                            lightboxImg.decode().catch(() => {}).finally(finish);
                        } else {
                            finish();
                        }
                    }
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

            // Progressive Lazy-Loading & Skeleton Reveal Controller
            const prefersReducedMotion = Boolean(
                window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches
            );

            function markImageReady(img) {
                if (!img || img.getAttribute('data-img-ready') === 'true') return;
                img.setAttribute('data-img-ready', 'true');
                const wrap = img.closest('.lazy-media-wrap');
                if (wrap) {
                    wrap.setAttribute('data-img-loaded', 'true');
                    const skeleton = wrap.querySelector('.lazy-media-skeleton');
                    if (skeleton) {
                        window.setTimeout(() => {
                            skeleton.style.display = 'none';
                        }, prefersReducedMotion ? 0 : 340);
                    }
                }
            }

            function bindLazyImage(img) {
                if (!img) return;
                const finish = () => {
                    if (typeof img.decode === 'function' && img.naturalWidth > 0) {
                        img.decode().catch(() => {}).finally(() => markImageReady(img));
                    } else {
                        markImageReady(img);
                    }
                };

                if (img.complete && img.naturalWidth > 0) {
                    finish();
                    return;
                }

                img.addEventListener('load', finish, { once: true });
                img.addEventListener('error', () => markImageReady(img), { once: true });
            }

            document.querySelectorAll('img[data-lazy-img]').forEach(bindLazyImage);

            const lazyCards = Array.from(document.querySelectorAll('[data-lazy-card]'));

            function waitForPrimaryImage(card, maxWaitMs) {
                const primaryImg = card.querySelector('img[data-lazy-img]');
                if (!primaryImg || (primaryImg.complete && primaryImg.naturalWidth > 0)) {
                    return Promise.resolve();
                }

                return new Promise((resolve) => {
                    let settled = false;
                    const done = () => {
                        if (settled) return;
                        settled = true;
                        resolve();
                    };

                    primaryImg.addEventListener('load', done, { once: true });
                    primaryImg.addEventListener('error', done, { once: true });
                    window.setTimeout(done, maxWaitMs);
                });
            }

            function revealLazyCard(card, staggerMs) {
                if (!card || card.dataset.lazyRevealing === 'true' || card.getAttribute('data-lazy-loaded') === 'true') {
                    return;
                }
                card.dataset.lazyRevealing = 'true';

                const minSkeletonMs = prefersReducedMotion ? 0 : 280 + staggerMs;
                const delayPromise = minSkeletonMs > 0
                    ? new Promise((resolve) => window.setTimeout(resolve, minSkeletonMs))
                    : Promise.resolve();

                Promise.all([waitForPrimaryImage(card, 1400), delayPromise]).then(() => {
                    card.setAttribute('data-lazy-loaded', 'true');
                    card.setAttribute('aria-busy', 'false');
                    const skeleton = card.querySelector(':scope > [data-lazy-skeleton]');
                    if (skeleton) {
                        window.setTimeout(() => {
                            skeleton.style.display = 'none';
                        }, prefersReducedMotion ? 0 : 360);
                    }
                });
            }

            if (lazyCards.length > 0) {
                lazyCards.forEach((card) => {
                    card.setAttribute('aria-busy', 'true');
                });

                if ('IntersectionObserver' in window) {
                    const cardObserver = new IntersectionObserver(
                        (entries) => {
                            let batchIndex = 0;
                            entries.forEach((entry) => {
                                if (!entry.isIntersecting) return;
                                const card = entry.target;
                                cardObserver.unobserve(card);
                                const stagger = Math.min(batchIndex * 70, 280);
                                batchIndex++;
                                revealLazyCard(card, stagger);
                            });
                        },
                        { rootMargin: '60px 0px', threshold: 0.05 }
                    );

                    lazyCards.forEach((card) => cardObserver.observe(card));

                    // Keyboard safety net: immediately reveal a card if focus moves inside it
                    document.addEventListener('focusin', (event) => {
                        const target = event.target;
                        if (!(target instanceof Element)) return;
                        const card = target.closest('[data-lazy-card]:not([data-lazy-loaded="true"])');
                        if (card) {
                            cardObserver.unobserve(card);
                            revealLazyCard(card, 0);
                        }
                    });
                } else {
                    lazyCards.forEach((card) => revealLazyCard(card, 0));
                }
            }
        })();
    </script>
</body>

</html>
