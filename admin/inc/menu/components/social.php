<?php
$facebook_url = get_theme_mod('facebook_url');
$twitter_url = get_theme_mod('twitter_url');
$youtube_url = get_theme_mod('youtube_url');
$telegram_url = get_theme_mod('telegram_url');
$tiktok_url = get_theme_mod('tiktok_url');
$pinterest_url = get_theme_mod('pinterest_url');
$whatsapp_url = get_theme_mod('whatsapp_url');
$instagram_url = get_theme_mod('instagram_url');
$github_url = get_theme_mod('github_url');
$linkedin_url = get_theme_mod('linkedin_url');
$skype_url = get_theme_mod('skype_url');
$tumblr_url = get_theme_mod('tumblr_url');
$twitch_url = get_theme_mod('twitch_url');
$vk_url = get_theme_mod('vk_url');
$reddit_url = get_theme_mod('reddit_url');
?>
<div class="at-field-section" data-section="social">
    <div class="at-form-header">
        <h2>Social</h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Social Platforms', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add URL of your social media platform profiles.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Facebook', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="facebook_url" class="at-text-ipt"
                            value="<?php echo esc_url($facebook_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Twitter', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="twitter_url" class="at-text-ipt"
                            value="<?php echo esc_url($twitter_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('YouTube', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="youtube_url" class="at-text-ipt"
                            value="<?php echo esc_url($youtube_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Telegram', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="telegram_url" class="at-text-ipt"
                            value="<?php echo esc_url($telegram_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('TikTok', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="tiktok_url" class="at-text-ipt"
                            value="<?php echo esc_url($tiktok_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Pinterest', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="pinterest_url" class="at-text-ipt"
                            value="<?php echo esc_url($pinterest_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('WhatsApp', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="whatsapp_url" class="at-text-ipt"
                            value="<?php echo esc_url($whatsapp_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Instagram', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="instagram_url" class="at-text-ipt"
                            value="<?php echo esc_url($instagram_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Github', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="github_url" class="at-text-ipt"
                            value="<?php echo esc_url($github_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('LinkedIn', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="linkedin_url" class="at-text-ipt"
                            value="<?php echo esc_url($linkedin_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Skype', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="skype_url" class="at-text-ipt"
                            value="<?php echo esc_url($skype_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Tumblr', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="tumblr_url" class="at-text-ipt"
                            value="<?php echo esc_url($tumblr_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Twitch', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="twitch_url" class="at-text-ipt"
                            value="<?php echo esc_url($twitch_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('VK', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="vk_url" class="at-text-ipt" value="<?php echo esc_url($vk_url); ?>" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Reddit', 'apktemplates'); ?>
                        </p>
                        <input type="text" name="reddit_url" class="at-text-ipt"
                            value="<?php echo esc_url($reddit_url); ?>" />
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>