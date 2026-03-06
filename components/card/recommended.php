<?php
$post_id = $args['post_id'];
$serial = isset($args['serial']) ? $args['serial'] : '';

$app_name = get_the_title($post_id);

$app_rating = get_post_meta($post_id, 'new_rating_average', true) ?: 0;

$app_category_info = apkup_get_primary_post_category($post_id);
$app_category = $app_category_info ? $app_category_info['name'] : 'App';

$app_logo = get_the_post_thumbnail_url($post_id, 'thumbnail');

$app_url = get_the_permalink($post_id);

$data = get_post_meta($post_id, 'datos_informacion', true);
$data = is_array($data) ? $data : [];
$app_version = $data['version'] ?? '';
$app_size = $data['tamano'] ?? '';

$is_app_mod = get_post_meta($post_id, 'app_type', true);
$app_mod_info = $data['mod_info'] ?? '';
$is_mod = ($is_app_mod === 'mod' || !empty($app_mod_info));
?>
<article class="carousel-cell mr-4 w-72 shrink-0 group">
    <a href="<?php echo esc_url($app_url); ?>" class="flex flex-col bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-100 dark:border-gray-700/50 p-4 relative overflow-hidden h-full min-h-[170px]">
        
        <!-- Large Serial Number Watermark -->
        <?php if ($serial) : ?>
            <div class="absolute -right-2 top-0 text-7xl font-black text-gray-100 dark:text-gray-700/50 select-none pointer-events-none group-hover:text-primary/20 transition-colors z-0">
                #<?php echo esc_html($serial); ?>
            </div>
        <?php endif; ?>

        <div class="flex items-start gap-4 z-10 relative flex-grow">
            <!-- Icon -->
            <div class="w-[60px] h-[60px] rounded-2xl overflow-hidden shrink-0 shadow-sm relative skeleton-bg">
                <img src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%201%201'%3E%3C/svg%3E" data-src="<?php echo esc_url($app_logo); ?>" alt="<?php echo esc_attr($app_name); ?> Icon" class="w-full h-full object-cover lazyload group-hover:scale-105 transition-transform duration-300">
            </div>

            <!-- Title and Meta Info -->
            <div class="flex-1 min-w-0 pt-0.5">
                <h3 class="font-bold text-gray-900 dark:text-white text-base leading-tight group-hover:text-primary transition-colors line-clamp-2" title="<?php echo esc_attr($app_name); ?>"><?php echo esc_html($app_name); ?></h3>
                
                <div class="flex flex-wrap items-center gap-1.5 mt-2">
                    <span class="text-primary text-[10px] font-semibold bg-primary/10 px-1.5 py-0.5 rounded border border-primary/20"><?php echo esc_html($app_category); ?></span>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col justify-end z-10 relative mt-2 pt-2">
            <!-- Description / Meta -->
            <div class="flex items-center gap-2 mb-3 text-[12.5px] text-gray-500 dark:text-[#888078] min-h-[19px]">
                <?php if(!empty($app_version) || !empty($app_size)) : ?>
                    <?php if(!empty($app_version)) : ?><span>v<?php echo esc_html($app_version); ?></span><?php endif; ?>
                    <?php if(!empty($app_version) && !empty($app_size)) : ?><span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"></span><?php endif; ?>
                    <?php if(!empty($app_size)) : ?><span><?php echo esc_html($app_size); ?></span><?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Footer: Ratings and MOD Info aligned -->
            <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center space-x-1.5 shrink-0 bg-primary/10 dark:bg-primary/20 px-2 py-0.5 rounded border border-primary/20 dark:border-primary/30">
                    <svg class="w-3.5 h-3.5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300"><?php echo esc_html(number_format((float)$app_rating, 1)); ?></span>
                </div>
                
                <?php if($is_mod) : ?>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-red-600 dark:text-red-400 bg-red-500/10 px-2.5 py-1 rounded-full">MOD</span>
                <?php endif; ?>
            </div>
        </div>
        
    </a>
</article>