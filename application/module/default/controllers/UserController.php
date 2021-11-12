<?php
class UserController extends Controller
{
    private $_changedPass;
    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('default/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    public function indexAction()
    {
        error_reporting(E_WARNING);
        $this->_view->_title    = 'Thông tin người dùng';     
        if($this->_arrayParam['form']['token'] > 0){
            if(md5($this->_arrayParam['form']['old_password']) == $this->_arrayParam['form']['current_password']){
                $validate      = new Validate($this->_arrayParam['form']);
                $validate->addRule('password', 'password', array('action' => 'add'));
                $validate->run();
                $this->_arrayParam['form'] = $validate->getResult();
                if($validate->isValid() == false){           
                    $this->_view->errors =  $validate->showErrorsPublic();
                }else{
                    // Insert Database
                    $this->_model->saveItem($this->_arrayParam, array('task' => 'change-password'));     
                    URL::redirect('default', 'index', 'login', null, 'login.html'); 
                }                  
            }else{
                Session::set('errorPassword', 'Mật khẩu cũ không đúng!');
            }
        }
        
        $this->_view->render('user/index', true);
    }

    public function orderAction()
    {
        error_reporting(E_WARNING);
        $cart       = Session::get('cart');
        $productID  = $this->_arrayParam['product_id'];
        $price      = $this->_arrayParam['price'];
        $idProOrd    = $this->_arrayParam['product_id'];
        $cateIDOrd   = $this->_arrayParam['category_id'];
        $cateNameOrd = URL::filterURL($this->_arrayParam['category_name']);
        $nameProOrd  = $this->_arrayParam['name'];
        $nameURLOrd  = URL::filterURL($nameProOrd);
        if(!empty($this->_arrayParam['size'])){
            if($this->_arrayParam['size'] == 'default'){
                // echo '<pre>';
                // print_r($this->_arrayParam);
                // echo '</pre>';
                // die('Function Die...');         
                Session::set('messageSize', 'Bạn chưa chọn size sản phẩm!');
                URL::redirect('default', 'product', 'detail', array('product_id' => $productID), "$cateNameOrd/$nameURLOrd-$cateIDOrd-$idProOrd.html");
            }else{
                $size       = $this->_arrayParam['size'];
            }
        }else{
                Session::set('messageSize', 'Sản phẩm tạm hết hàng!');
                URL::redirect('default', 'product', 'detail', array('product_id' => $productID), "$cateNameOrd/$nameURLOrd-$cateIDOrd-$idProOrd.html");
        }
        
        

        // $cart['product_id'][$productID]     = $idProOrd;
        // $cart['product_name'][$productID]   = $nameProOrd;
        // $cart['category_id'][$productID]    = $cateIDOrd;
        // $cart['category_name'][$productID]  = $this->_arrayParam['category_name'];

        if(empty($cart)){
            $cart['quantity'][$productID]   = 1;
            $cart['price'][$productID]      = $price;
            $cart['size'][$productID]       = $size;                    
        }else{
            if(key_exists($productID, $cart['quantity'])){
                $cart['quantity'][$productID]  += 1;
                $cart['price'][$productID]      = $price * $cart['quantity'][$productID];
                $cart['size'][$productID]       = $cart['size'][$productID] . ',' . $size ; 
            }else{
                $cart['quantity'][$productID]   = 1;
                $cart['price'][$productID]      = $price;
                $cart['size'][$productID]       = $size;   
            }
        }
        Session::set('cart', $cart);
        URL::redirect('default', 'product', 'detail', array('product_id' => $productID), "$cateNameOrd/$nameURLOrd-$cateIDOrd-$idProOrd.html");
    }

    public function cartAction()
    {     
        error_reporting(E_WARNING);
        $this->_view->_title    = 'Giỏ hàng';
        $this->_view->Items     = $this->_model->listItem($this->_arrayParam, array('task' => 'products-in-cart'));
        $this->_view->render('user/cart', true);
    }

    public function buyAction()
    {     
        error_reporting(E_WARNING);
        if(!empty($this->_arrayParam['form']['quantity'])){
            $validate      = new Validate($this->_arrayParam['form']);
            $validate->addRule('fullname', 'string', array('min' => 1, 'max' => 100))
                     ->addRule('address', 'string', array('min' => 1, 'max' => 255))
                     ->addRule('phone', 'string', array('min' => 1, 'max' => 20));
            $validate->run();
            $this->_arrayParam['form'] = $validate->getResult();
            if($validate->isValid() == false){               
                Session::set('messageErrors', $validate->showErrorsPublic());
                Session::set('validForm', $this->_arrayParam);
                URL::redirect('default','user','cart', null, 'cart.html');
            }else{
                // Insert Database
                $this->_model->saveItem($this->_arrayParam, array('task' => 'submit-cart'));
                URL::redirect('default', 'index', 'notice', array('type' => 'buy-success'), 'muahang-thanhcong.html');
            }                  
        }
        $this->_view->arrParam = $this->_arrayParam;    
    }

    public function historyAction()
    {     
        error_reporting(E_WARNING);
        $this->_view->_title    = 'Đơn hàng đã đặt';
        $this->_view->Items     = $this->_model->listItem($this->_arrayParam, array('task' => 'history-cart'));
        $this->_view->render('user/history', true);
    }

    
}
