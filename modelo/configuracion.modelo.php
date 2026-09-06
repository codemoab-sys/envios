<?php

require_once "conexion.php";

class ModeloConfiguracion{

    static private function prepararTabla(){

        $conexion = Conexion::conectar();
        $conexion->exec("CREATE TABLE IF NOT EXISTS configuracion (
            id INT NOT NULL AUTO_INCREMENT,
            nombre_emprendimiento VARCHAR(150) NOT NULL,
            whatsapp VARCHAR(9) NOT NULL,
            metodos_envio TEXT NOT NULL,
            dias_despacho TEXT NOT NULL,
            hora_corte TIME NOT NULL DEFAULT '18:00:00',
            anticipacion INT NOT NULL DEFAULT 0,
            tema VARCHAR(10) NOT NULL DEFAULT 'light',
            color_cabecera VARCHAR(7) NOT NULL DEFAULT '#dd4b39',
            color_boton_primario VARCHAR(7) NOT NULL DEFAULT '#3b82f6',
            color_boton_secundario VARCHAR(7) NOT NULL DEFAULT '#202c42',
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $columnas = $conexion->query("SHOW COLUMNS FROM configuracion")->fetchAll(PDO::FETCH_COLUMN);
        $nuevasColumnas = array(
            "nombre_emprendimiento" => "VARCHAR(150) NOT NULL DEFAULT ''",
            "whatsapp" => "VARCHAR(9) NOT NULL DEFAULT ''",
            "metodos_envio" => "TEXT NOT NULL",
            "dias_despacho" => "TEXT NOT NULL",
            "hora_corte" => "TIME NOT NULL DEFAULT '18:00:00'",
            "anticipacion" => "INT NOT NULL DEFAULT 0",
            "tema" => "VARCHAR(10) NOT NULL DEFAULT 'light'",
            "color_cabecera" => "VARCHAR(7) NOT NULL DEFAULT '#dd4b39'",
            "color_boton_primario" => "VARCHAR(7) NOT NULL DEFAULT '#3b82f6'",
            "color_boton_secundario" => "VARCHAR(7) NOT NULL DEFAULT '#202c42'"
        );

        foreach($nuevasColumnas as $columna => $definicion){
            if(!in_array($columna, $columnas)){
                $conexion->exec("ALTER TABLE configuracion ADD COLUMN $columna $definicion");
            }
        }

        if(!in_array("usuario_id", $columnas)){
            $conexion->exec("ALTER TABLE configuracion ADD COLUMN usuario_id INT NULL AFTER id");
        }

        $conexion->exec("UPDATE configuracion SET usuario_id = (SELECT id FROM usuarios WHERE perfil = 'administrador' ORDER BY id ASC LIMIT 1) WHERE usuario_id IS NULL AND id = (SELECT id_configuracion FROM (SELECT MIN(id) AS id_configuracion FROM configuracion) AS primera_configuracion)");

        foreach(array("razon_social", "ruc", "direccion", "telefono", "correo") as $columnaAntigua){
            if(in_array($columnaAntigua, $columnas)){
                $conexion->exec("ALTER TABLE configuracion MODIFY COLUMN $columnaAntigua VARCHAR(255) NULL");
            }
        }

        return $conexion;

    }

    static public function mdlMostrarConfiguracion($tabla){

        try{
            $conexion = self::prepararTabla();
            if(isset($_SESSION["id"]) && (int) $_SESSION["id"] > 0){
                $stmt = $conexion->prepare("SELECT * FROM $tabla WHERE usuario_id = :usuario_id LIMIT 1");
                $stmt->bindValue(":usuario_id", (int) $_SESSION["id"], PDO::PARAM_INT);
            }else{
                $stmt = $conexion->prepare("SELECT * FROM $tabla ORDER BY id ASC LIMIT 1");
            }
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: array();
        }catch(PDOException $e){
            return array();
        }

    }

    static public function mdlMostrarConfiguracionPorUsuario($usuarioId){
        try{
            $stmt = self::prepararTabla()->prepare("SELECT * FROM configuracion WHERE usuario_id = :usuario_id LIMIT 1");
            $stmt->bindValue(":usuario_id", (int) $usuarioId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: array();
        }catch(PDOException $e){
            return array();
        }
    }

    static public function mdlGuardarConfiguracion($tabla, $datos){

        try{
            $conexion = self::prepararTabla();
            if(!isset($_SESSION["id"]) || (int) $_SESSION["id"] <= 0){
                return "error";
            }
            $usuarioId = (int) $_SESSION["id"];
            $usuario = $conexion->prepare("UPDATE usuarios SET usuario = :whatsapp WHERE id = :usuario_id");
            $usuario->bindValue(":whatsapp", $datos["whatsapp"], PDO::PARAM_STR);
            $usuario->bindValue(":usuario_id", $usuarioId, PDO::PARAM_INT);
            if(!$usuario->execute()){
                return "error";
            }
            $actualStmt = $conexion->prepare("SELECT id FROM $tabla WHERE usuario_id = :usuario_id LIMIT 1");
            $actualStmt->bindValue(":usuario_id", $usuarioId, PDO::PARAM_INT);
            $actualStmt->execute();
            $actual = $actualStmt->fetch(PDO::FETCH_ASSOC);

            if($actual){
                $stmt = $conexion->prepare("UPDATE $tabla SET nombre_emprendimiento = :nombre_emprendimiento, whatsapp = :whatsapp, metodos_envio = :metodos_envio, dias_despacho = :dias_despacho, hora_corte = :hora_corte, anticipacion = :anticipacion WHERE id = :id AND usuario_id = :usuario_id");
                $stmt->bindParam(":id", $actual["id"], PDO::PARAM_INT);
            }else{
                $stmt = $conexion->prepare("INSERT INTO $tabla (usuario_id, nombre_emprendimiento, whatsapp, metodos_envio, dias_despacho, hora_corte, anticipacion) VALUES (:usuario_id, :nombre_emprendimiento, :whatsapp, :metodos_envio, :dias_despacho, :hora_corte, :anticipacion)");
            }

            $stmt->bindValue(":usuario_id", $usuarioId, PDO::PARAM_INT);
            $stmt->bindParam(":nombre_emprendimiento", $datos["nombre_emprendimiento"], PDO::PARAM_STR);
            $stmt->bindParam(":whatsapp", $datos["whatsapp"], PDO::PARAM_STR);
            $stmt->bindParam(":metodos_envio", $datos["metodos_envio"], PDO::PARAM_STR);
            $stmt->bindParam(":dias_despacho", $datos["dias_despacho"], PDO::PARAM_STR);
            $stmt->bindParam(":hora_corte", $datos["hora_corte"], PDO::PARAM_STR);
            $stmt->bindParam(":anticipacion", $datos["anticipacion"], PDO::PARAM_INT);

            return $stmt->execute() ? "ok" : "error";
        }catch(PDOException $e){
            return "error";
        }

    }

    static public function mdlWhatsappExiste($whatsapp, $usuarioId){
        try{
            $stmt = Conexion::conectar()->prepare("SELECT id FROM usuarios WHERE usuario = :whatsapp AND id <> :usuario_id LIMIT 1");
            $stmt->bindValue(":whatsapp", $whatsapp, PDO::PARAM_STR);
            $stmt->bindValue(":usuario_id", (int) $usuarioId, PDO::PARAM_INT);
            $stmt->execute();
            return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            return true;
        }
    }

    static public function mdlActualizarPassword($tabla, $password, $id){

        try{
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET password = :password WHERE id = :id");
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            return $stmt->execute() ? "ok" : "error";
        }catch(PDOException $e){
            return "error";
        }

    }

    static public function mdlGuardarApariencia($tema, $colorCabecera, $colorBotonPrimario, $colorBotonSecundario){
        try{
            $conexion = self::prepararTabla();
            $actual = $conexion->query("SELECT id FROM configuracion ORDER BY id ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            if($actual){
                $stmt = $conexion->prepare("UPDATE configuracion SET tema = :tema, color_cabecera = :color_cabecera, color_boton_primario = :color_boton_primario, color_boton_secundario = :color_boton_secundario WHERE id = :id");
                $stmt->bindParam(":id", $actual["id"], PDO::PARAM_INT);
            }else{
                $stmt = $conexion->prepare("INSERT INTO configuracion (nombre_emprendimiento, whatsapp, metodos_envio, dias_despacho, tema, color_cabecera, color_boton_primario, color_boton_secundario) VALUES ('', '', '[]', '[]', :tema, :color_cabecera, :color_boton_primario, :color_boton_secundario)");
            }
            $stmt->bindParam(":tema", $tema, PDO::PARAM_STR);
            $stmt->bindParam(":color_cabecera", $colorCabecera, PDO::PARAM_STR);
            $stmt->bindParam(":color_boton_primario", $colorBotonPrimario, PDO::PARAM_STR);
            $stmt->bindParam(":color_boton_secundario", $colorBotonSecundario, PDO::PARAM_STR);
            return $stmt->execute() ? "ok" : "error";
        }catch(PDOException $e){
            return "error";
        }
    }

}
