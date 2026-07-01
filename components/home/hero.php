<?php
$au_home_hero_swt = get_theme_mod('au_home_hero_swt', true);

if (!$au_home_hero_swt) {
    return;
}

$limit = get_theme_mod('au_home_hero_limit', 4);
$sort = get_theme_mod('au_home_hero_sort', 'modified');
$term_id = get_theme_mod('au_home_hero_term_id', '');

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
        $args['meta_key'] = 'post_views_count';
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
    default:
        $args['orderby'] = 'modified';
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

$recently_updated_query = new WP_Query($args);
$hero_title = get_theme_mod('au_home_hero_title', 'Últimas actualizaciones');
?>

<?php if ($recently_updated_query->have_posts()) : ?>
<section class="mt-6 md:px-0">
  <h2 class="text-lg font-bold mb-4 dark:text-white"><?php echo esc_html($hero_title); ?></h2>
  <div
    class="flex overflow-x-auto md:overflow-x-hidden no-scrollbar pb-4 w-full" id="heroFlickityGallery">
    
    <?php
    while ($recently_updated_query->have_posts()) :
        $recently_updated_query->the_post();
        $post_id = get_the_ID();
        $app_name = get_the_title();
        $app_url = get_the_permalink();
        
        $data = get_post_meta($post_id, 'datos_informacion', true);
        $app_size = $data['tamano'] ?? 'N/A';
        $app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;
        $app_category = apkup_get_primary_category_name($post_id);
        
        $app_banner = get_post_meta($post_id, 'wp_poster_GP', true);
        $app_logo   = get_the_post_thumbnail_url($post_id, 'thumbnail');
        
        if (empty($app_banner)) {
            $app_banner = $app_logo;
        }
    ?>
        <!-- Card: <?php echo esc_html($app_name); ?> -->
        <div class="flex-shrink-0 w-72 mr-6">
          <div class="relative aspect-video rounded-xl overflow-hidden mb-3">
            <img
              src="<?php echo esc_url($app_banner); ?>"
              alt="<?php echo esc_attr($app_name); ?>" class="w-full h-full object-cover">
          </div>
          <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-3 min-w-0">
              <img
                src="<?php echo esc_url($app_logo); ?>"
                alt="<?php echo esc_attr($app_name); ?> Icon" class="w-12 h-12 rounded-xl shadow-sm shrink-0">
              <div class="min-w-0">
                <a href="<?php echo esc_url($app_url); ?>">
                  <h4 class="font-semibold text-sm truncate dark:text-white hover:text-primary dark:hover:text-primary transition-colors"><?php echo esc_html($app_name); ?></h4>
                </a>
                <p class="text-gray-500 dark:text-gray-400 text-xs"><?php echo esc_html($app_category); ?></p>
                <div class="flex flex-wrap items-center gap-x-1 gap-y-0.5 mt-0.5">
                  <span class="text-gray-500 dark:text-gray-400 text-[10px] whitespace-nowrap"><?php echo esc_html(number_format((float) $app_rating, 1)); ?> ★</span>
                  <span class="text-gray-400 dark:text-gray-600 text-[10px]">•</span>
                  <span class="text-gray-500 dark:text-gray-400 text-[10px] whitespace-nowrap"><?php echo esc_html($app_size); ?></span>
                </div>
              </div>
            </div>
            <a href="<?php echo esc_url($app_url); ?>"
              class="bg-[#1a73e8] text-white px-4 py-1.5 rounded-full text-sm font-medium hover:bg-blue-600 transition-colors shrink-0">Instalar</a>
          </div>
        </div>
    <?php
    endwhile;
    wp_reset_postdata();
    ?>

  </div>
</section>

<?php endif; ?>