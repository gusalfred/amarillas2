@extends('layouts.interna')

@section('title') Iniciar sesión @endsection

@section('content')
<div class="container" style="margin-top:80px">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default panel-search">
                <div class="panel-heading"><i class="fa fa-sign-in"></i> Iniciar sesión</div>
                <div class="panel-body" style="padding:15px">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox2">
                                    <label>
                                        <input type="checkbox" name="remember"> Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    <i class="fa fa-fw fa-sign-in" aria-hidden="true"></i> Entrar
                                </button>
                            </div>                            
                        </div>
                            
                        <div class="form-group text-center">
                            <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                ¿Olvido su Contraseña? <i class="fa fa-life-ring"></i>
                            </a>
                        </div>
                        <hr>
                        <!--botones sesion social-->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
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
