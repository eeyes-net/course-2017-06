<?php

namespace App\Admin\Controllers;

use App\Course;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class CategoryController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('课程分类');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑课程分类');
            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('创建课程分类');
            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Admin::grid(Category::class, function (Grid $grid) {
            $grid->column('id', 'ID')->sortable();

            $grid->column('name', '名称')->editable()->sortable();
            $grid->column('excerpt', '简介')->editable('textarea');
            $grid->column('content', '详情')->editable('textarea');

            $grid->column('course_count', '课程数')->display(function () {
                $count = Category::find($this->id)->course_count;
                $url = action('\App\Admin\Controllers\CourseController@index', [
                    Grid\Filter\Where::getQueryHash(CourseController::filterCourseCategroy()) => $this->id
                ]);
                return '<a href="' . e($url) . '">' . e($count) . '</a>';
            });
        });
    }

    protected function form()
    {
        return Admin::form(Category::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('name', '名称');
            $form->text('excerpt', '简介');
            $form->textarea('content', '详情');

            $form->multipleSelect('courses_relation', '课程')->options(Course::pluck('title', 'id'));
        });
    }
}

class Category extends \App\Category
{
    protected $hidden = [];
    protected $with = [];
}
