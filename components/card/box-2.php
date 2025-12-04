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
<a href="<?php echo esc_url($app_url); ?>" class="app-card w-72 sm:w-auto">
    <figure class="app-banner">
        <img class="rounded-lg w-full h-40 object-cover" src="<?php echo esc_url($app_banner); ?>" alt="<?php echo $app_name; ?>">
    </figure>
    <div class="mt-2">
        <h3 class="font-medium leading-tight text-gray-900 dark:text-gray-100 truncate">
            <?php echo esc_html($app_name); ?>
        </h3>
        <p class="text-sm leading-snug text-gray-500 my-1">
            <span><?php echo esc_html($app_category); ?></span><?php if (!empty($app_mod_info)) echo '<span class="mx-1">•</span><span>' . $app_mod_info . '</span>'; ?>
        </p>
        <div class="flex items-center gap-1 text-sm text-gray-700 dark:text-gray-300">
            <span><?php echo esc_html(number_format((float)$app_rating, 1)); ?></span>
            <svg class="w-3 h-3 text-yellow-500" viewBox="0 0 20 20" aria-hidden="true" fill="currentColor">
                <path d="M10 1.5l2.7 5.47 6.03.88-4.36 4.25 1.03 6.01L10 15.9 4.6 18.1l1.03-6.01L1.28 7.85l6.03-.88L10 1.5z"></path>
            </svg>
        </div>
    </div>
</a>