<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    if(isset($_GET["insertAll"])){
        $auto_number=$db->fn_autonumber("exp_code","res_expenses_type");
        if($_POST["exp_code_edit"] !=""){
            $sql="exp_type_name='".$_POST["exp_type_name"]."' WHERE exp_code='".$_POST["exp_code_edit"]."'";
            $edit=$db->fn_edit("res_expenses_type",$sql);
            if($edit){
                echo json_encode(array("statusCode" => 202));
            }else{
                echo json_encode(array("statusCode" => 204));
            }
        }else{
            $sql="'".$auto_number."','".$_POST["exp_type_name"]."'";
            $insert=$db->fn_insert("res_expenses_type",$sql);
            if($insert){
                echo json_encode(array("statusCode" => 200));
            }else{
                echo json_encode(array("statusCode" => 204));
            }
        }
    }

    if(isset($_GET["DeleteTable"])){
        $delete=$db->fn_delete("res_expenses_type WHERE exp_code='".$_POST["dataID"]."' ");
    }

    if(isset($_GET["loadType"])){
        $sql=$db->fn_read_all("res_expenses_type ORDER BY exp_code DESC");
        if(count($sql)>0){
            $i=1;
        foreach($sql as $rowSql){
?>
    <tr>
        <td><?php echo $i++;?></td>
        <td><?php echo $rowSql["exp_type_name"]?></td>
        <td style="width:150px" align="center">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="typeEdit('<?php echo $rowSql['exp_code']?>','<?php echo $rowSql['exp_type_name']?>')">
                <i class="fas fa-pen"></i> ແກ້ໄຂ
            </button>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="typeDelete('<?php echo $rowSql['exp_code']?>')">
                <i class="fas fa-trash"></i> ລຶບ
            </button>
        </td>
    </tr>
    <?php } }else{?>
        <tr>
            <td colspan="5" align="center">
                <i class="fas fa-times-circle text-danger"></i><br>
                ບໍ່ພົບລາຍການ
            </td>
        </tr>
    <?php } }
    if(isset($_GET["insertList"])){
        $auto_number=$db->fn_autonumber("exp_id","res_expenses_list");
        $exp_price=filter_var($_POST["exp_price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $exp_qty=filter_var($_POST["exp_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $exp_total=filter_var($_POST["exp_total"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if($_POST["exp_id"] !=""){
            $sql="exp_date='".$_POST["exp_date"]."',
            exp_type_fk='".$_POST["exp_type_fk"]."',
            exp_name='".$_POST["exp_name"]."',
            exp_price='".$exp_price."',
            exp_qty='".$exp_qty."',
            exp_unite='".$_POST["exp_unite"]."',exp_total='".$exp_total."',
            exp_branch_fk='".$_POST["zone_branch_fk"]."' WHERE exp_id='".$_POST["exp_id"]."'";
            $edit=$db->fn_edit("res_expenses_list",$sql);
            if($edit){
                echo json_encode(array("statusCode" => 202));
            }else{
                echo json_encode(array("statusCode" => 204));
            }
        }else{
            $sql="'".$auto_number."','".$_POST["exp_date"]."',
            '".$_POST["exp_type_fk"]."','".$_POST["exp_name"]."',
            '".$exp_price."',
            '".$exp_qty."','".$_POST["exp_unite"]."','".$exp_total."','".$_POST["zone_branch_fk"]."'";
            $insert=$db->fn_insert("res_expenses_list",$sql);
            if($insert){
                echo json_encode(array("statusCode" => 200));
            }else{
                echo json_encode(array("statusCode" => 204));
            }
        }
    }

    if(isset($_GET["loadList1"])){
        
        $limit = $_POST["limit"];
        $page = 1;
        if (@$_POST['page'] > 1) {
            $start = (($_POST['page'] - 1) * $limit);
            $page = $_POST['page'];
        } else {
            $start = 0;
        }

        @$query.="view_expenses_list";

        if($_POST["start_date"] !="" && $_POST["end_date"] !=""){
            $query.=" WHERE exp_date BETWEEN '".$_POST["start_date"]."' AND '".$_POST["end_date"]."' ";
        }else{
            $query.="";
        }

        if($_POST["search_page"] !=""){
            $query.=" AND exp_name LIKE '%".$_POST["search_page"]."%' ";
        }else{
            $query.="";
        }

        if($_POST["search_branch"] !=""){
            $query.=" AND exp_branch_fk='".$_POST["search_branch"]."' ";
        }else{
            if($_SESSION["user_permission_fk"]=="202300000002"){
                $query.="";
            }else{
                $query.=" AND exp_branch_fk='".$_POST["search_branch"]."'";
            }
        }

        
        if($_POST["order_page"] !=""){
            $query.=" ORDER BY exp_date ".$_POST["order_page"]." ";
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
        $i=1;
        if ($total_data > 0) {
            foreach($fetch_sql as $row_sql){
                @$total_qty+=$row_sql["exp_qty"];
                @$total+=$row_sql["exp_total"];
    ?>
        <tr class="table_hover">
            <td align="center"><?php echo $i++;?></td>
            <td><?php echo $row_sql["branch_name"];?></td>
            <td><?php echo date("d/m/Y",strtotime($row_sql["exp_date"]));?></td>
            <td><?php echo $row_sql["exp_type_name"];?></td>
            <td><?php echo $row_sql["exp_name"];?></td>
            <td><?php echo $row_sql["exp_unite"];?></td>
            <td align="center"><?php echo @number_format($row_sql["exp_price"]);?></td>
            <td align="center"><?php echo @number_format($row_sql["exp_qty"]);?></td>
            <td align="center"><?php echo @number_format($row_sql["exp_total"]);?></td>
            <td align="center">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="edit_function('<?php echo $row_sql['exp_id']?>','<?php echo $row_sql['exp_date']?>','<?php echo $row_sql['exp_type_fk']?>','<?php echo $row_sql['exp_name']?>','<?php echo $row_sql['exp_price']?>','<?php echo $row_sql['exp_qty']?>','<?php echo $row_sql['exp_unite']?>','<?php echo $row_sql['exp_total']?>','<?php echo $row_sql['exp_branch_fk']?>')">
                    <i class="fas fa-pen"></i> ແກ້ໄຂ
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="delete_function('<?php echo $row_sql['exp_id'];?>')">
                    <i class="fas fa-trash"></i> ລຶບ
                </button>
            </td>
        </tr>
    <?php }?>
    <tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;">
            <td colspan="7" align="right">ລວມທັງໝົດ</td>
            <td align="center"><?php echo number_format($total_qty);?></td>
            <td align="center"><?php echo number_format($total);?></td>
            <td></td>
        <tr>
        <tr style="border-top:1px solid #DEE2E6">
            <td colspan="10">
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
                <td colspan="10" align="center" style="height:380px;padding:150px;color:red">
                    <i class="fas fa-times-circle fa-3x"></i><br>
                    ບໍ່ພົບລາຍການ
                </td>
            </tr>
    <?php } }
    if(isset($_GET["DeleteList"])){
        $delete=$db->fn_delete("res_expenses_list WHERE exp_id='".$_POST["dataID"]."' ");
        if ($delete) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    }
    ?>