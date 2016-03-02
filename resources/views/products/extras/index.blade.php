@extends('layouts.master')

@section('content')

    @include('products.extras.partials.menu')

    @foreach($extras as $extra)
        <table class="ui definition table">
            <tbody>
            <tr>
                <td class="two wide column">Title</td>
                <td>{{ $extra->title }}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>{{ $extra->description }}</td>
            </tr>
            <tr>
                <td>Image</td>
                <td>
                    <div class="ui segment compact">
                        <img src="{{ asset($extra->image) }}" class="ui small rounded image">
                    </div>
                </td>
            </tr>
            <tr>
                <td>Video</td>
                <td>
                    <div class="ui segment compact">
                        <video controls width="500">
                            <source src="{{ asset($extra->video) }}" type="video/mp4">
                            <source src="{{ asset($extra->video) }}" type="video/ogg">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Actions</td>
                <td>
                    <div class="ui small menu compact">
                        <div class="menu">
                            <a class="item" href="">
                                <i class="edit icon"></i>
                                Edit
                            </a>
                            <a class="item" href="">
                                <i class="delete icon"></i>
                                Delete
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    @endforeach
@endsection