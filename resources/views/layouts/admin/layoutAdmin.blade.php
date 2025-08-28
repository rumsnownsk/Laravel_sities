<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('sometext')</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    @isset($meta)
        <meta name="description" content={{ $meta }}>
    @endisset

</head>
<body>
@yield('headerH1')
<nav>
    <ul>
        <li><a href="{{route('admin.index')}}">main</a></li>
        <li><a href="{{route('admin.about')}}">about</a></li>
        <li><a href="{{route('admin.contact')}}">contact</a></li>
        <li><a href="{{route('admin.facadeDB')}}">workWithFacadeDB</a></li>
    </ul>
</nav>
<div class="container mt-3">
    @yield("content")
</div>

@include('layouts.incs.footer')

<script src="{{ asset("assets/js/bootstrap.min.js") }}"></script>
</body>
</html>
