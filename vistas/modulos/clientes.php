       <!-- Content Wrapper. Contains page content -->
       <div class="content-wrapper">
           <!-- Content Header (Page header) -->
           <section class="content-header">
               <h1>
                   administrar clientes

               </h1>
               <ol class="breadcrumb">
                   <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                   <li class="active">administrar aClientes</li>
               </ol>
           </section>

           <!-- Main content -->
           <section class="content">

               <!-- Default box -->
               <div class="box">
                   <div class="box-header with-border">


                       <button type="button" class="btn btn-primary" data-toggle="modal"
                           data-target="#modalAgregarCliente">
                           agregar Cliente
                       </button>


                   </div>
                   <div class="box-body">


                       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                           <thead>
                               <tr>
                                   <th style="width:10px">#</th>
                                   <th>nombre</th>
                                   <th>documento dni</th>
                                   <th>email</th>
                                   <th>telefono</th>
                                   <th>direccion</th>
                                   <th>fecha de nacimiento</th>
                                   <th>total de compras</th>
                                   <th>ingreso al sistema</th>
                                   <th>ultima compra</th>

                                   <th>Acciones</th>



                               </tr>



                           </thead>

                           <tbody>

                               <?php 

                            $item=null;
                            
                            
                            $valor=null;

                           

                            


                            $Clientes=ControladorClientes::ctrMostrarClientes($item,$valor);


                            foreach ($Clientes as $key => $value) {

                              




                                echo '

                                   <tr>

                                <td>'.($key+1).'</td>                            
                                <td>'.$value["nombre"].'</td>
                                <td>'.$value["documento"].'</td>
                                <td>'.$value["email"].'</td>
                                <td>'.$value["telefono"].'</td>
                                <td>'.$value["direccion"].'</td>;                                                                                                          
                                <td>'.$value["fecha_nacimiento"].'</td>
                                <td>'.$value["compras"].'</td>
                                <td>'.$value["ultima_compra"].'</td>
                                <td>'.$value["fecha"].'</td>
                                ';

                            
                        
                

                                echo '<td>

                                    <div class="btn-group">

                                        <button class="btn btn-primary btnEditarCliente" idCliente="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarCliente">

                                            <i class="fa fa-pencil"></i>
                                        </button>


                                        <button class="btn btn-danger btnEliminarCliente" idCliente="'.$value["id"].'" >


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
                                           placeholder="Ingresar fecha nacimiento"
                                           data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

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










       <!--=====================================
MODAL EDITAR ClienteS
======================================-->
       <div id="modalEditarCliente" class="modal fade" role="dialog">

           <div class="modal-dialog">

               <div class="modal-content">

                   <form role="form" method="post">

                       <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

                       <div class="modal-header" style="background:#3c8dbc; color:white">

                           <button type="button" class="close" data-dismiss="modal">&times;</button>

                           <h4 class="modal-title">Editar cliente</h4>

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

                                       <input type="text" class="form-control input-lg" name="editarCliente"
                                           id="editarCliente" required>
                                       <input type="hidden" id="idCliente" name="idCliente">
                                   </div>

                               </div>

                               <!-- ENTRADA PARA EL DOCUMENTO ID -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-key"></i></span>

                                       <input type="number" min="0" class="form-control input-lg"
                                           name="editarDocumentoId" id="editarDocumentoId" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA EL EMAIL -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                                       <input type="email" class="form-control input-lg" name="editarEmail"
                                           id="editarEmail" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA EL TELÉFONO -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                       <input type="text" class="form-control input-lg" name="editarTelefono"
                                           id="editarTelefono" data-inputmask="'mask':'(999) 999-9999'" data-mask
                                           required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA LA DIRECCIÓN -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                       <input type="text" class="form-control input-lg" name="editarDireccion"
                                           id="editarDireccion" required>

                                   </div>

                               </div>

                               <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->

                               <div class="form-group">

                                   <div class="input-group">

                                       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                       <input type="text" class="form-control input-lg" name="editarFechaNacimiento"
                                           id="editarFechaNacimiento" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask
                                           required>

                                   </div>

                               </div>

                           </div>

                       </div>

                       <!--=====================================
        PIE DEL MODAL
        ======================================-->

                       <div class="modal-footer">

                           <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                           <button type="submit" class="btn btn-primary">Guardar cambios</button>

                       </div>

                   </form>

                   <?php

        $editarCliente = new ControladorClientes();
        $editarCliente -> ctrEditarCliente();

      ?>



               </div>

           </div>

       </div>



       <?php 


$borraCliente=new ControladorClientes();
$borraCliente-> ctrEliminarCliente();
   
   
   ?>