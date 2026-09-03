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
                  <a href="productos">
                      <i class="fa fa-th"></i> <span>productos</span>
                      <span class="pull-right-container">
                          <small class="label pull-right bg-green">Hot</small>
                      </span>
                  </a>
              </li>
              <li>
                  <a href="clientes">
                      <i class="fa fa-th"></i> <span>clientes</span>
                      <span class="pull-right-container">
                          <small class="label pull-right bg-green">Hot</small>
                      </span>
                  </a>
              </li>
              <li class="treeview">
                  <a href="ventas">
                      <i class="fa fa-dashboard"></i> <span>ventas</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <li><a href="ventas"><i class="fa fa-circle-o"></i> administrar ventas</a></li>
                      <li><a href="crear-venta"><i class="fa fa-circle-o"></i> crear ventas</a></li>
                      <li><a href="reportes"><i class="fa fa-circle-o"></i> reportes</a></li>
                  </ul>
              </li>










          </ul>
      </section>
      <!-- /.sidebar -->
  </aside>