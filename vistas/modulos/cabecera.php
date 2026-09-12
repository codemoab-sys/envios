    <?php
    $configuracionCabecera = ControladorConfiguracion::ctrMostrarConfiguracion();
    $nombreEmprendimiento = "MOABCODE · Gestión de envíos";
    $nombreEmprendimientoSeguro = htmlspecialchars($nombreEmprendimiento, ENT_QUOTES, "UTF-8");
    $temaGuardado = ($configuracionCabecera["tema"] ?? "light") === "dark" ? "dark" : "light";
    $colorCabeceraGuardado = preg_match('/^#[0-9a-f]{6}$/i', $configuracionCabecera["color_cabecera"] ?? "") ? $configuracionCabecera["color_cabecera"] : "#111827";
    $colorBotonPrimarioGuardado = preg_match('/^#[0-9a-f]{6}$/i', $configuracionCabecera["color_boton_primario"] ?? "") ? $configuracionCabecera["color_boton_primario"] : "#2563eb";
    $colorBotonSecundarioGuardado = preg_match('/^#[0-9a-f]{6}$/i', $configuracionCabecera["color_boton_secundario"] ?? "") ? $configuracionCabecera["color_boton_secundario"] : "#334155";
    $usuarioActualId = isset($_SESSION["id"]) ? (int) $_SESSION["id"] : 0;
    $tenantActualId = isset($_SESSION["tenant_id"]) ? (int) $_SESSION["tenant_id"] : 0;
    $inicialesEmprendimiento = "MC";
    ?>
        <style>
            .user-icon-header { display: block; width: 90px; height: 90px; margin: 0 auto; padding-top: 25px; border-radius: 50%; background: rgba(255,255,255,.18); color: #fff; font-size: 38px; text-align: center; }
            .main-header { position: relative; background: var(--header-color) !important; }
            .main-header .logo { position: absolute; top: 0; left: 50%; z-index: 1; width: 190px !important; height: 50px; overflow: visible !important; padding: 4px 10px !important; background: var(--header-color) !important; transform: translateX(-50%); }
            .main-header .logo .brand-logo-lg { display: block !important; width: 100% !important; max-width: 170px; height: 42px; margin: 0 auto; object-fit: contain; }
            .brand-logo-mini { display: none !important; }
            .main-header .navbar { position: relative; z-index: 2; width: 100%; margin-left: 0 !important; background: transparent !important; }
            .main-header .navbar-custom-menu { position: absolute; top: 0; right: 0; z-index: 3; }
            .main-header .navbar-custom-menu .user-menu > a { display: flex; align-items: center; justify-content: center; height: 50px; padding-top: 0 !important; padding-bottom: 0 !important; }
            .main-header .navbar-custom-menu .user-image { flex: 0 0 auto; margin-top: 5px !important; }
            .main-header .sidebar-toggle,
            .main-header .sidebar-toggle:hover,
            .main-header .sidebar-toggle:focus { background: transparent !important; color: var(--header-text-color, #fff) !important; }
            .sidebar-mini.sidebar-collapse .main-header .logo .logo-mini,
            .sidebar-mini.sidebar-collapse .main-header .logo .brand-logo-mini { display: none !important; }
            .sidebar-mini.sidebar-collapse .main-header .logo .logo-lg,
            .sidebar-mini.sidebar-collapse .main-header .logo .brand-logo-lg { display: block !important; }
            @media (max-width: 768px) {
                .main-header { display: block !important; height: 50px !important; min-height: 50px; max-height: 50px; }
                .main-header .logo { float: none !important; left: 50%; width: 190px !important; height: 50px; text-align: center; padding: 4px 10px !important; }
                .main-header .logo .brand-logo-lg { display: block !important; width: 100% !important; max-width: 170px; height: 42px; margin: 0 auto; object-fit: contain; }
                .sidebar-mini.sidebar-collapse .main-header .logo { width: 190px !important; }
                .main-header .navbar { position: relative; float: none !important; width: 100%; height: 50px; margin-left: 0 !important; min-height: 50px; }
                .main-header .navbar > .sidebar-toggle { position: absolute; top: 0; left: 0; z-index: 4; width: 50px; height: 50px; padding: 15px; }
                .main-header .navbar-custom-menu { top: 0; right: 0; z-index: 4; height: 50px; }
            }
        </style>
    <header class="main-header">
      <!-- Logo -->
      <a href="inicio" class="logo" aria-label="MOABCODE">
          <img class="brand-logo-lg" src="LOGO.png" alt="MOABCODE" title="<?php echo $nombreEmprendimientoSeguro; ?>">
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
                          <i class="fa fa-user user-image" aria-label="Usuario"></i>
                          <span class="hidden-xs"><?php  echo $_SESSION["nombre"]; ?></span>
                      </a>
                      <ul class="dropdown-menu">
                          <!-- User image -->
                          <li class="user-header">
                              <i class="fa fa-user user-icon-header" aria-label="Usuario"></i>

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

    <div class="modal fade" id="modalApariencia" data-theme-current="<?php echo $temaGuardado; ?>" data-color-current="<?php echo htmlspecialchars($colorCabeceraGuardado, ENT_QUOTES, "UTF-8"); ?>" data-primary-current="<?php echo htmlspecialchars($colorBotonPrimarioGuardado, ENT_QUOTES, "UTF-8"); ?>" data-secondary-current="<?php echo htmlspecialchars($colorBotonSecundarioGuardado, ENT_QUOTES, "UTF-8"); ?>" data-user-id="<?php echo $usuarioActualId; ?>" data-tenant-id="<?php echo $tenantActualId; ?>" tabindex="-1" role="dialog" aria-labelledby="tituloModalApariencia">
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
                      <div class="apariencia-paletas-grupo">
                          <span class="apariencia-paletas-label">Temas claros</span>
                          <div class="apariencia-paletas">
                              <button type="button" class="apariencia-paleta" data-theme-palette="light" data-header="#0f766e" data-primary="#2563eb" data-secondary="#334155"><span class="paleta-muestra" style="--muestra:#0f766e"></span><span>Turquesa limpio</span></button>
                              <button type="button" class="apariencia-paleta" data-theme-palette="light" data-header="#1e40af" data-primary="#0284c7" data-secondary="#334155"><span class="paleta-muestra" style="--muestra:#1e40af"></span><span>Azul confianza</span></button>
                              <button type="button" class="apariencia-paleta" data-theme-palette="light" data-header="#b45309" data-primary="#d97706" data-secondary="#3f3f46"><span class="paleta-muestra" style="--muestra:#b45309"></span><span>Ámbar activo</span></button>
                          </div>
                      </div>
                      <div class="apariencia-paletas-grupo">
                          <span class="apariencia-paletas-label">Temas oscuros</span>
                          <div class="apariencia-paletas">
                              <button type="button" class="apariencia-paleta" data-theme-palette="dark" data-header="#166534" data-primary="#22c55e" data-secondary="#1f2937"><span class="paleta-muestra" style="--muestra:#166534"></span><span>Bosque sereno</span></button>
                              <button type="button" class="apariencia-paleta" data-theme-palette="dark" data-header="#1e3a8a" data-primary="#60a5fa" data-secondary="#0f172a"><span class="paleta-muestra" style="--muestra:#1e3a8a"></span><span>Azul nocturno</span></button>
                              <button type="button" class="apariencia-paleta" data-theme-palette="dark" data-header="#881337" data-primary="#fb7185" data-secondary="#3f172a"><span class="paleta-muestra" style="--muestra:#881337"></span><span>Coral profundo</span></button>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="guardarApariencia">Guardar cambios</button>
              </div>
          </div>
      </div>
  </div>