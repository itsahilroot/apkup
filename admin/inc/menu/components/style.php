<?php
$au_theme_color = get_theme_mod('au_theme_color', '#22c55e');
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
        </tbody>
    </table>
</div>
