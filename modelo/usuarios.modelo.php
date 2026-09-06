<?php 

require_once "conexion.php";
require_once "configuracion.modelo.php";

class ModeloUsuarios{

    static private function administradorGeneral(){
        return isset($_SESSION["perfil"]) && strtolower(trim((string) $_SESSION["perfil"])) === "administrador";
    }

    static public function mdlMostrarUsuarioParaLogin($usuario){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1");
        $stmt->bindValue(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function mdlRegistrarCuenta($nombre, $whatsapp, $password){
        try{
            // La preparación usa ALTER TABLE y debe ejecutarse fuera de la transacción.
            ModeloConfiguracion::mdlMostrarConfiguracion("configuracion");
            $conexion = Conexion::conectar();
            $conexion->beginTransaction();
            $consulta = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = :usuario LIMIT 1");
            $consulta->bindParam(":usuario", $whatsapp, PDO::PARAM_STR);
            $consulta->execute();
            if($consulta->fetch()){
                $conexion->rollBack();
                return "existe";
            }

            $encriptada = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, usuario, password, perfil, foto, estado, plan, fecha_inicio, fecha_vencimiento) VALUES (:nombre, :usuario, :password, 'Usuario/prueba', '', 1, 'prueba', NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY))");
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $whatsapp, PDO::PARAM_STR);
            $stmt->bindParam(":password", $encriptada, PDO::PARAM_STR);
            if(!$stmt->execute()){
                $conexion->rollBack();
                return "error";
            }
            $usuarioId = (int) $conexion->lastInsertId();
            $asignarTenant = $conexion->prepare("UPDATE usuarios SET tenant_id = :tenant_id WHERE id = :id");
            $asignarTenant->bindValue(":tenant_id", $usuarioId, PDO::PARAM_INT);
            $asignarTenant->bindValue(":id", $usuarioId, PDO::PARAM_INT);
            $asignarTenant->execute();

            $crear = $conexion->prepare("INSERT INTO configuracion (usuario_id, nombre_emprendimiento, whatsapp, metodos_envio, dias_despacho) VALUES (:usuario_id, :nombre, :whatsapp, '[]', '[]')");
            $crear->bindValue(":usuario_id", $usuarioId, PDO::PARAM_INT);
            $crear->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $crear->bindParam(":whatsapp", $whatsapp, PDO::PARAM_STR);
            if(!$crear->execute()){
                $conexion->rollBack();
                return "error";
            }
            $conexion->commit();
            return "ok";
        }catch(Throwable $e){
            if(isset($conexion) && $conexion->inTransaction()) $conexion->rollBack();
            error_log("Registro de cuenta: " . $e->getMessage());
            return "error";
        }
    }

    static public function mdlMostrarUsuarios($tabla,$item,$valor){

        $tenantId = Conexion::tenantId();
        $filtroTenant = self::administradorGeneral() ? "" : " AND tenant_id=:tenant_id";

        if($item !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item" . $filtroTenant);

            $stmt->bindParam(":".$item ,$valor,PDO::PARAM_STR);
            if($filtroTenant !== "") $stmt->bindValue(":tenant_id", $tenantId, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch();

        }else{

        $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla" . ($filtroTenant !== "" ? " WHERE tenant_id=:tenant_id" : ""));
        if($filtroTenant !== "") $stmt->bindValue(":tenant_id", $tenantId, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();

        }


      $stmt->close();
        $stmt=null;


    }




    static public function mdlEditarUsuario($tabla, $datos){

        $filtroTenant = self::administradorGeneral() ? "" : " AND tenant_id=:tenant_id";
        $plan = in_array(($datos["plan"] ?? ""), array("general", "mensual", "prueba"), true) ? $datos["plan"] : "general";
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, password = :password, perfil = :perfil, foto = :foto, plan = :plan, fecha_inicio = NOW(), fecha_vencimiento = CASE WHEN :plan_fecha = 'prueba' THEN DATE_ADD(NOW(), INTERVAL 3 DAY) WHEN :plan_fecha = 'mensual' THEN DATE_ADD(NOW(), INTERVAL 1 MONTH) ELSE NULL END WHERE usuario = :usuario" . $filtroTenant);
        if($filtroTenant !== "") $stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);
        $stmt->bindValue(":plan", $plan, PDO::PARAM_STR);
        $stmt->bindValue(":plan_fecha", $plan, PDO::PARAM_STR);


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


        $plan = strtolower(trim((string) ($datos["perfil"] ?? ""))) === "usuario/prueba" ? "prueba" : (strtolower(trim((string) ($datos["perfil"] ?? ""))) === "usuario" ? "mensual" : "general");
        $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(tenant_id,nombre,usuario,password,perfil,foto,plan,fecha_inicio,fecha_vencimiento) VALUES (:tenant_id,:nombre,:usuario,:password,:perfil,:foto,:plan,NOW(),CASE WHEN :plan_fecha = 'prueba' THEN DATE_ADD(NOW(), INTERVAL 3 DAY) WHEN :plan_fecha = 'mensual' THEN DATE_ADD(NOW(), INTERVAL 1 MONTH) ELSE NULL END)");
        $stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);
        $stmt->bindValue(":plan", $plan, PDO::PARAM_STR);
        $stmt->bindValue(":plan_fecha", $plan, PDO::PARAM_STR);

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

        $filtroTenant = self::administradorGeneral() ? "" : " AND tenant_id=:tenant_id";
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id=:id" . $filtroTenant);
        if($filtroTenant !== "") $stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);

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

        $filtroTenant = self::administradorGeneral() ? "" : " AND tenant_id=:tenant_id";
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :valor WHERE $item2=:$item2" . $filtroTenant);
        if($filtroTenant !== "") $stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);

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