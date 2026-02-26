<?php
$menu_locations = get_nav_menu_locations();
$mobile_menu_items = isset($menu_locations['mobile_menu'])
    ? wp_get_nav_menu_items($menu_locations['mobile_menu'])
    : [];
$footer_menu_items = isset($menu_locations['footer_menu'])
    ? wp_get_nav_menu_items($menu_locations['footer_menu'])
    : [];

$mobile_menu_items = array_slice($mobile_menu_items, 0, 5);

$au_header_logo = get_theme_mod('au_header_logo', get_template_directory_uri() . '/assets/img/logo.png');
$footer_copyright = get_theme_mod('footer_copyright', 'Copyright © 2025 APKTEMPLATES.');

$au_home_footer_info_swt = get_theme_mod('au_home_footer_info_swt', false);
$au_home_footer_info_title = get_theme_mod('au_home_footer_info_title', 'Best Android Apps & Games for free');
$au_home_footer_info_description = get_theme_mod('au_home_footer_info_description', 'Hre is the best place to dwonload android premium apps and mod games for free.');

$au_home_footer_tg_swt = get_theme_mod('au_home_footer_tg_swt', false);
$au_home_footer_tg_title = get_theme_mod('au_home_footer_tg_title', 'Join our Telegram');
$au_home_footer_tg_desc = get_theme_mod('au_home_footer_tg_desc', 'Get the latest updates and news directly on Telegram.');
$au_home_footer_tg_url = get_theme_mod('au_home_footer_tg_url', 'https://t.me/apkgamingstore');

$au_games_menu_url = get_theme_mod('au_games_menu_url', '');
$au_apps_menu_url = get_theme_mod('au_apps_menu_url', '');

$current_url = $_SERVER['REQUEST_URI'];
$games_path  = parse_url($au_games_menu_url, PHP_URL_PATH);
$apps_path   = parse_url($au_apps_menu_url, PHP_URL_PATH);
?>

<footer class="max-w-7xl mx-auto px-4">
    <div class="mb-8">
        <?php if ($au_home_footer_info_swt) : ?>
            <div class="about border border-gray-200 dark:border-gray-600 rounded-3xl p-8">
                <?php if (!empty($au_home_footer_info_title)) : ?>
                    <h2 class="title text-xl mb-4 dark:text-gray-200">
                        <?php echo $au_home_footer_info_title; ?>
                    </h2>
                <?php endif;
                if (!empty($au_home_footer_info_description)) : ?>
                    <p id="desc" class="desc text-gray-400 dark:text-gray-300 line-clamp-3 transition-all duration-300">
                        <?php echo $au_home_footer_info_description; ?>
                    </p>
                    <button id="toggleBtn" class="mt-3 text-primary hover:underline text-sm font-semibold focus:outline-none cursor-pointer">
                        LEER MÁS
                    </button>
                <?php endif; ?>
            </div>
        <?php endif;
        if ($au_home_footer_tg_swt) : ?>
            <div class="telegram my-4 relative rounded-2xl p-8 flex items-center justify-between overflow-hidden">
                <div class="absolute top-0 right-0 h-full w-1/3 bg-cover bg-center opacity-70"
                    style="background-image: url('<?php echo get_template_directory_uri() . '/assets/img/telegram.webp'; ?>');">
                </div>
                <div class="absolute inset-0 bg-gradient-to-r from-primary/20/70 to-green-200/70"></div>
                <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between w-full">
                    <div>
                        <?php if (!empty($au_home_footer_tg_title)) : ?>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2"><?php echo $au_home_footer_tg_title; ?></h2>
                        <?php endif;
                        if (!empty($au_home_footer_tg_desc)) : ?>
                            <p class="hidden lg:block text-gray-600 dark:text-gray-200 mb-4 lg:mb-0">
                                <?php echo $au_home_footer_tg_desc; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($au_home_footer_tg_url)) : ?>
                        <a href="<?php echo $au_home_footer_tg_url; ?>" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary transition-colors">
                            Únete ahora
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
    if (!empty($footer_menu_items)) : ?>
        <div class="footer-menu mt-4">
            <ul class="flex flex-wrap items-center gap-6 text-gray-600 border-b border-gray-300 py-4 dark:border-gray-600 dark:text-gray-400 my-2">
                <?php foreach ($footer_menu_items as $f_menu) : ?>
                    <li><a href="<?php echo $f_menu->url; ?>" class="hover:text-primary dark:text-white dark:hover:text-primary/40"><?php echo $f_menu->title; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="flex items-center justify-between py-4">
        <div class="left-footer flex items-center">
            <img src="<?php echo $au_header_logo; ?>" alt="<?php echo get_bloginfo('name'); ?> Logo" class="h-8 w-auto mr-4">
            <?php if (!empty($footer_copyright)) : ?>
                <p class="text-sm dark:text-white"><?php echo $footer_copyright; ?></p>
            <?php endif; ?>
        </div>
        <div class="right-footer">
            <a href="#top" aria-label="Scroll to top" class="inline-flex items-center justify-center text-gray-400 hover:bg-gray-200 border-2 border-gray-300 dark:border-gray-600 rounded-full p-2 transition-colors">
                <svg class="text-gray-700" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 256 256">
                    <path d="M213.66,165.66a8,8,0,0,1-11.32,0L128,91.31,53.66,165.66a8,8,0,0,1-11.32-11.32l80-80a8,8,0,0,1,11.32,0l80,80A8,8,0,0,1,213.66,165.66Z">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</footer>
