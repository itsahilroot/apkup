<?php
$is_mod_title = at_options('is_mod_title');
$is_mod_feature_title = at_options('is_mod_feature_title');
$is_title_version = at_options('is_title_version');
?>
<div class="at-field-section" data-section="importer">
    <div class="at-form-header">
        <h2>APK Importer</h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('MOD APK Title', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        Habilitar para agregar texto 'MOD APK' al título de la publicación.
                    </div>
                </td>
                <td>
                    <div>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="is_mod_title" <?php checked($is_mod_title); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('MOD Feature in Title', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        Habilitar para agregar texto de función MOD al título de la publicación.
                    </div>
                </td>
                <td>
                    <div>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="is_mod_feature_title" <?php checked($is_mod_feature_title); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('App Version in Title', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        Habilitar para agregar la versión de la aplicación al título de la publicación.
                    </div>
                </td>
                <td>
                    <div>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="is_title_version" <?php checked($is_title_version); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>