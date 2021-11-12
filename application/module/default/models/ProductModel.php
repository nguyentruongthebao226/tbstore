<?php
class ProductModel extends Model{

    private $_columns = array('id', 'name', 'description', 'price', 'special', 'sale_off', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'category_id');

    public function __construct(){
        parent::__construct();
        $this->setTable(TBL_PRODUCT);
    }

    public function countItem($arrParam, $option = null){
        if($option['task'] == 'products-in-cat'){
            $catID      = $arrParam['category_id'];
            $query[]    = "Select COUNT(`id`) AS `total`";
            $query[]    = "From `$this->table` ";
            $query[]    = Helper::filterProductsByCat($arrParam['filter'], $catID); 
            $query[]    = Helper::filterProductsByPrice($arrParam['filter']); 

            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result['total'];
        }

        if($option['task'] == 'all-products'){
            $where      = "WHERE `status` = 1";
            $query[]    = "Select COUNT(`id`) AS `total`";
            $query[]    = "From `$this->table` ";
            $query[]    = Helper::filterProductsByPrice($arrParam['filter'], $where); 

            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
             return $result['total'];
        }

        if($option['task'] == 'special-products'){
            $where      = "WHERE `status` = 1 And `special` = 1";
            $query[]    = "Select COUNT(`id`) AS `total`";
            $query[]    = "From `$this->table` ";
            $query[]    = Helper::filterProductsByPrice($arrParam['filter'], $where); 

            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result['total'];
        }

        if($option['task'] == 'saleoff-products'){
            $where      = "WHERE `status` = 1 And `sale_off` > 1"; 
            $query[]    = "Select COUNT(`id`) AS `total`";
            $query[]    = "From `$this->table` ";
            $query[]    = Helper::filterProductsByPrice($arrParam['filter'], $where); 

            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result['total'];
        }
        
    }

    public function infoItem($arrParam, $option = null){
        if($option['task'] == 'get-cat-name'){
            $query      = "Select `name` From `".TBL_CATEGORY."` WHERE `id` = '".$arrParam['category_id']."' ";
            $result     = $this->fetchRow($query);
            return $result['name'];
        }

        if($option['task'] == 'product-info'){
            $query      = "Select `id`, `name`, `price`, `sale_off`, `picture`, `description`, `size` From `".TBL_PRODUCT."` WHERE `id` = '".$arrParam['product_id']."' ";
            $result     = $this->fetchRow($query);
            return $result;
        }
    }

    public function listItem($arrParam, $option = null){
        if($option['task'] == 'products-in-cat'){
            $catID      = $arrParam['category_id'];
            $query[]    = "Select `id`, `name`, `picture`, `price`, `sale_off`, `special`,`category_id`";
            $query[]    = "From `$this->table` ";              
            $query[]    = Helper::filterProductsByCat($arrParam['filter'], $catID); 
            $query[]    = Helper::filterProductsByPrice($arrParam['filter']); 

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

        if($option['task'] == 'all-products'){
            $where      = "WHERE `status` = 1";
            $query[]    = "Select `id`, `name`, `picture`, `price`, `sale_off`, `special`, `category_id`";
            $query[]    = "From `$this->table` ";
            $query[]    = Helper::filterProductsByPrice($arrParam['filter'], $where); 

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

        if($option['task'] == 'special-products'){
            $where      = "WHERE `status` = 1 And `special` = 1";
            $query[]    = "Select `id`, `name`, `picture`, `price`, `sale_off`, `special`, `category_id`";
            $query[]    = "From `$this->table` ";
            $query[]    = Helper::filterProductsByPrice($arrParam['filter'], $where); 

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

        if($option['task'] == 'saleoff-products'){
            $where      = "WHERE `status` = 1 And `sale_off` > 1"; 
            $query[]    = "Select `id`, `name`, `picture`, `price`, `sale_off`, `special`, `category_id`";
            $query[]    = "From `$this->table` ";
            $query[]    = Helper::filterProductsByPrice($arrParam['filter'], $where); 

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

        if($option['task'] == 'products-relate'){
            $productID  = $arrParam['product_id'];
            $queryCate  = "Select `category_id` From `".TBL_PRODUCT."` where `id` = $productID";
            $resultCate = $this->fetchRow($queryCate);
            $catID      = $resultCate['category_id'];
            //$catID      = $arrParam['category_id'];

            $query[]    = "Select `id`, `name`, `picture`, `price`, `sale_off`, `special`, `category_id`";
            $query[]    = "From `$this->table` ";
            $query[]    = "WHERE `status` = 1 And `category_id` = '$catID' And `id` <> $productID"; 
            //$query[]    = "ORDER BY `ordering` ASC ";
            $query[]    = "ORDER BY `id` DESC ";

            $query      = implode(" ", $query);
            $result     = $this->fetchAll($query);
            return $result;
        }  
    }

}