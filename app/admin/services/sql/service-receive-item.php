<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if (isset($_GET["loatItem"])) {

    $limit = $_POST["limit"];
    $page = 1;
    if (@$_POST['page'] > 1) {
        $start = (($_POST['page'] - 1) * $limit);
        $page = $_POST['page'];
    } else {
        $start = 0;
    }


    @$query .= " view_receive_item ";

    if (@$_POST["start_date"] != "" && @$_POST["end_date"] != "") {
        $query .= " WHERE receive_date BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' ";
    } else {
        $query .= "";
    }

    if ($_POST["search_store"] != "") {
        $query .= " AND order_store_fk='" . $_POST["search_store"] . "' ";
    } else {
        $query .= "";
    }

    if ($_POST["search_branch"] != "") {
        $query .= " AND order_branch_fk='" . $_POST["search_branch"] . "' ";
    } else {
        $query .= "";
    }

    $query .= " AND order_status='2' ";

    if ($_POST["search"] != "") {
        $sqlCheck = $db->fn_fetch_rowcount("view_receive_item WHERE order_code LIKE '%" . $_POST["search"] . "%' ");
        if ($sqlCheck > 0) {
            $query .= " AND order_code LIKE '%" . $_POST["search"] . "%'";
        } else {
            $sqlCheck1 = $db->fn_fetch_rowcount("view_receive_item WHERE branch_name LIKE '%" . $_POST["search"] . "%' ");
            if ($sqlCheck1 > 0) {
                $query .= " AND branch_name LIKE '%" . $_POST["search"] . "%'";
            } else {
                $query .= "AND branch_name='dddcxvderfs234' ";
            }
        }
    } else {
        $query .= "";
    }

    if ($_POST["orderby"] != "") {
        $query .= " ORDER BY order_code " . $_POST["orderby"] . " ";
    } else {
        $query .= "";
    }


    if ($_POST["limit"] != "") {
        $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit . '';
    } else {
        $filter_query = $query;
    }


    if ($_POST["lookBill"] == "1") {
?>
        <table class="table text-nowrap">
            <thead>
                <tr>
                    <td width="5%" style="text-align:center !important;">ລໍາດັບ</td>
                    <td>ສະຖານະ</td>
                    <td>ປະເພດສາຂາ</td>
                    <td>ຊື່ຮ້ານ</td>
                    <td>ຊື່ສາຂາ</td>
                    <td>ເລກທີ່ສັ່ງຊື້</td>
                    <td>ວັນທີ່ສັ່ງຊື້</td>
                    <td>ວັນທີ່ຮັບເຂົ້າ</td>
                    <td>ລວມຈໍານວນ</td>
                    <td>ລວມເປັນເງິນ</td>
                    <td width="10%" style="text-align:center !important;">ຈັດການ</td>
                </tr>
            </thead>
            <tbody class="table-bordered-y table-sm display">
                <?php
                $fetch_sql = $db->fn_read_all($filter_query);
                $total_data = $db->fn_fetch_rowcount($query);
                $total_id = $start + 1;
                if ($total_data > 0) {
                    foreach ($fetch_sql as $row_sql) {
                        @$totalQty = $row_sql["order_total_qty"];
                        @$totalPrice = $row_sql["order_total_price"];
                        if (@$row_sql["order_status"] == "1") {
                            $color="text-danger";
                            $togle_check="";
                        } else {
                            $color="";
                            $togle_check="checked";
                        }
                ?>
                        <tr class="table_hover <?php echo $color;?>">
                            <td align="center"><?php echo @$total_id++; ?></td>
                            <td style="width:40px">
                                <center>
                                    <div class="form-check form-switch ms-auto">
                                        <input type="checkbox" class="form-check-input" id="pro_detail_open" name="pro_detail_open" <?php echo @$togle_check;?>>
                                        <label class="form-check-label" for="pro_detail_open">&nbsp;</label>
                                    </div>
                                </center>
                            </td>
                            <td>
                                <?php if (@$row_sql["branch_status"] == "1") {
                                    echo "ສາຂາຫຼັກ";
                                } else {
                                    echo "ສາຂາຍ່ອຍ";
                                } ?>
                            </td>
                            <td><?php echo $row_sql["store_name"] ?></td>
                            <td><?php echo $row_sql["branch_name"] ?></td>
                            <td><?php echo $row_sql["order_code"] ?></td>
                            <td><?php echo date("d/m/Y",strtotime($row_sql["order_date"])) ?></td>
                            <td><?php echo date("d/m/Y",strtotime($row_sql["receive_date"])) ?></td>
                            <td align="center"><?php echo @number_format($row_sql["order_total_qty"]) ?></td>
                            <td align="center"><?php echo @number_format($row_sql["order_total_price"]) ?></td>
                            
                            <td align="center">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="fnCancelData('<?php echo $row_sql['receive_code'];?>','<?php echo $row_sql['receive_item_fk'];?>')">
                                    <i class="fas fa-trash"></i> ຍົກເລີກ
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;">
                        <td colspan="8" align="right">ລວມທັງໝົດ</td>
                        <td align="center"><?php echo @number_format($totalQty); ?></td>
                        <td align="center"><?php echo @number_format($totalPrice); ?></td>
                        <td></td>
                    </tr>
                    <tr style="border-top:1px solid #DEE2E6">
                        <td colspan="11">
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
                <?php } else { ?>
                    <tr>
                        <td colspan="11" align="center" style="height:380px;padding:150px;color:red">
                            <i class="fas fa-times-circle fa-3x"></i><br>
                            ບໍ່ພົບລາຍການ
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <table class="table text-nowrap">
            <thead>
                <tr>
                    <td width="5%" style="text-align:center !important;">ລໍາດັບ</td>
                    <td>ປະເພດຮ້ານ</td>
                    <td>ຊື່ຮ້ານ</td>
                    <td>ຊື່ສາຂາ</td>
                    <td>ເລກທີ່ສັ່ງຊື້</td>
                    <td>ວັນທີ່ສັ່ງຊື້</td>
                    <td>ວັນທີ່ຮັບເຂົ້າ</td>
                    <td>ຊື່ສິນຄ້າ</td>
                    <td align="center">ລາຄາ</td>
                    <td align="center">ຈໍານວນ</td>
                    <td align="center">ເປັນເງິນ</td>
                </tr>
            </thead>
            <tbody class="table-sm display" style="border: 1px solid #FFFFFF;">
                <?php
                $fetch_sql = $db->fn_read_all($filter_query);
                $total_data = $db->fn_fetch_rowcount($query);
                $total_id = $start + 1;
                if ($total_data > 0) {
                    foreach ($fetch_sql as $row_sql) {
                        @$totalQty+= $row_sql["order_total_qty"];
                        @$totalPrice+= $row_sql["order_total_price"];
                ?>
                        <tr>
                            <td align="center"><?php echo @$total_id++; ?></td>
                            <td><?php if (@$row_sql["branch_status"] == "1") {
                                    echo "ສາຂາຫຼັກ"; 
                                } else {
                                    echo "ສາຂາຍ່ອຍ";
                                } ?>
                            </td>
                            <td><?php echo $row_sql["store_name"] ?></td>
                            <td><?php echo $row_sql["branch_name"] ?></td>
                            <td><?php echo $row_sql["order_code"] ?></td>
                            <td><?php echo date("d/m/Y",strtotime($row_sql["order_date"])) ?></td>
                            <td><?php echo date("d/m/Y",strtotime($row_sql["receive_date"])) ?></td>
                            <td align="center" colspan="4"></td>
                        </tr>
                        <?php 
                            $sqlDetail=$db->fn_read_all("view_receive_item_list  WHERE item_order_bill='".$row_sql["order_code"]."' ");
                            foreach($sqlDetail as $rowDetail){
                        ?>
                            <tr>
                                <td colspan="7"></td>
                                <td>- <?php echo @($rowDetail["product_name"])?> ( <?php echo @($rowDetail["size_name_la"])?> )</td>
                                <td align="center"><?php echo @number_format($rowDetail["item_order_price"])?></td>
                                <td align="center"><?php echo @number_format($rowDetail["item_order_qty"])?></td>
                                <td align="center"><?php echo @number_format($rowDetail["item_order_total"])?></td>
                            </tr>
                        <?php }?>
                            <tr style="background:#e5e5e5;color:#0F253B;font-size:16px !important;">
                                <td colspan="9" align="right">ລວມຍອດ</td>
                                <td align="center"><?php echo @number_format($row_sql["order_total_qty"]); ?></td>
                                <td align="center"><?php echo @number_format($row_sql["order_total_price"]); ?></td>
                            </tr>
                    <?php } ?>
                    <tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;">
                        <td colspan="9" align="right">ລວມທັງໝົດ</td>
                        <td align="center"><?php echo @number_format($totalQty); ?></td>
                        <td align="center"><?php echo @number_format($totalPrice); ?></td>
                    </tr>
                    <tr style="border-top:1px solid #DEE2E6">
                        <td colspan="11">
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
                <?php } else { ?>
                    <tr>
                        <td colspan="11" align="center" style="height:380px;padding:150px;color:red">
                            <i class="fas fa-times-circle fa-3x"></i><br>
                            ບໍ່ພົບລາຍການ
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    <?php }
    if(isset($_GET["fetchData"])){
        $sql_data=$db->fn_read_all("view_order_item_list WHERE item_order_bill='".$_POST["BillID"]."' AND order_status='1' ");
        if(count($sql_data)>0){
            foreach($sql_data as $row_join){
                $data[] = $row_join;
            }
            echo json_encode($data);
        }else{
            $sql_data1=$db->fn_read_all("view_order_item_list WHERE item_order_bill='".$_POST["BillID"]."' AND order_status='2' ");
            if(count($sql_data1)>0){
                echo json_encode("201");
            }else{
                echo json_encode("202");
            }
            
        }
    }

    if(isset($_GET["confirmData"])){
        $auto_number=$db->fn_autonumber("receive_code","res_receives");

        $sql="'".$auto_number."','".DATE("Y-m-d")."','".$_POST["searchInvoice"]."','".$_SESSION["users_id"]."'";
        $insert=$db->fn_insert("res_receives",$sql);

        $sqlDetail=$db->fn_read_all("res_orders_item_list WHERE item_order_bill='".$_POST["searchInvoice"]."' ");
        foreach($sqlDetail as $rowDetail){
            $editAll=$db->fn_edit("res_products_detail","pro_detail_qty=pro_detail_qty+'".$rowDetail["item_order_qty"]."',pro_detail_open='2' WHERE pro_detail_code='".$rowDetail["item_order_fk"]."' ");
        }

        $sqlTile=$db->fn_edit("res_orders_item","order_status='2' WHERE order_code='".$_POST["searchInvoice"]."' ");
        if($sqlTile){
            echo json_encode(array("statusCode" => 200));
        }else{
            echo json_encode(array("statusCode" => 204));
        }
    }

    if(isset($_GET["deleteOrder"])){
        $sqlTile=$db->fn_edit("res_orders_item","order_status='1' WHERE order_code='".$_POST["orderBill"]."' ");
        $sqlDetail=$db->fn_read_all("res_orders_item_list WHERE item_order_bill='".$_POST["orderBill"]."' ");
        foreach($sqlDetail as $rowDetail){
            $editAll=$db->fn_edit("res_products_detail","pro_detail_qty=pro_detail_qty-'".$rowDetail["item_order_qty"]."' WHERE pro_detail_code='".$rowDetail["item_order_fk"]."' ");
        }
        
        $delete = $db->fn_delete("res_receives WHERE receive_code='" . $_POST["receiveID"] . "' ");
        

    }

    ?>