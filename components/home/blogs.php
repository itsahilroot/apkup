<?php
$au_home_blogs_swt  = get_theme_mod('au_home_blogs_swt', false);
$au_home_blogs_title = get_theme_mod('au_home_blogs_title', 'Blogs');
$au_home_blogs_limit = get_theme_mod('au_home_blogs_limit', '5');

$blog_args = array(
    'post_type'      => 'blog',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'posts_per_page' => $au_home_blogs_limit,
);

$blogs = new WP_Query($blog_args);

if ($au_home_blogs_swt) : ?>
    <section class="relative mb-12">
        <header class="flex items-center justify-between mb-6 relative">
            <div class="flex items-center gap-3">
                <h2 class="text-3xl font-normal tracking-tight flex items-center space-x-2">
                    <span class="text-gray-500 dark:text-gray-200"><?php echo esc_html($au_home_blogs_title); ?></span>
                </h2>
            </div>
            <a href="<?php echo esc_url(get_site_url(null, '/blog')); ?>"
                class="group flex items-center text-primary hover:text-primary transition-colors rounded-full px-4 py-2 bg-white/70 dark:bg-gray-900/60 shadow-lg border border-primary/20 dark:border-primary">
                <span class="mr-2 font-medium">Ver todo</span>
                <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </header>
        <?php if ($blogs->have_posts()) : ?>
            <div class="carousel overflow-hidden focus:outline-none [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none'] min-h-[220px]">
                <?php
                while ($blogs->have_posts()) :
                    $blogs->the_post();
                    get_template_part('components/card/card-1');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <div class="bg-primary/10 dark:bg-gray-800 text-black dark:text-white px-8 py-4 text-lg text-center">No Blogs Found!</div>
        <?php endif; ?>
    </section>
<?php endif; ?>