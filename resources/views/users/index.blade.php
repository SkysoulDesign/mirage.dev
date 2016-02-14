@extends('layout.master')

@section('content')

    <div class="row">
        <div class="medium-12 columns">

            <div class="callout">
                <h5>Users Page</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda, atque.</p>
                <a href="{{ route('user.register') }}">Register New User</a>
            </div>

            <table style="width: 100%" class="hover">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Gender</th>
                    <th>Age Group</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->country }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->age }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection