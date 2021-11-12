<?php
error_reporting(E_WARNING);
$imageURL       = TEMPLATE_URL . 'default/main/' .  $this->_dirImg;
$linkHome       = URL::createLink('default', 'index', 'index', null, 'index.html');
$linkShop       = URL::createLink('default', 'product', 'index');
$linkBlogList   = URL::createLink('default', 'blog', 'list', null, 'blog.html');
$linkSanPham    = URL::createLink('default', 'product', 'list', array('options' => 'all-products'), 'products.html');
$linkThinhHanh  = URL::createLink('default', 'product', 'list', array('options' => 'special-products'), 'special.html');
$linkPhuKien    = URL::createLink('default', 'product', 'list', array('category_id' => 28));
$linkGiamgia    = URL::createLink('default', 'product', 'list', array('options' => 'saleoff-products'), 'sale-off.html');
$linkAboutUs    = URL::createLink('default', 'index', 'about', null, 'about.html');
$linkContact    = URL::createLink('default', 'index', 'contact', null, 'contact.html');
$linkMyAccount  = URL::createLink('default', 'user', 'index', null, 'my-account.html');
$linkRegister   = URL::createLink('default', 'index', 'register', null, 'register.html');
$linkLogin      = URL::createLink('default', 'index', 'login', null, 'login.html');
$linkLogout     = URL::createLink('default', 'index', 'logout');
$linkOrders     = URL::createLink('default', 'user', 'history', null, 'history.html');
$linkAdmin      = URL::createLink('admin', 'index', 'index');


$userObj        = Session::get('user');
$xhtml = '<li class="index-register"><a href="' . $linkRegister . '">Đăng ký</a></li>
          <li class="index-login"><a href="' . $linkLogin . '">Đăng nhập</a></li>';
$classAccount   = 'index-login';
$linkAccount    = $linkLogin;

if ($userObj['login'] == true) {
    $classAccount   = 'user-index';
    $linkAccount    = $linkMyAccount;
    $xhtml = '<li class="user-index"><a href="' . $linkMyAccount . '">Tài khoản của tôi</a></li>
              <li class="user-history"><a href="' . $linkOrders . '">Đơn hàng của tôi</a></li>
              <li class="index-logout"><a href="' . $linkLogout . '">Đăng xuất </a></li>';
    if ($userObj['group_acp'] == true) {
        $xhtml .= '<li class=""><a href="' . $linkAdmin . '">Admin Control Panel</a></li>';
    }
}

$model  = new Model();
$cateID = $this->arrParam['category_id'];

$query  = "Select `id`, `name` from `" . TBL_CATEGORY . "` Where `status` = 1";
$listCats = $model->fetchAll($query);
$styleCategory = '';
$listCategory  = '';
if (!empty($listCats)) {
    foreach ($listCats as $key => $value) {
        $idCate  = $value['id'];
        $nameURL = URL::filterURL($value['name']);
        $linkCategory  = URL::createLink('default', 'product', 'list', array('category_id' => $value['id']), "$nameURL-$idCate.html");
        $nameCategory  = $value['name'];
        if ($cateID == $value['id']) {
            $styleCategory = 'style="color:#ff6a28;"';
            $listCategory .= '<li><a ' . $styleCategory . ' href="' . $linkCategory . '">' . $nameCategory . '</a></li>';
        } else {
            $listCategory .= '<li><a href="' . $linkCategory . '">' . $nameCategory . '</a></li>';
        }
    }
}

$linkAllProducts = URL::createLink('default', 'product', 'list', array('options' => 'all-products'), 'products.html');
$linkSpecial     = URL::createLink('default', 'product', 'list', array('options' => 'special-products'), 'special.html');
$linkSale        = URL::createLink('default', 'product', 'list', array('options' => 'saleoff-products'), 'sale-off.html');

$categoryAllProducts     = '<li><a href="' . $linkAllProducts . '">Tất cả sản phẩm</a></li>';
$categorySpecialProducts = '<li><a href="' . $linkSpecial . '">Sản phẩm bán chạy</a></li>';
$categorySaleOffProducts = '<li><a href="' . $linkSale . '">Sản phẩm đang được ưu đãi</a></li>';

