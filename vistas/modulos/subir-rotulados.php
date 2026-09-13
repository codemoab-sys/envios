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
	.rotulados-empty { padding: 28px 10px; color: #9fb2d2; text-align: center; }
	.rotulados-lista { margin-top: 26px; }
	.rotulados-lista h3 { margin: 0 0 10px; color: #fff; }
	.rotulado-link { display: inline-flex; align-items: center; gap: 7px; margin: 5px 8px 5px 0; padding: 8px 10px; border-radius: 7px; background: #223555; color: #dce8ff; text-decoration: none; }
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
			<div id="rotuladosCliente" class="rotulados-lista"></div>
		</section>
	</main>
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
				html += '<tr><td>' + escapar(cliente.nombre) + '</td><td>' + escapar(cliente.doc) + '</td><td>' + cliente.total_rotulados + '</td><td><button type="button" class="rotulados-client-button btn-ver-rotulados" data-doc="' + escapar(cliente.doc) + '" data-nombre="' + escapar(cliente.nombre) + '"><i class="fa fa-folder-open"></i> Ver rotulados</button></td></tr>';
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
			if(respuesta.estado !== 'ok' || !respuesta.datos.length){
				contenedor.html('<h3>Rotulados de ' + escapar(nombre) + '</h3><div class="rotulados-empty">No tiene rotulados subidos.</div>');
				return;
			}
			var html = '<h3>Rotulados de ' + escapar(nombre) + ' (' + escapar(doc) + ')</h3>';
			$.each(respuesta.datos, function(_, rotulado){
				html += '<a class="rotulado-link" href="' + escapar(rotulado.url) + '" target="_blank" rel="noopener"><i class="fa fa-file-pdf-o"></i> ' + escapar(rotulado.nombre_archivo) + '</a>';
			});
			contenedor.html(html);
		}, 'json');
	});

	cargarClientes();
});
</script>
