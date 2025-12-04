<?php
function apkup_seo_schema() {
    if (!is_single()) {
        return;
    }

    $post_id    = get_the_ID();
    $post_type  = get_post_type($post_id);
    $post_url   = get_permalink($post_id);
    $post_title = get_the_title($post_id);
    $post_thumb = get_the_post_thumbnail_url($post_id);
    $published_time = get_the_time('c', $post_id);
    $modified_time  = get_the_modified_time('c', $post_id);
    $site_title     = get_bloginfo('name');
    $site_logo      = get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '';

    if ($post_type === 'post') {
        $datos_informacion = get_post_meta($post_id, 'datos_informacion', true);
        $datos_imagenes    = get_post_meta($post_id, 'datos_imagenes', true);

        $app_version  = $datos_informacion['version'] ?? '';
        $app_os       = $datos_informacion['os'] ?? 'ANDROID';
        $app_category = $datos_informacion['categoria_app'] ?? '';
        $app_desc     = !empty($datos_informacion['descripcion']) ? wp_strip_all_tags($datos_informacion['descripcion']) : '';
        $app_price    = $datos_informacion['offer']['price'] ?? 'gratis';
        $app_amount   = $datos_informacion['offer']['amount'] ?? '0';
        $app_currency = $datos_informacion['offer']['currency'] ?? 'USD';
        $rating_avg   = get_post_meta($post_id, 'new_rating_average', true) ?: '';
        $rating_users = get_post_meta($post_id, 'new_rating_users', true) ?: '';

        $price_amount = ($app_price === 'gratis') ? '0' : $app_amount;

        $screenshots = [];
        if (is_array($datos_imagenes)) {
            foreach ($datos_imagenes as $ss) {
                $screenshots[] = [
                    "@type" => "ImageObject",
                    "url"   => esc_url($ss),
                ];
            }
        }

        $schema = [
            "@context" => "http://schema.org",
            "@type"    => "SoftwareApplication",
            "name"     => $post_title,
            "url"      => esc_url($post_url),
            "image"    => esc_url($post_thumb),
            "softwareVersion" => $app_version,
            "operatingSystem" => strtoupper($app_os),
            "applicationCategory" => strtoupper($app_category),
            "description" => $app_desc,
            "offers" => [
                "@type" => "Offer",
                "price" => $price_amount,
                "priceCurrency" => $app_currency,
            ],
        ];

        if (!empty($screenshots)) {
            $schema["screenshot"] = $screenshots;
        }

        if (!empty($rating_avg) && !empty($rating_users)) {
            $schema["aggregateRating"] = [
                "@type"       => "AggregateRating",
                "ratingValue" => $rating_avg,
                "ratingCount" => $rating_users,
            ];
        }

        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';

    } elseif ($post_type === 'blog') {
        $schema_news = [
            "@context" => "https://schema.org",
            "@type"    => "NewsArticle",
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id"   => esc_url($post_url),
            ],
            "headline"       => $post_title,
            "image"          => [ esc_url($post_thumb) ],
            "datePublished"  => $published_time,
            "dateModified"   => $modified_time,
            "publisher" => [
                "@type" => "Organization",
                "name"  => $site_title ?: "APKGSTORE",
                "logo"  => [
                    "@type" => "ImageObject",
                    "url"   => $site_logo,
                ],
            ],
        ];

        echo '<script type="application/ld+json">' . wp_json_encode($schema_news, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
add_action('wp_head', 'apkup_seo_schema', 1);
