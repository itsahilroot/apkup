<?php
$au_single_ss_swt   = get_theme_mod('au_single_ss_swt', false);
$au_single_ss_limit = (int) get_theme_mod('au_single_ss_limit', 5);

$screenshots = get_post_meta(get_the_ID(), 'datos_imagenes', true);

single_top_ad('div', 'mt-8');

if ($au_single_ss_swt && !empty($screenshots)) :
    $limited_screenshots = array_slice($screenshots, 0, $au_single_ss_limit);
    ?>
    <div class="app-screenshots mb-10">
        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-6">Capturas de pantalla</h2>
        <div class="carousel-container max-w-7xl mx-auto">
            <div id="lightgallery-container" class="my-4 w-full h-full relative z-[1] flex transition-transform box-content overflow-auto snap-x snap-mandatory">
                <?php foreach ($limited_screenshots as $index => $url) : ?>
                    <a href="<?php echo esc_url($url); ?>" data-src="<?php echo esc_url($url); ?>" class="flex justify-center items-center shrink-0 mr-4 mb-4 snap-center cursor-pointer">
                        <img src="<?php echo esc_url($url); ?>" alt="Screenshot <?php echo $index + 1; ?>" loading="lazy" class="w-auto h-72 object-cover rounded-lg">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
