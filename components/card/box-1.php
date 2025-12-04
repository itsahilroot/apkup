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
<a href="<?php echo esc_url($app_url); ?>" class="apps-items flex-shrink-0 sm:flex-shrink min-w-[140px]">
    <figure class="w-32 h-32">
        <img src="<?php echo $app_logo_full; ?>" alt="<?php echo $app_name; ?>" class="rounded-2xl">
    </figure>
    <div class="apps-metas max-w-[140px] my-2">
        <h3 class="text-[15px] text-gray-900 dark:text-gray-100 line-clamp-2"><?php echo $app_name; ?></h3>
        <div class="flex items-center gap-2 text-[12px] text-gray-700 dark:text-gray-300">
            <span><?php echo esc_html(number_format((float)$app_rating, 1)); ?></span>
            <svg class="w-3 h-3 text-yellow-500" viewBox="0 0 20 20" aria-hidden="true" fill="currentColor">
                <path d="M10 1.5l2.7 5.47 6.03.88-4.36 4.25 1.03 6.01L10 15.9 4.6 18.1l1.03-6.01L1.28 7.85l6.03-.88L10 1.5z"></path>
            </svg>
        </div>
    </div>
</a>