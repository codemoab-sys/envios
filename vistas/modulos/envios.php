<?php
$totalRespuestas = ControladorEnvios::ctrContarRespuestas();
?>

<style>
    .envios-page {
        min-height: calc(100vh - 50px);
        padding: 16px 3.1% 28px;
        background: #030817;
        color: #eaf0ff;
        font-family: 'Source Sans Pro', sans-serif;
    }
    .envios-toolbar {
        padding: 17px 18px 20px;
        border: 1px solid #26344b;
        border-radius: 25px;
        background: linear-gradient(145deg, #182237, #101a2d);
        box-shadow: 0 12px 25px rgba(0, 0, 0, .18);
    }
    .envios-toolbar-row { display: flex; gap: 10px; align-items: center; }
    .envios-toolbar-row + .envios-toolbar-row { margin-top: 18px; }
    .envios-control, .envios-search {
        height: 36px;
        border: 1px solid #33415a;
        border-radius: 9px;
        background: #202c42;
        color: #dfe7fa;
        font-size: 14px;
        font-weight: 600;
    }
    .envios-control { padding: 0 13px; }
    .envios-date { width: 138px; color: #dde5f5; }
    .envios-search { flex: 1; min-width: 100px; padding: 0 14px 0 35px; color: #a7b1c8; font-weight: 400; background: #10192b url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%237b88a2' stroke-width='2'%3E%3Ccircle cx='7' cy='7' r='5'/%3E%3Cpath d='m11 11 4 4'/%3E%3C/svg%3E") 12px center no-repeat; }
    .envios-button { height: 36px; padding: 0 14px; border: 1px solid #33415a; border-radius: 9px; background: #202c42; color: #dce5f8; font-size: 14px; font-weight: 600; cursor: pointer; }
    .envios-button i { margin-right: 8px; color: #bec9dc; }
    .envios-button-primary { border-color: #397be4; background: #387ee8; color: #fff; }
    .envios-button-primary i { color: #fff; }
    .envios-button-green { border-color: #087d71; background: rgba(0, 148, 132, .16); color: #12bea6; }
    .envios-button-green i { color: #12bea6; }
    .envios-button-danger { border-color: #6c3c4c; background: rgba(154, 52, 66, .2); color: #e36b77; }
    .envios-button-danger i { color: #e36b77; }
    .envios-button-icon { width: 46px; padding: 0; }
    .envios-button-icon i { margin: 0; }
    .envios-spacer { width: 1px; height: 25px; margin: 0 2px; background: #344057; }
    .envios-board { min-height: 585px; margin-top: 14px; display: flex; align-items: center; justify-content: center; border: 1px solid #26344b; border-radius: 25px; background: #030817; }
    .envios-locked { width: 390px; max-width: 90%; text-align: center; }
    .envios-lock { width: 70px; height: 70px; margin: 0 auto 28px; display: flex; align-items: center; justify-content: center; border: 1px solid #17386f; border-radius: 50%; color: #4386ef; font-size: 34px; background: #0c2045; box-shadow: 0 0 26px rgba(47, 111, 232, .17); }
    .envios-locked h1 { margin: 0 0 12px; color: #f4f6ff; font-size: 20px; font-weight: 700; }
    .envios-locked p { margin: 0 0 26px; color: #8490aa; font-size: 16px; }
    .envios-view { padding: 0 27px; height: 61px; border: 0; border-radius: 13px; background: linear-gradient(100deg, #3c87ef, #4d38dc); color: #fff; font-size: 18px; font-weight: 700; cursor: pointer; box-shadow: 0 8px 18px rgba(47, 102, 237, .2); }
    .envios-view i { margin-right: 9px; }
    .envios-note { margin: 26px auto 0; padding-top: 20px; border-top: 1px solid #172034; color: #4f5b73; font-size: 13px; line-height: 1.45; }
    @media (max-width: 767px) {
        .envios-page { padding: 12px; }
        .envios-toolbar-row { flex-wrap: wrap; }
        .envios-search { order: 3; flex-basis: 100%; }
        .envios-date { flex: 1; min-width: 110px; }
        .envios-toolbar-row:nth-child(2) .envios-button { flex: 1 1 calc(50% - 10px); }
        .envios-toolbar-row:nth-child(2) .envios-button-icon { flex: 0 0 46px; }
        .envios-spacer { display: none; }
        .envios-board { min-height: 520px; }
        .envios-locked p { font-size: 14px; }
        .envios-view { max-width: 100%; padding: 0 20px; font-size: 16px; }
    }
    @media (max-width: 480px) {
        .envios-page { padding: 8px; }
        .envios-toolbar { padding: 14px 12px 16px; border-radius: 16px; }
        .envios-toolbar-row { gap: 8px; }
        .envios-control, .envios-search, .envios-button { font-size: 13px; }
        .envios-control { min-width: 0; }
        .envios-date { width: calc(50% - 4px); }
        .envios-board { min-height: 440px; border-radius: 16px; }
        .envios-lock { width: 58px; height: 58px; margin-bottom: 20px; font-size: 28px; }
        .envios-locked h1 { font-size: 18px; }
        .envios-note { font-size: 12px; }
    }
</style>

<div class="content-wrapper">
<main class="envios-page">
    <section class="envios-toolbar" aria-label="Filtros de respuestas">
        <div class="envios-toolbar-row">
            <select class="envios-control" aria-label="Estado">
                <option>PENDIENTES</option>
                <option>COMPLETADOS</option>
                <option>TODOS</option>
            </select>
            <input class="envios-control envios-date" type="text" placeholder="dd- -- aaaa" aria-label="Fecha">
            <input class="envios-search" type="search" placeholder="Buscar..." aria-label="Buscar respuestas">
        </div>
        <div class="envios-toolbar-row">
            <button class="envios-button" type="button"><i class="fa fa-check-square-o"></i>Todo</button>
            <button class="envios-button" type="button"><i class="fa fa-print"></i>Etiquetas</button>
            <button class="envios-button envios-button-green" type="button"><i class="fa fa-file-excel-o"></i>Excel</button>
            <button class="envios-button envios-button-icon" type="button" title="Actualizar"><i class="fa fa-refresh"></i></button>
            <span class="envios-spacer" aria-hidden="true"></span>
            <button class="envios-button envios-button-primary" type="button"><i class="fa fa-plus-circle"></i>Estado</button>
            <button class="envios-button envios-button-danger envios-button-icon" type="button" title="Eliminar"><i class="fa fa-trash-o"></i></button>
        </div>
    </section>

    <section class="envios-board" aria-label="Respuestas del formulario">
        <div class="envios-locked">
            <div class="envios-lock"><i class="fa fa-lock"></i></div>
            <h1>Plan Gratuito Limitado</h1>
            <p>La visualización de respuestas no está incluida en su plan actual.</p>
            <button class="envios-view" type="button" id="verRespuestas"><i class="fa fa-magic"></i>Ver <?php echo $totalRespuestas; ?> registros</button>
            <div class="envios-note">Todas tus respuestas serán visibles aquí, incluidas las conversaciones que se descarten en WhatsApp. Con el plan gratuito, solo se almacenan 2 meses de respuestas.</div>
        </div>
    </section>
</main>
</div>

<script>
$('#verRespuestas').on('click', function(){
    Swal.fire({title:'Plan Gratuito Limitado',text:'Actualiza tu plan para visualizar las respuestas.',icon:'info',confirmButtonText:'Cerrar'});
});
</script>
