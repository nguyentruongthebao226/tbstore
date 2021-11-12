 <?php
    if (!empty($this->blogInfo)) {
        $blogInfo       = $this->blogInfo;
        $name           = $blogInfo['name'];
        $description    = $blogInfo['description'];
        $created        = date("m/Y", strtotime($blogInfo['created']));

        $picturePath = UPLOAD_PATH . 'blog' . DS . '448x527-' . $blogInfo['picture'];
        if (file_exists($picturePath) == true) {
            $pathPic    = UPLOAD_URL . 'blog' . DS . '448x527-' . $blogInfo['picture'];
            $picture    = '<img style="width:1108px; height:483px;" src="' . $pathPic . '">';
        } else {
            $picture    = '<img style="width:1108px; height:483px;" src="' . UPLOAD_URL . 'blog' . DS . '60x90-default.jpg' . '">';
        }
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
                         <li>tin tức</li>
                         <li>/</li>
                         <li><?php echo $name; ?></li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!--breadcrumbs area end-->

 <!--blog body area start-->
 <div class="blog_area blog_details">
     <div class="container">
         <div class="row">
             <div class="col-lg-12 col-md-12">
                 <!--blog grid area start-->
                 <div class="blog_details_wrapper">
                     <div class="blog__thumb">
                         <a href="#"><?php echo $picture; ?></a>
                     </div>
                     <div class="blog_info_wrapper">
                         <div class="blog_info_inner">
                             <div class="post__date">
                                 <span class="month"><?php echo $created; ?></span>
                             </div>
                             <div class="post__info">
                                 <div class="post_header">
                                     <h3><?php echo $name; ?></h3>
                                 </div>
                                 <div class="post_meta">
                                     <span>Đăng bởi </span>
                                     <span><a href="#">TB Store</a></span>
                                 </div>
                                 <div class="post_content">
                                     <p><?php echo $description; ?></p>
                                 </div>
                                 <div class="post_meta">
                                     <span>Tags: </span>
                                     <span><a href="#">, <?php echo $name; ?></a></span>
                                     <span><a href="#">, <?php echo $created; ?></a></span>
                                 </div>

                             </div>
                         </div>
                     </div>
                 </div>
                 <!--blog grid area start-->
             </div>
         </div>
     </div>
 </div>
 <!--blog section area end-->