<?php
 
 include_once ''.MODULE_PATH.'/admin/views/toolbar.php';

// Input

$dataForm       = $this->arrParam['form'];
$inputName      = Helper::cmsInput('text', 'form[name]', 'name', $dataForm['name'], 'form-control');
$inputOrdering  = Helper::cmsInput('text', 'form[ordering]', 'ordering', $dataForm['ordering'], 'form-control');
$inputToken     = Helper::cmsInput('hidden', 'form[token]', 'token', time());
$selectStatus   = Helper::cmsSelectBox('form[status]', 'form-control select2 select2-hidden-accessible', array('default' => 'Select status', 1 => 'publish', 0 => 'unpublish'), $dataForm['status'], 'width: 100%;');
$selectGroupACP = Helper::cmsSelectBox('form[group_acp]', 'form-control select2 select2-hidden-accessible', array('default' => 'Select group acp', 1 => 'yes', 0 => 'no'), $dataForm['group_acp'], 'width: 100%;');

$inputID        = '';
$rowID          = '';
if(isset($this->arrParam['id'])){
    $inputID    = Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'], 'form-control', 'readonly');
    $rowID      = Helper::cmsRowForm('ID', $inputID);
}
// Row
$rowName        = Helper::cmsRowForm('Name', $inputName, true);
$rowOrdering    = Helper::cmsRowForm('Ordering', $inputOrdering);
$rowStatus      = Helper::cmsRowForm('Status', $selectStatus);
$rowGroupACP    = Helper::cmsRowForm('Group ACP', $selectGroupACP);

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
        <?php echo $rowName . $rowStatus . $rowGroupACP . $rowOrdering . $rowID; ?>      
    </div>
    <!-- /.card-body -->
    <div">
        <?php echo $inputToken; ?>
    </div>
</form>


<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>