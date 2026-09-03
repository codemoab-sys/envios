    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                vista inicio
                <small>it all starts here</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">Blank page</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">

                <?php 

        include "inicio/cajar-superiores.php";
        
        
        ?>




            </div>

            <div class="row">

                <div class="col-lg-12">

                    <?php 

        include "reportes/grafico-ventas.php";
        
        
        ?>

                </div>

                <div class="col-lg-6">

                    <?php 

        include "reportes/productos-mas-vendidos.php";
        
        
        ?>

                </div>

                <div class="col-lg-6">

                    <?php 

        include "inicio/productos-recientes.php";
        
        
        ?>

                </div>



            </div>




    </div>



    </section>
    <!-- /.content -->
    </div>