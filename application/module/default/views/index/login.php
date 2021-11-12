<?php

// Input
$inputEmail     = Helper::cmsInput('text', 'form[email]', 'email', null);
$inputPassword  = Helper::cmsInput('password', 'form[password]', 'password', null);
$inputToken     = Helper::cmsInput('hidden', 'form[token]', 'token', time());
$inputCaptcha   = Helper::cmsInput('text', 'form[captcha_code]', 'captcha_code', '');

//Row
$rowEmail       = Helper::cmsRow('Email', $inputEmail, true);
$rowPassword    = Helper::cmsRow('Password', $inputPassword, true);

$linkAction     = URL::createLink('default', 'index', 'login');
$linkDangKyTK   = URL::createLink('default', 'index', 'register');

$success = Session::get('success'); 
Session::delete('success');
if(isset($success)){
    $success =  '<div class="alert alert-success alert-dismissible"><h5> Alert!</h5><ul><li>'.$success.' </li></ul></div>'; 
}
?>


<div class="breadcrumbs_area other_bread">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li>Trang chủ</li>
                        <li>/</li>
                        <li>Đăng nhập</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!-- customer login start -->
<div class="customer_login">
    <div class="container">
        <div class="row">
            <!--register area start-->
            <div class="col-lg-12 col-md-12">
                <div class="account_form register">
                    <h2>Login</h2>
                    <?php echo $this->errors . $success; ?>
                    <form action="<?php echo $linkAction; ?>" name="adminform" method="POST">
                        <?php echo $rowEmail . $rowPassword . $inputToken ; ?>
                        <div class="login_submit" >
                            <a href="<?php echo $linkDangKyTK; ?>">Đăng ký tài khoản</a>
                            <button type="submit" class="login">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--register area end-->
        </div>
    </div>
</div>