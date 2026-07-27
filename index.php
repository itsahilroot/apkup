<?php
defined('ABSPATH') || exit;
get_header();

$site_cache_swt = get_theme_mod('site_cache_swt', '1');
$site_cache_time = intval(get_theme_mod('site_cache_time', '24'));
$current_page = get_query_var('paged') ? get_query_var('paged') : 1;
$transient_key = 'apkup_home_p_' . $current_page;

$is_cacheable = ($site_cache_swt && !is_user_logged_in());
$cached_html = $is_cacheable ? get_transient($transient_key) : false;

if ($cached_html !== false) {
    echo $cached_html;
    get_footer();
    exit;
}

if ($is_cacheable) {
    ob_start();
}
?>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php
    get_template_part('components/home/hero');
    get_template_part('components/home/recommended');
    home_top_ad();
    get_template_part('components/home/trending');
    get_template_part('components/home/term');
    get_template_part('components/home/premium');
    if (get_theme_mod('au_home_categories_swt', true)) {
        get_template_part('components/home/categories');
    }
    home_bottom_ad();
    get_template_part('components/home/blogs');
    get_template_part('components/home/footerinfo');
    ?>
</main>
<?php
if ($is_cacheable) {
    $cached_content = ob_get_clean();
    set_transient($transient_key, $cached_content, HOUR_IN_SECONDS * $site_cache_time);
    echo $cached_content;
}
get_footer();
?>