<?php
/* APK Import Ajax */

function at_gp_create_post()
{
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');

    if (!wp_verify_nonce($nonce, 'gplay_nonce')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Khatam! Tata! Good Bye!',
            ],
        ]);
        exit;
    }

    if (!current_user_can('manage_options')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Permission denied.',
            ],
        ]);
        exit;
    }

    $apk_url = filter_input(INPUT_POST, 'gplay_url', FILTER_SANITIZE_URL);

    // Parse package ID and check for duplicate before starting extraction/import
    $package_id = '';
    $url_parts = parse_url($apk_url);
    if (isset($url_parts['query'])) {
        parse_str($url_parts['query'], $query_params);
        if (!empty($query_params['id'])) {
            $package_id = sanitize_text_field($query_params['id']);
        }
    }
    if (empty($package_id) && preg_match('/id=([a-zA-Z0-9._\-]+)/', $apk_url, $matches)) {
        $package_id = sanitize_text_field($matches[1]);
    }

    if (!empty($package_id)) {
        $existing_posts = get_posts([
            'post_type' => 'post',
            'post_status' => 'any',
            'meta_query' => [
                [
                    'key' => 'wp_GP_ID',
                    'value' => $package_id,
                    'compare' => '=',
                ]
            ],
            'posts_per_page' => 1,
        ]);
        if (!empty($existing_posts)) {
            $existing_post = $existing_posts[0];
            wp_send_json([
                'status' => 'error',
                'data' => [
                    'message' => sprintf(
                        __('This app already exists. <a href="%s" target="_blank">Edit Post</a> | <a href="%s" target="_blank">View Post</a>', 'apktemplates'),
                        esc_url(get_edit_post_link($existing_post->ID)),
                        esc_url(get_permalink($existing_post->ID))
                    ),
                ],
            ]);
            exit;
        }
    }

    $is_advanced_options = filter_input(INPUT_POST, 'is_advanced_options', FILTER_VALIDATE_BOOLEAN);
    update_option('at_is_advanced_options', $is_advanced_options) || add_option('at_is_advanced_options', $is_advanced_options);

    $post_language = sanitize_text_field($_POST['post_language'] ?? at_options('post_language', 'es-ES'));

    if ($is_advanced_options) {
        $post_status            = sanitize_text_field($_POST['post_status'] ?? 'publish');
        $post_title_start       = sanitize_text_field($_POST['post_title_start'] ?? '');
        $post_title_end         = sanitize_text_field($_POST['post_title_end'] ?? '');
        $mod_feature            = sanitize_text_field($_POST['mod_feature'] ?? '');
        $post_thumbnail_format  = sanitize_text_field($_POST['post_thumbnail_format'] ?? 'jpg');
        $post_thumbnail_quality = sanitize_text_field($_POST['post_thumbnail_quality'] ?? '80');
        $import_screenshots     = filter_var($_POST['import_screenshots'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $post_screenshots_limit = sanitize_text_field($_POST['post_screenshots_limit'] ?? '5');
        $post_screenshots_format = sanitize_text_field($_POST['post_screenshots_format'] ?? 'jpg');

        update_option('at_post_status', $post_status);
        update_option('at_post_title_start', $post_title_start);
        update_option('at_post_title_end', $post_title_end);
        update_option('at_mod_feature', $mod_feature);
        update_option('at_post_thumbnail_format', $post_thumbnail_format);
        update_option('at_post_thumbnail_quality', $post_thumbnail_quality);
        update_option('at_import_screenshots', $import_screenshots);
        update_option('at_post_screenshots_limit', $post_screenshots_limit);
        update_option('at_post_screenshots_format', $post_screenshots_format);
        update_option('at_post_language', $post_language);
    }

    $apk_data = new AT_Google_Play($post_language);
    $response = $apk_data->extract($apk_url);

    wp_send_json($response);
    exit;
}
add_action('wp_ajax_at_gp_create_post', 'at_gp_create_post');

function at_gp_search_posts()
{
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');
    $search_query = strtolower(trim(sanitize_text_field($_POST['search_query'] ?? '')));

    if (!wp_verify_nonce($nonce, 'gplay_nonce')) {
        wp_send_json_error(['message' => 'Invalid request.']);
        exit;
    }

    if (!current_user_can('edit_posts')) {
        wp_send_json_error(['message' => 'Permission denied.']);
        exit;
    }

    if (strlen($search_query) < 3) {
        wp_send_json_error(['message' => 'Search query must be at least 3 characters long.']);
        exit;
    }

    $base_url = 'https://play.google.com/store/search?c=apps&q=';
    $search_url = $base_url . urlencode($search_query);

    $search_data = new AT_GP_Search();
    $response = $search_data->get_search_results($search_url);

    if ($response['status'] === 'success') {
        wp_send_json_success($response['data']);
    } else {
        wp_send_json_error(['message' => $response['data']['message']]);
    }
    exit;
}

add_action('wp_ajax_at_gp_search_posts', 'at_gp_search_posts');

function save_apktemplates_settings()
{
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');

    if (!wp_verify_nonce($nonce, 'panel_nonce')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Khatam! Tata! Good Bye!',
            ],
        ]);
        exit;
    }

    if (!current_user_can('manage_options')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Permission denied.',
            ],
        ]);
        exit;
    }

    $is_mod_title = $_POST['is_mod_title'];
    $is_mod_feature_title = $_POST['is_mod_feature_title'];
    $is_title_version = $_POST['is_title_version'];
    $is_blocks_content = $_POST['is_blocks_content'];
    $is_get_apk = $_POST['is_get_apk'];
    $upload_storage = sanitize_text_field($_POST['upload_storage']);
    $gdrive_client_id = sanitize_text_field($_POST['gdrive_client_id']);
    $gdrive_client_secret = sanitize_text_field($_POST['gdrive_client_secret']);
    $gdrive_folder_name = sanitize_text_field($_POST['gdrive_folder_name']);
    $ftp_server_ip = sanitize_text_field($_POST['ftp_server_ip']);
    $ftp_port = sanitize_text_field($_POST['ftp_port']);
    $ftp_username = sanitize_text_field($_POST['ftp_username']);
    $ftp_password = sanitize_text_field($_POST['ftp_password']);
    $ftp_directory = sanitize_text_field($_POST['ftp_directory']);
    $ftp_url = sanitize_text_field($_POST['ftp_url']);

    update_option('at_is_mod_title', $is_mod_title) || add_option('at_is_mod_title', $is_mod_title);
    update_option('at_is_mod_feature_title', $is_mod_feature_title) || add_option('at_is_mod_feature_title', $is_mod_feature_title);
    update_option('at_is_title_version', $is_title_version) || add_option('at_is_title_version', $is_title_version);
    update_option('at_is_blocks_content', $is_blocks_content) || add_option('at_is_blocks_content', $is_blocks_content);
    update_option('at_is_get_apk', $is_get_apk) || add_option('at_is_get_apk', $is_get_apk);
    update_option('at_upload_storage', $upload_storage) || add_option('at_upload_storage', $upload_storage);
    update_option('at_gdrive_client_id', $gdrive_client_id) || add_option('at_gdrive_client_id', $gdrive_client_id);
    update_option('at_gdrive_client_secret', $gdrive_client_secret) || add_option('at_gdrive_client_secret', $gdrive_client_secret);
    update_option('at_gdrive_folder_name', $gdrive_folder_name) || add_option('at_gdrive_folder_name', $gdrive_folder_name);
    update_option('at_ftp_server_ip', $ftp_server_ip) || add_option('at_ftp_server_ip', $ftp_server_ip);
    update_option('at_ftp_port', $ftp_port) || add_option('at_ftp_port', $ftp_port);
    update_option('at_ftp_username', $ftp_username) || add_option('at_ftp_username', $ftp_username);
    update_option('at_ftp_password', $ftp_password) || add_option('at_ftp_password', $ftp_password);
    update_option('at_ftp_directory', $ftp_directory) || add_option('at_ftp_directory', $ftp_directory);
    update_option('at_ftp_url', $ftp_url) || add_option('at_ftp_url', $ftp_url);
}

