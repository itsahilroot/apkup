<?php
// Archive blog listings

$blog_id = get_the_ID();
$blog_title = get_the_title();
$blog_publish_date = get_the_time('d M Y', $blog_id);
$blog_author = get_the_author();
$blog_views_raw = get_post_meta($blog_id, 'px_views', true) ?: '0';
$blog_views = $blog_views_raw ? apkup_format_views_count($blog_views_raw) : '0';
$blog_thumbnail = get_the_post_thumbnail_url($blog_id, 'large');
$blog_url = get_permalink($blog_id);
?>
<a href="<?php echo esc_url($blog_url); ?>" class="flex flex-col gap-2">
    <figure class="w-full h-[180px] overflow-hidden rounded-2xl">
        <img class="w-full h-full object-cover hover:scale-105 transition" src="<?php echo $blog_thumbnail; ?>" alt="<?php echo $blog_title; ?>">
    </figure>
    <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-300 mt-1">
        <span><?php echo $blog_publish_date; ?></span>
        <span class="mx-1 dark:text-gray-200">•</span>
        <span class="flex items-center gap-1 text-gray-500 dark:text-gray-300">By <?php echo esc_html($blog_author); ?></span>
        <span class="mx-1 dark:text-gray-200">•</span>
        <span class="flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="currentColor" viewBox="0 0 256 256">
                <path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.34c18.83-18.83,27.3-37.61,27.65-38.4A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z">
                </path>
            </svg>
            <?php echo esc_html($blog_views); ?>
        </span>
    </div>
    <h2 class="font-semibold text-lg dark:text-gray-200 dark:hover:text-primary/40 cursor-pointer leading-snug">
        <?php echo esc_html($blog_title); ?>
    </h2>
</a>