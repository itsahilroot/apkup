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
    <div class="md:flex md:gap-8 lg:gap-12">
        <div class="flex-1 min-w-0">
            <div class="text-title mb-7 text-center md:text-left">
                <h1 class="title text-3xl md:text-5xl text-gray-700 dark:text-gray-200 font-semibold"><?php echo $app_name; ?></h1>
            </div>
            <div class="app-icon flex justify-center md:justify-end md:hidden mb-8" skeleton-bg>
                <img fetchpriority="high" class="lazyload rounded-2xl shadow-lg" src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%201%201'%3E%3C/svg%3E" data-src="<?php echo $app_logo_full; ?>" width="220" height="220" alt="<?php echo $app_name; ?>">
            </div>
             
            <div class="app-buttons w-full md:max-w-2xl mx-auto md:mx-0 bg-white/60 dark:bg-gray-800/60 backdrop-blur-xl border border-gray-200/70 dark:border-gray-700/60 rounded-3xl p-5 md:p-7 shadow-sm hover:shadow-lg transition-all duration-500">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <a href="#download-links" class="btn-download !w-full md:!w-auto !px-10 !py-4 md:!min-w-[240px]">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <div class="flex flex-col items-start leading-tight">
                            <span class="text-[17px] tracking-wide relative z-10">Descargar APK</span>
                            <?php if(!empty($app_size)) : ?><span class="text-[11px] text-white/90 font-normal relative z-10"><?php echo $app_size; ?></span><?php endif; ?>
                        </div>
                    </a>
                    
                    <div class="flex justify-between md:justify-start items-center gap-6 md:gap-8 w-full md:w-auto">
                        <div class="flex flex-col items-center flex-1 md:flex-none bg-gray-50/50 dark:bg-gray-900/30 p-3 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                            <div id="rateYo" data-rateyo-rating="<?php echo esc_html(number_format((float)$new_rating_average, 1)); ?>" data-post_id="<?php the_ID(); ?>" style="padding: 0px; width: 110px;" class="jq-ry-container mb-1"></div>
                            <div class="text-[13px] font-medium text-gray-500 dark:text-gray-400 flex items-baseline gap-1">
                                <span id="currentRating" class="text-gray-900 dark:text-white font-bold text-[16px]"><?php echo esc_html(number_format((float)$new_rating_average, 1)); ?></span>
                                <span class="text-gray-400">/ 5</span> 
                                <span class="text-[11px] opacity-70 ml-1">(<span id="totalVotes"><?php echo esc_html($new_rating_users); ?></span>)</span>
                            </div>
                        </div>
                        
                        <div class="w-px h-12 bg-gray-200 dark:bg-gray-700 hidden md:block"></div>
                        
                        <a href="javascript:void(0);" id="post-share" class="group flex flex-col items-center gap-1.5 p-3 rounded-2xl text-gray-400 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-all bg-gray-50/50 dark:bg-gray-900/30 border border-gray-100 dark:border-gray-700/50 hover:border-primary/20">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 256 256" class="transform group-hover:scale-110 transition-transform">
                                <path d="M176,160a39.89,39.89,0,0,0-28.62,12.09l-46.1-29.63a39.8,39.8,0,0,0,0-28.92l46.1-29.63a40,40,0,1,0-8.66-13.45l-46.1,29.63a40,40,0,1,0,0,55.82l46.1,29.63A40,40,0,1,0,176,160Zm0-128a24,24,0,1,1-24,24A24,24,0,0,1,176,32ZM64,152a24,24,0,1,1,24-24A24,24,0,0,1,64,152Zm112,72a24,24,0,1,1,24-24A24,24,0,0,1,176,224Z"></path>
                            </svg>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Share</span>
                        </a>
                    </div>
                </div>
                
                <div class="h-px bg-gray-200/80 dark:bg-gray-700/60 my-5"></div>
                
                <div class="flex flex-wrap items-center gap-y-3 gap-x-6">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-gray-100 dark:bg-gray-700/50 rounded-lg text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-wider">Update</span>
                            <span class="text-[13px] font-medium text-gray-800 dark:text-gray-200"><?php echo $post_updated_date; ?></span>
                        </div>
                    </div>
                    
                    <?php if(!empty($app_version)) : ?>
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-gray-100 dark:bg-gray-700/50 rounded-lg text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-wider">Version</span>
                            <span class="text-[13px] font-medium text-gray-800 dark:text-gray-200"><?php echo $app_version; ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($primary_cat) : ?>
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-gray-100 dark:bg-gray-700/50 rounded-lg text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-wider">Category</span>
                            <a href="<?php echo esc_url($primary_cat['url']); ?>" class="text-[13px] font-medium text-primary hover:text-primary/80"><?php echo esc_html($primary_cat['name']); ?></a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($app_requires)) : ?>
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-gray-100 dark:bg-gray-700/50 rounded-lg text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-wider">Requires</span>
                            <span class="text-[13px] font-medium text-gray-800 dark:text-gray-200">Android <?php echo apkup_extract_number($app_requires) ?: '8.0'; ?>+</span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if(!empty($app_mod_info)) : ?>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                    <div class="flex gap-2.5 items-center">
                        <span class="flex items-center justify-center shrink-0 w-8 h-8 rounded-full bg-green-100/80 dark:bg-green-900/40 text-green-600 dark:text-green-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </span>
                        <span class="text-[13px] font-medium text-gray-700 dark:text-gray-300"><?php echo esc_html($app_mod_info); ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="app-icon hidden md:flex justify-center md:justify-end w-48 h-48">
            <img fetchpriority="high" class="rounded-2xl shadow-lg w-full h-full" src="<?php echo $app_logo_full; ?>" alt="<?php echo $app_name; ?>">
        </div>
    </div>