add_action('wp_ajax_save_apktemplates_settings', 'save_apktemplates_settings');

/* Panel Ajax */
function at_search_term()
{
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');

    if (!wp_verify_nonce($nonce, 'panel_nonce')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Khatam! Tata! Good Bye!',
            ],
        ]);
        exit;
    }

    if (!current_user_can('edit_posts')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Permission denied.',
            ],
        ]);
        exit;
    }

    $query = $_POST['query'];

    $query_term = new WP_Term_Query(
        array(
            'taxonomy' => array('category', 'post_tag'),
            'hide_empty' => false,
            'name__like' => $query,
            'posts_per_page' => 50,
        )
    );

    if ($query_term->terms) {
        echo '<ul>';
        foreach ($query_term->terms as $term) {
            echo '<li data-term-id="' . $term->term_id . '">' . $term->name . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<div class="no-result">No terms found...</div>';
    }

    wp_die();
}
add_action('wp_ajax_at_search_term', 'at_search_term');

function at_search_post()
{
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');

    if (!wp_verify_nonce($nonce, 'panel_nonce')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Khatam! Tata! Good Bye!',
            ],
        ]);
        exit;
    }

    if (!current_user_can('edit_posts')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Permission denied.',
            ],
        ]);
        exit;
    }

    $query = $_POST['query'];

    $query_posts = new WP_Query(
        array(
            'post_status' => 'publish',
            'post_type' => 'post',
            's' => $query,
            'post_parent' => 0,
            'posts_per_page' => 50,
        )
    );
    if ($query_posts->have_posts()):
        echo '<ul>';
        while ($query_posts->have_posts()):
            $query_posts->the_post();
            echo '<li data-post-id="' . get_the_ID() . '">' . get_the_title() . '</li>';
        endwhile;
        echo '</ul>';
    else:
        echo '<div class="no-result">No posts found...</div>';
    endif;

    wp_die();
}
add_action('wp_ajax_at_search_post', 'at_search_post');

