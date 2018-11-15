@extends('layouts.authentication.master')
@section('page.name', __('Reset Password'))
@section('page.body')
    <section class="login-container">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-xl-4 col-md-6 col-12 box-shadow-2 p-0">
                <div class="card border-grey border-lighten-3 px-1 py-1 m-0"
                     style="border-radius: 15px;">
                    <div class="card-header border-0">
                        <div class="card-title text-center">
                            <a href="{{url('/')}}">
                                <img src="{{asset('images/logo/logo-dark.png')}}" alt="branding logo">
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                            <span>{{__('Reset Password')}}</span>
                        </p>
                        <div class="card-body">
                            @include('authentication.includes.alerts')
                            {!! Form::open(['route' => 'password.email', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'auth-form', 'novalidate' => true]) !!}

                            <fieldset class="form-group position-relative has-icon-left {{ $errors->has('email') ? 'error' : '' }}">
                                {!! Form::email('email', null, ['class' => 'round form-control', 'placeholder' => __('Email Address'), 'required' => true]) !!}
                                <div class="form-control-position"><i class="ft-mail"></i></div>
                            </fieldset>

                            @include('authentication.includes.nocaptcha', [
                                'button' => [
                                    'title'         => '<i class="ft-unlock"></i> '. __('Send Password Reset Link'),
                                    'attributes'    => ['class' => 'btn round btn-danger btn-block']
                                ]
                            ])

                            {!! Form::close(); !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
