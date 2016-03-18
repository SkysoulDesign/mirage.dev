@extends('layouts.master-web')

@section('content')
    <video oncontextmenu="return false;" id="video" class="video-js vjs-default-skin"
    {{--<video  id="video" class="video-js vjs-default-skin"--}}
           src="http://mirage.dev/videos/bunny.mp4"></video>
@endsection

@section('css')
    <link href="{{ asset('video-js/video-js.css') }}" rel="stylesheet">
@endsection

@section('scripts')

    <script src="{{ asset('video-js/ie8/videojs-ie8.min.js') }}"></script>
    <script src="{{ asset('video-js/video.min.js') }}"></script>

    <script>
        videojs.options.flash.swf = "{{ asset('video-js/video-js.swf') }}";

        var options = {
            autoplay:   true,
            controls:   true,
            fluid:      true
        };

        var player = videojs('video', options, function () {
            this.play();
        });

    </script>

@endsection