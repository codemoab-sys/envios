
if(localStorage.getItem("capturarRango") != null){

    $("#reportrange span").html(localStorage.getItem("capturarRango"));


} else {

     $("#reportrange span").html('<i class="fa fa-calendar"> rango de fecha </i>');
    

}



/*=============================================
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/


$(".tablas tbody").on("click", "button.agregarProducto ", function () {

    var idProducto = $(this).attr("idProducto");

   // console.log(idProducto);

    $(this).removeClass("btn-primary agregarProducto");

    $(this).addClass("btn-default");

    var datos = new FormData();


    datos.append("idProducto", idProducto);


    $.ajax({
        url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
        dataType: "json",
        success(respuesta){
            
            var descripcion = respuesta["descripcion"];
            var stock = respuesta["stock"];
            var precio = respuesta["precio_venta"];
            var foto= respuesta["imagen"];


            if (stock == 0) {

                Swal.fire({
                    title: 'no hay stock disponible',
                    type: 'error',
                    confirmButtonText: "¡Cerrar!"
                                        
                });

                $("button.recuperarBoton[idProducto='" + idProducto + "']").addClass("btn-primary agregarProducto");


            }
          



            $(".nuevoProducto").append(


                '<div class="row" style="padding:5px 15px">' +
                
                                    '<div class="col-xs-5" style="padding-right:0px">'+

                                        '<div class="input-group">'+

                                            '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+

                                            '<input type="text" class="form-control nuevaDescripcionProducto" id="agregarProducto" value="'+descripcion+'" name="agregarProducto" placeholder="Descripción del producto" required idProducto="'+idProducto+'">'+

                                        '</div>'+

                                    '</div>'+
                                    

                                  

                                    '<div class="col-xs-2 ingresoCantidad">'+

                                        '<input type="number" class="form-control nuevaCantidadProducto"  name="nuevaCantidadProducto" stock="'+stock+'" nuevoStock="'+Number(stock-1)+'" min="1" placeholder="0" required>'+

                                    '</div>'+

                                  
                                    '<div class="col-xs-2 ingresoPrecio " style="padding-left:0px">'+

                                        '<div class="input-group">'+

                                            '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+

                                            '<input type="number" min="1" class="form-control nuevoPrecioProducto"  name="nuevoPrecioProducto" value="'+precio+'" precioReal="'+precio+'"  readonly required>'+

                                       ' </div>'+
                                    '</div>' +
                



                                    '<div class="col-xs-2" style="padding-left:0px">'+

                                        '<td><img src="'+foto+'"  width="40px"></td>'+
                                    '</div>' +
                              '</div>' );



                              sumarTotalPrecios()
                              agregarImpuesto()
                              listarProductos()
                              
                        
        }



    })

    
})


/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/


$(".formularioVenta").on("click", "button.quitarProducto ", function () { 


    $(this).parent().parent().parent().parent().remove();

    var idProducto = $(this).attr("idProducto");

    $("button.recuperarBoton[idProducto='" + idProducto + "']").removeClass("btn-default");

    $("button.recuperarBoton[idProducto='" + idProducto + "']").addClass("btn-primary agregarProducto");

    if($(".nuevoProducto").children().length == 0) {
    
        $("#nuevoTotalVenta").val(0);


    }else{

        sumarTotalPrecios()
        
        agregarImpuesto()

        listarProductos()
            
            
    }



    

})



/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA DISPOSITIVOS MOVILES
=============================================*/
var numProducto = 0;

$(".btnAgregarProducto").click(function () {

    numProducto++;
    

    var datos = new FormData();

    datos.append("traerProductos", "ok");


    $.ajax({

        url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
        dataType: "json",
        success(respuesta) { 

           


            $(".nuevoProducto").append(


                '<div class="row" style="padding:5px 15px">' +
                
                                    '<div class="col-xs-5" style="padding-right:0px">'+

                                        '<div class="input-group">'+

                                            '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto"><i class="fa fa-times"></i></button></span>'+

                 
                                        
                                        '<select class="form-control nuevaDescripcionProducto" id="producto' + numProducto + '" idProducto name="nuevaDescripcionProducto" required>' +
                                        
                                        '<option>Seleccione el producto</option>' +
                   
                                        '</select>'+  

                                        '</div>'+

                                    '</div>'+
                                    

                                  

                                    '<div class="col-xs-2 ingresoCantidad">'+

                                        '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" stock  nuevoStock min="1" placeholder="0" required>'+

                                    '</div>'+

                                  
                                    '<div class="col-xs-2 ingresoPrecio"    style="padding-left:0px">'+

                                        '<div class="input-group">'+

                                            '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+

                                            '<input type="number" min="1" class="form-control nuevoPrecioProducto" name="nuevoPrecioProducto"  precioReal=""    readonly required>'+

                                       ' </div>'+
                                    '</div>' +
                



                                    '<div class="col-xs-2 fotoProducto " style="padding-left:0px">'+

                                        '<td><img  src="" width="40px"></td>'+
                                    '</div>' +
                              '</div>' );




            respuesta.forEach(funcionForEach);


            function funcionForEach(item, index) {
                
                if (item.stock != 0) {

                    $("#producto" + numProducto).append(


                        '<option idProducto="'+item.id+'" value="'+item.descripcion+'">'+item.descripcion+'</option>'


                    )




                }


            }


            sumarTotalPrecios()

            agregarImpuesto()

        }

    })

})


