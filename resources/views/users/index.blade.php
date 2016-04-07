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
            <th>Actions</th>
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
                {{--<td>{{ $user->gender or '--' }}</td>--}}
                <td><i class="{{ $user->gender or 'default' }} icon"></i></td>
                <td>{{ ($user->age ? ($user->age->from.'-'.$user->age->to) : '--') }}</td>
                <td class="">
                    <div class="ui small basic icon buttons">
                        <a class="ui button" href="{{ route('user.edit', $user->id) }}">
                            <i class="edit icon"></i>
                            Edit
                        </a>
                        <a class="ui button" href="{{ route('user.codes', $user->id) }}">
                            <i class="edit icon"></i>
                            Codes
                        </a>
                        {{--<a class="ui button" href="{{ route('user.reset', $user->id) }}" title="Reset Password">--}}
                        {{--<i class="archive icon"></i>--}}
                        {{--Reset--}}
                        {{--</a>--}}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection