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

    static public function puedeEscribir(){
        self::actualizarEstadoSuscripcionSesion();
        return !isset($_SESSION["solo_lectura"]) || $_SESSION["solo_lectura"] !== true;
    }

    static public function actualizarEstadoSuscripcionSesion(){
        if(!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] !== "ok" || !isset($_SESSION["fecha_vencimiento"]) || $_SESSION["fecha_vencimiento"] === "") return;
        if(isset($_SESSION["perfil"]) && strtolower(trim((string) $_SESSION["perfil"])) === "administrador") return;
        $segundosRestantes = strtotime($_SESSION["fecha_vencimiento"]) - time();
        $_SESSION["dias_restantes"] = max(0, (int) ceil($segundosRestantes / 86400));
        $_SESSION["solo_lectura"] = $segundosRestantes <= 0;
    }

    static public function tenantPuedeEscribir($tenantId){
        $tenantId = (int) $tenantId;
        if($tenantId <= 0) return false;
        try{
            $stmt = self::conectar()->prepare("SELECT estado, perfil, plan, fecha_vencimiento FROM usuarios WHERE id = :id LIMIT 1");
            $stmt->bindValue(":id", $tenantId, PDO::PARAM_INT);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$usuario || (int) $usuario["estado"] !== 1) return false;
            if(strtolower(trim((string) $usuario["perfil"])) === "administrador") return true;
            if(in_array(strtolower(trim((string) $usuario["plan"])), array("general", ""), true)) return true;
            return !empty($usuario["fecha_vencimiento"]) && strtotime($usuario["fecha_vencimiento"]) > time();
        }catch(PDOException $e){
            return false;
        }
    }

    static public function prepararSuscripcion($usuario){
        $perfil = strtolower(trim((string) ($usuario["perfil"] ?? "")));
        $esAdministrador = $perfil === "administrador";
        $plan = strtolower(trim((string) ($usuario["plan"] ?? "")));
        if($plan === "") $plan = $perfil === "usuario/prueba" ? "prueba" : ($perfil === "usuario" ? "mensual" : "general");
        $inicio = (string) ($usuario["fecha_inicio"] ?? $usuario["fecha"] ?? date("Y-m-d H:i:s"));
        $vencimiento = (string) ($usuario["fecha_vencimiento"] ?? "");
        if($vencimiento === "" && $plan === "prueba") $vencimiento = date("Y-m-d H:i:s", strtotime($inicio . " +3 days"));
        if($vencimiento === "" && $plan === "mensual") $vencimiento = date("Y-m-d H:i:s", strtotime($inicio . " +1 month"));
        $segundosRestantes = $vencimiento === "" ? PHP_INT_MAX : strtotime($vencimiento) - time();
        $_SESSION["plan"] = $plan;
        $_SESSION["fecha_vencimiento"] = $vencimiento;
        $_SESSION["dias_restantes"] = $segundosRestantes === PHP_INT_MAX ? null : max(0, (int) ceil($segundosRestantes / 86400));
        $_SESSION["solo_lectura"] = !$esAdministrador && $segundosRestantes <= 0;
        return array("administrador" => $esAdministrador, "plan" => $plan, "vencimiento" => $vencimiento, "dias_restantes" => $_SESSION["dias_restantes"], "solo_lectura" => $_SESSION["solo_lectura"]);
    }

    static private function prepararMultiTenant($link){
        if(self::$multiTenantPreparado) return;

        $tablas = array("usuarios", "productos", "formularios_compartir", "respuestas_formulario");
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
                $suscripcionColumnas = array("plan" => "VARCHAR(20) NULL", "fecha_inicio" => "DATETIME NULL", "fecha_vencimiento" => "DATETIME NULL");
                foreach($suscripcionColumnas as $columna => $definicion){
                    if(!in_array($columna, $columnas)) $link->exec("ALTER TABLE usuarios ADD COLUMN $columna $definicion");
                }
                $link->exec("UPDATE usuarios SET plan = CASE WHEN LOWER(perfil) = 'usuario/prueba' THEN 'prueba' WHEN LOWER(perfil) = 'usuario' THEN 'mensual' ELSE 'general' END WHERE plan IS NULL OR plan = ''");
                $link->exec("UPDATE usuarios SET fecha_inicio = COALESCE(fecha_inicio, fecha), fecha_vencimiento = CASE WHEN plan = 'prueba' THEN DATE_ADD(COALESCE(fecha_inicio, fecha), INTERVAL 3 DAY) WHEN plan = 'mensual' THEN DATE_ADD(COALESCE(fecha_inicio, fecha), INTERVAL 1 MONTH) ELSE NULL END WHERE fecha_inicio IS NULL OR fecha_vencimiento IS NULL");
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
