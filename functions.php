<?php
$theme_data = wp_get_theme();
$theme_dir = get_template_directory();

$theme_name = $theme_data->get('Name');
$theme_version = $theme_data->get('Version');
$text_domain = $theme_data->get('TextDomain');

// Only Remove When Debug
/*error_reporting(E_ALL);
ini_set('display_errors', 'on'); */
define('APKT_THEME_NAME', $theme_name);
define('APKT_THEME_VERSION', $theme_version);
define('APKT_TRANSLATE', $text_domain);
define('API_URL', 'https://api.themespixel.net');
require $theme_dir . '/admin/inc/admin-functions.php';
require $theme_dir . '/inc/advertisements.php';
require $theme_dir . '/inc/ajax.php';
require $theme_dir . '/inc/breadcrumb.php';
require $theme_dir . '/inc/core.php';
require $theme_dir . '/inc/cpt.php';
require $theme_dir . '/inc/comments.php';
require $theme_dir . '/inc/filter.php';
require $theme_dir . '/inc/inits.php';
require $theme_dir . '/inc/pagination.php';
require $theme_dir . '/inc/snippet.php';
require $theme_dir . '/inc/metaboxes.php';
require $theme_dir . '/inc/theme-updater.php';

// Initialize the private GitHub Theme Updater
new APKUp_Theme_Updater('apkup');

require $theme_dir . '/inc/apkupdates.php';
require $theme_dir . '/inc/apkupdatestable.php';
require $theme_dir . '/inc/admin-bulk-developer.php';

if (!function_exists('apkup_setup')) {
    add_action('after_setup_theme', 'apkup_setup');
    function apkup_setup()
    {
        load_theme_textdomain('apktemplates');
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link', 'status'));
        add_theme_support('woocommerce');
        add_theme_support('title-tag');
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style'));
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('align-wide');
        add_theme_support('editor-styles');

        register_nav_menus(
            array(
                'header_menu' => __('Header Menu', 'apktemplates'),
                'mobile_menu' => __('Mobile Menu', 'apktemplates'),
                'footer_menu' => __('Footer Menu', 'apktemplates'),
            )
        );
    }
}

add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) {
        $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});

function apkup_enqueue_scripts()
{
    $theme_dir = get_template_directory_uri();

    wp_enqueue_style('apkup-theme-style', get_stylesheet_uri(), [], APKT_THEME_VERSION, 'all');
    // wp_enqueue_style('apkup-tailwind', $theme_dir . '/assets/css/input.css', [], APKT_THEME_VERSION, 'all');
    // wp_enqueue_style('apkup-style', $theme_dir . '/assets/css/style.min.css', ['apkup-tailwind'], APKT_THEME_VERSION, 'all');
    wp_enqueue_style('apkup-frontend', $theme_dir . '/assets/css/input.css', [], APKT_THEME_VERSION, 'all');

    if (is_front_page() || is_home() || is_archive()) {
        wp_enqueue_style('apkup-flickity', $theme_dir . '/assets/css/flickity.css', [], APKT_THEME_VERSION, 'all');
        wp_enqueue_script('apkup-flickity', $theme_dir . '/assets/js/flickity.js', [], APKT_THEME_VERSION, true);
    }

    /// custom js
    wp_enqueue_script('apkup-app', $theme_dir . '/assets/js/app.js', [], APKT_THEME_VERSION, true);
    // wp_enqueue_script('apkup-lightgallery', $theme_dir . '/assets/js/include/lightgallery.min.js', [], APKT_THEME_VERSION, true);
    // wp_enqueue_script('rateyo', $theme_dir . '/assets/js/include/rateYo.min.js', ['jquery'], '2.3.0', true);

    // wp_enqueue_script('apkup-script',  $theme_dir . '/assets/js/script.js', [], APKT_THEME_VERSION, true);

    wp_localize_script('apkup-app', 'apkup_ajax_vars', [
        'ajax_url'      => admin_url('admin-ajax.php'),
        'nonce'         => wp_create_nonce('apkup_nonce'),
        'site_pjax_swt' => get_theme_mod('site_pjax_swt', '1'),
        'home_url'      => esc_url(home_url('/')),
    ]);
}
add_action('wp_enqueue_scripts', 'apkup_enqueue_scripts', 20);

// Defer Flickity JS to prevent blocking rendering
add_filter('script_loader_tag', 'apkup_defer_scripts', 10, 2);
function apkup_defer_scripts($tag, $handle) {
    if ('apkup-flickity' === $handle) {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}

add_action('admin_enqueue_scripts', 'load_custom_wp_admin_scripts');

function load_custom_wp_admin_scripts()
{
    $theme_dir = get_template_directory_uri();
    wp_enqueue_script('apkupdates-js',  $theme_dir . '/assets/js/admin/apkupdate.js', ['jquery'], APKT_THEME_VERSION, true);

    wp_localize_script('apkupdates-js', 'vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('apkup_nonce'),
        '_img' => __('Thumbnail', 'apktemplates'),
        '_title' => __('Title', 'apktemplates'),
        '_version' => __('Version', 'apktemplates'),
        '_import_text' => __('Import', 'apktemplates'),
        '_confirm_update_text' => __('Do you want to update the information of this app? Remember that it will ', 'apktemplates')
    ));
}
