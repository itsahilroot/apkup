<?php
require_once get_template_directory() . '/inc/gp-fetcher.php';

function apkup_get_datos_download($post_id = false)
{
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }

    $datos_download = get_post_meta($post_id, 'datos_download', true);

    if (!is_array($datos_download)) {
        return [];
    }

    if (!isset($datos_download['links_options']) || !is_array($datos_download['links_options'])) {
        $datos_download['links_options'] = [];
    }

    $datos_download['links_options'] = array_values(
        array_filter($datos_download['links_options'], 'array_multi_filter_download_empty')
    );

    return $datos_download;
}

add_action('add_meta_boxes', 'add_post_metaboxes', 1);
add_action('save_post', 'save_app_info');
add_action('save_post', 'save_download_links');
add_action('save_post', 'save_screenshots');
add_action('save_post', 'apkt_banner');

function add_post_metaboxes()
{
    add_meta_box('download-links', __('Download Links', 'apktemplates'), 'download_links_callback', 'post', 'normal', 'high');
    add_meta_box('app-info', __('App Information', 'apktemplates'), 'app_info_callback', 'post', 'normal', 'high');
    add_meta_box('screenshots', __('Screenshots', 'apktemplates'), 'screenshots_callback', 'post', 'normal', 'high');
    add_meta_box('banner', __('Banner Image', 'apktemplates'), 'apkt_banner_callback', 'post', 'side', 'high');
}

