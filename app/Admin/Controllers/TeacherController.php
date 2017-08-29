<?php

namespace App\Admin\Controllers;

use App\Course;
use App\Http\Controllers\Controller;
use App\Teacher;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Database\Query\Builder;

class TeacherController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('教师列表');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑教师信息');
            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('新建教师信息');
            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Admin::grid(Teacher::class, function (Grid $grid) {
            $grid->column('id', 'ID')->sortable();

            $grid->column('title', '姓名')->editable()->sortable();
            $grid->column('excerpt', '简介')->editable('textarea');
            $grid->column('content', '详情')->editable('textarea');
            $grid->column('visit_count', '访问次数')->editable('text')->sortable();

            $grid->column('avatar', '头像')->image();
            $grid->column('email', '邮箱')->editable();
            $grid->column('department', '学院')->editable();

            $grid->column('approved_comment_count', '已通过评论数')->display(function () {
                $count = Teacher::find($this->id)->approved_comment_count;
                $url = action('\App\Admin\Controllers\CommentController@index', [
                    'commentable_type' => Teacher::class,
                    'commentable_id' => $this->id,
                    'approved' => '1',
                ]);
                return '<a href="' . e($url) . '">' . e($count) . '</a>';
            });
            $grid->column('comment_count', '总评论数')->display(function () {
                $count = Teacher::find($this->id)->comment_count;
                $url = action('\App\Admin\Controllers\CommentController@index', [
                    'commentable_type' => Teacher::class,
                    'commentable_id' => $this->id,
                ]);
                return '<a href="' . e($url) . '">' . e($count) . '</a>';
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();
                $filter->where(function (Builder $query) {
                    query_search($query, $this->input);
                }, '搜索');
            });
        });
    }

    protected function form()
    {
        return Admin::form(Teacher::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('title', '名称');
            $form->text('excerpt', '简介');
            $form->textarea('content', '详情');
            $form->number('visit_count', '访问量');

            $form->image('avatar', '头像');
            $form->text('email', '邮箱');
            $form->text('department', '学院');

            $form->multipleSelect('courses_relation', '课程')->options(Course::pluck('title', 'id'));
        });
    }
}
