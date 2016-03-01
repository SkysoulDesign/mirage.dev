@extends('layout.master')

@section('content')

    <div class="row">
        <div class="medium-12 columns">

            <table style="width: 100%" class="hover">
                <thead>
                <tr>
                    <th width="20%">Product Name</th>
                    <th width="60%">Product Code</th>
                    <th width="20%">QRCode</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->code }}</td>
                        <td><img src="{!! $product->QRCode() !!}" alt=""></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection