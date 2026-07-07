<?php
$current_path = $_SERVER['REQUEST_URI'];

$logo_fallback_light = 'https://apkgstore.co/wp-content/uploads/2026/03/apkgstore2.0-azul_Mesa-de-trabajo-1-scaled.png';
$logo_fallback_dark = 'https://apkgstore.co/wp-content/uploads/2026/03/apkgstore2.0-scaled.png';

$logo_light = get_theme_mod('au_header_logo');
$logo_dark = get_theme_mod('au_header_logo_dark');

if (empty($logo_light)) {
    $logo_light = $logo_fallback_light;
}
if (empty($logo_dark)) {
    $logo_dark = $logo_fallback_dark;
}

$menu_locations = get_nav_menu_locations();
$header_menus = !empty($menu_locations['header_menu']) ? wp_get_nav_menu_items($menu_locations['header_menu']) : [];

if (empty($header_menus)) {
    $header_menus = [
        (object)[ 'title' => 'Inicio', 'url' => home_url('/'), 'ID' => 0 ],
        (object)[ 'title' => 'Juegos', 'url' => home_url('/games/'), 'ID' => 0 ],
        (object)[ 'title' => 'Apps', 'url' => home_url('/apps/'), 'ID' => 0 ],
        (object)[ 'title' => 'Blog', 'url' => home_url('/blog/'), 'ID' => 0 ],
    ];
}

