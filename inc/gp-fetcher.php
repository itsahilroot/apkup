<?php
/**
 * Google Play Auto-Fetch Metabox
 * Fetches app data from https://peekanapp.vercel.app/api/all?androidAppId={package}
 * and fills all existing metabox fields via AJAX.
 */

// Add metabox to side panel
add_action('add_meta_boxes', 'apkt_register_gp_fetcher_metabox', 10);
function apkt_register_gp_fetcher_metabox() {
    add_meta_box(
        'gp-fetcher',
        __('Google Play Importer', 'apktemplates'),
        'apkt_gp_fetcher_callback',
        'post',
        'side',
        'high'
    );
}

// Save GP Fetcher package ID metadata
add_action('save_post', 'apkt_save_gp_fetcher_meta');
function apkt_save_gp_fetcher_meta($post_id) {
    if (isset($_POST['wp_GP_ID'])) {
        update_post_meta($post_id, 'wp_GP_ID', sanitize_text_field($_POST['wp_GP_ID']));
    }
}

// ─── GP Fetcher Side Metabox Callback ─────────────────────────────────────────
function apkt_gp_fetcher_callback($post) {
    $saved_package = get_post_meta($post->ID, 'wp_GP_ID', true);
    if (empty($saved_package)) {
        $saved_package = get_post_meta($post->ID, 'px_app_id', true);
    }
    wp_nonce_field('gp_fetcher_action', 'gp_fetcher_nonce');
    ?>
    <div id="gp-fetcher-wrap" style="padding: 4px 0;">
        <p style="margin: 0 0 12px; color: #64748b; font-size: 13px; line-height: 1.4;">
            Paste the package ID or full Google Play URL and click <strong>Fetch Data</strong> to auto-fill all fields.
        </p>
        <div class="apkt-input-wrapper" style="margin-bottom: 12px;">
            <input
                type="text"
                id="gp-package-input"
                name="wp_GP_ID"
                placeholder="e.g. com.supercell.clashofclans"
                value="<?php echo esc_attr($saved_package); ?>"
                style="width: 100%; height: 36px; padding: 0 10px; border-radius: 4px; border: 1px solid #cbd5e1; font-family: inherit; font-size: 13px; box-sizing: border-box;"
            />
        </div>
        <button
            type="button"
            id="gp-fetch-btn"
            class="button button-primary button-large"
            style="width: 100%; text-align: center; font-weight: 600; height: 36px; line-height: 34px;"
        >
            <?php _e('Fetch Data', 'apktemplates'); ?>
        </button>
        <div id="gp-fetch-msg" style="margin-top: 8px; font-size: 13px; display: none;"></div>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#gp-fetch-btn').on('click', function(e) {
            e.preventDefault();
            var btn = $(this);
            var packageVal = $('#gp-package-input').val().trim();
            var msgDiv = $('#gp-fetch-msg');

            if (!packageVal) {
                msgDiv.css('color', '#dc2626').text('Please enter a package ID or URL.').show();
                return;
            }

            var post_id = $('#post_ID').val();
            if (!post_id && window.wp && wp.data && wp.data.select) {
                post_id = wp.data.select('core/editor').getCurrentPostId();
            }
            if (!post_id) {
                var match = window.location.search.match(/[?&]post=(\d+)/);
                if (match) {
                    post_id = match[1];
                }
            }

            btn.prop('disabled', true).text('Fetching...');
            msgDiv.css('color', '#4b5563').text('Retrieving data from Play Store...').show();

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'apkt_fetch_gplay_data',
                    package: packageVal,
                    post_id: post_id,
                    nonce: $('#gp_fetcher_nonce').val()
                },
                success: function(res) {
                    btn.prop('disabled', false).text('Fetch Data');
                    if (res.success && res.data) {
                        msgDiv.css('color', '#16a34a').text('Data fetched and filled successfully!').show();
                        
                        var app = res.data.data;
                        
                        // Set Title only if empty
                        var currentTitle = '';
                        if (window.wp && wp.data && wp.data.select && wp.data.select('core/editor')) {
                            currentTitle = wp.data.select('core/editor').getEditedPostAttribute('title') || '';
                        } else {
                            currentTitle = $('#title').val() || '';
                        }
                        currentTitle = currentTitle.trim();

                        if (!currentTitle && app.name) {
                            $('#title').val(app.name).trigger('change');
                            var titleBlock = document.querySelector('.editor-post-title__input');
                            if (titleBlock) {
                                titleBlock.textContent = app.name;
                                titleBlock.dispatchEvent(new Event('input', { bubbles: true }));
                            }
                            if (window.wp && wp.data && wp.data.dispatch && wp.data.dispatch('core/editor')) {
                                wp.data.dispatch('core/editor').editPost({ title: app.name });
                            }
                        }

                        // Set Content / Description only if empty
                        var currentContent = '';
                        if (window.wp && wp.data && wp.data.select && wp.data.select('core/editor')) {
                            currentContent = wp.data.select('core/editor').getEditedPostAttribute('content') || '';
                        } else {
                            if (window.tinyMCE && tinyMCE.get('content')) {
                                currentContent = tinyMCE.get('content').getContent() || '';
                            } else {
                                currentContent = $('#content').val() || '';
                            }
                        }
                        currentContent = currentContent.trim();

                        if (!currentContent && app.description) {
                            if (window.tinyMCE && tinyMCE.get('content')) {
                                tinyMCE.get('content').setContent(app.description);
                            }
                            $('#content').val(app.description);
                            if (window.wp && wp.data && wp.data.dispatch && wp.data.dispatch('core/editor')) {
                                wp.data.dispatch('core/editor').editPost({ content: app.description });
                            }
                        }

                        // App fields
                        if (app.version) {
                            $('#datos_informacion_version').val(app.version);
                        }
                        if (app.packageID) {
                            $('#datos_informacion_consiguelo').val('https://play.google.com/store/apps/details?id=' + app.packageID);
                            $('#gp-package-input').val(app.packageID);
                            $('#wp_GP_ID').val(app.packageID);
                        }
                        if (app.downloads) {
                            $('#datos_informacion_descargas').val(app.downloads);
                        }
                        if (app.content_rating) {
                            $('#datos_informacion_content_rating').val(app.content_rating);
                        }
                        if (app.developer) {
                            $('#wp_developers_GP').val(app.developer);
                            
                            if (app.publisher_term_id) {
                                var termId = parseInt(app.publisher_term_id);
                                
                                // Sync Block Editor (Gutenberg) taxonomy state
                                if (window.wp && wp.data && wp.data.dispatch && wp.data.select && wp.data.select('core/editor')) {
                                    var selectedDevelopers = wp.data.select('core/editor').getEditedPostAttribute('developer') || [];
                                    if (selectedDevelopers.indexOf(termId) === -1) {
                                        var newDevelopers = selectedDevelopers.concat(termId);
                                        wp.data.dispatch('core/editor').editPost({ developer: newDevelopers });
                                    }
                                }
                                
                                // Sync Classic Editor taxonomy checkbox checklist
                                var checkbox = $('#in-developer-' + termId);
                                if (checkbox.length) {
                                    checkbox.prop('checked', true);
                                } else {
                                    var checklist = $('#developerchecklist');
                                    if (checklist.length) {
                                        var newLi = $('<li id="developer-' + termId + '"><label class="selectit"><input value="' + termId + '" type="checkbox" name="tax_input[developer][]" id="in-developer-' + termId + '" checked="checked" /> ' + app.developer + '</label></li>');
                                        checklist.append(newLi);
                                    }
                                }
                            }
                        }

                        // Rating
                        if (app.rating) {
                            $('#new_rating_average').val(app.rating).trigger('input');
                            $('.tooltip').text(app.rating);
                        }
                        if (app.noOfUsersRated) {
                            // Strip commas if necessary or preserve string
                            $('#new_rating_users').val(app.noOfUsersRated);
                        }

                        // What's New
                        if (app.whats_new) {
                            if (window.tinyMCE && tinyMCE.get('datos_informacion_novedades')) {
                                tinyMCE.get('datos_informacion_novedades').setContent(app.whats_new);
                            }
                            $('#datos_informacion_novedades').val(app.whats_new);
                        }

                        // Default to Free
                        $('#datos_informacion_offer_price_gratis').prop('checked', true);
                        $('#datos_informacion_offer_price_pago').prop('checked', false);
                        $('#datos_informacion_offer_amount').val('');

                        // Category Dropdown Matching
                        var categoryName = app.category || "";
                        var catSelect = $('#datos_informacion_categoria_app');
                        if (catSelect.length && categoryName) {
                            var matched = false;
                            catSelect.find('option').each(function() {
                                var optVal = $(this).val().toUpperCase();
                                if (optVal === categoryName.toUpperCase() || optVal.indexOf(categoryName.toUpperCase()) !== -1 || categoryName.toUpperCase().indexOf(optVal) !== -1) {
                                    catSelect.val($(this).val());
                                    matched = true;
                                    return false;
                                }
                            });
                            if (!matched) {
                                catSelect.find('option').each(function() {
                                    if ($(this).text().trim().toLowerCase() === categoryName.toLowerCase()) {
                                        catSelect.val($(this).val());
                                        return false;
                                    }
                                });
                            }
                        }

                        // Populate Screenshots table (old design compatible)
                        if (app.screenshots && app.screenshots.length > 0) {
                            $('#screenshots-table tbody tr').not('.empty-screenshot-row').remove();
                            
                            var counter = 1;
                            app.screenshots.forEach(function(url) {
                                var row = $('.empty-screenshot-row').clone(true);
                                row.removeClass('empty-screenshot-row').show();
                                
                                row.find('input').val(url).attr('id', 'screenshot-url-' + counter).attr('name', 'datos_imagenes[]');
                                row.find('.upload-screenshot-btn').attr('id', 'screenshot-btn-' + counter).attr('data-target', 'screenshot-url-' + counter);
                                
                                $('#screenshots-table tbody').prepend(row);
                                counter++;
                            });
                        }

                        // Populate Banner
                        if (app.banner) {
                            $('#upload_banner_image').val(app.banner);
                            $('#banner_background').html('<span class="components-responsive-wrapper"><div><img src="' + app.banner + '" alt="" class="components-responsive-wrapper__content" style="max-width: 100%; height: auto;"></div></span>');
                            $('#add_banner').text('Replace');
                            $('#remove_banner').show();
                        }

                        // Set Featured Image
                        if (res.data.featured_image_id) {
                            var attachmentId = res.data.featured_image_id;
                            // Classic
                            $('#_thumbnail_id').val(attachmentId);
                            var setThumbnailBtn = $('#set-post-thumbnail');
                            if (setThumbnailBtn.length) {
                                setThumbnailBtn.html('<img src="' + app.logo + '" style="max-width:100%;height:auto;" />');
                            }
                            // Block editor
                            if (window.wp && wp.data && wp.data.dispatch) {
                                wp.data.dispatch('core/editor').editPost({ featured_media: attachmentId });
                            }
                        }
                    } else {
                        msgDiv.css('color', '#dc2626').text(res.data || 'Failed to fetch data.').show();
                    }
                },
                error: function() {
                    btn.prop('disabled', false).text('Fetch Data');
                    msgDiv.css('color', '#dc2626').text('Error connecting to Play Store importer.').show();
                }
            });
        });
    });
    </script>
    <?php
}

