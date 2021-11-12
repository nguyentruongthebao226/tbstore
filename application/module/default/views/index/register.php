<?php

$dataForm       = $this->arrParam['form'];

// Input
$inputUserName  = Helper::cmsInput('text', 'form[username]', 'username', $dataForm['username']);
$inputFullName  = Helper::cmsInput('text', 'form[fullname]', 'fullname', $dataForm['fullname']);
$inputEmail     = Helper::cmsInput('text', 'form[email]', 'email', $dataForm['email']);
$inputPassword  = Helper::cmsInput('password', 'form[password]', 'password', $dataForm['password']);
$inputToken     = Helper::cmsInput('hidden', 'form[token]', 'token', time());
$inputCaptcha   = Helper::cmsInput('text', 'form[captcha_code]', 'captcha_code', '');

//Row
$rowUserName    = Helper::cmsRow('Username', $inputUserName, true);
$rowFullName    = Helper::cmsRow('Full Name', $inputFullName);
$rowEmail       = Helper::cmsRow('Email', $inputEmail, true);
$rowPassword    = Helper::cmsRow('Password', $inputPassword, true);
$rowCaptcha     = Helper::cmsRow('Captcha', $inputCaptcha, true);

$linkAction     = URL::createLink('default', 'index', 'register');
?>


<div class="breadcrumbs_area other_bread">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li>Trang chủ</li>
                        <li>/</li>
                        <li>Đăng ký</li>
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
                    <h2>Register</h2>
                    <?php echo $this->errors; ?>
                    <form action="<?php echo $linkAction; ?>" name="adminform" method="POST">
                        <?php echo $rowUserName . $rowFullName . $rowPassword . $rowEmail . $inputToken; ?>

                        <img names="captcha" id="captcha" src="<?php echo TEMPLATE_URL . 'default/main/'; ?>/securimage/securimage_show.php" alt="CAPTCHA Image" />
                        <a href="#" onclick="document.getElementById('captcha').src = '<?php echo TEMPLATE_URL . 'default/main/'; ?>/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
                        <?php echo $rowCaptcha; ?>
                        <div class="login_submit">
                            <button type="submit" class="register">Register</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--register area end-->
        </div>
    </div>
</div>