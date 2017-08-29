<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Teacher
 *
 * @package App
 *
 * @property int $id ID
 * @property string $title 名称
 * @property string $excerpt 简介
 * @property string $content 内容
 * @property int $visit_count 访问量
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 *
 * @property string $avatar 教师头像相对路径
 * @property string $email 教师邮箱
 * @property string $department 教师的学院或部门
 *
 * @property \Illuminate\Database\Eloquent\Collection $courses_relation
 *
 * @property \Illuminate\Support\Collection $courses 本教师的课程简要信息
 * @property \Illuminate\Support\Collection $simple_data 简要信息
 * @property string $avatar_url 教师头像绝对URL
 */
class Teacher extends Model
{
    use PostTrait;

    protected $appends = [
        'courses',
        'avatar_url',
    ];
    protected $simpleDataFields = [
        'id',
        'title',
        'excerpt',
        'visit_count',
    ];

    public function courses_relation()
    {
        return $this->belongsToMany(Course::class);
    }

    public function getCoursesAttribute()
    {
        return $this->courses_relation()->get()->pluck('simple_data');
    }

    public function getAvatarUrlAttribute()
    {
        return config('filesystems.admin.url') . '/' . $this->avatar;
    }
}