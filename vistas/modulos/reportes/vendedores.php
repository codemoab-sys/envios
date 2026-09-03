<?php 


$item = null;
$valor = null;

$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);


$arrayVendedores = array();

$arraylistaVendedores = array();

foreach ($ventas as $key => $valueVentas) {

    foreach ($usuarios as $key => $valueUsuarios) {


         if($valueUsuarios["id"] == $valueVentas["id_vendedor"]){

             array_push($arrayVendedores, $valueUsuarios["nombre"]);

              $arraylistaVendedores = array($valueUsuarios["nombre"] => $valueVentas["neto"]);


            foreach ($arraylistaVendedores as $key => $value) {

                $sumaTotalVendedores[$key] += $value;

            }



         }


    }

}


$noRepetirNombres = array_unique($arrayVendedores);













?>




<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">vendedores</h3>

    </div>
    <div class="box-body chart-responsive">
        <div class="chart" id="bar-chart" style="height: 300px;"></div>
    </div>

</div>







<script>
//BAR CHART
var bar = new Morris.Bar({
    element: 'bar-chart',
    resize: true,
    data: [


        <?php 


foreach ($noRepetirNombres as $key => $value) {


    echo " {
            y: '".$value."',
            a: '".$sumaTotalVendedores[$value]."'

        },";

}



?>



    ],
    barColors: ['#00a65a'],
    xkey: 'y',
    ykeys: ['a'],
    labels: ['ventas'],
    preUnits: '$',
    hideHover: 'auto'
});
</script>