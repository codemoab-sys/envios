<?php

session_start();
require_once "../controladores/envios.controlador.php";
require_once "../modelo/envios.modelo.php";
require_once "../modelo/compartir.modelo.php";

header("Content-Type: application/json; charset=UTF-8");

if(isset($_POST["guardarRespuestaAjax"])){
    $merchant = trim((string) ($_POST["merchant"] ?? ""));
    if($merchant === ""){
        echo json_encode(array("estado" => "error", "mensaje" => "Enlace de formulario no válido"));
        exit;
    }
    $formulario = ModeloCompartir::mdlMostrarPorToken($merchant);
    $tenantId = (int) ($formulario["tenant_id"] ?? 0);
    if($tenantId <= 0){
        echo json_encode(array("estado" => "error", "mensaje" => "El formulario no pertenece a una empresa válida"));
        exit;
    }
    if(!Conexion::tenantPuedeEscribir($tenantId)){
        echo json_encode(array("estado" => "error", "mensaje" => "La suscripción de esta empresa terminó; el formulario está temporalmente cerrado"));
        exit;
    }
    $datos = array(
        "tenant_id" => $tenantId,
        "nombre" => trim($_POST["nombre"] ?? ""),
        "doc" => trim($_POST["doc"] ?? ""),
        "telefono" => trim($_POST["telefono"] ?? ""),
        "direccion" => trim($_POST["direccion"] ?? ""),
        "agencia" => trim($_POST["agencia"] ?? "SHALOM"),
        "fecha_envio" => trim($_POST["fecha_envio"] ?? ""),
        "mensaje" => trim($_POST["mensaje"] ?? "")
    );
    echo json_encode(ControladorEnvios::ctrGuardarRespuesta($datos));
    exit;
}

if(isset($_POST["actualizarRespuestaAjax"])){
    $merchant = trim((string) ($_POST["merchant"] ?? ""));
    $formulario = $merchant !== "" ? ModeloCompartir::mdlMostrarPorToken($merchant) : array();
    $tenantId = (int) ($formulario["tenant_id"] ?? 0);
    if($tenantId <= 0){
        echo json_encode(array("estado" => "error", "mensaje" => "Enlace de formulario no válido"));
        exit;
    }
    $datos = array(
        "tenant_id" => $tenantId,
        "id" => (int) ($_POST["id"] ?? 0),
        "nombre" => trim($_POST["nombre"] ?? ""),
        "doc" => trim($_POST["doc"] ?? ""),
        "telefono" => trim($_POST["telefono"] ?? ""),
        "direccion" => trim($_POST["direccion"] ?? ""),
        "agencia" => trim($_POST["agencia"] ?? "SHALOM"),
        "fecha_envio" => trim($_POST["fecha_envio"] ?? ""),
        "mensaje" => trim($_POST["mensaje"] ?? "")
    );
    echo json_encode(ControladorEnvios::ctrActualizarRespuesta($datos));
    exit;
}

if(isset($_POST["listarRespuestasAjax"])){
    echo json_encode(ControladorEnvios::ctrListarRespuestas($_POST["estado"] ?? "todos", $_POST["busqueda"] ?? "", $_POST["agencia"] ?? "todos", $_POST["fecha_inicio"] ?? "", $_POST["fecha_fin"] ?? "", (int)($_POST["pagina"] ?? 1), (int)($_POST["limite"] ?? 10)));
    exit;
}

if(isset($_POST["cambiarEstadoAjax"])){
    echo json_encode(ControladorEnvios::ctrCambiarEstado((int)($_POST["id"] ?? 0), $_POST["nuevoEstado"] ?? "nuevo"));
    exit;
}

if(isset($_POST["eliminarRespuestaAjax"])){
    echo json_encode(ControladorEnvios::ctrEliminarRespuesta((int)($_POST["id"] ?? 0)));
    exit;
}

if(isset($_POST["listarClientesRotuladosAjax"])){
    echo json_encode(ModeloEnvios::mdlListarClientesRotulados());
    exit;
}

if(isset($_POST["listarRotuladosClienteAjax"])){
    $doc = strtoupper(preg_replace('/[^0-9A-Z]/i', '', trim((string) ($_POST["doc"] ?? ""))));
    echo json_encode(ModeloEnvios::mdlListarRotuladosCliente($doc));
    exit;
}

if(isset($_POST["subirRotuladoAjax"])){
    if(!Conexion::puedeEscribir()){
        echo json_encode(array("estado" => "error", "mensaje" => "Tu período terminó; solo puedes consultar los envíos"));
        exit;
    }
    $doc = strtoupper(preg_replace('/[^0-9A-Z]/i', '', trim((string) ($_POST["doc"] ?? ""))));
    if($doc === "" || empty($_FILES["pdf"]) || $_FILES["pdf"]["error"] !== UPLOAD_ERR_OK){
        echo json_encode(array("estado" => "error", "mensaje" => "Indica el DOC y selecciona un PDF válido"));
        exit;
    }
    $archivo = $_FILES["pdf"];
    if((int) $archivo["size"] > 15 * 1024 * 1024){
        echo json_encode(array("estado" => "error", "mensaje" => "El PDF no puede superar 15 MB"));
        exit;
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if($finfo->file($archivo["tmp_name"]) !== "application/pdf"){
        echo json_encode(array("estado" => "error", "mensaje" => "Solo se permiten archivos PDF"));
        exit;
    }
    $envio = ModeloEnvios::mdlBuscarEnvioPorDoc($doc);
    if(empty($envio)){
        echo json_encode(array("estado" => "error", "mensaje" => "No existe un envío de esta empresa con ese DOC"));
        exit;
    }
    $directorio = dirname(__DIR__) . DIRECTORY_SEPARATOR . "rotulados" . DIRECTORY_SEPARATOR . Conexion::tenantId();
    if(!is_dir($directorio) && !mkdir($directorio, 0750, true)){
        echo json_encode(array("estado" => "error", "mensaje" => "No se pudo crear la carpeta de rotulados"));
        exit;
    }
    $nombreSeguro = $doc . "-" . date("YmdHis") . "-" . bin2hex(random_bytes(4)) . ".pdf";
    $rutaLocal = $directorio . DIRECTORY_SEPARATOR . $nombreSeguro;
    if(!move_uploaded_file($archivo["tmp_name"], $rutaLocal)){
        echo json_encode(array("estado" => "error", "mensaje" => "No se pudo guardar el PDF"));
        exit;
    }
    $url = "rotulados/" . Conexion::tenantId() . "/" . $nombreSeguro;
    $resultado = ModeloEnvios::mdlGuardarRotulado(array("envio_id" => $envio["id"], "doc" => $doc, "nombre_archivo" => $archivo["name"], "archivo" => $rutaLocal, "url" => $url));
    if($resultado["estado"] !== "ok") @unlink($rutaLocal);
    echo json_encode($resultado);
    exit;
}

echo json_encode(array("estado" => "error", "mensaje" => "Solicitud no valida"));
