<?php
// Featured Section
$archive_featured_swt = get_theme_mod('archive_featured_swt', '1');
$archive_featured_count = get_theme_mod('archive_featured_count', '5');
$archive_sidebar_swt = get_theme_mod('archive_sidebar_swt', '1');

// Recent Section
$archive_recent_swt = get_theme_mod('archive_recent_swt', '1');
$archive_recent_limit = get_theme_mod('archive_recent_limit', '4');

// Recommended Section
$archive_recommended_swt = get_theme_mod('archive_recommended_swt', '1');
$archive_recommended_limit = get_theme_mod('archive_recommended_limit', '2');

// Premium Section
$archive_premium_swt = get_theme_mod('archive_premium_swt', '1');
$archive_premium_limit = get_theme_mod('archive_premium_limit', '6');

// Archive Loop
$archive_sort = get_theme_mod('archive_sort', 'latest');
$archive_posts_limit = get_theme_mod('archive_posts_limit', '12');

// Top Apps Section
$archive_top_apps_swt = get_theme_mod('archive_top_apps_swt', '1');
$archive_top_apps_count = get_theme_mod('archive_top_apps_count', '5');
$archive_numbered_subcats = get_theme_mod('archive_numbered_subcats', '0');

// Subcategory Carousels
$archive_carousel_swt = get_theme_mod('archive_carousel_swt', '1');
$archive_carousel_subcats = get_theme_mod('archive_carousel_subcats', '0');
$archive_carousel_sort = get_theme_mod('archive_carousel_sort', 'latest');
$archive_carousel_posts = get_theme_mod('archive_carousel_posts', '9');

// Dynamic Subcategories (Repeater)
$archive_dynamic_subcats = get_theme_mod('archive_dynamic_subcats', []);

// Custom Pages Settings
$popular_page_items = get_theme_mod('popular_page_items', '9');
$recommended_page_items = get_theme_mod('recommended_page_items', '12');

$posts_sortby = [
    'popular' => __('Popular', 'apktemplates'),
    'latest' => __('Latest to Old', 'apktemplates'),
    'oldest' => __('Old to New', 'apktemplates'),
    'modified' => __('Recently Modified', 'apktemplates'),
    'a_to_z' => __('A to Z ↓', 'apktemplates'),
    'z_to_a' => __('Z to A ↑', 'apktemplates'),
    'random' => __('Random', 'apktemplates'),
];

$top_apps_options = [
    '5' => __('Top 5', 'apktemplates'),
    '10' => __('Top 10', 'apktemplates'),
];

$subcats_options = [
    '0' => __('All Subcategories', 'apktemplates'),
    '1' => __('1 Subcategory', 'apktemplates'),
    '2' => __('2 Subcategories', 'apktemplates'),
    '3' => __('3 Subcategories', 'apktemplates'),
    '4' => __('4 Subcategories', 'apktemplates'),
    '5' => __('5 Subcategories', 'apktemplates'),
];

$carousel_styles = [
    'boxed' => __('Boxed', 'apktemplates'),
    'rectangle' => __('Rectangle', 'apktemplates'),
    'landscape' => __('Landscape', 'apktemplates'),
];

