<?php
// Home blog listing card

$blog_id = get_the_ID();
$blog_title = get_the_title();
$blog_publish_date = get_the_time('d M Y', $blog_id);
$blog_author = get_the_author();
$blog_views_raw = get_post_meta($blog_id, 'px_views', true) ?: '0';
$blog_views = $blog_views_raw ? apkup_format_views_count($blog_views_raw) : '0';
$blog_thumbnail = get_the_post_thumbnail_url($blog_id, 'large');
$blog_url = get_permalink($blog_id);
?>
<a href="<?php echo esc_url($blog_url); ?>"
    class="carditems my-4 mr-4 prose prose-sm dark:prose-invert shrink-0 w-72">
    <div class="block transition-opacity duration-300 hover:opacity-80 rounded-3xl overflow-hidden skeleton-bg">
        <img class="rounded-3xl w-full aspect-[16/9] object-cover block lazyload" src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%201%201'%3E%3C/svg%3E" data-src="<?php echo esc_url($blog_thumbnail); ?>" alt="<?php echo esc_attr($blog_title); ?> icon">
    </div>
    <div class="meta flex flex-wrap items-center gap-3 text-sm text-gray-600 dark:text-gray-300 mt-2">
        <span class="flex items-center gap-1 text-gray-500 dark:text-gray-300"><?php echo esc_html($blog_publish_date); ?></span>
        <span class="mx-1">•</span>
        <span class="flex items-center gap-1 text-gray-500 dark:text-gray-300">By <?php echo esc_html($blog_author); ?></span>
        <span class="mx-1">•</span>
        <span class="views flex items-center gap-1 text-gray-500 dark:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            <?php echo esc_html($blog_views); ?>
        </span>
    </div>
    <h3 class="title mt-2 text-gray-600 dark:text-gray-200 dark:hover:text-white dark:hover:text-primary/80 transition-colors line-clamp-1">
        <?php echo esc_html($blog_title); ?>
    </h3>
</a>