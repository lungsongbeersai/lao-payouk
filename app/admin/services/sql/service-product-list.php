<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    if(isset($_GET["fetch_data"])){
        $limit = $_POST["limit"];
        $page = 1;
        if (@$_POST['page'] > 1) {
            $start = (($_POST['page'] - 1) * $limit);
            $page = $_POST['page'];
        } else {
            $start = 0;
        }

        @$query.="view_product_titel ";

        if($_POST["product_branch"] !="" && $_POST["product_group_fk"] !="" && $_POST["product_cate_fk"] !="" && $_POST["search_page"] !=""){
            $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
            if($rowCount>0){
                $query.=" WHERE product_branch='".$_POST["product_branch"]."' 
                AND product_group_fk='".$_POST["product_group_fk"]."' 
                AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                $query.=" AND product_name LIKE '%".$_POST["search_page"]."%'";
            }else{
                $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
                if($rowCount>0){
                    $query.=" WHERE product_branch='".$_POST["product_branch"]."' 
                    AND product_group_fk='".$_POST["product_group_fk"]."' 
                    AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                    $query.=" AND product_name LIKE '%".$_POST["search_page"]."%'";
                }else{
                    $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%".$_POST["search_page"]."%' ");
                    if($rowCount>0){
                        $query.=" WHERE product_branch='".$_POST["product_branch"]."' 
                        AND product_group_fk='".$_POST["product_group_fk"]."' 
                        AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                        $query.=" AND cate_name LIKE '%".$_POST["search_page"]."%'";
                    }else{
                        $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%".$_POST["search_page"]."%' ");
                        if($rowCount>0){
                            $query.=" WHERE product_branch='".$_POST["product_branch"]."' 
                            AND product_group_fk='".$_POST["product_group_fk"]."' 
                            AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                            $query.=" AND group_name LIKE '%".$_POST["search_page"]."%'";
                        }else{
                            $query.="WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                        }
                    }
                }
            }
        }else if($_POST["product_branch"] !="" && $_POST["product_group_fk"] !="" && $_POST["product_cate_fk"]!="" && $_POST["search_page"]==""){
            $query.=" WHERE product_branch='".$_POST["product_branch"]."' 
                AND product_group_fk='".$_POST["product_group_fk"]."' 
                AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
        }else if($_POST["product_branch"] !="" && $_POST["product_group_fk"]=="" && $_POST["product_cate_fk"]=="" && $_POST["search_page"]==""){
            $query.=" WHERE product_branch='".$_POST["product_branch"]."'";
        }else if($_POST["product_branch"]=="" && $_POST["product_group_fk"]!="" && $_POST["product_cate_fk"]!="" && $_POST["search_page"]==""){
            $query.=" WHERE product_group_fk='".$_POST["product_group_fk"]."' AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
        }else if($_POST["product_branch"]=="" && $_POST["product_group_fk"]!="" && $_POST["product_cate_fk"]!="" && $_POST["search_page"]!=""){
            $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
            if($rowCount>0){
                $query.=" WHERE product_group_fk='".$_POST["product_group_fk"]."' AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                $query.=" AND product_name LIKE '%".$_POST["search_page"]."%'";
            }else{
                $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
                if($rowCount>0){
                    $query.=" WHERE product_group_fk='".$_POST["product_group_fk"]."' AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                    $query.=" AND product_name LIKE '%".$_POST["search_page"]."%'";
                }else{
                    $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%".$_POST["search_page"]."%' ");
                    if($rowCount>0){
                        $query.=" WHERE product_group_fk='".$_POST["product_group_fk"]."' AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                        $query.=" AND cate_name LIKE '%".$_POST["search_page"]."%'";
                    }else{
                        $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%".$_POST["search_page"]."%' ");
                        if($rowCount>0){
                            $query.=" WHERE product_group_fk='".$_POST["product_group_fk"]."' AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                            $query.=" AND group_name LIKE '%".$_POST["search_page"]."%'";
                        }else{
                            $query.="WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                        }
                    }
                }
            }
        }else if($_POST["product_branch"]=="" && $_POST["product_group_fk"]=="" && $_POST["product_cate_fk"]=="" && $_POST["search_page"]!=""){
            $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
            if($rowCount>0){
                $query.=" WHERE product_name LIKE '%".$_POST["search_page"]."%'";
            }else{
                $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
                if($rowCount>0){
                    $query.=" WHERE product_name LIKE '%".$_POST["search_page"]."%'";
                }else{
                    $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%".$_POST["search_page"]."%' ");
                    if($rowCount>0){
                        $query.=" WHERE cate_name LIKE '%".$_POST["search_page"]."%'";
                    }else{
                        $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%".$_POST["search_page"]."%' ");
                        if($rowCount>0){
                            $query.=" WHERE group_name LIKE '%".$_POST["search_page"]."%'";
                        }else{
                            $query.="WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                        }
                    }
                }
            }
        }else if($_POST["product_branch"]!="" && $_POST["product_group_fk"]=="" && $_POST["product_cate_fk"]=="" && $_POST["search_page"]!=""){
            $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
            if($rowCount>0){
                $query.=" WHERE product_name LIKE '%".$_POST["search_page"]."%'";
            }else{
                $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
                if($rowCount>0){
                    $query.=" WHERE product_name LIKE '%".$_POST["search_page"]."%'";
                }else{
                    $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%".$_POST["search_page"]."%' ");
                    if($rowCount>0){
                        $query.=" WHERE cate_name LIKE '%".$_POST["search_page"]."%'";
                    }else{
                        $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%".$_POST["search_page"]."%' ");
                        if($rowCount>0){
                            $query.=" WHERE group_name LIKE '%".$_POST["search_page"]."%'";
                        }else{
                            $query.="WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                        }
                    }
                }
            }
        }else{
            $query.="";
        }
        

        if($_POST["order_page"] !=""){
            $query.=" ORDER BY product_code ".$_POST["order_page"]." ";
        }else{
            $query.="";
        }

        

        if ($_POST["limit"] != "") {
            $filter_query = $query . 'LIMIT '.$start.', '.$limit.'';
        } else {
            $filter_query = $query;
        }


        $fetch_sql=$db->fn_read_all($filter_query);
        $total_data = $db->fn_fetch_rowcount($query);
        $total_id = $start + 1;
        if ($total_data > 0) {
        foreach($fetch_sql as $row_sql){
            // if($row_sql["pro_detail_location"]!=""){
            //     $img="assets/img/product_detail/".$row_sql["pro_detail_location"];
            // }else{
            //     if($row_sql["product_images"]){
            //         $img="assets/img/product_home/".$row_sql["product_images"];
            //     }else{
            //         $img="assets/img/logo/no_image.png";
            //     }
                
            // }

            if($row_sql["product_images"]){
                $img="../../api/images/product_home/".$row_sql["product_images"];
            }else{
                $img="../../api/images/logo/no_image.png";
            }


            // if($row_sql["pro_detail_open"]=="1"){
            //     $bg2="color:red !important;text-decoration: line-through";
            // }else{
            //     $bg2="";
            // }

            if($row_sql["product_notify"]=="1"){
                $togle_check1="";
                $notify1="<span class='text-danger'>ບໍ່ແຈ້ງເຕືອນ</span>";
            }else{
                $togle_check1="checked";
                $notify1="ແຈ້ງເຕືອນ";
            }


            
?>
            <tr style="vertical-align:middle;<?php echo $bg2?>;">
                <td style="width:110px !important;">
                    <center>
                        <div class="form-check form-switch ms-auto" style="font-size: 14px !important;">
                            <input type="checkbox" class="form-check-input" id="product_notify" name="product_notify" <?php echo @$togle_check1;?> onchange="fn_togle_notify('<?php echo $row_sql['product_code'];?>','<?php echo $row_sql['product_notify'];?>')">
                            <label class="form-check-label" for="product_notify" style="font-size: 14px !important;font-weight:normal !important"><?php echo $notify1;?></label>
                        </div>
                    </center>
                </td>
                <td align="center"><?php echo $total_id++;?></td>
                <td><center><img src='<?php echo $img;?>' width="40px" height="35px"></center></td>
                <td><?php echo $row_sql["cate_name"]?></td>
                <td><?php echo $row_sql["branch_name"]?></td>
                <td colspan="6"></td>
                <td>
                    <?php if($row_sql["product_cut_stock"]=="1"){echo "<span class='text-danger'> - ບໍ່ຕັດສະຕ໋ອກ</span>";}else if($row_sql["product_cut_stock"]=="2"){echo "<span class='text-primary'>- ຕັດສະຕ໋ອກ</span>";}else if($row_sql["product_cut_stock"]=="3"){echo "<span class='text-danger'>- ບໍ່ຕັດສະຕ໋ອກ</span>";}?>
                </td>
                <td align="center">
                    <a href="?add_product&proID=<?php echo base64_encode(($row_sql["product_code"]))?>" type="button" class="btn btn-outline-dark btn-sm">
                        <i class="fas fa-pen"></i> ແກ້ໄຂ
                    </a>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="delete_product('<?php echo $row_sql['product_code'];?>')">
                        <i class="fas fa-trash"></i> ລຶບ
                    </button>
                </td>
            </tr>
            <?php 
                $j=1;
                $sqlDetail=$db->fn_read_all("view_product_list WHERE pro_detail_product_fk='".$row_sql["product_code"]."' ORDER BY pro_detail_code ASC");
                foreach($sqlDetail as $rowDetail){
                    if($rowDetail["pro_detail_open"]=="1"){
                        $togle_check="";
                        $bg="color:red !important;text-decoration: line-through";
                        $open="<span class='text-danger'>ປິດ</span>";
                    }else{
                        $togle_check="checked";
                        $bg="";
                        $open="<span class='text-blue'>ເປິດ</span>";
                    }
            ?>
                <tr style="<?php echo $bg?>;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:100px !important;">
                        <center>
                            <div class="form-check form-switch ms-auto" style="font-size: 14px !important;">
                                <input type="checkbox" class="form-check-input" id="pro_detail_open" name="pro_detail_open" <?php echo @$togle_check;?> onchange="fn_togle_switch('<?php echo $rowDetail['pro_detail_code'];?>','<?php echo $rowDetail['pro_detail_open'];?>')">
                                <label class="form-check-label" for="pro_detail_open" style="font-size: 14px !important;font-weight:normal !important"><?php echo $open;?> &nbsp; &nbsp;</label>
                            </div>
                        </center>
                    </td>
                    <td><?php echo $j++;?>. <?php echo $rowDetail["product_name"]?></td>
                    <td align="center"><?php echo $rowDetail["size_name_la"]?></td>
                    <td align="center"><?php echo @number_format($rowDetail["pro_detail_qty"])?></td>
                    <td align="center"><?php echo @number_format($rowDetail["pro_detail_bprice"])?></td>
                    <td align="center"><?php echo @number_format($rowDetail["pro_detail_sprice"])?></td>
                </tr>
            <?php }?>
            <tr style="border-top:1px dotted #7a7979">
                <td colspan="13"></td>
            </tr>
        <?php }?>
        <tr>
            <td colspan="13">
                <center>
                    <ul class="pagination">
                            <?php
                            if ($limit != "") {
                                $limit1 = $limit;
                            } else {
                                $limit1 = $total_data;
                            }
                            $total_links = ceil($total_data / $limit1);
                            $previous_link = '';
                            $next_link = '';
                            $page_link = '';
                            if ($total_links > 4) {
                                if ($page < 5) {
                                        for ($count = 1; $count <= 5; $count++) {
                                            $page_array[] = $count;
                                        }
                                        $page_array[] = '...';
                                        $page_array[] = $total_links;
                                } else {
                                        $end_limit = $total_links - 5;
                                        if ($page > $end_limit) {
                                            $page_array[] = 1;
                                            $page_array[] = '...';
                                            for ($count = $end_limit; $count <= $total_links; $count++) {
                                                    $page_array[] = $count;
                                            }
                                        } else {
                                            $page_array[] = 1;
                                            $page_array[] = '...';
                                            for ($count = $page - 1; $count <= $page + 1; $count++) {
                                                    $page_array[] = $count;
                                            }
                                            $page_array[] = '...';
                                            $page_array[] = $total_links;
                                        }
                                }
                            } else {
                                for ($count = 1; $count <= $total_links; $count++) {
                                        $page_array[] = $count;
                                }
                            }

                            for ($count = 0; $count < count($page_array); $count++) {
                                if ($page == $page_array[$count]) {
                                        $page_link .= '
                                            <li class="page-item active">
                                            <div class="page-link" href="#">' . $page_array[$count] . ' <span class="sr-only">(current)</span></div>
                                            </li>
                                        ';

                                        $previous_id = $page_array[$count] - 1;
                                        if ($previous_id > 0) {
                                            $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $previous_id . '"><i class="fas fa-chevron-left"></i></a></li>';
                                        } else {
                                            $previous_link = '
                                                    <li class="page-item disabled">
                                                    <div class="page-link" href="#"><i class="fas fa-chevron-left"></i></div>
                                                    </li>
                                            ';
                                        }
                                        $next_id = $page_array[$count] + 1;
                                        if ($next_id > $total_links) {
                                            $next_link = '
                                            <li class="page-item disabled">
                                                <div class="page-link" href="#"><i class="fas fa-chevron-right"></i></div>
                                            </li>
                                            ';
                                        } else {
                                            $next_link = '<li class="page-item"><div class="page-link" href="javascript:void(0)" data-page_number="' . $next_id . '"><i class="fas fa-chevron-right"></i></div></li>';
                                        }
                                } else {
                                        if ($page_array[$count] == '...') {
                                            $page_link .= '
                                            <li class="page-item disabled">
                                            <div class="page-link" href="#">...</div>
                                            </li>
                                            ';
                                        } else {
                                            $page_link .= '
                                            <li class="page-item"><div class="page-link" href="javascript:void(0)" data-page_number="' . $page_array[$count] . '">' . $page_array[$count] . '</div></li>
                                            ';
                                        }
                                }
                            }

                            $output = $previous_link . $page_link . $next_link;
                            echo $output;
                            ?>
                    </ul>
                </center>
            </td>
        </tr>
        <?php }else{?>
            <tr>
                <td colspan="13" align="center" style="height:380px;padding:150px;color:red">
                    <i class="fas fa-times-circle fa-3x"></i><br>
                    ບໍ່ພົບລາຍການ
                </td>
            </tr>
        <?php }?>
<?php }
if(isset($_GET["togle_switch"])){
    if($_POST["pro_detail_open"]=="1"){
        $open="2";
    }else{
        $open="1";
    }
    $sql="pro_detail_open='".$open."' WHERE pro_detail_code='".$_POST["pro_detail_code"]."' ";
    $edit_data=$db->fn_edit("res_products_detail",$sql);
    if($edit_data){
        echo json_encode(array("statusCode" => 200));
    }else{
        echo json_encode(array("statusCode" => 204));
    }
}

if(isset($_GET["togle_noti"])){
    if($_POST["proStus"]=="2"){
        $open="1";
    }else{
        $open="2";
    }
    $sql="product_notify='".$open."' WHERE product_code='".$_POST["product_code"]."' ";
    $edit_data=$db->fn_edit("res_products_list",$sql);
    if($edit_data){
        echo json_encode(array("statusCode" => 200));
    }else{
        echo json_encode(array("statusCode" => 204));
    }
}

if(isset($_GET["delete_data"])){
    $delete1=$db->fn_delete("res_products_list WHERE product_code='".$_POST["field_id"]."' ");
    $delete=$db->fn_delete("res_products_detail WHERE pro_detail_product_fk='".$_POST["field_id"]."' ");
    if($delete){
        echo json_encode(array("statusCode"=>200));
     }else{
        echo json_encode(array("statusCode"=>201));
    }
}

if(isset($_GET["import_excel"])){
    // for($i=0;$i<=count($_POST["countID"]);$i++){
    //     echo $_POST["countID"][$i];
    // }
    foreach ($_POST["data"] as $count) {
        echo $count;
    }
    
}

?>