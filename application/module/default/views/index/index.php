<?php
// Category Content
$xhtml = '';
if (!empty($this->ItemsCategory)) {
    foreach ($this->ItemsCategory as $keyCat => $valCat) {      
        $name    = $valCat['name'];
        $idCat   = $valCat['id'];
        $nameURL = URL::filterURL($name);
        $link    = URL::createLink('default', 'product', 'list', array('category_id' => $valCat['id']), "$nameURL-$idCat.html");

        $picturePath = UPLOAD_PATH . 'category' . DS . '253x298-' . $valCat['picture'];
        if (file_exists($picturePath) == true) {
            $pictureCategory    = '<img style="width=253px; height=298px;" src="' . UPLOAD_URL . 'category' . DS . '253x298-' . $valCat['picture'] . '">';
        } else {
            $pictureCategory    = '<img style="width=253px; height=298px;" src="' . UPLOAD_URL . 'category' . DS . '60x90-default.jpg' . '">';
        }

        $xhtml .= '<div class="col-lg-3">
                    <div class="single_product">
                        <div class="product_thumb">
                            <a class="primary_img" href="' . $link . '">' . $pictureCategory . '</a>                     
                            <div class="quick_button">
                                <a href="' . $link . '" title="quick_view">Xem danh mục</a>
                            </div>
                        </div>
                        <div class="product_content">
                            <h3 style="text-align:center;"><a href="' . $link . '">' . $name . '</a></h3>                           
                        </div>
                    </div>
                </div>';
    }
}

$xhtmlSpecial = '';
// Special Products Content
if (!empty($this->SpecialProducts)) {
    foreach ($this->SpecialProducts as $keySpecial => $valSpecial) {
        $catIDSpec     = $valSpecial['category_id'];
        $catNameSpec   = URL::filterURL($valSpecial['category_name']);
        $SpecialName   = $valSpecial['name'];
        $idSpecial     = $valSpecial['id'];
        $nameURLSpe    = URL::filterURL($SpecialName);
        $linkSpecial   = URL::createLink('default', 'product', 'detail', array('category_id' => $valSpecial['category_id'], 'product_id' => $valSpecial['id']), "$catNameSpec/$nameURLSpe-$catIDSpec-$idSpecial.html");
        

        if ($valSpecial['sale_off'] > 1) {
            $saleoffSpecial    = '<div class="product_sale"><span>-' . $valSpecial['sale_off'] . '%</span></div>';
            $priceSpecial      = '<span class="current_price">' . number_format((100 - $valSpecial['sale_off']) * $valSpecial['price'] / 100) . ' VND</span>';
            $priceSpecial     .= '<span class="old_price">' . number_format($valSpecial['price']) . ' VNĐ</span>';
        } else {
            $saleoffSpecial    = '';
            $priceSpecial      = '<span class="current_price">' . number_format($valSpecial['price']) . ' VNĐ</span>';
        }


        $picturePath = UPLOAD_PATH . 'product' . DS . '448x527-' . $valSpecial['picture'];
        if (file_exists($picturePath) == true) {
            $pictureSpecial    = '<img style="width:255px; height:299px;" src="' . UPLOAD_URL . 'product' . DS . '448x527-' . $valSpecial['picture'] . '">';
        } else {
            $pictureSpecial    = '<img style="width:255px; height:299px;" src="' . UPLOAD_URL . 'product' . DS . '60x90-default.jpg' . '">';
        }

        $xhtmlSpecial .= '<div class="col-lg-3">
            <div class="single_product">
                <div class="product_thumb">
                    <a class="primary_img" href="' . $linkSpecial . '">' . $pictureSpecial . '</a>
                    <div class="quick_button">
                        <a href="' . $linkSpecial . '" title="quick_view">Xem sản phẩm</a>
                    </div>
                    <div class="double_base">
                        ' . $saleoffSpecial . '
                        <div class="label_product">
                            <span>new</span>
                        </div>
                    </div>
                </div>
                <div class="product_content">
                    <h3><a href="product-details.html">' . $SpecialName . '</a></h3>
                    ' . $priceSpecial . '
                </div>
            </div>
        </div>';
    }
}