// AJAX Handler for Fetching GPlay Data
add_action('wp_ajax_apkt_fetch_gplay_data', 'apkt_fetch_gplay_data_handler');
function apkt_fetch_gplay_data_handler() {
    check_ajax_referer('gp_fetcher_action', 'nonce');
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Permission denied.');
    }
    
    $package_input = sanitize_text_field($_POST['package'] ?? '');
    if (empty($package_input)) {
        wp_send_json_error('No package ID or URL provided.');
    }
    
    // Extract package ID if a full URL is entered
    $package_id = $package_input;
    if (strpos($package_input, 'play.google.com') !== false) {
        if (preg_match('/id=([a-zA-Z0-9._\-]+)/', $package_input, $matches)) {
            $package_id = $matches[1];
        }
    }
    
    $post_id = intval($_POST['post_id'] ?? 0);
    
    $api_url = 'https://peekanapp.vercel.app/api/all?androidAppId=' . urlencode($package_id);
    $response = wp_remote_get($api_url, ['timeout' => 15, 'sslverify' => false]);
    
    if (is_wp_error($response)) {
        wp_send_json_error('Failed to fetch data from API: ' . $response->get_error_message());
    }
    
    $body = wp_remote_retrieve_body($response);
    $api_data = json_decode($body, true);
    
    if (empty($api_data) || empty($api_data['playstore'])) {
        wp_send_json_error('App not found or API error.');
    }
    
    $playstore = $api_data['playstore'];
    
    // Save package ID to post meta immediately
    if ($post_id && !empty($package_id)) {
        update_post_meta($post_id, 'wp_GP_ID', sanitize_text_field($package_id));
    }

    // Save developer to post meta and auto-create/sync publisher taxonomy term
    $developer = $playstore['developer'] ?? $playstore['developerName'] ?? '';
    $term_id = 0;
    if ($post_id && !empty($developer)) {
        update_post_meta($post_id, 'wp_developers_GP', sanitize_text_field($developer));
        
        $term = get_term_by('name', $developer, 'developer');
        if ($term) {
            $term_id = $term->term_id;
        } else {
            $inserted = wp_insert_term($developer, 'developer');
            if (!is_wp_error($inserted)) {
                $term_id = $inserted['term_id'];
            }
        }
        
        if ($term_id) {
            wp_set_object_terms($post_id, intval($term_id), 'developer', false);
        }
    }
    
    // Map new API data format to the format expected by the frontend JavaScript
    $data = [
        'name'              => $playstore['title'] ?? '',
        'version'           => $playstore['version'] ?? '',
        'packageID'         => $playstore['appId'] ?? '',
        'downloads'         => $playstore['installs'] ?? '',
        'rating'            => $playstore['scoreText'] ?? (isset($playstore['score']) ? round($playstore['score'], 1) : ''),
        'noOfUsersRated'    => $playstore['ratings'] ?? '',
        'category'          => $playstore['genreId'] ?? $playstore['genre'] ?? '',
        'screenshots'       => $playstore['screenshots'] ?? [],
        'banner'            => $playstore['headerImage'] ?? '',
        'logo'              => $playstore['icon'] ?? '',
        'whats_new'         => $playstore['recentChanges'] ?? '',
        'description'       => $playstore['descriptionHTML'] ?? '',
        'developer'         => $developer,
        'publisher_term_id' => $term_id,
        'content_rating'    => $playstore['contentRating'] ?? '',
    ];
    
    // Download and sideload icon if requested
    $attachment_id = 0;
    $icon_url = $data['logo'] ?? '';
    $app_title = $data['name'] ?? '';
    if ($post_id && !empty($icon_url)) {
        // Delete old featured image if it exists to replace it with the new one
        $old_thumbnail_id = get_post_thumbnail_id($post_id);
        if ($old_thumbnail_id) {
            wp_delete_attachment($old_thumbnail_id, true);
        }

        $attachment_id = apkt_sideload_image_to_media($icon_url, $post_id, $app_title);
        if ($attachment_id) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }
    
    $result = [
        'data' => $data,
        'featured_image_id' => $attachment_id
    ];
    
    wp_send_json_success($result);
}

