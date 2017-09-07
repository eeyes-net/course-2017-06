@extends('web.layouts.master')

@section('banner')
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column">
                        <p class="title">
                            课程搜索结果：{{ $q }}
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
    <section class="section">
        <div class="container">
            <div class="content">
                @include('web.course.layouts.list')
            </div>
        </div>
    </section>
@stop