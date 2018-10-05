@extends('web.layouts.master')

@php
    $title = '课程搜索结果：' . e($q);
@endphp

@section('banner')
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column">
                        <h1 class="title is-spaced">
                            课程搜索结果：{{ $q }}
                        </h1>
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
