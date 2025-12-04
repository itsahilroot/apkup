<?php get_header(); ?>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <article>
        <section>
            <?php
            get_template_part('components/single/breadcrumb');
            get_template_part('components/single/info');
            get_template_part('components/single/screenshots');
            get_template_part('components/single/content');
            ?>
        </section>
    </article>
    <section>
        <?php get_template_part('components/single/recommended'); ?>
    </section>
    <section>
        <?php comments_template(); ?>
    </section>
</main>
<?php get_footer(); ?>