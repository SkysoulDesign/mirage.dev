@extends('layouts.master')

@section('content')

    @include('products.extras.partials.menu')

    <div class="ui segment">

        <?php
            $formAction = 'product.extra.';
            $formActionParam = $product;
            if (@$extra->id!=''){
            $formAction .= 'update';
            $formActionParam = array($product, $extra->id);
            } else {
            $formAction .= 'post';
            }
        ?>
        <form class="ui form" action="{{ route($formAction, $formActionParam) }}" method="POST"
              enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="required field">
                <label>Content Title</label>
                <input type="text" name="title" placeholder="Title" value="{{ old('title', @$extra->title) }}">
            </div>

            <div class="required field">
                <label>Content Description</label>
                <textarea type="text" name="description" placeholder="Description"
                          rows="2">{{ old('description', @$extra->description) }}</textarea>
            </div>

            @if(@$extra->image)
                <div class="fields">
                    <div class="field">
                        <label>Product</label>
                        <div class="ui compact segment">
                            <img class="ui medium rounded image" src="{{ asset($extra->image) }}">
                        </div>
                    </div>
                    <div class="field">
                        <label>Video</label>
                        <div class="ui compact segment">
                            <video controls width="500">
                                <source src="{{ asset($extra->video) }}" type="video/mp4">
                                <source src="{{ asset($extra->video) }}" type="video/ogg">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            @endif

            <div class="required field">
                {{--<div class="medium-12 columns">--}}
                <label class="">Product Image</label>
                <input type="file" name="image">
                {{--</div>--}}
            </div>

            <div class="required field">
                {{--<div class="medium-12 columns">--}}
                <label class="">Video</label>
                <input type="file" name="video">
                {{--</div>--}}
            </div>

            <button class="ui submit button primary"
                    type="submit">{{ (@$extra->id!='' ? 'Update' : 'Create') }}</button>

        </form>

    </div>

@endsection