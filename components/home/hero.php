<?php
$au_home_hero_swt = get_theme_mod('au_home_hero_swt', true);

if (!$au_home_hero_swt) {
    return;
}

$limit = get_theme_mod('au_home_hero_limit', 16);
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
?>
<section class="relative mb-12">
	<header class="flex items-center justify-between mb-6 relative">
        <div class="flex items-center gap-3">
            <h2 class="text-3xl font-normal tracking-tight flex items-center space-x-2">
                <span class="dark:text-gray-200"><?php echo esc_html(get_theme_mod('au_home_hero_title', 'Últimas actualizaciones')); ?></span>
            </h2>
        </div>
    </header>
    <?php if ($recently_updated_query->have_posts()) : ?>
        <div class="relative carousel hero-carousel [&:not(.flickity-enabled)]:flex [&:not(.flickity-enabled)]:gap-4 overflow-x-auto overflow-y-hidden p-2 scrollbar-hide focus:outline-none">
            <?php
            $i = 0;
            while ($recently_updated_query->have_posts()) :
                $recently_updated_query->the_post();
                get_template_part('components/card/hero', null, ['is_first' => $i === 0]);
                $i++;
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    <?php else : ?>
        <div class="bg-primary/10 dark:bg-gray-800 text-black dark:text-white px-8 py-4 text-lg text-center">
            No Posts Found!
        </div>
    <?php endif; ?>
</section>