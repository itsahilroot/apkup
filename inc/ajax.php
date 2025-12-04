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