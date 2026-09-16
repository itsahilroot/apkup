<?php
get_header();

$site_cache_swt = get_theme_mod('site_cache_swt', '1');
$site_cache_time = intval(get_theme_mod('site_cache_time', '24'));
$archive_featured_swt = get_theme_mod('archive_featured_swt', '1');
$archive_featured_count = intval(get_theme_mod('archive_featured_count', '3'));
$archive_recent_swt = get_theme_mod('archive_recent_swt', '1');
$archive_recent_limit = intval(get_theme_mod('archive_recent_limit', '4'));
$archive_recommended_swt = get_theme_mod('archive_recommended_swt', '1');
$archive_recommended_limit = intval(get_theme_mod('archive_recommended_limit', '2'));
$archive_premium_swt = get_theme_mod('archive_premium_swt', '1');
$archive_premium_limit = intval(get_theme_mod('archive_premium_limit', '6'));
$archive_sidebar_swt = get_theme_mod('archive_sidebar_swt', '1');
$term_id = get_queried_object_id();
$current_page = get_query_var('paged') ? get_query_var('paged') : 1;
$transient_key = 'apkup_arc_' . $term_id . '_p_' . $current_page;

$is_cacheable = false; // Temporarily disabled during development to bypass transient cache
$cached_html = $is_cacheable ? get_transient($transient_key) : false;

if ($cached_html !== false) {
    echo $cached_html;
    get_footer();
    exit;
}

if ($is_cacheable) {
    ob_start();
}

