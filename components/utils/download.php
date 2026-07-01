<?php
$post_id = get_the_ID();
$download_links = apkup_get_datos_download($post_id);
$app_name = get_the_title($post_id);
$app_logo_full = get_the_post_thumbnail_url($post_id, 'full');

$data = get_post_meta($post_id, 'datos_informacion', true);
$data = is_array($data) ? $data : [];
$app_version = $data['version'] ?? '';
$app_requires = $data['requerimientos'] ?? '';

$au_download_faqs = get_theme_mod('au_download_faqs', []);
$au_dl_timer = (int) get_theme_mod('au_dl_timer', '5');
if($au_dl_timer < 1 || empty($au_dl_timer)) {
    $au_dl_timer = 10;
}
$au_dl_timer = $au_dl_timer * 1000;

$au_home_footer_tg_url = get_theme_mod('au_home_footer_tg_url', 'https://t.me/apkgamingstore');

global $custom_download_id;
$download_id = absint($custom_download_id);

get_header(); 
$au_dl_banner_swt = get_theme_mod('au_dl_banner_swt', false);
$app_banner = get_post_meta($post_id, 'wp_poster_GP', true);
?>

<?php if ($au_dl_banner_swt && !empty($app_banner)): ?>
<div class="download-banner w-full h-64 md:h-80 relative overflow-hidden -z-10 before:absolute before:inset-0 before:bg-gradient-to-t before:from-white before:via-white/70 before:to-transparent dark:before:from-gray-900 dark:before:via-gray-900/70">
    <img src="<?php echo esc_url($app_banner); ?>" alt="<?php echo esc_attr($app_name); ?> Banner" class="w-full h-full object-cover">
