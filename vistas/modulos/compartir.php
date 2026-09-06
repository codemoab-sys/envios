<?php
$esFormularioPublico = isset($_GET["merchant"]);
$formularioCompartir = $esFormularioPublico
    ? ControladorCompartir::ctrMostrarPorToken(trim($_GET["merchant"]))
    : ControladorCompartir::ctrMostrarActivo();

if($esFormularioPublico):
    $tituloFormulario = htmlspecialchars($formularioCompartir["titulo"] ?? "Papu billas", ENT_QUOTES, "UTF-8");
    $configuracionPublica = ModeloConfiguracion::mdlMostrarConfiguracionPorUsuario((int) ($formularioCompartir["tenant_id"] ?? 0));
    $metodosConfigurados = json_decode($configuracionPublica["metodos_envio"] ?? "[]", true) ?: array();
    $agenciasShalom = array();
    $agenciasOlva = array();
    $agenciasMarvisur = array();
    $agenciasDinsides = array();
    $ubicacionesEncomienda = array();
    if(in_array("shalom", $metodosConfigurados, true)){
        try{
            $conexionAgencias = Conexion::conectar();
            $consultaAgencias = $conexionAgencias->query("SELECT id, nombre, distrito, provincia, departamento, direccion, referencia FROM agencia_shalon ORDER BY nombre ASC");
            $agenciasShalom = $consultaAgencias->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            $agenciasShalom = array();
        }
    }
    if(in_array("olva", $metodosConfigurados, true)){
        try{
            $conexionAgencias = Conexion::conectar();
            $consultaAgencias = $conexionAgencias->query("SELECT id, nombre, distrito, provincia, departamento, direccion FROM agencia_olva ORDER BY nombre ASC");
            $agenciasOlva = $consultaAgencias->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            $agenciasOlva = array();
        }
    }
    if(in_array("marvisur", $metodosConfigurados, true)){
        try{
            $conexionAgencias = Conexion::conectar();
            $consultaAgencias = $conexionAgencias->query("SELECT id, nombre, distrito, provincia, departamento, direccion FROM agencia_marvisur ORDER BY nombre ASC");
            $agenciasMarvisur = $consultaAgencias->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            $agenciasMarvisur = array();
        }
    }
    if(in_array("dinsides", $metodosConfigurados, true)){
        try{
            $conexionAgencias = Conexion::conectar();
            $consultaAgencias = $conexionAgencias->query("SELECT id, nombre, observacion FROM agencia_dinsides ORDER BY nombre ASC");
            $agenciasDinsides = $consultaAgencias->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            $agenciasDinsides = array();
        }
    }
    if(in_array("encomienda", $metodosConfigurados, true)){
        try{
            $conexionUbicaciones = Conexion::conectar();
            $consultaUbicaciones = $conexionUbicaciones->query("SELECT id, departamento, provincia, distrito FROM ubicaciones_encomienda WHERE activo = 1 ORDER BY departamento ASC, provincia ASC, distrito ASC");
            $ubicacionesEncomienda = $consultaUbicaciones->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            $ubicacionesEncomienda = array();
        }
    }
    $diasConfigurados = json_decode($configuracionPublica["dias_despacho"] ?? "[]", true) ?: array();
    $anticipacionPublica = (int) ($configuracionPublica["anticipacion"] ?? 0);
    $whatsappEmprendimiento = preg_replace('/\D/', '', (string) ($configuracionPublica["whatsapp"] ?? ""));
    $horaCortePublica = htmlspecialchars(substr($configuracionPublica["hora_corte"] ?? "18:00", 0, 5), ENT_QUOTES, "UTF-8");
    $nombresMetodos = array(
        "shalom" => "Retiro en agencia Shalom",
        "olva" => "Retiro en agencia Olva Courier",
        "marvisur" => "Retiro en agencia Marvisur",
        "dinsides" => "Retiro en agencia Dinsides",
        "delivery_lima" => "Delivery (Solo Lima)",
        "delivery_trujillo" => "Delivery (Solo Trujillo)",
        "retiro_tienda" => "Retiro en tienda",
        "encomienda" => "Encomienda"
    );
    $distritosLima = array();
    $distritosTrujillo = array();
    try{
        $conexionDistritos = Conexion::conectar();
        $consultaDistritos = $conexionDistritos->query("SELECT zona, distrito FROM distritos_delivery WHERE activo = 1 ORDER BY zona ASC, distrito ASC");
        foreach($consultaDistritos->fetchAll(PDO::FETCH_ASSOC) as $registroDistrito){
            if($registroDistrito["zona"] === "lima") $distritosLima[] = $registroDistrito["distrito"];
            if($registroDistrito["zona"] === "trujillo") $distritosTrujillo[] = $registroDistrito["distrito"];
        }
    }catch(PDOException $e){
        $distritosLima = array();
        $distritosTrujillo = array();
    }
    $diasSemana = array("lun" => 1, "mar" => 2, "mie" => 3, "jue" => 4, "vie" => 5, "sab" => 6, "dom" => 7);
    $nombresDias = array(1 => "Lunes", 2 => "Martes", 3 => "Miércoles", 4 => "Jueves", 5 => "Viernes", 6 => "Sábado", 7 => "Domingo");
    $fechasRecojo = array();
    $fechaBusqueda = new DateTime("today");
    $fechaBusqueda->modify("+" . $anticipacionPublica . " days");
    $diasDespachoNumericos = array_map(function($dia) use ($diasSemana){ return $diasSemana[$dia] ?? 0; }, $diasConfigurados);
    for($i = 0; $i <= 15; $i++){
        if(in_array((int) $fechaBusqueda->format("N"), $diasDespachoNumericos, true)){
            $textoFecha = $nombresDias[(int) $fechaBusqueda->format("N")] . " " . $fechaBusqueda->format("j M");
            if($fechaBusqueda->format("Y-m-d") === (new DateTime("today"))->format("Y-m-d")){
                $textoFecha = "¡HOY! - " . $textoFecha;
            }elseif($fechaBusqueda->format("Y-m-d") === (new DateTime("tomorrow"))->format("Y-m-d")){
                $textoFecha = "Mañana - " . $textoFecha;
            }
            $fechasRecojo[] = array("valor" => $fechaBusqueda->format("Y-m-d"), "texto" => $textoFecha);
        }
        $fechaBusqueda->modify("+1 day");
    }
