@extends('layout.master')

@section('content')

    <div class="row">

        <div class="medium-12 columns">
            <div class="callout">
                <h5>Products Page</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda, atque.</p>
                <a href="{{ route('product.create') }}">Create New Product</a>
            </div>
            <table style="width: 100%" class="hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td><a data-open="{{ $product->code }}">{{ $product->name }}</a></td>
                        <td>{{ $product->code }}</td>
                        <td class="float-right">
                            <div class="small button-group">
                                <a class="button" href="{{ route('product.code.create', $product->id) }}">Generate Code</a>
                                <a class="button" href="{{ route('product.code.index', $product->id) }}">Codes</a>
                                <a class="button secondary" href="{{ route('product.code.export', $product->id) }}">Export to Excel</a>
                            </div>
                        </td>
                    </tr>

                    <div class="reveal tiny" id="{{ $product->code }}" data-reveal>
                        <img class="thumbnail" src="{{ $product->image }}" alt="Photo of Uranus.">
                    </div>

                @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection