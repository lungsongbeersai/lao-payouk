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

        @$query.="view_users ";

        if($_SESSION["user_permission_fk"]=="202300000001"){
            
            if($_POST["search"] !=""){
                $check=$db->fn_fetch_rowcount("view_users WHERE store_name LIKE '%".$_POST["search"]."%'");
                if($check>0){
                    $query.="WHERE store_name LIKE '%".$_POST["search"]."%'";
                }else{
                    $check1=$db->fn_fetch_rowcount("view_users WHERE branch_name LIKE '%".$_POST["search"]."%'");
                    if($check1>0){
                        $query.="WHERE branch_name LIKE '%".$_POST["search"]."%'";
                    }else{
                        $check2=$db->fn_fetch_rowcount("view_users WHERE users_name LIKE '%".$_POST["search"]."%'");
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
                $query.=" ORDER BY users_id ".$_POST["orderby"]." ";
            }else{
                $query.="";
            }
    
            if ($_POST["limit"] != "") {
                $filter_query = $query . 'LIMIT '.$start.', '.$limit.'';
            } else {
                $filter_query = $query;
            }

        }else{
            $query.=" WHERE store_id='".$_SESSION["user_store_fk"]."' ";

            if($_POST["search"] !=""){
                $check=$db->fn_fetch_rowcount("view_users WHERE store_name LIKE '%".$_POST["search"]."%'");
                if($check>0){
                    $query.="AND store_name LIKE '%".$_POST["search"]."%'";
                }else{
                    $check1=$db->fn_fetch_rowcount("view_users WHERE branch_name LIKE '%".$_POST["search"]."%'");
                    if($check1>0){
                        $query.="AND branch_name LIKE '%".$_POST["search"]."%'";
                    }else{
                        $check2=$db->fn_fetch_rowcount("view_users WHERE users_name LIKE '%".$_POST["search"]."%'");
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
                $query.=" ORDER BY users_id ".$_POST["orderby"]." ";
            }else{
                $query.="";
            }
    
            if ($_POST["limit"] != "") {
                $filter_query = $query . 'LIMIT '.$start.', '.$limit.'';
            } else {
                $filter_query = $query;
            }

        }


        if($_POST["search_store"] !=""){
            $store="";
        }else{
            $store="";
        }

        

        $fetch_sql=$db->fn_read_all($filter_query);
        $total_data = $db->fn_fetch_rowcount($query);
        $total_id = $start + 1;
        if ($total_data > 0) {
        foreach($fetch_sql as $row_sql){
            if($row_sql["user_status_check_login"]=="on"){
                $colors="";
                $togle_check="checked";
            }else{
                $colors="text-danger";
                $togle_check="";
            }
?>
            <tr class="table_hover <?php echo $colors;?>">
                <td>
                    <center>
                        <div class="form-check form-switch ms-auto">
                            <input type="checkbox" class="form-check-input" id="pro_detail_open" name="pro_detail_open" <?php echo @$togle_check;?> onchange="fn_togle_switch('<?php echo $row_sql['users_id'];?>','<?php echo $row_sql['user_status_check_login'];?>')">
                            <label class="form-check-label" for="pro_detail_open">&nbsp;</label>
                        </div>
                    </center>
                </td>
                <td align="center"><?php echo $total_id++;?></td>
                <td><?php echo $row_sql["store_name"]?></td>
                <td><?php echo $row_sql["branch_name"]?></td>
                <td><?php echo $row_sql["users_name"]?></td>
                <td>
                    <div class="input-group">
                        <input type="password" id="users_password<?php echo $row_sql['users_id']?>" name="users_password" value="<?php echo $row_sql['users_password']?>" class="form-control form-control-sm users_password" style="border:none;outline: none !important;width:40px">
                        <button type="button" class="btn btn-xs btn-primary search" onclick="function_showpassword('<?php echo $row_sql['users_id']?>')">
                            <i class='fas fa-eye-slash'></i>
                        </button>
                    </div>
                </td>
                <td><?php echo $row_sql["status_name"]?></td>
                <td align="center">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="edit_function('<?php echo $row_sql['users_id'];?>','<?php echo $row_sql['user_store_fk'];?>','<?php echo $row_sql['user_branch_fk'];?>','<?php echo $row_sql['user_permission_fk'];?>','<?php echo $row_sql['users_name'];?>','<?php echo $row_sql['users_password'];?>')">
                        <i class="fas fa-pen"></i> ແກ້ໄຂ
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="delete_user('<?php echo $row_sql['users_id'];?>')">
                        <i class="fas fa-trash"></i> ລຶບ
                    </button>
                </td>
            </tr>
        <?php }?>
        <tr style="border-top:1px solid #DEE2E6">
            <td colspan="8">
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
                <td colspan="8" align="center" style="height:380px;padding:150px;color:red">
                    <i class="fas fa-times-circle fa-3x"></i><br>
                    ບໍ່ພົບລາຍການ
                </td>
            </tr>
        <?php }?>
<?php }
    if(isset($_GET["insert_data"])){
        $auto_number=$db->fn_autonumber("users_id","res_users");
        if($_POST["users_id"] !=""){
            if($_POST["users_checkPassword"]==$_POST["users_password"]){
                $sql="user_store_fk='".$_POST["branch_store"]."',user_branch_fk='".$_POST["branch_code"]."',user_permission_fk='".$_POST["user_permission_fk"]."',users_name='".$_POST["users_name"]."' WHERE users_id='".$_POST["users_id"]."'";
                $edit=$db->fn_edit("res_users",$sql);
                if($edit){
                    echo json_encode(array("statusCode" => 202));
                }else{
                    echo json_encode(array("statusCode" => 204));
                }
            }else{
                $sqlCheckPassword=$db->fn_fetch_rowcount("res_users WHERE users_password='".$_POST["users_password"]."' ");
                if($sqlCheckPassword>0){
                    echo json_encode(array("statusCode" => 205));
                }else{
                    $sql="user_store_fk='".$_POST["branch_store"]."',user_branch_fk='".$_POST["branch_code"]."',user_permission_fk='".$_POST["user_permission_fk"]."',users_name='".$_POST["users_name"]."',users_password='".$_POST["users_password"]."' WHERE users_id='".$_POST["users_id"]."'";
                    $edit=$db->fn_edit("res_users",$sql);
                    if($edit){
                        echo json_encode(array("statusCode" => 202));
                    }else{
                        echo json_encode(array("statusCode" => 204));
                    }
                }
            }
        }else{
            $sqlCheckPassword=$db->fn_fetch_rowcount("res_users WHERE users_password='".$_POST["users_password"]."' ");
            if($sqlCheckPassword>0){
                echo json_encode(array("statusCode" => 205));
            }else{
                $sql="'".$auto_number."','".$_POST["branch_store"]."','".$_POST["branch_code"]."','".$_POST["user_permission_fk"]."','".$_POST["users_name"]."','".$_POST["users_password"]."','on'";
                $insert=$db->fn_insert("res_users",$sql);
                if($insert){
                    echo json_encode(array("statusCode" => 200));
                }else{
                    echo json_encode(array("statusCode" => 204));
                }
            }
        }
        
    }
    if(isset($_GET["delete_data"])){
        $delete=$db->fn_delete("res_users WHERE users_id='".$_POST["field_id"]."' ");
        if($delete){
         echo json_encode(array("statusCode"=>200));
         }else{
         echo json_encode(array("statusCode"=>201));
        }
    }

    if(isset($_GET["editStatus"])){
        $editData=$db->fn_edit("res_users","user_status_check_login='".$_POST["status"]."' WHERE users_id='".$_POST["userID"]."'");
    }

?>