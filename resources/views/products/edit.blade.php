@extends('layouts.master')

@section('content')

    @include('products.partials.menu')

    <div class="ui segment">

        <form class="ui form"
              action="{{ route('product.update', $product) }}" method="POST"
              enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="required field">
                <label>Product Name</label>
                <input type="text" name="name" placeholder="Name" value="{{ $product->name }}">
            </div>

            <div class="required field">
                <label>Product Code</label>
                <input type="text" name="code" placeholder="Code" maxlength="5" value="{{ $product->code }}">
            </div>

            <div class="required field">
                <label>Description (Displayed on the Mobile App)</label>
                <textarea type="text" name="description" placeholder="Description"
                          rows="4">{{ $product->profile->description }}</textarea>
            </div>

            @if($product->profile->image)
                <div class="fields">
                    <div class="field">
                        <div class="ui compact segment">
                            <img class="ui medium rounded image" src="{{ $product->image }}">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui compact segment">
                            <img class="ui medium rounded image" src="{{ $product->profile->image }}">
                        </div>
                    </div>
                </div>
            @endif

            <div class="required field">
                <div class="medium-12 columns">
                    <label class="">Product Image (Displayed on the Mobile App)
                        <input type="file" name="image">
                    </label>
                </div>
            </div>

            <div class="required field">
                <div class="medium-12 columns">
                    <label class="">Poster (Displayed on the Mobile App)
                        <input type="file" name="poster">
                    </label>
                </div>
            </div>

            <button class="ui submit button primary" type="submit">Save</button>

        </form>

    </div>

@endsection