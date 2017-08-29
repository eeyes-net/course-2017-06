<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Download
 * 可供下载文件类
 *
 * @package App
 *
 * @property $id 文件ID
 * @property $title 标题
 * @property $url 链接
 * @property $visit_count 下载次数
 */
class Download extends Model
{
    use PostTrait;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $simpleDataFields = [
        'title',
        'url',
    ];
}
