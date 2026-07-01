<?php get_header(); ?>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <section class="mb-8">
        <?php if (function_exists('apkup_breadcrumb')) apkup_breadcrumb(); ?>
    </section>
    <?php archive_top_ad(); ?>
    <section class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Blogs</h1>
        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                while (have_posts()) : the_post();
                    get_template_part('components/card/card-2');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <div class="bg-primary/10 dark:bg-gray-800 text-black dark:text-gray-300 px-8 py-4 text-lg text-center">No Posts Found!</div>
        <?php endif; ?>
    </section>
    <?php archive_bottom_ad(); ?>
    <section>
        <?php
        global $wp_query;
        $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
        $total_pages = $wp_query->max_num_pages;
        if (function_exists('apkup_pagination')) echo apkup_pagination($current_page, $total_pages);
        ?>
    </section>
</main>
<?php get_footer(); ?>