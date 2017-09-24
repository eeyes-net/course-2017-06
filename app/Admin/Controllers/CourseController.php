<?php

namespace App\Admin\Controllers;

use App\Category;
use App\Course;
use App\Download;
use App\Http\Controllers\Controller;
use App\Teacher;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Database\Eloquent\Builder;

class CourseController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('课程列表');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑课程信息');
            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('新建课程信息');
            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Admin::grid(Course::class, function (Grid $grid) {
            $grid->column('id', 'ID')->sortable();

            $grid->column('title', '名称')->editable()->sortable();
            $grid->column('excerpt', '简介')->editable('textarea');
            $grid->column('content', '详情')->editable('textarea');
            $grid->column('visit_count', '访问次数')->editable('text')->sortable();

            $grid->column('code', '课程代码')->editable();
            $grid->column('hours', '学时')->editable();
            $grid->column('credit', '学分')->editable();
            $grid->column('hours_per_week', '周学时')->editable();
            $grid->column('teaching_model', '教学模式')->editable('textarea');
            $grid->column('assessment_method', '考核方式')->editable('textarea');
            $grid->column('feature', '特色')->editable('textarea');

            $grid->column('approved_comment_count', '已通过评论数')->display(function () {
                $count = Course::find($this->id)->approved_comment_count;
                $url = action('\App\Admin\Controllers\CommentController@index', [
                    'commentable_type' => Course::class,
                    'commentable_id' => $this->id,
                    'approved' => '1',
                ]);
                return '<a href="' . e($url) . '">' . e($count) . '</a>';
            });
            $grid->column('comment_count', '总评论数')->display(function () {
                $count = Course::find($this->id)->comment_count;
                $url = action('\App\Admin\Controllers\CommentController@index', [
                    'commentable_type' => Course::class,
                    'commentable_id' => $this->id,
                ]);
                return '<a href="' . e($url) . '">' . e($count) . '</a>';
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();
                $filter->where(function (Builder $query) {
                    query_search($query, $this->input);
                }, '搜索');
                $filter->where(static::filterCourseCategroy(), '课程分类')
                    ->select(Category::pluck('name', 'id'));
            });
        });
    }

    protected function form()
    {
        return Admin::form(Course::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('title', '名称');
            $form->text('excerpt', '简介');
            $form->textarea('content', '详情');
            $form->number('visit_count', '访问量');

            $form->text('code', '课程代码');
            $form->text('hours', '学时');
            $form->text('credit', '学分');
            $form->text('hours_per_week', '周学时');
            $form->textarea('teaching_model', '教学模式');
            $form->textarea('assessment_method', '考核方式');
            $form->textarea('feature', '特色');

            $form->multipleSelect('teachers_relation', '教师')->options(Teacher::pluck('title', 'id'));
            $form->multipleSelect('categories_relation', '课程分类')->options(Category::pluck('name', 'id'));
            $form->multipleSelect('downloads_relation', '下载链接')->options(Download::pluck('title', 'id'));
        });
    }

    /**
     * 获取专业大类过滤器的闭包
     * 主要用于\Encore\Admin\Grid\Filter\Where::getQueryHash(CourseController::filterCourseCategroy())
     *
     * @return \Closure
     */
    public static function filterCourseCategroy()
    {
        return function ($query) {
            /** @var Category $category */
            $category = Category::find($this->input);
            $course_ids = $category->courses_relation()->get()->pluck('id');
            $query->whereIn('id', $course_ids);
        };
    }
}