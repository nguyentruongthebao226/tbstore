<?php
    require_once 'define.php';
    function __autoload($className){
        $path = 'libs/';
        require_once LIBRARY_PATH . "{$className}.php";
    }

    Session::init();
    $bootstrap = new Bootstrap();
    $bootstrap->init();