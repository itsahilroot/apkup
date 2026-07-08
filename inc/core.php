<?php
function apkup_set_post_views($postID) {
    // Don't count for admins/editors
    if (current_user_can('edit_posts')) {
        return;
    }

    // Detect bots via user agent
    if (!empty($_SERVER['HTTP_USER_AGENT'])) {
        $bot_agents = ['bot', 'crawl', 'spider', 'slurp'];
        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        foreach ($bot_agents as $bot) {
            if (strpos($ua, $bot) !== false) {
                return; // Skip bots
            }
        }
    }

    $count_key = 'px_views';
    $count = (int) get_post_meta($postID, $count_key, true);

    $count++;
    update_post_meta($postID, $count_key, $count);

    return $count;
}

function apkup_get_post_views($postID) {
    $count_key = 'px_views';
    $count = get_post_meta($postID, $count_key, true);

    if ($count === '' || $count === false) {
        $count = 0;
        update_post_meta($postID, $count_key, 0);
    }

    return (int) $count;
}

function apkt_au_get_gp_categories()
{

    $gp_categories = array(
        'GAMES' => __('Games', 'apktemplates'),
        'GAME_ACTION' => __('Action games', 'apktemplates'),
        'GAME_ADVENTURE' => __('Adventure games', 'apktemplates'),
        'GAME_RACING' => __('Racing games', 'apktemplates'),
        'GAME_CARD' => __('Card games', 'apktemplates'),
        'GAME_CASINO' => __('Casino games', 'apktemplates'),
        'GAME_EDUCATIONAL' => __('Educational games', 'apktemplates'),
        'GAME_STRATEGY' => __('Strategy games', 'apktemplates'),
        'GAME_SPORTS' => __('Sports games', 'apktemplates'),
        'GAME_BOARD' => __('Board games', 'apktemplates'),
        'GAME_WORD' => __('Word games', 'apktemplates'),
        'GAME_ROLE_PLAYING' => __('Role playing games', 'apktemplates'),
        'GAME_CASUAL' => __('Casual games', 'apktemplates'),
        'GAME_MUSIC' => __('Music games', 'apktemplates'),
        'GAME_TRIVIA' => __('Trivia games', 'apktemplates'),
        'GAME_PUZZLE' => __('Puzzle games', 'apktemplates'),
        'GAME_ARCADE' => __('Arcade games', 'apktemplates'),
        'GAME_SIMULATION' => __('Simulation games', 'apktemplates'),
        'VIDEO_PLAYERS' => __('Video Players & Editors', 'apktemplates'),
        'ANDROID_WEAR' => __('Watch apps', 'apktemplates'),
        'ART_AND_DESIGN' => __('Art & Design', 'apktemplates'),
        'AUTO_AND_VEHICLES' => __('Auto & Vehicles', 'apktemplates'),
        'BEAUTY' => __('Beauty', 'apktemplates'),
        'LIBRARIES_AND_DEMO' => __('Libraries & Demo', 'apktemplates'),
        'WATCH_FACE' => __('Watch faces', 'apktemplates'),
        'FOOD_AND_DRINK' => __('Food & Drink', 'apktemplates'),
        'SHOPPING' => __('Shopping', 'apktemplates'),
        'COMMUNICATION' => __('Communication', 'apktemplates'),
        'DATING' => __('Dating', 'apktemplates'),
        'COMICS' => __('Comics', 'apktemplates'),
        'SPORTS' => __('Sports', 'apktemplates'),
        'EDUCATION' => __('Educational', 'apktemplates'),
        'ENTERTAINMENT' => __('Entertainment', 'apktemplates'),
        'LIFESTYLE' => __('Lifestyle', 'apktemplates'),
        'EVENTS' => __('Events', 'apktemplates'),
        'FINANCE' => __('Finance', 'apktemplates'),
        'PHOTOGRAPHY' => __('Photography', 'apktemplates'),
        'TOOLS' => __('Utilities', 'apktemplates'),
        'HOUSE_AND_HOME' => __('House & Home', 'apktemplates'),
        'BOOKS_AND_REFERENCE' => __('Books & Reference', 'apktemplates'),
        'MAPS_AND_NAVIGATION' => __('Maps & Navigation', 'apktemplates'),
        'MEDICAL' => __('Medical', 'apktemplates'),
        'MUSIC_AND_AUDIO' => __('Music & Audio', 'apktemplates'),
        'BUSINESS' => __('Business', 'apktemplates'),
        'NEWS_AND_MAGAZINES' => __('News & Magazines', 'apktemplates'),
        'PERSONALIZATION' => __('Personalization', 'apktemplates'),
        'PRODUCTIVITY' => __('Productivity', 'apktemplates'),
        'HEALTH_AND_FITNESS' => __('Health & Fitness', 'apktemplates'),
        'PARENTING' => __('Parenting', 'apktemplates'),
        'SOCIAL' => __('Social Networking', 'apktemplates'),
        'WEATHER' => __('Time', 'apktemplates'),
        'TRAVEL_AND_LOCAL' => __('Travel', 'apktemplates'),
    );

    return $gp_categories;
}

