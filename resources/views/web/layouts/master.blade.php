<link rel="stylesheet" href="/css/bulma.min.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">

@section('nav')
    @include('web.layouts.nav')
@show

@section('banner')
    @include('web.layouts.banner')
@show

@yield('main')

@section('footer')
    @include('web.layouts.footer')
@show