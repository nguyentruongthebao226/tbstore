<?php
$cart   = Session::get('cart');
$totalItems      = 0;
$totalPrices     = 0;
if(!empty($cart)) {
    $totalItems  = array_sum($cart['quantity']);
    $totalPrices = number_format(array_sum($cart['price']));
    $xhtmlCart = '';
    if(!empty($cart['quantity'])){
        foreach($cart['quantity'] as $key => $value){
            $queryCart      = "Select `id`, `name`, `price`, `sale_off`, `picture` from `".TBL_PRODUCT."` Where `id` = $key";
            $listCart       = $model->fetchRow($queryCart);
            $priceCart      = $listCart['price'];
            $nameCart       = $listCart['name'];
            $saleOffCart    = $listCart['sale_off'];
            $totalCart      = $value;

            

            $picturePathCart    = UPLOAD_PATH . 'product' . DS . '448x527-' . $listCart['picture'];
            if (file_exists($picturePathCart) == true) {
                $pictureCart    = '<img style="width:83px; height:98px;" src="' . UPLOAD_URL . 'product' . DS . '448x527-' . $listCart['picture'] . '">';
            } else {
                $pictureCart    = '<img style="width:83px; height:98px;" src="' . UPLOAD_URL . 'product' . DS . '60x90-default.jpg' . '">';
            }

            if ($saleOffCart > 1) {
                $priceSaleCart  = (100-$saleOffCart)*$priceCart/100;
                $priceCart      = '<span>'.$totalCart.' x '.number_format($priceSaleCart).'</span>';
            } else {
                $priceCart      = '<span>'.$totalCart.' x '. number_format($priceCart) . '</span>';
            }
       
            $xhtmlCart .= '<div class="cart_item top">
                            <div class="cart_img">
                                <a href="#">'.$pictureCart.'</a>
                            </div>
                            <div class="cart_info">
                                <a href="#">'.$nameCart.'</a>

                                '.$priceCart.'

                            </div>
                            <div class="cart_remove">
                                <a href="#"><i class="ion-android-close"></i></a>
                            </div>
                        </div>';
        }
    }
}
$linkViewCart   = URL::createLink('default', 'user', 'cart', null, 'cart.html');
?>

<div class="cart_area">
    <div class="cart_link">
        <a href="<?php echo $linkViewCart; ?>"><i class="fa fa-shopping-basket"></i><?php echo $totalItems; ?> item(s)</a>
        <!--mini cart-->
        <div class="mini_cart">
            <?php echo $xhtmlCart; ?>
            
            <div class="cart__table">
                <table>
                    <tbody>
                        <tr>
                        <tr>
                            <td class="text-left">Total :</td>
                            <td class="text-right"><?php echo $totalPrices; ?> VND</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="cart_button view_cart">
                <a href="<?php echo $linkViewCart; ?>">View Cart</a>
            </div>
            
        </div>
        <!--mini cart end-->
    </div>
</div>