<?php
function apkup_breadcrumb() {
    $post_id = get_the_ID();
    $app_name = get_the_title();

    $text = [
        'home'   => __('Home', 'apktemplates'),
        'page'   => __('Page %s', 'apktemplates'),
        'search' => __('You searched for %s', 'apktemplates'),
        '404'    => __('Error 404', 'apktemplates')
    ];

    $home_url = home_url('/');
    $item_list = [];
    $breadcrumbs = [];

    // Home
    $breadcrumbs[] = '<a href="' . esc_url($home_url) . '" class="breadcrum-list text-gray-500 dark:text-gray-200 hover:text-gray-700">' . esc_html($text['home']) . '</a>';
    $item_list[] = [
        "@type"    => "ListItem",
        "position" => 1,
        "name"     => $text['home'],
        "item"     => $home_url
    ];

    // --- Single Post ---
    if (is_singular('post')) {
        $post_categories = get_the_category();
        if (!empty($post_categories)) {
            // Use first parent category
            $cat = $post_categories[0];
            $breadcrumbs[] = '<a href="' . esc_url(get_category_link($cat->term_id)) . '" class="breadcrum-list text-gray-500 dark:text-gray-200 hover:text-gray-700">' . esc_html($cat->name) . '</a>';
            $item_list[] = [
                "@type"    => "ListItem",
                "position" => count($item_list) + 1,
                "name"     => $cat->name,
                "item"     => get_category_link($cat->term_id)
            ];
        }
        $breadcrumbs[] = '<span class="breadcrum-list text-gray-500 dark:text-gray-200">' . esc_html($app_name) . '</span>';
        $item_list[] = [
            "@type"    => "ListItem",
            "position" => count($item_list) + 1,
            "name"     => $app_name
        ];

    // --- Custom Post Type single ---
    } elseif (is_singular() && !is_singular('post')) {
        $post_type = get_post_type();
        $cpt = get_post_type_object($post_type);
        if ($cpt && !empty($cpt->has_archive)) {
            $archive_url = get_post_type_archive_link($post_type);
            $breadcrumbs[] = '<a href="' . esc_url($archive_url) . '" class="breadcrum-list text-gray-500 dark:text-gray-200 hover:text-gray-700">' . esc_html($cpt->labels->name) . '</a>';
            $item_list[] = [
                "@type"    => "ListItem",
                "position" => count($item_list) + 1,
                "name"     => $cpt->labels->name,
                "item"     => $archive_url
            ];
        }
        $breadcrumbs[] = '<span class="breadcrum-list text-gray-500 dark:text-gray-200">' . esc_html(get_the_title()) . '</span>';
        $item_list[] = [
            "@type"    => "ListItem",
            "position" => count($item_list) + 1,
            "name"     => get_the_title()
        ];

    // --- Archive (category, tag, taxonomy) ---
    } elseif (is_archive() && !is_post_type_archive()) {
        $term = get_queried_object();
        if ($term) {
            $breadcrumbs[] = '<span class="breadcrum-list text-gray-500 dark:text-gray-200">' . esc_html($term->name) . '</span>';
            $item_list[] = [
                "@type"    => "ListItem",
                "position" => count($item_list) + 1,
                "name"     => $term->name
            ];
        }

    // --- Post Type Archive ---
    } elseif (is_post_type_archive()) {
        $cpt = get_post_type_object(get_post_type());
        if ($cpt) {
            $breadcrumbs[] = '<span class="breadcrum-list text-gray-500 dark:text-gray-200">' . esc_html($cpt->labels->name) . '</span>';
            $item_list[] = [
                "@type"    => "ListItem",
                "position" => count($item_list) + 1,
                "name"     => $cpt->labels->name
            ];
        }

    // --- Pages ---
    } elseif (is_page()) {
        $ancestors = array_reverse(get_post_ancestors($post_id));
        foreach ($ancestors as $ancestor_id) {
            $breadcrumbs[] = '<a href="' . get_permalink($ancestor_id) . '" class="breadcrum-list text-gray-500 dark:text-gray-200 hover:text-gray-700">' . esc_html(get_the_title($ancestor_id)) . '</a>';
            $item_list[] = [
                "@type"    => "ListItem",
                "position" => count($item_list) + 1,
                "name"     => get_the_title($ancestor_id),
                "item"     => get_permalink($ancestor_id)
            ];
        }
        $breadcrumbs[] = '<span class="breadcrum-list text-gray-500 dark:text-gray-200">' . esc_html(get_the_title()) . '</span>';
        $item_list[] = [
            "@type"    => "ListItem",
            "position" => count($item_list) + 1,
            "name"     => get_the_title()
        ];

    // --- Search ---
    } elseif (is_search()) {
        $breadcrumbs[] = '<span class="breadcrum-list text-gray-500 dark:text-gray-200">' . sprintf($text['search'], get_search_query()) . '</span>';

    // --- 404 ---
    } elseif (is_404()) {
        $breadcrumbs[] = '<span class="breadcrum-list text-gray-500 dark:text-gray-200">' . $text['404'] . '</span>';
    }

    echo '<div class="breadcrumb"><div class="truncate">';
    echo implode('<span class="breadcrumb-sep text-gray-500 dark:text-gray-200 mx-2">/</span>', $breadcrumbs);
    echo '</div></div>';

    echo '<script type="application/ld+json">' . json_encode([
        "@context"        => "https://schema.org",
        "@type"           => "BreadcrumbList",
        "itemListElement" => $item_list
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
}