<?php

namespace App\Library\Eeyes\Api;

class Permission extends Base
{
    /**
     * 判断某CAS用户是否具有某权限
     *
     * @param string $username 用户名(NetId)
     * @param string $permission 权限代号
     *
     * @return array|null ['can' => mixed, 'msg' => string]
     * @throws \Exception
     */
    public static function username($username, $permission)
    {
        $response = json_decode(static::file_get_contents('/eeyes/permission/username?' . http_build_query([
                'username' => $username,
                'permission' => $permission,
            ])), true);
        if ($response['code'] === 200) {
            return $response['data'];
        } else {
            return [
                'can' => false,
                'msg' => 'Unknown error',
            ];
        }
    }

    /**
     * 判断某令牌是否具有某权限
     *
     * @param string $token 令牌
     * @param string $permission 权限代号
     *
     * @return array|null ['can' => mixed, 'msg' => string]
     * @throws \Exception
     */
    public static function token($token, $permission)
    {
        $response = json_decode(static::file_get_contents('/eeyes/permission/token?' . http_build_query([
                'token' => $token,
                'permission' => $permission,
            ])), true);
        if ($response['code'] === 200) {
            return $response['data'];
        } else {
            return [
                'can' => false,
                'msg' => 'Unknown error',
            ];
        }
    }
}
