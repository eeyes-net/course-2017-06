<?php

namespace App;

/**
 * Trait PostTrait
 *
 * @package App
 *
 * @property array $simpleDataFields
 *
 * @property \Illuminate\Database\Eloquent\Collection $comments_relation
 *
 * @method \Illuminate\Database\Query\Builder ordered 排序算法
 * @method \Illuminate\Database\Query\Builder paginatePluckSimpleData 简单数据分页
 * @method \Illuminate\Database\Query\Builder search(string $q) 搜索
 */
trait PostTrait
{
    public function comments_relation()
    {
        return $this->morphMany(Comment::class, 'commentable');
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
        return $query->orderBy('visit_count', 'desc');
    }

    /**
     * 简单数据分页
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return mixed
     */
    public function scopePaginatePluckSimpleData($query, $perPage = 15)
    {
        $paginator = $query->paginate($perPage);
        $paginator->setCollection($paginator->getCollection()->pluck('simple_data'));
        return $paginator;
    }

    /**
     * 搜索
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string $q 查找的文字
     *
     * @return mixed
     */
    public function scopeSearch($query, $q)
    {
        return query_search($query, $q, $this->searchFields);
    }

    public function getSimpleDataAttribute()
    {
        $result = [];
        foreach ($this->simpleDataFields as $key => $field) {
            if (is_numeric($key)) {
                $result[$field] = $this->$field;
            } else {
                $result[$key] = $this->$field;
            }
        }
        return $result;
    }

    public function getCommentCountAttribute()
    {
        return $this->comments_relation()->count();
    }

    public function getApprovedCommentCountAttribute()
    {
        return $this->comments_relation()->approved()->count();
    }
}
