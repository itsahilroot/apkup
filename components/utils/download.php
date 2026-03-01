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

get_header(); ?>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col items-center my-10 px-4">
    <div class="mb-12">
        <img src="<?php echo esc_url($app_logo_full); ?>" width="220" height="220" alt="<?php echo $app_name; ?>" class="rounded-3xl shadow-xl border-primary/20 p-2 dark:border-primary">
    </div>
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 my-2">
        Descargar <?php echo $app_name; ?>
    </h1>
    <div class="meta my-2 text-gray-600 dark:text-gray-300 space-x-4 mb-12">
        <span class="version">v<?php echo $app_version; ?></span>
        <span class="android">Android <?php echo apkup_extract_number($app_requires) ?: '8.0'; ?>+</span>
    </div>
    <?php download_top_ad('div'); ?>
    <div id="progress-section" class="w-full max-w-md mb-12">
        <div class="progress-container-premium w-full" role="progressbar" aria-valuemin="0" aria-valuemax="100">
            <div id="progress-fill" class="progress-fill-premium" style="width: 0%;"></div>
            <div class="relative z-10 flex h-full items-center justify-center pointer-events-none drop-shadow-md">
                <span class="px-4 py-1.5 rounded-full bg-black/20 dark:bg-black/40 text-sm md:text-base font-black tracking-wide text-white select-none backdrop-blur-md border border-white/20 shadow-[0_2px_4px_rgba(0,0,0,0.1)]">
                    Preparando descarga… <span id="seconds-left">5</span>s
                </span>
            </div>
        </div>
        <p class="mt-2 text-center text-sm text-gray-500 dark:text-gray-300">
            Tus enlaces aparecerán cuando la barra se complete.
        </p>
    </div>
    <div id="button-group" class="hidden flex-col w-full max-w-md gap-4 mb-12">
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

if (!empty($links)) :
    foreach ($links as $index => $download) :
        if ((int)$index === (int)$download_id) :
            // Priority: link_original > link
            $download_url = !empty($download['link_original']) ? $download['link_original'] : $download['link'];
            if (!empty($download_url)) : ?>
                <a href="<?php echo esc_url($download_url); ?>" target="_blank" class="btn-download">
                    <span id="downloadBtn">Descargar <?php echo !empty($dl['type']) ? esc_html($dl['type']) : 'APK'; ?></span>
                </a>
            <?php endif;
        endif;
    endforeach;
endif;
?>
		<?php if (!empty($au_home_footer_tg_url)) : ?>
		<a href="<?php echo esc_url($au_home_footer_tg_url); ?>" target="_blank" class="btn-telegram">
            <span>Únete a Telegram</span>
        </a>
		<?php endif; ?>
        <a href="<?php echo get_site_url(); ?>"
           class="relative flex items-center justify-center w-full
                  py-4 rounded-full overflow-hidden
                  font-bold text-lg uppercase tracking-wide
                  text-gray-900
                  bg-[linear-gradient(to_bottom,#f3f4f6_0%,#e5e7eb_50%,#d1d5db_100%)]
                  shadow-[0_6px_0_#9ca3af]
                  active:translate-y-[2px]
                  active:shadow-[0_3px_0_#9ca3af]
                  transition-all duration-150">

            <span class="absolute top-0 left-0 w-full h-1/2
                         bg-gradient-to-b from-white/60 to-transparent
                         rounded-full pointer-events-none"></span>

            <span class="relative z-10">Back to Home</span>
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
<script>
    (function() {
        const duration = <?php echo $au_dl_timer; ?>;
        let startAt = Date.now();

        const fill = document.getElementById('progress-fill');
        const secondsEl = document.getElementById('seconds-left');
        const progressSection = document.getElementById('progress-section');
        const buttonGroup = document.getElementById('button-group');

        function tick() {
            const now = Date.now();
            const elapsed = now - startAt;
            const percent = Math.min(100, (elapsed / duration) * 100);
            fill.style.width = percent + '%';

            const msLeft = Math.max(0, duration - elapsed);
            secondsEl.textContent = Math.ceil(msLeft / 1000);

            if (elapsed < duration) {
                requestAnimationFrame(tick);
            } else {
                progressSection.classList.add('hidden');
                buttonGroup.classList.remove('hidden');
                buttonGroup.classList.add('flex');
            }
        }
        requestAnimationFrame(tick);
    })();
</script>
<?php get_footer(); ?>