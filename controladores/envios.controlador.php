<?php

class ControladorEnvios{

    static public function ctrContarRespuestas(){
        return ModeloEnvios::mdlContarRespuestas();
    }

    static public function ctrGuardarRespuesta($datos){
        if($datos["nombre"] === ""){
            return array("estado" => "error", "mensaje" => "El nombre es obligatorio");
        }
        if($datos["telefono"] === ""){
            return array("estado" => "error", "mensaje" => "El telefono es obligatorio");
        }
        $datos["agencia"] = trim((string)($datos["agencia"] ?? "SHALOM"));
        if($datos["agencia"] === ""){
            $datos["agencia"] = "SHALOM";
        }
        $datos["fecha_envio"] = trim((string)($datos["fecha_envio"] ?? ""));
        if($datos["fecha_envio"] === "" || $datos["fecha_envio"] === "Elige una fecha..."){
            $datos["fecha_envio"] = "";
        }
        return ModeloEnvios::mdlGuardarRespuesta($datos);
    }

    static public function ctrListarRespuestas($estado, $busqueda, $agencia = "todos", $fechaInicio = "", $fechaFin = "", $pagina = 1, $limite = 10){
        return ModeloEnvios::mdlListarRespuestas($estado, $busqueda, $agencia, $fechaInicio, $fechaFin, $pagina, $limite);
    }

    static public function ctrCambiarEstado($id, $nuevoEstado){
        if(!Conexion::puedeEscribir()) return array("estado" => "error", "mensaje" => "Tu período terminó; solo puedes consultar los envíos");
        if($id <= 0){
            return array("estado" => "error", "mensaje" => "ID invalido");
        }
        $estadosPermitidos = array("pendiente", "completado");
        if(!in_array($nuevoEstado, $estadosPermitidos)){
            return array("estado" => "error", "mensaje" => "Estado no valido");
        }
        return ModeloEnvios::mdlCambiarEstado($id, $nuevoEstado);
    }

    static public function ctrEliminarRespuesta($id){
        if(!Conexion::puedeEscribir()) return array("estado" => "error", "mensaje" => "Tu período terminó; solo puedes consultar los envíos");
        if($id <= 0){
            return array("estado" => "error", "mensaje" => "ID invalido");
        }
        return ModeloEnvios::mdlEliminarRespuesta($id);
    }

}

?>