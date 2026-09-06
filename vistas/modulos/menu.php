  <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
              <div class="pull-left image">
                  <img src="<?php  echo $_SESSION["foto"]; ?>" class="img-circle" alt="User Image">
              </div>
              <div class="pull-left info">
                  <p><?php  echo $_SESSION["nombre"]; ?></p>
                  <a href="inicio"><i class="fa fa-circle text-success"></i> enlinea</a>
              </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
              <li class="header">menu de navegacion</li>
              <li>
                  <a href="inicio" title="Inicio">
                      <i class="fa fa-home"></i> <span>inicio</span>
                  </a>
              </li>
              <?php if(isset($_SESSION["perfil"]) && strtolower(trim((string) $_SESSION["perfil"])) === "administrador"): ?>
              <li>
                  <a href="usuarios" title="Usuarios">
                      <i class="fa fa-users"></i> <span>usuarios</span>
                  </a>
              </li>
              <?php endif; ?>
              <li>
                  <a href="configuracion" title="Configuración">
                      <i class="fa fa-cog"></i> <span>configuracion</span>
                  </a>
              </li>
              <li>
                  <a href="compartir" title="Compartir">
                      <i class="fa fa-share-alt"></i> <span>Compartir</span>
                  </a>
              </li>
              <li>
                  <a href="envios" title="Envíos">
                      <i class="fa fa-truck"></i> <span>Envios</span>
                  </a>
              </li>
            










          </ul>
      </section>
      <!-- /.sidebar -->
  </aside>