$current_cat = get_queried_object();
?>
<main class="max-w-md md:max-w-3xl lg:max-w-7xl mx-auto pb-10 sm:px-6 lg:px-8 mt-6 px-4">

    <!-- Breadcrumbs Section -->
    <nav class="flex items-center gap-2 text-xs text-slate-400 dark:text-slate-500 mb-6 font-light" aria-label="Breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary transition-colors">Inicio</a>
      <span class="text-slate-300 dark:text-slate-700">/</span>
      <?php
      if (is_category()) {
          $cat_obj = get_queried_object();
          if ($cat_obj && $cat_obj->category_parent != 0) {
              $parent_cat = get_term($cat_obj->category_parent, 'category');
              if ($parent_cat && !is_wp_error($parent_cat)) {
                  ?>
                  <a href="<?php echo esc_url(get_term_link($parent_cat)); ?>" class="hover:text-primary transition-colors"><?php echo esc_html($parent_cat->name); ?></a>
                  <span class="text-slate-300 dark:text-slate-700">/</span>
                  <?php
              }
          }
      }
      ?>
      <span class="text-slate-600 dark:text-slate-300 font-normal"><?php echo single_term_title('', false); ?></span>
    </nav>

    <!-- Page Intro Header Banner -->
    <header class="glass-card p-6 sm:p-8 rounded-[28px] border border-slate-200/50 dark:border-white/5 mb-8 relative overflow-hidden">
      <!-- Decorative Gradient Glow background -->
      <div class="absolute -right-16 -top-16 w-48 h-48 rounded-full bg-primary/10 blur-3xl pointer-events-none"></div>

      <div class="relative z-10">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight">
          <?php echo single_term_title('', false); ?>
        </h1>
        <?php if (term_description()) : ?>
          <div class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-light">
            <?php echo term_description(); ?>
          </div>
        <?php else : ?>
          <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-light">
            Descubre e instala las mejores versiones modificadas, premium y gratuitas para tu dispositivo Android.
            Todos nuestros archivos han sido analizados rigurosamente para garantizar descargas seguras.
          </p>
        <?php endif; ?>
      </div>
    </header>

    <?php
    if (is_category()) {
        $current_term = get_queried_object();
        if ($current_term && $current_term->category_parent == 0) {
            $subcats = get_categories([
                'parent'     => $current_term->term_id,
                'hide_empty' => false,
            ]);
            if (!empty($subcats)) : ?>
                <div class="mb-8">
                    <div class="carousel -mx-4 px-4 sm:mx-0 sm:px-0" data-flickity='{"freeScroll": true, "contain": true, "prevNextButtons": false, "pageDots": false, "cellAlign": "left"}'>
                        <?php foreach ($subcats as $subcat) : 
                            $subcat_link = get_term_link($subcat);
                            ?>
                            <a href="<?php echo esc_url($subcat_link); ?>" class="inline-flex items-center px-4 py-2.5 rounded-2xl text-xs font-semibold bg-white dark:bg-brand-darkCard text-slate-700 dark:text-slate-200 border border-slate-200/60 dark:border-brand-darkBorder hover:bg-primary hover:text-white dark:hover:bg-primary dark:hover:text-white transition-all duration-200 shadow-sm shrink-0 snap-center hover:scale-102 mr-3">
                                <span><?php echo esc_html($subcat->name); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif;
        }
    }
    ?>

    <?php archive_top_ad('div', 'my-4'); ?>

    <!-- Main Content Layout Section: Grid/Sections + Sidebar -->
    <div class="flex flex-col lg:flex-row gap-8">

      <!-- Left Column: Filter Controls, Multi-Layout, and Results Grid (Width: 3/4 or full-width) -->
      <section class="<?php echo ($archive_sidebar_swt === '1') ? 'w-full lg:w-3/4' : 'w-full'; ?> flex flex-col gap-6">

        <!-- Filter Controls Block -->
        <div class="flex flex-col gap-4">
          <!-- Category Chips -->
          <!-- <div class="flex gap-2.5 overflow-x-auto py-3 px-2 -mx-2 scrollbar-hide snap-x" aria-label="Filtrar por categoría">
            <button id="chip-all" onclick="clearCategoryFilter()" class="category-chip my-1 mx-0.5 px-4 py-2 shrink-0 rounded-full font-semibold text-xs text-slate-700 dark:text-slate-400 border border-transparent hover:scale-102 transition-all flex items-center gap-1.5 ring-2 ring-primary bg-slate-200 dark:bg-slate-800">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><rect width="7" height="7" x="3" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="14" rx="1"></rect><rect width="7" height="7" x="3" y="14" rx="1"></rect></svg> Todas
            </button>
            
            <?php
            $child_categories = [];
            if (is_category()) {
                $current_cat = get_queried_object();
                $parent_id = ($current_cat->category_parent == 0) ? $current_cat->term_id : $current_cat->category_parent;
                $child_categories = get_categories([
                    'parent'     => $parent_id,
                    'hide_empty' => true,
                ]);
            }
            
            $color_index = 0;
            $colors = [
                ['bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/10', 'flame', '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M12 3q1 4 4 6.5t3 5.5a1 1 0 0 1-14 0 5 5 0 0 1 1-3 1 1 0 0 0 5 0c0-2-1.5-3-1.5-5q0-2 2.5-4"></path></svg>'],
                ['bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/10', 'puzzle', '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M15.39 4.39a1 1 0 0 0 1.68-.474 2.5 2.5 0 1 1 3.014 3.015 1 1 0 0 0-.474 1.68l1.683 1.682a2.414 2.414 0 0 1 0 3.414L19.61 15.39a1 1 0 0 1-1.68-.474 2.5 2.5 0 1 0-3.014 3.015 1 1 0 0 1 .474 1.68l-1.683 1.682a2.414 2.414 0 0 1-3.414 0L8.61 19.61a1 1 0 0 0-1.68.474 2.5 2.5 0 1 1-3.014-3.015 1 1 0 0 0 .474-1.68l-1.683-1.682a2.414 2.414 0 0 1 0-3.414L4.39 8.61a1 1 0 0 1 1.68.474 2.5 2.5 0 1 0 3.014-3.015 1 1 0 0 1-.474-1.68l1.683-1.682a2.414 2.414 0 0 1 3.414 0z"></path></svg>'],
                ['bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/10', 'gamepad-2', '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><line x1="6" x2="10" y1="11" y2="11"></line><line x1="8" x2="8" y1="9" y2="13"></line><line x1="15" x2="15.01" y1="12" y2="12"></line><line x1="18" x2="18.01" y1="10" y2="10"></line><path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"></path></svg>'],
                ['bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/10', 'music', '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg>'],
                ['bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/10', 'cpu', '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M12 20v2"></path><path d="M12 2v2"></path><path d="M17 20v2"></path><path d="M17 2v2"></path><path d="M2 12h2"></path><path d="M2 17h2"></path><path d="M2 7h2"></path><path d="M20 12h2"></path><path d="M20 17h2"></path><path d="M20 7h2"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="8" y="8" width="8" height="8" rx="1"></rect></svg>'],
                ['bg-slate-500/10 text-slate-600 dark:text-slate-400 border border-slate-500/10', 'layers', '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path></svg>']
            ];
            
            foreach ($child_categories as $ccat) :
                $c_style = $colors[$color_index % count($colors)];
                // Auto-match icon logic or use standard color index layout
                ?>
                <button id="chip-<?php echo esc_attr($ccat->slug); ?>" onclick="filterCategory('<?php echo esc_attr($ccat->slug); ?>', this)" class="category-chip my-1 mx-0.5 px-4 py-2 shrink-0 rounded-full font-semibold text-xs <?php echo esc_attr($c_style[0]); ?> hover:scale-102 transition-all flex items-center gap-1.5">
                  <?php echo $c_style[2]; ?> <?php echo esc_html($ccat->name); ?>
                </button>
                <?php
                $color_index++;
            endforeach;
            ?>
          </div> -->
        </div>

        <?php
        // Check if the current term is a parent category (parent == 0) or if there's no queried object
        $is_parent_category = false;
        if (is_category()) {
            $cat_obj = get_queried_object();
            if ($cat_obj && $cat_obj->category_parent == 0) {
                $is_parent_category = true;
            }
        }
        ?>

        <!-- ==================== VIEW 1: MULTI-LAYOUT SECTIONS ==================== -->
        <div id="multi-layout-sections" class="space-y-10 <?php echo $is_parent_category ? '' : 'hidden'; ?>">

          <!-- LAYOUT STYLE 1: Destacados de la Semana (Landscape Cover Cards) -->
          <?php if ($archive_featured_swt == '1') : ?>
          <section>
            <div class="flex items-center justify-between mb-2">
              <h2 class="text-md font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5 text-amber-500"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path><circle cx="12" cy="8" r="6"></circle></svg> Lanzamientos Destacados
              </h2>
            </div>

            <div class="flex overflow-x-auto md:overflow-x-hidden no-scrollbar pb-4 w-full home-posts-carousel" id="archive-featured-carousel">
              <!-- Dynamically fetch posts with a tag/meta/rating or just recent posts for highlights -->
              <?php
              $highlight_args = [
                  'post_type'      => 'post',
                  'posts_per_page' => $archive_featured_count,
                  'cat'            => $term_id,
              ];
              $highlight_query = new WP_Query($highlight_args);
              if ($highlight_query->have_posts()) :
                  while ($highlight_query->have_posts()) : $highlight_query->the_post();
                      $h_id = get_the_ID();
                      $h_logo = get_the_post_thumbnail_url($h_id, 'thumbnail') ?: 'https://placehold.co/150x150/0052e0/ffffff?text=App';
                      $h_cover = get_post_meta($h_id, 'wp_poster_GP', true) ?: (get_the_post_thumbnail_url($h_id, 'large') ?: $h_logo);
                      $h_rating = get_post_meta($h_id, 'new_rating_average', true) ?: '4.2';
                      $h_data = get_post_meta($h_id, 'datos_informacion', true) ?: [];
                      $h_size = $h_data['tamano'] ?? '45 MB';
                      $h_version = $h_data['version'] ?? '1.0';
                      $h_is_mod = get_post_meta($h_id, 'app_type', true);
                      $h_tag = $h_is_mod == 1 ? 'MOD' : 'APK';
                      $h_tag_bg = $h_is_mod == 1 ? 'bg-emerald-500 text-white' : 'bg-blue-500 text-white';
                      
                      $h_cats = get_the_category();
                      $h_primary_cat = !empty($h_cats) ? $h_cats[0]->name : 'Apps';
                      ?>
                      <article class="shrink-0 w-72 mr-6 flex flex-col">
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/9] mb-3 border border-slate-200/30 dark:border-white/5 shadow-[0_8px_30px_rgba(0,0,0,0.06)] dark:shadow-[0_15px_40px_rgba(0,0,0,0.3)] transition-all duration-300">
                          <img alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover" src="<?php echo esc_url($h_cover); ?>">
                          <span class="absolute top-2.5 right-2.5 <?php echo esc_attr($h_tag_bg); ?> font-extrabold text-[9px] px-2.5 py-0.5 rounded-full shadow-md uppercase tracking-wider"><?php echo esc_html($h_tag); ?></span>
                        </div>
                        <div class="flex items-start gap-3 px-1">
                          <img class="w-11 h-11 rounded-xl shrink-0 object-cover shadow-md border border-slate-100 dark:border-slate-800" src="<?php echo esc_url($h_logo); ?>" alt="<?php the_title_attribute(); ?>">
                          <div class="min-w-0 flex-1">
                            <h3 class="text-xs font-bold truncate text-slate-800 dark:text-slate-200 transition-colors">
                              <?php the_title(); ?></h3>
                            <p class="text-[10px] text-slate-400"><?php echo esc_html($h_primary_cat); ?> • <?php echo esc_html($h_size); ?></p>
                            <p class="text-[10px] text-slate-400"><span class="text-amber-500 dark:text-amber-400 font-bold"><?php echo esc_html($h_rating); ?> ★</span> • v<?php echo esc_html($h_version); ?></p>
                          </div>
                          <a class="px-3 py-1 bg-slate-100 hover:bg-primary hover:text-white dark:bg-slate-800 dark:hover:bg-primary  transition-all text-[10px] font-semibold rounded-full" href="<?php the_permalink(); ?>">Ver</a>
                        </div>
                      </article>
                      <?php
                  endwhile;
                  wp_reset_postdata();
              endif;
              ?>
            </div>
          </section>
          <?php endif; ?>

          <!-- LAYOUT STYLE 2: Nuevas Incorporaciones (Store Grid Layout) -->
          <?php if ($archive_recent_swt == '1') : ?>
          <section>
            <div class="flex items-center justify-between mb-2">
              <h2 class="text-md font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5 text-primary animate-pulse"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg> Agregados Recientemente
              </h2>
            </div>

            <div class="flex overflow-x-auto md:overflow-x-hidden no-scrollbar pb-3 home-posts-carousel" id="archive-recent-carousel">
              <?php
              $recent_args = [
                  'post_type'      => 'post',
                  'posts_per_page' => $archive_recent_limit,
                  'cat'            => $term_id,
              ];
              $recent_query = new WP_Query($recent_args);
              if ($recent_query->have_posts()) :
                  while ($recent_query->have_posts()) : $recent_query->the_post();
                      $r_id = get_the_ID();
                      $r_logo = get_the_post_thumbnail_url($r_id, 'thumbnail') ?: 'https://placehold.co/150x150/0052e0/ffffff?text=App';
                      $r_data = get_post_meta($r_id, 'datos_informacion', true) ?: [];
                      $r_size = $r_data['tamano'] ?? '45 MB';
                      $r_version = $r_data['version'] ?? '1.0';
                      $r_is_mod = get_post_meta($r_id, 'app_type', true);
                      $r_tag = $r_is_mod == 1 ? 'MOD' : 'APK';
                      $r_tag_bg = $r_is_mod == 1 ? 'bg-emerald-100/70 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-blue-100/70 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300';
                      
                      $r_cats = get_the_category();
                      $r_primary_cat = !empty($r_cats) ? $r_cats[0]->name : 'Apps';
                      ?>
                      <article class="glass-card p-4 rounded-[24px] flex flex-col justify-between border border-slate-200/50 dark:border-white/5 shrink-0 w-36 mr-6">
                        <div class="flex items-center justify-between mb-2">
                          <span class="text-[9px] font-bold px-1.5 py-0.5 <?php echo esc_attr($r_tag_bg); ?> rounded"><?php echo esc_html($r_tag); ?></span>
                          <span class="text-[9px] text-slate-400 dark:text-slate-500 font-light">v<?php echo esc_html($r_version); ?></span>
                        </div>
                        <div class="flex flex-col items-center text-center flex-grow">
                          <div class="w-14 h-14 squircle-icon-medium bg-slate-100 dark:bg-slate-800 overflow-hidden shadow-md mb-3">
                            <img src="<?php echo esc_url($r_logo); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
                          </div>
                          <h3 class="font-bold text-xs text-slate-800 dark:text-white line-clamp-1 transition-colors">
                            <?php the_title(); ?></h3>
                          <p class="text-[9px] text-slate-400 mt-0.5"><?php echo esc_html($r_primary_cat); ?> • <?php echo esc_html($r_size); ?></p>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="mt-3 w-full py-1 bg-slate-150/70 hover:bg-primary hover:text-white dark:bg-slate-800/80 dark:hover:bg-primary transition-all text-[10px] font-semibold rounded-full block text-center">Instalar</a>
                      </article>
                      <?php
                  endwhile;
                  wp_reset_postdata();
              endif;
              ?>
            </div>
          </section>
          <?php endif; ?>

          <!-- LAYOUT STYLE 3: Recomendados (Compact Row List) -->
          <?php if ($archive_recommended_swt == '1') : ?>
          <section>
            <div class="flex items-center justify-between mb-2">
              <h2 class="text-md font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5 text-emerald-500"><path d="M21.801 10A10 10 0 1 1 17 3.335"></path><path d="m9 11 3 3L22 4"></path></svg> Recomendadas para ti
              </h2>
            </div>

            <div class="flex overflow-x-auto md:grid md:grid-cols-2 lg:grid-cols-3 gap-4 no-scrollbar pb-3 md:pb-0 -mx-4 px-4 md:mx-0 md:px-0 snap-x snap-mandatory">
              <?php
              $recommended_args = [
                  'post_type'      => 'post',
                  'posts_per_page' => $archive_recommended_limit,
                  'cat'            => $term_id,
                  'meta_key'       => 'new_rating_average',
                  'orderby'        => 'meta_value_num',
                  'order'          => 'DESC',
              ];
              $recommended_query = new WP_Query($recommended_args);
              if ($recommended_query->have_posts()) :
                  while ($recommended_query->have_posts()) : $recommended_query->the_post();
                      $rec_id = get_the_ID();
                      $rec_logo = get_the_post_thumbnail_url($rec_id, 'thumbnail') ?: 'https://placehold.co/150x150/0052e0/ffffff?text=App';
                      $rec_data = get_post_meta($rec_id, 'datos_informacion', true) ?: [];
                      $rec_version = $rec_data['version'] ?? '1.0';
                      $rec_is_mod = get_post_meta($rec_id, 'app_type', true);
                      $rec_tag = $rec_is_mod == 1 ? 'MOD Liberado' : 'Gratuito';
                      $rec_tag_color = $rec_is_mod == 1 ? 'text-blue-600 dark:text-blue-400' : 'text-emerald-600 dark:text-emerald-400';
                      
                      $rec_cats = get_the_category();
                      $rec_primary_cat = !empty($rec_cats) ? $rec_cats[0]->name : 'Apps';
                      ?>
                      <article class="glass-card p-4 rounded-2xl border border-slate-200/40 dark:border-white/5 flex items-center justify-between gap-4 shrink-0 w-[290px] md:w-auto snap-center">
                        <div class="flex items-center gap-3.5 min-w-0">
                          <img class="w-12 h-12 rounded-xl shrink-0 object-cover shadow-md" src="<?php echo esc_url($rec_logo); ?>" alt="<?php the_title_attribute(); ?>">
                          <div class="min-w-0">
                            <h3 class="font-bold text-xs text-slate-800 dark:text-white truncate transition-colors">
                              <?php the_title(); ?></h3>
                            <p class="text-[10px] text-slate-400"><?php echo esc_html($rec_primary_cat); ?> • Android App</p>
                            <span class="text-[9px] font-bold <?php echo esc_attr($rec_tag_color); ?>"><?php echo esc_html($rec_tag); ?> • v<?php echo esc_html($rec_version); ?></span>
                          </div>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="px-4 py-1.5 bg-slate-100 hover:bg-primary hover:text-white dark:bg-slate-800 dark:hover:bg-primary transition-all text-[10px] font-bold rounded-full shrink-0">Obtener</a>
                      </article>
                      <?php
                  endwhile;
                  wp_reset_postdata();
              endif;
              ?>
            </div>
          </section>
          <?php endif; ?>

          <!-- LAYOUT STYLE 4: Colecciones Populares Gratis (Horizontal Scroll) -->
          <?php if ($archive_premium_swt == '1') : ?>
          <section>
            <div class="flex items-center justify-between mb-2">
              <h2 class="text-md font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5 text-emerald-500"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"></path><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"></circle></svg> Joyas Premium Gratis
              </h2>
            </div>

            <div class="flex overflow-x-auto md:overflow-x-hidden pb-4 no-scrollbar home-posts-carousel" id="archive-premium-carousel">
              <?php
              $premium_args = [
                  'post_type'      => 'post',
                  'posts_per_page' => $archive_premium_limit,
                  'cat'            => $term_id,
                  'meta_query'     => [
                      [
                          'key'   => 'app_type',
                          'value' => '1',
                      ]
                  ]
              ];
              $premium_query = new WP_Query($premium_args);
              if ($premium_query->have_posts()) :
                  while ($premium_query->have_posts()) : $premium_query->the_post();
                      $p_id = get_the_ID();
                      $p_logo = get_the_post_thumbnail_url($p_id, 'thumbnail') ?: 'https://placehold.co/150x150/0052e0/ffffff?text=App';
                      ?>
                      <a href="<?php the_permalink(); ?>" class="w-32 mr-6 shrink-0 text-center block">
                        <div class="w-24 h-24 squircle-icon-extreme bg-white dark:bg-slate-850 mx-auto overflow-hidden shadow-md border border-slate-200/40 dark:border-white/5 ">
                          <img class="w-full h-full object-cover" src="<?php echo esc_url($p_logo); ?>" alt="<?php the_title_attribute(); ?>">
                        </div>
                        <h3 class="font-semibold text-[11px] text-slate-855 dark:text-slate-200 mt-2 truncate transition-colors">
                          <?php the_title(); ?></h3>
                        <div class="mt-0.5 flex justify-center gap-1 items-center">
                          <span class="text-[9px] font-bold text-emerald-600 dark:text-emerald-400 px-1 bg-emerald-100/70 dark:bg-emerald-950/40 rounded">GRATIS</span>
                        </div>
                      </a>
                      <?php
                  endwhile;
                  wp_reset_postdata();
              endif;
              ?>
            </div>
          </section>
          <?php endif; ?>


          <?php
          // RENDER DYNAMIC SUBCATEGORIES IF CONFIGURED
          $archive_dynamic_subcats = get_theme_mod('archive_dynamic_subcats', []);
          if (!empty($archive_dynamic_subcats)) {
              foreach ($archive_dynamic_subcats as $subcat) {
                  if (!($subcat['enable'] ?? true)) continue;
                  $parent_cat = $subcat['parent_cat'] ?? 'all';
                  if ($parent_cat !== 'all' && $parent_cat != $term_id) {
                      continue;
                  }
                  
                  $subcat_term_id = $subcat['term_id'] ?? '';
                  $section_title = $subcat['title'] ?? '';
                  if (empty($section_title) && !empty($subcat_term_id)) {
                      $term_obj = get_term($subcat_term_id);
                      if ($term_obj && !is_wp_error($term_obj)) {
                          $section_title = $term_obj->name;
                      }
                  }
                  
                  $posts_sortby = $subcat['posts_order'] ?? 'latest';
                  $posts_limit = $subcat['limit'] ?? 9;
                  $posts_style = $subcat['style'] ?? 'rectangle';
                  
                  $posts_args = array(
                      'post_type'      => 'post',
                      'posts_per_page' => $posts_limit,
                  );
                  
                  switch ($posts_sortby) {
                      case 'latest':
                          $posts_args['orderby'] = 'date';
                          $posts_args['order'] = 'DESC';
                          break;
                      case 'modified':
                          $posts_args['orderby'] = 'modified';
                          $posts_args['order'] = 'DESC';
                          break;
                      case 'popular':
                          $posts_args['meta_key'] = 'px_views';
                          $posts_args['orderby'] = 'meta_value_num';
                          $posts_args['order'] = 'DESC';
                          break;
                      case 'a_to_z':
                          $posts_args['orderby'] = 'title';
                          $posts_args['order'] = 'ASC';
                          break;
                      case 'z_to_a':
                          $posts_args['orderby'] = 'title';
                          $posts_args['order'] = 'DESC';
                          break;
                      case 'oldest':
                          $posts_args['orderby'] = 'date';
                          $posts_args['order'] = 'ASC';
                          break;
                      case 'random':
                          $posts_args['orderby'] = 'rand';
                          break;
                      default:
                          $posts_args['orderby'] = 'date';
                          $posts_args['order'] = 'DESC';
                          break;
                  }
                  
                  if (!empty($subcat_term_id)) {
                      $posts_args['tax_query'] = [
                          [
                              'taxonomy' => 'category',
                              'field'    => 'term_id',
                              'terms'    => $subcat_term_id,
                          ]
                      ];
                  }
                  
                  $posts_query = new WP_Query($posts_args);
                  
                  $category_link = '#';
                  if (!empty($subcat_term_id)) {
                      $term_obj = get_term($subcat_term_id);
                      if ($term_obj && !is_wp_error($term_obj)) {
                          $category_link = get_term_link($term_obj);
                      }
                  }
                  ?>
                  <section class="mt-4">
                    <div class="flex items-center justify-between mb-2">
                      <h2 class="text-md font-bold text-slate-800 dark:text-white flex items-center gap-2">
                          <?php echo esc_html($section_title ?: 'Unknown'); ?>
                      </h2>
                      <a class="right-arrow-btn" href="<?php echo esc_url($category_link); ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                      </a>
                    </div>
                    <?php if ($posts_query->have_posts()) : ?>
                        <?php if ($posts_style === 'rectangle') : ?>
                            <div class="flex overflow-x-auto md:overflow-x-hidden no-scrollbar pb-4 w-full home-posts-carousel" id="archive-subcat-rect-<?php echo esc_attr($subcat_term_id); ?>">
                                <?php
                                while ($posts_query->have_posts()) : $posts_query->the_post();
                                    $post_id = get_the_ID();
                                    $app_name = get_the_title();
                                    $app_url = get_the_permalink();
                                    
                                    $data = get_post_meta($post_id, 'datos_informacion', true);
                                    $data = is_array($data) ? $data : [];
                                    
                                    $app_category_info = apkup_get_primary_post_category($post_id);
                                    $app_category = $app_category_info ? $app_category_info['name'] : 'App';
                                    
                                    $app_mod_info = $data['mod_info'] ?? '';
                                    $meta_desc = $app_category;
                                    if (!empty($app_mod_info)) {
                                        $meta_desc .= ' • ' . $app_mod_info;
                                    }
                                    
                                    $app_size = $data['tamano'] ?? '';
                                    $app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;
                                    
                                    $app_banner = get_post_meta($post_id, 'wp_poster_GP', true);
                                    $app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail');
                                    
                                    if (empty($app_banner)) {
                                        $app_banner = $app_logo;
                                    }
                                ?>
                                    <!-- Game Card -->
                                    <div class="flex-shrink-0 w-44 md:w-72 mr-6 post-card">
                                      <div class="relative rounded-xl overflow-hidden aspect-[16/9] mb-2 border border-slate-200/40 dark:border-white/5 shadow-md transition-shadow duration-300">
                                        <a href="<?php echo esc_url($app_url); ?>">
                                          <img alt="<?php echo esc_attr($app_name); ?>" class="w-full h-full object-cover"
                                            src="<?php echo esc_url($app_banner); ?>">
                                        </a>
                                      </div>
                                      <div class="flex items-start gap-3">
                                        <a href="<?php echo esc_url($app_url); ?>" class="shrink-0">
                                          <img class="w-12 h-12 rounded-xl object-cover border border-slate-100 dark:border-white/5 shadow-md"
                                            src="<?php echo esc_url($app_logo); ?>"
                                            alt="<?php echo esc_attr($app_name); ?> Icon">
                                        </a>
                                        <div class="min-w-0 flex-1">
                                          <a href="<?php echo esc_url($app_url); ?>">
                                            <h3 class="text-sm font-bold truncate dark:text-white transition-colors"><?php echo esc_html($app_name); ?></h3>
                                          </a>
                                          <p class="text-[10px] text-gray-400 dark:text-gray-500 truncate"><?php echo esc_html($meta_desc); ?></p>
                                          <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5">
                                            <span class="text-amber-500 dark:text-amber-400 font-bold"><?php echo esc_html(number_format((float)$app_rating, 1)); ?> ★</span>
                                            <?php if (!empty($app_size)) : ?>
                                              <span class="ml-1"><?php echo esc_html($app_size); ?></span>
                                            <?php endif; ?>
                                          </p>
                                        </div>
                                      </div>
                                    </div>
                                <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        <?php elseif ($posts_style === 'landscape') : ?>
                            <div class="flex overflow-x-auto md:overflow-x-hidden no-scrollbar pb-4 w-full home-posts-carousel" id="archive-subcat-land-<?php echo esc_attr($subcat_term_id); ?>">
                                <?php
                                while ($posts_query->have_posts()) : $posts_query->the_post();
                                    $post_id = get_the_ID();
                                    $app_name = get_the_title();
                                    $app_url = get_the_permalink();
                                    
                                    $data = get_post_meta($post_id, 'datos_informacion', true);
                                    $data = is_array($data) ? $data : [];
                                    
                                    $app_category_info = apkup_get_primary_post_category($post_id);
                                    $app_category = $app_category_info ? $app_category_info['name'] : 'App';
                                    
                                    $app_mod_info = $data['mod_info'] ?? '';
                                    $meta_desc = $app_category;
                                    if (!empty($app_mod_info)) {
                                        $meta_desc .= ' • ' . $app_mod_info;
                                    }
                                    
                                    $app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;
                                    $app_banner = get_post_meta($post_id, 'wp_poster_GP', true);
                                    $app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail');
                                    
                                    if (empty($app_banner)) {
                                        $app_banner = $app_logo;
                                    }
                                ?>
                                    <!-- Landscape Post Card -->
                                    <div class="flex flex-col w-72 mr-6 shrink-0 post-card">
                                      <a href="<?php echo esc_url($app_url); ?>" class="overflow-hidden rounded-xl mb-2 block shadow-md transition-shadow duration-300 border border-slate-100 dark:border-white/5">
                                        <img class="w-full aspect-video object-cover"
                                          src="<?php echo esc_url($app_banner); ?>"
                                          alt="<?php echo esc_attr($app_name); ?>">
                                      </a>
                                      <a href="<?php echo esc_url($app_url); ?>" class="transition-colors">
                                        <h3 class="text-[11px] font-bold leading-tight dark:text-white"><?php echo esc_html($app_name); ?></h3>
                                      </a>
                                      <p class="text-[9px] text-gray-400 dark:text-gray-500 mt-0.5"><?php echo esc_html($meta_desc); ?></p>
                                      <p class="text-[9px] text-gray-400 dark:text-gray-500 mt-0.5">
                                        <span class="text-amber-500 dark:text-amber-400 font-bold"><?php echo esc_html(number_format((float)$app_rating, 1)); ?> ★</span>
                                      </p>
                                    </div>
                                <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        <?php else : ?>
                            <div class="flex overflow-x-auto md:overflow-x-hidden no-scrollbar pb-4 w-full home-posts-carousel" id="archive-subcat-box-<?php echo esc_attr($subcat_term_id); ?>">
                                <?php
                                while ($posts_query->have_posts()) : $posts_query->the_post();
                                    $post_id = get_the_ID();
                                    $app_name = get_the_title();
                                    $app_url = get_the_permalink();
                                    
                                    $data = get_post_meta($post_id, 'datos_informacion', true);
                                    $data = is_array($data) ? $data : [];
                                    
                                    $app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;
                                    $app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail');
                                    
                                    $is_app_mod = get_post_meta($post_id, 'app_type', true);
                                    $badge_text = ($is_app_mod == '1') ? 'MOD' : get_the_modified_date('Y');
                                ?>
                                    <!-- App Card Style 2 (Icon Layout) -->
                                    <div class="flex-shrink-0 w-16 md:w-20 mr-6 text-center flex flex-col gap-1 items-center post-card">
                                      <div class="relative shrink-0 pt-1.5 pr-1.5">
                                        <a href="<?php echo esc_url($app_url); ?>">
                                          <img alt="<?php echo esc_attr($app_name); ?>" class="w-16 h-16 rounded-2xl shadow-md transition-shadow duration-300 mb-1 object-cover border border-slate-100 dark:border-white/5" src="<?php echo esc_url($app_logo); ?>">
                                        </a>
                                        <?php if (!empty($badge_text)) : ?>
                                          <span class="absolute top-0.5 right-0.5 bg-orange-500 text-white text-[8px] px-1.5 py-0.5 rounded-full font-bold select-none pointer-events-none"><?php echo esc_html($badge_text); ?></span>
                                        <?php endif; ?>
                                      </div>
                                      <a href="<?php echo esc_url($app_url); ?>" class="transition-colors">
                                        <h3 class="text-[10px] font-medium leading-tight mb-1 min-h-[24px] line-clamp-2 dark:text-white"><?php echo esc_html($app_name); ?></h3>
                                      </a>
                                      <p class="text-[10px] text-gray-400 dark:text-gray-500 leading-none">
                                        <span class="text-amber-500 dark:text-amber-400 font-bold"><?php echo esc_html(number_format((float)$app_rating, 1)); ?> ★</span>
                                      </p>
                                    </div>
                                <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="bg-primary/10 dark:bg-gray-800 text-black dark:text-white px-8 py-4 text-lg text-center">No Posts Found!</div>
                    <?php endif; ?>
                  </section>
              <?php
              }
          }
          ?>
        </div>

        <!-- ==================== VIEW 2: RESULTS CATALOG GRID ==================== -->
        <div id="single-grid-section" class="flex-col gap-6 <?php echo $is_parent_category ? 'hidden' : 'flex'; ?>">
          <div id="catalog-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 <?php echo ($archive_sidebar_swt === '1') ? '' : 'lg:grid-cols-5 xl:grid-cols-6'; ?> gap-4 sm:gap-6">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    $post_id = get_the_ID();
                    $app_url = get_the_permalink($post_id);
                    $app_name = get_the_title();
                    $app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail');
                    if (empty($app_logo)) {
                        $app_logo = 'https://placehold.co/150x150/0052e0/ffffff?text=App';
                    }
                    $app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: '4.2';
                    $data = get_post_meta($post_id, 'datos_informacion', true);
                    $data = is_array($data) ? $data : [];
                    $app_size = $data['tamano'] ?? '45 MB';
                    $app_version = $data['version'] ?? '1.0';
                    
                    // App type tag (MOD, Gratis, Pro, etc.)
                    $is_app_mod = get_post_meta($post_id, 'app_type', true);
                    $app_tag = 'APK';
                    $tag_bg = 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400';
                    if ($is_app_mod == 1) {
                        $app_tag = 'MOD';
                        $tag_bg = 'bg-emerald-100/80 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400';
                    }
                    
                    // Determine item type and category slug
                    $post_categories = get_the_category();
                    $item_type = 'apps';
                    $item_cat_slug = 'all';
                    foreach ($post_categories as $c) {
                        $slug = strtolower($c->slug);
                        if (in_array($slug, ['games', 'juegos', 'game', 'juego'])) {
                            $item_type = 'games';
                        }
                        if ($c->parent != 0) {
                            $item_cat_slug = $slug;
                        }
                    }
                    if ($item_cat_slug === 'all' && !empty($post_categories)) {
                        $item_cat_slug = $post_categories[0]->slug;
                    }
                    $primary_cat_name = !empty($post_categories) ? $post_categories[0]->name : 'Apps';
                    ?>
                    <article data-item-type="<?php echo esc_attr($item_type); ?>" data-item-category="<?php echo esc_attr($item_cat_slug); ?>" class="glass-card p-4 rounded-[24px] flex flex-col justify-between relative border border-slate-200/50 dark:border-white/5">
                      <div class="flex items-center justify-between mb-3">
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-md <?php echo esc_attr($tag_bg); ?>"><?php echo esc_html($app_tag); ?></span>
                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-light">v<?php echo esc_html($app_version); ?></span>
                      </div>
                      <div class="flex flex-col items-center text-center flex-grow">
                        <div class="w-18 h-18 squircle-icon-medium bg-slate-100 dark:bg-slate-800 overflow-hidden shadow-md mb-3 relative">
                          <img src="<?php echo esc_url($app_logo); ?>" alt="<?php echo esc_attr($app_name); ?>" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-xs text-slate-800 dark:text-white line-clamp-1 transition-colors">
                          <?php echo esc_html($app_name); ?>
                        </h3>
                        <p class="text-[10px] text-slate-400 mt-1"><?php echo esc_html($primary_cat_name); ?> • <?php echo esc_html($app_size); ?></p>
                        <div class="flex items-center gap-1 mt-1 justify-center">
                          <span class="text-amber-500 text-[10px]">★</span>
                          <span class="text-slate-400 dark:text-slate-500 text-[10px] font-medium"><?php echo esc_html(number_format((float)$app_rating, 1)); ?></span>
                        </div>
                      </div>
                      <div class="mt-4">
                        <a class="w-full py-1.5 bg-slate-100 hover:bg-primary hover:text-white dark:bg-slate-800 dark:hover:bg-primary text-slate-700 dark:text-slate-400 transition-all text-xs font-semibold rounded-full block text-center" href="<?php echo esc_url($app_url); ?>">Obtener</a>
                      </div>
                    </article>
                <?php
                endwhile;
            else :
                ?>
                <div class="col-span-full py-12 text-center text-slate-500 dark:text-slate-400 font-light">
                    No se encontraron aplicaciones o juegos.
                </div>
            <?php endif; ?>
          </div>

          <!-- Pagination -->
          <div class="mt-4 flex justify-center">
            <?php
            global $wp_query;
            if ($wp_query->max_num_pages > 1 && function_exists('apkup_pagination')) {
                $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
                $total_pages = $wp_query->max_num_pages;
                echo apkup_pagination($current_page, $total_pages);
            }
            ?>
          </div>
        </div>
      </section>

      <?php if ($archive_sidebar_swt === '1') : ?>
      <!-- Right Column: Sidebar (Width: 1/4) -->
      <aside class="w-full lg:w-1/4 flex flex-col gap-6">

        <!-- Sidebar Widget: Top Populares -->
        <div class="glass-card p-6 rounded-[28px] border border-slate-200/50 dark:border-white/5 space-y-4">
          <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">
            <?php esc_html_e('Más Populares', 'apktemplates'); ?>
          </h3>
          
          <div class="flex flex-col gap-4">
            <?php
            $sidebar_args = [
                'post_type'      => 'post',
                'posts_per_page' => 5,
                'meta_key'       => 'px_views',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
            ];
            $sidebar_query = new WP_Query($sidebar_args);
            $rank = 1;
            if ($sidebar_query->have_posts()) :
                while ($sidebar_query->have_posts()) : $sidebar_query->the_post();
                    $s_id = get_the_ID();
                    $s_logo = get_the_post_thumbnail_url($s_id, 'thumbnail');
                    if (empty($s_logo)) {
                        $s_logo = 'https://placehold.co/150x150/0052e0/ffffff?text=App';
                    }
                    $s_rating = get_post_meta($s_id, 'new_rating_average', true) ?: '4.2';
                    $s_data = get_post_meta($s_id, 'datos_informacion', true);
                    $s_size = !empty($s_data['tamano']) ? $s_data['tamano'] : '45 MB';
                    ?>
                    <article class="flex items-center gap-3 group relative">
                      <div class="w-11 h-11 squircle-icon-medium bg-slate-100 dark:bg-slate-800 overflow-hidden shadow-sm shrink-0">
                        <img src="<?php echo esc_url($s_logo); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-200">
                      </div>
                      <div class="min-w-0 flex-1">
                        <h4 class="text-xs font-bold text-slate-855 dark:text-slate-200 truncate group-hover:text-primary transition-colors">
                          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <p class="text-[10px] text-slate-400 mt-0.5"><?php echo esc_html($s_size); ?> • <span class="text-amber-500 dark:text-amber-400 font-bold"><?php echo esc_html($s_rating); ?> ★</span></p>
                      </div>
                      <span class="text-xs font-bold text-slate-350 dark:text-slate-650">#<?php echo $rank; ?></span>
                    </article>
                    <?php
                    $rank++;
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
          </div>
        </div>
      </aside>
      <?php endif; ?>

    </div>
    <?php archive_bottom_ad('div', 'my-4'); ?>
