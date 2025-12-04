<?php
class AT_Create_GP_Post
{
    private $is_advanced_options = false;

    private $apk_description;
    private $apk_whats_new;
    private $apk_name;
    private $apk_developer;
    private $apk_size;
    private $apk_version;
    private $apk_id;
    private $apk_rating;
    private $apk_votes;
    private $apk_screenshots;
    private $apk_thumbnail_url;
    private $apk_banner_url;
    private $apk_installs;
    private $apk_category;
    private $apk_sub_category;
    private $apk_content;
    private $apt_id = "";

    private $post_id;
    private $parent_cat;
    private $child_cat;

    private $post_status = 'draft';
    private $post_start_title = '';
    private $post_end_title = '';
    private $post_mod_feature = '';
    private $post_thumbnail_format = 'png';
    private $post_thumbnail_quality = 'raw';
    private $import_screenshots = false;
    private $post_screenshots_format = 'jpg';

    public function __construct($post_meta)
    {
        $default_meta = [
            'apk_description' => '',
            'apk_whats_new' => '',
            'apk_name' => '',
            'apk_developer' => '',
            'apk_size' => '',
            'apk_version' => '',
            'apk_id' => '',
            'apk_rating_text' => '',
            'apk_total_votes' => '',
            'apk_screenshots' => [],
            'apk_thumbnail' => '',
            'apk_banner' => '',
            'apk_category' => '',
            'apk_sub_category' => '',
            'apk_content' => '',
            'apk_installs' => '',
            'apt_id' => '',
        ];

        $data = array_merge($default_meta, $post_meta['data']);

        $this->apk_description = $data['apk_description'];
        $this->apk_whats_new = $data['apk_whats_new'];
        $this->apk_name = $data['apk_name'];
        $this->apk_developer = $data['apk_developer'];
        $this->apk_size = $data['apk_size'];
        $this->apk_version = $data['apk_version'];
        $this->apk_id = $data['apk_id'];
        $this->apk_rating = $data['apk_rating_text'];
        $this->apk_votes = $data['apk_total_votes'];
        $this->apk_screenshots = $data['apk_screenshots'];
        $this->apk_thumbnail_url = $data['apk_thumbnail'];
        $this->apk_banner_url = $data['apk_banner'];
        $this->apk_category = $data['apk_category'];
        $this->apk_sub_category = $data['apk_sub_category'];
        $this->apk_content = $data['apk_content'];
        $this->apk_installs = $data['apk_installs'];
        $this->apt_id = $data['apt_id'];

        $this->is_advanced_options = at_options('is_advanced_options', false);

        if ($this->is_advanced_options) {
            $post_status = at_options('post_status');
            $post_start_title = at_options('post_title_start');
            $post_end_title = at_options('post_title_end');
            $post_mod_feature = at_options('mod_feature');
            $post_thumbnail_format = at_options('post_thumbnail_format');
            $post_thumbnail_quality = at_options('post_thumbnail_quality');
            $import_screenshots = at_options('import_screenshots', false);
            $post_screenshots_format = at_options('post_screenshots_format');

            $this->post_status = !empty($post_status) ? $post_status : '';
            $this->post_start_title = !empty($post_start_title) ? $post_start_title : '';
            $this->post_end_title = !empty($post_end_title) ? $post_end_title : '';
            $this->post_mod_feature = !empty($post_mod_feature) ? $post_mod_feature : '';
            $this->post_thumbnail_format = !empty($post_thumbnail_format) ? $post_thumbnail_format : '';
            $this->post_thumbnail_quality = !empty($post_thumbnail_quality) ? $post_thumbnail_quality : '';
            $this->import_screenshots = $import_screenshots ? $import_screenshots : false;
            $this->post_screenshots_format = $post_screenshots_format ? $post_screenshots_format : 'jpg';
        }
    }

