/*=============================================
EDITAR CATEGORIA
=============================================*/

$(".tablas").on("click", ".btnEditarCategoria", function () {

    var idCategoria = $(this).attr("idCategoria");

    var datos = new FormData();

    datos.append("idCategoria", idCategoria);

     $.ajax({

	  url:"ajax/categorias.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      
         success: function (respuesta) {

             console.log(respuesta)
          
             $("#editarCategoria").val(respuesta["categorias"]);
             $("#idCategoria").val(respuesta["id"]);

          

      		

      }

  	})
    

    



})


/*=============================================
ELIMINAR CATEGORIA
=============================================*/

$(".tablas").on("click", ".btnEliminarCategoria", function () {

    var idCategoria = $(this).attr("idCategoria");

    console.log(idCategoria)


       Swal.fire({
            title: '¿Está seguro de borrar la categoria?',
             icon: 'success',
            }).then((result) => {


                window.location = "index.php?ruta=categorias&idCategoria=" + idCategoria;


            })
    






})







