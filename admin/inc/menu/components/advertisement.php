<?php
$home_top_ads_swt = get_theme_mod('home_top_ads_swt', false);
$home_top_ads = get_theme_mod('home_top_ads');
$home_botm_ads_swt = get_theme_mod('home_botm_ads_swt', false);
$home_botm_ads = get_theme_mod('home_botm_ads');
$single_top_ads_swt = get_theme_mod('single_top_ads_swt', false);
$single_top_ads = get_theme_mod('single_top_ads');
$single_botm_ads_swt = get_theme_mod('single_botm_ads_swt', false);
$single_botm_ads = get_theme_mod('single_botm_ads');
$archive_top_ads_swt = get_theme_mod('archive_top_ads_swt', false);
$archive_top_ads = get_theme_mod('archive_top_ads');
$archive_botm_ads_swt = get_theme_mod('archive_botm_ads_swt', false);
$archive_botm_ads = get_theme_mod('archive_botm_ads');
$download_top_ads_swt = get_theme_mod('download_top_ads_swt', false);
$download_top_ads = get_theme_mod('download_top_ads');
$download_botm_ads_swt = get_theme_mod('download_botm_ads_swt', false);
$download_botm_ads = get_theme_mod('download_botm_ads');
?>
<div class="at-field-section" data-section="advertisement">
    <div class="at-form-header">
        <h2>Advertisement</h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Home Top Ad', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add an ad code below the first section in Home.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="home_top_ads_swt" <?php checked($home_top_ads_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <textarea name="home_top_ads" class="at-textarea" spellcheck="false"
                            rows="7"><?php echo stripslashes($home_top_ads); ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Home Bottom Ad', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add an ad code below the category/tag posts and articles/news in Home.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="home_botm_ads_swt" <?php checked($home_botm_ads_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <textarea name="home_botm_ads" class="at-textarea" spellcheck="false"
                            rows="7"><?php echo stripslashes($home_botm_ads); ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Single Top Ad', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add an ad code above the content in post.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="single_top_ads_swt" <?php checked($single_top_ads_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <textarea name="single_top_ads" class="at-textarea" spellcheck="false"
                            rows="7"><?php echo stripslashes($single_top_ads); ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Single Bottom Ad', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add an ad code below the content in post.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="single_botm_ads_swt" <?php checked($single_botm_ads_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <textarea name="single_botm_ads" class="at-textarea" spellcheck="false"
                            rows="7"><?php echo stripslashes($single_botm_ads); ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Archive Top Ad [Categories, Tags, Articles and News]', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add an ad code above the posts in archive pages.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="archive_top_ads_swt" <?php checked($archive_top_ads_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <textarea name="archive_top_ads" class="at-textarea" spellcheck="false"
                            rows="7"><?php echo stripslashes($archive_top_ads); ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Archive Bottom Ad [Categories, Tags, Articles and News]', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add an ad code below the posts in archive pages.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="archive_botm_ads_swt" <?php checked($archive_botm_ads_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <textarea name="archive_botm_ads" class="at-textarea" spellcheck="false"
                            rows="7"><?php echo stripslashes($archive_botm_ads); ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Download Top Ad', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add an ad code above the download link in download pages.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="download_top_ads_swt" <?php checked($download_top_ads_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <textarea name="download_top_ads" class="at-textarea" spellcheck="false"
                            rows="7"><?php echo stripslashes($download_top_ads); ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Download Bottom Ad', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add an ad code below the download link in download pages.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="download_botm_ads_swt" <?php checked($download_botm_ads_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <textarea name="download_botm_ads" class="at-textarea" spellcheck="false"
                            rows="7"><?php echo stripslashes($download_botm_ads); ?></textarea>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>