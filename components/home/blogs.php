<?php
$au_home_blogs_swt  = get_theme_mod('au_home_blogs_swt', false);
$au_home_blogs_title = get_theme_mod('au_home_blogs_title', 'Novedades y Blogs Técnicos');
$au_home_blogs_limit = get_theme_mod('au_home_blogs_limit', '3');

$blog_args = array(
    'post_type'      => 'blog',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'posts_per_page' => $au_home_blogs_limit,
);

$blogs = new WP_Query($blog_args);

if ($au_home_blogs_swt) : ?>
    <section class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white"><?php echo esc_html($au_home_blogs_title); ?></h2>
            <a class="right-arrow-btn" href="<?php echo esc_url(get_post_type_archive_link('blog')); ?>">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </a>
        </div>

        <?php if ($blogs->have_posts()) : 
            $blog_count = $blogs->post_count;
            $container_class = ($blog_count > 3) 
                ? "flex overflow-x-auto snap-x snap-mandatory gap-6 pb-4 beautiful-scrollbar" 
                : "flex overflow-x-auto snap-x snap-mandatory no-scrollbar md:grid md:grid-cols-2 lg:grid-cols-3 gap-6 pb-4 md:pb-0";
            $item_class = ($blog_count > 3) 
                ? "group flex flex-col gap-3 flex-shrink-0 w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] snap-center post-card" 
                : "group flex flex-col gap-3 flex-shrink-0 w-full snap-center post-card";
            ?>
            <!-- Grilla de Blogs Minimalista -->
            <div class="<?php echo esc_attr($container_class); ?>">
                <?php
                while ($blogs->have_posts()) : $blogs->the_post();
                    $blog_id = get_the_ID();
                    $thumb_url = get_the_post_thumbnail_url($blog_id, 'medium_large') ?: 'https://placehold.co/640x360/0052e0/ffffff?text=Blog';
                    $author_name = get_the_author() ?: 'APKGSTORE';
                    $post_date = get_the_date('d M Y');
                    
                    // Fetch primary category or custom tax taxonomy for blog post type if exists
                    $terms = get_the_terms($blog_id, 'blog_category');
                    if (empty($terms) || is_wp_error($terms)) {
                        $terms = get_the_category($blog_id);
                    }
                    $primary_cat = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->name : 'Tecnología';
                    ?>
                    <!-- Blog Card -->
                    <article class="<?php echo esc_attr($item_class); ?>">
                        <div class="relative overflow-hidden rounded-2xl aspect-video bg-slate-100 dark:bg-slate-850">
                            <img class="w-full h-full object-cover transition-all duration-300 group-hover:scale-103" src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>">
                        </div>
                        <div class="space-y-1 min-w-0">
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-light">
                                <?php echo esc_html($post_date); ?> • <?php echo esc_html($primary_cat); ?> • Por <?php echo esc_html($author_name); ?>
                            </span>
                            <a href="<?php the_permalink(); ?>" class="block">
                                <h4 class="font-normal text-sm text-slate-800 dark:text-slate-200 group-hover:text-primary transition-colors leading-snug">
                                    <?php the_title(); ?>
                                </h4>
                            </a>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <div class="py-8 text-center text-sm text-slate-450 dark:text-slate-550 border border-dashed border-slate-200 dark:border-slate-800 rounded-2xl">
                No se encontraron blogs.
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>