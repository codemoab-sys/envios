<?php

require_once "conexion.php";

class ModeloEnvios{

    static private function prepararTabla(){
        $conexion = Conexion::conectar();
        $conexion->exec("CREATE TABLE IF NOT EXISTS respuestas_formulario (
            id INT NOT NULL AUTO_INCREMENT,
            tenant_id INT NULL,
            nombre VARCHAR(150) NOT NULL,
            telefono VARCHAR(30) NULL,
            direccion VARCHAR(255) NULL,
            agencia VARCHAR(100) NOT NULL DEFAULT 'SHALOM',
            fecha_envio VARCHAR(50) NULL,
            estado VARCHAR(30) NOT NULL DEFAULT 'pendiente',
            mensaje TEXT NULL,
            fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            INDEX idx_respuestas_tenant (tenant_id),
            INDEX idx_respuestas_estado (estado),
            INDEX idx_respuestas_fecha (fecha)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        try{
            $result = $conexion->query("SHOW COLUMNS FROM respuestas_formulario LIKE 'agencia'");
            if($result && $result->rowCount() === 0){
                $conexion->exec("ALTER TABLE respuestas_formulario ADD COLUMN agencia VARCHAR(100) NOT NULL DEFAULT 'SHALOM' AFTER direccion");
            }
        }catch(PDOException $e){
            // Ignorar si la tabla ya está creada con la columna o si la BD no admite la verificación.
        }

        try{
            $result = $conexion->query("SHOW COLUMNS FROM respuestas_formulario LIKE 'fecha_envio'");
            if($result && $result->rowCount() === 0){
                $conexion->exec("ALTER TABLE respuestas_formulario ADD COLUMN fecha_envio VARCHAR(50) NULL AFTER agencia");
            }
        }catch(PDOException $e){
            // Ignorar si la columna ya existe.
        }

        return $conexion;
    }

    static public function mdlContarRespuestas(){
        try{
            $stmt = self::prepararTabla()->prepare("SELECT COUNT(*) FROM respuestas_formulario WHERE tenant_id=:tenant_id");
            $stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        }catch(PDOException $e){
            return 0;
        }
    }

    static public function mdlGuardarRespuesta($datos){
        try{
            $tenantId = (int) ($datos["tenant_id"] ?? Conexion::tenantId());
            if($tenantId <= 0) return array("estado" => "error", "mensaje" => "Tenant no válido");
            $conexion = self::prepararTabla();
            $stmt = $conexion->prepare("INSERT INTO respuestas_formulario (tenant_id, nombre, telefono, direccion, agencia, fecha_envio, estado, mensaje) VALUES (:tenant_id, :nombre, :telefono, :direccion, :agencia, :fecha_envio, 'pendiente', :mensaje)");
            $stmt->bindValue(":tenant_id", $tenantId, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
            $stmt->bindParam(":agencia", $datos["agencia"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_envio", $datos["fecha_envio"], PDO::PARAM_STR);
            $stmt->bindParam(":mensaje", $datos["mensaje"], PDO::PARAM_STR);
            if($stmt->execute()){
                return array("estado" => "ok", "id" => $conexion->lastInsertId());
            }
            return array("estado" => "error", "mensaje" => "No se pudo guardar la respuesta");
        }catch(PDOException $e){
            return array("estado" => "error", "mensaje" => $e->getMessage());
        }
    }

    static public function mdlListarRespuestas($estado, $busqueda, $agencia = "todos", $fechaInicio = "", $fechaFin = "", $pagina = 1, $limite = 10){
        try{
            $conexion = self::prepararTabla();
            $pagina = max(1, (int) $pagina);
            $limite = min(100, max(1, (int) $limite));
            $offset = ($pagina - 1) * $limite;
            $where = "";
            $parametros = array();
            $where = " WHERE tenant_id = :tenant_id";
            $parametros[":tenant_id"] = Conexion::tenantId();

            if($estado !== "todos"){
                $where .= " AND estado = :estado";
                $parametros[":estado"] = $estado;
            }

            if($agencia !== "todos"){
                $where .= " AND agencia = :agencia";
                $parametros[":agencia"] = $agencia;
            }

            if($fechaInicio !== ""){
                $where .= " AND (fecha_envio >= :fecha_inicio OR (COALESCE(fecha_envio, '') = '' AND DATE(fecha) >= :fecha_inicio_registro))";
                $parametros[":fecha_inicio"] = $fechaInicio;
                $parametros[":fecha_inicio_registro"] = $fechaInicio;
            }

            if($fechaFin !== ""){
                $where .= " AND (fecha_envio <= :fecha_fin OR (COALESCE(fecha_envio, '') = '' AND DATE(fecha) <= :fecha_fin_registro))";
                $parametros[":fecha_fin"] = $fechaFin;
                $parametros[":fecha_fin_registro"] = $fechaFin;
            }

            if($busqueda !== ""){
                $where .= " AND (nombre LIKE :busqueda OR telefono LIKE :busqueda2 OR direccion LIKE :busqueda3 OR agencia LIKE :busqueda4)";
                $parametros[":busqueda"] = "%" . $busqueda . "%";
                $parametros[":busqueda2"] = "%" . $busqueda . "%";
                $parametros[":busqueda3"] = "%" . $busqueda . "%";
                $parametros[":busqueda4"] = "%" . $busqueda . "%";
            }

            $totalStmt = $conexion->prepare("SELECT COUNT(*) FROM respuestas_formulario" . $where);
            $totalStmt->execute($parametros);
            $total = (int) $totalStmt->fetchColumn();
            $totalPaginas = max(1, (int) ceil($total / $limite));
            if($pagina > $totalPaginas){
                $pagina = $totalPaginas;
                $offset = ($pagina - 1) * $limite;
            }

            $sql = "SELECT * FROM respuestas_formulario" . $where . " ORDER BY fecha DESC LIMIT " . $limite . " OFFSET " . $offset;
            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            return array(
                "estado" => "ok",
                "datos" => $stmt->fetchAll(PDO::FETCH_ASSOC),
                "paginacion" => array("pagina" => $pagina, "limite" => $limite, "total" => $total, "total_paginas" => $totalPaginas)
            );
        }catch(PDOException $e){
            return array("estado" => "error", "mensaje" => $e->getMessage());
        }
    }

    static public function mdlCambiarEstado($id, $nuevoEstado){
        try{
            $conexion = self::prepararTabla();
            $stmt = $conexion->prepare("UPDATE respuestas_formulario SET estado = :estado WHERE id = :id AND tenant_id=:tenant_id");
            $stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);
            $stmt->bindParam(":estado", $nuevoEstado, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            if($stmt->execute()){
                return array("estado" => "ok");
            }
            return array("estado" => "error", "mensaje" => "No se pudo actualizar el estado");
        }catch(PDOException $e){
            return array("estado" => "error", "mensaje" => $e->getMessage());
        }
    }

    static public function mdlEliminarRespuesta($id){
        try{
            $conexion = self::prepararTabla();
            $stmt = $conexion->prepare("DELETE FROM respuestas_formulario WHERE id = :id AND tenant_id=:tenant_id");
            $stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            if($stmt->execute()){
                return array("estado" => "ok");
            }
            return array("estado" => "error", "mensaje" => "No se pudo eliminar la respuesta");
        }catch(PDOException $e){
            return array("estado" => "error", "mensaje" => $e->getMessage());
        }
    }

}

?>