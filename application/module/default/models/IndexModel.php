<?php
class IndexModel extends Model{

    private $_columns = array('id', 'username', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'register_date', 'register_ip', 'status', 'ordering', 'group_id');

    public function __construct(){
        parent::__construct();
        $this->setTable(TBL_USER);
    }

    public function saveItem($arrParam, $option = null){
        if($option['task'] == 'user-register'){
            $arrParam['form']['password']        = md5($arrParam['form']['password']);
            $arrParam['form']['register_date']   = date("Y-m-d H:m:s", time());
            $arrParam['form']['register_ip']     = $_SERVER['REMOTE_ADDR'];
            $arrParam['form']['status']          = 1;
            $data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
            $this->insert($data);
            return $this->lastID();
        }
    }

    public function infoItem($arrParam, $option = null){
        if($option == null){ 
            $email = $arrParam['form']['email'];
            $password = md5($arrParam['form']['password']);
            $query[]  = "Select `u`.`id`, `u`.`fullname`, `u`.`email`, `u`.`password`, `u`.`username`, `u`.`group_id`, `g`.`group_acp`, `g`.`privilege_id`";
            $query[]  = "From `user` as `u` Left Join `group` As `g` On `u`.`group_id` = `g`.`id`";
            $query[]  = "Where `email` = '$email' AND `password` = '$password'";

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

    public function listItem($arrParam, $option = null){
        if($option['task'] == 'list-category'){
            $query[]    = "Select `id`, `name`, `picture`";
            $query[]    = "From `".TBL_CATEGORY."` ";
            $query[]    = "WHERE `status` = 1"; 
            $query[]    = "ORDER BY `ordering` ASC ";

            $query      = implode(" ", $query);
            $result     = $this->fetchAll($query);
            return $result;
        }

        if($option['task'] == 'blogs'){
            $query[]    = "Select `id`, `name`, `description`, `created`, `picture`";
            $query[]    = "From `".TBL_BLOG."` ";
            $query[]    = "WHERE `status` = 1"; 
            $query[]    = "ORDER BY `id` DESC ";

            $query      = implode(" ", $query);
            $result     = $this->fetchAll($query);
            return $result;
        }

        if($option['task'] == 'products-special'){
            $query[]    = "Select `p`.`id`, `p`.`name`, `p`.`picture`, `p`.`price`, `p`.`sale_off`, `p`.`special`, `p`.`category_id`, `c`.`name` as `category_name`";
            $query[]    = "From `".TBL_PRODUCT."` as `p`, `".TBL_CATEGORY."` as `c` ";
            $query[]    = "WHERE `p`.`status` = 1 And `p`.`special` = 1 and `p`.`category_id` = `c`.`id`"; 
            $query[]    = "ORDER BY `p`.`id` ASC ";

            $query      = implode(" ", $query);
            $result     = $this->fetchAll($query);
            return $result;
        }  

        if($option['task'] == 'products-saleoff'){
            $query[]    = "Select `p`.`id`, `p`.`name`, `p`.`picture`, `p`.`price`, `p`.`sale_off`, `p`.`special`, `p`.`category_id`, `c`.`name` as `category_name`";
            $query[]    = "From `".TBL_PRODUCT."` as `p`, `".TBL_CATEGORY."` as `c` ";
            $query[]    = "WHERE `p`.`status` = 1 And `p`.`sale_off` > 1 and `p`.`category_id` = `c`.`id`"; 
            $query[]    = "ORDER BY `p`.`sale_off` DESC ";

            $query      = implode(" ", $query);
            $result     = $this->fetchAll($query);
            return $result;
        }  
        
    }
}