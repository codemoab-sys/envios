<?php

$configuracion = ControladorConfiguracion::ctrMostrarConfiguracion();

$razonSocial = htmlspecialchars($configuracion["razon_social"] ?? "", ENT_QUOTES, "UTF-8");
$ruc = htmlspecialchars($configuracion["ruc"] ?? "", ENT_QUOTES, "UTF-8");
$direccion = htmlspecialchars($configuracion["direccion"] ?? "", ENT_QUOTES, "UTF-8");
$telefono = htmlspecialchars($configuracion["telefono"] ?? "", ENT_QUOTES, "UTF-8");
$correo = htmlspecialchars($configuracion["correo"] ?? "", ENT_QUOTES, "UTF-8");

ControladorConfiguracion::ctrGuardarConfiguracion();

$metodosSeleccionados = json_decode($configuracion["metodos_envio"] ?? "[]", true) ?: array();
$diasSeleccionados = json_decode($configuracion["dias_despacho"] ?? "[]", true) ?: array();

$nombreEmprendimiento = htmlspecialchars($configuracion["nombre_emprendimiento"] ?? "", ENT_QUOTES, "UTF-8");
$whatsapp = htmlspecialchars($configuracion["whatsapp"] ?? "", ENT_QUOTES, "UTF-8");
$horaCorte = htmlspecialchars(substr($configuracion["hora_corte"] ?? "18:00", 0, 5), ENT_QUOTES, "UTF-8");
$anticipacion = (int) ($configuracion["anticipacion"] ?? 0);

$metodos = array(
    "shalom" => "Shalom",
    "olva" => "Olva Courier",
    "marvisur" => "Marvisur",
    "dinsides" => "Dinsides",
    "delivery" => "Delivery",
    "retiro_tienda" => "Retiro en tienda",
    "encomienda" => "Encomienda"
);

$dias = array(
    "lun" => "Lun",
    "mar" => "Mar",
    "mie" => "Mié",
    "jue" => "Jue",
    "vie" => "Vie",
    "sab" => "Sáb",
    "dom" => "Dom"
);

?>

