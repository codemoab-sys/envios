<?php
$configuracionLogin = ControladorConfiguracion::ctrMostrarConfiguracion();
$nombreLogin = trim((string)($configuracionLogin["nombre_emprendimiento"] ?? ""));
if($nombreLogin === "") $nombreLogin = "Mi emprendimiento";
$nombreLogin = htmlspecialchars($nombreLogin, ENT_QUOTES, "UTF-8");
$temaLogin = ($configuracionLogin["tema"] ?? "light") === "dark" ? "dark" : "light";
$colorLogin = preg_match('/^#[0-9a-f]{6}$/i', $configuracionLogin["color_cabecera"] ?? "") ? $configuracionLogin["color_cabecera"] : "#dd4b39";
?>
<style>
    body:has(.login-page-custom) { background: #f4f6f9; }
    .login-page-custom { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; background: radial-gradient(circle at top right, rgba(59,130,246,.12), transparent 38%), var(--bg-body); color: var(--text-primary); }
    .login-panel-custom { width: 100%; max-width: 420px; padding: 34px; border: 1px solid var(--border-color); border-radius: 16px; background: var(--bg-card); box-shadow: 0 20px 50px rgba(15,23,42,.14); }
    .login-brand-custom { margin-bottom: 28px; text-align: center; }
    .login-brand-custom .login-mark { width: 58px; height: 58px; margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; border-radius: 16px; background: var(--header-color); color: #fff; font-size: 25px; font-weight: 700; }
    .login-brand-custom h1 { margin: 0 0 7px; color: var(--text-primary); font-size: 25px; font-weight: 700; }
    .login-brand-custom p { margin: 0; color: var(--text-secondary); font-size: 14px; }
    .login-theme-custom { position: fixed; top: 18px; right: 18px; width: 42px; height: 42px; border: 1px solid var(--border-color); border-radius: 50%; background: var(--bg-card); color: var(--accent-warning); cursor: pointer; }
    .login-theme-custom:hover { border-color: var(--accent-primary); }
    .login-field-custom { position: relative; margin-bottom: 16px; }
    .login-field-custom i { position: absolute; top: 15px; left: 15px; z-index: 2; color: var(--text-muted); }
    .login-field-custom .form-control { height: 48px; padding-left: 42px; border-color: var(--border-color); border-radius: 9px; background: var(--bg-input); color: var(--text-primary); }
    .login-field-custom .form-control:focus { border-color: var(--accent-primary); box-shadow: 0 0 0 3px rgba(59,130,246,.14); }
    .login-submit-custom { width: 100%; height: 48px; margin-top: 6px; border: 0; border-radius: 9px; background: var(--button-primary-color); color: var(--button-primary-text); font-size: 15px; font-weight: 700; cursor: pointer; }
    .login-submit-custom:hover { filter: brightness(1.08); }
    .login-register-custom { display:block; margin-top:18px; color:var(--accent-primary); text-align:center; }
    [data-theme="dark"] body:has(.login-page-custom) { background: #0f172a; }
    @media (max-width: 480px) { .login-page-custom { padding: 16px; } .login-panel-custom { padding: 26px 20px; } }
</style>
<main class="login-page-custom" data-theme-current="<?php echo $temaLogin; ?>" data-color-current="<?php echo htmlspecialchars($colorLogin, ENT_QUOTES, "UTF-8"); ?>">
    <button type="button" id="themeToggle" class="login-theme-custom" title="Cambiar tema" aria-label="Cambiar tema"><i class="fa fa-moon-o"></i></button>
    <section class="login-panel-custom" aria-labelledby="tituloLogin">
        <div class="login-brand-custom">
            <div class="login-mark"><?php echo strtoupper(substr(strip_tags($nombreLogin), 0, 1)); ?></div>
            <h1 id="tituloLogin"><?php echo $nombreLogin; ?></h1>
            <p>Ingresa para administrar tus envíos</p>
        </div>
        <form method="post" autocomplete="on">
            <div class="login-field-custom">
                <i class="fa fa-user" aria-hidden="true"></i>
                <input type="text" class="form-control" name="usuario" placeholder="Usuario" autocomplete="username" required autofocus>
            </div>
            <div class="login-field-custom">
                <i class="fa fa-lock" aria-hidden="true"></i>
                <input type="password" name="password" class="form-control" placeholder="Contraseña" autocomplete="current-password" required>
            </div>
            <button type="submit" class="login-submit-custom">Ingresar <i class="fa fa-arrow-right"></i></button>
            <?php ControladorUsuarios::ctrIngresoUsuario(); ?>
        </form>
        <a class="login-register-custom" href="?ruta=registro">Crear una cuenta</a>
    </section>
</main>