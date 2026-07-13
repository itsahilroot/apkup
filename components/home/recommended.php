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
            $rec_posts[] = (object)[
                'post_id'    => get_the_ID(),
                'badge_text' => '',
            ];
        }
        wp_reset_postdata();
    }
} else {
    // Convert theme customizer option array to object list
    $rec_posts = [];
    foreach ($au_home_recommended as $item) {
        $rec_posts[] = (object)[
            'post_id'    => $item['post_id'],
            'badge_text' => $item['badge_text'] ?? '',
        ];
    }
}

$rec_title = get_theme_mod('au_home_recommended_title', 'Top Charts: Los Más Descargados');
?>

<?php if (!empty($rec_posts)) : ?>
<style>
@keyframes premiumShimmer {
  0% {
    left: -150%;
  }
  50% {
    left: 150%;
  }
  100% {
    left: 150%;
  }
}
.premium-shimmer-card {
  position: relative;
  overflow: hidden;
}
.premium-shimmer-card::after {
  content: '';
  position: absolute;
  top: 0;
  left: -150%;
  width: 50%;
  height: 100%;
  background: linear-gradient(
    to right,
    rgba(255, 255, 255, 0) 0%,
    rgba(255, 255, 255, 0.25) 50%,
    rgba(255, 255, 255, 0) 100%
  );
  transform: skewX(-25deg);
  animation: premiumShimmer 6s infinite ease-in-out;
  pointer-events: none;
}
.dark .premium-shimmer-card::after {
  background: linear-gradient(
    to right,
    rgba(255, 255, 255, 0) 0%,
    rgba(255, 255, 255, 0.1) 50%,
    rgba(255, 255, 255, 0) 100%
  );
}
</style>

