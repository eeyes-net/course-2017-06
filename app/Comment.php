<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @property int $id
 * @property string $post_id post表的外键
 * @property string $content 内容
 * @property string $approved 是否批准
 *
 * @method \Illuminate\Database\Query\Builder ordered() 排序
 * @method \Illuminate\Database\Query\Builder approved() 已通过评论
 *
 * @package App
 */
class Comment extends Model
{
    protected $hidden = ['approved', 'updated_at'];

    /**
     * 排序算法
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query; // TODO
    }

    /**
     * 已通过评论
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return mixed
     */
    public function scopeApproved($query)
    {
        return $query->where('approved', '1');
    }
}
