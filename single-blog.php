<?php
$blog_id = get_the_ID();
$blog_title = get_the_title();
$blog_publish_date = get_the_time('d M Y', $blog_id);
$blog_author = get_the_author();
$blog_views_raw = get_post_meta($blog_id, 'px_views', true) ?: '0';
$blog_views = $blog_views_raw ? apkup_format_views_count($blog_views_raw) : '0';
$blog_thumbnail = get_the_post_thumbnail_url($blog_id, 'full');

$related_args = array(
    'post_type' => get_post_type(),
    'posts_per_page' => 6,
    'post__not_in' => array($blog_id)
);

$related_posts = new WP_Query($related_args);

get_header(); ?>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <article class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
        <section class="lg:col-span-8 flex flex-col">
            <section class="mb-6">
                <?php if (function_exists('apkup_breadcrumb')) apkup_breadcrumb(); ?>
            </section>
            <h1 class="text-lg font-bold leading-tight text-slate-800 dark:text-white mb-4">
                <?php echo $blog_title; ?>
            </h1>
            <div class="flex items-center gap-3.5 mb-4">
                <span class="text-[10px] text-slate-400 dark:text-slate-500 font-light">
                    <?php 
                    $blog_cats = get_the_terms($blog_id, 'cblog');
                    $blog_cat_name = (!empty($blog_cats) && !is_wp_error($blog_cats)) ? $blog_cats[0]->name : 'General';
                    echo esc_html($blog_publish_date) . ' &bull; ' . esc_html($blog_cat_name) . ' &bull; Por ' . esc_html($blog_author);
                    ?>
                </span>
                <span class="flex items-center gap-1 text-[10px] text-slate-400 dark:text-slate-500 font-light">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 256 256" aria-hidden="true">
                        <path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.34c18.83-18.83,27.3-37.61,27.65-38.4A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path>
                    </svg>
                    <?php echo $blog_views; ?> vistas
                </span>
            </div>
            <div class="w-full rounded-2xl overflow-hidden mb-6 bg-slate-100 dark:bg-slate-850">
                <img src="<?php echo esc_url($blog_thumbnail); ?>" alt="<?php echo $blog_title; ?>" class="w-full h-auto object-cover">
            </div>
            <div class="entry-content wp-block-styles prose prose-slate dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 leading-relaxed">
                <?php the_content(); ?>
            </div>
        </section>
        <?php if ($related_posts->have_posts()) : ?>
            <aside class="lg:col-span-4 sticky top-6 self-start">
                <h2 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Relacionados</h2>
                <div class="flex flex-col gap-4">
                    <?php
                    while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                        <a href="<?php echo get_permalink(); ?>" class="flex items-start gap-3 bg-slate-100/50 dark:bg-slate-850/50 rounded-2xl p-3 border border-slate-100 dark:border-slate-800/80 hover:border-primary/50 transition-colors duration-200">
                            <?php the_post_thumbnail('thumbnail', [
                                'class' => 'w-24 h-24 rounded-xl object-cover shadow-sm',
                                'alt'   => get_the_title()
                            ]); ?>
                            <div class="flex flex-col min-w-0">
                                <span class="font-semibold text-sm line-clamp-2 text-slate-800 dark:text-slate-200 hover:text-primary transition-colors leading-snug"><?php the_title(); ?></span>
                                <span class="text-[10px] mt-2 text-slate-450 dark:text-slate-500 font-light">Por <?php the_author(); ?></span>
                            </div>
                        </a>
                    <?php endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </aside>
        <?php endif; ?>
    </article>
    <?php comments_template(); ?>
</main>
<?php get_footer(); ?>