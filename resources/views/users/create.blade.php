@extends('layouts.master')

@section('content')


    <div class="ui segment">

        <form class="ui form" action="{{ route('user.register') }}" method="POST">

            {{ csrf_field() }}

            <div class="required field">
                <label>Role</label>
                <div class="ui fluid search selection dropdown">
                    <input type="hidden" name="role_id" value="3">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select User Role</div>
                    <div class="menu">
                        @foreach($roles as $role)
                            <div class="item" data-value="{{ $role->id }}">
                                {{ studly_case($role->name) }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="required field">
                <label>Username</label>
                <input type="text" name="username" placeholder="Username">
            </div>

            <div class="two fields">
                <div class="required field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="required field">
                    <label>Repeat Password</label>
                    <input type="password" name="password_confirmation" placeholder="Password Confirmation">
                </div>
            </div>

            <div class="required field">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email">
            </div>

            <div class="field">
                <label>Gender</label>
                <div class="ui fluid search selection dropdown">
                    <input type="hidden" name="gender">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select User Role</div>
                    <div class="menu">
                        @foreach(['male', 'female'] as $gender)
                            <div class="item" data-value="{{ $gender }}">
                                <i class="{{ $gender }} icon"></i>
                                {{ studly_case($gender) }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="field">
                <label>Country</label>
                <div class="ui fluid search selection dropdown">
                    <input type="hidden" name="country_id">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select Country</div>
                    <div class="menu">
                        @foreach($countries as $country)
                            <div class="item" data-value="{{ $country->id }}">
                                <i class="{{ strtolower($country->code) }} flag"></i>
                                {{ $country->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="field">
                <label>Age Group</label>
                <div class="ui fluid search selection dropdown">
                    <input type="hidden" name="age" value="15/20">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select Your Age Group</div>
                    <div class="menu">
                        @foreach($ages as $age)
                            <div class="item" data-value="{{ $age }}">
                                {{ $age }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="required inline field">
                <div class="ui checkbox">
                    <input type="checkbox" tabindex="0" class="hidden" name="terms">
                    <label>I agree to the terms and conditions</label>
                </div>
            </div>

            <div class="required inline field">
                <div class="ui checkbox">
                    <input type="checkbox" tabindex="0" class="hidden" name="newsletter">
                    <label>Accept Receive news letter?</label>
                </div>
            </div>

            <button class="ui submit button primary" type="submit">Register</button>

        </form>
    </div>
@endsection