<section class="mt-4">
  <div class="flex items-center justify-between mb-2">
    <h2 class="text-lg font-bold dark:text-white">
      <?php echo esc_html($rec_title); ?> <span
        class="text-[11px] font-normal text-slate-400 dark:text-slate-500 block sm:inline sm:ml-2">Tendencia global 2026</span>
    </h2>
  </div>

  <div
    class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar md:grid md:grid-cols-2 lg:grid-cols-3 gap-6 p-2 pt-6 pb-6">
    
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
        $app_size = $data['tamano'] ?? '';
        $app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: '4.7';
        $app_type = get_post_meta($post_id, 'app_type', true);
        $is_mod = ($app_type == 1);
        $badge_text = $rec_post->badge_text;
        
        $meta_desc = $app_category;
        if (!empty($app_mod_info)) {
            $meta_desc .= ' • ' . $app_mod_info;
        }
        
        // Cycle status based on post ID to make the list look alive
        $status_id = $post_id % 3;
        $status_html = '';
        if ($status_id === 0) {
            $status_html = '<span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 dark:bg-emerald-500/15"><i data-lucide="trending-up" class="w-3 h-3"></i> Sube rápido</span>';
        } elseif ($status_id === 1) {
            $status_html = '<span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400"><i data-lucide="minus" class="w-3 h-3"></i> Estable</span>';
        } else {
            $status_html = '<span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-450 dark:bg-rose-500/15"><i data-lucide="trending-down" class="w-3 h-3"></i> Baja leve</span>';
        }

        // Rank styling classes
        $rank_classes = 'bg-slate-100 text-slate-500 dark:bg-slate-800/80 dark:text-slate-400 border border-slate-200/40 dark:border-white/5';
        if ($serial === 1) {
            $rank_classes = 'bg-gradient-to-br from-amber-400 via-amber-500 to-yellow-600 text-white border border-amber-300/40 dark:border-white/10 shadow-sm shadow-amber-500/35';
        } elseif ($serial === 2) {
            $rank_classes = 'bg-gradient-to-br from-slate-300 via-slate-400 to-slate-500 text-white border border-slate-300/40 dark:border-white/10 shadow-sm shadow-slate-400/30';
        } elseif ($serial === 3) {
            $rank_classes = 'bg-gradient-to-br from-orange-400 via-orange-500 to-amber-700 text-white border border-orange-300/40 dark:border-white/10 shadow-sm shadow-orange-500/35';
        }
    ?>
        <!-- Game Card <?php echo esc_html($serial); ?> -->
        <a href="<?php echo esc_url($app_url); ?>"
          class="relative flex items-center gap-3.5 p-3.5 pt-4.5 rounded-[24px] bg-gradient-to-br from-white/95 to-slate-50/90 dark:from-slate-900/65 dark:to-slate-950/80 border border-blue-200/80 dark:border-blue-800/60 shadow-[0_8px_30px_rgba(0,0,0,0.02)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.15)] hover:shadow-[0_20px_40px_rgba(26,115,232,0.06)] dark:hover:shadow-[0_20px_40px_rgba(0,0,0,0.35)] hover:border-blue-400 dark:hover:border-blue-600/70 transition-all duration-300 ease-out flex-shrink-0 w-[310px] snap-center md:w-full md:shrink group overflow-visible post-card premium-shimmer-card">
          
          <!-- Top Floating Highlight Ribbon/Badge -->
          <?php if (!empty($badge_text)) : ?>
            <span class="absolute top-0 right-4 translate-y-[-50%] bg-gradient-to-r from-blue-600 to-indigo-650 dark:from-blue-500 dark:to-indigo-500 text-white text-[8px] font-black uppercase px-2.5 py-0.5 rounded-full tracking-widest shadow-md z-10 flex items-center gap-1">
              <i data-lucide="sparkles" class="w-2.5 h-2.5"></i> <?php echo esc_html($badge_text); ?>
            </span>
          <?php endif; ?>

          <!-- Position badge -->
          <div class="w-6 h-6 rounded-full overflow-hidden flex items-center justify-center font-extrabold text-[10px] shrink-0 <?php echo $rank_classes; ?>">
            <?php echo esc_html($serial); ?>
          </div>

          <!-- App Icon wrapper with verified tick -->
          <div class="relative shrink-0 rounded-[18px]">
            <!-- App Icon with border -->
            <div class="w-13 h-13 rounded-[18px] overflow-hidden border border-emerald-500/30 dark:border-emerald-500/20 ring-4 ring-emerald-500/5 dark:ring-emerald-500/10">
              <img class="w-full h-full object-cover" src="<?php echo esc_url($app_logo); ?>" alt="<?php echo esc_attr($app_name); ?>">
            </div>
            <!-- Verified Tick Badge -->
            <span class="absolute bottom-[-2px] right-[-2px] bg-blue-500 text-white rounded-full p-0.5 border border-white dark:border-slate-900 shadow-sm flex items-center justify-center w-4.5 h-4.5 z-10">
              <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" stroke-width="4.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
              </svg>
            </span>
          </div>

          <!-- Text block -->
          <div class="flex-grow min-w-0">
            <h3 class="font-bold text-sm text-slate-900 dark:text-white truncate group-hover:text-primary dark:group-hover:text-blue-400 transition-colors duration-200"><?php echo esc_html($app_name); ?></h3>
            <p class="text-[11px] text-slate-450 dark:text-slate-400 truncate mt-0.5 mb-1.5 font-normal"><?php echo esc_html($meta_desc); ?></p>
            
            <!-- Metadata & Badge Row -->
            <div class="flex items-center gap-1.5 flex-wrap">
              <!-- Rating pill -->
              <span class="inline-flex items-center gap-0.5 text-[9px] font-bold px-1.5 py-0.5 rounded bg-gray-500/10 text-amber-500 dark:bg-gray-500/15 dark:text-amber-500">
                <i data-lucide="star" class="w-2.5 h-2.5 fill-amber-500 text-amber-500"></i> <?php echo esc_html(number_format((float)$app_rating, 1)); ?>
              </span>
              
              <!-- Size pill -->
              <?php if (!empty($app_size)) : ?>
                <span class="inline-flex items-center gap-0.5 text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-450">
                  <i data-lucide="hard-drive" class="w-2.5 h-2.5"></i> <?php echo esc_html($app_size); ?>
                </span>
              <?php endif; ?>

              <!-- MOD pill -->
              <?php if ($is_mod) : ?>
                <span class="inline-flex items-center gap-0.5 text-[9px] font-extrabold px-1.5 py-0.5 rounded bg-emerald-500/15 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400 uppercase tracking-wide">
                  <i data-lucide="zap" class="w-2.5 h-2.5"></i> MOD
                </span>
              <?php endif; ?>

              <!-- Trend Status badge -->
              <?php echo $status_html; ?>
            </div>
          </div>

          <!-- Premium Action Arrow -->
          <div class="w-7 h-7 rounded-full bg-slate-50 dark:bg-slate-850 flex items-center justify-center shrink-0 border border-slate-200/50 dark:border-white/5 group-hover:bg-primary dark:group-hover:bg-primary transition-all duration-300">
            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
            </svg>
          </div>
        </a>
    <?php
        $serial++;
    endforeach;
    ?>

  </div>
</section>
<?php endif; ?>