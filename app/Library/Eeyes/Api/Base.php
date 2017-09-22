<?php

namespace App\Library\Eeyes\Api;

class Base
{
    public static function getApiUrl($url)
    {
        if (substr($url, 0, 1) === '/') {
            $eeyes_api_url = env('EEYES_API_URL');
            if (!$eeyes_api_url) {
                throw new \Exception('EEYES_API_URL must be set.');
            }
            $url = $eeyes_api_url . $url;
        }
        return $url;
    }

    public static function getApiToken()
    {
        $eeyes_api_token = env('EEYES_API_TOKEN');
        if (!$eeyes_api_token) {
            throw new \Exception('EEYES_API_TOKEN should be set.');
        }
        return $eeyes_api_token;
    }

    /**
     * Send GET request
     *
     * @param string $url URL
     * @param int $timeout Timeout(seconds)
     *
     * @return string Text response
     * @throws \Exception
     */
    protected static function file_get_contents($url, $timeout = 10)
    {
        $opts = [
            'http' => [
                'timeout' => $timeout,
                'header' => "User-Agent: EeyesApiLibrary/1.0\r\n",
            ],
        ];
        return file_get_contents(static::getApiUrl($url), false, stream_context_create($opts));
    }

    /**
     * Send GET or POST request with CURL
     *
     * @param string $url URL
     *
     * @return string Text response
     * @throws \Exception
     */
    public static function curl($url, $postfields = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, static::getApiUrl($url));
        if (substr($url, 0, 8) === 'https://' && env('APP_DEBUG')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        if (!is_null($postfields)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfields));
            curl_setopt($ch, CURLOPT_POST, true);
        }
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);
        if (false === $content) {
            throw new \Exception('CURL return false. Infomation: ' . curl_getinfo($ch));
        }
        return $content;
    }
}