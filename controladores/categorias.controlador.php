<?php 

class ControladorCategorias{


    static public function ctrMostrarCategorias($item,$valor){

        $tabla="categorias";

        $respuesta=ModeloCategorias::mdlMostrarCategorias($tabla,$item,$valor);

        return $respuesta;




    }


    static public function ctrCrearCategoria(){

        if(isset($_POST["nuevaCategoria"])){

            $tabla="categorias";

            $datos=$_POST["nuevaCategoria"];

            $respuesta=ModeloCategorias::mdlIngresarCategoria($tabla,$datos);

            if($respuesta == "ok"){

                echo "<script>

                        Swal.fire({
                        title: '¡la categoria ha sido guardada correctamente!',
                        icon: 'success',
                        }).then((result) => {
                                                 
                            window.location = 'categorias';
                                                  
                        })
                                            
                    </script>";



            }



        }
     
    }




    static public function ctrEditarCategoria(){

        if(isset($_POST["editarCategoria"])){


            $tabla = "categorias";

            $datos=array("categoria"=>$_POST["editarCategoria"],
            "id"=>$_POST["idCategoria"]);

            $respuesta=ModeloCategorias::mdlEditarCategoria($tabla,$datos);

            if($respuesta=="ok"){

                  echo "<script>

                        Swal.fire({
                        title: '¡la categoria ha sido editada correctamente!',
                        icon: 'success',
                        }).then((result) => {
                                                 
                            window.location = 'categorias';
                                                  
                        })
                                            
                    </script>";




            }


         





        }





    }




    static public function ctrBorrarCategoria(){

        if(isset($_GET["idCategoria"])){


            $tabla ="categorias";
			$datos = $_GET["idCategoria"];

            $respuesta=ModeloCategorias::mdlBorrarCategoria($tabla,$datos);

            	if($respuesta == "ok"){

				echo'<script>

					Swal.fire({
						  type: "success",
						  title: "La categoría ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "categorias";

									}
								})

					</script>';
			}




        }




    }





}



?>