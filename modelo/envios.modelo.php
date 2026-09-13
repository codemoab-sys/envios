<?php

require_once "conexion.php";

class ModeloEnvios{

    static private function prepararTabla(){
        $conexion = Conexion::conectar();
        $conexion->exec("CREATE TABLE IF NOT EXISTS envio_respuestas_formulario (
            id INT NOT NULL AUTO_INCREMENT,
            tenant_id INT NULL,
            nombre VARCHAR(150) NOT NULL,
            doc VARCHAR(30) NULL,
            telefono VARCHAR(30) NULL,
            direccion TEXT NULL,
            agencia VARCHAR(100) NOT NULL DEFAULT 'SHALOM',
            fecha_envio VARCHAR(50) NULL,
            codigo VARCHAR(40) NULL,
                estado VARCHAR(30) NOT NULL DEFAULT 'nuevo',
            mensaje TEXT NULL,
            fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            INDEX idx_respuestas_tenant (tenant_id),
            INDEX idx_respuestas_estado (estado),
            INDEX idx_respuestas_fecha (fecha)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        try{
            $result = $conexion->query("SHOW COLUMNS FROM envio_respuestas_formulario LIKE 'agencia'");
            if($result && $result->rowCount() === 0){
                $conexion->exec("ALTER TABLE envio_respuestas_formulario ADD COLUMN agencia VARCHAR(100) NOT NULL DEFAULT 'SHALOM' AFTER direccion");
            }
        }catch(PDOException $e){
            // Ignorar si la tabla ya está creada con la columna o si la BD no admite la verificación.
        }

        try{
            $result = $conexion->query("SHOW COLUMNS FROM envio_respuestas_formulario LIKE 'doc'");
            if($result && $result->rowCount() === 0){
                $conexion->exec("ALTER TABLE envio_respuestas_formulario ADD COLUMN doc VARCHAR(30) NULL AFTER nombre");
            }
        }catch(PDOException $e){
            // Ignorar si la columna ya existe.
        }

        try{
            $result = $conexion->query("SHOW COLUMNS FROM envio_respuestas_formulario LIKE 'fecha_envio'");
            if($result && $result->rowCount() === 0){
                $conexion->exec("ALTER TABLE envio_respuestas_formulario ADD COLUMN fecha_envio VARCHAR(50) NULL AFTER agencia");
            }
        }catch(PDOException $e){
            // Ignorar si la columna ya existe.
        }

        try{
            $conexion->exec("ALTER TABLE envio_respuestas_formulario MODIFY COLUMN direccion TEXT NULL");
        }catch(PDOException $e){
            // Ignorar si la columna ya tiene un tipo compatible.
        }

        try{
            $result = $conexion->query("SHOW COLUMNS FROM envio_respuestas_formulario LIKE 'codigo'");
            if($result && $result->rowCount() === 0){
                $conexion->exec("ALTER TABLE envio_respuestas_formulario ADD COLUMN codigo VARCHAR(40) NULL AFTER fecha_envio");
            }
            $conexion->exec("UPDATE envio_respuestas_formulario SET codigo = CONCAT('ENV-', DATE_FORMAT(fecha, '%y%m%d'), '-', LPAD(id, 6, '0')) WHERE codigo IS NULL OR codigo = '' OR LENGTH(codigo) > 18");
            $indicesCodigo = $conexion->query("SHOW INDEX FROM envio_respuestas_formulario WHERE Key_name = 'uk_envio_respuestas_codigo'");
            if($indicesCodigo && $indicesCodigo->rowCount() === 0){
                $conexion->exec("ALTER TABLE envio_respuestas_formulario ADD UNIQUE KEY uk_envio_respuestas_codigo (codigo)");
            }
            $conexion->exec("UPDATE envio_respuestas_formulario SET estado = 'nuevo' WHERE estado IN ('pendiente', 'completado')");
            $conexion->exec("ALTER TABLE envio_respuestas_formulario MODIFY codigo VARCHAR(40) NOT NULL");
        }catch(PDOException $e){
            // Mantener el acceso disponible si la columna ya fue preparada en otra solicitud.
        }

        return $conexion;
    }

    static public function mdlContarRespuestas(){
        try{
            $stmt = self::prepararTabla()->prepare("SELECT COUNT(*) FROM envio_respuestas_formulario WHERE tenant_id=:tenant_id");
            $stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        }catch(PDOException $e){
            return 0;
        }
    }

    static public function mdlEstadisticasDashboard(){
        try{
            $conexion = self::prepararTabla();
            $tenantId = Conexion::tenantId();
            $hoy = date("Y-m-d");

            $stmtHoy = $conexion->prepare("SELECT COUNT(*) FROM envio_respuestas_formulario WHERE tenant_id=:tenant_id AND DATE(fecha)=:hoy");
            $stmtHoy->bindValue(":tenant_id", $tenantId, PDO::PARAM_INT);
            $stmtHoy->bindValue(":hoy", $hoy, PDO::PARAM_STR);
            $stmtHoy->execute();
            $hoyCount = (int) $stmtHoy->fetchColumn();

            $stmtPendientes = $conexion->prepare("SELECT COUNT(*) FROM envio_respuestas_formulario WHERE tenant_id=:tenant_id AND estado <> 'entregado'");
            $stmtPendientes->bindValue(":tenant_id", $tenantId, PDO::PARAM_INT);
            $stmtPendientes->execute();
            $pendientes = (int) $stmtPendientes->fetchColumn();

            $stmtCompletados = $conexion->prepare("SELECT COUNT(*) FROM envio_respuestas_formulario WHERE tenant_id=:tenant_id AND estado='entregado'");
            $stmtCompletados->bindValue(":tenant_id", $tenantId, PDO::PARAM_INT);
            $stmtCompletados->execute();
            $completados = (int) $stmtCompletados->fetchColumn();

            $stmtTotal = $conexion->prepare("SELECT COUNT(*) FROM envio_respuestas_formulario WHERE tenant_id=:tenant_id");
            $stmtTotal->bindValue(":tenant_id", $tenantId, PDO::PARAM_INT);
            $stmtTotal->execute();
            $total = (int) $stmtTotal->fetchColumn();

            return array(
                "hoy" => $hoyCount,
                "pendientes" => $pendientes,
                "completados" => $completados,
                "total" => $total
            );
        }catch(PDOException $e){
            return array("hoy" => 0, "pendientes" => 0, "completados" => 0, "total" => 0);
        }
    }

    static public function mdlDetalleReporte($fechaInicio = "", $fechaFin = "", $estado = "todos"){
        try{
            $conexion = self::prepararTabla();
            $where = " WHERE tenant_id = :tenant_id";
            $parametros = array(":tenant_id" => Conexion::tenantId());
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
            if(in_array($estado, array("nuevo", "etiqueta", "entregado"), true)){
                $estados = $estado === "nuevo" ? array("nuevo", "pagado", "preparando") : ($estado === "etiqueta" ? array("etiqueta", "etiqueta_generada", "enviado", "en_transito") : array("entregado"));
                $marcadores = array();
                foreach($estados as $indice => $estadoFiltro){
                    $marcador = ":estado_" . $indice;
                    $marcadores[] = $marcador;
                    $parametros[$marcador] = $estadoFiltro;
                }
                $where .= " AND estado IN (" . implode(",", $marcadores) . ")";
            }
            $stmt = $conexion->prepare("SELECT agencia, estado, COUNT(*) AS cantidad FROM envio_respuestas_formulario" . $where . " GROUP BY agencia, estado ORDER BY cantidad DESC, agencia ASC");
            $stmt->execute($parametros);
            $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $total = 0;
            foreach($filas as $fila) $total += (int) $fila["cantidad"];
            return array("estado" => "ok", "datos" => $filas, "total" => $total);
        }catch(PDOException $e){
            return array("estado" => "error", "mensaje" => $e->getMessage());
        }
    }

    static public function mdlPedidosRecientes($limite = 5){
        try{
            $conexion = self::prepararTabla();
            $stmt = $conexion->prepare("SELECT id, codigo, nombre, agencia, estado, fecha FROM envio_respuestas_formulario WHERE tenant_id=:tenant_id ORDER BY fecha DESC LIMIT :limite");
            $stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);
            $stmt->bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            return array();
        }
    }

