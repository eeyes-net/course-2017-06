<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Post;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Chart\Bar;
use Encore\Admin\Widgets\Chart\Doughnut;
use Encore\Admin\Widgets\Chart\Line;
use Encore\Admin\Widgets\Chart\Pie;
use Encore\Admin\Widgets\Chart\PolarArea;
use Encore\Admin\Widgets\Chart\Radar;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('仪表盘');
            $content->row(function ($row) {
                $row->column(3, new InfoBox('用户数', 'users', 'aqua', '/admin/users', '0'));
                $row->column(3, new InfoBox('教师数', 'user', 'green', '/admin/teachers', Post::ofType('teacher')->count()));
                $row->column(3, new InfoBox('课程数', 'book', 'yellow', '/admin/courses',Post::ofType('course')->count()));
                $row->column(3, new InfoBox('访问量', 'eye', 'red', '', Post::sum('visit_count')));
            });
        });
    }
}
