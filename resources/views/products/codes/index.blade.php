@extends('layouts.master')

@section('content')

    {{--*/ $userModule = false  /*--}}

    @if(@$user!='')
        {{--*/ $userModule = true  /*--}}
    @endif

    @if($userModule)
        @include('users.partials.menu')
    @else
        @include('products.codes.partials.menu')
    @endif

    <table class="ui selectable celled table">
        <thead>
        <tr>
            <th>Code</th>
            @if(!$userModule)
                <th>User</th>
            @endif
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($codes as $code)
            <tr>
                <td>{{ $code->code }}</td>
                @if(!$userModule)
                    <td>
                        @if($code->user_id!='')
                            <a class=""
                               href="{{ route('user.edit', $code->user_id) }}"
                               target="_blank">
                                {{ $code->user->username }}
                                <i class="edit icon"></i>
                            </a>
                        @else
                            -
                        @endif
                    </td>
                @endif
                <td class="right aligned collapsing">
                    @if($code->user_id!='')
                        <div class="ui small basic icon buttons">
                            {{--*/ $unlinkRoute = 'product.code.unlink' /*--}}
                            {{--*/ $routeParam = array($code->product_id, $code->id) /*--}}
                            @if($userModule)
                                {{--*/ $unlinkRoute = str_replace('product.', 'user.', $unlinkRoute) /*--}}
                                {{--*/ $routeParam = array_merge($routeParam, array('user')) /*--}}
                            @endif
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

        @if(!$userModule)
            <tfoot>
            <tr>
                <th colspan="4">
                    <div class="ui right floated pagination menu">
                        <a href="{{ $codes->previousPageUrl() }}" class="icon item">
                            <i class="left chevron icon"></i>
                        </a>
                        <a href="{{ $codes->url(1) }}" class="item">1..</a>
                        <div class="item">...</div>
                        <div class="active item">{{ $codes->currentPage() }}</div>
                        <a href="{{ $codes->url($codes->currentPage()+1) }}"
                           class="item">{{ $codes->currentPage()+1 }}</a>
                        <a href="{{ $codes->url($codes->currentPage()+2)  }}"
                           class="item">{{ $codes->currentPage()+2 }}</a>
                        <a href="{{ $codes->url($codes->currentPage()+3)  }}"
                           class="item">{{ $codes->currentPage()+3 }}</a>
                        <a href="{{ $codes->nextPageUrl() }}" class="icon item">
                            <i class="right chevron icon"></i>
                        </a>
                    </div>
                </th>
            </tr>
            </tfoot>
        @endif
    </table>

@endsection