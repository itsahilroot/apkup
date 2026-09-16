<?php
// Handle like via AJAX
function apkup_like_comment() {
    check_ajax_referer('apkup_nonce', 'nonce');

    $comment_id = intval($_POST['comment_id']);
    if (!$comment_id) {
        wp_send_json_error(['message' => 'Invalid comment ID']);
    }

    $likes = (int) get_comment_meta($comment_id, 'apkup_likes', true);
    $likes++;
    update_comment_meta($comment_id, 'apkup_likes', $likes);

    wp_send_json_success(['likes' => $likes]);
}
add_action('wp_ajax_apkup_like_comment', 'apkup_like_comment');
add_action('wp_ajax_nopriv_apkup_like_comment', 'apkup_like_comment');

function apkup_rate_post() {
    check_ajax_referer('apkup_nonce', 'nonce');

    $post_id = intval($_POST['post_id']);
    $rating  = floatval($_POST['rating']);

    if (!$post_id || $rating < 1 || $rating > 5) {
        wp_send_json_error(['message' => 'Invalid rating.']);
    }

    $cookie_key = 'apkup_rated_' . $post_id;
    if (isset($_COOKIE[$cookie_key]) && $_COOKIE[$cookie_key] === '1') {
        wp_send_json_error(['message' => 'You already rated this post.']);
    }

    $users   = (int) get_post_meta($post_id, 'new_rating_users', true);
    $average = (float) get_post_meta($post_id, 'new_rating_average', true);

    $total_score = $average * $users;
    $users++;
    $new_average = ($total_score + $rating) / $users;

    update_post_meta($post_id, 'new_rating_users', $users);
    update_post_meta($post_id, 'new_rating_average', $new_average);

    setcookie($cookie_key, '1', time() + 365 * DAY_IN_SECONDS, "/");

    wp_send_json_success([
        'new_votes'   => $users,
        'new_average' => number_format((float)$new_average, 1), // round to 1 decimal
    ]);
}

add_action('wp_ajax_apkup_rate_post', 'apkup_rate_post');
add_action('wp_ajax_nopriv_apkup_rate_post', 'apkup_rate_post');

// AJAX Search Handler
function apkup_ajax_search() {
    check_ajax_referer('apkup_nonce', 'nonce');

    if (!get_theme_mod('au_ajax_search_swt', false)) {
        wp_send_json_error(['message' => 'AJAX Search disabled']);
    }

    $query = sanitize_text_field($_GET['term']);
    if (strlen($query) < 2) {
        wp_send_json_success([]);
    }

    $args = [
        's'              => $query,
        'post_type'      => ['post'], // Limit to posts (apps/games)
        'posts_per_page' => 5,
        'post_status'    => 'publish',
    ];

    $search_query = new WP_Query($args);
    $results = [];

    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            
            $post_id = get_the_ID();
            $thumbnail = get_the_post_thumbnail_url($post_id, 'thumbnail');
            if (!$thumbnail) {
                 // Fallback or attempt to get from meta if your theme stores it there
                $thumbnail = get_post_meta($post_id, 'wp_poster_GP', true);
            }
            // If still no thumbnail, you might want a default icon

            $data = get_post_meta($post_id, 'datos_informacion', true);
            $data = is_array($data) ? $data : [];
            $version = !empty($data['version']) ? $data['version'] : '1.0';

            $results[] = [
                'title'     => get_the_title(),
                'permalink' => get_permalink(),
                'thumbnail' => $thumbnail,
                'rating'    => number_format((float)(get_post_meta($post_id, 'new_rating_average', true) ?: 0), 1),
                'version'   => $version
            ];
        }
        wp_reset_postdata();
    }

    wp_send_json_success($results);
}
add_action('wp_ajax_apkup_ajax_search', 'apkup_ajax_search');
add_action('wp_ajax_nopriv_apkup_ajax_search', 'apkup_ajax_search');

add_action('wp_ajax_apkt_mediafire_direct_link', 'apkt_mediafire_direct_link_handler');
add_action('wp_ajax_nopriv_apkt_mediafire_direct_link', 'apkt_mediafire_direct_link_handler');

function apkt_mediafire_direct_link_handler() {
    check_ajax_referer('apkup_nonce', 'nonce');

    $url = esc_url_raw($_POST['url'] ?? '');

    if (!$url) {
        wp_send_json_error('No URL provided.');
    }

    $parsed_url = wp_parse_url($url);
    if (!isset($parsed_url['host'])) {
        wp_send_json_error('Invalid URL.');
    }

    $host = strtolower($parsed_url['host']);
    if ($host !== 'mediafire.com' && $host !== 'www.mediafire.com') {
        wp_send_json_error('Not a MediaFire URL.');
    }

    $response = wp_remote_get($url, [
        'timeout'   => 15,
        'sslverify' => true,
        'headers'   => [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ]
    ]);

    if (is_wp_error($response)) {
        wp_send_json_error('Failed to fetch MediaFire page: ' . $response->get_error_message());
    }

    $html = wp_remote_retrieve_body($response);

    if (empty($html)) {
        wp_send_json_error('Empty response from MediaFire.');
    }

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR);
    $xpath = new DOMXPath($dom);

    $direct_url = '';

    $node = $xpath->query("//a[@id='downloadButton']");
    if ($node->length > 0) {
        $href = $node->item(0)->getAttribute('href');
        if ($href) {
            $direct_url = $href;
        }
    }

    if (!$direct_url) {
        $inputs = $xpath->query("//a[contains(@class, 'input')]");
        foreach ($inputs as $input) {
            $href = $input->getAttribute('href');
            if ($href && preg_match('/download\.mediafire\.com/', $href)) {
                $direct_url = $href;
                break;
            }
        }
    }

    libxml_clear_errors();

    if ($direct_url) {
        wp_send_json_success(['direct_url' => $direct_url]);
    } else {
        wp_send_json_error('Could not extract direct download link from MediaFire.');
    }
}