<?php
include_once ''.MODULE_PATH.'/admin/views/toolbar.php';
// Input
$dataForm           = $this->arrParam['form'];
$sale_off           = isset($dataForm['sale_off'])? $dataForm['sale_off'] : 1;
$inputName          = Helper::cmsInput('text', 'form[name]', 'name', $dataForm['name'], 'form-control');
$inputDescription   = '<div class="form-group"><textarea name="form[description]" class="form-control" rows="3">'.$dataForm['description'].'</textarea></div>';
$inputPrice         = Helper::cmsInput('text', 'form[price]', 'price', $dataForm['price'], 'form-control');
$inputSize          = Helper::cmsInput('text', 'form[size]', 'size', $dataForm['size'], 'form-control');
$inputSaleOff       = Helper::cmsInput('text', 'form[sale_off]', 'sale_off', $sale_off, 'form-control');
$inputOrdering      = Helper::cmsInput('text', 'form[ordering]', 'ordering', $dataForm['ordering'], 'form-control');
$inputToken         = Helper::cmsInput('hidden', 'form[token]', 'token', time());
$slbStatus          = Helper::cmsSelectBox('form[status]', 'form-control select2 select2-hidden-accessible', array('default' => '- Select status -', 1 => 'publish', 0 => 'unpublish'), $dataForm['status'], 'width: 100%;');
$slbSpecial         = Helper::cmsSelectBox('form[special]', 'form-control select2 select2-hidden-accessible', array('default' => '- Select special -', 1 => 'yes', 0 => 'no'), $dataForm['special'], 'width: 100%;');
$slbCategory        = Helper::cmsSelectBox('form[category_id]', 'form-control select2 select2-hidden-accessible', $this->slbCategory, $dataForm['category_id'], 'width: 100%;');
$inputPicture       = Helper::cmsInput('file', 'picture', 'picture', $dataForm['picture'], 'form-control', null, 'height: 47px;' );

$inputID            = '';
$rowID              = '';
$picture            = '';
$inputPictureHidden = '';
if(isset($this->arrParam['id']) || $dataForm['id']){
    $inputID            = Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'], 'form-control', 'readonly');
    $rowID              = Helper::cmsRowForm('ID', $inputID);
    $inputUserName      = Helper::cmsInput('text', 'form[username]', 'username', $dataForm['username'], 'form-control', 'readonly');

    $pathImage          = UPLOAD_URL . 'product' . DS . '448x527-' . $dataForm['picture'];
    $picture            = '<img src="'.$pathImage.'">';
    $inputPictureHidden = Helper::cmsInput('hidden', 'form[picture_hidden]', 'picture_hidden', $dataForm['picture'], 'form-control', null, 'height: 47px;' );
}
// Row
$rowName        = Helper::cmsRowForm('Name', $inputName, true);
$rowPicture     = Helper::cmsRowForm('Picture', $inputPicture . $picture . $inputPictureHidden);
$rowDescription = Helper::cmsRowForm('Description', $inputDescription);
$rowSaleOff     = Helper::cmsRowForm('Sale Off', $inputSaleOff);
$rowPrice       = Helper::cmsRowForm('Price', $inputPrice, true);
$rowSize        = Helper::cmsRowForm('Size', $inputSize, true);
$rowOrdering    = Helper::cmsRowForm('Ordering', $inputOrdering, true);
$rowStatus      = Helper::cmsRowForm('Status', $slbStatus);
$rowSpecial     = Helper::cmsRowForm('Special', $slbSpecial);
$rowCategory    = Helper::cmsRowForm('Category', $slbCategory, true);


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
        <?php echo $rowName . $rowPicture . $rowDescription . $rowPrice . $rowSize . $rowSaleOff . $rowCategory . $rowStatus . $rowSpecial . $rowOrdering . $rowID; ?>      
    </div>
    <!-- /.card-body -->
    <div>
        <?php echo $inputToken; ?>
    </div>
</form>


<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>