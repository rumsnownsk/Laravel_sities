<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('index')}}">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('index', session('city.slug')) }}">Home</a>
                    </li>

                    @if( session('city') )

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about', session('city.slug')) }}">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('news', session('city.slug')) }}">News</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('reset') }}">Reset City</a>
                        </li>
                    @endif



                </ul>



            </div>
        </div>
    </nav>
    {{ session('city.title') ?? 'select city' }}
    <ul>
        @foreach($cities as $city)
            <li><a href="{{ route('index', $city->slug) }}" @class([
                    'fw-bold'=>session('city') && session('city.slug') == $city->slug
                ])>
                    {{$city->title}}
                </a></li>
        @endforeach
    </ul>
</div>

<div class="container">

    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
