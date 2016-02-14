@extends('layout.master')

@section('content')

    <div class="row medium-8 columns">

        <div class="row">
            @foreach($codes as $code)

                <div class="medium-12">
                    <div class="callout large">
                        <div class="row">
                            <div class="medium-10 center columns">
                                <h5>{{ $code->product->name }}</h5>
                                <a href="#"> {{ $code->code }}</a>
                            </div>
                            <div class="medium-2 medium-text-right columns">
                                <img class="thumbnail" src="{!! $code->QRCode() !!}"/>
                            </div>
                        </div>
                    </div>

                </div>

            @endforeach
        </div>

    </div>

@endsection
