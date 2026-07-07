// Global Snackbar/Toast function (accessible globally)
function showToast(message, type = "success") {
    const container = document.getElementById("toast-container");
    if (!container) return;

    let colorClasses = type === "success"
        ? "bg-primary text-white"
        : "bg-red-500 text-white";

    const toast = document.createElement("div");
    toast.className = `px-4 py-2 rounded-lg shadow-lg ${colorClasses} transition transform duration-300 opacity-0 translate-y-2`;
    toast.innerHTML = `
        <div class="flex items-center gap-2">
            ${type === "success"
            ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
            : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>'
        }
            <span>${message}</span>
        </div>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove("opacity-0", "translate-y-2");
        toast.classList.add("opacity-100", "translate-y-0");
    }, 50);

    setTimeout(() => {
        toast.classList.remove("opacity-100", "translate-y-0");
        toast.classList.add("opacity-0", "translate-y-2");
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ----------------------------------------------------
// Page Feature Initializer (swapped during PJAX transitions)
// ----------------------------------------------------
window.apkup_init_page_features = function () {
    // 1. Flickity Carousel
    var carouselElems = document.querySelectorAll('.carousel, .main-carousel, .carousel-mobile');
    if (typeof Flickity !== 'undefined' && carouselElems.length > 0) {
        carouselElems.forEach(function (item) {
            // Prevent double initialization
            if (item.classList.contains('flickity-enabled')) {
                return;
            }
            var options = {
                cellAlign: 'left',
                prevNextButtons: false,
                wrapAround: true,
                pageDots: false
            };

            const dataAttr = item.getAttribute('data-flickity');
            if (dataAttr) {
                try {
                    options = Object.assign({}, options, JSON.parse(dataAttr));
                } catch (e) {
                    console.error('Failed to parse data-flickity', e);
                }
            } else if (item.classList.contains('hero-carousel') || item.classList.contains('recommended-carousel')) {
                options.freeScroll = true;
                options.wrapAround = true;
                options.groupCells = false;
                options.pageDots = false;
                options.imagesLoaded = true;
                options.prevNextButtons = false;
                options.friction = 0.2;
                options.selectedAttraction = 0.01;
                options.dragThreshold = 10;
            } else {
                options.groupCells = true;
            }

            new Flickity(item, options);
        });
    }

    // 2. LightGallery
    const lgContainer = document.getElementById("lightgallery-container");
    if (lgContainer && typeof lightGallery !== 'undefined') {
        lightGallery(lgContainer, {
            selector: "a",
            download: false,
            showCloseIcon: true,
        });
    }

    // 3. Read more/less toggle
    const home_desc = document.getElementById('desc');
    const home_desc_read_btn = document.getElementById('toggleBtn');
    if (home_desc && home_desc_read_btn) {
        home_desc_read_btn.addEventListener('click', () => {
            home_desc.classList.toggle('line-clamp-3');
            home_desc_read_btn.textContent = home_desc.classList.contains('line-clamp-3')
                ? 'READ MORE'
                : 'READ LESS';
        });
    }

    // 4. Tab Container Description/Help
    document.querySelectorAll('.tab-container').forEach(container => {
        const toggleBtn = container.querySelector('.tab-toggle');
        if (!toggleBtn) return;
        const thumb = toggleBtn.querySelector('span.absolute');
        const labels = toggleBtn.querySelectorAll('span.relative');
        const descriptionContent = document.getElementById('descriptionContent');
        const helpContent = document.getElementById('helpContent');

        if (!thumb || labels.length < 2 || !descriptionContent || !helpContent) {
            return;
        }

        let isHelpOpen = false;
        updateState();

        toggleBtn.addEventListener('click', () => {
            isHelpOpen = !isHelpOpen;
            updateState();
        });

        function updateState() {
            thumb.classList.toggle('translate-x-full', isHelpOpen);
            labels[0].classList.toggle('opacity-60', isHelpOpen);
            labels[1].classList.toggle('opacity-60', !isHelpOpen);

            if (isHelpOpen) {
                descriptionContent.classList.add('hidden', 'opacity-0');
                descriptionContent.classList.remove('opacity-100');

                helpContent.classList.remove('hidden');
                setTimeout(() => helpContent.classList.add('opacity-100'), 10);
            } else {
                helpContent.classList.add('hidden', 'opacity-0');
                helpContent.classList.remove('opacity-100');

                descriptionContent.classList.remove('hidden');
                setTimeout(() => descriptionContent.classList.add('opacity-100'), 10);
            }
        }
    });

    // 5. Expand Description Text Block
    const descText = document.getElementById('descriptionText');
    const toggleDescBtn = document.getElementById('toggleDescriptionBtn');
    if (descText && toggleDescBtn) {
        let expanded = false;
        toggleDescBtn.addEventListener('click', function toggle() {
            if (expanded) {
                descText.classList.add('max-h-32', 'overflow-hidden');
                toggleDescBtn.textContent = 'READ MORE';
                toggleDescBtn.setAttribute('aria-expanded', 'false');
            } else {
                descText.classList.remove('max-h-32', 'overflow-hidden');
                toggleDescBtn.textContent = 'READ LESS';
                toggleDescBtn.setAttribute('aria-expanded', 'true');
            }
            expanded = !expanded;
        });
    }

    // 6. Download links / mod info toggle
    document.querySelectorAll('.dl-tab-container').forEach(container => {
        const dlToggleBtn = container.querySelector('.dl-tab-toggle');
        if (!dlToggleBtn) return;
        const dlThumb = dlToggleBtn.querySelector('span.absolute');
        const dlTabLabels = dlToggleBtn.querySelectorAll('span.relative');
        const dlLinks = document.getElementById('dl-links');
        const dlModInfo = document.getElementById('dl-mod-info');

        if (!dlThumb || dlTabLabels.length < 2 || !dlLinks || !dlModInfo) {
            return;
        }

        let isModInfoOpen = false;
        updateState();

        dlToggleBtn.addEventListener('click', () => {
            isModInfoOpen = !isModInfoOpen;
            updateState();
        });

        function updateState() {
            dlThumb.classList.toggle('translate-x-full', isModInfoOpen);
            dlTabLabels[0].classList.toggle('opacity-60', isModInfoOpen);
            dlTabLabels[1].classList.toggle('opacity-60', !isModInfoOpen);

            const dlSection = container.closest('.dl-section');
            if (dlSection) {
                if (isModInfoOpen) {
                    dlSection.classList.remove('bg-primary/10');
                    dlSection.classList.add('bg-yellow-400/10');
                } else {
                    dlSection.classList.remove('bg-yellow-400/10');
                    dlSection.classList.add('bg-primary/10');
                }
            }

            if (isModInfoOpen) {
                dlLinks.classList.add('hidden', 'opacity-0');
                dlLinks.classList.remove('opacity-100');
                dlModInfo.classList.remove('hidden');
                setTimeout(() => dlModInfo.classList.add('opacity-100'), 10);
            } else {
                dlModInfo.classList.add('hidden', 'opacity-0');
                dlModInfo.classList.remove('opacity-100');
                dlLinks.classList.remove('hidden');
                setTimeout(() => dlLinks.classList.add('opacity-100'), 10);
            }
        }
    });

    // 7. Lazy Load with IntersectionObserver
    var lazyImages = [].slice.call(document.querySelectorAll("img.lazyload"));
    if ("IntersectionObserver" in window) {
        let lazyImageObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;
                    if (lazyImage.dataset.src) {
                        lazyImage.src = lazyImage.dataset.src;
                    }
                    lazyImage.classList.add("loaded");
                    lazyImageObserver.unobserve(lazyImage);
                }
            });
        });
        lazyImages.forEach(function (lazyImage) {
            lazyImageObserver.observe(lazyImage);
        });
    } else {
        lazyImages.forEach(function (lazyImage) {
            if (lazyImage.dataset.src) {
                lazyImage.src = lazyImage.dataset.src;
            }
            lazyImage.classList.add('loaded');
        });
    }

    // 8. Share Modal (if details page)
    const shareBtn = document.getElementById('post-share');
    const shareModal = document.getElementById('share-modal');
    const closeShareBtn = document.getElementById('close-share-modal');
    const shareOverlay = document.getElementById('share-overlay');
    const copyLinkBtn = document.getElementById('copy-link-btn');

    if (shareBtn && shareModal) {
        shareBtn.addEventListener('click', (e) => {
            e.preventDefault();
            shareModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        function closeShareModal() {
            shareModal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        if (closeShareBtn) {
            closeShareBtn.addEventListener('click', closeShareModal);
        }
        if (shareOverlay) {
            shareOverlay.addEventListener('click', closeShareModal);
        }

        if (copyLinkBtn) {
            copyLinkBtn.addEventListener('click', async () => {
                const url = copyLinkBtn.getAttribute('data-url');
                try {
                    await navigator.clipboard.writeText(url);
                    showToast('Link copied to clipboard!', 'success');
                } catch (err) {
                    console.error('Failed to copy: ', err);
                    showToast('Failed to copy link', 'error');
                }
            });
        }
    }

    // 9. RateYo Init (post ratings)
    if (window.jQuery && jQuery("#rateYo").length) {
        let $ = jQuery;
        function getCookie(name) {
            const match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
            return match ? match[2] : null;
        }
        function hasVoted(post_id) {
            return getCookie("apkup_rated_" + post_id) === "1";
        }
        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                const d = new Date();
                d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
                expires = "; expires=" + d.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        let dynamicColor = getComputedStyle(document.documentElement).getPropertyValue('--app-primary').trim() || '#27b427';
        $("#rateYo").rateYo({
            starWidth: '20px',
            fullStar: true,
            normalFill: "#dce1e5",
            ratedFill: dynamicColor,
            spacing: "8px",
            starSvg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z"/></svg>',
            onSet: function (rating, rateYoInstance) {
                var $this = $(this);
                var post_id = $this.data('post_id');
                var cookieKey = "apkup_rated_" + post_id;

                if (hasVoted(post_id)) {
                    showToast("You already rated this post!", "error");
                    return;
                }

                if (!rating || rating < 1 || rating > 5 || isNaN(post_id)) {
                    showToast("Invalid rating.", "error");
                    return;
                }

                $.ajax({
                    url: apkup_ajax_vars.ajax_url,
                    type: "POST",
                    data: {
                        action: "apkup_rate_post",
                        rating: rating,
                        post_id: post_id,
                        nonce: apkup_ajax_vars.nonce,
                    },
                    success: function (res) {
                        if (res.success) {
                            $("#currentRating").text(res.data.new_average);
                            $("#totalVotes").text(res.data.new_votes);

                            $(".jq-ry-rated-group").css("width", res.data.new_average / 5 * 100 + "%");
                            $("#rateYo").rateYo("option", "readOnly", true);

                            setCookie(cookieKey, "1", 365);

                            showToast("Thanks for your rating!", "success");
                        } else {
                            showToast(res.data.message || "Something went wrong", "error");
                        }
                    },
                    error: function () {
                        console.log("AJAX error");
                        showToast("Network error. Please try again.", "error");
                    }
                });
            }
        });
    }

    // 10. Download Page Timer moved to app.js
};

// ----------------------------------------------------
// Global DOMContentLoaded (Only binds once per tab load)
// ----------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
    // Call features initialization for initial load
    window.apkup_init_page_features();

    // 1. Mobile Navigation scroll hide/show
    const mobileNav = document.getElementById('mobileNav');
    const navHandle = document.getElementById('navHandle');
    const openMenuBtn = document.getElementById('openMenu');
    const closeMenuBtn = document.getElementById('closeMenu');
    const offcanvas = document.getElementById('offcanvas');
    const overlay = document.getElementById('overlay');

    let lastScrollY = window.scrollY;
    let isManuallyExpanded = false;

    function handleScroll() {
        if (!mobileNav) return;
        if (window.scrollY > lastScrollY && window.scrollY > 100 && !isManuallyExpanded) {
            mobileNav.classList.add('collapsed');
        } else if (window.scrollY < lastScrollY && window.scrollY > 50) {
            mobileNav.classList.remove('collapsed');
            isManuallyExpanded = false;
        }
        lastScrollY = window.scrollY;
    }

    let ticking = false;
    window.addEventListener('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(function () {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    });

    if (navHandle && mobileNav) {
        navHandle.addEventListener('click', function () {
            mobileNav.classList.toggle('collapsed');
            isManuallyExpanded = !mobileNav.classList.contains('collapsed');
        });
    }

    // --- Open offcanvas menu ---
    if (openMenuBtn && offcanvas) {
        openMenuBtn.addEventListener('click', function () {
            offcanvas.classList.add('open');
            if (overlay) overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            openMenuBtn.classList.add('active');
        });
    }

    // --- Close offcanvas menu ---
    window.apkup_close_menu = function () {
        if (offcanvas) offcanvas.classList.remove('open');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
        if (openMenuBtn) openMenuBtn.classList.remove('active');
    };

    if (closeMenuBtn) {
        closeMenuBtn.addEventListener('click', window.apkup_close_menu);
    }
    if (overlay) {
        overlay.addEventListener('click', window.apkup_close_menu);
    }

    // Close modal when clicking outside
    const searchModal = document.getElementById('search-modal');
    if (searchModal) {
        searchModal.addEventListener('click', (e) => {
            if (e.target === searchModal) {
                searchModal.classList.add('hidden');
            }
        });
    }

    // 2. AJAX Search Logic
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
                fetch(apkup_ajax_vars.ajax_url + '?action=apkup_ajax_search&term=' + query + '&nonce=' + apkup_ajax_vars.nonce)
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
                            <a href="/?s=${query}" class="block text-center p-3 text-sm font-medium text-primary hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border-t border-gray-100 dark:border-gray-700">
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

        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    }

    // 3. jQuery Delegated Listeners (Likes)
    if (window.jQuery) {
        let $ = window.jQuery;
        function getLikedComments() {
            let liked = localStorage.getItem("apkup_liked_comments");
            return liked ? JSON.parse(liked) : [];
        }

        function saveLikedComment(commentId) {
            let liked = getLikedComments();
            if (!liked.includes(commentId)) {
                liked.push(commentId);
                localStorage.setItem("apkup_liked_comments", JSON.stringify(liked));
                document.cookie = "apkup_liked_comments=" + JSON.stringify(liked) + "; path=/";
            }
        }

        $(document).on("click", ".like-btn", function (e) {
            e.preventDefault();
            let $btn = $(this);
            let commentId = $btn.data("comment-id");

            if (getLikedComments().includes(commentId)) {
                showToast("You already liked this comment!", "error");
                return;
            }

            $.ajax({
                url: apkup_ajax_vars.ajax_url,
                type: "POST",
                data: {
                    action: "apkup_like_comment",
                    comment_id: commentId,
                    nonce: apkup_ajax_vars.nonce,
                },
                success: function (res) {
                    if (res.success) {
                        let newCount = res.data.likes;
                        $btn.find(".like-count").text(newCount);
                        saveLikedComment(commentId);
                        showToast("Thanks for liking this comment!", "success");
                    } else {
                        showToast(res.data.message || "Something went wrong", "error");
                    }
                },
            });
        });
    }

    // ----------------------------------------------------
    // SPA PJAX Navigation Engine
    // ----------------------------------------------------
    window.pageCache = {};
    const pjaxEnabled = typeof apkup_ajax_vars !== 'undefined' && apkup_ajax_vars.site_pjax_swt === '1';

    // Top progress loading bar
    const progressBar = {
        el: null,
        timer: null,
        create() {
            if (this.el) return;
            this.el = document.createElement('div');
            this.el.style.position = 'fixed';
            this.el.style.top = '0';
            this.el.style.left = '0';
            this.el.style.height = '3px';
            this.el.style.backgroundColor = '#10B981'; // beautiful green (emerald-500)
            this.el.style.zIndex = '99999';
            this.el.style.transition = 'width 0.2s ease, opacity 0.4s ease';
            this.el.style.width = '0%';
            this.el.style.opacity = '1';
            document.body.appendChild(this.el);
        },
        start() {
            this.create();
            this.el.style.opacity = '1';
            this.el.style.width = '0%';
            clearInterval(this.timer);
            let width = 0;
            this.timer = setInterval(() => {
                if (width < 90) {
                    width += Math.random() * 15;
                    this.el.style.width = width + '%';
                }
            }, 100);
        },
        finish() {
            if (!this.el) return;
            clearInterval(this.timer);
            this.el.style.width = '100%';
            setTimeout(() => {
                this.el.style.opacity = '0';
                setTimeout(() => {
                    this.el.style.width = '0%';
                }, 400);
            }, 200);
        }
    };

    function isInternalLink(anchor) {
        if (!anchor || !anchor.href) return false;
        const href = anchor.getAttribute('href');
        // Ignore hashes, JavaScript actions, mail, phone links, and wp-admin links
        if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) {
            return false;
        }
        if (href.indexOf('/wp-admin') !== -1 || anchor.getAttribute('target') === '_blank') {
            return false;
        }
        // Check if same domain
        const homeUrl = apkup_ajax_vars.home_url;
        try {
            const urlObj = new URL(anchor.href);
            const homeObj = new URL(homeUrl);
            return urlObj.hostname === homeObj.hostname;
        } catch (e) {
            return false;
        }
    }

    function swapContent(html, url, pushState) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        // Swap Document Title
        if (doc.title) {
            document.title = doc.title;
        }

        // Swap body classes (important for styling)
        document.body.className = doc.body.className;

        // Handle banner update/removal
        const currentBanner = document.querySelector('.download-banner');
        const newBanner = doc.querySelector('.download-banner');

        if (currentBanner) {
            currentBanner.remove();
        }
        if (newBanner) {
            const mainEl = document.querySelector('main');
            if (mainEl) {
                mainEl.parentNode.insertBefore(newBanner, mainEl);
            }
        }

        // Swap <main> container
        const currentMain = document.querySelector('main');
        const newMain = doc.querySelector('main');

        if (currentMain && newMain) {
            currentMain.innerHTML = newMain.innerHTML;
            currentMain.className = newMain.className;
        }

        // Close menu & modal
        window.apkup_close_menu();
        if (searchModal) {
            searchModal.classList.add('hidden');
        }

        // Scroll to hash element if present, else to top
        try {
            const targetUrl = new URL(url);
            if (targetUrl.hash) {
                const targetId = targetUrl.hash.substring(1);
                const element = document.getElementById(targetId);
                if (element) {
                    element.scrollIntoView({ behavior: 'instant' });
                } else {
                    window.scrollTo({ top: 0, behavior: 'instant' });
                }
            } else {
                window.scrollTo({ top: 0, behavior: 'instant' });
            }
        } catch (e) {
            window.scrollTo({ top: 0, behavior: 'instant' });
        }

        // Update history
        if (pushState) {
            history.pushState({ url: url }, doc.title || '', url);
        }

        // Initialize features for the new content
        window.apkup_init_page_features();
    }

    function loadPage(url, pushState = true) {
        if (window.pageCache[url]) {
            swapContent(window.pageCache[url], url, pushState);
            return;
        }

        progressBar.start();
        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Response error');
                return response.text();
            })
            .then(html => {
                window.pageCache[url] = html;
                swapContent(html, url, pushState);
                progressBar.finish();
            })
            .catch(err => {
                console.error('PJAX navigation error:', err);
                progressBar.finish();
                window.location.href = url; // Fallback to normal navigation
            });
    }

    function preloadPage(url) {
        if (window.pageCache[url]) return;
        fetch(url)
            .then(response => {
                if (response.ok) return response.text();
            })
            .then(html => {
                if (html) {
                    window.pageCache[url] = html;
                }
            })
            .catch(() => {});
    }

    if (pjaxEnabled) {
        // Intercept clicks on internal links
        document.addEventListener('click', function (e) {
            const anchor = e.target.closest('a');
            if (anchor && isInternalLink(anchor)) {
                try {
                    const targetUrl = new URL(anchor.href);
                    const currentUrl = new URL(window.location.href);

                    // Normalize trailing slashes
                    const targetPath = targetUrl.pathname.replace(/\/$/, "");
                    const currentPath = currentUrl.pathname.replace(/\/$/, "");

                    // Case 1: Same page, just a hash link
                    if (targetPath === currentPath && targetUrl.search === currentUrl.search) {
                        if (targetUrl.hash) {
                            e.preventDefault();
                            const targetId = targetUrl.hash.substring(1);
                            const element = document.getElementById(targetId);
                            if (element) {
                                element.scrollIntoView({ behavior: 'smooth' });
                            }
                            // Update the URL hash in the browser address bar without a reload
                            history.replaceState(null, null, anchor.href);
                        }
                        return;
                    }
                } catch (err) {
                    console.error('URL parsing error:', err);
                }

                e.preventDefault();
                loadPage(anchor.href, true);
            }
        });

        // Preload links on hover/mouseover
        document.addEventListener('mouseover', function (e) {
            const anchor = e.target.closest('a');
            if (anchor && isInternalLink(anchor)) {
                preloadPage(anchor.href);
            }
        });

        // Handle browser history back/forward buttons
        window.addEventListener('popstate', function (e) {
            const url = location.href;
            loadPage(url, false);
        });
    }
});
