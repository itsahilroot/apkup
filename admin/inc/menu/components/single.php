<?php
$au_single_help_guide_title = get_theme_mod('au_single_help_guide_title', 'How To Install?');
$au_single_help_guide = get_theme_mod('au_single_help_guide', []);

$au_single_ss_swt = get_theme_mod('au_single_ss_swt', false);
$au_single_ss_limit = get_theme_mod('au_single_ss_limit', '5');
$au_single_related_swt = get_theme_mod('au_single_related_swt', false);
$au_single_related_limit = get_theme_mod('au_single_related_limit', 6);
$au_single_developer_swt = get_theme_mod('au_single_developer_swt', '1');
?>
<div class="at-field-section" data-section="single">
    <div class="at-form-header">
        <h2>Single</h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <tr>
                <td>
                    <h3><?php esc_html_e('Help Guide', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize single post help information.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Guide Title', 'apktemplates'); ?></p>
                        <input type="text" name="au_single_help_guide_title" class="at-text-ipt" value="<?php echo esc_attr($au_single_help_guide_title); ?>" placeholder="E.g. How To Install?" />
                    </div>
                    <div id="at-single-help-guide" class="at-mb-2 <?php echo !empty($au_single_help_guide) ? 'active' : ''; ?>" <?php echo !empty($au_single_help_guide) ? 'style="display: block"' : 'style="display: none"'; ?>>
                        <?php foreach ($au_single_help_guide as $index => $help_guide): ?>
                            <div class="at-coll-container" data-index="<?php echo esc_attr($index); ?>">
                                <div class="at-coll-header">
                                    <div class="at-coll-title">
                                        <?php echo esc_html__('Help Text', 'apktemplates') . ' ' . ($index + 1); ?>
                                    </div>
                                    <div class="at-coll-action">
                                        <span class="at-action-move" aria-label="<?php esc_attr_e('Move section', 'apktemplates'); ?>">
                                            <i class="fa fa-bars"></i>
                                        </span>
                                        <a href="javascript:void(0);" class="remove-at-coll delete"
                                            aria-label="<?php esc_attr_e('Remove', 'apktemplates'); ?>">
                                            <?php esc_html_e('Remove', 'apktemplates'); ?>
                                        </a>
                                        <a href="javascript:void(0);" class="edit-at-coll edit"
                                            aria-label="<?php esc_attr_e('Edit', 'apktemplates'); ?>">
                                            <?php esc_html_e('Edit', 'apktemplates'); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="at-coll-body" style="display: none" aria-expanded="false">
                                    <div>
                                        <p class="at-mini-title"><?php esc_html_e('Help text', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Add text for help section.', 'apktemplates'); ?></p>
                                        <input type="text" name="au_single_help_guide[<?php echo esc_attr($index); ?>][text]"
                                            class="at-text-ipt" value="<?php echo esc_attr($help_guide['text']); ?>"
                                            data-field-key="text" />
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button id="add-new-help-text" type="button" class="add-button">
                        <?php esc_html_e('Add Help text', 'apktemplates'); ?>
                    </button>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?php esc_html_e('Screenshots', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Show/Hide screenshots section and set the limit of screenshots visible on post.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="au_single_ss_swt" <?php checked($au_single_ss_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Screenshots Limit', 'apktemplates'); ?>
                        </p>
                        <input type="number" name="au_single_ss_limit" class="at-number-ipt" min="1" max="50"
                            value="<?php echo esc_html($au_single_ss_limit); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?php esc_html_e('Related Posts', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Show/Hide related posts section and set the limit of related posts visible on post.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="au_single_related_swt" <?php checked($au_single_related_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <p class="at-mini-title at-mb-1">
                            <?php esc_html_e('Related Posts Limit', 'apktemplates'); ?>
                        </p>
                        <input type="number" name="au_single_related_limit" class="at-number-ipt" min="1" max="50" value="<?php echo esc_html($au_single_related_limit); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?php esc_html_e('Developer Name', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Show/Hide developer name link on the single post page.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="au_single_developer_swt" value="1" <?php checked($au_single_developer_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>