function apkt_delete_files($target) {
    if (empty($target)) {
        return;
    }
    $upload_dir = wp_upload_dir();
    $base_upload_dir = realpath($upload_dir['basedir']);
    $real_target = realpath($target);
    if (!$real_target || strpos($real_target, $base_upload_dir) !== 0) {
        return;
    }
    if (is_dir($real_target)) {
        $files = glob($real_target . '/*', GLOB_MARK);
        foreach ($files as $file) {
            apkt_delete_files($file);
        }
        @rmdir($real_target);
    } elseif (is_file($real_target)) {
        @unlink($real_target);
    }
}

function apkt_delete_folder_action()
{
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');

    if (!wp_verify_nonce($nonce, 'panel_nonce')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Khatam! Tata! Good Bye!',
            ],
        ]);
        exit;
    }

    if (!current_user_can('manage_options')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Permission denied.',
            ],
        ]);
        exit;
    }

    $upload_dir = wp_upload_dir();
    $cache_dir = trailingslashit($upload_dir['basedir']) . 'apkt_cache';
    if (file_exists($cache_dir)) {
        apkt_delete_files($cache_dir);
    }
    wp_send_json_success('Cache cleared :)');
    exit;
}

add_action('wp_ajax_apkt_delete_folder_action', 'apkt_delete_folder_action');


