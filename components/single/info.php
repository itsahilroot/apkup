<?php
$post_id = get_the_ID();

$app_name = get_the_title();
$post_updated_date = get_the_modified_date('d M Y', $post_id);
$app_logo_full = get_the_post_thumbnail_url($post_id, 'full');

$is_app_mod = get_post_meta($post_id, 'app_type', true);

$data = get_post_meta($post_id, 'datos_informacion', true);
$data = is_array($data) ? $data : [];
$app_version = $data['version'] ?? '';
$app_requires = $data['requerimientos'] ?? '';
$app_size = $data['tamano'] ?? '';
$app_mod_info = $data['mod_info'] ?? '';

$new_rating_average = get_post_meta($post_id, 'new_rating_average', true) ?: 0;
$new_rating_users = get_post_meta($post_id, 'new_rating_users', true) ?: 0;

$price = apkup_get_appyn_datos_info('offer', 'price') ?: 'gratis';
if ($price === 'gratis') {
    $price = 'Free';
} else {
    $price = 'Paid';
}

$primary_cat = apkup_get_primary_post_category($post_id);
?>
<div class="app-info mb-10">
    <div class="md:flex">
        <div class="flex-1">
            <div class="text-title mb-7 text-center md:text-left">
                <h1 class="title text-3xl md:text-5xl text-gray-700 dark:text-gray-200 font-semibold"><?php echo $app_name; ?></h1>
            </div>
            <div class="app-icon flex justify-center md:justify-end md:hidden mb-8">
                <img fetchpriority="high" class="rounded-2xl shadow-lg" src="<?php echo $app_logo_full; ?>" width="220" height="220" alt="<?php echo $app_name; ?>">
            </div>
            <div class="app-meta mb-7 flex gap-4 overflow-x-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none'] md:flex-wrap md:overflow-visible md:gap-4 whitespace-nowrap py-2">
                <div class="app-meta-item flex flex-col pr-4 md:border-r md:border-gray-200 md:pr-8 text-sm md:text-base gap-2">
                    <span class="text-gray-500 dark:text-gray-200">Actualizado</span>
                    <span class="text-gray-800 dark:text-gray-300 font-medium"><?php echo $post_updated_date; ?></span>
                </div>
                <?php if(!empty($app_version)) : ?>
                <div class="app-meta-item flex flex-col pr-4 md:border-r md:border-gray-200 md:pr-8 text-sm md:text-base gap-2">
                    <span class="text-gray-500 dark:text-gray-200">Version</span>
                    <span class="text-gray-800 dark:text-gray-300 font-medium"><?php echo $app_version; ?></span>
                </div>
                <?php endif; if(!empty($app_requires)) : ?>
                <div class="app-meta-item flex flex-col pr-4 md:border-r md:border-gray-200 md:pr-8 text-sm md:text-base gap-2">
                    <span class="text-gray-500 dark:text-gray-200">Requisitos</span>
                    <span class="text-gray-800 dark:text-gray-300 font-medium">Android <?php echo apkup_extract_number($app_requires) ?: '8.0'; ?>+</span>
                </div>
                <?php endif; if ($primary_cat) : ?>
                    <div class="app-meta-item flex flex-col pr-4 md:border-r md:border-gray-200 md:pr-8 text-sm md:text-base gap-2">
                        <span class="text-gray-500 dark:text-gray-200">Género</span>
                        <a href="<?php echo esc_url($primary_cat['url']); ?>" class="text-gray-800 dark:text-gray-300 font-medium"><?php echo esc_html($primary_cat['name']); ?></span></a>
                    </div>
                <?php endif; if(!empty($price)) : ?>
                <div class="app-meta-item flex flex-col pr-4 text-sm <?php if(!empty($app_mod_info)) echo 'md:border-r md:border-gray-200 md:pr-8'; ?> md:text-base gap-2">
                    <span class="text-gray-500 dark:text-gray-200">Price</span>
                    <span class="text-gray-800 dark:text-gray-300 font-medium"><?php echo $price; ?></span>
                </div>
                <?php endif; if(!empty($app_mod_info)) : ?>
                <div class="app-meta-item flex flex-col pr-4 text-sm md:text-base gap-2">
                    <span class="text-gray-500 dark:text-gray-200">MOD Info</span>
                    <span class="text-gray-800 dark:text-gray-300 font-medium"><?php echo $app_mod_info; ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div class="app-buttons md:inline-block md:border md:border-gray-200 dark:md:border-gray-500 rounded-xl md:p-4 mx-auto md:mx-0 max-w-lg">
                <div class="flex flex-col md:flex-row md:items-center gap-8">
                    <a href="#download-links" class="bg-primary rounded-xl px-4 py-3 text-center text-md md:shrink-0 font-semibold text-white shadow-lg transition-all duration-300 hover:bg-primary dark:hover:bg-green-400 hover:shadow-xl hover:shadow-[rgba(0, 212, 14, 0.3)]">
                        Descargar <?php if(!empty($app_size)) : ?><span class="text-xs text-white/80">(<?php echo $app_size; ?>)</span><?php endif; ?>
                    </a>
                    <div class="flex justify-center md:justify-start items-center gap-8">
                        <div class="flex flex-col items-center">
                            <div id="rateYo" data-rateyo-rating="<?php echo esc_html(number_format((float)$new_rating_average, 1)); ?>" data-post_id="<?php the_ID(); ?>" style="padding: 0px; width: 170px;" class="jq-ry-container mb-1"></div>
                            <div class="text-sm text-gray-500 dark:text-gray-300">
                                <span id="currentRating"><?php echo esc_html(number_format((float)$new_rating_average, 1)); ?></span>
                                (<span id="totalVotes"><?php echo esc_html($new_rating_users); ?></span>)
                            </div>
                        </div>
                        <a href="javascript:void(0);" id="post-share" class="text-gray-400 hover:text-gray-600 flex flex-col items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M176,160a39.89,39.89,0,0,0-28.62,12.09l-46.1-29.63a39.8,39.8,0,0,0,0-28.92l46.1-29.63a40,40,0,1,0-8.66-13.45l-46.1,29.63a40,40,0,1,0,0,55.82l46.1,29.63A40,40,0,1,0,176,160Zm0-128a24,24,0,1,1-24,24A24,24,0,0,1,176,32ZM64,152a24,24,0,1,1,24-24A24,24,0,0,1,64,152Zm112,72a24,24,0,1,1,24-24A24,24,0,0,1,176,224Z"></path>
                            </svg>
                            Share
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-icon hidden md:flex justify-center md:justify-end w-48 h-48">
            <img fetchpriority="high" class="rounded-2xl shadow-lg w-full h-full" src="<?php echo $app_logo_full; ?>" alt="<?php echo $app_name; ?>">
        </div>
    </div>
</div>