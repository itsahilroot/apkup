<?php
$menu_locations = get_nav_menu_locations();
$header_menus = !empty($menu_locations['header_menu']) ? wp_get_nav_menu_items($menu_locations['header_menu']) : [];
$au_header_logo = get_theme_mod('au_header_logo', get_template_directory_uri() . '/assets/img/logo.png');
$au_header_logo_dark = get_theme_mod('au_header_logo_dark', get_template_directory_uri() . '/assets/img/logo.png');
$au_home_hero_top_description = get_theme_mod('au_home_hero_top_description', 'GAMES & APPS FOR ANDROID - A LARGE SELECTION OF APPS FOR ANDROID DEVICES FREE AND WITH NO VIRUSES');
$au_ajax_search_swt = get_theme_mod('au_ajax_search_swt', false);
?>
<header class="sticky top-0 z-40 bg-white/70 dark:bg-[rgba(15,15,26,0.65)] backdrop-blur-[30px] backdrop-saturate-200 shadow-sm border-b border-gray-200/50 dark:border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="<?php echo get_site_url(); ?>" class="flex items-center">
                <img src="<?php echo esc_url($au_header_logo); ?>"
                    alt="<?php echo esc_attr(get_bloginfo('name')); ?> Logo"
                    class="h-8 w-auto block dark:hidden">
                <img src="<?php echo esc_url($au_header_logo_dark); ?>"
                    alt="<?php echo esc_attr(get_bloginfo('name')); ?> Dark Logo"
                    class="h-8 w-auto hidden dark:block">
            </a>
            <?php if (!empty($header_menus)) : ?>
                <nav class="hidden md:flex space-x-3 lg:space-x-4">
                    <?php foreach ($header_menus as $menu) : 
                        $icon_type = get_post_meta($menu->ID, 'apkup_menu_icon_class', true);
                        $icon_class = $icon_type ? esc_attr($icon_type) : 'fas fa-star';
                    ?>
                        <a href="<?php echo esc_url($menu->url); ?>" class="flex items-center gap-3 pr-4 pl-1.5 py-1.5 bg-transparent hover:bg-white dark:hover:bg-gray-700 rounded-full text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary hover:shadow-[0_8px_20px_rgba(0,0,0,0.06)] hover:-translate-y-0.5 transition-all duration-300 font-bold text-sm tracking-wide group">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 group-hover:bg-primary/10 dark:group-hover:bg-primary/20 transition-colors duration-300 shadow-sm">
                                <i class="<?php echo $icon_class; ?> text-gray-500 dark:text-gray-400 group-hover:text-primary transition-colors duration-300 text-xs"></i>
                            </span>
                            <?php echo esc_html($menu->title); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
            <div class="flex items-center space-x-3">
                <button type="button" id="searchButton" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100/60 hover:bg-primary/10 dark:bg-gray-700/60 dark:hover:bg-primary/20 text-gray-700 hover:text-primary dark:text-gray-300 dark:hover:text-primary transition-all duration-300 backdrop-blur-md shadow-sm border border-gray-200/50 dark:border-gray-600/50 focus:outline-none hover:cursor-pointer" aria-label="Open search">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <button type="button" id="darkModeToggle" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100/60 hover:bg-primary/10 dark:bg-gray-700/60 dark:hover:bg-primary/20 text-gray-700 hover:text-primary dark:text-gray-300 dark:hover:text-primary transition-all duration-300 backdrop-blur-md shadow-sm border border-gray-200/50 dark:border-gray-600/50 relative overflow-hidden focus:outline-none hover:cursor-pointer" aria-label="Toggle dark mode">
                    <svg id="moonIcon" class="h-5 w-5 absolute transition-all duration-300 transform scale-100 rotate-0 opacity-100" fill="currentColor" stroke="none" viewBox="0 0 24 24">
                        <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg id="sunIcon" class="h-6 w-6 absolute transition-all duration-300 transform scale-0 rotate-90 opacity-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Search Shutter -->
    <div id="searchModal" class="absolute left-0 w-full top-full bg-white/80 dark:bg-[rgba(15,15,26,0.85)] backdrop-blur-[30px] backdrop-saturate-200 border-b border-gray-200/50 dark:border-white/10 shadow-xl search-shutter -z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">búsqueda de Apps</h3>
                <button type="button" id="closeSearchModal" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 cursor-pointer transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form class="relative" method="GET" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search"
                    name="s"
                    id="searchInput"
                    placeholder="Search for apps, games, and more..."
                    minlength="3"
                    required
                    class="w-full px-4 py-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary dark:text-gray-300 text-lg shadow-inner">
                <button type="submit" class="absolute right-3 top-3.5 p-1 text-gray-400 hover:text-primary focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="sr-only"><?php esc_html_e('Search', 'apktemplates'); ?></span>
                </button>
                
                <?php if ($au_ajax_search_swt) : ?>
                    <div id="ajax-search-results" class="absolute left-0 right-0 top-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden z-20 hidden border border-gray-100 dark:border-gray-700 max-h-[60vh] overflow-y-auto w-full"></div>
                <?php endif; ?>
            </form>
            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
               Ejemplo: PUBG Mobile, Instagram, WhatsApp, TikTok
            </div>
        </div>
    </div>
    
    <!-- Full-screen Theme Transition Overlay -->
    <div id="themeTransitionOverlay" class="fixed inset-0 z-[100] flex items-center justify-center pointer-events-none opacity-0 transition-opacity duration-300 hidden backdrop-blur-2xl bg-white/60 dark:bg-black/60">
        <svg id="centerMoonIcon" class="w-48 h-48 text-gray-800 dark:text-white hidden transform scale-0 transition-transform duration-500 ease-out drop-shadow-2xl" fill="currentColor" stroke="none" viewBox="0 0 24 24">
            <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
        <svg id="centerSunIcon" class="w-48 h-48 text-yellow-400 hidden transform scale-0 transition-transform duration-500 ease-out drop-shadow-[0_0_40px_rgba(250,204,21,0.6)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
    </div>
