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
$app_logo   = get_the_post_thumbnail_url($post_id, 'thumbnail');

if (empty($app_banner)) {
    $app_banner = $app_logo;
}

$app_url = get_the_permalink();

// Detect first (LCP) item
$is_first = !empty($args['is_first']);

// Banner image attributes
$banner_loading = $is_first ? 'eager' : 'lazy';
$banner_class   = 'w-full h-48 object-cover rounded-xl bg-gray-200 dark:bg-gray-700';

// Logo image attributes (always lazy)
$logo_loading = 'lazy';
$logo_class   = 'rounded-xl shadow-md w-full h-full object-contain bg-gray-100 dark:bg-gray-800';

// Lazy-load handling
if ($is_first) {
    // Explicitly opt out of any lazy-load JS
    $banner_class .= ' skip-lazy lcp-image';
} else {
    $banner_class .= ' lazyload';
    $logo_class   .= ' lazyload';
}
?>

<div class="carousel-cell mr-4 w-[85vw] sm:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1rem)] shrink-0 group">
    <div class="relative mb-4">
        <img
            class="<?php echo esc_attr($banner_class); ?>"
            src="<?php echo esc_url($app_banner); ?>"
            alt="<?php echo esc_attr($app_name); ?>"
            width="312"
            height="192"
            loading="<?php echo esc_attr($banner_loading); ?>"
            <?php if ($is_first) : ?>
                fetchpriority="high"
                decoding="async"
            <?php endif; ?>
        >



        <div class="absolute bottom-0 left-0 w-full p-3 rounded-b-xl bg-gradient-to-t from-black/70 via-black/30 to-transparent">
            <p class="text-white text-sm line-clamp-2 dark:text-gray-300">
                <?php echo esc_html($app_description); ?>
            </p>
        </div>
    </div>

    <div class="app-items flex items-center gap-4">
        <div class="flex-shrink-0 w-20 h-20">
            <img
                src="<?php echo esc_url($app_logo); ?>"
                alt="<?php echo esc_attr($app_name); ?>"
                class="<?php echo esc_attr($logo_class); ?>"
                width="80"
                height="80"
                loading="<?php echo esc_attr($logo_loading); ?>"
            >
        </div>

        <div class="flex-1 min-w-0 flex flex-col justify-center">
            <span class="block font-bold text-gray-900 dark:text-white truncate group-hover:text-primary transition-colors text-base">
                <?php echo esc_html($app_name); ?>
            </span>

            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 truncate mt-0.5">
                <?php echo esc_html($app_category); ?>
            </div>

            <div class="flex items-center text-xs font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap overflow-hidden mt-1 gap-2">
                <div class="flex items-center bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded">
                    <span class="mr-1 text-xs font-bold text-gray-700 dark:text-gray-300"><?php echo esc_html(number_format((float) $app_rating, 1)); ?></span>
                    <svg class="w-3 h-3 text-primary" viewBox="0 0 20 20" aria-hidden="true" fill="currentColor">
                        <path d="M10 1.5l2.7 5.47 6.03.88-4.36 4.25 1.03 6.01L10 15.9 4.6 18.1l1.03-6.01L1.28 7.85l6.03-.88L10 1.5z"></path>
                    </svg>
                </div>
                <?php if (!empty($app_mod_info)) : ?>
                    <span class="bg-red-500/10 text-red-600 dark:text-red-400 dark:bg-red-500/20 px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider truncate"><?php echo esc_html($app_mod_info); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <a href="<?php echo esc_url($app_url); ?>"
           class="flex-shrink-0 btn-primary-action">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Instalar
        </a>
    </div>
</div>
