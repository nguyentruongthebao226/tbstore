<?php 
$pictureAbout  = UPLOAD_URL . 'about' . DS . 'about1.jpg'; 
$pictureUsers  = UPLOAD_URL . 'about' . DS . 'count.png'; 
$pictureOrders = UPLOAD_URL . 'about' . DS . 'count2.png'; 
$pictureHours  = UPLOAD_URL . 'about' . DS . 'count3.png'; 
$pictureHappy  = UPLOAD_URL . 'about' . DS . 'count4.png'; 

$linkShop = URL::createLink('default', 'product', 'list', array('options' => 'all-products'));
?>
 
 <!--breadcrumbs area start-->
  <div class="breadcrumbs_area other_bread">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <div class="breadcrumb_content">
                      <ul>
                          <li>Trang chủ</li>
                          <li>/</li>
                          <li>Giới thiệu</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!--breadcrumbs area end-->

  <!--about section area -->
  <div class="about_section">
      <div class="container">
          <div class="row">
              <div class="col-lg-6 col-md-12">
                  <div class="about_content">
                      <h1>Chào mừng bạn đến TB Store!</h1>
                      <p> Chào mừng bạn đến với TB Store, shop chúng tôi được thành lập vào tháng 10/2021. Tất cả sản phẩm giày tại TB Store đều là hàng chính hãng và chúng tôi cam kết không bán hàng kém chất lượng cho quý khách hàng, cùng với xu thế phát triển trong lĩnh vực giày dép thời trang, Shop không ngừng nâng cao chất lượng phục vụ và đa dạng hoá sản phẩm nhằm đáp ứng tốt hơn nhu cầu của khách hàng. </p>
                      <p>Shop luôn quan tấm đến ý kiến của khách hàng, nên mỗi góp ý của khách hàng góp phần vào sự thành công to lớn của Shop.</p>
                      <div class="view__work">
                          <a href="<?php echo $linkShop; ?>">xem sản phẩm của chúng tôi </a>
                      </div>
                  </div>
              </div>
              <div class="col-lg-6 col-md-12">
                  <div class="about_thumb">
                      
                      <img src="<?php echo $pictureAbout; ?>" alt="">
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!--about section end-->


  <!--counterup area -->
  <div class="counterup_section">
      <div class="container">
          <div class="row">
              <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="single_counterup">
                      <div class="counter_img">
                          <img src="<?php echo $pictureUsers; ?>" alt="">
                      </div>
                      <div class="counter_info">
                          <h2 class="counter_number">2170</h2>
                          <p>Khách hàng đã mua</p>
                      </div>
                  </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="single_counterup count-two">
                      <div class="counter_img">
                          <img src="<?php echo $pictureOrders; ?>" alt="">
                      </div>
                      <div class="counter_info">
                          <h2 class="counter_number">1700</h2>
                          <p>Đơn hàng đã bán</p>
                      </div>
                  </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="single_counterup">
                      <div class="counter_img">
                          <img src="<?php echo $pictureHours; ?>" alt="">
                      </div>
                      <div class="counter_info">
                          <h2 class="counter_number">155</h2>
                          <p>Ngày hoạt động</p>
                      </div>
                  </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="single_counterup count-two">
                      <div class="counter_img">
                          <img src="<?php echo $pictureHappy; ?>" alt="">
                      </div>
                      <div class="counter_info">
                          <h2 class="counter_number">2150</h2>
                          <p>Khách hàng hài lòng</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!--counterup end-->