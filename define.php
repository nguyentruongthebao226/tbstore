<?php
    //====================================================== PATHS =================================================
    define('DS'                 , '/');
    define('ROOT_PATH'          , dirname(__FILE__));                           // Định nghĩa đường dẫn đến thư mục gốc
    define('LIBRARY_PATH'       , ROOT_PATH . DS . 'libs' . DS);                // Định nghĩa đường dẫn đến thư mục thư viện   
    define('LIBRARY_EXT_PATH'   , LIBRARY_PATH . 'extends' . DS );
    define('LIBRARY_MAIL_PATH'  , LIBRARY_PATH . 'Mail' . DS );
    define('LIBRARY_VENDOR_PATH', LIBRARY_MAIL_PATH . 'vendor' . DS );
    define('PUBLIC_PATH'        , ROOT_PATH . DS . 'public' . DS);              // Định nghĩa đường dẫn đến thư mục public
    define('UPLOAD_PATH'        , PUBLIC_PATH . 'files' . DS);
    define('SCRIPT_PATH'        , PUBLIC_PATH . 'scripts' . DS);
    define('APPLICATION_PATH'   , ROOT_PATH . DS . 'application' . DS);         // Định nghĩa đường dẫn đến thư mục public
    define('MODULE_PATH'        , APPLICATION_PATH . 'module' . DS);            // Định nghĩa đường dẫn đến thư mục module
    define('BLOCK_PATH'         , APPLICATION_PATH . 'block' . DS);             // Định nghĩa đường dẫn đến thư mục block
    define('TEMPLATE_PATH'        , PUBLIC_PATH  . 'template' . DS);

    define('ROOT_URL'           , DS . 'storetb'  );
    define('PUBLIC_URL'         , ROOT_URL . DS . 'public' . DS);
    define('UPLOAD_URL'         , PUBLIC_URL . 'files' . DS);
    define('APPLICATION_URL'    , ROOT_URL . DS . 'application' . DS); 
    define('TEMPLATE_URL'       , PUBLIC_URL . 'template' . DS);

    define('DEFAULT_MODULE'     , 'default');
    define('DEFAULT_CONTROLLER' , 'index');
    define('DEFAULT_ACTION'     , 'index');


    //====================================================== DATABASE =================================================
    define('DB_HOST'    , 'localhost');
    define('DB_USERS'   , 'root'); 
    define('DB_PASS'    , ''); 
    define('DB_NAME'    , 'tbstore');
    define('DB_TABLE'   , 'group');

    //====================================================== DATABASE TABLE =================================================
    define('TBL_GROUP'    , 'group');
    define('TBL_USER'     , 'user');
    define('TBL_PRIVILEGE', 'privilege');
    define('TBL_CATEGORY' , 'category');
    define('TBL_PRODUCT'  , 'product');
    define('TBL_BLOG'     , 'blog');
    define('TBL_CART'     , 'cart');

    //====================================================== CONFIG =================================================
    define('TIME_LOGIN'   , 3600);