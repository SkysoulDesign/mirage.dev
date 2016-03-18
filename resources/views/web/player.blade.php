@extends('layouts.master-web')

@section('content')
    <video id="video"></video>
@endsection

@section('css')
    <link href="{{ asset('video-js/video-js.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')

    <script src="{{ asset('video-js-ie8/videojs-ie8.min.js') }}"></script>
    <script src="{{ asset('video-js/video.js') }}"></script>
    <script>

        videojs.options.flash.swf = "{{ asset('video-js/video-js.swf') }}";

        var myPlayer = videojs('video');

    </script>

@endsection