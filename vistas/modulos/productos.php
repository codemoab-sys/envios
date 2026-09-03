       <!-- Content Wrapper. Contains page content -->
       <div class="content-wrapper">
           <!-- Content Header (Page header) -->
           <section class="content-header">
               <h1>
                   administrar productos

               </h1>
               <ol class="breadcrumb">
                   <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                   <li class="active">administrar aproductos</li>
               </ol>
           </section>

           <!-- Main content -->
           <section class="content">

               <!-- Default box -->
               <div class="box">
                   <div class="box-header with-border">


                       <button type="button" class="btn btn-primary" data-toggle="modal"
                           data-target="#modalAgregarProducto">
                           agregar producto
                       </button>


                   </div>
                   <div class="box-body">


                       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                           <thead>
                               <tr>
                                   <th style="width:10px">#</th>
                                   <th>Imagen</th>
                                   <th>Código</th>
                                   <th>Descripción</th>
                                   <th>Categoría</th>
                                   <th>Stock</th>
                                   <th>Precio de compra</th>
                                   <th>Precio de venta</th>
                                   <th>fecha</th>
                                   <th>Acciones</th>



                               </tr>



                           </thead>

                           <tbody>

                               <?php 

                            $item=null;
                            
                            
                            $valor=null;

                            $orden="id";

                            


                            $Productos=ControladorProductos::ctrMostrarProductos($item,$valor, $orden);


                            foreach ($Productos as $key => $value) {

                                $item="id";
                                $valor=$value["id_categoria"];

                                $categoria=ControladorCategorias::ctrMostrarCategorias($item,$valor);




                                echo '

                                   <tr>

                                <td>'.($key+1).'</td>


                                <td><img src="'.$value["imagen"].'" alt="" width="40px"></td>
                                
                                <td>'.$value["codigo"].'</td>
                                <td>'.$value["descripcion"].'</td>
                                <td>'.$categoria["categorias"].'</td>
                                <td>'.$value["stock"].'</td>
                                <td>'.$value["precio_compra"].'</td>
                                <td>'.$value["precio_venta"].'</td>;                                                                                                          
                                <td>'.$value["fecha"].'</td>';

                            
                        
                

                                echo '<td>

                                    <div class="btn-group">

                                        <button class="btn btn-primary btnEditarProducto" idProducto="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarProducto">

                                            <i class="fa fa-pencil"></i>
                                        </button>


                                        <button class="btn btn-danger btnEliminarProducto" idProducto="'.$value["id"].'" codigo="'.$value["codigo"].'" imagen="'.$value["imagen"].'">


                                            <i class="fa fa-times"></i>
                                        </button>


                                    </div>

                                </td>

                            </tr> ';
                                
                                                                                                                                                                                   

                            }
                        
                                                                              
                        ?>


                           </tbody>






                       </table>





                   </div>

               </div>


           </section>

       </div>









       <!--=====================================
MODAL AGREGAR ProductoS
======================================-->
       <div id="modalAgregarProducto" class="modal fade" role="dialog">

           <div class="modal-dialog">

               <div class="modal-content">


                   <form role="form" method="post" enctype="multipart/form-data">

                       <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->


                       <div class="modal-header" style="background:#3c8dbc; color:white">

                           <button type="button" class="close" data-dismiss="modal">&times;</button>

                           <h4 class="modal-title">Agregar Producto</h4>

                       </div>

                       <!--=====================================
                    CUERPO DEL MODAL
                    ======================================-->

                       <div class="modal-body">
                           <div class="box-body">

                               <!-- ENTRADA PARA SELECIONAR LA CATEGORIA -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-th"></i></span>

                                       <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria">


                                           <option value="">seleccionar categoria</option>

                                           <?php 

                                        $item=null;
                                        $valor=null;

                                        $categorias = ControladorCategorias::ctrMostrarCategorias($item,$valor);

                                        foreach ($categorias as $key => $value) {

                                            echo '<option value="'.$value["id"].'">'.$value["categorias"].'</option>';



                                        
                                        }




                                        ?>



                                       </select>

                                   </div>

                               </div>





                               <!-- ENTRADA PARA EL CODIGO -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-code"></i></span>

                                       <input type="text" class="form-control input-lg" id="nuevoCodigo"
                                           name="nuevoCodigo" placeholder="Ingresar código" readonly required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA LA DESCRIPCIÓN -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                                       <input type="text" class="form-control input-lg" name="nuevaDescripcion"
                                           placeholder="Ingresar descripción" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA STOCK -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-check"></i></span>

                                       <input type="number" class="form-control input-lg" name="nuevoStock" min="0"
                                           placeholder="Stock" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA PRECIO DE la  COMPRA -->

                               <div class="form-group row">

                                   <div class="col-xs-6">

                                       <div class="input-group">

                                           <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>

                                           <input type="number" class="form-control input-lg" id="nuevoPrecioCompra"
                                               name="nuevoPrecioCompra" step="any" min="0"
                                               placeholder="Precio de compra" required>

                                       </div>

                                   </div>


                                   <!-- ENTRADA PARA PRECIO VENTA -->

                                   <div class="col-xs-6">

                                       <div class="input-group">

                                           <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>

                                           <input type="number" class="form-control input-lg" id="nuevoPrecioVenta"
                                               name="nuevoPrecioVenta" step="any" min="0" placeholder="Precio de venta"
                                               required>

                                       </div>

                                       <br>

                                       <!-- CHECKBOX PARA PORCENTAJE -->

                                       <div class="col-xs-6">

                                           <div class="form-group">

                                               <label>

                                                   <input type="checkbox" class="minimal porcentaje" checked>
                                                   Utilizar procentaje
                                               </label>

                                           </div>

                                       </div>

                                       <!-- ENTRADA PARA PORCENTAJE -->

                                       <div class="col-xs-6" style="padding:0">

                                           <div class="input-group">

                                               <input type="number" class="form-control input-lg nuevoPorcentaje"
                                                   min="0" value="40" required>

                                               <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                                           </div>

                                       </div>

                                   </div>

                               </div>


                               <!-- ENTRADA PARA SUBIR FOTO -->

                               <div class="form-group">

                                   <div class="panel">SUBIR IMAGEN</div>

                                   <input type="file" class="nuevaImagen" name="nuevaImagen">

                                   <p class="help-block">Peso máximo de la imagen 2MB</p>

                                   <img src="vistas/img/productos/default/anonymous.png"
                                       class="img-thumbnail previsualizar" width="100px">

                               </div>

                           </div>

                       </div>

                       <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                       <div class="modal-footer">

                           <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                           <button type="submit" class="btn btn-primary">Guardar Producto</button>

                       </div>

                       <?php 

                    $crearProducto=new ControladorProductos();
                    $crearProducto->ctrCrearProducto();
                    
                    
                    
                    ?>






                   </form>

               </div>
           </div>
       </div>










       <!--=====================================