?>
<style>
    .formulario-publico-page { min-height: 100vh; margin: 0; padding: 0 0 60px; background: #fff; color: #263143; font-family: 'Source Sans Pro', sans-serif; font-size: 16px; }
    .formulario-publico-page, .formulario-publico-page * { box-sizing: border-box; }
    .formulario-publico-header { min-height: 90px; padding: 20px 8%; display: flex; align-items: center; gap: 16px; border-bottom: 1px solid #e9ebee; }
    .formulario-publico-logo { width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 14px; background: #f0f8ff; color: #111923; font-size: 26px; }
    .formulario-publico-header h1 { margin: 0 0 2px; color: #18202d; font-size: 24px; line-height: 1.2; font-weight: 700; }
    .formulario-publico-header p { margin: 0; color: #9da3ad; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; }
    .formulario-publico-content { max-width: 500px; margin: 40px auto 0; padding: 0 20px; }
    .formulario-publico-cutoff { padding: 20px 24px; border: 1px solid #ffebc5; border-radius: 12px; background: #fff8ed; color: #9a4027; }
    .formulario-publico-cutoff h2 { margin: 0 0 8px; font-size: 18px; font-weight: 700; }
    .formulario-publico-cutoff h2 i { margin-right: 10px; color: #f49b3b; }
    .formulario-publico-cutoff p { margin: 0; font-size: 14px; line-height: 1.4; }
    .formulario-publico-field { margin-top: 30px; }
    .formulario-publico-field label { display: block; margin: 0 0 10px; color: #303a4a; font-size: 15px; font-weight: 600; }
    .formulario-publico-input { width: 100%; height: 52px; padding: 0 18px; border: 1px solid #e4e7eb; border-radius: 10px; outline: none; background: #fbfcfe; color: #5c6678; font-size: 16px; box-shadow: 0 1px 3px rgba(24, 32, 45, .05); transition: border-color 0.2s, box-shadow 0.2s; }
    .formulario-publico-input:focus { border-color: #3984ee; box-shadow: 0 0 0 3px rgba(57, 132, 238, .1); }
    .formulario-publico-input::placeholder { color: #9ca5b5; }
    .formulario-publico-phone { display: flex; align-items: center; width: 100%; height: 52px; padding: 0 18px; border: 1px solid #e4e7eb; border-radius: 10px; background: #fbfcfe; color: #263143; box-shadow: 0 1px 3px rgba(24, 32, 45, .05); }
    .formulario-publico-phone-prefix { flex: 0 0 auto; padding-right: 10px; color: #7b8799; font-size: 16px; }
    .formulario-publico-phone .formulario-publico-input { height: 48px; padding: 0; border: 0; background: transparent; box-shadow: none; }
    .formulario-publico-phone:focus-within { border-color: #3984ee; box-shadow: 0 0 0 3px rgba(57, 132, 238, .1); }
    .formulario-publico-agencia-results { display: none; overflow: hidden; margin-top: -1px; border: 1px solid #e4e7eb; border-radius: 0 0 10px 10px; background: #fff; box-shadow: 0 5px 12px rgba(24, 32, 45, .1); }
    .formulario-publico-agencia-results.visible { display: block; }
    .formulario-publico-agencia-option { width: 100%; padding: 10px 14px; border: 0; border-bottom: 1px solid #edf0f3; background: #fff; color: #192437; cursor: pointer; text-align: left; }
    .formulario-publico-agencia-option:last-child { border-bottom: 0; }
    .formulario-publico-agencia-option:hover, .formulario-publico-agencia-option:focus { outline: none; background: #f3f7fd; }
    .formulario-publico-agencia-title { display: block; overflow: hidden; font-size: 15px; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }
    .formulario-publico-agencia-address { display: block; margin-top: 4px; color: #7b8799; font-size: 13px; line-height: 1.25; }
    .formulario-publico-select { width: 100%; height: 52px; padding: 0 40px 0 18px; border: 1px solid #e4e7eb; border-radius: 10px; outline: none; background: #fbfcfe; color: #263143; font-size: 16px; box-shadow: 0 1px 3px rgba(24, 32, 45, .05); transition: border-color 0.2s, box-shadow 0.2s; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca5b5' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; }
    .formulario-publico-select:focus { border-color: #3984ee; box-shadow: 0 0 0 3px rgba(57, 132, 238, .1); }
    .formulario-publico-delivery-fields { display: none; }
    .formulario-publico-delivery-fields.visible { display: block; }
    .formulario-publico-theme-toggle { margin-left: auto; width: 42px; height: 42px; border: 1px solid #dfe4eb; border-radius: 50%; background: #fff; color: #536176; font-size: 17px; cursor: pointer; }
    .formulario-publico-theme-toggle:hover { border-color: #3984ee; color: #3984ee; }
    .formulario-publico-page.modo-oscuro { background: #111827; color: #e5e7eb; }
    .formulario-publico-page.modo-oscuro .formulario-publico-header { border-color: #2b3648; }
    .formulario-publico-page.modo-oscuro .formulario-publico-header h1,
    .formulario-publico-page.modo-oscuro .formulario-publico-field label { color: #f3f4f6; }
    .formulario-publico-page.modo-oscuro .formulario-publico-header p { color: #9ca8ba; }
    .formulario-publico-page.modo-oscuro .formulario-publico-cutoff { border-color: #6b4d2d; background: #30251b; color: #f3b36c; }
    .formulario-publico-page.modo-oscuro .formulario-publico-cutoff h2 { color: #ffc078; }
    .formulario-publico-page.modo-oscuro .formulario-publico-cutoff h2 i { color: #ff9d3d; }
    .formulario-publico-page.modo-oscuro .formulario-publico-cutoff p { color: #e8b98b; }
    .formulario-publico-page.modo-oscuro .formulario-publico-input,
    .formulario-publico-page.modo-oscuro .formulario-publico-select { border-color: #37465d; background-color: #1b2638; color: #f3f4f6; box-shadow: none; }
    .formulario-publico-page.modo-oscuro .formulario-publico-input::placeholder { color: #93a0b5; }
    .formulario-publico-page.modo-oscuro .formulario-publico-phone { border-color: #37465d; background: #1b2638; color: #f3f4f6; box-shadow: none; }
    .formulario-publico-page.modo-oscuro .formulario-publico-phone-prefix { color: #9ca8ba; }
    .formulario-publico-page.modo-oscuro .formulario-publico-agencia-results { border-color: #37465d; background: #1b2638; box-shadow: 0 5px 12px rgba(0, 0, 0, .3); }
    .formulario-publico-page.modo-oscuro .formulario-publico-agencia-option { border-color: #2f3d52; background: #1b2638; color: #f3f4f6; }
    .formulario-publico-page.modo-oscuro .formulario-publico-agencia-option:hover,
    .formulario-publico-page.modo-oscuro .formulario-publico-agencia-option:focus { background: #26364e; }
    .formulario-publico-page.modo-oscuro .formulario-publico-agencia-address { color: #9ca8ba; }
    .formulario-publico-page.modo-oscuro .formulario-publico-theme-toggle { border-color: #475569; background: #1b2638; color: #facc15; }
    .formulario-publico-submit { width: 100%; height: 52px; margin-top: 40px; border: 0; border-radius: 10px; background: #3984ee; color: #fff; font-size: 16px; font-weight: 600; box-shadow: 0 4px 12px rgba(39, 116, 223, .25); cursor: pointer; transition: background 0.2s, transform 0.1s, box-shadow 0.2s; }
    .formulario-publico-submit:hover { background: #2b6fde; box-shadow: 0 6px 16px rgba(39, 116, 223, .35); }
    .formulario-publico-submit:active { transform: scale(0.98); }
    .formulario-publico-submit i { margin-left: 8px; font-size: 16px; }
    @media (max-width: 500px) {
        .formulario-publico-header { padding: 18px 6%; gap: 12px; }
        .formulario-publico-logo { width: 46px; height: 46px; font-size: 22px; border-radius: 12px; }
        .formulario-publico-header h1 { font-size: 20px; }
        .formulario-publico-header p { font-size: 11px; letter-spacing: 1px; }
        .formulario-publico-content { margin-top: 28px; padding: 0 16px; }
        .formulario-publico-cutoff { padding: 16px 18px; }
        .formulario-publico-cutoff h2 { font-size: 16px; }
        .formulario-publico-cutoff p { font-size: 13px; }
        .formulario-publico-field { margin-top: 24px; }
        .formulario-publico-input, .formulario-publico-select { height: 48px; font-size: 15px; }
        .formulario-publico-submit { height: 48px; font-size: 15px; margin-top: 30px; }
    }
</style>
<style>.main-sidebar, .main-header { display: none !important; } .content-wrapper { margin-left: 0 !important; min-height: 100vh !important; }</style>
<main class="formulario-publico-page" id="formularioPublico">
    <header class="formulario-publico-header">
        <div class="formulario-publico-logo"><i class="fa fa-cube"></i></div>
        <div><h1><?php echo $tituloFormulario; ?></h1><p>FORMULARIO DE ENVÍO</p></div>
        <button class="formulario-publico-theme-toggle" type="button" id="cambiarTemaPublico" aria-label="Activar modo oscuro" title="Cambiar tema"><i class="fa fa-moon-o"></i></button>
    </header>
    <section class="formulario-publico-content">
        <div class="formulario-publico-cutoff">
            <h2><i class="fa fa-clock-o"></i>Hora de corte: <?php echo $horaCortePublica; ?></h2>
            <p>Asegura tu envío registrando tus datos antes de la hora de corte.</p>
        </div>
        <div class="formulario-publico-field">
            <label for="whatsappPublico">Tu WhatsApp *</label>
            <div class="formulario-publico-phone">
                <span class="formulario-publico-phone-prefix">+51</span>
                <input class="formulario-publico-input" id="whatsappPublico" type="tel" inputmode="numeric" pattern="9[0-9]{8}" minlength="9" maxlength="9" placeholder="9XXXXXXXX" required>
            </div>
        </div>
        <div class="formulario-publico-field">
            <label for="metodoPublico">¿Cómo quieres recibir tu pedido? *</label>
            <select class="formulario-publico-select" id="metodoPublico" required>
                <option value="">Elige una opción...</option>
                <?php foreach($metodosConfigurados as $metodo): ?>
                    <?php if(isset($nombresMetodos[$metodo])): ?>
                        <option value="<?php echo htmlspecialchars($metodo, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($nombresMetodos[$metodo], ENT_QUOTES, "UTF-8"); ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="camposDelivery" class="formulario-publico-delivery-fields">
            <div class="formulario-publico-field">
                <label for="distritoPublico">Distrito *</label>
                <input class="formulario-publico-input" id="distritoPublico" list="distritosLimaPublicos" type="text" placeholder="Buscar Distrito..." autocomplete="off">
                <datalist id="distritosLimaPublicos">
                    <?php foreach($distritosLima as $distritoLima): ?>
                        <option value="<?php echo htmlspecialchars($distritoLima, ENT_QUOTES, "UTF-8"); ?>"></option>
                    <?php endforeach; ?>
                </datalist>
                <datalist id="distritosTrujilloPublicos">
                    <?php foreach($distritosTrujillo as $distritoTrujillo): ?>
                        <option value="<?php echo htmlspecialchars($distritoTrujillo, ENT_QUOTES, "UTF-8"); ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>
            <div class="formulario-publico-field">
                <label for="direccionPublica">Dirección Exacta *</label>
                <input class="formulario-publico-input" id="direccionPublica" type="text" placeholder="Calle, Av, Número...">
            </div>
            <div class="formulario-publico-field">
                <label for="referenciaPublica">Referencia *</label>
                <input class="formulario-publico-input" id="referenciaPublica" type="text">
            </div>
            <div class="formulario-publico-field">
                <label for="nombrePublico">Nombre y Apellidos *</label>
                <input class="formulario-publico-input" id="nombrePublico" type="text">
            </div>
            <div class="formulario-publico-field">
                <label for="fechaPublica">Fecha de Envío</label>
                <select class="formulario-publico-select" id="fechaPublica">
                    <option value="">Elige una fecha...</option>
                    <?php foreach($fechasRecojo as $fecha): ?>
                        <option value="<?php echo $fecha["valor"]; ?>"><?php echo htmlspecialchars($fecha["texto"], ENT_QUOTES, "UTF-8"); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div id="camposRetiroTienda" class="formulario-publico-delivery-fields">
            <div class="formulario-publico-field">
                <label for="nombreRetiroPublico">Nombre y Apellidos *</label>
                <input class="formulario-publico-input" id="nombreRetiroPublico" type="text">
            </div>
            <div class="formulario-publico-field">
                <label for="fechaRetiroPublica">Fecha de Recojo</label>
                <select class="formulario-publico-select" id="fechaRetiroPublica">
                    <option value="">Elige una fecha...</option>
                    <?php foreach($fechasRecojo as $fecha): ?>
                        <option value="<?php echo $fecha["valor"]; ?>"><?php echo htmlspecialchars($fecha["texto"], ENT_QUOTES, "UTF-8"); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div id="camposShalom" class="formulario-publico-delivery-fields">
            <div class="formulario-publico-field">
                <label for="agenciaShalomPublica">Busca tu Agencia *</label>
                <input class="formulario-publico-input" id="agenciaShalomPublica" type="text" placeholder="Buscar sede Shalom..." autocomplete="off">
                <input id="agenciaShalomId" type="hidden">
                <div class="formulario-publico-agencia-results" id="resultadosAgenciasShalom">
                    <?php foreach($agenciasShalom as $agencia): ?>
                        <?php
                        $ubicacion = implode(" / ", array_filter(array($agencia["departamento"], $agencia["provincia"], $agencia["distrito"], $agencia["nombre"]), function($valor){ return trim((string) $valor) !== ""; }));
                        $direccionAgencia = trim((string) ($agencia["direccion"] ?? ""));
                        $referenciaAgencia = trim((string) ($agencia["referencia"] ?? ""));
                        if($referenciaAgencia !== "") $direccionAgencia .= ($direccionAgencia !== "" ? ", " : "") . "Ref. " . $referenciaAgencia;
                        ?>
                        <button class="formulario-publico-agencia-option" type="button" data-id="<?php echo (int) $agencia["id"]; ?>" data-nombre="<?php echo htmlspecialchars($agencia["nombre"], ENT_QUOTES, "UTF-8"); ?>" data-ubicacion="<?php echo htmlspecialchars($ubicacion, ENT_QUOTES, "UTF-8"); ?>" data-direccion="<?php echo htmlspecialchars($direccionAgencia, ENT_QUOTES, "UTF-8"); ?>">
                            <span class="formulario-publico-agencia-title"><?php echo htmlspecialchars($ubicacion, ENT_QUOTES, "UTF-8"); ?></span>
                            <span class="formulario-publico-agencia-address"><?php echo htmlspecialchars($direccionAgencia, ENT_QUOTES, "UTF-8"); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="formulario-publico-field">
                <label for="dniShalomPublico">DNI/CE para Recoger *</label>
                <input class="formulario-publico-input" id="dniShalomPublico" type="text" placeholder="Número de DNI / CE">
            </div>
            <div class="formulario-publico-field">
                <label for="nombreShalomPublico">Nombre y Apellidos *</label>
                <input class="formulario-publico-input" id="nombreShalomPublico" type="text">
            </div>
            <div class="formulario-publico-field">
                <label for="fechaShalomPublica">Fecha de Envío</label>
                <select class="formulario-publico-select" id="fechaShalomPublica">
                    <option value="">Elige una fecha...</option>
                    <?php foreach($fechasRecojo as $fecha): ?>
                        <option value="<?php echo $fecha["valor"]; ?>"><?php echo htmlspecialchars($fecha["texto"], ENT_QUOTES, "UTF-8"); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div id="camposEncomienda" class="formulario-publico-delivery-fields">
            <div class="formulario-publico-field">
                <label for="ubicacionEncomiendaPublica">Busca tu Ubicación *</label>
                <input class="formulario-publico-input" id="ubicacionEncomiendaPublica" type="text" placeholder="Buscar departamento, provincia o distrito..." autocomplete="off">
                <input id="ubicacionEncomiendaId" type="hidden">
                <div class="formulario-publico-agencia-results" id="resultadosUbicacionesEncomienda">
                    <?php foreach($ubicacionesEncomienda as $ubicacion): ?>
                        <?php $textoUbicacion = implode(" / ", array_filter(array($ubicacion["departamento"], $ubicacion["provincia"], $ubicacion["distrito"]), function($valor){ return trim((string) $valor) !== ""; })); ?>
                        <button class="formulario-publico-agencia-option" type="button" data-id="<?php echo (int) $ubicacion["id"]; ?>" data-ubicacion="<?php echo htmlspecialchars($textoUbicacion, ENT_QUOTES, "UTF-8"); ?>">
                            <span class="formulario-publico-agencia-title"><?php echo htmlspecialchars($textoUbicacion, ENT_QUOTES, "UTF-8"); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="formulario-publico-field">
                <label for="dniPublico">DNI/CE para Recoger *</label>
                <input class="formulario-publico-input" id="dniPublico" type="text" placeholder="Número de DNI / CE">
            </div>
            <div class="formulario-publico-field">
                <label for="nombreEncomiendaPublico">Nombre y Apellidos *</label>
                <input class="formulario-publico-input" id="nombreEncomiendaPublico" type="text">
            </div>
            <div class="formulario-publico-field">
                <label for="fechaEncomiendaPublica">Fecha de Envío</label>
                <select class="formulario-publico-select" id="fechaEncomiendaPublica">
                    <option value="">Elige una fecha...</option>
                    <?php foreach($fechasRecojo as $fecha): ?>
                        <option value="<?php echo $fecha["valor"]; ?>"><?php echo htmlspecialchars($fecha["texto"], ENT_QUOTES, "UTF-8"); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div id="camposOlva" class="formulario-publico-delivery-fields">
            <div class="formulario-publico-field">
                <label for="agenciaOlvaPublica">Busca tu Agencia *</label>
                <input class="formulario-publico-input" id="agenciaOlvaPublica" type="text" placeholder="Buscar sede Olva Courier..." autocomplete="off">
                <input id="agenciaOlvaId" type="hidden">
                <div class="formulario-publico-agencia-results" id="resultadosAgenciasOlva">
                    <?php foreach($agenciasOlva as $agencia): ?>
                        <?php $ubicacionOlva = implode(" / ", array_filter(array($agencia["departamento"], $agencia["provincia"], $agencia["distrito"], $agencia["nombre"]), function($valor){ return trim((string) $valor) !== ""; })); ?>
                        <button class="formulario-publico-agencia-option" type="button" data-id="<?php echo (int) $agencia["id"]; ?>" data-ubicacion="<?php echo htmlspecialchars($ubicacionOlva, ENT_QUOTES, "UTF-8"); ?>" data-direccion="<?php echo htmlspecialchars(trim((string) ($agencia["direccion"] ?? "")), ENT_QUOTES, "UTF-8"); ?>">
                            <span class="formulario-publico-agencia-title"><?php echo htmlspecialchars($ubicacionOlva, ENT_QUOTES, "UTF-8"); ?></span>
                            <span class="formulario-publico-agencia-address"><?php echo htmlspecialchars(trim((string) ($agencia["direccion"] ?? "")), ENT_QUOTES, "UTF-8"); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="formulario-publico-field">
                <label for="dniOlvaPublico">DNI/CE para Recoger *</label>
                <input class="formulario-publico-input" id="dniOlvaPublico" type="text" placeholder="Número de DNI / CE">
            </div>
            <div class="formulario-publico-field">
                <label for="nombreOlvaPublico">Nombre y Apellidos *</label>
                <input class="formulario-publico-input" id="nombreOlvaPublico" type="text">
            </div>
            <div class="formulario-publico-field">
                <label for="fechaOlvaPublica">Fecha de Envío</label>
                <select class="formulario-publico-select" id="fechaOlvaPublica">
                    <option value="">Elige una fecha...</option>
                    <?php foreach($fechasRecojo as $fecha): ?>
                        <option value="<?php echo $fecha["valor"]; ?>"><?php echo htmlspecialchars($fecha["texto"], ENT_QUOTES, "UTF-8"); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div id="camposMarvisur" class="formulario-publico-delivery-fields">
            <div class="formulario-publico-field">
                <label for="agenciaMarvisurPublica">Busca tu Agencia *</label>
                <input class="formulario-publico-input" id="agenciaMarvisurPublica" type="text" placeholder="Buscar sede Marvisur..." autocomplete="off">
                <input id="agenciaMarvisurId" type="hidden">
                <div class="formulario-publico-agencia-results" id="resultadosAgenciasMarvisur">
                    <?php foreach($agenciasMarvisur as $agencia): ?>
                        <?php $ubicacionMarvisur = implode(" / ", array_filter(array($agencia["departamento"], $agencia["provincia"], $agencia["distrito"], $agencia["nombre"]), function($valor){ return trim((string) $valor) !== ""; })); ?>
                        <button class="formulario-publico-agencia-option" type="button" data-id="<?php echo (int) $agencia["id"]; ?>" data-ubicacion="<?php echo htmlspecialchars($ubicacionMarvisur, ENT_QUOTES, "UTF-8"); ?>" data-direccion="<?php echo htmlspecialchars(trim((string) ($agencia["direccion"] ?? "")), ENT_QUOTES, "UTF-8"); ?>">
                            <span class="formulario-publico-agencia-title"><?php echo htmlspecialchars($ubicacionMarvisur, ENT_QUOTES, "UTF-8"); ?></span>
                            <span class="formulario-publico-agencia-address"><?php echo htmlspecialchars(trim((string) ($agencia["direccion"] ?? "")), ENT_QUOTES, "UTF-8"); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="formulario-publico-field">
                <label for="dniMarvisurPublico">DNI/CE para Recoger *</label>
                <input class="formulario-publico-input" id="dniMarvisurPublico" type="text" placeholder="Número de DNI / CE">
            </div>
            <div class="formulario-publico-field">
                <label for="nombreMarvisurPublico">Nombre y Apellidos *</label>
                <input class="formulario-publico-input" id="nombreMarvisurPublico" type="text">
            </div>
            <div class="formulario-publico-field">
                <label for="fechaMarvisurPublica">Fecha de Envío</label>
                <select class="formulario-publico-select" id="fechaMarvisurPublica">
                    <option value="">Elige una fecha...</option>
                    <?php foreach($fechasRecojo as $fecha): ?>
                        <option value="<?php echo $fecha["valor"]; ?>"><?php echo htmlspecialchars($fecha["texto"], ENT_QUOTES, "UTF-8"); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div id="camposDinsides" class="formulario-publico-delivery-fields">
            <div class="formulario-publico-field">
                <label for="agenciaDinsidesPublica">Busca tu Agencia *</label>
                <input class="formulario-publico-input" id="agenciaDinsidesPublica" type="text" placeholder="Buscar sede Dinsides..." autocomplete="off">
                <input id="agenciaDinsidesId" type="hidden">
                <div class="formulario-publico-agencia-results" id="resultadosAgenciasDinsides">
                    <?php foreach($agenciasDinsides as $agencia): ?>
                        <?php $nombreDinsides = trim((string) ($agencia["nombre"] ?? "")); $observacionDinsides = trim((string) ($agencia["observacion"] ?? "")); ?>
                        <button class="formulario-publico-agencia-option" type="button" data-id="<?php echo (int) $agencia["id"]; ?>" data-ubicacion="<?php echo htmlspecialchars($nombreDinsides, ENT_QUOTES, "UTF-8"); ?>" data-direccion="<?php echo htmlspecialchars($observacionDinsides, ENT_QUOTES, "UTF-8"); ?>">
                            <span class="formulario-publico-agencia-title"><?php echo htmlspecialchars($nombreDinsides, ENT_QUOTES, "UTF-8"); ?></span>
                            <span class="formulario-publico-agencia-address"><?php echo htmlspecialchars($observacionDinsides, ENT_QUOTES, "UTF-8"); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="formulario-publico-field">
                <label for="dniDinsidesPublico">DNI/CE para Recoger *</label>
                <input class="formulario-publico-input" id="dniDinsidesPublico" type="text" placeholder="Número de DNI / CE">
            </div>
            <div class="formulario-publico-field">
                <label for="nombreDinsidesPublico">Nombre y Apellidos *</label>
                <input class="formulario-publico-input" id="nombreDinsidesPublico" type="text">
            </div>
            <div class="formulario-publico-field">
                <label for="fechaDinsidesPublica">Fecha de Envío</label>
                <select class="formulario-publico-select" id="fechaDinsidesPublica">
                    <option value="">Elige una fecha...</option>
                    <?php foreach($fechasRecojo as $fecha): ?>
                        <option value="<?php echo $fecha["valor"]; ?>"><?php echo htmlspecialchars($fecha["texto"], ENT_QUOTES, "UTF-8"); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button class="formulario-publico-submit" type="button" id="agendarPublico">Agendar y ver resumen <i class="fa fa-calendar-o"></i></button>
    </section>
</main>
<script>
var resultadosAgenciasShalom = $('#resultadosAgenciasShalom');
var opcionesAgenciasShalom = resultadosAgenciasShalom.find('.formulario-publico-agencia-option');

function normalizarTextoAgencia(texto){
    return (texto || '').toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
}

var distritosLimaPublicos = <?php echo json_encode($distritosLima, JSON_UNESCAPED_UNICODE); ?>;
var distritosTrujilloPublicos = <?php echo json_encode($distritosTrujillo, JSON_UNESCAPED_UNICODE); ?>;
var whatsappEmprendimiento = <?php echo json_encode($whatsappEmprendimiento); ?>;

function presentarTextoAgencia(texto){
    return (texto || '').toString().toLowerCase().replace(/(^|[\s\/|,-])([a-záéíóúñ])/g, function(match, separador, letra){
        return separador + letra.toUpperCase();
    });
}

function filtrarAgenciasShalom(){
    var busqueda = normalizarTextoAgencia($('#agenciaShalomPublica').val());
    var visibles = 0;
    opcionesAgenciasShalom.each(function(){
        var opcion = $(this);
        var coincide = !busqueda || normalizarTextoAgencia(opcion.text()).indexOf(busqueda) !== -1;
        var mostrar = coincide && visibles < 8;
        opcion.toggle(mostrar);
        if(mostrar) visibles++;
    });
    resultadosAgenciasShalom.toggleClass('visible', visibles > 0 && $('#camposShalom').hasClass('visible'));
}

$('#agenciaShalomPublica').on('input focus', function(){
    $('#agenciaShalomId').val('');
    filtrarAgenciasShalom();
});

opcionesAgenciasShalom.on('click', function(){
    var opcion = $(this);
    var ubicacion = opcion.data('ubicacion');
    var direccion = opcion.data('direccion');
    $('#agenciaShalomPublica').val(presentarTextoAgencia(ubicacion) + (direccion ? ' | ' + presentarTextoAgencia(direccion) : ''));
    $('#agenciaShalomId').val(opcion.data('id'));
    resultadosAgenciasShalom.removeClass('visible');
});

$(document).on('click', function(evento){
    if(!$(evento.target).closest('#agenciaShalomPublica, #resultadosAgenciasShalom').length){
        resultadosAgenciasShalom.removeClass('visible');
    }
});

var resultadosAgenciasOlva = $('#resultadosAgenciasOlva');
var opcionesAgenciasOlva = resultadosAgenciasOlva.find('.formulario-publico-agencia-option');

function filtrarAgenciasOlva(){
    var busqueda = normalizarTextoAgencia($('#agenciaOlvaPublica').val());
    var visibles = 0;
    opcionesAgenciasOlva.each(function(){
        var opcion = $(this);
        var coincide = !busqueda || normalizarTextoAgencia(opcion.text()).indexOf(busqueda) !== -1;
        var mostrar = coincide && visibles < 8;
        opcion.toggle(mostrar);
        if(mostrar) visibles++;
    });
    resultadosAgenciasOlva.toggleClass('visible', visibles > 0 && $('#camposOlva').hasClass('visible'));
}

$('#agenciaOlvaPublica').on('input focus', function(){
    $('#agenciaOlvaId').val('');
    filtrarAgenciasOlva();
});

opcionesAgenciasOlva.on('click', function(){
    var opcion = $(this);
    var ubicacion = opcion.data('ubicacion');
    var direccion = opcion.data('direccion');
    $('#agenciaOlvaPublica').val(presentarTextoAgencia(ubicacion) + (direccion ? ' | ' + presentarTextoAgencia(direccion) : ''));
    $('#agenciaOlvaId').val(opcion.data('id'));
    resultadosAgenciasOlva.removeClass('visible');
});

var resultadosAgenciasMarvisur = $('#resultadosAgenciasMarvisur');
var opcionesAgenciasMarvisur = resultadosAgenciasMarvisur.find('.formulario-publico-agencia-option');

function filtrarAgenciasMarvisur(){
    var busqueda = normalizarTextoAgencia($('#agenciaMarvisurPublica').val());
    var visibles = 0;
    opcionesAgenciasMarvisur.each(function(){
        var opcion = $(this);
        var coincide = !busqueda || normalizarTextoAgencia(opcion.text()).indexOf(busqueda) !== -1;
        var mostrar = coincide && visibles < 8;
        opcion.toggle(mostrar);
        if(mostrar) visibles++;
    });
    resultadosAgenciasMarvisur.toggleClass('visible', visibles > 0 && $('#camposMarvisur').hasClass('visible'));
}

$('#agenciaMarvisurPublica').on('input focus', function(){
    $('#agenciaMarvisurId').val('');
    filtrarAgenciasMarvisur();
});

opcionesAgenciasMarvisur.on('click', function(){
    var opcion = $(this);
    var ubicacion = opcion.data('ubicacion');
    var direccion = opcion.data('direccion');
    $('#agenciaMarvisurPublica').val(presentarTextoAgencia(ubicacion) + (direccion ? ' | ' + presentarTextoAgencia(direccion) : ''));
    $('#agenciaMarvisurId').val(opcion.data('id'));
    resultadosAgenciasMarvisur.removeClass('visible');
});

var resultadosAgenciasDinsides = $('#resultadosAgenciasDinsides');
var opcionesAgenciasDinsides = resultadosAgenciasDinsides.find('.formulario-publico-agencia-option');

function filtrarAgenciasDinsides(){
    var busqueda = normalizarTextoAgencia($('#agenciaDinsidesPublica').val());
    var visibles = 0;
    opcionesAgenciasDinsides.each(function(){
        var opcion = $(this);
        var coincide = !busqueda || normalizarTextoAgencia(opcion.text()).indexOf(busqueda) !== -1;
        var mostrar = coincide && visibles < 8;
        opcion.toggle(mostrar);
        if(mostrar) visibles++;
    });
    resultadosAgenciasDinsides.toggleClass('visible', visibles > 0 && $('#camposDinsides').hasClass('visible'));
}

$('#agenciaDinsidesPublica').on('input focus', function(){
    $('#agenciaDinsidesId').val('');
    filtrarAgenciasDinsides();
});

opcionesAgenciasDinsides.on('click', function(){
    var opcion = $(this);
    var ubicacion = opcion.data('ubicacion');
    var direccion = opcion.data('direccion');
    $('#agenciaDinsidesPublica').val(presentarTextoAgencia(ubicacion) + (direccion ? ' | ' + presentarTextoAgencia(direccion) : ''));
    $('#agenciaDinsidesId').val(opcion.data('id'));
    resultadosAgenciasDinsides.removeClass('visible');
});

var resultadosUbicacionesEncomienda = $('#resultadosUbicacionesEncomienda');
var opcionesUbicacionesEncomienda = resultadosUbicacionesEncomienda.find('.formulario-publico-agencia-option');

function filtrarUbicacionesEncomienda(){
    var busqueda = normalizarTextoAgencia($('#ubicacionEncomiendaPublica').val());
    var visibles = 0;
    opcionesUbicacionesEncomienda.each(function(){
        var opcion = $(this);
        var coincide = !busqueda || normalizarTextoAgencia(opcion.text()).indexOf(busqueda) !== -1;
        var mostrar = coincide && visibles < 8;
        opcion.toggle(mostrar);
        if(mostrar) visibles++;
    });
    resultadosUbicacionesEncomienda.toggleClass('visible', visibles > 0 && $('#camposEncomienda').hasClass('visible'));
}

$('#ubicacionEncomiendaPublica').on('input focus', function(){
    $('#ubicacionEncomiendaId').val('');
    filtrarUbicacionesEncomienda();
});

opcionesUbicacionesEncomienda.on('click', function(){
    var opcion = $(this);
    $('#ubicacionEncomiendaPublica').val(presentarTextoAgencia(opcion.data('ubicacion')));
    $('#ubicacionEncomiendaId').val(opcion.data('id'));
    resultadosUbicacionesEncomienda.removeClass('visible');
});

$('#whatsappPublico').on('input', function(){
    this.value = this.value.replace(/\D/g, '').slice(0, 9);
});

$('#agendarPublico').on('click', function(){
    var whatsappPublico = $('#whatsappPublico').val().trim();
    if(!/^9[0-9]{8}$/.test(whatsappPublico)) { $('#whatsappPublico').focus(); return; }
    if(!$('#metodoPublico').val()) { $('#metodoPublico').focus(); return; }
    if(['delivery_lima', 'delivery_trujillo'].indexOf($('#metodoPublico').val()) !== -1) {
        var camposDelivery = ['#distritoPublico', '#direccionPublica', '#referenciaPublica', '#nombrePublico'];
        for(var i = 0; i < camposDelivery.length; i++) {
            if(!$(camposDelivery[i]).val().trim()) { $(camposDelivery[i]).focus(); return; }
        }
        if($('#metodoPublico').val() == 'delivery_lima') {
            var distritoElegido = normalizarTextoAgencia($('#distritoPublico').val());
            var distritoValido = distritosLimaPublicos.some(function(distrito){ return normalizarTextoAgencia(distrito) == distritoElegido; });
            if(!distritoValido) {
                $('#distritoPublico').focus();
                return;
            }
        }
        if($('#metodoPublico').val() == 'delivery_trujillo') {
            var distritoTrujilloElegido = normalizarTextoAgencia($('#distritoPublico').val());
            var distritoTrujilloValido = distritosTrujilloPublicos.some(function(distrito){ return normalizarTextoAgencia(distrito) == distritoTrujilloElegido; });
            if(!distritoTrujilloValido) {
                $('#distritoPublico').focus();
                return;
            }
        }
    }
    if($('#metodoPublico').val() == 'retiro_tienda' && !$('#nombreRetiroPublico').val().trim()) {
        $('#nombreRetiroPublico').focus();
        return;
    }
    if($('#metodoPublico').val() == 'shalom') {
        var camposShalom = ['#agenciaShalomPublica', '#dniShalomPublico', '#nombreShalomPublico'];
        for(var k = 0; k < camposShalom.length; k++) {
            if(!$(camposShalom[k]).val().trim()) { $(camposShalom[k]).focus(); return; }
        }
        if(!$('#agenciaShalomId').val()) {
            $('#agenciaShalomPublica').focus();
            return;
        }
    }
    if($('#metodoPublico').val() == 'olva') {
        var camposOlva = ['#agenciaOlvaPublica', '#dniOlvaPublico', '#nombreOlvaPublico'];
        for(var l = 0; l < camposOlva.length; l++) {
            if(!$(camposOlva[l]).val().trim()) { $(camposOlva[l]).focus(); return; }
        }
        if(!$('#agenciaOlvaId').val()) {
            $('#agenciaOlvaPublica').focus();
            return;
        }
    }
    if($('#metodoPublico').val() == 'marvisur') {
        var camposMarvisur = ['#agenciaMarvisurPublica', '#dniMarvisurPublico', '#nombreMarvisurPublico'];
        for(var m = 0; m < camposMarvisur.length; m++) {
            if(!$(camposMarvisur[m]).val().trim()) { $(camposMarvisur[m]).focus(); return; }
        }
        if(!$('#agenciaMarvisurId').val()) {
            $('#agenciaMarvisurPublica').focus();
            return;
        }
    }
    if($('#metodoPublico').val() == 'dinsides') {
        var camposDinsides = ['#agenciaDinsidesPublica', '#dniDinsidesPublico', '#nombreDinsidesPublico'];
        for(var d = 0; d < camposDinsides.length; d++) {
            if(!$(camposDinsides[d]).val().trim()) { $(camposDinsides[d]).focus(); return; }
        }
        if(!$('#agenciaDinsidesId').val()) {
            $('#agenciaDinsidesPublica').focus();
            return;
        }
    }
    if($('#metodoPublico').val() == 'encomienda') {
        var camposEncomienda = ['#ubicacionEncomiendaPublica', '#dniPublico', '#nombreEncomiendaPublico'];
        for(var j = 0; j < camposEncomienda.length; j++) {
            if(!$(camposEncomienda[j]).val().trim()) { $(camposEncomienda[j]).focus(); return; }
        }
        if(!$('#ubicacionEncomiendaId').val()) {
            $('#ubicacionEncomiendaPublica').focus();
            return;
        }
    }
    function escaparResumen(valor){
        return $('<div>').text(valor || '').html();
    }

    var metodoSeleccionado = $('#metodoPublico').val();
    var metodoTexto = $('#metodoPublico option:selected').text();
    var nombreResumen = '';
    var dniResumen = '';
    var ubicacionResumen = '';
    var direccionResumen = '';
    var fechaResumen = '';
    var fechaValor = '';

    if(['delivery_lima', 'delivery_trujillo'].indexOf(metodoSeleccionado) !== -1){
        nombreResumen = $('#nombrePublico').val().trim();
        ubicacionResumen = $('#distritoPublico').val().trim();
        direccionResumen = $('#direccionPublica').val().trim() + ' - ' + $('#referenciaPublica').val().trim();
        fechaResumen = $('#fechaPublica option:selected').text();
        fechaValor = $('#fechaPublica').val();
    }else if(metodoSeleccionado == 'retiro_tienda'){
        nombreResumen = $('#nombreRetiroPublico').val().trim();
        fechaResumen = $('#fechaRetiroPublica option:selected').text();
        fechaValor = $('#fechaRetiroPublica').val();
    }else if(metodoSeleccionado == 'shalom'){
        nombreResumen = $('#nombreShalomPublico').val().trim();
        dniResumen = $('#dniShalomPublico').val().trim();
        ubicacionResumen = $('#agenciaShalomPublica').val().trim();
        fechaResumen = $('#fechaShalomPublica option:selected').text();
        fechaValor = $('#fechaShalomPublica').val();
    }else if(metodoSeleccionado == 'olva'){
        nombreResumen = $('#nombreOlvaPublico').val().trim();
        dniResumen = $('#dniOlvaPublico').val().trim();
        ubicacionResumen = $('#agenciaOlvaPublica').val().trim();
        fechaResumen = $('#fechaOlvaPublica option:selected').text();
        fechaValor = $('#fechaOlvaPublica').val();
    }else if(metodoSeleccionado == 'marvisur'){
        nombreResumen = $('#nombreMarvisurPublico').val().trim();
        dniResumen = $('#dniMarvisurPublico').val().trim();
        ubicacionResumen = $('#agenciaMarvisurPublica').val().trim();
        fechaResumen = $('#fechaMarvisurPublica option:selected').text();
        fechaValor = $('#fechaMarvisurPublica').val();
    }else if(metodoSeleccionado == 'dinsides'){
        nombreResumen = $('#nombreDinsidesPublico').val().trim();
        dniResumen = $('#dniDinsidesPublico').val().trim();
        ubicacionResumen = $('#agenciaDinsidesPublica').val().trim();
        fechaResumen = $('#fechaDinsidesPublica option:selected').text();
        fechaValor = $('#fechaDinsidesPublica').val();
    }else if(metodoSeleccionado == 'encomienda'){
        nombreResumen = $('#nombreEncomiendaPublico').val().trim();
        dniResumen = $('#dniPublico').val().trim();
        ubicacionResumen = $('#ubicacionEncomiendaPublica').val().trim();
        fechaResumen = $('#fechaEncomiendaPublica option:selected').text();
        fechaValor = $('#fechaEncomiendaPublica').val();
    }

    var resumenWhatsApp = '*NUEVO ENVÍO (' + metodoTexto.toUpperCase() + ')*\n\n' +
        'Nombre: ' + nombreResumen + '\n' +
        'WhatsApp: +51 ' + whatsappPublico + '\n' +
        (dniResumen ? 'DNI/CE: ' + dniResumen + '\n' : '') +
        (ubicacionResumen ? 'Ubicación: ' + ubicacionResumen + '\n' : '') +
        (direccionResumen ? 'Dirección: ' + direccionResumen + '\n' : '') +
        (fechaResumen && fechaResumen != 'Elige una fecha...' ? 'Fecha: ' + fechaResumen : '');

    var resumenHtml = '<div style="text-align:left;padding:4px 8px">' +
        '<div style="padding-bottom:10px;margin-bottom:12px;border-bottom:1px solid #e5e7eb;color:#8b98aa;font-size:13px;font-weight:700;letter-spacing:1px">RESUMEN</div>' +
        '<div style="line-height:1.65;font-size:15px">' +
        '<div>📦 &nbsp;<b>NUEVO ENVÍO (' + escaparResumen(metodoTexto.toUpperCase()) + ')</b></div>' +
        '<div>👤 &nbsp;' + escaparResumen(nombreResumen) + '</div>' +
        '<div>📱 &nbsp;+51 ' + escaparResumen(whatsappPublico) + '</div>' +
        (dniResumen ? '<div>🪪 &nbsp;DNI: ' + escaparResumen(dniResumen) + '</div>' : '') +
        (ubicacionResumen ? '<div>🏢 &nbsp;' + escaparResumen(ubicacionResumen) + '</div>' : '') +
        (direccionResumen ? '<div>📍 &nbsp;' + escaparResumen(direccionResumen) + '</div>' : '') +
        (fechaResumen && fechaResumen != 'Elige una fecha...' ? '<div>🗓️ &nbsp;' + escaparResumen(fechaResumen) + '</div>' : '') +
        '</div></div>';

    Swal.fire({
        title: 'Verifica tus datos',
        html: resumenHtml,
        confirmButtonText: '<i class="fa fa-whatsapp"></i> Enviar por WhatsApp',
        cancelButtonText: 'Editar',
        showDenyButton: true,
        denyButtonText: '<i class="fa fa-check"></i> Terminar',
        showCancelButton: true,
        reverseButtons: true,
        confirmButtonColor: '#20c968',
        width: 520
    }).then(function(resultado){
        if(resultado.isDenied || resultado.isConfirmed){
            if(resultado.isConfirmed){
                var mensajeWhatsApp = window.location.origin + window.location.pathname + '?ruta=compartir&merchant=' + <?php echo json_encode($formularioCompartir["token"] ?? ""); ?> + '\n\nCompleta este formulario';
                window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(mensajeWhatsApp), '_blank');
            }
            Swal.fire({title:'Guardando...',text:'Registrando tu respuesta...',allowOutsideClick:false,onBeforeOpen:function(){Swal.showLoading();}});
            var formData = new FormData();
            formData.append('guardarRespuestaAjax', '1');
            formData.append('merchant', <?php echo json_encode($_GET["merchant"] ?? ""); ?>);
            formData.append('nombre', nombreResumen);
            formData.append('telefono', whatsappPublico);
            formData.append('direccion', ubicacionResumen + (direccionResumen ? ' - ' + direccionResumen : ''));
            formData.append('agencia', (metodoTexto || 'SHALOM').toString().toUpperCase());
            formData.append('fecha_envio', fechaValor && fechaValor !== 'Elige una fecha...' ? fechaValor : '');
            formData.append('mensaje', resumenWhatsApp);
            $.ajax({
                url: 'ajax/envios.ajax.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(respuesta){
                    Swal.close();
                    $('#formularioPublico input').val('');
                    $('#formularioPublico select').prop('selectedIndex', 0);
                    $('.formulario-publico-delivery-fields, .formulario-publico-agencia-results').removeClass('visible');
                    $('#metodoPublico').trigger('change');
                    $('#formularioPublico')[0].scrollIntoView({behavior: 'smooth', block: 'start'});
                },
                error: function(){
                    Swal.close();
                    Swal.fire({icon:'error',title:'No se pudo registrar',text:'Inténtalo nuevamente.',confirmButtonText:'Cerrar'});
                }
            });
        }
    });
});

$('#metodoPublico').on('change', function(){
    var esDelivery = ['delivery_lima', 'delivery_trujillo'].indexOf($(this).val()) !== -1;
    var esRetiroTienda = $(this).val() == 'retiro_tienda';
    var esShalom = $(this).val() == 'shalom';
    var esOlva = $(this).val() == 'olva';
    var esMarvisur = $(this).val() == 'marvisur';
    var esDinsides = $(this).val() == 'dinsides';
    var esEncomienda = $(this).val() == 'encomienda';
    $('#distritoPublico').attr('list', $(this).val() == 'delivery_trujillo' ? 'distritosTrujilloPublicos' : 'distritosLimaPublicos');
    $('#camposDelivery').toggleClass('visible', esDelivery);
    $('#camposDelivery input').prop('required', esDelivery);
    $('#camposRetiroTienda').toggleClass('visible', esRetiroTienda);
    $('#nombreRetiroPublico').prop('required', esRetiroTienda);
    $('#camposShalom').toggleClass('visible', esShalom);
    $('#camposShalom input').prop('required', esShalom);
    if(!esShalom) resultadosAgenciasShalom.removeClass('visible');
    $('#camposOlva').toggleClass('visible', esOlva);
    $('#camposOlva input').prop('required', esOlva);
    if(!esOlva) resultadosAgenciasOlva.removeClass('visible');
    $('#camposMarvisur').toggleClass('visible', esMarvisur);
    $('#camposMarvisur input').prop('required', esMarvisur);
    if(!esMarvisur) resultadosAgenciasMarvisur.removeClass('visible');
    $('#camposDinsides').toggleClass('visible', esDinsides);
    $('#camposDinsides input').prop('required', esDinsides);
    if(!esDinsides) resultadosAgenciasDinsides.removeClass('visible');
    $('#camposEncomienda').toggleClass('visible', esEncomienda);
    $('#camposEncomienda input').prop('required', esEncomienda);
    if(!esEncomienda) resultadosUbicacionesEncomienda.removeClass('visible');
});

(function(){
    var formulario = $('#formularioPublico');
    var botonTema = $('#cambiarTemaPublico');
    var modoOscuro = localStorage.getItem('formularioPublicoTema') == 'oscuro';

    function actualizarTema(){
        formulario.toggleClass('modo-oscuro', modoOscuro);
        botonTema.find('i').toggleClass('fa-moon-o', !modoOscuro).toggleClass('fa-sun-o', modoOscuro);
        botonTema.attr('aria-label', modoOscuro ? 'Activar modo claro' : 'Activar modo oscuro');
    }

    botonTema.on('click', function(){
        modoOscuro = !modoOscuro;
        localStorage.setItem('formularioPublicoTema', modoOscuro ? 'oscuro' : 'claro');
        actualizarTema();
    });

    actualizarTema();
})();
</script>
<?php else:
$enlaceCompartirRaw = trim((string) ($formularioCompartir["enlace"] ?? ""));
$enlaceCompartir = htmlspecialchars($enlaceCompartirRaw, ENT_QUOTES, "UTF-8");
?>
<style>
    .compartir-page { position: relative; left: 0; width: calc(100vw - 230px); min-height: 0 !important; margin-top: 50px; margin-left: 230px; display: flex; align-items: center; justify-content: center; box-sizing: border-box; padding: 24px 20px 32px; background: #030817; color: #f5f7ff; font-family: 'Source Sans Pro', sans-serif; }
    body.sidebar-collapse .compartir-page { width: calc(100vw - 50px); margin-left: 50px; }
    .compartir-shell { width: 100%; max-width: 560px; text-align: center; }
    .compartir-card { padding: 24px 28px 22px; border: 1px solid #344052; border-radius: 22px; background: linear-gradient(145deg, #1e2a3d, #111a2d); box-shadow: 0 24px 50px rgba(0, 0, 0, .35); }
    .compartir-icon { width: 64px; height: 64px; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(0, 190, 151, .25); border-radius: 50%; color: #0fbd8e; font-size: 28px; background: rgba(5, 105, 98, .12); box-shadow: 0 0 27px rgba(0, 190, 151, .13); }
    .compartir-card h1 { margin: 0 0 10px; font-size: 26px; font-weight: 700; }
    .compartir-copy { margin: 0 auto 16px; max-width: 420px; color: #a0aabd; font-size: 15px; line-height: 1.35; }
    .compartir-link { display: block; overflow: hidden; margin-bottom: 16px; padding: 13px 16px; border: 1px solid #2e3a4e; border-radius: 12px; background: #0c1424; color: #4389ff; font-family: Consolas, monospace; font-size: 12px; font-weight: 700; text-overflow: ellipsis; white-space: nowrap; text-align: left; }
    .compartir-action { width: 100%; min-height: 46px; margin-bottom: 8px; border-radius: 11px; font-size: 15px; font-weight: 700; cursor: pointer; transition: filter .2s, transform .2s; }
    .compartir-action:hover { filter: brightness(1.1); transform: translateY(-1px); }
    .compartir-action-primary { border: 0; background: #3d82ef; color: #fff; }
    .compartir-action-whatsapp { border: 1px solid rgba(13, 190, 145, .22); background: #10474a; color: #0fc18f; }
    .compartir-action-open { border: 1px solid #3b4659; background: rgba(45, 56, 76, .46); color: #f5f7ff; }
    .compartir-action i { margin-right: 8px; }
    [data-theme="light"] .compartir-page { background: #f4f6f9; color: #1f2937; }
    [data-theme="light"] .compartir-card { border-color: #dbe3ed; background: linear-gradient(145deg, #fff, #f7faff); box-shadow: 0 18px 40px rgba(31, 41, 55, .12); }
    [data-theme="light"] .compartir-copy { color: #64748b; }
    [data-theme="light"] .compartir-link { border-color: #dbe3ed; background: #f8fafc; color: #2563eb; }
    [data-theme="light"] .compartir-action-primary { background: var(--button-primary-color); color: var(--button-primary-text); }
    [data-theme="light"] .compartir-action-open { border-color: #cbd5e1; background: #fff; color: #334155; }
    [data-theme="dark"] .compartir-page { background: #030817; color: #f5f7ff; }
    [data-theme="dark"] .compartir-card { border-color: #344052; background: linear-gradient(145deg, #1e2a3d, #111a2d); }
    @media (max-width: 767px) { .compartir-page { width: 100%; margin-left: 0; margin-top: 50px; } }
    @media (max-width: 600px) { .compartir-page { padding: 18px 12px 24px; } .compartir-card { padding: 20px 16px 18px; border-radius: 20px; } .compartir-card h1 { font-size: 23px; } .compartir-copy { font-size: 14px; } .compartir-link { padding: 12px 14px; font-size: 11px; } .compartir-action { min-height: 42px; font-size: 14px; } }
    @media (max-height: 620px) { .compartir-page { padding-top: 12px; padding-bottom: 12px; } .compartir-card { padding-top: 14px; padding-bottom: 12px; } .compartir-icon { width: 48px; height: 48px; margin-bottom: 8px; font-size: 22px; } .compartir-card h1 { margin-bottom: 6px; font-size: 21px; } .compartir-copy { margin-bottom: 10px; } .compartir-link { margin-bottom: 10px; padding: 9px 12px; } .compartir-action { min-height: 36px; margin-bottom: 5px; } }
</style>
<main class="compartir-page"><section class="compartir-shell"><div class="compartir-card"><div class="compartir-icon"><i class="fa fa-share-alt"></i></div><h1>¡Listo para compartir!</h1><p class="compartir-copy">Tu formulario personalizado está activo. Comparte el siguiente enlace con tus clientes.</p><div class="compartir-link" id="enlaceCompartir"><?php echo $enlaceCompartir; ?></div><button class="compartir-action compartir-action-primary" type="button" id="copiarEnlace"><i class="fa fa-copy"></i>Copiar Link</button><button class="compartir-action compartir-action-whatsapp" type="button" id="whatsappEnlace"><i class="fa fa-whatsapp"></i>Enviar por WhatsApp</button><button class="compartir-action compartir-action-open" type="button" id="abrirEnlace"><i class="fa fa-external-link"></i>Abrir en nueva pestaña</button></div></section></main>
<script>
(function(){ var enlace = <?php echo json_encode($enlaceCompartirRaw); ?>; $('#copiarEnlace').on('click', function(){ navigator.clipboard.writeText(enlace).then(function(){ Swal.fire({toast:true,position:'top-end',icon:'success',title:'Link copiado',showConfirmButton:false,timer:1800}); }); }); $('#whatsappEnlace').on('click', function(){ if(!enlace){ Swal.fire({icon:'error',title:'No hay enlace para compartir',confirmButtonText:'Cerrar'}); return; } var mensaje = enlace + '\n\nCompleta este formulario'; window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(mensaje), '_blank'); }); $('#abrirEnlace').on('click', function(){ window.open(enlace, '_blank'); }); })();
</script>
<?php endif; ?>
