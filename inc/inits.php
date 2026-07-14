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

    $gp_cats_list = apkt_au_get_gp_categories();
    wp_nonce_field('app_info_nonce', 'app_info_nonce');
    ?>
    <div class="apkt-app-info-container">
        <!-- Group 1: General Info -->
        <h3 class="apkt-info-section-title"><?php esc_html_e('General Info', 'apktemplates'); ?></h3>
        <div class="apkt-app-info-grid apkt-grid-3">
            <div class="apkt-info-field">
                <label class="apkt-info-label" for="app_type"><?php esc_html_e('App Type', 'apktemplates'); ?></label>
                <div class="apkt-info-input-wrapper">
                    <select name="app_type" id="app_type">
                        <option value="0" <?php selected($app_type, 0); ?>><?php esc_html_e('Normal', 'apktemplates'); ?></option>
                        <option value="1" <?php selected($app_type, 1); ?>><?php esc_html_e('MOD', 'apktemplates'); ?></option>
                    </select>
                </div>
            </div>

            <div class="apkt-info-field">
                <label class="apkt-info-label" for="datos_informacion_categoria_app"><?php esc_html_e('App Category', 'apktemplates'); ?></label>
                <div class="apkt-info-input-wrapper">
                    <select id="datos_informacion_categoria_app" name="datos_informacion[categoria_app]">
                        <?php foreach ($gp_cats_list as $key => $cat_name): ?>
                            <option value="<?php echo esc_attr($key); ?>" <?php if (!empty($data['categoria_app'])) { selected($data['categoria_app'], $key); } ?>>
                                <?php echo esc_html($cat_name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="apkt-info-field">
                <label class="apkt-info-label"><?php esc_html_e('Operating System', 'apktemplates'); ?></label>
                <div class="apkt-radio-group">
                    <?php $current_os = apkup_get_appyn_datos_info('os') ?: 'ANDROID'; ?>
                    <label for="datos_informacion_os_android"><input type="radio" id="datos_informacion_os_android" name="datos_informacion[os]" value="ANDROID" <?php checked($current_os, 'ANDROID'); ?>> Android</label>
                    <label for="datos_informacion_os_ios"><input type="radio" id="datos_informacion_os_ios" name="datos_informacion[os]" value="iOS" <?php checked($current_os, 'iOS'); ?>> iOS</label>
                    <label for="datos_informacion_os_mac"><input type="radio" id="datos_informacion_os_mac" name="datos_informacion[os]" value="MAC" <?php checked($current_os, 'MAC'); ?>> Mac</label>
                    <label for="datos_informacion_os_windows"><input type="radio" id="datos_informacion_os_windows" name="datos_informacion[os]" value="WINDOWS" <?php checked($current_os, 'WINDOWS'); ?>> Windows</label>
                    <label for="datos_informacion_os_linux"><input type="radio" id="datos_informacion_os_linux" name="datos_informacion[os]" value="LINUX" <?php checked($current_os, 'LINUX'); ?>> Linux</label>
                </div>
            </div>
        </div>

        <div class="apkt-info-field span-full" style="margin-top: 16px; margin-bottom: 24px;">
            <label class="apkt-info-label"><?php esc_html_e('Price & Offer', 'apktemplates'); ?></label>
            <div class="apkt-price-wrapper">
                <?php
                $price = apkup_get_appyn_datos_info('offer', 'price') ?: 'gratis';
                $amount = apkup_get_appyn_datos_info('offer', 'amount');
                $currency = apkup_get_appyn_datos_info('offer', 'currency') ?: 'USD';
                ?>
                <div class="apkt-radio-group" style="min-height: auto;">
                    <label for="datos_informacion_offer_price_gratis">
                        <input type="radio" id="datos_informacion_offer_price_gratis" name="datos_informacion[offer][price]" value="gratis" <?php checked($price, 'gratis'); ?>>
                        <?php esc_html_e('Free', 'apktemplates'); ?>
                    </label>
                    <label for="datos_informacion_offer_price_pago">
                        <input type="radio" id="datos_informacion_offer_price_pago" name="datos_informacion[offer][price]" value="pago" <?php checked($price, 'pago'); ?>>
                        <?php esc_html_e('Paid', 'apktemplates'); ?>
                    </label>
                </div>
                <div class="apkt-info-input-wrapper" style="display: inline-flex; align-items: center; gap: 6px;">
                    <span style="font-size: 13px; color: #666;"><?php esc_html_e('Amount', 'apktemplates'); ?>:</span>
                    <input type="text" id="datos_informacion_offer_amount" name="datos_informacion[offer][amount]" value="<?php echo esc_attr($amount); ?>" placeholder="1.00" style="width: 80px; height: 32px; border-radius: 6px; padding: 0 8px;">
                </div>
                <div class="apkt-info-input-wrapper" style="display: inline-flex; align-items: center; gap: 6px;">
                    <span style="font-size: 13px; color: #666;"><?php esc_html_e('Currency', 'apktemplates'); ?>:</span>
                    <select id="datos_informacion_offer_currency" name="datos_informacion[offer][currency]" style="width: 90px; height: 32px; border-radius: 6px; padding: 0 4px;">
                        <?php
                        $currencies = gp_currencies() ?: 'USD';
                        foreach ($currencies as $cur) {
                            echo '<option value="' . esc_attr($cur) . '"' . selected($currency, $cur, false) . '>' . esc_html($cur) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Group 2: Specs -->
        <h3 class="apkt-info-section-title"><?php esc_html_e('App Specifications', 'apktemplates'); ?></h3>
        <div class="apkt-app-info-grid apkt-grid-5" style="margin-bottom: 18px;">
            <?php
            $app_fields = [
                'version' => [__('Version', 'apktemplates'), 'E.g. 1.20.2'],
                'tamano' => [__('Size', 'apktemplates'), 'E.g. 50MB'],
                'requerimientos' => [__('Requirements', 'apktemplates'), 'E.g. 5.0'],
                'descargas' => [__('Downloads', 'apktemplates'), 'E.g. 536454'],
                'mod_info' => [__('MOD Info', 'apktemplates'), 'E.g. Unlocked All'],
            ];
            foreach ($app_fields as $field_key => $field_data): ?>
                <div class="apkt-info-field">
                    <label class="apkt-info-label" for="datos_informacion_<?= $field_key ?>"><?php echo $field_data[0]; ?></label>
                    <div class="apkt-info-input-wrapper">
                        <input type="text" id="datos_informacion_<?= $field_key ?>" name="datos_informacion[<?= $field_key ?>]" value="<?= esc_attr($data[$field_key] ?? ''); ?>" placeholder="<?php echo $field_data[1]; ?>" />
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="apkt-info-field span-full" style="margin-bottom: 24px;">
            <label class="apkt-info-label" for="datos_informacion_consiguelo"><?php esc_html_e('Store URL', 'apktemplates'); ?></label>
            <div class="apkt-info-input-wrapper">
                <input type="text" id="datos_informacion_consiguelo" name="datos_informacion[consiguelo]" value="<?= esc_attr($data['consiguelo'] ?? ''); ?>" placeholder="E.g. https://play.google.com/..." />
            </div>
        </div>

        <!-- Group 3: Rating Details -->
        <h3 class="apkt-info-section-title"><?php esc_html_e('Ratings', 'apktemplates'); ?></h3>
        <div class="apkt-app-info-grid">
            <div class="apkt-info-field">
                <label class="apkt-info-label" for="new_rating_average"><?php esc_html_e('Average Rating', 'apktemplates'); ?></label>
                <div class="apkt-info-input-wrapper" style="display: flex; align-items: center; gap: 10px; height: 38px;">
                    <input type="range" id="new_rating_average" name="new_rating_average" step="0.1" min="1" max="5" value="<?= esc_attr($new_rating_average); ?>" class="range-input" style="flex: 1;" />
                    <span class="tooltip" style="font-weight: bold; font-size: 14px; color: #444; min-width: 25px; text-align: right;"><?= esc_html($new_rating_average); ?></span>
                </div>
            </div>

            <div class="apkt-info-field">
                <label class="apkt-info-label" for="new_rating_users"><?php esc_html_e('Total Users Rated', 'apktemplates'); ?></label>
                <div class="apkt-info-input-wrapper">
                    <input type="text" id="new_rating_users" name="new_rating_users" value="<?= esc_attr($new_rating_users); ?>" placeholder="E.g. 123" />
                </div>
            </div>
        </div>

        <!-- Group 4: Rich Content -->
        <h3 class="apkt-info-section-title"><?php esc_html_e('Updates & Mod Info Details', 'apktemplates'); ?></h3>
        <div class="apkt-info-field span-full" style="margin-bottom: 16px;">
            <label class="apkt-info-label" for="whats_new" style="margin-bottom: 6px; display: block;"><?php esc_html_e("What's New", 'apktemplates'); ?></label>
            <div>
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
                        'textarea_rows' => 4,
                    )
                );
                ?>
            </div>
        </div>

        <div class="apkt-info-field span-full" style="margin-bottom: 16px;">
            <?php
            $custom_boxes = get_post_meta($post_id, 'custom_boxes', true);
            $mod_info_1_title = '';
            if (is_array($custom_boxes) && isset($custom_boxes[0]['title'])) {
                $mod_info_1_title = $custom_boxes[0]['title'];
            }
            ?>
            <label class="apkt-info-label" for="mod_info_1_title" style="margin-bottom: 6px; display: block;"><?php esc_html_e('MOD Info Box Title', 'apktemplates'); ?></label>
            <div class="apkt-info-input-wrapper">
                <input type="text" id="mod_info_1_title" name="custom_boxes[0][title]" value="<?php echo esc_attr($mod_info_1_title); ?>" placeholder="E.g. Features of MOD" />
            </div>
        </div>

        <div class="apkt-info-field span-full">
            <label class="apkt-info-label" style="margin-bottom: 6px; display: block;"><?php esc_html_e("MOD Info Box Content", 'apktemplates'); ?></label>
            <div>
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
                        'textarea_rows' => 6,
                        'tinymce'       => true,
                        'quicktags'     => true,
                    )
                );
                ?>
            </div>
        </div>
    </div>
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

    ?>
    <div class="apkt-meta-container" id="download-repeater">
        <div class="apkt-repeater-header">
            <?php _e('App Download Links', 'apktemplates'); ?>
        </div>
        <div id="download-items" class="ui-sortable">
            <?php if (!empty($links)) : ?>
                <?php foreach ($links as $dl) : 
                    $type = $dl['type'] ?? '';
                    $version = $dl['version'] ?? '';
                    $mod_info = $dl['mod_info'] ?? '';
                    $size = $dl['size'] ?? '';
                    $url = $dl['link'] ?? '';
                    $text = $dl['texto'] ?? '';
                ?>
                    <div class="apkt-repeater-item">
                        <div class="apkt-drag-handle">⋮⋮</div>
                        <input type="text" name="download_type[]" value="<?php echo esc_attr($type); ?>" class="apkt-field-input" placeholder="Type">
                        <input type="text" name="download_version[]" value="<?php echo esc_attr($version); ?>" class="apkt-field-input" placeholder="Version">
                        <input type="text" name="download_mod_info[]" value="<?php echo esc_attr($mod_info); ?>" class="apkt-field-input" placeholder="MOD Info">
                        <input type="text" name="download_size[]" value="<?php echo esc_attr($size); ?>" class="apkt-field-input" placeholder="Size">
                        <input type="url" name="download_url[]" value="<?php echo esc_url($url); ?>" class="apkt-field-input" placeholder="Download URL">
                        <input type="text" name="download_text[]" value="<?php echo esc_attr($text); ?>" class="apkt-field-input" placeholder="Text">
                        <button type="button" class="apkt-btn apkt-btn-danger remove-download-item">X</button>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="apkt-repeater-item">
                    <div class="apkt-drag-handle">⋮⋮</div>
                    <input type="text" name="download_type[]" value="" class="apkt-field-input" placeholder="Type">
                    <input type="text" name="download_version[]" value="" class="apkt-field-input" placeholder="Version">
                    <input type="text" name="download_mod_info[]" value="" class="apkt-field-input" placeholder="MOD Info">
                    <input type="text" name="download_size[]" value="" class="apkt-field-input" placeholder="Size">
                    <input type="url" name="download_url[]" value="" class="apkt-field-input" placeholder="Download URL">
                    <input type="text" name="download_text[]" value="" class="apkt-field-input" placeholder="Text">
                    <button type="button" class="apkt-btn apkt-btn-danger remove-download-item">X</button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Template row for JS cloning -->
        <div id="download-item-template" style="display:none;">
            <div class="apkt-repeater-item">
                <div class="apkt-drag-handle">⋮⋮</div>
                <input type="text" name="download_type[]" value="" class="apkt-field-input" placeholder="Type">
                <input type="text" name="download_version[]" value="" class="apkt-field-input" placeholder="Version">
                <input type="text" name="download_mod_info[]" value="" class="apkt-field-input" placeholder="MOD Info">
                <input type="text" name="download_size[]" value="" class="apkt-field-input" placeholder="Size">
                <input type="url" name="download_url[]" value="" class="apkt-field-input" placeholder="Download URL">
                <input type="text" name="download_text[]" value="" class="apkt-field-input" placeholder="Text">
                <button type="button" class="apkt-btn apkt-btn-danger remove-download-item">X</button>
            </div>
        </div>

        <button type="button" id="add-download-item" class="button button-secondary" style="margin-top: 12px; justify-content: center; display: inline-flex; align-items: center;">
            <?php _e('Add Link', 'apktemplates'); ?>
        </button>
    </div>
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

    $new_data = [
        'option'        => $old_data['option'] ?? 'links',
        'type'          => $old_data['type'] ?? '',
        'links_options' => [],
    ];

    if (!empty($_POST['download_url'])) {
        foreach ($_POST['download_url'] as $i => $url) {
            $type          = $_POST['download_type'][$i] ?? '';
            $version       = $_POST['download_version'][$i] ?? '';
            $mod_info      = $_POST['download_mod_info'][$i] ?? '';
            $size          = $_POST['download_size'][$i] ?? '';
            $text          = $_POST['download_text'][$i] ?? '';

            if (!empty($url) || !empty($version) || !empty($mod_info) || !empty($size) || !empty($text)) {
                $new_data['links_options'][] = [
                    'type'          => sanitize_text_field($type),
                    'link'          => esc_url_raw($url),
                    'link_original' => esc_url_raw($url), // Populate link_original with main URL for compatibility
                    'shortlink'     => '',
                    'texto'         => sanitize_text_field($text),
                    'version'       => sanitize_text_field($version),
                    'mod_info'      => sanitize_text_field($mod_info),
                    'size'          => sanitize_text_field($size),
                ];
            }
        }
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
    <div class="apkt-screenshots-container">
        <div id="screenshots-grid" class="apkt-screenshots-grid">
            <?php 
            $counter = 1;
            if (!empty($datos_imagenes)) :
                foreach ($datos_imagenes as $url) :
                    if (empty($url)) continue;
                    ?>
                    <div class="apkt-screenshot-card">
                        <div class="apkt-screenshot-preview">
                            <img src="<?php echo esc_url($url); ?>" alt="Screenshot" />
                            <div class="apkt-screenshot-placeholder" style="display: none;">
                                <span class="dashicons dashicons-format-image"></span>
                            </div>
                        </div>
                        <div class="apkt-screenshot-inputs">
                            <input type="text" id="screenshot-url-<?php echo $counter; ?>" name="datos_imagenes[]" value="<?php echo esc_url($url); ?>" class="screenshot-url-input apkt-field-input" placeholder="Image URL" />
                            <div class="apkt-screenshot-actions">
                                <button type="button" class="upload-screenshot-btn button button-secondary" data-target="screenshot-url-<?php echo $counter; ?>"><?php _e('Upload', 'apktemplates'); ?></button>
                                <button type="button" class="remove-screenshot-btn button button-link-destructive"><?php _e('Remove', 'apktemplates'); ?></button>
                            </div>
                        </div>
                    </div>
                    <?php 
                    $counter++;
                endforeach;
            endif;
            // If empty, render at least one blank slot
            if ($counter === 1) :
                ?>
                <div class="apkt-screenshot-card">
                    <div class="apkt-screenshot-preview">
                        <img src="" alt="Screenshot" style="display: none;" />
                        <div class="apkt-screenshot-placeholder">
                            <span class="dashicons dashicons-format-image"></span>
                        </div>
                    </div>
                    <div class="apkt-screenshot-inputs">
                        <input type="text" id="screenshot-url-1" name="datos_imagenes[]" value="" class="screenshot-url-input apkt-field-input" placeholder="Image URL" />
                        <div class="apkt-screenshot-actions">
                            <button type="button" class="upload-screenshot-btn button button-secondary" data-target="screenshot-url-1"><?php _e('Upload', 'apktemplates'); ?></button>
                            <button type="button" class="remove-screenshot-btn button button-link-destructive"><?php _e('Remove', 'apktemplates'); ?></button>
                        </div>
                    </div>
                </div>
                <?php 
                $counter++;
            endif;
            ?>
        </div>

        <!-- Template for clone -->
        <div id="screenshot-template" style="display: none;">
            <div class="apkt-screenshot-card">
                <div class="apkt-screenshot-preview">
                    <img src="" alt="Screenshot" style="display: none;" />
                    <div class="apkt-screenshot-placeholder">
                        <span class="dashicons dashicons-format-image"></span>
                    </div>
                </div>
                <div class="apkt-screenshot-inputs">
                    <input type="text" class="screenshot-url-input apkt-field-input" placeholder="Image URL" />
                    <div class="apkt-screenshot-actions">
                        <button type="button" class="upload-screenshot-btn button button-secondary"><?php _e('Upload', 'apktemplates'); ?></button>
                        <button type="button" class="remove-screenshot-btn button button-link-destructive"><?php _e('Remove', 'apktemplates'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" id="add-screenshot-btn" class="button button-secondary" style="margin-top: 16px; justify-content: center; display: inline-flex; align-items: center;">
            <?php _e('Add Screenshot', 'apktemplates'); ?>
        </button>
    </div>
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