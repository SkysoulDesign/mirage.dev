@extends('layout.master')

@section('content')

    <div class="row medium-12 columns">

        <form action="{{ route('generator') }}" method="POST">

            <div class="row">

                <div class="medium-12 columns">
                    <label>Product Name
                        <input type="text" name="name" placeholder="Product Name">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <label>Product Code
                        <input type="text" name="code" placeholder="Product Code">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <label>
                        How many codes to be generated?
                        <input type="number" name="quantity" value="10">
                    </label>
                </div>

                <div class="medium-12 columns">
                    <button type="submit" class="button">Create</button>
                </div>

            </div>

        </form>

    </div>

@endsection