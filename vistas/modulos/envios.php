    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                administrar envios
            </h1>
            <ol class="breadcrumb">
                <li><a href="inicio"><i class="fa fa-dashboard"></i> inicio</a></li>
                <li class="active">administrar envios</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarEnvio">
                        agregar envio
                    </button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th style="width:10px">#</th>
                                <th>destinatario</th>
                                <th>direccion</th>
                                <th>estado</th>
                                <th>fecha</th>
                                <th>acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Cliente ejemplo</td>
                                <td>Direccion ejemplo</td>
                                <td><span class="label label-success">En camino</span></td>
                                <td><?php echo date("Y-m-d"); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
