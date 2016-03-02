@extends('layouts.master')

@section('content')

    <div class="ui segment">

        <form class="ui form" action="{{ route('login.post') }}" method="POST">

            {!! csrf_field() !!}

            <div class="field">
                <label>Username or Email</label>
                <input type="text" name="credential" placeholder="Username Or Email">
            </div>

            <div class="field">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password">
            </div>

            <button class="ui button" type="submit">Login</button>

        </form>
    </div>

@endsection