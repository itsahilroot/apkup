<?php
$au_home_footer_info_swt = get_theme_mod('au_home_footer_info_swt', false);
$au_home_footer_info_title = get_theme_mod('au_home_footer_info_title', 'Las mejores aplicaciones y juegos de Android gratis 2026');
$au_home_footer_info_description = get_theme_mod('au_home_footer_info_description', 'APKGSTORE es la plataforma líder y más segura para descargar juegos modificados, versiones pro y aplicaciones totalmente liberadas de forma gratuita para tu dispositivo Android. Nos enfocamos en ofrecer velocidad, seguridad total con análisis de malware riguroso y actualizaciones constantes para que disfrutes de tus títulos favoritos como <span class="italic font-normal text-primary">Subway Surfers</span>, <span class="italic font-normal text-primary">Mortal Kombat</span>, y <span class="italic font-normal text-primary">DEAD TRIGGER 2</span> sin publicidad y con ventajas increíbles.');

$au_home_footer_tg_swt = get_theme_mod('au_home_footer_tg_swt', false);
$au_home_footer_tg_title = get_theme_mod('au_home_footer_tg_title', 'Join our Telegram');
$au_home_footer_tg_desc = get_theme_mod('au_home_footer_tg_desc', 'Get the latest updates and news directly on Telegram.');
$au_home_footer_tg_url = get_theme_mod('au_home_footer_tg_url', 'https://t.me/apkgamingstore');

$footer_copyright = get_theme_mod('footer_copyright', 'Copyright © 2025 APKTEMPLATES.');
$au_footer_code = get_theme_mod('au_footer_code');
?>
<div class="at-field-section" data-section="footer">
    <div class="at-form-header">
        <h2>Footer</h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <tr>
                <td>
                    <h3><?php esc_html_e('Footer Information', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize home footer information.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="au_home_footer_info_swt" value="1" <?php checked($au_home_footer_info_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Footer Info Title', 'apktemplates'); ?></p>
                        <input type="text" name="au_home_footer_info_title" class="at-text-ipt"
                            value="<?php echo esc_attr($au_home_footer_info_title); ?>" />
                    </div>
                    <div>
                        <p class="at-mini-title"><?php esc_html_e('Footer Info Description', 'apktemplates'); ?></p>
                        <textarea name="au_home_footer_info_description" class="at-textarea" spellcheck="false" rows="7" placeholder="E.g. Premium apps and games available on our site..."><?php echo stripslashes($au_home_footer_info_description); ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?php esc_html_e('Footer Telegram', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize home footer telegram box.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="au_home_footer_tg_swt" value="1" <?php checked($au_home_footer_tg_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Telegram title', 'apktemplates'); ?></p>
                        <input type="text" name="au_home_footer_tg_title" class="at-text-ipt"
                            value="<?php echo esc_attr($au_home_footer_tg_title); ?>" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Telegram Description', 'apktemplates'); ?></p>
                        <input type="text" name="au_home_footer_tg_desc" class="at-text-ipt"
                            value="<?php echo esc_attr($au_home_footer_tg_desc); ?>" />
                    </div>
                    <div>
                        <p class="at-mini-title"><?php esc_html_e('Telegram URL', 'apktemplates'); ?></p>
                        <input type="text" name="au_home_footer_tg_url" class="at-text-ipt"
                            value="<?php echo esc_attr($au_home_footer_tg_url); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Copyright Text', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('This text only appears in footer.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <input type="text" name="footer_copyright" class="at-text-ipt"
                            value="<?php echo stripcslashes($footer_copyright); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Footer Code', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add the footer code for your entire website. For instance, you can include Adsense, Google Analytics, Webmaster, Bing or any tracking codes you want. This code will appear above </body> tag.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <textarea name="au_footer_code" class="at-textarea" spellcheck="false"
                            rows="7"><?php echo stripcslashes($au_footer_code); ?></textarea>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>