$au_home_hero_top_description = get_theme_mod('au_home_hero_top_description', 'GAMES & APPS FOR ANDROID - A LARGE SELECTION OF APPS FOR ANDROID DEVICES FREE AND WITH NO VIRUSES');
$au_ajax_search_swt = get_theme_mod('au_ajax_search_swt', false);
?>
<header class="sticky top-0 z-50 glass-header shadow-sm transition-all duration-300">
    <!-- Main Header Container -->
    <div id="header-main-container" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300">
        <div class="flex items-center justify-between h-16">
            <!-- Logotipo Oficial APKGSTORE -->
            <div class="flex items-center gap-3">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
                    <img src="<?php echo esc_url($logo_light); ?>"
                        alt="<?php echo esc_attr(get_bloginfo('name')); ?> Logo" class="h-7 w-auto block dark:hidden">
                    <img src="<?php echo esc_url($logo_dark); ?>"
                        alt="<?php echo esc_attr(get_bloginfo('name')); ?> Dark Logo" class="h-7 w-auto hidden dark:block">
                </a>
            </div>

            <!-- Enlaces de Navegación Refinados (Grosores delgados) -->
            <?php if (!empty($header_menus)) : ?>
                <nav class="hidden md:flex space-x-6 text-sm font-medium">
                    <?php foreach ($header_menus as $menu) : 
                        $menu_path = parse_url($menu->url, PHP_URL_PATH);
                        $is_active = false;
                        if ($menu_path) {
                            if ($menu_path === '/' || $menu_path === '') {
                                $is_active = (is_front_page() || is_home());
                            } else {
                                $is_active = (strpos($current_path, $menu_path) === 0);
                            }
                        }
                        $icon_type = get_post_meta($menu->ID, 'apkup_menu_icon_class', true);
                        if (!$icon_type) {
                            $title_lower = strtolower($menu->title);
                            if (strpos($title_lower, 'inicio') !== false || strpos($title_lower, 'home') !== false) {
                                $icon_class = 'home';
                            } elseif (strpos($title_lower, 'juego') !== false || strpos($title_lower, 'game') !== false) {
                                $icon_class = 'gamepad-2';
                            } elseif (strpos($title_lower, 'app') !== false || strpos($title_lower, 'lay') !== false) {
                                $icon_class = 'layers';
                            } elseif (strpos($title_lower, 'blog') !== false || strpos($title_lower, 'news') !== false) {
                                $icon_class = 'newspaper';
                            } else {
                                $icon_class = 'star';
                            }
                        } else {
                            $icon_class = esc_attr($icon_type);
                        }
                        $is_fa = (strpos($icon_class, 'fa-') !== false || strpos($icon_class, 'fas') !== false || strpos($icon_class, 'fa-solid') !== false);
                    ?>
                        <a href="<?php echo esc_url($menu->url); ?>"
                            class="<?php echo $is_active ? 'flex items-center gap-2 px-4 py-1.5 rounded-full text-primary bg-primary/10 transition-all' : 'flex items-center gap-2 px-3 py-1.5 text-slate-600 dark:text-slate-300 hover:text-primary transition-all'; ?>">
                            <?php if ($is_fa) : ?>
                                <i class="<?php echo $icon_class; ?> w-4 h-4"></i>
                            <?php else : ?>
                                <i data-lucide="<?php echo $icon_class; ?>" class="w-4 h-4"></i>
                            <?php endif; ?>
                            <?php echo esc_html($menu->title); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>

            <!-- Herramientas Rápidas -->
            <div class="flex items-center gap-3">
                <!-- Search Button -->
                <button id="searchButton"
                    class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 hover:bg-primary/10 dark:bg-slate-800 dark:hover:bg-primary/20 text-slate-600 dark:text-slate-300 hover:text-primary transition-all cursor-pointer"
                    aria-label="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </button>

                <!-- Dark Mode Toggle Button -->
                <button id="darkModeToggle"
                    class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 hover:bg-primary/10 dark:bg-slate-800 dark:hover:bg-primary/20 text-slate-600 dark:text-slate-300 hover:text-primary transition-all cursor-pointer"
                    aria-label="Cambiar tema">
                    <svg id="themeIconSun" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-sun block dark:hidden">
                        <circle cx="12" cy="12" r="4" />
                        <path d="M12 2v2" />
                        <path d="M12 20v2" />
                        <path d="m4.93 4.93 1.41 1.41" />
                        <path d="m17.66 17.66 1.41 1.41" />
                        <path d="M2 12h2" />
                        <path d="M20 12h2" />
                        <path d="m6.34 17.66-1.41 1.41" />
                        <path d="m19.07 4.93-1.41 1.41" />
                    </svg>
                    <svg id="themeIconMoon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-moon hidden dark:block">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
                    </svg>
                </button>

                <!-- Mobile Hamburger Button -->
                <button id="hamburger-btn"
                    class="flex md:hidden w-9 h-9 items-center justify-center rounded-full bg-slate-100 hover:bg-primary/10 dark:bg-slate-800 dark:hover:bg-primary/20 text-slate-600 dark:text-slate-300 hover:text-primary transition-all cursor-pointer"
                    aria-label="Menú">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-menu">
                        <line x1="4" x2="20" y1="12" y2="12" />
                        <line x1="4" x2="20" y1="6" y2="6" />
                        <line x1="4" x2="20" y1="18" y2="18" />
                    </svg>
                </button>
        </div>
    </div>
    <!-- Search Overlay Container -->
    <div id="search-overlay-container"
        class="fixed inset-0 bg-slate-950/70 backdrop-blur-md px-4 flex items-start justify-center pt-20 sm:pt-28 opacity-0 pointer-events-none transition-all duration-300 z-[99999]">
        <!-- Search Card Box -->
        <div class="w-full max-w-2xl bg-white dark:bg-slate-900 rounded-3xl p-5 sm:p-6 shadow-2xl border border-slate-100 dark:border-slate-800 relative transform transition-all duration-300 -translate-y-4" id="search-card-box">
            <!-- Close Button -->
            <button id="closeSearchButton"
                class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-500 dark:text-slate-400 transition-all cursor-pointer"
                aria-label="Cerrar búsqueda">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>

            <!-- Search Form -->
            <form class="flex items-center w-full" method="GET" action="<?php echo esc_url(home_url('/')); ?>">
                <span class="text-primary mr-3 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </span>
                <input type="text" name="s" id="searchInput" placeholder="Buscar juegos, aplicaciones..."
                    class="w-full bg-transparent border-none focus:outline-none focus:ring-0 text-slate-850 dark:text-slate-100 placeholder-slate-400 text-base sm:text-lg font-medium pr-10">
                
                <?php if ($au_ajax_search_swt) : ?>
                    <div id="ajax-search-results" class="absolute left-0 right-0 top-full mt-3 bg-white dark:bg-slate-900 rounded-2xl shadow-xl overflow-hidden z-20 hidden border border-slate-100 dark:border-slate-800 max-h-[60vh] overflow-y-auto w-full"></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</header>

