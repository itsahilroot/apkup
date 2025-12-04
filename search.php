<?php get_header(); ?>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <section class="mb-8">
        <?php if (function_exists('apkup_breadcrumb')) apkup_breadcrumb(); ?>
    </section>

    <section class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
            <?php printf(__('Search Results for: %s', 'apktemplates'), get_search_query()); ?>
        </h1>
    </section>
    <section class="mb-8">
        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-2 vs:grid-cols-3 gap-x-5 gap-y-5 sm:gap-y-8 md:grid-cols-3 lg:grid-cols-4">
                <?php
                while (have_posts()) : the_post();
                    get_template_part('components/card/box-3');
                endwhile;
                ?>
            </div>
        <?php else : ?>
            <div class="bg-green-50 dark:bg-gray-800 text-black dark:text-white px-8 py-4 text-lg text-center">
                <?php _e('No results found. Please try again with different keywords.', 'apktemplates'); ?>
            </div>
        <?php endif; ?>
    </section>
    <section class="mb-8">
        <?php
        global $wp_query;
        $current_page = max(1, get_query_var('paged'));
        $total_pages  = $wp_query->max_num_pages;

        if ($total_pages > 1 && function_exists('apkup_pagination')) {
            echo apkup_pagination($current_page, $total_pages);
        }
        ?>
    </section>
</main>
<?php get_footer(); ?>