@extends('web.layouts.master')

@section('banner')
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column">
                        <p class="title is-spaced">
                            课程：{{ $data->title }}
                        </p>
                        <p class="subtitle">
                            {{ $data->excerpt }}
                        </p>
                        @if (isset($data->categories))
                            <div class="tags">
                                @foreach($data->categories as $category)
                                    <a href="{{ action('Web\CategoryController@courses', ['name' => $category['name']]) }}" style="margin-right: .3em;"><span class="tag">{{ $category['name'] }}</span></a>
                                @endforeach
                            </div>
                        @endif
                    </div>
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
                        <h3>教学内容</h3>
                        <p>{{ $data->content ?: '（本部分暂无内容）' }}</p>
                        <h3>课程代码</h3>
                        <p>{{ $data->code ?: '（本部分暂无内容）' }}</p>
                        <h3>学时</h3>
                        <p>{{ $data->hours ?: '（本部分暂无内容）' }}</p>
                        <h3>学分</h3>
                        <p>{{ $data->credit ?: '（本部分暂无内容）' }}</p>
                        <h3>周学时</h3>
                        <p>{{ $data->hours_per_week ?: '（本部分暂无内容）' }}</p>
                        <h3>教学模式</h3>
                        <p>{{ $data->teaching_model ?: '（本部分暂无内容）' }}</p>
                        <h3>考核方式</h3>
                        <p>{{ $data->assessment_method ?: '（本部分暂无内容）' }}</p>
                        <h3>特色</h3>
                        <p>{{ $data->feature ?: '（本部分暂无内容）' }}</p>
                        <h3>任课教师</h3>
                        <?php $data1 = $data; ?>
                        <?php $data = $data->teachers; ?>
                        @include('web.teacher.layouts.list')
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
