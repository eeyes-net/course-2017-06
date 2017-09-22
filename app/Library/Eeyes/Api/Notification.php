<?php

namespace App\Library\Eeyes\Api;


class Notification extends Base
{
    public static function dingTalk($content)
    {
        $response = json_decode(static::curl('/eeyes/notification/ding_talk?' . http_build_query([
                'token' => static::getApiToken(),
            ]), [
            'content' => $content,
        ]), true);
        if ($response['code'] === 200) {
            return true;
        } else {
            return false;
        }
    }
}