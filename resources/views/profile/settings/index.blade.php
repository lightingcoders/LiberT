@extends('layouts.master')
@section('page.name', __(":name - Settings", ['name' => $user->name]))
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/profile.css')}}">
@endpush
@section('page.body')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">
                {{strtoupper($user->name) . ' | ' . __('Settings')}}
            </h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('profile', $user->name) }}
                </div>
            </div>
        </div>
    </div>


    <div class="content-detached content-right">
        <div class="content-body">
            <section class="row">
                <div class="col-12">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in show" id="general"
                             aria-labelledby="general-tab" aria-expanded="true">
                            @include('profile.settings.partials.tabs.general')
                        </div>
                        <div class="tab-pane fade" id="security" role="tabpanel"
                             aria-labelledby="security-tab" aria-expanded="false">
                            @include('profile.settings.partials.tabs.security')
                        </div>

                        @if(Auth::user()->priority() > $user->priority())
                            <div class="tab-pane fade" id="panel" role="tabpanel"
                                 aria-labelledby="panel-tab" aria-expanded="false">
                                @include('profile.settings.partials.tabs.panel')
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="sidebar-detached sidebar-left sidebar-sticky">
        <div class="sidebar">
            <div class="sidebar-content card">
                <!-- Predefined Views -->
                <div class="card-head">
                    <div class="media p-1">
                        <div class="media-left pr-1">
                            <span class="avatar avatar-sm {{getPresenceClass($user)}} rounded-circle">
                                <img src="{{getProfileAvatar($user)}}" alt="avatar"><i></i>
                            </span>
                        </div>
                        <div class="media-body media-middle">
                            <h5 class="media-heading">{{$user->name}}</h5>
                        </div>
                    </div>
                </div>

                <div class="card-body border-top-blue-grey border-top-lighten-5">
                    <ul class="nav nav-pills nav-pill-with-active-bordered flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-toggle="pill"
                               href="#general" role="tab" aria-controls="general" aria-expanded="true">
                                <i class="ft-globe"></i> {{__('General')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="security-tab" data-toggle="pill"
                               href="#security" role="tab" aria-controls="security" aria-expanded="false">
                                <i class="ft-shield"></i> {{__('Security')}}
                            </a>
                        </li>

                        @if(Auth::user()->priority() > $user->priority())
                            <li class="pt-1"><p class="lead">{{__('Administration')}}</p></li>

                            <li class="nav-item">
                                <a class="nav-link" id="panel-tab" data-toggle="pill"
                                   href="#panel" role="tab" aria-controls="panel" aria-expanded="false">
                                    <i class="ft-briefcase"></i> {{__('Panel')}}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!--/ Predefined Views -->
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            window._tableData = [
                {
                    'selector': '#moderation-activities',
                    'options': {
                        processing: false,
                        serverSide: true,

                        "ajax": {
                            "async": true,
                            "type": "POST",
                            "url": '{{route('profile.settings.moderation-activity-data', ['user' => $user->name])}}'
                        },

                        columnDefs: [{
                            targets: 0,
                            className: 'control',
                            orderable: false,
                        }],

                        columns: [
                            {data: null, defaultContent: ''},
                            {data: 'moderator'},
                            {data: 'activity'},
                            {data: 'comment', orderable: false},
                            {data: 'created_at'},
                            {data: 'link', orderable: false}
                        ],

                        "order": [
                            [4, 'desc']
                        ],
                    }
                }
            ]
        </script>
    @endpush


    @push('mixins')
        <script type="text/javascript">
            window._vueData = {!! json_encode([
                'profile' => [
                    'name' => $user->name,
                    'last_seen' => $user->last_seen,
                    'presence' => $user->presence,
                    'id' => $user->id,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'currency' => $user->currency,

                    'verification' => [
                        'email' => !boolval($user->verified) && !empty($user->email),
                        'phone' => !boolval($user->verified_phone) && !empty($user->phone),
                    ],

                    'settings' => [
                        'google2fa_status' => boolval($setting->google2fa_status)
                    ],

                    'options' => [
                        'edit_email' => !$user->email,
                        'edit_phone' => !$user->phone
                    ],

                    'roles' => $user->getRoleNames()
                ],

                'form' => [
                    'twofa_code' => '',
                    'phone_code' => '',
                ]
            ]) !!}
        </script>
    @endpush

@endsection

@push('mixins')
    <script src="{{asset('js/pages/profile/mixin.js')}}" type="text/javascript"></script>
@endpush

@push('scripts')
    <script src="{{asset('js/pages/profile/script.js')}}" type="text/javascript"></script>
@endpush
