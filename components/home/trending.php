<?php
$au_home_trending_swt = get_theme_mod('au_home_trending_swt', true);

if (!$au_home_trending_swt) {
    return;
}

$limit = get_theme_mod('au_home_trending_limit', 15);
$sort = get_theme_mod('au_home_trending_sort', 'popular');
$term_id = get_theme_mod('au_home_trending_term_id', '');
$title = get_theme_mod('au_home_trending_title', 'Tendencias');

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
    default:
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = 'px_views';
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

$trending_query = new WP_Query($args);
?>
<section class="relative mb-12">
    <header class="flex items-center justify-between mb-6 relative">
        <div class="flex items-center gap-3">
            <h2 class="text-3xl font-bold tracking-tight drop-shadow-lg flex items-center space-x-2">
                <span class="text-black dark:text-gray-200"><?php echo esc_html($title); ?></span>
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