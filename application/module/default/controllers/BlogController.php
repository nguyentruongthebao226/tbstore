<?php
class BlogController extends Controller{

    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('default/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    // List Blog
    public function listAction(){
        error_reporting(E_WARNING);
        $this->_view->_title                = 'Tin tức';
        $totalItems                 = $this->_model->countItem($this->_arrayParam, array('task' => 'blogs'));      
        $configPagination           = array('totalItemsPerPage' => 4, 'pageRange' => 3 );
        $this->setPagination($configPagination);
        $this->_view->pagination    = new Pagination($totalItems, $this->_pagination);
        $this->_view->Items         = $this->_model->listItem($this->_arrayParam, array('task' => 'blogs'));
   
        $this->_view->render('blog/list', true);
    }

    // Detail Blog
    public function detailAction(){
        $this->_view->_title                = 'Chi tiết';
        $this->_view->blogInfo           = $this->_model->infoItem($this->_arrayParam, array('task' => 'blog-info'));
        $this->_view->render('blog/detail', true);
    }

}