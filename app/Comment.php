<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @property int $id ID
 * @property string $content 内容
 * @property string $approved 是否批准
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间（无用）
 * @property int $commentable_id 关联的Commentable模型ID
 * @property string $commentable_type 关联的Commentable模型类名
 *
 * @property \App\PostTrait $commentable 关联的Commentable模型
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
    protected $hidden = [
        'approved',
        'updated_at',
        'commentable_id',
        'commentable_type',
    ];
    protected $appends = [
        'likes_count'
    ];

    public function commentable()
    {
        return $this->morphTo();
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
