<?php
$post_id = $args['post_id'];

$app_name = get_the_title($post_id);

$app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;

$app_category = apkup_get_primary_category_name($post_id);
$app_description = apkup_get_post_short_description($post_id);

$app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail');

$app_url = get_the_permalink($post_id);
?>
<div class="carousel-cell mr-4 w-64 shrink-0 group">
    <a href="<?php echo esc_url($app_url); ?>" class="block h-full bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-gray-700/50">
    <div class="p-4 h-full flex flex-col">
        <div class="flex items-start gap-3 mb-3">
            <div class="w-14 h-14 rounded-xl overflow-hidden shrink-0 shadow-sm relative group-hover:scale-105 transition-transform duration-300 skeleton-bg">
                <img src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%201%201'%3E%3C/svg%3E" data-src="<?php echo $app_logo; ?>" alt="<?php echo $app_name; ?> Icon" class="w-full h-full object-cover lazyload">
            </div>
            <div class="flex-1 min-w-0 pt-0.5">
                <h3 class="font-bold text-gray-900 dark:text-white text-base leading-tight truncate group-hover:text-green-600 transition-colors" title="<?php echo esc_attr($app_name); ?>"><?php echo $app_name; ?></h3>
                <p class="text-gray-500 dark:text-gray-400 text-xs font-medium truncate mt-0.5"><?php echo esc_html($app_category); ?></p>
            </div>
        </div>
        
        <p class="text-gray-500 dark:text-gray-400 text-xs line-clamp-2 leading-relaxed mb-3 flex-grow"><?php echo esc_html($app_description); ?></p>

        <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-700/50 mt-auto">
             <div class="flex items-center space-x-1.5 bg-gray-50 dark:bg-gray-700/30 px-2 py-1 rounded-md">
                <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <span class="text-xs font-bold text-gray-700 dark:text-gray-300"><?php echo esc_html(number_format((float)$app_rating, 1)); ?></span>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded">Free</span>
        </div>
    </div>
    </a>
</div>