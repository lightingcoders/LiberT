<div class="card border-top-primary">
    <div class="card-head">
        <div class="card-header">
            <h4 class="card-title">{{__('Global')}}</h4>
        </div>
    </div>

    <div class="card-content">
        <div class="card-body">
            {!! Form::open(['url' => route('administration.configuration.general.update'), 'class' => 'form form-horizontal', 'method' => 'POST']) !!}
            <div class="form-body">
                <h4 class="form-section"><i class="ft-globe"></i> {{__('APPLICATION')}}</h4>

                <div class="form-group row">
                    {!! Form::label('APP_NAME', 'Name', ['class' => 'col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::text('APP_NAME', $env['APP_NAME']['value'], ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('APP_DESCRIPTION', 'Description', ['class' => 'col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::textarea('APP_DESCRIPTION', $env['APP_DESCRIPTION']['value'], ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('APP_KEYWORDS', 'Keywords', ['class' => 'col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::text('APP_KEYWORDS', $env['APP_KEYWORDS']['value'], ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('APP_SHORTCUT_ICON', 'Shortcut Icon', ['class' => 'col-md-3']) !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group-prepend"> <span class="input-group-text"><i class="ft-link"></i></span> </div>

                            {!! Form::text('APP_SHORTCUT_ICON', $env['APP_SHORTCUT_ICON']['value'], ['class' => 'form-control']) !!}
                        </div>

                        <p class="text-left">
                            <small class="text-muted">
                                {{__('Make sure the image complies with the dimension')}}
                                <code>16</code> x <code>16</code>
                            </small>
                        </p>
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('APP_LOGO_ICON', 'Logo Icon', ['class' => 'col-md-3']) !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group-prepend"> <span class="input-group-text"><i class="ft-link"></i></span> </div>

                            {!! Form::text('APP_LOGO_ICON', $env['APP_LOGO_ICON']['value'], ['class' => 'form-control']) !!}
                        </div>

                        <p class="text-left">
                            <small class="text-muted">
                                {{__('Make sure the image complies with the dimension')}}
                                <code>30</code> x <code>30</code>
                            </small>
                        </p>
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('APP_LOGO_BRAND', 'Logo Brand', ['class' => 'col-md-3']) !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group-prepend"> <span class="input-group-text"><i class="ft-link"></i></span> </div>

                            {!! Form::text('APP_LOGO_BRAND', $env['APP_LOGO_BRAND']['value'], ['class' => 'form-control']) !!}
                        </div>

                        <p class="text-left">
                            <small class="text-muted">
                                {{__('Make sure the image complies with the dimension')}}
                                <code>180</code> x <code>40</code>
                            </small>
                        </p>
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

        <div class="card-body">
            {!! Form::open(['url' => route('administration.configuration.general.update'), 'class' => 'form form-horizontal', 'method' => 'POST']) !!}
            <div class="form-body">
                <h4 class="form-section"><i class="ft-server"></i> {{__('BROADCAST')}}</h4>

                <div class="form-group row">
                    {!! Form::label('BROADCAST_DRIVER', 'Driver', ['class' => 'col-md-3']) !!}
                    <div class="col-md-9">
                        {!! Form::select('BROADCAST_DRIVER', get_broadcast_drivers(), $env['BROADCAST_DRIVER']['value'], ['is' => 'select2', 'class' => 'form-control', 'v-model' => 'form.settings.broadcast_driver']) !!}
                    </div>
                </div>

                <div v-if="form.settings.broadcast_driver === 'pusher'">
                    <div class="form-group row">
                        {!! Form::label('PUSHER_APP_ID', 'App Id', ['class' => 'col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('PUSHER_APP_ID', $env['PUSHER_APP_ID']['value'], ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('PUSHER_APP_KEY', 'App Key', ['class' => 'col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('PUSHER_APP_KEY', $env['PUSHER_APP_KEY']['value'], ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('PUSHER_APP_SECRET', 'App Secret', ['class' => 'col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('PUSHER_APP_SECRET', $env['PUSHER_APP_SECRET']['value'], ['class' => 'form-control']) !!}
                        </div>
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
