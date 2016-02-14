@extends('layout.master')

@section('content')
    <div class="row medium-12 columns">

        <form action="{{ route('notification.post') }}" method="POST">
            <div class="row">

                <div class="medium-12 columns">
                    <label>Title
                        <input type="text" name="title" placeholder="Title">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <label>Message Body
                        <input type="text" name="body" placeholder="Message Body">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <label>Release Date & Time
                        <input type="datetime-local" name="release_date" placeholder="Release Date">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <button type="submit" class="button">Create</button>
                </div>

            </div>
        </form>
    </div>
@endsection