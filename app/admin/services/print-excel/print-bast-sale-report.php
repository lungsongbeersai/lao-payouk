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
    <title>ລາຍງານສິນຄ້າຂາຍດີ</title>
</head>
<body>
<?php
if ($_POST["start_date"] != "" && $_POST["end_date"] != "") {
    @$query .= " WHERE check_bill_list_date BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' ";
} else {
    @$query .= "";
}

if ($_POST["search_branch"] != "") {
    @$query .= "AND check_bill_list_branch_fk='" . $_POST["search_branch"] . "' ";
} else {
    @$query .= "";
}

if ($_POST["type_cate"] != "") {
    @$query .= " AND check_bill_list_status='" . $_POST["type_cate"] . "'";
} else {
    @$query .= "";
}


$sql = $db->fn_read_all("view_bast_sale $query GROUP BY check_bill_list_date,group_code,check_bill_list_branch_fk ORDER BY group_code ASC");
if (isset($_POST["print"])) {
?>
    <link href="style.css" rel="stylesheet" />
    <body onload="window.print()">
        <center>
            <h3>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</h3>
            <h3 style="margin-top: -20px;">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h3>
            <h4><u>ລາຍງານສິນຄ້າຂາຍດີ</u></h4>
        </center>
        <h4>ວັນທີ່ລາຍງານ : <?php echo date("d/m/Y", strtotime($_POST["start_date"])) ?> ຫາ <?php echo date("d/m/Y", strtotime($_POST["end_date"])) ?></h4>
        <table border="1" style="border-collapse: collapse;width:100%">
            <thead style="background:#0F253B;color:#eaeaea;font-size:16px !important;">
                <tr>
                    <td align="center">ວັນທີ່</td>
                    <td align="center">ປະເພດ</td>
                    <td align="center">ລໍາດັບ</td>
                    <td>ຊື່ອາຫານ ຫຼື ເຄື່ອງດຶ່ມ</td>
                    <td align="center">ລາຄາ</td>
                    <td align="center">ຈໍານວນ</td>
                    <td align="center">ຍອດລວມ</td>
                </tr>
            </thead>
            <tbody class="table-bordered-y">
                <?php
                $i = 1;
                if (count($sql) > 0) {
                    foreach ($sql as $rowSql) {
                        // @$total+=$rowSql["totalAll"];
                        $sqlGroup = $db->fn_read_all("view_bast_sale WHERE group_code='" . $rowSql["group_code"] . "' GROUP BY group_code ");
                        foreach ($sqlGroup as $rowGroup) {
                ?>
                            <tr>
                                <td align="center" style="border-bottom: 1px solid #dbdbdb !important;"><?php echo date("d/m/Y", strtotime($rowSql["check_bill_list_date"])) ?></td>
                                <td style="border-bottom: 1px solid #dbdbdb !important;" colspan="6"><b>- ປະເພດ<?php echo $rowGroup["group_name"] ?> </b></td>
                            </tr>

                            <?php
                            if ($_POST["orderBy"] == "1") {
                                $orderBy = "ORDER BY sumQty DESC";
                            } else {
                                $orderBy = "ORDER BY amounts DESC";
                            }
                            $j = 1;
                            $sqlBast = $db->fn_read_all("view_bast_sale WHERE group_code='" . $rowGroup["group_code"] . "' 
                    AND check_bill_list_date='" . $rowSql["check_bill_list_date"] . "' $orderBy");
                            foreach ($sqlBast as $rowBast) {
                                @$amount += $rowBast["amounts"];
                            ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td align="center"><?php echo $j++; ?></td>
                                    <td><?php echo $rowBast["fullProname"] ?></td>
                                    <td align="center"><?php echo @number_format($rowBast["check_bill_list_pro_price"]) ?></td>
                                    <td align="center"><?php echo @number_format($rowBast["sumQty"]) ?></td>
                                    <td align="center"><?php echo @number_format($rowBast["amounts"]) ?></td>
                                </tr>
                            <?php }
                            $subTotal = $db->fn_fetch_single_all("view_subtotal WHERE group_code='" . $rowGroup["group_code"] . "' 
                            AND check_bill_list_date='" . $rowSql["check_bill_list_date"] . "' $orderBy");
                            @$granQty += $subTotal["sumQty"];
                            @$grantotal += $subTotal["amounts"];
                            ?>

                            <tr style="border-top:1px solid #dbdbdb;background:#fcebe3;font-size:16px !important">
                                <td colspan="5" align="right">ລວມຍອດ</td>
                                <td align="center"><?php echo @number_format($subTotal["sumQty"]) ?></td>
                                <td align="center"><?php echo @number_format($subTotal["amounts"]) ?></td>
                            </tr>
                        <?php } ?>


                    <?php } ?>
                    <tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;">
                        <td colspan="5" align="right">ລວມທັງໝົດ</td>
                        <td align="center"><?php echo @number_format($granQty) ?></td>
                        <td align="center"><?php echo @number_format($grantotal) ?></td>
                    <tr>
                    <?php } else { ?>
                    <tr>
                        <td colspan="8" align="center" style="height:380px;padding:150px;color:red">
                            <i class="fas fa-times-circle fa-3x"></i><br>
                            ບໍ່ພົບລາຍການ
                        </td>
                    </tr>
            <?php }
            ?>
            </tbody>
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
            <h4><u>ລາຍງານສິນຄ້າຂາຍດີ</u></h4>
        </center>
        <h4>ວັນທີ່ລາຍງານ : <?php echo date("d/m/Y", strtotime($_POST["start_date"])) ?> ຫາ <?php echo date("d/m/Y", strtotime($_POST["end_date"])) ?></h4>
        <table border="1" style="border-collapse: collapse;width:100%">
            <thead style="background:#0F253B;color:#eaeaea;font-size:16px !important;">
                <tr>
                    <td align="center">ວັນທີ່</td>
                    <td align="center">ປະເພດ</td>
                    <td align="center">ລໍາດັບ</td>
                    <td>ຊື່ອາຫານ ຫຼື ເຄື່ອງດຶ່ມ</td>
                    <td align="center">ລາຄາ</td>
                    <td align="center">ຈໍານວນ</td>
                    <td align="center">ຍອດລວມ</td>
                </tr>
            </thead>
            <tbody class="table-bordered-y">
                <?php
                $i = 1;
                if (count($sql) > 0) {
                    foreach ($sql as $rowSql) {
                        // @$total+=$rowSql["totalAll"];
                        $sqlGroup = $db->fn_read_all("view_bast_sale WHERE group_code='" . $rowSql["group_code"] . "' GROUP BY group_code ");
                        foreach ($sqlGroup as $rowGroup) {
                ?>
                            <tr>
                                <td align="center" style="border-bottom: 1px solid #dbdbdb !important;"><?php echo date("d/m/Y", strtotime($rowSql["check_bill_list_date"])) ?></td>
                                <td style="border-bottom: 1px solid #dbdbdb !important;" colspan="6"><b>- ປະເພດ<?php echo $rowGroup["group_name"] ?> </b></td>
                            </tr>

                            <?php
                            if ($_POST["orderBy"] == "1") {
                                $orderBy = "ORDER BY sumQty DESC";
                            } else {
                                $orderBy = "ORDER BY amounts DESC";
                            }
                            $j = 1;
                            $sqlBast = $db->fn_read_all("view_bast_sale WHERE group_code='" . $rowGroup["group_code"] . "' 
                    AND check_bill_list_date='" . $rowSql["check_bill_list_date"] . "' $orderBy");
                            foreach ($sqlBast as $rowBast) {
                                @$amount += $rowBast["amounts"];
                            ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td align="center"><?php echo $j++; ?></td>
                                    <td><?php echo $rowBast["fullProname"] ?></td>
                                    <td align="center"><?php echo @number_format($rowBast["check_bill_list_pro_price"]) ?></td>
                                    <td align="center"><?php echo @number_format($rowBast["sumQty"]) ?></td>
                                    <td align="center"><?php echo @number_format($rowBast["amounts"]) ?></td>
                                </tr>
                            <?php }
                            $subTotal = $db->fn_fetch_single_all("view_subtotal WHERE group_code='" . $rowGroup["group_code"] . "' 
                            AND check_bill_list_date='" . $rowSql["check_bill_list_date"] . "' $orderBy");
                            @$granQty += $subTotal["sumQty"];
                            @$grantotal += $subTotal["amounts"];
                            ?>

                            <tr style="border-top:1px solid #dbdbdb;background:#fcebe3;font-size:16px !important">
                                <td colspan="5" align="right">ລວມຍອດ</td>
                                <td align="center"><?php echo @number_format($subTotal["sumQty"]) ?></td>
                                <td align="center"><?php echo @number_format($subTotal["amounts"]) ?></td>
                            </tr>
                        <?php } ?>


                    <?php } ?>
                    <tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;">
                        <td colspan="5" align="right">ລວມທັງໝົດ</td>
                        <td align="center"><?php echo @number_format($granQty) ?></td>
                        <td align="center"><?php echo @number_format($grantotal) ?></td>
                    <tr>
                    <?php } else { ?>
                    <tr>
                        <td colspan="8" align="center" style="height:380px;padding:150px;color:red">
                            <i class="fas fa-times-circle fa-3x"></i><br>
                            ບໍ່ພົບລາຍການ
                        </td>
                    </tr>
            <?php }
            ?>
            </tbody>
        </table>
    </body>
    <?php }?>
    </body>
</html>