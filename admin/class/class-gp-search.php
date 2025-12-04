<?php

class AT_GP_Search
{
    function __construct()
    {
    }

    private function validate_gplay_url($gplay_url)
    {
        if (empty($gplay_url) || !strpos($gplay_url, 'play.google.com')) {
            return false;
        }
        return true;
    }

    private function single_map_data($script_data, $mapping_values)
    {
        $mapped_data = [];
        foreach ($mapping_values as $key => $mapping) {
            if (is_array($mapping)) {
                if (isset($mapping['fun'])) {
                    $value = $this->extract_path_value($script_data, $mapping['path']);
                    $mapped_data[$key] = $mapping['fun']($value);
                } else {
                    $mapped_data[$key] = $this->extract_path_value($script_data, $mapping);
                }
            }
        }
        return $mapped_data;
    }

    private function multiple_map_data($script_data, $mapping_values)
    {
        $mapped_data = [];
        foreach ($script_data as $item) {
            $mapped_item = [];
            foreach ($mapping_values as $key => $mapping) {
                if (is_array($mapping)) {
                    if (isset($mapping['fun'])) {
                        $value = $this->extract_path_value($item, $mapping['path']);
                        $mapped_item[$key] = $mapping['fun']($value);
                    } else {
                        $mapped_item[$key] = $this->extract_path_value($item, $mapping);
                    }
                }
            }
            $mapped_data[] = $mapped_item;
        }
        return $mapped_data;
    }

    public function search_single_map_data($script_data, $mapping_values)
    {
        $mapped_data = [];
        foreach ($script_data as $item) {
            $mapped_item = [];
            foreach ($mapping_values as $key => $mapping) {
                if (is_array($mapping)) {
                    if (isset($mapping['fun'])) {
                        $value = $this->extract_path_value($item, $mapping['path']);
                        $mapped_item[$key] = $mapping['fun']($value);
                    } else {
                        $mapped_item[$key] = $this->extract_path_value($item, $mapping);
                    }
                }
            }
            $mapped_data[] = $mapped_item;
        }
        return $mapped_data;
    }

    private function extract_path_value($script_data, $mapping_path)
    {
        $current_data = $script_data;
        foreach ($mapping_path as $key) {
            if (isset($current_data[$key])) {
                $current_data = $current_data[$key];
            } else {
                return null;
            }
        }
        return $current_data;
    }

    private function search_mappings($index)
    {
        if ($index === 23) {

            $search_mappings = [
                'apk_name' => [0, 3],
                'apk_id' => [0, 0, 0],
                'apk_url' => [
                    'path' => [0, 10, 4, 2],
                    'fun' => function ($path) {
                        $url = rtrim($this->base_url, '/') . '/' . ltrim($path, '/');
                        return $url;
                    },
                ],
                'apk_thumbnail' => [
                    'path' => [0, 1, 3, 2],
                    'fun' => function ($thumbnail) {
                        return $thumbnail . '=w96-rw';
                    },
                ],
                'apk_banner' => [0, 101, 1, 0, 3, 2],
                'apk_developer' => [0, 14],
                'apk_currency' => [0, 8, 1, 0, 1],
                'apk_price' => [
                    'path' => [0, 8, 1, 0, 0],
                    'fun' => function ($price) {
                        return $price / 1000000;
                    },
                ],
                'apk_is_free' => [
                    'path' => [0, 8, 1, 0, 0],
                    'fun' => function ($price) {
                        return $price === 0;
                    },
                ],
                'apk_description' => [0, 13, 1],
                'apk_downloads' => [0, 15],
                'apk_rating_text' => [0, 4, 0],
                'apk_rating' => [0, 4, 1],
            ];

            return $search_mappings;

        } elseif ($index === 24) {

            $search_mappings_1 = [
                'apk_name' => [16, 2, 0, 0],
                'apk_id' => [16, 11, 0, 0],
                'apk_url' => [
                    'path' => [17, 0, 0, 4, 2],
                    'fun' => function ($path) {
                        $url = rtrim('https://play.google.com/', '/') . '/' . ltrim($path, '/');
                        return $url;
                    },
                ],
                'apk_thumbnail' => [
                    'path' => [16, 2, 95, 0, 3, 2],
                    'fun' => function ($thumbnail) {
                        return $thumbnail . '=w96-rw';
                    },
                ],
                'apk_banner' => [16, 2, 96, 0, 3, 2],
                'apk_developer' => [16, 2, 68, 0],
                'apk_currency' => [17, 0, 2, 0, 1, 0, 1],
                'apk_price' => [
                    'path' => [17, 0, 2, 0, 1, 0, 0],
                    'fun' => function ($price) {
                        return $price / 1000000;
                    },
                ],
                'apk_is_free' => [
                    'path' => [17, 0, 2, 0, 1, 0, 0],
                    'fun' => function ($price) {
                        return $price === 0;
                    },
                ],
                'apk_description' => [16, 2, 73, 0, 1],
                'apk_downloads' => [16, 2, 13, 0],
                'apk_rating_text' => [16, 2, 51, 0, 0],
                'apk_rating' => [16, 2, 51, 0, 1],
            ];

            $search_mappings_2 = [
                'apk_name' => [0, 3],
                'apk_id' => [0, 0, 0],
                'apk_url' => [
                    'path' => [0, 10, 4, 2],
                    'fun' => function ($path) {
                        $url = rtrim('https://play.google.com/', '/') . '/' . ltrim($path, '/');
                        return $url;
                    },
                ],
                'apk_thumbnail' => [
                    'path' => [0, 1, 3, 2],
                    'fun' => function ($thumbnail) {
                        return $thumbnail . '=w96-rw';
                    },
                ],
                'apk_banner' => [0, 22, 3, 2],
                'apk_developer' => [0, 14],
                'apk_currency' => [0, 8, 1, 0, 1],
                'apk_price' => [
                    'path' => [0, 8, 1, 0, 0],
                    'fun' => function ($price) {
                        return $price / 1000000;
                    },
                ],
                'apk_is_free' => [
                    'path' => [0, 8, 1, 0, 0],
                    'fun' => function ($price) {
                        return $price === 0;
                    },
                ],
                'apk_description' => [0, 13, 1],
                'apk_downloads' => [0, 15],
                'apk_rating_text' => [0, 4, 0],
                'apk_rating' => [0, 4, 1],
            ];

            $search_mappings[] = $search_mappings_1;
            $search_mappings[] = $search_mappings_2;

            return $search_mappings;

        } elseif ($index === 26) {

            $search_mappings = [
                'no_results' => [0, 0, 1],
                'no_results_description' => [1, 0, 1],
            ];

            return $search_mappings;

        }
    }