// SaleOffProducts
$xhtmlSaleOff = '';
if (!empty($this->SaleOffProducts)) {
    foreach ($this->SaleOffProducts as $keySaleOff => $valSaleOff) {
        $catIDSale     = $valSaleOff['category_id'];
        $catNameSale   = URL::filterURL($valSaleOff['category_name']);
        $SaleOffName   = $valSaleOff['name'];
        $idSale        = $valSaleOff['id'];
        $nameURLSale   = URL::filterURL($SaleOffName);
        $linkSaleOff   = URL::createLink('default', 'product', 'detail', array('category_id' => $valSaleOff['category_id'], 'product_id' => $valSaleOff['id']), "$catNameSale/$nameURLSale-$catIDSale-$idSale.html");
        $SaleOffName   = $valSaleOff['name'];

        if ($valSaleOff['sale_off'] > 1) {
            if($valSaleOff['special'] == 1){
                $saleoff       = '<div class="double_base"><div class="product_sale"><span>-' . $valSaleOff['sale_off'] . '%</span></div>
                                    <div class="label_product"><span>new</span></div></div>';
            }else{
                $saleoff           = '<div class="product_sale"><span>-' . $valSaleOff['sale_off'] . '%</span></div>';
                $priceSaleOff      = '<span class="current_price">' . number_format((100 - $valSaleOff['sale_off']) * $valSaleOff['price'] / 100) . ' VND</span>';
                $priceSaleOff     .= '<span class="old_price">' . number_format($valSaleOff['price']) . ' VNĐ</span>';
            }          
        }

        $picturePath = UPLOAD_PATH . 'product' . DS . '448x527-' . $valSaleOff['picture'];
        if (file_exists($picturePath) == true) {
            $pictureSaleOff    = '<img style="width:255px; height:299px;" src="' . UPLOAD_URL . 'product' . DS . '448x527-' . $valSaleOff['picture'] . '">';
        } else {
            $pictureSaleOff    = '<img style="width:255px; height:299px;" src="' . UPLOAD_URL . 'product' . DS . '60x90-default.jpg' . '">';
        }

        $xhtmlSaleOff .= '<div class="col-lg-3">
            <div class="single_product">
                <div class="product_thumb">
                    <a class="primary_img" href="' . $linkSaleOff . '">' . $pictureSaleOff . '</a>

                    <div class="quick_button">
                        <a href="' . $linkSaleOff . '" title="quick_view">Xem sản phẩm</a>
                    </div>
                    '.$saleoff.'
                </div>
                <div class="product_content">
                    <h3><a href="product-details.html">' . $SaleOffName . '</a></h3>
                    ' . $priceSaleOff . '
                </div>
            </div>
        </div>';
    }
}

// Blog Content
$xhtmlBlog = '';
if (!empty($this->Blogs)) {
    foreach ($this->Blogs as $keyBlog => $valBlog) {
        $nameBlog    = $valBlog['name'];
        $idBlog      = $valBlog['id'];
        $nameURLBlog = URL::filterURL($nameBlog);
        $linkBlog    = URL::createLink('default', 'blog', 'detail', array('blog_id' => $valBlog['id']), "$nameURLBlog/$idBlog.html");    
        $desBlog     = substr($valBlog['description'], 0, 100);
        $createBlog  = date("d/m/Y", strtotime($valBlog['created']));

        $picturePath = UPLOAD_PATH . 'blog' . DS . $valBlog['picture'];
        if (file_exists($picturePath) == true) {
            $pictureBlog    = '<img style="width=349px; height=345px;" src="' . UPLOAD_URL . 'blog' . DS . $valBlog['picture'] . '">';
        } else {
            $pictureBlog    = '<img style="width=349px; height=345px;" src="' . UPLOAD_URL . 'blog' . DS . '60x90-default.jpg' . '">';
        }

        $xhtmlBlog .= '<div class="col-lg-4">
                            <div class="single_blog">
                                <div class="blog_thumb">
                                    <a href="'.$linkBlog.'">'.$pictureBlog.'</a>
                                    <div class="blog_icon">
                                        <a href="'.$linkBlog.'"></a>
                                    </div>
                                </div>
                                <div class="blog_content">
                                    <h3><a href="'.$linkBlog.'">'.$nameBlog.'</a></h3>
                                    <div class="author_name">
                                        <p>
                                            <span class="post_by">by</span>
                                            <span class="themes">TB Store</span>
                                            / '.$createBlog.'
                                        </p>

                                    </div>
                                    <div class="post_desc">
                                        <p>'.$desBlog.'</p>
                                    </div>
                                </div>
                            </div>
                        </div>';
        }
}

$linkMoreSpecial     = URL::createLink('default', 'product', 'list', array('options' => 'special-products'));
$linkMoreSaleOff     = URL::createLink('default', 'product', 'list', array('options' => 'saleoff-products'));
$linkShowAll         = URL::createLink('default', 'product', 'list', array('options' => 'all-products'));
$linkAllBlog         = URL::createLink('default', 'blog', 'list');
?>


