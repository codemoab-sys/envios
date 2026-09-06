<?php

session_start();
require_once "../controladores/configuracion.controlador.php";
require_once "../modelo/configuracion.modelo.php";

header("Content-Type: application/json; charset=UTF-8");

if(!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] != "ok" || !isset($_SESSION["id"])){ 
    echo json_encode(array("estado" => "error", "mensaje" => "Sesión no válida"));
    exit;
}

if(isset($_POST["actualizarPasswordAjax"])){
    echo json_encode(ControladorConfiguracion::ctrActualizarPassword($_POST["nuevaPassword"] ?? "", $_SESSION["id"]));
    exit;
}

if(isset($_POST["guardarAparienciaAjax"])){ 
    echo json_encode(ControladorConfiguracion::ctrGuardarApariencia($_POST["tema"] ?? "light", $_POST["color_cabecera"] ?? "#dd4b39", $_POST["color_boton_primario"] ?? "#3b82f6", $_POST["color_boton_secundario"] ?? "#202c42"));
    exit;
}

echo json_encode(array("estado" => "error", "mensaje" => "Solicitud no válida"));