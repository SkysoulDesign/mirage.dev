@extends('layouts.master-web')

@section('content')

    <div class="ui segment">
        <form class="ui form" role="form" method="POST" action="{{ url('/password/reset') }}">
            {!! csrf_field() !!}
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="field">
                <label>E-Mail Address</label>
                <input readonly type="email" class="form-control" name="email"
                       value="{{ $email or old('email') }}">
            </div>

            <div class="field">
                <label>Password</label>
                <input type="password" name="password">
            </div>

            <div class="field">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation">
            </div>

            <button class="ui button primary" type="submit">Reset Password</button>

        </form>
    </div>
@endsection