</div>

<!-- Share Modal -->
<div id="share-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="share-overlay"></div>
    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all scale-100 opacity-100">
        <!-- Header -->
        <div class="p-5 flex items-start justify-between">
            <div class="flex items-center gap-4">
                <img src="<?php echo $app_logo_full; ?>" alt="<?php echo $app_name; ?>" class="w-12 h-12 rounded-full object-cover shadow-sm bg-gray-100 dark:bg-gray-700">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight"><?php echo $app_name; ?></h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Share this app</p>
                </div>
            </div>
            <button id="close-share-modal" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Social Icons -->
        <div class="px-5 pb-2 flex gap-4 overflow-x-auto py-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
            <!-- Telegram -->
            <a href="https://t.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode($app_name); ?>" target="_blank" rel="noopener noreferrer" class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-[#2AABEE] text-white hover:opacity-90 transition-opacity">
                <svg class="w-6 h-6 transform -ml-0.5 translate-y-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 11.944 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
            </a>
            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-[#1877F2] text-white hover:opacity-90 transition-opacity">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <!-- WhatsApp -->
            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($app_name . ' ' . get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-[#25D366] text-white hover:opacity-90 transition-opacity">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
            </a>
            <!-- X/Twitter -->
            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($app_name); ?>&url=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-black text-white hover:opacity-90 transition-opacity">
               <svg class="w-6 h-6 p-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
        </div>
        
        <!-- Copy Link -->
        <div class="p-5">
            <div class="relative flex items-center">
                <input type="text" readonly value="<?php echo get_permalink(); ?>" class="w-full bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600/50 rounded-lg py-3 px-4 text-sm text-gray-500 dark:text-gray-400 focus:outline-none select-all">
                <button id="copy-link-btn" data-url="<?php echo get_permalink(); ?>" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-primary hover:bg-primary/10 rounded-md transition-colors group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <span class="absolute right-0 -top-8 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">Copy link</span>
                </button>
            </div>
        </div>
    </div>
</div>