if ($this->arrParam['options'] == 'all-products')     $categoryAllProducts     = '<li><a style="color:#ff6a28;" href="' . $linkAllProducts . '">Tất cả sản phẩm</a></li>';
if ($this->arrParam['options'] == 'special-products') $categorySpecialProducts = '<li><a style="color:#ff6a28;" href="' . $linkSpecial . '">Sản phẩm bán chạy</a></li>';
if ($this->arrParam['options'] == 'saleoff-products') $categorySaleOffProducts = '<li><a style="color:#ff6a28;" href="' . $linkSale . '">Sản phẩm đang được ưu đãi</a></li>';

$activeCateSpecial = '';
$activeCateAll = '';
$activeCateSaleOff = '';

if ($this->arrParam['controller'] == 'product' && $this->arrParam['action'] == 'list' && $this->arrParam['options'] == 'special-products') $activeCateSpecial = 'active';
if ($this->arrParam['controller'] == 'product' && $this->arrParam['action'] == 'list' && $this->arrParam['options'] == 'saleoff-products') $activeCateSaleOff = 'active';
if ($this->arrParam['controller'] == 'product' && $this->arrParam['action'] == 'list' && $this->arrParam['options'] == 'all-products') $activeCateAll = 'active';
if ($this->arrParam['controller'] == 'user' && $this->arrParam['action'] == 'history') $activeTaiKhoan = 'active';
if ($this->arrParam['controller'] == 'blog' && $this->arrParam['action'] == 'detail') $activeBlog = 'active';

$controller = !empty($this->arrParam['controller']) ? $this->arrParam['controller'] : 'index';
$action     = !empty($this->arrParam['action']) ? $this->arrParam['action'] : 'index';
?>

<div class="off_canvars_overlay">

