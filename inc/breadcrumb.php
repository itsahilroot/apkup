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

    // Home (Inactive)
    $breadcrumbs[] = '<a href="' . esc_url($home_url) . '" class="text-slate-400 dark:text-slate-500 hover:text-primary transition-colors duration-200">' . esc_html($text['home']) . '</a>';
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
            $child_cat = null;
            $parent_cat = null;
            foreach ($post_categories as $c) {
                if ($c->parent != 0) {
                    $child_cat = $c;
                    $parent_cat = get_term($c->parent, 'category');
                    break;
                }
            }
            
            if (!$child_cat) {
                $parent_cat = $post_categories[0];
            }
            
            if ($parent_cat && !is_wp_error($parent_cat)) {
                $breadcrumbs[] = '<a href="' . esc_url(get_category_link($parent_cat->term_id)) . '" class="text-slate-400 dark:text-slate-500 hover:text-primary transition-colors duration-200">' . esc_html($parent_cat->name) . '</a>';
                $item_list[] = [
                    "@type"    => "ListItem",
                    "position" => count($item_list) + 1,
                    "name"     => $parent_cat->name,
                    "item"     => get_category_link($parent_cat->term_id)
                ];
            }
            
            if ($child_cat) {
                $breadcrumbs[] = '<a href="' . esc_url(get_category_link($child_cat->term_id)) . '" class="text-slate-400 dark:text-slate-500 hover:text-primary transition-colors duration-200">' . esc_html($child_cat->name) . '</a>';
                $item_list[] = [
                    "@type"    => "ListItem",
                    "position" => count($item_list) + 1,
                    "name"     => $child_cat->name,
                    "item"     => get_category_link($child_cat->term_id)
                ];
            }
        }
        // Current post (Active)
        $breadcrumbs[] = '<span class="text-slate-700 dark:text-slate-200 truncate max-w-[140px] sm:max-w-[220px] inline-block align-bottom">' . esc_html($app_name) . '</span>';
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
            $breadcrumbs[] = '<a href="' . esc_url($archive_url) . '" class="text-slate-400 dark:text-slate-500 hover:text-primary transition-colors duration-200">' . esc_html($cpt->labels->name) . '</a>';
            $item_list[] = [
                "@type"    => "ListItem",
                "position" => count($item_list) + 1,
                "name"     => $cpt->labels->name,
                "item"     => $archive_url
            ];
        }
        // Active
        $breadcrumbs[] = '<span class="text-slate-700 dark:text-slate-200 truncate max-w-[140px] sm:max-w-[220px] inline-block align-bottom">' . esc_html(get_the_title()) . '</span>';
        $item_list[] = [
            "@type"    => "ListItem",
            "position" => count($item_list) + 1,
            "name"     => get_the_title()
        ];

    // --- Archive (category, tag, taxonomy) ---
    } elseif (is_archive() && !is_post_type_archive()) {
        $term = get_queried_object();
        if ($term) {
            $breadcrumbs[] = '<span class="text-slate-700 dark:text-slate-200">' . esc_html($term->name) . '</span>';
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
            $breadcrumbs[] = '<span class="text-slate-700 dark:text-slate-200">' . esc_html($cpt->labels->name) . '</span>';
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
            $breadcrumbs[] = '<a href="' . get_permalink($ancestor_id) . '" class="text-slate-400 dark:text-slate-500 hover:text-primary transition-colors duration-200">' . esc_html(get_the_title($ancestor_id)) . '</a>';
            $item_list[] = [
                "@type"    => "ListItem",
                "position" => count($item_list) + 1,
                "name"     => get_the_title($ancestor_id),
                "item"     => get_permalink($ancestor_id)
            ];
        }
        $breadcrumbs[] = '<span class="text-slate-700 dark:text-slate-200">' . esc_html(get_the_title()) . '</span>';
        $item_list[] = [
            "@type"    => "ListItem",
            "position" => count($item_list) + 1,
            "name"     => get_the_title()
        ];

    // --- Search ---
    } elseif (is_search()) {
        $breadcrumbs[] = '<span class="text-slate-700 dark:text-slate-200">' . sprintf($text['search'], get_search_query()) . '</span>';

    // --- 404 ---
    } elseif (is_404()) {
        $breadcrumbs[] = '<span class="text-slate-700 dark:text-slate-200">' . $text['404'] . '</span>';
    }

    // Breadcrumb output wrapper
    echo '<nav aria-label="Breadcrumb" class="flex items-center text-[11px] sm:text-xs font-semibold py-1 select-none">';
    echo '<div class="flex items-center flex-wrap gap-y-0.5 truncate max-w-full">';
    echo implode('<span class="text-slate-300 dark:text-slate-700 mx-1.5 font-normal select-none">&rsaquo;</span>', $breadcrumbs);
    echo '</div></nav>';

    echo '<script type="application/ld+json">' . json_encode([
        "@context"        => "https://schema.org",
        "@type"           => "BreadcrumbList",
        "itemListElement" => $item_list
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
}