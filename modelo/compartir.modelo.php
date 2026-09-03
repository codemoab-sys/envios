<?php

require_once "conexion.php";

class ModeloCompartir{

    static private function prepararTabla(){
        $conexion = Conexion::conectar();
        $conexion->exec("CREATE TABLE IF NOT EXISTS formularios_compartir (
            id INT NOT NULL AUTO_INCREMENT,
            titulo VARCHAR(150) NOT NULL,
            descripcion VARCHAR(255) NULL,
            token VARCHAR(64) NOT NULL,
            enlace VARCHAR(500) NOT NULL,
            estado TINYINT(1) NOT NULL DEFAULT 1,
            fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY uk_formularios_compartir_token (token)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        return $conexion;
    }

    static public function mdlMostrarActivo(){
        try{
            $conexion = self::prepararTabla();
            $stmt = $conexion->query("SELECT * FROM formularios_compartir WHERE estado = 1 ORDER BY id DESC LIMIT 1");
            $formulario = $stmt->fetch(PDO::FETCH_ASSOC);
            if($formulario && strpos($formulario["enlace"], "localhost./form") !== false){
                $formulario["enlace"] = str_replace("localhost./form", "localhost/form", $formulario["enlace"]);
                $stmt = $conexion->prepare("UPDATE formularios_compartir SET enlace = :enlace WHERE id = :id");
                $stmt->execute(array(":enlace" => $formulario["enlace"], ":id" => $formulario["id"]));
            }
            if(!$formulario){
                $token = bin2hex(random_bytes(8));
                $enlace = self::crearEnlace($token);
                $stmt = $conexion->prepare("INSERT INTO formularios_compartir (titulo, descripcion, token, enlace) VALUES (:titulo, :descripcion, :token, :enlace)");
                $stmt->execute(array(
                    ":titulo" => "Formulario personalizado",
                    ":descripcion" => "Completa tus datos para coordinar tu envío.",
                    ":token" => $token,
                    ":enlace" => $enlace
                ));
                $formulario = $conexion->query("SELECT * FROM formularios_compartir WHERE id = LAST_INSERT_ID()")->fetch(PDO::FETCH_ASSOC);
            }
            return $formulario ?: array();
        }catch(PDOException $e){
            return array();
        }
    }

    static private function crearEnlace($token){
        $protocolo = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https" : "http";
        $directorio = rtrim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"] ?? "")), "/");
        if($directorio == "."){ $directorio = ""; }
        return $protocolo . "://" . ($_SERVER["HTTP_HOST"] ?? "localhost") . $directorio . "/form?merchant=" . $token;
    }

    static public function mdlGuardar($datos){
        try{
            $conexion = self::prepararTabla();
            $token = bin2hex(random_bytes(8));
            $stmt = $conexion->prepare("INSERT INTO formularios_compartir (titulo, descripcion, token, enlace) VALUES (:titulo, :descripcion, :token, :enlace)");
            $stmt->bindValue(":titulo", $datos["titulo"], PDO::PARAM_STR);
            $stmt->bindValue(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindValue(":token", $token, PDO::PARAM_STR);
            $stmt->bindValue(":enlace", self::crearEnlace($token), PDO::PARAM_STR);
            return $stmt->execute() ? "ok" : "error";
        }catch(PDOException $e){
            return "error";
        }
    }

}

?>
