<?php
$post_id = $args['post_id'];

$app_name = get_the_title($post_id);

$app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;

$app_category = apkup_get_primary_category_name($post_id);
$app_description = apkup_get_post_short_description($post_id);

$app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail');

$app_url = get_the_permalink($post_id);
?>
<a href="<?php echo esc_url($app_url); ?>" class="mr-4 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition-shadow">
    <div class="p-3">
        <div class="flex items-start justify-between mb-2">
            <div class="flex items-center min-w-0">
                <div class="w-12 h-12 rounded-lg overflow-hidden mr-2 shrink-0">
                    <img src="<?php echo $app_logo; ?>" alt="<?php echo $app_name; ?> Icon" class="w-full h-full object-cover">
                </div>
                <div class="min-w-0">
                    <h3 class="font-bold text-gray-800 dark:text-gray-200 text-sm truncate"><?php echo $app_name; ?></h3>
                    <p class="text-gray-500 dark:text-gray-300 text-xs truncate"><?php echo esc_html($app_category); ?></p>
                </div>
            </div>
            <div class="flex items-center bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded shrink-0">
                <svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <span class="text-xs font-medium text-gray-800 dark:text-gray-300 ml-1"><?php echo esc_html(number_format((float)$app_rating, 1)); ?></span>
            </div>
        </div>
        <p class="text-gray-600 dark:text-gray-300 text-xs line-clamp-2"><?php echo esc_html($app_description); ?></p>
    </div>
</a>