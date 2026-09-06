<?php

class Conexion{

    static private $multiTenantPreparado = false;

    static public function conectar(){

        $host = "localhost";
        $db = "enviosbd";
        $user = "root";
        $pass = "";

        $link = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $link->exec("set names utf8mb4");
        self::prepararMultiTenant($link);

        return $link;

    }

    static public function tenantId(){
        return isset($_SESSION["tenant_id"]) && (int) $_SESSION["tenant_id"] > 0
            ? (int) $_SESSION["tenant_id"]
            : (isset($_SESSION["id"]) && (int) $_SESSION["id"] > 0 ? (int) $_SESSION["id"] : 0);
    }

    static private function prepararMultiTenant($link){
        if(self::$multiTenantPreparado) return;

        $tablas = array("usuarios", "categorias", "clientes", "productos", "ventas", "formularios_compartir", "respuestas_formulario");
        foreach($tablas as $tabla){
            $existe = $link->prepare("SHOW TABLES LIKE :tabla");
            $existe->bindValue(":tabla", $tabla, PDO::PARAM_STR);
            $existe->execute();
            if(!$existe->fetchColumn()) continue;

            $columnas = $link->query("SHOW COLUMNS FROM `$tabla`")->fetchAll(PDO::FETCH_COLUMN);
            if(!in_array("tenant_id", $columnas)){
                $link->exec("ALTER TABLE `$tabla` ADD COLUMN tenant_id INT NULL AFTER id");
                $link->exec("ALTER TABLE `$tabla` ADD INDEX idx_{$tabla}_tenant (tenant_id)");
            }
            if($tabla === "usuarios"){
                $link->exec("UPDATE usuarios SET tenant_id = id WHERE tenant_id IS NULL");
            }else{
                $link->exec("UPDATE `$tabla` SET tenant_id = (SELECT id FROM usuarios WHERE perfil = 'administrador' ORDER BY id ASC LIMIT 1) WHERE tenant_id IS NULL");
            }
        }
        self::$multiTenantPreparado = true;
    }

}

?>
