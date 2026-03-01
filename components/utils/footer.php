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
            <div class="info-card">
                <?php if (!empty($au_home_footer_info_title)) : ?>
                    <h2>
                        <?php echo $au_home_footer_info_title; ?>
                    </h2>
                <?php endif;
                if (!empty($au_home_footer_info_description)) : ?>
                    <p id="desc" class="line-clamp-3 transition-all duration-300">
                        <?php echo $au_home_footer_info_description; ?>
                    </p>
                    <button id="toggleBtn" class="leer-mas bg-transparent border-none cursor-pointer">
                        LEER MÁS
                    </button>
                <?php endif; ?>
            </div>
        <?php endif;
        if ($au_home_footer_tg_swt) : ?>
            <div class="telegram-banner mt-4 flex">
                <div class="absolute top-0 right-0 h-full w-full md:w-2/3 bg-cover bg-right opacity-0 md:opacity-60 pointer-events-none transition-opacity duration-300 z-0" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/telegram.webp'); mask-image: linear-gradient(to right, transparent 0%, black 50%); -webkit-mask-image: linear-gradient(to right, transparent 0%, black 50%); mix-blend-mode: multiply;"></div>
                
                <div class="relative z-10 flex flex-col md:items-start justify-center text-center md:text-left md:pr-4 md:flex-1 w-full">
                    <h3><?php echo !empty($au_home_footer_tg_title) ? $au_home_footer_tg_title : 'Únete <span>a</span> nuestro Telegram'; ?></h3>
                    <?php if (!empty($au_home_footer_tg_desc)) : ?>
                        <p class="hidden md:block text-gray-700 dark:text-gray-200 text-sm font-bold opacity-80 max-w-md m-0">
                            <?php echo $au_home_footer_tg_desc; ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="relative z-10 flex items-center justify-center shrink-0 mt-5 md:mt-0">
                    <a href="<?php echo $au_home_footer_tg_url ?: 'https://t.me/apkgamingstore'; ?>" target="_blank" class="btn-join">
                        Únete ahora &rarr;
                    </a>
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
            <a href="#top" aria-label="Scroll to top" class="btn-icon !w-12 !h-12 flex items-center justify-center">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
            </a>
        </div>
    </div>
</footer>
<?php
if ($mobile_menu_items) : ?>
    <div class="offcanvas" id="offcanvas">
        <div class="offcanvas-header bg-gray-50 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 p-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Menu</h2>
            <button class="offcanvas-close w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-full shadow-sm text-gray-500 transition-colors" id="closeMenu">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body p-4 bg-white dark:bg-gray-900 h-full">
            <ul class="flex flex-col gap-2">
                <?php foreach ($mobile_menu_items as $mb_menu) :
                    $icon_type = get_post_meta($mb_menu->ID, 'apkup_menu_icon_class', true);
                    $icon_class = $icon_type ? esc_attr($icon_type) : 'fas fa-home';
                ?>
                    <li>
                        <a href="<?php echo esc_url($mb_menu->url); ?>" class="flex items-center gap-4 p-3 bg-transparent hover:bg-gray-50 dark:hover:bg-gray-800 rounded-2xl text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:shadow-sm hover:translate-x-1 transition-all duration-300 font-bold group">
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-50 dark:bg-gray-800 group-hover:bg-blue-100 dark:group-hover:bg-gray-700 transition-colors duration-300 shadow-sm">
                                <i class="<?php echo $icon_class; ?> text-blue-500 dark:text-gray-400 group-hover:scale-110 transition-transform duration-300"></i>
                            </span>
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
<nav class="fixed bottom-0 left-0 w-full bg-white/30 dark:bg-[#1c1c1e]/30 backdrop-blur-2xl backdrop-saturate-[180%] border-t border-black/5 dark:border-white/10 z-50 md:hidden shadow-[0_-8px_30px_rgba(0,0,0,0.05)] transition-transform duration-300" id="mobileNav">
    <!-- Restored Pull Handle -->
    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-16 h-6 bg-white/30 dark:bg-[#1c1c1e]/30 backdrop-blur-2xl backdrop-saturate-[180%] rounded-t-xl border-t border-l border-r border-black/5 dark:border-white/10 flex items-center justify-center cursor-pointer shadow-[0_-4px_10px_rgba(0,0,0,0.02)] group" id="navHandle">
        <i class="fas fa-chevron-up text-gray-400 group-hover:text-primary transition-colors text-xs nav-handle-icon"></i>
    </div>
    <div class="flex justify-around items-center px-1 py-3 pb-safe">
        <a href="<?php echo esc_url(home_url('/')); ?>"
            class="flex flex-col items-center justify-center w-16 gap-1.5 group <?php echo is_front_page() ? 'text-primary' : 'text-gray-500 dark:text-gray-400'; ?> hover:text-primary transition-colors">
            <span class="flex items-center justify-center w-10 h-10 rounded-full <?php echo is_front_page() ? 'bg-blue-50 dark:bg-gray-700 shadow-inner' : 'bg-transparent'; ?> group-hover:bg-blue-50 dark:group-hover:bg-gray-700 transition-all duration-300">
                <i class="fas fa-home text-[1.1rem] group-hover:scale-110 transition-transform group-active:scale-95"></i>
            </span>
            <span class="text-[10px] font-bold tracking-wider">Inicio</span>
        </a>

        <a href="<?php echo esc_url($au_games_menu_url); ?>"
            class="flex flex-col items-center justify-center w-16 gap-1.5 group <?php echo (strpos($current_url, $games_path) === 0) ? 'text-primary' : 'text-gray-500 dark:text-gray-400'; ?> hover:text-primary transition-colors">
            <span class="flex items-center justify-center w-10 h-10 rounded-full <?php echo (strpos($current_url, $games_path) === 0) ? 'bg-blue-50 dark:bg-gray-700 shadow-inner' : 'bg-transparent'; ?> group-hover:bg-blue-50 dark:group-hover:bg-gray-700 transition-all duration-300">
                <i class="fas fa-gamepad text-[1.1rem] group-hover:scale-110 transition-transform group-active:scale-95"></i>
            </span>
            <span class="text-[10px] font-bold tracking-wider">Juegos</span>
        </a>

        <a href="<?php echo esc_url($au_apps_menu_url); ?>"
            class="flex flex-col items-center justify-center w-16 gap-1.5 group <?php echo (strpos($current_url, $apps_path) === 0) ? 'text-primary' : 'text-gray-500 dark:text-gray-400'; ?> hover:text-primary transition-colors">
            <span class="flex items-center justify-center w-10 h-10 rounded-full <?php echo (strpos($current_url, $apps_path) === 0) ? 'bg-blue-50 dark:bg-gray-700 shadow-inner' : 'bg-transparent'; ?> group-hover:bg-blue-50 dark:group-hover:bg-gray-700 transition-all duration-300">
                <i class="fa-solid fa-layer-group text-[1.1rem] group-hover:scale-110 transition-transform group-active:scale-95"></i>
            </span>
            <span class="text-[10px] font-bold tracking-wider">Apps</span>
        </a>

        <button id="openMenu" class="flex flex-col items-center justify-center w-16 gap-1.5 group text-gray-500 dark:text-gray-400 hover:text-primary transition-colors outline-none cursor-pointer">
            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-transparent group-hover:bg-blue-50 dark:group-hover:bg-gray-700 transition-all duration-300">
                <i class="fas fa-bars text-[1.1rem] group-hover:scale-110 transition-transform group-active:scale-95"></i>
            </span>
            <span class="text-[10px] font-bold tracking-wider">Menu</span>
        </button>
    </div>
</nav>