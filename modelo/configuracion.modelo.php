<?php

require_once "conexion.php";

class ModeloConfiguracion{

    static private function prepararTabla(){

        $conexion = Conexion::conectar();
        $conexion->exec("CREATE TABLE IF NOT EXISTS configuracion (
            id INT NOT NULL AUTO_INCREMENT,
            razon_social VARCHAR(150) NOT NULL,
            ruc VARCHAR(11) NOT NULL,
            direccion VARCHAR(255) NULL,
            telefono VARCHAR(30) NULL,
            correo VARCHAR(150) NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

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
                $stmt = $conexion->prepare("UPDATE $tabla SET razon_social = :razon_social, ruc = :ruc, direccion = :direccion, telefono = :telefono, correo = :correo WHERE id = :id");
                $stmt->bindParam(":id", $actual["id"], PDO::PARAM_INT);
            }else{
                $stmt = $conexion->prepare("INSERT INTO $tabla (razon_social, ruc, direccion, telefono, correo) VALUES (:razon_social, :ruc, :direccion, :telefono, :correo)");
            }

            $stmt->bindParam(":razon_social", $datos["razon_social"], PDO::PARAM_STR);
            $stmt->bindParam(":ruc", $datos["ruc"], PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);

            return $stmt->execute() ? "ok" : "error";
        }catch(PDOException $e){
            return "error";
        }

    }

}
