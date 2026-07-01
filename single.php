<?php get_header(); ?>
<main class="max-w-7xl mx-auto px-2 sm:px-4 pt-2 space-y-6">
    <?php single_top_ad('div', 'my-4'); ?>
    <article>
        <section class="entry-content">
            <?php
            get_template_part('components/single/info');
            get_template_part('components/single/screenshots');
            get_template_part('components/single/content');
            ?>
        </section>
    </article>
    <?php single_bottom_ad('div', 'my-4'); ?>
    <section>
        <?php get_template_part('components/single/recommended'); ?>
    </section>
    <section>
        <?php comments_template(); ?>
    </section>
</main>
<?php get_footer(); ?>