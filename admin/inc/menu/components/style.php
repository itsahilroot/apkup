<?php
$au_theme_color = get_theme_mod('au_theme_color', '#22c55e');
$au_font_family = get_theme_mod('au_font_family', 'Inter, sans-serif');
$au_base_font_size = get_theme_mod('au_base_font_size', '16px');
$au_heading_weight = get_theme_mod('au_heading_weight', '600');
?>
<div class="at-field-section" data-section="style">
    <div class="at-form-header">
        <h2>Typography & Style</h2>
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
                        <?php esc_html_e('Font Family', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Specify the primary font family for the site. (e.g. "Inter", sans-serif)', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" name="au_font_family" class="at-text-ipt" value="<?php echo esc_attr($au_font_family); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Base Font Size', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Base font size for the body. (e.g. 16px, 1rem)', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" name="au_base_font_size" class="at-text-ipt" value="<?php echo esc_attr($au_base_font_size); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Heading Font Weight', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Select the font weight to be applied to all section headings.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <select name="au_heading_weight" class="at-select">
                            <option value="400" <?php selected($au_heading_weight, '400'); ?>>Regular (400)</option>
                            <option value="500" <?php selected($au_heading_weight, '500'); ?>>Medium (500)</option>
                            <option value="600" <?php selected($au_heading_weight, '600'); ?>>Semi-Bold (600)</option>
                            <option value="700" <?php selected($au_heading_weight, '700'); ?>>Bold (700)</option>
                            <option value="800" <?php selected($au_heading_weight, '800'); ?>>Extra Bold (800)</option>
                            <option value="900" <?php selected($au_heading_weight, '900'); ?>>Black (900)</option>
                        </select>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
