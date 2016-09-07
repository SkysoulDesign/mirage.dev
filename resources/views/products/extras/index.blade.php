@extends('layouts.master')

@section('content')

    @include('products.extras.partials.menu')

    @foreach($extras as $extra)
        <table class="ui definition table">
            <tbody>
            <tr>
                {{ dd($extra->titleArray, $extra->getOriginal('title')) }}
                <td class="two wide column">Title</td>
                <td>{{ implode(' / ', $extra->titleArray) }}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>{{ implode(' / ', $extra->descriptionArray) }}</td>
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
                        {{--<video controls width="500">--}}
                            {{--<source src="{{ asset($extra->video) }}" type="video/mp4">--}}
                            {{--<source src="{{ asset($extra->video) }}" type="video/ogg">--}}
                            {{--Your browser does not support the video tag.--}}
                        {{--</video>--}}
                        <video controls width="500"
                               src="{{ route('media.stream', array('video', encrypt('code;;;0;;;'.$extra->id))) }}"></video>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Actions</td>
                <td>
                    <div class="ui small menu compact">
                        <div class="menu">
                            <a class="item" href="{{ route('product.extra.edit', array($product->id, $extra->id)) }}">
                                <i class="edit icon"></i>
                                Edit
                            </a>
                            {!! method_field('DELETE') !!}
                            <a class="item" href="{{ route('product.extra.delete', array($product->id, $extra->id)) }}">
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
