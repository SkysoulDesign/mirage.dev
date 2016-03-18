<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mirage</title>
</head>

<link rel="stylesheet" href="{{ asset('css/semantic.min.css') }}">

@yield('css')

<style>
    .ui.container {
        padding: 5% 5%;
    }
</style>

<body>

<div class="ui fluid container">
    @include('web.partials.menu')
    @include('errors.errors')
    @yield('content')
</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/semantic.min.js') }}"></script>
@yield('scripts')

</body>
</html>