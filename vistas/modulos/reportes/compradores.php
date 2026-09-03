<?php 


$item = null;
$valor = null;

$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);


$arrayClientes = array();

$arraylistaClientes = array();

foreach ($ventas as $key => $valueVentas) {

    foreach ($clientes as $key => $valueclientes) {


         if($valueclientes["id"] == $valueVentas["id_cliente"]){

             array_push($arrayClientes, $valueclientes["nombre"]);

              $arraylistaClientes = array($valueclientes["nombre"] => $valueVentas["neto"]);


            foreach ($arraylistaClientes as $key => $value) {

                $sumaTotalClientes[$key] += $value;

            }



         }


    }

}


$noRepetirNombres = array_unique($arrayClientes);













?>




<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">clientes</h3>

    </div>
    <div class="box-body chart-responsive">
        <div class="chart" id="bar-chart2" style="height: 300px;"></div>
    </div>

</div>







<script>
//BAR CHART
var bar = new Morris.Bar({
    element: 'bar-chart2',
    resize: true,
    data: [


        <?php 


foreach ($noRepetirNombres as $key => $value) {


    echo " {
            y: '".$value."',
            a: '".$sumaTotalClientes[$value]."'

        },";

}



?>



    ],
    barColors: ['#FF5733'],
    xkey: 'y',
    ykeys: ['a'],
    labels: ['ventas'],
    preUnits: '$',
    hideHover: 'auto'
});
</script>