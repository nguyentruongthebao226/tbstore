<!--breadcrumbs area start-->
<div class="breadcrumbs_area other_bread">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li>trang chủ</li>
                        <li>/</li>
                        <li>giỏ hàng</li>
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

        <?php
        $linkSubmitForm = URL::createLink('default', 'user', 'buy');
        if (!empty($this->Items)) {
            $xhtml      = '';
            $totalPrice = 0;
            foreach($this->Items as $key => $value){
                $linkAction     = URL::createLink('default', 'user', 'cart');
                $linkDeleteProd = URL::createLink('default', 'user', 'cart', array('product_id_trash' => $value['id']));
                $linkDeleteAll  = URL::createLink('default', 'user', 'cart', array('product_id_trash_all' => 'delete-all-cart'));
                
                $idPro          = $value['id'];
                $categoryName   = URL::filterURL($value['category_name']);
                $categoryID     = $value['category_id'];
                $name           = $value['name'];
                $nameURL        = URL::filterURL($name);
                $linkDetailProd = URL::createLink('default', 'product', 'detail', array('product_id' => $value['id']), "$categoryName/$nameURL-$categoryID-$idPro.html");

                $price          = number_format($value['price']);
                $priceTotal     = number_format($value['totalprice']);
                $quantity       = $value['quantity'];
                $size           = $value['size'];
                $totalPrice    += $value['totalprice'];

                $picturePath    = UPLOAD_PATH . 'product' . DS . '448x527-' . $value['picture'];
                if (file_exists($picturePath) == true) {
                    $picture    = '<img style="width:83; height:98;" src="' . UPLOAD_URL . 'product' . DS . '448x527-' . $value['picture'] . '">';
                } else {
                    $picture    = '<img style="width:83; height:98;" src="' . UPLOAD_URL . 'product' . DS . '60x90-default.jpg' . '">';
                }

                $inputProductID = Helper::cmsInput('hidden', 'form[productid][]', 'input_product_', $value['id']);
                $inputQuantity  = Helper::cmsInput('hidden', 'form[quantity][]', 'input_quantity_', $value['quantity']);
                $inputSize      = Helper::cmsInput('hidden', 'form[size][]', 'input_size_', $value['size']);
                $inputPrice     = Helper::cmsInput('hidden', 'form[price][]', 'input_price_', $value['price']);
                $inputName      = Helper::cmsInput('hidden', 'form[name][]', 'input_name_', $value['name']);
                $inputPicture   = Helper::cmsInput('hidden', 'form[picture][]', 'input_picture_', $value['picture']);

                $xhtml .= ' <tr>
                                <td class="product_remove"><a href="'.$linkDeleteProd.'"><i class="fa fa-trash-o"></i></a></td>
                                <td class="product_thumb"><a href="'.$linkDetailProd.'">'.$picture.'</td>
                                <td class="product_name"><a href="#">'.$name.'</a></td>
                                <td class="product-price">'.$price.'</td>
                                <td class="product_total"><a>'.$quantity.'</a></td>
                                <td class="product_name"><a>'.$size.'</a></td>
                                <td class="product_total">'.$priceTotal.'</td>
                            </tr>';
                $xhtml .= $inputProductID . $inputQuantity . $inputSize . $inputPrice . $inputName . $inputPicture;
            }
            $valid   = Session::get('validForm');
            Session::delete('validForm');
            $message = Session::get('messageErrors');
            Session::delete('messageErrors');
        ?>
            <form action="<?php echo $linkSubmitForm; ?>" method="post" name="adminForm" id="adminForm">
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            <div class="cart_page table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product_remove">Xóa</th>
                                            <th class="product_thumb">Hình</th>
                                            <th class="product_name">Sản phẩm</th>
                                            <th class="product-price">Giá</th>
                                            <th class="product_quantity">Số lượng</th>
                                            <th class="product_quantity">Size</th>
                                            <th class="product_total">Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php echo $xhtml; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart_submit">
                                <a style="padding: 10px 15px 10px 15px; background-color:black;color:white;font-weight:bold;" href="<?php echo $linkAllProducts; ?>">TIẾP TỤC MUA HÀNG</a>
                                
                                <a style="padding: 10px 15px 10px 15px; background-color:#ff6a28;color:white;font-weight:bold;" href="<?php echo $linkDeleteAll; ?>">XÓA GIỎ HÀNG</a>
                            </div> 
                        </div>
                    </div>
                </div>

                <!--coupon code area start-->
                <div class="coupon_area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code left">
                                <h3>Thông Tin Đặt Hàng</h3>
                                
                                <div class="coupon_inner">
                                    <label style="margin-top: 7px;">Họ tên</label>
                                    <input name="form[fullname]" style="float:right; padding-left:100px;" type="text" value="<?php echo $valid['form']['fullname']; ?>">                         
                                </div>
                                <div class="coupon_inner">
                                    <label style="margin-top: 7px;">Địa chỉ</label>
                                    <input name="form[address]" style="float:right; padding-left:100px;" type="text" value="<?php echo $valid['form']['address']; ?>">                             
                                </div>
                                <div class="coupon_inner">
                                    <label style="margin-top: 7px;">Số điện thoại</label>
                                    <input name="form[phone]" style="float:right; padding-left:100px;" type="text" value="<?php echo $valid['form']['phone']; ?>">                         
                                </div>
                                <div class="row">
                                    <a href="#"><?php echo $message; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code right">
                                <h3>Thanh Toán</h3>
                                <div class="coupon_inner">
                                    <div class="cart_subtotal">
                                        <p>Tổng tiền</p>
                                        <p class="cart_amount"><?php echo  number_format($totalPrice) ?> VND</p>
                                    </div>
                                    <div class="cart_subtotal ">
                                        <p>Phí ship</p>
                                        <p class="cart_amount">Free Ship</p>
                                    </div>

                                    <div class="checkout_btn">
                                        <a onclick="javascript:submitForm('<?php echo $linkSubmitForm; ?>')" href="#">Thanh toán</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area end-->

            </form>
        <?php
        } else {
        ?>

            <h3 style="color:#ff6a28;">Chưa có sản phẩm nào trong giỏ hàng!</h3>
            <br />

        <?php
        }
        ?>


    </div>
</div>
<!-- shopping cart area end -->