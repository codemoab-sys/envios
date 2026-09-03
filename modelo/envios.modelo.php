<?php

require_once "conexion.php";

class ModeloEnvios{

    static private function prepararTabla(){
        $conexion = Conexion::conectar();
        $conexion->exec("CREATE TABLE IF NOT EXISTS respuestas_formulario (
            id INT NOT NULL AUTO_INCREMENT,
            nombre VARCHAR(150) NOT NULL,
            telefono VARCHAR(30) NULL,
            direccion VARCHAR(255) NULL,
            estado VARCHAR(30) NOT NULL DEFAULT 'pendiente',
            mensaje TEXT NULL,
            fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            INDEX idx_respuestas_estado (estado),
            INDEX idx_respuestas_fecha (fecha)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        return $conexion;
    }

    static public function mdlContarRespuestas(){
        try{
            $stmt = self::prepararTabla()->query("SELECT COUNT(*) FROM respuestas_formulario");
            return (int) $stmt->fetchColumn();
        }catch(PDOException $e){
            return 0;
        }
    }

}

?>
