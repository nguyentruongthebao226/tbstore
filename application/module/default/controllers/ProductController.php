<?php
class ProductController extends Controller{

    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        error_reporting(E_WARNING);
        $this->_templateObj->setFolderTemplate('default/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    // List Product
    public function listAction(){
        error_reporting(E_WARNING);
        $this->_view->_title                = 'Sản phẩm';
        $val = null;
        switch($this->_arrayParam['options']){
            case 'all-products':
                $val = 'all-products';
                break;
            case 'special-products':
                $val = 'special-products';
                break;
            case 'saleoff-products':
                $val = 'saleoff-products';
                break;
            default:
                $val = 'products-in-cat';
        }
        $totalItems                 = $this->_model->countItem($this->_arrayParam, array('task' => $val));
        $configPagination           = array('totalItemsPerPage' => 9, 'pageRange' => 3 );
        $this->setPagination($configPagination);
        $this->_view->pagination    = new Pagination($totalItems, $this->_pagination);

        if(isset($this->_arrayParam['filter']) && isset($this->_arrayParam['options']) && $this->_arrayParam['filter'] == 2){
            URL::redirect('default', 'product', 'list', array('options' => 'special-products'), 'special.html');
        }
        if(isset($this->_arrayParam['filter']) && isset($this->_arrayParam['options']) && $this->_arrayParam['filter'] == 3){
            URL::redirect('default', 'product', 'list', array('options' => 'saleoff-products'), 'sale-off.html');
        }
        if(isset($this->_arrayParam['category_id'])){
            $this->_view->categoryName          = $this->_model->infoItem($this->_arrayParam, array('task' => 'get-cat-name'));
            $this->_view->Items                 = $this->_model->listItem($this->_arrayParam, array('task' => 'products-in-cat'));
        }
        if(isset($this->_arrayParam['options'])){           
            switch($this->_arrayParam['options']){
                case 'all-products':
                    $this->_view->categoryName          = 'Tất cả sản phẩm';
                    $this->_view->Items                 = $this->_model->listItem($this->_arrayParam, array('task' => 'all-products'));
                    break;
                case 'special-products':
                    $this->_view->categoryName          = 'Sản phẩm bán chạy';
                    $this->_view->Items                 = $this->_model->listItem($this->_arrayParam, array('task' => 'special-products'));
                    break;
                case 'saleoff-products':
                    $this->_view->categoryName          = 'Sản phẩm đang được giảm giá';
                    $this->_view->Items                 = $this->_model->listItem($this->_arrayParam, array('task' => 'saleoff-products'));
                    break;
            }
        }
        
       
        $this->_view->render('product/list', true);
    }

    // Detail Product
    public function detailAction(){
        $this->_view->_title                = 'Info Product';      
        $this->_view->productInfo           = $this->_model->infoItem($this->_arrayParam, array('task' => 'product-info'));
        $this->_view->categoryName          = $this->_model->infoItem($this->_arrayParam, array('task' => 'get-cat-name'));
        $this->_view->productRelate         = $this->_model->listItem($this->_arrayParam, array('task' => 'products-relate'));
        $this->_view->render('product/detail', true);
    }

}