<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mirage</title>
</head>

<link rel="stylesheet" href="{{ asset('css/semantic.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<body>

<div class="ui container">

    @include('partials.top-bar')
    @include('errors.errors')
    @yield('content')

</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/semantic.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>