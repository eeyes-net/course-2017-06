<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Post;
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
        return Admin::grid(Post::class, function (Grid $grid) {
            $grid->model()->ofType('teacher');

            $grid->id('ID')->sortable();
            $grid->column('title', '教师姓名')->sortable()->editable();
            $grid->column('excerpt', '教师简介')->editable();
            $grid->column('visit_count', '访问量')->sortable();
            $grid->column('approved_comment_count', '已通过评论数')->display(function () {
                $post = Post::find($this->id);
                return $post->comments()->approved()->count();
            });
            $grid->column('comment_count', '总评论数')->display(function () {
                $post = Post::find($this->id);
                return $post->comments()->count();
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();
                $filter->where(function (Builder $query) {
                    $query->where('title', 'like', "%{$this->input}%")
                        ->orWhere('excerpt', 'like', "%{$this->input}%")
                        ->orWhere('content', 'like', "%{$this->input}%");
                }, '搜索');
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                /** @var Post $post */
                $post = $actions->row;
                $actions->append('<a href="' . e(action('\App\Admin\Controllers\CommentController@index', ['post_id' => $post->id])) . '"><i class="fa fa-comment"></i></a>');
            });
        });
    }

    protected function form()
    {
        return Admin::form(Post::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('title', '教师姓名');
            $form->text('excerpt', '教师简介');
            $form->textarea('content', '教师详情');
            $form->number('visit_count', '访问量');
            $form->image('avatar', '头像');
            $form->text('department', '学院/部门');
            $form->text('email', '邮箱');
            $form->multipleSelect('courses', '课程')->options(Post::ofType('course')->get()->pluck('title', 'id'));
        });
    }
}
