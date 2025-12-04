<?php
$sidebar_cat_1 = get_theme_mod('sidebar_cat_1');
$sidebar_cat_2 = get_theme_mod('sidebar_cat_2');
?>
<div class="at-field-section" data-section="sidebar">
    <div class="at-form-header">
        <h2>Sidebar</h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <tr>
                <td>
                    <h3>
                        <?php esc_html_e('Category/Tag', 'apktemplates'); ?>
                    </h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Choose sidebar categories or tags.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title">Term 1</p>
                        <div id="at-sb-term-search-1">
                            <input type="search" class="at-search-ipt term-search" min="3"
                                placeholder="Enter atleast 3 letters..." />
                            <div class="term-results" style="display: none"></div>
                            <div class="term-selected">
                                <ul>
                                    <?php
                                    if (!empty($sidebar_cat_1) && apkt_is_category_or_tag($sidebar_cat_1)):
                                        ?>
                                        <li data-term-id="<?php echo $sidebar_cat_1; ?>">
                                            <?php echo esc_html(get_term_name_by_id($sidebar_cat_1)); ?>
                                            <span class="delete"><i class="fa fa-trash-alt"></i></span>
                                            <input type="hidden" name="sidebar_cat_1"
                                                value="<?php echo $sidebar_cat_1; ?>" />
                                        </li>
                                    <?php else: ?>
                                        <input type="hidden" name="sidebar_cat_1" value="" />
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="at-mb">
                        <p class="at-mini-title">Term 2</p>
                        <div id="at-sb-term-search-2">
                            <input type="search" class="at-search-ipt term-search" min="3"
                                placeholder="Enter atleast 3 letters..." />
                            <div class="term-results" style="display: none"></div>
                            <div class="term-selected">
                                <ul>
                                    <?php if (!empty($sidebar_cat_2) && apkt_is_category_or_tag($sidebar_cat_2)): ?>
                                        <li data-term-id="<?php echo $sidebar_cat_2; ?>">
                                            <?php echo esc_html(get_term_name_by_id($sidebar_cat_2)); ?>
                                            <span class="delete"><i class="fa fa-trash-alt"></i></span>
                                            <input type="hidden" name="sidebar_cat_2"
                                                value="<?php echo $sidebar_cat_2; ?>" />
                                        </li>
                                    <?php else: ?>
                                        <input type="hidden" name="sidebar_cat_2" value="" />
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>