function gp_currencies()
{
    $currencies = [
        'USD',
        'EUR',
        'AED',
        'AFN',
        'ALL',
        'AMD',
        'ANG',
        'AOA',
        'ARS',
        'AUD',
        'AWG',
        'AZN',
        'BAM',
        'BBD',
        'BDT',
        'BGN',
        'BHD',
        'BIF',
        'BMD',
        'BND',
        'BOB',
        'BRL',
        'BSD',
        'BTN',
        'BWP',
        'BYN',
        'BZD',
        'CAD',
        'CDF',
        'CHF',
        'CLP',
        'CNY',
        'COP',
        'CRC',
        'CUP',
        'CVE',
        'CZK',
        'DJF',
        'DKK',
        'DOP',
        'DZD',
        'EGP',
        'ERN',
        'ETB',
        'FJD',
        'FKP',
        'GBP',
        'GEL',
        'GGP',
        'GHS',
        'GIP',
        'GMD',
        'GNF',
        'GTQ',
        'GYD',
        'HKD',
        'HNL',
        'HRK',
        'HTG',
        'HUF',
        'IDR',
        'ILS',
        'IMP',
        'INR',
        'IQD',
        'IRR',
        'ISK',
        'JEP',
        'JMD',
        'JOD',
        'JPY',
        'KES',
        'KGS',
        'KHR',
        'KMF',
        'KPW',
        'KRW',
        'KWD',
        'KYD',
        'KZT',
        'LAK',
        'LBP',
        'LKR',
        'LRD',
        'LSL',
        'LYD',
        'MAD',
        'MDL',
        'MGA',
        'MKD',
        'MMK',
        'MNT',
        'MOP',
        'MRU',
        'MUR',
        'MVR',
        'MWK',
        'MXN',
        'MYR',
        'MZN',
        'NAD',
        'NGN',
        'NIO',
        'NOK',
        'NPR',
        'NZD',
        'OMR',
        'PEN',
        'PGK',
        'PHP',
        'PKR',
        'PLN',
        'PYG',
        'QAR',
        'RON',
        'RSD',
        'RUB',
        'RWF',
        'SAR',
        'SBD',
        'SCR',
        'SDG',
        'SEK',
        'SGD',
        'SHP',
        'SLL',
        'SOS',
        'SRD',
        'SSP',
        'STN',
        'SYP',
        'SZL',
        'THB',
        'TJS',
        'TMT',
        'TND',
        'TOP',
        'TRY',
        'TTD',
        'TWD',
        'TZS',
        'UAH',
        'UGX',
        'UYU',
        'UZS',
        'VES',
        'VND',
        'VUV',
        'WST',
        'XAF',
        'XCD',
        'XDR',
        'XOF',
        'XPF',
        'YER',
        'ZAR',
        'ZMW'
    ];
    return $currencies;
}

