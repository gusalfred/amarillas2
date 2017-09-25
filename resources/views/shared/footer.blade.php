<div id="footer-box">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <img src="{{asset('images/logo.png')}}" style="width:120px" class=" hidden-sm hidden-xs"/>
                <img src="{{asset('images/logo.png')}}" style="width:120px" class="center-block hidden-lg hidden-md"/><br>
                <b>Amarillas365.com, S.A.</b><br>
                Direccion av entre calles.<br>
                Telefono: 765.43.21
            </div>
            <div class="col-sm-4">
                <ul>
                    <li><a href="{{ URL::to('anuncie/') }}">Anuncie con Nosotros</a></li>
                    <li><a href="{{ URL::to('registro_empresa/') }}">Registre su empresa gratis</a></li>
                </ul>
            </div>
            <div class="col-sm-4">
                <ul>
                    <li><a href="{{ URL::to('nosotros/') }}">Quienes somos</a></li>
                    <li><a href="{{ URL::to('contacto/') }}">Contáctenos</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <p class="hidden-sm hidden-xs text-left">Copyright 2016 &copy; Amarillas 365, Todos los derechos reservados.</p>
                <p class="hidden-md hidden-lg text-center">Copyright 2016 &copy; Amarillas 365, Todos los derechos reservados.</p>
            </div>
            <div class="col-md-5 col-sm-12">
                <ul class="list-inline align-center">
                    <li><a href="{{ url('/politicas_de_privacidad') }}">Politicas de privacidad</a></li>
                    <li><a href="{{ url('/terminos') }}">Terminos y condiciones</a></li>
                </ul>
            </div>
            <div class="col-md-1">
                <ul class="list-inline align-center">
                    <li><a href="#"><i class="fa fa-2x fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-2x fa-facebook"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>