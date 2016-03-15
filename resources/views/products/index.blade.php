@extends('layouts.master')

@section('content')

    @include('products.partials.menu')

    <table class="ui celled striped table">
        <thead>
        <tr>
            <th colspan="3">
                Products
            </th>
        </tr>
        </thead>
        <tbody>

        @foreach($products as $product)
            <tr>
                <td class="collapsing">
                    {{ $product->code }}
                </td>

                <td>
                    <h4 class="ui image header">
                        <img src="{{ asset($product->image) }}" class="ui mini rounded image">
                        <div class="content">
                            {{ $product->name }}
                            <div class="sub header">
                                Generated Codes: {{ $product->codes()->count() }}
                            </div>
                        </div>
                    </h4>
                </td>

                <td class="right aligned collapsing">

                    <div class="ui small basic icon buttons">
                        <a href="{{ route('product.edit', $product->id) }}" class="ui button"><i
                                    class="edit icon"></i> Edit</a>
                        <a href="{{ route('product.extra.index', $product->id) }}" class="ui button"><i
                                    class="archive icon"></i> Extras</a>
                        <a href="{{ route('product.code.create', $product->id) }}" class="ui button"><i
                                    class="upload icon"></i> Generate</a>
                        <a class="ui button" href="{{ route('product.code.index', $product->id) }}"><i
                                    class="file icon"></i> Codes</a>
                        <a class="ui button" href="{{ route('product.code.export', $product->id) }}"><i
                                    class="download icon"></i> Export</a>
                    </div>

                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

@endsection