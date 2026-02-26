<?php
$au_home_recommended = get_theme_mod('au_home_recommended', []);
?>
<section class="relative mb-12">
    <header class="flex items-center justify-between mb-6 relative">
        <div class="flex items-center gap-3">
            <h2 class="text-3xl font-normal tracking-tight flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary dark:text-green-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-500 dark:text-gray-200"><?php echo esc_html(get_theme_mod('au_home_recommended_title', 'Recommended')); ?></span>
            </h2>
        </div>
    </header>
    <?php if (!empty($au_home_recommended)) : ?>
        <div class="carousel recommended-carousel overflow-y-hidden p-2 scrollbar-hide focus:outline-none [&:not(.flickity-enabled)]:flex [&:not(.flickity-enabled)]:gap-4">
            <?php
            foreach ($au_home_recommended as $rec_post) {
                $post_id = $rec_post['post_id'];
                get_template_part('components/card/recommended', null, ['post_id' => $post_id]);
            }
            ?>
        </div>
    <?php else : ?>
        <div class="bg-green-50 dark:bg-gray-800 text-black dark:text-white px-8 py-4 text-lg text-center">
            No Posts Found!
        </div>
    <?php endif; ?>
</section>