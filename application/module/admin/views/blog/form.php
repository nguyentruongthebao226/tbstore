<?php
include_once ''.MODULE_PATH.'/admin/views/toolbar.php';
// Input
$dataForm           = $this->arrParam['form'];
$sale_off           = isset($dataForm['sale_off'])? $dataForm['sale_off'] : 1;
$inputName          = Helper::cmsInput('text', 'form[name]', 'name', $dataForm['name'], 'form-control');
$inputDescription   = '<div class="form-group"><textarea name="form[description]" class="form-control" rows="3">'.$dataForm['description'].'</textarea></div>';
$inputToken         = Helper::cmsInput('hidden', 'form[token]', 'token', time());
$slbStatus          = Helper::cmsSelectBox('form[status]', 'form-control select2 select2-hidden-accessible', array('default' => '- Select status -', 1 => 'publish', 0 => 'unpublish'), $dataForm['status'], 'width: 100%;');
$inputPicture       = Helper::cmsInput('file', 'picture', 'picture', $dataForm['picture'], 'form-control', null, 'height: 47px;' );

$inputID            = '';
$rowID              = '';
$picture            = '';
$inputPictureHidden = '';
if(isset($this->arrParam['id']) || $dataForm['id']){
    $inputID            = Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'], 'form-control', 'readonly');
    $rowID              = Helper::cmsRowForm('ID', $inputID);
    $inputUserName      = Helper::cmsInput('text', 'form[username]', 'username', $dataForm['username'], 'form-control', 'readonly');

    $pathImage          = UPLOAD_URL . 'blog' . DS . '448x527-' . $dataForm['picture'];
    $picture            = '<img src="'.$pathImage.'">';
    $inputPictureHidden = Helper::cmsInput('hidden', 'form[picture_hidden]', 'picture_hidden', $dataForm['picture'], 'form-control', null, 'height: 47px;' );
}

// Row
$rowName        = Helper::cmsRowForm('Name', $inputName, true);
$rowPicture     = Helper::cmsRowForm('Picture', $inputPicture . $picture . $inputPictureHidden);
$rowDescription = Helper::cmsRowForm('Description', $inputDescription);
$rowStatus      = Helper::cmsRowForm('Status', $slbStatus);

//Message
$message = Session::get('message');
Session::delete('message');
$strMessage = Helper::cmsMessage($message);

?>
<!-- MESSAGE -->
<?php echo $strMessage . $this->errors; ?>
<!-- MESSAGE END -->

<!-- Form -->
<form action="#" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <div class="card-body">
        <?php echo $rowName . $rowPicture . $rowDescription . $rowStatus . $rowID; ?>      
    </div>
    <!-- /.card-body -->
    <div>
        <?php echo $inputToken; ?>
    </div>
</form>


<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>