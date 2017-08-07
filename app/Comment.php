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
 * @property Post $post 关联的Post模型
 * @property CommentLike $likes 关联的CommentLike模型
 * @property int $likes_count 点赞数
 *
 * @method \Illuminate\Database\Query\Builder ordered() 排序
 * @method \Illuminate\Database\Query\Builder approved() 已通过评论
 *
 * @package App
 */
class Comment extends Model
{
    protected $hidden = ['updated_at'];
    protected $appends = [
        'likes_count'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

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

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}
