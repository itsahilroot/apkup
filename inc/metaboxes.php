<?php
// Register Meta Box
function apkup_register_ad_metabox() {
    add_meta_box(
        'apkup_ad_settings',
        __('Ad Settings', 'apktemplates'),
        'apkup_ad_metabox_callback',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'apkup_register_ad_metabox');

// Meta Box Callback
function apkup_ad_metabox_callback($post) {
    wp_nonce_field('apkup_save_ad_data', 'apkup_ad_meta_nonce');
    $disable_ads = get_post_meta($post->ID, '_apkup_disable_ads', true);
    ?>
    <label for="apkup_disable_ads">
        <input type="checkbox" name="apkup_disable_ads" id="apkup_disable_ads" value="1" <?php checked($disable_ads, 1); ?> />
        <?php _e('Disable Ads on this post', 'apktemplates'); ?>
    </label>
    <br><br>
    <?php
    $hide_desktop = get_post_meta($post->ID, '_apkup_hide_desktop', true);
    ?>
    <label for="apkup_hide_desktop">
        <input type="checkbox" name="apkup_hide_desktop" id="apkup_hide_desktop" value="1" <?php checked($hide_desktop, 1); ?> />
        <?php _e('Hide from Desktop(DMCA)', 'apktemplates'); ?>
    </label>
    <br><br>
    <?php
    $package_id = get_post_meta($post->ID, 'wp_GP_ID', true);
    if (empty($package_id)) {
        $package_id = get_post_meta($post->ID, 'px_app_id', true);
    }
    ?>
    <label for="wp_GP_ID" style="display:block; margin-bottom:5px; font-weight:bold;">
        <?php _e('Package ID / App ID', 'apktemplates'); ?>
    </label>
    <input type="text" name="wp_GP_ID" id="wp_GP_ID" value="<?php echo esc_attr($package_id); ?>" class="widefat" />
    <?php
}

// Save Meta Box Data
function apkup_save_ad_meta($post_id) {
    if (!isset($_POST['apkup_ad_meta_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['apkup_ad_meta_nonce'], 'apkup_save_ad_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['apkup_disable_ads'])) {
        update_post_meta($post_id, '_apkup_disable_ads', 1);
    } else {
        delete_post_meta($post_id, '_apkup_disable_ads');
    }

    if (isset($_POST['apkup_hide_desktop'])) {
        update_post_meta($post_id, '_apkup_hide_desktop', 1);
    } else {
        delete_post_meta($post_id, '_apkup_hide_desktop');
    }

    if (isset($_POST['wp_GP_ID'])) {
        update_post_meta($post_id, 'wp_GP_ID', sanitize_text_field($_POST['wp_GP_ID']));
    }
}
add_action('save_post', 'apkup_save_ad_meta');
