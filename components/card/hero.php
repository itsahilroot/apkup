<?php
// Featured box in home
$post_id = get_the_ID();

$app_name = get_the_title();

$data = get_post_meta($post_id, 'datos_informacion', true);
$app_mod_info = $data['mod_info'] ?? '';

$app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;

$app_category = apkup_get_primary_category_name($post_id);
$app_description = apkup_get_post_short_description($post_id);

$app_banner = get_post_meta($post_id, 'wp_poster_GP', true);
$app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail');
if(empty($app_banner)) {
    $app_banner = $app_logo;
}

$app_url = get_the_permalink();

$is_first = $args['is_first'] ?? false;
$loading_attr = $is_first ? 'eager' : 'lazy';
$img_class = 'w-full h-48 object-cover rounded-xl bg-gray-200 dark:bg-gray-700';
$logo_class = 'rounded-xl shadow-md w-full h-full object-contain bg-gray-100 dark:bg-gray-800';

if (!$is_first) {
    $img_class .= ' lazyload';
    $logo_class .= ' lazyload';
}
?>
<div class="carousel-cell mr-4 w-[85vw] sm:w-78 shrink-0 group">
    <div class="relative mb-4">
        <img class="<?php echo $img_class; ?>" src="<?php echo $app_banner; ?>" alt="<?php echo $app_name; ?>" width="312" height="192" loading="<?php echo $loading_attr; ?>">
		<?php if(!empty($app_mod_info)) : ?>
		<p class="absolute top-3 left-3 text-white text-sm font-bold px-2 rounded-full" style="width: fit-content;background-color: #df1e1e;">MOD</p>
		<?php endif; ?>
        <div class="absolute bottom-0 left-0 w-full p-3 rounded-b-xl bg-gradient-to-t from-black/70 via-black/30 to-transparent">
            <p class="text-white text-sm line-clamp-2 dark:text-gray-300"><?php echo esc_html($app_description); ?></p>
        </div>
    </div>
    <div class="app-items flex items-center gap-4">
        <div class="flex-shrink-0 w-20 h-20">
            <img src="<?php echo $app_logo; ?>" alt="<?php echo $app_name; ?>" class="<?php echo $logo_class; ?>" width="80" height="80" loading="<?php echo $loading_attr; ?>">
        </div>
        <div class="flex-1 min-w-0">
            <span class="block font-bold text-gray-900 dark:text-white truncate group-hover:text-primary transition-colors text-base"><?php echo $app_name; ?></span>
            <div class="flex items-center text-xs font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap overflow-hidden mt-1">
                <span class="mr-1 truncate"><?php echo esc_html($app_category); ?></span>
                <span class="mr-1"> • <?php echo esc_html(number_format((float)$app_rating, 1)); ?></span>
                <svg class="w-3 h-3 text-yellow-500" viewBox="0 0 20 20" aria-hidden="true" fill="currentColor">
                    <path d="M10 1.5l2.7 5.47 6.03.88-4.36 4.25 1.03 6.01L10 15.9 4.6 18.1l1.03-6.01L1.28 7.85l6.03-.88L10 1.5z"></path>
                </svg>
            </div>
        </div>
        <a href="<?php echo esc_url($app_url); ?>" class="flex-shrink-0 shadow-md bg-primary hover:bg-green-700 text-white px-8 py-2 rounded-2xl text-sm h-10 flex items-center after:content-[''] after:absolute after:inset-0 after:z-10">Instalar</a>
    </div>
</div>