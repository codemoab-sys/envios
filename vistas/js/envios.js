$(document).ready(function(){
    var fechasIniciales = obtenerFechasPorDefecto();
    $('#filtroFechaInicio').val(fechasIniciales.inicio);
    $('#filtroFechaFin').val(fechasIniciales.fin);
    cargarRespuestas();

    function cargarRespuestas(){
        var estado = $('#filtroEstado').val();
        var agencia = $('#filtroAgencia').val();
        var fechaInicio = $('#filtroFechaInicio').val();
        var fechaFin = $('#filtroFechaFin').val();
        var busqueda = $('#buscadorRespuestas').val();
        if(!fechaInicio && !fechaFin){
            var fechasPorDefecto = obtenerFechasPorDefecto();
            fechaInicio = fechasPorDefecto.inicio;
            fechaFin = fechasPorDefecto.fin;
        }
        $.ajax({
            url: 'ajax/envios.ajax.php',
            method: 'POST',
            data: { listarRespuestasAjax: 1, estado: estado, agencia: agencia, fecha_inicio: fechaInicio, fecha_fin: fechaFin, busqueda: busqueda },
            dataType: 'json',
            beforeSend: function(){
                $('#tablaRespuestas').html('<div class="envios-loading"><i class="fa fa-spinner fa-spin"></i> Cargando...</div>');
                $('#vacioRespuestas').hide();
                $('#contenedorTabla').show();
            },
            success: function(respuesta){
                if(respuesta.estado === 'ok'){
                    renderizarTabla(respuesta.datos);
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

    function renderizarTabla(datos){
        var contenedor = $('#tablaRespuestas');
        contenedor.empty();
        if(datos.length === 0){
            $('#contenedorTabla').hide();
            $('#vacioRespuestas').show();
            $('#contadorRespuestasBoard').text('0 registros');
            return;
        }
        $('#contenedorTabla').show();
        $('#vacioRespuestas').hide();
        $('#contadorRespuestasBoard').text(datos.length + ' registros');
        $.each(datos, function(i, item){
            var fechaRegistro = item.fecha ? item.fecha.split(' ')[0].split('-').reverse().join('/') : '-';
            var horaRegistro = item.fecha ? item.fecha.split(' ')[1] : '';
            var fechaEnvioTexto = formatearFechaEnvio(item.fecha_envio, fechaRegistro, horaRegistro);
            var estadoClase = item.estado === 'completado' ? 'envios-status-completado' : 'envios-status-pendiente';
            var estadoTexto = item.estado === 'completado' ? 'completado' : 'pendiente';
            var telefono = escaparHtml(item.telefono || '-');
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
                            '<span class="envios-status ' + estadoClase + '">' + estadoTexto + '</span>' +
                        '</div>' +
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
        actualizarBotonTodo();
    }

    function crearMensajeWhatsapp(item){
        var nombre = (item.nombre || '').toString().trim() || 'cliente';
        var fecha = formatearFechaMensaje(item.fecha_envio);
        var courier = obtenerCourier(item.agencia);
        var agencia = (item.direccion || '').toString().trim() || '-';
        var dniCoincidencia = (item.mensaje || '').toString().match(/DNI(?:\/CE)?\s*:\s*([^\n]+)/i);
        var dni = dniCoincidencia ? dniCoincidencia[1].trim() : '';
        var estado = item.estado === 'completado' ? 'Completado' : 'Programado';

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
        cargarRespuestas();
    });

    $('#filtroAgencia').on('change', function(){
        cargarRespuestas();
    });

    $('#filtroFechaInicio, #filtroFechaFin').on('change', function(){
        cargarRespuestas();
    });

    var temporizadorBusqueda;
    $('#buscadorRespuestas').on('input', function(){
        clearTimeout(temporizadorBusqueda);
        temporizadorBusqueda = setTimeout(function(){ cargarRespuestas(); }, 400);
    });

    $('#btnActualizar').on('click', function(){
        cargarRespuestas();
    });

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
        var nuevoEstado = estadoActual === 'pendiente' ? 'completado' : 'pendiente';
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
                data: { cambiarEstadoAjax: 1, id: id, nuevoEstado: 'completado' },
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
