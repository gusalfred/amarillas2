@extends('layouts.interna')

<!-- Main Content -->
@section('content')
<div class="container fullheight" style="margin-top: 80px;" height="300px">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default panel-search">
                <div class="panel-heading"><i class="fa fa-life-ring"></i> Restaurar contraseña</div>
                <div class="panel-body" style="padding:15px">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo Electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    <i class="fa fa-send-o"></i> Enviar
                                </button>
                            </div>
                        </div>
                            
                        <div class="form-group text-center">
                            <small><i class="fa fa-info-circle fa-lg"></i> Asegurate de escribir bien tu E-mail, recibirás un correo para restaurar tu contraseña</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
