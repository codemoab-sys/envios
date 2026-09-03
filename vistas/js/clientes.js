/*=============================================
EDITAR CLIENTE
=============================================*/

$(".tablas").on("click", ".btnEditarCliente", function () {

    var idCliente = $(this).attr("idCliente");

    

    var datos = new FormData();

    datos.append("idCliente", idCliente);

    $.ajax({
      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
        success: function (respuesta) {

          console.log(respuesta)
          

          
            $("#idCliente").val(respuesta["id"]);
            $("#editarCliente").val(respuesta["nombre"]);
            $("#editarDocumentoId").val(respuesta["documento"]);
            $("#editarEmail").val(respuesta["email"]);
            $("#editarTelefono").val(respuesta["telefono"]);
            $("#editarDireccion").val(respuesta["direccion"]);
            $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);


          


      }






    })
    




})

/*=============================================
ELIMINAR CLIENTE
=============================================*/

$(".tablas").on("click", ".btnEliminarCliente", function () {

  var idCliente = $(this).attr("idCliente");

      Swal.fire({
            title: '¿Está seguro de borrar el cliente?',
             icon: 'success',
            }).then((result) => {


                window.location = "index.php?ruta=clientes&idCliente=" + idCliente;


            })


  




})