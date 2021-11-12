<?php
$id             = $_SESSION['user']['info']['id'];
$linkGroup      = URL::createLink('admin', 'group', 'index');
$linkUser       = URL::createLink('admin', 'user', 'index');
$linkProduct    = URL::createLink('admin', 'product', 'index');
$linkCart       = URL::createLink('admin', 'cart', 'index');
$linkCategory   = URL::createLink('admin', 'category', 'index');
$linkBlog       = URL::createLink('admin', 'blog', 'index');
$linkEmail      = URL::createLink('admin', 'index', 'configEmail');
$linkTimeout    = URL::createLink('admin', 'index', 'configTimeout');
$linkLogout     = URL::createLink('admin', 'index', 'logout');
$name           = isset($_SESSION['user']['info']['fullname'])? $_SESSION['user']['info']['fullname'] : 'Admin';
$linkProfile    = URL::createLink('admin', 'index', 'form', array('id' => $id));

echo $this->arrParam['controller'];
$active = '';
switch($this->arrParam['controller']){
    case 'group':
        $activeGroup    = 'active';
        break;
    case 'blog':
        $activeBlog     = 'active';
        break;
    case 'user':
        $activeUser     = 'active';
        break;
    case 'category':
        $activeCategory = 'active';
        break;
    case 'product':
        $activeProduct  = 'active';
        break;
    case 'cart':
        $activeCart     = 'active';
        break;
    case 'index':
        switch($this->arrParam['action']){
            case 'index':
                $activeIndex    = 'active';
                break;
            case 'form':
                $activeProfile  = 'active';
                break;
            case 'configEmail':
                $menu_open      = 'menu-open';
                $activeEmail    = 'active';
                $activeConfig   = 'active';
                break;
            case 'configTimeout':
                $menu_open      = 'menu-open';
                $activeTimeOut  = 'active';
                $activeConfig   = 'active';
                break;
        }
        break;
}



?>


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo URL::createLink('admin', 'index', 'index'); ?>" class="brand-link">
        <img src="<?php echo TEMPLATE_URL . 'admin/main/'; ?>images/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TB Store</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo TEMPLATE_URL . 'admin/main/'; ?>images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?php echo $linkProfile; ?>" class="d-block">Admin</a>
            </div>
            <div class="info">
                <a href="#" class="d-block">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </div>
            <div class="info">
                <a style="color:red" href="<?php echo $linkLogout; ?>" class="d-block">Log out</a>
            </div>
        </div>
        

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo URL::createLink('admin', 'index', 'index'); ?>" class="nav-link <?php echo $activeIndex; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item <?php echo $menu_open; ?>">
                    <a href="#" class="nav-link <?php echo $activeConfig; ?>">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Config
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo $linkEmail; ?>" class="nav-link <?php echo $activeEmail; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Email</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $linkTimeout; ?>" class="nav-link <?php echo $activeTimeOut; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TimeOut</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $linkGroup; ?>" class="nav-link <?php echo $activeGroup; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Group
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $linkUser; ?>" class="nav-link <?php echo $activeUser; ?>">
                        <i class="nav-icon fas fa-user"></i></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $linkCategory; ?>" class="nav-link <?php echo $activeCategory; ?>">
                        <i class="nav-icon fas fa-list"></i></i>
                        <p>
                            Category
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $linkProduct; ?>" class="nav-link <?php echo $activeProduct; ?>">
                        <i class="nav-icon fas fa-tshirt"></i></i>
                        <p>
                            Product
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $linkCart; ?>" class="nav-link <?php echo $activeCart; ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i></i>
                        <p>
                            Cart
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $linkBlog; ?>" class="nav-link <?php echo $activeBlog; ?>">
                        <i class="nav-icon fas fa-blog"></i></i>
                        <p>
                            Blog
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $linkProfile; ?>" class="nav-link <?php echo $activeProfile; ?>">
                        <i class="nav-icon fas fa-id-card"></i></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>