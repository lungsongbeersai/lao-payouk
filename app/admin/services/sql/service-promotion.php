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

        @$query.="view_promotion ";

        if($_SESSION["user_permission_fk"]=="202300000001"){
            
            if($_POST["search"] !=""){
                $check=$db->fn_fetch_rowcount("view_promotion WHERE store_name LIKE '%".$_POST["search"]."%'");
                if($check>0){
                    $query.="WHERE store_name LIKE '%".$_POST["search"]."%'";
                }else{
                    $check1=$db->fn_fetch_rowcount("view_promotion WHERE branch_name LIKE '%".$_POST["search"]."%'");
                    if($check1>0){
                        $query.="WHERE branch_name LIKE '%".$_POST["search"]."%'";
                    }else{
                        $check2=$db->fn_fetch_rowcount("view_promotion WHERE users_name LIKE '%".$_POST["search"]."%'");
                        if($check2>0){
                            $query.="WHERE users_name LIKE '%".$_POST["search"]."%'";
                        }else{
                            $query.="WHERE users_name='iokl895624llkkkddxx'";
                        }
                    }
                }
            }else{
                $query.="";
            }
            
            if($_POST["orderby"] !=""){
                $query.=" ORDER BY promo_id ".$_POST["orderby"]." ";
            }else{
                $query.="";
            }
    
            if ($_POST["limit"] != "") {
                $filter_query = $query . 'LIMIT '.$start.', '.$limit.'';
            } else {
                $filter_query = $query;
            }

        }else{
            $query.=" WHERE promo_store_fk='".$_SESSION["user_store_fk"]."' ";

            if($_POST["search"] !=""){
                $check=$db->fn_fetch_rowcount("view_promotion WHERE store_name LIKE '%".$_POST["search"]."%'");
                if($check>0){
                    $query.="AND store_name LIKE '%".$_POST["search"]."%'";
                }else{
                    $check1=$db->fn_fetch_rowcount("view_promotion WHERE branch_name LIKE '%".$_POST["search"]."%'");
                    if($check1>0){
                        $query.="AND branch_name LIKE '%".$_POST["search"]."%'";
                    }else{
                        $check2=$db->fn_fetch_rowcount("view_promotion WHERE users_name LIKE '%".$_POST["search"]."%'");
                        if($check2>0){
                            $query.="AND users_name LIKE '%".$_POST["search"]."%'";
                        }else{
                            $query.="AND users_name='iokl895624llkkkddxx'";
                        }
                    }
                }
            }else{
                $query.="";
            }
            
            if($_POST["orderby"] !=""){
                $query.=" ORDER BY promo_id ".$_POST["orderby"]." ";
            }else{
                $query.="";
            }
    
            if ($_POST["limit"] != "") {
                $filter_query = $query . 'LIMIT '.$start.', '.$limit.'';
            } else {
                $filter_query = $query;
            }

        }



        

        $fetch_sql=$db->fn_read_all($filter_query);
        $total_data = $db->fn_fetch_rowcount($query);
        $total_id = $start + 1;
        if ($total_data > 0) {
        foreach($fetch_sql as $row_sql){
            if($row_sql["promo_status"]=="1"){
                $colors="";
                $togle_check="checked";
                $disabled="";
            }else{
                $colors="text-danger";
                $togle_check="";
                $disabled="disabled";
            }
            $s_time=substr($row_sql['promo_start_time'],0,2);
            $s_time_sa=substr($row_sql['promo_start_time'],3);

            $e_time=substr($row_sql['promo_end_time'],0,2);
            $e_time_sa=substr($row_sql['promo_end_time'],3);
?>
            <tr class="table_hover <?php echo $colors;?>">
                <td>
                    <center>
                        <div class="form-check form-switch ms-auto">
                            <input type="checkbox" class="form-check-input" id="pro_detail_open" name="pro_detail_open" <?php echo @$togle_check;?> onchange="fn_togle_switch('<?php echo $row_sql['promo_id'];?>','<?php echo $row_sql['promo_status'];?>')">
                            <label class="form-check-label" for="pro_detail_open">&nbsp;</label>
                        </div>
                    </center>
                </td>
                <td align="center"><?php echo $total_id++;?></td>
                <td><?php echo $row_sql["store_name"]?></td>
                <td><?php echo $row_sql["branch_name"]?></td>
                <td><?php echo date("d/m/Y",strtotime($row_sql["promo_start_date"]))?> <?php echo $row_sql["promo_start_time"]?></td>
                <td><?php echo date("d/m/Y",strtotime($row_sql["promo_end_date"]))?> <?php echo $row_sql["promo_end_time"]?></td>
                <td><?php echo $row_sql["fullnameSize"]?></td>
                <td align="center"><?php echo $row_sql["promo_qty"]?></td>
                <td align="center"><?php echo $row_sql["promo_gif_qty"]?></td>
                <td align="center"><?php echo $row_sql["promo_qty_total"]?></td>
                <td align="center"><?php echo @number_format($row_sql["promo_price"])?>
            </td>
                <td align="center">
                    <button type="button" class="btn btn-outline-primary btn-sm" <?php echo $disabled;?> onclick="edit_function('<?php echo $row_sql['promo_id'];?>','<?php echo $row_sql['promo_store_fk'];?>','<?php echo $row_sql['promo_branch_fk'];?>','<?php echo $row_sql['promo_start_date'];?>','<?php echo $s_time;?>','<?php echo $s_time_sa;?>','<?php echo $row_sql['promo_end_date'];?>','<?php echo $e_time;?>','<?php echo $e_time_sa;?>','<?php echo $row_sql['promo_product_fk'];?>','<?php echo $row_sql['promo_qty'];?>','<?php echo $row_sql['promo_gif_qty'];?>','<?php echo $row_sql['promo_qty_total'];?>','<?php echo $row_sql['promo_price'];?>')">
                        <i class="fas fa-pen"></i> ແກ້ໄຂ
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" <?php echo $disabled;?> onclick="delete_user('<?php echo $row_sql['promo_id'];?>','<?php echo $row_sql['promo_product_fk'];?>')">
                        <i class="fas fa-trash"></i> ລຶບ
                    </button>
                </td>
            </tr>
        <?php }?>
        <tr style="border-top:1px solid #DEE2E6">
            <td colspan="12">
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
                <td colspan="12" align="center" style="height:380px;padding:150px;color:red">
                    <i class="fas fa-times-circle fa-3x"></i><br>
                    ບໍ່ພົບລາຍການ
                </td>
            </tr>
        <?php }?>
