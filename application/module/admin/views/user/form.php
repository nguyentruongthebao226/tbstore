<?php
 

include_once ''.MODULE_PATH.'/admin/views/toolbar.php';

// Input
$dataForm       = $this->arrParam['form'];
$inputUserName  = Helper::cmsInput('text', 'form[username]', 'username', $dataForm['username'], 'form-control');
$inputEmail     = Helper::cmsInput('text', 'form[email]', 'email', $dataForm['email'], 'form-control');
$inputFullName  = Helper::cmsInput('text', 'form[fullname]', 'fullname', $dataForm['fullname'], 'form-control');
$inputPassword  = Helper::cmsInput('text', 'form[password]', 'password', $dataForm['password'], 'form-control');
$inputOrdering  = Helper::cmsInput('text', 'form[ordering]', 'ordering', $dataForm['ordering'], 'form-control');
$inputToken     = Helper::cmsInput('hidden', 'form[token]', 'token', time());
$slbStatus      = Helper::cmsSelectBox('form[status]', 'form-control select2 select2-hidden-accessible', array('default' => 'Select status', 1 => 'publish', 0 => 'unpublish'), $dataForm['status'], 'width: 100%;');
$slbGroup       = Helper::cmsSelectBox('form[group_id]', 'form-control select2 select2-hidden-accessible', $this->slbGroup, $dataForm['group_id'], 'width: 100%;');

$inputID        = '';
$rowID          = '';
if(isset($this->arrParam['id']) || $dataForm['id']){
    $inputID        = Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'], 'form-control', 'readonly');
    $rowID          = Helper::cmsRowForm('ID', $inputID);

    $inputUserName  = Helper::cmsInput('text', 'form[username]', 'username', $dataForm['username'], 'form-control', 'readonly');
}
// Row
$rowUserName    = Helper::cmsRowForm('Username', $inputUserName, true);
$rowUserEmail   = Helper::cmsRowForm('Email', $inputEmail, true);
$rowFullName    = Helper::cmsRowForm('FullName', $inputFullName);
$rowPassword    = Helper::cmsRowForm('Password', $inputPassword, true);
$rowOrdering    = Helper::cmsRowForm('Ordering', $inputOrdering);
$rowStatus      = Helper::cmsRowForm('Status', $slbStatus);
$rowGroup       = Helper::cmsRowForm('Group ACP', $slbGroup);

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
        <?php echo $rowUserName . $rowUserEmail . $rowFullName . $rowPassword . $rowStatus . $rowGroup . $rowOrdering . $rowID; ?>      
    </div>
    <!-- /.card-body -->
    <div>
        <?php echo $inputToken; ?>
    </div>
</form>


<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>