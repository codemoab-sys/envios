$(document).on("submit", "#formPasswordConfiguracion", function(event){

    event.preventDefault();

    var formulario = this;
    var boton = $(formulario).find("button[type='submit']");
    var password = $(formulario).find("[name='nuevaPassword']").val().trim();

    if(password.length < 6){
        Swal.fire({icon: "error", title: "La contraseña debe tener al menos 6 caracteres", confirmButtonText: "Cerrar"});
        return;
    }

    boton.prop("disabled", true).html("Actualizando...");

    $.ajax({
        url: "ajax/configuracion.ajax.php",
        method: "POST",
        dataType: "json",
        data: {actualizarPasswordAjax: 1, nuevaPassword: password},
        success: function(respuesta){
            if(respuesta.estado == "ok"){
                formulario.reset();
                Swal.fire({icon: "success", title: respuesta.mensaje, confirmButtonText: "Cerrar"});
            }else{
                Swal.fire({icon: "error", title: respuesta.mensaje, confirmButtonText: "Cerrar"});
            }
        },
        error: function(){
            Swal.fire({icon: "error", title: "No se pudo actualizar la contraseña", confirmButtonText: "Cerrar"});
        },
        complete: function(){
            boton.prop("disabled", false).html("Actualizar");
        }
    });

});