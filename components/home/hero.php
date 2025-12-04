<?php
$args = array(
    'post_type'           => 'post',
    'posts_per_page'      => 16,
    'orderby'             => 'modified',
    'order'               => 'DESC',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
);

$recently_updated_query = new WP_Query($args);
?>
<section class="relative mb-12">
	<header class="flex items-center justify-between mb-6 relative">
        <div class="flex items-center gap-3">
            <h2 class="text-3xl font-bold tracking-tight drop-shadow-lg flex items-center space-x-2">
                <span class="text-black dark:text-gray-200">Últimas actualizaciones</span>
            </h2>
        </div>
    </header>
    <?php if ($recently_updated_query->have_posts()) : ?>
        <div class="relative carousel overflow-y-hidden p-2 scrollbar-hide focus:outline-none">
            <?php
            while ($recently_updated_query->have_posts()) :
                $recently_updated_query->the_post();
                get_template_part('components/card/hero');
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