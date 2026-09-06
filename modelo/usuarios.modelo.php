<?php 

require_once "conexion.php";

class ModeloUsuarios{

    static public function mdlRegistrarCuenta($nombre, $whatsapp, $password){
        try{
            $conexion = Conexion::conectar();
            $consulta = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = :usuario LIMIT 1");
            $consulta->bindParam(":usuario", $whatsapp, PDO::PARAM_STR);
            $consulta->execute();
            if($consulta->fetch()) return "existe";

            $encriptada = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, usuario, password, perfil, foto, estado) VALUES (:nombre, :usuario, :password, 'Administrador', '', 1)");
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $whatsapp, PDO::PARAM_STR);
            $stmt->bindParam(":password", $encriptada, PDO::PARAM_STR);
            if(!$stmt->execute()) return "error";

            $configuracion = $conexion->prepare("SELECT id FROM configuracion ORDER BY id ASC LIMIT 1");
            $configuracion->execute();
            $fila = $configuracion->fetch(PDO::FETCH_ASSOC);
            if($fila){
                $actualizar = $conexion->prepare("UPDATE configuracion SET nombre_emprendimiento = :nombre, whatsapp = :whatsapp WHERE id = :id");
                $actualizar->bindParam(":nombre", $nombre, PDO::PARAM_STR);
                $actualizar->bindParam(":whatsapp", $whatsapp, PDO::PARAM_STR);
                $actualizar->bindParam(":id", $fila["id"], PDO::PARAM_INT);
                $actualizar->execute();
            }else{
                $crear = $conexion->prepare("INSERT INTO configuracion (nombre_emprendimiento, whatsapp, metodos_envio, dias_despacho) VALUES (:nombre, :whatsapp, '[]', '[]')");
                $crear->bindParam(":nombre", $nombre, PDO::PARAM_STR);
                $crear->bindParam(":whatsapp", $whatsapp, PDO::PARAM_STR);
                $crear->execute();
            }
            return "ok";
        }catch(PDOException $e){
            return "error";
        }
    }

    static public function mdlMostrarUsuarios($tabla,$item,$valor){

        if($item !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item");

            $stmt->bindParam(":".$item ,$valor,PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();

        }else{

        $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();

        }


      $stmt->close();
        $stmt=null;


    }




    static public function mdlEditarUsuario($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, password = :password, perfil = :perfil, foto = :foto WHERE usuario = :usuario");


        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

        if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;




    }





  





    static public function mdlIngresarUsuario($tabla,$datos){


        $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,usuario,password,perfil,foto) VALUES (:nombre,:usuario,:password,:perfil,:foto)");

        $stmt->bindParam(":nombre" ,$datos["nombre"],PDO::PARAM_STR);
        $stmt->bindParam(":usuario" ,$datos["usuario"],PDO::PARAM_STR);
        $stmt->bindParam(":password" ,$datos["password"],PDO::PARAM_STR);
        $stmt->bindParam(":perfil" ,$datos["perfil"],PDO::PARAM_STR);
        $stmt->bindParam(":foto" ,$datos["foto"],PDO::PARAM_STR);


        if($stmt->execute()){

            return "ok";

        }else{

            return "error";


        }

         $stmt->close();

        $stmt=null;

    }



    	/*=============================================
	BORRAR USUARIO
	=============================================*/

    static public function mdlBorrarUsuarios($tabla , $datos){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id=:id");

        $stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;








    }


     	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/



    static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

        $columnasPermitidas = ["estado"];
        if(!in_array($item1, $columnasPermitidas)){
            return "error";
        }

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :valor WHERE $item2=:$item2");

        $stmt -> bindParam(":valor", $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

        if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;




    }








}


?>