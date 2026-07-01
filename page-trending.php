<?php
/**
 * Template Name: Trending Template
 */
get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$limit = 12; // 12 items per page

$sort = get_theme_mod('au_home_trending_sort', 'popular');
$term_id = get_theme_mod('au_home_trending_term_id', '');
$title = get_theme_mod('au_home_trending_title', 'Tendencias');

$args = array(
    'post_type'           => 'post',
    'posts_per_page'      => $limit,
    'paged'               => $paged,
    'ignore_sticky_posts' => true,
);

// Sorting Logic
switch ($sort) {
    case 'latest':
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
        break;
    case 'popular':
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = 'px_views';
        $args['order'] = 'DESC';
        break;
    case 'a_to_z':
        $args['orderby'] = 'title';
        $args['order'] = 'ASC';
        break;
    case 'z_to_a':
        $args['orderby'] = 'title';
        $args['order'] = 'DESC';
        break;
    case 'modified':
        $args['orderby'] = 'modified';
        $args['order'] = 'DESC';
        break;
    default:
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = 'px_views';
        $args['order'] = 'DESC';
        break;
}

// Filter Logic
if (!empty($term_id)) {
    $term = get_term($term_id);
    if ($term && !is_wp_error($term)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $term->taxonomy,
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        );
    }
}

$trending_query = new WP_Query($args);

if (!function_exists('apkup_get_relative_time_spanish')) {
    function apkup_get_relative_time_spanish($post_time) {
        $current_time = current_time('timestamp');
        $diff = $current_time - $post_time;

        if ($diff < 86400 && date('Ymd', $post_time) === date('Ymd', $current_time)) {
            return 'Hoy';
        } elseif ($diff < 172800 && date('Ymd', $post_time) === date('Ymd', strtotime('yesterday', $current_time))) {
            return 'Ayer';
        } else {
            $days = round($diff / 86400);
            if ($days <= 0) {
                $days = 1;
            }
            return 'Hace ' . $days . ' ' . _n('día', 'días', $days, 'apktemplates');
        }
    }
}
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-6">
    <!-- Breadcrumbs Section -->
    <nav class="flex items-center gap-2 text-xs text-slate-400 dark:text-slate-500 mb-6 font-light" aria-label="Breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary transition-colors">Inicio</a>
      <span class="text-slate-300 dark:text-slate-700">/</span>
      <span class="text-slate-600 dark:text-slate-300 font-normal"><?php echo esc_html($title); ?></span>
    </nav>

    <!-- Header Banner -->
    <header class="glass-card p-6 sm:p-8 rounded-[28px] border border-slate-200/50 dark:border-white/5 mb-8 relative overflow-hidden">
      <div class="absolute -right-16 -top-16 w-48 h-48 rounded-full bg-primary/10 blur-3xl pointer-events-none"></div>
      <div class="relative z-10 max-w-2xl">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight">
          <?php echo esc_html($title); ?>
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-light">
          Descubre las aplicaciones y juegos más populares y con mayor tendencia del momento.
        </p>
      </div>
    </header>

    <?php if ($trending_query->have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4">
            <?php
            while ($trending_query->have_posts()) : $trending_query->the_post();
                $post_id = get_the_ID();
                $app_name = get_the_title($post_id);
                $app_url = get_the_permalink($post_id);
                
                $data = get_post_meta($post_id, 'datos_informacion', true);
                $data = is_array($data) ? $data : [];
                $app_size = $data['tamano'] ?? '';
                $app_type = get_post_meta($post_id, 'app_type', true);
                $is_mod = ($app_type == 1);
                $app_mod_info = $data['mod_info'] ?? '';
                
                $app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;
                $app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail') ?: get_the_post_thumbnail_url($post_id, 'full');
                $app_desc = apkup_get_post_short_description($post_id);
                
                $time_pretty = apkup_get_relative_time_spanish(get_the_time('U'));
            ?>
                <!-- Item: <?php echo esc_html($app_name); ?> -->
                <div class="flex items-start gap-3 py-3 px-4 rounded-2xl post-card glass-card hover:shadow-md transition-shadow">
                  <img alt="<?php echo esc_attr($app_name); ?>" class="w-14 h-14 rounded-xl shrink-0 object-cover"
                    src="<?php echo esc_url($app_logo); ?>">
                  <div class="flex-1 min-w-0">
                    <a href="<?php echo esc_url($app_url); ?>">
                      <h3 class="font-bold text-sm truncate dark:text-white hover:text-primary dark:hover:text-primary transition-colors"><?php echo esc_html($app_name); ?></h3>
                    </a>
                    <p class="text-gray-500 dark:text-gray-400 text-xs mt-0.5 line-clamp-2"><?php echo esc_html($app_desc); ?></p>
                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                      <span class="text-[10px] text-gray-400 dark:text-gray-500"><?php echo esc_html(number_format((float)$app_rating, 1)); ?> ★</span>
                      <?php if (!empty($app_size)) : ?>
                        <span class="text-[10px] text-gray-400 dark:text-gray-500"><?php echo esc_html($app_size); ?></span>
                      <?php endif; ?>
                      <?php if ($is_mod) : ?>
                        <span class="text-[10px] bg-green-500 text-white font-bold px-1 rounded">MOD</span>
                      <?php endif; ?>
                      <?php if ($is_mod && !empty($app_mod_info)) : ?>
                        <span class="text-[10px] text-gray-400 dark:text-gray-500 truncate max-w-[100px]"><?php echo esc_html($app_mod_info); ?></span>
                      <?php else : ?>
                        <span class="text-[10px] text-gray-400 dark:text-gray-500"><?php echo esc_html($time_pretty); ?></span>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
            <?php
            endwhile;
            ?>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
          <?php
          if ($trending_query->max_num_pages > 1 && function_exists('apkup_pagination')) {
              echo apkup_pagination($paged, $trending_query->max_num_pages);
          }
          ?>
        </div>
    <?php
    else :
    ?>
        <div class="py-12 text-center text-slate-500 dark:text-slate-400 font-light bg-slate-100 dark:bg-slate-800 rounded-2xl">
            No se encontraron aplicaciones o juegos.
        </div>
    <?php
    endif;
    wp_reset_postdata();
    ?>
</main>

<?php
get_footer();
