<?php
$au_theme_color = get_theme_mod('au_theme_color', '#22c55e');
$au_font_family = get_theme_mod('au_font_family', 'Inter');
$au_base_font_size = get_theme_mod('au_base_font_size', '16px');
$au_base_font_weight = get_theme_mod('au_base_font_weight', '400');
$au_heading_font_family = get_theme_mod('au_heading_font_family', 'Inter');
$au_heading_size = get_theme_mod('au_heading_size', '1.875rem');
$au_heading_weight = get_theme_mod('au_heading_weight', '600');

$google_fonts = [
    'Inter' => 'Inter',
    'Roboto' => 'Roboto',
    'Open Sans' => 'Open Sans',
    'Lato' => 'Lato',
    'Poppins' => 'Poppins',
    'Montserrat' => 'Montserrat',
    'Oswald' => 'Oswald',
    'Raleway' => 'Raleway',
    'Nunito' => 'Nunito',
    'Playfair Display' => 'Playfair Display',
    'Ubuntu' => 'Ubuntu',
    'Merriweather' => 'Merriweather',
    'Outfit' => 'Outfit',
    'Quicksand' => 'Quicksand',
    'Work Sans' => 'Work Sans',
    'Fira Sans' => 'Fira Sans',
    'Rubik' => 'Rubik',
    'Karla' => 'Karla',
    'Lora' => 'Lora',
];
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
                        <?php esc_html_e('Body Font Family', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Select the primary body font from Google Fonts.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <select name="au_font_family" class="at-select">
                            <option value="">System Default</option>
                            <?php foreach ($google_fonts as $key => $font) : ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($au_font_family, $key); ?>><?php echo esc_html($font); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Base Body Font Size', 'apktemplates'); ?>
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
                        <?php esc_html_e('Base Body Font Weight', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Select the base font weight.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <select name="au_base_font_weight" class="at-select">
                            <option value="300" <?php selected($au_base_font_weight, '300'); ?>>Light (300)</option>
                            <option value="400" <?php selected($au_base_font_weight, '400'); ?>>Regular (400)</option>
                            <option value="500" <?php selected($au_base_font_weight, '500'); ?>>Medium (500)</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Heading Font Family', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Select the font family for section headings.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <select name="au_heading_font_family" class="at-select">
                            <option value="">System Default</option>
                            <?php foreach ($google_fonts as $key => $font) : ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($au_heading_font_family, $key); ?>><?php echo esc_html($font); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Heading Font Size', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Specify the font size applied to section headings. (e.g. 1.875rem, 30px)', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" name="au_heading_size" class="at-text-ipt" value="<?php echo esc_attr($au_heading_size); ?>" />
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
