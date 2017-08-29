<?php

namespace App\Admin\Controllers;

use App\Course;
use App\Http\Controllers\Controller;
use App\Teacher;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('仪表盘');
            $content->row(function ($row) {
                $row->column(3, new InfoBox('用户数', 'users', 'aqua', '/admin/user', '0'));
                $row->column(3, new InfoBox('教师数', 'user', 'green', '/admin/teacher', Teacher::count()));
                $row->column(3, new InfoBox('课程数', 'book', 'yellow', '/admin/course', Course::count()));
                $row->column(3, new InfoBox('访问量', 'eye', 'red', '', Teacher::sum('visit_count') + Course::sum('visit_count')));
            });
        });
    }
}
