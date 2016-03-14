@extends('layouts.master')

@section('content')

    <div class="ui grid">
        <div class="four wide column">
            <div class="ui card">
                <div class="image">
                    <img src="{{ asset($product->image) }}">
                </div>
                <div class="content">
                    <a class="header">{{ $product->name }}</a>
                    <div class="meta">
                        <span class="date">Generated codes: <b>{{ $product->codes()->count() }}</b></span>
                    </div>
                    <div class="description">
                        {{ $product->description or $product->name }}
                    </div>
                </div>
                <div class="extra content">
                    <a>
                        <i class="user icon"></i>
                        Acquired Users: 0
                    </a>
                </div>
            </div>
        </div>
        <div class="twelve wide column">

            <div class="ui segment">

                <form class="ui form" action="{{ route('product.code.post', $product) }}" method="POST">

                    {{ csrf_field() }}

                    <div class="field">
                        <label>Product Name</label>
                        <input type="text" value="{{ $product->name }}" readonly>
                    </div>

                    <div class="field">
                        <label>Product Code </label>
                        <input type="text" value="{{ $product->code }}" readonly>
                    </div>

                    <div class="field">
                        <label> How many codes to be generated?</label>
                        <input type="number" name="amount" value="5000">
                    </div>

                    <div class="inline field">
                        <div class="ui checked checkbox">
                            <input type="checkbox" tabindex="0" class="hidden" name="export" checked="">
                            <label>Export to Excel After Creation</label>
                        </div>
                    </div>

                    <button type="submit" class="ui button primary">Generate</button>

                </form>

            </div>

        </div>
    </div>

@endsection