<?php 
$xhtml = '';
if (!empty($this->Items)) {
    foreach ($this->Items as $key => $value) {
        $nameBlog       = $value['name'];
        $idBlog         = $value['id'];
        $nameURLBlog    = URL::filterURL($nameBlog);
        $link           = URL::createLink('default', 'blog', 'detail', array('blog_id' => $value['id']), "$nameURLBlog/$idBlog.html");
        $description    = substr($value['description'], 0, 1000);
        $created        = date("d/m/Y", strtotime($value['created']));

        $picturePath    = UPLOAD_PATH . 'blog' . DS . '448x527-' . $value['picture'];
        if (file_exists($picturePath) == true) {
            $picture    = '<img style="width:500px; height:320px;" src="' . UPLOAD_URL . 'blog' . DS . '448x527-' . $value['picture'] . '">';
        } else {
            $picture    = '<img style="width:330px; height:245px;" src="' . UPLOAD_URL . 'blog' . DS . '60x90-default.jpg' . '">';
        }

        $xhtml .= '<div class="blog_grid">
                        <div class="blog_thumb">
                            <a href="'.$link.'">'.$picture.'</a>
                        </div>
                        <div class="blog_content">
                            <div class="post_date">
                                <span class="month">'.$created.'</span>
                            </div>
                            <h3 class="post_title"><a href="'.$link.'">'.$name.'</a></h3>
                            <p class="post_desc">'.$description.'</p>
                            <a class="read_more" href="'.$link.'">Xem chi tiết</a>
                            <div class="post_meta">
                                <span>Đăng bởi </span>
                                <span><a href="#">TB store</a></span>
                            </div>
                        </div>
                    </div>';
    }
} else {
    $xhtml = '<h2 style="color:#ff6a28;">Tin tức đang được cập nhật!</h2>';
}


//Pagination
$paginationHTML     = $this->pagination->showPaginationPublic(URL::createLink('default', 'product', 'list'));

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
                        <li>Tin tức</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
<form action="#" method="post" name="adminForm" id="adminForm">
<!--blog body area start-->
<div class="blog_area blog_page blog_reverse">
    <div class="container">
        
            <div class="row">          
                <div class="col-lg-12 col-md-12">
                    <!--blog grid area start-->
                    <div class="blog_grid_area">
                        <?php echo $xhtml; ?>
                    </div>
                    <!--blog grid area start-->
                </div>
            </div>
        
    </div>
</div>
<!--blog section area end-->

<!--blog pagination area start-->
<div class="blog_pagination">
    <div class="container">
        <div class="row">
            <div class="col-12">
            <input type="hidden" name="filter_page" value="1">
                <?php echo $paginationHTML; ?>
            </div>
        </div>
    </div>
</div>
</form>