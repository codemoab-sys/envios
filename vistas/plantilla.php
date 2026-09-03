<?php 

session_start();


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>sistemas de ventas </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="vistas/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">


    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <!-- ChartJS http://www.chartjs.org/-->
    <script src="vistas/bower_components/Chart.js/Chart.js"></script>

    <!--=====================================
    daterangepicker
    ======================================-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />




    <!--=====================================
    PLUGINS DE JAVASCRIPT
    ======================================-->


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-red sidebar-mini">

    <?php
    
if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"){

    echo'<div class="wrapper">';

       
        include "modulos/cabecera.php";

        include "modulos/menu.php";


        if(isset($_GET["ruta"])){

            $ruta = strtolower($_GET["ruta"]);

            if($ruta == "usuarios" ||
                $ruta == "configuracion" ||
                $ruta == "categorias" ||
                $ruta == "ventas" ||
                $ruta == "inicio" ||
                $ruta == "reportes" ||
                $ruta == "salir" ||
                $ruta == "crear-venta" ||
                $ruta == "productos"||
                $ruta == "login"||
                $ruta == "editar-venta"||
                $ruta == "clientes"||
                $ruta == "compartir"||
                $ruta == "envios"){

                include "modulos/".$ruta.".php";


            }

        }else{

            include "modulos/inicio.php";


        }


        include "modulos/footer.php";

        echo '</div>';


    }else{

        include "modulos/login.php";


    }


?>









    <!-- ./wrapper -->



    <!-- jQuery 3 -->
    <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="vistas/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="vistas/dist/js/adminlte.min.js"></script>








    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>





    <script src="vistas/js/usuarios.js"></script>
    <script src="vistas/js/categorias.js"></script>
    <script src="vistas/js/productos.js"></script>
    <script src="vistas/js/clientes.js"></script>
    <script src="vistas/js/ventas.js"></script>
    <script src="vistas/js/reportes.js"></script>





    <script>
    $(document).ready(function() {
        $('.sidebar-menu').tree()
    })
    </script>
</body>

</html>