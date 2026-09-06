/*=====================================
MODO CLARO / OSCURO
=====================================*/

document.addEventListener('DOMContentLoaded', function() {
    
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    const icon = themeToggle ? themeToggle.querySelector('i') : null;
    
    // Cargar tema guardado
    const modalApariencia = document.getElementById('modalApariencia');
    const superficieTema = modalApariencia || document.querySelector('[data-theme-current]');
    const temaBaseDatos = superficieTema ? superficieTema.getAttribute('data-theme-current') : '';
    const colorBaseDatos = superficieTema ? superficieTema.getAttribute('data-color-current') : '';
    const primarioBaseDatos = modalApariencia ? modalApariencia.getAttribute('data-primary-current') : '';
    const secundarioBaseDatos = modalApariencia ? modalApariencia.getAttribute('data-secondary-current') : '';
    const savedTheme = temaBaseDatos || localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateIcon(savedTheme);
    aplicarColorCabecera(colorBaseDatos || localStorage.getItem('headerColor') || '#dd4b39');
    aplicarColorBotones(primarioBaseDatos || localStorage.getItem('primaryButtonColor') || '#3b82f6', secundarioBaseDatos || localStorage.getItem('secondaryButtonColor') || '#202c42');

    document.querySelectorAll('[data-theme-choice]').forEach(function(button) {
        button.addEventListener('click', function() {
            const newTheme = button.getAttribute('data-theme-choice');
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
            actualizarTemaActivo(newTheme);
        });
    });

    const colorCabecera = document.getElementById('colorCabecera');
    const codigoColorCabecera = document.getElementById('codigoColorCabecera');
    if(colorCabecera){
        colorCabecera.value = colorBaseDatos || colorCabecera.value || localStorage.getItem('headerColor') || '#dd4b39';
        actualizarCodigoColor(colorCabecera.value);
        colorCabecera.addEventListener('input', function(){
            aplicarColorCabecera(colorCabecera.value);
            localStorage.setItem('headerColor', colorCabecera.value);
            actualizarCodigoColor(colorCabecera.value);
        });
    }
    configurarColor('colorBotonPrimario', 'codigoColorBotonPrimario', '--button-primary-color', 'primaryButtonColor');
    configurarColor('colorBotonSecundario', 'codigoColorBotonSecundario', '--button-secondary-color', 'secondaryButtonColor');

    document.querySelectorAll('.apariencia-paleta').forEach(function(paleta){
        paleta.addEventListener('click', function(){
            var temaPaleta = paleta.getAttribute('data-theme-palette');
            if(temaPaleta) window.cambiarTemaApariencia(temaPaleta);
            aplicarColorSeleccionado('colorCabecera', 'codigoColorCabecera', paleta.getAttribute('data-header'));
            aplicarColorSeleccionado('colorBotonPrimario', 'codigoColorBotonPrimario', paleta.getAttribute('data-primary'));
            aplicarColorSeleccionado('colorBotonSecundario', 'codigoColorBotonSecundario', paleta.getAttribute('data-secondary'));
            aplicarColorCabecera(paleta.getAttribute('data-header'));
            aplicarColorBotones(paleta.getAttribute('data-primary'), paleta.getAttribute('data-secondary'));
        });
    });
    if(codigoColorCabecera){
        codigoColorCabecera.addEventListener('input', function(){
            var valor = normalizarColor(codigoColorCabecera.value);
            if(valor){
                colorCabecera.value = valor;
                aplicarColorCabecera(valor);
                localStorage.setItem('headerColor', valor);
            }
        });
        codigoColorCabecera.addEventListener('blur', function(){
            var valor = normalizarColor(codigoColorCabecera.value) || '#dd4b39';
            codigoColorCabecera.value = valor.toUpperCase();
            colorCabecera.value = valor;
            aplicarColorCabecera(valor);
        });
    }
    actualizarTemaActivo(savedTheme);

    const guardarApariencia = document.getElementById('guardarApariencia');
    if(guardarApariencia){
        guardarApariencia.addEventListener('click', function(){
            guardarApariencia.disabled = true;
            $.ajax({
                url: 'ajax/configuracion.ajax.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    guardarAparienciaAjax: 1,
                    tema: html.getAttribute('data-theme'),
                    color_cabecera: colorCabecera ? colorCabecera.value : '#dd4b39'
                    ,color_boton_primario: obtenerColor('colorBotonPrimario', primarioBaseDatos || '#3b82f6')
                    ,color_boton_secundario: obtenerColor('colorBotonSecundario', secundarioBaseDatos || '#202c42')
                },
                success: function(respuesta){
                    if(respuesta.estado === 'ok'){
                        localStorage.setItem('theme', html.getAttribute('data-theme'));
                        localStorage.setItem('headerColor', colorCabecera ? colorCabecera.value : '#dd4b39');
                        $('#modalApariencia').modal('hide');
                        Swal.fire({icon: 'success', title: 'Apariencia guardada', timer: 1400, showConfirmButton: false});
                    }else{
                        Swal.fire('Error', respuesta.mensaje, 'error');
                    }
                },
                error: function(){
                    Swal.fire('Error', 'No se pudo guardar la apariencia', 'error');
                },
                complete: function(){
                    guardarApariencia.disabled = false;
                }
            });
        });
    }
    
    // Toggle tema
    if(themeToggle){
        themeToggle.addEventListener('click', function() {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            window.cambiarTemaApariencia(newTheme);
        });
    }
    
    // Actualizar icono
    function updateIcon(theme) {
        if(!icon || !themeToggle) return;
        if (theme === 'dark') {
            icon.className = 'fa fa-sun-o';
            themeToggle.title = 'Modo claro';
        } else {
            icon.className = 'fa fa-moon-o';
            themeToggle.title = 'Modo oscuro';
        }
    }

    function aplicarColorCabecera(color){
        document.documentElement.style.setProperty('--header-color', color);
        document.documentElement.style.setProperty('--header-text-color', colorContraste(color));
    }

    function aplicarColorBotones(primario, secundario){
        document.documentElement.style.setProperty('--button-primary-color', primario);
        document.documentElement.style.setProperty('--button-secondary-color', secundario);
        document.documentElement.style.setProperty('--button-primary-text', colorContraste(primario));
        document.documentElement.style.setProperty('--button-secondary-text', colorContraste(secundario));
    }

    function configurarColor(colorId, codigoId, variable, storageKey){
        var selector = document.getElementById(colorId);
        var codigo = document.getElementById(codigoId);
        if(!selector || !codigo) return;
        codigo.value = selector.value.toUpperCase();
        selector.addEventListener('input', function(){
            codigo.value = selector.value.toUpperCase();
            document.documentElement.style.setProperty(variable, selector.value);
            localStorage.setItem(storageKey, selector.value);
        });
        codigo.addEventListener('input', function(){
            var valor = normalizarColor(codigo.value);
            if(valor){
                selector.value = valor;
                document.documentElement.style.setProperty(variable, valor);
                if(variable === '--button-primary-color') document.documentElement.style.setProperty('--button-primary-text', colorContraste(valor));
                if(variable === '--button-secondary-color') document.documentElement.style.setProperty('--button-secondary-text', colorContraste(valor));
                localStorage.setItem(storageKey, valor);
            }
        });
        codigo.addEventListener('blur', function(){
            codigo.value = normalizarColor(codigo.value || selector.value).toUpperCase() || selector.value.toUpperCase();
        });
    }

    function obtenerColor(id, defecto){
        var elemento = document.getElementById(id);
        return elemento && normalizarColor(elemento.value) ? normalizarColor(elemento.value) : defecto;
    }

    function aplicarColorSeleccionado(selectorId, codigoId, color){
        var selector = document.getElementById(selectorId);
        var codigo = document.getElementById(codigoId);
        if(selector) selector.value = color;
        if(codigo) codigo.value = color.toUpperCase();
    }

    function actualizarCodigoColor(color){
        if(codigoColorCabecera) codigoColorCabecera.value = color.toUpperCase();
    }

    function normalizarColor(color){
        var valor = (color || '').trim();
        if(!/^#[0-9a-f]{6}$/i.test(valor)) return '';
        return valor.toLowerCase();
    }

    function colorContraste(color){
        var valor = normalizarColor(color).substring(1);
        var rojo = parseInt(valor.substring(0, 2), 16);
        var verde = parseInt(valor.substring(2, 4), 16);
        var azul = parseInt(valor.substring(4, 6), 16);
        return (rojo * 299 + verde * 587 + azul * 114) > 150000 ? '#172033' : '#ffffff';
    }

    function actualizarTemaActivo(theme){
        document.querySelectorAll('[data-theme-choice]').forEach(function(button){
            button.classList.toggle('active', button.getAttribute('data-theme-choice') === theme);
        });
    }

    window.cambiarTemaApariencia = function(theme){
        const nuevoTema = theme === 'dark' ? 'dark' : 'light';
        html.setAttribute('data-theme', nuevoTema);
        actualizarTemaActivo(nuevoTema);
        updateIcon(nuevoTema);
        localStorage.setItem('theme', nuevoTema);
    };

    document.addEventListener('click', function(event){
        const botonTema = event.target.closest('[data-theme-choice]');
        if(botonTema){
            event.preventDefault();
            window.cambiarTemaApariencia(botonTema.getAttribute('data-theme-choice'));
        }
    });
    
});