function save_at_customization()
{
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');

    if (!wp_verify_nonce($nonce, 'panel_nonce')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Khatam! Tata! Good Bye!',
            ],
        ]);
        exit;
    }

    if (!current_user_can('manage_options')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Permission denied.',
            ],
        ]);
        exit;
    }

    $data = $_POST['data'];

    $new_data = [];
    $repeater_data = [];
    $multi_select_data = [];
    $options_data = [];

    $options = [
        'is_mod_title',
        'is_mod_feature_title',
        'is_title_version',
        'upload_storage',
        'gdrive_client_id',
        'gdrive_client_secret',
        'gdrive_folder_name',
        'ftp_server_ip',
        'ftp_port',
        'ftp_username',
        'ftp_password',
        'ftp_directory',
        'ftp_url',
        'appyn_apikey'
    ];

    $single_data = array_filter($data, function ($item) {
        return strpos($item['name'], '[') === false;
    });

    $repeater_datas = array_filter($data, function ($item) {
        return strpos($item['name'], '[') !== false;
    });

    foreach ($single_data as $item) {
        if ($item['value'] === 'true' || $item['value'] === 'false') {
            $item['value'] = filter_var($item['value'], FILTER_VALIDATE_BOOLEAN);
        } else {
            $item['value'] = removeslashes_deep($item['value']);
        }

        if (!in_array($item['name'], $options)) {
            $new_data[$item['name']] = $item['value'];
        } else {
            $options_data[$item['name']] = $item['value'];
        }
    }
    // for normal repeater with array (download faq and home terms)
    foreach ($repeater_datas as $item) {
        if ($item['value'] === 'true' || $item['value'] === 'false') {
            $item['value'] = filter_var($item['value'], FILTER_VALIDATE_BOOLEAN);
        } else {
            $item['value'] = removeslashes_deep($item['value']);
        }

        if (!in_array($item['name'], $options)) {
            if (strpos($item['name'], '[]') !== false) {
                $main_name = str_replace('[]', '', $item['name']);
                $repeater_data[$main_name] = array();
            } else {
                preg_match('/^([^\[]+)\[([\d]+)\]\[([^\]]+)\]$/', $item['name'], $matches);

                if (count($matches) === 4) {
                    $main_name = $matches[1];
                    $index = $matches[2];
                    $field_name = $matches[3];

                    if (!isset($repeater_data[$main_name])) {
                        $repeater_data[$main_name] = array();
                    }

                    if (!isset($repeater_data[$main_name][$index])) {
                        $repeater_data[$main_name][$index] = array();
                    }

                    $repeater_data[$main_name][$index][$field_name] = $item['value'];
                }
            }
        }
    }
    // For multi selected options repeater (App Info)
    foreach ($repeater_datas as $item) {
        if ($item['value'] === 'true' || $item['value'] === 'false') {
            $item['value'] = filter_var($item['value'], FILTER_VALIDATE_BOOLEAN);
        }
        if (!in_array($item['name'], $options)) {
            preg_match('/^([^\[]+)(\[[^\]]+\])?$/', $item['name'], $matches);

            if (count($matches) === 3) {
                $main_name = $matches[1];
                $multi_select_suffix = $matches[2];
                if ($multi_select_suffix) {
                    $value_key = trim($multi_select_suffix, '[]');
                    if ($item['value'] === true) {
                        if (!isset($multi_select_data[$main_name])) {
                            $multi_select_data[$main_name] = [];
                        }
                        $multi_select_data[$main_name][] = $value_key;
                    }
                }
            }
        }
    }

    foreach ($repeater_data as $main_name => $values) {
        $new_data[$main_name] = $values;
    }

    foreach ($multi_select_data as $main_name => $values) {
        $new_data[$main_name] = $values;
    }

    $sensitive_code_fields = [
        'au_head_code',
        'au_footer_code',
        'home_top_ads',
        'home_botm_ads',
        'single_top_ads',
        'single_botm_ads',
        'archive_top_ads',
        'archive_botm_ads',
        'download_top_ads',
        'download_botm_ads'
    ];

    foreach ($new_data as $main_name => $values) {
        if (in_array($main_name, $sensitive_code_fields)) {
            if (!current_user_can('unfiltered_html')) {
                wp_send_json([
                    'status' => 'error',
                    'data' => [
                        'message' => 'Permission denied: unfiltered_html capability is required to modify header, footer, or advertisement code fields.',
                    ],
                ]);
                exit;
            }
        }
        set_theme_mod($main_name, $values);
    }

    foreach ($options_data as $main_name => $values) {
        if ($main_name === 'appyn_apikey') {
            update_option('appyn_apikey', $values);
        } else {
            update_option('at_' . $main_name, $values);
        }
    }

    wp_send_json_success('Changes Saved!');
    wp_die();
}

