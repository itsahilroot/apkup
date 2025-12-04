<?php
$au_single_help_guide_title = get_theme_mod('au_single_help_guide_title', 'How To Install?');
$au_single_help_guide = get_theme_mod('au_single_help_guide', []);

$post_id = get_the_ID();
$data = get_post_meta($post_id, 'datos_informacion', true);
$data = is_array($data) ? $data : [];
$app_whatsnew = $data['novedades'] ?? '';
?>
<div class="app-content mb-10">
    <div class="tab-container group" data-open="false">
        <div class="flex mb-4 justify-center lg:justify-start">
            <button class="tab-toggle relative grid grid-cols-2 h-10 bg-[hsla(157,2%,25%,0.05)] 
             dark:bg-gray-700 rounded-full p-1 cursor-pointer text-sm leading-5 
             shadow-inner outline-none">
                <span class="absolute top-1 left-1 h-8 w-[calc(50%-4px)] bg-white dark:bg-gray-600 rounded-full shadow transition-transform duration-200 ease-in-out"></span>
                <span class="relative bottom-[1px] z-10 flex items-center justify-center px-2 py-2 min-w-32 text-center transition-opacity duration-200 ease-in-out text-gray-800 dark:text-gray-200">Description</span>
                <span class="relative bottom-[1px] z-10 flex items-center justify-center px-3 py-2 min-w-32 text-center transition-opacity duration-200 ease-in-out opacity-60 text-gray-800 dark:text-gray-200">Help</span>
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 dark:text-gray-300 rounded-2xl p-6 mb-10 shadow-sm">
        <div id="descriptionContent" class="tab-content transition-opacity duration-300">
            <div id="descriptionText" class="entry-content wp-block-styles text-gray-700 dark:text-gray-300 max-h-32 overflow-hidden">
                <?php the_content(); ?>
            </div>
            <button id="toggleDescriptionBtn" class="text-sm text-primary font-semibold cursor-pointer mt-2 dark:hover:text-green-300" aria-expanded="false">LEER MÁS</button>
        </div>
        <div id="helpContent" class="tab-content hidden opacity-0 transition-opacity duration-300">
            <?php if (!empty($au_single_help_guide_title)) : ?>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4"><?php echo $au_single_help_guide_title; ?></h3>
            <?php endif;
            if (!empty($au_single_help_guide)) : ?>
                <div class="space-y-3 text-gray-700 dark:text-gray-300">
                    <?php foreach ($au_single_help_guide as $index => $text) : ?>
                        <div class="flex items-start gap-3">
                            <span class="bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-medium flex-shrink-0"><?php echo $index + 1; ?></span>
                            <p><?php echo $text['text']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <p class="text-yellow-800 text-sm"><strong>Note:</strong> Asegúrese de descargar solo de fuentes confiables para evitar malware.</p>
            </div>
        </div>
    </div>
    <?php if(!empty($app_whatsnew)) : ?>
    <div class="bg-white dark:bg-gray-800 dark:text-gray-300 rounded-2xl p-6 mb-10 shadow-sm">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Qué hay de nuevo</h2>
        <div class="content-desc">
            <?php echo $app_whatsnew; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php get_template_part('components/single/download-links'); ?>
</div>