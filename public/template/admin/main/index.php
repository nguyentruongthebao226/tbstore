<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->_metaHTTP; ?>
    <?php echo $this->_metaName; ?>
    <title><?php echo $this->_title; ?></title>
    <?php echo $this->_cssFiles; ?>
    <?php echo $this->_jsFiles; ?>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo TEMPLATE_URL . 'admin/main/'; ?>images/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div> -->


        <!-- Header -->
        <?php include_once 'html/header.php'; ?>
        <!-- Header End -->
        <!-- Main Sidebar Container -->
        <?php include_once 'html/sidebar.php'; ?>

        <!-- Content -->
        <div class="content-wrapper">           
            <!-- /.content-header -->
    
                    <?php
                    require_once MODULE_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php';
                    ?>
        
        </div>       
        <!-- Content End -->

        <!-- Footer -->
        <?php include_once 'html/footer.php'; ?>
        <!-- Footer End -->

           
    </div>

    <!-- Script -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

</body>