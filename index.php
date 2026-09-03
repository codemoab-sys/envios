<?php 

require_once "controladores/plantilla.controlador.php";

require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/configuracion.controlador.php"; 
require_once "controladores/compartir.controlador.php";
require_once "controladores/envios.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventas.controlador.php";

require_once "modelo/ventas.modelo.php";
require_once "modelo/conexion.php";
require_once "modelo/configuracion.modelo.php";
require_once "modelo/compartir.modelo.php";
require_once "modelo/envios.modelo.php";
require_once "modelo/clientes.modelo.php";
require_once "modelo/productos.modelo.php";
require_once "modelo/usuarios.modelo.php";
require_once "modelo/categorias.modelo.php";


$plantilla =new ControladorPlantilla();
$plantilla->ctrPlantilla();



?>