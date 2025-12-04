<?php
class Scraper
{
    private $user_agents = [
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 14_2_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Safari/605.1.15',
        'Mozilla/5.0 (Linux; Android 13; SM-G998B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.5845.187 Mobile Safari/537.36',
        'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/119.0',
        'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.5 Mobile/15E148 Safari/604.1'
    ];

    public function scrape($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'status' => 'error',
                'data' => [
                    'http_code' => 0,
                    'content' => null,
                    'message' => "Invalid URL provided",
                ]
            ];
        }

        $curl = curl_init();
        $ref_domain = parse_url($url, PHP_URL_SCHEME) ? $url : 'http://' . $url;
        $user_agent = $this->user_agents[array_rand($this->user_agents)];

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language: en-US,en;q=0.5',
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
                'Cache-Control: no-cache',
            ],
            CURLOPT_USERAGENT => $user_agent,
            CURLOPT_REFERER => $ref_domain,
            CURLOPT_ENCODING => 'gzip, deflate, br',
            CURLOPT_TIMEOUT => 15,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_DNS_CACHE_TIMEOUT => 7200, // Cache DNS for 2 hours
            CURLOPT_TCP_FASTOPEN => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_FAILONERROR => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2TLS, // Prefer HTTP/2 for faster connections
            CURLOPT_TCP_NODELAY => true, // Disable Nagle's algorithm for faster data transfer
        ]);

        $data = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($curl);
        $curl_errno = curl_errno($curl);
        curl_close($curl);

        if ($curl_errno || $http_code >= 400) {
            return [
                'status' => 'error',
                'data' => [
                    'http_code' => $http_code,
                    'content' => $data,
                    'message' => $curl_error ?: "HTTP error code: $http_code",
                ]
            ];
        }

        return [
            'status' => 'success',
            'data' => [
                'http_code' => $http_code,
                'content' => $data,
                'message' => '',
            ]
        ];
    }
}