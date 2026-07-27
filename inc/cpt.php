<?php
/* Register CPT Blog Post Type */
function apkup_blog_post_type() {
    $labels = array(
        'name'                => _x( 'Blogs', 'Post Type General Name', 'apktemplates' ),
        'singular_name'       => _x( 'Blog', 'Post Type Singular Name', 'apktemplates' ),
        'menu_name'           => __( 'Blogs', 'apktemplates' ),
        'parent_item_colon'   => __( 'Parent Blog:', 'apktemplates' ),
        'all_items'           => __( 'All Blogs', 'apktemplates' ),
        'view_item'           => __( 'View Info', 'apktemplates' ),
        'add_new_item'        => __( 'Add New', 'apktemplates' ),
        'add_new'             => __( 'Add New', 'apktemplates' ),
        'edit_item'           => __( 'Edit Info', 'apktemplates' ),
        'update_item'         => __( 'Update Info', 'apktemplates' ),
        'search_items'        => __( 'Search', 'apktemplates' ),
        'not_found'           => __( 'Not found', 'apktemplates' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'apktemplates' ),
    );
    $args = array(
        'label'               => __( 'Blogs', 'apktemplates' ),
        'description'         => __( 'Info Blogs', 'apktemplates' ),
        'labels'              => $labels,
        'show_in_rest'        => true, // To use Gutenberg editor.
        'supports'            => array( 'title', 'editor', 'thumbnail', 'comments' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 8,
        'menu_icon'           => 'dashicons-media-document',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'rewrite'             => array( 'slug' => 'blog' ),
		'taxonomies'          => array( 'blog_tag' ),
    );
    register_post_type( 'blog', $args );
}
add_action( 'init', 'apkup_blog_post_type' );

/* Register CPT Blog Category/Tags */
function apkup_blog_taxonomy() {
    $category_labels = array(
        'name'              => _x( 'Blog Categories', 'taxonomy general name', 'apktemplates' ),
        'singular_name'     => _x( 'Blog Category', 'taxonomy singular name', 'apktemplates' ),
        'search_items'      => __( 'Search Categories', 'apktemplates' ),
        'all_items'         => __( 'All Categories', 'apktemplates' ),
        'parent_item'       => __( 'Parent Category', 'apktemplates' ),
        'parent_item_colon' => __( 'Parent Category:', 'apktemplates' ),
        'edit_item'         => __( 'Edit Category', 'apktemplates' ),
        'update_item'       => __( 'Update Category', 'apktemplates' ),
        'add_new_item'      => __( 'Add New Category', 'apktemplates' ),
        'new_item_name'     => __( 'New Category Name', 'apktemplates' ),
        'menu_name'         => __( 'Categories', 'apktemplates' ),
    );

    $category_args = array(
        'hierarchical'      => true, // For category taxanomy
        'labels'            => $category_labels,
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'cblog', 'hierarchical' => true ),
    );

    register_taxonomy( 'cblog', 'blog', $category_args );

    $tag_labels = array(
        'name'              => _x( 'Blog Tags', 'taxonomy general name', 'apktemplates' ),
        'singular_name'     => _x( 'Blog Tag', 'taxonomy singular name', 'apktemplates' ),
        'search_items'      => __( 'Search Tags', 'apktemplates' ),
        'all_items'         => __( 'All Tags', 'apktemplates' ),
        'edit_item'         => __( 'Edit Tag', 'apktemplates' ),
        'update_item'       => __( 'Update Tag', 'apktemplates' ),
        'add_new_item'      => __( 'Add New Tag', 'apktemplates' ),
        'new_item_name'     => __( 'New Tag Name', 'apktemplates' ),
        'menu_name'         => __( 'Tags', 'apktemplates' ),
    );

    $tag_args = array(
        'hierarchical'      => false, //For tags taxanomy
        'labels'            => $tag_labels,
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'tblog' ),
    );

    register_taxonomy( 'tblog', 'blog', $tag_args );
}
add_action( 'init', 'apkup_blog_taxonomy' );

