{{--*/ /**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 3/16/16
 * Time: 1:06 PM
 */
 /*--}}
@extends('layouts.master')

@section('content')
    <div class="ui segment">
        <form class="ui form" action="{{ route('user.update', $user->id) }}" method="POST">

            {{ csrf_field() }}


            <div class="required field">
                <label>Role</label>
                <div class="ui fluid search selection dropdown">
                    <input type="hidden" name="role_id" value="{{ old('role_id', $user->roles->first()->id) }}">
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
                <input type="text" name="username" placeholder="Username"
                       value="{{ old('username', $user->username) }}">
            </div>

            <div class="two fields">
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Leave blank if don't want to change password">
                </div>
                <div class="field">
                    <label>Repeat Password</label>
                    <input type="password" name="password_confirmation" placeholder="Password Confirmation">
                </div>
            </div>

            <div class="field">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}">
            </div>

            <div class="field">
                <label>Gender</label>
                <div class="ui fluid search selection dropdown">
                    <input type="hidden" name="gender" value="{{ old('gender', $user->gender) }}">
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

            <div class="required field">
                <label>Country</label>
                <div class="ui fluid search selection dropdown">
                    <input type="hidden" name="country_id" value="{{ old('country_id', $user->country_id) }}">
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
                    <input type="hidden" name="age_id" value="{{ old('age_id', $user->age_id) }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select Your Age Group</div>
                    <div class="menu">
                        @foreach($ages as $age)
                            <div class="item" data-value="{{ $age->id }}">
                                {{ $age->from.'-'.$age->to }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="required inline field">
                <div class="ui checkbox">
                    <input type="checkbox" tabindex="0" class="hidden" name="terms" checked>
                    <label>Agree to the terms and conditions</label>
                </div>
            </div>

            <div class="required inline field">
                <div class="ui checkbox">
                    <input type="checkbox" tabindex="0" class="hidden" name="newsletter"
                            {{ old('newsletter', $user->newsletter)==1 ? ' checked' : '' }}>
                    <label>Accept Receive news letter?</label>
                </div>
            </div>

            <button class="ui submit button primary" type="submit">Update</button>

            <a href="{{ route('user.index') }}" class="ui button ui-icon-cancel">
                Cancel
            </a>

        </form>
    </div>
@endsection