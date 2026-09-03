<?php 

$item = null;
$valor = null;
$orden = "id";

$ventas = ControladorVentas::ctrSumaTotalVentas();

$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
$totalCategorias=count($categorias);

$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
$totalClientes=count($clientes);

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
$totalProductos = count($productos);




?>




<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">categorias</span>
            <span class="info-box-number"><?php echo $totalCategorias; ?><small></small></span>
        </div>

    </div>

</div>

<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">productos</span>
            <span class="info-box-number"><?php echo $totalProductos; ?></span>
        </div>

    </div>

</div>


<div class="clearfix visible-sm-block"></div>
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">ventas</span>
            <span class="info-box-number">$<?php echo number_format($ventas["total"],2); ?></span>
        </div>

    </div>

</div>

<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">clientes</span>
            <span class="info-box-number"><?php echo $totalClientes; ?></span>
        </div>

    </div>

</div>