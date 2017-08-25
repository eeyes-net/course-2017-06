<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Teacher
 *
 * @package App
 *
 * @property int $id ID
 * @property string $title 文章标题
 * @property string $excerpt 文章简介
 * @property string $content 文章内容
 * @property int $visit_count 访问量
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 *
 * @property string $avatar 教师头像相对路径
 * @property string $email 教师邮箱
 * @property string $department 教师的学院或部门
 *
 * @property \Illuminate\Support\Collection $courses
 * @property \Illuminate\Support\Collection $simple_data
 */
class Teacher extends Model
{
    use PostTrait;

    protected $appends = [
        'courses'
    ];
    protected $simpleDataFields = [
        'id',
        'title',
        'excerpt',
        'visit_count',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function getCoursesAttribute()
    {
        return $this->courses()->get()->pluck('simple_data');
    }
}