<?php
$post_id = get_the_ID();
$download_links = apkup_get_datos_download($post_id);

$custom_boxes = get_post_meta($post_id, 'custom_boxes', true);
$permanent_custom_boxes = get_option('permanent_custom_boxes');
?>
<div id="download-links" class="dl-section bg-primary/10 dark:bg-gray-800 rounded-2xl p-6 shadow-sm">
    <div class="dl-tab-container group" data-open="false">
        <div class="flex mb-8 justify-center lg:justify-start">
            <button class="dl-tab-toggle relative grid grid-cols-2 h-10 bg-[hsla(157,2%,25%,0.05)] dark:bg-gray-700 rounded-full p-1 cursor-pointer text-sm leading-5 shadow-inner outline-none">
                <span class="absolute top-1 left-1 h-8 w-[calc(50%-4px)] bg-white rounded-full shadow transition-transform duration-200 ease-in-out dark:bg-gray-600"></span>
                <span class="relative bottom-[1px] z-10 flex items-center justify-center px-2 py-2 min-w-32 text-center transition-opacity duration-200 ease-in-out text-gray-800 dark:text-gray-200">
                    Links
                </span>
                <span class="relative bottom-[1px] z-10 flex items-center justify-center px-3 py-2 min-w-32 text-center transition-opacity duration-200 ease-in-out opacity-60 text-gray-800 dark:text-gray-200">
                    MOD Info
                </span>
            </button>
        </div>
    </div>
    <div id="dl-links" class="tab-content">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">
            Descargar <?php the_title(); ?>
        </h2>
        <?php single_bottom_ad('div', 'mt-8'); ?>
        <?php $links = [];
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
    foreach ($links as $index => $dl) :
        $download_url = get_permalink() . 'download/' . $index;
        if (!empty($download_url)) : ?>
            <?php if (!empty($dl['type'])) : ?>
                <div class="mb-6">
                    <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium uppercase">
                        <?php echo esc_html($dl['type']); ?>
                    </span>
                </div>
            <?php endif; ?>

            <a href="<?php echo esc_url($download_url); ?>"
                   class="px-6 py-3 rounded-xl bg-primary text-white shadow hover:shadow-md hover:bg-primary transition-all flex items-center justify-center gap-2 mb-6">
                    <?php echo !empty($dl['texto']) ? esc_html($dl['texto']) : 'DOWNLOAD'; ?>
                    <?php if (!empty($dl['type'])) : ?>
                        <span class="ml-1 rounded bg-black/10 px-2 py-0.5 text-xs dark:bg-white/10">
                            <?php echo esc_html($dl['type']); ?>
                        </span>
                    <?php endif; ?>
                </a>
<?php
        endif;
    endforeach;
endif;
?>
        <div class="space-y-2">
            <h3 class="font-bold text-gray-800 dark:text-gray-300">Descarga rápida - ¡libre de virus!</h3>
            <p class="text-gray-800 dark:text-gray-300">
                En nuestro sitio web, puedes descargar la última versión…
            </p>
            <p class="text-gray-800 dark:text-gray-300">
                No es necesario registrarse ni enviar SMS; ¡enlace directo y archivos verificados!
            </p>
        </div>
    </div>
    <div id="dl-mod-info" class="tab-content">
        <?php if (!empty($custom_boxes) || !empty($permanent_custom_boxes)) : ?>
            <?php if (!empty($custom_boxes[0]['title']) || !empty($custom_boxes[0]['content'])) : ?>
                <div class="mb-4">
                    <?php if (!empty($custom_boxes[0]['title'])) : ?>
                        <h2 class="text-xl font-bold dark:text-gray-200 mb-2">
                            <?php echo esc_html($custom_boxes[0]['title']); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if (!empty($custom_boxes[0]['content'])) : ?>
                        <div class="dark:text-gray-200">
                            <?php echo wp_kses_post($custom_boxes[0]['content']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($permanent_custom_boxes[0]['title']) || !empty($permanent_custom_boxes[0]['content'])) : ?>
                <div class="mt-4">
                    <?php if (!empty($permanent_custom_boxes[0]['title'])) : ?>
                        <h2 class="text-xl font-bold dark:text-gray-200 mb-2">
                            <?php echo esc_html($permanent_custom_boxes[0]['title']); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if (!empty($permanent_custom_boxes[0]['content'])) : ?>
                        <div class="dark:text-gray-200">
                            <?php echo wp_kses_post($permanent_custom_boxes[0]['content']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>