MODAL EDITAR ProductoS
======================================-->
       <div id="modalEditarProducto" class="modal fade" role="dialog">

           <div class="modal-dialog">

               <div class="modal-content">


                   <form role="form" method="post" enctype="multipart/form-data">

                       <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->


                       <div class="modal-header" style="background:#3c8dbc; color:white">

                           <button type="button" class="close" data-dismiss="modal">&times;</button>

                           <h4 class="modal-title">Editar Producto</h4>

                       </div>

                       <!--=====================================
                    CUERPO DEL MODAL
                    ======================================-->

                       <div class="modal-body">
                           <div class="box-body">

                               <!-- ENTRADA PARA SELECIONAR LA CATEGORIA -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-th"></i></span>

                                       <select class="form-control input-lg" name="editarCategoria">


                                           <option id="editarCategoria"></option>





                                       </select>

                                   </div>

                               </div>





                               <!-- ENTRADA PARA EL CODIGO -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-code"></i></span>

                                       <input type="text" class="form-control input-lg" id="editarCodigo"
                                           name="editarCodigo" placeholder="Ingresar código" readonly required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA LA DESCRIPCIÓN -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                                       <input type="text" class="form-control input-lg" id="editarDescripcion"
                                           name="editarDescripcion" placeholder="Ingresar descripción" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA STOCK -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-check"></i></span>

                                       <input type="number" class="form-control input-lg" id="editarStock"
                                           name="editarStock" min="0" placeholder="Stock" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA PRECIO DE la  COMPRA -->

                               <div class="form-group row">

                                   <div class="col-xs-6">

                                       <div class="input-group">

                                           <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>

                                           <input type="number" class="form-control input-lg" id="editarPrecioCompra"
                                               name="editarPrecioCompra" step="any" min="0" required>

                                       </div>

                                   </div>


                                   <!-- ENTRADA PARA PRECIO VENTA -->

                                   <div class="col-xs-6">

                                       <div class="input-group">

                                           <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>

                                           <input type="number" class="form-control input-lg" id="editarPrecioVenta"
                                               name="editarPrecioVenta" step="any" min="0" placeholder="Precio de venta"
                                               required>

                                       </div>

                                       <br>

                                       <!-- CHECKBOX PARA PORCENTAJE -->

                                       <div class="col-xs-6">

                                           <div class="form-group">

                                               <label>

                                                   <input type="checkbox" class="minimal porcentaje" checked>
                                                   Utilizar procentaje
                                               </label>

                                           </div>

                                       </div>

                                       <!-- ENTRADA PARA PORCENTAJE -->

                                       <div class="col-xs-6" style="padding:0">

                                           <div class="input-group">

                                               <input type="number" class="form-control input-lg nuevoPorcentaje"
                                                   min="0" value="40" required>

                                               <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                                           </div>

                                       </div>

                                   </div>

                               </div>


                               <!-- ENTRADA PARA SUBIR FOTO -->

                               <div class="form-group">

                                   <div class="panel">SUBIR IMAGEN</div>

                                   <input type="file" class="nuevaImagen" name="editarImagen">

                                   <p class="help-block">Peso máximo de la imagen 2MB</p>

                                   <img src="vistas/img/productos/default/anonymous.png"
                                       class="img-thumbnail previsualizar" width="100px">


                                   <input type="hidden" name="imagenActual" id="imagenActual">

                               </div>

                           </div>

                       </div>

                       <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                       <div class="modal-footer">

                           <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                           <button type="submit" class="btn btn-primary">Guardar Producto</button>

                       </div>

                       <?php 

                    $editarProducto=new ControladorProductos();
                    $editarProducto->ctrEditarProducto();
                    
                    
                    
                    ?>






                   </form>

               </div>
           </div>
       </div>



       <?php 


$borraProducto=new ControladorProductos();
$borraProducto-> ctrEliminarProducto();
   
   
   ?>