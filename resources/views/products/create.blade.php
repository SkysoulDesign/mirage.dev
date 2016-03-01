@extends('layout.master')

@section('content')

    <div class="row medium-12 columns">

        <form action="{{ route('product.post') }}" method="POST" enctype="multipart/form-data">

            {!! csrf_field() !!}

            <div class="row">

                <div class="medium-12 columns">
                    <label>Name
                        <input type="text" name="name" placeholder="Product Name">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <label>Code
                        <input type="text" name="code" placeholder="Product Code">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <label class="">Product Image
                        <input type="file" name="image">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <button type="submit" class="button">Create</button>
                </div>

            </div>

        </form>

    </div>
@endsection