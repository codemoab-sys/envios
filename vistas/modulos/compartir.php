<?php
$esFormularioPublico = isset($_GET["merchant"]);
$formularioCompartir = $esFormularioPublico
    ? ControladorCompartir::ctrMostrarPorToken(trim($_GET["merchant"]))
    : ControladorCompartir::ctrMostrarActivo();

if($esFormularioPublico):
    $tituloFormulario = htmlspecialchars($formularioCompartir["titulo"] ?? "Papu billas", ENT_QUOTES, "UTF-8");
?>
<style>
    .formulario-publico-page { min-height: 100vh; margin: -20px -15px; padding: 0 0 110px; background: #fff; color: #263143; font-family: 'Source Sans Pro', sans-serif; }
    .formulario-publico-page ~ * { display: none !important; }
    .formulario-publico-page, .formulario-publico-page * { box-sizing: border-box; }
    .formulario-publico-header { min-height: 152px; padding: 28px 7.5%; display: flex; align-items: center; gap: 28px; border-bottom: 1px solid #e9ebee; }
    .formulario-publico-logo { width: 96px; height: 96px; display: flex; align-items: center; justify-content: center; border-radius: 27px; background: #f0f8ff; color: #111923; font-size: 48px; }
    .formulario-publico-header h1 { margin: 0 0 3px; color: #18202d; font-size: 39px; line-height: 1.1; font-weight: 700; }
    .formulario-publico-header p { margin: 0; color: #9da3ad; font-size: 25px; letter-spacing: 3px; }
    .formulario-publico-content { max-width: 655px; margin: 78px auto 0; padding: 0 25px; }
    .formulario-publico-cutoff { padding: 39px 40px 38px; border: 2px solid #ffebc5; border-radius: 28px; background: #fff8ed; color: #9a4027; }
    .formulario-publico-cutoff h2 { margin: 0 0 12px; font-size: 31px; font-weight: 700; }
    .formulario-publico-cutoff h2 i { margin-right: 25px; color: #f49b3b; }
    .formulario-publico-cutoff p { margin: 0 0 0 76px; font-size: 29px; line-height: 1.38; }
    .formulario-publico-field { margin-top: 81px; }
    .formulario-publico-field label { display: block; margin: 0 0 23px 10px; color: #303a4a; font-size: 29px; font-weight: 700; }
    .formulario-publico-input { width: 100%; height: 148px; padding: 0 40px; border: 2px solid #e4e7eb; border-radius: 27px; outline: none; background: #fbfcfe; color: #5c6678; font-size: 30px; box-shadow: 0 3px 5px rgba(24, 32, 45, .07); }
    .formulario-publico-input::placeholder { color: #9ca5b5; }
    .formulario-publico-submit { width: 100%; height: 144px; margin-top: 78px; border: 0; border-radius: 27px; background: #3984ee; color: #fff; font-size: 36px; font-weight: 600; box-shadow: 0 12px 18px rgba(39, 116, 223, .2); cursor: pointer; }
    .formulario-publico-submit i { margin-left: 18px; font-size: 38px; }
    .formulario-publico-footer { margin-top: 106px; padding-top: 30px; border-top: 1px solid #edf0f3; color: #a0a6af; font-size: 22px; letter-spacing: 6px; text-align: center; }
    @media (max-width: 700px) { .formulario-publico-page { margin: -20px -15px; } .formulario-publico-header { padding: 25px 8%; gap: 18px; } .formulario-publico-logo { width: 70px; height: 70px; font-size: 36px; border-radius: 20px; } .formulario-publico-header h1 { font-size: 28px; } .formulario-publico-header p { font-size: 17px; letter-spacing: 2px; } .formulario-publico-content { margin-top: 48px; padding: 0 25px; } .formulario-publico-cutoff { padding: 28px 20px; } .formulario-publico-cutoff h2 { font-size: 23px; } .formulario-publico-cutoff h2 i { margin-right: 12px; } .formulario-publico-cutoff p { margin-left: 39px; font-size: 23px; } .formulario-publico-field { margin-top: 58px; } .formulario-publico-field label { font-size: 23px; } .formulario-publico-input { height: 110px; padding: 0 24px; font-size: 24px; } .formulario-publico-submit { height: 110px; margin-top: 55px; font-size: 27px; } .formulario-publico-footer { font-size: 14px; letter-spacing: 3px; } }
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
        <button class="formulario-publico-submit" type="button" id="agendarPublico">Agendar y ver resumen <i class="fa fa-calendar-o"></i></button>
        <footer class="formulario-publico-footer">FORMULARIO LOGÍSTICO • CREADO POR LATAM5S</footer>
    </section>
</main>
<script>
$('#agendarPublico').on('click', function(){
    if(!$('#whatsappPublico').val().trim()) { $('#whatsappPublico').focus(); return; }
    Swal.fire({title:'Datos registrados',text:'Tu envío ha sido agendado correctamente.',icon:'success',confirmButtonText:'Continuar'});
});
</script>
<?php else:
$enlaceCompartir = htmlspecialchars($formularioCompartir["enlace"] ?? "", ENT_QUOTES, "UTF-8");
?>
<style>
    .compartir-page { min-height: calc(100vh - 50px); display: flex; align-items: center; justify-content: center; padding: 44px 20px 56px; background: #030817; color: #f5f7ff; font-family: 'Source Sans Pro', sans-serif; }
    .compartir-shell { width: 100%; max-width: 560px; text-align: center; }
    .compartir-card { padding: 40px 40px 38px; border: 1px solid #344052; border-radius: 28px; background: linear-gradient(145deg, #1e2a3d, #111a2d); box-shadow: 0 24px 50px rgba(0, 0, 0, .35); }
    .compartir-icon { width: 100px; height: 100px; margin: 0 auto 30px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(0, 190, 151, .25); border-radius: 50%; color: #0fbd8e; font-size: 43px; background: rgba(5, 105, 98, .12); box-shadow: 0 0 27px rgba(0, 190, 151, .13); }
    .compartir-card h1 { margin: 0 0 20px; font-size: 30px; font-weight: 700; }
    .compartir-copy { margin: 0 auto 41px; max-width: 420px; color: #a0aabd; font-size: 18px; line-height: 1.55; }
    .compartir-link { display: block; overflow: hidden; margin-bottom: 40px; padding: 25px 35px; border: 1px solid #2e3a4e; border-radius: 16px; background: #0c1424; color: #4389ff; font-family: Consolas, monospace; font-size: 14px; font-weight: 700; text-overflow: ellipsis; white-space: nowrap; text-align: left; }
    .compartir-action { width: 100%; min-height: 70px; margin-bottom: 20px; border-radius: 15px; font-size: 20px; font-weight: 700; cursor: pointer; transition: filter .2s, transform .2s; }
    .compartir-action:hover { filter: brightness(1.1); transform: translateY(-1px); }
    .compartir-action-primary { border: 0; background: #3d82ef; color: #fff; }
    .compartir-action-whatsapp { border: 1px solid rgba(13, 190, 145, .22); background: #10474a; color: #0fc18f; }
    .compartir-action-open { border: 1px solid #3b4659; background: rgba(45, 56, 76, .46); color: #f5f7ff; }
    .compartir-action i { margin-right: 12px; }
    .compartir-brand { margin-top: 42px; color: #74809c; font-size: 12px; font-weight: 700; letter-spacing: 2px; }
    @media (max-width: 600px) { .compartir-page { padding: 28px 12px 36px; } .compartir-card { padding: 32px 20px 28px; border-radius: 24px; } .compartir-card h1 { font-size: 27px; } .compartir-copy { font-size: 16px; } .compartir-link { padding: 22px 18px; font-size: 12px; } }
</style>
<main class="compartir-page"><section class="compartir-shell"><div class="compartir-card"><div class="compartir-icon"><i class="fa fa-share-alt"></i></div><h1>¡Listo para compartir!</h1><p class="compartir-copy">Tu formulario personalizado está activo. Comparte el siguiente enlace con tus clientes.</p><div class="compartir-link" id="enlaceCompartir"><?php echo $enlaceCompartir; ?></div><button class="compartir-action compartir-action-primary" type="button" id="copiarEnlace"><i class="fa fa-copy"></i>Copiar Link</button><button class="compartir-action compartir-action-whatsapp" type="button" id="whatsappEnlace"><i class="fa fa-whatsapp"></i>Enviar por WhatsApp</button><button class="compartir-action compartir-action-open" type="button" id="abrirEnlace"><i class="fa fa-external-link"></i>Abrir en nueva pestaña</button></div><div class="compartir-brand">POWERED BY LATAM5S</div></section></main>
<script>
(function(){ var enlace = <?php echo json_encode($enlaceCompartir); ?>; $('#copiarEnlace').on('click', function(){ navigator.clipboard.writeText(enlace).then(function(){ Swal.fire({toast:true,position:'top-end',icon:'success',title:'Link copiado',showConfirmButton:false,timer:1800}); }); }); $('#whatsappEnlace').on('click', function(){ window.open('https://wa.me/?text=' + encodeURIComponent('Completa este formulario: ' + enlace), '_blank'); }); $('#abrirEnlace').on('click', function(){ window.open(enlace, '_blank'); }); })();
</script>
<?php endif; ?>
