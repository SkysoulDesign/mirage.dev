@extends('layout.master-basic')

@section('content')

    <div class="row medium-12 columns">

        <form action="{{ route('login') }}" method="POST">

            {!! csrf_field() !!}

            <div class="row">

                <div class="medium-12 columns">
                    <label>Username or Email
                        <input type="text" name="email" placeholder="Username Or Email">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <label>Password
                        <input type="password" name="password" placeholder="Password">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <button type="submit" class="button">Login</button>
                </div>

            </div>

        </form>

    </div>

@endsection
