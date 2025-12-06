<?php
// Trending box in home

$post_id = get_the_ID();

$app_name = get_the_title($post_id);

$app_type = get_post_meta($post_id, 'app_type', true);
$app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;

$data = get_post_meta($post_id, 'datos_informacion', true);
$data = is_array($data) ? $data : [];
$app_version = $data['version'] ?? '';
$app_size = $data['tamano'] ?? '';
$app_mod_info = $data['mod_info'] ?? '';

$app_category = apkup_get_primary_category_name($post_id) ?: 'Uncategorized';
$app_logo_full = get_the_post_thumbnail_url($post_id, 'full');

$app_url = get_the_permalink($post_id);
?>
<a href="<?php echo esc_url($app_url); ?>" class="apps-items flex my-2 truncate">
    <figure class="app-item flex-shrink-0 w-20 h-20 rounded-2xl overflow-hidden skeleton-bg">
        <img src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%201%201'%3E%3C/svg%3E" data-src="<?php echo esc_url($app_logo_full); ?>" alt="<?php echo $app_name; ?>" class="app-icon rounded-2xl flex-shrink-0 w-full h-full lazyload">
    </figure>
    <div class="apps-info flex flex-col justify-between ml-4 flex-1 min-w-0 truncate">
        <h3 class="font-semibold text-sm truncate dark:text-gray-300"><?php echo esc_html($app_name); ?></h3>
        <p class="text-xs text-gray-500 truncate"><?php echo esc_html($app_category); ?><?php if (!empty($app_mod_info)) echo ' • ' . $app_mod_info; ?></p>
        <div class="flex items-center">
            <span class="text-yellow-500">★</span>
            <span class="text-xs ml-1 dark:text-gray-400"><?php echo esc_html(number_format((float)$app_rating, 1)); ?></span>
            <span class="text-xs text-gray-500 dark:text-gary-400 ml-2"><?php echo $app_size; ?></span>
        </div>
    </div>
</a>