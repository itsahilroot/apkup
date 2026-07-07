<?php get_header(); ?>
<main class="max-w-md md:max-w-3xl lg:max-w-7xl mx-auto pb-10 sm:px-6 lg:px-8 mt-6 px-4">

    <!-- Breadcrumbs Section -->
    <nav class="flex items-center gap-2 text-xs text-slate-400 dark:text-slate-500 mb-6 font-light" aria-label="Breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary transition-colors">Inicio</a>
      <span class="text-slate-300 dark:text-slate-700">/</span>
      <span class="text-slate-600 dark:text-slate-300 font-normal">Búsqueda</span>
    </nav>

    <!-- Page Intro Header Banner -->
    <header class="glass-card p-6 sm:p-8 rounded-[28px] border border-slate-200/50 dark:border-white/5 mb-8 relative overflow-hidden">
      <!-- Decorative Gradient Glow background -->
      <div class="absolute -right-16 -top-16 w-48 h-48 rounded-full bg-primary/10 blur-3xl pointer-events-none"></div>

      <div class="relative z-10 max-w-2xl">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight">
          <?php printf(__('Resultados para: "%s"', 'apktemplates'), get_search_query()); ?>
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-light">
          <?php 
          global $wp_query;
          printf(__('Hemos encontrado %s resultados que coinciden con tu búsqueda.', 'apktemplates'), $wp_query->found_posts); 
          ?>
        </p>
      </div>
    </header>

    <!-- Results Catalog Grid -->
    <section class="mb-8">
        <?php if (have_posts()) : ?>
            <div id="catalog-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 sm:gap-6">
                <?php
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
                    $tag_bg = 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-350';
                    if ($is_app_mod == 1) {
                        $app_tag = 'MOD';
                        $tag_bg = 'bg-emerald-100/80 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400';
                    }
                    
                    // Determine item type and category slug
                    $post_categories = get_the_category();
                    $primary_cat_name = !empty($post_categories) ? $post_categories[0]->name : 'Apps';
                    ?>
                    <article class="glass-card p-4 rounded-[24px] flex flex-col justify-between group relative border border-slate-200/50 dark:border-white/5">
                      <div class="flex items-center justify-between mb-3">
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-md <?php echo esc_attr($tag_bg); ?>"><?php echo esc_html($app_tag); ?></span>
                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-light">v<?php echo esc_html($app_version); ?></span>
                      </div>
                      
                      <!-- Icon & Title Flex wrapper -->
                      <div class="flex flex-col items-center text-center">
                        <a href="<?php echo esc_url($app_url); ?>" class="block relative w-20 h-20 rounded-2xl overflow-hidden shadow-sm border border-slate-100 dark:border-white/5 mb-3">
                          <img src="<?php echo esc_url($app_logo); ?>" alt="<?php echo esc_attr($app_name); ?> Logo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" width="80" height="80">
                        </a>
                        <a href="<?php echo esc_url($app_url); ?>" class="block w-full">
                          <h3 class="text-xs font-bold text-slate-800 dark:text-white truncate px-1 group-hover:text-primary transition-colors"><?php echo esc_html($app_name); ?></h3>
                        </a>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-light mt-0.5"><?php echo esc_html($primary_cat_name); ?></p>
                      </div>

                      <div class="flex items-center justify-between border-t border-slate-100 dark:border-white/5 mt-4 pt-3 text-[10px]">
                        <div class="flex items-center gap-1 font-semibold text-slate-700 dark:text-slate-350">
                          <span class="text-amber-500">★</span>
                          <span><?php echo esc_html($app_rating); ?></span>
                        </div>
                        <span class="text-slate-400 dark:text-slate-500 font-light"><?php echo esc_html($app_size); ?></span>
                      </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <div class="text-center py-16 px-4 glass-card rounded-[28px] border border-slate-200/50 dark:border-white/5">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-850 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-400 dark:text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-x"><path d="m13.5 8.5-5 5"/><path d="m8.5 8.5 5 5"/><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white"><?php _e('No se encontraron resultados', 'apktemplates'); ?></h3>
                <p class="text-sm text-slate-400 dark:text-slate-500 max-w-sm mx-auto mt-2 leading-relaxed font-light">
                    <?php _e('Lo sentimos, no encontramos ningún resultado para tu búsqueda. Inténtalo de nuevo con palabras clave diferentes.', 'apktemplates'); ?>
                </p>
                <div class="mt-6 max-w-md mx-auto">
                    <form method="GET" action="<?php echo esc_url(home_url('/')); ?>" class="flex items-center bg-slate-50 dark:bg-slate-850/50 border border-slate-200/50 dark:border-white/5 rounded-2xl p-1.5 pl-4 focus-within:ring-2 focus-within:ring-primary/20">
                        <input type="text" name="s" placeholder="Buscar de nuevo..." class="w-full bg-transparent border-none focus:outline-none focus:ring-0 text-slate-800 dark:text-slate-100 placeholder-slate-400 text-sm">
                        <button type="submit" class="px-5 py-2.5 bg-primary text-white text-xs font-semibold rounded-xl hover:bg-primary/95 transition-all">Buscar</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <!-- Pagination Section -->
    <section class="mt-10">
        <?php
        $current_page = max(1, get_query_var('paged'));
        $total_pages  = $wp_query->max_num_pages;

        if ($total_pages > 1 && function_exists('apkup_pagination')) {
            echo apkup_pagination($current_page, $total_pages);
        }
        ?>
    </section>
</main>
<?php get_footer(); ?>