// Sideload Image to Media Library Helper
function apkt_sideload_image_to_media($url, $post_id, $app_title = '') {
    if (empty($url)) return false;
    
    if (!class_exists('Scraper')) {
        require_once get_template_directory() . '/admin/class/class-scraper.php';
    }
    
    $upload_dir = wp_upload_dir();
    if (!isset($upload_dir['path'], $upload_dir['url'])) {
        return false;
    }

    $scraper = new Scraper();
    $fetch_image = $scraper->scrape($url);

    if (!is_array($fetch_image) || $fetch_image['status'] !== 'success' || empty($fetch_image['data']['content'])) {
        return false;
    }

    $image_content = $fetch_image['data']['content'];

    $original_format = null;
    if (!empty($fetch_image['data']['headers']['content-type'])) {
        $mime = $fetch_image['data']['headers']['content-type'];
        $ext  = wp_check_filetype_from_ext($mime);
        if (!empty($ext['ext'])) {
            $original_format = $ext['ext'];
        } else {
            if (strpos($mime, 'image/png') !== false) {
                $original_format = 'png';
            } elseif (strpos($mime, 'image/jpeg') !== false) {
                $original_format = 'jpg';
            } elseif (strpos($mime, 'image/webp') !== false) {
                $original_format = 'webp';
            }
        }
    }

    $final_format = $original_format ?: 'png';

    // Get the title to be used for naming and alt text
    $title_to_use = !empty($app_title) ? $app_title : get_the_title($post_id);
    if (empty($title_to_use)) {
        $title_to_use = 'app-icon';
    }
    $clean_title = function_exists('apktemplates_clean') ? apktemplates_clean($title_to_use) : $title_to_use;
    $image_name  = sanitize_title_with_dashes($clean_title);
    $unique_suffix   = substr(time() . mt_rand(1000, 9999), -8);
    $image_full_name = "{$image_name}-icon-{$unique_suffix}.{$final_format}";
    $image_path      = trailingslashit($upload_dir['path']) . $image_full_name;

    if (file_put_contents($image_path, $image_content) === false) {
        return false;
    }

    $file_type = wp_check_filetype(basename($image_full_name), null);
    if (empty($file_type['type'])) {
        @unlink($image_path);
        return false;
    }

    $image_attachment = [
        'post_mime_type' => $file_type['type'],
        'post_title'     => $title_to_use,
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $image_id = wp_insert_attachment($image_attachment, $image_path, $post_id);
    if (is_wp_error($image_id) || !$image_id) {
        @unlink($image_path);
        return false;
    }

    // Set Alt Text of the attachment image to the Post Title / App Title
    update_post_meta($image_id, '_wp_attachment_image_alt', $title_to_use);

    require_once ABSPATH . 'wp-admin/includes/image.php';
    $image_data = wp_generate_attachment_metadata($image_id, $image_path);
    if (!is_wp_error($image_data) && !empty($image_data)) {
        wp_update_attachment_metadata($image_id, $image_data);
    }

    return $image_id;
}