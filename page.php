<?php
$page_id = get_the_ID();
$page_title = get_the_title();
$page_last_update_date = get_the_modified_time('d M Y', $page_id);

$related_args = array(
    'post_type' => get_post_type(),
    'posts_per_page' => 6,
    'post__not_in' => array($page_id)
);

$related_pages = new WP_Query($related_args);

get_header(); ?>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <article class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
        <section class="lg:col-span-8 flex flex-col">
            <section class="mb-6">
                <?php if (function_exists('apkup_breadcrumb')) apkup_breadcrumb(); ?>
            </section>
            <h1 class="text-2xl lg:text-4xl font-semibold leading-tight text-gray-800 dark:text-gray-200 mb-4">
                <?php echo $page_title; ?>
            </h1>
            <div class="text-sm text-gray-500 flex items-center gap-4 dark:text-gray-300 dark:border-gray-400 mb-4">
                <span>Updated on: <?php echo $page_last_update_date; ?></span>
            </div>
            <div class="entry-content wp-block-styles prose prose-slate dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 leading-relaxed">
                <?php the_content(); ?>
            </div>
        </section>

    </article>
</main>
<?php get_footer(); ?>