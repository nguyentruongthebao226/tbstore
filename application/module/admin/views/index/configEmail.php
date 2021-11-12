<?php
$linkConfigEmail    = TEMPLATE_PATH . 'admin/main/data/mail-admin.json';
$data = file_get_contents($linkConfigEmail);
$data = json_decode($data, TRUE);

$linkActionEmail    = URL::createLink('admin', 'index', 'configEmail');

$message = Session::get('message');
Session::delete('message');
$strMessage = Helper::cmsMessage($message);


?>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Config Email</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form  action="<?php echo $linkActionEmail; ?>" method="post" class="form-horizontal">
    <?php echo $strMessage . $this->errors; ?>
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" id="emailConfig" name="form[emailConfig]" value="<?php echo $data['EmailConfig'] ;?>" class="form-control" />
                </div>
            </div>
            <input type="hidden" name="form[tokenEmail]" value="<?php echo time(); ?>">
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" id="emailPassword" name="form[emailPassword]" value="<?php echo $data['EmailPassword'] ;?>" class="form-control" />
                </div>
            </div>
            
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info float-right">Save</button>
        </div>
        <!-- /.card-footer -->
    </form>
</div>