<style>
    .configuracion-page { background: #060b1e; min-height: calc(100vh - 50px); padding: 28px 35px 12px; color: #98a7bf; }
    .configuracion-page .configuracion-title { color: #f4f7fb; font-size: 30px; font-weight: 700; margin: 0 0 36px; }
    .configuracion-page .configuracion-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; max-width: 1480px; margin: 0 auto; }
    .configuracion-page .config-card { background: #182337; border: 1px solid #2b3a52; border-radius: 28px; padding: 30px; box-shadow: 0 12px 30px rgba(0,0,0,.12); }
    .configuracion-page .config-card h2 { color: #4089ff; font-size: 16px; letter-spacing: .4px; font-weight: 700; margin: 0 0 28px; padding-bottom: 14px; border-bottom: 1px solid #29374e; }
    .configuracion-page .config-card h2 i { margin-right: 8px; }
    .configuracion-page .form-label { display: block; color: #9ba9be; font-size: 14px; font-weight: 700; margin: 0 0 8px; }
    .configuracion-page .form-control { background: #0d1627; border: 1px solid #25344b; border-radius: 15px; color: #f4f7fb; height: 54px; padding: 14px 18px; box-shadow: none; }
    .configuracion-page .form-control:focus { border-color: #3786ff; }
    .configuracion-page .form-group { margin-bottom: 25px; }
    .configuracion-page .help-text { color: #61728d; font-size: 12px; margin: 7px 5px 0; }
    .configuracion-page .config-topbar { display: flex; justify-content: space-between; align-items: center; }
    .configuracion-page .btn-save, .configuracion-page .btn-update { border: 0; border-radius: 15px; color: #fff; font-size: 16px; font-weight: 700; padding: 14px 28px; }
    .configuracion-page .btn-save { background: #3987fa; padding-top: 5px; padding-bottom: 5px; }
    .configuracion-page .btn-update { background: #5547e6; height: 54px; white-space: nowrap; }
    .configuracion-page .password-row { display: flex; gap: 15px; align-items: end; }
    .configuracion-page .password-row .form-group { flex: 1; margin: 0; }
    .configuracion-page .option-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .configuracion-page .option { display: flex; align-items: center; min-height: 42px; padding: 8px 10px; background: #0d1627; border: 1px solid #25344b; border-radius: 5px; color: #96a5bb; font-weight: 600; }
    .configuracion-page .option.selected { background: #203556; color: #4089ff; }
    .configuracion-page .option input { appearance: none; width: 15px; height: 15px; border: 1px solid #6a7e9d; border-radius: 5px; margin: 0 10px 0 0; }
    .configuracion-page .option input:checked { background: #3987fa; border-color: #3987fa; box-shadow: inset 0 0 0 3px #3987fa; }
    .configuracion-page .option input:checked:after { content: '\2713'; display: block; color: #fff; font-size: 11px; line-height: 13px; text-align: center; }
    .configuracion-page .days { display: flex; gap: 10px; flex-wrap: wrap; }
    .configuracion-page .day { background: #0d1627; border: 1px solid #25344b; border-radius: 5px; color: #96a5bb; cursor: pointer; font-weight: 700; padding: 8px 15px; }
    .configuracion-page .day input { display: none; }
    .configuracion-page .day:has(input:checked) { background: #3987fa; border-color: #3987fa; color: #fff; }
    .configuracion-page .fields-inline { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .configuracion-page .input-icon { position: relative; }
    .configuracion-page .input-icon i { position: absolute; left: 17px; top: 19px; color: #3987fa; z-index: 2; }
    .configuracion-page .input-icon .form-control { padding-left: 43px; }
    .configuracion-page .input-icon.anticipacion i { color: #11c99a; }
    @media (max-width: 900px) { .configuracion-page { padding: 20px 15px; } .configuracion-page .configuracion-grid { grid-template-columns: 1fr; } }
    @media (max-width: 520px) { .configuracion-page .config-topbar { align-items: flex-start; gap: 15px; } .configuracion-page .configuracion-title { font-size: 25px; } .configuracion-page .config-card { padding: 20px; border-radius: 20px; } .configuracion-page .password-row, .configuracion-page .fields-inline { display: block; } .configuracion-page .btn-update { margin-top: 15px; width: 100%; } }
</style>

<div class="content-wrapper configuracion-page">
    <div class="config-topbar">
        <h1 class="configuracion-title">Configuración</h1>
        <button type="submit" form="formConfiguracion" class="btn-save"><i class="fa fa-save"></i> Guardar</button>
    </div>

    <div class="configuracion-grid">
        <div>
            <div class="config-card">
                <h2>DATOS PÚBLICOS</h2>
                <form id="formConfiguracion" method="post">
                    <div class="form-group">
                        <label class="form-label" for="nombreEmprendimiento">NOMBRE EMPRENDIMIENTO</label>
                        <input class="form-control" id="nombreEmprendimiento" name="nombreEmprendimiento" value="<?php echo $nombreEmprendimiento; ?>" required maxlength="150">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" for="whatsapp">WHATSAPP EMPRENDIMIENTO</label>
                        <div class="input-icon"><i>+51</i><input class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $whatsapp; ?>" pattern="9[0-9]{8}" maxlength="9" placeholder="9 . . ." required></div>
                        <p class="help-text">Solo números, debe empezar con 9.</p>
                    </div>

                    <input type="hidden" name="guardarConfiguracion" value="1">
                </form>
            </div>

            <div class="config-card" style="margin-top: 30px;">
                <h2><i class="fa fa-lock"></i> SEGURIDAD</h2>
                <form method="post">
                    <div class="password-row">
                        <div class="form-group">
                            <label class="form-label" for="nuevaPassword">NUEVA CONTRASEÑA</label>
                            <input class="form-control" type="password" id="nuevaPassword" name="nuevaPassword" minlength="6">
                        </div>
                        <button type="submit" name="actualizarPasswordConfiguracion" value="1" class="btn-update">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="config-card">
            <h2>LOGÍSTICA <span style="color:#ef5350;">*</span></h2>
            <div class="form-group">
                <label class="form-label">MÉTODOS DE ENVÍO/RETIRO <span style="color:#ef5350;">*</span></label>
                <div class="option-grid">
                    <?php foreach($metodos as $valor => $texto): ?>
                        <label class="option <?php echo in_array($valor, $metodosSeleccionados) ? "selected" : ""; ?>"><input type="checkbox" form="formConfiguracion" name="metodosEnvio[]" value="<?php echo $valor; ?>" <?php echo in_array($valor, $metodosSeleccionados) ? "checked" : ""; ?>><?php echo $texto; ?></label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">DÍAS DE DESPACHO <span style="color:#ef5350;">*</span></label>
                <div class="days">
                    <?php foreach($dias as $valor => $texto): ?>
                        <label class="day"><input type="checkbox" form="formConfiguracion" name="diasDespacho[]" value="<?php echo $valor; ?>" <?php echo in_array($valor, $diasSeleccionados) ? "checked" : ""; ?>><?php echo $texto; ?></label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="fields-inline">
                <div class="form-group">
                    <label class="form-label" for="horaCorte">HORA CORTE <span style="color:#ef5350;">*</span></label>
                    <div class="input-icon"><i class="fa fa-clock-o"></i><input class="form-control" type="time" id="horaCorte" name="horaCorte" form="formConfiguracion" value="<?php echo $horaCorte; ?>" required></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="anticipacion">ANTICIPACIÓN (DÍAS) <span style="color:#ef5350;">*</span></label>
                    <div class="input-icon anticipacion"><i class="fa fa-clock-o"></i><input class="form-control" type="number" id="anticipacion" name="anticipacion" form="formConfiguracion" value="<?php echo $anticipacion; ?>" min="0" max="365" required></div>
                </div>
            </div>
            <p class="help-text">* La “Anticipación” define cuántos días mínimos de margen necesitas para preparar el pedido antes del día de envío.</p>
        </div>
    </div>
</div>

?>