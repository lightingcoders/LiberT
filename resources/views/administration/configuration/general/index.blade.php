@extends('layouts.master')
@section('page.name', __('General Configuration'))
@section('page.body')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{__('General Configuration')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('administration.configuration.general') }}
                </div>
            </div>
        </div>
    </div>

    <div class="content-detached content-right">
        <div class="content-body">
            <section class="row">
                <div class="col-12">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in show" id="global"
                             aria-labelledby="global-tab" aria-expanded="true">
                            @include('administration.configuration.general.partials.tabs.global')
                        </div>
                        <div class="tab-pane fade" id="google" role="tabpanel"
                             aria-labelledby="google-tab" aria-expanded="false">
                            @include('administration.configuration.general.partials.tabs.google')
                        </div>
                        <div class="tab-pane fade" id="blockcypher" role="tabpanel"
                             aria-labelledby="blockcypher-tab" aria-expanded="false">
                            @include('administration.configuration.general.partials.tabs.blockcypher')
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>


    <div class="sidebar-detached sidebar-sticky sidebar-left">
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
                                <li class="nav-item">
                                    <a class="nav-link active" id="global-tab" data-toggle="pill"
                                       href="#global" role="tab" aria-controls="global" aria-expanded="true">
                                        <i class="ft-globe"></i> {{__('Global')}}
                                    </a>
                                </li>

                                <li class="pt-1"><p class="lead">{{__('Services')}}</p></li>

                                <li class="nav-item">
                                    <a class="nav-link" id="google-tab" data-toggle="pill" aria-expanded="false"
                                       href="#google" role="tab" aria-controls="google">
                                        {{__('Google')}}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="blockcypher-tab" data-toggle="pill" aria-expanded="false"
                                       href="#blockcypher" role="tab" aria-controls="blockcypher">
                                        {{__('BlockCypher')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!--/ Groups-->
                    </div>
                </div>
                <!--/ Predefined Views -->
            </div>
        </div>
    </div>

    @push('mixins')
        <script type="text/javascript">
            window._vueData = {!! json_encode([
                'form' => [
                    'settings' => [
                        'broadcast_driver' => $env['BROADCAST_DRIVER']['value'],
                    ]
                ]
            ]) !!}
        </script>
    @endpush

@endsection

@push('mixins')
    <script src="{{asset('js/pages/administration/configuration/general/mixin.js')}}" type="text/javascript"></script>
@endpush

@push('scripts')
    <script src="{{asset('js/pages/administration/configuration/general/script.js')}}" type="text/javascript"></script>
@endpush