/**
 * Retrieves a specific value from the 'datos_informacion' post meta for a given post.
 *
 * This function fetches data stored in the 'datos_informacion' post meta field, which is expected
 * to be an array. It supports retrieving either a top-level key or a nested key within the meta data.
 * If no value is found, it returns a default value (e.g., 'ANDROID' for the 'os' key, or an empty string).
 * The function is used in contexts like post edit screens to populate fields such as operating system or category.
 *
 * @param string $key       The key to retrieve from the 'datos_informacion' post meta array.
 *                          For example, 'os' to get the operating system or 'categoria_app' for the app category.
 * @param string|false $key_ Optional. A nested key to retrieve a specific value from the $key array.
 *                          If provided, the function looks for $di[$key][$key_]. Default is false.
 * @param int|false $post_id Optional. The ID of the post to retrieve meta data for.
 *                          If false, the function uses the global $post->ID. Default is false.
 *
 * @return string The value associated with the specified key or nested key.
 *                Returns 'ANDROID' as a default for the 'os' key if no value is found.
 *                Returns an empty string for other keys if no value is found or if the post ID is invalid.
 */

function apkup_get_appyn_datos_info($key, $key_ = false, $post_id = false)
{
    if (!$post_id) {
        global $post;
        $post_id = isset($post->ID) ? $post->ID : 0;
    }

    if (!$post_id) {
        return '';
    }

    $di = get_post_meta($post_id, 'datos_informacion', true);

    if (empty($di) || !is_array($di)) {
        return '';
    }

    if (function_exists('array_multi_filter_download_empty')) {
        $di = array_filter($di, 'array_multi_filter_download_empty');
    }

    if ($key_) {
        return isset($di[$key][$key_]) ? $di[$key][$key_] : '';
    }

    return isset($di[$key]) ? $di[$key] : '';
}

function apkup_wp_editor_fix( $content, $editor_id, $settings = array() ){      
    ob_start();
    wp_editor($content, $editor_id, $settings);
    $out = ob_get_contents();
    $js = json_encode($out);
    $id_editor_ctn  = $editor_id.'-ctn';
    ob_clean(); ?>
    <div id="<?php echo $id_editor_ctn; ?>"></div>
    <script>
    setTimeout(function() {
		var id_ctn = '#<?php echo $id_editor_ctn; ?>';
		jQuery(id_ctn).append(<?php echo $js; ?>); 
		setTimeout(function() {
			jQuery('#<?php echo $editor_id; ?>-tmce').trigger('click');
			
		}, 500);
    }, 3000);
    </script>
    <?php
    $out = ob_get_contents();
    ob_end_clean();
    echo $out;
}

function apkt_is_category_or_tag($id)
{
    if (empty($id)) {
        return false;
    }

    $category = get_term($id, 'category');
    if ($category && !is_wp_error($category)) {
        return true;
    }

    $tag = get_term($id, 'post_tag');
    if ($tag && !is_wp_error($tag)) {
        return true;
    }

    return false;
}

/* Custom Icon Field for menu Appearance -> Menu */
add_action('wp_nav_menu_item_custom_fields', function ($item_id, $item) {
    $icon_class = get_post_meta($item_id, 'apkup_menu_icon_class', true);
    ?>
    <p class="description description-wide">
        <label for="edit-menu-item-icon-class-<?php echo $item_id; ?>">
            <?php _e('FontAwesome Icon Class (e.g., fa-solid fa-home)', 'apktemplates'); ?><br>
            <input type="text"
                   id="edit-menu-item-icon-class-<?php echo $item_id; ?>"
                   name="apkup-menu-icon-class[<?php echo $item_id; ?>]"
                   value="<?php echo esc_attr($icon_class); ?>"
                   class="widefat code"
                   placeholder="fa-solid fa-home" />
        </label>
    </p>
    <?php
}, 10, 2);

