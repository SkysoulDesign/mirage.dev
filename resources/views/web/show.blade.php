@extends('layouts.master-web')

@section('content')

    <div class="ui raised segments">

        <div class="ui fluid raised segment">
            {{--<img class="ui fluid bordered image" src="{{ $product->profile->image }}">--}}
            <video oncontextmenu="return false;" id="video" class="video-js vjs-default-skin"
                   src="{{ route('media.video', encrypt($extras->first()->video)) }}"></video>
        </div>

        <div class="ui fluid raised segment ui green inverted">
            <h1>{{ $product->name }}</h1>
            {{ $code->code }}
        </div>
        <div class="ui fluid raised segment">
            <div class="description">
                {{--@foreach($extras as $extra)--}}
                {{--{{ $extra->description }}--}}
                {{--@endforeach--}}
                {{ $product->profile->description }}
            </div>
        </div>
    </div>

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
            autoplay: false,
            controls: true,
            fluid: true,
            poster: '{{ $extras->first()->image }}'
        };

        var player = videojs('video', options, function () {
            //this.play();
        });

    </script>

@endsection