    static public function mdlGuardarRespuesta($datos){
        try{
            $tenantId = (int) ($datos["tenant_id"] ?? Conexion::tenantId());
            if($tenantId <= 0) return array("estado" => "error", "mensaje" => "Tenant no válido");
            if(!Conexion::tenantPuedeEscribir($tenantId)) return array("estado" => "error", "mensaje" => "La suscripción de esta empresa terminó");
            $conexion = self::prepararTabla();
            $conexion->beginTransaction();
            $codigoTemporal = "TMP-" . date("ymdHis") . "-" . mt_rand(100000, 999999);
            $stmt = $conexion->prepare("INSERT INTO envio_respuestas_formulario (tenant_id, nombre, doc, telefono, direccion, agencia, fecha_envio, codigo, estado, mensaje) VALUES (:tenant_id, :nombre, :doc, :telefono, :direccion, :agencia, :fecha_envio, :codigo, 'nuevo', :mensaje)");
            $stmt->bindValue(":tenant_id", $tenantId, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":doc", $datos["doc"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
            $stmt->bindParam(":agencia", $datos["agencia"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_envio", $datos["fecha_envio"], PDO::PARAM_STR);
            $stmt->bindValue(":codigo", $codigoTemporal, PDO::PARAM_STR);
            $stmt->bindParam(":mensaje", $datos["mensaje"], PDO::PARAM_STR);
            if($stmt->execute()){
                $id = (int) $conexion->lastInsertId();
                $codigo = "ENV-" . date("ymd") . "-" . str_pad((string) $id, 6, "0", STR_PAD_LEFT);
                $stmtCodigo = $conexion->prepare("UPDATE envio_respuestas_formulario SET codigo = :codigo WHERE id = :id");
                $stmtCodigo->bindValue(":codigo", $codigo, PDO::PARAM_STR);
                $stmtCodigo->bindValue(":id", $id, PDO::PARAM_INT);
                if(!$stmtCodigo->execute()) throw new PDOException("No se pudo asignar el código del envío");
                $conexion->commit();
                return array("estado" => "ok", "id" => $id, "codigo" => $codigo);
            }
            $conexion->rollBack();
            return array("estado" => "error", "mensaje" => "No se pudo guardar la respuesta");
        }catch(PDOException $e){
            if(isset($conexion) && $conexion->inTransaction()) $conexion->rollBack();
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
                $estadosFiltro = array($estado);
                if($estado === "nuevo") $estadosFiltro = array("nuevo", "pagado", "preparando");
                if($estado === "etiqueta") $estadosFiltro = array("etiqueta", "etiqueta_generada", "enviado", "en_transito");
                $marcadoresEstado = array();
                foreach($estadosFiltro as $indiceEstado => $estadoFiltro){
                    $marcadorEstado = ":estado_" . $indiceEstado;
                    $marcadoresEstado[] = $marcadorEstado;
                    $parametros[$marcadorEstado] = $estadoFiltro;
                }
                $where .= " AND estado IN (" . implode(",", $marcadoresEstado) . ")";
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
                $where .= " AND (nombre LIKE :busqueda OR doc LIKE :busqueda2 OR telefono LIKE :busqueda3 OR direccion LIKE :busqueda4 OR agencia LIKE :busqueda5)";
                $parametros[":busqueda"] = "%" . $busqueda . "%";
                $parametros[":busqueda2"] = "%" . $busqueda . "%";
                $parametros[":busqueda3"] = "%" . $busqueda . "%";
                $parametros[":busqueda4"] = "%" . $busqueda . "%";
                $parametros[":busqueda5"] = "%" . $busqueda . "%";
            }

            $totalStmt = $conexion->prepare("SELECT COUNT(*) FROM envio_respuestas_formulario" . $where);
            $totalStmt->execute($parametros);
            $total = (int) $totalStmt->fetchColumn();
            $totalPaginas = max(1, (int) ceil($total / $limite));
            if($pagina > $totalPaginas){
                $pagina = $totalPaginas;
                $offset = ($pagina - 1) * $limite;
            }

            $sql = "SELECT * FROM envio_respuestas_formulario" . $where . " ORDER BY fecha DESC LIMIT " . $limite . " OFFSET " . $offset;
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

    static public function mdlActualizarRespuesta($datos){
        try{
            $tenantId = (int) ($datos["tenant_id"] ?? 0);
            if($tenantId <= 0 || !Conexion::tenantPuedeEscribir($tenantId)) return array("estado" => "error", "mensaje" => "Tu período terminó; solo puedes consultar los envíos");
            $conexion = self::prepararTabla();
            $stmt = $conexion->prepare("UPDATE envio_respuestas_formulario SET nombre = :nombre, doc = :doc, telefono = :telefono, direccion = :direccion, agencia = :agencia, fecha_envio = :fecha_envio, mensaje = :mensaje WHERE id = :id AND tenant_id = :tenant_id");
            $stmt->bindValue(":id", (int) $datos["id"], PDO::PARAM_INT);
            $stmt->bindValue(":tenant_id", $tenantId, PDO::PARAM_INT);
            $stmt->bindValue(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindValue(":doc", $datos["doc"], PDO::PARAM_STR);
            $stmt->bindValue(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $stmt->bindValue(":direccion", $datos["direccion"], PDO::PARAM_STR);
            $stmt->bindValue(":agencia", $datos["agencia"], PDO::PARAM_STR);
            $stmt->bindValue(":fecha_envio", $datos["fecha_envio"], PDO::PARAM_STR);
            $stmt->bindValue(":mensaje", $datos["mensaje"], PDO::PARAM_STR);
            if(!$stmt->execute()) return array("estado" => "error", "mensaje" => "No se pudo actualizar la respuesta");
            $codigoStmt = $conexion->prepare("SELECT codigo FROM envio_respuestas_formulario WHERE id = :id AND tenant_id = :tenant_id LIMIT 1");
            $codigoStmt->execute(array(":id" => (int) $datos["id"], ":tenant_id" => $tenantId));
            return array("estado" => "ok", "codigo" => (string) $codigoStmt->fetchColumn());
        }catch(PDOException $e){
            return array("estado" => "error", "mensaje" => $e->getMessage());
        }
    }

    static public function mdlCambiarEstado($id, $nuevoEstado){
        try{
            $conexion = self::prepararTabla();
            $stmt = $conexion->prepare("UPDATE envio_respuestas_formulario SET estado = :estado WHERE id = :id AND tenant_id=:tenant_id");
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
            $stmt = $conexion->prepare("DELETE FROM envio_respuestas_formulario WHERE id = :id AND tenant_id=:tenant_id");
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

    static private function prepararTablaRotulados(){
        $conexion = self::prepararTabla();
        $conexion->exec("CREATE TABLE IF NOT EXISTS envio_rotulados (
            id INT NOT NULL AUTO_INCREMENT,
            tenant_id INT NOT NULL,
            envio_id INT NOT NULL,
            doc VARCHAR(30) NOT NULL,
            nombre_archivo VARCHAR(255) NOT NULL,
            archivo VARCHAR(255) NOT NULL,
            url VARCHAR(500) NOT NULL,
            fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            INDEX idx_rotulados_tenant_doc (tenant_id, doc),
            INDEX idx_rotulados_envio (envio_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        return $conexion;
    }

    static public function mdlBuscarEnvioPorDoc($doc){
        try{
            $stmt = self::prepararTablaRotulados()->prepare("SELECT id, nombre, doc FROM envio_respuestas_formulario WHERE tenant_id = :tenant_id AND doc = :doc ORDER BY fecha DESC, id DESC LIMIT 1");
            $stmt->execute(array(":tenant_id" => Conexion::tenantId(), ":doc" => $doc));
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: array();
        }catch(PDOException $e){
            return array();
        }
    }

    static public function mdlGuardarRotulado($datos){
        try{
            $conexion = self::prepararTablaRotulados();
            $stmt = $conexion->prepare("INSERT INTO envio_rotulados (tenant_id, envio_id, doc, nombre_archivo, archivo, url) VALUES (:tenant_id, :envio_id, :doc, :nombre_archivo, :archivo, :url)");
            $stmt->execute(array(
                ":tenant_id" => Conexion::tenantId(),
                ":envio_id" => (int) $datos["envio_id"],
                ":doc" => $datos["doc"],
                ":nombre_archivo" => $datos["nombre_archivo"],
                ":archivo" => $datos["archivo"],
                ":url" => $datos["url"]
            ));
            return array("estado" => "ok", "id" => (int) $conexion->lastInsertId());
        }catch(PDOException $e){
            return array("estado" => "error", "mensaje" => "No se pudo guardar el rotulado");
        }
    }

    static public function mdlListarClientesRotulados(){
        try{
            $stmt = self::prepararTablaRotulados()->prepare("SELECT e.doc, e.nombre, e.telefono, COUNT(r.id) AS total_rotulados, (SELECT r2.url FROM envio_rotulados r2 WHERE r2.tenant_id = e.tenant_id AND r2.doc = e.doc ORDER BY r2.fecha DESC, r2.id DESC LIMIT 1) AS ultimo_rotulado FROM envio_respuestas_formulario e LEFT JOIN envio_rotulados r ON r.tenant_id = e.tenant_id AND r.doc = e.doc WHERE e.tenant_id = :tenant_id AND e.doc IS NOT NULL AND e.doc <> '' GROUP BY e.doc, e.nombre, e.telefono ORDER BY e.nombre ASC");
            $stmt->execute(array(":tenant_id" => Conexion::tenantId()));
            return array("estado" => "ok", "datos" => $stmt->fetchAll(PDO::FETCH_ASSOC));
        }catch(PDOException $e){
            return array("estado" => "error", "mensaje" => $e->getMessage());
        }
    }

    static public function mdlListarRotuladosCliente($doc){
        try{
            $stmt = self::prepararTablaRotulados()->prepare("SELECT r.*, e.codigo, e.telefono, e.nombre FROM envio_rotulados r INNER JOIN envio_respuestas_formulario e ON e.id = r.envio_id AND e.tenant_id = r.tenant_id WHERE r.tenant_id = :tenant_id AND r.doc = :doc ORDER BY r.fecha DESC, r.id DESC");
            $stmt->execute(array(":tenant_id" => Conexion::tenantId(), ":doc" => $doc));
            return array("estado" => "ok", "datos" => $stmt->fetchAll(PDO::FETCH_ASSOC));
        }catch(PDOException $e){
            return array("estado" => "error", "mensaje" => $e->getMessage());
        }
    }

}

?>