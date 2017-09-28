/*!
 * Start Bootstrap - Agency Bootstrap Theme (http://startbootstrap.com)
 * Code licensed under the Apache License v2.0.
 * For details, see http://www.apache.org/licenses/LICENSE-2.0.
 */

/*funcion para mostrar y oculata elementos segun el ancho de la pag*/

function showHide(){
    var WinWidth=$(window).width();   //captura la anchura
    if(WinWidth<=750){
       $('#menu-collapsible form').removeClass('search-md');
       $('#menu-collapsible .input-group').addClass('input-group-lg');
    }else{
        //$('#menu-search').attr('style','display:none !important');
        $('#menu-collapsible form').addClass('search-md');
        $('#menu-collapsible .input-group').removeClass('input-group-lg');
    }
}
//altura completa
function allHeight(){
  var WinWidth=$(window).width();   //captura la anchura
    var tamano= $('.fullheight').attr('height'); //captura el alto del elemento especificado por este atributo
    if(WinWidth<=750){        //si la anhura de la pantalla es menor adapta la altura al tamaño especificado
      $('.fullheight').outerHeight(tamano);
    }else{        //si no captura la altura de la ventana y de las 2 partes q conforman el footer para darle el tamaño al conenido
       var WinHeight=$(window).height();
        var foot1H= $('#footer-box').outerHeight(true);
        var foot2H= $('footer').outerHeight(true);
        $('.fullheight').outerHeight(WinHeight-foot1H-foot2H-80);
    }
    
}

$(window).resize(function(){
    allHeight();
    showHide();
    });

//document ready ejecuta las funciones de cuadre de elementos
$(document).ready(function(){
  $('[name="q"]').val('');
    showHide();
    allHeight(false);
    });

//funciones en scroll
$(window).scroll(function() {
    if ($(document).scrollTop() > 240) {
        $('#menu-collapsible').collapse('hide');
        $('.home').css('top','0px');
    }
    if ($(document).scrollTop() < 240) {
         $('.home').css('top','-100px');
    }
});
function botonLimpia(){
  
}
$(document).on('keyup','[name="q"]',function(){
    var valor=$(this).val();
    $('[name="q"]').val(valor);
    if(valor !== ''){
      $('.limpiar').removeClass('hidden');
    }else{
      $('.limpiar').addClass('hidden');
    }
  });

$(document).on('click','.limpiar',function(e){
  e.preventDefault();
  $('.limpiar').addClass('hidden');
  $('[name="q"]').val('');
  });