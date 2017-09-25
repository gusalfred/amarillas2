@extends('layouts.interna')

@section('title') {{ $empresa->nombre }} @endsection

@section('content')
<style>
    .panel{
        background:#f2f2f2;
    }
</style>
<div style="background-color: #EDEDED; margin-top: 50px;">
     <div class="container">
        <div class="row">
             <div class="col-md-12 col-sm-12" style="margin-bottom: 20px;">
                <h3 style="margin-bottom: 0;">{{ $empresa->nombre }}</h3>
                <p>{{ $empresa->direccion }}</p>
                <div class="rateit" data-rateit-value="{{ $empresa->estrellas }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
             </div>
        </div>
     </div>
</div>
<div class="container">
    <div class="row" style="margin-top: 20px;">
        <!--info-->    
        <div class="col-md-8 col-xs-12">
        {{--@if($imagen )
            <img src="{{ asset('uploads/media/'.$imagen->archivo) }}" style="display: block;" class="img-responsive" alt="">
             @endif--}}
            <div class="row">
                <div class="col-md-12">
                    <h5 style="font-size: 11px; color: #CCC; text-align: center;margin:0px">Avisos </h5>
                    <img src="{{ url('uploads/avisos/'.$empresa->archivo) }}" class="img-responsive center-block" alt="">
                </div> 
                <div class="col-md-12">
                     <p class="text-justify">
                     {{ isset($empresa->descripcion) ? $empresa->descripcion:'Sin descripción'}}
                     </p>
                    <div class="panel panel-default">
                        <div class="panel-body row">
                            <div class="col-md-3 col-xs-12" style="margin-top: 10px">
                                <i class="fa fa-2x fa-phone"></i>
                                <?php $telefonos = explode(",", $empresa->telefonos) ?>    
                                @if(count($telefonos) == 1)
                                        @if( $telefonos[0] == '')
                                            s/n
                                        @else
                                            {{ $telefonos[0] }}
                                        @endif
                                @else
                                    <a class="" data-toggle="popover" data-placement="top" data-content="@foreach ($telefonos as $tel) {{ $tel }}<br> @endforeach">
                                        {{ $telefonos[0] }} <i class="fa fa-caret-down"></i>
                                    </a>
                                @endif    
                            </div>
                            <div class="col-md-3  col-xs-12 " style="margin-top: 10px">
                                <a href="mailto:{{ $empresa->email }}"><i class="fa fa-2x fa-envelope-o"></i> Contactar</a>
                            </div>
                            <div class="col-md-3  col-xs-12 " style="margin-top: 10px">
                                <a target="_blank" href="{{ $empresa->web }}"><i class="fa fa-2x fa-globe "></i> Website </a>
                            </div>
                            <div class="col-md-3  col-xs-12 " style="margin-top: 10px">
                                <a><i class="fa fa-2x fa-plus"></i> Info</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--fotos-->
                <div class="col-md-12">
                    <h4 style="margin:0px"><i class="fa fa-picture-o fa-lg"></i> Más fotos</h4>
                        <div class="row">
                            <div class="slider col-md-12 col-xs-12" >
                            @if (count($imagenes)>0)
                                @foreach ($imagenes as $img)
                                <div class="slider-item">
                                    <img src="{{asset('uploads/media/'.$img->archivo )}}">
                                </div>
                                @endforeach
                            @else
                                <div class="slider-item">
                                    <img src="{{ url('uploads/categorias/no.jpg') }}" style="height: 200px;">
                                    <p class="text-center">No hay mas fotos <i class="fa fa-meh-o"></i> </p>
                                </div>
                            @endif
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!--mapa y social-->
        <div class="col-md-4 col-xs-12" style="margin-top:10px">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body" style="padding:0px">
                        <div id="map" style="height: 270px;"></div>
                        <script type="text/javascript">
                            function initMap() {
                                var myLatLng = {lat: {{ $empresa->latitud }}, lng: {{ $empresa->longitud }} };
                    
                                var map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 13,
                                    mapTypeControl: false,
                                    streetViewControl: false,
                                    fullscreenControl: false,
                                    center: myLatLng
                                });
                    
                                var marker = new google.maps.Marker({
                                    position: myLatLng,
                                    map: map,
                                    title: '{{ $empresa->nombre }}'
                                });
                            }
                        </script>
                        <script async defer
                                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOBAJodR1EfwjOhSCUwdyshas1nvuAwuI&callback=initMap">
                        </script>
                    </div>
                    <div class="panel-footer map-box">
                       <h4><a href="#" data-toggle="modal" data-target="#direc"><i class="fa fa-dot-circle-o"></i> Ver todas las sucursales</a></h4>
                    </div>
                </div>
                <div class="col-md-12" style="font-size: 14px;">
                     <h4 style="vertical-align:middle"><i class=" glyphicon glyphicon-print"></i> Imprimir direcciones</h4>
                </div>
                <div class="col-md-12">
                    <h4>Redes sociales</h4>
                    @foreach($redes as $red)
                        <a href="{{ $red->url }}" target="_blank"><p><i class="{{ $red->icon_class }} fa-2x" style="color: {{ $red->color }};"></i></p></a>
                    @endforeach
                </div>
            </div>
        </div>
        <!--comments-->
        <div class="col-md-8 col-xs-12">
            <h4><i class="fa fa-comment-o"></i> {{ count($comentarios)  }} Comentarios</h4>
          <hr>
            @if ( Auth::guest() )
                Debes <a class="btn-link" href="{{ url('/login') }}"> iniciar sesión</a> para poder comentar
            @else
            <form class="" method="post" action="{{ url('/comentar') }}" >
                {{ csrf_field() }}
                <input type="hidden" name="id_empresa" value="{{ $empresa->id_empresa }}">
                <input type="hidden" name="id_empresa_direccion" value="{{ $empresa->id_empresa_direccion }}">
                <div class="form-group">
                    <textarea cols="70" rows="2" class="form-control" name="comentario" placeholder="Comentario" required></textarea>
                </div>
               <div class="form-group row">
                    <select id="valor" name="valor">
                         <option value="1">1</option>
                         <option value="2">2</option>
                         <option value="3">3</option>
                         <option value="4">4</option>
                         <option value="5">5</option>
                    </select>
                    <div class="col-md-8 col-xs-12">
                         <b class="text-center" >Valora esta empresa: </b>
                         <div class="rateit" data-rateit-backingfld="#valor" data-rateit-min="0" style="vertical-align:text-top"></div>                    
                    </div>
                    <div class="col-md-4 col-xs-12 text-center">
                         <button type="submit" class="btn btn-success"><i class="fa fa-commenting-o"></i> Comentar</button>
                    </div>                    
               </div>                
            </form>
            @endif
            <hr>
            @foreach ($comentarios as $comentario)
                <div class="media">
                    <div class="media-left">
                            <img class="media-object img-circle" src="{{ url('uploads/foto.png') }}" width="60">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">{{ $comentario->name }}</h5>
                        <div>{{ $comentario->comentario }}</div>
                        <div class="rateit" data-rateit-value="{{ $comentario->valor }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="direc" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
                <h4 class="modal-title" id="myModalLabel">Sucursales</h4>
            </div>
            <div class="modal-body list-goup" style="padding:0px">
                @foreach($direcciones as $direccion)
                    <a class="list-group-item" style="border-radius:0px"><i class="fa fa-building"></i> {{ $direccion->direccion }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
<aside id="sticky-social" class="hidden-xs">
    <ul>
        <li><a href="#" class="entypo-facebook" target="_blank"><i class="fa fa-facebook-square fa-2x"></i> <span>Facebook</span></a></li>
        <li><a href="#" class="entypo-twitter" target="_blank"><i class="fa fa-twitter-square fa-2x"></i> <span>Twitter</span></a></li>
        <li><a href="#" class="entypo-instagrem" target="_blank"><i class="fa fa-instagram fa-2x"></i> <span>Instagram</span></a></li>
    </ul>
</aside>
@endsection
