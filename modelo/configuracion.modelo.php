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
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $columnas = $conexion->query("SHOW COLUMNS FROM configuracion")->fetchAll(PDO::FETCH_COLUMN);
        $nuevasColumnas = array(
            "nombre_emprendimiento" => "VARCHAR(150) NOT NULL DEFAULT ''",
            "whatsapp" => "VARCHAR(9) NOT NULL DEFAULT ''",
            "metodos_envio" => "TEXT NOT NULL",
            "dias_despacho" => "TEXT NOT NULL",
            "hora_corte" => "TIME NOT NULL DEFAULT '18:00:00'",
            "anticipacion" => "INT NOT NULL DEFAULT 0"
        );

        foreach($nuevasColumnas as $columna => $definicion){
            if(!in_array($columna, $columnas)){
                $conexion->exec("ALTER TABLE configuracion ADD COLUMN $columna $definicion");
            }
        }

        foreach(array("razon_social", "ruc", "direccion", "telefono", "correo") as $columnaAntigua){
            if(in_array($columnaAntigua, $columnas)){
                $conexion->exec("ALTER TABLE configuracion MODIFY COLUMN $columnaAntigua VARCHAR(255) NULL");
            }
        }

        return $conexion;

    }

    static public function mdlMostrarConfiguracion($tabla){

        try{
            $stmt = self::prepararTabla()->prepare("SELECT * FROM $tabla ORDER BY id ASC LIMIT 1");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: array();
        }catch(PDOException $e){
            return array();
        }

    }

    static public function mdlGuardarConfiguracion($tabla, $datos){

        try{
            $conexion = self::prepararTabla();
            $actual = $conexion->query("SELECT id FROM $tabla ORDER BY id ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            if($actual){
                $stmt = $conexion->prepare("UPDATE $tabla SET nombre_emprendimiento = :nombre_emprendimiento, whatsapp = :whatsapp, metodos_envio = :metodos_envio, dias_despacho = :dias_despacho, hora_corte = :hora_corte, anticipacion = :anticipacion WHERE id = :id");
                $stmt->bindParam(":id", $actual["id"], PDO::PARAM_INT);
            }else{
                $stmt = $conexion->prepare("INSERT INTO $tabla (nombre_emprendimiento, whatsapp, metodos_envio, dias_despacho, hora_corte, anticipacion) VALUES (:nombre_emprendimiento, :whatsapp, :metodos_envio, :dias_despacho, :hora_corte, :anticipacion)");
            }

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

}
