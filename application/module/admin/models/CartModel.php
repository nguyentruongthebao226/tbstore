<?php
class CartModel extends Model{

    private $_columns = array('id', 'username', 'fullname', 'phone', 'address', 'products', 'prices', 'sizes', 'quantities', 'names', 'pictures', 'status', 'date');
    private $_userInfo;

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_CART);
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
            $query[]    = "AND `name` LIKE $keyword"; 
        }

        // Filter: Status
        if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
            $query[]    = "And `status` = '".$arrParam['filter_state']."' ";    
        }

        $query      = implode(" ", $query);
        $result     = $this->fetchRow($query);
        return $result['total'];
    }

    public function listItem($arrParam, $option = null){
        $query[]    = "Select `id`, `username`, `fullname`, `phone`, `address`, `products`, `prices`, `sizes`, `quantities`, `names`, `status`, `date`";
        $query[]    = "From `$this->table` ";
        $query[]    = "WHERE `phone` <> 0"; 

        // Filter: Keyword
        if(!empty($arrParam['filter_search'])){
            $keyword    = '"%'. $arrParam['filter_search'] .'%"';
            $query[]    = "AND `name` LIKE $keyword"; 
        }

        // Filter: Status
        if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
            $query[]    = "And `status` = '".$arrParam['filter_state']."' "; 
        }

        // SORT
        if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])){
            $column     = $arrParam['filter_column'];
            $columnDir  = $arrParam['filter_column_dir'];
            $query[]    = "ORDER BY `$column` $columnDir "; // ORDER BY `name` ASC
        }else{
            $query[]    = "ORDER BY `id` DESC "; // ORDER BY `name` ASC
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
            $id     = $arrParam['id'];
            $query  = "UPDATE `$this->table` SET `status` = $status WHERE `id` = '$id'";
            $this->query($query);

            $result = array('id' => $id, 
                            'status' => $status,
                            'link' => URL::createLink('admin', 'cart', 'ajaxStatus', array('id' => $id, 'status' => $status))
                            );

            return $result;
        }

        if($option['task'] == 'change-status'){
            $status         = $arrParam['type'];
            if(!empty($arrParam['cid'])){
                $ids        = $this->createWhereDeleteSQL($arrParam['cid']);
                $query      = "UPDATE `$this->table` SET `status` = $status WHERE `id` IN ($ids)";
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

    // public function infoItem($arrParam, $option = null){
    //     if($option == null){
    //         $query[]    = "Select `id`, `name`, `group_acp`, `status`, `ordering`";
    //         $query[]    = "From `$this->table` ";
    //         $query[]    = "WHERE `id` = '".$arrParam['id']."' "; 
    //         $query      = implode(" ", $query);
    //         $result     = $this->fetchRow($query);
    //         return $result;
    //     }
    // }

    public function saveItem($arrParam, $option = null){
        if($option['task'] == 'add'){
            $data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
            $this->insert($data);
            Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'D??? li???u ???????c l??u th??nh c??ng!'));  
            return $this->lastID();
        }

        // if($option['task'] == 'edit'){
        //     $arrParam['form']['modified']    = date('Y-m-d', time());
        //     $arrParam['form']['modified_by'] = $this->_userInfo['username'];
        //     $data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
        //     $this->update($data, array(array('id', $arrParam['form']['id'])));
        //     Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'D??? li???u ???????c ch???nh s???a th??nh c??ng!'));   
        //     return $arrParam['form']['id'];   
        // }
    }


}