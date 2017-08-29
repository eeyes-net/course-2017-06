<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @package App
 *
 * @property int $id ID
 * @property string $content 内容
 * @property string $approved 是否批准
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间（无用）
 * @property int $commentable_id 关联的Commentable模型ID
 * @property string $commentable_type 关联的Commentable模型类名
 *
 * @property CommentLike $coursesRelation
 * @property \App\PostTrait $commentable
 *
 * @property int $like_count 点赞数
 * @property string $commentable_type_str 关联的Commentable模型类中文名
 *
 * @method \Illuminate\Database\Query\Builder ordered() 排序
 * @method \Illuminate\Database\Query\Builder approved() 已通过评论
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
        'like_count'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function likesRelation()
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
        return $query->latest(); // TODO
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

    public function getLikeCountAttribute()
    {
        return $this->likesRelation()->count();
    }

    public function getCommentableTypeStrAttribute()
    {
        switch ($this->commentable_type) {
            case Course::class:
                return '课程';
            case Teacher::class:
                return '教师';
            case Download::class:
                return '下载链接';
            case Category::class:
                return '课程分类';
            default:
                return class_basename($this->commentable_type);
        }

        return $this->likesRelation()->count();
    }
}
