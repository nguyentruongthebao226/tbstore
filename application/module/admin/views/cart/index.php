<!-- TOOLBAR  -->
<?php
include_once(MODULE_PATH . 'admin/views/toolbar.php');
?>
<?php
error_reporting(E_WARNING);
$columnPost     = isset($this->arrParam['filter_column']) ? $this->arrParam['filter_column'] : 'name';
$orderPost      = isset($this->arrParam['filter_column_dir']) ? $this->arrParam['filter_column_dir'] : 'asc';
$lblUserName    = Helper::cmsLinkSort('Username', 'username', $columnPost, $orderPost);
$lblFullName    = Helper::cmsLinkSort('Fullname', 'fullname', $columnPost, $orderPost);
$lblPhone       = Helper::cmsLinkSort('Phone', 'phone', $columnPost, $orderPost);
$lblAddress     = Helper::cmsLinkSort('Address', 'address', $columnPost, $orderPost);
$lblProducts    = Helper::cmsLinkSort('Products', 'products', $columnPost, $orderPost);
$lblPrices      = Helper::cmsLinkSort('Prices', 'prices', $columnPost, $orderPost);
$lblSizes       = Helper::cmsLinkSort('Sizes', 'sizes', $columnPost, $orderPost);
$lblQuantities  = Helper::cmsLinkSort('Quantities', 'quantities', $columnPost, $orderPost);
$lblNames       = Helper::cmsLinkSort('Names', 'names', $columnPost, $orderPost);
$lblStatus      = Helper::cmsLinkSort('Status', 'status', $columnPost, $orderPost);
$lblDate        = Helper::cmsLinkSort('Date', 'date', $columnPost, $orderPost);



// SELECT Status
$arrStatus          = array('default' => '- Select Status -', 1 => 'Publish', 0 => 'Unpublish');
$selectboxStatus    = Helper::cmsSelectBox('filter_state', 'inputbox', $arrStatus, $this->arrParam['filter_state'], 'margin-left: 10px;height:35px;');


//Pagination
$paginationHTML     = $this->pagination->showPagination(URL::createLink('admin', 'cart', 'index'));
$endPagination      = $this->pagination->showEndPagination();

//Message
$message = Session::get('message');
Session::delete('message');
$strMessage = Helper::cmsMessage($message);

?>

<!-- MESSAGE -->
<?php echo $strMessage; ?>
<!-- MESSAGE END -->

<!-- TABLE -->
<div class="card text-center">
    <div class="card-body">
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12 col-md-6"></div>
                <div class="col-sm-12 col-md-6"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                        <form action="#" method="post" name="adminForm" id="adminForm">
                            <!-- Filter Search -->
                            <div id="filter-bar" class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div id="filter" class="input-group input-group-lg">
                                            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->arrParam['filter_search']; ?>" placeholder="Search....">
                                            <button style="margin-left: 5px;" type="submit" class="btn btn-info" name="submit-keyword">Search</button>
                                            <button style="margin-left: 5px;" type="submit" class="btn btn-default" name="clear-keyword">Clear</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3"></div>
                                <div class="col-3">
                                    <div class="filter-select fltrt">
                                        <?php echo $selectboxStatus; ?>

                                    </div>
                                </div>
                            </div>

                            <!-- Filter End -->
                            <thead>
                                <tr role="row">
                                    <th style="width: 117px;">
                                        <input id="checkAll" type="checkbox" name="checkall-toggle" />
                                    </th>
                                    <!-- <i style="margin-left: 10px;" class="fas fa-caret-square-up"></i> -->
                                    <th style="width: 178px;"><?php echo $lblUserName; ?></th>
                                    <th style="width: 34px;"><?php echo $lblFullName; ?></th>
                                    <th style="width: 34px;"><?php echo $lblPhone; ?></th>
                                    <th style="width: 34px;"><?php echo $lblAddress; ?></th>
                                    <th style="width: 34px;"><?php echo $lblProducts; ?></th>
                                    <th style="width: 34px;"><?php echo $lblPrices; ?></th>
                                    <th style="width: 34px;"><?php echo $lblSizes; ?></th>
                                    <th style="width: 34px;"><?php echo $lblQuantities; ?></th>
                                    <th style="width: 45px;"><?php echo $lblNames; ?></th>
                                    <th style="width: 68px;"><?php echo $lblStatus; ?></th>
                                    <th style="width: 68px;"><?php echo $lblDate; ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if (!empty($this->Items)) {
                                    $i = 0;
                                    foreach ($this->Items as $key => $value) {
                                        $id          = $value['id'];
                                        $ckb         = '<input type="checkbox" name="cid[]" value="' . $id . '" >';
                                        $username    = $value['username'];
                                        $fullname    = $value['fullname'];
                                        $phone       = $value['phone'];
                                        $address     = $value['address'];
                                        $products    = $value['products'];
                                        $prices      = $value['prices'];
                                        $sizes       = $value['sizes'];
                                        $quantities  = $value['quantities'];
                                        $names       = $value['names'];
                                        $row         = ($i % 2 == 0) ? 'even' : 'odd';
                                        $status      = Helper::cmsStatus($value['status'], URL::createLink('admin', 'cart', 'ajaxStatus', array('id' => $id, 'status' => $value['status'])), $id);
                                        $date        = $value['date'];
                                      

                                        
                                        
                                        $ordering    = '<input style="width:34px; text-align:center;" type="text" name="order[' . $id . ']" value="' . $value['ordering'] . '">';
                                        // $linkEdit    = URL::createLink('admin', 'group', 'form', array('id' => $id));


                                ?>
                                        <tr class="<?php echo $row; ?>">
                                            <td class="center"><?php echo $ckb; ?></td>
                                            <td class=" "><a style="color:black" href="#"><?php echo $username; ?></a></td>
                                            <td class=" "><?php echo $fullname; ?></td>
                                            <td class=" "><?php echo $phone; ?></td>
                                            <td class=" "><?php echo $address; ?></td>
                                            <td class=" "><?php echo $products; ?></td>
                                            <td class=" "><?php echo $prices; ?></td>
                                            <td class=" "><?php echo $sizes; ?></td>
                                            <td class=" "><?php echo $quantities; ?></td>
                                            <td class=" "><?php echo $names; ?></td>
                                            <td class=" "><?php echo $status; ?></td>
                                            <td class=" "><?php echo $date; ?></td>
                                            <td class=" "><?php echo $id; ?></td>
                                        </tr>
                                <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                            <div>
                                <input type="hidden" name="filter_column" value="username">
                                <input type="hidden" name="filter_page" value="1">
                                <input type="hidden" name="filter_column_dir" value="desc">
                            </div>
                        </form>
                    </table>
                </div>
            </div>
            <!-- PAGINATION -->
            <div class="row">
                <div class="col-sm-12 col-md-1">
                    <!-- <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div> -->
                    <?php echo $endPagination ?>
                </div>
                <div class="col-sm-12 col-md-4"></div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                        <?php echo $paginationHTML ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>
</div>
</section>