/* Register Developer Taxonomy */
function apkup_developer_taxonomy() {
    $labels = array(
        'name'              => _x( 'Developers', 'taxonomy general name', 'apktemplates' ),
        'singular_name'     => _x( 'Developer', 'taxonomy singular name', 'apktemplates' ),
        'search_items'      => __( 'Search Developers', 'apktemplates' ),
        'all_items'         => __( 'All Developers', 'apktemplates' ),
        'parent_item'       => __( 'Parent Developer', 'apktemplates' ),
        'parent_item_colon' => __( 'Parent Developer:', 'apktemplates' ),
        'edit_item'         => __( 'Edit Developer', 'apktemplates' ),
        'update_item'       => __( 'Update Developer', 'apktemplates' ),
        'add_new_item'      => __( 'Add New Developer', 'apktemplates' ),
        'new_item_name'     => __( 'New Developer Name', 'apktemplates' ),
        'menu_name'         => __( 'Developers', 'apktemplates' ),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'developer' ),
    );

    register_taxonomy( 'developer', 'post', $args );
}
add_action( 'init', 'apkup_developer_taxonomy' );

/* Auto-sync wp_developers_GP / legacy data to developer taxonomy on save and edit */
function apkup_sync_developer_to_developer_taxonomy($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (get_post_type($post_id) !== 'post') {
        return;
    }
    
    // Check if developer taxonomy is already set
    $terms = wp_get_object_terms($post_id, 'developer');
    if (!empty($terms) && !is_wp_error($terms)) {
        return; // Already set
    }

    $developer = '';

    // 1. Try wp_developers_GP meta
    $developer = get_post_meta($post_id, 'wp_developers_GP', true);

    // 2. Try legacy 'dev' taxonomy
    if (empty($developer)) {
        $dev_terms = get_the_terms($post_id, 'dev');
        if (!empty($dev_terms) && !is_wp_error($dev_terms)) {
            $first_dev = array_shift($dev_terms);
            $developer = $first_dev->name;
        }
    }

    // 3. Try old desarrollador meta
    if (empty($developer)) {
        if (function_exists('get_datos_info')) {
            $developer = get_datos_info('desarrollador', false, $post_id);
        }
        if (empty($developer)) {
            $info = get_post_meta($post_id, 'datos_informacion', true);
            if (is_array($info) && !empty($info['desarrollador'])) {
                $developer = $info['desarrollador'];
            }
        }
        if (empty($developer)) {
            $developer = get_post_meta($post_id, 'desarrollador', true);
        }
    }

    // If we found a developer name, assign it to the new 'developer' taxonomy
    if (!empty($developer)) {
        wp_set_object_terms($post_id, $developer, 'developer', false);
        // Also save to wp_developers_GP meta if missing
        if (!get_post_meta($post_id, 'wp_developers_GP', true)) {
            update_post_meta($post_id, 'wp_developers_GP', sanitize_text_field($developer));
        }
    }
}
add_action('save_post', 'apkup_sync_developer_to_developer_taxonomy', 10, 1);
add_action('edit_post', 'apkup_sync_developer_to_developer_taxonomy', 10, 1);

// Ensure it runs when loading the post editor (Classic Editor)
add_action('admin_enqueue_scripts', function() {
    global $post;
    if (is_admin() && isset($post->ID)) {
        apkup_sync_developer_to_developer_taxonomy($post->ID);
    }
});

// Ensure it runs when Gutenberg block editor requests the post via REST API
add_filter('rest_prepare_post', function($response, $post_obj, $request) {
    if (isset($post_obj->ID)) {
        apkup_sync_developer_to_developer_taxonomy($post_obj->ID);
    }
    return $response;
}, 10, 3);

/* One-time migration to automatically copy terms from old publisher taxonomy to new developer taxonomy */
function apkup_migrate_publisher_to_developer_taxonomy() {
    if (get_option('apkup_publisher_to_developer_migrated')) {
        return;
    }

    // Temporarily register 'publisher' taxonomy so we can retrieve existing term relations
    register_taxonomy('publisher', 'post', array('public' => false, 'hierarchical' => true));

    $posts = get_posts([
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'post_status'    => 'any',
    ]);

    if (!empty($posts)) {
        foreach ($posts as $p) {
            $publisher_terms = wp_get_post_terms($p->ID, 'publisher', array('fields' => 'names'));
            if (!empty($publisher_terms) && !is_wp_error($publisher_terms)) {
                wp_set_object_terms($p->ID, $publisher_terms, 'developer', false);
            }
        }
    }

    update_option('apkup_publisher_to_developer_migrated', true);
    flush_rewrite_rules();
}
add_action('init', 'apkup_migrate_publisher_to_developer_taxonomy', 20);