<!-- Mobile Navigation Drawer Overlay -->
<div id="menu-overlay"
    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300 z-50">
</div>

<!-- Mobile Navigation Drawer (Off-canvas Menu) -->
<div id="off-canvas-menu"
    class="fixed top-0 left-0 bottom-0 w-[70vw] sm:w-80 bg-white dark:bg-slate-900 shadow-2xl z-50 transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
    <!-- Drawer Header -->
    <div class="flex items-center justify-between px-6 h-16 border-b border-slate-100 dark:border-slate-800">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
            <img src="<?php echo esc_url($logo_light); ?>"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?> Logo" class="h-6 w-auto block dark:hidden">
            <img src="<?php echo esc_url($logo_dark); ?>"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?> Dark Logo" class="h-6 w-auto hidden dark:block">
        </a>
        <!-- Close Button -->
        <button id="close-menu"
            class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 dark:text-slate-400 transition-all cursor-pointer"
            aria-label="Cerrar menú">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-x">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </button>
    </div>

    <!-- Drawer Content (Navigation Links) -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <?php if (!empty($header_menus)) : ?>
            <?php foreach ($header_menus as $menu) : 
                $menu_path = parse_url($menu->url, PHP_URL_PATH);
                $is_active = false;
                if ($menu_path) {
                    if ($menu_path === '/' || $menu_path === '') {
                        $is_active = (is_front_page() || is_home());
                    } else {
                        $is_active = (strpos($current_path, $menu_path) === 0);
                    }
                }
                $icon_type = get_post_meta($menu->ID, 'apkup_menu_icon_class', true);
                if (!$icon_type) {
                    $title_lower = strtolower($menu->title);
                    if (strpos($title_lower, 'inicio') !== false || strpos($title_lower, 'home') !== false) {
                        $icon_class = 'home';
                    } elseif (strpos($title_lower, 'juego') !== false || strpos($title_lower, 'game') !== false) {
                        $icon_class = 'gamepad-2';
                    } elseif (strpos($title_lower, 'app') !== false || strpos($title_lower, 'lay') !== false) {
                        $icon_class = 'layers';
                    } elseif (strpos($title_lower, 'blog') !== false || strpos($title_lower, 'news') !== false) {
                        $icon_class = 'newspaper';
                    } else {
                        $icon_class = 'star';
                    }
                } else {
                    $icon_class = esc_attr($icon_type);
                }
                $is_fa = (strpos($icon_class, 'fa-') !== false || strpos($icon_class, 'fas') !== false || strpos($icon_class, 'fa-solid') !== false);
            ?>
                <a href="<?php echo esc_url($menu->url); ?>"
                    class="<?php echo $is_active ? 'flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-primary bg-primary/10 transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-800 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-all'; ?>">
                    <?php if ($is_fa) : ?>
                        <i class="<?php echo $icon_class; ?> <?php echo $is_active ? 'text-primary w-5 h-5' : 'text-slate-400 w-5 h-5'; ?>"></i>
                    <?php else : ?>
                        <i data-lucide="<?php echo $icon_class; ?>" class="<?php echo $is_active ? 'text-primary w-5 h-5' : 'text-slate-400 w-5 h-5'; ?>"></i>
                    <?php endif; ?>
                    <?php echo esc_html($menu->title); ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </nav>

    <!-- Drawer Footer -->
    <div class="p-6 border-t border-slate-100 dark:border-slate-800">
        <div class="flex items-center gap-3 text-xs text-slate-400 dark:text-slate-500 font-light">
            <span>© 2026 APKGSTORE</span>
        </div>
    </div>
</div>

<?php if (is_home() && !empty($au_home_hero_top_description)) : ?>
    <div class="bg-primary text-white py-2 px-4 text-center text-sm">
        <?php echo $au_home_hero_top_description; ?>
    </div>
<?php endif; ?>

<script>
(function() {
    function handleScroll() {
        const header = document.querySelector('.glass-header');
        if (header) {
            if (window.scrollY > 10) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    }
    window.addEventListener('scroll', handleScroll);
    document.addEventListener('pjax:complete', handleScroll);
    document.addEventListener('DOMContentLoaded', handleScroll);
    handleScroll();
})();
</script>