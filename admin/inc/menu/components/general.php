<?php
$au_theme_color = get_theme_mod('au_theme_color', '#eb144c');
$au_header_logo = get_theme_mod('au_header_logo', get_template_directory_uri() . '/assets/img/logo.png');
$au_header_logo_dark = get_theme_mod('au_header_logo_dark', get_template_directory_uri() . '/assets/img/logo.png');
$appyn_apikey = get_option('appyn_apikey', '');
$au_games_menu_url = get_theme_mod('au_games_menu_url', '');
$au_apps_menu_url = get_theme_mod('au_apps_menu_url', '');
$au_ajax_search_swt = get_theme_mod('au_ajax_search_swt', false);
$au_head_code = get_theme_mod('au_head_code', '');
$site_pjax_swt = get_theme_mod('site_pjax_swt', '1');
$site_cache_swt = get_theme_mod('site_cache_swt', '1');
$site_cache_time = get_theme_mod('site_cache_time', '24');
?>
<div class="at-field-section active" data-section="general">
    <div class="at-form-header">
        <h2>General</h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <!--             <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Theme Color', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Set your favorite color to theme.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" name="au_theme_color" value="<?php echo esc_attr($au_theme_color); ?>"
                            class="color-picker" />
                    </div>
                </td>
            </tr> -->
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Logo (Light Mode)', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Header logo (light mode) for website. It\'s only appears on header/footer section.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <div class="at-img-upload">
                            <input type="text" name="au_header_logo" id="au_header_logo" class="at-text-ipt"
                                value="<?php echo esc_html($au_header_logo); ?>" />
                            <button type="button" class="at-upload-img-ipt" data-title="Header/Footer Logo" data-target="#au_header_logo"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg></button>
                        </div>
                    </div>
                    <p class="at-field-hint at-mb-2">
                        <?php esc_html_e('Required image size: width: 214px and height: 64px.', 'apktemplates'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Logo (Dark Mode)', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Header logo (Dark Mode) for website. It\'s only appears on header/footer section.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <div class="at-img-upload">
                            <input type="text" name="au_header_logo_dark" id="au_header_logo_dark" class="at-text-ipt"
                                value="<?php echo esc_html($au_header_logo_dark); ?>" />
                            <button type="button" class="at-upload-img-ipt" data-title="Header/Footer Logo" data-target="#au_header_logo_dark"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg></button>
                        </div>
                    </div>
                    <p class="at-field-hint at-mb-2">
                        <?php esc_html_e('Required image size: width: 214px and height: 64px.', 'apktemplates'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Appyn API Key', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add Appyn API key for APK Updates..', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" name="appyn_apikey" id="appyn_apikey" class="at-text-ipt"
                            value="<?php echo esc_html($appyn_apikey); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Games Menu URL (Mobile)', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add Games page url for bottom menu for mobile view.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" name="au_games_menu_url" id="au_games_menu_url" class="at-text-ipt"
                            value="<?php echo esc_html($au_games_menu_url); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Apps Menu URL (Mobile)', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add Games page url for bottom menu for mobile view.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" name="au_apps_menu_url" id="au_apps_menu_url" class="at-text-ipt"
                            value="<?php echo esc_html($au_apps_menu_url); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Head Code', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add the head code for your entire website. For instance, you can include Adsense, Google Analytics, Webmaster, Bing or any tracking codes you want. This code will appear above </head> tag.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <textarea name="au_head_code" class="at-textarea" spellcheck="false"
                            rows="7"><?php echo esc_textarea(trim(stripslashes($au_head_code))); ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('AJAX Search', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Enable or disable live search suggestions.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <label class="at-switch-btn">
                        <input type="checkbox" name="au_ajax_search_swt" id="au_ajax_search_swt" <?php checked($au_ajax_search_swt, true); ?> />
                        <span class="at-switch"></span>
                    </label>
                </td>
            </tr>
            <!-- Site Caching & Speed -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Site Caching & Speed', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Configure SPA page transitions (PJAX) and global page caching to make your site load like a rocket.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Enable SPA Page Transitions (PJAX)', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Make page loading feel instant ("like React") by swapping layout elements without doing full browser reloads.', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="site_pjax_swt" value="1" <?php checked($site_pjax_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Enable Server-side Page Cache', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Cache homepage and category pages as static-like transients for guest users.', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="site_cache_swt" value="1" <?php checked($site_cache_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Cache Expiration (Hours)', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('How many hours dynamic page cache will remain valid before rebuilding.', 'apktemplates'); ?></p>
                        <input type="number" name="site_cache_time" class="at-number-ipt" min="1" max="720" value="<?php echo esc_attr($site_cache_time); ?>" />
                    </div>
                    <div class="at-pt-2">
                        <button id="apkup-clear-cache-btn" type="button" class="add-button" style="background-color: #ef4444; border-color: #ef4444; margin-top: 10px;">
                            <?php esc_html_e('Clear Site Cache', 'apktemplates'); ?>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>