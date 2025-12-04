<?php
function apkt_gp_importer()
{
    $is_advanced_options = at_options('is_advanced_options', false);
    $post_status = at_options('post_status', 'draft');
    $post_title_start = at_options('post_title_start');
    $post_title_end = at_options('post_title_end');
    $mod_feature = at_options('mod_feature');
    $post_thumbnail_format = at_options('post_thumbnail_format', 'png');
    $post_thumbnail_quality = at_options('post_thumbnail_quality', 'large');
    $import_screenshots = at_options('import_screenshots', false);
    $post_screenshots_format = at_options('post_screenshots_format', 'jpg');
    $post_language = at_options('post_language', 'en-US');
    ?>
    <div id="at-importer">
        <div class="at-container">
            <!-- Header Section -->
            <div class="at-header">
                <h1>
                    <svg xmlns="http://www.w3.org/2000/svg" class="at-header-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Google Play Importer
                </h1>
                <p>Import apps and games directly from Google Play Store</p>
            </div>

            <div class="at-card">
                <!-- Main Importer Form -->
                <div class="at-card-body">
                    <form method="POST" id="at-gp-importer-form">
                        <div class="at-form-group">
                            <label for="at-gp-url" class="at-label">Google Play URL</label>
                            <div class="at-input-group">
                                <div class="at-input-wrapper">
                                    <div class="at-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                    </div>
                                    <input type="url" name="at_gp_url" id="at-gp-url" 
                                        class="at-input" 
                                        placeholder="https://play.google.com/store/apps/details?id=com.example.app" required />
                                </div>
                                <button type="submit" class="at-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Import Content
                                </button>
                            </div>
                        </div>

                        <!-- Results / Log Area -->
                        <div class="at-results at-importer-results">
                            <h3 class="at-log-title">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 1rem; width: 1rem; margin-right: 0.5rem; color: #3b82f6;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Import Log
                            </h3>
                            <ul class="process-log at-log-list" style="display: none"></ul>
                            <ul class="process-error-log at-log-list at-log-error" style="display: none"></ul>
                        </div>

                        <!-- Advanced Options Toggle -->
                        <div class="at-advanced-toggle">
                            <div class="at-toggle-header" id="at-advanced-toggle-btn">
                                <div class="at-toggle-info">
                                    <div class="at-toggle-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.5rem; width: 1.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="at-toggle-text">
                                        <h3>Advanced Options</h3>
                                        <p>Configure post status, language, and more</p>
                                    </div>
                                </div>
                                <div>
                                     <label class="at-switch">
                                        <input type="checkbox" name="at_advanced_options" id="at_advanced_options" <?php checked($is_advanced_options);?>>
                                        <span class="at-switch-bg"></span>
                                        <span class="at-switch-dot"></span>
                                    </label>
                                </div>
                            </div>

                            <div id="advanced-options-container" class="at-advanced-options <?php if ($is_advanced_options) { echo 'active'; } ?>">
                                <div class="at-warning">
                                    <div class="at-warning-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="at-warning-text">
                                        Enabling advanced options may increase import time due to screenshot and APK processing.
                                    </div>
                                </div>

                                <div class="at-grid">
                                    <!-- Post Status -->
                                    <div>
                                        <label class="at-label"><?php esc_html_e('Post status', 'apktemplates');?></label>
                                        <select name="at_post_status" class="at-select">
                                            <option value="draft" <?php selected($post_status, 'draft'); ?>>Draft</option>
                                            <option value="publish" <?php selected($post_status, 'publish'); ?>>Publish</option>
                                        </select>
                                    </div>

                                    <!-- Post Title Start -->
                                    <div>
                                        <label class="at-label"><?php esc_html_e('Post title starting text', 'apktemplates');?></label>
                                        <input type="text" name="at_post_title_start" class="at-select"
                                            value="<?php echo esc_attr($post_title_start); ?>"
                                            placeholder="Eg. [Start text] Spotify MOD APK" />
                                    </div>

                                    <!-- Post Title End -->
                                    <div>
                                        <label class="at-label"><?php esc_html_e('Post title ending text', 'apktemplates');?></label>
                                        <input type="text" name="at_post_title_end" class="at-select"
                                            value="<?php echo esc_attr($post_title_end); ?>"
                                            placeholder="Eg. Spotify MOD APK [End text]" />
                                    </div>

                                    <!-- MOD Feature -->
                                    <div>
                                        <label class="at-label"><?php esc_html_e('MOD Feature', 'apktemplates');?></label>
                                        <input type="text" name="at_mod_feature" class="at-select"
                                            value="<?php echo esc_attr($mod_feature); ?>"
                                            placeholder="Eg. Premium Unlocked">
                                    </div>

                                    <!-- Thumbnail Format -->
                                    <div>
                                        <label class="at-label"><?php esc_html_e('Thumbnail format', 'apktemplates');?></label>
                                        <select name="at_post_thumbnail_format" class="at-select">
                                            <option value="png" <?php selected($post_thumbnail_format, 'png'); ?>>PNG (.png)</option>
                                            <option value="webp" <?php selected($post_thumbnail_format, 'webp'); ?>>WEBP (.webp)</option>
                                        </select>
                                    </div>

                                    <!-- Thumbnail Quality -->
                                    <div>
                                        <label class="at-label"><?php esc_html_e('Thumbnail quality', 'apktemplates');?></label>
                                        <select name="at_post_thumbnail_quality" class="at-select">
                                            <option value="raw" <?php selected($post_thumbnail_quality, 'raw'); ?>>Original</option>
                                            <option value="512" <?php selected($post_thumbnail_quality, '512'); ?>>Large (512x512)</option>
                                            <option value="256" <?php selected($post_thumbnail_quality, '256'); ?>>Medium (256x256)</option>
                                            <option value="128" <?php selected($post_thumbnail_quality, '128'); ?>>Small (128x128) Recommended</option>
                                        </select>
                                    </div>

                                    <!-- Import Screenshots -->
                                    <div class="at-checkbox-wrapper">
                                        <span class="at-label" style="margin-bottom: 0;"><?php esc_html_e('Import Screenshots', 'apktemplates');?></span>
                                        <label class="at-switch">
                                            <input type="checkbox" name="at_import_screenshots" id="at_import_screenshots" <?php checked($import_screenshots);?>>
                                            <span class="at-switch-bg"></span>
                                            <span class="at-switch-dot"></span>
                                        </label>
                                    </div>

                                    <!-- Screenshots Format -->
                                    <div>
                                        <label class="at-label"><?php esc_html_e('Screenshots format', 'apktemplates');?></label>
                                        <select name="at_post_screenshots_format" class="at-select">
                                            <option value="jpg" <?php selected($post_screenshots_format, 'jpg'); ?>>JPEG (.jpg)</option>
                                            <option value="webp" <?php selected($post_screenshots_format, 'webp'); ?>>WEBP (.webp)</option>
                                        </select>
                                    </div>

                                    <!-- Post Language -->
                                    <div>
                                        <label class="at-label"><?php esc_html_e('Post language', 'apktemplates');?></label>
                                        <select name="at_post_language" class="at-select">
                                             <option value="en-GB" <?php selected($post_language, 'en-GB');?>>English (UK)</option>
                                            <option value="en-US" <?php selected($post_language, 'en-US');?>>English (US)</option>
                                            <option value="es-419" <?php selected($post_language, 'es-419');?>>Spanish (Latin America)</option>
                                            <option value="es-ES" <?php selected($post_language, 'es-ES');?>>Spanish (Spain)</option>
                                            <option value="af" <?php selected($post_language, 'af');?>>Afrikaans</option>
                                            <option value="am" <?php selected($post_language, 'am');?>>Amharic</option>
                                            <option value="bg" <?php selected($post_language, 'bg');?>>Bulgarian</option>
                                            <option value="ca" <?php selected($post_language, 'ca');?>>Catalan</option>
                                            <option value="zh-HK" <?php selected($post_language, 'zh-HK');?>>Chinese (Hong Kong)</option>
                                            <option value="zh-CN" <?php selected($post_language, 'zh-CN');?>>Chinese (PRC)</option>
                                            <option value="zh-TW" <?php selected($post_language, 'zh-TW');?>>Chinese (Taiwan)</option>
                                            <option value="hr" <?php selected($post_language, 'hr');?>>Croatian</option>
                                            <option value="cs" <?php selected($post_language, 'cs');?>>Czech</option>
                                            <option value="da" <?php selected($post_language, 'da');?>>Danish</option>
                                            <option value="nl" <?php selected($post_language, 'nl');?>>Dutch</option>
                                            <option value="et" <?php selected($post_language, 'et');?>>Estonian</option>
                                            <option value="fil" <?php selected($post_language, 'fil');?>>Filipino</option>
                                            <option value="fi" <?php selected($post_language, 'fi');?>>Finnish</option>
                                            <option value="fr-CA" <?php selected($post_language, 'fr-CA');?>>French (Canada)</option>
                                            <option value="fr-FR" <?php selected($post_language, 'fr-FR');?>>French (France)</option>
                                            <option value="de" <?php selected($post_language, 'de');?>>German</option>
                                            <option value="el" <?php selected($post_language, 'el');?>>Greek</option>
                                            <option value="he" <?php selected($post_language, 'he');?>>Hebrew</option>
                                            <option value="hi" <?php selected($post_language, 'hi');?>>Hindi</option>
                                            <option value="hu" <?php selected($post_language, 'hu');?>>Hungarian</option>
                                            <option value="is" <?php selected($post_language, 'is');?>>Icelandic</option>
                                            <option value="id" <?php selected($post_language, 'id');?>>Indonesian</option>
                                            <option value="it" <?php selected($post_language, 'it');?>>Italian</option>
                                            <option value="ja" <?php selected($post_language, 'ja');?>>Japanese</option>
                                            <option value="ko" <?php selected($post_language, 'ko');?>>Korean</option>
                                            <option value="lv" <?php selected($post_language, 'lv');?>>Latvian</option>
                                            <option value="lt" <?php selected($post_language, 'lt');?>>Lithuanian</option>
                                            <option value="ms" <?php selected($post_language, 'ms');?>>Malay</option>
                                            <option value="no" <?php selected($post_language, 'no');?>>Norwegian</option>
                                            <option value="pl" <?php selected($post_language, 'pl');?>>Polish</option>
                                            <option value="pt-BR" <?php selected($post_language, 'pt-BR');?>>Portuguese (Brazil)</option>
                                            <option value="pt-PT" <?php selected($post_language, 'pt-PT');?>>Portuguese (Portugal)</option>
                                            <option value="ro" <?php selected($post_language, 'ro');?>>Romanian</option>
                                            <option value="ru" <?php selected($post_language, 'ru');?>>Russian</option>
                                            <option value="sr" <?php selected($post_language, 'sr');?>>Serbian</option>
                                            <option value="sk" <?php selected($post_language, 'sk');?>>Slovak</option>
                                            <option value="sl" <?php selected($post_language, 'sl');?>>Slovenian</option>
                                            <option value="sw" <?php selected($post_language, 'sw');?>>Swahili</option>
                                            <option value="sv" <?php selected($post_language, 'sv');?>>Swedish</option>
                                            <option value="th" <?php selected($post_language, 'th');?>>Thai</option>
                                            <option value="tr" <?php selected($post_language, 'tr');?>>Turkish</option>
                                            <option value="uk" <?php selected($post_language, 'uk');?>>Ukrainian</option>
                                            <option value="vi" <?php selected($post_language, 'vi');?>>Vietnamese</option>
                                            <option value="zu" <?php selected($post_language, 'zu');?>>Zulu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Section -->
            <div class="at-card">
                <div class="at-card-body">
                    <div class="at-search-header">
                        <h2>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search Games & Apps
                        </h2>
                    </div>
                    
                    <div class="at-input-group">
                        <div class="at-input-wrapper">
                            <div class="at-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="at-gp-search-query" 
                                class="at-input" 
                                placeholder="E.g. Spotify, Minecraft, etc." required />
                        </div>
                        <button id="at-gp-search-submit" class="at-btn at-btn-dark">
                            Search
                        </button>
                    </div>

                    <div id="at-gp-results" style="margin-top: 1.5rem;">
                        <div class="at-apk-results-container">
                            <div class="at-no-results">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <p style="margin-top: 0.5rem; font-weight: 500; color: #1f2937;">No results yet</p>
                                <p style="font-size: 0.875rem;">Search for your favorite games and apps to get started.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer/Credits -->
            <div class="at-footer">
                <p>&copy; <?php echo date('Y'); ?> APKTemplates. All rights reserved.</p>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('at-advanced-toggle-btn');
        const container = document.getElementById('advanced-options-container');
        const checkbox = document.getElementById('at_advanced_options');

        if (toggleBtn && container && checkbox) {
            toggleBtn.addEventListener('click', function(e) {
                // If the click was NOT on the checkbox or label (which triggers checkbox), toggle the checkbox
                if (e.target !== checkbox && e.target.tagName !== 'LABEL' && !e.target.closest('.at-switch')) {
                    checkbox.checked = !checkbox.checked;
                }
                
                // Sync visibility with checkbox state
                if (checkbox.checked) {
                    container.classList.add('active');
                } else {
                    container.classList.remove('active');
                }
            });

            // Also listen for direct checkbox changes (e.g. keyboard nav)
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    container.classList.add('active');
                } else {
                    container.classList.remove('active');
                }
            });
        }
    });
    </script>
<?php
}