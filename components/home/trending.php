<?php
$args = array(
    'post_type'           => 'post',
    'posts_per_page'      => 15,
    'meta_key'            => 'px_views',
    'orderby'             => 'meta_value_num',
    'order'               => 'DESC',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
);

$trending_query = new WP_Query($args);
?>
<section class="relative mb-12">
    <header class="flex items-center justify-between mb-6 relative">
        <div class="flex items-center gap-3">
            <h2 class="text-3xl font-bold tracking-tight drop-shadow-lg flex items-center space-x-2">
                <span class="text-black dark:text-gray-200">Tendencias</span>
            </h2>
        </div>
    </header>
    <?php if ($trending_query->have_posts()) : ?>
        <div class="carousel overflow-y-hidden p-2 scrollbar-hide focus:outline-none">
            <?php
            $count = 0;
            while ($trending_query->have_posts()) : $trending_query->the_post();

                // Open a new "item-cont" for every 3 posts
                if ($count % 3 == 0) {
                    echo '<div class="item-cont grid grid-rows-3 gap-4 min-w-[200px] max-w-[300px] mr-4">';
                }

                get_template_part('components/card/trending');

                $count++;

                // Close "item-cont" after 3 posts OR at the last post
                if ($count % 3 == 0 || $count == $trending_query->post_count) {
                    echo '</div>';
                }

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