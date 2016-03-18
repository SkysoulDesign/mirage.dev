@extends('layouts.master-web')

@section('content')

    <form class="ui form" action="{{ route('web.product.create') }}" method="POST">

        <div class="ui stacked segments">

            {{ csrf_field() }}

            <div class="ui segment">
                <div class="required field">
                    <label>Product Code</label>
                    <input type="text" name="code" placeholder="Product Code" value="{{ old('code') }}">
                </div>
            </div>

            <div class="ui segment">
                <button class="ui submit button primary" type="submit">Register</button>

                <a href="{{ route('web.index') }}" class="ui button ui-icon-cancel">
                    Cancel
                </a>
            </div>
        </div>

    </form>
@endsection