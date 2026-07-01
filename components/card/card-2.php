<?php
// Archive blog listings card

$blog_id = get_the_ID();
$thumb_url = get_the_post_thumbnail_url($blog_id, 'medium_large') ?: 'https://placehold.co/640x360/0052e0/ffffff?text=Blog';
$author_name = get_the_author() ?: 'APKGSTORE';
$post_date = get_the_date('d M Y');

// Fetch primary category or custom tax taxonomy for blog post type if exists
$terms = get_the_terms($blog_id, 'blog_category');
if (empty($terms) || is_wp_error($terms)) {
    $terms = get_the_category($blog_id);
}
$primary_cat = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->name : 'Tecnología';
?>
<!-- Blog Card -->
<article class="group flex flex-col gap-3 post-card">
    <div class="relative overflow-hidden rounded-2xl aspect-video bg-slate-100 dark:bg-slate-850">
        <img class="w-full h-full object-cover transition-all duration-300 group-hover:scale-103" src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>">
    </div>
    <div class="space-y-1 min-w-0">
        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-light">
            <?php echo esc_html($post_date); ?> • <?php echo esc_html($primary_cat); ?> • Por <?php echo esc_html($author_name); ?>
        </span>
        <a href="<?php the_permalink(); ?>" class="block">
            <h4 class="font-normal text-sm text-slate-800 dark:text-slate-200 group-hover:text-primary transition-colors leading-snug">
                <?php the_title(); ?>
            </h4>
        </a>
    </div>
</article>