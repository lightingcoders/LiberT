@extends('layouts.master')
@section('page.name', __('Wallet'))
@section('page.body')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{__('Wallet')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('wallet') }}
                </div>
            </div>
        </div>
    </div>

    <div class="content-detached content-right">
        <div class="content-body">
            <section class="row">
                <div class="col-12">
                    <div class="tab-content">
                        {{--
                        <div role="tabpanel" class="tab-pane fade active in show" id="currency"
                             aria-labelledby="currency-tab" aria-expanded="true">
                            @include('wallet.partials.tabs.currency')
                        </div>
                        --}}
                        <div role="tabpanel" class="tab-pane fade active in show" id="bitcoin"
                             aria-labelledby="bitcoin-tab" aria-expanded="true">
                            @include('wallet.partials.tabs.bitcoin')
                        </div>

                        {{--<div role="tabpanel" class="tab-pane fade" id="dogecoin"--}}
                             {{--aria-labelledby="dogecoin-tab" aria-expanded="true">--}}
                            {{--@include('wallet.partials.tabs.dogecoin')--}}
                        {{--</div>--}}

                        <div role="tabpanel" class="tab-pane fade" id="dash"
                             aria-labelledby="dash-tab" aria-expanded="true">
                            @include('wallet.partials.tabs.dash')
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="litecoin"
                             aria-labelledby="litecoin-tab" aria-expanded="true">
                            @include('wallet.partials.tabs.litecoin')
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="sidebar-detached sidebar-left">
        <div class="sidebar">
            <div class="bug-list-sidebar-content">
                <!-- Predefined Views -->
                <div class="card">
                    <div class="card-head">
                        <div class="card-header">
                            <h4 class="card-title">{{__('Navigation')}}</h4>
                        </div>
                    </div>
                    <div class="card-content">
                        <!-- Groups -->
                        <div class="card-body">
                            <ul class="nav nav-pills nav-pill-with-active-bordered flex-column">
                                {{--
                                <li class="nav-item">
                                    <a class="nav-link active" id="currency-tab" data-toggle="pill"
                                       href="#currency" role="tab" aria-controls="currency" aria-expanded="true">
                                        <i class="ft-globe"></i> {{__('Currency (:currency)', ['currency' => Auth::user()->currency])}}
                                    </a>
                                </li>
                                --}}

                                {{-- <li class="pt-1"><p class="lead">{{__('Cryptocurrency')}}</p></li> --}}

                                <li class="nav-item">
                                    <a class="nav-link active" id="bitcoin-tab" data-toggle="pill"
                                       href="#bitcoin" role="tab" aria-controls="bitcoin" aria-expanded="true">
                                        <i class="cc BTC-alt"></i> {{__('Bitcoin')}}
                                    </a>
                                </li>

                                {{--<li class="nav-item">--}}
                                    {{--<a class="nav-link" id="dogecoin-tab" data-toggle="pill"--}}
                                       {{--href="#dogecoin" role="tab" aria-controls="dogecoin" aria-expanded="true">--}}
                                        {{--<i class="cc DOGE-alt"></i> {{__('Dogecoin')}}--}}
                                    {{--</a>--}}
                                {{--</li>--}}

                                <li class="nav-item">
                                    <a class="nav-link" id="dash-tab" data-toggle="pill"
                                       href="#dash" role="tab" aria-controls="dash" aria-expanded="true">
                                        <i class="cc DASH-alt"></i> {{__('Dash')}}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="litecoin-tab" data-toggle="pill"
                                       href="#litecoin" role="tab" aria-controls="litecoin" aria-expanded="true">
                                        <i class="cc LTC-alt"></i> {{__('Litecoin')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            window._tableData = [
                // Bitcoin
                {
                    'selector': '#bitcoin-address-list',
                    'options': {
                        "ajax": {
                            "async": true,
                            "url": '{{route('wallet.address-data', ['coin' => 'btc'])}}',
                            "type": "POST",
                        },

                        columns: [
                            {data: null, defaultContent: ''},
                            {data: 'address'},
                            {data: 'total_received'}
                        ]
                    }
                },

                {
                    'selector': '#bitcoin-transaction-list',
                    'options': {
                        "ajax": {
                            "async": true,
                            "url": '{{route('wallet.transaction-data', ['coin' => 'btc'])}}',
                            "type": "POST",
                        },

                        columns: [
                            {data: null, defaultContent: ''},
                            {data: 'type'},
                            {data: 'address'},
                            {data: 'value'},
                            {data: 'received'},
                            {data: 'confirmations'},
                        ]
                    }
                },

                // Dogecoin
                {
                    'selector': '#dogecoin-address-list',
                    'options': {
                        "ajax": {
                            "async": true,
                            "url": '{{route('wallet.address-data', ['coin' => 'doge'])}}',
                            "type": "POST",
                        },

                        columns: [
                            {data: null, defaultContent: ''},
                            {data: 'address'},
                            {data: 'total_received'}
                        ]
                    }
                },

                {
                    'selector': '#dogecoin-transaction-list',
                    'options': {
                        "ajax": {
                            "async": true,
                            "url": '{{route('wallet.transaction-data', ['coin' => 'doge'])}}',
                            "type": "POST",
                        },

                        columns: [
                            {data: null, defaultContent: ''},
                            {data: 'type'},
                            {data: 'address'},
                            {data: 'value'},
                            {data: 'received'},
                            {data: 'confirmations'},
                        ]
                    }
                },

                // Dash
                {
                    'selector': '#dash-address-list',
                    'options': {
                        "ajax": {
                            "async": true,
                            "url": '{{route('wallet.address-data', ['coin' => 'dash'])}}',
                            "type": "POST",
                        },

                        columns: [
                            {data: null, defaultContent: ''},
                            {data: 'address'},
                            {data: 'total_received'}
                        ]
                    }
                },

                {
                    'selector': '#dash-transaction-list',
                    'options': {
                        "ajax": {
                            "async": true,
                            "url": '{{route('wallet.transaction-data', ['coin' => 'dash'])}}',
                            "type": "POST",
                        },

                        columns: [
                            {data: null, defaultContent: ''},
                            {data: 'type'},
                            {data: 'address'},
                            {data: 'value'},
                            {data: 'received'},
                            {data: 'confirmations'},
                        ]
                    }
                },

                // Litecoin
                {
                    'selector': '#litecoin-address-list',
                    'options': {
                        "ajax": {
                            "async": true,
                            "url": '{{route('wallet.address-data', ['coin' => 'ltc'])}}',
                            "type": "POST",
                        },

                        columns: [
                            {data: null, defaultContent: ''},
                            {data: 'address'},
                            {data: 'total_received'}
                        ]
                    }
                },

                {
                    'selector': '#litecoin-transaction-list',
                    'options': {
                        "ajax": {
                            "async": true,
                            "url": '{{route('wallet.transaction-data', ['coin' => 'ltc'])}}',
                            "type": "POST",
                        },

                        columns: [
                            {data: null, defaultContent: ''},
                            {data: 'type'},
                            {data: 'address'},
                            {data: 'value'},
                            {data: 'received'},
                            {data: 'confirmations'},
                        ]
                    }
                }
            ]
        </script>
    @endpush

    @push('mixins')
        <script type="text/javascript">
            window._vueData = {!! json_encode([
                'send' => [
                    'btc_value' => 0,
                    'dash_value' => 0,
                    'ltc_value' => 0
                ],

                'balance' => [
                    'btc_value' => $wallet['btc']['total_available'],
                    'dash_value' => $wallet['dash']['total_available'],
                    'ltc_value' => $wallet['ltc']['total_available'],
                ]
            ]) !!}
        </script>
    @endpush
@endsection

@push('mixins')
    <script src="{{asset('js/pages/wallet/mixin.js')}}" type="text/javascript"></script>
@endpush

@push('scripts')
    <script src="{{asset('js/pages/wallet/script.js')}}" type="text/javascript"></script>
@endpush

