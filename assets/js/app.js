// Safe DOM initializer
function initializeApp() {
    // Dynamic component loader
    async function loadComponents() {
        const elements = document.querySelectorAll('[data-include]');
        for (const el of elements) {
            const file = el.getAttribute('data-include');
            if (file) {
                try {
                    const response = await fetch(file);
                    if (response.ok) {
                        el.innerHTML = await response.text();
                        console.log(`Loaded component: ${file}`);

                        // Re-evaluate scripts inside injected HTML
                        const scripts = el.querySelectorAll('script');
                        scripts.forEach(oldScript => {
                            const newScript = document.createElement('script');
                            Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                            newScript.appendChild(document.createTextNode(oldScript.innerHTML));
                            oldScript.parentNode.replaceChild(newScript, oldScript);
                        });
                    } else {
                        console.error(`Failed to load component: ${file}`);
                    }
                } catch (error) {
                    console.error(`Error loading component ${file}:`, error);
                }
            }
        }
        if (window.lucide) {
            window.lucide.createIcons();
        }
        if (window.initLazyLoading) {
            window.initLazyLoading();
        }
    }

    loadComponents();

    // Global Event Delegation for Interactive Elements
    document.addEventListener("click", (e) => {
        // --- Hamburger Menu Triggers ---
        const hamburger = e.target.closest("#hamburger-btn");
        if (hamburger) {
            e.preventDefault();
            toggleMenu(true);
            return;
        }

        const closeMenuBtn = e.target.closest("#close-menu");
        if (closeMenuBtn) {
            e.preventDefault();
            toggleMenu(false);
            return;
        }

        const overlay = e.target.closest("#menu-overlay");
        if (overlay) {
            e.preventDefault();
            toggleMenu(false);
            return;
        }

        // --- Dark Mode Toggle ---
        const darkToggle = e.target.closest("#darkModeToggle");
        if (darkToggle) {
            e.preventDefault();
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            return;
        }

        // --- Search Overlay Triggers ---
        const searchBtn = e.target.closest("#searchButton");
        if (searchBtn) {
            e.preventDefault();
            const searchOverlay = document.getElementById('search-overlay-container');
            const searchInputField = document.getElementById('searchInput');
            const searchBox = document.getElementById('search-card-box');
            if (searchOverlay) {
                searchOverlay.classList.remove('opacity-0', 'pointer-events-none');
                searchOverlay.classList.add('opacity-100', 'pointer-events-auto');
                if (searchBox) {
                    searchBox.classList.remove('-translate-y-4');
                    searchBox.classList.add('translate-y-0');
                }
                if (searchInputField) {
                    setTimeout(() => searchInputField.focus(), 150);
                }
            }
            return;
        }

        const closeSearchBtn = e.target.closest("#closeSearchButton");
        const isBackdropClick = e.target.id === 'search-overlay-container';
        if (closeSearchBtn || isBackdropClick) {
            e.preventDefault();
            const searchOverlay = document.getElementById('search-overlay-container');
            const searchInputField = document.getElementById('searchInput');
            const searchBox = document.getElementById('search-card-box');
            if (searchOverlay) {
                searchOverlay.classList.remove('opacity-100', 'pointer-events-auto');
                searchOverlay.classList.add('opacity-0', 'pointer-events-none');
                if (searchBox) {
                    searchBox.classList.remove('translate-y-0');
                    searchBox.classList.add('-translate-y-4');
                }
                if (searchInputField) {
                    searchInputField.value = '';
                }
            }
            return;
        }

        // --- Smooth Scroll to Top ---
        const toTopBtn = e.target.closest('a[href="#top"]');
        if (toTopBtn) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            return;
        }
    });

    // Helper to toggle off-canvas menu
    function toggleMenu(shouldOpen) {
        const menu = document.getElementById('off-canvas-menu');
        const overlay = document.getElementById('menu-overlay');
        if (!menu || !overlay) return;

        if (shouldOpen) {
            menu.classList.remove('-translate-x-full');
            menu.classList.add('translate-x-0');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
        } else {
            menu.classList.remove('translate-x-0');
            menu.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0', 'pointer-events-none');
        }
    }

    // Expose close menu globally for SPA / PJAX transitions
    window.apkup_close_menu = function () {
        toggleMenu(false);
        const originalOffcanvas = document.getElementById('offcanvas');
        const originalOverlay = document.getElementById('overlay');
        if (originalOffcanvas) originalOffcanvas.classList.remove('open');
        if (originalOverlay) originalOverlay.classList.remove('active');
        document.body.style.overflow = '';
    };

    function handleHeaderScroll() {
        const header = document.querySelector('header');
        if (header) {
            if (window.scrollY > 10) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    }
    window.addEventListener('scroll', handleHeaderScroll);
    setTimeout(handleHeaderScroll, 100);

    // Download Page Timer & MediaFire resolver
    const progressSection = document.getElementById('progress-section');
    if (progressSection) {
        const duration = parseInt(progressSection.getAttribute('data-duration') || '5000', 10);
        const isMediafire = progressSection.getAttribute('data-is-mediafire') === 'true';
        
        const fill = document.getElementById('progress-fill');
        const secondsEl = document.getElementById('seconds-left');
        const buttonGroup = document.getElementById('button-group');

        if (fill && secondsEl && buttonGroup) {
            // Force reflow and set progress transition
            fill.style.width = '0%';
            void fill.offsetWidth;
            fill.style.transition = `width ${duration}ms linear`;
            setTimeout(() => {
                fill.style.width = '100%';
            }, 10);

            let startAt = Date.now();

            function updateTimer() {
                const currentSecondsEl = document.getElementById('seconds-left');
                if (!currentSecondsEl) return; // stops if navigated away

                const now = Date.now();
                const elapsed = now - startAt;
                const msLeft = Math.max(0, duration - elapsed);
                
                currentSecondsEl.textContent = Math.ceil(msLeft / 1000);

                if (elapsed < duration) {
                    requestAnimationFrame(updateTimer);
                } else {
                    setTimeout(() => {
                        const currentProgressSection = document.getElementById('progress-section');
                        const currentButtonGroup = document.getElementById('button-group');
                        if (currentProgressSection && currentButtonGroup) {
                            currentProgressSection.classList.add('hidden');
                            currentButtonGroup.classList.remove('hidden');
                            currentButtonGroup.classList.add('flex');
                        }
                    }, 50);
                }
            }
            requestAnimationFrame(updateTimer);
        }

        // Resolve MediaFire URL
        if (isMediafire && typeof apkup_ajax_vars !== 'undefined') {
            const downloadBtnEl = document.querySelector('.btn-download');
            if (downloadBtnEl) {
                const mfUrl = downloadBtnEl.getAttribute('data-original-url');
                if (mfUrl) {
                    fetch(apkup_ajax_vars.ajax_url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            action: 'apkt_mediafire_direct_link',
                            url: mfUrl
                        })
                    })
                    .then(response => response.json())
                    .then(res => {
                        if (res.success && res.data.direct_url) {
                            downloadBtnEl.setAttribute('href', res.data.direct_url);
                        }
                    })
                    .catch(err => console.error('Error resolving MediaFire URL:', err));
                }
            }
        }
    }

    // Initialize Flickity Sliders with deferred execution to protect FCP/LCP/CLS
    function initFlickitySliders() {
        const init = () => {
            if (typeof Flickity === 'undefined') {
                setTimeout(init, 50);
                return;
            }

            const heroGallery = document.getElementById('heroFlickityGallery');
            if (heroGallery) {
                heroGallery.classList.remove('flex', 'overflow-x-auto', 'no-scrollbar', 'md:overflow-x-hidden');
                new Flickity(heroGallery, {
                    cellAlign: 'left',
                    contain: true,
                    prevNextButtons: false,
                    pageDots: false,
                    dragThreshold: 10,
                    percentPosition: false,
                    freeScroll: true
                });
            }

            const homeCarousels = document.querySelectorAll('.home-posts-carousel');
            homeCarousels.forEach(carousel => {
                carousel.classList.remove('flex', 'overflow-x-auto', 'no-scrollbar', 'md:overflow-x-hidden');
                new Flickity(carousel, {
                    cellAlign: 'left',
                    contain: true,
                    prevNextButtons: false,
                    pageDots: false,
                    dragThreshold: 10,
                    percentPosition: false,
                    freeScroll: true
                });
            });
        };

        if (window.requestIdleCallback) {
            window.requestIdleCallback(() => {
                setTimeout(init, 100);
            });
        } else {
            setTimeout(init, 200);
        }
    }

    initFlickitySliders();

    // AJAX Search suggestions logic
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('ajax-search-results');
    let searchTimeout;

    if (searchInput && searchResults) {
        searchInput.addEventListener('keyup', function () {
            const query = this.value.trim();
            clearTimeout(searchTimeout);

            if (query.length < 2) {
                searchResults.classList.add('hidden');
                searchResults.innerHTML = '';
                return;
            }

            searchTimeout = setTimeout(() => {
                if (typeof apkup_ajax_vars === 'undefined') return;
                fetch(apkup_ajax_vars.ajax_url + '?action=apkup_ajax_search&term=' + encodeURIComponent(query) + '&nonce=' + apkup_ajax_vars.nonce)
                    .then(response => response.json())
                    .then(res => {
                        if (res.success && res.data.length > 0) {
                            let html = '<div class="divide-y divide-gray-100 dark:divide-gray-700">';
                            res.data.forEach(item => {
                                html += `
                                <a href="${item.permalink}" class="flex items-center gap-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0">
                                        <img src="${item.thumbnail}" alt="${item.title}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">${item.title}</h4>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">${item.rating}</span>
                                            </div>
                                            <span class="text-gray-300 dark:text-gray-600">•</span>
                                            <span class="text-[10px] text-gray-500 dark:text-gray-400 font-semibold bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">v${item.version}</span>
                                        </div>
                                    </div>
                                </a>
                                `;
                            });
                            html += '</div>';
                            html += `
                            <a href="${apkup_ajax_vars.home_url}?s=${encodeURIComponent(query)}" class="block text-center p-3 text-sm font-medium text-primary hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border-t border-gray-100 dark:border-gray-700">
                                View all results for "${query}"
                            </a>
                            `;
                            searchResults.innerHTML = html;
                            searchResults.classList.remove('hidden');
                        } else {
                            searchResults.innerHTML = `
                            <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                No apps found for "${query}"
                            </div>
                            `;
                            searchResults.classList.remove('hidden');
                        }
                    })
                    .catch(err => {
                        console.error('Search error:', err);
                    });
            }, 300);
        });
    }

    // Run lazy loading on initial load
    if (window.initLazyLoading) {
        window.initLazyLoading();
    }
}

