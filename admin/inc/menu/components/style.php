<?php
$au_theme_color = get_theme_mod('au_theme_color', '#22c55e');
$au_star_rating_theme_color_swt = get_theme_mod('au_star_rating_theme_color_swt', true);
?>
<div class="at-field-section" data-section="style">
    <div class="at-form-header">
        <h2>Style Settings</h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Theme Color', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Set the primary color for buttons, links, and highlights.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" name="au_theme_color" value="<?php echo esc_attr($au_theme_color); ?>" class="color-picker" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Star Rating Color Style', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Choose color style for star ratings across all frontend components. Left: Gray color according to section, Right: Theme color.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 13px; font-weight: 500; color: #64748b;"><?php esc_html_e('Gray Color', 'apktemplates'); ?></span>
                        <label class="at-switch-btn" style="margin-bottom: 0;">
                            <input type="checkbox" name="au_star_rating_theme_color_swt" id="au_star_rating_theme_color_swt" <?php checked($au_star_rating_theme_color_swt, true); ?> />
                            <span class="at-switch"></span>
                        </label>
                        <span style="font-size: 13px; font-weight: 600; color: <?php echo esc_attr($au_theme_color); ?>;"><?php esc_html_e('Theme Color', 'apktemplates'); ?></span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
