<?php
// Input
$inputOldPass   = Helper::cmsInput('password', 'form[old_password]', 'old_password', null);
$inputNewPass   = Helper::cmsInput('password', 'form[password]', 'old_password', null);
$inputCurPass   = Helper::cmsInput('hidden', 'form[current_password]', 'current_password', $userObj['info']['password']);
$inputToken     = Helper::cmsInput('hidden', 'form[token]', 'token', time());

// Row
$rowOldPass     = Helper::cmsRow('Mật khẩu cũ', $inputOldPass, true);
$rowNewPass     = Helper::cmsRow('Mật khẩu mới', $inputNewPass, true);

// Link
$linkAction     = URL::createLink('default', 'user', 'index');

$message = Session::get('errorPassword'); 
Session::delete('errorPassword');
if(isset($message)){
    $message =  '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5><ul><li>'.$message.' </li></ul></div>'; 
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
                        <li>Thông tin tài khoản</li>
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
            

       
                    <br />
                    
                    <div style="font-weight: bold;" class="col-lg-1 col-md-1">
                       <p>Username</p>
                       <p>Email</p>
                       <p>Họ tên</p>
                    </div>
                    <div class="col-lg-6 col-md-6">
                       <p><?php echo $userObj['info']['username'];?></p>
                       <p><?php echo $userObj['info']['email'];?></p>
                       <p><?php echo $userObj['info']['fullname'];?></p>
                    </div>

           
            <!--register area end-->
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">&nbsp;</div>
        <div class="row">
        <div class="col-lg-12 col-md-12">
                <div class="account_form register">
                
                <a style="font-weight: bold;font-size:20px;color:#ff6a28;">Đổi mật khẩu</a>
                <?php echo $this->errors . $message; ?>
                    <form action="<?php echo $linkAction; ?>" name="adminform" method="POST">
                        <?php echo $rowOldPass . $rowNewPass . $inputToken. $inputCurPass ; ?>
                        <div class="login_submit" >
                            <button type="submit" class="login">Đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 500px;">&nbsp;</div>
    </div>
</div>