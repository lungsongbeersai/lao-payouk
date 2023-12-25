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
    <title>ລາຍງານປະຈໍາວັນເດືອນ <?php echo date("m/Y", strtotime(DATE("Y-m-d"))) ?></title>
    <style>
        @media print{
            @page {
                size: landscape;
                margin: 0;
            }
            body { margin: 1.5cm; }
        }
    </style>
</head>
<body>
<?php
$sql = $db->fn_read_all("view_daily_report_month WHERE list_bill_date BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' AND list_bill_branch_fk='".$_SESSION["user_branch"]."'");
if (isset($_POST["print"])) {
?>
    <link href="style.css" rel="stylesheet" />

    <body onload="window.print()">
        <center>
            <h3>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</h3>
            <h3 style="margin-top: -20px;">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h3>
            <h4><u>ລາຍງານຍອດຂາຍປະຈໍາເດືອນ</u></h4>
        </center>
        <h4>ວັນທີ່ລາຍງານ : <?php echo date("d/m/Y", strtotime($_POST["start_date"])) ?> ຫາ <?php echo date("d/m/Y", strtotime($_POST["end_date"])) ?></h4>
        <table border="1" style="border-collapse: collapse;width:100%">
            <thead>
                <tr>
                    <td rowspan="2" widtd="5%" style="text-align:center !important;">ລໍາດັບ</td>
                    <td rowspan="2" style="text-align: center;">ເດືອນ</td>
                    <td rowspan="2" align="center">ລວມບິນຂາຍ</td>
                    <td rowspan="2" align="center">ລວມຍອດຂາຍກ່ອນຫຼຸດ</td>
                    <td colspan="2" align="center">ລວມສ່ວນຫຼຸດ</td>
                    <td rowspan="2" align="center">ລວມຍອດຂາຍຫຼັງຫຼຸດ</td>
                    <td colspan="3" align="center">ລວມຍອດເງິນສົດ</td>
                    <td colspan="3" align="center">ລວມຍອດເງິນໂອນ</td>
                    <td rowspan="2" align="center">ລວມຍອດເງິນທອນ</td>
                </tr>
                <tr>
                    <td>ຫຼຸດເປັນລາຍການ</td>
                    <td>ຫຼຸດທ້າຍບິນ</td>
                    <td align="center">ຈ່າຍກີບ</td>
                    <td align="center">ຈ່າຍບາດ</td>
                    <td align="center">ຈ່າຍໂດຣາ</td>

                    <td align="center">ໂອນກີບ</td>
                    <td align="center">ໂອນບາດ</td>
                    <td align="center">ໂອນໂດຣາ</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if (count($sql) > 0) {
                    foreach ($sql as $rowSql) {
                        @$sumcountBill += $rowSql["countBill"];
                        @$sumamounts += $rowSql["amounts"];
                        @$sumamountPerlist += $rowSql["amountPerlist"];
                        @$sumamountPerBill += $rowSql["amountPerBill"];
                        @$sumtotals += $rowSql["totals"];
                        @$sumpaykip += $rowSql["payKip"];
                        @$sumpayBath += $rowSql["payBath"];
                        @$sumpayUs += $rowSql["payUs"];
                        @$sumtransferKip += $rowSql["transferKip"];
                        @$sumtransferBath += $rowSql["transferBath"];
                        @$sumtransferUs += $rowSql["transferUs"];
                        @$sumreturnAll += $rowSql["returnAll"];
                ?>
                        <tr>
                            <td align="center"><?php echo $i++; ?></td>
                            <td align="center"><?php echo $rowSql["monthNow"]; ?></td>
                            <td align="center"><?php echo @number_format($rowSql["countBill"]); ?></td>
                            <td align="center"><?php echo @number_format($rowSql["amounts"]); ?></td>
                            <td align="center"><?php echo @number_format($rowSql["amountPerlist"]); ?></td>
                            <td align="center"><?php echo @number_format($rowSql["amountPerBill"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["totals"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["payKip"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["payBath"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["payUs"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["transferKip"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["transferBath"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["transferUs"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["returnAll"]); ?></td>

                        </tr>
                    <?php } ?>
                    <tr style="font-size:16px !important;font-weight:bold;">
                        <td colspan="2" align="right">ລວມທັງໝົດ</td>
                        <td align="center"><?php echo @number_format($sumcountBill) ?></td>
                        <td align="center"><?php echo @number_format($sumamounts) ?></td>
                        <td align="center"><?php echo @number_format($sumamountPerlist); ?></td>
                        <td align="center"><?php echo @number_format($sumamountPerBill) ?></td>
                        <td align="right"><?php echo @number_format($sumtotals) ?></td>
                        <td align="right"><?php echo @number_format($sumpaykip) ?></td>
                        <td align="right"><?php echo @number_format($sumpayBath) ?></td>
                        <td align="right"><?php echo @number_format($sumpayUs) ?></td>
                        <td align="right"><?php echo @number_format($sumtransferKip) ?></td>
                        <td align="right"><?php echo @number_format($sumtransferBath) ?></td>
                        <td align="right"><?php echo @number_format($sumtransferUs) ?></td>
                        <td align="right"><?php echo @number_format($sumreturnAll) ?></td>
                    <tr>
                    <?php } else { ?>
                    <tr>
                        <td colspan="19" align="center" style="height:380px;padding:150px;color:red">
                            <i class="fas fa-times-circle fa-3x"></i><br>
                            ບໍ່ພົບລາຍການ
                        </td>
                    </tr>
                <?php } ?>
        </table>
        <table style="margin-top: 20px;float:right">
            <tr>
                <td style="font-size: 14px;font-weight:bold"><u>ລາຍງານໂດຍ : </u> &nbsp;&nbsp;&nbsp;</td>
            </tr>
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
            <h4><u>ລາຍງານຍອດຂາຍປະຈໍາເດືອນ</u></h4>
        </center>
        <h4>ວັນທີ່ລາຍງານ : <?php echo date("d/m/Y", strtotime($_POST["start_date"])) ?> ຫາ <?php echo date("d/m/Y", strtotime($_POST["end_date"])) ?></h4>
        <table border="1" style="border-collapse: collapse;width:100%">
            <thead>
                <tr>
                    <td rowspan="2" widtd="5%" style="text-align:center !important;">ລໍາດັບ</td>
                    <td rowspan="2" style="text-align: center;">ເດືອນ</td>
                    <td rowspan="2" align="center">ລວມບິນຂາຍ</td>
                    <td rowspan="2">ລວມຍອດຂາຍກ່ອນຫຼຸດ</td>
                    <td colspan="2" align="center">ລວມສ່ວນຫຼຸດ</td>
                    <td rowspan="2">ລວມຍອດຂາຍຫຼັງຫຼຸດ</td>
                    <td colspan="3" align="center">ລວມຍອດເງິນສົດ</td>
                    <td colspan="3" align="center">ລວມຍອດເງິນໂອນ</td>
                    <td rowspan="2">ລວມຍອດເງິນທອນ</td>
                </tr>
                <tr>
                    <td>ຫຼຸດເປັນລາຍການ</td>
                    <td>ຫຼຸດທ້າຍບິນ</td>
                    <td align="center">ຈ່າຍກີບ</td>
                    <td align="center">ຈ່າຍບາດ</td>
                    <td align="center">ຈ່າຍໂດຣາ</td>

                    <td align="center">ໂອນກີບ</td>
                    <td align="center">ໂອນບາດ</td>
                    <td align="center">ໂອນໂດຣາ</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if (count($sql) > 0) {
                    foreach ($sql as $rowSql) {
                        @$sumcountBill += $rowSql["countBill"];
                        @$sumamounts += $rowSql["amounts"];
                        @$sumamountPerlist += $rowSql["amountPerlist"];
                        @$sumamountPerBill += $rowSql["amountPerBill"];
                        @$sumtotals += $rowSql["totals"];
                        @$sumpaykip += $rowSql["payKip"];
                        @$sumpayBath += $rowSql["payBath"];
                        @$sumpayUs += $rowSql["payUs"];
                        @$sumtransferKip += $rowSql["transferKip"];
                        @$sumtransferBath += $rowSql["transferBath"];
                        @$sumtransferUs += $rowSql["transferUs"];
                        @$sumreturnAll += $rowSql["returnAll"];
                ?>
                        <tr>
                            <td align="center"><?php echo $i++; ?></td>
                            <td align="center"><?php echo $rowSql["monthNow"]; ?></td>
                            <td align="center"><?php echo @number_format($rowSql["countBill"]); ?></td>
                            <td align="center"><?php echo @number_format($rowSql["amounts"]); ?></td>
                            <td align="center"><?php echo @number_format($rowSql["amountPerlist"]); ?></td>
                            <td align="center"><?php echo @number_format($rowSql["amountPerBill"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["totals"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["payKip"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["payBath"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["payUs"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["transferKip"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["transferBath"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["transferUs"]); ?></td>
                            <td align="right"><?php echo @number_format($rowSql["returnAll"]); ?></td>

                        </tr>
                    <?php } ?>
                    <tr style="font-size:16px !important;font-weight:bold;">
                        <td colspan="2" align="right">ລວມທັງໝົດ</td>
                        <td align="center"><?php echo @number_format($sumcountBill) ?></td>
                        <td align="center"><?php echo @number_format($sumamounts) ?></td>
                        <td align="center"><?php echo @number_format($sumamountPerlist); ?></td>
                        <td align="center"><?php echo @number_format($sumamountPerBill) ?></td>
                        <td align="right"><?php echo @number_format($sumtotals) ?></td>
                        <td align="right"><?php echo @number_format($sumpaykip) ?></td>
                        <td align="right"><?php echo @number_format($sumpayBath) ?></td>
                        <td align="right"><?php echo @number_format($sumpayUs) ?></td>
                        <td align="right"><?php echo @number_format($sumtransferKip) ?></td>
                        <td align="right"><?php echo @number_format($sumtransferBath) ?></td>
                        <td align="right"><?php echo @number_format($sumtransferUs) ?></td>
                        <td align="right"><?php echo @number_format($sumreturnAll) ?></td>
                    <tr>
                    <?php } else { ?>
                    <tr>
                        <td colspan="19" align="center" style="height:380px;padding:150px;color:red">
                            <i class="fas fa-times-circle fa-3x"></i><br>
                            ບໍ່ພົບລາຍການ
                        </td>
                    </tr>
                <?php } ?>
        </table>
        <table style="margin-top: 20px;float:right">
            <tr>
                <td style="font-size: 14px;font-weight:bold"><u>ລາຍງານໂດຍ : </u> &nbsp;&nbsp;&nbsp;</td>
            </tr>
        </table>
    </body>
<?php } ?>
</body>
</html>