<?php 

require_once "controladores/plantilla.controlador.php";

require_once "controladores/usuarios.controlador.php";
require_once "controladores/configuracion.controlador.php"; 
require_once "controladores/compartir.controlador.php";
require_once "controladores/envios.controlador.php";

require_once "modelo/conexion.php";
require_once "modelo/configuracion.modelo.php";
require_once "modelo/compartir.modelo.php";
require_once "modelo/envios.modelo.php";
require_once "modelo/usuarios.modelo.php";


$plantilla =new ControladorPlantilla();
$plantilla->ctrPlantilla();



?>