<?php
$logo_light = get_theme_mod('au_header_logo');
$logo_dark = get_theme_mod('au_header_logo_dark');
$footer_copyright = get_theme_mod('footer_copyright', 'Copyright © 2025 APKTEMPLATES.');
$menu_locations = get_nav_menu_locations();
$footer_menus = !empty($menu_locations['footer_menu']) ? wp_get_nav_menu_items($menu_locations['footer_menu']) : [];

if (empty($footer_menus)) {
    $footer_menus = [
        (object)[ 'title' => 'Acerca de Nosotros', 'url' => 'https://apkgstore.co/inicio/' ],
        (object)[ 'title' => 'Política de Cookies', 'url' => 'https://apkgstore.co/politica-de-cookies/' ],
        (object)[ 'title' => 'Política de Privacidad', 'url' => 'https://apkgstore.co/politica-de-privacidad/' ],
        (object)[ 'title' => 'DMCA', 'url' => 'https://apkgstore.co/dmca/' ],
    ];
}
?>
<footer
  class="bg-white/40 dark:bg-slate-950 border-t border-slate-200/40 dark:border-white/5 py-10 mb-0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <div
      class="flex flex-col md:flex-row items-center justify-between gap-6 pb-6 border-b border-slate-200/40 dark:border-white/5">
      <div class="flex items-center gap-3">
                    <img src="<?php echo esc_url($logo_light); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?> Logo" class="h-7 w-auto block dark:hidden">
                    <img src="<?php echo esc_url($logo_dark); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?> Dark Logo" class="h-7 w-auto hidden dark:block">
      </div>
      <div class="flex flex-wrap justify-center gap-6 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <?php foreach ($footer_menus as $menu) : ?>
          <a href="<?php echo esc_url($menu->url); ?>" class="group flex items-center gap-2 hover:text-primary transition-all">
            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-700 group-hover:bg-primary group-hover:shadow-[0_0_8px_rgba(26,115,232,0.8)] transition-all duration-300"></span>
            <?php echo esc_html($menu->title); ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="flex flex-col md:flex-row items-center justify-between text-[11px] text-slate-400 gap-4 font-light">
      <p><?php echo esc_html($footer_copyright); ?></p>
      <a href="#top"
        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-primary dark:bg-slate-800 text-slate-500 hover:text-white flex items-center justify-center transition-all"
        aria-label="Subir al inicio">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up"><path d="m5 12 7-7 7 7"/><path d="M12 5v14"/></svg>
      </a>
    </div>
  </div>
</footer>
