<?php
$configuracionRegistro = ControladorConfiguracion::ctrMostrarConfiguracion();
$nombreRegistro = htmlspecialchars($configuracionRegistro["nombre_emprendimiento"] ?? "Crear cuenta", ENT_QUOTES, "UTF-8");
?>
<style>
body:has(.registro-page) { background: #f4f6f9; }
.registro-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; background: var(--bg-body); color: var(--text-primary); }
.registro-panel { width: 100%; max-width: 440px; padding: 34px; border: 1px solid var(--border-color); border-radius: 16px; background: var(--bg-card); box-shadow: 0 20px 50px rgba(15,23,42,.14); }
.registro-panel h1 { margin: 0 0 8px; color: var(--text-primary); font-size: 25px; text-align: center; }.registro-panel p { margin: 0 0 26px; color: var(--text-secondary); text-align: center; }.registro-field { margin-bottom: 16px; }.registro-field label { display:block; margin-bottom:7px; color:var(--text-primary); font-weight:600; }.registro-field input { width:100%; height:48px; padding:0 14px; border:1px solid var(--border-color); border-radius:9px; background:var(--bg-input); color:var(--text-primary); }.registro-submit { width:100%; height:48px; border:0; border-radius:9px; background:var(--button-primary-color); color:var(--button-primary-text); font-weight:700; }.registro-back { display:block; margin-top:18px; color:var(--accent-primary); text-align:center; }.login-alert { margin-top:16px; padding:10px; border-radius:7px; background:#fee2e2; color:#991b1b; font-size:13px; }
</style>
<main class="registro-page" data-theme-current="<?php echo (($configuracionRegistro["tema"] ?? "light") === "dark" ? "dark" : "light"); ?>" data-color-current="<?php echo htmlspecialchars($configuracionRegistro["color_cabecera"] ?? "#dd4b39", ENT_QUOTES, "UTF-8"); ?>">
    <section class="registro-panel">
        <h1>Crear cuenta</h1><p>Configura tu emprendimiento para comenzar.</p>
        <form method="post">
            <div class="registro-field"><label for="nombreEmprendimientoRegistro">Nombre del emprendimiento</label><input id="nombreEmprendimientoRegistro" name="nombreEmprendimiento" required maxlength="150"></div>
            <div class="registro-field"><label for="whatsappRegistro">WhatsApp</label><input id="whatsappRegistro" name="whatsapp" type="tel" pattern="9[0-9]{8}" maxlength="9" placeholder="9XXXXXXXX" required></div>
            <div class="registro-field"><label for="passwordRegistro">Contraseña</label><input id="passwordRegistro" name="passwordRegistro" type="password" minlength="6" required></div>
            <button class="registro-submit" type="submit" name="registrarCuenta" value="1">Crear cuenta</button>
            <?php ControladorUsuarios::ctrRegistrarCuenta(); ?>
        </form>
        <a class="registro-back" href="?ruta=login">Ya tengo una cuenta, ingresar</a>
    </section>
</main>