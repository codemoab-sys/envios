<?php
$esFormularioPublico = isset($_GET["merchant"]);
$formularioCompartir = $esFormularioPublico
    ? ControladorCompartir::ctrMostrarPorToken(trim($_GET["merchant"]))
    : ControladorCompartir::ctrMostrarActivo();

if($esFormularioPublico):
    $tituloFormulario = htmlspecialchars($formularioCompartir["titulo"] ?? "Papu billas", ENT_QUOTES, "UTF-8");
?>
<style>
    .formulario-publico-page { min-height: 100vh; margin: 0; padding: 0 0 60px; background: #fff; color: #263143; font-family: 'Source Sans Pro', sans-serif; font-size: 16px; }
    .formulario-publico-page ~ * { display: none !important; }
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
    .formulario-publico-select { width: 100%; height: 52px; padding: 0 40px 0 18px; border: 1px solid #e4e7eb; border-radius: 10px; outline: none; background: #fbfcfe; color: #263143; font-size: 16px; box-shadow: 0 1px 3px rgba(24, 32, 45, .05); transition: border-color 0.2s, box-shadow 0.2s; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca5b5' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; }
    .formulario-publico-select:focus { border-color: #3984ee; box-shadow: 0 0 0 3px rgba(57, 132, 238, .1); }
    .formulario-publico-submit { width: 100%; height: 52px; margin-top: 40px; border: 0; border-radius: 10px; background: #3984ee; color: #fff; font-size: 16px; font-weight: 600; box-shadow: 0 4px 12px rgba(39, 116, 223, .25); cursor: pointer; transition: background 0.2s, transform 0.1s, box-shadow 0.2s; }
    .formulario-publico-submit:hover { background: #2b6fde; box-shadow: 0 6px 16px rgba(39, 116, 223, .35); }
    .formulario-publico-submit:active { transform: scale(0.98); }
    .formulario-publico-submit i { margin-left: 8px; font-size: 16px; }
    .formulario-publico-footer { margin-top: 60px; padding-top: 20px; border-top: 1px solid #edf0f3; color: #a0a6af; font-size: 11px; letter-spacing: 3px; text-align: center; }
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
<style>.main-sidebar, .main-header, .main-footer { display: none !important; } .content-wrapper { margin-left: 0 !important; min-height: 100vh !important; }</style>
<main class="formulario-publico-page">
    <header class="formulario-publico-header">
        <div class="formulario-publico-logo"><i class="fa fa-cube"></i></div>
        <div><h1><?php echo $tituloFormulario; ?></h1><p>FORMULARIO DE ENVÍO</p></div>
    </header>
    <section class="formulario-publico-content">
        <div class="formulario-publico-cutoff">
            <h2><i class="fa fa-clock-o"></i>Hora de corte: 18:00</h2>
            <p>Asegura tu envío registrando tus datos antes de la hora de corte.</p>
        </div>
        <div class="formulario-publico-field">
            <label for="whatsappPublico">Tu WhatsApp *</label>
            <input class="formulario-publico-input" id="whatsappPublico" type="tel" placeholder="+51  9XXXXXXXX" required>
        </div>
        <div class="formulario-publico-field">
            <label for="metodoPublico">¿Cómo quieres recibir tu pedido? *</label>
            <select class="formulario-publico-select" id="metodoPublico" required>
                <option value="">Elige una opción...</option>
                <option value="shalom">Retiro en agencia Shalom</option>
                <option value="delivery">Delivery (Solo Lima)</option>
                <option value="marvisur">Retiro en agencia Marvisur</option>
            </select>
        </div>
        <button class="formulario-publico-submit" type="button" id="agendarPublico">Agendar y ver resumen <i class="fa fa-calendar-o"></i></button>
        <footer class="formulario-publico-footer">FORMULARIO LOGÍSTICO • CREADO POR LATAM5S</footer>
    </section>
</main>
<script>
$('#agendarPublico').on('click', function(){
    if(!$('#whatsappPublico').val().trim()) { $('#whatsappPublico').focus(); return; }
    if(!$('#metodoPublico').val()) { $('#metodoPublico').focus(); return; }
    Swal.fire({title:'Datos registrados',text:'Tu envío ha sido agendado correctamente.',icon:'success',confirmButtonText:'Continuar'});
});
</script>
<?php else:
$enlaceCompartir = htmlspecialchars($formularioCompartir["enlace"] ?? "", ENT_QUOTES, "UTF-8");
?>
<style>
    body:has(.compartir-page) { overflow: hidden; }
    body:has(.compartir-page) .main-footer { display: none !important; }
    .compartir-page { height: calc(100vh - 50px); min-height: 0; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 16px 20px; background: #030817; color: #f5f7ff; font-family: 'Source Sans Pro', sans-serif; }
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
    .compartir-brand { margin-top: 18px; color: #74809c; font-size: 10px; font-weight: 700; letter-spacing: 2px; }
    @media (max-width: 600px) { .compartir-page { height: calc(100vh - 50px); padding: 10px 12px; } .compartir-card { padding: 20px 16px 18px; border-radius: 20px; } .compartir-card h1 { font-size: 23px; } .compartir-copy { font-size: 14px; } .compartir-link { padding: 12px 14px; font-size: 11px; } .compartir-action { min-height: 42px; font-size: 14px; } .compartir-brand { margin-top: 12px; } }
    @media (max-height: 620px) { .compartir-page { padding-top: 6px; padding-bottom: 6px; } .compartir-card { padding-top: 14px; padding-bottom: 12px; } .compartir-icon { width: 48px; height: 48px; margin-bottom: 8px; font-size: 22px; } .compartir-card h1 { margin-bottom: 6px; font-size: 21px; } .compartir-copy { margin-bottom: 10px; } .compartir-link { margin-bottom: 10px; padding: 9px 12px; } .compartir-action { min-height: 36px; margin-bottom: 5px; } .compartir-brand { margin-top: 8px; } }
</style>
<main class="compartir-page"><section class="compartir-shell"><div class="compartir-card"><div class="compartir-icon"><i class="fa fa-share-alt"></i></div><h1>¡Listo para compartir!</h1><p class="compartir-copy">Tu formulario personalizado está activo. Comparte el siguiente enlace con tus clientes.</p><div class="compartir-link" id="enlaceCompartir"><?php echo $enlaceCompartir; ?></div><button class="compartir-action compartir-action-primary" type="button" id="copiarEnlace"><i class="fa fa-copy"></i>Copiar Link</button><button class="compartir-action compartir-action-whatsapp" type="button" id="whatsappEnlace"><i class="fa fa-whatsapp"></i>Enviar por WhatsApp</button><button class="compartir-action compartir-action-open" type="button" id="abrirEnlace"><i class="fa fa-external-link"></i>Abrir en nueva pestaña</button></div><div class="compartir-brand">POWERED BY LATAM5S</div></section></main>
<script>
(function(){ var enlace = <?php echo json_encode($enlaceCompartir); ?>; $('#copiarEnlace').on('click', function(){ navigator.clipboard.writeText(enlace).then(function(){ Swal.fire({toast:true,position:'top-end',icon:'success',title:'Link copiado',showConfirmButton:false,timer:1800}); }); }); $('#whatsappEnlace').on('click', function(){ window.open('https://wa.me/?text=' + encodeURIComponent('Completa este formulario: ' + enlace), '_blank'); }); $('#abrirEnlace').on('click', function(){ window.open(enlace, '_blank'); }); })();
</script>
<?php endif; ?>