</div>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 flex flex-col items-center -mt-32 relative z-10 px-4">
<?php else: ?>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col items-center my-10 px-4">
<?php endif; ?>
    <div class="mb-12">
        <img src="<?php echo esc_url($app_logo_full); ?>" width="220" height="220" alt="<?php echo $app_name; ?>" class="rounded-3xl shadow-xl border-primary/20 p-2 dark:border-primary">
    </div>
    <h2 class="text-3xl text-gray-800 dark:text-gray-200 my-2">
        Descargar <?php echo $app_name; ?>
    </h2>
    <div class="w-full max-w-md mb-8 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="px-3 py-1.5 rounded-full border border-slate-200 dark:border-white/5 bg-slate-50 dark:bg-slate-900/50 text-slate-600 dark:text-slate-350 text-xs font-semibold select-none shadow-sm">
                v<?php echo $app_version; ?>
            </div>
            <div class="px-3 py-1.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/10 text-xs font-semibold select-none flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg> Android <?php echo apkup_extract_number($app_requires) ?: '8.0'; ?>+
            </div>
        </div>
        <div class="flex items-center gap-1.5 pl-2">
            <div class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-700 animate-pulse"></div>
            <div class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-700 animate-pulse [animation-delay:0.2s]"></div>
            <div class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-700 animate-pulse [animation-delay:0.4s]"></div>
            <div class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-700 animate-pulse [animation-delay:0.6s]"></div>
        </div>
    </div>
    <?php
    $links = [];
    if (!empty($download_links['links_options'])) {
        $links = $download_links['links_options'];
    } else {
        foreach ($download_links as $k => $v) {
            if (is_int($k) && is_array($v)) {
                $links[$k] = $v;
            }
        }
    }

    $is_mediafire_url = false;
    $active_download_url = '';
    if (!empty($links)) {
        foreach ($links as $index => $download) {
            if ((int)$index == (int)$download_id || $index == $download_id) {
                $download_url = !empty($download['link_original']) ? $download['link_original'] : $download['link'];
                $active_download_url = $download_url;
                $afp_mediafire_direct = get_theme_mod('afp_mediafire_direct', false);
                if ($afp_mediafire_direct && !empty($download_url) && preg_match('/mediafire\.com/', $download_url)) {
                    $is_mediafire_url = true;
                }
            }
        }
    }
    ?>

    <?php download_top_ad('div'); ?>
    <div id="progress-section" class="w-full max-w-md mb-12" data-duration="<?php echo $au_dl_timer; ?>" data-is-mediafire="<?php echo $is_mediafire_url ? 'true' : 'false'; ?>">
        <div class="flex items-center justify-between text-slate-800 dark:text-white mb-3">
            <div class="flex flex-col">
                <span class="text-[10px] uppercase tracking-wider text-slate-400 dark:text-slate-500 font-bold mb-0.5">Estado</span>
                <span class="text-sm font-extrabold">Preparando enlaces...</span>
            </div>
            <div class="text-right flex flex-col items-end">
                <span class="text-[10px] uppercase tracking-wider text-slate-400 dark:text-slate-500 font-bold mb-0.5">Espera</span>
                <div class="flex items-baseline gap-0.5 text-primary">
                    <span id="seconds-left" class="text-lg font-black tracking-tight leading-none"><?php echo ($au_dl_timer / 1000); ?></span>
                    <span class="text-xs font-bold opacity-75">s</span>
                </div>
            </div>
        </div>
        
        <div class="w-full h-2.5 bg-slate-100 dark:bg-slate-800/80 rounded-full overflow-hidden" role="progressbar" aria-valuemin="0" aria-valuemax="100">
            <div id="progress-fill" class="h-full bg-primary rounded-full w-0" style="width: 0%;"></div>
        </div>
        
        <p class="mt-4 text-center text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Tus enlaces aparecerán pronto
        </p>
    </div>
    <div id="button-group" class="hidden flex-col w-full max-w-md gap-3 mb-12">
        <?php
        if (!empty($links)) :
            foreach ($links as $index => $download) :
                if ((int)$index == (int)$download_id || $index == $download_id) :
                    // Priority: link_original > link
                    $download_url = !empty($download['link_original']) ? $download['link_original'] : $download['link'];
                    if (!empty($download_url)) : ?>
                        <a href="<?php echo esc_url($download_url); ?>" target="_blank" class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white flex items-center justify-center gap-2 rounded-2xl transition duration-300 font-bold text-sm shadow-lg shadow-primary/25 btn-download" <?php if ($is_mediafire_url) : ?>data-original-url="<?php echo esc_url($download_url); ?>"<?php endif; ?>>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3v12"/>
                                <path d="M7.5 10.5 12 15l4.5-4.5"/>
                                <path d="M3 15v3a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-3"/>
                            </svg>
                            <span id="downloadBtn">Descargar <?php echo !empty($download['type']) ? esc_html($download['type']) : 'APK'; ?></span>
                        </a>
                    <?php endif;
                endif;
            endforeach;
        endif;
        ?>
		<?php if (!empty($au_home_footer_tg_url)) : ?>
		<a href="<?php echo esc_url($au_home_footer_tg_url); ?>" target="_blank" class="w-full py-3.5 bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center gap-2 rounded-2xl transition duration-300 font-bold text-sm shadow-lg shadow-blue-500/25">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                <path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.3 3.64 12c-.88-.25-.89-.86.2-1.3l15.97-6.16c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z"/>
            </svg>
            <span>Únete a Telegram</span>
        </a>
		<?php endif; ?>
        <a href="<?php echo get_site_url(); ?>" class="w-full py-3 border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-600 dark:text-slate-350 flex items-center justify-center gap-2 rounded-2xl transition duration-300 font-bold text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="m6 12 6 5v-4h6v-2h-6V7z"></path>
            </svg>
            <span>BACK TO HOME</span>
        </a>
    </div>
    <?php download_bottom_ad('div'); ?>
    <?php if (!empty($au_download_faqs)) : ?>
        <section class="faq w-full max-w-2xl">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">
                Preguntas frecuentes
            </h2>
            <div class="space-y-3">
                <?php foreach ($au_download_faqs as $faq) : ?>
                    <details class="group rounded-xl border border-gray-200 bg-white p-4 shadow-sm open:shadow-md open:border-primary/40 dark:open:border-primary/80 transition-all dark:bg-gray-900 dark:border-gray-800">
                        <summary class="flex cursor-pointer items-center justify-between gap-3 font-semibold">
                            <span class="text-gray-800 dark:text-gray-200"><?php echo $faq['question']; ?></span>
                            <svg class="chev h-5 w-5 text-primary transition-transform dark:text-primary/80" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                            </svg>
                        </summary>
                        <div class="mt-2 text-gray-600 dark:text-gray-300 animate-[fadeIn_.25s_ease]">
                            <?php echo $faq['answer']; ?>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>