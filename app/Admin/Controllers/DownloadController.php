<?php

namespace App\Admin\Controllers;

use App\Download;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class DownloadController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('下载链接');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑下载链接');
            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('创建下载链接');
            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Admin::grid(Download::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->column('title', '文件名称')->sortable()->editable();
            $grid->column('url', '下载链接')->sortable()->editable();
            $grid->column('visit_count', '下载次数')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();
                $filter->where(function (Builder $query) {
                    $query->where('title', 'like', "%{$this->input}%")
                        ->orWhere('url', 'like', "%{$this->input}%");
                }, '搜索');
            });
        });
    }

    protected function form()
    {
        return Admin::form(Download::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('title', '文件名称');
            $form->text('url', '下载链接');
            $form->number('visit_count', '下载量');
        });
    }
}
