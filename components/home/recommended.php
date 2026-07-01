<?php
$au_home_recommended = get_theme_mod('au_home_recommended', []);

if (empty($au_home_recommended)) {
    // Query fallback: fetch 6 popular posts
    $args = array(
        'post_type'           => 'post',
        'posts_per_page'      => 6,
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
        'meta_key'            => 'px_views',
        'orderby'             => 'meta_value_num',
        'order'               => 'DESC',
    );
    $rec_query = new WP_Query($args);
    $rec_posts = [];
    if ($rec_query->have_posts()) {
        while ($rec_query->have_posts()) {
            $rec_query->the_post();
            $rec_posts[] = (object)['post_id' => get_the_ID()];
        }
        wp_reset_postdata();
    }
} else {
    // Convert theme customizer option array to object list
    $rec_posts = [];
    foreach ($au_home_recommended as $item) {
        $rec_posts[] = (object)['post_id' => $item['post_id']];
    }
}

$rec_title = get_theme_mod('au_home_recommended_title', 'Top Charts: Los Más Descargados');
?>

<?php if (!empty($rec_posts)) : ?>
<section class="mt-8">
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-bold dark:text-white">
      <?php echo esc_html($rec_title); ?> <span
        class="text-[11px] font-normal text-slate-400 dark:text-slate-500 block sm:inline sm:ml-2">Tendencia global 2026</span>
    </h2>
  </div>

  <div
    class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar md:grid md:grid-cols-2 lg:grid-cols-3 gap-6 pb-4 md:pb-0">
    
    <?php
    $serial = 1;
    foreach ($rec_posts as $rec_post) :
        $post_id = $rec_post->post_id;
        $app_name = get_the_title($post_id);
        $app_url = get_the_permalink($post_id);
        $app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail');
        
        $app_category_info = apkup_get_primary_post_category($post_id);
        $app_category = $app_category_info ? $app_category_info['name'] : 'App';
        
        $data = get_post_meta($post_id, 'datos_informacion', true);
        $data = is_array($data) ? $data : [];
        $app_mod_info = $data['mod_info'] ?? '';
        
        $meta_desc = $app_category;
        if (!empty($app_mod_info)) {
            $meta_desc .= ' • ' . $app_mod_info;
        }
        
        // Cycle status based on post ID to make the list look alive
        $status_id = $post_id % 3;
        $status_html = '';
        if ($status_id === 0) {
            $status_html = '<span class="text-[10px] font-semibold text-emerald-500"><i data-lucide="trending-up" class="w-3 h-3 inline-block align-middle mr-0.5"></i> Sube rápido</span>';
        } elseif ($status_id === 1) {
            $status_html = '<span class="text-[10px] font-semibold text-slate-400 dark:text-slate-500"><i data-lucide="minus" class="w-3 h-3 inline-block align-middle mr-0.5"></i> Estable</span>';
        } else {
            $status_html = '<span class="text-[10px] font-semibold text-red-500"><i data-lucide="trending-down" class="w-3 h-3 inline-block align-middle mr-0.5"></i> Baja leve</span>';
        }
    ?>
        <!-- Game Card <?php echo esc_html($serial); ?> -->
        <a href="<?php echo esc_url($app_url); ?>"
          class="flex items-center gap-2.5 sm:gap-3.5 glass-card p-3 sm:p-4 rounded-[20px] transition-all flex-shrink-0 w-[300px] snap-center md:w-full md:shrink post-card">
          <span
            class="text-base sm:text-lg font-semibold text-slate-400 dark:text-slate-600 w-5 sm:w-6 text-center"><?php echo esc_html($serial); ?></span>
          <img class="w-12 h-12 squircle-icon-medium object-cover shrink-0"
            src="<?php echo esc_url($app_logo); ?>" alt="<?php echo esc_attr($app_name); ?>">
          <div class="flex-1 min-w-0">
            <h4 class="font-semibold text-sm text-slate-800 dark:text-white truncate"><?php echo esc_html($app_name); ?></h4>
            <p class="text-xs text-slate-500 dark:text-slate-400 truncate font-light"><?php echo esc_html($meta_desc); ?></p>
            <?php echo $status_html; ?>
          </div>
        </a>
    <?php
        $serial++;
    endforeach;
    ?>

  </div>
</section>
<?php endif; ?>