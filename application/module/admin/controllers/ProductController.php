<?php
class ProductController extends Controller{

    public function __construct($arrParams){
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('admin/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    
    // Hiển thị danh sách product
    public function indexAction(){
        $this->_view->_title        = 'Product Manager';
        $totalItems                 = $this->_model->countItem($this->_arrayParam, null);
        $configPagination           = array('totalItemsPerPage' => 5, 'pageRange' => 3 );
        $this->setPagination($configPagination);
        $this->_view->pagination    = new Pagination($totalItems, $this->_pagination);

        $this->_view->slbCategory   = $this->_model->itemInSelectBox($this->_arrayParam, null);
        $this->_view->Items         = $this->_model->listItem($this->_arrayParam, null);
        $this->_view->render('product/index', true);
    }

    // Thêm và Edit product
    public function formAction(){

        $this->_view->_title = 'Product: Add';
        error_reporting(E_WARNING);
        $this->_view->slbCategory      = $this->_model->itemInSelectBox($this->_arrayParam, null);
        if(!empty($_FILES)) $this->_arrayParam['form']['picture'] = $_FILES['picture'];

        if(isset($this->_arrayParam['id'])){           
            $this->_view->_title = 'Product: Edit';
            $this->_arrayParam['form'] = $this->_model->infoItem($this->_arrayParam);
            // echo '<pre>';
            // print_r($this->_arrayParam['form']);
            // echo '</pre>';
            if(empty($this->_arrayParam['form'])) URL::redirect('admin', 'product', 'index');
        }
        
        if($this->_arrayParam['form']['token'] > 0){
            $task   = 'add';
            if(isset($this->_arrayParam['form']['id'])){
                $task   = 'edit';       
            }

            
            $validate      = new Validate($this->_arrayParam['form']);
            $validate->addRule('name', 'string', array('min' => 1, 'max' => 255))
                     ->addRule('picture', 'file', array('min' => 100, 'max' => 1000000, 'extension' => array('jpg', 'png', 'jfif')), false)
                     ->addRule('ordering', 'int', array('min' => 1, 'max' => 100))
                     ->addRule('status', 'status', array('deny' => array('default')))
                     ->addRule('special', 'status', array('deny' => array('default')))
                     ->addRule('category_id', 'status', array('deny' => array('default')))
                     ->addRule('price', 'int', array('min' => 1000, 'max' => 10000000))
                     ->addRule('sale_off', 'int', array('min' => 0, 'max' => 100));
            $validate->run();
            $this->_arrayParam['form'] = $validate->getResult();
            if($validate->isValid() == false){
                $this->_view->errors = $validate->showErrors();
            }else{
                // Insert Database
                $id     = $this->_model->saveItem($this->_arrayParam, array('task' => $task));
                $type   = $this->_arrayParam['type'];
                if($type == 'save-close')   URL::redirect('admin', 'product', 'index');
                if($type == 'save-new')     URL::redirect('admin', 'product', 'form');
                if($type == 'save')         URL::redirect('admin', 'product', 'form', array('id' => $id));
            }                  
        }
        $this->_view->arrParam = $this->_arrayParam;
        $this->_view->render('product/form', true);
    }

    // ACTION: AJAX STATUS (*)
    public function ajaxStatusAction(){
        $result = $this->_model->changeStatus($this->_arrayParam, array('task' => 'change-ajax-status'));
        echo json_encode($result);
    }

    // ACTION: AJAX SPECIAL (*)
    public function ajaxSpecialAction(){
        $result = $this->_model->changeStatus($this->_arrayParam, array('task' => 'change-ajax-special'));
        echo json_encode($result);
    }


    // ACTION: Status
    public function statusAction(){
        $this->_model->changeStatus($this->_arrayParam, array('task' => 'change-status'));
        URL::redirect('admin', 'product', 'index');
    }

    // ACTION: Delete (*)
    public function deleteAction(){
        $this->_model->deleteItem($this->_arrayParam);
        URL::redirect('admin', 'product', 'index');
    }

    // ACTION: Ordering (*)
    public function orderingAction(){
        $this->_model->ordering($this->_arrayParam);
        URL::redirect('admin', 'product', 'index');
    }

    
}