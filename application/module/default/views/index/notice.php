<?php

    $message = '';
    $img     = '';
    $href    = '';
    switch($this->arrParam['type']){
        case 'register-success':
            $img     = '<div class="img-register"><img src="'.TEMPLATE_URL.'default/main/images/tks.PNG"/></div>';
            $href    = 'login.html';
            $message = 'Tài khoản của bạn được tạo thành công. Bấm vào đây để quay về trang đăng nhập!';
            break;
        case 'not-permission':
            $img     = '<div class="img-register"><img src="'.TEMPLATE_URL.'default/main/images/permissions.PNG"/></div>';
            $href    = 'index.html';
            $message = 'Bạn không có quyền truy cập vào chức năng đó. Bấm vào đây để quay về trang chủ!';
            break;
        case 'not-url':
            $img     = '';
            $href    = '';
            $message = 'Đường dẫn không hợp lệ!';
            break;
        case 'buy-success':
            $img     = '<div class="img-register"><img src="'.TEMPLATE_URL.'default/main/images/ordersuccess.jpg"/></div>';
            $href    = 'history.html';
            $message = 'Đặt hàng thành công, cảm ơn bạn đã quan tâm đến TB Store. Bấm vào đây để xem đơn hàng đã đặt!';
            break;
    }
    
?>
<?php echo $img; ?>
<div class="notice"><a class="register" href="<?php echo $href; ?>"><?php echo $message; ?></a></div>