    private function generate_post_title()
    {
        $start_title = "";
        $end_title = "";
        $mod_feature_title = "";
        $is_mod_title = at_options('is_mod_title', false);
        $is_title_version = at_options('is_title_version', false);
        $is_mod_feature_title = at_options('is_mod_feature_title', false);

        if ($this->is_advanced_options) {
            $start_title = (!empty($this->post_start_title)) ? $this->post_start_title . ' ' : '';
            $end_title = (!empty($this->post_end_title)) ? $this->post_end_title : '';
            $mod_feature_title = ($is_mod_feature_title && !empty($this->post_mod_feature)) ? '(' . $this->post_mod_feature . ') ' : '';
        }

        $main_title = $this->apk_name . ' ';

        $mod_title = ($is_mod_title) ? 'MOD APK' . ' ' : '';

        $title_version = $this->apk_version;
        $version_title = ($is_title_version && !empty($title_version)) ? 'v' . $title_version . ' ' : '';

        $post_title = $start_title . $main_title . $mod_title . $mod_feature_title . $version_title . $end_title;

        return $post_title;
    }

    private function get_category()
    {
        $categories = [
            'parent_id' => null,
            'child_id' => null,
        ];

        $parent_cat_name = get_parsed_category($this->apk_category);
        $child_cat_name = $this->apk_sub_category;

        $parent_cat_slug = sanitize_title_with_dashes(apktemplates_clean($parent_cat_name));
        $child_cat_slug = sanitize_title_with_dashes(apktemplates_clean($child_cat_name));

        $parent_category = get_term_by("slug", $parent_cat_slug, "category");

        if ($parent_category) {
            $categories['parent_id'] = $parent_category->term_id;
        } else {
            $parent_id = wp_insert_term($parent_cat_name, "category", ['slug' => $parent_cat_slug]);

            if (!is_wp_error($parent_id)) {
                $categories['parent_id'] = $parent_id["term_id"];
            }
        }

        $child_category = get_term_by("slug", $child_cat_slug, "category");

        if ($child_category) {
            $categories['child_id'] = $child_category->term_id;
        } else {
            $child_id = wp_insert_term($child_cat_name, "category", ["parent" => $categories['parent_id'], "slug" => $child_cat_slug]);

            if (!is_wp_error($child_id)) {
                $categories['child_id'] = $child_id["term_id"];
            }
        }

        return $categories;
    }

    private function add_meta_data()
    {
        $datos_informacion = [];
        $datos_informacion['descripcion'] = $this->apk_description;
        $datos_informacion['novedades'] = $this->apk_whats_new;
        $datos_informacion['version'] = $this->apk_version;
        $datos_informacion['requerimientos'] = '5.0';
        $datos_informacion['consiguelo'] = 'https://play.google.com/store/apps/details?id=' . $this->apk_id;
        $datos_informacion['descargas'] = $this->apk_installs;
        $datos_informacion['os'] = 'ANDROID';
        $datos_informacion['categoria_app'] = $this->apk_category ?? '';
        add_post_meta($this->post_id, "wp_GP_ID", $this->apk_id);
        add_post_meta($this->post_id, "app_type", "0");

        add_post_meta($this->post_id, "datos_informacion", $datos_informacion);

        if ($this->is_advanced_options && !empty($this->post_mod_feature)) {
            add_post_meta($this->post_id, "wp_mods", $this->post_mod_feature);
        }

        add_post_meta($this->post_id, "new_rating_average", floatval($this->apk_rating));
        add_post_meta($this->post_id, "new_rating_users", intval($this->apk_votes));
    }

