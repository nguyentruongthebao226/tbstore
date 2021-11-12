<?php
class CategoryModel extends Model{

    private $_columns = array('id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering');
    private $_userInfo;

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_CATEGORY);
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
        $query[]    = "Select `id`, `name`, `picture`, `status`, `ordering`, `created`, `created_by`, `modified`, `modified_by`";
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
            // Examp: Có 24(totalItems) phần tử chia làm 4(pagerRange) trang, mỗi trang có 6 phần tử(totalItemsPerPage)
            // Position(vị trí phần tử để tính trang): Đang ở trang 3 => Position = (3-1) * 6 = 12 
            // => Khi ở trang 3 sẽ lấy phần tử có vị trí thứ 12 cho đến 6 phần tử tiếp theo
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
                            'link' => URL::createLink('admin', 'category', 'ajaxStatus', array('id' => $id, 'status' => $status))
                            );

            return $result;
        }

        if($option['task'] == 'change-status'){
            $status         = $arrParam['type'];
            $modified_by    = $this->_userInfo['username'];
            $modified       = date('Y-m-d', time());
            if(!empty($arrParam['cid'])){
                $ids        = $this->createWhereDeleteSQL($arrParam['cid']);
                $query      = "UPDATE `$this->table` SET `status` = $status, `modified` = '$modified', `modified_by` = '$modified_by' WHERE `id` IN ($ids)";
                $this->query($query);
                Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'Có '.$this->affectedRows().' được cập nhật status thành công!'));
            }else{
                Session::set('message', array('class' => 'danger', 'icon' => 'fa-ban', 'content' => 'Vui lòng chọn vào phần tử muốn thay đổi status!'));
            }
        }
    }

    public function deleteItem($arrParam, $option = null){
        if($option == null){
            if(!empty($arrParam['cid'])){       
                $ids        = $this->createWhereDeleteSQL($arrParam['cid']);
               
                
                //Remove Image
                $query      = "Select `id`, `picture` as `name` From `$this->table` WHERE `id` IN ($ids)";
                $arrImage   = $this->fetchPairs($query);
                require_once LIBRARY_EXT_PATH . 'Upload.php';
                $uploadObj = new Upload();
                foreach($arrImage as $value){
                    $uploadObj->removeFile('category', $value);
                    $uploadObj->removeFile('category', '253x298-' . $value);
                }

                //Delete from database
                $query      = "DELETE FROM `$this->table` WHERE `id` IN ($ids)";
                $this->query($query);   
                
                Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'Có '.$this->affectedRows().' phần tử đã được xóa!'));      
            }else{
                Session::set('message', array('class' => 'danger', 'icon' => 'fa-ban', 'content' => 'Vui lòng chọn vào phần tử muốn muốn xóa!'));
            }
        }
    }

    public function infoItem($arrParam, $option = null){
        if($option == null){
            $query[]    = "Select `id`, `name`, `picture`, `status`, `ordering`";
            $query[]    = "From `$this->table` ";
            $query[]    = "WHERE `id` = '".$arrParam['id']."' "; 
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result;
        }
    }

    public function saveItem($arrParam, $option = null){
        require_once LIBRARY_EXT_PATH . 'Upload.php';
        $uploadObj = new Upload();
        if($option['task'] == 'add'){
            $arrParam['form']['picture']    = $uploadObj->uploadFile($arrParam['form']['picture'], 'category');
            $arrParam['form']['created']    = date('Y-m-d', time());
            $arrParam['form']['created_by'] = $this->_userInfo['username'];
            $data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
            $this->insert($data);
            Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'Dữ liệu được lưu thành công!'));  
            return $this->lastID();
        }

        if($option['task'] == 'edit'){
            $arrParam['form']['modified']    = date('Y-m-d', time());
            $arrParam['form']['modified_by'] = $this->_userInfo['username'];

            if($arrParam['form']['picture']['name'] == null){
                unset($arrParam['form']['picture']);
            }else{
                $uploadObj->removeFile('category', $arrParam['form']['picture_hidden']);
                $uploadObj->removeFile('category', '253x298-' . $arrParam['form']['picture_hidden']);
                $arrParam['form']['picture']    = $uploadObj->uploadFile($arrParam['form']['picture'], 'category');
            }

            $data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
            $this->update($data, array(array('id', $arrParam['form']['id'])));
            Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'Dữ liệu được chỉnh sửa thành công!'));   
            return $arrParam['form']['id'];   
        }
    }

    public function ordering($arrParam, $option = null){
        if($option == null){
            $getOrdering = $this->getOrdering();
            $modified_by    = $this->_userInfo['username'];
            $modified       = date('Y-m-d', time());
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
                    Session::set('message', array('class' => 'danger', 'icon' => 'fa-ban', 'content' => 'Chưa có phần tử được thay đổi ordering!'));
                }else{
                    Session::set('message', array('class' => 'info', 'icon' => 'fa-info', 'content' => 'Có '.$i.' phần tử dã được thay đổi ordering!'));
                }
                
            }
        }
    }

    public function getOrdering(){
        $query[]    = "Select `id`, `ordering`";
        $query[]    = "From `$this->table` ";
        $query      = implode(" ", $query);
        $result     = $this->fetchAll($query);
        $arrOrdering = array();
        foreach($result as $value){
            $arrOrdering[$value['id']] = $value['ordering'];
        }
        return $arrOrdering;
    }
}