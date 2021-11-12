<?php
class UserController extends Controller{

    public function __construct($arrParams){
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('admin/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    
    // Hiển thị danh sách user
    public function indexAction(){
        $this->_view->_title        = 'User Manager';
        $totalItems                 = $this->_model->countItem($this->_arrayParam, null);
        $configPagination           = array('totalItemsPerPage' => 4, 'pageRange' => 3 );
        $this->setPagination($configPagination);
        $this->_view->pagination    = new Pagination($totalItems, $this->_pagination);

        $this->_view->slbGroup      = $this->_model->itemInSelectBox($this->_arrayParam, null);
        $this->_view->Items         = $this->_model->listItem($this->_arrayParam, null);
        $this->_view->render('user/index', true);
    }

    // Thêm và Edit user
    public function formAction(){
  
        $this->_view->_title = 'User: Add';
        error_reporting(E_WARNING);
        $this->_view->slbGroup      = $this->_model->itemInSelectBox($this->_arrayParam, null);
        if(isset($this->_arrayParam['id'])){           
            $this->_view->_title = 'User: Edit';
            $this->_arrayParam['form'] = $this->_model->infoItem($this->_arrayParam);
            if(empty($this->_arrayParam['form'])) URL::redirect('admin', 'user', 'index');
        }
        
        if($this->_arrayParam['form']['token'] > 0){
            $task   = 'add';
            $requirePass   = true;
            $queryUserName = "Select `id` From `".TBL_USER."` Where `username` = '".$this->_arrayParam['form']['username']."'";
            $queryEmail    = "Select `id` From `".TBL_USER."` Where `email` = '".$this->_arrayParam['form']['email']."'";
            if(isset($this->_arrayParam['form']['id'])){
                $task   = 'edit';
                $requirePass   = false;
                $queryUserName .= "AND `id` <> '".$this->_arrayParam['form']['id']."'";
                $queryEmail    .= "AND `id` <> '".$this->_arrayParam['form']['id']."'";  
            }

            
            $validate      = new Validate($this->_arrayParam['form']);
            $validate->addRule('username', 'string-notExistRecord', array('database' => $this->_model, 'query' => $queryUserName, 'min' => 3, 'max' => 25 ))
                     ->addRule('email', 'email-notExistRecord', array('database' => $this->_model, 'query' => $queryEmail, 'min' => 3, 'max' => 25 ))
                     ->addRule('password', 'password', array('action' => $task), $requirePass)
                     ->addRule('ordering', 'int', array('min' => 1, 'max' => 100))
                     ->addRule('status', 'status', array('deny' => array('default')))
                     ->addRule('group_id', 'status', array('deny' => array('default')));
            $validate->run();
            $this->_arrayParam['form'] = $validate->getResult();
            if($validate->isValid() == false){
                $this->_view->errors = $validate->showErrors();
            }else{
                // Insert Database
                $id     = $this->_model->saveItem($this->_arrayParam, array('task' => $task));
                $type   = $this->_arrayParam['type'];
                if($type == 'save-close')   URL::redirect('admin', 'user', 'index');
                if($type == 'save-new')     URL::redirect('admin', 'user', 'form');
                if($type == 'save')         URL::redirect('admin', 'user', 'form', array('id' => $id));
            }                  
        }
        $this->_view->arrParam = $this->_arrayParam;
        $this->_view->render('user/form', true);
    }

    // ACTION: AJAX STATUS (*)
    public function ajaxStatusAction(){
        $result = $this->_model->changeStatus($this->_arrayParam, array('task' => 'change-ajax-status'));
        echo json_encode($result);
    }


    // ACTION: Status
    public function statusAction(){
        $this->_model->changeStatus($this->_arrayParam, array('task' => 'change-status'));
        URL::redirect('admin', 'user', 'index');
    }

    // ACTION: Delete (*)
    public function deleteAction(){
        $this->_model->deleteItem($this->_arrayParam);
        URL::redirect('admin', 'user', 'index');
    }

    // ACTION: Ordering (*)
    public function orderingAction(){
        $this->_model->ordering($this->_arrayParam);
        URL::redirect('admin', 'user', 'index');
    }

    
}