<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="西安交通大学,西安交大,西交,e瞳网,e学堂,选课宝典,新生,教务处,新版培养计划,自选课,课程详情,教师详情,选修,课程考核,给分情况,考试资料,学习资料,整合资源">
    <meta name="description" content="e学堂是一个以评论社区为特色的，提供交大所有课程、授课老师介绍以及部分课程资料（包括课程ppt、学霸笔记、试题卷）的选课辅助工具">

    <title>@if (!empty($title)){{ $title }} - @endif{{ config('app.name') }} - eeyes.net</title>

    <link rel="shortcut icon" href="/images/logo/course.png">
    <link rel="stylesheet" href="/css/bulma.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
</head>
<body>

    @section('nav')
        @include('web.layouts.nav')
    @show

    @yield('banner')

    @yield('main')

    @section('footer')
        @include('web.layouts.footer')
    @show

</body>
</html>
