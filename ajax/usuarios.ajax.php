<?php 

session_start();

if(!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] !== "ok" || strtolower(trim((string)($_SESSION["perfil"] ?? ""))) !== "administrador"){
    http_response_code(403);
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode(array("estado" => "error", "mensaje" => "No autorizado"));
    exit;
}

require_once "../controladores/usuarios.controlador.php";
require_once "../modelo/usuarios.modelo.php";



class AjaxUsuarios{


    public $idUsuario;


    public function ajaxEditarUsuario(){

        $item="id";
        $valor=$this->idUsuario;
        $respuesta=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);

        echo json_encode($respuesta);

    }


    	/*=============================================
	ACTIVAR USUARIO
	=============================================*/	

	public $activarUsuario;
	public $activarId;


    public function ajaxActivarUsuario(){

        $tabla="usuarios";

        $item1="estado";
        $valor1=$this->activarUsuario;

        $item2 = "id";
		$valor2 = $this->activarId;

        $respuesta = ControladorUsuarios::ctrActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);




    }

}




/*=============================================
EDITAR USUARIO
=============================================*/

if(isset($_POST["idUsuario"])){

$editar=new AjaxUsuarios();
$editar->idUsuario=$_POST["idUsuario"];
$editar->ajaxEditarUsuario();



}



/*=============================================
ACTIVAR USUARIO
=============================================*/	

if(isset($_POST["activarUsuario"])){

	$activarUsuario = new AjaxUsuarios();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario();

}








?>