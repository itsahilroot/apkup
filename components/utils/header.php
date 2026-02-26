<?php
$menu_locations = get_nav_menu_locations();
$header_menus = !empty($menu_locations['header_menu']) ? wp_get_nav_menu_items($menu_locations['header_menu']) : [];
$au_header_logo = get_theme_mod('au_header_logo', get_template_directory_uri() . '/assets/img/logo.png');
$au_header_logo_dark = get_theme_mod('au_header_logo_dark', get_template_directory_uri() . '/assets/img/logo.png');
$au_home_hero_top_description = get_theme_mod('au_home_hero_top_description', 'GAMES & APPS FOR ANDROID - A LARGE SELECTION OF APPS FOR ANDROID DEVICES FREE AND WITH NO VIRUSES');
$au_ajax_search_swt = get_theme_mod('au_ajax_search_swt', false);
?>
<header class="sticky top-0 z-40 bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
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
                <nav class="hidden md:flex space-x-8">
                    <?php foreach ($header_menus as $menu) : ?>
                        <a href="<?php echo esc_url($menu->url); ?>" class="text-gray-700 dark:text-gray-200 dark:hover:text-primary/40 hover:text-primary px-3 py-2 text-lg font-medium">
                            <?php echo esc_html($menu->title); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
            <div class="flex items-center space-x-4">
                <button type="button" id="searchButton" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors cursor-pointer" aria-label="Open search">
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <button type="button" id="darkModeToggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer" aria-label="Toggle dark mode">
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>
<div id="searchModal" class="fixed inset-0 bg-black/50 z-50 hidden">
    <div class="flex items-start justify-center min-h-screen pt-20">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-2xl mx-4">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">búsqueda de Apps</h3>
                    <button type="button" id="closeSearchModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-pointer">
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
                        class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary dark:text-gray-300 text-lg">
                    <button type="submit" class="absolute right-3 top-3.5 text-gray-400 hover:text-primary focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="sr-only"><?php esc_html_e('Search', 'apktemplates'); ?></span>
                    </button>
                    
                    <?php if ($au_ajax_search_swt) : ?>
                        <div id="ajax-search-results" class="absolute left-0 right-0 top-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden z-20 hidden border border-gray-100 dark:border-gray-700 max-h-[60vh] overflow-y-auto"></div>
                    <?php endif; ?>
                </form>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-300">
                   Ejemplo: PUBG Mobile, Instagram, WhatsApp, TikTok
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Dark mode toggle functionality
    const darkModeToggle = document.getElementById('darkModeToggle');
    const html = document.documentElement;

    darkModeToggle.addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem('darkMode', html.classList.contains('dark'));
    });

    // Check for saved dark mode preference
    if (localStorage.getItem('darkMode') === 'true') {
        html.classList.add('dark');
    }

    // Search modal functionality
    const searchButton = document.getElementById('searchButton');
    const searchModal = document.getElementById('searchModal');
    const closeSearchModal = document.getElementById('closeSearchModal');

    searchButton.addEventListener('click', () => {
        searchModal.classList.remove('hidden');
        document.getElementById('searchInput').focus();
    });

    closeSearchModal.addEventListener('click', () => {
        searchModal.classList.add('hidden');
    });

    // Close modal when clicking outside
    searchModal.addEventListener('click', (e) => {
        if (e.target === searchModal) {
            searchModal.classList.add('hidden');
        }
    });
</script>
<?php if (is_home() && !empty($au_home_hero_top_description)) : ?>
    <div class="bg-primary text-white py-2 px-4 text-center text-sm">
        <?php echo $au_home_hero_top_description; ?>
    </div>
<?php endif; ?>