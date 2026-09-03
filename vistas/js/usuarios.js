/*=============================================
EDITAR USUARIO
=============================================*/


$(".tablas").on("click", ".btnEditarUsuario", function () {


    var idUsuario = $(this).attr("idUsuario");

   

    var datos = new FormData();

    datos.append("idUsuario", idUsuario);


    $.ajax({

        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {


          
            $("#editarNombre").val(respuesta["nombre"]);
            $("#editarUsuario").val(respuesta["usuario"]);
            $("#editarPerfil").html(respuesta["perfil"]);
			$("#editarPerfil").val(respuesta["perfil"]);
			$("#fotoActual").val(respuesta["foto"]);

            $("#passwordActual").val(respuesta["password"]);


            if (respuesta["foto"] != "") {

                $(".previsualizarEditar").attr("src", respuesta["foto"]);
                
            } else {

                $(".previsualizarEditar").attr("src", "vistas/img/usuarios/default/anonymous.png");
                
            }
          



            


        }

    })
    
})



/*=============================================
ELIMINAR USUARIO
=============================================*/

$(".tablas").on("click", ".btnEliminarUsuario", function () {

    var idUsuario = $(this).attr("idUsuario");
    var fotoUsuario = $(this).attr("fotoUsuario");
    var usuario = $(this).attr("usuario");

    Swal.fire({
            title: '¿Está seguro de borrar el usuario?',
             icon: 'success',
            }).then((result) => {


                window.location = "index.php?ruta=usuarios&idUsuario=" + idUsuario + "&usuario=" + usuario + "&fotoUsuario=" + fotoUsuario;


            })


})
 



/*=============================================
ACTIVAR USUARIO
=============================================*/
$(".tablas").on("click", ".btnActivar", function () {


    var idUsuario = $(this).attr("idUsuario");
    var estadoUsuario = $(this).attr("estadoUsuario");

    var datos = new FormData();

    datos.append("activarId", idUsuario);
  	datos.append("activarUsuario", estadoUsuario);

    $.ajax({

	  url:"ajax/usuarios.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

      		

      }

  	})

    if(estadoUsuario == 0){

        $(this).removeClass('btn-success');
        $(this).addClass('btn-danger');
        $(this).html('desactivado');
        $(this).attr('estadoUsuario', 1);



    }else{

        $(this).addClass('btn-success');
        $(this).removeClass('btn-danger');
        $(this).html('Activado');
        $(this).attr('estadoUsuario', 0);





    }

    



})