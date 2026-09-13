<?php
$totalRespuestas = ControladorEnvios::ctrContarRespuestas();
$configuracionEnvios = ControladorConfiguracion::ctrMostrarConfiguracion();
$nombreEmprendimientoEtiqueta = trim((string) ($configuracionEnvios["nombre_emprendimiento"] ?? ""));
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
    .envios-reporte-label { color: #aebbd2; font-size: 13px; font-weight: 700; white-space: nowrap; }
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
    .envios-select-with-icon { display: contents; }
    .envios-select-with-icon i { display: none; }
    .envios-mobile-select-toggle,
    .envios-mobile-select-options { display: none; }
    .envios-spacer { width: 1px; height: 25px; margin: 0 2px; background: #344057; }
    .envios-agencia-header {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 14px;
        min-height: 72px;
        padding: 16px 20px 18px;
        border: 2px solid #3d7bf7;
        border-radius: 20px;
        background: linear-gradient(180deg, rgba(11, 22, 36, 0.94), rgba(8, 17, 29, 0.98));
        box-shadow: inset 0 0 0 1px rgba(115, 164, 255, 0.08);
    }
    .envios-agencia-mark {
        width: 4px;
        height: 28px;
        border-radius: 6px;
        background: linear-gradient(180deg, #6ab2ff, #3d7bf7);
        box-shadow: 0 0 14px rgba(61, 123, 247, 0.7);
    }
    .envios-agencia-name {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -0.04em;
        color: #eff5ff;
        line-height: 1;
    }
    .envios-board { margin-top: 14px; border: 1px solid #26344b; border-radius: 25px; background: rgba(8, 18, 31, 0.96); overflow: hidden; }
    .envios-board-header { display: none; }
    .envios-cards-wrap { padding: 14px; }
    .envios-cards { display: flex; flex-direction: column; gap: 14px; }
    .envios-card {
        background: linear-gradient(180deg, rgba(21, 35, 57, 0.9), rgba(12, 23, 39, 0.96));
        border: 2px solid #3d7bf7;
        border-radius: 18px;
        padding: 18px 20px 16px;
        box-shadow: inset 0 0 0 1px rgba(136, 171, 255, 0.08);
    }
    .envios-card-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .envios-check {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 16px;
        height: 16px;
        position: relative;
        flex-shrink: 0;
    }
    .envios-check input {
        position: absolute;
        inset: 0;
        opacity: 0;
        margin: 0;
        cursor: pointer;
    }
    .envios-check span {
        display: block;
        width: 16px;
        height: 16px;
        border: 2px solid #7a92be;
        border-radius: 4px;
        background: rgba(20, 30, 45, 0.7);
    }
    .envios-check input:checked + span {
        background: linear-gradient(180deg, #3f8cff, #2b6df0);
        border-color: #53a3ff;
        position: relative;
    }
    .envios-check input:checked + span::after {
        content: "";
        position: absolute;
        left: 4px;
        top: 1px;
        width: 4px;
        height: 8px;
        border: solid #fff;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    .envios-person { flex: 1; min-width: 0; }
    .envios-name-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 8px;
    }
    .envios-name {
        font-size: 19px;
        font-weight: 700;
        color: #edf5ff;
    }
    .envios-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 116px;
        height: 30px;
        padding: 0 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border: 1px solid transparent;
        cursor: pointer;
    }
    .envios-status:hover { filter: brightness(1.12); }
    .envios-status-pendiente {
        background: rgba(251, 191, 36, 0.18);
        border-color: rgba(251, 191, 36, 0.45);
        color: #f8d161;
    }
    .envios-status-completado {
        background: rgba(34, 197, 94, 0.16);
        border-color: rgba(34, 197, 94, 0.3);
        color: #4ade80;
    }
    .envios-meta-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        color: #9ab1d3;
        font-size: 14px;
    }
    .envios-meta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        color: #b8caec;
    }
    .envios-meta i {
        color: #7ca7ff;
        font-size: 13px;
    }
    .envios-meta strong {
        color: #dfe9ff;
        font-weight: 600;
    }
    .envios-fecha {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 2px 0;
        color: #cfe0ff;
        font-size: 13px;
    }
    .envios-fecha .envios-fecha-label {
        color: #dfe9ff;
        font-weight: 600;
    }
    .envios-agencia-mini {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        color: #cbe1ff;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.02em;
    }
    .envios-agencia-mini i {
        color: #a7c9ff;
        font-size: 12px;
    }
    .envios-whatsapp {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(37, 211, 102, 0.12);
        border: 1px solid rgba(37, 211, 102, 0.4);
        color: #25d366;
        text-decoration: none;
        flex-shrink: 0;
    }
    .envios-address {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 16px;
        padding-top: 12px;
        border-top: 1px solid rgba(120, 151, 204, 0.18);
        color: #e0ebff;
        font-size: 15px;
        line-height: 1.5;
    }
    .envios-address i {
        color: #b9c8e7;
        font-size: 14px;
    }
    .envios-empty { padding: 60px 20px; text-align: center; }
    .envios-empty i { font-size: 48px; color: #26344b; margin-bottom: 16px; display: block; }
    .envios-empty p { color: #8490aa; font-size: 15px; margin: 0; }
    .envios-loading { text-align: center; color: #8490aa; padding: 30px; }
    .envios-pagination { display: flex; align-items: center; justify-content: center; gap: 12px; padding: 14px; border-top: 1px solid #26344b; color: #9ab1d3; font-size: 13px; }
    .envios-pagination button { min-width: 36px; height: 32px; border: 1px solid #33415a; border-radius: 8px; background: #202c42; color: #dce5f8; cursor: pointer; }
    .envios-pagination button:disabled { opacity: .4; cursor: not-allowed; }
    [data-theme="light"] .envios-page { background: #f4f6f9; color: #1f2937; }
    [data-theme="light"] .envios-toolbar { border-color: #dbe3ed; background: linear-gradient(145deg, #fff, #f4f7fb); box-shadow: 0 8px 22px rgba(31, 41, 55, .08); }
    [data-theme="light"] .envios-control, [data-theme="light"] .envios-search, [data-theme="light"] .envios-button { border-color: #cbd5e1; background: #fff; color: #334155; }
    [data-theme="light"] .envios-search { color: #334155; background-color: #fff; }
    [data-theme="light"] .envios-button i { color: #64748b; }
    [data-theme="light"] .envios-button-primary { border-color: #2563eb; background: #2563eb; color: #fff; }
    [data-theme="light"] .envios-button-primary i { color: #fff; }
    [data-theme="light"] .envios-button-green { border-color: #0f9f82; background: #ecfdf5; color: #087f68; }
    [data-theme="light"] .envios-button-danger { border-color: #e5a1aa; background: #fff1f2; color: #be3b4b; }
    [data-theme="light"] .envios-spacer { background: #d5dde8; }
    [data-theme="light"] .envios-board { border-color: #dbe3ed; background: #fff; }
    [data-theme="light"] .envios-card { border-color: #80aaf5; background: linear-gradient(180deg, #fff, #f7faff); box-shadow: 0 5px 15px rgba(31, 41, 55, .06); }
    [data-theme="light"] .envios-name { color: #172033; }
    [data-theme="light"] .envios-meta, [data-theme="light"] .envios-meta strong, [data-theme="light"] .envios-fecha, [data-theme="light"] .envios-fecha .envios-fecha-label, [data-theme="light"] .envios-agencia-mini { color: #334155; }
    [data-theme="light"] .envios-meta i, [data-theme="light"] .envios-agencia-mini i { color: #2563eb; }
    [data-theme="light"] .envios-address { border-top-color: #e2e8f0; color: #334155; }
    [data-theme="light"] .envios-pagination { border-top-color: #e2e8f0; color: #64748b; }
    [data-theme="light"] .envios-pagination button { border-color: #cbd5e1; background: #fff; color: #334155; }
    @media (max-width: 767px) {
        .content-wrapper:has(.envios-page) { padding-top: 50px !important; }
        .envios-page { padding: 12px; }
        .envios-toolbar-row { flex-wrap: wrap; }
        .envios-toolbar-row:first-child { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 8px; }
        .envios-toolbar-row:first-child #filtroEstado,
        .envios-toolbar-row:first-child #filtroAgencia,
        .envios-toolbar-row:first-child .envios-date { width: 100%; min-width: 0; }
        .envios-search { order: initial; grid-column: 1 / -1; width: 100%; }
        .envios-toolbar-row:nth-child(2) { flex-wrap: nowrap; gap: 8px; overflow-x: auto; padding-bottom: 2px; scrollbar-width: thin; }
        .envios-toolbar-row:nth-child(2) .envios-button,
        .envios-toolbar-row:nth-child(2) .envios-control,
        .envios-toolbar-row:nth-child(2) .envios-reporte-label { flex: 0 0 auto; }
        .envios-toolbar-row:nth-child(2) .envios-button { width: 42px; height: 42px; padding: 0; }
        .envios-toolbar-row:nth-child(2) .envios-button span,
        .envios-toolbar-row:nth-child(2) .envios-reporte-label { display: none; }
        .envios-toolbar-row:nth-child(2) .envios-button i { margin: 0; }
        .envios-toolbar-row:nth-child(2) .envios-button-icon { flex: 0 0 42px; width: 42px; }
        .envios-toolbar-row:nth-child(2) #btnMarcarCompletado { width: auto; min-width: 112px; padding: 0 12px; white-space: nowrap; }
        .envios-toolbar-row:nth-child(2) #btnMarcarCompletado i { margin-right: 7px; }
        .envios-toolbar-row:nth-child(2) .envios-control { height: 42px; max-width: 130px; }
        .envios-toolbar-row:nth-child(2) .envios-select-with-icon { display: flex; align-items: center; justify-content: center; gap: 0; width: 42px; height: 42px; padding: 0; border: 1px solid #33415a; border-radius: 9px; background: #202c42; color: #9fb2d2; }
        .envios-toolbar-row:nth-child(2) .envios-select-with-icon i { display: block; flex: 0 0 auto; }
        .envios-toolbar-row:nth-child(2) .envios-select-with-icon { position: relative; overflow: visible; }
        .envios-toolbar-row:nth-child(2) .envios-select-with-icon .envios-control { position: absolute; width: 1px; height: 1px; opacity: 0; pointer-events: none; }
        .envios-mobile-select-toggle { display: block; position: absolute; inset: 0; z-index: 2; border: 0; background: transparent; cursor: pointer; }
        .envios-mobile-select-options { position: fixed; top: auto; left: auto; z-index: 1050; min-width: 190px; padding: 6px; border: 1px solid #33415a; border-radius: 10px; background: #182237; box-shadow: 0 12px 24px rgba(0,0,0,.3); }
        .envios-mobile-select-options.is-open { display: grid; gap: 3px; }
        .envios-mobile-select-options button { width: 100%; padding: 9px 10px; border: 0; border-radius: 7px; background: transparent; color: #dce5f8; font-size: 13px; text-align: left; cursor: pointer; }
        .envios-mobile-select-options button:hover { background: #243858; }
        .envios-spacer { display: none; }
        .envios-board { border-radius: 16px; }
        .envios-card { padding: 16px 14px; }
        .envios-name-row { align-items: flex-start; }
        .envios-name { font-size: 17px; }
        .envios-meta-row { gap: 10px 12px; font-size: 12px; }
    }
    @media (max-width: 480px) {
        .envios-page { padding: 8px; }
        .envios-toolbar { padding: 14px 12px 16px; border-radius: 16px; }
        .envios-toolbar-row { gap: 8px; }
        .envios-control, .envios-search, .envios-button { font-size: 13px; }
        .envios-control { min-width: 0; }
        .envios-date { width: calc(50% - 4px); }
        .envios-card-row { flex-wrap: wrap; }
        .envios-whatsapp { margin-left: auto; }
        .envios-name-row { flex-direction: column; align-items: flex-start; }
        .envios-status { min-width: auto; }
        .envios-toolbar-row:nth-child(2) .envios-select-with-icon { width: 42px; max-width: 42px; }
    }
</style>

<div class="content-wrapper">
<main class="envios-page">
    <section class="envios-toolbar" aria-label="Filtros de respuestas">
        <div class="envios-toolbar-row">
            <select class="envios-control" id="filtroEstado" aria-label="Estado">
                <option value="todos">TODOS</option>
                <option value="nuevo" selected>NUEVO</option>
                <option value="etiqueta">ETIQUETA</option>
                <option value="entregado">ENTREGADO</option>
            </select>
            <select class="envios-control" id="filtroAgencia" aria-label="Agencia o metodo de envio">
                <option value="todos">TODAS LAS AGENCIAS</option>
                <option value="RETIRO EN AGENCIA SHALOM">Shalom</option>
                <option value="RETIRO EN AGENCIA OLVA COURIER">Olva Courier</option>
                <option value="RETIRO EN AGENCIA MARVISUR">Marvisur</option>
                <option value="RETIRO EN AGENCIA DINSIDES">Dinsides</option>
                <option value="DELIVERY (SOLO LIMA)">Delivery (Solo Lima)</option>
                <option value="DELIVERY (SOLO TRUJILLO)">Delivery (Solo Trujillo)</option>
                <option value="RETIRO EN TIENDA">Retiro en tienda</option>
                <option value="ENCOMIENDA">Encomienda</option>
            </select>
            <input class="envios-control envios-date" type="date" id="filtroFechaInicio" aria-label="Fecha de inicio" title="Fecha de inicio">
            <input class="envios-control envios-date" type="date" id="filtroFechaFin" aria-label="Fecha de fin" title="Fecha de fin">
            <input class="envios-search" type="search" id="buscadorRespuestas" placeholder="Buscar por nombre, telefono o agencia..." aria-label="Buscar respuestas por nombre, telefono o agencia">
        </div>
        <div class="envios-toolbar-row">
            <button class="envios-button" type="button" id="btnTodo"><i class="fa fa-check-square-o"></i><span>Todo</span></button>
            <button class="envios-button envios-button-icon" type="button" id="btnActualizar" title="Actualizar"><i class="fa fa-refresh"></i></button>
            <span class="envios-spacer" aria-hidden="true"></span>
            <span class="envios-select-with-icon">
                <i class="fa fa-tags" aria-hidden="true"></i>
                <select class="envios-control" id="selectorEtiquetas" aria-label="Formato de etiquetas">
                    <option value="">Etiquetas</option>
                    <option value="grandes">Etiquetas en 1 columna</option>
                    <option value="dos-columnas">Etiquetas en 2 columnas</option>
                    <option value="tres-columnas">Etiquetas en 3 columnas</option>
                </select>
                <button class="envios-mobile-select-toggle" type="button" aria-label="Seleccionar formato de etiquetas"></button>
                <span class="envios-mobile-select-options" data-select="selectorEtiquetas">
                    <button type="button" data-value="grandes">Etiquetas en 1 columna</button>
                    <button type="button" data-value="dos-columnas">Etiquetas en 2 columnas</button>
                    <button type="button" data-value="tres-columnas">Etiquetas en 3 columnas</button>
                </span>
            </span>
            <span class="envios-reporte-label">Tipo de reporte:</span>
            <span class="envios-select-with-icon">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                <select class="envios-control" id="selectorReporteExcel" aria-label="Selecciona el tipo de reporte para descargar">
                    <option value="" selected>Selecciona un reporte...</option>
                    <option value="shalom">Shalom (formato de agencia)</option>
                    <option value="general">General (todos los envíos)</option>
                </select>
                <button class="envios-mobile-select-toggle" type="button" aria-label="Seleccionar tipo de reporte"></button>
                <span class="envios-mobile-select-options" data-select="selectorReporteExcel">
                    <button type="button" data-value="shalom">Shalom (formato de agencia)</button>
                    <button type="button" data-value="general">General (todos los envíos)</button>
                </span>
            </span>
            <button class="envios-button envios-button-primary" type="button" id="btnMarcarCompletado"><i class="fa fa-check-circle"></i>Avanzar estado</button>
            <button class="envios-button envios-button-danger envios-button-icon" type="button" id="btnEliminar" title="Eliminar"><i class="fa fa-trash-o"></i></button>
        </div>
    </section>

    <section class="envios-board" aria-label="Respuestas del formulario">
        <div class="envios-board-header">
            <h2>Respuestas del formulario</h2>
            <span id="contadorRespuestasBoard"><?php echo $totalRespuestas; ?> registros</span>
        </div>
        <div class="envios-cards-wrap" id="contenedorTabla">
            <div class="envios-cards" id="tablaRespuestas"></div>
        </div>
        <div class="envios-pagination" id="paginacionRespuestas" style="display:none">
            <button type="button" id="btnPaginaAnterior" aria-label="Pagina anterior"><i class="fa fa-chevron-left"></i></button>
            <span id="textoPaginacionRespuestas"></span>
            <button type="button" id="btnPaginaSiguiente" aria-label="Pagina siguiente"><i class="fa fa-chevron-right"></i></button>
        </div>
        <div class="envios-empty" id="vacioRespuestas" style="display:none">
            <i class="fa fa-inbox"></i>
            <p>No hay respuestas para mostrar</p>
        </div>
    </section>
</main>
</div>

<script>var nombreEmprendimientoEtiqueta = <?php echo json_encode($nombreEmprendimientoEtiqueta, JSON_UNESCAPED_UNICODE); ?>;</script>
<script>
    $(function(){
        $('.envios-mobile-select-toggle').on('click', function(){
            var menu = $(this).siblings('.envios-mobile-select-options');
            $('.envios-mobile-select-options').not(menu).removeClass('is-open');
            var rect = this.getBoundingClientRect();
            var seAbrira = !menu.hasClass('is-open');
            menu.toggleClass('is-open', seAbrira);
            if(seAbrira){
                var left = Math.min(rect.left, window.innerWidth - menu.outerWidth() - 8);
                menu.css({left: Math.max(8, left) + 'px', top: (rect.bottom + 6) + 'px'});
            }
        });
        $('.envios-mobile-select-options button').on('click', function(){
            var menu = $(this).parent();
            $('#' + menu.data('select')).val($(this).data('value')).trigger('change');
            menu.removeClass('is-open');
        });
        $(document).on('click', function(event){
            if(!$(event.target).closest('.envios-select-with-icon').length){
                $('.envios-mobile-select-options').removeClass('is-open');
            }
        });
    });
</script>
<script src="vistas/js/envios.js?v=<?php echo (int) filemtime(__DIR__ . '/../js/envios.js'); ?>"></script>
