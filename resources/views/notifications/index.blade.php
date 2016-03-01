@extends('layouts.master')

@section('content')
    <div class="ui segment">
        todo
    </div>
    <!--
    <div class="row">
        <div class="medium-12 columns">

            <div class="callout">
                <h5>Push Notifications</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda, atque.</p>
                <a href="{{ route('notification.create') }}">Create new Push Notification</a>
            </div>

            <table style="width: 100%" class="hover">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Release Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($notifications as $notification)
            <tr>
                <td>{{ $notification->title }}</td>
                        <td>{{ $notification->body }}</td>
                        <td>{{ $notification->release_date }}</td>
                        <td><a href="#">Trigger now</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
-->
@endsection