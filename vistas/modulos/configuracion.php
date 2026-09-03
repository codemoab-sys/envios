<?php

$configuracion = ControladorConfiguracion::ctrMostrarConfiguracion();

$razonSocial = htmlspecialchars($configuracion["razon_social"] ?? "", ENT_QUOTES, "UTF-8");
$ruc = htmlspecialchars($configuracion["ruc"] ?? "", ENT_QUOTES, "UTF-8");
$direccion = htmlspecialchars($configuracion["direccion"] ?? "", ENT_QUOTES, "UTF-8");
$telefono = htmlspecialchars($configuracion["telefono"] ?? "", ENT_QUOTES, "UTF-8");
$correo = htmlspecialchars($configuracion["correo"] ?? "", ENT_QUOTES, "UTF-8");

ControladorConfiguracion::ctrGuardarConfiguracion();

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Configuración</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> inicio</a></li>
            <li class="active">configuración</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Datos de la empresa</h3>
            </div>
            <form method="post">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="razonSocial">Razón social *</label>
                            <input type="text" class="form-control" id="razonSocial" name="razonSocial" value="<?php echo $razonSocial; ?>" required maxlength="150">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ruc">RUC *</label>
                            <input type="text" class="form-control" id="ruc" name="ruc" value="<?php echo $ruc; ?>" required maxlength="11" pattern="[0-9]{11}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>" maxlength="255">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>" maxlength="30">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="correo">Correo electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo; ?>" maxlength="150">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="guardarConfiguracion" value="1" class="btn btn-primary">
                        <i class="fa fa-save"></i> Guardar configuración
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
