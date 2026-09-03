  <header class="main-header">
      <!-- Logo -->
      <a href="inicio" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Admin</b>LTE</span>
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

                  <li>
                      <button id="themeToggle" class="theme-toggle" title="Cambiar tema">
                          <i class="fa fa-moon-o"></i>
                      </button>
                  </li>

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
                                  <a href="usuarios" class="btn btn-default btn-flat">perfil</a>
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