@extends('web.layouts.master')

@section('banner')
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column">
                        <p class="title">
                            教师
                        </p>
                        <p class="subtitle">
                            Teachers of <em>Xi'an Jiao Tong University</em>.
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
            @include('web.teacher.layouts.list')
        </div>
    </section>
    @include('web.layouts.pagination')
    <section class="section"></section>
@stop