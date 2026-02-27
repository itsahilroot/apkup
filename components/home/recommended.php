<?php
$au_home_recommended = get_theme_mod('au_home_recommended', []);
?>
<section class="relative mb-12">
    <header class="flex items-center justify-between mb-6 relative">
        <div class="flex items-center gap-3">
            <h2 class="text-3xl font-normal tracking-tight flex items-center space-x-2">
                <span class="dark:text-gray-200"><?php echo esc_html(get_theme_mod('au_home_recommended_title', 'Recommended')); ?></span>
            </h2>
        </div>
    </header>
    <?php if (!empty($au_home_recommended)) : ?>
        <div class="carousel recommended-carousel overflow-y-hidden p-2 scrollbar-hide focus:outline-none [&:not(.flickity-enabled)]:flex [&:not(.flickity-enabled)]:gap-4">
            <?php
            $serial = 1;
            foreach ($au_home_recommended as $rec_post) {
                $post_id = $rec_post['post_id'];
                get_template_part('components/card/recommended', null, ['post_id' => $post_id, 'serial' => $serial]);
                $serial++;
            }
            ?>
        </div>
    <?php else : ?>
        <div class="bg-primary/10 dark:bg-gray-800 text-black dark:text-white px-8 py-4 text-lg text-center">
            No Posts Found!
        </div>
    <?php endif; ?>
</section>