// Globally accessible lazy loading initializer (IntersectionObserver based)
window.initLazyLoading = function () {
    const lazyImages = document.querySelectorAll('img.lazyload, .lazyload-bg');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;

                    if (el.tagName === 'IMG') {
                        if (el.dataset.src) {
                            el.src = el.dataset.src;
                            el.removeAttribute('data-src');
                        }
                        if (el.dataset.srcset) {
                            el.srcset = el.dataset.srcset;
                            el.removeAttribute('data-srcset');
                        }
                    } else {
                        // Background image loading
                        const bgUrl = el.dataset.bgUrl;
                        if (bgUrl) {
                            el.style.backgroundImage = `url('${bgUrl}')`;
                            el.removeAttribute('data-bg-url');
                        }
                    }

                    el.classList.remove('lazyload');
                    el.classList.remove('lazyload-bg');
                    el.classList.add('lazyloaded');
                    obs.unobserve(el);
                }
            });
        }, {
            rootMargin: '0px 0px 300px 0px' // Load elements 300px before they cross the viewport threshold
        });

        lazyImages.forEach(img => observer.observe(img));
    } else {
        // Direct source loading fallback for older browsers
        lazyImages.forEach(el => {
            if (el.tagName === 'IMG') {
                if (el.dataset.src) el.src = el.dataset.src;
                if (el.dataset.srcset) el.srcset = el.dataset.srcset;
            } else {
                const bgUrl = el.dataset.bgUrl;
                if (bgUrl) el.style.backgroundImage = `url('${bgUrl}')`;
            }
            el.classList.remove('lazyload', 'lazyload-bg');
            el.classList.add('lazyloaded');
        });
    }
};

// Run immediately or on DomContentLoaded
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initializeApp);
} else {
    initializeApp();
}
