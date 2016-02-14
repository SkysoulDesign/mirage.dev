@extends('layout.master')

@section('content')
    <div class="row medium-12 columns">

        <form action="{{ route('user.register') }}" method="POST">

            {{ csrf_field() }}

            @if($errors->any())

                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach

            @endif

            <div class="row">

                <div class="medium-12 columns">
                    <label>Role
                        <select name="role">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if($role->id === 3) selected @endif>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="medium-12 columns">
                    <label>Username
                        <input type="text" name="username" placeholder="Username">
                    </label>
                </div>
                <div class="medium-12 columns">
                    <label>Password
                        <input type="password" name="password" placeholder="Password">
                        <input type="password" name="password_confirmation" placeholder="Password Confirmation">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <label>Email
                        <input type="email" name="email" placeholder="Email">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <legend>Gender</legend>
                    <input type="radio" name="gender" value="male" required><label>Male</label>
                    <input type="radio" name="gender" value="female"><label>Female</label>
                </div>

                <div class="medium-12 columns">
                    <label>Country
                        <input type="text" name="country" placeholder="Country">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <legend>Age Group</legend>
                    <input type="radio" name="age" value="5/10"><label>5 - 10</label>
                    <input type="radio" name="age" value="15/20"><label>15 - 20</label>
                    <input type="radio" name="age" value="21/30"><label>21 - 30</label>
                    <input type="radio" name="age" value="31/40"><label>31 - 40</label>
                    <input type="radio" name="age" value="41/50"><label>41 - 50</label>
                    <input type="radio" name="age" value="51/60"><label>51 - 60</label>
                    <input type="radio" name="age" value="Above 60"><label>Above 60</label>
                </div>

                <div class="medium-12 columns">
                    <label>
                        <input type="checkbox" name="newsletter">
                        Accept Receive news letter?
                    </label>
                </div>

                <div class="medium-12 columns">
                    <button type="submit" class="button">Create</button>
                </div>

            </div>
        </form>
    </div>
@endsection