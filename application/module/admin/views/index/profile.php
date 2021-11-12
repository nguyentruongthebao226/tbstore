<?php
 
include_once ''.MODULE_PATH.'/admin/views/toolbar.php';

// Input
$dataForm       = $this->arrParam['form'];
$inputFullName  = Helper::cmsInput('text', 'form[fullname]', 'fullname', $dataForm['fullname'], 'form-control');
$inputEmail     = Helper::cmsInput('text', 'form[email]', 'email', $dataForm['email'], 'form-control');
$inputPassword  = Helper::cmsInput('text', 'form[password]', 'password', $dataForm['password'], 'form-control');
$inputID        = Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'], 'form-control', 'readonly');
$inputToken     = Helper::cmsInput('hidden', 'form[token]', 'token', time());

// Row
$rowID          = Helper::cmsRowForm('ID', $inputID);
$rowEmail       = Helper::cmsRowForm('Email', $inputEmail, true);
$rowFullName    = Helper::cmsRowForm('FullName', $inputFullName);
$rowPassword    = Helper::cmsRowForm('Password', $inputPassword, true);

//Message
$message = Session::get('message');
Session::delete('message');
$strMessage = Helper::cmsMessage($message);

?>
<!-- MESSAGE -->
<?php echo $strMessage . $this->errors; ?>
<!-- MESSAGE END -->

<!-- Form -->
<form method="post" name="adminForm" id="adminForm">
    <div class="card-body">
        <?php echo $rowEmail . $rowFullName . $rowID . $rowPassword; ?>      
    </div>
    <!-- /.card-body -->
    <div>
        <?php echo $inputToken; ?>
    </div>
</form>


<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>