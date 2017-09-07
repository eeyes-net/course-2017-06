<?php

namespace App\Library\Eeyes;

class EeyesAdmin
{
    const EEYES_ADMIN_API_URL = 'https://admin.eeyes.net/api';

    /**
     * 判断某CAS用户是否具有某权限
     *
     * @param string $username 用户名(NetId)
     * @param string $permission 权限代号
     *
     * @return array ['can' => mixed, 'msg' => string]
     */
    public static function permission($username, $permission)
    {
        return json_decode(static::file_get_contents(static::EEYES_ADMIN_API_URL . '/permission/can?' . http_build_query([
                'username' => $username,
                'permission' => $permission,
            ])), true);
    }

    /**
     * 获取token对应的CAS用户名
     *
     * @param string $token 令牌
     *
     * @return array ['username' => string|null, 'msg' => string]
     */
    public static function token($token)
    {
        return json_decode(static::file_get_contents(static::EEYES_ADMIN_API_URL . '/token?' . http_build_query([
                'token' => $token,
            ])), true);
    }

    /**
     * Send GET request
     *
     * @param string $url URL
     * @param int $timeout Timeout(seconds)
     *
     * @return string Text response
     */
    protected static function file_get_contents($url, $timeout = 10)
    {
        $opts = array(
            'http' => array(
                'timeout' => $timeout,
            ),
        );
        return file_get_contents($url, false, stream_context_create($opts));
    }
}
