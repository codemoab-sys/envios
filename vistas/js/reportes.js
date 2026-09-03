if(localStorage.getItem("capturarRango2") != null){

    $("#reportrange2 span").html(localStorage.getItem("capturarRango2"));


} else {

     $("#reportrange2 span").html('<i class="fa fa-calendar"> rango de fecha </i>');
    

}


/*=============================================
RANGO DE FECHAS
=============================================*/

var start = moment();
var end = moment();


function cb(start, end) {

    $('#reportrange2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    
    var fechaInicial = start.format('YYYY-MM-DD');

    var fechaFinal = end.format('YYYY-MM-DD');
    
    var capturarRango2 = $("#reportrange2 span").html();

    localStorage.setItem("capturarRango2", capturarRango2);

    window.location = "index.php?ruta=reportes&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;





}



$('#reportrange2').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Hoy': [moment(), moment()],
           'ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'ultimos 7 dias': [moment().subtract(6, 'days'), moment()],
           'ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
           'este mes': [moment().startOf('month'), moment().endOf('month')],
           'ultimo mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
}, cb);

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

$(".daterangepicker.opensright .drp-buttons .cancelBtn").on("click",function(){

    localStorage.removeItem("capturarRango2");
    localStorage.clear();
    window.location = "reportes";


})



/*=============================================
CAPTURAR HOY
=============================================*/

$(".daterangepicker.opensright .ranges li").on("click" ,function(){


    var textoHoy = $(this).attr("data-range-key");


    if(textoHoy=="Hoy"){

        var d = new Date();


        var dia = d.getDate();
        var mes = d.getMonth() + 1;
        var año = d.getFullYear();


        if(mes < 10){

            var fechaInicial = año + "-0" + mes + "-" + dia;
            var fechaFinal = año + "-0" + mes + "-"+dia;

            console.log(fechaInicial)



        } else if (dia < 10) {

             var fechaInicial = año + "-" + mes + "-0" + dia;
            var fechaFinal = año + "-" + mes + "-0"+dia;
            

        } else if (mes < 10 && dia < 10) {

               var fechaInicial = año + "-0" + mes + "-0" + dia;
            var fechaFinal = año + "-0" + mes + "-0"+dia;
            


        }

        localStorage.setItem("capturarRango2", "Hoy");

        window.location = "index.php?ruta=reportes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;


    }

})