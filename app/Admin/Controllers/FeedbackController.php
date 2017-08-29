<?php

namespace App\Admin\Controllers;

use App\Feedback;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class FeedbackController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('所有反馈');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑反馈');
            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('新建反馈');
            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Admin::grid(Feedback::class, function (Grid $grid) {
            $grid->column('id', 'ID')->sortable();

            $grid->column('content', '反馈内容');
            $grid->column('created_at', '评论时间')->display(function () {
                $carbon = new Carbon($this->created_at);
                return e($carbon->diffForHumans());
            })->sortable();
        });
    }

    protected function form()
    {
        return Admin::form(Feedback::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->textarea('content', '反馈内容');
        });
    }
}
