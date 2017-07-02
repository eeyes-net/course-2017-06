<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="西安交通大学,西安交大,e瞳网,选课宝典,新生,教务处,新版培养计划,自选课,课程详情,教师详情,选修,课程考核,给分情况,考试资料,学习资料,整合资源">
        <meta name="description" content="选课宝典是一个以评论社区为特色的，提供交大所有课程、授课老师介绍以及部分课程资料（包括课程ppt、学霸笔记、试题卷）的选课辅助工具">

        <title>选课宝典 - eeyes.net</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    选课宝典
                </div>

                <div class="links">
                    <a href="/docs/">Documentation</a>
                    <a href="/admin/">Administration</a>
                    <a href="https://github.com/eeyes-net/course-2017-06">Fork me on GitHub</a>
                    <a href="https://www.eeyes.net">&copy;eeyes.net</a>
                </div>
            </div>
        </div>
    </body>
</html>