$repeater_posts_sortby = [
    'latest' => __('Latest', 'apktemplates'),
    'popular' => __('Popular', 'apktemplates'),
    'oldest' => __('Oldest', 'apktemplates'),
    'modified' => __('Recently Modified', 'apktemplates'),
    'a_to_z' => __('A to Z', 'apktemplates'),
    'random' => __('Random', 'apktemplates'),
];
?>
<div class="at-field-section" data-section="archives">
    <div class="at-form-header">
        <h2><?php esc_html_e('Archives', 'apktemplates'); ?></h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <!-- Featured Section -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Featured Section', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Configure the featured banners section for the archive page.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Featured Banners (Destacados)', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Show the featured banners slider on the archive page.', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="archive_featured_swt" value="1" <?php checked($archive_featured_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <p class="at-mini-title"><?php esc_html_e('Featured Count', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Number of featured apps to show in the slider.', 'apktemplates'); ?></p>
                        <input type="number" name="archive_featured_count" class="at-number-ipt" min="1" max="50" value="<?php echo esc_attr($archive_featured_count); ?>" />
                    </div>
                </td>
            </tr>

            <!-- Agregados Recientemente (Recent Releases) -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Agregados Recientemente', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Configure the Agregados Recientemente section for the archive page.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Show/Hide Section', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Show Agregados Recientemente section on parent category archives.', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="archive_recent_swt" value="1" <?php checked($archive_recent_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <p class="at-mini-title"><?php esc_html_e('Posts Limit', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Number of recent apps to show (default 4).', 'apktemplates'); ?></p>
                        <input type="number" name="archive_recent_limit" class="at-number-ipt" min="1" max="50" value="<?php echo esc_attr($archive_recent_limit); ?>" />
                    </div>
                </td>
            </tr>

            <!-- Recomendadas para ti (Recommended) -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Recomendadas para ti', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Configure the Recomendadas para ti section for the archive page.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Show/Hide Section', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Show Recomendadas para ti section on parent category archives.', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="archive_recommended_swt" value="1" <?php checked($archive_recommended_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <p class="at-mini-title"><?php esc_html_e('Posts Limit', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Number of recommended apps to show (default 2).', 'apktemplates'); ?></p>
                        <input type="number" name="archive_recommended_limit" class="at-number-ipt" min="1" max="50" value="<?php echo esc_attr($archive_recommended_limit); ?>" />
                    </div>
                </td>
            </tr>

            <!-- Joyas Premium Gratis (Premium) -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Joyas Premium Gratis', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Configure the Joyas Premium Gratis section for the archive page.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Show/Hide Section', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Show Joyas Premium Gratis section on parent category archives.', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="archive_premium_swt" value="1" <?php checked($archive_premium_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div>
                        <p class="at-mini-title"><?php esc_html_e('Posts Limit', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Number of premium/free apps to show (default 6).', 'apktemplates'); ?></p>
                        <input type="number" name="archive_premium_limit" class="at-number-ipt" min="1" max="50" value="<?php echo esc_attr($archive_premium_limit); ?>" />
                    </div>
                </td>
            </tr>

            <!-- Archive Loop -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Archive Loop', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Configure default sorting and posts limit for the main archive page loop.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Order By', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Default sorting order for the archive loop.', 'apktemplates'); ?></p>
                        <select class="at-select" name="archive_sort">
                            <?php foreach ($posts_sortby as $key => $sort): ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($archive_sort, $key); ?>>
                                    <?php echo esc_html($sort); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <p class="at-mini-title"><?php esc_html_e('Posts Limit', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Number of posts to display per page in the archive loop.', 'apktemplates'); ?></p>
                        <input type="number" name="archive_posts_limit" class="at-number-ipt" min="1" max="100" value="<?php echo esc_attr($archive_posts_limit); ?>" />
                    </div>
                </td>
            </tr>

            <!-- Top Apps Section -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Top Apps Section', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Configure top apps layout and subcategories limit.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Top Apps Section', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Show the unified top apps list (Parent Category only).', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="archive_top_apps_swt" value="1" <?php checked($archive_top_apps_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Top Apps Count', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('How many top apps to show.', 'apktemplates'); ?></p>
                        <select class="at-select" name="archive_top_apps_count">
                            <?php foreach ($top_apps_options as $key => $label): ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($archive_top_apps_count, $key); ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <p class="at-mini-title"><?php esc_html_e('Subcategories in Numbered List', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('How many subcategories to include when building the unified top apps list.', 'apktemplates'); ?></p>
                        <select class="at-select" name="archive_numbered_subcats">
                            <?php foreach ($subcats_options as $key => $label): ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($archive_numbered_subcats, $key); ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </td>
            </tr>

            <!-- Subcategory Carousels -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Subcategory Carousels', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Configure the default horizontal flickity carousels for subcategories.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Carousel Sections', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Show the Flickity multi-column carousel sections.', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="archive_carousel_swt" value="1" <?php checked($archive_carousel_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Carousel Subcategories', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('How many subcategories to show in the carousel section.', 'apktemplates'); ?></p>
                        <select class="at-select" name="archive_carousel_subcats">
                            <?php foreach ($subcats_options as $key => $label): ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($archive_carousel_subcats, $key); ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Order By', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Sorting order for the subcategory carousels.', 'apktemplates'); ?></p>
                        <select class="at-select" name="archive_carousel_sort">
                            <?php foreach ($posts_sortby as $key => $sort): ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($archive_carousel_sort, $key); ?>>
                                    <?php echo esc_html($sort); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <p class="at-mini-title"><?php esc_html_e('Carousel Posts per Category', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Number of posts to fetch for each subcategory carousel (multiple of 3 recommended).', 'apktemplates'); ?></p>
                        <input type="number" name="archive_carousel_posts" class="at-number-ipt" min="1" max="50" value="<?php echo esc_attr($archive_carousel_posts); ?>" />
                    </div>
                </td>
            </tr>

            <!-- Dynamic Subcategories -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Dynamic Subcategories', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Add repeatable subcategory sections with custom styles and titles. (If used, this overrides the default Subcategory Carousels).', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div id="archive-dynamic-subcats" class="at-mb-2 at-term-field <?php echo !empty($archive_dynamic_subcats) ? 'active' : ''; ?>" <?php echo !empty($archive_dynamic_subcats) ? 'style="display: block"' : 'style="display: none"'; ?>>
                        <?php foreach ($archive_dynamic_subcats as $index => $subcat): ?>
                            <div class="at-coll-container" data-index="<?php echo esc_attr($index); ?>">
                                <div class="at-coll-header">
                                    <div class="at-coll-title">
                                        <?php echo esc_html__('Dynamic Subcategory', 'apktemplates') . ' ' . ($index + 1); ?>
                                    </div>
                                    <div class="at-coll-action">
                                        <span class="at-action-move" aria-label="<?php esc_attr_e('Move section', 'apktemplates'); ?>">
                                            <i class="fa fa-bars"></i>
                                        </span>
                                        <a href="javascript:void(0);" class="remove-at-coll delete" aria-label="<?php esc_attr_e('Remove', 'apktemplates'); ?>">
                                            <?php esc_html_e('Remove', 'apktemplates'); ?>
                                        </a>
                                        <a href="javascript:void(0);" class="edit-at-coll edit" aria-label="<?php esc_attr_e('Edit', 'apktemplates'); ?>">
                                            <?php esc_html_e('Edit', 'apktemplates'); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="at-coll-body" style="display: none" aria-expanded="false">
                                    <div class="at-mb-2 at-pb-2">
                                        <p class="at-mini-title"><?php esc_html_e('Enable/Disable', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Show/Hide this section.', 'apktemplates'); ?></p>
                                        <label class="at-switch-btn">
                                            <input type="checkbox" name="archive_dynamic_subcats[<?php echo esc_attr($index); ?>][enable]" data-field-key="enable" <?php checked($subcat['enable'] ?? true, true); ?> />
                                            <span class="at-switch"></span>
                                        </label>
                                    </div>
                                    <div class="at-mb-2 at-pb-2">
                                        <p class="at-mini-title"><?php esc_html_e('Custom Title', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Leave empty to use category name.', 'apktemplates'); ?></p>
                                        <input type="text" name="archive_dynamic_subcats[<?php echo esc_attr($index); ?>][title]" class="at-text-ipt" value="<?php echo esc_attr($subcat['title'] ?? ''); ?>" data-field-key="title" />
                                    </div>
                                    <div class="at-mb-2 at-pb-2">
                                        <p class="at-mini-title"><?php esc_html_e('Subcategory', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Search and select the subcategory.', 'apktemplates'); ?></p>
                                        <input type="search" class="at-search-ipt coll-search" minlength="3" data-index="<?php echo esc_attr($index); ?>" placeholder="<?php esc_attr_e('Enter at least 3 letters...', 'apktemplates'); ?>" />
                                        <div class="coll-results" style="display: none"></div>
                                        <div class="coll-results-selected">
                                            <ul data-term-search-id="<?php echo esc_attr($index); ?>">
                                                <?php if (!empty($subcat['term_id']) && apkt_is_category_or_tag($subcat['term_id'])): ?>
                                                    <li data-term-id="<?php echo esc_attr($subcat['term_id']); ?>">
                                                        <?php echo esc_html(get_term_name_by_id($subcat['term_id'])); ?>
                                                        <span class="delete" aria-label="<?php esc_attr_e('Remove term', 'apktemplates'); ?>">
                                                            <i class="fa fa-trash-alt"></i>
                                                        </span>
                                                        <input type="hidden" name="archive_dynamic_subcats[<?php echo esc_attr($index); ?>][term_id]" value="<?php echo esc_attr($subcat['term_id']); ?>" data-field-key="term_id" />
                                                    </li>
                                                <?php else: ?>
                                                    <input type="hidden" name="archive_dynamic_subcats[<?php echo esc_attr($index); ?>][term_id]" value="" data-field-key="term_id" />
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="at-mb-2 at-pb-2">
                                        <p class="at-mini-title"><?php esc_html_e('Parent Category Filter', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Show this section on this parent category page only.', 'apktemplates'); ?></p>
                                        <select class="terms_parent_cat" name="archive_dynamic_subcats[<?php echo esc_attr($index); ?>][parent_cat]" data-field-key="parent_cat" style="width: 100%;">
                                            <?php
                                            $top_categories = get_categories(['parent' => 0, 'hide_empty' => false]);
                                            $parent_cat_val = $subcat['parent_cat'] ?? 'all';
                                            ?>
                                            <option value="all" <?php selected($parent_cat_val, 'all'); ?>><?php esc_html_e('All', 'apktemplates'); ?></option>
                                            <?php if (!is_wp_error($top_categories) && !empty($top_categories)) : ?>
                                                <?php foreach ($top_categories as $cat) : ?>
                                                    <option value="<?php echo esc_attr($cat->term_id); ?>" <?php selected($parent_cat_val, $cat->term_id); ?>>
                                                        <?php echo esc_html($cat->name); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="at-mb-2 at-pb-2">
                                        <p class="at-mini-title"><?php esc_html_e('Display Style', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Choose the layout style.', 'apktemplates'); ?></p>
                                        <select class="terms_style" name="archive_dynamic_subcats[<?php echo esc_attr($index); ?>][style]" data-field-key="style" style="width: 100%;">
                                            <?php foreach ($carousel_styles as $key => $style_label): ?>
                                                <option value="<?php echo esc_attr($key); ?>" <?php selected($subcat['style'] ?? 'rectangle', $key); ?>>
                                                    <?php echo esc_html($style_label); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="at-mb-2 at-pb-2">
                                        <p class="at-mini-title"><?php esc_html_e('Order By', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Sorting order for this subcategory.', 'apktemplates'); ?></p>
                                        <select class="terms_sortby" name="archive_dynamic_subcats[<?php echo esc_attr($index); ?>][posts_order]" data-field-key="posts_order" style="width: 100%;">
                                            <?php foreach ($repeater_posts_sortby as $key => $sort_label): ?>
                                                <option value="<?php echo esc_attr($key); ?>" <?php selected($subcat['posts_order'] ?? 'latest', $key); ?>>
                                                    <?php echo esc_html($sort_label); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div>
                                        <p class="at-mini-title"><?php esc_html_e('Posts Limit', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Number of apps to show.', 'apktemplates'); ?></p>
                                        <input type="number" name="archive_dynamic_subcats[<?php echo esc_attr($index); ?>][limit]" class="at-number-ipt" min="1" max="100" value="<?php echo esc_attr($subcat['limit'] ?? 9); ?>" data-field-key="limit" />
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button id="add-new-dynamic-subcat" type="button" class="add-button">
                        <?php esc_html_e('Add Dynamic Subcategory', 'apktemplates'); ?>
                    </button>
                </td>
            </tr>

            <!-- Archive Sidebar Option -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Archive Sidebar', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Toggle the visibility of the sidebar on archive/category pages.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Show Sidebar', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Enable to show the sidebar (e.g. "Más Populares") on the archive page. Disable to hide it and show main content in full width.', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="archive_sidebar_swt" value="1" <?php checked($archive_sidebar_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                </td>
            </tr>

            <!-- Custom Pages Settings -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Custom Pages Settings', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Configure lists display limit for Popular and Recommended custom templates.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Popular Apps Items', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Number of items to show per page on the Popular Apps custom page.', 'apktemplates'); ?></p>
                        <input type="number" name="popular_page_items" class="at-number-ipt" min="1" max="100" value="<?php echo esc_attr($popular_page_items); ?>" />
                    </div>
                    <div>
                        <p class="at-mini-title"><?php esc_html_e('Recommended Apps Items', 'apktemplates'); ?></p>
                        <p class="at-field-hint"><?php esc_html_e('Number of items to show per page on the Recommended Apps custom page.', 'apktemplates'); ?></p>
                        <input type="number" name="recommended_page_items" class="at-number-ipt" min="1" max="100" value="<?php echo esc_attr($recommended_page_items); ?>" />
                    </div>
                </td>
            </tr>

        </tbody>
    </table>
</div>
