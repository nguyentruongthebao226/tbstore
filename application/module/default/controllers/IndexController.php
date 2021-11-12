<?php
class IndexController extends Controller{

    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('default/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }
    public function noticeAction(){
        $this->_view->_title                = 'Thông báo';
        $this->_view->render('index/notice', true);
    }

    public function contactAction(){
        
        $this->_view->_title                = 'Liên hệ';
        // require_once ''.LIBRARY_PATH.'Mail/Mail.class.php';
        if(isset($this->_arrayParam['form']['token'])){
            $validate      = new Validate($this->_arrayParam['form']);
            $validate->addRule('name', 'string', array('min' => 3, 'max' => 50))
                    ->addRule('email', 'email')
                    ->addRule('subject', 'string', array('min' => 3, 'max' => 100))
                    ->addRule('description', 'string', array('min' => 3, 'max' => 50));
            $validate->run();
            $this->_arrayParam['form'] = $validate->getResult();
            if ($validate->isValid() == false) {
                $this->_view->errors = $validate->showErrorsPublic();
            } else {
                require_once ''.LIBRARY_PATH.'Mail/Mail.class.php';
                $mail = new Mail();
                $mail->sendMail($this->_arrayParam['form'], array('task' => 'send-mail-to-admin'));
                $mail->sendMail($this->_arrayParam['form'], array('task' => 'send-mail-to-user'));
                Session::set('successContact', 'Gửi form thành công!');
                header('location: contact.html');
                exit();
            }
        }
        
        $this->_view->render('index/contact', true);
    }

    public function aboutAction(){
        
        $this->_view->_title                = 'Giới thiệu';
       
        $this->_view->render('index/about', true);
    }

    public function indexAction(){
        $this->_view->_title                = 'TB Store';
        $this->_view->ItemsCategory         = $this->_model->listItem($this->_arrayParam, array('task' => 'list-category'));
        //$this->_view->
        $this->_view->Blogs                 = $this->_model->listItem($this->_arrayParam, array('task' => 'blogs'));
        $this->_view->SpecialProducts       = $this->_model->listItem($this->_arrayParam, array('task' => 'products-special'));
        $this->_view->SaleOffProducts       = $this->_model->listItem($this->_arrayParam, array('task' => 'products-saleoff'));
        $this->_view->render('index/index', true);
    }

    public function registerAction()
    {
        $userInfo   = Session::get('user');
        if ($userInfo['login'] == true && $userInfo['time'] + TIME_LOGIN >= time()) {
            URL::redirect('default', 'user', 'index', null, 'my-account.html');
        }
        error_reporting(E_WARNING);
        $this->_view->_title        = 'Đăng ký';
        if (isset($this->_arrayParam['form']['username'])) {      
            URL::checkRefreshPage($this->_arrayParam['form']['token'], 'default', 'user', 'register', 'register.html');

            $queryUserName = "Select `id` From `" . TBL_USER . "` Where `username` = '" . $this->_arrayParam['form']['username'] . "'";
            $queryEmail    = "Select `id` From `" . TBL_USER . "` Where `email` = '" . $this->_arrayParam['form']['email'] . "'";

            $validate      = new Validate($this->_arrayParam['form']);
            $validate->addRule('username', 'string-notExistRecord', array('database' => $this->_model, 'query' => $queryUserName, 'min' => 3, 'max' => 25))
                ->addRule('email', 'email-notExistRecord', array('database' => $this->_model, 'query' => $queryEmail, 'min' => 3, 'max' => 25))
                ->addRule('password', 'password', array('action' => 'add'))
                ->addRule('captcha_code', 'captcha');
            $validate->run();
            $this->_arrayParam['form'] = $validate->getResult();
            if ($validate->isValid() == false) {
                $this->_view->errors = $validate->showErrorsPublic();
            } else {
                // Insert Database
                $id     = $this->_model->saveItem($this->_arrayParam, array('task' => 'user-register'));
                URL::redirect('default', 'index', 'notice', array('type' => 'register-success'), 'dangky-thanhcong.html');
            }
        }
        $this->_view->render('index/register', true);
    }

    public function loginAction()
    {
        $userInfo   = Session::get('user');
        if ($userInfo['login'] == true && $userInfo['time'] + TIME_LOGIN >= time()) {
            URL::redirect('default', 'user', 'index', null, 'my-account.html');
        }
        error_reporting(E_WARNING);

        $this->_view->_title        = 'Đăng nhập';

        if ($this->_arrayParam['form']['token'] > 0) {
            $validate = new Validate($this->_arrayParam['form']);
            $email    = $this->_arrayParam['form']['email'];
            $password = md5($this->_arrayParam['form']['password']);
            $query    = "Select `id` From `user` Where `email` = '$email' AND `password` = '$password'";
            $validate->addRule('email', 'existRecord', array('database' => $this->_model, 'query' => $query));
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
                URL::redirect('default', 'user', 'index', null, 'my-account.html');
            } else {
                $this->_view->errors = $validate->showErrorsPublic();
            }
        }
        $this->_view->render('index/login');
    }

    public function logoutAction()
    {
        Session::delete('user');
        URL::redirect('default', 'index', 'index', null, 'index.html');
    }

}