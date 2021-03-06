<div class="card border-top-primary">
    <div class="card-head">
        <div class="card-header">
            <h4 class="card-title">{{__('Google')}}</h4>
        </div>
    </div>

    <div class="card-content">
        <div class="card-body">
            {!! Form::open(['url' => route('administration.configuration.general.update'), 'class' => 'form form-horizontal', 'method' => 'POST']) !!}
            <div class="form-body">
                <h4 class="form-section"><i class="ft-shield"></i> {{__('RECAPTCHA')}}</h4>
                <div class="form-group row">
                    {!! Form::label('NOCAPTCHA_ENABLE', 'Enable', ['class' => 'col-md-3']) !!}
                    <div class="col-md-9">
                        @php $options = ['true' => 'Yes', 'false' => 'No']; @endphp
                        {!! Form::select('NOCAPTCHA_ENABLE', $options, $env['NOCAPTCHA_ENABLE']['value'], ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('NOCAPTCHA_SECRET', 'Secret', ['class' => 'col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::text('NOCAPTCHA_SECRET', $env['NOCAPTCHA_SECRET']['value'], ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('NOCAPTCHA_SITEKEY', 'Site Key', ['class' => 'col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::text('NOCAPTCHA_SITEKEY', $env['NOCAPTCHA_SITEKEY']['value'], ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="form-actions right">
                <button type="submit" class="btn ladda-button btn-primary">
                    {{__('UPDATE')}}
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
