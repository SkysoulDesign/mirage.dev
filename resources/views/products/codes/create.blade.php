@extends('layout.master')

@section('content')

    <div class="row medium-12 columns">

        <form action="{{ route('product.code.post', ['product' => $product->id]) }}" method="POST">

            <div class="row">

                <div class="medium-3 columns">
                    <div class="row medium-12 columns">
                        <img class="thumbnail" src="{{ url($product->image) }}" alt="">
                    </div>
                </div>

                <div class="medium-9 columns">

                    <div class="row">
                        <div class="medium-10 columns">
                            <label>Product Name
                                <input type="text" value="{{ $product->name }}" readonly>
                            </label>
                        </div>

                        <div class="medium-10 columns">
                            <label>Product Code
                                <input type="text" value="{{ $product->code }}" readonly>
                            </label>
                        </div>

                        <div class="medium-10 columns">
                            <label>
                                How many codes to be generated?
                                <input type="number" name="amount" value="10">
                            </label>
                        </div>

                        <div class="medium-12 columns">
                            <button type="submit" class="button">Create</button>
                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>

@endsection