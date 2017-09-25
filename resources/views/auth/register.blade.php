@extends('layouts.interna')

@section('title') Registro @endsection

@section('content')
<div class="container" style="margin-top:80px">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default panel-search">
                <div class="panel-heading" ><i class="fa fa-user-plus"></i> Registro</div>
                <div class="panel-body" style="padding:15px">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        
                        <!--nombre-->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} has-feedback">
                            <label for="name" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                <span class="fa fa-tag form-control-feedback"></span>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            
                         <!--correo-->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}  has-feedback">
                            <label for="email" class="col-md-4 control-label">Correo electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                <span class="fa fa-envelope form-control-feedback"></span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            
                         <!--contraseña-->
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                                <span class="fa fa-key form-control-feedback"></span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            
                         <!--contraseña confirm-->
                        <div class="form-group has-feedback">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                <span class="fa fa-key form-control-feedback">*</span>
                            </div>
                        </div>

                        {!! Recaptcha::render() !!}
                        
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" class=" btn btn-primary btn-lg btn-block">
                                    <i class="fa fa-fw fa-sign-in"></i> Registrarse
                                </button>
                            </div>
                        </div>                        

                        <hr>
                        
                        <!--registro por sociales-->
                        <div class="row " style="margin-top:-32px">
                            <div class="col-md-6 col-md-offset-3 col-sm-12 text-center">
                                <b style="background:white"><span>Ó</span></b><br> Registrate a travéz de las redes sociales
                            </div>

                            <div class="col-md-6 col-md-offset-3 col" style="margin-top: 15px;">
                                <a class="btn btn-md btn-primary" style="background-color: #3b5998; width: 100%;" href="{{ url('/redirect/facebook') }}">
                                    <i class="fa fa-fw fa-facebook-square fa-2x"></i>  Iniciar sesión con Facebook
                                </a>
                            </div>

                            <div class="col-md-6 col-md-offset-3" style="margin-top: 15px;">
                                <a class="btn btn-md btn-primary" style="background-color: #00aced; width: 100%;" href="{{ url('/redirect/twitter') }}">
                                    <i class="fa fa-fw fa-twitter-square fa-2x"></i>  Iniciar sesión con Twitter
                                </a>
                            </div>

                            <div class="col-md-6 col-md-offset-3" style="margin-top: 15px;">
                                <a class="btn btn-md btn-primary" style="background-color: #CC3335; width: 100%;" href="{{ url('/redirect/google') }}">
                                    <i class="fa fa-fw fa-google-plus-square fa-2x"></i>  Iniciar sesión con Google+
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
