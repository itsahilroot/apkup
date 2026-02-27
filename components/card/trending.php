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

// Generate diverse badge colors dynamically based on post ID
$mod_colors = [
    'from-yellow-400 to-orange-500',
    'from-emerald-400 to-primary',
    'from-blue-400 to-indigo-600',
    'from-purple-400 to-fuchsia-600',
    'from-red-400 to-rose-600',
    'from-indigo-400 to-violet-600',
    'from-orange-400 to-amber-600',
    'from-teal-400 to-cyan-600',
    'from-pink-400 to-rose-600'
];
$color_class = $mod_colors[$post_id % count($mod_colors)];
?>
<div class="flex gap-3 items-start group hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl p-2 transition-colors duration-200 -mx-2">
    <a href="<?php echo esc_url($app_url); ?>" class="relative w-14 h-14 rounded-xl overflow-hidden shrink-0 block">
        <img src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%201%201'%3E%3C/svg%3E" data-src="<?php echo esc_url($app_logo_full); ?>" alt="<?php echo esc_attr($app_name); ?>" class="app-icon w-full h-full object-cover lazyload">
        <div class="skeleton absolute inset-0"></div>
    </a>
    <div class="min-w-0">
        <a href="<?php echo esc_url($app_url); ?>" class="font-semibold block truncate group-hover:text-primary dark:group-hover:text-primary transition-colors text-gray-900 dark:text-gray-100"><?php echo esc_html($app_name); ?></a>
        <div class="flex items-center gap-1 text-xs text-gray-500 mt-0.5 mb-1.5 flex-wrap">
            <span><?php echo esc_html($app_category); ?></span>
            <?php if (!empty($app_mod_info)) : ?>
            <span>·</span>
            <span class="shine-effect bg-gradient-to-r <?php echo $color_class; ?> text-white px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider shadow-sm"><?php echo esc_html($app_mod_info); ?></span>
            <?php endif; ?>
        </div>
        <div class="flex items-center gap-2 text-sm">
            <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-700 w-max px-2 py-0.5 rounded-full">
                <span class="text-sm text-gray-600 font-normal dark:text-gray-300"><?php echo esc_html(number_format((float)$app_rating, 1)); ?></span>
                <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="m6.87 14.33-1.83 6.4c-.12.4.03.84.37 1.08.34.25.8.26 1.14.02L12 18.2l5.45 3.63a.99.99 0 0 0 1.14-.02c.34-.25.49-.68.37-1.08l-1.83-6.4 4.54-4.08c.3-.27.41-.69.28-1.06-.13-.38-.47-.64-.87-.68l-5.7-.45-2.47-5.46a.998.998 0 0 0-1.82 0L8.62 8.06l-5.7.45c-.4.03-.74.3-.87.68s-.02.8.28 1 .99 .99 .99 .99z">
                    </path>
                </svg>
            </div>
            <?php if (!empty($app_size)) : ?>
            <span class="text-gray-500"><?php echo esc_html($app_size); ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>