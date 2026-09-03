       <!-- Content Wrapper. Contains page content -->
       <div class="content-wrapper">
           <!-- Content Header (Page header) -->
           <section class="content-header">
               <h1>
                   administrar categorias

               </h1>
               <ol class="breadcrumb">
                   <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                   <li class="active">administrar categorias</li>
               </ol>
           </section>

           <!-- Main content -->
           <section class="content">

               <!-- Default box -->
               <div class="box">
                   <div class="box-header with-border">


                       <button type="button" class="btn btn-primary" data-toggle="modal"
                           data-target="#modalAgregarCategoria">
                           agregar categoria
                       </button>


                   </div>
                   <div class="box-body">


                       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                           <thead>
                               <tr>
                                   <th># </th>
                                   <th>nombre</th>
                                   <th>acciones</th>



                               </tr>



                           </thead>

                           <tbody>

                               <?php 

                            $item=null;
                            
                            
                            $valor=null;


                            $categorias=ControladorCategorias::ctrMostrarCategorias($item,$valor);


                            foreach ($categorias as $key => $value) {

                                echo '

                                   <tr>

                                <td>'.($key+1).'</td>
                              
                                
                              
                                <td>'.$value["categorias"].'</td>';

                            
                        
                

                                echo '<td>

                                    <div class="btn-group">

                                        <button class="btn btn-primary btnEditarCategoria" idCategoria="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarCategoria">

                                            <i class="fa fa-pencil"></i>
                                        </button>


                                        <button class="btn btn-danger btnEliminarCategoria" idCategoria="'.$value["id"].'">


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
MODAL AGREGAR CATEGORIAS
======================================-->
       <div id="modalAgregarCategoria" class="modal fade" role="dialog">

           <div class="modal-dialog">

               <div class="modal-content">


                   <form role="form" method="post" enctype="multipart/form-data">

                       <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->


                       <div class="modal-header" style="background:#3c8dbc; color:white">

                           <button type="button" class="close" data-dismiss="modal">&times;</button>

                           <h4 class="modal-title">Agregar categoria</h4>

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

                                       <input type="text" class="form-control input-lg" name="nuevaCategoria" required>

                                   </div>

                               </div>




                           </div>

                       </div>

                       <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                       <div class="modal-footer">

                           <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                           <button type="submit" class="btn btn-primary">Guardar categoria</button>

                       </div>

                       <?php 

                    $crearCategoria=new ControladorCategorias();
                    $crearCategoria->ctrCrearCategoria();
                    
                    
                    
                    ?>






                   </form>

               </div>
           </div>
       </div>










       <!--=====================================
MODAL EDITAR CATEGORIAS
======================================-->
       <div id="modalEditarCategoria" class="modal fade" role="dialog">

           <div class="modal-dialog">

               <div class="modal-content">


                   <form role="form" method="post" enctype="multipart/form-data">

                       <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->


                       <div class="modal-header" style="background:#3c8dbc; color:white">

                           <button type="button" class="close" data-dismiss="modal">&times;</button>

                           <h4 class="modal-title">editar categoria</h4>

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

                                       <input type="text" class="form-control input-lg" id="editarCategoria"
                                           name="editarCategoria" required>

                                       <input type="hidden" name="idCategoria" id="idCategoria" required>

                                   </div>

                               </div>




                           </div>

                       </div>

                       <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                       <div class="modal-footer">

                           <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                           <button type="submit" class="btn btn-primary">editar categoria</button>

                       </div>

                       <?php 

                    $editarCategoria=new ControladorCategorias();
                    $editarCategoria->ctrEditarCategoria();
                    
                    
                    
                    ?>






                   </form>

               </div>
           </div>
       </div>



       <?php 


$borraCategoria=new ControladorCategorias();
$borraCategoria-> ctrBorrarCategoria();
   
   
   ?>