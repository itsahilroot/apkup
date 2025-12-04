<?php
// Archive posts

$post_id = get_the_ID();
$app_url = get_the_permalink($post_id);
$app_name = get_the_title();

$data = get_post_meta($post_id, 'datos_informacion', true);
$data = is_array($data) ? $data : [];
$app_version = $data['version'] ?? '';

$app_logo_full = get_the_post_thumbnail_url($post_id, 'full');

$is_app_mod = get_post_meta($post_id, 'app_type', true);
?>
<div class="sm:flex sm:items-center relative gap-4">
    <div class="relative mb-4 md:mb-0">
        <figure class="relative min-w-32 max-w-32">
            <img class="shadow-lg rounded-2xl w-32 h-32" src="<?php echo esc_url($app_logo_full); ?>" alt="<?php echo $app_name; ?>">
        </figure>
    </div>
    <a href="<?php echo esc_url($app_url); ?>" class="flex flex-col after:content-[''] after:absolute after:inset-0 after:z-10">
        <div class="flex items-center flex-wrap gap-1 mb-2">
            <?php if($is_app_mod == '1') : ?>
            <span class="tag px-2 py-1 bg-green-100 text-green-700 text-sm rounded-xl uppercase leading-4">MOD</span>
            <?php endif; ?>
            <span class="android px-2 py-1 text-gray-500 dark:text-gray-300 text-sm rounded leading-4">Android 6.0</span>
        </div>
        <h2 class="app-title font-semibold text-sm dark:text-gray-200 line-clamp-1 md:line-clamp-3 mb-2"><?php echo $app_name; ?></h2>
        <span class="version text-gray-500 dark:text-gray-300 text-sm">v<?php echo $app_version; ?></span>
    </a>
</div>