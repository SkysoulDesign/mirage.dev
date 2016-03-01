@extends('layouts.master')

@section('content')

    @include('users.partials.menu')

    <table class="ui selectable celled table">
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
                @if($user->country)
                    <td><i class="{{ strtolower($user->country->code) }} flag"></i> {{ $user->country->name }}</td>
                @else
                    <td>--</td>
                @endif
                <td>{{ $user->gender or '--' }}</td>
                <td>{{ $user->age or '--'}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection