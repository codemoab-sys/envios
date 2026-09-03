/*=============================================
CAPTURANDO LA CATEGORIA PARA ASIGNAR CÓDIGO
=============================================*/

$("#nuevaCategoria").change(function(){

    var idCategoria = $(this).val();
    
	var datos = new FormData();
  	datos.append("idCategoria", idCategoria);

  	$.ajax({

      url:"ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
            success: function (respuesta) {
                  
      	if(!respuesta){

      		var nuevoCodigo = idCategoria+"01";
      		$("#nuevoCodigo").val(nuevoCodigo);

      	}else{

               console.log(respuesta)

      		var nuevoCodigo = Number(respuesta["codigo"]) + 1;
          	$("#nuevoCodigo").val(nuevoCodigo);

      	}
                
      }

  	})

})




/*=============================================
EDITAR PRODUCTO
=============================================*/

$(".tablas tbody").on("click", "button.btnEditarProducto", function () {
    
    var idProducto = $(this).attr("idProducto");

    //console.log(idProducto);

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
        success: function (respuesta) {

            var datosCategoria = new FormData();
            datosCategoria.append("idCategoria", respuesta["id_categoria"]);

            console.log(respuesta["id_categoria"])

            $.ajax({

                url:"ajax/categorias.ajax.php",
                method: "POST",
                data: datosCategoria,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (respuesta) {

                    console.log(respuesta["categorias"]);
                     
                    $("#editarCategoria").val(respuesta["id"]);
                    $("#editarCategoria").html(respuesta["categorias"]);

                 
                 }

             })


            $("#editarCodigo").val(respuesta["codigo"]);
            $("#editarDescripcion").val(respuesta["descripcion"]);
            $("#editarStock").val(respuesta["stock"]);
            $("#editarPrecioCompra").val(respuesta["precio_compra"]);
            $("#editarPrecioVenta").val(respuesta["precio_venta"]);

            if(respuesta["imagen"] !=""){

                $("#imagenActual").val(respuesta["imagen"]);
                $(".previsualizar").attr("src", respuesta["imagen"]);



            }




      }


    })



})

/*=============================================
AGREGANDO PRECIO DE VENTA
=============================================*/
$("#nuevoPrecioCompra , #editarPrecioCompra").change(function(){

    if($(".porcentaje").prop("checked")){

        var valorPorcentaje = $(".nuevoPorcentaje").val();

        var porcentaje = Number(($("#nuevoPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#nuevoPrecioCompra").val());

         var editarPorcentaje = Number(($("#editarPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#editarPrecioCompra").val());


        $("#nuevoPrecioVenta").val(porcentaje);
        $("#nuevoPrecioVenta").prop("readonly", true);


        $("#editarPrecioVenta").val(editarPorcentaje);
        $("#editarPrecioVenta").prop("readonly", true);
        
        




    }




})

/*=============================================
CAMBIO DE PORCENTAJE
=============================================*/

$(".nuevoPorcentaje").change(function(){

    if($(".porcentaje").prop("checked")) {

        var valorPorcentaje = $(this).val();

        var porcentaje = Number(($("#nuevoPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#nuevoPrecioCompra").val());

        var editarPorcentaje = Number(($("#editarPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#editarPrecioCompra").val());

        $("#nuevoPrecioVenta").val(porcentaje);
        $("#nuevoPrecioVenta").prop("readonly", true);

        $("#editarPrecioVenta").val(editarPorcentaje);
        $("#editarPrecioVenta").prop("readonly", true);





     }

})



$(".poncetaje").on("ifUnchecked",function(){

    $("#nuevoPrecioVenta").prop("readonly", false)
    $("#editarPrecioVenta").prop("readonly",false)


})


$(".poncetaje").on("ifchecked",function(){

    $("#nuevoPrecioVenta").prop("readonly", true)
    $("#editarPrecioVenta").prop("readonly", true);


})



/*=============================================
ELIMINAR PRODUCTO
=============================================*/


$(".tablas tbody").on("click",".btnEliminarProducto",function(){

    var idProducto = $(this).attr("idProducto");
    var codigo = $(this).attr("codigo");
    var imagen = $(this).attr("imagen");

      Swal.fire({
            title: '¿Está seguro de borrar el usuario?',
             icon: 'success',
            }).then((result) => {


                window.location = "index.php?ruta=productos&idProducto=" + idProducto + "&codigo=" + codigo + "&imagen=" + imagen;


            })









})