function app_info_callback($post)
{
    $post_id = $post->ID;
    $app_type = get_post_meta($post_id, 'app_type', true);
    $data = get_post_meta($post_id, 'datos_informacion', true);
    $new_rating_average = get_post_meta($post_id, 'new_rating_average', true) ?: 0;
    $new_rating_users = get_post_meta($post_id, 'new_rating_users', true) ?: 0;
    $datos_video = get_post_meta($post_id, 'datos_video', true);

    $gp_cats_list = apkt_au_get_gp_categories();

    wp_nonce_field('app_info_nonce', 'app_info_nonce');
?>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><label for="app_type"><?php esc_html_e('App Type', 'apktemplates'); ?></label></th>
                <td>
                    <select name="app_type" id="app_type">
                        <option value="0" <?php selected($app_type, 0); ?>><?php esc_html_e('Normal', 'apktemplates'); ?>
                        </option>
                        <option value="1" <?php selected($app_type, 1); ?>><?php esc_html_e('MOD', 'apktemplates'); ?>
                        </option>
                    </select>
                </td>
            </tr>
            <!-- <tr>
                <th scope="row"><label for="descripcion"><?php esc_html_e('Description', 'apktemplates'); ?></label></th>
                <td>
                    <textarea class="widefat" id="descripcion" name="datos_informacion[descripcion]"
                        rows="5"><?php echo apkup_get_appyn_datos_info('descripcion'); ?></textarea>
                </td>
            </tr> -->
            <?php
            $app_fields = [
                'version' => [__('Version', 'apktemplates'), 'E.g. 1.20.2'],
                'tamano' => [__('Size', 'apktemplates'), 'E.g. 50MB'],
                'requerimientos' => [__('Requirements', 'apktemplates'), 'E.g. 5.0'],
                'consiguelo' => [__('Store URL', 'apktemplates'), 'E.g. https://play.google.com/store/apps/details?id=jp.naver.line.android'],
                'descargas' => [__('Downloads', 'apktemplates'), 'E.g. 536454'],
                'mod_info' => [__('MOD Info', 'apktemplates'), 'E.g. Unlocked All'],
            ];
            foreach ($app_fields as $field_key => $field_data): ?>
                <tr>
                    <th scope="row"><label for="datos_informacion_<?= $field_key ?>"><?php echo $field_data[0]; ?></label></th>
                    <td><input type="text" id="datos_informacion_<?= $field_key ?>" name="datos_informacion[<?= $field_key ?>]"
                            value="<?= esc_attr($data[$field_key] ?? ''); ?>" class="regular-text"
                            placeholder="<?php echo $field_data[1]; ?>" /></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th scope="row">
                    <label for="datos_informacion_categoria_app">
                        <?php esc_html_e('App Category', 'apktemplates'); ?>
                    </label>
                </th>
                <td>
                    <select id="datos_informacion_categoria_app" name="datos_informacion[categoria_app]">
                        <?php foreach ($gp_cats_list as $key => $cat_name): ?>
                            <option value="<?php echo esc_attr($key); ?>"
                                <?php
                                if (!empty($data['categoria_app'])) {
                                    selected($data['categoria_app'], $key);
                                }
                                ?>>
                                <?php echo esc_html($cat_name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="datos_informacion_os_android">
                        <?php esc_html_e('Operating System', 'apktemplates'); ?>
                    </label>
                </th>
                <td>
                    <?php
                    $current_os = apkup_get_appyn_datos_info('os') ?: 'ANDROID';
                    ?>
                    <label for="datos_informacion_os_android"><input type="radio" id="datos_informacion_os_android"
                            name="datos_informacion[os]" value="ANDROID" <?php checked($current_os, 'ANDROID'); ?>>
                        Android</label> 
                    <label for="datos_informacion_os_ios"><input type="radio" id="datos_informacion_os_ios"
                            name="datos_informacion[os]" value="iOS" <?php checked($current_os, 'iOS'); ?>> iOS</label> 
                    <label for="datos_informacion_os_mac"><input type="radio" id="datos_informacion_os_mac"
                            name="datos_informacion[os]" value="MAC" <?php checked($current_os, 'MAC'); ?>> Mac</label> 
                    <label for="datos_informacion_os_windows"><input type="radio" id="datos_informacion_os_windows"
                            name="datos_informacion[os]" value="WINDOWS" <?php checked($current_os, 'WINDOWS'); ?>>
                        Windows</label> 
                    <label for="datos_informacion_os_linux"><input type="radio" id="datos_informacion_os_linux"
                            name="datos_informacion[os]" value="LINUX" <?php checked($current_os, 'LINUX'); ?>>
                        Linux</label>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="datos_informacion_offer_price_gratis">
                        <?php esc_html_e('Price', 'apktemplates'); ?>
                    </label>
                </th>
                <td>
                    <?php
                    $price = apkup_get_appyn_datos_info('offer', 'price') ?: 'gratis';
                    $amount = apkup_get_appyn_datos_info('offer', 'amount');
                    $currency = apkup_get_appyn_datos_info('offer', 'currency') ?: 'USD';
                    ?>
                    <label for="datos_informacion_offer_price_gratis">
                        <input type="radio" id="datos_informacion_offer_price_gratis" name="datos_informacion[offer][price]"
                            value="gratis" <?php checked($price, 'gratis'); ?>>
                        <?php esc_html_e('Free', 'apktemplates'); ?>
                    </label>
                    <label for="datos_informacion_offer_price_pago">
                        <input type="radio" id="datos_informacion_offer_price_pago" name="datos_informacion[offer][price]"
                            value="pago" <?php checked($price, 'pago'); ?>>
                        <?php esc_html_e('Paid', 'apktemplates'); ?>
                    </label> 
                    <label for="datos_informacion_offer_amount">
                        <?php esc_html_e('Amount', 'apktemplates'); ?>:
                        <input type="text" id="datos_informacion_offer_amount" name="datos_informacion[offer][amount]"
                            value="<?php echo esc_attr($amount); ?>" placeholder="1.00" style="width: 50px;">
                    </label> 
                    <label for="datos_informacion_offer_currency">
                        <?php esc_html_e('Currency', 'apktemplates'); ?>:
                        <select id="datos_informacion_offer_currency" name="datos_informacion[offer][currency]">
                            <?php
                            $currencies = gp_currencies() ?: 'USD';
                            foreach ($currencies as $cur) {
                                echo '<option value="' . esc_attr($cur) . '"' . selected($currency, $cur, false) . '>' . esc_html($cur) . '</option>';
                            }
                            ?>
                        </select>
                    </label>
                </td>
            </tr>
            <!-- <tr>
                <th scope="row"><label for="datos_video_id"><?php esc_html_e('Video ID', 'apktemplates'); ?></label></th>
                <td><input type="text" id="datos_video_id" name="datos_video[id]"
                        value="<?= esc_attr($datos_video['id'] ?? ''); ?>" class="regular-text"
                        placeholder="E.g. 5LFBTFpWYVI" />
                </td>
            </tr> -->
            <tr>
                <th scope="row">
                    <label for="new_rating_average"><?php esc_html_e('Average Rating', 'apktemplates'); ?></label>
                </th>
                <td>
                    <input type="range" id="new_rating_average" name="new_rating_average" step="0.1" min="1" max="5"
                        value="<?= esc_attr($new_rating_average); ?>" class="range-input" />
                    <span class="tooltip"><?= esc_html($new_rating_average); ?></span>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="new_rating_users"><?php esc_html_e('Total Users Rated', 'apktemplates'); ?></label>
                </th>
                <td>
                    <input type="text" id="new_rating_users" name="new_rating_users"
                        value="<?= esc_attr($new_rating_users); ?>" class="regular-text" placeholder="E.g. 123" />
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="whats_new"><?php esc_html_e("What's New", 'apktemplates'); ?></label></th>
                <td>
                    <?php
                    $novedades_content = apkup_get_appyn_datos_info('novedades');
                    if (!is_string($novedades_content)) {
                        $novedades_content = '';
                    }
                    apkup_wp_editor_fix(
                        $novedades_content,
                        'datos_informacion_novedades',
                        array(
                            'textarea_name' => 'datos_informacion[novedades]',
                            'textarea_rows' => 5,
                        )
                    );
                    ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="mod_info_1_title"><?php esc_html_e('MOD Info 1 Title', 'apktemplates'); ?></label>
                </th>
                <td>
                    <?php
                    $custom_boxes = get_post_meta($post_id, 'custom_boxes', true);

                    $mod_info_1_title = '';
                    if (is_array($custom_boxes) && isset($custom_boxes[0]['title'])) {
                        $mod_info_1_title = $custom_boxes[0]['title'];
                    }
                    ?>
                    <input type="text"
                        id="mod_info_1_title"
                        name="custom_boxes[0][title]"
                        value="<?php echo esc_attr($mod_info_1_title); ?>"
                        class="regular-text"
                        placeholder="E.g. Features of MOD" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="custom_boxes_0_content"><?php esc_html_e("MOD Info 1 Content", 'apktemplates'); ?></label>
                </th>
                <td>
                    <?php
                    $first_box_content = '';
                    if (is_array($custom_boxes) && isset($custom_boxes[0]['content'])) {
                        $first_box_content = $custom_boxes[0]['content'];
                    }
                    apkup_wp_editor_fix(
                        $first_box_content,
                        'custom_boxes_0_content',
                        array(
                            'textarea_name' => 'custom_boxes[0][content]',
                            'textarea_rows' => 5,
                            'tinymce'       => true,
                            'quicktags'     => true,
                        )
                    );
                    ?>
                </td>
            </tr>

        </tbody>
    </table>
<?php
}

function save_app_info($post_id)
{
    if (!isset($_POST['app_info_nonce']) || !wp_verify_nonce($_POST['app_info_nonce'], 'app_info_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    $allowed_post_types = ['post'];
    if (!in_array(get_post_type($post_id), $allowed_post_types)) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['app_type'])) {
        update_post_meta($post_id, 'app_type', sanitize_text_field($_POST['app_type']));
    }

    $datos_informacion = [];
    if (isset($_POST['datos_informacion'])) {
        foreach ($_POST['datos_informacion'] as $key => $value) {
            if ($key === 'offer' && is_array($value)) {
                $datos_informacion['offer'] = [
                    'price' => isset($value['price']) ? sanitize_text_field($value['price']) : 'gratis',
                    'amount' => isset($value['amount']) ? sanitize_text_field($value['amount']) : '',
                    'currency' => isset($value['currency']) ? sanitize_text_field($value['currency']) : 'USD',
                ];
            } elseif ($key === 'descripcion') {
                $datos_informacion['descripcion'] = wpautop($value);
            } elseif ($key === 'novedades') {
                $datos_informacion['novedades'] = wpautop($value);
            } else {
                $datos_informacion[$key] = sanitize_text_field($value);
            }
        }
        update_post_meta($post_id, 'datos_informacion', $datos_informacion);
    }

    // Save datos_video
    /* if (isset($_POST['datos_video'])) {
        update_post_meta($post_id, 'datos_video', ['id' => sanitize_text_field($_POST['datos_video']['id'])]);
    } */


    // Save custom_boxes
    if (isset($_POST['custom_boxes'])) {
        $custom_boxes = array();

        if (isset($_POST['custom_boxes'][0]['title'])) {
            $custom_boxes[0]['title'] = sanitize_text_field($_POST['custom_boxes'][0]['title']);
        }

        if (isset($_POST['custom_boxes'][0]['content'])) {
            $custom_boxes[0]['content'] = wp_kses_post($_POST['custom_boxes'][0]['content']);
        }

        update_post_meta($post_id, 'custom_boxes', $custom_boxes);
    }

    // Save ratings
    $new_rating_average = !empty($_POST['new_rating_average']) ? floatval($_POST['new_rating_average']) : 0;
    $new_rating_users = !empty($_POST['new_rating_users']) ? intval($_POST['new_rating_users']) : 0;
    update_post_meta($post_id, 'new_rating_average', $new_rating_average);
    update_post_meta($post_id, 'new_rating_users', $new_rating_users);
}

function download_links_callback($post)
{
    $datos_download = apkup_get_datos_download($post->ID);
    wp_nonce_field('download_links_nonce', 'download_links_nonce');

    // Normalize links: prefer links_options, but also check numeric keys (old format)
    $links = [];
    if (!empty($datos_download['links_options'])) {
        $links = $datos_download['links_options'];
    } else {
        foreach ($datos_download as $k => $v) {
            if (is_int($k) && is_array($v)) {
                $links[$k] = $v;
            }
        }
    }

    $list_count = count($links) ?: 1;
    ?>
    <div class="table-container">
        <table id="download-table" class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th></th>
                    <th><strong><?php _e('Type', 'apktemplates'); ?></strong></th>
                    <th><strong><?php _e('Link', 'apktemplates'); ?></strong></th>
                    <th><strong><?php _e('Link Original', 'apktemplates'); ?></strong></th>
                    <th><strong><?php _e('Shortlink', 'apktemplates'); ?></strong></th>
                    <th><strong><?php _e('Text', 'apktemplates'); ?></strong></th>
                    <th><strong><?php _e('Actions', 'apktemplates'); ?></strong></th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < $list_count; $i++): 
                    $field = $links[$i] ?? [];
                    $link = $field['link'] ?? '';
                    $link_original = $field['link_original'] ?? '';
                    $shortlink = $field['shortlink'] ?? '';
                    $texto = $field['texto'] ?? '';
                    $type = $field['type'] ?? 'apk';
                ?>
                <tr>
                    <td class="handle_icon"><span class="handle">☰</span></td>

                    <td><input type="text" class="widefat"
                        name="datos_download[links_options][<?php echo $i; ?>][type]"
                        value="<?php echo esc_attr($type); ?>" /></td>

                    <td><input type="text" class="widefat"
                        name="datos_download[links_options][<?php echo $i; ?>][link]"
                        value="<?php echo esc_url($link); ?>" /></td>

                    <td><input type="text" class="widefat"
                        name="datos_download[links_options][<?php echo $i; ?>][link_original]"
                        value="<?php echo esc_url($link_original); ?>" /></td>

                    <td><input type="text" class="widefat"
                        name="datos_download[links_options][<?php echo $i; ?>][shortlink]"
                        value="<?php echo esc_url($shortlink); ?>" /></td>

                    <td><input type="text" class="widefat"
                        name="datos_download[links_options][<?php echo $i; ?>][texto]"
                        value="<?php echo esc_attr($texto); ?>" /></td>

                    <td>
                        <button type="button"
                            class="remove-btn components-button is-destructive">
                            <?php _e('Remove', 'apktemplates'); ?>
                        </button>
                    </td>
                </tr>
                <?php endfor; ?>

                <!-- Empty row template for JS cloning -->
                <tr class="empty-d-row" style="display:none;">
                    <td class="handle_icon"><span class="handle">☰</span></td>
                    <td><input type="text" class="widefat" name="datos_download[links_options][__index__][type]" value="apk" /></td>
                    <td><input type="text" class="widefat" name="datos_download[links_options][__index__][link]" /></td>
                    <td><input type="text" class="widefat" name="datos_download[links_options][__index__][link_original]" /></td>
                    <td><input type="text" class="widefat" name="datos_download[links_options][__index__][shortlink]" /></td>
                    <td><input type="text" class="widefat" name="datos_download[links_options][__index__][texto]" /></td>
                    <td>
                        <button type="button"
                            class="remove-btn components-button is-destructive">
                            <?php _e('Remove', 'apktemplates'); ?>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <button type="button" id="add-row" class="add-btn components-button is-secondary"
        style="flex-grow: 1; justify-content: center; margin-top: 16px;">
        <?php _e('Add Link', 'apktemplates'); ?>
    </button>
    <?php
}

