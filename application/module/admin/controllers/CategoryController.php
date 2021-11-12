<?php
class CategoryController extends Controller{

    public function __construct($arrParams){
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('admin/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    
    // Hiển thị danh sách category
    public function indexAction(){
        $this->_view->_title        = 'Category';
        $totalItems                 = $this->_model->countItem($this->_arrayParam, null);
        $configPagination           = array('totalItemsPerPage' => 5, 'pageRange' => 2 );
        $this->setPagination($configPagination);
        $this->_view->pagination    = new Pagination($totalItems, $this->_pagination);
        $this->_view->Items         = $this->_model->listItem($this->_arrayParam, null);
        $this->_view->render('category/index', true);
    }

    // Thêm và Edit category
    public function formAction(){
        $this->_view->_title = 'Category: Add';
        if(!empty($_FILES)) $this->_arrayParam['form']['picture'] = $_FILES['picture'];
        error_reporting(E_WARNING);
        if(isset($this->_arrayParam['id'])){
            $this->_view->_title = 'Category: Edit';
            $this->_arrayParam['form'] = $this->_model->infoItem($this->_arrayParam);
            if(empty($this->_arrayParam['form'])) URL::redirect('admin', 'category', 'index');
        }

        if($this->_arrayParam['form']['token'] > 0){
            $validate   = new Validate($this->_arrayParam['form']);
            $validate->addRule('name', 'string', array('min' => 3, 'max' => 255))
                     ->addRule('ordering', 'int', array('min' => 1, 'max' => 100))
                     ->addRule('status', 'status', array('deny' => array('default')))
                     ->addRule('picture', 'file', array('min' => 100, 'max' => 1000000, 'extension' => array('jpg', 'png', 'jfif')), false);
            $validate->run();
            $this->_arrayParam['form'] = $validate->getResult();
            if($validate->isValid() == false){
                $this->_view->errors = $validate->showErrors();
            }else{
                // Insert Database
                $task   = (isset($this->_arrayParam['form']['id'])) ? 'edit' : 'add';
                $id     = $this->_model->saveItem($this->_arrayParam, array('task' => $task));
                $type   = $this->_arrayParam['type'];
                if($type == 'save-close')   URL::redirect('admin', 'category', 'index');
                if($type == 'save-new')     URL::redirect('admin', 'category', 'form');
                if($type == 'save')         URL::redirect('admin', 'category', 'form', array('id' => $id));
            }                  
        }
        $this->_view->arrParam = $this->_arrayParam;
        $this->_view->render('category/form', true);
    }


    // ACTION: AJAX STATUS (*)
    public function ajaxStatusAction(){
        $result = $this->_model->changeStatus($this->_arrayParam, array('task' => 'change-ajax-status'));
        echo json_encode($result);
    }

    // ACTION: Status
    public function statusAction(){
        $this->_model->changeStatus($this->_arrayParam, array('task' => 'change-status'));
        URL::redirect('admin', 'category', 'index');
    }

    // ACTION: Delete (*)
    public function deleteAction(){
        $this->_model->deleteItem($this->_arrayParam);
        URL::redirect('admin', 'category', 'index');
    }


    // ACTION: Ordering (*)
    public function orderingAction(){
        $this->_model->ordering($this->_arrayParam);
        URL::redirect('admin', 'category', 'index');
    }

    
}