/*=============================================
SELECCIONAR PRODUCTO
=============================================*/

$(".formularioVenta").on("change", "select.nuevaDescripcionProducto", function () {
    

    var nombreProducto = $(this).val();


    var nuevaDescripcionProducto = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionProducto");

    
    var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

     var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");



    var fotoProducto = $(this).parent().parent().parent().children(".fotoProducto").children();

    //console.log(nuevaDescripcionProducto)

  

    




    //console.log(nuevoPrecioProducto)





    var datos = new FormData();
    datos.append("nombreProducto",nombreProducto)


    $.ajax({

        url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
        dataType: "json",
        success(respuesta) { 

            $(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
            $(nuevaCantidadProducto).attr("stock", respuesta["stock"]);
            $(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["stock"])-1);
            $(nuevoPrecioProducto).val(respuesta["precio_venta"]);
            $(fotoProducto).attr("src", respuesta["imagen"]);
            $(nuevoPrecioProducto).attr("precioReal", respuesta["precio_venta"]);


            listarProductos()

           

        }

    })


})


/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioVenta").on("change", "input.nuevaCantidadProducto", function () {


    var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

    //console.log(precio)

    var precioFinal = $(this).val() * precio.attr("precioReal");

   //console.log(precioFinal);

    precio.val(precioFinal);

    var nuevoStock = Number($(this).attr("stock")) - $(this).val();

    $(this).attr("nuevoStock", nuevoStock);


    if (Number($(this).val()) > Number($(this).attr("stock"))) {
        
        	/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/

        $(this).val(0);

        $(this).attr("nuevoStock", $(this).attr("stock"));

        //var precioFinal = $(this).val() * precio.attr("precioReal");
        
        precio.val(precio.attr("precioReal"));

        sumarTotalPrecios()


        Swal.fire({
	      title: "La cantidad supera el Stock",
	      text: "¡Sólo hay "+$(this).attr("stock")+" unidades!",
	      type: "error",
	      confirmButtonText: "¡Cerrar!"
	    });

	    return;



    }


    sumarTotalPrecios()

    agregarImpuesto()

    listarProductos()



 })

 /*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/


function sumarTotalPrecios() {
    

    var precioItem = $(".nuevoPrecioProducto");

    var arraySumaPrecio = [];

    for (var i = 0; i < precioItem.length; i++){
        
        arraySumaPrecio.push(Number($(precioItem[i]).val()));
       

       // console.log(arraySumaPrecio);



    }

    function sumarArrayPrecios(total, numero) {
        
        return total + numero;
        
    }


    var sumaTotalPrecio = arraySumaPrecio.reduce(sumarArrayPrecios);

    $("#nuevoTotalVenta").val(sumaTotalPrecio);

    $("#nuevoTotalVenta").attr("total", sumaTotalPrecio);





}


/*=============================================
FUNCIÓN AGREGAR IMPUESTO
=============================================*/

function agregarImpuesto(){

    var impuesto = $("#nuevoImpuestoVenta").val();
    var precioTotal = $("#nuevoTotalVenta").attr("total");


    var precioImpuesto = Number(precioTotal * impuesto / 100);

    var totalConImpuesto = Number(precioImpuesto) + Number(precioTotal);

    $("#nuevoTotalVenta").val(totalConImpuesto);

    $("#totalVenta").val(totalConImpuesto);

    $("#nuevoPrecioImpuesto").val(precioImpuesto);

    $("#nuevoPrecioNeto").val(precioTotal);




}

/*=============================================
CUANDO CAMBIA EL IMPUESTO
=============================================*/

