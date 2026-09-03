<div class="content-wrapper">


    <section class="content-header">
        <h1>
            editar ventas

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

            <li class="active">crear ventas</li>
        </ol>
    </section>




    <section class="content">

        <div class="row">

            <div class="col-lg-5 col-xs-12">

                <div class="box box-success">

                    <div class="box-header with-border"></div>

                    <form role="form" method="post" class="formularioVenta">


                        <div class="box-body">

                            <div class="box">

                                <?php 

                            $item ="id";
                            $valor=$_GET["idVenta"];

                            $venta=ControladorVentas::ctrMostrarVentas($item,$valor);


                            $itemUsuario="id";
                            $valorUsuario=$venta["id_vendedor"];

                            $vendedor=ControladorUsuarios::ctrMostrarUsuarios($itemUsuario,$valorUsuario);



                            $itemCliente="id";
                            $valorCliente=$venta["id_cliente"];

                            $cliente=ControladorClientes::ctrMostrarClientes($itemCliente,$valorCliente);


                            $pordentajeImpuesto=$venta["impuesto"] * 100 / $venta["neto"];

                          
                            //var_dump($venta);



                            ?>





                                <!--=====================================
                            ENTRADA DEL VENDEDOR
                            ======================================-->


                                <div class="form-group">

                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                        <input type="text" class="form-control" id="nuevoVendedor" name="nuevoVendedor"
                                            value="<?php echo $vendedor["nombre"];  ?>" readonly>

                                        <input type="hidden" name="idVendedor" value="<?php echo $vendedor["id"];  ?>">

                                    </div>

                                </div>


                                <!--=====================================
                            ENTRADA DEL codigo venta
                            ======================================-->

                                <div class="form-group">

                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>

                                        <input type="text" class="form-control" id="nuevaVenta" name="editarVenta"
                                            value="<?php echo $venta["codigo"] ?>" readonly>







                                    </div>

                                </div>

                                <!--=====================================
                            ENTRADA DEL CLIENTE
                            ======================================-->

                                <div class="form-group">

                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-users"></i></span>

                                        <select class="form-control" id="seleccionarCliente" name="seleccionarCliente"
                                            required>

                                            <option value="<?php echo $cliente["id"]; ?>">
                                                <?php echo $cliente["nombre"];  ?></option>

                                            <?php 


                                            $item=null;
                                            $valor=null;

                                            $clientes=ControladorClientes::ctrMostrarClientes($item,$valor);

                                            foreach ($clientes as $key => $value) {

                                            echo ' <option value="'.$value["id"].'">'.$value["nombre"].'</option>';

                                            }


                                            ?>




                                        </select>

                                        <span class="input-group-addon"><button type="button"
                                                class="btn btn-default btn-xs" data-toggle="modal"
                                                data-target="#modalAgregarCliente" data-dismiss="modal">Agregar
                                                cliente</button></span>

                                    </div>

                                </div>

                                <!--=====================================
                                ENTRADA PARA AGREGAR PRODUCTO
                                ======================================-->

                                <div class="form-group row nuevoProducto">


                                    <?php 

                                $listaProductos=json_decode($venta["productos"] ,true);

                                foreach ($listaProductos as $key => $value) {


                                    $item="id";
                                    $valor=$value["id"];
                                    $orden="id";


                                    $respuesta=ControladorProductos::ctrMostrarProductos($item,$valor,$orden);

                                    $stockAntiguo=$respuesta["stock"] + $value["cantidad"];

                                    

                                echo '<div class="row" style="padding:5px 15px">
                
                                    <div class="col-xs-5" style="padding-right:0px">

                                        <div class="input-group">

                                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'"><i class="fa fa-times"></i></button></span>

                                            <input type="text" class="form-control nuevaDescripcionProducto" id="agregarProducto" value="'.$value["descripcion"].'" name="agregarProducto" placeholder="Descripción del producto" required idProducto="'.$value["id"].'">

                                        </div>

                                    </div>
                                    

                                  

                                    <div class="col-xs-2 ingresoCantidad">

                                        <input type="number" class="form-control nuevaCantidadProducto"  name="nuevaCantidadProducto" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stock"].'" min="1" placeholder="0" required>

                                    </div>

                                  
                                    <div class="col-xs-2 ingresoPrecio " style="padding-left:0px">

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

                                            <input type="number" min="1" class="form-control nuevoPrecioProducto"  name="nuevoPrecioProducto" value="'.$value["total"].'" precioReal="'.$respuesta["precio_venta"].'"  readonly required>

                                       </div>
                                    </div>
                



                                    <div class="col-xs-2" style="padding-left:0px">

                                        <td><img src="'.$respuesta["imagen"].'"  width="40px"></td>
                                    </div>
                              </div>';

                                 

                                }
                                
                                
                                
                                
                                
                                ?>




                                </div>

                                <input type="hidden" id="listaProductos" name="listaProductos">

                                <!--=====================================
                                BOTÓN PARA AGREGAR PRODUCTO
                                ======================================-->

                                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar
                                    producto</button>


                                <hr>


                                <div class="row">


                                    <!--=====================================
                                ENTRADA IMPUESTOS Y TOTAL
                                ======================================-->

                                    <div class="col-xs-8 pull-right">


                                        <table class="table">

                                            <thead>

                                                <tr>
                                                    <th>Impuesto</th>
                                                    <th>Total</th>
                                                </tr>

                                            </thead>



                                            <tbody>

                                                <tr>

                                                    <td style="width: 50%">

                                                        <div class="input-group">

                                                            <input type="number" class="form-control" min="0"
                                                                id="nuevoImpuestoVenta" name="nuevoImpuestoVenta"
                                                                value="<?php echo $pordentajeImpuesto;  ?>"
                                                                placeholder="0" required>

                                                            <input type="hidden" name="nuevoPrecioImpuesto"
                                                                value="<?php echo $venta["impuesto"];  ?>"
                                                                id="nuevoPrecioImpuesto" required>

                                                            <input type="hidden" name="nuevoPrecioNeto"
                                                                value="<?php echo $venta["neto"];  ?>"
                                                                id="nuevoPrecioNeto" required>





                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-percent"></i></span>

                                                        </div>


                                                    </td>

                                                    <td style="width: 50%">

                                                        <div class="input-group">

                                                            <span class="input-group-addon"><i
                                                                    class="ion ion-social-usd"></i></span>

                                                            <input type="number" min="1" class="form-control"
                                                                id="nuevoTotalVenta"
                                                                total="<?php echo $venta["neto"];  ?>"
                                                                name="nuevoTotalVenta"
                                                                value="<?php echo $venta["total"];  ?>"
                                                                placeholder="00000" readonly required>

                                                            <input type="hidden" name="totalVenta"
                                                                value="<?php echo $venta["total"];  ?>" id="totalVenta">


                                                        </div>


                                                    </td>




                                                </tr>



                                            </tbody>



                                        </table>


                                    </div>


                                </div>


                                <hr>

                                <!--=====================================
                            ENTRADA MÉTODO DE PAGO
                            ======================================-->

                                <div class="form-group row">

                                    <div class="col-xs-6" style="padding-right:0px">
                                        <div class="input-group">
                                            <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago"
                                                required>
                                                <option value="">Seleccione método de pago</option>
                                                <option value="efectivo">Efectivo</option>
                                                <option value="tarjetaCredito">Tarjeta Crédito</option>
                                                <option value="tarjetaDebito">Tarjeta Débito</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="cajasMetodoPago">


                                    </div>





                                </div>

                                <br>

                            </div>

                        </div>

                        <div class="box-footer">

                            <button type="submit" class="btn btn-primary pull-right">Guardar venta</button>

                        </div>

                    </form>

                    <?php
                    
                      $editarVenta = new ControladorVentas();
                      $editarVenta -> ctrEditarVenta();
                    
                    
                    ?>


                </div>

            </div>

            <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

            <div class="col-lg-7 hidden-md hidden-sm hidden-xs">

                <div class="box box-warning">

                    <div class="box-header with-border"></div>

                    <div class="box-body">

                        <table class="table table-bordered table-striped dt-responsive tablas">

                            <thead>

                                <tr>

                                    <th style="width: 10px">#</th>
                                    <th>imagen</th>
                                    <th>codigo</th>
                                    <th>descripcion</th>
                                    <th>stock</th>
                                    <th>acciones</th>


                                </tr>



                            </thead>

                            <tbody>

                                <?php 

                            $item=null;
                            
                            
                            $valor=null;

                            $orden="id";

                            


                            $Productos=ControladorProductos::ctrMostrarProductos($item,$valor, $orden);



                            foreach ($Productos as $key => $value) {


                            echo '   <tr>

                                    <td>'.($key+1).'</td>
                                    <td><img src="'.$value["imagen"].'" class="img-thumbnail"
                                            width="40px"></td>
                                    <td>'.$value["codigo"].'</td>
                                    <td>'.$value["descripcion"].'</td>
                                    <td>'.$value["stock"].'</td>
                                    <td>
                                        <div class="btn-group">

                                            <button class="btn btn-primary agregarProducto recuperarBoton" idProducto="'.$value["id"].'" type="button">agregar producto</button>

                                        </div>
                                    </td>
                                </tr>';



                              
                            }




?>



                            </tbody>


                        </table>


                    </div>


                </div>



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
                                    placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask
                                    required>

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

                    $crearCliente=new ControladorClientes();
                    $crearCliente->ctrCrearCliente();
                    
                    
                    
                    ?>






            </form>

        </div>
    </div>
</div>