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
    case 'random':
        $args['orderby'] = 'rand';
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
        $data = is_array($data) ? $data : [];
        $app_size = $data['tamano'] ?? 'N/A';
        $app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;
        $app_category = apkup_get_primary_category_name($post_id);
        
        $is_app_mod = get_post_meta($post_id, 'app_type', true);
        $app_mod_info = $data['mod_info'] ?? '';
        $is_mod = ($is_app_mod === 'mod' || !empty($app_mod_info));
        
        $app_banner = get_post_meta($post_id, 'wp_poster_GP', true);
        $app_logo   = get_the_post_thumbnail_url($post_id, 'thumbnail');
        
        if (empty($app_banner)) {
            $app_banner = $app_logo;
        }
    ?>
        <!-- Card: <?php echo esc_html($app_name); ?> -->
        <div class="flex-shrink-0 w-72 mr-6 group/card">
          <!-- Outer Shadow Wrapper: holds the strong shadow by default without hover translate/zoom -->
          <div class="rounded-[18px] mb-3.5 shadow-[0_12px_32px_rgba(0,0,0,0.12)] dark:shadow-[0_12px_38px_rgba(0,0,0,0.55)]">
            <!-- Inner Clip Container (overflow-hidden) -->
            <div class="relative aspect-video rounded-[18px] overflow-hidden border border-slate-200/50 dark:border-white/5">
              <a href="<?php echo esc_url($app_url); ?>" class="block w-full h-full">
                
                <img
                  src="<?php echo esc_url($app_banner); ?>"
                  alt="<?php echo esc_attr($app_name); ?>" 
                  class="w-full h-full object-cover">
                <!-- Soft gradient vignette overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/15 via-transparent to-transparent pointer-events-none"></div>
              </a>
            </div>
          </div>
          
          <!-- Card Info & Action -->
          <div class="flex items-center justify-between gap-2 px-1">
            <div class="flex items-center gap-3 min-w-0">
              <!-- Logo with premium shadow and border -->
              <img
                src="<?php echo esc_url($app_logo); ?>"
                alt="<?php echo esc_attr($app_name); ?> Icon" 
                class="w-12 h-12 rounded-[14px] shadow-[0_6px_16px_rgba(0,0,0,0.1)] dark:shadow-[0_6px_18px_rgba(0,0,0,0.4)] border border-slate-100 dark:border-white/5 shrink-0">
              <div class="min-w-0">
                <a href="<?php echo esc_url($app_url); ?>">
                  <h4 class="font-semibold text-sm truncate dark:text-white hover:text-primary dark:hover:text-primary transition-colors"><?php echo esc_html($app_name); ?></h4>
                </a>
                <div class="flex items-center gap-1.5 mt-0.5">
                  <span class="text-gray-500 dark:text-gray-400 text-xs"><?php echo esc_html($app_category); ?></span>
                  <?php if ($is_mod) : ?>
                    <span class="bg-green-500 text-white px-1.5 py-0.5 rounded-full text-[8px] font-bold flex items-center gap-1 uppercase tracking-wider leading-none">
                        <span class="w-1 h-1 rounded-full bg-white relative flex">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1 w-1 bg-white"></span>
                        </span>
                        MOD
                    </span>
                  <?php endif; ?>
                </div>
                <div class="flex flex-wrap items-center gap-x-1.5 gap-y-0.5 mt-1">
                  <!-- Gold Star Badge -->
                  <span class="text-amber-500 text-[10px] font-semibold flex items-center gap-0.5">
                    <svg class="w-2.5 h-2.5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    <?php echo esc_html(number_format((float) $app_rating, 1)); ?>
                  </span>
                  <span class="text-gray-300 dark:text-gray-700 text-[8px]">•</span>
                  <span class="text-gray-500 dark:text-gray-400 text-[10px] whitespace-nowrap font-medium"><?php echo esc_html($app_size); ?></span>
                </div>
              </div>
            </div>
            <!-- Premium button with hover background color transition only -->
            <a href="<?php echo esc_url($app_url); ?>"
              class="bg-primary text-white px-4.5 py-1.5 rounded-full text-xs font-semibold hover:bg-blue-600 transition-colors shrink-0 shadow-[0_4px_12px_rgba(26,115,232,0.18)] dark:shadow-[0_4px_12px_rgba(26,115,232,0.3)]">Instalar</a>
          </div>
        </div>
    <?php
    endwhile;
    wp_reset_postdata();
    ?>

  </div>
</section>

<?php endif; ?>