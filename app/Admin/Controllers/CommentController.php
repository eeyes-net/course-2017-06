<?php

namespace App\Admin\Controllers;

use App\Category;
use App\Course;
use App\Download;
use App\Http\Controllers\Controller;
use App\Teacher;
use Carbon\Carbon;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Layout\Content;

class CommentController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('所有评论');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑评论');
            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('新建评论');
            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Admin::grid(Comment::class, function (Grid $grid) {
            $grid->disableCreation();

            $grid->id('ID')->sortable();

            $grid->column('commentable_type_str', '文章类型')->display(function () {
                return e(Comment::find($this->id)->commentable_type_str);
            });
            $grid->column('commentable_title', '文章标题')->display(function () {
                $commentable = Comment::find($this->id)->commentable;
                return e($commentable->title);
            });
            $grid->column('content', '评论内容')->editable('textarea');
            $grid->column('approved', '审核情况')->switch([
                'on' => ['text' => '已审核'],
                'off' => ['text' => '未审核'],
            ]);
            $grid->column('like_count', '点赞数')->display(function () {
                $comment = Comment::find($this->id);
                return e($comment->like_count);
            });
            $grid->column('created_at', '评论时间')->display(function () {
                $carbon = new Carbon($this->created_at);
                return e($carbon->diffForHumans());
            })->sortable();

            $grid->filter(function (Filter $filter) {
                $filter->disableIdFilter();
                $filter->is('commentable_type', '文章类型')->select([
                    Course::class => '课程',
                    Teacher::class => '教师',
                    Download::class => '下载链接',
                    Category::class => '课程分类',
                ]);
                $filter->is('commentable_id', '文章id');
                $filter->is('approved', '审核情况')->select([
                    '1' => '已通过',
                ]);
            });
        });
    }

    protected function form()
    {
        return Admin::form(Comment::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->textarea('content', '评论内容');
            $form->switch('approved', '审核情况')->states([
                'on' => ['value' => '1', 'text' => '已审核'],
                'off' => ['value' => '', 'text' => '未审核'],
            ]);
            $form->display('created_at', '评论时间');
        });
    }
}

class Comment extends \App\Comment
{
    protected $hidden = [];
}