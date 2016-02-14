@extends('layout.master')

@section('content')

    <div class="row">

        <div class="medium-12 columns">
            <div class="callout">
                <h5>Products Page</h5>
                <p>Number of Codes: <b>{{ $product->codes->count() }}</b></p>
                <a href="{{ route('product.code.create', ['product' => $product->id]) }}">Generate More Codes</a>
            </div>
            <table style="width: 100%" class="hover">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($codes as $code)

                    <tr>
                        <td><a data-open="{{ $code->code }}">{{ $code->code}}</a></td>
                        <td>{{ $code->status == 0 ? 'unactivated ': 'activated'}}</td>
                    </tr>

                    <div class="reveal tiny" id="{{ $code->code }}" data-reveal>
                        <img width="100%" class="thumbnail" src="{{ $code->QRcode(300) }}" alt="Photo of Uranus.">
                    </div>

                @endforeach
                </tbody>
            </table>
            <div class="callout">
                {!! $codes->render() !!}
            </div>

        </div>
    </div>

@endsection