<?php }
    if(isset($_GET["insert_data"])){
        $auto_number=$db->fn_autonumber("promo_id","res_promotion");
        $promo_qty=filter_var($_POST["promo_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $promo_gif_qty=filter_var($_POST["promo_gif_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $promo_qty_total=filter_var($_POST["promo_qty_total"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        $start_time=$_POST["promo_start_time"].":".$_POST["promo_start_time_sa"];
        $end_time=$_POST["promo_end_time"].":".$_POST["promo_end_time_sa"];
        $promo_price=filter_var($_POST["promo_price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        $edit=$db->fn_edit("res_products_detail","pro_detail_gif='2',pro_detail_date_pomo='".$_POST["promo_end_date"]."',pro_detail_time_pomo='".$end_time."',
        pro_detail_promotion_price='".$promo_price."' WHERE pro_detail_code='".$_POST["promo_product_fk"]."' ");

        if($_POST["promo_id"] !=""){

            // $checkpromo=$db->fn_fetch_rowcount("res_promotion WHERE promo_product_fk='".$_POST["promo_product_fk"]."' AND promo_status='1' ");
            // if($checkpromo=="0"){
            //     $sqlpromotion=$db->fn_fetch_single_all("res_promotion WHERE promo_id='".$_POST["promo_id"]."' AND promo_status='1' ");
            //     $edit_old=$db->fn_edit("res_products_detail","pro_detail_gif='1' WHERE pro_detail_code='".$sqlpromotion["promo_product_fk"]."' ");
            //     $edit_now=$db->fn_edit("res_products_detail","pro_detail_gif='2' WHERE pro_detail_code='".$_POST["promo_product_fk"]."' ");
            // }

            $edit_now=$db->fn_edit("res_products_detail","pro_detail_promotion_price='".$promo_price."' WHERE pro_detail_code='".$_POST["promo_product_fk"]."' ");

            $sql="promo_store_fk='".$_POST["branch_store"]."',
            promo_branch_fk='".$_POST["branch_code"]."',
            promo_start_date='".$_POST["promo_start_date"]."',
            promo_start_time='".$start_time."',
            promo_end_date='".$_POST["promo_end_date"]."',
            promo_end_time='".$end_time."',
            promo_product_fk='".$_POST["promo_product_fk"]."',
            promo_qty='".$promo_qty."',
            promo_gif_qty='".$promo_gif_qty."',
            promo_qty_total='".$promo_qty_total."',
            promo_price='".$promo_price."'
            WHERE promo_id='".$_POST["promo_id"]."'";
            $edit=$db->fn_edit("res_promotion",$sql);

            if($edit){
                echo json_encode(array("statusCode" => 202));
            }else{
                echo json_encode(array("statusCode" => 204));
            }
        }else{
            
            $sql="'".$auto_number."','".$_POST["branch_store"]."','".$_POST["branch_code"]."','".$_POST["promo_start_date"]."','".$start_time."','".$_POST["promo_end_date"]."','".$end_time."','".$_POST["promo_product_fk"]."','".$promo_qty."','".$promo_gif_qty."','".$promo_qty_total."','1','".$promo_price."'";
           $insert=$db->fn_insert("res_promotion",$sql);
            if($insert){
                echo json_encode(array("statusCode" => 200));
            }else{
                echo json_encode(array("statusCode" => 204));
            }
        }
        
    }
    if(isset($_GET["delete_data"])){
        $edit=$db->fn_edit("res_products_detail","pro_detail_gif='1',pro_detail_promotion_price='0' WHERE pro_detail_code='".$_POST["proID"]."'  ");
        $delete=$db->fn_delete("res_promotion WHERE promo_id='".$_POST["field_id"]."' ");
        if($delete){
         echo json_encode(array("statusCode"=>200));
         }else{
         echo json_encode(array("statusCode"=>201));
        }
    }

    if(isset($_GET["editStatus"])){
        $editData=$db->fn_edit("res_promotion","promo_status='".$_POST["status"]."' WHERE promo_id='".$_POST["userID"]."'");
    }

?>