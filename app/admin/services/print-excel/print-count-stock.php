<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ລາຍງານສະຕ໋ອກປະຈໍາວັນ</title>
</head>
<body>
    

<?php 
$limit = $_POST["limit_page"];
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
        $query .= "";
    }

    if ($_POST["search_page"] != "") {
        $query .= "AND product_name='" . $_POST["search_page"] . "' ";
    } else {
        $query .= "";
    }


    $orderBy = " GROUP BY branch_code ORDER BY branch_code " . $_POST['order_page'] . " ";

    $querySub = "ORDER BY pro_detail_code " . $_POST['order_page'] . " ";

    if ($_POST["limit_page"] != "") {
        $filter_query = $query . $orderBy . ' LIMIT ' . $start . ', ' . $limit . '';
    } else {
        $filter_query = $query . $orderBy;
    }

    $sqlreport = $db->fn_read_all($filter_query);
    $total_data = $db->fn_fetch_rowcount($query);
    $total_id = $start + 1;
if (isset($_POST["print"])) {
?>
    <link href="style.css" rel="stylesheet" />

    <body onload="window.print()">
        <center>
            <h3>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</h3>
            <h3 style="margin-top: -20px;">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h3>
            <h4><u>ລາຍງານສະຕ໋ອກປະຈໍາວັນ</u></h4>
        </center>
        <h4>ວັນທີ່ລາຍງານ : <?php echo date("d/m/Y", strtotime($_POST["start_date"])) ?> ຫາ <?php echo date("d/m/Y", strtotime($_POST["end_date"])) ?></h4>
        <table border="1" style="border-collapse: collapse;width:100%">
            <thead>
                <tr>
                    <td>ລໍາດັບ</td>
                    <td>ຊື່ຮ້ານ</td>
                    <td>ສາຂາ</td>
                    <td>ລະຫັດສິນຄ້າ</td>
                    <td>ຊື່ສິນຄ້າ</td>
                    <td align="center">ຮັບເຂົ້າ</td>
                    <td align="center">ຂາຍອອກ</td>
                    <td align="center">ຄົງເຫຼືອ</td>
                </tr>
            </thead>
            <?php
            if ($total_data > 0) {
                foreach ($sqlreport as $rowreport) {
            ?>
                    <tbody id="showDataAll" class="table-bordered-y table-sm">
                        <tr style="background:#e5e5e5">
                            <td><?php echo $total_id++; ?></td>
                            <td><?php echo $rowreport["store_name"] ?></td>
                            <td><?php echo $rowreport["branch_name"] ?></td>
                            <td colspan="5"></td>
                        </tr>
                        <?php
                        $sql_subquery = "view_product_list WHERE product_cut_stock='2' AND product_branch='" . $rowreport["product_branch"] . "' ";
                        $sqlSubQuery = $db->fn_read_all($sql_subquery);
                        foreach ($sqlSubQuery as $rowSub) {
                            $sqlReceive = $db->fn_fetch_single_field("item_order_fk,SUM(item_order_qty)AS sumQty", "view_receive_item_list 
                                WHERE order_status='2' AND item_order_fk='" . $rowSub["pro_detail_code"] . "' $r_start_date 
                                AND order_branch_fk='" . $rowreport["product_branch"] . "' GROUP BY item_order_fk 
                                ORDER BY receive_date ASC");
                            if (@$sqlReceive["item_order_fk"] == @$rowSub["pro_detail_code"]) {
                                @$sumReceive = $sqlReceive["sumQty"];
                            } else {
                                @$sumReceive = "0";
                            }

                            $sqlOrder = $db->fn_fetch_single_field("check_bill_list_pro_code_fk,SUM(check_bill_list_order_qty)AS qtyTotal", "
                                view_daily_report_list WHERE product_cut_stock='2' AND check_bill_list_pro_code_fk='" . $rowSub["pro_detail_code"] . "'  
                                $o_start_date AND check_bill_list_branch_fk='" . $rowreport["product_branch"] . "' GROUP BY check_bill_list_pro_code_fk ORDER BY check_bill_list_date ASC");
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
                    </tbody>
            <?php }
                    }
                } else { ?>
            <tr>
                <td colspan="8" align="center" style="height:380px;padding:150px;color:red">
                    <i class="fas fa-times-circle fa-3x"></i><br>
                    ບໍ່ພົບລາຍການ
                </td>
            </tr>
        <?php } ?>
        </table>
    </body>
<?php }
if (isset($_POST["excel"])) {
    date_default_timezone_set('Asia/Bangkok');
    header("Content-Type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="' . rand() . '.xls"');
    echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">';
?>
    <link href="style.css" rel="stylesheet" />
    <body>
        <center>
            <h3>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</h3>
            <h3 style="margin-top: -20px;">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h3>
            <h4><u>ລາຍງານສະຕ໋ອກປະຈໍາວັນ</u></h4>
        </center>
        <h4>ວັນທີ່ລາຍງານ : <?php echo date("d/m/Y", strtotime($_POST["start_date"])) ?> ຫາ <?php echo date("d/m/Y", strtotime($_POST["end_date"])) ?></h4>
        <table border="1" style="border-collapse: collapse;width:100%">
            <thead>
                <tr>
                    <td>ລໍາດັບ</td>
                    <td>ຊື່ຮ້ານ</td>
                    <td>ສາຂາ</td>
                    <td>ລະຫັດສິນຄ້າ</td>
                    <td>ຊື່ສິນຄ້າ</td>
                    <td align="center">ຮັບເຂົ້າ</td>
                    <td align="center">ຂາຍອອກ</td>
                    <td align="center">ຄົງເຫຼືອ</td>
                </tr>
            </thead>
            <?php
            if ($total_data > 0) {
                foreach ($sqlreport as $rowreport) {
            ?>
                    <tbody id="showDataAll" class="table-bordered-y table-sm">
                        <tr style="background:#e5e5e5">
                            <td><?php echo $total_id++; ?></td>
                            <td><?php echo $rowreport["store_name"] ?></td>
                            <td><?php echo $rowreport["branch_name"] ?></td>
                            <td colspan="5"></td>
                        </tr>
                        <?php
                        $sql_subquery = "view_product_list WHERE product_cut_stock='2' AND product_branch='" . $rowreport["product_branch"] . "' ";
                        $sqlSubQuery = $db->fn_read_all($sql_subquery);
                        foreach ($sqlSubQuery as $rowSub) {
                            $sqlReceive = $db->fn_fetch_single_field("item_order_fk,SUM(item_order_qty)AS sumQty", "view_receive_item_list 
                                WHERE order_status='2' AND item_order_fk='" . $rowSub["pro_detail_code"] . "' $r_start_date 
                                AND order_branch_fk='" . $rowreport["product_branch"] . "' GROUP BY item_order_fk 
                                ORDER BY receive_date ASC");
                            if (@$sqlReceive["item_order_fk"] == @$rowSub["pro_detail_code"]) {
                                @$sumReceive = $sqlReceive["sumQty"];
                            } else {
                                @$sumReceive = "0";
                            }

                            $sqlOrder = $db->fn_fetch_single_field("check_bill_list_pro_code_fk,SUM(check_bill_list_order_qty)AS qtyTotal", "
                                view_daily_report_list WHERE product_cut_stock='2' AND check_bill_list_pro_code_fk='" . $rowSub["pro_detail_code"] . "'  
                                $o_start_date AND check_bill_list_branch_fk='" . $rowreport["product_branch"] . "' GROUP BY check_bill_list_pro_code_fk ORDER BY check_bill_list_date ASC");
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
                    </tbody>
            <?php }
                    }
                } else { ?>
            <tr>
                <td colspan="8" align="center" style="height:380px;padding:150px;color:red">
                    <i class="fas fa-times-circle fa-3x"></i><br>
                    ບໍ່ພົບລາຍການ
                </td>
            </tr>
        <?php } ?>
        </table>
    </body>
<?php }?>
</body>
</html>