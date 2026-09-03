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
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
              <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Search...">
                  <span class="input-group-btn">
                      <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                              class="fa fa-search"></i>
                      </button>
                  </span>
              </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
              <li class="header">menu de navegacion</li>
              <li>
                  <a href="inicio">
                      <i class="fa fa-th"></i> <span>inicio</span>
                      <span class="pull-right-container">
                          <small class="label pull-right bg-green">Hot</small>
                      </span>
                  </a>
              </li>
              <li>
                  <a href="usuarios">
                      <i class="fa fa-th"></i> <span>usuarios</span>
                      <span class="pull-right-container">
                          <small class="label pull-right bg-green">Hot</small>
                      </span>
                  </a>
              </li>
              <li>
                  <a href="configuracion">
                      <i class="fa fa-th"></i> <span>configuracion</span>
                      <span class="pull-right-container">
                          <small class="label pull-right bg-green">Hot</small>
                      </span>
                  </a>
              </li>
              <li>
                  <a href="compartir">
                      <i class="fa fa-th"></i> <span>Compartir</span>
                      <span class="pull-right-container">
                          <small class="label pull-right bg-green">Hot</small>
                      </span>
                  </a>
              </li>
              <li>
                  <a href="envios">
                      <i class="fa fa-th"></i> <span>Envios</span>
                      <span class="pull-right-container">
                          <small class="label pull-right bg-green">Hot</small>
                      </span>
                  </a>
              </li>
            










          </ul>
      </section>
      <!-- /.sidebar -->
  </aside>