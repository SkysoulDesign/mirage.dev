@extends('layouts.master')

@section('content')

    @include('help.partials.menu')

    <div class="ui segment">

        <form class="ui form" action="{{ route('help.post') }}" method="post">

            {{ csrf_field() }}

            <div class="field">
                <label>Url</label>
                <select class="ui search dropdown" name="route">
                    @foreach($routes as $route)
                        <option value="{{ $route->getName() }}">{{ $route->getMethods()[0] }} :: {{ $route->getPath() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Description</label>
                <textarea rows="2" name="description"></textarea>
            </div>

            <button class="ui button" type="submit">Create</button>

        </form>

    </div>
@endsection