<?php

class ControladorConfiguracion{

    static public function ctrMostrarConfiguracion(){

        return ModeloConfiguracion::mdlMostrarConfiguracion("configuracion");

    }

    static public function ctrGuardarConfiguracion(){

        if(!isset($_POST["guardarConfiguracion"]) && !isset($_POST["actualizarPasswordConfiguracion"])){
            return;
        }

        if(isset($_POST["actualizarPasswordConfiguracion"])){
            $password = trim($_POST["nuevaPassword"] ?? "");

            if($password == ""){
                self::mostrarAlerta("error", "Escribe una nueva contraseña");
                return;
            }

            $encriptar = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            $respuesta = ModeloConfiguracion::mdlActualizarPassword("usuarios", $encriptar, $_SESSION["id"]);

            if($respuesta == "ok"){
                self::mostrarAlerta("success", "La contraseña se actualizó correctamente", "configuracion");
            }else{
                self::mostrarAlerta("error", "No se pudo actualizar la contraseña");
            }

            return;
        }

        $datos = array(
            "nombre_emprendimiento" => trim($_POST["nombreEmprendimiento"] ?? ""),
            "whatsapp" => trim($_POST["whatsapp"] ?? ""),
            "metodos_envio" => json_encode($_POST["metodosEnvio"] ?? array()),
            "dias_despacho" => json_encode($_POST["diasDespacho"] ?? array()),
            "hora_corte" => $_POST["horaCorte"] ?? "18:00",
            "anticipacion" => (int) ($_POST["anticipacion"] ?? 0)
        );

        if($datos["nombre_emprendimiento"] == ""){
            self::mostrarAlerta("error", "Completa el nombre del emprendimiento");
            return;
        }

        if(!preg_match('/^9[0-9]{8}$/', $datos["whatsapp"])){ 
            self::mostrarAlerta("error", "El WhatsApp debe tener 9 dígitos y empezar con 9");
            return;
        }

        if(count(json_decode($datos["metodos_envio"], true) ?: array()) == 0){
            self::mostrarAlerta("error", "Selecciona al menos un método de envío o retiro");
            return;
        }

        if(count(json_decode($datos["dias_despacho"], true) ?: array()) == 0){
            self::mostrarAlerta("error", "Selecciona al menos un día de despacho");
            return;
        }

        $respuesta = ModeloConfiguracion::mdlGuardarConfiguracion("configuracion", $datos);

        if($respuesta == "ok"){
            self::mostrarAlerta("success", "La configuración se guardó correctamente", "configuracion");
        }else{
            self::mostrarAlerta("error", "No se pudo guardar la configuración");
        }

    }

    static public function ctrActualizarPassword($password, $id){

        if(trim($password) == ""){
            return array("estado" => "error", "mensaje" => "Escribe una nueva contraseña");
        }

        if(strlen($password) < 6){
            return array("estado" => "error", "mensaje" => "La contraseña debe tener al menos 6 caracteres");
        }

        $encriptar = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
        $respuesta = ModeloConfiguracion::mdlActualizarPassword("usuarios", $encriptar, $id);

        return array(
            "estado" => $respuesta == "ok" ? "ok" : "error",
            "mensaje" => $respuesta == "ok" ? "La contraseña se actualizó correctamente" : "No se pudo actualizar la contraseña"
        );

    }

    static private function mostrarAlerta($tipo, $titulo, $ruta = ""){

        $redireccion = $ruta == "" ? "" : ".then(function(){window.location=\"".$ruta."\";})";
        echo '<script>Swal.fire({icon:"'.$tipo.'",title:"'.$titulo.'",showConfirmButton:true,confirmButtonText:"Cerrar"})'.$redireccion.';</script>';

    }

}
