<?php
$au_home_posts = get_theme_mod('au_home_posts', []);

foreach ($au_home_posts as $index => $posts) :
    $section_title = $posts['title'];
    $posts_limit = $posts['limit'];
    $term_id = $posts['term_id'];
    $posts_sortby = $posts['sort'];
    $posts_style = $posts['style'] ?? 'boxed';
    $is_bottom_ad = $posts['is_btm_ad'];

    if (empty($posts_style)) {
        $posts_style = 'boxed';
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
    <section class="relative mb-12">
        <header class="flex items-center justify-between mb-6 relative">
            <div class="flex items-center gap-3">
                <h2 class="text-3xl font-normal tracking-tight flex items-center space-x-2">
                    <span class="text-gray-500 dark:text-gray-200"><?php echo $section_title ?: 'Unknown'; ?></span>
                </h2>
            </div>
            <a href="<?php echo esc_url(get_category_link($term_id)); ?>" class="group flex items-center text-primary hover:text-primary transition-colors rounded-full px-4 py-2 bg-white/70 dark:bg-gray-900/60 shadow-lg border border-primary/20 dark:border-primary">
                <span class="mr-2 font-medium"><?php esc_html_e('View all', 'apktemplates'); ?></span>
                <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </header>
        <?php if ($posts_query->have_posts()) :
            if ($posts_style === 'rectangle') :
        ?>
                <div class="overflow-x-auto overflow-y-hidden [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    <div class="grid grid-rows-2 grid-flow-col gap-4 sm:grid-cols-2 sm:grid-rows-none sm:grid-flow-row md:grid-cols-3 lg:grid-cols-4">
                        <?php
                        while ($posts_query->have_posts()) : $posts_query->the_post();
                            get_template_part('components/card/box-2');
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="flex gap-4 overflow-x-auto sm:grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 sm:gap-6 sm:overflow-visible mobile-no-scrollbar">
                    <?php
                    while ($posts_query->have_posts()) : $posts_query->the_post();
                        get_template_part('components/card/box-1');
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