@extends('web.layouts.master')

@section('banner')
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column">
                        <p class="title is-spaced">
                            教师：{{ $data->title }}
                        </p>
                        <p class="subtitle">
                            {{ $data->excerpt }}
                        </p>
                    </div>
                    @if ($data->avatar)
                    <div class="column is-narrow">
                        <div class="box">
                            <img src="{{ $data->avatar_url }}">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@stop

@section('main')
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-offset-2 is-8">
                    <div class="content">
                        <h3>教师详情</h3>
                        @if($data->content)
                            <p>{!! str_replace("\n", '</p><p>', $data->content) !!}</p>
                        @else
                            <p>（本部分暂无内容）</p>
                        @endif
                        <h3>教师邮箱</h3>
                        <p>{{ $data->email ?: '（本部分暂无内容）' }}</p>
                        <h3>教师的学院或部门</h3>
                        <p>{{ $data->department ?: '（本部分暂无内容）' }}</p>
                        <h3>讲授课程</h3>
                        <?php $data1 = $data; ?>
                        <?php $data = $data->courses; ?>
                        @include('web.course.layouts.list')
                        <?php $data = $data1; ?>
                        <p>
                            访问量：{{ $data->visit_count }}次
                            最后修改时间：{{ $data->updated_at }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
