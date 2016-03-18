@extends('layouts.master-web')

@section('content')

    <div class="ui three column grid">

        @foreach($codes as $code)

            <div class="column">
                <div class="ui fluid card">
                    <a href="{{ route('web.product.view', $code->id)  }}" class="image">
                        <img src="{{ $code->product->image }}">
{{--                        {{ $code->product->profile->image or }}--}}
                    </a>
                    <div class="content">
                        <a class="header">{{ $code->product->name }}</a>
                    </div>
                </div>
            </div>

        @endforeach

    </div>


@endsection