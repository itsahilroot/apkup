<?php
$allow_url_fopen = ini_get('allow_url_fopen');
$max_execution_time = ini_get('max_execution_time');
$max_input_time = ini_get('max_input_time');
$memory_limit = ini_get('memory_limit');
$post_max_size = ini_get('post_max_size');
$upload_max_filesize = ini_get('upload_max_filesize');
?>
<div class="at-field-section" data-section="info">
    <div class="at-form-header">
        <h2>Info</h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <tr class="table-content">
                <td colspan="2">
                    <h3>Required Info</h3>
                    <div class="at-field-descr" style="opacity: 1">
                        Requirements are must need.
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>allow_url_fopen</h3>
                </td>
                <td>
                    <?php if ($allow_url_fopen == 1): ?>
                        <span class="at-badge at-badge-success">Enabled</span>
                    <?php else: ?>
                        <span class="at-badge at-badge-danger">Disabled</span>
                        <p class="at-field-hint">
                            Recommended: Enable
                        </p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>max_execution_time</h3>
                </td>
                <td>
                    <?php if ($max_execution_time >= 300): ?>
                        <span class="at-badge at-badge-success">
                            <?php echo $max_execution_time; ?>
                        </span>
                    <?php else: ?>
                        <span class="at-badge at-badge-danger at-mb-1">
                            <?php echo ($max_execution_time <= 0) ? 'No limit' : $max_execution_time; ?>
                        </span>
                        <p class="at-field-hint">
                            <strong>Recommended:</strong> <em>300 or Greater than 300</em>
                        </p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>max_input_time</h3>
                </td>
                <td>
                    <?php if ($max_input_time >= 300): ?>
                        <span class="at-badge at-badge-success">
                            <?php echo $max_input_time; ?>
                        </span>
                    <?php else: ?>
                        <span class="at-badge at-badge-danger at-mb-1">
                            <?php echo ($max_input_time <= 0) ? 'No limit' : $max_input_time; ?>
                        </span>
                        <p class="at-field-hint">
                            <strong>Recommended:</strong> <em>300 or Greater than 300</em>
                        </p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>memory_limit</h3>
                </td>
                <td>
                    <?php if (is_server_setting_valid($memory_limit, 4096)): ?>
                        <span class="at-badge at-badge-success">
                            <?php echo $memory_limit; ?>
                        </span>
                    <?php else: ?>
                        <span class="at-badge at-badge-danger at-mb-1">
                            <?php echo $memory_limit; ?>
                        </span>
                        <p class="at-field-hint">
                            <strong>Recommended:</strong> <em>4GB or Greater than 4GB</em>
                        </p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>post_max_size</h3>
                </td>
                <td>
                    <?php if (is_server_setting_valid($post_max_size, 4096)): ?>
                        <span class="at-badge at-badge-success">
                            <?php echo $post_max_size; ?>
                        </span>
                    <?php else: ?>
                        <span class="at-badge at-badge-danger at-mb-1">
                            <?php echo $post_max_size; ?>
                        </span>
                        <p class="at-field-hint">
                            <strong>Recommended:</strong> <em>4GB or Greater than 4GB</em>
                        </p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>upload_max_filesize</h3>
                </td>
                <td>
                    <?php if (is_server_setting_valid($upload_max_filesize, 4096)): ?>
                        <span class="at-badge at-badge-success">
                            <?php echo $upload_max_filesize; ?>
                        </span>
                    <?php else: ?>
                        <span class="at-badge at-badge-danger at-mb-1">
                            <?php echo $upload_max_filesize; ?>
                        </span>
                        <p class="at-field-hint">
                            <strong>Recommended:</strong> <em>4GB or Greater than 4GB</em>
                        </p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr class="table-content">
                <td colspan="2">
                    <h3>Theme Information</h3>
                    <div class="at-field-descr" style="opacity: 1">
                        Here is the information about currently installed our theme. Thank you for choosing APKTEMPLATES
                        :).
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Name</h3>
                </td>
                <td>
                    <span class="at-badge"><?php echo 'APKUP'; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Version</h3>
                </td>
                <td>
                    <span class="at-badge"><?php echo APKT_THEME_VERSION; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Publisher</h3>
                </td>
                <td>
                    <span class="at-badge"><?php echo 'APKTEMPLATES'; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Website</h3>
                </td>
                <td>
                    <a href="https://apktemplates.com" target="_blank" rel="nofollow, noindex, noreferrer"><span
                            class="at-badge"><?php echo 'Visit'; ?> <span
                                class="dashicons dashicons-admin-links"></span></span></a>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Descripción</h3>
                </td>
                <td>
                    <p style="opacity: 1;"><?php echo 'APKUP is customized WordPress theme for apps/games.'; ?></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>