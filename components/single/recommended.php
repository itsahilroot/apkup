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
        <div class="p-6 sm:p-8 bg-white dark:bg-brand-darkCard rounded-[32px] border border-slate-200/50 dark:border-white/5 space-y-6 my-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Recomendado para ti</h2>
            <div class="grid grid-cols-2 vs:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <?php
                while ($related_posts->have_posts()) : $related_posts->the_post();
                    $rel_id = get_the_ID();
                    $rel_url = get_the_permalink($rel_id);
                    $rel_name = get_the_title();
                    $rel_logo = get_the_post_thumbnail_url($rel_id, 'thumbnail');
                    if (empty($rel_logo)) {
                        $rel_logo = 'https://placehold.co/150x150/0052e0/ffffff?text=App';
                    }
                    $rel_data = get_post_meta($rel_id, 'datos_informacion', true);
                    $rel_data = is_array($rel_data) ? $rel_data : [];
                    $rel_version = !empty($rel_data['version']) ? $rel_data['version'] : '1.0';
                    $rel_is_mod = get_post_meta($rel_id, 'app_type', true);
                ?>
                    <article class="p-3 bg-white dark:bg-brand-darkCard rounded-2xl border border-slate-200/50 dark:border-white/5 space-y-2 text-center group relative hover:shadow-md transition-all flex flex-col items-center">
                      <div class="w-20 h-20 rounded-[24%] overflow-hidden bg-slate-100 dark:bg-slate-800 mx-auto shadow-sm">
                        <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'></svg>" data-src="<?php echo esc_url($rel_logo); ?>" alt="<?php echo esc_attr($rel_name); ?> App Icon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 lazyload">
                      </div>
                      <h3 class="font-bold text-xs text-slate-800 dark:text-white truncate w-full"><?php echo esc_html($rel_name); ?></h3>
                      <?php if ($rel_is_mod == '1') : ?>
                        <span class="inline-block px-2 py-0.5 bg-primary/10 text-primary rounded text-[9px] font-bold">MOD</span>
                      <?php else : ?>
                        <span class="inline-block px-2 py-0.5 bg-slate-150/50 dark:bg-slate-800 rounded text-[9px] font-bold text-slate-500 dark:text-slate-400">v<?php echo esc_html($rel_version); ?></span>
                      <?php endif; ?>
                      <a href="<?php echo esc_url($rel_url); ?>" class="absolute inset-0 z-10" aria-label="Ver detalles de <?php echo esc_attr($rel_name); ?>"></a>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
<?php endif;
endif; ?>