add_action('wp_update_nav_menu_item', function ($menu_id, $menu_item_db_id) {
    if (isset($_POST['apkup-menu-icon-class'][$menu_item_db_id])) {
        $sanitized = sanitize_text_field($_POST['apkup-menu-icon-class'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, 'apkup_menu_icon_class', $sanitized);
    } else {
        delete_post_meta($menu_item_db_id, 'apkup_menu_icon_class');
    }
}, 10, 2);

/* Get SVG Icon */
function apkt_get_svg_icon($icon = 'games')
{
    switch ($icon) {
        case 'home':
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
            </svg>';
        case 'games':
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
            <path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1z"/>
            <path d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.39c.655-.079 1.35-.117 2.043-.117.72 0 1.443.041 2.12.126a.5.5 0 0 1 .622-.399l1.932.518a.5.5 0 0 1 .306.729q.211.136.373.297c.408.408.78 1.05 1.095 1.772.32.733.599 1.591.805 2.466s.34 1.78.364 2.606c.024.816-.059 1.602-.328 2.21a1.42 1.42 0 0 1-1.445.83c-.636-.067-1.115-.394-1.513-.773-.245-.232-.496-.526-.739-.808-.126-.148-.25-.292-.368-.423-.728-.804-1.597-1.527-3.224-1.527s-2.496.723-3.224 1.527c-.119.131-.242.275-.368.423-.243.282-.494.575-.739.808-.398.38-.877.706-1.513.773a1.42 1.42 0 0 1-1.445-.83c-.27-.608-.352-1.395-.329-2.21.024-.826.16-1.73.365-2.606.206-.875.486-1.733.805-2.466.315-.722.687-1.364 1.094-1.772a2.3 2.3 0 0 1 .433-.335l-.028-.079zm2.036.412c-.877.185-1.469.443-1.733.708-.276.276-.587.783-.885 1.465a14 14 0 0 0-.748 2.295 12.4 12.4 0 0 0-.339 2.406c-.022.755.062 1.368.243 1.776a.42.42 0 0 0 .426.24c.327-.034.61-.199.929-.502.212-.202.4-.423.615-.674.133-.156.276-.323.44-.504C4.861 9.969 5.978 9.027 8 9.027s3.139.942 3.965 1.855c.164.181.307.348.44.504.214.251.403.472.615.674.318.303.601.468.929.503a.42.42 0 0 0 .426-.241c.18-.408.265-1.02.243-1.776a12.4 12.4 0 0 0-.339-2.406 14 14 0 0 0-.748-2.295c-.298-.682-.61-1.19-.885-1.465-.264-.265-.856-.523-1.733-.708-.85-.179-1.877-.27-2.913-.27s-2.063.091-2.913.27"/>
            </svg>';
        case 'apps':
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
            </svg>';
        case 'apps-alt':
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
            <path d="M4 2v2H2V2zm1 12v-2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1m0-5V7a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1m0-5V2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1m5 10v-2a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1m0-5V7a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1m0-5V2a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1M9 2v2H7V2zm5 0v2h-2V2zM4 7v2H2V7zm5 0v2H7V7zm5 0h-2v2h2zM4 12v2H2v-2zm5 0v2H7v-2zm5 0v2h-2v-2zM12 1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zm-1 6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm1 4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1z"/>
            </svg>';
        case 'news':
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
            <path d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5z"/>
            <path d="M2 3h10v2H2zm0 3h4v3H2zm0 4h4v1H2zm0 2h4v1H2zm5-6h2v1H7zm3 0h2v1h-2zM7 8h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2z"/>
            </svg>';
        case 'trophy':
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
            <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5q0 .807-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33 33 0 0 1 2.5.5m.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935m10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935M3.504 1q.01.775.056 1.469c.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.5.5 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667q.045-.694.056-1.469z"/>
            </svg>';
        case 'fire':
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
            <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16m0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15"/>
            </svg>';
        case 'thunder':
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
            <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09zM4.157 8.5H7a.5.5 0 0 1 .478.647L6.11 13.59l5.732-6.09H9a.5.5 0 0 1-.478-.647L9.89 2.41z"/>
            </svg>';
        case 'rss':
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
            <path d="M5.5 12a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-3-8.5a1 1 0 0 1 1-1c5.523 0 10 4.477 10 10a1 1 0 1 1-2 0 8 8 0 0 0-8-8 1 1 0 0 1-1-1m0 4a1 1 0 0 1 1-1 6 6 0 0 1 6 6 1 1 0 1 1-2 0 4 4 0 0 0-4-4 1 1 0 0 1-1-1"/>
            </svg>';
        default:
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
            <path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1z"/>
            <path d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.39c.655-.079 1.35-.117 2.043-.117.72 0 1.443.041 2.12.126a.5.5 0 0 1 .622-.399l1.932.518a.5.5 0 0 1 .306.729q.211.136.373.297c.408.408.78 1.05 1.095 1.772.32.733.599 1.591.805 2.466s.34 1.78.364 2.606c.024.816-.059 1.602-.328 2.21a1.42 1.42 0 0 1-1.445.83c-.636-.067-1.115-.394-1.513-.773-.245-.232-.496-.526-.739-.808-.126-.148-.25-.292-.368-.423-.728-.804-1.597-1.527-3.224-1.527s-2.496.723-3.224 1.527c-.119.131-.242.275-.368.423-.243.282-.494.575-.739.808-.398.38-.877.706-1.513.773a1.42 1.42 0 0 1-1.445-.83c-.27-.608-.352-1.395-.329-2.21.024-.826.16-1.73.365-2.606.206-.875.486-1.733.805-2.466.315-.722.687-1.364 1.094-1.772a2.3 2.3 0 0 1 .433-.335l-.028-.079zm2.036.412c-.877.185-1.469.443-1.733.708-.276.276-.587.783-.885 1.465a14 14 0 0 0-.748 2.295 12.4 12.4 0 0 0-.339 2.406c-.022.755.062 1.368.243 1.776a.42.42 0 0 0 .426.24c.327-.034.61-.199.929-.502.212-.202.4-.423.615-.674.133-.156.276-.323.44-.504C4.861 9.969 5.978 9.027 8 9.027s3.139.942 3.965 1.855c.164.181.307.348.44.504.214.251.403.472.615.674.318.303.601.468.929.503a.42.42 0 0 0 .426-.241c.18-.408.265-1.02.243-1.776a12.4 12.4 0 0 0-.339-2.406 14 14 0 0 0-.748-2.295c-.298-.682-.61-1.19-.885-1.465-.264-.265-.856-.523-1.733-.708-.85-.179-1.877-.27-2.913-.27s-2.063.091-2.913.27"/>
            </svg>';
    }
}

function apkup_add_category_icon_meta_box() {
    ?>
    <div class="form-field">
        <label for="category-icon">Icon</label>
        <input type="text" name="category-icon" id="category-icon" class="regular-text" value="" />
        <p>
            <input type="button" name="category-icon-upload-button" id="category-icon-upload-button" class="button-secondary" value="Upload Icon" />
        </p>
        <p id="category-icon-description">
            We recommend downloading category-related SVG icons from 
            <a href="https://www.svgrepo.com" target="_blank">SVG Repo</a> and editing with color 
            <code>#00bcd4</code>. Then upload the icon here.
        </p>
    </div>
    <?php
}
add_action('category_add_form_fields', 'apkup_add_category_icon_meta_box');

function apkup_edit_category_icon_meta_box($term) {
    $category_icon = get_term_meta($term->term_id, 'category_icon', true);
    ?>
    <tr class="form-field">
        <th scope="row"><label for="category-icon">Icon</label></th>
        <td>
            <input type="text" name="category-icon" id="category-icon" class="regular-text" value="<?php echo esc_attr($category_icon); ?>" />
            <p>
                <input type="button" name="category-icon-upload-button" id="category-icon-upload-button" class="button-secondary" value="Upload Icon" />
            </p>
            <p id="category-icon-description">
                We recommend downloading category-related SVG icons from 
                <a href="https://www.svgrepo.com" target="_blank">SVG Repo</a> and editing with color 
                <code>#00bcd4</code>. Then upload the icon here.
            </p>
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'apkup_edit_category_icon_meta_box');

function apkup_save_category_icon_meta($term_id) {
	if (!isset($_POST['category-icon'])) {
        return;
    }
        update_term_meta($term_id, 'category_icon', $_POST['category-icon']);
}
add_action('edited_category', 'apkup_save_category_icon_meta', 10, 2);
add_action('create_category', 'apkup_save_category_icon_meta', 10, 2);

function apkup_enqueue_category_icon_scripts($hook) {
    if ($hook === 'term.php' || $hook === 'edit-tags.php') {
        wp_enqueue_media();
        wp_enqueue_script('category-icon-upload', get_template_directory_uri() . '/assets/js/admin/admin.min.js', array('jquery'), '0.1');
    }
}
add_action('admin_enqueue_scripts', 'apkup_enqueue_category_icon_scripts');

/**
 * Get a single category name for a post.
 * Priority: parent category > first category found.
 * Falls back to "Uncategorized" if none found.
 *
 * @param int $post_id
 * @return string
 */
function apkup_get_primary_category_name( $post_id ) {
    $categories = get_the_category( $post_id );

    if ( empty( $categories ) || is_wp_error( $categories ) ) {
        return 'Uncategorized';
    }

    // Check for parent category first
    foreach ( $categories as $cat ) {
        if ( $cat->parent == 0 ) {
            return $cat->name;
        }
    }

    return $categories[0]->name ?: 'Uncategorized';
}

/**
 * Get trimmed description/excerpt for a post.
 *
 * @param int $post_id
 * @param int $word_limit
 * @return string
 */
function apkup_get_post_short_description( $post_id, $word_limit = 10 ) {
    // Get excerpt, or fall back to post content
    $post = get_post( $post_id );
    if ( ! $post ) {
        return '';
    }

    $text = $post->post_excerpt ? $post->post_excerpt : $post->post_content;

    // Strip shortcodes & tags
    $text = wp_strip_all_tags( strip_shortcodes( $text ) );

    // Trim to word limit
    return wp_trim_words( $text, $word_limit, '...' );
}

/**
 * Extract the first number (int or decimal) from a string.
 *
 * @param string $string
 * @return string|null
 */
function apkup_extract_number( $string ) {
    if(empty($string)) {
        return '';
    }
    if ( preg_match( '/\d+(?:\.\d+)?/', $string, $matches ) ) {
        return $matches[0]; // first match is number
    }
    return '';
}

function apkup_format_views_count($number) {
    if (!is_numeric($number)) {
        return '0';
    }

    $number = (float) $number;

    if ($number < 1000) {
        return (string) $number;
    } elseif ($number < 1000000) {
        return round($number / 1000, 1) . 'K';
    } elseif ($number < 1000000000) {
        return round($number / 1000000, 1) . 'M';
    } else {
        return round($number / 1000000000, 1) . 'B';
    }
}

function apkup_format_downloads($value) {
    $value = trim($value);
    if (empty($value)) {
        return '10M+';
    }

    // If it already contains format characters like K, M, B, etc., just return it
    if (preg_match('/[kmb]/i', $value)) {
        return $value;
    }

    // Check if there is a '+' symbol
    $has_plus = (strpos($value, '+') !== false) ? '+' : '';

    // Strip dots, commas, spaces
    $clean = str_replace([',', '.', ' '], '', $value);

    // Find the numeric prefix
    if (preg_match('/^\d+/', $clean, $matches)) {
        $num = (float) $matches[0];
        
        if ($num < 1000) {
            $formatted = $num;
        } elseif ($num < 1000000) {
            $div = $num / 1000;
            $formatted = ($div == (int)$div ? (int)$div : round($div, 1)) . 'K';
        } elseif ($num < 1000000000) {
            $div = $num / 1000000;
            $formatted = ($div == (int)$div ? (int)$div : round($div, 1)) . 'M';
        } else {
            $div = $num / 1000000000;
            $formatted = ($div == (int)$div ? (int)$div : round($div, 1)) . 'B';
        }
        
        return $formatted . $has_plus;
    }

    return $value;
}

/**
 * Get the primary category for a post:
 * - If only subcategories exist, pick the first subcategory.
 * - If multiple parents exist, pick the parent with most posts.
 * Returns array with 'name' and 'url'.
 */
function apkup_get_primary_post_category( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $categories = get_the_category( $post_id );
    if ( empty( $categories ) ) {
        return false;
    }

    $chosen = null;

    // Separate parent and child categories
    $parents = [];
    $children = [];

    foreach ( $categories as $cat ) {
        if ( $cat->parent == 0 ) {
            $parents[] = $cat;
        } else {
            $children[] = $cat;
        }
    }

    if ( ! empty( $children ) && empty( $parents ) ) {
        // Case 1: only subcategories
        $chosen = $children[0]; // pick first subcategory
    } elseif ( ! empty( $parents ) ) {
        // Case 2: multiple parent categories — choose one with max posts
        usort( $parents, function( $a, $b ) {
            return $b->count - $a->count;
        });
        $chosen = $parents[0];
    } else {
        // fallback: just take first
        $chosen = $categories[0];
    }

    if ( ! $chosen ) {
        return false;
    }

    return [
        'name' => $chosen->name,
        'url'  => get_category_link( $chosen->term_id ),
    ];
}

function apkup_download_page_endpoint(){
	add_rewrite_endpoint('download', EP_PERMALINK);
}
add_action('init', 'apkup_download_page_endpoint');

function apkup_download_page_template(){
	global $wp_query;

	if (isset($wp_query->query_vars['download'])) {
		$requested_url = $_SERVER['REQUEST_URI'];

		if (preg_match('/\/download\/(\d+)/', $requested_url, $matches)) {
			$download_id = $matches[1];
			$template_path = get_template_directory() . '/components/utils/download.php';
		} else if (strpos($requested_url, '/download') !== false) {
			$template_path = get_template_directory() . '/components/utils/download.php';
		}

		if (isset($template_path) && file_exists($template_path)) {
			global $custom_download_id;
			$custom_download_id = isset($download_id) ? $download_id : null;
			include $template_path;
			exit;
		}
	}
}
add_action('template_redirect', 'apkup_download_page_template');

/* Rewrite rules and redirect for /trending/ page */
function apkup_trending_page_rewrite_rules() {
    add_rewrite_rule('^trending/?$', 'index.php?trending=1', 'top');
    add_rewrite_rule('^trending/page/([0-9]+)/?$', 'index.php?trending=1&paged=$matches[1]', 'top');
    
    if (!get_option('apkup_trending_rewrite_flushed')) {
        flush_rewrite_rules(false);
        update_option('apkup_trending_rewrite_flushed', 1);
    }
}
add_action('init', 'apkup_trending_page_rewrite_rules');

function apkup_trending_page_query_vars($vars) {
    $vars[] = 'trending';
    return $vars;
}
add_filter('query_vars', 'apkup_trending_page_query_vars');

function apkup_trending_page_template_redirect() {
    if (get_query_var('trending')) {
        $template = get_template_directory() . '/page-trending.php';
        if (file_exists($template)) {
            include $template;
            exit;
        }
    }
}
add_action('template_redirect', 'apkup_trending_page_template_redirect');

/* Search result display only posts */
function apkup_modify_search_results($query) {
    if ($query->is_search && $query->is_main_query() && !is_admin()) {
        $query->set('post_type', 'post'); // for news also ['post', 'news']
    }
}
add_action('pre_get_posts', 'apkup_modify_search_results');

//Vegam in WP
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_null' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

add_filter('wp_resource_hints', function (array $urls, string $relation): array {
    if ($relation !== 'dns-prefetch') {
        return $urls;
    }
    $urls = array_filter($urls, function (string $url): bool {
        return strpos($url, 's.w.org') === false;
    });
    return $urls;
}, 10, 2);

remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_filter('wp_robots', 'wp_robots_max_image_preview_large');

/* add_filter('rank_math/json_ld', function ($data, $jsonld) {
    if (is_singular(['post', 'articles', 'blog'])) {
        return [];
    }

    return $data;
}, 99, 2);

add_filter('wpseo_json_ld_output', function ($output) {
    if (is_singular(['post', 'articles', 'blog'])) {
        $output = false;
    }

    return $output;
}, 99, 2); */

function apkup_head_code() {
    $head_code = get_theme_mod('au_head_code');
    if (!empty($head_code)) {
        echo $head_code;
    }
}
add_action('wp_head', 'apkup_head_code');

function apkup_footer_code() {
    $footer_code = get_theme_mod('au_footer_code');
    if (!empty($footer_code)) {
        echo $footer_code;
    }
}
add_action('wp_footer', 'apkup_footer_code');

function apkup_check_hide_desktop() {
    if (is_single()) {
        $post_id = get_the_ID();
        $hide_desktop = get_post_meta($post_id, '_apkup_hide_desktop', true);

        if ($hide_desktop && !wp_is_mobile()) {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
            nocache_headers();
            $template = get_query_template('404');
            if ($template) {
                include($template);
            }
            exit;
        }
    }
}
add_action('template_redirect', 'apkup_check_hide_desktop');

function apkup_dynamic_styles() {
    $au_theme_color = get_theme_mod('au_theme_color', '#22c55e');
    $au_star_rating_theme_color_swt = get_theme_mod('au_star_rating_theme_color_swt', true);

    $star_color = $au_star_rating_theme_color_swt ? 'var(--app-primary)' : '#94a3b8';
    $star_color_dark = $au_star_rating_theme_color_swt ? 'var(--app-primary)' : '#4b5563';

    echo "<style>
        :root {
            --app-primary: {$au_theme_color};
            --star-color: {$star_color};
        }
        .dark {
            --star-color: {$star_color_dark};
        }
        .text-amber-500, .text-amber-500 svg, .text-amber-500 svg path, .text-amber-500 path {
            color: var(--star-color) !important;
            fill: var(--star-color) !important;
        }
        .jq-ry-container .jq-ry-rated-group svg {
            fill: var(--star-color) !important;
        }
        /* Override primary colored star icons inside components */
        .apps-items svg.text-primary, 
        .recommended-items svg.text-primary,
        .trending-items svg.text-primary,
        .hero-items svg.text-primary,
        .download-items svg.text-primary,
        figure svg.text-primary {
            color: var(--star-color) !important;
            fill: var(--star-color) !important;
        }
        .star-icon, svg.star-rating, span.text-amber-500 {
            color: var(--star-color) !important;
            fill: var(--star-color) !important;
        }
        .text-primary { color: var(--app-primary) !important; }
        .bg-primary { background-color: var(--app-primary) !important; }
        .border-primary { border-color: var(--app-primary) !important; }
        .hover\:text-primary:hover { color: var(--app-primary) !important; }
        .hover\:bg-primary:hover { background-color: var(--app-primary) !important; }
        .hover\:border-primary:hover { border-color: var(--app-primary) !important; }
        .group:hover .group-hover\:text-primary { color: var(--app-primary) !important; }
        .bg-primary\/10, .bg-green-50 { background-color: color-mix(in srgb, var(--app-primary) 10%, transparent) !important; }
        .bg-primary\/20, .bg-green-100 { background-color: color-mix(in srgb, var(--app-primary) 20%, transparent) !important; }
        .border-primary\/20, .border-green-200 { border-color: color-mix(in srgb, var(--app-primary) 20%, transparent) !important; }
    </style>";
}
add_action('wp_head', 'apkup_dynamic_styles', 100);

/* Modify main archive queries based on custom panel settings */
function apkup_modify_archive_query($query) {
    if (($query->is_category() || $query->is_tag() || $query->is_tax()) && $query->is_main_query() && !is_admin()) {
        $posts_limit = get_theme_mod('archive_posts_limit', '12');
        $query->set('posts_per_page', intval($posts_limit));

        $sort = get_theme_mod('archive_sort', 'latest');
        switch ($sort) {
            case 'latest':
                $query->set('orderby', 'date');
                $query->set('order', 'DESC');
                break;
            case 'oldest':
                $query->set('orderby', 'date');
                $query->set('order', 'ASC');
                break;
            case 'popular':
                $query->set('orderby', 'meta_value_num');
                $query->set('meta_key', 'post_views_count');
                $query->set('order', 'DESC');
                break;
            case 'modified':
                $query->set('orderby', 'modified');
                $query->set('order', 'DESC');
                break;
            case 'a_to_z':
                $query->set('orderby', 'title');
                $query->set('order', 'ASC');
                break;
            case 'z_to_a':
                $query->set('orderby', 'title');
                $query->set('order', 'DESC');
                break;
            case 'random':
                $query->set('orderby', 'rand');
                break;
        }
    }
}
add_action('pre_get_posts', 'apkup_modify_archive_query');

/**
 * Clear all site cache transients (archives and home)
 */
function apkup_clear_all_transients() {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_apkup_arc_%' OR option_name LIKE '_transient_timeout_apkup_arc_%' OR option_name LIKE '_transient_apkup_home_%' OR option_name LIKE '_transient_timeout_apkup_home_%'");
}

// Hook into post save, delete, and cache cleanup to clear transients
add_action('save_post', 'apkup_clear_all_transients');
add_action('delete_post', 'apkup_clear_all_transients');
add_action('clean_post_cache', 'apkup_clear_all_transients');

// Hook into theme options updates to clear transients
add_action('update_option_theme_mods_apkup', 'apkup_clear_all_transients');