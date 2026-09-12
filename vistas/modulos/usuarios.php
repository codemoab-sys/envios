    <style>
        .usuarios-foto-icon { display: inline-flex; width: 34px; height: 34px; align-items: center; justify-content: center; border-radius: 50%; background: #eef2f7; color: #536176; font-size: 18px; }
        .usuarios-password-toggle { cursor: pointer; user-select: none; color: #3c8dbc; font-weight: 600; }
        .usuarios-password-toggle:hover { text-decoration: underline; }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                administrar usuarios

            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> inicio</a></li>

                <li class="active">administrar usuarios</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">


                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#modalAgregarUsuario">
                        agregar usuario
                    </button>


                </div>
                <div class="box-body">


                    <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                        <thead>
                            <tr>
                                <th># </th>
                                <th>nombre</th>
                                <th>usuario</th>
                                <th>foto</th>
                                <th>perfil</th>
                                <th>plan</th>
                                <th>inicio</th>
                                <th>vencimiento</th>
                                <th>tiempo restante</th>
                                <th>estado</th>
                                <th>acciones</th>


                            </tr>



                        </thead>

                        <tbody>

                            <?php

                            if(session_status() !== PHP_SESSION_ACTIVE) session_start();
                            if(!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] !== "ok" || strtolower(trim((string)($_SESSION["perfil"] ?? ""))) !== "administrador"){
                                http_response_code(403);
                                exit("No autorizado");
                            }

                            $item=null;
                            
                            
                            $valor=null;


                            $usuarios=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);


                            foreach ($usuarios as $key => $value) {

                                $planUsuario = strtolower(trim((string)($value["plan"] ?? "")));
                                $fechaInicioUsuario = !empty($value["fecha_inicio"]) ? date("d/m/Y H:i", strtotime($value["fecha_inicio"])) : "-";
                                $fechaVencimientoUsuario = !empty($value["fecha_vencimiento"]) ? date("d/m/Y H:i", strtotime($value["fecha_vencimiento"])) : "-";
                                if((int)($value["estado"] ?? 0) === 0){
                                    $tiempoUsuario = "Desactivado";
                                }elseif($planUsuario === "general" || $planUsuario === ""){
                                    $tiempoUsuario = "Sin límite";
                                }elseif(!empty($value["fecha_vencimiento"]) && strtotime($value["fecha_vencimiento"]) <= time()){
                                    $tiempoUsuario = "Solo lectura";
                                }else{
                                    $diasUsuario = !empty($value["fecha_vencimiento"]) ? max(0, (int) ceil((strtotime($value["fecha_vencimiento"]) - time()) / 86400)) : 0;
                                    $tiempoUsuario = $diasUsuario . " día(s)";
                                }
                                $planVisible = $planUsuario === "prueba" ? "Usuario/prueba" : ($planUsuario === "mensual" ? "Usuario mensual" : "General");

                                echo '

                                   <tr>

                                <td>'.($key + 1).'</td>
                                <td>'.htmlspecialchars((string) $value["nombre"], ENT_QUOTES, "UTF-8").'</td>
                                <td>'.htmlspecialchars((string) $value["usuario"], ENT_QUOTES, "UTF-8").'</td>
                                <td><i class="fa fa-user usuarios-foto-icon" aria-label="Usuario"></i></td>
                                <td>'.htmlspecialchars($value["perfil"], ENT_QUOTES, "UTF-8").'</td>
                                <td>'.htmlspecialchars($planVisible, ENT_QUOTES, "UTF-8").'</td>
                                <td>'.$fechaInicioUsuario.'</td>
                                <td>'.$fechaVencimientoUsuario.'</td>
                                <td>'.htmlspecialchars($tiempoUsuario, ENT_QUOTES, "UTF-8").'</td>';

                                if($value["estado"] != 0){

                            echo '<td><button class="btn btn-success btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="0">Activado</button></td>';

                        }else{

                            echo '<td><button class="btn btn-danger btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="1">Desactivado</button></td>';

                        }



                                
                            

                                


                                echo '<td>

                                    <div class="btn-group">

                                        <button class="btn btn-primary btnEditarUsuario" idUsuario="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarUsuario">

                                            <i class="fa fa-pencil"></i>
                                        </button>


                                        <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value["id"].'"  fotoUsuario=""  usuario="'.$value["usuario"].'">


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
MODAL AGREGAR USUARIO
======================================-->
    <div id="modalAgregarUsuario" class="modal fade" role="dialog">

        <div class="modal-dialog">

            <div class="modal-content">


                <form role="form" method="post" enctype="multipart/form-data">

                    <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->


                    <div class="modal-header" style="background:#3c8dbc; color:white">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h4 class="modal-title">Agregar usuario</h4>

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

                                    <input type="text" class="form-control input-lg" name="nuevoNombre"
                                        placeholder="Ingresar nombre" required>

                                </div>

                            </div>

                            <!-- ENTRADA PARA EL USUARIO -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                                    <input type="text" class="form-control input-lg" name="nuevoUsuario"
                                        placeholder="Ingresar usuario" id="nuevoUsuario" required>

                                </div>

                            </div>


                            <!-- ENTRADA PARA LA CONTRASEÑA -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                                    <input type="password" class="form-control input-lg" name="nuevoPassword"
                                        placeholder="Ingresar contraseña" minlength="6" maxlength="8" required>

                                </div>

                            </div>

                            <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-users"></i></span>

                                    <select class="form-control input-lg" name="nuevoPerfil">

                                        <option value="">Selecionar perfil</option>

                                        <option value="Administrador">Administrador</option>

                                        <option value="Usuario">Usuario</option>

                                        <option value="Usuario/prueba">Usuario/prueba</option>

                                    </select>

                                </div>

                            </div>

                            <!-- ENTRADA PARA SUBIR FOTO -->

                            <div class="form-group">

                                <div class="panel">SUBIR FOTO</div>

                                <input type="file" class="nuevaFoto" name="nuevaFoto">

                                <p class="help-block">Peso máximo de la foto 2MB</p>

                                <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar"
                                    width="200px" height="200px">

                            </div>

                        </div>

                    </div>

                    <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                        <button type="submit" class="btn btn-primary">Guardar usuario</button>

                    </div>

                    <?php 

                    $crearUsuario=new ControladorUsuarios();
                    $crearUsuario->ctrCrearUsuario();
                    
                    
                    
                    ?>






                </form>

            </div>
        </div>
    </div>





    <!--=====================================
MODAL EDITAR USUARIO
======================================-->

    <div id="modalEditarUsuario" class="modal fade" role="dialog">

        <div class="modal-dialog">

            <div class="modal-content">

                <form role="form" method="post" enctype="multipart/form-data">

                    <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

                    <div class="modal-header" style="background:#3c8dbc; color:white">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h4 class="modal-title">Editar usuario</h4>

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

                                    <input type="text" class="form-control input-lg" id="editarNombre"
                                        name="editarNombre" value="" required>

                                </div>

                            </div>

                            <!-- ENTRADA PARA EL USUARIO -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                                    <input type="text" class="form-control input-lg" id="editarUsuario"
                                        name="editarUsuario" value="" readonly>

                                </div>

                            </div>

                            <!-- ENTRADA PARA LA CONTRASEÑA -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                                    <input type="password" class="form-control input-lg" name="editarPassword"
                                        placeholder="Escriba la nueva contraseña" minlength="6" maxlength="8">

                                    <input type="hidden" id="passwordActual" name="passwordActual">

                                </div>

                            </div>


                            <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-users"></i></span>

                                    <select class="form-control input-lg" name="editarPerfil">

                                        <option value="" id="editarPerfil"></option>

                                        <option value="Administrador">Administrador</option>

                                        <option value="Usuario">Usuario</option>

                                        <option value="Usuario/prueba">Usuario/prueba</option>

                                    </select>

                                </div>

                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <select class="form-control input-lg" name="editarPlan" id="editarPlan">
                                        <option value="general">Sin límite</option>
                                        <option value="mensual">Usuario mensual</option>
                                        <option value="prueba">Usuario/prueba (3 días)</option>
                                    </select>
                                </div>
                                <p class="help-block">Al guardar, el plan inicia hoy y calcula automáticamente su vencimiento.</p>
                            </div>


                            <!-- ENTRADA PARA SUBIR FOTO -->

                            <div class="form-group">

                                <div class="panel">SUBIR FOTO</div>

                                <input type="file" class="nuevaFoto" name="editarFoto">

                                <p class="help-block">Peso máximo de la foto 2MB</p>

                                <img src="vistas/img/usuarios/default/anonymous.png"
                                    class="img-thumbnail previsualizarEditar" width="100px">

                                <input type="hidden" name="fotoActual" id="fotoActual">

                            </div>


                        </div>
                    </div>

                    <!--=====================================
        PIE DEL MODAL
        ======================================-->

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                        <button type="submit" class="btn btn-primary">Modificar usuario</button>

                    </div>

                    <?php
                    
                    $editarUsuario=new ControladorUsuarios();
                    $editarUsuario->ctrEditarUsuario();
                    
                    
                    ?>





                </form>
            </div>
        </div>
    </div>

    <?php
                    
                    $eliminarUsuario=new ControladorUsuarios();
                    $eliminarUsuario->ctrBorrarUsuario();
                    
                    
                    ?>