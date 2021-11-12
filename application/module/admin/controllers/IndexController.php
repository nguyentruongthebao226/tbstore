<?php
class IndexController extends Controller
{
    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('admin/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    public function indexAction()
    {
        $this->_view->_title             = 'Index Admin';
        $this->_view->totalItemsUser     = $this->_model->countItem(array('task' => 'user'));
        $this->_view->totalItemsGroup    = $this->_model->countItem(array('task' => 'group'));
        $this->_view->totalItemsCart     = $this->_model->countItem(array('task' => 'cart'));
        $this->_view->totalItemsProduct  = $this->_model->countItem(array('task' => 'product'));
        $this->_view->totalItemsCategory = $this->_model->countItem(array('task' => 'category'));
        $this->_view->totalItemsBlog     = $this->_model->countItem(array('task' => 'blog'));
        $this->_view->render('index/index');
    }

    public function formAction()
    {
        error_reporting(E_WARNING);
        $this->_view->_title            = 'Profile';
        $userObj    = Session::get('user');
        $this->_view->arrParam['form'] = $userObj['info'];


        if (isset($this->_arrayParam['id'])) {
            $this->_arrayParam['form'] = $this->_model->infoItem($this->_arrayParam, 'profile');
            if (empty($this->_arrayParam['form'])) URL::redirect('admin', 'user', 'index');
        }

        if ($this->_arrayParam['form']['token'] > 0) {
            $requirePass   = true;
            $queryEmail    = "Select `id` From `" . TBL_USER . "` Where `email` = '" . $this->_arrayParam['form']['email'] . "'";
            if (isset($this->_arrayParam['form']['id'])) {

                $task   = 'edit';
                $requirePass   = false;
                $queryEmail    .= "AND `id` <> '" . $this->_arrayParam['form']['id'] . "'";
            }

            $validate      = new Validate($this->_arrayParam['form']);
            $validate->addRule('email', 'email-notExistRecord', array('database' => $this->_model, 'query' => $queryEmail, 'min' => 3, 'max' => 25))
                ->addRule('password', 'password', array('action' => $task), $requirePass);


            $validate->run();
            $this->_arrayParam['form'] = $validate->getResult();
            if ($validate->isValid() == false) {
                $this->_view->errors = $validate->showErrors();
            } else {
                $id     = $this->_model->saveItem($this->_arrayParam, array('task' => $task));
                $type   = $this->_arrayParam['type'];

                if ($type == 'save-close')   URL::redirect('admin', 'index', 'index');
                if ($type == 'save-new')     URL::redirect('admin', 'index', 'form');
                if ($type == 'save')         URL::redirect('admin', 'index', 'form', array('id' => $id));
            }
        }
        $this->_view->arrParam = $this->_arrayParam;

        $this->_view->render('index/profile');
    }

    public function loginAction()
    {
        $userInfo   = Session::get('user');
        if ($userInfo['login'] == true && $userInfo['time'] + TIME_LOGIN >= time()) {
            URL::redirect('admin', 'index', 'index');
        }
        error_reporting(E_WARNING);
        $this->_templateObj->setFolderTemplate('admin/main/');
        $this->_templateObj->setFileTemplate('login.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();

        $this->_view->_title        = 'Login Admin';

        if ($this->_arrayParam['form']['token'] > 0) {
            $validate = new Validate($this->_arrayParam['form']);
            $username = $this->_arrayParam['form']['username'];
            $password = md5($this->_arrayParam['form']['password']);
            $query    = "Select `id` From `user` Where `username` = '$username' AND `password` = '$password'";
            $validate->addRule('username', 'existRecord', array('database' => $this->_model, 'query' => $query));
            $validate->run();

            if ($validate->isValid() == true) {
                $infoUser       = $this->_model->infoItem($this->_arrayParam);
                
                $arraySession   = array(
                    'login'     => true,
                    'info'      => $infoUser,
                    'time'      => time(),
                    'group_acp' => $infoUser['group_acp']
                );
                Session::set('user', $arraySession);
                URL::redirect('admin', 'index', 'index');
            } else {
                $this->_view->errors = $validate->showErrors();
            }
        }
        $this->_view->render('index/login');
    }

    public function logoutAction()
    {
        Session::delete('user');
        URL::redirect('admin', 'index', 'login');
    }

    public function configEmailAction()
    {
        error_reporting(E_WARNING);
        $this->_view->_title            = 'Config Email';
        if ($this->_arrayParam['form']['tokenEmail'] > 0) {
            $validate = new Validate($this->_arrayParam['form']);
            $validate->addRule('emailConfig', 'email')
                    ->addRule('emailPassword', 'password');
            $validate->run();

            if ($validate->isValid() == true) {
                $linkConfigEmail    = TEMPLATE_PATH . 'admin/main/data/mail-admin.json';
                $data['EmailConfig'] = $this->_arrayParam['form']['emailConfig'];
                $data['EmailPassword'] = $this->_arrayParam['form']['emailPassword'];
                file_put_contents($linkConfigEmail, json_encode($data));

                Session::set('message', array('class' => 'success', 'icon' => 'fa-info', 'content' => 'Cấu hình Email thành công!'));   
                URL::redirect('admin', 'index', 'configEmail');
            } else {
                $this->_view->errors = $validate->showErrors();
            }
        }     
        $this->_view->render('index/configEmail');
    }

    public function configTimeoutAction()
    {
        error_reporting(E_WARNING);
        $this->_view->_title            = 'Config Timeout';
        if ($this->_arrayParam['form']['tokenTimeout'] > 0) {
            $validate = new Validate($this->_arrayParam['form']);
            $validate->addRule('timeout', 'int', array('min' => 1, 'max' => 3600));
            $validate->run();

            if ($validate->isValid() == true) {
                $linkConfigTimeout  = TEMPLATE_PATH . 'admin/main/data/timeout.json';
                $data['Timeout']    = $this->_arrayParam['form']['timeout'];
                file_put_contents($linkConfigTimeout, json_encode($data));

                Session::set('message', array('class' => 'success', 'icon' => 'fa-info', 'content' => 'Cấu hình Timeout thành công!'));   
                URL::redirect('admin', 'index', 'configTimeout');
            } else {
                $this->_view->errors = $validate->showErrors();
            }
        }
        $this->_view->render('index/configTimeout');
    }
}
