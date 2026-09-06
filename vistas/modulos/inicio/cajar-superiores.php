<?php 

$item = null;
$valor = null;
$orden = "id";

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
$totalProductos = count($productos);




?>




<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">productos</span>
            <span class="info-box-number"><?php echo $totalProductos; ?></span>
        </div>

    </div>

</div>