</div>
<!-- ------------------------------------------------------offcanvas_menu ---------------------------------------------------->
<div class="offcanvas_menu">
    <div class="canvas_open">
        <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
    </div>
    <div class="offcanvas_menu_wrapper">
        <div class="canvas_close">
            <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
        </div>
        <div class="welcome_text">
            <ul>
                <li><span>Free Delivery:</span> Take advantage of our time to save event</li>
                <li><span>Free Returns *</span> Satisfaction guaranteed</li>
            </ul>
        </div>

        <div class="top_right">
            <ul>
                <li class="top_links"><a href="#">My Account <i class="ion-chevron-down"></i></a>
                    <ul class="dropdown_links">
                        <li><a href="wishlist.html">My Wish List </a></li>
                        <li><a href="<?php echo $linkMyAccount; ?>">My Account </a></li>
                        <li><a href="<?php echo $linkRegister; ?>">Register</a></li>
                        <li><a href="<?php echo $linkLogin; ?>">Login</a></li>
                        <li><a href="compare.html">Compare Products </a></li>
                    </ul>
                </li>
                <li class="language"><a href="#"><img src="<?php echo $imageURL; ?>/logo/language.png" alt=""> English <i class="ion-chevron-down"></i></a>
                    <ul class="dropdown_language">
                        <li><a href="#"><img src="<?php echo $imageURL; ?>/logo/cigar.jpg" alt=""> French</a></li>
                        <li><a href="#"><img src="<?php echo $imageURL; ?>/logo/language2.png" alt="">German</a></li>
                    </ul>
                </li>
                <li class="currency"><a href="#">USD <i class="ion-chevron-down"></i></a>
                    <ul class="dropdown_currency">
                        <li><a href="#">EUR</a></li>
                        <li><a href="#">BRL</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="search_bar">
            <form action="#">
                <select class="select_option" name="select" id="categori">
                    <option selected value="1">All Categories</option>
                    <option value="2">Accessories</option>
                    <option value="3">Bridge</option>
                    <option value="4">Hub</option>
                    <option value="5">Repeater</option>
                    <option value="6">Switch</option>
                    <option value="7">Video Games</option>
                    <option value="8">PlayStation 3</option>
                    <option value="9">PlayStation 4</option>
                    <option value="10">Xbox 360</option>
                    <option value="11">Xbox One</option>
                </select>
                <input placeholder="Search entire store here..." type="text">
                <button type="submit"><i class="ion-ios-search-strong"></i></button>
            </form>
        </div>
        <div class="cart_area">
            <div class="middel_links">
                <ul>
                    <li><a href="login.html">Login</a></li>
                    <li>/</li>
                    <li><a href="login.html">Register</a></li>
                </ul>

            </div>
            <div class="cart_link">
                <a href="#"><i class="fa fa-shopping-basket"></i><?php echo $totalItems; ?> item(s)</a>
                <!--mini cart-->
                <div class="mini_cart">
                    <div class="cart_item top">
                        <div class="cart_img">
                            <a href="#"><img src="<?php echo $imageURL; ?>/s-product/product.jpg" alt=""></a>
                        </div>
                        <div class="cart_info">
                            <a href="#">Apple iPhone SE 16GB</a>

                            <span>1x $60.00</span>

                        </div>
                        <div class="cart_remove">
                            <a href="#"><i class="ion-android-close"></i></a>
                        </div>
                    </div>
                    <div class="cart_item bottom">
                        <div class="cart_img">
                            <a href="#"><img src="<?php echo $imageURL; ?>/s-product/product2.jpg" alt=""></a>
                        </div>
                        <div class="cart_info">
                            <a href="#">Marshall Portable Bluetooth</a>
                            <span> 1x $160.00</span>
                        </div>
                        <div class="cart_remove">
                            <a href="#"><i class="ion-android-close"></i></a>
                        </div>
                    </div>
                    <div class="cart__table">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="text-left">Sub-Total :</td>
                                    <td class="text-right">$150.00</td>
                                </tr>

                                <tr>
                                    <td class="text-left">Total :</td>
                                    <td class="text-right">$184.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="cart_button view_cart">
                        <a href="cart.html">View Cart</a>
                    </div>
                    <div class="cart_button checkout">
                        <a href="checkout.html">Checkout</a>
                    </div>
                </div>
                <!--mini cart end-->
            </div>
        </div>
        <div id="menu" class="text-left ">
            <ul class="offcanvas_main_menu">
                <li class="menu-item-has-children active">
                    <a href="#">Home</a>
                </li>
                <li class="category-index menu-item-has-children">
                    <a href="<?php echo $linkShop ?>">Shop</a>
                    <ul class="sub-menu">
                        <li class="menu-item-has-children">
                            <a href="#">Shop Layouts</a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo $linkShop; ?>">shop</a></li>
                                <li><a href="shop-fullwidth.html">Full Width</a></li>
                                <li><a href="shop-fullwidth-list.html">Full Width list</a></li>
                                <li><a href="shop-right-sidebar.html">Right Sidebar </a></li>
                                <li><a href="shop-right-sidebar-list.html"> Right Sidebar list</a></li>
                                <li><a href="shop-list.html">List View</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">other Pages</a>
                            <ul class="sub-menu">
                                <li><a href="portfolio.html">portfolio</a></li>
                                <li><a href="portfolio-details.html">portfolio details</a></li>
                                <li><a href="cart.html">cart</a></li>
                                <li><a href="checkout.html">Checkout</a></li>
                                <li><a href="<?php echo $linkMyAccount; ?>">my account</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Product Types</a>
                            <ul class="sub-menu">
                                <li><a href="product-details.html">product details</a></li>
                                <li><a href="product-sidebar.html">product sidebar</a></li>
                                <li><a href="product-grouped.html">product grouped</a></li>
                                <li><a href="variable-product.html">product variable</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="blog-index menu-item-has-children">
                    <a href="#">blog</a>
                </li>
                <li class="user-login menu-item-has-children">
                    <a href="<?php echo $linkLogin ?>">Account </a>
                    <ul class="sub-menu">
                        <?php echo $xhtml; ?>
                    </ul>
                </li>
                <li class="user-login menu-item-has-children">
                    <a href="<?php echo $linkMyAccount; ?>">my account</a>
                </li>
                <li class="about-index menu-item-has-children">
                    <a href="about.html">About Us</a>
                </li>
                <li class="contact-index menu-item-has-children">
                    <a href="contact.html"> Contact Us</a>
                </li>
            </ul>
        </div>
        <div class="offcanvas_footer">
            <span><a href="#"><i class="fa fa-envelope-o"></i> info@yourdomain.com</a></span>
            <ul>
                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------offcanvas_menu ---------------------------------------------------->
<!--Offcanvas menu area end-->

