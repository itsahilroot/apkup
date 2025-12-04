<div class="at-field-section" data-section="settings">
    <div class="at-form-header">
        <h2>Settings</h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <tr class="table-content">
                <td colspan="2">
                    <h3>Import Demo</h3>
                    <div class="at-field-descr" style="opacity: 1">
                        Here you can <code><strong>Import Demo</strong></code> posts.
                    </div>
                </td>
            </tr>
            <tr class="table-content">
                <td colspan="2">
                    <div style="display: flex; column-gap: 1rem;">
                        <a id="import-demo-btn" href="#!" class="at-btn at-btn-primary">
                            <span class="dashicons dashicons-download"></span>
                            <?php esc_html_e('Import Demo', 'apktemplates'); ?>
                        </a>
                    </div>
                </td>
            </tr>
            <tr id="import-demo-container" class="table-content" style="display: none">
                <td><label for="import-demo" class="import-settings-container">
                        <input type="file" name="import-demo" id="import-demo" class="at-upload-file-ipt"
                            accept=".json">
                    </label>
                </td>
            </tr>
            <tr class="table-content">
                <td colspan="2">
                    <h3>Import/Export Customization</h3>
                    <div class="at-field-descr" style="opacity: 1">
                        Here you can <code><strong>Import/Export</strong></code> theme panel
                        settings. With one
                        click to export your theme settings to save as backup.
                    </div>
                </td>
            </tr>
            <tr class="table-content">
                <td colspan="2">
                    <div style="display: flex; column-gap: 1rem;">
                        <a id="import-settings-btn" href="#!" class="at-btn at-btn-primary">
                            <span class="dashicons dashicons-download"></span>
                            <?php esc_html_e('Import Settings', 'apktemplates'); ?>
                        </a>
                        <a id="export-settings" href="#!" class="at-btn at-btn-success">
                            <span class="dashicons dashicons-upload"></span>
                            <?php esc_html_e('Export Settings', 'apktemplates'); ?>
                        </a>
                    </div>
                </td>
            </tr>
            <tr id="import-settings-container" class="table-content" style="display: none">
                <td><label for="import-settings" class="import-settings-container">
                        <input type="file" name="import-settings" id="import-settings" class="at-upload-file-ipt"
                            accept=".json">
                    </label>
                </td>
            </tr>
            <tr class="table-content">
                <td colspan="2">
                    <h3>Cache</h3>
                    <div class="at-field-descr" style="opacity: 1">
                        This theme all cache files are stored in
                        <code><strong>wp-content/uploads/apktemplates/cache</strong></code> folder.
                        So you can delete cache files from here or manually delete by following the
                        directory path. <br>
                        <br>
                        <code><strong>Note: </strong> You need to clear the cache or
                                                delete the cache folder inside files when you do not use the APK file
                                                importer. During the APK import process, don't clear the cache or delete
                                                folders; otherwise, you will get an import error.</code>
                    </div>
                </td>
            </tr>
            <tr class="table-content">
                <td colspan="2">
                    <div>
                        <a id="delete-cache" href="<?php echo $delete_folder_url; ?>" class="at-btn at-btn-danger">
                            <span class="dashicons dashicons-trash"></span>
                            <?php esc_html_e('Clear Cache'); ?>
                        </a>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>