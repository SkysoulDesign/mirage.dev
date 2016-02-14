<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mirage</title>
</head>

<link rel="stylesheet" href="{{ url('css/foundation.min.css') }}">

<body>

<div class="callout large secondary"></div>

@yield('content')

<script src="{{ url('js/vendor/jquery.min.js') }}"></script>
<script src="{{ url('js/vendor/what-input.min.js') }}"></script>
<script src="{{ url('js/foundation.min.js') }}"></script>
<script src="{{ url('js/app.js') }}"></script>

</body>
</html>