    private function upload_image_to_wp($image_url, $format = null, $name = 'thumbnail')
    {
        try {
            if (empty($image_url)) {
                return null;
            }

            $upload_dir = wp_upload_dir();
            if (!isset($upload_dir['path'], $upload_dir['url'])) {
                return null;
            }

            $scraper = new Scraper();
            $fetch_image = $scraper->scrape($image_url);

            if (!is_array($fetch_image) || $fetch_image['status'] !== 'success' || empty($fetch_image['data']['content'])) {
                return null;
            }

            $image_content = $fetch_image['data']['content'];

            $original_format = null;
            if (!empty($fetch_image['data']['headers']['content-type'])) {
                $mime = $fetch_image['data']['headers']['content-type'];
                $ext  = wp_check_filetype_from_ext($mime);
                if (!empty($ext['ext'])) {
                    $original_format = $ext['ext'];
                }
            }

            $final_format = $format ?: ($original_format ?: 'jpg');

            $image_name      = sanitize_title_with_dashes(apktemplates_clean($this->apk_name));
            $unique_suffix   = substr(time() . mt_rand(1000, 9999), -8);;
            $image_full_name = "{$image_name}-{$name}-{$unique_suffix}.{$final_format}";
            $image_path      = trailingslashit($upload_dir['path']) . $image_full_name;

            if (file_put_contents($image_path, $image_content) === false) {
                return null;
            }

            $file_type = wp_check_filetype(basename($image_full_name), null);

            if (empty($file_type['type']) && $original_format) {
                @unlink($image_path);
                $image_full_name = "{$image_name}-{$name}-{$unique_suffix}.{$original_format}";
                $image_path      = trailingslashit($upload_dir['path']) . $image_full_name;

                if (file_put_contents($image_path, $image_content) === false) {
                    return null;
                }

                $file_type = wp_check_filetype(basename($image_full_name), null);

                if (empty($file_type['type'])) {
                    @unlink($image_path);
                    return null;
                }
            }

            $image_attachment = [
                'post_mime_type' => $file_type['type'],
                'post_title'     => $image_name,
                'post_content'   => '',
                'post_status'    => 'inherit',
            ];

            $image_id = wp_insert_attachment($image_attachment, $image_path);
            if (is_wp_error($image_id) || !$image_id) {
                @unlink($image_path);
                return null;
            }

            require_once ABSPATH . 'wp-admin/includes/image.php';
            $image_data = wp_generate_attachment_metadata($image_id, $image_path);

            if (is_wp_error($image_data) || empty($image_data)) {
                wp_delete_attachment($image_id, true);
                return null;
            }

            wp_update_attachment_metadata($image_id, $image_data);

            return $image_id;
        } catch (Exception $e) {
            return null;
        }
    }

    private function upload_thumbnail()
    {
        $image_size = '';
        $image_quality = '';

        if ($this->is_advanced_options) {
            if ($this->post_thumbnail_format === 'webp') {
                $image_quality = ($this->post_thumbnail_quality === 'raw') ? '=rw' : '-rw';
            }

            switch ($this->post_thumbnail_quality) {
                case '512':
                    $image_size = '=s512';
                    break;
                case '256':
                    $image_size = '=s256';
                    break;
                case '128':
                    $image_size = '=s128';
                    break;
            };
        }

        $thumbnail_id = $this->upload_image_to_wp($this->apk_thumbnail_url . $image_size . $image_quality, $this->post_thumbnail_format);

        if ($thumbnail_id) {
            set_post_thumbnail($this->post_id, $thumbnail_id);
        }
    }

private function upload_banner_image()
{
    if (empty($this->apk_banner_url)) {
        return;
    }

    // --- Fetch Original Image ---
    $scraper = new Scraper();
    $fetch = $scraper->scrape($this->apk_banner_url);

    if (!is_array($fetch) || $fetch['status'] !== 'success' || empty($fetch['data']['content'])) {
        return;
    }

    $image_data = $fetch['data']['content'];

    // --- Create image resource ---
    $src_img = @imagecreatefromstring($image_data);
    if (!$src_img) return;

    // Desired final size
    $final_w = 312;
    $final_h = 192;

    // --- Resize / Crop ---
    $dst_img = imagecreatetruecolor($final_w, $final_h);

    // Better quality
    imagealphablending($dst_img, true);
    imagesavealpha($dst_img, true);

    $src_w = imagesx($src_img);
    $src_h = imagesy($src_img);

    // Maintain center crop
    $ratio_src = $src_w / $src_h;
    $ratio_dst = $final_w / $final_h;

    if ($ratio_src > $ratio_dst) {
        // crop width
        $new_height = $src_h;
        $new_width = intval($src_h * $ratio_dst);
        $crop_x = intval(($src_w - $new_width) / 2);
        $crop_y = 0;
    } else {
        // crop height
        $new_width = $src_w;
        $new_height = intval($src_w / $ratio_dst);
        $crop_x = 0;
        $crop_y = intval(($src_h - $new_height) / 2);
    }

    imagecopyresampled(
        $dst_img,
        $src_img,
        0, 0,
        $crop_x, $crop_y,
        $final_w, $final_h,
        $new_width, $new_height
    );

    // --- Save as WebP ---
    $upload = wp_upload_dir();
    $file_name = sanitize_title_with_dashes($this->apk_name) . "-banner.webp";
    $file_path = $upload['path'] . '/' . $file_name;

    // WebP compression: 70–80 is ideal (small + good quality)
    imagewebp($dst_img, $file_path, 80);

    imagedestroy($src_img);
    imagedestroy($dst_img);

    // --- Register as Attachment ---
    $attachment = [
        'post_mime_type' => 'image/webp',
        'post_title' => sanitize_title_with_dashes($this->apk_name),
        'post_content' => '',
        'post_status' => 'inherit'
    ];

    $attach_id = wp_insert_attachment($attachment, $file_path);

    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
    wp_update_attachment_metadata($attach_id, $attach_data);

    // Save meta URL
    $banner_url = wp_get_attachment_url($attach_id);
    add_post_meta($this->post_id, "wp_poster_GP", $banner_url);
}


