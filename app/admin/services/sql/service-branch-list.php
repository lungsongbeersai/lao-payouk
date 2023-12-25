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
        if($_SESSION["user_permission_fk"]=="202300000001"){

        }else{

        }

        @$query.="res_branch AS A LEFT JOIN res_store AS B ON A.branch_com_fk=B.store_id";

        if($_POST["search"] !=""){
            $query.=" AND branch_name LIKE '%".$_POST["search"]."%' OR branch_code LIKE '%".$_POST["search"]."%'  ";
        }else{
            $query.="";
        }
        
        if($_POST["orderby"] !=""){
            $query.=" ORDER BY branch_code ".$_POST["orderby"]." ";
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
?>
            <tr class="table_hover" ondblclick="edit_function('<?php echo $row_sql['branch_code'];?>','<?php echo $row_sql['branch_name'];?>','<?php echo $row_sql['branch_tel'];?>','<?php echo $row_sql['branch_email'];?>','<?php echo $row_sql['branch_address'];?>','<?php echo $row_sql['branch_com_fk'];?>','<?php echo $row_sql['branch_status'];?>','<?php echo $row_sql['branch_qrcode'];?>')">
                <td align="center"><?php echo $total_id++;?></td>
                <td><?php if($row_sql["branch_status"]=="1"){echo "ສາຂາຫຼັກ";}else{echo "ສາຂາຍ່ອຍ";}?></td>
                <td><?php echo $row_sql["store_name"]?></td>
                <td><?php echo $row_sql["branch_name"]?></td>
                <td><?php echo $row_sql["branch_tel"]?></td>
                <td><?php echo $row_sql["branch_email"]?></td>
                <td><?php echo $row_sql["branch_address"]?></td>
                <td align="center">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="edit_function('<?php echo $row_sql['branch_code'];?>','<?php echo $row_sql['branch_name'];?>','<?php echo $row_sql['branch_tel'];?>','<?php echo $row_sql['branch_email'];?>','<?php echo $row_sql['branch_address'];?>','<?php echo $row_sql['branch_com_fk'];?>','<?php echo $row_sql['branch_status'];?>','<?php echo $row_sql['branch_qrcode'];?>')">
                        <i class="fas fa-pen"></i> ແກ້ໄຂ
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="delete_data('<?php echo $row_sql['branch_code'];?>','service-branch-list.php?delete','','','','','service-branch-list.php?fetch_data','display')">
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
        $auto_number=$db->fn_autonumber("branch_code","res_branch");
        if($_POST["branch_code"] !=""){
            if($_FILES['store_img']['name'] !=""){
                $file = '../../../../api/images/qr/'.$_POST["store_img_file"];
                @unlink($file);
                $fileinfo=PATHINFO($_FILES['store_img']['name']);
                $newfilename=rand()."_".$_POST["branch_code"]."_".time().".".$fileinfo['extension'];
                $location="../../../../api/images/qr/".$newfilename;
                $path=$newfilename;
                move_uploaded_file($_FILES['store_img']['tmp_name'],$location);

                $sql="branch_name='".$_POST["branch_name"]."',
                branch_tel='".$_POST["branch_tel"]."',
                branch_email='".$_POST["branch_email"]."',
                branch_address='".$_POST["branch_address"]."',
                branch_com_fk='".$_POST["branch_com_fk"]."',
                branch_status='".$_POST["branch_status"]."',branch_qrcode='".$path."' WHERE branch_code='".$_POST["branch_code"]."'";
                $edit=$db->fn_edit("res_branch",$sql);
                if($edit){
                    echo json_encode(array("statusCode" => 202));
                }else{
                    echo json_encode(array("statusCode" => 204));
                }
            }else{
                $sql="branch_name='".$_POST["branch_name"]."',
                branch_tel='".$_POST["branch_tel"]."',
                branch_email='".$_POST["branch_email"]."',
                branch_address='".$_POST["branch_address"]."',
                branch_com_fk='".$_POST["branch_com_fk"]."',
                branch_status='".$_POST["branch_status"]."' WHERE branch_code='".$_POST["branch_code"]."'";
                $edit=$db->fn_edit("res_branch",$sql);
                if($edit){
                    echo json_encode(array("statusCode" => 202));
                }else{
                    echo json_encode(array("statusCode" => 204));
                }
            }

        }else{

            if($_FILES['store_img']['name'] !=""){
                $fileinfo=PATHINFO($_FILES['store_img']['name']);
                $newfilename=rand()."_".$auto_number."_".time().".".$fileinfo['extension'];
                $location="../../../../api/images/qr/".$newfilename;
                $path=$newfilename;
                move_uploaded_file($_FILES['store_img']['tmp_name'],$location);
            }else{
                $path="";
            }

            $sql="'".$auto_number."',
            '".$_POST["branch_name"]."',
            '".$_POST["branch_tel"]."',
            '".$_POST["branch_email"]."',
            '".$_POST["branch_address"]."',
            '".$_POST["branch_com_fk"]."','".$_POST["branch_status"]."','".$path."'";
            $insert=$db->fn_insert("res_branch",$sql);
            if($insert){
                echo json_encode(array("statusCode" => 200));
            }else{
                echo json_encode(array("statusCode" => 204));
            }
        }
    }
    if(isset($_GET["delete"])){
        $delete=$db->fn_delete("res_branch WHERE branch_code='".$_POST["field_id"]."' ");
        if($delete){
         echo json_encode(array("statusCode"=>200));
         }else{
         echo json_encode(array("statusCode"=>201));
        }
    }
?>