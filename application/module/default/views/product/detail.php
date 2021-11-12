<?php
// Detail Product
error_reporting(E_WARNING);
if(!empty($this->productInfo)){
    $categoryID = $this->arrParam['category_id'];
    $query  = "Select `id`, `name` from `" . TBL_CATEGORY . "` Where `id` = $categoryID";
    $listCate = $model->fetchRow($query);
   
    $productInfo     = $this->productInfo;
    $name            = $productInfo['name'];
    $size            = explode(',', $this->productInfo['size']);
    $size            = array_reverse($size);

    $picturePath = UPLOAD_PATH . 'product' . DS . '448x527-' . $productInfo['picture'];
    if (file_exists($picturePath) == true) {
        $pathPic    = UPLOAD_URL . 'product' . DS . '448x527-' . $productInfo['picture'];
        $picture    = '<img id="zoom1" src="' . $pathPic . '" data-zoom-image="' . $pathPic . '">';
    } else {
        $picture    = '<img style="width:448px; height:527px;" src="' . UPLOAD_URL . 'product' . DS . '60x90-default.jpg' . '">';
    }

    $description    = substr($productInfo['description'], 0, 800);
    $descriptionAll = $productInfo['description'];

    $priceReal = 0;
    if ($productInfo['sale_off'] > 1) {
        $priceReal  = (100-$productInfo['sale_off'])*$productInfo['price']/100;
        $price      = '<span class="current_price" style="text-decoration: line-through;color:#ff6a28;">' . $productInfo['price'] . '</span>';
        $price     .= '<span class="current_price">&nbsp;&nbsp;&nbsp;</span>';
        $price     .= '<span class="current_price" style="font-size: 20px;">' . number_format($priceReal) . ' VND</span>';
    } else {
        $price      = '<span class="current_price" style="font-size: 20px;">' . number_format($productInfo['price']) . ' VND</span>';
        $priceReal  = $productInfo['price'];
    }
    $linkOrder          = URL::createLink('default', 'user', 'order', array('product_id' => $productInfo['id'], 'price' => $priceReal, 'name' => $productInfo['name'], 'category_id' => $listCate['id'], 'category_name' => $listCate['name'] ));
    $intputProductID    = Helper::cmsInput('hidden', 'product_id', 'product_id', $productInfo['id']);
    $intputProductPrice = Helper::cmsInput('hidden', 'price', 'price', $priceReal);
}


// Relate Product
$xhtmlRelate = '';
if (!empty($this->productRelate)) {
    foreach ($this->productRelate as $keyRelate => $valRelate) {
        $idProRel       = $valRelate['id'];
        $cateIDRel      = $valRelate['category_id'];
        $cateNameRel    = URL::filterURL($this->categoryName);
        $nameRel        = $valRelate['name'];
        $nameURLRel     = URL::filterURL($name);
        $linkRelate     = URL::createLink('default', 'product', 'detail', array('category_id' => $valRelate['category_id'], 'product_id' => $valRelate['id']), "$cateNameRel/$nameURLRel-$cateIDRel-$idProRel.html");
        

        if ($valRelate['sale_off'] > 1) {
            $saleoffRelate     = '<div class="product_sale"><span>-' . $valRelate['sale_off'] . '%</span></div>';
            $priceRelate       = '<span class="current_price">' . number_format((100 - $valRelate['sale_off']) * $valRelate['price'] / 100) . ' VND</span>';
            $priceRelate      .= '<span class="old_price">' . number_format($valRelate['price']) . ' VNĐ</span>';
        } else {
            $saleoffRelate    = '';
            $priceRelate      = '<span class="current_price">' . number_format($valRelate['price']) . ' VNĐ</span>';
        }


        $picturePath = UPLOAD_PATH . 'product' . DS . '448x527-' . $valRelate['picture'];
        if (file_exists($picturePath) == true) {
            $pictureRelate    = '<img style="width:255px; height:299px;" src="' . UPLOAD_URL . 'product' . DS . '448x527-' . $valRelate['picture'] . '">';
        } else {
            $pictureRelate    = '<img style="width:255px; height:299px;" src="' . UPLOAD_URL . 'product' . DS . '60x90-default.jpg' . '">';
        }

        $xhtmlRelate .= '<div class="col-lg-3">
            <div class="single_product">
                <div class="product_thumb">
                    <a class="primary_img" href="' . $linkRelate . '">' . $pictureRelate . '</a>
                    <div class="quick_button">
                        <a href="' . $linkRelate . '" title="quick_view">Xem sản phẩm</a>
                    </div>
                    <div class="double_base">
                        ' . $saleoffRelate . '
                        <div class="label_product">
                            <span>new</span>
                        </div>
                    </div>
                </div>
                <div class="product_content">
                    <h3><a href="' . $linkRelate . '">' . $nameRel . '</a></h3>
                    ' . $priceRelate . '
                </div>
            </div>
        </div>';
    }
}


$cart   = Session::get('cart');

// Chọn size
if(!empty($this->productInfo['size'])){
    $selectboxSize    = Helper::cmsSelectBoxPublic('size', $size, 'margin-left: 10px;height:35px;');
}else{
    $selectboxSize    = '<a style="color:red;">Sản phẩm tạm hết hàng</a>';
}


// Message lỗi chưa chọn size
$message = Session::get('messageSize');
Session::delete('messageSize');
$strMessageSize = ' <div class="product_desc">
                        <a style="font-size: 30px;color:red;">'.$message.'</a>
                    </div>';