    private function add_screenshots_meta()
    {
        $urls = [];
        $get_screenshots = $this->apk_screenshots;
        $image_quality = '';

        if ($this->post_screenshots_format === 'webp') {
            $image_quality = '=rw';
        }

        if ($this->is_advanced_options && $this->import_screenshots) {
            for ($i = 0; $i < count($get_screenshots); $i++) {
                if (!empty($get_screenshots[$i])) {
                    $ss_name = 'screenshot-' . ($i + 1);
                    $ss_id = $this->upload_image_to_wp(
                        esc_url($get_screenshots[$i]) . $image_quality,
                        $this->post_screenshots_format,
                        $ss_name
                    );

                    if ($ss_id) {
                        $urls[] = esc_url(wp_get_attachment_url($ss_id));
                    } else {
                        $urls[] = esc_url($get_screenshots[$i] . $image_quality);
                    }
                }
            }
        } else {
            for ($i = 0; $i < count($get_screenshots); $i++) {
                if (!empty($get_screenshots[$i])) {
                    $urls[] = esc_url($get_screenshots[$i] . $image_quality);
                }
            }
        }

        if (!empty($urls)) {
            update_post_meta($this->post_id, "datos_imagenes", $urls);
        } else {
            delete_post_meta($this->post_id, "datos_imagenes");
        }
    }

    private function add_download_meta()
    {
        $download_info = [];
        $mod_feature = '';

        if ($this->is_advanced_options && !empty($this->post_mod_feature)) {
            $mod_feature = $this->post_mod_feature;
        }

        $download_info_data = [
            'download_name' => 'APK',
            'download_version' => $this->apk_version,
            'download_mod_info' => $mod_feature,
            'download_size' => $this->apk_size,
            'download_url' => 'https://play.google.com/store/apps/details?id=' . $this->apk_id,
        ];

        array_push($download_info, $download_info_data);

        update_post_meta($this->post_id, "repeatable_download_link", $download_info);
    }

    public function create_post()
    {
        /* $lic = new AT_License();

        if (!$lic->is_valid_license()) {
            $response = [
                'status' => 'error',
                'data' => [
                    'message' => __('License Key is invalid or expired.', 'apktemplates'),
                ],
            ];

            return $response;
        } */

        $post_permalink = sanitize_title_with_dashes(apktemplates_clean($this->apk_name));

        $category = $this->get_category();
        $post_content = wp_encode_emoji($this->apk_content);

        $new_post = [
            "post_title" => $this->generate_post_title(),
            "post_name" => $post_permalink,
            "post_content" => $post_content,
            "post_status" => $this->post_status,
            "post_category" => [$category['parent_id'], $category['child_id']],
            "post_type" => "post",
        ];

        $post_id = wp_insert_post($new_post);

        $this->post_id = $post_id;

        $this->add_meta_data();

        $this->upload_thumbnail();

        $this->upload_banner_image();

        $this->add_screenshots_meta();

        //$this->add_download_meta();

        $response = [
            'status' => 'success',
            'data' => [
                'message' => '<strong><a href="' . get_edit_post_link($this->post_id) . '" target="_blank">' . $this->apk_name . '</a></strong> post uploaded.',
            ],
        ];

        return $response;
    }
}