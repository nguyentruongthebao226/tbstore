<?php
class UserModel extends Model{

    private $_columns = array('id', 'username', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'group_id');
    private $_userInfo;

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_USER);
        $userObj            = Session::get('user');
        $this->_userInfo    = $userObj['info'];
    }

    public function countItem($arrParam, $option = null){
        $query[]    = "Select COUNT(`id`) AS `total`";
        $query[]    = "From `$this->table` ";
        $query[]    = "WHERE `id` > 0"; 

        // Filter: Keyword
        if(!empty($arrParam['filter_search'])){
            $keyword    = '"%'. $arrParam['filter_search'] .'%"';
            $query[]    = "AND (`username` LIKE $keyword OR `email` LIKE $keyword )"; 
        }

        // Filter: Status
        if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
            $query[]    = "And `status` = '".$arrParam['filter_state']."' ";        
        }

        // Filter: Group ID
        if(isset($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default'){
            $query[]    = "And `group_id` = '".$arrParam['filter_group_id']."' "; 
        }

        $query      = implode(" ", $query);
        $result     = $this->fetchRow($query);
        return $result['total'];
    }

    public function itemInSelectbox($arrParam, $option = null){
        if($option == null){
            $query  = "Select `id`, `name` From `".TBL_GROUP."`";
            $result = $this->fetchPairs($query);
            $result['default'] = "- Select Group -";
            ksort($result);
        }
        return $result;
    }

    public function listItem($arrParam, $option = null){
        $query[]    = "Select `u`.`id`, `u`.`username`, `u`.`email`, `u`.`fullname`, `u`.`status`, `u`.`ordering`, `u`.`created`, `u`.`created_by`, `u`.`modified`, `u`.`modified_by`, `g`.`name` as `group_name`";
        $query[]    = "From `$this->table` as `u` LEFT JOIN `".TBL_GROUP."` as `g` ON `u`.`group_id` = `g`.`id` ";
        $query[]    = "WHERE `u`.`id` > 0"; 
        // Filter: Keyword
        if(!empty($arrParam['filter_search'])){
            $keyword    = '"%'. $arrParam['filter_search'] .'%"';
            $query[]    = "And (`u`.`username` LIKE $keyword OR `u`.`email` LIKE $keyword )"; 
        }

        // Filter: Status
        if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
            $query[]    = "And `u`.`status` = '".$arrParam['filter_state']."' "; 
        }

        // Filter: Group ID
        if(isset($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default'){
            $query[]    = "And `u`.`group_id` = '".$arrParam['filter_group_id']."' "; 
        }


        // SORT
        if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])){
            $column     = $arrParam['filter_column'];
            $columnDir  = $arrParam['filter_column_dir'];
            $query[]    = "ORDER BY `u`.`$column` $columnDir "; // ORDER BY `name` ASC
        }else{
            $query[]    = "ORDER BY `u`.`id` DESC "; // ORDER BY `name` ASC
        }

        // Pagination
        $pagination         = $arrParam['pagination'];
        $totalItemsPerPage  = $pagination['totalItemsPerPage'];

        if($totalItemsPerPage > 0){
            // Examp: C?? 24(totalItems) ph???n t??? chia l??m 4(pagerRange) trang, m???i trang c?? 6 ph???n t???(totalItemsPerPage)
            // Position(v??? tr?? ph???n t??? ????? t??nh trang): ??ang ??? trang 3 => Position = (3-1) * 6 = 12 
            // => Khi ??? trang 3 s??? l???y ph???n t??? c?? v??? tr?? th??? 12 cho ?????n 6 ph???n t??? ti???p theo
            $position   = ($pagination['currentPage'] - 1)*$totalItemsPerPage;   
            $query[]    = "LIMIT $position, $totalItemsPerPage";
        }

        $query      = implode(" ", $query);
        $result     = $this->fetchAll($query);
        return $result;
    }

    public function changeStatus($arrParam, $option = null){
        if($option['task'] == 'change-ajax-status'){
            $status = ($arrParam['status'] == 0)? 1 : 0;
            $modified_by = $this->_userInfo['username'];
            $modified    = date('Y-m-d', time());
            $id     = $arrParam['id'];
            $query  = "UPDATE `$this->table` SET `status` = $status, `modified` = '$modified', `modified_by` = '$modified_by' WHERE `id` = $id";
            $this->query($query);

            $result = array('id' => $id, 
                            'status' => $status,
                            'link' => URL::createLink('admin', 'user', 'ajaxStatus', array('id' => $id, 'status' => $status))
                            );

            return $result;
        }


        if($option['task'] == 'change-status'){
            $status         = $arrParam['type'];
            $modified_by = $this->_userInfo['username'];
            $modified    = date('Y-m-d', time());
            if(!empty($arrParam['cid'])){
                $ids        = $this->createWhereDeleteSQL($arrParam['cid']);
                $query      = "UPDATE `$this->table` SET `status` = $status, `modified` = '$modified', `modified_by` = '$modified_by' WHERE `id` IN ($ids)";
                $this->query($query);
                Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'C?? '.$this->affectedRows().' ???????c c???p nh???t status th??nh c??ng!'));
            }else{
                Session::set('message', array('class' => 'danger', 'icon' => 'fa-ban', 'content' => 'Vui l??ng ch???n v??o ph???n t??? mu???n thay ?????i status!'));
            }
        }
    }

    public function deleteItem($arrParam, $option = null){
        if($option == null){
            if(!empty($arrParam['cid'])){       
                $ids        = $this->createWhereDeleteSQL($arrParam['cid']);
                $query      = "DELETE FROM `$this->table` WHERE `id` IN ($ids)";
                $this->query($query);     
                Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'C?? '.$this->affectedRows().' ph???n t??? ???? ???????c x??a!'));      
            }else{
                Session::set('message', array('class' => 'danger', 'icon' => 'fa-ban', 'content' => 'Vui l??ng ch???n v??o ph???n t??? mu???n mu???n x??a!'));
            }
        }
    }

    public function infoItem($arrParam, $option = null){
        if($option == null){
            $query[]    = "Select `id`, `username`, `email`, `fullname`, `group_id`, `status`, `ordering`";
            $query[]    = "From `$this->table` ";
            $query[]    = "WHERE `id` = '".$arrParam['id']."' "; 
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result;
        }
    }

    public function saveItem($arrParam, $option = null){
        if($option['task'] == 'add'){
            $arrParam['form']['created']    = date('Y-m-d', time());
            $arrParam['form']['created_by'] = $this->_userInfo['username'];
            $arrParam['form']['password']   = md5($arrParam['form']['password']);
            $data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
            $this->insert($data);
            Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'D??? li???u ???????c l??u th??nh c??ng!'));  
            return $this->lastID();
        }

        if($option['task'] == 'edit'){
            //Kh??ng cho thay ?????i Username
            unset($arrParam['form']['username']);
            $arrParam['form']['modified']    = date('Y-m-d', time());
            $arrParam['form']['modified_by'] = $this->_userInfo['username'];
            if($arrParam['form']['password'] != null){
                $arrParam['form']['password']   = md5($arrParam['form']['password']);
            }else{
                unset($arrParam['form']['password']);
            }
            $data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
            $this->update($data, array(array('id', $arrParam['form']['id'])));
            Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'D??? li???u ???????c ch???nh s???a th??nh c??ng!'));   
            return $arrParam['form']['id'];   
        }
    }

    public function ordering($arrParam, $option = null){
        if($option == null){
            $getOrdering = $this->getOrdering($arrParam);
            $modified_by = $this->_userInfo['username'];
            $modified    = date('Y-m-d', time());
            if(!empty($arrParam['order'])){  
                $i = 0;  
                $result = array();
                foreach($arrParam['order'] as $id => $ordering){
                    $i++;
                    $query          = "UPDATE `$this->table` SET `ordering` = $ordering, `modified` = '$modified', `modified_by` = '$modified_by' WHERE `id` = '".$id."'";     
                    $this->query($query); 
                    $result[$id] = $ordering; 
                }
                if($result == $getOrdering){
                    Session::set('message', array('class' => 'danger', 'icon' => 'fa-ban', 'content' => 'Ch??a c?? ph???n t??? ???????c thay ?????i ordering!'));
                }else{
                    Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'C?? '.$i.' ph???n t??? d?? ???????c thay ?????i ordering!'));
                }
                
            }
        }
    }

    public function getOrdering($arrParam){
   
        $ids        = $this->createWhereDeleteSQL(array_flip($arrParam['order']));
        $query[]    = "Select `id`, `ordering`";
        $query[]    = "From `$this->table` ";
        $query[]    = "Where `id` IN ($ids) ";
        $query      = implode(" ", $query);
        $result     = $this->fetchAll($query);
        $arrOrdering = array();
        foreach($result as $value){
            $arrOrdering[$value['id']] = $value['ordering'];
        }
        return $arrOrdering;
    }
}