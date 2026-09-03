<?php

class ControladorConfiguracion{

    static public function ctrMostrarConfiguracion(){

        return ModeloConfiguracion::mdlMostrarConfiguracion("configuracion");

    }

    static public function ctrGuardarConfiguracion(){

        if(!isset($_POST["guardarConfiguracion"])){
            return;
        }

        $datos = array(
            "razon_social" => trim($_POST["razonSocial"] ?? ""),
            "ruc" => trim($_POST["ruc"] ?? ""),
            "direccion" => trim($_POST["direccion"] ?? ""),
            "telefono" => trim($_POST["telefono"] ?? ""),
            "correo" => trim($_POST["correo"] ?? "")
        );

        if($datos["razon_social"] == "" || $datos["ruc"] == ""){
            echo '<script>Swal.fire({type:"error",title:"Completa la razón social y el RUC",showConfirmButton:true,confirmButtonText:"Cerrar"});</script>';
            return;
        }

        if(!preg_match('/^[0-9]{11}$/', $datos["ruc"])){ 
            echo '<script>Swal.fire({type:"error",title:"El RUC debe tener 11 dígitos",showConfirmButton:true,confirmButtonText:"Cerrar"});</script>';
            return;
        }

        $respuesta = ModeloConfiguracion::mdlGuardarConfiguracion("configuracion", $datos);

        if($respuesta == "ok"){
            echo '<script>Swal.fire({type:"success",title:"La configuración se guardó correctamente",showConfirmButton:true,confirmButtonText:"Cerrar"}).then(function(){window.location="configuracion";});</script>';
        }else{
            echo '<script>Swal.fire({type:"error",title:"No se pudo guardar la configuración",showConfirmButton:true,confirmButtonText:"Cerrar"});</script>';
        }

    }

}
