<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
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
 * @property string $code 课程代码
 * @property string $hours 学时
 * @property string $credit 学分
 * @property string $hours_per_week 周学时
 * @property string $teaching_model 教学模式
 * @property string $assessment_method 考核方式
 * @property string $feature 特色
 *
 * @property \Illuminate\Database\Eloquent\Collection $teachers_relation
 * @property \Illuminate\Database\Eloquent\Collection $categories_relation
 * @property \Illuminate\Database\Eloquent\Collection $downloads_relation
 *
 * @property \Illuminate\Support\Collection $teachers 本课程的教师简要信息
 * @property \Illuminate\Support\Collection $categories 本课程的课程分类简要信息
 * @property \Illuminate\Support\Collection $downloads 本课程的下载链接简要信息
 * @property \Illuminate\Support\Collection $simple_data 简要信息
 */
class Course extends Model
{
    use PostTrait;

    protected $appends = [
        'teachers',
        'categories',
        'downloads',
    ];
    protected $simpleDataFields = [
        'id',
        'title',
        'excerpt',
        'categories',
        'visit_count',
    ];

    public function teachers_relation()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function categories_relation()
    {
        return $this->belongsToMany(Category::class);
    }

    public function downloads_relation()
    {
        return $this->belongsToMany(Download::class);
    }

    public function getTeachersAttribute()
    {
        return $this->teachers_relation()->get()->pluck('simple_data');
    }

    public function getCategoriesAttribute()
    {
        return $this->categories_relation()->get()->pluck('simple_data');
    }

    public function getDownloadsAttribute()
    {
        return $this->downloads_relation()->get()->pluck('simple_data');
    }
}
