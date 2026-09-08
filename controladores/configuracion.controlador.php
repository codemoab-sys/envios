<?php

class ControladorConfiguracion{

    static public function ctrMostrarConfiguracion(){

        return ModeloConfiguracion::mdlMostrarConfiguracion("envio_configuracion");

    }

    static public function ctrGuardarConfiguracion(){

        if(!isset($_POST["guardarConfiguracion"]) && !isset($_POST["actualizarPasswordConfiguracion"])){
            return;
        }
        if(!Conexion::puedeEscribir()){
            self::mostrarAlerta("warning", "Tu período terminó. Puedes consultar la información, pero no crear ni modificar datos.");
            return;
        }

        if(isset($_POST["actualizarPasswordConfiguracion"])){
            $password = trim($_POST["nuevaPassword"] ?? "");

            if($password == ""){
                self::mostrarAlerta("error", "Escribe una nueva contraseña");
                return;
            }

            $encriptar = password_hash($password, PASSWORD_DEFAULT);
            $respuesta = ModeloConfiguracion::mdlActualizarPassword("envio_usuarios", $encriptar, $_SESSION["id"]);

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

        if(ModeloConfiguracion::mdlWhatsappExiste($datos["whatsapp"], $_SESSION["id"] ?? 0)){
            self::mostrarAlerta("error", "Ese WhatsApp ya está registrado en otra cuenta");
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

        $respuesta = ModeloConfiguracion::mdlGuardarConfiguracion("envio_configuracion", $datos);

        if($respuesta == "ok"){
            $_SESSION["usuario"] = $datos["whatsapp"];
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

        $encriptar = password_hash($password, PASSWORD_DEFAULT);
        $respuesta = ModeloConfiguracion::mdlActualizarPassword("envio_usuarios", $encriptar, $id);

        return array(
            "estado" => $respuesta == "ok" ? "ok" : "error",
            "mensaje" => $respuesta == "ok" ? "La contraseña se actualizó correctamente" : "No se pudo actualizar la contraseña"
        );

    }

    static public function ctrGuardarApariencia($tema, $colorCabecera, $colorBotonPrimario, $colorBotonSecundario){
        $tema = $tema === "dark" ? "dark" : "light";
        $colorCabecera = strtolower(trim($colorCabecera));
        $colorBotonPrimario = strtolower(trim($colorBotonPrimario));
        $colorBotonSecundario = strtolower(trim($colorBotonSecundario));
        if(!preg_match('/^#[0-9a-f]{6}$/i', $colorCabecera) || !preg_match('/^#[0-9a-f]{6}$/i', $colorBotonPrimario) || !preg_match('/^#[0-9a-f]{6}$/i', $colorBotonSecundario)){
            return array("estado" => "error", "mensaje" => "Color de cabecera no válido");
        }
        $respuesta = ModeloConfiguracion::mdlGuardarApariencia($tema, $colorCabecera, $colorBotonPrimario, $colorBotonSecundario);
        return array(
            "estado" => $respuesta === "ok" ? "ok" : "error",
            "mensaje" => $respuesta === "ok" ? "Apariencia guardada" : "No se pudo guardar la apariencia"
        );
    }

    static private function mostrarAlerta($tipo, $titulo, $ruta = ""){

        $redireccion = $ruta == "" ? "" : ".then(function(){window.location=\"".$ruta."\";})";
        echo '<script>Swal.fire({icon:"'.$tipo.'",title:"'.$titulo.'",showConfirmButton:true,confirmButtonText:"Cerrar"})'.$redireccion.';</script>';

    }

}
