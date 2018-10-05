@extends('web.layouts.master')

@php
    $title = '分类：' . e($name);
@endphp

@section('banner')
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column">
                        <h1 class="title is-spaced">
                            分类：{{ $name }}
                        </h1>
                        <p class="subtitle">
                            Courses of <em>Xi'an Jiao Tong University</em>.
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
            @include('web.course.layouts.list')
        </div>
    </section>
    @include('web.layouts.pagination')
    <section class="section"></section>
@stop
