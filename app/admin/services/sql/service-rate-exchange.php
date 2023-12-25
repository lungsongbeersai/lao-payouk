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

        @$query.="res_exchange ";

        if($_POST["search"] !=""){
            $query.=" WHERE ex_bath_kip LIKE '%".$_POST["search"]."%' OR ex_auto LIKE '%".$_POST["search"]."%'  ";
        }else{
            $query.="";
        }
        
        if($_POST["orderby"] !=""){
            $query.=" ORDER BY ex_auto ".$_POST["orderby"]." ";
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
            <tr class="table_hover" ondblclick="edit_function('<?php echo $row_sql['ex_auto'];?>','<?php echo $row_sql['ex_bath_kip'];?>','<?php echo $row_sql['ex_dolar_kip'];?>')">
                <td align="center"><?php echo $total_id++;?></td>
                <td><?php echo @number_format($row_sql["ex_bath_kip"])?></td>
                <td><?php echo @number_format($row_sql["ex_dolar_kip"])?></td>
                <td align="center">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="edit_function('<?php echo $row_sql['ex_auto'];?>','<?php echo $row_sql['ex_bath_kip'];?>','<?php echo $row_sql['ex_dolar_kip'];?>')">
                        <i class="fas fa-pen"></i> ແກ້ໄຂ
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="delete_data('<?php echo $row_sql['ex_auto'];?>','service-rate-exchange.php?delete','','','','','service-rate-exchange.php?fetch_data','display')">
                        <i class="fas fa-trash"></i> ລຶບ
                    </button>
                </td>
            </tr>
        <?php }?>
        <tr style="border-top:1px solid #DEE2E6">
            <td colspan="4">
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
                <td colspan="4" align="center" style="height:380px;padding:150px;color:red">
                    <i class="fas fa-times-circle fa-3x"></i><br>
                    ບໍ່ພົບລາຍການ
                </td>
            </tr>
        <?php }?>
<?php }
    if(isset($_GET["insert_data"])){
        $auto_number=$db->fn_autonumber("ex_auto","res_exchange");
        if($_POST["ex_auto"] !=""){
            $kip=filter_var($_POST["ex_bath_kip"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $dolar=filter_var($_POST["ex_dolar_kip"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $sql="ex_bath_kip='".$kip."',ex_dolar_kip='".$dolar."' WHERE ex_auto='".$_POST["ex_auto"]."'";
            $edit=$db->fn_edit("res_exchange",$sql);
            if($edit){
                echo json_encode(array("statusCode" => 202));
            }else{
                echo json_encode(array("statusCode" => 204));
            }
        }else{
            $kip=filter_var($_POST["ex_bath_kip"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $dolar=filter_var($_POST["ex_dolar_kip"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $sql="'".$auto_number."','".$kip."','".$dolar."'";
            $insert=$db->fn_insert("res_exchange",$sql);
            if($insert){
                echo json_encode(array("statusCode" => 200));
            }else{
                echo json_encode(array("statusCode" => 204));
            }
        }
    }
    if(isset($_GET["delete"])){
        $delete=$db->fn_delete("res_exchange WHERE ex_auto='".$_POST["field_id"]."' ");
        if($delete){
         echo json_encode(array("statusCode"=>200));
         }else{
         echo json_encode(array("statusCode"=>201));
        }
    }
?>