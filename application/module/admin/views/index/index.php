<?php
$linkProfile    = URL::createLink('admin', 'index', 'form', array('id' => $id));
$arrMenu  = array(
  array('link' => URL::createLink('admin', 'user', 'index'), 'name' => 'User', 'classDiv' => 'bg-warning', 'classIcon' => 'fas fa-user', 'totalItem' => $this->totalItemsUser),
  array('link' => URL::createLink('admin', 'group', 'index'), 'name' => 'Group', 'classDiv' => 'bg-success', 'classIcon' => 'fas fa-users', 'totalItem' => $this->totalItemsGroup),
  array('link' => URL::createLink('admin', 'cart', 'index'), 'name' => 'Cart', 'classDiv' => 'bg-info', 'classIcon' => 'fas fa-shopping-bag', 'totalItem' => $this->totalItemsCart),
  array('link' => URL::createLink('admin', 'product', 'index'), 'name' => 'Product', 'classDiv' => 'bg-danger', 'classIcon' => 'fas fa-tshirt', 'totalItem' => $this->totalItemsProduct),
  array('link' => URL::createLink('admin', 'category', 'index'), 'name' => 'Category', 'classDiv' => 'bg-warning', 'classIcon' => 'fas fa-list', 'totalItem' => $this->totalItemsCategory),
  array('link' => $linkProfile, 'name' => 'Profile', 'classDiv' => 'bg-success', 'classIcon' => 'fas fa-id-card', 'totalItem' => '&nbsp;'),
  array('link' => URL::createLink('admin', 'blog', 'index'), 'name' => 'Blog', 'classDiv' => 'bg-info', 'classIcon' => 'fas fa-blog', 'totalItem' => $this->totalItemsBlog)
);
$xhtml = '';
foreach ($arrMenu as $key => $value) {
  $xhtml .= ' <div class="col-lg-3 col-6">
                    <div class="small-box ' . $value['classDiv'] . '">
                      <div class="inner">
                        <h3>' . $value['totalItem'] . '</h3>

                        <p>' . $value['name'] . '</p>
                      </div>
                      <div class="icon">
                        <i class="' . $value['classIcon'] . '"></i>
                      </div>
                      <a href="' . $value['link'] . '" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>';
}
?>

<div class="row">
  <?php echo $xhtml; ?>
</div>



