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

    public function courses()
    {
        return $this->belongsToMany(Course::class);
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
