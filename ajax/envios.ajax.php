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
        "telefono" => trim($_POST["telefono"] ?? ""),
        "direccion" => trim($_POST["direccion"] ?? ""),
        "agencia" => trim($_POST["agencia"] ?? "SHALOM"),
        "fecha_envio" => trim($_POST["fecha_envio"] ?? ""),
        "mensaje" => trim($_POST["mensaje"] ?? "")
    );
    echo json_encode(ControladorEnvios::ctrGuardarRespuesta($datos));
    exit;
}

if(isset($_POST["listarRespuestasAjax"])){
    echo json_encode(ControladorEnvios::ctrListarRespuestas($_POST["estado"] ?? "todos", $_POST["busqueda"] ?? "", $_POST["agencia"] ?? "todos", $_POST["fecha_inicio"] ?? "", $_POST["fecha_fin"] ?? "", (int)($_POST["pagina"] ?? 1), (int)($_POST["limite"] ?? 10)));
    exit;
}

if(isset($_POST["cambiarEstadoAjax"])){
    echo json_encode(ControladorEnvios::ctrCambiarEstado((int)($_POST["id"] ?? 0), $_POST["nuevoEstado"] ?? "pendiente"));
    exit;
}

if(isset($_POST["eliminarRespuestaAjax"])){
    echo json_encode(ControladorEnvios::ctrEliminarRespuesta((int)($_POST["id"] ?? 0)));
    exit;
}

echo json_encode(array("estado" => "error", "mensaje" => "Solicitud no valida"));
