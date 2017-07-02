<?php

namespace App\Admin\Controllers;

use App\Category;
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
            $content->header('专业大类');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑专业大类');
            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('创建专业大类');
            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Admin::grid(Category::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->column('name', '专业大类名称')->sortable()->editable();
            $grid->column('excerpt', '专业大类简介')->editable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                /** @var Category $category */
                $category = $actions->row;
                $actions->append('<a href="' . e(action('\App\Admin\Controllers\CourseController@index', [Grid\Filter\Where::getQueryHash(CourseController::filterCourseCategroy()) => $category->id])) . '"><i class="fa fa-bookmark"></i></a>');
            });
        });
    }

    protected function form()
    {
        return Admin::form(Category::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('name', '专业大类名称');
            $form->text('excerpt', '专业大类简介');
            $form->textarea('content', '专业大类详情');
        });
    }
}
