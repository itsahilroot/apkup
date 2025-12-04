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