</header>
<script>
    // Dark mode toggle functionality
    const darkModeToggle = document.getElementById('darkModeToggle');
    const moonIcon = document.getElementById('moonIcon');
    const sunIcon = document.getElementById('sunIcon');
    const html = document.documentElement;

    function updateIcons() {
        if (html.classList.contains('dark')) {
            moonIcon.classList.add('scale-0', '-rotate-90', 'opacity-0');
            moonIcon.classList.remove('scale-100', 'rotate-0', 'opacity-100');
            sunIcon.classList.remove('scale-0', 'rotate-90', 'opacity-0');
            sunIcon.classList.add('scale-100', 'rotate-0', 'opacity-100');
        } else {
            sunIcon.classList.add('scale-0', 'rotate-90', 'opacity-0');
            sunIcon.classList.remove('scale-100', 'rotate-0', 'opacity-100');
            moonIcon.classList.remove('scale-0', '-rotate-90', 'opacity-0');
            moonIcon.classList.add('scale-100', 'rotate-0', 'opacity-100');
        }
    }

    // Check for saved dark mode preference natively
    if (localStorage.getItem('darkMode') === 'true') {
        html.classList.add('dark');
        updateIcons(); // Force sun icon visibility on initial load if dark mode
    }

    darkModeToggle.addEventListener('click', (e) => {
        const isDark = html.classList.contains('dark');
        const overlay = document.getElementById('themeTransitionOverlay');
        const cMoon = document.getElementById('centerMoonIcon');
        const cSun = document.getElementById('centerSunIcon');
        
        // We are going to Light mode if we are currently Dark mode, so show Sun. Otherwise show Moon.
        const iconToShow = isDark ? cSun : cMoon;
        
        // Prepare overlay
        overlay.classList.remove('hidden');
        cMoon.classList.add('hidden');
        cSun.classList.add('hidden');
        cMoon.classList.remove('scale-100');
        cSun.classList.remove('scale-100');
        
        iconToShow.classList.remove('hidden');
        
        // Fade in overlay and scale up the center icon
        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            overlay.classList.add('opacity-100');
            iconToShow.classList.remove('scale-0');
            iconToShow.classList.add('scale-100');
        }, 10);
        
        const toggleTheme = () => {
            html.classList.toggle('dark');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
            updateIcons();
        };

        // Wait for the icon to pop up, then trigger the ripple!
        setTimeout(() => {
            if (!document.startViewTransition) {
                toggleTheme();
                setTimeout(() => {
                    overlay.classList.remove('opacity-100');
                    overlay.classList.add('opacity-0');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                }, 300);
                return;
            }

            // Expanding circle from the very center
            const x = innerWidth / 2;
            const y = innerHeight / 2;
            const endRadius = Math.hypot(x, y);

            const transition = document.startViewTransition(toggleTheme);

            transition.ready.then(() => {
                const anim = document.documentElement.animate(
                    {
                        clipPath: [
                            `circle(0px at ${x}px ${y}px)`,
                            `circle(${endRadius}px at ${x}px ${y}px)`
                        ]
                    },
                    {
                        duration: 600,
                        easing: 'ease-in-out',
                        pseudoElement: '::view-transition-new(root)'
                    }
                );
                
                anim.onfinish = () => {
                    iconToShow.classList.remove('scale-100');
                    iconToShow.classList.add('scale-0');
                    overlay.classList.remove('opacity-100');
                    overlay.classList.add('opacity-0');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                };
            });
        }, 400); // 400ms delay gives the giant sun/moon time to playfully jump into the screen before wiping!
    });

    // Search modal functionality
    const searchButton = document.getElementById('searchButton');
    const searchModal = document.getElementById('searchModal');
    const closeSearchModal = document.getElementById('closeSearchModal');

    searchButton.addEventListener('click', (e) => {
        e.stopPropagation();
        searchModal.classList.toggle('open');
        if (searchModal.classList.contains('open')) {
            setTimeout(() => document.getElementById('searchInput').focus(), 150);
        }
    });

    closeSearchModal.addEventListener('click', () => {
        searchModal.classList.remove('open');
    });

    // Close modal when clicking outside
    document.addEventListener('click', (e) => {
        if (searchModal.classList.contains('open') && !searchModal.contains(e.target) && !searchButton.contains(e.target)) {
            searchModal.classList.remove('open');
        }
    });
</script>
<?php if (is_home() && !empty($au_home_hero_top_description)) : ?>
    <div class="bg-primary text-white py-2 px-4 text-center text-sm">
        <?php echo $au_home_hero_top_description; ?>
    </div>
<?php endif; ?>