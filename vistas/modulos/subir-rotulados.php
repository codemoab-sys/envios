<style>
	.rotulados-page { min-height: calc(100vh - 50px); padding: 22px 3.1% 32px; background: #030817; color: #eaf0ff; font-family: 'Source Sans Pro', sans-serif; }
	.rotulados-panel { max-width: 1100px; margin: 0 auto; padding: 22px; border: 1px solid #26344b; border-radius: 18px; background: #101a2d; box-shadow: 0 12px 28px rgba(0,0,0,.18); }
	.rotulados-title { margin: 0 0 5px; font-size: 25px; color: #fff; }
	.rotulados-help { margin: 0 0 22px; color: #9fb2d2; }
	.rotulados-form { display: grid; grid-template-columns: minmax(160px, 240px) minmax(220px, 1fr) auto; gap: 10px; align-items: end; padding: 16px; border: 1px solid #33415a; border-radius: 12px; background: #182237; }
	.rotulados-field { display: grid; gap: 6px; color: #b8c7df; font-size: 13px; font-weight: 600; }
	.rotulados-control { width: 100%; height: 40px; padding: 0 11px; border: 1px solid #40516d; border-radius: 8px; background: #0c1425; color: #fff; }
	.rotulados-button { height: 40px; padding: 0 16px; border: 0; border-radius: 8px; background: #e31b2b; color: #fff; font-weight: 700; cursor: pointer; }
	.rotulados-button:disabled { opacity: .55; cursor: wait; }
	.rotulados-table { width: 100%; margin-top: 22px; border-collapse: collapse; }
	.rotulados-table th, .rotulados-table td { padding: 12px 10px; border-bottom: 1px solid #2a3850; text-align: left; }
	.rotulados-table th { color: #9fb2d2; font-size: 12px; text-transform: uppercase; }
	.rotulados-table td { color: #eaf0ff; }
	.rotulados-client-button { padding: 7px 11px; border: 1px solid #5575a6; border-radius: 7px; background: #223555; color: #fff; cursor: pointer; }
	.rotulados-client-actions { display: flex; align-items: center; gap: 7px; }
	.rotulados-empty { padding: 28px 10px; color: #9fb2d2; text-align: center; }
	.rotulados-lista { margin-top: 26px; }
	.rotulados-lista h3 { margin: 0 0 10px; color: #fff; }
	.rotulados-modal { display: none; position: fixed; inset: 0; z-index: 1100; padding: 5vh 16px; background: rgba(0,0,0,.72); }
	.rotulados-modal.is-open { display: flex; align-items: flex-start; justify-content: center; }
	.rotulados-modal-box { width: min(760px, 100%); max-height: 90vh; overflow: auto; border: 1px solid #40516d; border-radius: 14px; background: #101a2d; box-shadow: 0 18px 45px rgba(0,0,0,.4); }
	.rotulados-modal-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 15px 18px; border-bottom: 1px solid #2a3850; }
	.rotulados-modal-header h3 { margin: 0; color: #fff; }
	.rotulados-modal-close { width: 34px; height: 34px; border: 0; border-radius: 7px; background: #263852; color: #fff; font-size: 20px; cursor: pointer; }
	.rotulados-modal-body { padding: 18px; }
	.rotulado-link { display: flex; align-items: center; gap: 7px; width: 100%; margin: 5px 0; padding: 10px 12px; border: 1px solid #334d75; border-radius: 7px; background: #223555; color: #dce8ff; text-align: left; cursor: pointer; }
	.rotulado-link:hover { background: #2b4770; }
	.rotulado-item { display: flex; align-items: center; gap: 8px; margin: 5px 0; }
	.rotulado-item .rotulado-link { flex: 1; margin: 0; }
	.rotulado-whatsapp { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border: 0; border-radius: 7px; background: #20c968; color: #fff; cursor: pointer; }
	.rotulado-whatsapp.is-disabled { background: #536174; cursor: not-allowed; }
	.rotulado-visor { width: 100%; height: 75vh; border: 0; background: #fff; }
	@media (max-width: 700px) { .rotulados-form { grid-template-columns: 1fr; } .rotulados-table { font-size: 13px; } .rotulados-table th:nth-child(3), .rotulados-table td:nth-child(3) { display: none; } }
</style>

<div class="content-wrapper">
	<main class="rotulados-page">
		<section class="rotulados-panel">
			<h1 class="rotulados-title"><i class="fa fa-upload"></i> Subir rotulados</h1>
			<p class="rotulados-help">Carga el PDF del rotulado. El sistema leerá el DNI o RUC que aparece junto a N°DOC.</p>
			<form id="formSubirRotulado" class="rotulados-form" enctype="multipart/form-data">
				<label class="rotulados-field">Archivo PDF
					<input class="rotulados-control" id="pdfRotulado" name="pdf" type="file" accept="application/pdf,.pdf" required>
				</label>
				<button class="rotulados-button" type="submit"><i class="fa fa-upload"></i> Subir PDF</button>
			</form>
			<div id="listaClientesRotulados" class="rotulados-lista"></div>
		</section>
	</main>
</div>

<div id="modalListaRotulados" class="rotulados-modal" role="dialog" aria-modal="true" aria-hidden="true">
	<div class="rotulados-modal-box">
		<div class="rotulados-modal-header"><h3 id="tituloListaRotulados">Rotulados</h3><button type="button" class="rotulados-modal-close" data-cerrar-modal="modalListaRotulados" aria-label="Cerrar">&times;</button></div>
		<div id="rotuladosCliente" class="rotulados-modal-body"></div>
	</div>
</div>

<div id="modalVisorRotulado" class="rotulados-modal" role="dialog" aria-modal="true" aria-hidden="true">
	<div class="rotulados-modal-box">
		<div class="rotulados-modal-header"><h3 id="tituloVisorRotulado">Rotulado</h3><button type="button" class="rotulados-modal-close" data-cerrar-modal="modalVisorRotulado" aria-label="Cerrar">&times;</button></div>
		<div class="rotulados-modal-body"><iframe id="visorRotulado" class="rotulado-visor" title="Vista del rotulado"></iframe></div>
	</div>
</div>

<script>
$(function(){
	function cargarClientes(){
		$.post('ajax/envios.ajax.php', {listarClientesRotuladosAjax: 1}, function(respuesta){
			var contenedor = $('#listaClientesRotulados').empty();
			if(respuesta.estado !== 'ok' || !respuesta.datos.length){
				contenedor.html('<div class="rotulados-empty">No hay clientes con DOC registrado.</div>');
				return;
			}
			var html = '<h3>Clientes</h3><table class="rotulados-table"><thead><tr><th>Cliente</th><th>DOC</th><th>Rotulados</th><th></th></tr></thead><tbody>';
			$.each(respuesta.datos, function(_, cliente){
				html += '<tr><td>' + escapar(cliente.nombre) + '</td><td>' + escapar(cliente.doc) + '</td><td>' + cliente.total_rotulados + '</td><td><div class="rotulados-client-actions"><button type="button" class="rotulados-client-button btn-ver-rotulados" data-doc="' + escapar(cliente.doc) + '" data-nombre="' + escapar(cliente.nombre) + '"><i class="fa fa-folder-open"></i> Ver rotulados</button>' + (cliente.ultimo_rotulado ? '<button type="button" class="rotulado-whatsapp ' + (!cliente.telefono ? 'is-disabled' : '') + ' btn-enviar-rotulado" data-url="' + escapar(cliente.ultimo_rotulado) + '" data-nombre="' + escapar(cliente.nombre) + '" data-telefono="' + escapar(cliente.telefono || '') + '" title="Enviar rotulado más reciente por WhatsApp" aria-label="Enviar rotulado más reciente por WhatsApp"><i class="fa fa-whatsapp"></i></button>' : '') + '</div></td></tr>';
			});
			contenedor.html(html + '</tbody></table>');
		}, 'json');
	}

	function escapar(valor){ return $('<div>').text(valor || '').html(); }

	$('#formSubirRotulado').on('submit', function(event){
		event.preventDefault();
		var boton = $(this).find('button[type="submit"]');
		var datos = new FormData(this);
		datos.append('subirRotuladoAjax', '1');
		boton.prop('disabled', true);
		$.ajax({url:'ajax/envios.ajax.php', method:'POST', data:datos, processData:false, contentType:false, dataType:'json'})
			.done(function(respuesta){
				if(respuesta.estado !== 'ok'){ Swal.fire('Error', respuesta.mensaje || 'No se pudo subir el PDF', 'error'); return; }
				Swal.fire({toast:true, position:'top-end', icon:'success', title:'Rotulado relacionado', showConfirmButton:false, timer:2000});
				$('#pdfRotulado').val('');
				cargarClientes();
			}).fail(function(){ Swal.fire('Error', 'No se pudo conectar con el servidor', 'error'); })
			.always(function(){ boton.prop('disabled', false); });
	});

	$(document).on('click', '.btn-ver-rotulados', function(){
		var doc = $(this).data('doc');
		var nombre = $(this).data('nombre');
		$.post('ajax/envios.ajax.php', {listarRotuladosClienteAjax:1, doc:doc}, function(respuesta){
			var contenedor = $('#rotuladosCliente').empty();
			$('#tituloListaRotulados').text('Rotulados de ' + nombre + ' (' + doc + ')');
			if(respuesta.estado !== 'ok' || !respuesta.datos.length){
				contenedor.html('<div class="rotulados-empty">No tiene rotulados subidos.</div>');
				abrirModal('modalListaRotulados');
				return;
			}
			var html = '';
			$.each(respuesta.datos, function(_, rotulado){
				html += '<div class="rotulado-item"><button type="button" class="rotulado-link btn-ver-pdf" data-url="' + escapar(rotulado.url) + '" data-nombre="' + escapar(rotulado.nombre_archivo) + '"><i class="fa fa-file-pdf-o"></i> ' + escapar(rotulado.nombre_archivo) + '</button><button type="button" class="rotulado-whatsapp ' + (!rotulado.telefono ? 'is-disabled' : '') + ' btn-enviar-rotulado" data-url="' + escapar(rotulado.url) + '" data-nombre="' + escapar(rotulado.nombre || nombre) + '" data-telefono="' + escapar(rotulado.telefono || '') + '" title="Enviar por WhatsApp" aria-label="Enviar por WhatsApp"><i class="fa fa-whatsapp"></i></button></div>';
			});
			contenedor.html(html);
			abrirModal('modalListaRotulados');
		}, 'json');
	});

	function abrirModal(id){ $('#' + id).addClass('is-open').attr('aria-hidden', 'false'); }
	function cerrarModal(id){
		$('#' + id).removeClass('is-open').attr('aria-hidden', 'true');
		if(id === 'modalVisorRotulado') $('#visorRotulado').attr('src', '');
	}

	$(document).on('click', '.btn-ver-pdf', function(){
		$('#tituloVisorRotulado').text($(this).data('nombre'));
		$('#visorRotulado').attr('src', $(this).data('url'));
		abrirModal('modalVisorRotulado');
	});
	$(document).on('click', '.btn-enviar-rotulado', function(){
		var telefono = String($(this).data('telefono') || '').replace(/[^0-9]/g, '');
		if(!telefono){ Swal.fire('Sin teléfono', 'Este envío no tiene un número registrado', 'info'); return; }
		if(telefono.length === 9) telefono = '51' + telefono;
		var url = new URL($(this).data('url'), window.location.href).href;
		var mensaje = 'Hola *' + ($(this).data('nombre') || 'cliente') + '*, aquí está tu rotulado:\n' + url;
		window.open('https://wa.me/' + telefono + '?text=' + encodeURIComponent(mensaje), '_blank');
	});
	$(document).on('click', '[data-cerrar-modal]', function(){ cerrarModal($(this).data('cerrar-modal')); });
	$('.rotulados-modal').on('click', function(event){ if(event.target === this) cerrarModal(this.id); });
	$(document).on('keydown', function(event){
		if(event.key === 'Escape'){
			cerrarModal('modalVisorRotulado');
			cerrarModal('modalListaRotulados');
		}
	});

	cargarClientes();
});
</script>
