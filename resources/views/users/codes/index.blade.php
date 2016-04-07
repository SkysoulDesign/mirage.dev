@extends('layouts.master')

@section('content')

    @include('users.partials.codes-menu')

    <table class="ui selectable celled table">
        <thead>
        <tr>
            <th>Code</th>

            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($codes as $code)
            <tr>
                <td>{{ $code->code }}</td>

                <td class="right aligned collapsing">
                    @if($code->user_id!='')
                        <div class="ui small basic icon buttons">
                            {{--*/ $unlinkRoute = 'user.code.unlink'; /*--}}
                            {{--*/ $routeParam = array($code->product_id, $code->id, 'user') /*--}}
                            <a class="ui button"
                               href="{{ route($unlinkRoute, $routeParam) }}"
                            >
                                Unlink&nbsp;<i class="delete icon"></i>
                            </a>
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>


    </table>

@endsection