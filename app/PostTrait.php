<?php

namespace App;

/**
 * Trait PostTrait
 *
 * @package App
 *
 * @property array $simpleDataFields
 *
 * @property \Illuminate\Database\Eloquent\Collection $comments
 *
 * @method \Illuminate\Database\Query\Builder ordered 排序算法
 * @method \Illuminate\Database\Query\Builder paginatePluckSimpleData 简单数据分页
 * @method \Illuminate\Database\Query\Builder search(string $q) 搜索
 */
trait PostTrait
{
    public function comments()
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
        $q = sql_filter($q);
        if (empty($q)) {
            return $query->whereRaw('FALSE');
        }
        // replace '你好世界' with '%你%好%世%界%';
        $q = '%' . preg_replace('/./u', '$0%', $q);
        if (!isset($this->searchFields)) {
            $this->searchFields = [
                'title',
                'excerpt',
                'content',
            ];
        }
        foreach ($this->searchFields as $field) {
            $query->orWhere($field, 'like', $q);
        }
        return $query;
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

    /**
     * Convert the model instance to an array.
     * Override
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributesToArray() + $this->relationsToArray();
    }
}
