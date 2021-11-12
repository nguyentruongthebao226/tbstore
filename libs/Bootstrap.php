<?php
class Bootstrap
{
    private $_params;
    private $_controllerObject;
    public function init()
    {
        $this->setParam();

        $controllerName = ucfirst($this->_params['controller']) . 'Controller';
        $filePath = MODULE_PATH . $this->_params['module'] . DS . 'controllers' . DS . $controllerName . '.php';
        if (file_exists($filePath)) {
            $this->loadExistingController($filePath, $controllerName);
            $this->callMethod();
        }else{
            URL::redirect('default', 'index', 'notice', array('type' => 'not-url'), 'duongdankhonghople.html');
        }
    }

    //CALL METHODE
    public function callMethod(){
        $actionName = $this->_params['action'] . 'Action';
        if (method_exists($this->_controllerObject, $actionName) == true) {
            $module     = $this->_params['module'];
            $controller = $this->_params['controller'];
            $action     = $this->_params['action'];
            $requestURL = "$module-$controller-$action";
            $userInfo   = Session::get('user');    
            $timeout    = $this->readTimeout();

            $logged     = ($userInfo['login'] == true && $userInfo['time'] + $timeout >= time());

            // Module admin
            if($module == 'admin'){
                if($logged == true){
                    if($userInfo['group_acp'] == 1){
                        // echo '<pre>';
                        // print_r($userInfo);
                        // echo '</pre>';
                        // die('Function Die...');
                        if(in_array($requestURL, $userInfo['info']['privilege']) == true){
                            $this->_controllerObject->$actionName();
                        }else{
                            URL::redirect('default', 'index', 'notice', array('type' => 'not-permission'), ' permission.html');
                        }
                    }else{                        
                        Session::delete('user');
                        URL::redirect('default', 'index', 'notice', array('type' => 'not-permission'), 'permission.html');
                    }
                }else{
                    $this->callLoginAction($module);
                }
            // Module Default
            }else if($module == 'default'){
                if($controller == 'user'){
                    if($logged == true){
                        $this->_controllerObject->$actionName();  
                    }else{
                        $this->callLoginAction($module);
                    }
                }else{
                    $this->_controllerObject->$actionName();  
                }
                
            }
        } else{
            URL::redirect('default', 'index', 'notice', array('type' => 'not-url'), 'duongdankhonghople.html');
        }
    }

    //SET PARAMS
    public function setParam()
    {
        $this->_params     = array_merge($_GET, $_POST);
        $this->_params['module']     = isset($this->_params['module']) ? $this->_params['module'] : DEFAULT_MODULE;
        $this->_params['controller']     = isset($this->_params['controller']) ? $this->_params['controller'] : DEFAULT_CONTROLLER;
        $this->_params['action']     = isset($this->_params['action']) ? $this->_params['action'] : DEFAULT_ACTION;

    }

    //CALL ACTION LOGIN
    private function loadExistingController($filePath, $controllerName)
    {

        require_once $filePath;
        $this->_controllerObject = new $controllerName($this->_params);
        
    }
   
    //LOAD EXISTING CONTROLLER
    private function callLoginAction($module = 'default')
    {
        Session::delete('user');
        require_once (MODULE_PATH . $module . DS . 'controllers' . DS  . 'IndexController.php');
        $indexController = new IndexController($this->_params);
        $indexController->loginAction();      
    }

    //ErrorController
    public function _error()
    {
        require_once MODULE_PATH . 'default' . DS . 'controllers' . DS  . 'ErrorController.php';
        $this->_controllerObject = new ErrorController();
        $this->_controllerObject->setView('default');
        $this->_controllerObject->indexAction();
    }

    public function readTimeout(){
        $linkTimeout    = TEMPLATE_PATH . 'admin/main/data/timeout.json';
        $data = file_get_contents($linkTimeout);
        $data = json_decode($data, TRUE);
        return $data['Timeout'];
    }
}
