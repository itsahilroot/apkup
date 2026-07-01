<?php
$au_home_posts = get_theme_mod('au_home_posts', []);

foreach ($au_home_posts as $index => $posts) :
    $section_title = $posts['title'];
    $posts_limit = $posts['limit'];
    $term_id = $posts['term_id'];
    $posts_sortby = $posts['sort'];
    $posts_style = $posts['style'] ?? 'rectangle';
    $is_bottom_ad = $posts['is_btm_ad'];

    if (empty($posts_style)) {
        $posts_style = 'rectangle';
    }

    $posts_args = array();

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
        default:
            $posts_args['orderby'] = 'modified';
            $posts_args['order'] = 'DESC';
            break;
    }

    $posts_args['posts_per_page'] = $posts_limit;
    $posts_args['tax_query'] = [
        'relation' => 'AND',
    ];

    if (!empty($term_id)) {
        $term_obj = get_term_by("id", $term_id, "category");

        if (!$term_obj) {
            $term_obj = get_term_by("id", $term_id, "post_tag");
        }

        if ($term_obj) {
            $tax_query_item = [
                "taxonomy" => $term_obj->taxonomy,
                "field" => "id",
                "terms" => $term_obj->term_id,
            ];
            $posts_args["tax_query"][] = $tax_query_item;
        }
    }

    $posts_query = new WP_Query($posts_args);
?>
    <section class="mt-8">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold dark:text-white"><?php echo esc_html($section_title ?: 'Unknown'); ?></h2>
        <?php
        $category_link = '#';
        if (!empty($term_id)) {
            $term_obj = get_term($term_id);
            if ($term_obj && !is_wp_error($term_obj)) {
                $category_link = get_term_link($term_obj);
            }
        }
        ?>
        <a class="right-arrow-btn" href="<?php echo esc_url($category_link); ?>">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
          </svg>
        </a>
      </div>
      <?php if ($posts_query->have_posts()) :
          if ($posts_style === 'rectangle') :
      ?>
              <div class="flex overflow-x-auto md:overflow-x-hidden no-scrollbar pb-4 w-full home-posts-carousel" id="posts-carousel-rect-<?php echo esc_attr($index); ?>">
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
                        <div class="relative rounded-xl overflow-hidden aspect-[16/9] mb-2">
                          <a href="<?php echo esc_url($app_url); ?>">
                            <img alt="<?php echo esc_attr($app_name); ?>" class="w-full h-full object-cover"
                              src="<?php echo esc_url($app_banner); ?>">
                          </a>
                        </div>
                        <div class="flex items-start gap-3">
                          <a href="<?php echo esc_url($app_url); ?>" class="shrink-0">
                            <img class="w-12 h-12 rounded-xl object-cover"
                              src="<?php echo esc_url($app_logo); ?>"
                              alt="<?php echo esc_attr($app_name); ?> Icon">
                          </a>
                          <div class="min-w-0">
                            <a href="<?php echo esc_url($app_url); ?>">
                              <h3 class="text-sm font-bold truncate dark:text-white hover:text-primary dark:hover:text-primary transition-colors"><?php echo esc_html($app_name); ?></h3>
                            </a>
                            <p class="text-[10px] text-gray-400 dark:text-gray-500 truncate"><?php echo esc_html($meta_desc); ?></p>
                            <p class="text-[10px] text-gray-400 dark:text-gray-500"><?php echo esc_html(number_format((float)$app_rating, 1)); ?> ★ <?php echo esc_html($app_size); ?></p>
                          </div>
                        </div>
                      </div>
                  <?php
                  endwhile;
                  wp_reset_postdata();
                  ?>
              </div>
          <?php elseif ($posts_style === 'landscape') : ?>
              <div class="flex overflow-x-auto md:overflow-x-hidden no-scrollbar pb-4 w-full home-posts-carousel" id="posts-carousel-land-<?php echo esc_attr($index); ?>">
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
                      <div class="flex flex-col w-72 mr-6 shrink-0 post-card group">
                        <a href="<?php echo esc_url($app_url); ?>" class="overflow-hidden rounded-xl mb-2">
                          <img class="w-full aspect-video object-cover hover:scale-105 transition-transform duration-200"
                            src="<?php echo esc_url($app_banner); ?>"
                            alt="<?php echo esc_attr($app_name); ?>">
                        </a>
                        <a href="<?php echo esc_url($app_url); ?>" class="hover:text-primary dark:hover:text-primary transition-colors">
                          <h3 class="text-[11px] font-bold leading-tight dark:text-white"><?php echo esc_html($app_name); ?></h3>
                        </a>
                        <p class="text-[9px] text-gray-400 dark:text-gray-500 mt-0.5"><?php echo esc_html($meta_desc); ?></p>
                        <p class="text-[9px] text-gray-400 dark:text-gray-500"><?php echo esc_html(number_format((float)$app_rating, 1)); ?> ★</p>
                      </div>
                  <?php
                  endwhile;
                  wp_reset_postdata();
                  ?>
              </div>
          <?php else : ?>
              <div class="flex overflow-x-auto md:overflow-x-hidden no-scrollbar pb-4 w-full home-posts-carousel" id="posts-carousel-box-<?php echo esc_attr($index); ?>">
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
                            <img alt="<?php echo esc_attr($app_name); ?>" class="w-16 h-16 rounded-2xl shadow-sm mb-1 object-cover hover:scale-105 transition-transform duration-200" src="<?php echo esc_url($app_logo); ?>">
                          </a>
                          <?php if (!empty($badge_text)) : ?>
                            <span class="absolute top-0.5 right-0.5 bg-orange-500 text-white text-[8px] px-1.5 py-0.5 rounded-full font-bold select-none pointer-events-none"><?php echo esc_html($badge_text); ?></span>
                          <?php endif; ?>
                        </div>
                        <a href="<?php echo esc_url($app_url); ?>" class="hover:text-primary dark:hover:text-primary transition-colors">
                          <h3 class="text-[10px] font-medium leading-tight mb-1 min-h-[24px] line-clamp-2 dark:text-white"><?php echo esc_html($app_name); ?></h3>
                        </a>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 leading-none"><?php echo esc_html(number_format((float)$app_rating, 1)); ?> ★</p>
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
    if ($is_bottom_ad) {
        home_bottom_ad();
    }
endforeach; ?>