</main>

<script>
let currentCategory = 'all';

function filterCategory(catSlug, btnEl) {
    // Toggle active state for chips
    document.querySelectorAll('.category-chip').forEach(btn => {
        btn.classList.remove('ring-2', 'ring-primary', 'bg-slate-200', 'dark:bg-slate-800');
    });
    
    if (btnEl) {
        btnEl.classList.add('ring-2', 'ring-primary', 'bg-slate-200', 'dark:bg-slate-800');
    }
    
    currentCategory = catSlug;
    applyFilters();
}

function clearCategoryFilter() {
    filterCategory('all', document.getElementById('chip-all'));
}

function applyFilters() {
    const articles = document.querySelectorAll('#catalog-grid article');
    let visibleCount = 0;
    
    articles.forEach(art => {
        const cat = art.getAttribute('data-item-category');
        const matchesCat = (currentCategory === 'all') || (cat === currentCategory);
        
        if (matchesCat) {
            art.style.display = 'flex';
            visibleCount++;
        } else {
            art.style.display = 'none';
        }
    });

    // Dynamic visibility swap for parent categories between multi-layout view and catalog grid view
    const multiLayoutEl = document.getElementById('multi-layout-sections');
    const singleGridEl = document.getElementById('single-grid-section');
    
    <?php if ($is_parent_category) : ?>
    if (currentCategory === 'all') {
        if (multiLayoutEl) multiLayoutEl.classList.remove('hidden');
        if (singleGridEl) singleGridEl.classList.add('hidden');
    } else {
        if (multiLayoutEl) multiLayoutEl.classList.add('hidden');
        if (singleGridEl) {
            singleGridEl.classList.remove('hidden');
            singleGridEl.classList.add('flex');
        }
    }
    <?php endif; ?>
    
    const noResults = document.getElementById('no-results-msg');
    if (visibleCount === 0) {
        if (!noResults) {
            const msg = document.createElement('div');
            msg.id = 'no-results-msg';
            msg.className = 'col-span-full py-12 text-center text-slate-500 dark:text-slate-400 font-light';
            msg.innerText = 'No se encontraron aplicaciones o juegos.';
            document.getElementById('catalog-grid').appendChild(msg);
        }
    } else if (noResults) {
        noResults.remove();
    }
}

// Initial filter execution
document.addEventListener("DOMContentLoaded", () => {
    applyFilters();
});
</script>
<?php
if ($is_cacheable) {
    $cached_content = ob_get_clean();
    set_transient($transient_key, $cached_content, HOUR_IN_SECONDS * $site_cache_time);
    echo $cached_content;
}
get_footer();
?>