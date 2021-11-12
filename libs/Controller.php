<?php
class Controller{
    // View
    protected $_view;

    // Model object
    protected $_model;

    // Template object
    protected $_templateObj;

    // Params (GET - POST)
    protected $_arrayParam;

    // Pagination
    protected $_pagination = array(
                                    'totalItemsPerPage' => 4,
                                    'pageRange'         => 3
                                );

    public function __construct($arrParams){
        $this->setModel($arrParams['module'], $arrParams['controller']);
        $this->setTemplate($this);
        $this->setView($arrParams['module']);

        $this->_pagination['currentPage']   = (isset($arrParams['filter_page']))? $arrParams['filter_page'] : 1;
        $arrParams['pagination'] = $this->_pagination;
        $this->setParams($arrParams);

        $this->_view->arrParam = $arrParams;
    }

    // Set Model
    public function setModel($moduleName, $modelName){
        $modelName = ucfirst($modelName) . 'Model';
        $path = MODULE_PATH . $moduleName . DS . 'models' . DS . $modelName . '.php';
        if(file_exists($path)){
            require_once $path;
            $this->_model   = new $modelName();
        }
        
    }

    // Get Model
    public function getModel(){
        return $this->_model;
    }

    // Set View
    public function setView($moduleName){
        $this->_view = new View($moduleName);
    }

    // Get View
    public function getView(){
        return $this->_view;
    }

    // Set Template
    public function setTemplate($moduleName){
        $this->_templateObj = new Template($this);
    }

    // Get Template
    public function getTemplate(){
        return $this->_templateObj;
    }

    // Set Param
    public function setParams($arrParam){
        $this->_arrayParam = $arrParam;
    }

    // Get Param
    public function getParams(){
        return $this->_arrayParam;
    }

    // Set Pagination
    public function setPagination($config){
        $this->_pagination['totalItemsPerPage'] = $config['totalItemsPerPage'];
        $this->_pagination['pageRange']         = $config['pageRange'];
        $this->_arrayParam['pagination']        = $this->_pagination;
        $this->_view->arrParam                  = $this->_arrayParam;
    }
}