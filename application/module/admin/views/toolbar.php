<?php
$controller     = $this->arrParam['controller'];

$linkSave       = URL::createLink('admin', $controller, 'form', array('type' => 'save'));
$btnSave        = Helper::cmsButton('Save', 'fa-save', $linkSave, 'submit');

$linkSaveClose  = URL::createLink('admin', $controller, 'form', array('type' => 'save-close'));
$btnSaveClose   = Helper::cmsButton('Save & Close', 'fa-share-square', $linkSaveClose, 'submit');

$linkSaveNew    = URL::createLink('admin', $controller, 'form', array('type' => 'save-new'));
$btnSaveNew     = Helper::cmsButton('Save & New', 'fa-plus-square', $linkSaveNew, 'submit');

$linkNew        = URL::createLink('admin', $controller, 'form');
$btnNew         = Helper::cmsButton('Add', 'fas fa-plus', $linkNew);

$linkOrdering   = URL::createLink('admin', $controller, 'ordering');
$btnOrdering    = Helper::cmsButton('Ordering', 'fas fa-check', $linkOrdering, 'submit');

$linkPublish    = URL::createLink('admin', $controller, 'status', array('type' => 1));
$btnPublish     = Helper::cmsButton('Publish', 'fa-lock-open', $linkPublish, 'submit');

$linkUnpublish  = URL::createLink('admin', $controller, 'status', array('type' => 0));
$btnUnpublish   = Helper::cmsButton('Unpublish', 'fa-lock', $linkUnpublish, 'submit');

$linkDelete     = URL::createLink('admin', $controller, 'delete');
$btnDelete      = Helper::cmsButton('Delete', 'fa-trash-alt', $linkDelete, 'submit');

$linkCancel     = URL::createLink('admin', $controller, 'index');
$btnCancel      = Helper::cmsButton('Cancel', 'fa-window-close', $linkCancel);



switch ($this->arrParam['action']) {
    case 'index':
        if($controller == 'group'){
            $strButton      = $btnPublish . $btnUnpublish . $btnOrdering;
        }else{
            $strButton      = $btnNew . $btnPublish . $btnUnpublish . $btnOrdering . $btnDelete;
        }
        
        break;
    case 'form':
        $strButton      = $btnSave . $btnSaveClose . $btnSaveNew . $btnCancel;
        break;
    case 'edit':
        $strButton      = $btnSave . $btnPublish . $btnUnpublish . $btnCancel;
        break;
    case 'profile':
        $strButton      = $btnSave . $btnSaveClose . $btnCancel;
        break;
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <i class="fas fa-group"></i>
                <h1 class="m-0"><?php echo $this->_title; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a >Home</a></li>
                    <li class="breadcrumb-item active"><?php echo ucfirst($this->arrParam['controller']) ?></li>
                    <li class="breadcrumb-item active"><?php echo ucfirst($this->arrParam['action']) ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">   
        <!-- TOOLBAR BUTTON -->
        <div class="text-center">
            <?php echo $strButton; ?>
        </div>



