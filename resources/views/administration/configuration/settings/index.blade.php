@extends('layouts.master')
@section('page.name', __('Settings Configuration'))
@section('page.body')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{__('Settings Configuration')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('administration.configuration.settings') }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-header border-top-success">
                    <h4 class="card-title">{{__('Platform Settings')}}</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        {!! Form::open(['url' => route('administration.configuration.settings.update'), 'class' => 'form form-horizontal']) !!}
                        <div class="form-body">
                            <h4 class="form-section">
                                <i class="la la-dollar"></i> {{__('Currency')}}
                            </h4>

                            <div class="form-group row">
                                {!! Form::label('SET_DEFAULT_CURRENCY', __('Default Currency'), ['class' => 'col-md-3']) !!}
                                <div class="col-md-9">
                                    {!! Form::select('SET_DEFAULT_CURRENCY', get_iso_currencies(), null, ['is' => 'select2', 'html-class' => 'form-control', 'required', 'v-model' => 'default_currency']) !!}
                                </div>
                            </div>

                            <h4 class="form-section">
                                <i class="la la-briefcase"></i> {{__('Transaction')}}
                            </h4>

                            <p class="card-text">
                                {{__('Set the default blockchain transaction preference property to high, medium, or low. This will calculate and include appropriate miners fees for all transaction to be included in the next 1-2 blocks, 3-6 blocks or 7 or more blocks respectively.')}}
                            </p>

                            <div class="form-group row">
                                {!! Form::label('SET_TX_PREFERENCE', __('Preference'), ['class' => 'col-md-3']) !!}
                                <div class="col-md-9">
                                    {!! Form::select('SET_TX_PREFERENCE', get_tx_preferences(), null, ['is' => 'select2', 'html-class' => 'form-control', 'required', 'v-model' => 'tx_preference']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('SET_MIN_TX_CONFIRMATIONS', __('Required Confirmations'), ['class' => 'col-md-3']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('SET_MIN_TX_CONFIRMATIONS', null, ['class' => 'form-control', 'required', 'v-model' => 'min_tx_confirmations']) !!}
                                </div>
                            </div>

                            <h4 class="form-section">
                                <i class="ft-percent"></i> {{__('Trade Fee')}}
                            </h4>

                            <p class="card-text">
                                {{__('The percentage to be charged on each trade from the seller. This is stored securely on separate addresses for each trade which the platform keeps track of. You may send all accumulated fee to another address from the moderation menu.')}}
                            </p>

                            <div class="form-group row">
                                {!! Form::label('SET_BTC_TRADE_FEE', __('Bitcoin Fee'), ['class' => 'col-md-3']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('SET_BTC_TRADE_FEE', null, ['class' => 'form-control', 'required', 'v-model' => 'btc_trade_fee']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('SET_DASH_TRADE_FEE', __('Dash Fee'), ['class' => 'col-md-3']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('SET_DASH_TRADE_FEE', null, ['class' => 'form-control', 'required', 'v-model' => 'dash_trade_fee']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('SET_LTC_TRADE_FEE', __('Litecoin Fee'), ['class' => 'col-md-3']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('SET_LTC_TRADE_FEE', null, ['class' => 'form-control', 'required', 'v-model' => 'ltc_trade_fee']) !!}
                                </div>
                            </div>

                            <h4 class="form-section">
                                <i class="ft-lock"></i> {{__('Locked Balance')}}
                            </h4>

                            <p class="card-text">
                                {{__('This should be set a little bit above the standard miners fee. It is needed to ensure that the transaction succeeds at all times, i.e to avoid error of insufficient balance.')}}
                            </p>

                            <div class="form-group row">
                                {!! Form::label('SET_BTC_LOCKED_BALANCE', __('Bitcoin Amount'), ['class' => 'col-md-3']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('SET_BTC_LOCKED_BALANCE', null, ['class' => 'form-control', 'required', 'v-model' => 'btc_locked_balance']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('SET_DASH_LOCKED_BALANCE', __('Dash Amount'), ['class' => 'col-md-3']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('SET_DASH_LOCKED_BALANCE', null, ['class' => 'form-control', 'required', 'v-model' => 'dash_locked_balance']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('SET_LTC_LOCKED_BALANCE', __('Litecoin Amount'), ['class' => 'col-md-3']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('SET_LTC_LOCKED_BALANCE', null, ['class' => 'form-control', 'required', 'v-model' => 'ltc_locked_balance']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-actions right">
                            <button type="submit" class="btn ladda-button btn-primary">
                                <i class="la la-check-square-o"></i> {{__('Save')}}
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('mixins')
        <script type="text/javascript">
            window._vueData = {!! json_encode([
                'default_currency' => $env['SET_DEFAULT_CURRENCY']['value'],
                'tx_preference' => $env['SET_TX_PREFERENCE']['value'],
                'min_tx_confirmations' => $env['SET_MIN_TX_CONFIRMATIONS']['value'],

                'btc_trade_fee' => $env['SET_BTC_TRADE_FEE']['value'],
                'dash_trade_fee' => $env['SET_DASH_TRADE_FEE']['value'],
                'ltc_trade_fee' => $env['SET_LTC_TRADE_FEE']['value'],

                'btc_locked_balance' => $env['SET_BTC_LOCKED_BALANCE']['value'],
                'dash_locked_balance' => $env['SET_DASH_LOCKED_BALANCE']['value'],
                'ltc_locked_balance' => $env['SET_LTC_LOCKED_BALANCE']['value'],
            ]) !!}
        </script>
    @endpush

@endsection

@push('mixins')
    <script src="{{asset('js/pages/administration/configuration/settings/mixin.js')}}" type="text/javascript"></script>
@endpush

@push('scripts')
    <script src="{{asset('js/pages/administration/configuration/settings/script.js')}}" type="text/javascript"></script>
@endpush
