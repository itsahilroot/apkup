<?php
// Games, Apps repeatable sections

$post_id = get_the_ID();

$app_name = get_the_title();

$is_app_mod = get_post_meta($post_id, 'app_type', true);
$app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;

$data = get_post_meta($post_id, 'datos_informacion', true);
$data = is_array($data) ? $data : [];
$app_version = $data['version'] ?? '';
$app_requires = $data['requerimientos'] ?? '';

$app_logo_full = get_the_post_thumbnail_url($post_id, 'full');

$app_url = get_the_permalink($post_id);
?>
<a href="<?php echo esc_url($app_url); ?>" class="apps-items flex flex-col flex-shrink-0 sm:flex-shrink w-[130px] group">
    <figure class="w-full aspect-square rounded-2xl overflow-hidden skeleton-bg relative">
        <img src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%201%201'%3E%3C/svg%3E" data-src="<?php echo esc_url($app_logo_full); ?>" alt="<?php echo esc_attr($app_name); ?>" class="rounded-2xl lazyload w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        <div class="absolute top-1.5 left-1.5 flex items-center bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-1.5 py-0.5 rounded-md shadow-sm z-10 pointer-events-none">
            <span class="mr-1 text-[11px] font-bold text-gray-800 dark:text-gray-200"><?php echo esc_html(number_format((float)$app_rating, 1)); ?></span>
            <svg class="w-2.5 h-2.5 text-primary" viewBox="0 0 20 20" aria-hidden="true" fill="currentColor">
                <path d="M10 1.5l2.7 5.47 6.03.88-4.36 4.25 1.03 6.01L10 15.9 4.6 18.1l1.03-6.01L1.28 7.85l6.03-.88L10 1.5z"></path>
            </svg>
        </div>
    </figure>
    <div class="apps-metas w-full mt-2 text-left">
        <h3 class="text-[14px] font-medium leading-tight text-gray-900 dark:text-gray-100 line-clamp-2 group-hover:text-primary transition-colors"><?php echo esc_html($app_name); ?></h3>
    </div>
</a>