<?php
class APKT_APKPure
{
    public function get_google_play_app_id($url)
    {
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return '';
        }

        $parts = wp_parse_url($url);

        if (empty($parts['query'])) {
            return '';
        }

        parse_str($parts['query'], $query_params);

        return isset($query_params['id']) ? sanitize_text_field($query_params['id']) : '';
    }
    public function extract($url)
    {
        $app_id = $this->get_google_play_app_id($url);

        if (empty($app_id)) {
            return [];
        }

        $apkpure_url = "https://apkpure.net/en/$app_id";
        $scraper = new Scraper();
        $get_html_response = $scraper->scrape($apkpure_url);

        if ($get_html_response['status'] !== 'success') {
            return [];
        }

        $html = new simple_html_dom();
        $html->load($get_html_response['data']['content']);

        $data = [
            'version' => '',
            'category' => '',
            'subcategory' => '',
            'android_os' => '',
            'file_size' => '',
            'developer_name' => '',
            'google_play' => '',
            'whats_new' => '',
        ];

        // Extract primary apk-info details
        foreach ($html->find('.apk-info .info') as $info) {
            $titleElement = $info->find('.title', 0);
            $valueElement = $info->find('.additional-info', 0);

            if (!$titleElement || !$valueElement) {
                continue;
            }

            $label = strtolower(trim($titleElement->plaintext));
            $value = trim($valueElement->plaintext);

            switch ($label) {
                case 'latest version':
                    $data['version'] = $value;
                    break;
                case 'category':
                    $data['category'] = $value;
                    break;
                case 'android os':
                    $data['android_os'] = preg_replace('/[^0-9\.]/', '', $value);
                    break;
                case 'file size':
                    $data['file_size'] = $value;
                    break;
                case 'developer':
                    $data['developer_name'] = $value;
                    break;
                case 'available on':
                    $linkElement = $info->find('a', 0);
                    if ($linkElement) {
                        $googlePlayUrl = html_entity_decode($linkElement->href);
                        $googlePlayUrlParts = parse_url($googlePlayUrl);

                        if (!empty($googlePlayUrlParts['query'])) {
                            parse_str($googlePlayUrlParts['query'], $queryParams);
                            $cleanQuery = isset($queryParams['id']) ? 'id=' . urlencode($queryParams['id']) : '';
                            $googlePlayUrl = $googlePlayUrlParts['scheme'] . '://' . $googlePlayUrlParts['host'] . $googlePlayUrlParts['path'] . '?' . $cleanQuery;
                        }

                        $data['google_play'] = esc_url_raw($googlePlayUrl);
                    }
                    break;
            }
        }

        // Extract Whats New content
        $whatsNewElement = $html->find('.whats-new-content', 0);
        if ($whatsNewElement) {
            $data['whats_new'] = trim($whatsNewElement->plaintext);
        }

        // Fallback extraction from alternative .apk-info-item
        if (empty($data['file_size']) || empty($data['android_os']) || empty($data['developer_name'])) {
            foreach ($html->find('.apk-info-item li') as $li) {
                $desc = strtolower(trim($li->getAttribute('data-dt-desc')));
                $headText = trim($li->find('p.head', 0)->plaintext ?? '');

                if (empty($data['file_size']) && $desc === 'filesize') {
                    $data['file_size'] = $headText;
                } elseif (empty($data['android_os']) && $desc === 'androidos') {
                    $data['android_os'] = preg_replace('/[^0-9\.]/', '', $headText);
                }
            }
        }

        // Breadcrumb extraction
        $breadcrumbs = $html->find('nav.breadcrumbs a.item.link');
        if (count($breadcrumbs) >= 3) {
            $data['category'] = trim($breadcrumbs[1]->plaintext);
            $data['subcategory'] = trim($breadcrumbs[2]->plaintext);
        }

        // Fallback using JSON-LD Schema
        foreach ($html->find('script[type="application/ld+json"]') as $script) {
            $json = json_decode($script->innertext, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
                foreach ($json as $entry) {
                    if (isset($entry['@type']) && $entry['@type'] === 'MobileApplication') {
                        if (empty($data['developer_name']) && !empty($entry['publisher']['name'])) {
                            $data['developer_name'] = $entry['publisher']['name'];
                        }
                        if (empty($data['file_size']) && isset($entry['offers']['price'])) {
                            // Not ideal fallback but placeholder logic if needed
                        }
                        if (empty($data['category'])) {
                            $data['category'] = $entry['applicationCategory'] ?? $data['category'];
                        }
                        if (empty($data['subcategory'])) {
                            $data['subcategory'] = $entry['applicationSubCategory'] ?? $data['subcategory'];
                        }
                    }
                }
            }
        }

        return $data;
    }

}