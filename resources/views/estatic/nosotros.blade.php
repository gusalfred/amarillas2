@extends('layouts.interna')

@section('content')

        <div class="container fullheight" style="margin-top: 80px;" height="600px">
            <div class="row" >
                <div class="col-md-8 col-sm-12">
                    <h2 class="hidden-sm hidden-xs"><i class="fa fa-users"></i> Quienes somos</h2>
                    <h3 class="hidden-md hidden-lg text-center"><i class="fa fa-users fa-lg"></i><br> Quienes somos</h3>
                    <p class="text-justify">Amarillas 365 es un directorio digital de productos, servicios y profesionales que permite la
                        interacción directa del anunciante a fin de facilitar la búsqueda del consumidor final, complementado
                        la misma con opiniones y anécdotas, además de la utilización de redes sociales que persiguen una
                        retroalimentación eficiente.</p>

                    <p class="text-justify">Basada en la aplicación de técnicas de búsquedas avanzadas, amarillas365.com
                        busca posicionarse como uno de los mejores motores de búsqueda en internet, garantizando al usuario resultados
                        efectivos al instante, fundamentados en una profunda captación de anunciantes confiables mediante técnicas de
                        venta directa que aseguren a la vez el éxito del capital humano.</p>
                </div>
                <div class="col-md-4 col-sm-12">
                    <img id="logo" src="{{asset('images/logo.png')}}" class="img-responsive center-block"/>
                </div>
            </div>
        </div>

@endsection
