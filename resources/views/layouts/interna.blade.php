<!DOCTYPE html>
<html lang="es">
@include('shared.head')
<body id="page-top" class="index">
<!--navbar mobil-->
<nav class="navbar navbar-default navbar-fixed-top"  id="mobile-nav" style="top:0px">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle btn-menu btn-yellow" data-toggle="collapse" data-target="#menu-collapsible">
        <span class="fa fa-bars fa-lg"></span>
      </button>
      <button type="submit" class="navbar-toggle btn-search" data-toggle="collapse" data-target="#menu-collapsible">
          <span class="glyphicon glyphicon-search fa fa-lg"></span>
      </button>
      <a href="{{ url('/') }}"><img id="logo"  class="navbar-brand" src="{{asset('images/logo.png')}}"/></a>
    </div>
        <!--menu de sesion y otras cosas-->
    <div class="collapse navbar-collapse" id="menu-collapsible">
      <form class="navbar-form navbar-left search-md" method="get" action="{{ url('/search/') }}">
          <div class="input-group">
              <input name="q" type="text" class="form-control fsearch" placeholder="¿Que Buscas?">
              <span class="input-group-btn">
                  <button type="submit" class="btn btn-default">
                      <span class="glyphicon glyphicon-search"></span>
                  </button>
                  <button  class="btn btn-danger hidden limpiar">
                      <i class="fa fa-close"></i>
                  </button>
              </span>                
          </div>            
      </form>
      <ul class="nav navbar-nav navbar-right" id="menuUser">
        @if (Auth::guest())
        <li>
            <a href="{{ url('/login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Iniciar sesión</a>
        </li>
        <li>
            <a href="{{ url('/register') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrarse</a>
        </li>
        @else
          <li class="navbar-text text-center">
              <i class="fa fa-user"></i> {{ Auth::user()->name }} 
          </li>
          <li class=" text-center">
             <a href="{{ url('/logout') }}" class="text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out" aria-hidden="true"></i> Salir
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
          </li>
        @endif
      </ul>
    </div>
    <!--barra de busqueda en navbar
    <div class="collapse navbar-collapse" id="menu-search">
       <form class="navbar-form" method="get" action="{{ url('/search/') }}">
        <div class="input-group input-group-lg">
          <input name="q" type="text" class="form-control fsearch mobileSearch" placeholder="¿Que Buscas?">
          <span class="input-group-btn">
              <button  class="btn btn-danger hidden limpiar">
                      <i class="fa fa-close"></i>
              </button>
              <button type="submit" class="btn btn-default">
                 Ir
              </button>
          </span> 
        </div>
       </form>       
    </div>-->
  </div>
</nav>
<!--/navbar movil-->



@yield('content')
@include('shared.footer')

    <!-- JavaScripts -->
    <script src="{{ asset('js/slick.min.js') }}"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

<script>
    $(document).ready(function() {
    //popover
     $('[data-toggle="popover"]').popover({
      html:true,
      content: $('#telfPlus').html()
     });
     //tooltip
     $('[data-toggle="tooltip"]').tooltip({
      html: true,
      content: 'limpiar puntuación'
     });
     //dropdown
     $('[data-toggle="dropdown"]').dropdown();
     
        $('.slider').slick({
            infinite: true,
            dots:true,
            speed: 300,
            adaptiveHeight:false,
            variableWidth:true,
            centerMode:true,
            prevArrow:'<button class="btn btn-default slick-prev2 text-center"><i class="fa fa-lg fa-chevron-left"></i></button>',
            nextArrow:'<button class="btn btn-default slick-next2 text-center pull-right"><i class="fa fa-lg fa-chevron-right"></i></button>',
            responsive: [{
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 1,
                  dots: true
                }
              },
              {
                breakpoint: 600,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 1,
                  arrows: true
                }
              },
              {
                breakpoint: 480,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  dots:true,
                  arrows: false
                }
              }
            ]});

        var config = {
            url: window.location.href,
            ui: {
                flyout: 'top left',
                button_font: false,
                buttonText: 'Compartir',
                icon_font: true
            },
            networks: {
                googlePlus: { enabled: true, url: ''},
                twitter: { enabled: true, url: '', description: ''},
                facebook: { enabled: true, load_sdk: true, url: '', appId: '', title: '', caption: '', description: '', image: ''},
                pinterest: { enabled: true, url: '', image: '', description: ''},
                reddit: { enabled: false},
                linkedin: { enabled: false},
                whatsapp: { enabled: false},
                email: { enabled: false}
            }
        }

        var shareButton = new ShareButton('', config);

    });
</script>

</body>
</html>
