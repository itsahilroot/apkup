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
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 flex flex-col items-center -mt-24 relative z-10">
<?php else: ?>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col items-center my-10">
<?php endif; ?>

    <!-- Main Premium Card Box -->
    <div class="relative w-full max-w-2xl bg-white/80 dark:bg-[#0b0f19]/85 backdrop-blur-2xl rounded-[32px] p-8 sm:p-10 border border-slate-200/50 dark:border-white/5 shadow-[0_30px_100px_rgba(0,0,0,0.06)] overflow-hidden">
        
        <!-- Glowing Ambient Backdrops -->
        <div class="absolute -top-32 -left-32 w-64 h-64 rounded-full bg-primary/20 blur-[90px] pointer-events-none animate-pulse"></div>
        <div class="absolute -bottom-32 -right-32 w-64 h-64 rounded-full bg-blue-500/10 blur-[90px] pointer-events-none animate-pulse"></div>
        
        <div class="relative z-10 flex flex-col items-center">
            <!-- App Icon Wrapper with Light Shadow -->
            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-[28px] mb-6 relative shadow-[0_8px_30px_rgba(0,0,0,0.05)] dark:shadow-[0_15px_40px_rgba(0,0,0,0.2)] border border-slate-100 dark:border-white/5 p-1 bg-white dark:bg-slate-900">
                <img src="<?php echo esc_url($app_logo_full); ?>" alt="<?php echo $app_name; ?>" class="w-full h-full rounded-[24px] object-cover">
                <span class="absolute -top-1 -right-1 flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500 text-white shadow border-2 border-white dark:border-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" /></svg>
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-black text-center text-slate-800 dark:text-white tracking-tight mb-1">
                <?php echo $app_name; ?>
            </h1>

            <p class="text-[11px] text-slate-400 dark:text-slate-500 mb-6 text-center font-extrabold uppercase tracking-widest">
                v<?php echo $app_version; ?> • Secure Download
            </p>

            <!-- Grid details -->
            <div class="w-full grid grid-cols-2 gap-4 mb-8">
                <div class="bg-slate-50/50 dark:bg-slate-900/30 border border-slate-100 dark:border-white/5 rounded-2xl p-4 flex flex-col items-center justify-center">
                    <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 mb-1">Requisitos</span>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">Android <?php echo apkup_extract_number($app_requires) ?: '8.0'; ?>+</span>
                </div>
                <div class="bg-slate-50/50 dark:bg-slate-900/30 border border-slate-100 dark:border-white/5 rounded-2xl p-4 flex flex-col items-center justify-center">
                    <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 mb-1">Seguridad</span>
                    <span class="text-xs font-bold text-emerald-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="inline"><path d="M20 13c0 5-3.5 7.5-7.66 9.7a1 1 0 0 1-.68 0C7.5 20.5 4 18 4 13V6a1 1 0 0 1 .76-.97l8.24-2a1 1 0 0 1 .5 0l8.24 2A1 1 0 0 1 20 6Z"/><path d="m9 12 2 2 4-4"/></svg> Verificado
                    </span>
                </div>
            </div>

            <!-- Dynamic Verification Checklist -->
            <div id="security-check-list" class="w-full max-w-md bg-slate-50/40 dark:bg-slate-950/20 border border-slate-100 dark:border-white/5 rounded-2xl p-5 mb-8 text-left space-y-4">
                <div class="flex items-center justify-between text-xs font-semibold text-slate-600 dark:text-slate-300" id="step-1">
                    <span class="flex items-center gap-2">
                        <span class="step-icon flex items-center justify-center w-5 h-5 rounded-full bg-primary/10 text-primary">
                            <span class="animate-spin w-3 h-3 border-2 border-primary border-t-transparent rounded-full"></span>
                        </span>
                        Verificando firma de seguridad...
                    </span>
                    <span class="step-status text-[10px] font-bold text-slate-400 dark:text-slate-500">En progreso</span>
                </div>
                <div class="flex items-center justify-between text-xs font-semibold text-slate-400 dark:text-slate-600" id="step-2">
                    <span class="flex items-center gap-2">
                        <span class="step-icon flex items-center justify-center w-5 h-5 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-400 dark:text-slate-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        </span>
                        Escaneando archivos en la nube...
                    </span>
                    <span class="step-status text-[10px] font-bold">Esperando</span>
                </div>
                <div class="flex items-center justify-between text-xs font-semibold text-slate-400 dark:text-slate-600" id="step-3">
                    <span class="flex items-center gap-2">
                        <span class="step-icon flex items-center justify-center w-5 h-5 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-400 dark:text-slate-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        </span>
                        Generando servidor de descarga rápida...
                    </span>
                    <span class="step-status text-[10px] font-bold">Esperando</span>
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

            <!-- Loader / Timer Section -->
            <div id="progress-section" class="w-full max-w-md mb-6" data-duration="<?php echo $au_dl_timer; ?>" data-is-mediafire="<?php echo $is_mediafire_url ? 'true' : 'false'; ?>">
                <div class="flex items-center justify-between mb-3 text-slate-850 dark:text-white">
                    <span class="text-xs font-bold text-slate-400 dark:text-slate-500">Progreso de inicialización</span>
                    <span class="text-sm font-extrabold text-primary"><span id="seconds-left"><?php echo ($au_dl_timer / 1000); ?></span>s</span>
                </div>
                <div class="w-full h-1.5 bg-slate-100 dark:bg-slate-800/80 rounded-full overflow-hidden relative">
                    <div id="progress-fill" class="h-full bg-gradient-to-r from-primary to-emerald-400 rounded-full w-0"></div>
                </div>
            </div>

            <!-- Top Ad Slot -->
            <div class="mb-4 w-full text-center">
                <?php download_top_ad('div'); ?>
            </div>

            <!-- Download Button Group -->
            <div id="button-group" class="hidden flex-col w-full max-w-md gap-3.5">
                <?php
                if (!empty($links)) :
                    foreach ($links as $index => $download) :
                        if ((int)$index == (int)$download_id || $index == $download_id) :
                            $download_url = !empty($download['link_original']) ? $download['link_original'] : $download['link'];
                            if (!empty($download_url)) : ?>
                                <a href="<?php echo esc_url($download_url); ?>" target="_blank" class="w-full py-4 bg-primary hover:bg-primary-hover text-white flex items-center justify-center gap-2 rounded-2xl transition duration-300 font-bold text-sm shadow-lg shadow-primary/20 btn-download" <?php if ($is_mediafire_url) : ?>data-original-url="<?php echo esc_url($download_url); ?>"<?php endif; ?>>
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
                <a href="<?php echo esc_url($au_home_footer_tg_url); ?>" target="_blank" class="w-full py-4 bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center gap-2 rounded-2xl transition duration-300 font-bold text-sm shadow-lg shadow-blue-500/25">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                        <path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.3 3.64 12c-.88-.25-.89-.86.2-1.3l15.97-6.16c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z"/>
                    </svg>
                    <span>Únete a Telegram</span>
                </a>
                <?php endif; ?>

                <a href="<?php echo get_site_url(); ?>" class="w-full py-3.5 border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 flex items-center justify-center gap-2 rounded-2xl transition duration-300 font-bold text-xs uppercase tracking-wider">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                        <path d="m6 12 6 5v-4h6v-2h-6V7z"></path>
                    </svg>
                    <span>VOLVER AL INICIO</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Ad Slot bottom -->
    <div class="mb-2 w-full text-center">
        <?php download_bottom_ad('div'); ?>
    </div>

    <!-- FAQ Accordion section -->
    <?php if (!empty($au_download_faqs)) : ?>
        <style>
            .parent-faq-accordion[open] > summary .parent-chev {
                transform: rotate(180deg);
            }
            .child-faq-accordion[open] > summary .child-chev {
                transform: rotate(180deg);
            }
        </style>
        <section class="faq w-full max-w-2xl mt-4">
            <details class="parent-faq-accordion rounded-3xl border border-slate-200 dark:border-white/5 bg-white/60 dark:bg-slate-900/60 p-6 shadow-sm open:shadow-md transition-all">
                <summary class="flex cursor-pointer items-center justify-between gap-3 font-extrabold select-none list-none [&::-webkit-details-marker]:hidden">
                    <h2 class="text-xl sm:text-2xl text-gray-800 dark:text-white">
                        Preguntas frecuentes
                    </h2>
                    <svg class="parent-chev h-6 w-6 text-primary transition-transform duration-300 dark:text-primary" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                    </svg>
                </summary>
                
                <div class="space-y-4 mt-6 border-t border-slate-100 dark:border-white/5 pt-6 animate-[fadeIn_.25s_ease]">
                    <?php foreach ($au_download_faqs as $faq) : ?>
                        <details class="child-faq-accordion rounded-2xl border border-slate-200 dark:border-white/5 bg-white/40 dark:bg-slate-900/40 p-5 shadow-sm open:shadow-md transition-all">
                            <summary class="flex cursor-pointer items-center justify-between gap-3 font-semibold select-none list-none [&::-webkit-details-marker]:hidden">
                                <span class="text-gray-800 dark:text-gray-200 text-sm sm:text-base"><?php echo $faq['question']; ?></span>
                                <svg class="child-chev h-5 w-5 text-primary transition-transform duration-300 dark:text-primary" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                                </svg>
                            </summary>
                            <div class="mt-3 text-sm text-gray-600 dark:text-gray-400 font-light leading-relaxed border-t border-slate-100 dark:border-white/5 pt-3">
                                <?php echo $faq['answer']; ?>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>
            </details>
        </section>
    <?php endif; ?>
    <!-- Top Downloaded Apps & Games Section -->
    <?php
    $au_dl_top_downloaded_swt = get_theme_mod('au_dl_top_downloaded_swt', false);
    if ($au_dl_top_downloaded_swt) :
        $au_dl_top_downloaded_limit = intval(get_theme_mod('au_dl_top_downloaded_limit', '5'));
        $top_args = array(
            'post_type'           => 'post',
            'posts_per_page'      => $au_dl_top_downloaded_limit,
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
            'meta_key'            => 'px_views',
            'orderby'             => 'meta_value_num',
            'order'               => 'DESC',
        );
        $top_query = new WP_Query($top_args);
        if ($top_query->have_posts()) :
        ?>
            <style>
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(12px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                .animate-fade-in-up {
                    opacity: 0;
                    animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                }
            </style>
            <section class="top-downloaded w-full max-w-2xl mt-12 mb-6">
                <div class="flex items-center justify-between mb-5 px-1">
                    <h2 class="text-xl font-extrabold text-gray-800 dark:text-white tracking-tight">
                        Top Descargados
                    </h2>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest flex items-center gap-1">
                        Desliza 
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="animate-pulse"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </span>
                </div>
                <div class="flex overflow-x-auto snap-x snap-mandatory gap-5 no-scrollbar pb-4 -mx-4 px-4 sm:mx-0 sm:px-0">
                    <?php
                    $count = 0;
                    $rank = 1;
                    while ($top_query->have_posts()) : $top_query->the_post();
                        $top_id = get_the_ID();
                        $top_logo = get_the_post_thumbnail_url($top_id, 'thumbnail');
                        $top_rating = get_post_meta($top_id, 'new_rating_average', true) ?: 0;
                        $top_category_info = apkup_get_primary_post_category($top_id);
                        $top_category = $top_category_info ? $top_category_info['name'] : 'App';
                        
                        if ($count % 3 === 0) {
                            if ($count > 0) echo '</div>'; // close previous column
                            echo '<div class="flex flex-col gap-4 w-[280px] sm:w-[310px] shrink-0 snap-center">';
                        }

                        // Premium ranking badge style
                        $rank_class = '';
                        if ($rank === 1) {
                            $rank_class = 'bg-gradient-to-br from-amber-400 to-yellow-500 text-white shadow-md shadow-yellow-500/20';
                        } elseif ($rank === 2) {
                            $rank_class = 'bg-gradient-to-br from-slate-300 to-slate-400 text-white shadow-md shadow-slate-400/20';
                        } elseif ($rank === 3) {
                            $rank_class = 'bg-gradient-to-br from-amber-600 to-amber-700 text-white shadow-md shadow-amber-700/20';
                        } else {
                            $rank_class = 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400';
                        }
                    ?>
                        <a href="<?php the_permalink(); ?>" 
                           class="animate-fade-in-up flex items-center gap-3.5 p-3 rounded-2xl bg-white/40 dark:bg-slate-900/35 border border-slate-200/40 dark:border-white/5 hover:border-primary/30 dark:hover:border-primary/50 hover:bg-white dark:hover:bg-slate-900/90 shadow-[0_4px_20px_rgba(0,0,0,0.01)] hover:shadow-[0_10px_25px_rgba(0,0,0,0.04)] hover:-translate-y-[2px] transition-all duration-350 group"
                           style="animation-delay: <?php echo ($rank * 60); ?>ms;">
                            
                            <!-- Premium Rank Number Badge -->
                            <span class="text-xs font-black w-6 h-6 rounded-full flex items-center justify-center shrink-0 <?php echo $rank_class; ?>">
                                <?php echo $rank; ?>
                            </span>

                            <!-- App Icon with light shadow -->
                            <img class="w-12 h-12 rounded-xl object-cover shrink-0 shadow-sm border border-slate-100 dark:border-slate-800 group-hover:scale-105 transition-transform duration-300" src="<?php echo esc_url($top_logo); ?>" alt="<?php the_title_attribute(); ?>">
                            
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-xs sm:text-sm text-slate-850 dark:text-white truncate group-hover:text-primary transition-colors"><?php the_title(); ?></h4>
                                <div class="flex items-center gap-2 text-[11px] text-slate-450 dark:text-slate-500 mt-0.5 font-medium">
                                    <span><?php echo esc_html($top_category); ?></span>
                                    <span>•</span>
                                    <span class="flex items-center gap-0.5 text-amber-500 font-bold">
                                        <svg class="w-2.5 h-2.5 text-amber-500 fill-current inline-block" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M10 1.5l2.7 5.47 6.03.88-4.36 4.25 1.03 6.01L10 15.9 4.6 18.1l1.03-6.01L1.28 7.85l6.03-.88L10 1.5z"></path>
                                        </svg>
                                        <?php echo esc_html(number_format((float)$top_rating, 1)); ?>
                                    </span>
                                </div>
                            </div>
                        </a>
                    <?php
                        $count++;
                        $rank++;
                    endwhile;
                    if ($count > 0) echo '</div>'; // close last column
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
        <?php
        endif;
    endif;
    ?>

    <!-- Elegant Thank You Section -->
    <div class="text-center animate-fade-in-up">
        <div class="inline-flex items-center gap-2 px-4.5 py-2 rounded-full bg-slate-50 dark:bg-slate-900/40 border border-slate-100 dark:border-white/5 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                ¡Gracias por visitar <span class="text-primary font-bold"><?php echo esc_html(get_bloginfo('name')); ?></span>!
            </p>
        </div>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const duration = <?php echo $au_dl_timer; ?>;
    const startTime = Date.now();
    
    function updateSteps() {
        const elapsed = Date.now() - startTime;
        const percent = Math.min(100, (elapsed / duration) * 100);
        
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const step3 = document.getElementById('step-3');
        
        const checkIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-emerald-500"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" /></svg>`;
        const spinnerIcon = `<span class="animate-spin w-3 h-3 border-2 border-primary border-t-transparent rounded-full"></span>`;

        if (percent >= 33 && step1 && !step1.dataset.completed) {
            step1.dataset.completed = "true";
            step1.querySelector('.step-icon').innerHTML = checkIcon;
            step1.querySelector('.step-icon').className = "step-icon flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10";
            step1.querySelector('.step-status').textContent = "Completado";
            step1.querySelector('.step-status').className = "step-status text-[10px] font-bold text-emerald-500";
            
            if (step2) {
                step2.className = "flex items-center justify-between text-xs font-semibold text-slate-600 dark:text-slate-400";
                step2.querySelector('.step-icon').innerHTML = spinnerIcon;
                step2.querySelector('.step-icon').className = "step-icon flex items-center justify-center w-5 h-5 rounded-full bg-primary/10 text-primary";
                step2.querySelector('.step-status').textContent = "En progreso";
            }
        }
        
        if (percent >= 66 && step2 && !step2.dataset.completed) {
            step2.dataset.completed = "true";
            step2.querySelector('.step-icon').innerHTML = checkIcon;
            step2.querySelector('.step-icon').className = "step-icon flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10";
            step2.querySelector('.step-status').textContent = "Completado";
            step2.querySelector('.step-status').className = "step-status text-[10px] font-bold text-emerald-500";
            
            if (step3) {
                step3.className = "flex items-center justify-between text-xs font-semibold text-slate-600 dark:text-slate-400";
                step3.querySelector('.step-icon').innerHTML = spinnerIcon;
                step3.querySelector('.step-icon').className = "step-icon flex items-center justify-center w-5 h-5 rounded-full bg-primary/10 text-primary";
                step3.querySelector('.step-status').textContent = "En progreso";
            }
        }
        
        if (percent >= 100 && step3 && !step3.dataset.completed) {
            step3.dataset.completed = "true";
            step3.querySelector('.step-icon').innerHTML = checkIcon;
            step3.querySelector('.step-icon').className = "step-icon flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10";
            step3.querySelector('.step-status').textContent = "Completado";
            step3.querySelector('.step-status').className = "step-status text-[10px] font-bold text-emerald-500";
        }

        if (elapsed < duration) {
            requestAnimationFrame(updateSteps);
        }
    }
    requestAnimationFrame(updateSteps);
});
</script>

<?php get_footer(); ?>