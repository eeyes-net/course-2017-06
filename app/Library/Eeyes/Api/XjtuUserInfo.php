<?php

namespace App\Library\Eeyes\Api;

class XjtuUserInfo extends Base
{
    public static function getByNetId($net_id)
    {
        $response = json_decode(static::file_get_contents('/xjtu/user/info?' . http_build_query([
                'net_id' => $net_id,
                'token' => static::getApiToken(),
            ])), true);
        if ($response['code'] === 200) {
            return $response['data'];
        } else {
            return null;
        }
    }
}