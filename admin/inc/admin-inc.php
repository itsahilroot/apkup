<?php
/* Initializations */
function at_options($option, $default = false)
{
    $value = get_option('at_' . $option, false);

    if ($value !== false) {
        return $value;
    } else {
        return ($default !== false) ? $default : '';
    }
}

/* APK Importer */
function get_parsed_category($category)
{
    $parent_category = __('Apps', 'apktemplates');

    if (!empty($category) && strpos($category, 'GAME_') !== false) {
        $parent_category = __('Games', 'apktemplates');
    }

    return $parent_category;
}

function get_parsed_subcategory($category)
{
    $sub_category = '';

    if (!empty($category)) {
        $sub_category = strtolower(str_replace('GAME_', '', $category));
        $sub_category = str_replace('_', '-', $sub_category);
    }

    return $sub_category;
}

/* Panel */
function is_server_setting_valid($value, $limit)
{
    if ($value == -1) {
        return 999999;
    }

    if (preg_match('/^(\d+)(.)$/', $value, $matches)) {
        if ($matches[2] == 'G') {
            $value = $matches[1] * 1024 * 1024 * 1024;
        } else if ($matches[2] == 'M') {
            $value = $matches[1] * 1024 * 1024;
        } else if ($matches[2] == 'K') {
            $value = $matches[1] * 1024;
        }
    }
    return ($value >= $limit * 1024 * 1024);
}

function get_term_name_by_id($term_id)
{
    $term_info = get_term(intval($term_id));

    if (!is_wp_error($term_info) && isset($term_info->name)) {
        return esc_html($term_info->name);
    }

    return '';
}

function removeslashes_deep($string)
{
    return stripslashes(str_replace('\\', '', $string));
}

/* WordPress Inits */
function remove_at_admin_footer_wp_text()
{
    if (isset($_GET['page']) && in_array($_GET['page'], array('at-apk-importer', 'at-panel'))) {
        add_filter('admin_footer_text', function ($content) {
            return '<em>Thank your for choosing <a href="https://apktemplates.com" target="_blank">APKTEMPLATES</a></em>';
        }, 11);
    }
}
add_action('admin_init', 'remove_at_admin_footer_wp_text');

function apkt_format_bytes($get_bytes)
{
    $bytes = (int) $get_bytes;
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' Bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' Bytes';
    } else {
        $bytes = '0 Bytes';
    }

    return $bytes;
}

function apkt_set_post_thumbnail_from_url($post_id, $url) {
    $image_id = media_sideload_image($url, $post_id, null, 'id');
    
    if (!is_wp_error($image_id)) {
        return $image_id;
    }
    
    return 0;
}

add_action('rest_api_init', function() {
    register_rest_field('post', 'apktemplates', [
        'get_callback'    => 'get_apktemplates_post_meta',
        'update_callback' => 'update_apktemplates_post_meta',
        'schema'          => [
            'type'        => 'object',
            'description' => 'Customize APKTEMPLATES theme meta key and values.',
            'context'     => ['view', 'edit'],
        ],
    ]);
});

function get_apktemplates_post_meta($post, $field_name, $request) {
    $apktemplates = [
        'wp_description_GP'	=> get_post_meta($post['id'], 'wp_description_GP', true),
        'wp_mod_info_GP'	=> get_post_meta($post['id'], 'wp_mod_info_GP', true),
        'wp_whatnews_GP'	=> get_post_meta($post['id'], 'wp_whatnews_GP', true),
        'wp_title_GP'	=> get_post_meta($post['id'], 'wp_title_GP', true),
        'wp_version_GP'	=> get_post_meta($post['id'], 'wp_version_GP', true),
        'wp_developers_GP'  => get_post_meta($post['id'], 'wp_developers_GP', true),
        'wp_sizes_GP'  => get_post_meta($post['id'], 'wp_sizes_GP', true),
        'wp_GP_ID'  => get_post_meta($post['id'], 'wp_GP_ID', true),
        'wp_mods'  => get_post_meta($post['id'], 'wp_mods', true),
        'avg_rating'  => get_post_meta($post['id'], 'avg_rating', true),
        'total_votes'  => get_post_meta($post['id'], 'total_votes', true),
        'repeatable_download_link'  => get_post_meta($post['id'], 'repeatable_download_link', true),
        'ss_images'  => get_post_meta($post['id'], 'ss_images', true),
        'wp_poster_GP'  => get_post_meta($post['id'], 'wp_poster_GP', true),
    ];

    return $apktemplates;
}

function update_apktemplates_post_meta($meta_value, $post) {
    if (isset($meta_value['wp_description_GP'])) {
        update_post_meta($post->ID, 'wp_description_GP', $meta_value['wp_description_GP']);
    }

	if (isset($meta_value['wp_mod_info_GP'])) {
        update_post_meta($post->ID, 'wp_mod_info_GP', $meta_value['wp_mod_info_GP']);
    }
	
    if (isset($meta_value['wp_whatnews_GP'])) {
        update_post_meta($post->ID, 'wp_whatnews_GP', $meta_value['wp_whatnews_GP']);
    }

	if (isset($meta_value['wp_title_GP'])) {
        update_post_meta($post->ID, 'wp_title_GP', $meta_value['wp_title_GP']);
    }
	
    if (isset($meta_value['wp_version_GP'])) {
        update_post_meta($post->ID, 'wp_version_GP', $meta_value['wp_version_GP']);
    }
	
    if (isset($meta_value['wp_developers_GP'])) {
        update_post_meta($post->ID, 'wp_developers_GP', $meta_value['wp_developers_GP']);
    }
	
    if (isset($meta_value['wp_sizes_GP'])) {
        update_post_meta($post->ID, 'wp_sizes_GP', $meta_value['wp_sizes_GP']);
    }

    if (isset($meta_value['wp_GP_ID'])) {
        update_post_meta($post->ID, 'wp_GP_ID', $meta_value['wp_GP_ID']);
    }

    if (isset($meta_value['wp_mods'])) {
        update_post_meta($post->ID, 'wp_mods', $meta_value['wp_mods']);
    }

    if (isset($meta_value['avg_rating'])) {
        update_post_meta($post->ID, 'avg_rating', $meta_value['avg_rating']);
    }
	
    if (isset($meta_value['total_votes'])) {
        update_post_meta($post->ID, 'total_votes', $meta_value['total_votes']);
    }
	
    if (isset($meta_value['repeatable_download_link'])) {
        update_post_meta($post->ID, 'repeatable_download_link', $meta_value['repeatable_download_link']);
    }
	
    if (isset($meta_value['ss_images'])) {
        update_post_meta($post->ID, 'ss_images', $meta_value['ss_images']);
    }
	
    if (isset($meta_value['wp_poster_GP'])) {
        update_post_meta($post->ID, 'wp_poster_GP', $meta_value['wp_poster_GP']);
    }
}
function apktemplates_clean($string) {
   $string = str_replace(' ', '-', $string);
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
   return preg_replace('/-+/', '-', $string); 
}