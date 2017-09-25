/*!
 * Start Bootstrap - Agency Bootstrap Theme (http://startbootstrap.com)
 * Code licensed under the Apache License v2.0.
 * For details, see http://www.apache.org/licenses/LICENSE-2.0.
 */

/*funcion para mostrar y oculata elementos segun el ancho de la pag*/
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});


function showHide(){
    var WinWidth=$(window).width();
    //console.log(WinWidth);
    
    if(WinWidth<=750){
       $('#menu-search').attr('style','display:').collapse('hide');
       $('#search-md').css('display','none');
    //console.log('mostrar navbar de busqueda');
    }else{
        $('#menu-search').attr('style','display:none !important');
        $('#search-md').css('display','block');
        //console.log('esconder navbar de busqueda');
    }
}
function allHeight(){
    var WinWidth=$(window).width();
    var tamano= $('.fullheight').attr('height');
    if(WinWidth<=750){
      $('.fullheight').outerHeight(tamano);
      //console.log('es pequeño');
    }else{
       var WinHeight=$(window).height();
        var foot1H= $('#footer-box').outerHeight(true);
        var foot2H= $('footer').outerHeight(true);
        //console.log('window: '+WinHeight+', foot1: '+foot1H+', foot2: '+foot2H+' compH: '+parseInt(WinHeight-foot1H-foot2H));
        $('.fullheight').outerHeight(WinHeight-foot1H-foot2H-80);
    }
    
}
$(window).resize(function(){
    allHeight();
    showHide();
    });
$(document).ready(function(){
    showHide();
    allHeight(false);
    });


$(window).scroll(function() {
   $('[data-toggle="popover"]').popover('hide');
    if ($(document).scrollTop() > 240) {
        $('.home').css('top','0px');
    }
    if ($(document).scrollTop() < 240) {
         $('.home').css('top','-100px');
    }
});
