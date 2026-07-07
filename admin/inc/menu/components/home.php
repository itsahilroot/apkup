<?php
$au_home_hero_top_description = get_theme_mod('au_home_hero_top_description', 'GAMES & APPS FOR ANDROID - A LARGE SELECTION OF APPS FOR ANDROID DEVICES FREE AND WITH NO VIRUSES');

$au_home_hero_swt = get_theme_mod('au_home_hero_swt', true);
$au_home_hero_limit = get_theme_mod('au_home_hero_limit', 16);
$au_home_hero_sort = get_theme_mod('au_home_hero_sort', 'modified');
$au_home_hero_term_id = get_theme_mod('au_home_hero_term_id', '');

$au_hero_title_1 = get_theme_mod('au_hero_title_1', 'Unlock');
$au_hero_title_2 = get_theme_mod('au_hero_title_2', 'New Games');
$au_hero_title_3 = get_theme_mod('au_hero_title_3', 'MOD APPS');
$au_hero_description = get_theme_mod('au_hero_description', 'Premium mods that transform your favorite games with enhanced features and unlimited possibilities.');

$au_hero_btn_title_1 = get_theme_mod('au_hero_btn_title_1', 'ALL GAMES');
$au_hero_btn_title_2 = get_theme_mod('au_hero_btn_title_2', 'MOD APPS');
$au_hero_btn_url_1 = get_theme_mod('au_hero_btn_url_1', get_site_url());
$au_hero_btn_url_2 = get_theme_mod('au_hero_btn_url_2', get_site_url());

$au_hero_dl_text = get_theme_mod('au_hero_dl_text', '100K+');
$au_hero_mod_text = get_theme_mod('au_hero_mod_text', '900+');
$au_hero_rating_text = get_theme_mod('au_hero_rating_text', '4.9');

$au_hero_banner_img = get_theme_mod('au_hero_banner_img', get_template_directory_uri() . '/assets/img/banner.jpg');
$au_hero_banner_icon_1 = get_theme_mod('au_hero_banner_icon_1', get_template_directory_uri() . '/assets/img/icon1.png');
$au_hero_banner_icon_2 = get_theme_mod('au_hero_banner_icon_2', get_template_directory_uri() . '/assets/img/icon2.png');

$au_home_trending_swt = get_theme_mod('au_home_trending_swt', true);
$au_home_trending_title = get_theme_mod('au_home_trending_title', 'Tendencias');
$au_home_trending_limit = get_theme_mod('au_home_trending_limit', 15);
$au_home_trending_sort = get_theme_mod('au_home_trending_sort', 'popular');
$au_home_trending_term_id = get_theme_mod('au_home_trending_term_id', '');
$au_home_premium_swt = get_theme_mod('au_home_premium_swt', false);
$au_home_premium_title = get_theme_mod('au_home_premium_title', 'Juegos Populares Baratos / Premium Gratis');
$au_home_premium_limit = get_theme_mod('au_home_premium_limit', 10);
$au_home_premium_sort = get_theme_mod('au_home_premium_sort', 'modified');
$au_home_premium_term_id = get_theme_mod('au_home_premium_term_id', '');
$au_home_recommended_swt = get_theme_mod('au_home_recommended_swt', false);

$au_home_recommended = get_theme_mod('au_home_recommended', []);
$au_home_posts = get_theme_mod('au_home_posts', []);
$posts_sortby = [
    'latest' => __('Latest', 'apktemplates'),
    'modified' => __('Modified', 'apktemplates'),
    'popular' => __('Popular', 'apktemplates'),
    'a_to_z' => __('A to Z ↓', 'apktemplates'),
    'z_to_a' => __('A to Z ↑', 'apktemplates')
];
$au_home_categories = get_theme_mod('au_home_categories', []);
$au_home_categories_swt = get_theme_mod('au_home_categories_swt', true);