add_action('wp_ajax_save_at_customization', 'save_at_customization');

function apkt_import_demo()
{
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');

    if (!wp_verify_nonce($nonce, 'panel_nonce')) {
        wp_send_json_error('Invalid nonce.');
        exit;
    }

    if (!current_user_can('manage_options')) {
        wp_send_json_error('Permission denied.');
        exit;
    }

    if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] === UPLOAD_ERR_OK) {
        $import_file = $_FILES['import_file']['tmp_name'];
        $import_json = file_get_contents($import_file);

        if ($import_json !== false) {
            $demo_data = json_decode($import_json, true);
            if (is_array($demo_data)) {
                if (isset($demo_data['info']) && strtolower($demo_data['info']['theme_name']) === strtolower(APKT_THEME_NAME)) {

                    foreach ($demo_data['posts'] as $post_data) {
                        $title = $post_data['title'];
                        $description = wp_encode_emoji($post_data['description']);
                        $thumbnail_url = $post_data['thumbnail'];
                        $banner_url = $post_data['apktemplates']['wp_poster_GP'];

                        $parent_cat_name = $post_data['category']['name'];
                        $parent_cat_slug = $post_data['category']['slug'];

                        $child_cat_name = $post_data['subcategory']['name'];
                        $child_cat_slug = $post_data['subcategory']['slug'];

                        $parent_cat_id = null;
                        $child_cat_id = null;

                        $parent_category = get_term_by("slug", $parent_cat_slug, "category");

                        if ($parent_category) {
                            $parent_cat_id = $parent_category->term_id;
                        } else {
                            $parent_id = wp_insert_term($parent_cat_name, "category", ['slug' => $parent_cat_slug]);
                            if (!is_wp_error($parent_id)) {
                                $parent_cat_id = $parent_id["term_id"];
                            }
                        }

                        $child_category = get_term_by("slug", $child_cat_slug, "category");

                        if ($child_category) {
                            $child_cat_id = $child_category->term_id;
                        } else {
                            $child_id = wp_insert_term($child_cat_name, "category", ["parent" => $parent_cat_id, "slug" => $child_cat_slug]);
                            if (!is_wp_error($child_id)) {
                                $child_cat_id = $child_id["term_id"];
                            }
                        }

                        $post_id = wp_insert_post([
                            'post_title' => $title,
                            'post_content' => $description,
                            'post_category' => [$parent_cat_id, $child_cat_id],
                            'post_status' => 'publish',
                            'meta_input' => $post_data['apktemplates']
                        ]);

                        if ($post_id && !is_wp_error($post_id)) {
                            if (!empty($banner_url)) {
                                $image_id = media_sideload_image($banner_url, $post_id, null, 'id');

                                if (!is_wp_error($image_id)) {
                                    $uploaded_image_url = wp_get_attachment_url($image_id);
                                    update_post_meta($post_id, 'wp_poster_GP', $uploaded_image_url);
                                }
                            }

                            if (!empty($thumbnail_url)) {
                                $image_id = apkt_set_post_thumbnail_from_url($post_id, $thumbnail_url);
                                set_post_thumbnail($post_id, $image_id);
                            }
                        }
                    }

                    foreach ($demo_data['articles'] as $post_data) {
                        $title = $post_data['title'];
                        $description = wp_encode_emoji($post_data['description']);
                        $thumbnail_url = $post_data['thumbnail'];

                        $post_id = wp_insert_post([
                            'post_title' => $title,
                            'post_content' => $description,
                            'post_type' => 'articles',
                            'post_status' => 'publish',
                        ]);

                        if ($post_id && !is_wp_error($post_id)) {

                            if (!empty($thumbnail_url)) {
                                $image_id = apkt_set_post_thumbnail_from_url($post_id, $thumbnail_url);
                                set_post_thumbnail($post_id, $image_id);
                            }
                        }
                    }

                    foreach ($demo_data['news'] as $post_data) {
                        $title = $post_data['title'];
                        $description = wp_encode_emoji($post_data['description']);
                        $thumbnail_url = $post_data['thumbnail'];

                        $post_id = wp_insert_post([
                            'post_title' => $title,
                            'post_content' => $description,
                            'post_type' => 'news',
                            'post_status' => 'publish',
                        ]);

                        if ($post_id && !is_wp_error($post_id)) {

                            if (!empty($thumbnail_url)) {
                                $image_id = apkt_set_post_thumbnail_from_url($post_id, $thumbnail_url);
                                set_post_thumbnail($post_id, $image_id);
                            }
                        }
                    }

                    wp_send_json_success('Import demo successful :)');
                } else {
                    wp_send_json_error('The imported demo is not for this theme.');
                }
            } else {
                wp_send_json_error('Invalid JSON format');
            }
        } else {
            wp_send_json_error('Unable to read file');
        }
    } else {
        wp_send_json_error('No file uploaded or error occurred');
    }
    exit;
}