<!--header area start-->
<header class="header_area header_three">
    <!--header top start-->
    <div class="header_top">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12">
                    <div class="welcome_text">
                        <ul>
                            <li><span>Free Shipping:</span> Mua sản phẩm ở TB Store sẽ được Free Shipping</li>
                            <li><span>Free Returns *</span> Sản phẩm không đúng sẽ được returns trong 3 ngày</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="top_right text-right">
                        <ul>
                            <li class="<?php echo $classAccount . ' ' . $activeTaiKhoan; ?>"><a href="<?php echo $linkAccount; ?>">Tài khoản</i></a>
                                <ul class="dropdown_links">
                                    <?php echo $xhtml; ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header top start-->

    <!--header middel start-->
    <div class="header_middel">
        <div class="container-fluid">
            <div class="middel_inner">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <a href="<?php echo $linkHome; ?>"><img style="width: 200px; height: 50px;" src="<?php echo $imageURL; ?>/logo/logoTB2.png" alt=""></a>

                    </div>

                    <div class="col-lg-4">
                        <div class="logo">
                            <a href="<?php echo $linkHome; ?>"><img src="<?php echo $imageURL; ?>/logo/logoTB.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <?php include_once 'cart.php'; ?>
                    </div>
                </div>
            </div>
            <!-- ------------------------------------------------------Horizontal ---------------------------------------------------->
            <div class="horizontal_menu">
                <div class="left_menu">
                    <div id="menu" class="main_menu">
                        <nav>
                            <ul>

                                <li class="index-index"><a href="<?php echo $linkHome; ?>">Trang chủ </a>
                                </li>
                                <li class="product-list"><a <?php echo $styleCategory; ?> href="<?php echo $linkAllProducts; ?>">Danh mục <i class="fa fa-angle-down"></i></a>
                                    <ul class="sub_menu pages">
                                        <?php echo $categoryAllProducts; ?>
                                        <?php echo $listCategory; ?>
                                        <?php echo $categorySpecialProducts; ?>
                                        <?php echo $categorySaleOffProducts; ?>
                                    </ul>
                                </li>
                                <li class="product-uudai <?php echo $activeCateSaleOff; ?>"><a href="<?php echo $linkGiamgia ?>">Ưu đãi</a></li>

                                <li class="product-banchay <?php echo $activeCateSpecial; ?>"><a href="<?php echo $linkThinhHanh ?>">Bán chạy</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="right_menu">
                    <div id="menu" class="main_menu">
                        <nav>
                            <ul>
                            <li class="product-phukien <?php echo $activeCateAll; ?>"><a href="<?php echo $linkSanPham ?>">Tất cả sản phẩm </i></a>
                            <li class="blog-list <?php echo $activeBlog; ?>"><a href="<?php echo $linkBlogList ?>">Tin tức </i></a>
                                
                                <li class="index-about"><a href="<?php echo $linkAboutUs ?>">Giới thiệu</a></li>
                                <li class="index-contact"><a href="<?php echo $linkContact ?>">Liên hệ</a></li>

                                <li class="<?php echo $classAccount . ' ' . $activeTaiKhoan; ?>"><a href="<?php echo $linkAccount; ?>">Tài khoản <i class="fa fa-angle-down"></i></a>
                                    <ul class="sub_menu pages">
                                        <?php echo $xhtml; ?>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- ------------------------------------------------------Horizontal ---------------------------------------------------->
        </div>
    </div>
    <!--header middel end-->

    <!--header bottom satrt-->
    <div class="header_bottom sticky-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="main_menu_inner">
                        <div id="menu" class="main_menu">
                            <nav>
                                <ul>
                                    <li class="index-index"><a href="<?php echo $linkHome; ?>">Trang chủ </a></li>
                                    <li class="product-a <?php echo $activeCateAll; ?>"><a href="<?php echo $linkAllProducts; ?>">Danh mục </a></li>
                                    <li class="index-about"><a href="<?php echo $linkAboutUs ?>">Giới thiệu </a></li>
                                    <li class="<?php echo $classAccount . ' ' . $activeTaiKhoan; ?>"><a href="<?php echo $linkAccount; ?>">Tài khoản <i class="fa fa-angle-down"></i></a>
                                        <ul class="sub_menu pages">
                                            <?php echo $xhtml; ?>
                                        </ul>
                                    </li>
                                    <li class="blog-index <?php echo $activeCateSaleOff; ?>"><a href="<?php echo $linkGiamgia ?>">Ưu đãi </a></li>

                                    <li class="index-contact"><a href="<?php echo $linkContact ?>">Liên hệ</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header bottom end-->
    
</header>

<!-- <script type="text/javascript">
    $(document).ready(function(){
        var controller  = '<?php echo $controller; ?>';
        var action      = '<?php echo $action; ?>';
        var classSelect = controller + '-' + action;
        console.log(classSelect);
        $('#menu nav ul li.' + classSelect). addClass('active');
    });
</script> -->