<?php
if ($mobile_menu_items) : ?>
    <div class="offcanvas" id="offcanvas">
        <div class="offcanvas-header">
            <h2 class="text-xl font-bold">Menu</h2>
            <button class="offcanvas-close" id="closeMenu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <ul class="offcanvas-menu">
                <?php foreach ($mobile_menu_items as $mb_menu) :
                    $icon_type = get_post_meta($mb_menu->ID, 'apkup_menu_icon_class', true);
                ?>
                    <li class="offcanvas-item">
                        <a href="<?php echo esc_url($mb_menu->url); ?>" class="offcanvas-link">
                            <?php
                            $icon_class = $icon_type ? esc_attr($icon_type) : 'fas fa-home';
                            ?>
                            <i class="<?php echo $icon_class; ?> offcanvas-icon"></i>
                            <?php echo esc_html($mb_menu->title); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<!-- Overlay -->
<div class="overlay" id="overlay"></div>
<!-- Mobile Navigation -->
<nav class="mobile-nav" id="mobileNav">
    <div class="nav-handle" id="navHandle">
        <i class="fas fa-chevron-up nav-handle-icon"></i>
    </div>
    <div class="nav-content">
        <div class="nav-tabs">
            <a href="<?php echo esc_url(home_url('/')); ?>"
                class="nav-tab <?php echo is_front_page() ? 'active' : ''; ?>">
                <i class="fas fa-home nav-tab-icon"></i>
                <span class="nav-tab-text">Inicio</span>
            </a>

            <a href="<?php echo esc_url($au_games_menu_url); ?>"
                class="nav-tab <?php echo (strpos($current_url, $games_path) === 0) ? 'active' : ''; ?>">
                <i class="fas fa-gamepad nav-tab-icon"></i>
                <span class="nav-tab-text">Juegos</span>
            </a>

            <a href="<?php echo esc_url($au_apps_menu_url); ?>"
                class="nav-tab <?php echo (strpos($current_url, $apps_path) === 0) ? 'active' : ''; ?>">
                <i class="fas fa-th nav-tab-icon"></i>
                <span class="nav-tab-text">Apps</span>
            </a>

            <button class="nav-tab" id="openMenu">
                <i class="fas fa-bars nav-tab-icon"></i>
                <span class="nav-tab-text">Menu</span>
            </button>
        </div>
    </div>
</nav>