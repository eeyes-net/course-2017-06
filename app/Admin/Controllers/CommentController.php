<?php

namespace App\Admin\Controllers;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Post;
use App\PostTypeException;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
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
            $grid->model()->latest();

            $grid->id('ID')->sortable();
            $grid->column('post_title', '评论文章')->display(function () {
                $post = Post::find($this->post_id);
                $title = $post->title;
                switch ($post->type) {
                    case 'teacher':
                        return '<a href="' . action('\App\Admin\Controllers\TeacherController@edit', ['id' => $post->id]) . '">' . e($title) . '</a>';
                        break;
                    case 'course':
                        return '<a href="' . action('\App\Admin\Controllers\CourseController@edit', ['id' => $post->id]) . '">' . e($title) . '</a>';
                        break;
                    default:
                        throw new PostTypeException();
                }
            });
            $grid->column('content', '评论内容')->editable('textarea');
            $grid->column('approved', '审核情况')->switch([
                'on' => ['text' => '已审核'],
                'off' => ['text' => '未审核'],
            ]);

            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->is('post_id', '文章')->select(Post::all()->pluck('title', 'id'));
            });
        });
    }

    protected function form()
    {
        return Admin::form(Comment::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->select('post_id', '评论文章')->options(function ($id) {
                $post = Post::find($id);
                if ($post) {
                    return [$post->id => $post->title];
                }
            })->ajax(action('\App\Admin\Controllers\Api\PostController@index'));
            $form->textarea('content', '评论内容');
            $form->switch('approved', '审核情况')->states([
                'on' => ['text' => '已审核'],
                'off' => ['text' => '未审核'],
            ]);
        });
    }
}
