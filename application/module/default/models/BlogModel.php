<?php
class BlogModel extends Model{

    private $_columns = array('id', 'name', 'description', 'price', 'special', 'sale_off', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'category_id');

    public function __construct(){
        parent::__construct();
        $this->setTable(TBL_BLOG);
    }

    public function countItem($arrParam, $option = null){
        if($option['task'] == 'blogs'){
            $query[]    = "Select COUNT(`id`) AS `total`";
            $query[]    = "From `$this->table` ";
            $query[]    = "Where `status` = 1 ";

            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result['total'];
        }

       
        
    }

    public function infoItem($arrParam, $option = null){
        if($option['task'] == 'blog-info'){
            $query      = "Select `id`, `name`, `picture`, `description`, `created` From `".TBL_BLOG."` WHERE `id` = '".$arrParam['blog_id']."' ";
            $result     = $this->fetchRow($query);
            return $result;
        }
    }

    public function listItem($arrParam, $option = null){
        if($option['task'] == 'blogs'){
          
            $query[]    = "Select `id`, `name`, `picture`, `description`, `created`";
            $query[]    = "From `$this->table` ";              
            $query[]    = "Where `status` = 1 ";      

            // Pagination
            $pagination         = $arrParam['pagination'];
            $totalItemsPerPage  = $pagination['totalItemsPerPage'];

            if($totalItemsPerPage > 0){
                $position   = ($pagination['currentPage'] - 1)*$totalItemsPerPage;   
                $query[]    = "LIMIT $position, $totalItemsPerPage";
            }


            $query      = implode(" ", $query);
            $result     = $this->fetchAll($query);
            return $result;
        }  

    }

}