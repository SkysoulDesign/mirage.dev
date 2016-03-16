@extends('layouts.master')

@section('content')

    @include('products.partials.menu')

    <div class="ui segment">

        <form class="ui form" action="{{ route('product.post') }}" method="POST" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="required field">
                <label>Product Name</label>
                <input type="text" name="name" placeholder="Name" value="">
            </div>

            <div class="required field">
                <label>Product Code</label>
                <input type="text" name="code" placeholder="Code" maxlength="5" value="">
            </div>

            <div class="required field">
                <label>Description (Displayed on the Mobile App)</label>
                <textarea type="text" name="description" placeholder="Description" rows="2"></textarea>
            </div>

            <div class="required field upload">
                {{--<div class="medium-12 columns">--}}
                    <label class="">Product Image (Displayed on the Mobile App)</label>
                    <input type="file" name="image">
                {{--</div>--}}
            </div>

            <div class="required field upload">
                {{--<div class="medium-12 columns">--}}
                    <label class="">Poster (Displayed on the Mobile App)</label>
                    <input type="file" name="poster">
                {{--</div>--}}
            </div>

            <button class="ui submit button primary" type="submit">Create</button>

        </form>

    </div>

@endsection