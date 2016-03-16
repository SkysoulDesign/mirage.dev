@extends('layouts.master')

@section('content')

    @include('products.codes.partials.menu')

    <table class="ui selectable celled table">
        <thead>
        <tr>
            <th>Code</th>
            <th>Status</th>
            <th>User</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($codes as $code)
            <tr>
                <td>{{ $code->code }}</td>
                <td>{{ $code->status or 'unactivated' }}</td>
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
                <td class="right aligned collapsing">
                    @if($code->user_id!='')
                        <div class="ui small basic icon buttons">
                            <a class="ui button"
                               href="{{ route('product.code.unlink', array($product, $code->id)) }}"
                            >
                                <i class="delete icon"></i>
                            </a>
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>

        <tfoot>
        <tr>
            <th colspan="3">
                <div class="ui right floated pagination menu">
                    <a href="{{ $codes->previousPageUrl() }}" class="icon item">
                        <i class="left chevron icon"></i>
                    </a>
                    <a href="{{ $codes->url(1) }}" class="item">1..</a>
                    <div class="item">...</div>
                    <div class="active item">{{ $codes->currentPage() }}</div>
                    <a href="{{ $codes->url($codes->currentPage()+1) }}" class="item">{{ $codes->currentPage()+1 }}</a>
                    <a href="{{ $codes->url($codes->currentPage()+2)  }}" class="item">{{ $codes->currentPage()+2 }}</a>
                    <a href="{{ $codes->url($codes->currentPage()+3)  }}" class="item">{{ $codes->currentPage()+3 }}</a>
                    <a href="{{ $codes->nextPageUrl() }}" class="icon item">
                        <i class="right chevron icon"></i>
                    </a>
                </div>
            </th>
        </tr>
        </tfoot>
    </table>

@endsection