<?php get_header(); ?>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <section class="mb-8">
        <?php if (function_exists('apkup_breadcrumb')) apkup_breadcrumb(); ?>
    </section>
    <section class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
            <?php the_archive_title(); ?>
        </h1>
        <?php
        $current_cat = get_queried_object();

        if (isset($current_cat->term_id)) {
            $sub_cats = get_categories([
                'child_of'   => $current_cat->term_id,
                'hide_empty' => false,
            ]);

            if (!empty($sub_cats)) : ?>
                <div class="mt-4 py-2">
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($sub_cats as $sub_cat) :
                            if ($sub_cat->count > 0) : ?>
                                <a href="<?php echo esc_url(get_category_link($sub_cat->term_id)); ?>"
                                    class="category-btn bg-green-100 text-green-500 dark:bg-primary dark:text-white px-3 py-1 rounded-full text-sm font-medium">
                                    <?php echo esc_html($sub_cat->name); ?>
                                </a>
                        <?php endif;
                        endforeach; ?>
                    </div>
                </div>
        <?php endif;
        }
        ?>
    </section>
    <?php if (!empty($sub_cats)) : ?>
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Best Picks</h2>
            <div class="relative">
                <div class="flex gap-4 overflow-x-auto scroll-smooth pb-2">
                    <?php
                    $excluded_ids = [];
                    if (isset($current_cat->term_id)) {
                        $best_apps = new WP_Query([
                            'posts_per_page' => 10,
                            'cat'            => $current_cat->term_id,
                            'meta_key'       => 'px_views',
                            'orderby'        => 'meta_value_num',
                            'order'          => 'DESC',
                        ]);
                        $rank = 1;
                        if ($best_apps->have_posts()) :
                            while ($best_apps->have_posts()) : $best_apps->the_post();
                                $excluded_ids[] = get_the_ID();
                                get_template_part('components/card/box-4', null, ['rank' => $rank]);
                                $rank++;
                            endwhile;
                            wp_reset_postdata();
                        endif;
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php archive_top_ad(); ?>
    <?php
    if (!empty($sub_cats)) :
        $i = 1;
        foreach ($sub_cats as $sub_cat) :
            $posts_query = new WP_Query([
                'cat'            => $sub_cat->term_id,
                'posts_per_page' => 8,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);
            if ($posts_query->have_posts()) : ?>
                <section class="mb-8">
                    <a href="<?php echo esc_url( get_category_link( $sub_cat->term_id ) ); ?>" class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6 block">
                        <?php echo esc_html($sub_cat->name); ?>
                    </a>
                    <?php if (($i - 1) % 3 == 0) : ?>
                        <div class="grid grid-cols-2 vs:grid-cols-3 gap-x-5 gap-y-5 sm:gap-y-8 md:grid-cols-3 lg:grid-cols-4">
                            <?php
                            while ($posts_query->have_posts()) : $posts_query->the_post();
                                get_template_part('components/card/box-3');
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    <?php else : ?>
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
                    <?php endif; ?>
                </section>
    <?php
            endif;
            $i++;
        endforeach;
    endif;
    ?>
    <?php if (empty($sub_cats)) : ?>
        <section class="mb-8">
            <?php
            if (have_posts()) : ?>
                <div class="grid grid-cols-2 vs:grid-cols-3 gap-x-5 gap-y-5 sm:gap-y-8 md:grid-cols-3 lg:grid-cols-4">
                    <?php
                    while (have_posts()) : the_post();
                        get_template_part('components/card/box-3');
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php else : ?>
                <div class="bg-green-50 dark:bg-gray-800 text-black dark:text-white px-8 py-4 text-lg text-center">
                    No Posts Found!
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>
    <?php archive_bottom_ad(); ?>
    <?php if (empty($sub_cats)) : ?>
        <section class="mb-8">
            <?php
            global $wp_query;
            if ($wp_query->max_num_pages > 1 && function_exists('apkup_pagination')) {
                $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
                $total_pages = $wp_query->max_num_pages;
                echo apkup_pagination($current_page, $total_pages);
            }
            ?>
        </section>
    <?php endif; ?>
</main>
<?php get_footer(); ?>