    private function get_search_data($url)
    {
        $gp_search_html = '';
        $response = [
            'status' => '',
            'data' => '',
        ];

        $scraper = new Scraper();
        $scraper_response = $scraper->scrape($url);

        if ($scraper_response['status'] === 'success') {
            $gp_search_html = $scraper_response['data']['content'];

            $html = new simple_html_dom();
            $html->load($gp_search_html);

            $scripts = $html->find('script');

            if ($scripts) {

                foreach ($scripts as $script) {

                    if (strpos($script->innertext, "key: 'ds:4'") !== false) {

                        $search_script = $script->innertext;

                        $start_pos = strpos($search_script, "data:[[");

                        if ($start_pos !== false) {

                            $start_pos += strlen("data:");

                            $end_pos = strpos($search_script, ", sideChannel: {}}", $start_pos);

                            if ($end_pos !== false) {
                                $length = $end_pos - $start_pos;

                                $search_data = substr($search_script, $start_pos, $length);

                                $search_data = substr($search_data, 1, -1);

                                $search_data = json_decode("[$search_data]", true);

                                $search_data_length = count($search_data[0][1][0]);

                                if ($search_data_length === 23) {

                                    $search_data = $this->search_single_map_data($search_data[0][1][0][22][0], $this->search_mappings(23));

                                    $response['status'] = 'success';
                                    $response['data'] = $search_data;

                                } elseif ($search_data_length === 24) {
                                    $search_mappings = $this->search_mappings(24);

                                    $searched_data_1 = [$this->single_map_data($search_data[0][1][0][23], $search_mappings[0])];
                                    $searched_data_2 = $this->multiple_map_data($search_data[0][1][1][22][0], $search_mappings[1]);

                                    $search_data = array_merge($searched_data_1, $searched_data_2);

                                    $response['status'] = 'success';
                                    $response['data'] = $search_data;

                                } elseif ($search_data_length === 26) {

                                    $search_data = $this->single_map_data($search_data[0][1][0][25][0], $this->search_mappings(26));

                                    $response['status'] = 'error';
                                    $response['data'] = [
                                        'message' => 'No results found :(',
                                    ];

                                } else {

                                    $response['status'] = 'error';
                                    $response['data'] = [
                                        'message' => 'Requested data not found in script data.',
                                    ];

                                }

                            } else {

                                $response['status'] = 'error';
                                $response['data'] = [
                                    'message' => 'Data found but sideChannel not found in script.',
                                ];

                            }

                        } else {

                            $response['status'] = 'error';
                            $response['data'] = [
                                'message' => 'Script not found in play store.',
                            ];

                        }

                    }

                }

            } else {

                $response['status'] = 'error';
                $response['data'] = [
                    'message' => 'No one script files not available in play store!',
                ];

            }
        } else {
            $response['status'] = 'error';
                $response['data'] = [
                    'message' => $scraper_response['data']['message'],
                ];
        }

        return $response;
    }

    public function get_search_results($gp_search_url)
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

        $gp_url_validation = $this->validate_gplay_url($gp_search_url);

        if ($gp_url_validation === false) {
            $response = [
                'status' => 'error',
                'data' => [
                    'message' => 'Please enter a valid Google Play Store URL!',
                ],
            ];

            return $response;
        }

        return $this->get_search_data($gp_search_url);
    }

}