<?php
$au_home_premium_swt = get_theme_mod('au_home_premium_swt', false);

if (!$au_home_premium_swt) {
    return;
}

$limit = get_theme_mod('au_home_premium_limit', 10);
$sort = get_theme_mod('au_home_premium_sort', 'modified');
$term_id = get_theme_mod('au_home_premium_term_id', '');
$title = get_theme_mod('au_home_premium_title', 'Juegos Populares Baratos / Premium Gratis');

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

$premium_query = new WP_Query($args);
?>

<?php if ($premium_query->have_posts()) : ?>
    <section class="mt-4">
      <div class="flex items-center justify-between mb-2">
        <h2 class="text-lg font-bold dark:text-white"><?php echo esc_html($title); ?></h2>
        <?php 
            $view_all_link = '#';
            if (!empty($term_id)) {
                $term = get_term((int)$term_id);
                if ($term && !is_wp_error($term)) {
                    $view_all_link = get_term_link($term);
                }
            } 
        ?>
        <a class="right-arrow-btn" href="<?php echo esc_url($view_all_link); ?>">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
          </svg>
        </a>
      </div>

      <!-- Grilla horizontal de squircles supercurvados con precio S/ tachados -->
      <div class="flex overflow-x-auto md:overflow-x-hidden pb-4 no-scrollbar home-posts-carousel" id="premiumFlickityGallery">
          <?php
          while ($premium_query->have_posts()) : $premium_query->the_post();
              $post_id = get_the_ID();
              $app_name = get_the_title();
              $app_url = get_the_permalink();
              
              $data = get_post_meta($post_id, 'datos_informacion', true);
              $data = is_array($data) ? $data : [];
              
              $app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail');
              
              // Pricing text logic
              $price_type = $data['offer']['price'] ?? 'gratis';
              $price_amount = $data['offer']['amount'] ?? '';
              $price_currency = $data['offer']['currency'] ?? 'PEN';
              
              $currency_symbol = ($price_currency === 'PEN') ? 'S/' : (($price_currency === 'USD') ? '$' : $price_currency);
              
              if (!empty($price_amount) && $price_amount != '0') {
                  $old_price_text = $currency_symbol . ' ' . number_format((float)$price_amount, 2);
              } else {
                  // Consistent pseudo-random price based on post ID
                  $seed = $post_id;
                  srand($seed);
                  $prices_list = ['S/ 2.90', 'S/ 3.50', 'S/ 4.90', 'S/ 5.90', 'S/ 6.90', 'S/ 9.90', 'S/ 12.90'];
                  $old_price_text = $prices_list[$post_id % count($prices_list)];
                  srand(); // reset seed
              }
          ?>
              <!-- App Card Premium -->
              <a href="<?php echo esc_url($app_url); ?>"
                class="w-36 mr-6 shrink-0 text-center group block post-card">
                <div
                  class="w-28 h-28 squircle-icon-extreme bg-white/40 dark:bg-slate-900/20 mx-auto overflow-hidden shadow-lg border-2 border-white/50 dark:border-white/10 group-hover:scale-102 transition-all duration-300 relative">
                  <img class="w-full h-full object-cover"
                    src="<?php echo esc_url($app_logo); ?>" alt="<?php echo esc_attr($app_name); ?>">
                  <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors"></div>
                </div>
                <h3
                  class="font-semibold text-xs text-slate-800 dark:text-white mt-2 truncate leading-tight px-1 transition-colors hover:text-primary dark:hover:text-primary">
                  <?php echo esc_html($app_name); ?></h3>
                <div class="mt-1 flex justify-center gap-1.5 flex-wrap items-center">
                  <span class="text-[10px] text-slate-400 dark:text-gray-500 font-light line-through"><?php echo esc_html($old_price_text); ?></span>
                  <span
                    class="text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 px-1.5 py-0.5 bg-emerald-100/70 dark:bg-emerald-950/50 rounded-md select-none">
                    GRATIS
                  </span>
                </div>
              </a>
          <?php
          endwhile;
          wp_reset_postdata();
          ?>
      </div>
    </section>
<?php endif; ?>
