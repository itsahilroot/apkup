<?php
defined('ABSPATH') || exit;
get_header(); ?>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php
	home_top_ad();
    get_template_part('components/home/hero');
    get_template_part('components/home/recommended');
    get_template_part('components/home/trending');
    home_top_ad();
    get_template_part('components/home/term');
    get_template_part('components/home/categories');
    home_bottom_ad();
    get_template_part('components/home/blogs');
    get_template_part('components/home/footerinfo');
    ?>
</main>
<?php get_footer(); ?>