add_action('wp_ajax_apkt_import_demo', 'apkt_import_demo');

function apkt_import_settings()
{
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');

    if (!wp_verify_nonce($nonce, 'panel_nonce')) {
        wp_send_json_error('Invalid nonce.');
        exit;
    }

    if (!current_user_can('manage_options')) {
        wp_send_json_error('Permission denied.');
        exit;
    }

    if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] === UPLOAD_ERR_OK) {
        $import_file = $_FILES['import_file']['tmp_name'];

        $import_json = file_get_contents($import_file);

        if ($import_json !== false) {
            $backup_data = json_decode($import_json, true);

            if (is_array($backup_data)) {
                if (isset($backup_data['info']) && $backup_data['info']['theme_name'] === strtolower(APKT_THEME_NAME)) {
                    $sensitive_code_fields = [
                        'au_head_code',
                        'au_footer_code',
                        'home_top_ads',
                        'home_botm_ads',
                        'single_top_ads',
                        'single_botm_ads',
                        'archive_top_ads',
                        'archive_botm_ads',
                        'download_top_ads',
                        'download_botm_ads'
                    ];

                    foreach ($backup_data as $option_name => $option_value) {
                        if ($option_name !== 'info') {
                            if (in_array($option_name, $sensitive_code_fields) && !current_user_can('unfiltered_html')) {
                                continue; // skip code fields if user lacks unfiltered_html capability
                            }
                            if ($option_value['is_option']) {
                                update_option($option_name, $option_value['value']);
                            } else {
                                set_theme_mod($option_name, $option_value['value']);
                            }
                        }
                    }

                    wp_send_json_success('Import successful :)');
                } else {
                    wp_send_json_error('The imported backup is not for this theme.');
                }
            } else {
                wp_send_json_error('Invalid JSON format');
            }
        } else {
            wp_send_json_error('Unable to read file');
        }
    } else {
        wp_send_json_error('No file uploaded or error occurred');
    }
    exit;
}
add_action('wp_ajax_apkt_import_settings', 'apkt_import_settings');

