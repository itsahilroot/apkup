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
<style>
/* ══════════════════════════════
    MOBILE NAV GLASS BAR
══════════════════════════════ */
.mobile-nav {
  position: fixed;
  bottom: 0; left: 0; right: 0;
  z-index: 998;
}

/* handle pill */
.nav-handle {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 6px 0 2px;
  cursor: pointer;
  background: transparent;
  width: 100%;
}
.nav-handle-pill {
  width: 36px; height: 4px;
  border-radius: 2px;
  background: rgba(255,255,255,0.7);
}
.dark .nav-handle-pill {
  background: rgba(255,255,255,0.25);
}

/* glass bar */
.nav-content {
  padding: 8px 16px calc(env(safe-area-inset-bottom, 0px) + 8px);
  background: rgba(255, 255, 255, 0.65);
  backdrop-filter: saturate(200%) blur(30px);
  -webkit-backdrop-filter: saturate(200%) blur(30px);
  border-top: 1px solid rgba(0,0,0,0.1);
  box-shadow: 0 -1px 0 rgba(0,0,0,0.06), 0 -20px 60px rgba(0,0,0,0.1);
  border-radius: 0;
}
.dark .nav-content {
  background: rgba(15, 15, 26, 0.65);
  border-top: 1px solid rgba(255,255,255,0.1);
  box-shadow: 0 -1px 0 rgba(255,255,255,0.06), 0 -20px 60px rgba(0,0,0,0.35);
}

.nav-tabs {
  display: flex !important;
  align-items: flex-end;
  justify-content: space-around;
  gap: 4px;
}

.nav-tab {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 4px;
  padding: 8px 12px;
  border-radius: 16px;
  border: none;
  background: transparent;
  color: rgba(0,0,0,0.45);
  cursor: pointer;
  text-decoration: none;
  transition: color 0.2s, background 0.2s, transform 0.15s;
  min-width: 56px;
  flex: 1;
  position: relative;
}
.dark .nav-tab { color: rgba(255,255,255,0.45); }

.nav-tab:hover {
  background: rgba(0,0,0,0.06);
  color: rgba(0,0,0,0.75);
}
.dark .nav-tab:hover {
  background: rgba(255,255,255,0.06);
  color: rgba(255,255,255,0.75);
}
.nav-tab:active { transform: scale(0.92); }

.nav-tab.active { color: #000; }
.dark .nav-tab.active { color: #fff; }

/* active glow pill behind icon */
.nav-tab.active::before {
  content: '';
  position: absolute;
  top: 6px;
  left: 50%;
  transform: translateX(-50%);
  width: 32px; height: 32px;
  border-radius: 10px;
  background: rgba(0, 122, 255, 0.15);
  box-shadow: 0 0 14px rgba(0,122,255,0.4);
  z-index: 0;
}
.dark .nav-tab.active::before { background: rgba(0, 122, 255, 0.25); }

.nav-tab-icon {
  font-size: 20px;
  position: relative;
  z-index: 1;
  transition: transform 0.2s cubic-bezier(0.34,1.56,0.64,1);
}
.nav-tab.active .nav-tab-icon { transform: scale(1.15); }

.nav-tab-text {
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 0.02em;
  position: relative;
  z-index: 1;
  transition: opacity 0.2s;
}

/* active tab label — iOS SF style */
.nav-tab.active .nav-tab-text {
  color: #007aff;
  text-shadow: 0 0 12px rgba(0,122,255,0.3);
}
.dark .nav-tab.active .nav-tab-text {
  text-shadow: 0 0 12px rgba(0,122,255,0.6);
}
.nav-tab.active .nav-tab-icon { color: #007aff; }

/* bounce on click */
@keyframes tabBounce {
  0%   { transform: scale(1); }
  40%  { transform: scale(0.85); }
  70%  { transform: scale(1.2); }
  100% { transform: scale(1.1); }
}
.nav-tab.active .nav-tab-icon { animation: tabBounce 0.35s cubic-bezier(0.34,1.56,0.64,1) forwards; }

/* notification badge */
.nav-badge {
  position: absolute;
  top: 3px;
  right: calc(50% - 22px);
  background: #ff375f;
  color: #fff;
  font-size: 9px;
  font-weight: 800;
  min-width: 16px;
  height: 16px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 4px;
  border: 1.5px solid rgba(255,255,255,0.8);
  z-index: 2;
}
.dark .nav-badge { border: 1.5px solid rgba(15,15,26,0.8); }
</style>

<nav class="mobile-nav block md:hidden" id="mobileNav">
    <div class="nav-handle" id="navHandle">
        <div class="nav-handle-pill"></div>
    </div>
    <div class="nav-content">
        <div class="nav-tabs">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-tab <?php echo is_front_page() ? 'active' : ''; ?>">
                <i class="fas fa-home nav-tab-icon"></i>
                <span class="nav-tab-text">Inicio</span>
            </a>

            <a href="<?php echo esc_url($au_games_menu_url); ?>" class="nav-tab <?php echo (strpos($current_url, $games_path) === 0) ? 'active' : ''; ?>">
                <span class="nav-badge">3</span>
                <i class="fas fa-gamepad nav-tab-icon"></i>
                <span class="nav-tab-text">Juegos</span>
            </a>

            <a href="<?php echo esc_url($au_apps_menu_url); ?>" class="nav-tab <?php echo (strpos($current_url, $apps_path) === 0) ? 'active' : ''; ?>">
                <i class="fa-solid fa-layer-group nav-tab-icon"></i>
                <span class="nav-tab-text">Apps</span>
            </a>

            <button class="nav-tab" id="openMenu">
                <i class="fas fa-bars nav-tab-icon"></i>
                <span class="nav-tab-text">Menú</span>
            </button>
        </div>
    </div>
</nav>
