@extends('layouts.master')
@section('page.name', __('Manage Trades'))
@section('page.body')

    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <h3 class="content-header-title">{{__('Manage Trades')}}</h3>
        </div>
    </div>

    <div class="content-detached content-right">
        <div class="content-body">
            <section class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-top-primary">
                            <h4 class="card-title">
                                {{__('All Trades')}}
                            </h4>
                            <a class="heading-elements-toggle">
                                <i class="la la-ellipsis-h font-medium-3"></i>
                            </a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <a data-action="reload">
                                            <i class="ft-rotate-cw"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="trades" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="all">{{__('Coin')}}</th>
                                            <th class="all">{{__('Amount')}}</th>
                                            <th class="none">{{__('Coin Value')}}</th>
                                            <th>{{__('Rate')}}</th>
                                            <th>{{__('Method')}}</th>
                                            <th class="all">{{__('Buyer')}}</th>
                                            <th class="all">{{__('Seller')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th class="all">{{__('Trade')}}</th>
                                            <th>{{__('Offer')}}</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>{{__('Coin')}}</th>
                                            <th>{{__('Amount')}}</th>
                                            <th>{{__('Coin Value')}}</th>
                                            <th>{{__('Rate')}}</th>
                                            <th>{{__('Method')}}</th>
                                            <th>{{__('Buyer')}}</th>
                                            <th>{{__('Seller')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Trade')}}</th>
                                            <th>{{__('Offer')}}</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @hasanyrole('admin')
            <div class="row">
                <div class="col mb-1">
                    <h4 class="text-uppercase">{{__('NET ESCROW PROFIT')}}</h4>
                    <p class="text-muted text-bold-300">{{__('Total Fee Charged')}}</p>
                </div>

                <div class="col d-none d-md-inline-block">
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-success round box-shadow-1 px-2"
                                data-toggle="modal" data-target="#payout">
                            <i class="ft-fast-forward"></i> {{__('PAYOUT')}}
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade text-left" id="payout" tabindex="-1" role="dialog" aria-labelledby="payout-label"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    {!! Form::open(['url' => route('moderation.manage_trades.payout'), 'class' => 'form form-horizontal', 'method' => 'POST']) !!}
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title" id="payout-label">
                                <i class="la la-send"></i> {{__('Payout')}}
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-body">
                                <p class="text-center bock-tag">
                                    {{__('Double check the outgoing address. This process is irreversible!')}}
                                </p>

                                <div class="form-group row">
                                    <label class="col-md-4">{{__('Coin')}}</label>
                                    <div class="col-md-8">
                                        {!! Form::select('coin', get_coins(), null, ['class' => 'form-control', 'placeholder' => 'Select Coin', 'novalidate']) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4">{{__('Address')}}</label>
                                    <div class="col-md-8">
                                        {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => __('Enter receiver address')]) !!}
                                    </div>
                                </div>
                                <hr>

                                <p class="text-center bock-tag">
                                    <span class="badge badge-danger">{{__('Security:')}}</span> {{__('Please verify your identity!')}}
                                </p>

                                @if(!Auth::user()->getSetting()->outgoing_transfer_2fa)
                                    <div class="form-group row">
                                        <label class="col-md-4">{{__('Password')}}</label>
                                        <div class="col-md-8">
                                            {!! Form::password('password', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group row">
                                        <label class="col-md-4">{{__('2FA Token')}}</label>
                                        <div class="col-md-8">
                                            {!! Form::password('token', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">
                                {{__('Close')}}
                            </button>
                            <button type="submit" class="btn btn-success">
                                {{__('Send')}}
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4">
                    <div class="card bg-warning">
                        <div class="card-content">
                            <div class="card-body pb-1">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="text-white mb-1"><i class="cc BTC" title="BTC"></i> Bitcoin</h4>
                                    </div>
                                    <div class="col text-right">
                                        <h6 class="text-white">{{$escrow_wallet->get('btc')['total_available_price']}}</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="text-white">{{$escrow_wallet->get('btc')['total_available']}} BTC</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card bg-primary">
                        <div class="card-content">
                            <div class="card-body pb-1">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="text-white mb-1"><i class="cc DASH" title="DASH"></i> Dash</h4>
                                    </div>
                                    <div class="col text-right">
                                        <h6 class="text-white">{{$escrow_wallet->get('dash')['total_available_price']}}</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="text-white">{{$escrow_wallet->get('dash')['total_available']}} DASH</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card bg-secondary">
                        <div class="card-content">
                            <div class="card-body pb-1">
                                <div class="row">
                                    <div class="col-7">
                                        <h4 class="text-white mb-1"><i class="cc LTC" title="LTC"></i> Litecoin</h4>
                                    </div>
                                    <div class="col-5 text-right">
                                        <h6 class="text-white">{{$escrow_wallet->get('ltc')['total_available_price']}}</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="text-white">{{$escrow_wallet->get('ltc')['total_available']}} LTC</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endhasrole
        </div>
    </div>

    <div class="sidebar-detached sidebar-left">
        <div class="sidebar">
            <div class="bug-list-sidebar-content">
                <!-- Predefined Views -->
                <div class="card">
                    <div class="card-head">
                        <div class="card-header">
                            <h4 class="card-title">{{__('Filter')}}</h4>
                            <a class="heading-elements-toggle">
                                <i class="la la-ellipsis-h font-medium-3"></i>
                            </a>
                            <div class="heading-elements">
                                <a href="{{route('marketplace.buy-coin.index')}}"
                                   class="btn btn-warning btn-sm">
                                    <i class="ft-filter white"></i>
                                    {{__('Clear')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <!-- Groups -->
                        <div class="card-body">
                            <p class="lead">{{__('By Coin')}}</p>
                            <div class="list-group">
                                @foreach($coins as $key => $name)
                                    <a href="{{updateUrlQuery(request(), ['coin' => $key])}}"
                                       class="list-group-item {{request()->get('coin') == $key? 'active': ''}}">
                                        {{removeSnakeCase($name)}}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-body">
                            <p class="lead">{{__('By Status')}}</p>
                            <div class="list-group">
                                <a href="{{updateUrlQuery(request(), ['status' => 'active'])}}"
                                   class="list-group-item {{request()->get('status') == 'active'? 'active': ''}}">
                                    <span class="badge badge-primary badge-pill float-right">
                                        {{\App\Models\Trade::where('status', 'active')->count()}}
                                    </span>

                                    {{__('Active')}}
                                </a>

                                <a href="{{updateUrlQuery(request(), ['status' => 'successful'])}}"
                                   class="list-group-item {{request()->get('status') == 'successful'? 'active': ''}}">
                                    <span class="badge badge-success badge-pill float-right">
                                        {{\App\Models\Trade::where('status', 'successful')->count()}}
                                    </span>

                                    {{__('Successful')}}
                                </a>

                                <a href="{{updateUrlQuery(request(), ['status' => 'cancelled'])}}"
                                   class="list-group-item {{request()->get('status') == 'cancelled'? 'active': ''}}">
                                    <span class="badge badge-danger badge-pill float-right">
                                        {{\App\Models\Trade::where('status', 'cancelled')->count()}}
                                    </span>

                                    {{__('Cancelled')}}
                                </a>

                                <a href="{{updateUrlQuery(request(), ['status' => 'dispute'])}}"
                                   class="list-group-item {{request()->get('status') == 'dispute'? 'active': ''}}">
                                    <span class="badge badge-warning badge-pill float-right">
                                        {{\App\Models\Trade::where('status', 'dispute')->count()}}
                                    </span>

                                    {{__('Dispute')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Predefined Views -->
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            let url = new URL(window.location);
            let params = url.searchParams;

            window._tableData = [
                // Trades
                {
                    'selector': '#trades',
                    'options': {
                        "ajax": {
                            "async": true,
                            "url": '{{route('moderation.manage_trades.data')}}',
                            "type": "POST",
                            "data": {
                                'status': params.get('status'),
                                'coin': params.get('coin'),
                            }
                        },

                        columns: [
                            {data: null, defaultContent: ''},
                            {data: 'coin', orderable: false},
                            {data: 'amount'},
                            {data: 'coin_value'},
                            {data: 'rate'},
                            {data: 'payment_method', orderable: false},
                            {
                                data: 'buyer', orderable: false,
                                createdCell: function (td) {
                                    let res = Vue.compile($(td).html());

                                    let component = new Vue({
                                        render: res.render,
                                        staticRenderFns: res.staticRenderFns
                                    }).$mount();

                                    $(td).html(component.$el)
                                }
                            },
                            {
                                data: 'seller', orderable: false,
                                createdCell: function (td) {
                                    let res = Vue.compile($(td).html());

                                    let component = new Vue({
                                        render: res.render,
                                        staticRenderFns: res.staticRenderFns
                                    }).$mount();

                                    $(td).html(component.$el)
                                }
                            },
                            {data: 'status', orderable: false},
                            {data: 'trade'},
                            {data: 'offer'},
                        ]
                    }
                },
            ]
        </script>
    @endpush

@endsection

@push('mixins')
    <script src="{{asset('js/pages/moderation/manage_trades/mixin.js')}}" type="text/javascript"></script>
@endpush

@push('scripts')
    <script src="{{asset('js/pages/moderation/manage_trades/script.js')}}" type="text/javascript"></script>
@endpush
