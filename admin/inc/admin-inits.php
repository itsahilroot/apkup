<?php
function at_admin_menus()
{
    $menu_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"><path d="M6 2H18C19.1 2 20 2.9 20 4V7.32C20 7.87 19.55 8.32 19 8.32H5C4.45 8.32 4 7.87 4 7.32V4C4 2.9 4.9 2 6 2Z" fill="#292D32"/><path d="M4 10.3203V11.8803C4 12.9603 4.58 13.9603 5.53 14.4903L8.49 16.1603C9.12 16.5103 9.51 17.1803 9.51 17.9003V20.0003C9.51 21.1003 10.41 22.0003 11.51 22.0003H12.51C13.61 22.0003 14.51 21.1003 14.51 20.0003V17.9003C14.51 17.1803 14.9 16.5103 15.53 16.1603L18.49 14.4903C19.43 13.9603 20.02 12.9603 20.02 11.8803V10.3203C20.02 9.77031 19.57 9.32031 19.02 9.32031H5C4.45 9.32031 4 9.76031 4 10.3203Z" fill="#292D32"/></svg>';
    $menu_icon_url = "data:image/svg+xml;base64," . base64_encode($menu_svg);

    add_menu_page('APKTEMPLATES', 'APKTEMPLATES', 'manage_options', 'at-google-play', 'apkt_gp_importer', $menu_icon_url, 82);
    add_submenu_page('at-google-play', 'Google Play Importer', 'Google Play', 'manage_options', 'at-google-play');
    add_submenu_page('at-google-play', 'APKTEMPLATES Theme Panel', 'Panel', 'manage_options', 'at-panel', 'apkt_panel');
}
add_action('admin_menu', 'at_admin_menus');

function at_admin_styles()
{
    if (isset($_GET['page']) && in_array($_GET['page'], array('at-google-play', 'at-panel'))) {
        wp_enqueue_style('at-admin-fontawesome', get_template_directory_uri() . '/assets/css/admin/font-awesome.css', array(), APKT_THEME_VERSION);
    }

    if (isset($_GET['page']) && in_array($_GET['page'], array('at-google-play'))) {
        wp_enqueue_style('at-importer-custom', get_template_directory_uri() . '/assets/css/admin/importer-custom.css', array(), time(), 'all');
    }

    if (isset($_GET['page']) && in_array($_GET['page'], array('at-panel'))) {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('at-admin-panel', get_template_directory_uri() . '/assets/css/admin/panel.css', array(), APKT_THEME_VERSION, 'all');
        wp_enqueue_style('at-google-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap', array(), null);
        wp_enqueue_style('at-admin-panel-custom', get_template_directory_uri() . '/assets/css/admin/panel-custom.css', array(), time(), 'all');
    }
}
add_action('admin_enqueue_scripts', 'at_admin_styles');

function at_admin_scripts()
{
    if (is_admin() && get_current_screen()->id === 'post') {
        wp_enqueue_style('apkup-post-editor', get_template_directory_uri() . '/assets/css/admin/admin.min.css', array(), time(), 'all');
        wp_enqueue_script('apkup-post-editor', get_template_directory_uri() . '/assets/js/admin/admin.min.js', array('jquery', 'jquery-ui-sortable'), time(), true);
    }

    if (isset($_GET['page']) && in_array($_GET['page'], array('at-google-play'))) {
        wp_enqueue_script('at-admin-importer', get_template_directory_uri() . '/assets/js/admin/gp.min.js', array(), APKT_THEME_VERSION, true);

        wp_localize_script(
            'at-admin-importer',
            'apktemplates_ajax_vars',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('gplay_nonce')
            )
        );
    }

    if (isset($_GET['page']) && in_array($_GET['page'], array('at-panel'))) {
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_media();
        wp_enqueue_script('wp-color-picker');

        wp_enqueue_script('at-admin-panel', get_template_directory_uri() . '/assets/js/admin/panel.js', array(), APKT_THEME_VERSION, true);

        $parent_categories = get_categories(array('parent' => 0, 'hide_empty' => false));
        $parent_cats_options = array('all' => __('All', 'apktemplates'));
        if (!is_wp_error($parent_categories) && !empty($parent_categories)) {
            foreach ($parent_categories as $cat) {
                $parent_cats_options[$cat->term_id] = $cat->name;
            }
        }

        wp_localize_script(
            'at-admin-panel',
            'apktemplates_ajax_vars',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('panel_nonce'),
                'parent_cats' => $parent_cats_options
            )
        );
    }
}
add_action('admin_enqueue_scripts', 'at_admin_scripts');


function apkt_dashboard_admin_bar_menu( $wp_admin_bar ) {
    $wp_admin_bar->add_menu( array(
        'id'    => 'apktemplates_menu',
        'title' => '<span class="ab-icon dashicons dashicons-screenoptions"></span><span class="ab-label">APKTEMPLATES</span>',
        'href'  => admin_url('admin.php?page=at-google-play'),
        'meta'  => array(
            'class' => 'apkt-menu',
        ),
    ) );

    $wp_admin_bar->add_menu( array(
        'parent' => 'apktemplates_menu',
        'id'     => 'apkt_gp_menu',
        'title'  => 'Google Play',
        'href'   => admin_url('admin.php?page=at-google-play'),
    ) );

    $wp_admin_bar->add_menu( array(
        'parent' => 'apktemplates_menu',
        'id'     => 'apkt_panel_menu',
        'title'  => 'Panel',
        'href'   => admin_url('admin.php?page=at-panel'),
    ) );
}

add_action( 'admin_bar_menu', 'apkt_dashboard_admin_bar_menu', 999 );