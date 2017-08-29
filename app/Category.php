<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * @package App
 *
 * @property int $id ID
 * @property string $name 名称
 * @property string $excerpt 简介
 * @property string $content 内容
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 *
 * @property \Illuminate\Database\Eloquent\Collection $courses_relation
 *
 * @property int $course_count 课程数量
 */
class Category extends Model
{
    use PostTrait;

    protected $searchFields = [
        'name',
        'excerpt',
        'content',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $simpleDataFields = [
        'id',
        'name',
    ];

    public function courses_relation()
    {
        return $this->belongsToMany(Course::class);
    }

    public function getCourseCountAttribute()
    {
        return $this->courses_relation()->count();
    }

    /**
     * 通过名称查找
     *
     * @param string $name
     *
     * @return \App\Category mixed
     */
    public static function findByName($name)
    {
        return static::where('name', $name)->first();
    }
}
