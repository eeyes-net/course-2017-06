<?php

namespace App\Admin\Controllers;

use App\Category;
use App\Post;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
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
        return Admin::grid(Post::class, function (Grid $grid) {
            $grid->model()->ofType('course');

            $grid->id('ID')->sortable();
            $grid->column('title', '课程姓名')->sortable()->editable();
            $grid->column('excerpt', '课程简介')->editable();
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
                $filter->where(static::filterCourseCategroy(), '专业大类')
                    ->select(Category::all()->pluck('name', 'id'));
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
            $form->text('title', '课程姓名');
            $form->text('excerpt', '课程简介');
            $form->textarea('content', '课程详情');
            $form->number('visit_count', '访问量');
            $form->multipleSelect('categories', '专业大类')->options(Category::all()->pluck('name', 'id'));
            $form->embeds('metas', '其他信息', function (Form\EmbeddedForm $form) {
                $form->text('credit', '学分')->default(function (Form $form) {
                    /** @var Post $post */
                    $post = $form->model();
                    return $post->getMeta('credit', '');
                });
            });
            $form->saving(function (Form $form) {
                /** @var Post $post */
                $post = $form->model();
                $post->setMeta('credit', $form->input('metas.credit') ?: '');
                $form->input('metas', []); // 清空metas信息，阻止Laravel-Admin更新关联表
            });
        });
    }

    /**
     * 获取专业大类过滤器的闭包
     * 主要用于\Encore\Admin\Grid\Filter\Where::getQueryHash(CourseController::filterCourseCategroy())
     *
     * @return \Closure
     */
    public static function filterCourseCategroy() {
        return function ($query) {
            /** @var Category $category */
            $category = Category::find($this->input);
            $post_ids = $category->courses()->get()->pluck('id');
            $query->whereIn('id', $post_ids);
        };
    }
}
