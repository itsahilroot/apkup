<?php
$au_home_trending_swt = get_theme_mod('au_home_trending_swt', true);

if (!$au_home_trending_swt) {
    return;
}

$limit = get_theme_mod('au_home_trending_limit', 12); // Default to 12 for 4x3 grid layout
$sort = get_theme_mod('au_home_trending_sort', 'popular');
$term_id = get_theme_mod('au_home_trending_term_id', '');
$title = get_theme_mod('au_home_trending_title', 'Tendencias');

$args = array(
    'post_type'           => 'post',
    'posts_per_page'      => $limit,
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
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
    case 'random':
        $args['orderby'] = 'rand';
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
        
        $today_start = strtotime('today', $current_time);
        $yesterday_start = strtotime('yesterday', $current_time);
        
        if ($post_time >= $today_start) {
            return 'Actualizado hoy';
        } elseif ($post_time >= $yesterday_start) {
            return 'Ayer';
        }
        
        $days = floor($diff / 86400);
        if ($days < 7) {
            $days = max(1, $days);
            return 'Hace ' . $days . ' ' . _n('día', 'días', $days, 'apktemplates');
        } elseif ($days < 30) {
            $weeks = floor($days / 7);
            return 'Hace ' . $weeks . ' ' . _n('semana', 'semanas', $weeks, 'apktemplates');
        } else {
            $months = floor($days / 30);
            return 'Hace ' . $months . ' ' . _n('mes', 'meses', $months, 'apktemplates');
        }
    }
}
?>

<?php if ($trending_query->have_posts()) : ?>
<section class="mt-4" data-purpose="actualizaciones-list">
  <div class="flex items-center justify-between mb-2">
    <h2 class="text-lg font-bold dark:text-white"><?php echo esc_html($title); ?></h2>
    <a class="right-arrow-btn" href="<?php echo esc_url(home_url('/trending/')); ?>">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
      </svg>
    </a>
  </div>
  <div
    class="grid grid-flow-col auto-cols-[100%] grid-rows-4 gap-2 overflow-x-auto md:grid-flow-row md:grid-cols-3 md:grid-rows-none md:auto-cols-auto md:gap-x-6 md:gap-y-3 scrollbar-hide">

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
        
        $app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;
        $app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail') ?: get_the_post_thumbnail_url($post_id, 'full');
        $app_desc = apkup_get_post_short_description($post_id);
        $app_mod_info = $data['mod_info'] ?? '';
        
        $time_pretty = apkup_get_relative_time_spanish(get_post_modified_time('U', false, $post_id));
    ?>
        <!-- Item: <?php echo esc_html($app_name); ?> -->
        <div class="flex items-start gap-3 py-2 rounded-2xl post-card">
          <img
            src="<?php echo esc_url($app_logo); ?>"
            alt="<?php echo esc_attr($app_name); ?> Icon"
            width="52"
            height="52"
            loading="lazy"
            decoding="async"
            class="w-13 h-13 rounded-2xl shadow-sm border border-slate-100 dark:border-white/5 shrink-0 bg-slate-100 dark:bg-slate-800 object-cover aspect-square">
          <div class="flex-1 min-w-0">
            <a href="<?php echo esc_url($app_url); ?>">
              <h3 class="font-bold text-sm truncate dark:text-white hover:text-primary dark:hover:text-primary transition-colors"><?php echo esc_html($app_name); ?></h3>
            </a>
            <p class="text-gray-500 dark:text-gray-400 text-xs mt-0.5 line-clamp-2"><?php echo esc_html($app_desc); ?></p>
            <div class="flex items-center gap-2 mt-1">
              <span class="text-[10px] text-amber-500 font-semibold"><?php echo esc_html(number_format((float)$app_rating, 1)); ?> ★</span>
              <?php if (!empty($app_size)) : ?>
                <span class="text-[10px] text-gray-400 dark:text-gray-500"><?php echo esc_html($app_size); ?></span>
              <?php endif; ?>
              <?php if ($is_mod) : ?>
                <span class="text-[10px] bg-green-500 text-white font-bold px-1 rounded">MOD</span>
              <?php endif; ?>
              <?php if ($is_mod && !empty($app_mod_info)) : ?>
                <span class="text-[10px] text-gray-400 dark:text-gray-500"><?php echo esc_html($app_mod_info); ?></span>
              <?php else : ?>
                <span class="text-[10px] text-gray-400 dark:text-gray-500"><?php echo esc_html($time_pretty); ?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>
    <?php
    endwhile;
    wp_reset_postdata();
    ?>

  </div>
</section>
<?php endif; ?>