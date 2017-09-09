<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiLog
 *
 * @package App
 *
 * @property $id ID
 * @property $path 路径
 * @property $method HTTP方法
 * @property $ip IP
 * @property $user_agent User Agent
 * @property $query Query string
 * @property $body POST body
 */
class ApiLog extends Model
{
    //
}