?>


<!--breadcrumbs area start-->
<div class="breadcrumbs_area product_bread">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li>Trang chủ</li>
                        <li>/</li>
                        <li>Thông tin sản phẩm</li>
                        <li>/</li>
                        <li><?php echo $name; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--product details start-->
<div class="product_details">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5">
                <div class="product-details-tab">

                    <div id="img-1" class="zoomWrapper single-zoom">
                        <a href="#">
                            <?php echo $picture; ?>
                        </a>
                    </div>


                </div>
            </div>
            <div class="col-lg-7 col-md-7">
                <div class="product_d_right">
                    <form onsubmit="valid()" method="post" name="detailForm" id="detailForm" action="<?php echo $linkOrder; ?>">
                        <h1><?php echo $name; ?></h1>
                        <div class=" product_ratting">
                            <ul>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="review"><a href="#"> 7 đánh giá </a></li>
                            </ul>
                        </div>
                        <div class="product_price">
                            <?php echo $price; ?>
                        </div>
                        <div class="product_desc">
                            <p><?php echo $description; ?></p>
                        </div>

                        <!-- onclick="document.getElementById('detailForm').submit();" -->
                        <?php
                        echo $intputProductID . $intputProductPrice . $intputProductSize;
                        ?>
                        <div class="product_desc">
                            <?php echo $selectboxSize; ?>
                        </div>
                        
                        
                        <div class="product_desc">
                           <a id="tagSubmit"  onclick="document.getElementById('detailForm').submit();" class="button">Thêm Vào Giỏ Hàng</a>
                        </div>

                        <div class="product_d_action">
                            <ul>
                                <li><a href="#" title="Add to wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i> Thêm vào yêu thích</a></li>
                                <li><a href="#" title="Add to Compare"><i class="fa fa-sliders" aria-hidden="true"></i> Sản phẩm liên quan</a></li>
                            </ul>
                        </div>

                    </form>
                    <div class="priduct_social">
                        <h3>Chia sẽ:</h3>
                        <ul>
                            <li><a href="#"><i class="fa fa-rss"></i></a></li>
                            <li><a href="#"><i class="fa fa-vimeo"></i></a></li>
                            <li><a href="#"><i class="fa fa-tumblr"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                    
                    <?php echo $strMessageSize; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!--product details end-->

<!--product info start-->
<div class="product_d_info">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product_d_inner">
                    <div class="product_info_button">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Thông tin</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">Thông tin chi tiết</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="product_info_content">
                                <p><?php echo $description; ?></p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="sheet" role="tabpanel">
                            <div class="product_d_table">
                                <form action="#">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="first_child">Tên sản phẩm</td>
                                                <td><?php echo $name; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="first_child">Giá tiền:</td>
                                                <td><?php echo $price; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="first_child">Sale off</td>
                                                <td><?php echo $productInfo['sale_off']; ?>%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <div class="product_info_content">
                                <p><?php echo $descriptionAll; ?></p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--product info end-->

<!--product section area start-->
<section class="product_section related_product">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Sản phẩm được gợi ý</h2>
                    <p>Sản phẩm liên quan</p>
                </div>
            </div>
        </div>
        <div class="product_area">
            <div class="row">
                <div class="product_carousel product_three_column4 owl-carousel">
                    <?php echo $xhtmlRelate; ?>
                </div>
            </div>
        </div>

    </div>
</section>
<!--product section area end-->








<!-- modal area start-->
<div class="modal fade" id="modal_box" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal_body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="modal_tab">
                                <div class="tab-content product-details-large">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product4.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product6.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product8.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab4" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product2.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab5" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product12.jpg" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal_tab_button">
                                    <ul class="nav product_navactive owl-carousel" role="tablist">
                                        <li>
                                            <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false"><img src="assets/img/s-product/product3.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><img src="assets/img/s-product/product.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link button_three" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"><img src="assets/img/s-product/product2.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false"><img src="assets/img/s-product/product4.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="false"><img src="assets/img/s-product/product5.jpg" alt=""></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="modal_right">
                                <div class="modal_title mb-10">
                                    <h2>Handbag feugiat</h2>
                                </div>
                                <div class="modal_price mb-10">
                                    <span class="new_price">$64.99</span>
                                    <span class="old_price">$78.99</span>
                                </div>
                                <div class="modal_description mb-15">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum ad impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui nemo ipsum numquam, reiciendis maiores quidem aperiam, rerum vel recusandae </p>
                                </div>
                                <div class="variants_selects">
                                    <div class="variants_size">
                                        <h2>size</h2>
                                        <select class="select_option">
                                            <option selected value="1">s</option>
                                            <option value="1">m</option>
                                            <option value="1">l</option>
                                            <option value="1">xl</option>
                                            <option value="1">xxl</option>
                                        </select>
                                    </div>
                                    <div class="variants_color">
                                        <h2>color</h2>
                                        <select class="select_option">
                                            <option selected value="1">purple</option>
                                            <option value="1">violet</option>
                                            <option value="1">black</option>
                                            <option value="1">pink</option>
                                            <option value="1">orange</option>
                                        </select>
                                    </div>
                                    <div class="modal_add_to_cart">
                                        <form action="#">
                                            <input min="0" max="100" step="2" value="1" type="number">
                                            <button type="submit">add to cart</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal_social">
                                    <h2>Share this product</h2>
                                    <ul>
                                        <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                        <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal area start-->