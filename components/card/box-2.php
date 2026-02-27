<?php
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
$app_banner = get_post_meta($post_id, 'wp_poster_GP', true);
$app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail');
if(empty($app_banner)) {
    $app_banner = $app_logo;
}

$app_url = get_the_permalink($post_id);
?>
<a href="<?php echo esc_url($app_url); ?>" class="app-card w-72 sm:w-auto group block">
    <figure class="app-banner rounded-lg overflow-hidden skeleton-bg relative">
        <img class="rounded-lg w-full h-40 object-cover lazyload group-hover:scale-105 transition-transform duration-300" src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%201%201'%3E%3C/svg%3E" data-src="<?php echo esc_url($app_banner); ?>" alt="<?php echo $app_name; ?>">
        <div class="absolute top-2 left-2 flex items-center bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-1.5 py-0.5 rounded-md shadow-sm z-10 pointer-events-none">
            <span class="mr-1 text-xs font-bold text-gray-800 dark:text-gray-200"><?php echo esc_html(number_format((float)$app_rating, 1)); ?></span>
            <svg class="w-3 h-3 text-primary" viewBox="0 0 20 20" aria-hidden="true" fill="currentColor">
                <path d="M10 1.5l2.7 5.47 6.03.88-4.36 4.25 1.03 6.01L10 15.9 4.6 18.1l1.03-6.01L1.28 7.85l6.03-.88L10 1.5z"></path>
            </svg>
        </div>
    </figure>
    <div class="mt-2">
        <h3 class="font-medium leading-tight text-gray-900 dark:text-gray-100 truncate group-hover:text-primary transition-colors">
            <?php echo esc_html($app_name); ?>
        </h3>
        <p class="text-sm leading-snug text-gray-500 my-1">
            <span><?php echo esc_html($app_category); ?></span><?php if (!empty($app_mod_info)) echo '<span class="mx-1">•</span><span>' . $app_mod_info . '</span>'; ?>
        </p>
    </div>
</a>