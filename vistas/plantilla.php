<?php 

session_start();
Conexion::actualizarEstadoSuscripcionSesion();
$esFormularioPublico = isset($_GET["ruta"]) && strtolower((string) $_GET["ruta"]) === "compartir" && isset($_GET["merchant"]);
header("Content-Type: text/html; charset=UTF-8");
if($esFormularioPublico){
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
}
$esRegistro = isset($_GET["ruta"]) && strtolower((string) $_GET["ruta"]) === "registro";
$esWeb = !isset($_GET["ruta"]) || strtolower((string) $_GET["ruta"]) === "web";
$ruta = isset($_GET["ruta"]) ? strtolower((string) $_GET["ruta"]) : "";
$esAdministrador = isset($_SESSION["perfil"]) && strtolower(trim((string) $_SESSION["perfil"])) === "administrador";
$metaFormularioPublico = $esFormularioPublico ? ModeloCompartir::mdlMostrarPorToken(trim($_GET["merchant"])) : array();
$metaConfiguracionPublica = $esFormularioPublico ? ModeloConfiguracion::mdlMostrarConfiguracionPorUsuario((int) ($metaFormularioPublico["tenant_id"] ?? 0)) : array();
$metaNombrePublico = trim((string) ($metaConfiguracionPublica["nombre_emprendimiento"] ?? $metaFormularioPublico["titulo"] ?? ""));
$metaNombrePublico = $metaNombrePublico !== "" ? $metaNombrePublico : "MOABCODE · Gestión de envíos";
$metaDescripcionPublica = trim((string) ($metaFormularioPublico["descripcion"] ?? "Completa tus datos para coordinar tu envío."));
$metaProtocolo = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https" : "http";
$metaBasePublica = $metaProtocolo . "://" . ($_SERVER["HTTP_HOST"] ?? "localhost") . rtrim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"] ?? "")), "/");
$metaLogoRuta = __DIR__ . "/../LOGO.png";
$metaLogoVersion = file_exists($metaLogoRuta) ? (string) filemtime($metaLogoRuta) : "1";
$metaImagenPublica = $metaBasePublica . "/LOGO.png?v=" . rawurlencode($metaLogoVersion);
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
    <title>MOABCODE · Gestión de envíos</title>
    <?php if($esFormularioPublico): ?>
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($metaNombrePublico, ENT_QUOTES, "UTF-8"); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($metaDescripcionPublica, ENT_QUOTES, "UTF-8"); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($metaImagenPublica, ENT_QUOTES, "UTF-8"); ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="2000">
    <meta property="og:image:height" content="418">
    <meta property="og:url" content="<?php echo htmlspecialchars($metaBasePublica . "/compartir?merchant=" . rawurlencode(trim($_GET["merchant"])), ENT_QUOTES, "UTF-8"); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($metaNombrePublico, ENT_QUOTES, "UTF-8"); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($metaDescripcionPublica, ENT_QUOTES, "UTF-8"); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($metaImagenPublica, ENT_QUOTES, "UTF-8"); ?>">
    <?php endif; ?>
    <link rel="icon" type="image/x-icon" href="ISOTIPO.ico">
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
    <link rel="stylesheet" href="vistas/dist/css/dark-mode.css?v=20260906-25">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">
    <style>
        body.solo-lectura #btnMarcarCompletado,
        body.solo-lectura #btnEliminar,
        body.solo-lectura #guardarApariencia,
        body.solo-lectura .config-card-save,
        body.solo-lectura [name="guardarCompartir"] { display: none !important; }
    </style>


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-red sidebar-mini fixed<?php echo isset($_SESSION["solo_lectura"]) && $_SESSION["solo_lectura"] === true ? ' solo-lectura' : ''; ?>">

    <?php
    
if($esWeb){
    include "modulos/web.php";
}elseif($esRegistro){
    include "modulos/registro.php";
}elseif((isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") || $esFormularioPublico){

    echo'<div class="wrapper">';

       
        include "modulos/cabecera.php";

        include "modulos/menu.php";

        if(isset($_GET["ruta"])){
            if($ruta == "usuarios" ||
                $ruta == "configuracion" ||
                $ruta == "inicio" ||
                $ruta == "salir" ||
                $ruta == "login"||
                $ruta == "compartir"||
                $ruta == "envios" ||
                $ruta == "subir-rotulados" ||
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








    <script src="vistas/js/usuarios.js"></script>
    <script src="vistas/js/configuracion.js"></script>
    <script src="vistas/js/dark-mode.js?v=20260906-1"></script>





    <script>
    $(document).ready(function() {
        $('.sidebar-menu').tree()
    })
    </script>
</body>

</html>