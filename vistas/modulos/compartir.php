<?php
$formularioCompartir = ControladorCompartir::ctrMostrarActivo();
ControladorCompartir::ctrGuardar();
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

<main class="compartir-page">
    <section class="compartir-shell" aria-label="Compartir formulario">
        <div class="compartir-card">
            <div class="compartir-icon"><i class="fa fa-share-alt" aria-hidden="true"></i></div>
            <h1>¡Listo para compartir!</h1>
            <p class="compartir-copy">Tu formulario personalizado está activo. Comparte el siguiente enlace con tus clientes.</p>
            <div class="compartir-link" id="enlaceCompartir"><?php echo $enlaceCompartir; ?></div>
            <button class="compartir-action compartir-action-primary" type="button" id="copiarEnlace"><i class="fa fa-copy"></i>Copiar Link</button>
            <button class="compartir-action compartir-action-whatsapp" type="button" id="whatsappEnlace"><i class="fa fa-whatsapp"></i>Enviar por WhatsApp</button>
            <button class="compartir-action compartir-action-open" type="button" id="abrirEnlace"><i class="fa fa-external-link"></i>Abrir en nueva pestaña</button>
        </div>
        <div class="compartir-brand">POWERED BY LATAM5S</div>
    </section>
</main>

<script>
(function(){
    var enlace = <?php echo json_encode($enlaceCompartir); ?>;
    $('#copiarEnlace').on('click', function(){
        navigator.clipboard.writeText(enlace).then(function(){ Swal.fire({toast:true,position:'top-end',icon:'success',title:'Link copiado',showConfirmButton:false,timer:1800}); });
    });
    $('#whatsappEnlace').on('click', function(){ window.open('https://wa.me/?text=' + encodeURIComponent('Completa este formulario: ' + enlace), '_blank'); });
    $('#abrirEnlace').on('click', function(){ window.open(enlace, '_blank'); });
})();
</script>
