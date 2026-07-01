<?php
/**
 * APKUP Private GitHub Theme Updater
 * Enables one-click updates for private repositories.
 */

if (!class_exists('APKUp_Theme_Updater')) {
    class APKUp_Theme_Updater {
        private $theme_slug;
        private $github_username;
        private $github_repo;
        private $github_token;
        private $cached_response = null;

        public function __construct($theme_slug, $github_username = '', $github_repo = '', $github_token = '') {
            $this->theme_slug      = $theme_slug;
            
            // Check for overrides defined in wp-config.php, else use constructor params
            $this->github_username = defined('APKUP_GITHUB_USER') ? APKUP_GITHUB_USER : $github_username;
            $this->github_repo     = defined('APKUP_GITHUB_REPO') ? APKUP_GITHUB_REPO : $github_repo;
            $this->github_token    = defined('APKUP_GITHUB_TOKEN') ? APKUP_GITHUB_TOKEN : $github_token;

            if (empty($this->github_username) || empty($this->github_repo)) {
                return; // Nothing to check
            }

            // Hook into transient theme update checks
            add_filter('pre_set_site_transient_update_themes', array($this, 'check_for_update'));

            // Inject authentication token during zip download
            add_filter('http_request_args', array($this, 'add_github_token_to_download'), 10, 2);

            // Correct folder naming (renames "repo-name-version-hash" to "apkup")
            add_filter('upgrader_source_selection', array($this, 'rename_github_theme_folder'), 10, 4);
        }

        /**
         * Check for update against GitHub Releases API
         */
        public function check_for_update($transient) {
            if (empty($transient->checked)) {
                return $transient;
            }

            $release_data = $this->get_latest_github_release();

            if ($release_data && isset($release_data['tag_name'])) {
                $latest_version = ltrim($release_data['tag_name'], 'v');
                $current_theme = wp_get_theme($this->theme_slug);
                $current_version = $current_theme->get('Version');

                // If newer version is available, populate transient response
                if (version_compare($current_version, $latest_version, '<')) {
                    $transient->response[$this->theme_slug] = array(
                        'theme'       => $this->theme_slug,
                        'new_version' => $latest_version,
                        'url'         => $release_data['html_url'],
                        'package'     => $release_data['zipball_url'], // Secure zipball API URL
                    );
                }
            }

            return $transient;
        }

        /**
         * Inject authentication headers to WordPress HTTP request for GitHub download URLs
         */
        public function add_github_token_to_download($args, $url) {
            if (empty($this->github_token)) {
                return $args;
            }

            // Authenticate requests destined for our private GitHub repo zipball or codeload redirect
            if (strpos($url, "api.github.com/repos/{$this->github_username}/{$this->github_repo}") !== false || 
                strpos($url, "codeload.github.com/{$this->github_username}/{$this->github_repo}") !== false) {
                
                if (!isset($args['headers'])) {
                    $args['headers'] = array();
                }

                $args['headers']['Authorization'] = 'token ' . $this->github_token;
                $args['headers']['User-Agent']    = 'WordPress/' . get_bloginfo('version') . '; ' . get_home_url();
            }

            return $args;
        }

        /**
         * Clean up directory structure after extract (renames GitHub's hashed tag folder back to correct theme slug)
         */
        public function rename_github_theme_folder($source, $remote_source, $upgrader, $hook_extra) {
            global $wp_filesystem;

            if (isset($hook_extra['theme']) && $hook_extra['theme'] === $this->theme_slug) {
                $corrected_source = trailingslashit($remote_source) . $this->theme_slug;

                if (empty($wp_filesystem)) {
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    WP_Filesystem();
                }

                if (isset($wp_filesystem) && is_object($wp_filesystem)) {
                    if ($wp_filesystem->move($source, $corrected_source, true)) {
                        return $corrected_source;
                    }
                }
            }

            return $source;
        }

        /**
         * Fetch latest release data from private/public GitHub Repo
         */
        private function get_latest_github_release() {
            if ($this->cached_response !== null) {
                return $this->cached_response;
            }

            $api_url = "https://api.github.com/repos/{$this->github_username}/{$this->github_repo}/releases/latest";
            
            $args = array(
                'timeout'    => 15,
                'user-agent' => 'WordPress/' . get_bloginfo('version') . '; ' . get_home_url(),
            );

            if (!empty($this->github_token)) {
                $args['headers'] = array(
                    'Authorization' => 'token ' . $this->github_token,
                    'Accept'        => 'application/vnd.github.v3+json',
                );
            }

            $response = wp_remote_get($api_url, $args);

            if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
                return false;
            }

            $body = wp_remote_retrieve_body($response);
            $this->cached_response = json_decode($body, true);

            return $this->cached_response;
        }
    }
}
