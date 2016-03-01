@extends('layouts.master')

@section('content')

    @include('products.extras.partials.menu')

    <div class="ui segment">

        <form class="ui form" action="{{ route('product.extra.post', $product) }}" method="POST" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="required field">
                <label>Content Title</label>
                <input type="text" name="title" placeholder="Title">
            </div>

            <div class="required field">
                <label>Content Description</label>
                <textarea type="text" name="description" placeholder="Description" rows="2"></textarea>
            </div>

            <div class="required field">
                <div class="medium-12 columns">
                    <label class="">Product Image
                        <input type="file" name="image">
                    </label>
                </div>
            </div>

            <div class="required field">
                <div class="medium-12 columns">
                    <label class="">Video
                        <input type="file" name="video">
                    </label>
                </div>
            </div>

            <button class="ui submit button primary" type="submit">Create</button>

        </form>

    </div>

@endsection