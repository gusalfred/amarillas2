<!DOCTYPE html>
<html lang="es">
@include('shared.head')

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBOBAJodR1EfwjOhSCUwdyshas1nvuAwuI&libraries=places&callback=Maps" async defer></script>

<body id="page-top" class="index">
<!--navbar mobil-->
<nav class="navbar navbar-default navbar-fixed-top home"  id="mobile-nav">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed btn-yellow" data-toggle="collapse" data-target="#menu-collapsible">
        <span class="fa fa-bars fa-lg"></span>
      </button>
    <button class="navbar-toggle btn-search" data-toggle="collapse" data-target="#menu-search">
        <span class="glyphicon glyphicon-search fa fa-lg"></span>
    </button>
      <a href="{{ url('/') }}"><img id="logo"  class="navbar-brand" style="margin-" src="{{asset('images/logo.png')}}"/></a>
    </div>
        <!--menu de sesion y otras cosas-->
    <div class="collapse navbar-collapse" id="menu-collapsible">
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
        <li>
            <a href="{{ url('/login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Iniciar sesión</a>
        </li>
        <li>
            <a style="white-space: nowrap;" href="{{ url('/register') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrarse</a>
        </li>
        @else
          <li class="navbar-text text-center">
              <i class="fa fa-user"></i> {{ Auth::user()->name }} 
          </li>
          <li class=" text-center">
             <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out" aria-hidden="true"></i> Salir
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
          </li>
        @endif
      </ul>
        <form class="navbar-form navbar-left" id="search-md" method="get" action="{{ url('/search/') }}">
            <div class="input-group">
                <input name="q" type="text" class="form-control fsearch" placeholder="¿Que Buscas?">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                       <i class="fa fa-search"></i>
                    </button>
                </span>                
            </div>            
        </form>
    </div>
        
    <div class="collapse navbar-collapse" id="menu-search" style="display:none !important">
       <form class="navbar-form input-group input-group-lg" method="get" action="{{ url('/search/') }}">
            <input name="q" type="text" class="form-control fsearch" placeholder="¿Que Buscas?">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                  <i class="fa fa-search"></i>
                </button>
            </span>            
        </form>
    </div>
  </div>
</nav>
        <!--/navbar movil-->
<header id="a365-header" >
    <div class="container">
        <div class="row">
            <div class=" col-sm-12 col-md-3">
                <a href="{{ url('/') }}"><img id="logo"  style="width:80%" class="img-responsive center-block " src="{{asset('images/logo.png')}}"/></a>
            </div>
            <div class="col-sm-12 col-md-3 col-md-offset-6 text-center" style="padding-top: 15px;" id="session-act">
                @if (Auth::guest())
                <a href="{{ url('/login') }}">
                  <i class="fa fa-sign-in"></i> Iniciar sesión
                </a> |
                <a href="{{ url('register') }}">
                  <i class="fa fa-user-plus"></i> Registrarse
                </a>
                @else
                    <span><i class="fa fa-user"></i> {{ Auth::user()->name }} </span>|
                    <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Salir
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @endif
            </div>
            <div class="col-sm-12 col-md-12 center-block">
            <div class="row">
              <div class="col-sm-12">
                <h3 class="search-title " >
                <p>
                  Encuentra eso que necesitas
                </p>
                </h3>
              </div>              
            </div>            
                <form class="form-search input-group input-group-lg" method="get" action="{{ url('/search/') }}">
                    <input name="q" type="text" class="form-control " placeholder="¿Que Buscas?">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>                    
                </form>
            </div>
        </div>
    </div>
</header>

<div class="banner-home" data-stellar-background-ratio="0.5">
    <div class="container">

    </div>
</div>

<div style="background-color: #eee; margin-bottom: 20px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="masthead">
                    <nav>
                        <ul class="nav nav-justified">
                            <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
                            <li><a href="#"><i class="fa fa-thumbs-o-up"></i> Mas votados</a></li>
                            <li><a href="#"><i class="fa fa-cutlery"></i> Restaurantes</a></li>
                            <li><a href="#"><i class="fa fa-bed"></i> Hoteles</a></li>
                            <li><a href="#"><i class="fa fa-car"></i> Autos</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@yield('content')

@include('shared.footer')

<script>
    $(document).ready(function () {
         $.stellar({horizontalScrolling: false,responsive:true, verticalOffset: 50});
        //$('#input-3').rating({displayOnly: true, step: 0.5});

        var config = {
            url: window.location.href,
            ui: {
                flyout: 'top left',
                button_font: false,
                buttonText: 'Compartir',
                icon_font: false
            },
            networks: {
                googlePlus: {enabled: true, url: ''},
                twitter: {enabled: true, url: '', description: ''},
                facebook: {
                    enabled: true,
                    load_sdk: true,
                    url: '',
                    appId: '',
                    title: '',
                    caption: '',
                    description: '',
                    image: ''
                },
                pinterest: {enabled: true, url: '', image: '', description: ''},
                reddit: {enabled: false},
                linkedin: {enabled: false},
                whatsapp: {enabled: false},
                email: {enabled: false}
            }
        }

        var shareButton = new ShareButton('', config);

    });
    
//LOCALIZACION
function Maps() {
//servicio de geocodificacion
    var geocoder = new google.maps.Geocoder();
    var city;
    //mapa necesario para el servicio de busqueda y geocodificacion
    var map = new google.maps.Map({zoom:15});
    
    //mi ubicación
if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            //geocodificacion de mi posicion
            geocoder.geocode({'location': pos}, function(results, status) {
                if (status === 'OK') {
                    //console.log(results[0].address_components[2].long_name);
                    city=results[0].address_components[2].long_name; //captura mi ciudad
                    searchPlace(pos,city);  //funcion para obtener la foto
                }
              });
            map.setCenter(pos);
          }, function() {
            handleLocationError(true);
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false);
        }
        function handleLocationError(browserHasGeolocation) {
            console.log(browserHasGeolocation ?
                                  'Error: The Geolocation service failed.' :
                                  'Error: Your browser doesn\'t support geolocation.');
          }
          //----servicio de Places-----
      var service = new google.maps.places.PlacesService(map);
      //busqueda de mi ciudad
      function searchPlace(position){
        var request={
            location: position,
            query:city
        };
        service.textSearch(request, callback);
      }
      function callback(results, status) {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    searchPhoto(results[0].place_id);
                }
      }
      //busqueda de foto de mi ciudad
      function searchPhoto(id){
      //console.log(id);
        var request2={
            placeId: id
        };
        service.getDetails(request2, callback2);
      }
      function callback2(result, status) {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    $('.banner-home').css({'background-image': 'url("'+result.photos[0].getUrl({'maxWidth': 2000, 'maxHeight': 2000})+'")','background-size':'cover'});
                }
      }
};
</script>

</body>
</html>
