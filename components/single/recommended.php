<?php
$au_single_related_swt = get_theme_mod('au_single_related_swt', false);
$au_single_related_limit = (int) get_theme_mod('au_single_related_limit', 6);

$post_id = get_the_ID();
$post_categories = get_the_terms($post_id, 'category');

$chosen_cat_id = null;

if (!empty($post_categories)) {
    $subcats = [];
    $parents = [];

    foreach ($post_categories as $cat) {
        if ($cat->parent != 0) {
            $subcats[] = $cat; // collect subcategories
        } else {
            $parents[] = $cat; // collect parent categories
        }
    }

    if (!empty($subcats)) {
        // ✅ Rule 1: Prefer first available subcategory
        $chosen_cat_id = $subcats[0]->term_id;
    } elseif (!empty($parents)) {
        // ✅ Rule 2: No subcategory, fallback to parent(s)
        $chosen_cat_id = $parents[0]->term_id;
    }
}

$related_posts = null;
if ($chosen_cat_id) {
    $related_posts = new WP_Query(array(
        'cat' => $chosen_cat_id,
        'posts_per_page' => $au_single_related_limit ?: 6,
        'post__not_in' => array($post_id)
    ));
}
if ($au_single_related_swt) :
    if ($related_posts && $related_posts->have_posts()) : ?>
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 mb-10 shadow-sm">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Recomendado</h2>
            <div class="grid grid-cols-2 vs:grid-cols-3 gap-x-5 gap-y-5 sm:gap-y-8">
                <?php
                while ($related_posts->have_posts()) : $related_posts->the_post();
                    get_template_part('components/card/box-3');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
<?php endif;
endif; ?>