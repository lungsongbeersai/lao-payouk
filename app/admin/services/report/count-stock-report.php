<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if (isset($_GET["report"])) {
    $limit = $_POST["limit"];
    $page = 1;
    if (@$_POST['page'] > 1) {
        $start = (($_POST['page'] - 1) * $limit);
        $page = $_POST['page'];
    } else {
        $start = 0;
    }
    $i = 1;
    @$query .= "view_product_list WHERE product_cut_stock='2' ";

    if ($_POST["start_date"] != "" && $_POST["end_date"] != "") {
        $r_start_date = "AND receive_date BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' ";
        $o_start_date = "AND check_bill_list_date BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' ";
    } else {
        $r_start_date = "";
        $o_start_date = "";
    }


    if ($_POST["search_store"] != "") {
        $query .= "AND store_id='" . $_POST["search_store"] . "' ";
    } else {
        $query .= "";
    }

    if ($_POST["search_branch"] != "") {
        $query .= "AND product_branch='" . $_POST["search_branch"] . "' ";
    } else {
        if($_SESSION["user_permission_fk"]=="202300000002"){
            $query.="";
        }else{
            $query.="AND product_branch='".$_SESSION["user_branch"]."'";
        }
    }

    if ($_POST["search_page"] != "") {
        $query .= "AND product_name='" . $_POST["search_page"] . "' ";
    } else {
        $query .= "";
    }


    $orderBy = " GROUP BY branch_code ORDER BY branch_code " . $_POST['order_page'] . " ";

    $querySub = "ORDER BY pro_detail_code " . $_POST['order_page'] . " ";

    if ($_POST["limit"] != "") {
        $filter_query = $query . $orderBy . ' LIMIT ' . $start . ', ' . $limit . '';
    } else {
        $filter_query = $query . $orderBy;
    }

    $sqlreport = $db->fn_read_all($filter_query);
    $total_data = $db->fn_fetch_rowcount($query);
    $total_id = $start + 1;
    if ($total_data > 0) {
        foreach ($sqlreport as $rowreport) {
?>
            <tr style="background:#e5e5e5">
                <td><?php echo $total_id++; ?></td>
                <td><?php echo $rowreport["store_name"] ?></td>
                <td><?php echo $rowreport["branch_name"] ?></td>
                <td colspan="6"></td>
            </tr>
            <?php
            $sql_subquery="view_product_list WHERE product_cut_stock='2' AND product_branch='".$rowreport["product_branch"] ."' ";
            $sqlSubQuery = $db->fn_read_all($sql_subquery);
            foreach ($sqlSubQuery as $rowSub) {
                $sqlReceive = $db->fn_fetch_single_field("item_order_fk,SUM(item_order_qty)AS sumQty","view_receive_item_list 
                WHERE order_status='2' AND item_order_fk='" . $rowSub["pro_detail_code"] . "' $r_start_date 
                AND order_branch_fk='".$rowreport["product_branch"]."' GROUP BY item_order_fk 
                ORDER BY receive_date ASC");
                if (@$sqlReceive["item_order_fk"] == @$rowSub["pro_detail_code"]) {
                    @$sumReceive = $sqlReceive["sumQty"];
                } else {
                    @$sumReceive = "0";
                }

                $sqlOrder = $db->fn_fetch_single_field("check_bill_list_pro_code_fk,SUM(check_bill_list_order_qty)AS qtyTotal", "
                view_daily_report_list WHERE product_cut_stock='2' AND check_bill_list_pro_code_fk='" . $rowSub["pro_detail_code"] . "'  
                $o_start_date AND check_bill_list_branch_fk='".$rowreport["product_branch"]."' GROUP BY check_bill_list_pro_code_fk ORDER BY check_bill_list_date ASC");
                if (@$sqlOrder["check_bill_list_pro_code_fk"] == @$rowSub["pro_detail_code"]) {
                    @$sumOrder = $sqlOrder["qtyTotal"];
                } else {
                    @$sumOrder = "0";
                }
            ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $rowSub["pro_detail_code"] ?></td>
                    <td>- <?php echo $rowSub["product_name"] ?> ( <?php echo $rowSub["size_name_la"] ?> )</td>
                    <td align="center">
                        <?php echo @number_format($sumReceive) ?>
                    </td>
                    <td align="center">
                        <?php echo @number_format($sumOrder) ?>
                    </td>
                    <td align="center"><?php echo number_format($rowSub["pro_detail_qty"]) ?></td>

                </tr>
        <?php }
        } ?>
        <tr style="border-top:1px solid #DEE2E6">
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
    <?php } else { ?>
        <tr>
            <td colspan="8" align="center" style="height:380px;padding:150px;color:red">
                <i class="fas fa-times-circle fa-3x"></i><br>
                ບໍ່ພົບລາຍການ
            </td>
        </tr>
    <?php } ?>
<?php } ?>