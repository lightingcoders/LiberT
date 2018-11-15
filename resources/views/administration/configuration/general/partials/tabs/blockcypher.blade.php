<div class="card border-top-primary">
    <div class="card-head">
        <div class="card-header">
            <h4 class="card-title">{{__('BlockCypher')}}</h4>
        </div>
    </div>

    <div class="card-content">
        <div class="card-body">
            {!! Form::open(['url' => route('administration.configuration.general.update'), 'class' => 'form form-horizontal', 'method' => 'POST']) !!}
            <div class="form-body">
                <h4 class="form-section"><i class="ft-server"></i> {{__('BLOCKCHAIN')}}</h4>
                <div class="form-group row">
                    {!! Form::label('BLOCKCYPHER_TOKEN', 'Token', ['class' => 'col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::text('BLOCKCYPHER_TOKEN', $env['BLOCKCYPHER_TOKEN']['value'], ['class' => 'form-control']) !!}
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
