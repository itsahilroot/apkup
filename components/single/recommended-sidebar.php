<?php
$au_single_related_limit = (int) get_theme_mod('au_single_related_limit', 6);

$post_id = get_the_ID();
$post_categories = get_the_terms($post_id, 'category');

$chosen_cat_id = null;

if (!empty($post_categories)) {
    $subcats = [];
    $parents = [];

    foreach ($post_categories as $cat) {
        if ($cat->parent != 0) {
            $subcats[] = $cat;
        } else {
            $parents[] = $cat;
        }
    }

    if (!empty($subcats)) {
        $chosen_cat_id = $subcats[0]->term_id;
    } elseif (!empty($parents)) {
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

if ($related_posts && $related_posts->have_posts()) : 
    $cat_link = $chosen_cat_id ? get_category_link($chosen_cat_id) : '#';
    ?>
    <section class="bg-white dark:bg-brand-darkCard rounded-3xl p-4 sm:p-6 shadow-sm border border-slate-100 dark:border-brand-darkBorder transition-all flex flex-col space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-brand-darkBorder/40 pb-2.5">
            <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">Sugerencias</h2>
            <a href="<?php echo esc_url($cat_link); ?>" aria-label="Ver todas las sugerencias" class="w-8 h-8 flex items-center justify-center bg-slate-50 dark:bg-slate-900 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800/80 border border-slate-150 dark:border-brand-darkBorder transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5 text-slate-500 dark:text-slate-400"><path d="m9 18 6-6-6-6"></path></svg>
            </a>
        </div>
        <ul class="space-y-3">
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
            ?>
                <li>
                    <article class="relative flex items-center gap-3.5 bg-slate-50/40 hover:bg-slate-100/50 dark:bg-slate-900/30 dark:hover:bg-slate-900/60 p-2.5 rounded-2xl border border-slate-100/80 dark:border-brand-darkBorder/40 transition-all duration-200 group">
                        <div class="w-14 h-14 rounded-xl overflow-hidden shadow-sm flex-shrink-0 border border-slate-100/50 dark:border-brand-darkBorder/70">
                            <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'></svg>" data-src="<?php echo esc_url($rel_logo); ?>" class="lazyload w-full h-full object-cover" width="56" height="56" alt="<?php echo esc_attr($rel_name); ?> Icon">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-primary transition-colors truncate"><?php echo esc_html($rel_name); ?></h3>
                            <p class="text-xs text-slate-400 dark:text-slate-500 truncate mt-0.5">v<?php echo esc_html($rel_version); ?></p>
                        </div>
                        <span class="w-8 h-8 flex items-center justify-center bg-slate-150/70 dark:bg-slate-800/80 text-primary group-hover:bg-gray-200 group-hover:text-white rounded-full transition-colors shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </span>
                        <a href="<?php echo esc_url($rel_url); ?>" class="absolute inset-0 z-10" aria-label="Ver detalles de <?php echo esc_attr($rel_name); ?>"></a>
                    </article>
                </li>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </ul>
    </section>
<?php endif; ?>
