<?php
class Helper
{
    // Create Button
    public static function cmsButton($name, $classIcon, $link, $type = 'new')
    {


        if ($type == 'new') {
            $xhtml = '<a href="' . $link . '" class="btn btn-app"><i class="fas ' . $classIcon . '"></i>' . $name . '</a>';
        } else if ($type == 'submit') {
            $xhtml = '<a href="#" onclick="javascript:submitForm(\'' . $link . '\')" class="btn btn-app"><i class="fa ' . $classIcon . '"></i>' . $name . '</a>';
        }
        return $xhtml;
    }

    // Format date
    public static function formatDate($format, $value)
    {
        $result = '';
        if (!empty($value) && $value != "1000-01-01") {
            $result = date($format, strtotime($value));
        } else {
            $result = '';
        }
        return $result;
    }

    // Create Icon Status
    public static function cmsStatus($statusValue, $link, $id)
    {
        $strStatus = ($statusValue == 0) ? 'fa-lock text-danger' : 'fa-unlock text-info';
        $xhtml     = '<a id="status-' . $id . '" href="javascript:changeStatus(\'' . $link . '\');" class="nav-icon fas ' . $strStatus . '" ></a>';
        return $xhtml;
    }

    // Create Icon Special
    public static function cmsSpecial($statusValue, $link, $id)
    {
        $strStatus = ($statusValue == 0) ? 'fa-lock text-danger' : 'fa-unlock text-info';
        $xhtml     = '<a id="special-' . $id . '" href="javascript:changeSpecial(\'' . $link . '\');" class="nav-icon fas ' . $strStatus . '" ></a>';
        return $xhtml;
    }

    // Create Title sort
    public static function cmsLinkSort($name, $column, $columnPost, $orderPost)
    {
        $img    = '';
        $order  = ($orderPost == 'desc') ? 'asc' : 'desc';
        if ($column == $columnPost) {
            $img    = '<img src="' . TEMPLATE_URL . 'admin\main\images\admin\sort_' . $orderPost . '.png" alt="">';
        }
        $xhtml = '<a style="color:#043f69;" href="#" onclick="javascript:sortList(\'' . $column . '\', \'' . $order . '\' )">' . $name . $img . '</a>';
        return $xhtml;
    }

    // Create Message
    public static function cmsMessage($message)
    {
        $xhtml = '';
        if(!empty($message)){
            $xhtml = '<div class="alert alert-'.$message['class'].' alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas '.$message['icon'].'"></i> Alert!</h5>
                                '.$message['content'].'
                            </div>';
        }
        return $xhtml;
    }

    // Create Selectbox
    public static function cmsSelectBox($name, $class, $arrValue, $keySelect = 'default', $style = null)
    {
        $xhtml  = '<select style="'.$style.'" name="'.$name.'" class="'.$class.'">';
        foreach($arrValue as $key => $value){
            if($key == $keySelect && is_numeric($keySelect)){
                $xhtml .= '<option selected="selected" value="'.$key.'">'.$value.'</option>';
            }else{
                $xhtml .= '<option value="'.$key.'">'.$value.'</option>';
            }              
        }                     
        $xhtml  .= '</select>';
        return $xhtml;
    }

     // Create Selectbox Public
     public static function cmsSelectBoxPublic($name, $arrValue, $style = null)
     {
         $xhtml  = '<a>Size</a><select style="'.$style.'" name="'.$name.'" id="short" class="inputbox"><option selected value="default">Chọn size</option>';
         foreach($arrValue as $key => $value){
            $xhtml .= '<option value="'.$value.'">'.$value.'</option>';      
         }                     
         $xhtml  .= '</select>';
         return $xhtml;
     }

    // Create Input
    public static function cmsInput($type, $name, $id, $value, $class = null, $disable = null, $style = null)
    {
        $xhtml  = "<input type='$type' style='$style' class='$class' value='$value' name='$name' id='$id' $disable>";
        return $xhtml;
    }

    // Create Row - Admin
    public static function cmsRowForm($labelName, $input, $required = false)
    {
        $strRequired = '';
        if($required == true) $strRequired = '<span style="color:red;">&nbsp;*</span>';
        $xhtml  = '<div class="form-group">
                        <label for="exampleInputEmail1">'.$labelName.$strRequired.'</label>
                        '.$input.'
                    </div>';
        return $xhtml;
    }

    // Create Row - Public
    public static function cmsRow($labelName, $input, $required = false)
    {
        $strRequired = '';
        if($required == true) $strRequired = '<span style="color:red;">&nbsp;*</span>';
        $xhtml  = '<p><label>'.$labelName.' '.$strRequired.'</label>'.$input.'</p>';
        return $xhtml;
    }

    // Create Icon Group ACP
    public static function cmsGroupACP($groupAcpValue, $link, $id)
    {
        $strGroupACP = ($groupAcpValue == 0) ? 'fa-lock text-danger' : 'fa-unlock text-info';
        $xhtml       = '<a id="group-acp-' . $id . '" href="javascript:changeGroupACP(\'' . $link . '\');" class="nav-icon fas ' . $strGroupACP . '"></a>';
        return $xhtml;
    }

    public static function filterProductsByCat($valueFilter, $cat){
        if(isset($valueFilter) && $valueFilter != 'default'){
            if($valueFilter == 2 || $valueFilter == 3){
                if($valueFilter == 2) $result    = "WHERE `status` = 1 And `category_id` = '$cat' And `special` = 1"; ;
                if($valueFilter == 3) $result    = "WHERE `status` = 1 And `category_id` = '$cat' And `sale_off` > 1"; ;
            }else{
                $result    = "WHERE `status` = 1 And `category_id` = '$cat'"; 
            }              
        }else{
            $result    = "WHERE `status` = 1 And `category_id` = '$cat'"; 
        }      
        return $result;
    }

    public static function filterProductsByPrice($valueFilter, $where = ''){
        $result = $where. ' ';
        if(isset($valueFilter) && $valueFilter != 'default'){
            if($valueFilter == 0 || $valueFilter == 1){
                if($valueFilter == 0) $result    .= "ORDER BY `price` ASC "; ;
                if($valueFilter == 1) $result    .= "ORDER BY `price` DESC "; ;
            }else{
                $result    .= "ORDER BY `id` DESC ";
            }              
        }else{
            $result    .=  "ORDER BY `id` DESC ";
        }      
        return $result;
    }

    // Create Image
    // public static function createImage($folder, $prefix, $pictureName, $style = null){
        
    // $picturePath = UPLOAD_PATH . $folder . DS . $prefix . $pictureName;
    //     if (file_exists($picturePath) == true) {
    //         $pathPic    = UPLOAD_URL . $folder . DS . $prefix . $folder;
    //         $picture    = '<img '.$style.' src="' . $pathPic . '" >';
    //     } else {
    //         $picture    = '<img '.$style.' src="' . UPLOAD_URL . 'product' . DS . '60x90-default.jpg' . '">';
    //     }
    //     return $picture;
    // }

    // Create Title - Default
    // public static function createTitle($imageURL, $titleName){
    //     $xhtml = '';
    // }
 
}
