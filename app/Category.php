<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * @package App
 *
 * @property array $courses
 */
class Category extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function courses()
    {
        return $this->belongsToMany(Post::class, 'category_course', 'category_id', 'course_id');
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

    /**
     * 获取简略信息
     *
     * @return array
     * @throws PostTypeException
     */
    public function getSimpleDataAttribute()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'excerpt' => $this->excerpt,
        ];
    }
}
