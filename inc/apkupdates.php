<?php
add_action('init', function () {
    $dnau = appyn_options('disabled_notif_apps_update');

    if ($dnau)    wp_clear_scheduled_hook('appyn_send_apps');
});

if (! wp_next_scheduled('appyn_send_apps')) {

    wp_schedule_event(time(), 'hourly', 'appyn_send_apps');
}

add_action('appyn_send_apps', 'px_appyn_hook_send_apps');

function px_appyn_hook_send_apps()
{
    global $post;

    //if( apply_filters( 'px_appyn_filter_stop_send_apps', false ) ) return; 

    $psa = get_option('px_status_apikey', null);

    //if( ! isset($psa['status']) ) return;

    $query = new WP_Query(array('posts_per_page' => -1, 'post_parent' => 0, 'suppress_filters' => true, 'cache_results'  => false));

    if ($query->have_posts()) :

        $list_ids = array();

        while ($query->have_posts()) : $query->the_post();

            if ($post->ID == null) continue;

            $url = get_datos_info('consiguelo');

            if (empty($url)) continue;

            if (strpos($url, 'https://play.google.com/store/') === false) continue;

            if ($post->post_parent != 0) continue;

            //if( ! appyn_options( 'show_mod_apps_to_apps_to_update' ) )
            //if( appyn_gpm( $post->ID, 'app_type' ) == 1 ) continue;

            $re = '/(?<=[?&]id=)[^&]+/m';
            preg_match_all($re, $url, $matches, PREG_SET_ORDER, 0);
            $app_id = $matches[0][0];

            if (!in_array_r($app_id, $list_ids)) {
                $list_ids[] = array(
                    'id' => $app_id,
                    'post_id' => $post->ID,
                );
            }

        endwhile;

        if (count($list_ids) > 0) {
            $result = apply_filters('remote_post_check_apps', $list_ids);

            if (!empty($result)) {
                if (! is_array($result))
                    $e = json_decode($result, true);
                else
                    $e = $result;

                if ($e['status'] == 'success') {
                    update_option('trans_updated_apps', $e['results']);
                    px_process_list_apps();
                } elseif ($e['status'] == 'error') {
                    update_option('trans_updated_apps', $e['response']);
                }
            }
        }
    endif;
}

add_action('post_updated', 'px_process_apps_to_update', 10, 1);

function px_process_apps_to_update($post_id)
{

    if (get_post_type($post_id) == "post") {
        px_process_list_apps($post_id);
    }
}

function px_process_list_apps($post_id = null)
{

    $updated_apps = get_option('trans_updated_apps', null);

    if (! is_array($updated_apps)) {
        return;
    }

    if ($post_id) {

        foreach ($updated_apps as $key => $p) {

            if (!isset($p['version'])) continue;

            if ($p['post_id'] == $post_id) {

                $di = get_post_meta($post_id, 'datos_informacion', true);
                $fa = (isset($di['fecha_actualizacion'])) ? $di['fecha_actualizacion'] : 0;
                $dd = strtotime($fa);
                $last_update = (!empty($di['last_update'])) ? (isValidTimeStamp($di['last_update']) ? $di['last_update'] : strtotime($di['last_update'])) : $dd;
                $updated_apps[$key]['post_title'] = get_the_title($p['post_id']);

                $version = (isset($di['version'])) ? $di['version'] : '';
                if (strtotime(date('Y-m-d', $last_update) . "+1 day") >= strtotime(date('Y-m-d', strtotime($p['update']))) || $version == $p['version']) {
                    unset($updated_apps[$key]);
                }
            }
        }
    } else {

        foreach ($updated_apps as $key => $p) {

            if (!isset($p['version'])) continue;

            $di = get_post_meta($p['post_id'], 'datos_informacion', true);
            $fa = (isset($di['fecha_actualizacion'])) ? $di['fecha_actualizacion'] : 0;
            $dd = strtotime($fa);
            $last_update = (!empty($di['last_update'])) ? (isValidTimeStamp($di['last_update']) ? $di['last_update'] : strtotime($di['last_update'])) : $dd;
            $updated_apps[$key]['post_title'] = get_the_title($p['post_id']);

            $version = (isset($di['version'])) ? $di['version'] : '';
            if (strtotime(date('Y-m-d', $last_update) . "+1 day") >= strtotime(date('Y-m-d', strtotime($p['update']))) || $version == $p['version']) {
                unset($updated_apps[$key]);
            }
        }
    }

    update_option('trans_updated_apps', $updated_apps);
    set_transient('trans_count_updated_apps', count($updated_apps));
}

