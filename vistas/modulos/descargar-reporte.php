<?php 

require_once "../../controladores/ventas.controlador.php";
require_once "../../modelo/ventas.modelo.php";
require_once "../../controladores/clientes.controlador.php";
require_once "../../modelo/clientes.modelo.php";
require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelo/usuarios.modelo.php";



$reporte= new ControladorVentas();
$reporte -> ctrDescargarReporte();



?>