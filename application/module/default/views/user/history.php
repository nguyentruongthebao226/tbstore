<?php
$xhtml = '';
if (!empty($this->Items)) {
    $i = 0;
    $tableHeader = '<thead><tr><th class="product_thumb">Image</th><th class="product_name">Product</th><th class="product-price">Price</th><th class="product-price">Size</th><th class="product_quantity">Quantity</th><th class="product_total">Total</th></tr></thead>';
    foreach ($this->Items as $key => $value) {     
        $i++;
        $cartID         = $value['id'];
        $date           = date("H:i:s d/m/Y", strtotime($value['date']));
        $fullname       = $value['fullname'];
        $address        = $value['address'];
        $phone          = $value['phone'];

        $arrProductID   = json_decode($value['products'], true);
        $arrSize        = json_decode($value['sizes'], true);
        $arrPrice       = json_decode($value['prices'], true);
        $arrName        = json_decode($value['names'], true);
        $arrQuantity    = json_decode($value['quantities'], true);
        $arrPicture     = json_decode($value['pictures'], true);
        $tableContent   = '';
        $totalPrice     = 0;


        foreach ($arrProductID as $keyB => $valueB) {
       
            $query  = "Select `c`.`id`, `c`.`name` from `".TBL_CATEGORY."` as `c`, `".TBL_PRODUCT."` as `p` Where `p`.`status` = 1 And `p`.`id` = $valueB And `p`.`category_id` = `c`.`id`";
            $query  = $model->query($query);
            $result = mysqli_fetch_assoc($query);
            // echo '<pre>';
            // print_r($result);
            // echo '</pre>';
            $categoryId     = $result['id'];
            $categoryName   = URL::filterURL($result['name']);
            $nameURLProduct = URL::filterURL($arrName[$keyB]);
            $idProduct      = $valueB;
        
          
            $linkDetailProd = URL::createLink('default', 'product', 'detail', array('product_id' => $valueB), "$categoryName/$nameURLProduct-$categoryId-$idProduct.html");
            $picturePath    = UPLOAD_PATH . 'product' . DS . '448x527-' . $arrPicture[$keyB];
            if (file_exists($picturePath) == true) {
                $picture    = '<img style="width:42; height:49;" src="' . UPLOAD_URL . 'product' . DS . '448x527-' . $arrPicture[$keyB] . '">';
            } else {
                $picture    = '<img style="width:83; height:98;" src="' . UPLOAD_URL . 'product' . DS . '60x90-default.jpg' . '">';
            }
            $totalPrice     += $arrQuantity[$keyB] * $arrPrice[$keyB];
            $tableContent  .= '<tr>
                                <td class="product_thumb"><a href="'.$linkDetailProd.'">'.$picture.'</a></td>
                                <td class="product_name"><a href="#">' . $arrName[$keyB] . '</a></td>
                                <td class="product_total">' . number_format($arrPrice[$keyB]) . '</td>
                                <td class="product_total">' . $arrSize[$keyB] . '</td>
                                <td class="product_total">' . $arrQuantity[$keyB] . '</td>
                                <td class="product_total">' . number_format($arrQuantity[$keyB] * $arrPrice[$keyB]) . ' VND</td>
                            </tr>';
        }

        $xhtml .= '<div class="history-cart" style="font-size:30px;color:#ff6a28;">Đơn hàng ' . $i . '</div><br />
                    <div class="history-cart">
                        <form action="#">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table_desc">
                                        <div class="cart_page table-responsive">
                                            <div class="history-cart">
                                                <h4>Mã đơn hàng: ' . $cartID . ' - Thời gian: ' . $date . '</h4>
                                                <h4>Họ tên người nhận: ' . $fullname . ' - Địa chỉ người nhận: ' . $address . ' - SĐT người nhận: ' . $phone . '</h4>
                                                <table>
                                                    ' . $tableHeader . '
                                                    <tbody>
                                                    ' . $tableContent . '
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="cart_submit">
                                            <a style="font-weight:bold;font-size:15px;color:#ff6a28;">Tổng tiền đơn hàng: </a><a style="font-weight:bold;font-size:15px;">' . number_format($totalPrice) . ' VND</a>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>';
    }
} else {
    $xhtml = ' <h3 style="color:#ff6a28;">Chưa có dơn hàng nào!</h3><br />';
}
?>

<!--breadcrumbs area start-->
<div class="breadcrumbs_area other_bread">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li>Trang chủ</li>
                        <li>/</li>
                        <li>Đơn hàng của tôi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!-- shopping cart area start -->
<div class="shopping_cart_area">
    <div class="container">
        <?php echo $xhtml; ?>
    </div>
</div>
<!-- shopping cart area end -->