function appyn_options($option, $default = false)
{

    if (!empty(get_option('appyn_' . $option))) {
        return get_option('appyn_' . $option);
    } else {
        return ($default) ?  (is_bool($default) ? '' : $default) : '0';
    }
}

function px_count_update_apps($a = false)
{

    $results = get_option('trans_updated_apps', null);

    if (! $results || is_string($results)) return 0;

    $count = count($results);

    return ($a) ? (($count > 99) ? '99+' : $count) : $count;
}

function appyn_updated_apps()
{
?>
    <style>
        .table_list_apps form {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }

        .table_list_apps .post_title.column-post_title>div {
            display: flex !important;
        }

        .modapp {
            background: #20a400;
            color: #FFF;
            border-radius: 3px;
            font-weight: 500;
            font-size: 10px;
            display: inline-block;
            padding: 0px 5px;
            margin-left: 5px;
        }

        .table_list_apps .column-post_title>div>img {
            margin-right: 10px;
        }

        .table_list_apps a:focus {
            box-shadow: none !important;
        }

        .table_list_apps .column-post_title a:nth-last-of-type(1) {
            margin-left: 5px;
        }

        .table_list_apps .column-post_title span img {
            margin-right: 10px;
        }

        .table_list_apps .column-post_title {
            width: 600px;
        }

        .table_list_apps .column-version {
            width: 100px;
        }

        .table_list_apps .search-box {
            order: 1;
        }

        .table_list_apps .subsubsub {
            order: 2;
            float: none;
            text-align: left;
        }
    </style>
    <div id="apps_to_update" class="table_list_apps wrap">
        <h1><?php echo __('Apps to update', 'appyn'); ?></h1>
        <?php
        $apps_to_update = new List_Table_ATUL();
        $apps_to_update->prepare_items();
        ?>
        <form id="nds-user-list-form" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
            <?php
            $apps_to_update->search_box(__('Search', 'appyn'), 'nds-user-find');
            ?>
        </form>
        <?php $apps_to_update->display(); ?>
        <?php
        $time = wp_next_scheduled('appyn_send_apps');
        echo '<p>' . sprintf(__('This list is updated every hour. Next update: %s', 'appyn'), '<strong>' . get_date_from_gmt(date('Y-m-d H:i', $time), 'Y-m-d H:i') . '</strong>') . '</p>';
        ?>

    </div>
<?php
}

if (! wp_next_scheduled('appyn_check_apikey')) {
    wp_schedule_event(time(), 'daily', 'appyn_check_apikey');
}

add_action('appyn_check_apikey', 'px_appyn_hook_check_apikey');

function px_appyn_hook_check_apikey()
{
    $url = API_URL . "/check/apikey";

    $response = wp_remote_post($url, array(
        'method'      => 'POST',
        'timeout'     => 30,
        'blocking'    => true,
        'headers'     => array(
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Referer' => get_site_url(),
            'Cache-Control' => 'max-age=0',
            'Expect' => '',
        ),
        'body' => array(
            'apikey' => get_option('appyn_apikey', true),
            'website'    => get_site_url(),
        ),
    ));

    if (! is_wp_error($response)) {
        update_option('px_status_apikey', json_decode($response['body'], true));
    }
}

add_action('init', 'px_cron_init');

function px_cron_init()
{
    if (! get_option('run_first_time_cron_apikey')) {
        px_appyn_hook_check_apikey();
        update_option('run_first_time_cron_apikey', 1);
    }
    if (! get_option('run_first_time_cron')) {
        px_appyn_hook_send_apps();
        update_option('run_first_time_cron', 1);
    }
}

add_filter('remote_post_check_apps', 'func_remote_post_check_apps', 10, 1);

