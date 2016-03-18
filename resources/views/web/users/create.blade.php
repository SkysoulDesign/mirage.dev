@extends('layouts.master-web')

@section('content')

    <form class="ui form" action="{{ route('user.register') }}" method="POST">

        <div class="ui stacked segments">

            {{ csrf_field() }}
            <div class="ui segment">
                <div class="required field">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}">
                </div>
            </div>

            <div class="ui segment">
                <div class="required field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password">
                </div>
            </div>

            <div class="ui segment">
                <div class="required field">
                    <label>Repeat Password</label>
                    <input type="password" name="password_confirmation" placeholder="Password Confirmation">
                </div>
            </div>

            <div class="ui segment">
                <div class="required field">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                </div>
            </div>

            <div class="ui segment">
                <div class="field">
                    <label>Gender</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="gender" value="{{ old('gender') }}">
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
            </div>

            <div class="ui segment">
                <div class="field">
                    <label>Country</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="country_id" value="{{ old('country_id') }}">
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
            </div>

            <div class="ui segment">
                <div class="field">
                    <label>Age Group</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="age_id" value="{{ old('age_id') }}">
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
            </div>

            <div class="ui segment">
                <div class="required inline field">
                    <div class="ui checkbox">
                        <input type="checkbox" tabindex="0" class="hidden" name="terms">
                        <label>I agree to the terms and conditions</label>
                    </div>
                </div>
            </div>

            <div class="ui segment">
                <div class="required inline field">
                    <div class="ui checkbox">
                        <input type="checkbox" tabindex="0" class="hidden" name="newsletter">
                        <label>Accept Receive news letter?</label>
                    </div>
                </div>
            </div>

            <div class="ui segment">
                <button class="ui submit button primary" type="submit">Register</button>

                <a href="{{ route('user.index') }}" class="ui button ui-icon-cancel">
                    Cancel
                </a>
            </div>
        </div>

    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            $('.dropdown').dropdown();

            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            $('.ui.checkbox').checkbox();

        });
    </script>
@endsection