<div class="slider_area slider_style home_three_slider owl-carousel">
    <div class="single_slider" data-bgimg="<?php echo $imageURL; ?>/slider/slider4.jpg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="slider_content content_one">
                        <img src="<?php echo $imageURL; ?>/slider/content3.png" alt="">
                        <p>Các sản phẩm dành cho mùa đông đang được ưu đãi</p>
                        <a href="<?php echo $linkThinhHanh ?>">Xem ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="single_slider" data-bgimg="<?php echo $imageURL; ?>/slider/slider5.jpg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="slider_content content_two">
                        <img src="<?php echo $imageURL; ?>/slider/content4.png" alt="">
                        <p>Rất nhiều sản phẩm đang được giảm giá upto 50%</p>
                        <a href="<?php echo $linkGiamgia ?>">Xem ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="single_slider" data-bgimg="<?php echo $imageURL; ?>/slider/slider6.jpg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="slider_content content_three">
                        <img src="<?php echo $imageURL; ?>/slider/content5.png" alt="">
                        <p>Giảm giá lên đến 3.000.000 đồng</p>
                        <a href="<?php echo $linkGiamgia ?>">Xem ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="banner_section banner_section_three">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-4 col-md-6">
                <div class="banner_area">
                    <div class="banner_thumb">
                        <a href="<?php echo $linkAllProducts; ?>"><img src="<?php echo $imageURL; ?>/bg/banner8.jpg" alt="#"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="banner_area">
                    <div class="banner_thumb">
                        <a href="<?php echo $linkGiamgia ?>"><img src="<?php echo $imageURL; ?>/bg/banner9.jpg" alt="#"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="banner_area bottom">
                    <div class="banner_thumb">
                        <a href="<?php echo $linkPhuKien; ?>"><img src="<?php echo $imageURL; ?>/bg/banner10.jpg" alt="#"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--product section area start-->
<section class="product_section womens_product">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Danh mục sản phẩm</h2>
                    <p>Các sản phẩm thiết kế hiện đại,mới nhất</p>
                </div>
            </div>
        </div>
        <div class="product_area">
            <div class="row">
                <div class="col-12">
                    <div class="product_tab_button">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#clothing" role="tab" aria-controls="clothing" aria-selected="true">Sản phẩm của TB Store 100% là hàng chính hãng!</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="clothing" role="tabpanel">
                    <div class="product_container">
                        <div class="row product_column4">
                            
                            <?php echo $xhtml; ?>
                            
                        </div>
                    </div>
                    <div class="row"><a href="<?php echo $linkShowAll; ?>" style="text-align:right;color:#ff6a28;font-size:15px;">Xem tất cả sản phẩm</a></div>
                </div>

                
                
            </div>
        </div>

    </div>
</section>
<!--product section area end-->

<!--banner area start-->
<section class="banner_section banner_section_three">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-6 col-md-6">
                <div class="banner_area">
                    <div class="banner_thumb">
                        <a href="<?php echo $linkPhuKien; ?>"><img src="<?php echo $imageURL; ?>/bg/banner11.jpg" alt="#"></a>
                        <div class="banner_content">
                            <h1>Phụ kiện <br> Balo, túi, nón...</h1>
                            <a href="<?php echo $linkPhuKien; ?>">Xem ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="banner_area">
                    <div class="banner_thumb">
                        <a href="<?php echo $linkGiamgia ?>"><img src="<?php echo $imageURL; ?>/bg/banner12.jpg" alt="#"></a>
                        <div class="banner_content">
                            <h1>Giày <br> Giảm đến 50%</h1>
                            <a href="<?php echo $linkGiamgia ?>">Xem ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--banner area end-->

<!--product section area start-->
<section class="product_section womens_product bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Sản phẩm thịnh hành</h2>
                    <p>Sản phẩm ấn tượng và bán chạy nhất</p>

                </div>
            </div>
        </div>
        <div class="product_area">
            <div class="row">
                <div class="product_carousel product_three_column4 owl-carousel">
                    <!-- Special Product Content -->
                    <?php echo $xhtmlSpecial; ?>
                </div>
            </div>
            <div class="row"><a href="<?php echo $linkMoreSpecial; ?>" style="text-align:right;color:#ff6a28;font-size:15px;">Xem thêm</a></div>
        </div>

    </div>
</section>
<!--product section area end-->

<section class="product_section womens_product bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Sản phẩm đang được giảm giá</h2>
                    <p>Sản phẩm được giảm giá lên đến 50% </p>
                </div>
            </div>
        </div>
        <div class="product_area">
            <div class="row">
                <div class="product_carousel product_three_column4 owl-carousel">
                    <!-- Special Product Content -->
                    <?php echo $xhtmlSaleOff; ?>
                </div>
            </div>
            <div class="row"><a href="<?php echo $linkMoreSaleOff; ?>" style="text-align:right;color:#ff6a28;font-size:15px;">Xem thêm</a></div>
        </div>

    </div>
</section>

<!--blog section area start-->
<section class="blog_section blog_section_three">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Bài viết mới nhất</h2>
                    <p>Cập nhật xu thế thời trang</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="blog_wrapper blog_column3 owl-carousel">
                <?php echo $xhtmlBlog; ?>
            </div>
        </div>
    </div>
</section>
<!--blog section area end-->