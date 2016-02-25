@extends('layouts.master')

@section('content')

    @include('help.partials.menu')

    <div class="ui styled fluid accordion">
        @foreach($apis as $api)

            <div class="title">
                <i class="dropdown icon"></i>
                {!! $api->present()->route !!}
            </div>
            <div class="content">
                <div class="ui message">
                    <div class="header">
                        Description
                    </div>
                    <p>{{ $api->description }}</p>
                </div>
                <table class="ui celled striped table">
                    <thead>
                    <tr>
                        <th colspan="3">
                            Request
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="collapsing">
                            <i class="world icon"></i>Url
                        </td>
                        <td>{!! $api->present()->route !!}</td>
                    </tr>
                    <tr>
                        <td class="collapsing">
                            <i class="folder icon"></i>Method
                        </td>
                        <td>
                            <div class="ui list">
                                @foreach($api->present()->methods as $method)

                                    <div class="item">
                                        <i class="right triangle icon"></i>
                                        <div class="content">
                                            <div class="header">{{ $method }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="collapsing">
                            <i class="folder icon"></i>Parameters
                        </td>
                        <td>
                            <div class="ui list">

                                @forelse($api->present()->parameters as $key => $description)

                                    <div class="item">
                                        <i class="right triangle icon"></i>
                                        <div class="content">
                                            <div class="header">{{ $key }}</div>
                                            <div class="content">{!! $description !!}</div>
                                        </div>
                                    </div>
                                @empty
                                    []
                                @endforelse

                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="collapsing">
                            <i class="world icon"></i>Return
                        </td>
                        <td>
                            <pre>
                               {{ $api->present()->response }}
                            </pre>
                        </td>
                        <td class="right aligned collapsing">
                            <div class="ui button primary disabled">Test</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="collapsing">
                            <i class="world icon"></i>Error
                        </td>
                        <td class="left aligned">
                            <pre>
                               {{ $api->present()->response_error }}
                            </pre>
                        </td>
                        <td class="right aligned collapsing">
                            <div class="ui button primary disabled">Test</div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

@endsection