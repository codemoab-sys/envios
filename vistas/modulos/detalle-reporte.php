<style>
	.detalle-reporte-page { min-height: calc(100vh - 50px); padding: 22px 3.1% 32px; background: #030817; color: #eaf0ff; font-family: 'Source Sans Pro', sans-serif; }
	.detalle-reporte-panel { max-width: 1100px; margin: 0 auto; padding: 22px; border: 1px solid #26344b; border-radius: 18px; background: #101a2d; box-shadow: 0 12px 28px rgba(0,0,0,.18); }
	.detalle-reporte-title { margin: 0 0 5px; color: #fff; font-size: 25px; }
	.detalle-reporte-help { margin: 0 0 20px; color: #9fb2d2; }
	.detalle-reporte-filtros { display: flex; flex-wrap: wrap; gap: 10px; align-items: end; padding: 15px; border: 1px solid #33415a; border-radius: 12px; background: #182237; }
	.detalle-reporte-field { display: grid; gap: 5px; color: #b8c7df; font-size: 13px; font-weight: 600; }
	.detalle-reporte-control { height: 38px; min-width: 145px; padding: 0 10px; border: 1px solid #40516d; border-radius: 7px; background: #0c1425; color: #fff; }
	.detalle-reporte-button { height: 38px; padding: 0 14px; border: 0; border-radius: 7px; background: #e31b2b; color: #fff; font-weight: 700; cursor: pointer; }
	.detalle-reporte-button.secondary { background: #29446d; }
	.detalle-reporte-resumen { display: grid; grid-template-columns: repeat(4, minmax(130px, 1fr)); gap: 12px; margin: 20px 0; }
	.detalle-reporte-card { padding: 15px; border: 1px solid #2c4264; border-radius: 11px; background: #182943; }
	.detalle-reporte-card span { display: block; color: #9fb2d2; font-size: 12px; text-transform: uppercase; }
	.detalle-reporte-card strong { display: block; margin-top: 5px; color: #fff; font-size: 28px; }
	.detalle-reporte-table { width: 100%; border-collapse: collapse; }
	.detalle-reporte-table th, .detalle-reporte-table td { padding: 12px 10px; border-bottom: 1px solid #2a3850; text-align: left; }
	.detalle-reporte-table th { color: #9fb2d2; font-size: 12px; text-transform: uppercase; }
	.detalle-reporte-table td { color: #eaf0ff; }
	.detalle-reporte-loading { padding: 30px; color: #9fb2d2; text-align: center; }
	@media (max-width: 700px) { .detalle-reporte-resumen { grid-template-columns: repeat(2, 1fr); } .detalle-reporte-filtros { display: grid; grid-template-columns: 1fr 1fr; } .detalle-reporte-field, .detalle-reporte-button { min-width: 0; width: 100%; } }
</style>

<div class="content-wrapper">
	<main class="detalle-reporte-page">
		<section class="detalle-reporte-panel">
			<h1 class="detalle-reporte-title"><i class="fa fa-bar-chart"></i> Detalle y reporte</h1>
			<p class="detalle-reporte-help">Consulta el resumen de envíos por agencia y estado de tu empresa.</p>
			<div class="detalle-reporte-filtros">
				<label class="detalle-reporte-field">Desde<input id="reporteFechaInicio" class="detalle-reporte-control" type="date"></label>
				<label class="detalle-reporte-field">Hasta<input id="reporteFechaFin" class="detalle-reporte-control" type="date"></label>
				<label class="detalle-reporte-field">Estado<select id="reporteEstado" class="detalle-reporte-control"><option value="todos">Todos</option><option value="nuevo">Nuevo</option><option value="etiqueta">Etiqueta</option><option value="entregado">Entregado</option></select></label>
				<button type="button" id="btnActualizarReporte" class="detalle-reporte-button"><i class="fa fa-refresh"></i> Actualizar</button>
				<button type="button" id="btnExportarReporte" class="detalle-reporte-button secondary"><i class="fa fa-download"></i> CSV</button>
			</div>
			<div id="reporteResumen" class="detalle-reporte-resumen"></div>
			<div id="reporteTabla"><div class="detalle-reporte-loading"><i class="fa fa-spinner fa-spin"></i> Cargando...</div></div>
		</section>
	</main>
</div>

<script>
$(function(){
	var reporteActual = [];
	var nombresAgencia = {
		'DELIVERY (SOLO LIMA)': 'DELIVERY',
		'DELIVERY (SOLO TRUJILLO)': 'DELIVERY',
		'RETIRO EN AGENCIA SHALOM': 'SHALOM',
		'RETIRO EN AGENCIA OLVA COURIER': 'OLVA COURIER',
		'RETIRO EN AGENCIA MARVISUR': 'MARVISUR',
		'RETIRO EN AGENCIA DINSIDES': 'DINSIDES',
		'RETIRO EN TIENDA': 'RETIRO EN TIENDA',
		'ENCOMIENDA': 'ENCOMIENDA'
	};
	var nombresEstado = {nuevo:'NUEVO', etiqueta:'ETIQUETA', entregado:'ENTREGADO', pagado:'NUEVO', preparando:'NUEVO', etiqueta_generada:'ETIQUETA', enviado:'ETIQUETA', en_transito:'ETIQUETA'};

	function escapar(valor){ return $('<div>').text(valor || '').html(); }
	function cargarReporte(){
		$('#reporteTabla').html('<div class="detalle-reporte-loading"><i class="fa fa-spinner fa-spin"></i> Cargando...</div>');
		$.post('ajax/envios.ajax.php', {detalleReporteAjax:1, fecha_inicio:$('#reporteFechaInicio').val(), fecha_fin:$('#reporteFechaFin').val(), estado:$('#reporteEstado').val()}, function(respuesta){
			if(respuesta.estado !== 'ok'){ $('#reporteTabla').html('<div class="detalle-reporte-loading">No se pudo cargar el reporte.</div>'); return; }
			reporteActual = respuesta.datos || [];
			var estados = {nuevo:0, etiqueta:0, entregado:0};
			$.each(reporteActual, function(_, fila){ var estado = nombresEstado[fila.estado] === 'ETIQUETA' ? 'etiqueta' : (nombresEstado[fila.estado] === 'ENTREGADO' ? 'entregado' : 'nuevo'); estados[estado] += Number(fila.cantidad || 0); });
			$('#reporteResumen').html('<div class="detalle-reporte-card"><span>Total</span><strong>' + respuesta.total + '</strong></div><div class="detalle-reporte-card"><span>Nuevo</span><strong>' + estados.nuevo + '</strong></div><div class="detalle-reporte-card"><span>Etiqueta</span><strong>' + estados.etiqueta + '</strong></div><div class="detalle-reporte-card"><span>Entregado</span><strong>' + estados.entregado + '</strong></div>');
			if(!reporteActual.length){ $('#reporteTabla').html('<div class="detalle-reporte-loading">No hay envíos para los filtros seleccionados.</div>'); return; }
			var html = '<table class="detalle-reporte-table"><thead><tr><th>Agencia</th><th>Estado</th><th>Cantidad</th></tr></thead><tbody>';
			$.each(reporteActual, function(_, fila){ html += '<tr><td>' + escapar(nombresAgencia[String(fila.agencia || '').toUpperCase()] || fila.agencia || 'SIN AGENCIA') + '</td><td>' + escapar(nombresEstado[fila.estado] || fila.estado) + '</td><td>' + fila.cantidad + '</td></tr>'; });
			$('#reporteTabla').html(html + '</tbody></table>');
		}, 'json');
	}
	$('#btnActualizarReporte').on('click', cargarReporte);
	$('#btnExportarReporte').on('click', function(){
		if(!reporteActual.length){ Swal.fire('Sin datos', 'No hay datos para exportar', 'info'); return; }
		var filas = [['Agencia','Estado','Cantidad']];
		$.each(reporteActual, function(_, fila){ filas.push([nombresAgencia[String(fila.agencia || '').toUpperCase()] || fila.agencia || 'SIN AGENCIA', nombresEstado[fila.estado] || fila.estado, fila.cantidad]); });
		var csv = filas.map(function(fila){ return fila.map(function(valor){ return '"' + String(valor).replace(/"/g, '""') + '"'; }).join(';'); }).join('\n');
		var enlace = document.createElement('a'); enlace.href = URL.createObjectURL(new Blob([csv], {type:'text/csv;charset=utf-8;'})); enlace.download = 'detalle-reporte.csv'; enlace.click(); URL.revokeObjectURL(enlace.href);
	});
	cargarReporte();
});
</script>
