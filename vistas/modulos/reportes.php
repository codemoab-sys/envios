    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                reporte de ventas

            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                <li class="active">reporte ventas</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">




                    <div id="reportrange2" class="btn btn-default pull-lefth"
                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 30%">
                        &nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>

                    <div class="box-tools pull-right">

                        <?php
                    
                    if(isset($_GET["fechaInicial"])){

                        echo '<a href="vistas/modulos/descargar-reporte.php?reportes=reportes&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'">';


                    }else{

                        echo '<a href="vistas/modulos/descargar-reporte.php?reportes=reportes">';



                    }
                    
                             
                    ?>


                        <button class="btn btn-success" style="margin-top:5px">Descargar reporte en Excel</button>

                    </div>









                </div>
                <div class="box-body">

                    <div class="row">

                        <div class="col-xs-12">

                            <?php 

                            include "reportes/grafico-ventas.php";
                            
                            
                            
                            ?>


                        </div>
                        <div class="col-md-6 col-xs-12">

                            <?php 

                            include "reportes/productos-mas-vendidos.php";
                            
                            
                            
                            ?>


                        </div>

                        <div class="col-md-6 col-xs-12">

                            <?php 

                            include "reportes/vendedores.php";
                            
                            
                            
                            ?>


                        </div>

                        <div class="col-md-6 col-xs-12">

                            <?php

            include "reportes/compradores.php";

            ?>

                        </div>




                    </div>








                </div>

            </div>


        </section>

    </div>