function apkt_export_settings()
{
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');

    if (!wp_verify_nonce($nonce, 'panel_nonce')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Khatam! Tata! Good Bye!',
            ],
        ]);
        exit;
    }

    if (!current_user_can('manage_options')) {
        wp_send_json([
            'status' => 'error',
            'data' => [
                'message' => 'Permission denied.',
            ],
        ]);
        exit;
    }

    $date = date('Y-m-d_H-i-s');

    $backup_data = array();

    $backup_data['info'] = array(
        'theme_name' => strtolower(APKT_THEME_NAME),
        'theme_version' => APKT_THEME_VERSION,
        'author' => 'apktemplates',
        'created' => $date
    );

    $option_names = array(
        'at_is_mod_title',
        'at_is_mod_feature_title',
        'at_is_title_version',
    );

    $theme_mods_names = array(
        'theme_colors',
        'logo_txt',
        'head_code',
        'au_games_menu_url',
        'au_apps_menu_url',
        'au_telegram_menu_url',
        'home_terms',
        'home_articles_swt',
        'home_articles_title',
        'home_articles_limit',
        'home_news_swt',
        'home_news_title',
        'home_news_limit',
        'sp_big_thumb_swt',
        'app_info',
        'mod_info_swt',
        'scroll_download',
        'sp_screenshot_swt',
        'screenshots_limit',
        'sp_telegram_swt',
        'recommend_swt',
        'recommend_post_limit',
        'download_timer',
        'download_recommend_swt',
        'download_recommend_post_limit',
        'download_faq_swt',
        'download_faq_title',
        'download_faq',
        'popular_game_banner',
        'popular_game',
        'sidebar_cat_1',
        'sidebar_cat_2',
        'advertisement_txt',
        'home_top_ads_swt',
        'home_top_ads',
        'home_botm_ads_swt',
        'home_botm_ads',
        'single_top_ads_swt',
        'single_top_ads',
        'single_botm_ads_swt',
        'single_botm_ads',
        'archive_top_ads_swt',
        'archive_top_ads',
        'archive_botm_ads_swt',
        'archive_botm_ads',
        'download_top_ads_swt',
        'download_top_ads',
        'download_botm_ads_swt',
        'download_botm_ads',
        'facebook_url',
        'twitter_url',
        'youtube_url',
        'telegram_url',
        'tiktok_url',
        'pinterest_url',
        'whatsapp_url',
        'instagram_url',
        'github_url',
        'linkedin_url',
        'skype_url',
        'tumblr_url',
        'twitch_url',
        'vk_url',
        'reddit_url',
        'footer_copyright',
        'footer_code',
        'archive_featured_swt',
        'archive_featured_count',
        'archive_recent_swt',
        'archive_recent_limit',
        'archive_recommended_swt',
        'archive_recommended_limit',
        'archive_premium_swt',
        'archive_premium_limit',
        'archive_sort',
        'archive_posts_limit',
        'archive_top_apps_swt',
        'archive_top_apps_count',
        'archive_numbered_subcats',
        'archive_carousel_swt',
        'archive_carousel_subcats',
        'archive_carousel_sort',
        'archive_carousel_posts',
        'archive_dynamic_subcats',
        'popular_page_items',
        'recommended_page_items',
        'site_pjax_swt',
        'site_cache_swt',
        'site_cache_time',
        'scrapedo_api_key',
        'zenrows_api_key'
    );

    foreach ($option_names as $option_name) {
        $backup_data[$option_name] = array(
            'value' => get_option($option_name),
            'is_option' => true,
        );
    }

    foreach ($theme_mods_names as $theme_mod_name) {
        $backup_data[$theme_mod_name] = array(
            'value' => get_theme_mod($theme_mod_name),
            'is_option' => false,
        );
    }

    $backup_json = json_encode($backup_data);
    $upload_dir = wp_upload_dir();
    $cache_dir = trailingslashit($upload_dir['basedir']) . 'apkt_cache';
    if (!file_exists($cache_dir)) {
        wp_mkdir_p($cache_dir);
    }
    $export_json_path = $cache_dir . '/' . strtolower(APKT_THEME_NAME) . '_' . $date . '.json';

    file_put_contents($export_json_path, $backup_json);

    $cache_url = trailingslashit($upload_dir['baseurl']) . 'apkt_cache';
    $export_json_url = $cache_url . '/' . strtolower(APKT_THEME_NAME) . '_' . $date . '.json';
    wp_send_json_success($export_json_url);
    exit;
}
add_action('wp_ajax_apkt_export_settings', 'apkt_export_settings');

function apkup_ajax_clear_archive_cache() {
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');
    if (!wp_verify_nonce($nonce, 'panel_nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce.']);
        exit;
    }

    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Permission denied.']);
        exit;
    }

    if (function_exists('apkup_clear_all_transients')) {
        apkup_clear_all_transients();
        wp_send_json_success('Site cache cleared!');
    } else {
        wp_send_json_error(['message' => 'Cache clearing function not found.']);
    }
    exit;
}
add_action('wp_ajax_apkup_clear_archive_cache', 'apkup_ajax_clear_archive_cache');

