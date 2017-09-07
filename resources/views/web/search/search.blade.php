@extends('web.layouts.master')

@section('banner')
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column">
                        <p class="title">
                            搜索结果：{{ $q }}
                        </p>
                        <p class="subtitle">
                            Searching result.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('main')
    <?php $data = $course; ?>
    <section class="section">
        <div class="container">
            <div class="content">
                <h1>课程</h1>
                @include('web.course.layouts.list')
                <a href="{{ action('Web\CourseController@search') . '?' . http_build_query(['q' => $q]) }}">更多</a>
            </div>
        </div>
    </section>
    <?php $data = $teacher; ?>
    <section class="section">
        <div class="container">
            <div class="content">
                <h1>教师</h1>
                @include('web.teacher.layouts.list')
                <a href="{{ action('Web\TeacherController@search') . '?' . http_build_query(['q' => $q]) }}">更多</a>
            </div>
        </div>
    </section>
    <section class="section"></section>
@stop