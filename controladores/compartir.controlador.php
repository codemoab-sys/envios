<?php

class ControladorCompartir{

    static public function ctrMostrarActivo(){
        return ModeloCompartir::mdlMostrarActivo();
    }

    static public function ctrMostrarPorToken($token){
        return ModeloCompartir::mdlMostrarPorToken($token);
    }

    static public function ctrGuardar(){
        if(!isset($_POST["guardarCompartir"])){ return; }
        if(!Conexion::puedeEscribir()){
            echo '<script>Swal.fire({icon:"warning",title:"Cuenta en modo solo lectura",text:"Tu período terminó; no puedes crear nuevos formularios.",confirmButtonText:"Cerrar"});</script>';
            return;
        }
        $titulo = trim($_POST["tituloCompartir"] ?? "");
        $descripcion = trim($_POST["descripcionCompartir"] ?? "");
        if($titulo == ""){
            echo '<script>Swal.fire({type:"error",title:"Escribe un título para el formulario",confirmButtonText:"Cerrar"});</script>';
            return;
        }
        if(ModeloCompartir::mdlGuardar(array("titulo" => $titulo, "descripcion" => $descripcion)) == "ok"){
            echo '<script>Swal.fire({type:"success",title:"El formulario se creó correctamente",confirmButtonText:"Continuar"}).then(function(){window.location="compartir";});</script>';
        }
    }

}

?>