function func_remote_post_check_apps($list_ids)
{

    $url = API_URL . "/check/";

    $response = wp_remote_post($url, array(
        'method'      => 'POST',
        'timeout'     => 30,
        'blocking'    => true,
        'headers'     => array(
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Referer' => get_site_url(),
            'Cache-Control' => 'max-age=0',
            'Expect' => '',
        ),
        'body' => array(
            'apikey' => get_option('appyn_apikey', true),
            'website'    => get_site_url(),
            'apps' => $list_ids
        ),
    ));

    if (! is_wp_error($response)) {
        return $response['body'];
    }
}

function get_datos_info($key, $key_ = false, $post_id = false)
{
    if (! $post_id) {
        global $post;
        $post_id = $post->ID;
    }
    $di = get_post_meta($post_id, 'datos_informacion', true);

    if (!empty($di)) {
        $di = array_filter($di, 'array_multi_filter_download_empty');

        if ($key_)
            return (isset($di[$key][$key_])) ? $di[$key][$key_] : '';
        else
            return (isset($di[$key])) ? $di[$key] : '';
    }
}

function appyn_gpm($post_id, $key, $default = "")
{
    return (get_post_meta($post_id, $key, true)) ? get_post_meta($post_id, $key, true) : $default;
}

function in_array_r($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

// functions.php or your plugin file
add_action('wp_ajax_bulk_update_version', 'handle_bulk_update_version');

function handle_bulk_update_version()
{
    check_ajax_referer('apkup_nonce', 'nonce');

    if (!current_user_can('edit_posts')) {
        wp_send_json_error(['message' => 'No permission']);
    }

    $posts = isset($_POST['posts']) ? (array) $_POST['posts'] : [];
    $transient_key = 'trans_updated_apps';

    $transient_data = get_option($transient_key, []);

    if (empty($transient_data)) {
        wp_send_json_error(['message' => 'No transient data found']);
    }

    $updated = [];

    foreach ($posts as $item) {
        // Each item is now an array with post_id + gplay_url
        $post_id   = isset($item['post_id']) ? intval($item['post_id']) : 0;
        $gplay_url = isset($item['gplay_url']) ? esc_url_raw($item['gplay_url']) : '';

        if (!$post_id || !$gplay_url) {
            continue;
        }

        foreach ($transient_data as $package_name => $entry) {
            if ((int) $entry['post_id'] === $post_id) {
                $meta = get_post_meta($post_id, 'datos_informacion', true);
                if (!is_array($meta)) {
                    $meta = [];
                }

                // Use the gplay_url sent by JS
                $body = array(
                    'apikey'  => appyn_options('apikey', true),
                    'website' => get_site_url(),
                    'app'     => trim($gplay_url),
                );

                $url = API_URL . '/v2/gplay';

                $response = wp_remote_post($url, array(
                    'method'    => 'POST',
                    'timeout'   => 60,
                    'blocking'  => true,
                    'sslverify' => false,
                    'headers'   => array(
                        'Referer'       => get_site_url(),
                        'Cache-Control' => 'max-age=0',
                        'Expect'        => '',
                    ),
                    'body' => $body,
                ));

                if (!is_wp_error($response)) {
                    $bot = json_decode($response['body'], true);
                    $status = (isset($bot['status'])) ? $bot['status'] : false;

                    if ($status != 'error' && $status) {
                        $bot_info = $bot['app'];
                        $app_info = array();

                        $app_info['app_title'] = $bot_info['title'];
                        $app_info['app_icon'] = $bot_info['icon'];

                        $old_thumbnail_id = get_post_thumbnail_id($post_id);
                        if ($old_thumbnail_id) {
                            wp_delete_attachment($old_thumbnail_id, true);
                        }

                        if (!empty($app_info['app_icon'])) {
                            $attach_id = apkt_insert_remote_image_as_attachment(
                                $app_info['app_icon'],
                                'icon',
                                $app_info['app_title'],
                                $post_id
                            );

                            if ($attach_id) {
                                set_post_thumbnail($post_id, $attach_id);
                            }
                        }
                        // Save screenshots
                        $n = 0;
                        foreach ($bot_info['screenshots'] as $screenshot) {
                            if ($n < 5) {
                                $app_info['screenshots'][$n] = $screenshot;
                            }
                            $n++;
                        }
                        if (isset($app_info['screenshots'])) {
                            update_post_meta($post_id, 'datos_imagenes', $app_info['screenshots']);
                        }
                    }
                }

                // Update version info
                $meta['version'] = $entry['version'];
                update_post_meta($post_id, 'datos_informacion', $meta);
				wp_update_post(['ID' => $post_id]);
                unset($transient_data[$package_name]);

                $updated[] = [
                    'post_id' => $post_id,
                    'version' => $entry['version'],
                    'title'   => $entry['post_title'],
                    'gplay_url' => $gplay_url,
                ];

                sleep(2);
                break;
            }
        }
    }

    update_option($transient_key, $transient_data);

    wp_send_json_success([
        'updated'   => $updated,
        'remaining' => $transient_data
    ]);
}

function px_noimage($bg = false)
{
    $noimage = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKoAAACqBAMAAADPWMmxAAAAElBMVEXu7u7////09PT7+/v39/fx8fFOJAxSAAABPklEQVRo3u3YQW6DMBCFYYLjAzxM9iRK9tA2e2h6ACP1/mcpFDlQNVTQGdpEvO8Av62RDYKIiIiIiIiIiIj+THyY4TS1usEMjlVW/7+aTLourK60ai+v+lVbAGf1ao2G164WaOTKVYtWolyN0UqVq1u03F3u9enmXHeyqkW2wBkw32Zh2pSXVffhxPcU7lYRZtizx1Mkq8ZoeO1nlkHjrF2t0HBeuYpPedS5eJXq9ss732KnUq3RycOQM41qgY4LayQKVYsgD2uU8qpBkIaz6+TVGldlWCMXVwsMN1uh5bywGmMgs+jshFWDgcRc+7LqHkNVPwxRtcBtpaS6xQgnqW4w5iyoVhjj/BJVJItUkS1STRepIl+k6n5bfX/7SfYQ3zArqaaHCY738deB1XVXzfMMLxERERERERERET24D8nRkAcrLOazAAAAAElFTkSuQmCC";

    if ($bg) return $noimage;

    if (appyn_options('lazy_loading')) {
        return '<img data-src="' . $noimage . '" src="" width="150" height="150" alt="No image" class="lazyload">';
    } else {
        return '<img src="' . $noimage . '" width="150" height="150" alt="No image">';
    }
}


function isValidTimeStamp($timestamp)
{
    return ((string) (int) $timestamp === $timestamp)
        && ($timestamp <= PHP_INT_MAX)
        && ($timestamp >= ~PHP_INT_MAX);
}

function apkt_insert_remote_image_as_attachment($image_url, $name, $apk_name, $post_id = 0)
{
    $upload_dir = wp_upload_dir();
    if (!isset($upload_dir['path'], $upload_dir['url'])) {
        return null;
    }

    $scraper = new Scraper();
    $fetch_image = $scraper->scrape($image_url);

    if (!is_array($fetch_image) || $fetch_image['status'] !== 'success' || empty($fetch_image['data']['content'])) {
        return null;
    }

    $image_content = $fetch_image['data']['content'];

    $original_format = null;
    if (!empty($fetch_image['data']['headers']['content-type'])) {
        $mime = $fetch_image['data']['headers']['content-type'];
        $ext  = wp_check_filetype_from_ext($mime);
        if (!empty($ext['ext'])) {
            $original_format = $ext['ext'];
        }
    }

    $final_format = $original_format ?: 'jpg';

    $image_name      = sanitize_title_with_dashes(apktemplates_clean($apk_name));
    $unique_suffix   = substr(time() . mt_rand(1000, 9999), -8);
    $image_full_name = "{$image_name}-{$name}-{$unique_suffix}.{$final_format}";
    $image_path      = trailingslashit($upload_dir['path']) . $image_full_name;

    if (file_put_contents($image_path, $image_content) === false) {
        return null;
    }

    $file_type = wp_check_filetype(basename($image_full_name), null);
    if (empty($file_type['type'])) {
        @unlink($image_path);
        return null;
    }

    $image_attachment = [
        'post_mime_type' => $file_type['type'],
        'post_title'     => $image_name,
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $image_id = wp_insert_attachment($image_attachment, $image_path, $post_id);
    if (is_wp_error($image_id) || !$image_id) {
        @unlink($image_path);
        return null;
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    $image_data = wp_generate_attachment_metadata($image_id, $image_path);
    if (!is_wp_error($image_data) && !empty($image_data)) {
        wp_update_attachment_metadata($image_id, $image_data);
    }

    return $image_id;
}