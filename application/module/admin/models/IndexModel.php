<?php
class IndexModel extends Model{
    private $_columns = array('id', 'username', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'group_id');
    private $_userInfo;

    public function __construct(){
        parent::__construct();
        $this->setTable(TBL_USER);
        $userObj            = Session::get('user');
        $this->_userInfo    = $userObj['info'];
    }

    public function countItem($option = null){
        if($option['task'] == 'user'){
            $query[]    = "Select COUNT(`id`) AS `total`";
            $query[]    = "From `".TBL_USER."` ";
            $query[]    = "WHERE `id` > 0"; 
            
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result['total'];
        }

        if($option['task'] == 'group'){
            $query[]    = "Select COUNT(`id`) AS `total`";
            $query[]    = "From `".TBL_GROUP."` ";
            $query[]    = "WHERE `id` > 0"; 
            
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result['total'];
        }

        if($option['task'] == 'cart'){
            $query[]    = "Select COUNT(`id`) AS `total`";
            $query[]    = "From `".TBL_CART."` ";
            $query[]    = "WHERE `id` > 0"; 
            
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result['total'];
        }

        if($option['task'] == 'product'){
            $query[]    = "Select COUNT(`id`) AS `total`";
            $query[]    = "From `".TBL_PRODUCT."` ";
            $query[]    = "WHERE `id` > 0"; 
            
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result['total'];
        }

        if($option['task'] == 'category'){
            $query[]    = "Select COUNT(`id`) AS `total`";
            $query[]    = "From `".TBL_CATEGORY."` ";
            $query[]    = "WHERE `id` > 0"; 
            
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result['total'];
        }

        if($option['task'] == 'blog'){
            $query[]    = "Select COUNT(`id`) AS `total`";
            $query[]    = "From `".TBL_BLOG."` ";
            $query[]    = "WHERE `id` > 0"; 
            
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result['total'];
        }
    }

    public function infoItem($arrParam, $option = null){
        if($option == null){ 
            $username = $arrParam['form']['username'];
            $password = md5($arrParam['form']['password']);
            $query[]  = "Select `u`.`id`, `u`.`fullname`, `u`.`email`, `u`.`password`, `u`.`username`, `u`.`group_id`, `g`.`group_acp`, `g`.`privilege_id`";
            $query[]  = "From `user` as `u` Left Join `group` As `g` On `u`.`group_id` = `g`.`id`";
            $query[]  = "Where `username` = '$username' AND `password` = '$password'";

            $query    = implode(" ", $query);
            $result   = $this->fetchRow($query);

            if($result['group_acp'] == 1){
                $arrPrivilege   = explode(',', $result['privilege_id']);
                $strPrivilegeID = '';
                foreach($arrPrivilege as $privilegeID) $strPrivilegeID .= "'$privilegeID', ";
                $queryP[] = "Select `id`, CONCAT(`module`, '-', `controller`, '-', `action`) as `name`";
                $queryP[] = "From `".TBL_PRIVILEGE."` as p";
                $queryP[] = "Where id IN ($strPrivilegeID '0')";

                $queryP   = implode(" ", $queryP);
                $result['privilege'] =  $this->fetchPairs($queryP);
                
            }
            
            return $result;
        }

        if($option == 'profile'){ 
            $query[]    = "Select `id`, `username`, `email`, `fullname`, `group_id`, `status`, `ordering`";
            $query[]    = "From `$this->table` ";
            $query[]    = "WHERE `id` = '".$arrParam['id']."' "; 
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result;
        }
    }

    public function saveItem($arrParam, $option = null){
        if($option['task'] == 'edit'){ 
          
            $arrParam['form']['modified']    = date('Y-m-d', time());
            $arrParam['form']['modified_by'] = $this->_userInfo['username'];
            if($arrParam['form']['password'] != null){
                $arrParam['form']['password']   = md5($arrParam['form']['password']);
            }else{
                unset($arrParam['form']['password']);
            }
            $data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            // die('Function Die...');
            $this->update($data, array(array('id', $arrParam['form']['id'])));
            Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'Dữ liệu được chỉnh sửa thành công!'));   
            return $arrParam['form']['id'];   
        }
    }
}