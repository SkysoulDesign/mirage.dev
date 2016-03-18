@extends('layouts.master-web')

@section('content')

    <div class="ui raised segments">

        <a href="{{ route('player') }}" class="ui fluid raised segment">
            <img class="ui fluid bordered image" src="{{ asset('image/products/MF002-poster.png') }}">
        </a>

        <div class="ui fluid raised segment ui green inverted">
            <h1>Batmanattand Version I</h1>
            MF001-ACA9-034F-AD83
        </div>
        <div class="ui fluid raised segment">
            <div class="description">
                Driven by the haunting vision of his parents’ brutal slaying, the orphaned young billionaire Bruce
                Wayne
                devoted his life to becoming the world’s greatest weapon against crime: Batman. The ultimate
                vigilante,
                this Dark Knight’s mastery of physical strength and intellectual superiority fuel his relentless
                pursuit
                of justice against the greatest evils in Gotham City, and beyond.
            </div>
        </div>
    </div>

@endsection