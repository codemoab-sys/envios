<?php 

session_start();
Conexion::actualizarEstadoSuscripcionSesion();
$esFormularioPublico = isset($_GET["ruta"]) && strtolower((string) $_GET["ruta"]) === "compartir" && isset($_GET["merchant"]);
$esRegistro = isset($_GET["ruta"]) && strtolower((string) $_GET["ruta"]) === "registro";
$ruta = isset($_GET["ruta"]) ? strtolower((string) $_GET["ruta"]) : "";
$esAdministrador = isset($_SESSION["perfil"]) && strtolower(trim((string) $_SESSION["perfil"])) === "administrador";
if(!$esRegistro && !$esFormularioPublico && $ruta === "usuarios" && !$esAdministrador){
    http_response_code(403);
    $ruta = "inicio";
}


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
    <!-- Dark Mode CSS -->
    <link rel="stylesheet" href="vistas/dist/css/dark-mode.css?v=20260905-4">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">
    <style>
        body.solo-lectura #modalAgregarProducto,
        body.solo-lectura .btnEditarProducto,
        body.solo-lectura .btnEliminarProducto,
        body.solo-lectura #btnMarcarCompletado,
        body.solo-lectura #btnEliminar,
        body.solo-lectura #guardarApariencia,
        body.solo-lectura .config-card-save,
        body.solo-lectura [name="guardarCompartir"] { display: none !important; }
        .subscription-alert { display: flex !important; align-items: center; clear: both; width: calc(100% - 30px); min-height: 48px; margin: 15px !important; padding: 12px 16px !important; border: 1px solid transparent; border-radius: 4px; font-size: 14px; line-height: 1.4; }
        .subscription-alert i { margin-right: 8px; }
    </style>


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

<body class="hold-transition skin-red sidebar-mini fixed<?php echo isset($_SESSION["solo_lectura"]) && $_SESSION["solo_lectura"] === true ? ' solo-lectura' : ''; ?>">

    <?php
    
if($esRegistro){
    include "modulos/registro.php";
}elseif((isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") || $esFormularioPublico){

    echo'<div class="wrapper">';

       
        include "modulos/cabecera.php";

        include "modulos/menu.php";

        if(isset($_SESSION["solo_lectura"]) && $_SESSION["solo_lectura"] === true){
            echo '<div class="alert alert-warning subscription-alert" role="alert"><i class="fa fa-lock"></i><span>Tu período terminó. Estás en modo solo lectura; no puedes crear ni modificar información.</span></div>';
        }elseif(isset($_SESSION["plan"]) && $_SESSION["plan"] !== "general" && isset($_SESSION["dias_restantes"]) && $_SESSION["dias_restantes"] !== null){
            $tipoSuscripcion = $_SESSION["plan"] === "prueba" ? "prueba" : "suscripción mensual";
            $diasRestantes = (int) $_SESSION["dias_restantes"];
            $claseAlerta = $diasRestantes <= 3 ? "alert-warning" : "alert-info";
            $mensajeRenovacion = $diasRestantes <= 3 ? " Renueva pronto para no quedar en modo solo lectura." : "";
            echo '<div class="alert '.$claseAlerta.' subscription-alert" role="alert"><i class="fa fa-clock-o"></i><span>Te quedan '.$diasRestantes.' día(s) de tu '.$tipoSuscripcion.'.'.$mensajeRenovacion.'</span></div>';
        }


        if(isset($_GET["ruta"])){
            if($ruta == "usuarios" ||
                $ruta == "configuracion" ||
                $ruta == "inicio" ||
                $ruta == "salir" ||
                $ruta == "productos"||
                $ruta == "login"||
                $ruta == "compartir"||
                $ruta == "envios" ||
                $ruta == "registro"){

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








    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>





    <script src="vistas/js/usuarios.js"></script>
    <script src="vistas/js/productos.js"></script>
    <script src="vistas/js/configuracion.js"></script>
    <script src="vistas/js/dark-mode.js?v=20260905"></script>





    <script>
    $(document).ready(function() {
        $('.sidebar-menu').tree()
    })
    </script>
</body>

</html>