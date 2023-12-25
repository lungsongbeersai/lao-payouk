<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if (isset($_POST["print"])) {

    $limit = $_POST["limit_page"];
    $page = 1;
    if (@$_POST['page'] > 1) {
        $start = (($_POST['page'] - 1) * $limit);
        $page = $_POST['page'];
    } else {
        $start = 0;
    }

    @$query .= "view_expenses_list";

    if ($_POST["start_date"] != "" && $_POST["end_date"] != "") {
        $query .= " WHERE exp_date BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' ";
    } else {
        $query .= "";
    }

    if ($_POST["search_page"] != "") {
        $query .= " AND exp_name LIKE '%" . $_POST["search_page"] . "%' ";
    } else {
        $query .= "";
    }

    if ($_POST["order_page"] != "") {
        $query .= " ORDER BY exp_date " . $_POST["order_page"] . " ";
    } else {
        $query .= "";
    }

    if ($_POST["limit_page"] != "") {
        $filter_query = $query . 'LIMIT ' . $start . ', ' . $limit . '';
    } else {
        $filter_query = $query;
    }

?>
    <html>
        <head>
            <title>ລາຍງານລາຍຈ່າຍ</title>
            <link href="style.css" rel="stylesheet" />
        </head>
    <body onload="window.print()">
    <center>
                <h3>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</h3>
                <h3 style="margin-top: -20px;">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h3>
                <h4><u>ລາຍງານລາຍຈ່າຍປະຈໍາວັນ</u></h4>
            </center>
            <h5>ວັນທີ່ລາຍງານ : <?php echo date("d/m/Y", strtotime($_POST["start_date"])) ?> ຫາ <?php echo date("d/m/Y", strtotime($_POST["end_date"])) ?></h5>
        <table border="1" style="border-collapse: collapse;width:100%">
            <thead>
                <tr style="font-weight: bold;font-size:16px !important">
                    <td width="5%" style="text-align:center !important;">ລໍາດັບ</td>
                    <td>ວັນທີ່ບັນທຶກ</td>
                    <td>ປະເພດ</td>
                    <td>ຊື່ລາຍການ</td>
                    <td>ຫົວໜ່ວຍ</td>
                    <td align="center">ລາຄາ</td>
                    <td align="center">ຈໍານວນ</td>
                    <td align="center">ເປັນເງິນ</td>
                </tr>
            </thead>
            <tbody>
                <?php

                $fetch_sql = $db->fn_read_all($filter_query);
                $total_data = $db->fn_fetch_rowcount($query);
                $total_id = $start + 1;
                $i = 1;
                if ($total_data > 0) {
                    foreach ($fetch_sql as $row_sql) {
                        @$total_qty+=$row_sql["exp_qty"];
                        @$total += $row_sql["exp_total"];
                ?>
                        <tr class="table_hover">
                            <td align="center"><?php echo $i++; ?></td>
                            <td><?php echo date("d/m/Y", strtotime($row_sql["exp_date"])); ?></td>
                            <td><?php echo $row_sql["exp_type_name"]; ?></td>
                            <td><?php echo $row_sql["exp_name"]; ?></td>
                            <td><?php echo $row_sql["exp_unite"]; ?></td>
                            <td align="center"><?php echo @number_format($row_sql["exp_price"]); ?></td>
                            <td align="center"><?php echo @number_format($row_sql["exp_qty"]); ?></td>
                            <td align="center"><?php echo @number_format($row_sql["exp_total"]); ?></td>
                        </tr>
                    <?php } ?>
                    <tr style="font-size:16px !important;font-weight:bold">
                        <td colspan="6" align="right">ລວມທັງໝົດ</td>
                        <td align="center"><?php echo number_format($total_qty); ?></td>
                        <td align="center"><?php echo number_format($total); ?></td>
                    <tr>
                    <?php } else { ?>
                    <tr>
                        <td colspan="8" align="center" style="height:380px;padding:150px;color:red">
                            <i class="fas fa-times-circle fa-3x"></i><br>
                            ບໍ່ພົບລາຍການ
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <table style="margin-top: 20px;float:right">
                <tr>
                    <td style="font-size: 14px;font-weight:bold"><u>ລາຍງານໂດຍ : </u> &nbsp;&nbsp;&nbsp;</td>
                </tr>
            </table>
    </body>
    </html>
<?php } ?>