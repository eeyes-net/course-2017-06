<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
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
 * @property string $code 课程代码
 * @property string $hours 学时
 * @property string $credit 学分
 * @property string $hours_per_week 周学时
 * @property string $teaching_model 教学模式
 * @property string $assessment_method 考核方式
 * @property string $feature 特色
 *
 * @property \Illuminate\Support\Collection $teachers
 * @property \Illuminate\Support\Collection $categories
 * @property \Illuminate\Support\Collection $downloads
 * @property \Illuminate\Support\Collection $simple_data
 */
class Course extends Model
{
    use PostTrait;

    protected $with = [
        'categories',
    ];
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

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function downloads()
    {
        return $this->belongsToMany(Download::class);
    }

    public function getTeachersAttribute()
    {
        return $this->teachers()->get()->pluck('simple_data');
    }

    public function getCategoriesAttribute()
    {
        return $this->categories()->get()->pluck('simple_data');
    }

    public function getDownloadsAttribute()
    {
        return $this->downloads()->get()->pluck('simple_data');
    }
}