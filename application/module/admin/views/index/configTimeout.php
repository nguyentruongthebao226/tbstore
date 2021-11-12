<?php
$linkTimeout    = TEMPLATE_PATH . 'admin/main/data/timeout.json';
$data = file_get_contents($linkTimeout);
$data = json_decode($data, TRUE);

$linkActionTimeout    = URL::createLink('admin', 'index', 'configTimeout');
$message = Session::get('message');
Session::delete('message');
$strMessage = Helper::cmsMessage($message);


?>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Config Timeout</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form  action="<?php echo $linkActionTimeout; ?>" method="post" class="form-horizontal">
    <?php echo $strMessage . $this->errors; ?>
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Timeout</label>
                <div class="col-sm-10">
                    <input type="text" id="timeout" name="form[timeout]" value="<?php echo $data['Timeout'] ;?>" class="form-control" />
                </div>
            </div>
            <input type="hidden" name="form[tokenTimeout]" value="<?php echo time(); ?>">
            
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info float-right">Save</button>
        </div>
        <!-- /.card-footer -->
    </form>
</div>