<?php

class ControladorUsuarios{

    	/*=============================================
	INGRESO DE USUARIO
	=============================================*/

    static public function ctrIngresoUsuario(){


        if(isset($_POST["usuario"])){

            $encriptar=crypt($_POST["password"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

            $tabla="usuarios";

            $item="usuario";

            $valor=$_POST["usuario"];


            $respuesta=ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);

            if($respuesta["usuario"] == $_POST["usuario"] && $respuesta["password"] == $encriptar){


                if($respuesta["estado"]==1){

                    $_SESSION["iniciarSesion"]="ok";
                    $_SESSION["id"]= $respuesta["id"];
                    $_SESSION["nombre"]= $respuesta["nombre"];
                    $_SESSION["usuario"]= $respuesta["usuario"];
                    $_SESSION["foto"]= $respuesta["foto"];
                    $_SESSION["perfil"]= $respuesta["perfil"];

                    echo '<script>

                    window.location="usuarios";
                    
                    
                    </script>';


                }else{

                    echo '<br>
                       <div class="alert alert-danger">El usuario aún no está activado</div> ';
                              

                }



            }else{

                echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';


            }



        }



    }


    













     /*=============================================
	MOSTRAR USUARIOS
	=============================================*/

    static public function ctrMostrarUsuarios($item,$valor){

        $tabla="usuarios";

        $respuesta=ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);

        return $respuesta;

    }


    	/*=============================================
	EDITAR USUARIO
	=============================================*/

    static public function ctrEditarUsuario(){

            if(isset($_POST["editarNombre"])){

                /*=============================================
				VALIDAR IMAGEN
				=============================================*/

                $ruta=$_POST["fotoActual"];

                if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

                    list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
					$nuevoAlto = 500;


                    /*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

                    $directorio = "vistas/img/usuarios/".$_POST["editarUsuario"];

                    /*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

                    if(!empty($_POST["fotoActual"])){

						unlink($_POST["fotoActual"]);

					}else{

						mkdir($directorio, 0755);

					}

                    	/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

                    	if($_FILES["editarFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

                    	if($_FILES["editarFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

                }

                $tabla = "usuarios";


                if($_POST["editarPassword"] != ""){


                    $encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');


                }else{

                    $encriptar = $_POST["passwordActual"];

                
                }


                	$datos = array("nombre" => $_POST["editarNombre"],
							   "usuario" => $_POST["editarUsuario"],
							   "password" => $encriptar,
							   "perfil" => $_POST["editarPerfil"],
							   "foto" => $ruta);


                    $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

                    
				if($respuesta == "ok"){

                      echo "<script>

                        Swal.fire({
                        title: 'El usuario ha sido editado correctamente',
                        icon: 'success',
                        }).then((result) => {
                                                 
                            window.location = 'usuarios';
                                                  
                        })
                                            
                    </script>";

				

				}



            }




    }













    /*=============================================
	REGISTRO DE USUARIO
	=============================================*/

    static public function ctrCrearUsuario(){


        if(isset($_POST["nuevoNombre"])){



             /*=============================================
				VALIDAR IMAGEN
				=============================================*/

                $ruta="";


                if(isset($_FILES["nuevaFoto"]["tmp_name"])){


                    list($ancho , $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

                    $nuevoAncho=500;
                    $nuevoAlto=500;

                       /*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/


                    $directorio="vistas/img/usuarios/".$_POST["nuevoUsuario"];
                    
                    
                    mkdir($directorio,0755);

                    /*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

                    if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){

                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

                        $aleatorio=mt_rand(100 , 999);

                        $ruta="vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".jpg";

                        $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho,$nuevoAlto);

                        imagecopyresized($destino,$origen,0,0,0,0,$nuevoAncho,$nuevoAlto,$ancho,$alto);

                        imagejpeg($destino,$ruta);


                    }


                    if($_FILES["nuevaFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}
          
                }

                    $tabla="usuarios";


                    $encriptar=crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                    $datos=array(

                        "nombre"=>$_POST["nuevoNombre"],
                        "usuario"=>$_POST["nuevoUsuario"],
                        "password"=>$encriptar,
                        "perfil"=>$_POST["nuevoPerfil"],
                        "foto"=>$ruta);



                        $respuesta=ModeloUsuarios::mdlIngresarUsuario($tabla,$datos);


                        if($respuesta=="ok"){

                               echo "<script>

                                Swal.fire({
                                        title: 'se guardo correctamente el usuario',
                                        icon: 'success',
                                        }).then((result) => {
                                                                
                                            window.location = 'usuarios';
                                                                
                                        })
                                                
                                </script>";






                        }
                        
                 
                        




                        
                        
                        
                        {


    }


    /*=============================================
	ACTIVAR/DESACTIVAR USUARIO
	=============================================*/

    static public function ctrActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

        $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

        return $respuesta;

    }


}







    }



     /*=============================================
	BORRAR USUARIO
	=============================================*/


    static public function ctrBorrarUsuario(){


        if(isset($_GET["idUsuario"])){

            $tabla="usuarios";
            $datos=$_GET["idUsuario"];

            if($_GET["fotoUsuario"]  !=""){

                unlink($_GET["fotoUsuario"]);
                rmdir("vistas/img/usuarios/".$_GET["usuario"]);
  }


  $respuesta=ModeloUsuarios::mdlBorrarUsuarios($tabla,$datos);

  	if($respuesta == "ok"){

                  echo "<script>

                        Swal.fire({
                        title: '¡El usuario ha sido borrado correctamente!',
                        icon: 'success',
                        }).then((result) => {
                                                 
                            window.location = 'usuarios';
                                                  
                        })
                                            
                    </script>";

			

			}





          







        }




    }







}




?>