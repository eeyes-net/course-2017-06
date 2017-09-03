@extends('web.layouts.master')

@section('main')
    <section class="hero is-medium has-text-centered">
        <div class="hero-body">
            <div class="container">
                <h1 class="title is-spaced">
                    <img src="/images/logo/course.png" alt="选课宝典logo" width="240" height="240">
                </h1>
                <h1 class="title is-spaced">
                    {{ config('app.name') }}
                </h1>
                <h2 class="subtitle">
                    一个以评论社区为特色的，提供交大所有课程、授课老师介绍以及部分课程资料（包括课程ppt、学霸笔记、试题卷）的选课辅助工具
                </h2>
                <div class="columns">
                    <div class="column is-offset-3 is-6">
                        <form action="/s" method="GET">
                            <div class="field is-grouped">
                                <div class="control has-icons-left is-expanded">
                                    <input type="search" name="q" class="input is-flat required email" placeholder="输入关键词...（例如：高数）" aria-required="true">
                                    <span class="icon is-small is-left"><i class="fa fa-search"></i></span>
                                </div>
                                <div class="control">
                                    <input type="submit" value="搜索" class="button is-info">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop