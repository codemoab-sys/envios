$(document).ready(function(){
    var registrosPorId = {};
    var ventanaEtiquetas = null;
    var paginaActual = 1;
    var limitePagina = 10;
    var filtrosCargados = false;

    function cargarRespuestas(){
        var estado = $('#filtroEstado').val();
        var agencia = $('#filtroAgencia').val();
        var fechaInicio = $('#filtroFechaInicio').val();
        var fechaFin = $('#filtroFechaFin').val();
        var busqueda = $('#buscadorRespuestas').val();
        $.ajax({
            url: 'ajax/envios.ajax.php',
            method: 'POST',
            data: { listarRespuestasAjax: 1, estado: estado, agencia: agencia, fecha_inicio: fechaInicio, fecha_fin: fechaFin, busqueda: busqueda, pagina: paginaActual, limite: limitePagina },
            dataType: 'json',
            beforeSend: function(){
                $('#tablaRespuestas').html('<div class="envios-loading"><i class="fa fa-spinner fa-spin"></i> Cargando...</div>');
                $('#vacioRespuestas').hide();
                $('#contenedorTabla').show();
            },
            success: function(respuesta){
                if(respuesta.estado === 'ok'){
                    renderizarTabla(respuesta.datos, respuesta.paginacion);
                } else {
                    $('#tablaRespuestas').html('<div class="envios-loading" style="color:#e36b77">Error al cargar datos</div>');
                }
            },
            error: function(){
                $('#tablaRespuestas').html('<div class="envios-loading" style="color:#e36b77">Error de conexion</div>');
            }
        });
    }

    function obtenerFechasPorDefecto(){
        var hoy = new Date();
        var ayer = new Date(hoy);
        ayer.setDate(hoy.getDate() - 1);
        return {
            inicio: convertirFechaInput(ayer),
            fin: convertirFechaInput(hoy)
        };
    }

    function convertirFechaInput(fecha){
        var anio = fecha.getFullYear();
        var mes = String(fecha.getMonth() + 1).padStart(2, '0');
        var dia = String(fecha.getDate()).padStart(2, '0');
        return anio + '-' + mes + '-' + dia;
    }

    function renderizarTabla(datos, paginacion){
        var contenedor = $('#tablaRespuestas');
        contenedor.empty();
        if(datos.length === 0){
            $('#contenedorTabla').hide();
            $('#vacioRespuestas').show();
            $('#contadorRespuestasBoard').text('0 registros');
            $('#paginacionRespuestas').hide();
            return;
        }
        $('#contenedorTabla').show();
        $('#vacioRespuestas').hide();
        $('#contadorRespuestasBoard').text((paginacion ? paginacion.total : datos.length) + ' registros');
        $.each(datos, function(i, item){
            registrosPorId[item.id] = item;
            var fechaRegistro = item.fecha ? item.fecha.split(' ')[0].split('-').reverse().join('/') : '-';
            var horaRegistro = item.fecha ? item.fecha.split(' ')[1] : '';
            var fechaEnvioTexto = formatearFechaEnvio(item.fecha_envio, fechaRegistro, horaRegistro);
            var estado = normalizarEstado(item.estado);
            var estadoClase = estado === 'entregado' ? 'envios-status-completado' : 'envios-status-pendiente';
            var estadoTexto = nombreEstado(estado);
            var telefono = escaparHtml(item.telefono || '-');
            var codigo = escaparHtml(item.codigo || '-');
            var direccion = escaparHtml(item.direccion || '-');
            var nombre = escaparHtml(item.nombre || '-');
            var agenciaTexto = (item.agencia && item.agencia.trim()) ? escaparHtml(item.agencia.trim()) : 'SHALOM';
            var numeroWhatsapp = (item.telefono || '').replace(/[^0-9]/g, '');
            var mensajeWhatsapp = crearMensajeWhatsapp(item);
            var enlaceWhatsapp = numeroWhatsapp ? 'https://wa.me/' + numeroWhatsapp + '?text=' + encodeURIComponent(mensajeWhatsapp) : '#';
            var fila = '<article class="envios-card" data-id="' + item.id + '">' +
                '<div class="envios-card-row">' +
                    '<label class="envios-check">' +
                        '<input type="checkbox" class="seleccionar-fila" value="' + item.id + '">' +
                        '<span></span>' +
                    '</label>' +
                    '<div class="envios-person">' +
                        '<div class="envios-name-row">' +
                            '<div class="envios-name">' + nombre + '</div>' +
                            '<button class="envios-status ' + estadoClase + ' btn-cambiar-estado" type="button" data-id="' + item.id + '" data-estado="' + estado + '" title="Avanzar estado">' + estadoTexto + '</button>' +
                        '</div>' +
                        '<div class="envios-meta-row"><span class="envios-meta"><i class="fa fa-hashtag"></i><strong>' + codigo + '</strong></span></div>' +
                        '<div class="envios-meta-row">' +
                            '<span class="envios-meta"><i class="fa fa-phone"></i><strong>' + telefono + '</strong></span>' +
                            '<span class="envios-fecha"><i class="fa fa-calendar"></i><span class="envios-fecha-label">Envío:</span><span>' + fechaEnvioTexto + '</span></span>' +
                        '</div>' +
                        '<div class="envios-agencia-mini"><i class="fa fa-building-o"></i><span>Agencia: ' + agenciaTexto + '</span></div>' +
                    '</div>' +
                    '<a class="envios-whatsapp" href="' + enlaceWhatsapp + '" target="_blank" rel="noopener" aria-label="Abrir WhatsApp"' + (numeroWhatsapp ? '' : ' onclick="return false;"') + '><i class="fa fa-whatsapp"></i></a>' +
                '</div>' +
                '<div class="envios-address"><i class="fa fa-map-marker"></i><span>' + direccion + '</span></div>' +
            '</article>';
            contenedor.append(fila);
        });
        actualizarPaginacion(paginacion);
        actualizarBotonTodo();
    }

    function actualizarPaginacion(paginacion){
        if(!paginacion || paginacion.total_paginas <= 1){
            $('#paginacionRespuestas').hide();
            return;
        }
        paginaActual = Number(paginacion.pagina);
        $('#paginacionRespuestas').show();
        $('#textoPaginacionRespuestas').text('Pagina ' + paginaActual + ' de ' + paginacion.total_paginas);
        $('#btnPaginaAnterior').prop('disabled', paginaActual <= 1);
        $('#btnPaginaSiguiente').prop('disabled', paginaActual >= paginacion.total_paginas);
    }

    var estadosPedido = ['nuevo', 'pagado', 'preparando', 'etiqueta_generada', 'enviado', 'en_transito', 'entregado'];
    var nombresEstados = {
        nuevo: 'Nuevo',
        pagado: 'Pagado',
        preparando: 'Preparando',
        etiqueta_generada: 'Etiqueta generada',
        enviado: 'Enviado',
        en_transito: 'En tránsito',
        entregado: 'Entregado'
    };

    function normalizarEstado(estado){
        return estadosPedido.indexOf(estado) !== -1 ? estado : 'nuevo';
    }

    function nombreEstado(estado){
        return nombresEstados[normalizarEstado(estado)];
    }

    function siguienteEstado(estado){
        var indice = estadosPedido.indexOf(normalizarEstado(estado));
        return estadosPedido[(indice + 1) % estadosPedido.length];
    }

    function crearMensajeWhatsapp(item){
        var nombre = (item.nombre || '').toString().trim() || 'cliente';
        var fecha = formatearFechaMensaje(item.fecha_envio);
        var courier = obtenerCourier(item.agencia);
        var agencia = (item.direccion || '').toString().trim() || '-';
        var dniCoincidencia = (item.mensaje || '').toString().match(/DNI(?:\/CE)?\s*:\s*([^\n]+)/i);
        var dni = dniCoincidencia ? dniCoincidencia[1].trim() : '';
        var estado = nombreEstado(item.estado);

        return 'Hola *' + nombre + '*!\n\n' +
            'Tu envio esta *' + estado + '*\n\n' +
            '\u25A3 *Fecha:* ' + fecha + '\n\n' +
            '\u279C *Courier:* ' + courier + '\n\n' +
            '\u2302 *Agencia:* ' + agencia + (dni ? ' (DNI: ' + dni + ')' : '') + '\n\n' +
            'Gracias por tu compra!';
    }

    function obtenerCourier(agencia){
        var valor = (agencia || '').toString().trim().toUpperCase();
        var couriers = {
            'RETIRO EN AGENCIA SHALOM': 'Shalom',
            'RETIRO EN AGENCIA OLVA COURIER': 'Olva Courier',
            'RETIRO EN AGENCIA MARVISUR': 'Marvisur',
            'RETIRO EN AGENCIA DINSIDES': 'Dinsides',
            'DELIVERY (SOLO LIMA)': 'Delivery Lima',
            'DELIVERY (SOLO TRUJILLO)': 'Delivery Trujillo',
            'RETIRO EN TIENDA': 'Tienda',
            'ENCOMIENDA': 'Encomienda'
        };
        return couriers[valor] || (agencia || 'Shalom');
    }

    function formatearFechaMensaje(fecha){
        var valor = (fecha || '').toString().trim();
        if(!/^\d{4}-\d{2}-\d{2}$/.test(valor)) return valor || '-';
        var partes = valor.split('-');
        var fechaLocal = new Date(Number(partes[0]), Number(partes[1]) - 1, Number(partes[2]));
        var dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
        return dias[fechaLocal.getDay()] + ' ' + partes[2] + '/' + partes[1];
    }

    function actualizarBotonTodo(){
        var filas = $('.seleccionar-fila');
        var todasMarcadas = filas.length > 0 && filas.filter(':checked').length === filas.length;
        $('#btnTodo i').toggleClass('fa-check-square-o', !todasMarcadas).toggleClass('fa-square-o', todasMarcadas);
        $('#btnTodo span').text(todasMarcadas ? 'Desmarcar' : 'Todo');
    }

    function formatearFechaEnvio(fechaEnvio, fechaRegistro, horaRegistro){
        if(fechaEnvio && fechaEnvio.toString().trim()){
            var valor = fechaEnvio.toString().trim();
            if(/^\d{4}-\d{2}-\d{2}$/.test(valor)){
                var partes = valor.split('-');
                return partes[2] + '/' + partes[1] + '/' + partes[0];
            }
            return valor;
        }
        return (fechaRegistro !== '-' ? fechaRegistro + (horaRegistro ? ' ' + horaRegistro : '') : '-');
    }

    function escaparHtml(texto){
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(texto || ''));
        return div.innerHTML;
    }

    $('#filtroEstado').on('change', function(){
        paginaActual = 1;
        cargarRespuestas();
    });

    $('#filtroAgencia').on('change', function(){
        paginaActual = 1;
        cargarRespuestas();
    });

    $('#filtroFechaInicio, #filtroFechaFin').on('change', function(){
        paginaActual = 1;
        cargarRespuestas();
    });

    var temporizadorBusqueda;
    $('#buscadorRespuestas').on('input', function(){
        clearTimeout(temporizadorBusqueda);
        temporizadorBusqueda = setTimeout(function(){ paginaActual = 1; cargarRespuestas(); }, 400);
    });

    $('#btnActualizar').on('click', function(){
        paginaActual = 1;
        cargarRespuestas();
    });

    $('#btnPaginaAnterior').on('click', function(){
        if(paginaActual > 1){
            paginaActual--;
            cargarRespuestas();
        }
    });

    $('#btnPaginaSiguiente').on('click', function(){
        paginaActual++;
        cargarRespuestas();
    });

    $('#selectorEtiquetas').on('change', function(){
        var selector = this;
        var formato = selector.value;
        if(formato){
            imprimirSeleccionados(formato);
            setTimeout(function(){
                selector.value = '';
                selector.blur();
            }, 0);
        }
    });

    $('#selectorReporteExcel').on('change', function(){
        descargarReporteSeleccionado($(this).val());
        $(this).val('');
    });

    function descargarReporteSeleccionado(tipoReporte){
        if(!tipoReporte) return;
        var seleccionados = $('.seleccionar-fila:checked');
        if(seleccionados.length === 0){
            Swal.fire('Atencion', 'Selecciona al menos un envio para exportar', 'info');
            return;
        }
        var envios = [];
        seleccionados.each(function(){
            var envio = registrosPorId[$(this).val()];
            if(envio) envios.push(envio);
        });
        if(tipoReporte === 'shalom'){
            envios = envios.filter(function(item){
                var agencia = (item.agencia || 'SHALOM').toString().trim().toUpperCase();
                return agencia === 'SHALOM' || agencia === 'RETIRO EN AGENCIA SHALOM';
            });
            if(envios.length === 0){
                Swal.fire('Atencion', 'Entre los envios seleccionados no hay registros de Shalom', 'info');
                return;
            }
        }
        exportarExcel(envios, tipoReporte);
    }

    function exportarExcel(envios, tipoReporte){
        var esReporteShalom = tipoReporte === 'shalom';
        var encabezados = esReporteShalom
            ? ['DESTINATARIO (DOC)', 'TELF. DESTINATARIO', 'CONTACTO (DOC)', 'TELF. CONTACTO', 'NRO GRR', 'ORIGEN', 'DESTINO', 'MERCADERIA', 'ALTO', 'ANCHO', 'LARGO', 'PESO', 'CANTIDAD']
            : ['Codigo', 'Nombre', 'Telefono', 'Fecha de envio', 'Courier', 'Agencia / direccion', 'DNI/CE', 'Estado'];
        var filas = envios.map(function(item){
            var dniCoincidencia = (item.mensaje || '').toString().match(/DNI(?:\/CE)?\s*:\s*([^\n]+)/i);
            var dni = dniCoincidencia ? dniCoincidencia[1].trim() : '';
            if(esReporteShalom){
                return [
                    item.nombre || '',
                    item.telefono || '',
                    '',
                    '',
                    '',
                    '',
                    item.direccion || '',
                    '',
                    item.alto !== undefined && item.alto !== '' ? item.alto : 0,
                    item.ancho !== undefined && item.ancho !== '' ? item.ancho : 0,
                    item.largo !== undefined && item.largo !== '' ? item.largo : 0,
                    item.peso !== undefined && item.peso !== '' ? item.peso : 0,
                    item.cantidad !== undefined && item.cantidad !== '' ? item.cantidad : 1
                ];
            }
            return [
                item.codigo || '',
                item.nombre || '',
                item.telefono || '',
                formatearFechaEtiqueta(item.fecha_envio || item.fecha),
                obtenerCourier(item.agencia),
                item.direccion || '',
                dni,
                nombreEstado(item.estado)
            ];
        });
        var contenido = [encabezados].concat(filas).map(function(fila){
            return fila.map(function(valor){
                return '"' + (valor || '').toString().replace(/"/g, '""').replace(/\r?\n/g, ' ') + '"';
            }).join(';');
        }).join('\r\n');
        var archivo = new Blob(['\uFEFF' + contenido], {type: 'text/csv;charset=utf-8;'});
        var enlace = document.createElement('a');
        enlace.href = URL.createObjectURL(archivo);
        enlace.download = (esReporteShalom ? 'reporte-shalom-' : 'reporte-general-') + convertirFechaInput(new Date()) + '.csv';
        document.body.appendChild(enlace);
        enlace.click();
        document.body.removeChild(enlace);
        URL.revokeObjectURL(enlace.href);
    }

    $(window).on('focus pageshow', function(){
        $('#selectorEtiquetas').val('').prop('disabled', false).blur();
    });

    function imprimirSeleccionados(formato){
        var seleccionados = $('.seleccionar-fila:checked');
        if(seleccionados.length === 0){
            Swal.fire('Atencion', 'Selecciona al menos un envio para imprimir', 'info');
            return;
        }
        var envios = [];
        seleccionados.each(function(){
            var envio = registrosPorId[$(this).val()];
            if(envio) envios.push(envio);
        });
        imprimirEtiquetas(envios, formato);
    }

    function imprimirEtiquetas(envios, formato){
        var remitente = escaparHtmlTexto((window.nombreEmprendimientoEtiqueta || '').toString().trim() || 'Emprendimiento');
        var etiquetas = envios.map(function(item){
            var dniCoincidencia = (item.mensaje || '').toString().match(/DNI(?:\/CE)?\s*:\s*([^\n]+)/i);
            var dni = dniCoincidencia ? dniCoincidencia[1].trim() : '';
            var fecha = formatearFechaEtiqueta(item.fecha_envio || item.fecha);
            var courier = escaparHtmlTexto(obtenerCourier(item.agencia));
            var nombre = escaparHtmlTexto(item.nombre || '-');
            var telefono = escaparHtmlTexto(item.telefono || '-');
            var direccion = escaparHtmlTexto(item.direccion || '-');
            var documento = escaparHtmlTexto(dni || '-');
            return '<article class="etiqueta-envio">' +
                '<div class="etiqueta-linea etiqueta-remitente"><span>REMITENTE</span><strong>' + remitente + '</strong></div>' +
                '<div class="etiqueta-seccion">DESTINATARIO:</div>' +
                '<div class="etiqueta-nombre">' + nombre + '</div>' +
                '<div class="etiqueta-datos"><strong>N°DOC: ' + documento + '</strong><strong>Cel: ' + telefono + '</strong></div>' +
                '<div class="etiqueta-seccion">DESTINO:</div>' +
                '<div class="etiqueta-direccion">' + direccion + '</div>' +
                '<div class="etiqueta-pie"><strong>' + courier.toUpperCase() + '</strong><strong>' + fecha + '</strong></div>' +
                '</article>';
        }).join('');
        if(ventanaEtiquetas && !ventanaEtiquetas.closed){
            ventanaEtiquetas.focus();
        }else{
            ventanaEtiquetas = window.open('', 'ventanaEtiquetasEnvios');
        }
        if(!ventanaEtiquetas){
            Swal.fire('Atencion', 'El navegador bloqueo la ventana de impresion. Permite las ventanas emergentes para este sitio.', 'warning');
            return;
        }
        var ventana = ventanaEtiquetas;
        ventana.document.open();
        ventana.document.write('<!doctype html><html><head><meta charset="UTF-8"><title>Etiquetas de envio</title><style>' + estilosEtiquetas(formato) + '</style></head><body>' + etiquetas + '<script>window.onload=function(){window.print();};<\/script></body></html>');
        ventana.document.close();
    }

    function estilosEtiquetas(formato){
        var tresColumnas = formato === 'tres-columnas';
        var grandes = formato === 'grandes';
        var ancho = grandes ? '100%' : (tresColumnas ? '31.8%' : '48%');
        var alto = grandes ? '82mm' : (tresColumnas ? '62mm' : '82mm');
        var margen = grandes ? '0 0 5mm' : (tresColumnas ? '0 .75% 4mm' : '0 1% 5mm');
        var padding = tresColumnas ? '3mm 2.5mm 2mm' : '5mm 4mm 3mm';
        var tamanoRemitente = tresColumnas ? '8px' : '12px';
        var tamanoMarca = tresColumnas ? '11px' : '17px';
        var tamanoSeccion = tresColumnas ? '7px' : '11px';
        var tamanoNombre = tresColumnas ? '13px' : '20px';
        var tamanoDatos = tresColumnas ? '10px' : '17px';
        var tamanoDireccion = tresColumnas ? '9px' : '15px';
        var tamanoPie = tresColumnas ? '10px' : '16px';
        return '@page{size:A4;margin:10mm}*{box-sizing:border-box}body{margin:0;font-family:Arial,sans-serif;color:#111;display:flex;flex-wrap:wrap;align-content:flex-start}.etiqueta-envio{width:' + ancho + ';min-height:' + alto + ';margin:' + margen + ';padding:' + padding + ';border:1px solid #222;border-radius:3mm;page-break-inside:avoid}.etiqueta-linea{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #777;padding-bottom:2mm}.etiqueta-remitente{font-size:' + tamanoRemitente + ';color:#555}.etiqueta-remitente strong{font-size:' + tamanoMarca + ';color:#111}.etiqueta-seccion{margin-top:3mm;font-size:' + tamanoSeccion + ';font-weight:bold}.etiqueta-nombre{margin-top:1mm;font-size:' + tamanoNombre + ';font-weight:bold;text-transform:uppercase}.etiqueta-datos{display:flex;gap:' + (tresColumnas ? '4mm' : '28mm') + ';margin-top:1mm;font-size:' + tamanoDatos + '}.etiqueta-direccion{margin-top:1mm;font-size:' + tamanoDireccion + ';line-height:1.25}.etiqueta-pie{display:flex;justify-content:space-between;align-items:center;margin-top:4mm;padding-top:2mm;border-top:1px solid #777;font-size:' + tamanoPie + '}.etiqueta-pie strong:first-child{background:#eee;padding:1mm 2mm}@media print{.etiqueta-envio{break-inside:avoid}}';
    }

    function formatearFechaEtiqueta(fecha){
        var valor = (fecha || '').toString().trim().split(' ')[0];
        if(!/^\d{4}-\d{2}-\d{2}$/.test(valor)) return valor || '-';
        var partes = valor.split('-');
        var fechaLocal = new Date(Number(partes[0]), Number(partes[1]) - 1, Number(partes[2]));
        var dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
        return dias[fechaLocal.getDay()] + ' ' + partes[2] + '/' + partes[1];
    }

    function escaparHtmlTexto(texto){
        return $('<div>').text(texto || '').html();
    }

    $('#btnTodo').on('click', function(){
        var filas = $('.seleccionar-fila');
        var marcarTodas = filas.length > 0 && filas.filter(':checked').length < filas.length;
        filas.prop('checked', marcarTodas);
        $('#seleccionarTodos').prop('checked', marcarTodas);
        actualizarBotonTodo();
    });

    $('#seleccionarTodos').on('change', function(){
        $('.seleccionar-fila').prop('checked', $(this).prop('checked'));
    });

    $(document).on('change', '.seleccionar-fila', function(){
        var filas = $('.seleccionar-fila');
        $('#seleccionarTodos').prop('checked', filas.length > 0 && filas.filter(':checked').length === filas.length);
        actualizarBotonTodo();
    });

    $(document).on('click', '.btn-cambiar-estado', function(){
        var id = $(this).data('id');
        var estadoActual = $(this).data('estado');
        var nuevoEstado = siguienteEstado(estadoActual);
        $.ajax({
            url: 'ajax/envios.ajax.php',
            method: 'POST',
            data: { cambiarEstadoAjax: 1, id: id, nuevoEstado: nuevoEstado },
            dataType: 'json',
            success: function(respuesta){
                if(respuesta.estado === 'ok'){
                    cargarRespuestas();
                } else {
                    Swal.fire('Error', respuesta.mensaje, 'error');
                }
            }
        });
    });

    $(document).on('click', '.btn-eliminar-fila', function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Eliminar respuesta?',
            text: 'Esta accion no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e36b77',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function(resultado){
            if(resultado.isConfirmed){
                $.ajax({
                    url: 'ajax/envios.ajax.php',
                    method: 'POST',
                    data: { eliminarRespuestaAjax: 1, id: id },
                    dataType: 'json',
                    success: function(respuesta){
                        if(respuesta.estado === 'ok'){
                            cargarRespuestas();
                        } else {
                            Swal.fire('Error', respuesta.mensaje, 'error');
                        }
                    }
                });
            }
        });
    });

    $('#btnMarcarCompletado').on('click', function(){
        var seleccionados = $('.seleccionar-fila:checked');
        if(seleccionados.length === 0){
            Swal.fire('Atencion', 'Selecciona al menos una respuesta', 'info');
            return;
        }
        var ids = [];
        seleccionados.each(function(){ ids.push($(this).val()); });
        var completados = 0;
        var total = ids.length;
        ids.forEach(function(id){
            $.ajax({
                url: 'ajax/envios.ajax.php',
                method: 'POST',
                data: { cambiarEstadoAjax: 1, id: id, nuevoEstado: siguienteEstado(registrosPorId[id] ? registrosPorId[id].estado : 'nuevo') },
                dataType: 'json',
                success: function(){
                    completados++;
                    if(completados === total) cargarRespuestas();
                }
            });
        });
    });

    $('#btnEliminar').on('click', function(){
        var seleccionados = $('.seleccionar-fila:checked');
        if(seleccionados.length === 0){
            Swal.fire('Atencion', 'Selecciona al menos una respuesta', 'info');
            return;
        }
        Swal.fire({
            title: 'Eliminar respuestas?',
            text: 'Se eliminaran ' + seleccionados.length + ' respuestas',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e36b77',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function(resultado){
            if(resultado.isConfirmed){
                var ids = [];
                seleccionados.each(function(){ ids.push($(this).val()); });
                var eliminados = 0;
                var total = ids.length;
                ids.forEach(function(id){
                    $.ajax({
                        url: 'ajax/envios.ajax.php',
                        method: 'POST',
                        data: { eliminarRespuestaAjax: 1, id: id },
                        dataType: 'json',
                        success: function(){
                            eliminados++;
                            if(eliminados === total) cargarRespuestas();
                        }
                    });
                });
            }
        });
    });
});
