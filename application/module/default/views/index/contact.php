  <?php
    // require_once ''.LIBRARY_PATH.'Mail/Mail.class.php';
    $linkActionContact = URL::createLink('default', 'index', 'contact');

    $success = Session::get('successContact');
    Session::delete('successContact');
    if (isset($success)) {
        $success =  '<div class="alert alert-success alert-dismissible"><h5> Alert!</h5><ul><li>'.$success.' </li></ul></div>'; 
    }
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
                          <li>Liên Hệ</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!--breadcrumbs area end-->


  <!--contact area start-->
  <div class="contact_area">
      <div class="container">
          <div class="row">
              <div class="col-lg-6 col-md-12">
                  <div class="contact_message content">
                      <h3>Liên hệ với TB Store</h3>
                      <p>Nếu bạn có góp ý hoặc không hài lòng về dịch vụ của Store thì hãy điền vào form, mỗi một góp ý giúp cho TB Store ngày càng phát triển hơn. Giao hàng trong mùa dịch đôi khi lâu hơn dự kiến nên mong quý khách hàng thông cảm cho TB Store!</p>
                      <ul>
                          <li><i class="fa fa-fax"></i> Địa chỉ : Quận 4, TP.HCM</li>
                          <li><i class="fa fa-phone"></i> 0938641861</li>
                          <li><i class="fa fa-envelope-o"></i> <a href="#">callmebaobao22@gmail.com</a></li>
                      </ul>
                  </div>
              </div>
              <div class="col-lg-6 col-md-12">
                  <div class="contact_message form">
                      <h3>Form liên hệ</h3>
                      <?php echo $this->errors . $success; ?>
                      <form id="contactForm" method="POST" action="<?php echo $linkActionContact; ?>">
                          <p>
                              <label> Họ tên (required)</label>
                              <input name="form[name]" placeholder="Họ tên *" type="text" value="<?php echo $this->arrParam['form']['name']; ?>">
                          </p>
                          <p>
                              <label> Địa chỉ Email (required)</label>
                              <input name="form[email]" placeholder="Email *" type="email" value="<?php echo $this->arrParam['form']['email']; ?>">
                          </p>
                          <p>
                              <label> Tiêu đề</label>
                              <input name="form[subject]" placeholder="Tiêu đề *" type="text" value="<?php echo $this->arrParam['form']['subject']; ?>">
                          </p>
                          <div class="contact_textarea">
                              <label> Nội dung</label>
                              <textarea placeholder="Nội dung *" name="form[description]" value="<?php echo $this->arrParam['form']['description']; ?>" class="form-control2"></textarea>
                          </div>
                          <input type="hidden" name="form[token]" value="<?php echo time() ?>" />
                          <div class="product_desc">
                              <a id="submit" onclick="document.getElementById('contactForm').submit();" class="button">Gửi Form</a>
                          </div>
                          <p class="form-messege"></p>
                      </form>

                  </div>
              </div>
          </div>
      </div>
  </div>

  <!--contact area end-->