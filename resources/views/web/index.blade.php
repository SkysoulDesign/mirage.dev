@extends('layouts.master-web')

@section('content')

    <div class="ui three column grid">

        @foreach(range(0,6) as $item)

            <div class="column">
                <div class="ui fluid card">
                    <a href="{{ route('show') }}" class="image">
                        <img src="{{ asset('image/products/MF003-figurine.png') }}">
                    </a>
                    <div class="content">
                        <a class="header">Daniel Louise</a>
                    </div>
                </div>
            </div>

        @endforeach

    </div>


@endsection