function save_download_links($post_id)
{
    if (
        !isset($_POST['download_links_nonce']) ||
        !wp_verify_nonce($_POST['download_links_nonce'], 'download_links_nonce')
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    $allowed_post_types = ['post'];
    if (!in_array(get_post_type($post_id), $allowed_post_types, true)) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $old_data = get_post_meta($post_id, 'datos_download', true);

    // 🔄 Migration: if old_data has numeric keys, convert them into links_options
    if (is_array($old_data)) {
        foreach ($old_data as $k => $v) {
            if (is_int($k) && is_array($v)) {
                $old_data['links_options'][] = $v;
                unset($old_data[$k]); // remove the numeric entry
            }
        }
    }

    $new_data = [
        'option'        => $old_data['option'] ?? 'links',
        'type'          => $old_data['type'] ?? 'apk',
        'links_options' => [],
    ];

    if (!empty($_POST['datos_download']['links_options'])) {
        foreach ($_POST['datos_download']['links_options'] as $link) {
            // Save only if at least one meaningful field is filled
            if (
                !empty($link['link']) ||
                !empty($link['link_original']) ||
                !empty($link['shortlink']) ||
                !empty($link['texto'])
            ) {
                $new_data['links_options'][] = [
                    'type'          => sanitize_text_field($link['type'] ?? 'apk'),
                    'link'          => esc_url_raw($link['link'] ?? ''),
                    'link_original' => esc_url_raw($link['link_original'] ?? ''),
                    'shortlink'     => esc_url_raw($link['shortlink'] ?? ''),
                    'texto'         => sanitize_text_field($link['texto'] ?? ''),
                ];
            }
        }

        $new_data['links_options'] = array_values($new_data['links_options']);
    }

    if (!empty($new_data['links_options'])) {
        update_post_meta($post_id, 'datos_download', $new_data);
    } elseif ($old_data) {
        delete_post_meta($post_id, 'datos_download');
    }
}

function screenshots_callback($post)
{
    $datos_imagenes = get_post_meta($post->ID, 'datos_imagenes', true);
    wp_nonce_field('screenshots_nonce', 'screenshots_nonce');
?>
    <table id="screenshots-table" class="form-table">
        <tbody>
            <?php if ($datos_imagenes):
                $counter = 1;
            ?>
                <?php foreach ($datos_imagenes as $url):
                    if (!empty($url)): ?>
                        <tr>
                            <td>
                                <input id="screenshot-url-<?php echo $counter; ?>" class="widefat" type="text" name="datos_imagenes[]"
                                    value="<?= esc_url($url); ?>" placeholder="Enter Image URL" />
                            </td>
                            <td>
                                <button type="button" id="screenshot-btn-<?php echo $counter; ?>"
                                    class="upload-screenshot-btn components-button is-secondary"
                                    data-target="screenshot-url-<?php echo $counter; ?>"
                                    style="justify-content: center;"><?php _e('Upload', 'apktemplates'); ?></button>
                                <button type="button"
                                    class="remove-screenshot-btn remove-btn components-button is-destructive"><?php _e('Remove', 'apktemplates'); ?></button>
                            </td>
                        </tr>
                <?php
                        $counter++;
                    endif;
                endforeach; ?>
            <?php else: ?>
                <tr>
                    <td>
                        <input id="screenshot-url-1" class="widefat" type="text" name="datos_imagenes[]" value=""
                            placeholder="Enter Image URL" />
                    </td>
                    <td>
                        <button type="button" id="screenshot-btn-1" class="upload-screenshot-btn components-button is-secondary"
                            data-target="screenshot-url-1"
                            style="justify-content: center;"><?php _e('Upload', 'apktemplates'); ?></button>
                        <button type="button"
                            class="remove-screenshot-btn remove-btn components-button is-destructive"><?php _e('Remove', 'apktemplates'); ?></button>
                    </td>
                </tr>
            <?php endif; ?>
            <tr class="empty-screenshot-row" style="display:none;">
                <td>
                    <input id="ss-url-<?php echo $counter; ?>" class="widefat" type="text" name="datos_imagenes[]" value=""
                        placeholder="Enter Image URL" />
                </td>
                <td>
                    <button type="button" id="screenshot-btn-<?php echo $counter; ?>"
                        class="upload-screenshot-btn components-button is-secondary"
                        data-target="ss-url-<?php echo $counter; ?>"><?php _e('Upload', 'apktemplates'); ?></button>
                    <button type="button"
                        class="remove-screenshot-btn remove-btn components-button is-destructive"><?php _e('Remove', 'apktemplates'); ?></button>
                </td>
            </tr>
        </tbody>
    </table>
    <button type="button" id="add-screenshot-btn" class="add-btn components-button is-secondary"
        style="justify-content: center; margin-top: 16px;"><?php _e('Add Screenshot', 'apktemplates'); ?></button>
<?php
}

function save_screenshots($post_id)
{
    if (!isset($_POST['screenshots_nonce']) || !wp_verify_nonce($_POST['screenshots_nonce'], 'screenshots_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    $allowed_post_types = ['post'];
    if (!in_array(get_post_type($post_id), $allowed_post_types)) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $datos_imagenes = get_post_meta($post_id, 'datos_imagenes', true);
    $new_data = [];

    if (isset($_POST['datos_imagenes'])) {
        foreach ($_POST['datos_imagenes'] as $url) {
            if (!empty($url)) {
                $new_data[] = esc_url($url);
            }
        }
    }

    if (!empty($new_data) && $new_data !== $datos_imagenes) {
        update_post_meta($post_id, 'datos_imagenes', $new_data);
    } elseif (empty($new_data) && $datos_imagenes) {
        delete_post_meta($post_id, 'datos_imagenes');
    }
}

function apkt_banner_callback($post) {
    global $content_width, $_wp_additional_image_sizes;

    // Get the value of the custom field 'wp_poster_GP' as the second featured image URL
    $second_image_url = get_post_meta($post->ID, 'wp_poster_GP', true);

    if (!empty($second_image_url)) {
        $content = '
        <div class="editor-post-featured-image__container">
            <button type="button" class="components-button editor-post-featured-image__preview" id="banner_background">
                <span class="components-responsive-wrapper">
                    <div>
                        <img src="' . esc_url($second_image_url) . '" alt="" class="components-responsive-wrapper__content" style="max-width: 100%; height: auto;">
                    </div>
                </span>
            </button>
			<input type="hidden" id="upload_banner_image" name="upload_banner_image" value="' . esc_attr($second_image_url) . '" />
            <div class="css-17gjz0w" style="margin-top: 16px;">
                <button id="add_banner" type="button" class="components-button is-secondary" style="flex-grow: 1; justify-content: center;height:20px;">Replace</button>
                <button id="remove_banner" type="button" class="components-button is-destructive" style="height:20px;">Remove</button>
            </div>
        </div>';
    } else {
        $content = '
        <div>
            <div class="editor-post-featured-image__container">
                <button id="banner_background" type="button" class="components-button editor-post-featured-image__preview">Set banner image</button>
            </div>
            <div class="css-17gjz0w" style="margin-top: 16px;">
                <button id="add_banner" type="button" class="components-button is-secondary" style="flex-grow: 1; justify-content: center;height:20px;">Add Banner</button>
				<button id="remove_banner" type="button" class="components-button is-destructive" style="display: none;height:20px;">Remove</button>
            </div>
            <input type="hidden" id="upload_banner_image" name="upload_banner_image" value="" />
        </div>';
    }

    echo $content;
}

function apkt_banner($post_id) {
    if (isset($_POST['upload_banner_image'])) {
        $second_image_url = sanitize_text_field($_POST['upload_banner_image']);
        update_post_meta($post_id, 'wp_poster_GP', $second_image_url);
    }
}