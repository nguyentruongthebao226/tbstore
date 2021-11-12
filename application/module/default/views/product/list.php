<?php
$xhtml = '';
if (!empty($this->Items)) {
    foreach ($this->Items as $key => $value) {
        $idPro    = $value['id'];
        $cateID   = $value['category_id'];
        $cateName = URL::filterURL($this->categoryName);
        $name     = $value['name'];
        $nameURL  = URL::filterURL($name);
        $link     = URL::createLink('default', 'product', 'detail', array('category_id' => $value['category_id'], 'product_id' => $value['id']), "$cateName/$nameURL-$cateID-$idPro.html");
        $price    = $value['price'];
        $sale_off = $value['sale_off'];
        $special  = $value['special'];

        if ($sale_off > 1) {
            if ($special == 1) {
                $salespecial   = '<div class="double_base"><div class="product_sale"><span>-' . $sale_off . '%</span></div>
                                    <div class="label_product"><span>new</span></div></div>';
            } else {
                $salespecial   = '<div class="product_sale"><span>-' . $sale_off . '%</span></div>';
            }
            $priceSaleOff      = '<span class="current_price">' . number_format((100 - $sale_off) * $price / 100) . ' VND</span>';
            $priceSaleOff     .= '<span class="old_price">' . number_format($price) . ' VNĐ</span>';
        } else {
            if ($special == 1) {
                $salespecial   = '<div class="label_product"><span>new</span></div>';
            } else {
                $salespecial   = '';
            }
            $priceSaleOff      = '<span class="current_price">' . number_format($price) . ' VNĐ</span>';
        }

        $picturePath = UPLOAD_PATH . 'product' . DS . '448x527-' . $value['picture'];
        if (file_exists($picturePath) == true) {
            $picture    = '<img src="' . UPLOAD_URL . 'product' . DS . '448x527-' . $value['picture'] . '">';
        } else {
            $picture    = '<img style="width:448px; height:527px;" src="' . UPLOAD_URL . 'product' . DS . '60x90-default.jpg' . '">';
        }

        $xhtml .= '<div class="col-lg-4 col-md-4 col-12 ">
        <div class="single_product">
            <div class="product_thumb">
                <a class="primary_img" href="' . $link . '">' . $picture . '</a>

                <div class="quick_button">
                    <a href="' . $link . '" title="quick_view">Xem sản phẩm</a>
                </div>
                ' . $salespecial . '
            </div>

            <div class="product_content grid_content">
                <h3><a href="' . $link . '">' . $name . '</a></h3>
                ' . $priceSaleOff . '
            </div>
        </div>
    </div>';
    }
} else {
    $xhtml = '<h2 style="color:#ff6a28;">Sản phẩm đang được cập nhật!</h2>';
}

// SELECT Status
$arrFilter          = array('default' => 'Tìm kiếm theo', 1 => 'Giá giảm dần', 0 => 'Giá tăng dần', 2 => 'Sản phẩm bán chạy', 3 => 'Sản phẩm đang được ưu đãi');
$selectboxFilter    = Helper::cmsSelectBox('filter', 'inputbox', $arrFilter, $this->arrParam['filter'], 'height:30px;');

//Pagination
$paginationHTML     = $this->pagination->showPaginationPublic(URL::createLink('default', 'product', 'list'));

?>


<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li>Trang chủ</li>
                        <li>/</li>
                        <li>Danh mục</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="shop_area shop_reverse">
    <div class="container">
        <div class="shop_inner_area">
            <form action="#" method="post" name="adminForm" id="adminForm">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <!--sidebar widget start-->
                        <div class="sidebar_widget">
                            <div class="widget_list widget_categories">
                                <!-- <h1>----------</h1> -->
                                <h1 style="color:#ff6a28">TBstore</h1>
                            </div>
                            <div class="widget_list widget_categories">
                                <h2>Danh mục sản phẩm</h2>
                                <ul>
                                    <?php echo $categoryAllProducts; ?>
                                    <?php echo $listCategory; ?>
                                    <?php echo $categorySpecialProducts; ?>
                                    <?php echo $categorySaleOffProducts; ?>

                                </ul>
                            </div>



                        </div>
                        <!--sidebar widget end-->
                    </div>

                    <div class="col-lg-9 col-md-12">
                        <!--shop wrapper start-->
                        <!--shop toolbar start-->
                        <div class="shop_title">
                            <h1><?php echo $this->categoryName; ?></h1>
                        </div>
                        <div class="row">
                            <div id="optionselectbox" class="a">
                                <div class="optionselectbox" id="optionselectbox">
                                    <?php echo $selectboxFilter; ?>
                                </div>
                            </div>
                            <div class="page_amount">
                                <p>Showing 1–9 of 21 results</p>
                            </div>
                        </div>
                        <!--shop toolbar end-->

                        <div class="row shop_wrapper">
                            <?php echo $xhtml; ?>
                        </div>
                        <input type="hidden" name="filter_page" value="1">
                        
                                <?php echo $paginationHTML; ?>
                            
                        <!--shop toolbar end-->
                        <!--shop wrapper end-->
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>