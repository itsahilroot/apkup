<?php
/**
 * Bulk Developer Sync Admin Tool
 * Scans for posts lacking developer data and updates them using the API.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Add page under Posts
add_action('admin_menu', 'apkup_bulk_developer_menu');
function apkup_bulk_developer_menu() {
    add_submenu_page(
        'edit.php', // Parent slug
        __('Bulk Developer Sync', 'apkup'),
        __('Bulk Dev Sync', 'apkup'),
        'manage_options',
        'apkup-bulk-developer',
        'apkup_bulk_developer_page'
    );
}

// AJAX handler: Scan posts
add_action('wp_ajax_apkup_get_posts_lacking_developer', 'apkup_get_posts_lacking_developer_handler');
function apkup_get_posts_lacking_developer_handler() {
    check_ajax_referer('apkup_bulk_dev_nonce', 'nonce');
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Permission denied.');
    }

    $posts = get_posts([
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'meta_query'     => [
            'relation' => 'OR',
            [
                'key'     => 'wp_GP_ID',
                'compare' => 'EXISTS',
            ],
            [
                'key'     => 'px_app_id',
                'compare' => 'EXISTS',
            ],
        ],
        'fields'         => 'ids',
    ]);

    $lacking = [];
    foreach ($posts as $post_id) {
        // Check standard taxonomies
        $dev_terms = get_the_terms($post_id, 'developer');
        if (!empty($dev_terms) && !is_wp_error($dev_terms)) {
            continue;
        }

        $dev_terms_old = get_the_terms($post_id, 'dev');
        if (!empty($dev_terms_old) && !is_wp_error($dev_terms_old)) {
            continue;
        }

        // Check metadata
        if (!empty(get_post_meta($post_id, 'wp_developers_GP', true))) {
            continue;
        }
        if (!empty(get_post_meta($post_id, 'desarrollador', true))) {
            continue;
        }

        $di = get_post_meta($post_id, 'datos_informacion', true);
        if (is_array($di) && !empty($di['desarrollador'])) {
            continue;
        }

        // Gather Package ID
        $package = get_post_meta($post_id, 'wp_GP_ID', true);
        if (empty($package)) {
            $package = get_post_meta($post_id, 'px_app_id', true);
        }

        if (!empty($package)) {
            $lacking[] = [
                'id'      => $post_id,
                'title'   => get_the_title($post_id),
                'package' => $package,
            ];
        }
    }

    wp_send_json_success($lacking);
}

// AJAX handler: Sync developer info for a specific post
add_action('wp_ajax_apkup_bulk_sync_post_developer', 'apkup_bulk_sync_post_developer_handler');
function apkup_bulk_sync_post_developer_handler() {
    check_ajax_referer('apkup_bulk_dev_nonce', 'nonce');
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Permission denied.');
    }

    $post_id = intval($_POST['post_id'] ?? 0);
    if (!$post_id) {
        wp_send_json_error('Invalid post ID.');
    }

    $package = get_post_meta($post_id, 'wp_GP_ID', true);
    if (empty($package)) {
        $package = get_post_meta($post_id, 'px_app_id', true);
    }
    if (empty($package)) {
        wp_send_json_error('No Package ID / App ID found.');
    }

    // Extract package ID from URL if necessary
    if (strpos($package, 'play.google.com') !== false) {
        if (preg_match('/id=([a-zA-Z0-9._\-]+)/', $package, $matches)) {
            $package = $matches[1];
        }
    }

    $post_language = function_exists('at_options') ? at_options('post_language', 'es-ES') : 'es-ES';
    $api_url = 'https://peekanapp.vercel.app/api/all?androidAppId=' . urlencode($package) . '&lang=' . urlencode($post_language) . '&hl=' . urlencode($post_language);
    $response = wp_remote_get($api_url, ['timeout' => 15, 'sslverify' => true]);

    if (is_wp_error($response)) {
        wp_send_json_error($response->get_error_message());
    }

    $body = wp_remote_retrieve_body($response);
    $api_data = json_decode($body, true);

    if (empty($api_data) || empty($api_data['playstore'])) {
        wp_send_json_error('App not found or API parsing error.');
    }

    $playstore = $api_data['playstore'];
    $developer = $playstore['developer'] ?? $playstore['developerName'] ?? '';

    if (empty($developer)) {
        wp_send_json_error('No developer field found in Play Store response.');
    }

    // Save developer to post meta
    update_post_meta($post_id, 'wp_developers_GP', sanitize_text_field($developer));

    // Save/Sync to developer taxonomy
    $term = get_term_by('name', $developer, 'developer');
    $term_id = 0;
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

    wp_send_json_success([
        'developer' => $developer,
        'post_id'   => $post_id
    ]);
}

// Render Admin Page Callback
function apkup_bulk_developer_page() {
    wp_enqueue_style('common');
    ?>
    <div class="wrap" style="max-width: 1000px; margin-top: 20px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;">
        <h1 style="font-weight: 700; margin-bottom: 20px; color: #1e293b;"><?php _e('Bulk Developer Sync', 'apkup'); ?></h1>
        
        <!-- Header Controls Panel -->
        <div style="background: #ffffff; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; margin-bottom: 24px;">
            <h2 style="margin-top: 0; color: #334155; font-size: 18px; font-weight: 600;"><?php _e('Sync Controls', 'apkup'); ?></h2>
            <p style="color: #64748b; font-size: 14px; margin-bottom: 20px; line-height: 1.5;">
                <?php _e('Scan and automatically assign developers to posts that have Package IDs but lack developer names. The tool processes posts individually, logs real-time statuses, and allows you to pause and resume at any point.', 'apkup'); ?>
            </p>
            
            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <button id="scan-dev-btn" class="button button-secondary button-hero" style="font-weight: 600;"><?php _e('Scan Posts', 'apkup'); ?></button>
                <button id="start-dev-btn" class="button button-primary button-hero" style="font-weight: 600; display: none;"><?php _e('Start Sync', 'apkup'); ?></button>
                <button id="pause-dev-btn" class="button button-secondary button-hero" style="font-weight: 600; display: none; background: #fee2e2; border-color: #fecaca; color: #991b1b;"><?php _e('Pause Sync', 'apkup'); ?></button>
                <button id="resume-dev-btn" class="button button-primary button-hero" style="font-weight: 600; display: none;"><?php _e('Resume Sync', 'apkup'); ?></button>
                <button id="reset-dev-btn" class="button button-link" style="color: #64748b; text-decoration: none; font-weight: 500; display: none;" onclick="resetSyncState()"><?php _e('Clear Saved State', 'apkup'); ?></button>
            </div>

            <!-- Progress Bar -->
            <div id="progress-container" style="display: none; margin-top: 24px;">
                <div style="display: flex; justify-content: space-between; font-weight: 600; font-size: 14px; color: #475569; margin-bottom: 8px;">
                    <span id="progress-status"><?php _e('Syncing developers...', 'apkup'); ?></span>
                    <span id="progress-percent">0%</span>
                </div>
                <div style="background: #e2e8f0; border-radius: 9999px; height: 12px; overflow: hidden; width: 100%;">
                    <div id="progress-bar" style="background: #0284c7; width: 0%; height: 100%; transition: width 0.3s ease; border-radius: 9999px;"></div>
                </div>
                <div id="progress-count" style="margin-top: 8px; font-size: 13px; color: #64748b; font-weight: 500;"></div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; min-height: 400px;">
            <!-- Post Queue Panel -->
            <div style="background: #ffffff; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; display: flex; flex-direction: column; max-height: 550px;">
                <h3 style="margin-top: 0; color: #334155; font-size: 16px; font-weight: 600; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                    <?php _e('Queue / Pending Posts', 'apkup'); ?>
                    <span id="queue-badge" style="background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 9999px; font-size: 12px; margin-left: 8px;">0</span>
                </h3>
                <div id="queue-list" style="flex-grow: 1; overflow-y: auto; font-size: 13px; color: #475569;">
                    <p style="text-align: center; color: #94a3b8; padding: 40px 0; font-style: italic;"><?php _e('Click "Scan Posts" to scan the database.', 'apkup'); ?></p>
                </div>
            </div>

            <!-- Console Log Panel -->
            <div style="background: #0f172a; padding: 24px; border-radius: 12px; border: 1px solid #1e293b; color: #34d399; font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; display: flex; flex-direction: column; max-height: 550px; box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.6);">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #1e293b; padding-bottom: 12px; margin-bottom: 12px;">
                    <span style="color: #94a3b8; font-weight: 600; font-size: 14px; font-family: inherit;"><?php _e('Terminal Logs', 'apkup'); ?></span>
                    <button class="button" style="background: #1e293b; color: #e2e8f0; border-color: #334155; font-size: 11px; padding: 0 8px; height: 24px; line-height: 22px;" onclick="clearConsole()"><?php _e('Clear', 'apkup'); ?></button>
                </div>
                <div id="terminal-console" style="flex-grow: 1; overflow-y: auto; font-size: 12px; line-height: 1.6; white-space: pre-wrap; font-family: inherit;">
                    <span style="color: #64748b;">[system] Terminal initialized. Waiting for task...</span>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    // ajaxurl is already defined globally by WordPress in admin dashboard
    const bulkNonce = '<?php echo wp_create_nonce('apkup_bulk_dev_nonce'); ?>';
    
    let isProcessing = false;
    let postQueue = [];
    let processedCount = 0;
    let totalCount = 0;
    
    // Load local storage state on page load
    document.addEventListener("DOMContentLoaded", function() {
        const savedState = localStorage.getItem('apkup_bulk_dev_state');
        if (savedState) {
            try {
                const state = JSON.parse(savedState);
                if (state.queue && state.queue.length > 0) {
                    postQueue = state.queue;
                    processedCount = state.processedCount || 0;
                    totalCount = state.totalCount || postQueue.length + processedCount;
                    
                    logToConsole(`[system] Restored sync state from local storage. Lacking: ${postQueue.length} posts.`);
                    renderQueue();
                    updateProgressBar();
                    
                    document.getElementById('start-dev-btn').style.display = 'none';
                    document.getElementById('scan-dev-btn').style.display = 'inline-block';
                    document.getElementById('resume-dev-btn').style.display = 'inline-block';
                    document.getElementById('reset-dev-btn').style.display = 'inline-block';
                }
            } catch (e) {
                console.error("Failed to load saved state", e);
            }
        }
    });

    function saveState() {
        localStorage.setItem('apkup_bulk_dev_state', JSON.stringify({
            queue: postQueue,
            processedCount: processedCount,
            totalCount: totalCount
        }));
    }

    function resetSyncState() {
        localStorage.removeItem('apkup_bulk_dev_state');
        postQueue = [];
        processedCount = 0;
        totalCount = 0;
        isProcessing = false;
        
        document.getElementById('start-dev-btn').style.display = 'none';
        document.getElementById('pause-dev-btn').style.display = 'none';
        document.getElementById('resume-dev-btn').style.display = 'none';
        document.getElementById('reset-dev-btn').style.display = 'none';
        document.getElementById('scan-dev-btn').style.display = 'inline-block';
        document.getElementById('progress-container').style.display = 'none';
        
        document.getElementById('queue-badge').innerText = '0';
        document.getElementById('queue-list').innerHTML = `<p style="text-align: center; color: #94a3b8; padding: 40px 0; font-style: italic;"><?php _e('State cleared. Scan database again.', 'apkup'); ?></p>`;
        logToConsole('[system] Local storage state cleared.');
    }

    function clearConsole() {
        document.getElementById('terminal-console').innerHTML = '<span style="color: #64748b;">[system] Console cleared.</span>';
    }

    function logToConsole(message, type = 'info') {
        const consoleEl = document.getElementById('terminal-console');
        let color = '#34d399'; // green for info/success
        if (type === 'error') {
            color = '#f87171'; // red
        } else if (type === 'warn') {
            color = '#fbbf24'; // orange/yellow
        } else if (type === 'system') {
            color = '#64748b'; // gray
        }
        
        const timestamp = new Date().toLocaleTimeString();
        consoleEl.innerHTML += `\n<span style="color: #64748b;">[${timestamp}]</span> <span style="color: ${color};">${message}</span>`;
        consoleEl.scrollTop = consoleEl.scrollHeight;
    }

    function renderQueue() {
        const queueList = document.getElementById('queue-list');
        const queueBadge = document.getElementById('queue-badge');
        queueBadge.innerText = postQueue.length;
        
        if (postQueue.length === 0) {
            queueList.innerHTML = `<div style="text-align: center; color: #10b981; font-weight: 600; padding: 40px 0;">🎉 <?php _e('All posts have developer data assigned!', 'apkup'); ?></div>`;
            return;
        }
        
        let html = '<ul style="margin: 0; padding: 0; list-style: none;">';
        postQueue.forEach((post, index) => {
            html += `
                <li style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; border-bottom: 1px solid #f1f5f9; ${index === 0 ? 'background: #f0f9ff; font-weight: 600;' : ''}">
                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 200px;">${post.title}</span>
                    <span style="font-family: monospace; font-size: 11px; background: #f8fafc; border: 1px solid #e2e8f0; padding: 2px 6px; border-radius: 4px; color: #64748b;">${post.package}</span>
                </li>
            `;
        });
        html += '</ul>';
        queueList.innerHTML = html;
    }

    function updateProgressBar() {
        const container = document.getElementById('progress-container');
        const bar = document.getElementById('progress-bar');
        const percentEl = document.getElementById('progress-percent');
        const countEl = document.getElementById('progress-count');
        
        container.style.display = 'block';
        
        let percentage = 0;
        if (totalCount > 0) {
            percentage = Math.round((processedCount / totalCount) * 100);
        }
        
        bar.style.width = percentage + '%';
        percentEl.innerText = percentage + '%';
        countEl.innerText = `Processed: ${processedCount} / Total: ${totalCount}`;
    }

    // Scan posts
    jQuery('#scan-dev-btn').on('click', function() {
        const btn = jQuery(this);
        btn.prop('disabled', true).text('Scanning...');
        logToConsole('[system] Scanning database for posts lacking developer meta...');
        
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'apkup_get_posts_lacking_developer',
                nonce: bulkNonce
            },
            success: function(res) {
                btn.prop('disabled', false).text('Scan Posts');
                if (res.success) {
                    postQueue = res.data;
                    processedCount = 0;
                    totalCount = postQueue.length;
                    
                    logToConsole(`[system] Scan complete. Found ${postQueue.length} posts lacking developer.`);
                    renderQueue();
                    updateProgressBar();
                    saveState();
                    
                    if (postQueue.length > 0) {
                        document.getElementById('start-dev-btn').style.display = 'inline-block';
                        document.getElementById('reset-dev-btn').style.display = 'inline-block';
                        document.getElementById('resume-dev-btn').style.display = 'none';
                    } else {
                        document.getElementById('start-dev-btn').style.display = 'none';
                    }
                } else {
                    logToConsole(`[error] Scan failed: ${res.data}`, 'error');
                }
            },
            error: function() {
                btn.prop('disabled', false).text('Scan Posts');
                logToConsole('[error] Connection error during post scan.', 'error');
            }
        });
    });

    // Start sync
    jQuery('#start-dev-btn, #resume-dev-btn').on('click', function() {
        isProcessing = true;
        document.getElementById('scan-dev-btn').style.display = 'none';
        document.getElementById('start-dev-btn').style.display = 'none';
        document.getElementById('resume-dev-btn').style.display = 'none';
        document.getElementById('pause-dev-btn').style.display = 'inline-block';
        document.getElementById('reset-dev-btn').style.display = 'inline-block';
        
        logToConsole('[system] Sync process started...');
        processNextPost();
    });

    // Pause sync
    jQuery('#pause-dev-btn').on('click', function() {
        isProcessing = false;
        document.getElementById('pause-dev-btn').style.display = 'none';
        document.getElementById('resume-dev-btn').style.display = 'inline-block';
        document.getElementById('scan-dev-btn').style.display = 'inline-block';
        
        logToConsole('[system] Sync process paused by user.', 'warn');
        saveState();
    });

    function processNextPost() {
        if (!isProcessing) return;
        
        if (postQueue.length === 0) {
            isProcessing = false;
            logToConsole('[system] Sync completed successfully!', 'info');
            document.getElementById('pause-dev-btn').style.display = 'none';
            document.getElementById('scan-dev-btn').style.display = 'inline-block';
            document.getElementById('reset-dev-btn').style.display = 'none';
            localStorage.removeItem('apkup_bulk_dev_state');
            return;
        }
        
        const currentPost = postQueue[0];
        logToConsole(`Syncing post [ID: ${currentPost.id}] "${currentPost.title}" using Package: ${currentPost.package}...`);
        
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'apkup_bulk_sync_post_developer',
                post_id: currentPost.id,
                nonce: bulkNonce
            },
            success: function(res) {
                if (res.success) {
                    logToConsole(`Successfully synced developer "${res.data.developer}" for post ID: ${res.data.post_id}.`, 'info');
                    
                    // Remove from queue and save state
                    postQueue.shift();
                    processedCount++;
                    renderQueue();
                    updateProgressBar();
                    saveState();
                    
                    // Delay slightly to prevent spamming
                    setTimeout(processNextPost, 1000);
                } else {
                    logToConsole(`Failed for [ID: ${currentPost.id}] "${currentPost.title}": ${res.data}`, 'error');
                    handleSyncError();
                }
            },
            error: function(xhr, status, err) {
                logToConsole(`Network error for [ID: ${currentPost.id}] "${currentPost.title}": ${err || status}`, 'error');
                handleSyncError();
            }
        });
    }

    function handleSyncError() {
        isProcessing = false;
        document.getElementById('pause-dev-btn').style.display = 'none';
        document.getElementById('resume-dev-btn').style.display = 'inline-block';
        document.getElementById('scan-dev-btn').style.display = 'inline-block';
        logToConsole('[system] Sync paused due to error. Fix the issue and click Resume.', 'warn');
        saveState();
    }
    </script>
    <?php
}
