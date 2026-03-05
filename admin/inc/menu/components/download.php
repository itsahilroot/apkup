<?php
$au_dl_timer = get_theme_mod('au_dl_timer', '5');
$au_dl_related_swt = get_theme_mod('au_dl_related_swt', false);
$au_dl_related_limit = get_theme_mod('au_dl_related_limit', '5');

$au_download_faqs = get_theme_mod('au_download_faqs', []);
?>
<div class="at-field-section" data-section="download">
    <div class="at-form-header">
        <h2>Descargar</h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <tr>
                <td>
                    <h3><?php esc_html_e('Download Timer', 'apktemplates'); ?></h3>
                    <div class="at-field-descr"><?php esc_html_e('Set download timer.', 'apktemplates'); ?></div>
                </td>
                <td>
                    <div>
                        <p class="at-mini-title at-mb-1"><?php esc_html_e('Timer', 'apktemplates'); ?></p>
                        <input type="number" name="au_dl_timer" class="at-number-ipt" min="1" max="50"
                            value="<?php echo esc_html($au_dl_timer); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?php esc_html_e('App Banner', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Show/Hide the app banner on the download page if the post has a banner set.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <label class="at-switch-btn">
                            <?php $au_dl_banner_swt = get_theme_mod('au_dl_banner_swt', false); ?>
                            <input type="checkbox" name="au_dl_banner_swt" <?php checked($au_dl_banner_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                </td>
            </tr>
<!--             <tr>
                <td>
                    <h3><?php esc_html_e('Related Posts', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Show/Hide and set the limit of related posts on the download page.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="au_dl_related_swt" <?php checked($au_dl_related_swt, 1); ?>>
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <p class="at-mini-title at-mb-1"><?php esc_html_e('Related Posts Limit', 'apktemplates'); ?></p>
                        <input type="number" name="au_dl_related_limit" class="at-number-ipt" min="1" max="50"
                            value="<?php echo esc_html($au_dl_related_limit); ?>" />
                    </div>
                </td>
            </tr> -->
            <tr>
                <td>
                    <h3><?php esc_html_e('FAQs', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize download page faqs.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div id="at-download-faqs" class="at-mb-2 <?php echo !empty($au_download_faqs) ? 'active' : ''; ?>" <?php echo !empty($au_download_faqs) ? 'style="display: block"' : 'style="display: none"'; ?>>
                        <?php foreach ($au_download_faqs as $index => $faq): ?>
                            <div class="at-coll-container" data-index="<?php echo esc_attr($index); ?>">
                                <div class="at-coll-header">
                                    <div class="at-coll-title">
                                        <?php echo esc_html__('FAQ', 'apktemplates') . ' ' . ($index + 1); ?>
                                    </div>
                                    <div class="at-coll-action">
                                        <span class="at-action-move" aria-label="<?php esc_attr_e('Move section', 'apktemplates'); ?>">
                                            <i class="fa fa-bars"></i>
                                        </span>
                                        <a href="javascript:void(0);" class="remove-at-coll delete"
                                            aria-label="<?php esc_attr_e('Remove Section', 'apktemplates'); ?>">
                                            <?php esc_html_e('Remove', 'apktemplates'); ?>
                                        </a>
                                        <a href="javascript:void(0);" class="edit-at-coll edit"
                                            aria-label="<?php esc_attr_e('Edit Section', 'apktemplates'); ?>">
                                            <?php esc_html_e('Edit', 'apktemplates'); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="at-coll-body" style="display: none" aria-expanded="false">
                                    <div class="at-mb-2">
                                        <p class="at-mini-title"><?php esc_html_e('Question', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Add text for question.', 'apktemplates'); ?></p>
                                        <input type="text" name="au_download_faqs[<?php echo esc_attr($index); ?>][question]" class="at-text-ipt" value="<?php echo esc_attr($faq['question']); ?>"
                                            data-field-key="text" />
                                    </div>
                                    <div>
                                        <p class="at-mini-title"><?php esc_html_e('Answer', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Add text for answer.', 'apktemplates'); ?></p>
                                        <textarea name="au_download_faqs[<?php echo esc_attr($index); ?>][answer]" class="at-textarea" spellcheck="false" rows="7" data-field-key="textarea"><?php echo stripslashes($faq['answer']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button id="add-new-dl-faq" type="button" class="add-button">
                        <?php esc_html_e('Add FAQ', 'apktemplates'); ?>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>