$au_home_blogs_swt = get_theme_mod('au_home_blogs_swt', false);
$au_home_blogs_title = get_theme_mod('au_home_blogs_title', 'Blogs');
$au_home_blogs_limit = get_theme_mod('au_home_blogs_limit', '5');
?>
<div class="at-field-section" data-section="home">
    <div class="at-form-header">
        <h2><?php esc_html_e('Home', 'apktemplates'); ?></h2>
    </div>
    <table class="at-field-table">
        <tbody>
            <tr>
                <td>
                    <h3><?php esc_html_e('Hero Top Bar text', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize home hero (Intro) section top bar text.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Top Bar Text', 'apktemplates'); ?></p>
                        <input type="text" name="au_home_hero_top_description" class="at-text-ipt" value="<?php echo esc_attr($au_home_hero_top_description); ?>" placeholder="E.g. GAMES & APPS FOR ANDROID ..." />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?php esc_html_e('Hero Section Title', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize the title for the Hero / Recently Updated section.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Section Title', 'apktemplates'); ?></p>
                        <input type="text" name="au_home_hero_title" class="at-text-ipt" value="<?php echo esc_attr(get_theme_mod('au_home_hero_title', 'Últimas actualizaciones')); ?>" placeholder="E.g. Latest Updates" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Enable Section', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="au_home_hero_swt" value="1" <?php checked($au_home_hero_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Posts Limit', 'apktemplates'); ?></p>
                        <input type="number" name="au_home_hero_limit" class="at-number-ipt" min="1" max="50" value="<?php echo esc_attr($au_home_hero_limit); ?>" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Sort Order', 'apktemplates'); ?></p>
                        <select class="at-select" name="au_home_hero_sort">
                            <?php foreach ($posts_sortby as $key => $sort): ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($au_home_hero_sort, $key); ?>>
                                    <?php echo esc_html($sort); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Filter by Category/Tag', 'apktemplates'); ?></p>
                        <div class="at-term-select-wrapper" id="at-hero-term-wrapper">
                            <input type="search" class="at-search-ipt" minlength="3" placeholder="<?php esc_attr_e('Enter at least 3 letters...', 'apktemplates'); ?>" />
                            <div class="term-results" style="display: none"></div>
                            <div class="term-selected at-mt-1">
                                <ul>
                                    <?php if (!empty($au_home_hero_term_id) && apkt_is_category_or_tag($au_home_hero_term_id)): ?>
                                        <li data-term-id="<?php echo esc_attr($au_home_hero_term_id); ?>">
                                            <?php echo esc_html(get_term_name_by_id($au_home_hero_term_id)); ?>
                                            <span class="delete"><i class="fa fa-trash-alt"></i></span>
                                            <input type="hidden" name="au_home_hero_term_id" value="<?php echo esc_attr($au_home_hero_term_id); ?>" />
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <!-- <tr>
                <td>
                    <h3><?php esc_html_e('Hero Section', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize home hero (Intro) section.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Intro Title 1', 'apktemplates'); ?></p>
                        <input type="text" name="au_hero_title_1" class="at-text-ipt" value="<?php echo esc_attr($au_hero_title_1); ?>" placeholder="E.g. Unlock" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Intro Title 2', 'apktemplates'); ?></p>
                        <input type="text" name="au_hero_title_2" class="at-text-ipt" value="<?php echo esc_attr($au_hero_title_2); ?>" placeholder="E.g. New Games" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Intro Title 3', 'apktemplates'); ?></p>
                        <input type="text" name="au_hero_title_3" class="at-text-ipt" value="<?php echo esc_attr($au_hero_title_3); ?>" placeholder="E.g. MOD APPS" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Intro Description', 'apktemplates'); ?></p>
                        <textarea name="au_hero_description" class="at-textarea" spellcheck="false" rows="7" placeholder="E.g. Premium apps and games available on our site..."><?php echo stripslashes($au_hero_description); ?></textarea>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Intro Button 1 Title', 'apktemplates'); ?></p>
                        <input type="text" name="au_hero_btn_title_1" class="at-text-ipt" value="<?php echo esc_attr($au_hero_btn_title_1); ?>" placeholder="E.g. ALL GAMES" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Intro Button 1 URL', 'apktemplates'); ?></p>
                        <input type="url" name="au_hero_btn_url_1" class="at-text-ipt" value="<?php echo esc_attr($au_hero_btn_url_1); ?>" placeholder="E.g. https://example.com/games" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Intro Button 2 Title', 'apktemplates'); ?></p>
                        <input type="text" name="au_hero_btn_title_2" class="at-text-ipt" value="<?php echo esc_attr($au_hero_btn_title_2); ?>" placeholder="E.g. MOD APPS" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Intro Button 2 URL', 'apktemplates'); ?></p>
                        <input type="url" name="au_hero_btn_url_2" class="at-text-ipt" value="<?php echo esc_attr($au_hero_btn_url_2); ?>" placeholder="E.g. https://example.com/apps" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Intro Downloads Count', 'apktemplates'); ?></p>
                        <input type="text" name="au_hero_dl_text" class="at-text-ipt" value="<?php echo esc_attr($au_hero_dl_text); ?>" placeholder="E.g. 500K+" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Intro MOD Posts Count', 'apktemplates'); ?></p>
                        <input type="text" name="au_hero_mod_text" class="at-text-ipt" value="<?php echo esc_attr($au_hero_mod_text); ?>" placeholder="E.g. 1920" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Intro Site Rating', 'apktemplates'); ?></p>
                        <input type="text" name="au_hero_rating_text" class="at-text-ipt" value="<?php echo esc_attr($au_hero_rating_text); ?>" placeholder="E.g. 4.9" />
                    </div>
                    <div class="at-mb-1">
                        <p class="at-mini-title"><?php esc_html_e('Intro Banner Image', 'apktemplates'); ?></p>
                        <div class="at-img-upload">
                            <input type="text" name="au_hero_banner_img" id="au_hero_banner_img" class="at-text-ipt"
                                value="<?php echo esc_html($au_hero_banner_img); ?>" />
                            <button type="button" class="at-upload-img-ipt" data-title="Intro Banner Image" data-target="#au_hero_banner_img"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg></button>
                        </div>
                    </div>
                    <p class="at-field-hint at-mb-2">
                        <?php esc_html_e('Required image size: width: 610px and height: 500px.', 'apktemplates'); ?>
                    </p>
                    <div class="at-mb-1">
                        <p class="at-mini-title"><?php esc_html_e('Intro Banner Icon 1', 'apktemplates'); ?></p>
                        <div class="at-img-upload">
                            <input type="text" name="au_hero_banner_icon_1" id="au_hero_banner_icon_1" class="at-text-ipt"
                                value="<?php echo esc_html($au_hero_banner_icon_1); ?>" />
                            <button type="button" class="at-upload-img-ipt" data-title="Intro Banner Icon 1" data-target="#au_hero_banner_icon_1"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg></button>
                        </div>
                    </div>
                    <p class="at-field-hint at-mb-2">
                        <?php esc_html_e('Required image size: width: 128px and height: 128px.', 'apktemplates'); ?>
                    </p>
                    <div class="at-mb-1">
                        <p class="at-mini-title"><?php esc_html_e('Intro Banner Icon 2', 'apktemplates'); ?></p>
                        <div class="at-img-upload">
                            <input type="text" name="au_hero_banner_icon_2" id="au_hero_banner_icon_2" class="at-text-ipt"
                                value="<?php echo esc_html($au_hero_banner_icon_2); ?>" />
                            <button type="button" class="at-upload-img-ipt" data-title="Intro Banner Icon 2" data-target="#au_hero_banner_icon_2"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg></button>
                        </div>
                    </div>
                    <p class="at-field-hint at-mb-2">
                        <?php esc_html_e('Required image size: width: 128px and height: 128px.', 'apktemplates'); ?>
                    </p>
                </td>
            </tr> -->
            <tr>
                <td>
                    <h3><?php esc_html_e('Trending Section', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize the Trending section.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Enable Section', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="au_home_trending_swt" value="1" <?php checked($au_home_trending_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Section Title', 'apktemplates'); ?></p>
                        <input type="text" name="au_home_trending_title" class="at-text-ipt" value="<?php echo esc_attr($au_home_trending_title); ?>" placeholder="E.g. Trending" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Posts Limit', 'apktemplates'); ?></p>
                        <input type="number" name="au_home_trending_limit" class="at-number-ipt" min="1" max="50" value="<?php echo esc_attr($au_home_trending_limit); ?>" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Sort Order', 'apktemplates'); ?></p>
                        <select class="at-select" name="au_home_trending_sort">
                            <?php foreach ($posts_sortby as $key => $sort): ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($au_home_trending_sort, $key); ?>>
                                    <?php echo esc_html($sort); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Filter by Category/Tag', 'apktemplates'); ?></p>
                        <div class="at-term-select-wrapper" id="at-trending-term-wrapper">
                            <input type="search" class="at-search-ipt" minlength="3" placeholder="<?php esc_attr_e('Enter at least 3 letters...', 'apktemplates'); ?>" />
                            <div class="term-results" style="display: none"></div>
                            <div class="term-selected at-mt-1">
                                <ul>
                                    <?php if (!empty($au_home_trending_term_id) && apkt_is_category_or_tag($au_home_trending_term_id)): ?>
                                        <li data-term-id="<?php echo esc_attr($au_home_trending_term_id); ?>">
                                            <?php echo esc_html(get_term_name_by_id($au_home_trending_term_id)); ?>
                                            <span class="delete"><i class="fa fa-trash-alt"></i></span>
                                            <input type="hidden" name="au_home_trending_term_id" value="<?php echo esc_attr($au_home_trending_term_id); ?>" />
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?php esc_html_e('Premium Section', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize the Premium Apps and Games section.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Enable Section', 'apktemplates'); ?></p>
                        <label class="at-switch-btn">
                            <input type="checkbox" name="au_home_premium_swt" value="1" <?php checked($au_home_premium_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Section Title', 'apktemplates'); ?></p>
                        <input type="text" name="au_home_premium_title" class="at-text-ipt" value="<?php echo esc_attr($au_home_premium_title); ?>" placeholder="E.g. Premium Apps" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Posts Limit', 'apktemplates'); ?></p>
                        <input type="number" name="au_home_premium_limit" class="at-number-ipt" min="1" max="50" value="<?php echo esc_attr($au_home_premium_limit); ?>" />
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Sort Order', 'apktemplates'); ?></p>
                        <select class="at-select" name="au_home_premium_sort">
                            <?php foreach ($posts_sortby as $key => $sort): ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($au_home_premium_sort, $key); ?>>
                                    <?php echo esc_html($sort); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Filter by Category/Tag', 'apktemplates'); ?></p>
                        <div class="at-term-select-wrapper" id="at-premium-term-wrapper">
                            <input type="search" class="at-search-ipt" minlength="3" placeholder="<?php esc_attr_e('Enter at least 3 letters...', 'apktemplates'); ?>" />
                            <div class="term-results" style="display: none"></div>
                            <div class="term-selected at-mt-1">
                                <ul>
                                    <?php if (!empty($au_home_premium_term_id) && apkt_is_category_or_tag($au_home_premium_term_id)): ?>
                                        <li data-term-id="<?php echo esc_attr($au_home_premium_term_id); ?>">
                                            <?php echo esc_html(get_term_name_by_id($au_home_premium_term_id)); ?>
                                            <span class="delete"><i class="fa fa-trash-alt"></i></span>
                                            <input type="hidden" name="au_home_premium_term_id" value="<?php echo esc_attr($au_home_premium_term_id); ?>" />
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?php esc_html_e('Recommended Posts', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize home recommended posts.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div id="at-home-rc-field" class="at-mb-2 <?php echo !empty($au_home_recommended) ? 'active' : ''; ?>" <?php echo !empty($au_home_ep) ? 'style="display: block"' : 'style="display: none"'; ?>>
                        <div class="at-mb-2">
                            <p class="at-mini-title"><?php esc_html_e('Section Title', 'apktemplates'); ?></p>
                            <input type="text" name="au_home_recommended_title" class="at-text-ipt" value="<?php echo esc_attr(get_theme_mod('au_home_recommended_title', 'Recommended')); ?>" />
                        </div>
                        <?php foreach ($au_home_recommended as $index => $recommended): ?>
                            <div class="at-coll-container" data-index="<?php echo esc_attr($index); ?>">
                                <div class="at-coll-header">
                                    <div class="at-coll-title">
                                        <?php echo esc_html__('Recommended Post', 'apktemplates') . ' ' . ($index + 1); ?>
                                    </div>
                                    <div class="at-coll-action">
                                        <span class="at-action-move"
                                            aria-label="<?php esc_attr_e('Move section', 'apktemplates'); ?>">
                                            <i class="fa fa-bars"></i>
                                        </span>
                                        <a href="javascript:void(0);" class="remove-at-coll delete"
                                            aria-label="<?php esc_attr_e('Remove featured post', 'apktemplates'); ?>">
                                            <?php esc_html_e('Remove', 'apktemplates'); ?>
                                        </a>
                                        <a href="javascript:void(0);" class="edit-at-coll edit"
                                            aria-label="<?php esc_attr_e('Edit featured post', 'apktemplates'); ?>">
                                            <?php esc_html_e('Edit', 'apktemplates'); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="at-coll-body" style="display: none" aria-expanded="false">
                                    <div>
                                        <p class="at-mini-title"><?php esc_html_e('Post', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Select a post to link to this featured post.', 'apktemplates'); ?>
                                        </p>
                                        <input type="search" class="at-search-ipt coll-search" minlength="3"
                                            data-index="<?php echo esc_attr($index); ?>"
                                            placeholder="<?php esc_attr_e('Enter at least 3 letters...', 'apktemplates'); ?>" />
                                        <div class="coll-results" style="display: none"></div>
                                        <div class="coll-results-selected">
                                            <ul data-post-search-id="<?php echo esc_attr($index); ?>">
                                                <?php if (!empty($recommended['post_id']) && get_post($recommended['post_id'])): ?>
                                                    <li data-post-id="<?php echo esc_attr($recommended['post_id']); ?>">
                                                        <?php echo esc_html(get_the_title($recommended['post_id'])); ?>
                                                        <span class="delete"
                                                            aria-label="<?php esc_attr_e('Remove post', 'apktemplates'); ?>">
                                                            <i class="fa fa-trash-alt"></i>
                                                        </span>
                                                        <input type="hidden"
                                                            name="au_home_recommended[<?php echo esc_attr($index); ?>][post_id]"
                                                            value="<?php echo esc_attr($recommended['post_id']); ?>"
                                                            data-field-key="post_id" />
                                                    </li>
                                                <?php else: ?>
                                                    <input type="hidden"
                                                        name="au_home_recommended[<?php echo esc_attr($index); ?>][post_id]" value=""
                                                        data-field-key="post_id" />
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button id="add-new-recommended" type="button" class="add-button">
                        <?php esc_html_e('Add Recommended Post', 'apktemplates'); ?>
                    </button>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?php esc_html_e('Posts', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize home posts.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div id="at-posts-field"
                        class="at-mb-2 at-term-field <?php echo !empty($au_home_posts) ? 'active' : ''; ?>" <?php echo !empty($au_home_posts) ? 'style="display: block"' : 'style="display: none"'; ?>>
                        <?php foreach ($au_home_posts as $index => $posts): ?>
                            <div class="at-coll-container" data-index="<?php echo esc_attr($index); ?>">
                                <div class="at-coll-header">
                                    <div class="at-coll-title">
                                        <?php echo esc_html__('Posts', 'apktemplates') . ' ' . ($index + 1); ?>
                                    </div>
                                    <div class="at-coll-action">
                                        <span class="at-action-move"
                                            aria-label="<?php esc_attr_e('Move section', 'apktemplates'); ?>">
                                            <i class="fa fa-bars"></i>
                                        </span>
                                        <a href="javascript:void(0);" class="remove-at-coll delete"
                                            aria-label="<?php esc_attr_e('Remove section', 'apktemplates'); ?>">
                                            <?php esc_html_e('Remove', 'apktemplates'); ?>
                                        </a>
                                        <a href="javascript:void(0);" class="edit-at-coll edit"
                                            aria-label="<?php esc_attr_e('Edit section', 'apktemplates'); ?>">
                                            <?php esc_html_e('Edit', 'apktemplates'); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="at-coll-body" style="display: none" aria-expanded="false">
                                    <div class="at-mb-2 at-pb-2">
                                        <p class="at-mini-title"><?php esc_html_e('Section Title', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Add text for title.', 'apktemplates'); ?></p>
                                        <input type="text" name="au_home_posts[<?php echo esc_attr($index); ?>][title]"
                                            class="at-text-ipt" value="<?php echo esc_attr($posts['title']); ?>"
                                            data-field-key="title" />
                                    </div>
                                    <div class="at-mb-2 at-pb-2">
                                        <p class="at-mini-title"><?php esc_html_e('Posts Limit', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Set the number of posts shown.', 'apktemplates'); ?></p>
                                        <input type="number" name="au_home_posts[<?php echo esc_attr($index); ?>][limit]"
                                            class="at-number-ipt" min="1" max="50"
                                            value="<?php echo esc_attr($posts['limit']); ?>" data-field-key="limit" />
                                        <?php esc_html_e('Posts', 'apktemplates'); ?>
                                    </div>
                                    <div class="at-mb-2 at-pb-2">
                                        <p class="at-mini-title">Posts Order</p>
                                        <p>Set posts order to showcase your posts.</p>
                                        <select class="terms_sortby" name="au_home_posts[<?php echo esc_attr($index); ?>][sort]" style="width: 100%;">
                                            <option value="">Select a Posts Order</option>
                                            <?php foreach ($posts_sortby as $key => $sort): ?>
                                                <option value="<?php echo esc_attr($key); ?>" <?php selected($posts['sort'] ?? '', $key); ?>>
                                                    <?php echo esc_html($sort); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="at-mb-2 at-pb-2">
                                        <p class="at-mini-title">Posts Style</p>
                                        <p>Set posts style to showcase your posts.</p>
                                        <?php $current_style = $au_home_posts[$index]['style'] ?? ''; ?>
                                        <select class="terms_style" name="au_home_posts[<?php echo esc_attr($index); ?>][style]" style="width: 100%;">
                                            <option value="">Select</option>
                                            <option value="boxed" <?php selected($current_style, 'boxed'); ?>>Boxed</option>
                                            <option value="rectangle" <?php selected($current_style, 'rectangle'); ?>>Rectangle</option>
                                            <option value="landscape" <?php selected($current_style, 'landscape'); ?>>Landscape</option>
                                        </select>
                                    </div>
                                    <div class="at-mb-2 at-pb-2">
                                        <p class="at-mini-title"><?php esc_html_e('Category/Tag', 'apktemplates'); ?></p>
                                        <p><?php esc_html_e('Select a category or tag term for the posts that will be shown.', 'apktemplates'); ?>
                                        </p>
                                        <input type="search" class="at-search-ipt coll-search" minlength="3"
                                            data-index="<?php echo esc_attr($index); ?>"
                                            placeholder="<?php esc_attr_e('Enter at least 3 letters...', 'apktemplates'); ?>" />
                                        <div class="coll-results" style="display: none"></div>
                                        <div class="coll-results-selected">
                                            <ul data-term-search-id="<?php echo esc_attr($index); ?>">
                                                <?php if (!empty($posts['term_id']) && apkt_is_category_or_tag($posts['term_id'])): ?>
                                                    <li data-term-id="<?php echo esc_attr($posts['term_id']); ?>">
                                                        <?php echo esc_html(get_term_name_by_id($posts['term_id'])); ?>
                                                        <span class="delete"
                                                            aria-label="<?php esc_attr_e('Remove term', 'apktemplates'); ?>">
                                                            <i class="fa fa-trash-alt"></i>
                                                        </span>
                                                        <input type="hidden"
                                                            name="au_home_posts[<?php echo esc_attr($index); ?>][term_id]"
                                                            value="<?php echo esc_attr($posts['term_id']); ?>"
                                                            data-field-key="term_id" />
                                                    </li>
                                                <?php else: ?>
                                                    <input type="hidden"
                                                        name="au_home_posts[<?php echo esc_attr($index); ?>][term_id]" value=""
                                                        data-field-key="term_id" />
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="at-mini-title"><?php esc_html_e('Section Bottom Ad', 'apktemplates'); ?>
                                        </p>
                                        <p><?php esc_html_e('Show or hide the advertisement shown at the bottom of this posts.', 'apktemplates'); ?>
                                        </p>
                                        <label class="at-switch-btn">
                                            <input type="checkbox"
                                                name="au_home_posts[<?php echo esc_attr($index); ?>][is_btm_ad]"
                                                data-field-key="is_btm_ad" <?php checked($posts['is_btm_ad'], true); ?> />
                                            <span class="at-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button id="add-new-posts" type="button" class="add-button">
                        <?php esc_html_e('Add Posts', 'apktemplates'); ?>
                    </button>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?php esc_html_e('Categories Section', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Enable or disable the categories section on the home page.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="au_home_categories_swt" value="1" <?php checked($au_home_categories_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <h3><?php esc_html_e('Blogs', 'apktemplates'); ?></h3>
                    <div class="at-field-descr">
                        <?php esc_html_e('Customize home blogs.', 'apktemplates'); ?>
                    </div>
                </td>
                <td>
                    <div class="at-mb-1">
                        <label class="at-switch-btn">
                            <input type="checkbox" name="au_home_blogs_swt" value="1" <?php checked($au_home_blogs_swt, 1); ?> />
                            <span class="at-switch"></span>
                        </label>
                    </div>
                    <div class="at-mb-2">
                        <p class="at-mini-title"><?php esc_html_e('Section Title', 'apktemplates'); ?></p>
                        <input type="text" name="au_home_blogs_title" class="at-text-ipt"
                            value="<?php echo esc_attr($au_home_blogs_title); ?>" />
                    </div>
                    <div>
                        <p class="at-mini-title"><?php esc_html_e('Blogs Limit', 'apktemplates'); ?></p>
                        <input type="number" name="au_home_blogs_limit" class="at-number-ipt" min="1" max="50"
                            value="<?php echo esc_attr($au_home_blogs_limit); ?>" />
                        <?php esc_html_e('Posts', 'apktemplates'); ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>