$("#nuevoImpuestoVenta").change(function () {
    

    agregarImpuesto();


})


/*=============================================
SELECCIONAR MÉTODO DE PAGO
=============================================*/
$("#nuevoMetodoPago").change(function(){


    var metodo = $(this).val();

   // console.log(metodo)


    if(metodo =="efectivo"){

        $(this).parent().parent().removeClass("col-xs-6");
        $(this).parent().parent().addClass("col-xs-4");
        $(this).parent().parent().parent().children(".cajasMetodoPago").html(


        '<div class="col-xs-4">' +

                '<div class="input-group">' +
                
                '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                
                    '<input type="text" class="form-control" id="nuevoValorEfectivo" placeholder="000000" required>'+
            
                '</div>' +
            
        '</div>'+


       '<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">'+

			 	'<div class="input-group">'+

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+

			 		'<input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly required>'+

			 	'</div>'+

		'</div>' )

            
    }else{

        $(this).parent().parent().removeClass("col-xs-4");
        $(this).parent().parent().addClass("col-xs-6");
         $(this).parent().parent().parent().children(".cajasMetodoPago").html(


             '<div class="col-xs-6" style="padding-left:0px">'+

                            '<div class="input-group">'+

                                    '<input type="text" class="form-control" id="nuevoCodigoTransaccion" name="nuevoCodigoTransaccion" placeholder="Código transacción" required>'+

                                    '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+

                            '</div>'+

             '</div>'
          
         )


    }


})


/*=============================================
CAMBIO EN EFECTIVO
=============================================*/


$(".formularioVenta").on("change", "input#nuevoValorEfectivo", function () {

  
    var efectivo = $(this).val();

    var cambio = Number(efectivo) - Number($("#nuevoTotalVenta").val());

    var nuevoCambioEfectivo = $(this).parent().parent().parent().children("#capturarCambioEfectivo").children().children("#nuevoCambioEfectivo");


    nuevoCambioEfectivo.val(cambio);



})

/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductos(){


    var listaProductos = [];

    var descripcion = $(".nuevaDescripcionProducto");
    var cantidad = $(".nuevaCantidadProducto");
    var precio = $(".nuevoPrecioProducto");

    for (var i = 0; i < descripcion.length; i++ ){

        listaProductos.push({
            "id": $(descripcion[i]).attr("idproducto"),
            "descripcion": $(descripcion[i]).val(),
            "cantidad": $(cantidad[i]).val(),
            "stock": $(cantidad[i]).attr("nuevostock"),
            "precio": $(precio[i]).attr("precioreal"),
            "total": $(precio[i]).val(),
        
        
        
        })

        //console.log(listaProductos);

        $("#listaProductos").val(JSON.stringify(listaProductos));


    }

}


/*=============================================
BOTON EDITAR VENTA
=============================================*/

$(".tablas").on("click", ".btnEditarVentas", function () {
    
    var idVenta = $(this).attr("idVentas");

   

    window.location = "index.php?ruta=editar-venta&idVenta="+ idVenta;


})


/*=============================================
BORRAR VENTA
=============================================*/

$(".tablas").on("click", ".btnEliminarVentas", function(){

  var idVenta = $(this).attr("idVentas");

    console.log(idVenta)

  Swal.fire({
        title: '¿Está seguro de borrar la venta?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar venta!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=ventas&idVenta="+idVenta;
        }

  })

})


/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click", ".btnImprimirFactura", function(){


    var codigoVenta = $(this).attr("codigoVenta");

    window.open("extensiones/examples/factura.php?codigo="+codigoVenta, "_blank");


})








/*=============================================
RANGO DE FECHAS
=============================================*/

var start = moment();
var end = moment();


function cb(start, end) {

    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    
    var fechaInicial = start.format('YYYY-MM-DD');

    var fechaFinal = end.format('YYYY-MM-DD');
    
    var capturarRango = $("#reportrange span").html();

    localStorage.setItem("capturarRango", capturarRango);

    window.location = "index.php?ruta=ventas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;





}



$('#reportrange').daterangepicker({
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

$(".daterangepicker.opensleft .drp-buttons .cancelBtn").on("click",function(){

    localStorage.removeItem("capturarRango");
    localStorage.clear();
    window.location = "ventas";


})







/*=============================================
CAPTURAR HOY
=============================================*/

$(".daterangepicker.opensleft .ranges li").on("click" ,function(){


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

        localStorage.setItem("capturarRango", "Hoy");

        window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;


    }

})






















                               





           


                
