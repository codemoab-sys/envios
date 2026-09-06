    <?php
    $configuracionCabecera = ControladorConfiguracion::ctrMostrarConfiguracion();
    $nombreEmprendimiento = trim((string)($configuracionCabecera["nombre_emprendimiento"] ?? ""));
    if($nombreEmprendimiento === "") $nombreEmprendimiento = "Mi emprendimiento";
    $nombreEmprendimientoSeguro = htmlspecialchars($nombreEmprendimiento, ENT_QUOTES, "UTF-8");
    $temaGuardado = ($configuracionCabecera["tema"] ?? "light") === "dark" ? "dark" : "light";
    $colorCabeceraGuardado = preg_match('/^#[0-9a-f]{6}$/i', $configuracionCabecera["color_cabecera"] ?? "") ? $configuracionCabecera["color_cabecera"] : "#dd4b39";
    $colorBotonPrimarioGuardado = preg_match('/^#[0-9a-f]{6}$/i', $configuracionCabecera["color_boton_primario"] ?? "") ? $configuracionCabecera["color_boton_primario"] : "#3b82f6";
    $colorBotonSecundarioGuardado = preg_match('/^#[0-9a-f]{6}$/i', $configuracionCabecera["color_boton_secundario"] ?? "") ? $configuracionCabecera["color_boton_secundario"] : "#202c42";
    $inicialesEmprendimiento = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $nombreEmprendimiento), 0, 2));
    if($inicialesEmprendimiento === "") $inicialesEmprendimiento = "ME";
    ?>
    <header class="main-header">
      <!-- Logo -->
      <a href="inicio" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b><?php echo htmlspecialchars($inicialesEmprendimiento, ENT_QUOTES, "UTF-8"); ?></b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg" title="<?php echo $nombreEmprendimientoSeguro; ?>"><?php echo $nombreEmprendimientoSeguro; ?></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </a>

          <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">

                  <li class="dropdown user user-menu">
                      <a href="inicio" class="dropdown-toggle" data-toggle="dropdown">
                          <img src="<?php  echo $_SESSION["foto"]; ?>" class="user-image" alt="User Image">
                          <span class="hidden-xs"><?php  echo $_SESSION["nombre"]; ?></span>
                      </a>
                      <ul class="dropdown-menu">
                          <!-- User image -->
                          <li class="user-header">
                              <img src="<?php  echo $_SESSION["foto"]; ?>" class="img-circle" alt="User Image">

                              <p>
                                  <?php  echo $_SESSION["nombre"]; ?>
                                  <small></small>
                              </p>
                          </li>
                          <!-- Menu Body -->

                          <!-- Menu Footer-->
                          <li class="user-footer">
                              <div class="pull-left">
                                  <button type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modalApariencia">Apariencia</button>
                              </div>
                              <div class="pull-right">
                                  <a href="salir" class="btn btn-default btn-flat">salir</a>
                              </div>
                          </li>
                      </ul>
                  </li>

              </ul>
          </div>
      </nav>
  </header>

    <div class="modal fade" id="modalApariencia" data-theme-current="<?php echo $temaGuardado; ?>" data-color-current="<?php echo htmlspecialchars($colorCabeceraGuardado, ENT_QUOTES, "UTF-8"); ?>" data-primary-current="<?php echo htmlspecialchars($colorBotonPrimarioGuardado, ENT_QUOTES, "UTF-8"); ?>" data-secondary-current="<?php echo htmlspecialchars($colorBotonSecundarioGuardado, ENT_QUOTES, "UTF-8"); ?>" tabindex="-1" role="dialog" aria-labelledby="tituloModalApariencia">
      <div class="modal-dialog" role="document">
          <div class="modal-content apariencia-modal">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="tituloModalApariencia"><i class="fa fa-sliders"></i> Apariencia</h4>
              </div>
              <div class="modal-body">
                  <div class="apariencia-control">
                      <label>Modo de pantalla</label>
                      <div class="apariencia-temas">
                          <button type="button" class="apariencia-tema" data-theme-choice="light" onclick="cambiarTemaApariencia('light'); return false;"><i class="fa fa-sun-o"></i> Claro</button>
                          <button type="button" class="apariencia-tema" data-theme-choice="dark" onclick="cambiarTemaApariencia('dark'); return false;"><i class="fa fa-moon-o"></i> Oscuro</button>
                      </div>
                  </div>
                  <div class="apariencia-control">
                      <label for="colorCabecera">Color de la cabecera</label>
                      <div class="apariencia-color-row">
                          <input type="color" id="colorCabecera" value="<?php echo htmlspecialchars($colorCabeceraGuardado, ENT_QUOTES, "UTF-8"); ?>">
                          <input type="text" id="codigoColorCabecera" value="<?php echo htmlspecialchars(strtoupper($colorCabeceraGuardado), ENT_QUOTES, "UTF-8"); ?>" maxlength="7" pattern="^#[0-9A-Fa-f]{6}$" aria-label="Código hexadecimal del color">
                      </div>
                  </div>
                  <div class="apariencia-control">
                      <label for="colorBotonPrimario">Color del botón primario</label>
                      <div class="apariencia-color-row">
                          <input type="color" id="colorBotonPrimario" value="<?php echo htmlspecialchars($colorBotonPrimarioGuardado, ENT_QUOTES, "UTF-8"); ?>">
                          <input type="text" id="codigoColorBotonPrimario" value="<?php echo htmlspecialchars(strtoupper($colorBotonPrimarioGuardado), ENT_QUOTES, "UTF-8"); ?>" maxlength="7" pattern="^#[0-9A-Fa-f]{6}$" aria-label="Código del botón primario">
                      </div>
                  </div>
                  <div class="apariencia-control">
                      <label for="colorBotonSecundario">Color de los botones secundarios</label>
                      <div class="apariencia-color-row">
                          <input type="color" id="colorBotonSecundario" value="<?php echo htmlspecialchars($colorBotonSecundarioGuardado, ENT_QUOTES, "UTF-8"); ?>">
                          <input type="text" id="codigoColorBotonSecundario" value="<?php echo htmlspecialchars(strtoupper($colorBotonSecundarioGuardado), ENT_QUOTES, "UTF-8"); ?>" maxlength="7" pattern="^#[0-9A-Fa-f]{6}$" aria-label="Código de los botones secundarios">
                      </div>
                  </div>
                  <div class="apariencia-control">
                      <label>Paletas recomendadas</label>
                      <div class="apariencia-paletas">
                          <button type="button" class="apariencia-paleta" data-theme-palette="light" data-header="#0f766e" data-primary="#2563eb" data-secondary="#334155"><span class="paleta-muestra" style="--muestra:#0f766e"></span><span>Claro turquesa</span></button>
                          <button type="button" class="apariencia-paleta" data-theme-palette="light" data-header="#1d4ed8" data-primary="#0ea5e9" data-secondary="#1e3a5f"><span class="paleta-muestra" style="--muestra:#1d4ed8"></span><span>Claro azul</span></button>
                          <button type="button" class="apariencia-paleta" data-theme-palette="light" data-header="#b45309" data-primary="#ea580c" data-secondary="#44403c"><span class="paleta-muestra" style="--muestra:#b45309"></span><span>Claro ámbar</span></button>
                          <button type="button" class="apariencia-paleta" data-theme-palette="dark" data-header="#166534" data-primary="#16a34a" data-secondary="#365314"><span class="paleta-muestra" style="--muestra:#166534"></span><span>Oscuro bosque</span></button>
                          <button type="button" class="apariencia-paleta" data-theme-palette="dark" data-header="#172554" data-primary="#3b82f6" data-secondary="#1e293b"><span class="paleta-muestra" style="--muestra:#172554"></span><span>Oscuro nocturno</span></button>
                          <button type="button" class="apariencia-paleta" data-theme-palette="dark" data-header="#4c1d2c" data-primary="#f43f5e" data-secondary="#3f1d2e"><span class="paleta-muestra" style="--muestra:#4c1d2c"></span><span>Oscuro coral</span></button>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="guardarApariencia">Guardar cambios</button>
              </div>
          </div>
      </div>
  </div>