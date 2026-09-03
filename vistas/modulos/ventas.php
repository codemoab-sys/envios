    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                administrar ventas

            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                <li class="active">administrar ventas</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">


                    <a href="crear-venta">

                        <button type="button" class="btn btn-primary">
                            agregar venta
                        </button>

                    </a>

                    <div id="reportrange" class="btn btn-default pull-right"
                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 30%">
                        &nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>









                </div>
                <div class="box-body">


                    <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                        <thead>
                            <tr>
                                <th># </th>
                                <th>codigo factura</th>
                                <th>cliente</th>
                                <th>vendedor</th>
                                <th>tipo de pago</th>
                                <th>neto</th>
                                <th>fecha</th>
                                <th>acciones</th>


                            </tr>



                        </thead>

                        <tbody>

                            <?php 

                                if(isset($_GET["fechaInicial"])){

                                    $fechaInicial=$_GET["fechaInicial"];
                                    $fechaFinal=$_GET["fechaFinal"];



                                }else{


                                    $fechaInicial=null;
                                                            
                                                            
                                    $fechaFinal=null;


                                }

                                $respuesta=ControladorVentas::ctrRangoFechasVentas($fechaInicial,$fechaFinal);



                        



                            //$Ventas=ControladorVentas::ctrMostrarVentas($item,$valor);


                            foreach ($respuesta as $key => $value) {

                                echo '

                                   <tr>

                                <td>'.($key+1).'</td>
                                <td>'.$value["codigo"].'</td>';

                                $itemCliente="id";
                                $valorCliente=$value["id_cliente"];

                                $respuestaCliente=ControladorClientes::ctrMostrarClientes($itemCliente,$valorCliente);


                               echo' <td>'.$respuestaCliente["nombre"].'</td>';

                                $itemUsuario="id";
                                $valorUsuario=$value["id_vendedor"];

                                $respuestaUsuarios=ControladorUsuarios::ctrMostrarUsuarios($itemUsuario,$valorUsuario);


                                echo'<td>'.$respuestaUsuarios["nombre"].'</td>
                                <td>'.$value["metodo_pago"].'</td>
                                <td>'.$value["neto"].'</td>                                                          
                                <td>'.$value["fecha"].'</td>';

                     



                                

                                echo '<td>

                                    <div class="btn-group">

                                        <button class="btn btn-info btnImprimirFactura" codigoVenta="'.$value["codigo"].'" idVentas="'.$value["id"].'">

                                            <i class="fa fa-print"></i>
                                        </button>

                                        <button class="btn btn-warning btnEditarVentas" idVentas="'.$value["id"].'">

                                            <i class="fa fa-pencil"></i>
                                        </button>


                                        <button class="btn btn-danger btnEliminarVentas" idVentas="'.$value["id"].'">


                                            <i class="fa fa-times"></i>
                                        </button>


                                    </div>

                                </td>

                            </tr> ';
                                
                                                                                                                                                                                   

                            }
                        
                                                                              
                        ?>


                        </tbody>

                        <?php

      $eliminarVenta = new ControladorVentas();
      $eliminarVenta -> ctrEliminarVenta();

      ?>




                    </table>





                </div>

            </div>


        </section>

    </div>







    <!--=====================================
MODAL AGREGAR ClienteS
======================================-->
    <div id="modalAgregarCliente" class="modal fade" role="dialog">

        <div class="modal-dialog">

            <div class="modal-content">


                <form role="form" method="post" enctype="multipart/form-data">

                    <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->


                    <div class="modal-header" style="background:#3c8dbc; color:white">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h4 class="modal-title">Agregar Cliente</h4>

                    </div>

                    <!--=====================================
                    CUERPO DEL MODAL
                    ======================================-->

                    <div class="modal-body">
                        <div class="box-body">

                            <!-- ENTRADA PARA EL NOMBRE -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                    <input type="text" class="form-control input-lg" name="nuevoCliente"
                                        placeholder="Ingresar nombre" required>

                                </div>

                            </div>

                            <!-- ENTRADA PARA EL DOCUMENTO ID -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                                    <input type="text" min="0" class="form-control input-lg" name="nuevoDocumentoId"
                                        placeholder="Ingresar documento" required>

                                </div>

                            </div>

                            <!-- ENTRADA PARA EL EMAIL -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                                    <input type="email" class="form-control input-lg" name="nuevoEmail"
                                        placeholder="Ingresar email" required>

                                </div>

                            </div>


                            <!-- ENTRADA PARA EL TELÉFONO -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                    <input type="text" class="form-control input-lg" name="nuevoTelefono"
                                        placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'"
                                        data-mask required>

                                </div>

                            </div>


                            <!-- ENTRADA PARA LA DIRECCIÓN -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                    <input type="text" class="form-control input-lg" name="nuevaDireccion"
                                        placeholder="Ingresar dirección" required>

                                </div>

                            </div>

                            <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                    <input type="text" class="form-control input-lg" name="nuevaFechaNacimiento"
                                        placeholder="Ingresar fecha nacimiento" data-inputmask="'alias': 'yyyy/mm/dd'"
                                        data-mask required>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                        <button type="submit" class="btn btn-primary">Guardar Cliente</button>

                    </div>

                    <?php 

                 /*   $crearCliente=new ControladorClientes();
                    $crearCliente->ctrCrearCliente();*/
                    
                    
                    
                    ?>






                </form>

            </div>
        </div>
    </div>