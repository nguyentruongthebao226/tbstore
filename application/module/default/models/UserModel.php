<?php
class UserModel extends Model
{

    private $_columns = array('id', 'username', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'register_date', 'register_ip', 'status', 'ordering', 'group_id');
    private $_userInfo;

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_USER);
        $userObj            = Session::get('user');
        $this->_userInfo    = $userObj['info'];
    }

    public function listItem($arrParam, $option = null)
    {
        if ($option['task'] == 'products-in-cart') {

            if (isset($arrParam['product_id_trash_all']) || $arrParam['product_id_trash_all'] == 'delete-all-cart') {
                Session::delete('cart');
                URL::redirect('default', 'user', 'cart', null, 'cart.html');
            } else {
                $cart   = Session::get('cart');
            }

            if (isset($arrParam['product_id_trash'])) {
                unset($cart['quantity'][$arrParam['product_id_trash']]);
                unset($cart['price'][$arrParam['product_id_trash']]);
                unset($cart['size'][$arrParam['product_id_trash']]);
                $cartNew   = Session::set('cart', $cart);
                URL::redirect('default', 'user', 'cart', null, 'cart.html');
            } else {
                $cartNew   = Session::get('cart');
            }

            $result = array();
            if (!empty($cartNew)) {
                $ids    = "(";
                foreach ($cartNew['quantity'] as $key => $value) $ids .= "'$key',";
                $ids   .= "'0')";
                // $query[]    = "Select `id`, `name`, `picture`";
                // $query[]    = "From `" . TBL_PRODUCT . "`";
                // $query[]    = "Where `status` = 1 And `id` IN $ids ";

                $query[]    = "Select `p`.`id`, `p`.`name`, `p`.`picture`, `p`.`category_id`, `c`.`name` as `category_name`";
                $query[]    = "From `".TBL_PRODUCT."` as `p`, `".TBL_CATEGORY."` as `c` ";
                $query[]    = "Where `p`.`status` = 1 And `p`.`id` IN $ids And `p`.`category_id` = `c`.`id` ";

                $query      = implode(" ", $query);
                $result     = $this->fetchAll($query);

                foreach ($result as $key => $value) {
                    $result[$key]['size']       = $cartNew['size'][$value['id']];
                    $result[$key]['quantity']   = $cartNew['quantity'][$value['id']];
                    $result[$key]['totalprice'] = $cartNew['price'][$value['id']];
                    $result[$key]['price']      = $result[$key]['totalprice'] / $result[$key]['quantity'];
                }
            }
            return $result;
        }

        if ($option['task'] == 'history-cart') {
            $username   = $this->_userInfo['username'];

            $query[]    = "Select `id`, `fullname`, `address`, `phone`, `products`, `prices`, `sizes`, `quantities`, `names`, `pictures`, `status`, `date`";
            $query[]    = "From `" . TBL_CART . "`";
            $query[]    = "Where `username` = '$username' ";
            $query[]    = "Order by `date` ASC";

            $query      = implode(" ", $query);
            $result     = $this->fetchAll($query);

            return $result;
        }
    }

    public function saveItem($arrParam, $option = null)
    {
        if ($option['task'] == 'submit-cart') {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $id         = $this->randomString(7);
            $username   = $this->_userInfo['username'];
            $products   = json_encode($arrParam['form']['productid']);
            $prices     = json_encode($arrParam['form']['price']);
            $sizes      = json_encode($arrParam['form']['size']);
            $quantities = json_encode($arrParam['form']['quantity']);
            $names      = json_encode($arrParam['form']['name']);
            $pictures   = json_encode($arrParam['form']['picture']);
            $date       = date('Y-m-d H:i:s', time());
            $fullname   = $arrParam['form']['fullname'];
            $address    = $arrParam['form']['address'];
            $phone      = $arrParam['form']['phone'];

            $query      = "Insert Into `" . TBL_CART . "`(`id` , `username`, `fullname`, `address`, `phone`, `products`, `prices`, `sizes`, `quantities`, `names`, `pictures`, `status`, `date`)
                           Values ('$id', '$username', '$fullname', '$address', '$phone', '$products', '$prices', '$sizes', '$quantities', '$names', '$pictures', '0', '$date')";

            $this->query($query);
            Session::delete('cart');
            //Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'Dữ liệu được lưu thành công!'));  
        }

        if ($option['task'] == 'change-password') {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $arrParam['form']['modified']    = date('Y-m-d', time());
            $arrParam['form']['modified_by'] = $this->_userInfo['username'];
            $arrParam['form']['password']    = md5($arrParam['form']['password']);
            
            $data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
            $this->update($data, array(array('id',  $this->_userInfo['id'])));
            
            Session::delete('user');
            Session::set('success', 'Đổi mật khẩu thành công, vui lòng đăng nhập lại!');   
        }
    }

    private function randomString($length = 5)
    {
        $arrCharacter = array_merge(range('a', 'z'), range(0, 9), range('A', 'Z'));
        $arrCharacter = implode('', $arrCharacter);
        $arrCharacter = str_shuffle($arrCharacter);

        $result        = substr($arrCharacter, 0, $length);
        return $result;
    }
}
