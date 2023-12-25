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
    <title>ລາຍງານປະຈໍາວັນທີ່ <?php echo date("d/m/Y", strtotime(DATE("Y-m-d"))) ?></title>
    <style>
        @media print{
            @page {
                size: landscape;
                margin: 0;
            }
            body { margin: 0.5cm; }
        }
    </style>
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
    if (isset($_POST["print"])) {
        if ($_POST["lookType"] == "1") {
            @$query .= "view_daily_report_group";

            if ($_POST["start_date"] != "" && $_POST["end_date"] != "") {
                $query .= " WHERE list_bill_date BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' ";
            } else {
                $query .= "";
            }

            if ($_POST["search_page"] != "") {
                $sqlCheck = $db->fn_fetch_rowcount("res_bill WHERE bill_code LIKE '%" . $_POST["search_page"] . "%' ");
                if ($sqlCheck > 0) {
                    $query .= " AND list_bill_no LIKE '%" . $_POST["search_page"] . "%'";
                } else {
                    $sqlCheck1 = $db->fn_fetch_rowcount("res_tables WHERE table_name LIKE '%" . $_POST["search_page"] . "%' ");
                    if ($sqlCheck1 > 0) {
                        $query .= " AND table_name LIKE '%" . $_POST["search_page"] . "%'  ";
                    } else {
                        $query.="AND table_name='232sdsfeer2222'";
                    }
                }
            } else {$query.
                $query .= "";
            }

            if ($_POST["typePayment"] != "") {
                $query .= "AND list_bill_type_pay_fk='" . $_POST["typePayment"] . "'";
            } else {
                $query .= "";
            }

            if ($_POST["search_branch"] != "") {
                $query .= "AND list_bill_branch_fk='" . $_POST["search_branch"] . "'";
            } else {
                $query .= "";
            }


            $query.= " AND list_bill_status='1' ORDER BY list_bill_no " . $_POST['order_page'] . " ";
            if ($_POST["limit_page"] != "") {
                $filter_query = $query.' LIMIT ' . $start . ', ' . $limit . '';
            } else {
                $filter_query = $query ;
            }

            $fetch_sql = $db->fn_read_all($filter_query);
            $total_data = $db->fn_fetch_rowcount($query);
            $total_id = $start + 1;
    ?>
            <link href="style.css" rel="stylesheet" />
            <body onload="window.print()">
                <center>
                    <h4>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</h4>
                    <h4 style="margin-top: -20px;">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h4>
                    <h3><u>ລາຍງານຍອດຂາຍປະຈໍາວັນ</u><br>( ແບບລວມ )</h3>
                </center>
                <h4 style="margin-left: 60px;margin-top: -20px;"><img src="../../assets/img/store/<?php echo $_SESSION["store_img"];?>" style="width:80px;" alt=""></h4>
                <h5 style="margin-top: -20px;">ວັນທີ່ລາຍງານ : <?php echo date("d/m/Y", strtotime($_POST["start_date"])) ?> ຫາ <?php echo date("d/m/Y", strtotime($_POST["end_date"])) ?></h5>

                <table border="1" style="border-collapse: collapse;width:100%">
                    <thead style="background-color:#0F253B;color:white">
                        <tr style="font-size:14px !important">
                            <td rowspan="2" class="theader" widtd="5%" style="text-align:center !important;">ລໍາດັບ</td>
                            <td rowspan="2" class="theader" style="text-align: center;">ວັນທີ່ຂາຍ</td>
                            <td rowspan="2" class="theader" align="center">ເລກບິນ</td>
                            <td rowspan="2" class="theader" align="center">ເບີໂຕະ</td>
                            <td colspan="2" class="theader" align="center">ອັດຕາແລກປ່ຽນ</td>
                            <td rowspan="2" class="theader" align="center">ປະເພດຊໍາລະ</td>
                            <td rowspan="2" class="theader" align="center" style="background-color: #CFBAA4;color:black">ຈ/ນລວມ</td>
                            <td rowspan="2" class="theader" align="center" style="background-color: #F7BE25;color:black">ລາຄາລວມ</td>
                            <td rowspan="2" class="theader" align="center" style="background-color: #D76006;color:white">ລູກຄ້າຕິດໜີ້</td>
                            <td colspan="2" class="theader" align="center" style="background-color: #2E4D4D;color:white">ສ່ວນຫຼຸດ</td>
                            <td rowspan="2" class="theader" align="center" style="background-color: #F7BE25;color:black">ຍອດຂາຍລວມ</td>
                            <td colspan="3" class="theader" align="center" style="background-color: #D4A020;color:black">ຈ່າຍເງິນສົດ</td>
                            <td colspan="3" class="theader" align="center" style="background-color: #2E447C;color:white">ຈ່າຍເງິນໂອນ</td>
                            <td rowspan="2" class="theader" align="center" style="background-color: #CA8E78;color:black" >ເງິນທອນ</td>
                            <td rowspan="2" class="theader" align="center" style="background-color: #F7BE25;color:black">ຍອດຂາຍຕົວຈິງ</td>
                        </tr>
                        <tr style="font-size:14px !important">
                            <td align="center" class="theader">ບາດ-ກີບ</td>
                            <td align="center" class="theader">ໂດຣາ-ກີບ</td>
                            <td align="center" class="theader" style="background-color: #2E4D4D;color:white">ເປັນເງິນ</td>
                            <td align="center" class="theader" style="background-color: #2E4D4D;color:white">ເປັນ%</td>
                            <td align="center" class="bg-primary theader" style="background-color: #D4A020;color:black">ກີບ</td>
                            <td align="center" class="bg-primary theader" style="background-color: #D4A020;color:black">ບາດ</td>
                            <td align="center" class="bg-primary theader" style="background-color: #D4A020;color:black">ໂດຣາ</td>
                            <td align="center" class="bg-orange theader" style="background-color: #2E447C;color:white">ກີບ</td>
                            <td align="center" class="bg-orange theader" style="background-color: #2E447C;color:white">ບາດ</td>
                            <td align="center" class="bg-orange theader" style="background-color: #2E447C;color:white">ໂດຣາ</td>
                        </tr>
                    </thead>
                    <tbody class="table-bordered-y table-sm display">
                        <?php
                        if ($total_data > 0) {
                            foreach ($fetch_sql as $row_sql) {

                                @$amount+=$row_sql["list_bill_amount"];
                                @$sumPerPrice+=$row_sql["list_bill_percented_price"];
                                @$sumTotal1+=$row_sql["list_bill_amount_kip"];
                                if($row_sql["list_bill_type_pay_fk"]!="4"){
                                    
                                    @$sumTotal+=$row_sql["list_bill_amount_kip"];
                                    @$sumTotalKang+=$row_sql["list_bill_amount_kip"];
                                    @$sumBill=$row_sql["list_bill_amount"];
                                    @$sumNy=0;
                                    @$totalNy+=0;

                                }else{
                                    // @$amount+=0;
                                    @$sumTotal+=0;
                                    @$sumBill=0;
                                    @$sumNy=$row_sql["list_bill_amount"];
                                    @$totalNy+=$row_sql["list_bill_amount"];
                                }

                                @$sumPaykip += $row_sql["list_bill_pay_kip"];
                                @$sumPaybath += $row_sql["list_bill_pay_bath"];
                                @$sumPayus += $row_sql["list_bill_pay_us"];
                                @$sumReturn += $row_sql["list_bill_return"];
                                @$sumQty += $row_sql["list_bill_qty"] + $row_sql["list_bill_sum_qty_promotion"];
                                if ($row_sql["list_bill_percented"] != "0") {
                                    @$amountPer = $row_sql["list_bill_percented"] . "%";
                                    @$amountPercented = $row_sql["list_bill_total_percented"];
                                } else {
                                    @$amountPer = "0";
                                    @$amountPercented = "0";
                                }

                                @$sumtransferKip += $row_sql["list_bill_transfer_kip"];
                                @$sumtransferBath += $row_sql["list_bill_transfer_bath"];
                                @$sumtransferUs += $row_sql["list_bill_transfer_us"];

                                @$sumPer += $amountPercented;

                                if ($row_sql["list_bill_type_pay_fk"] == "1") {
                                    $typePayment = "ເງິນສົດ";
                                    $color = "";
                                } elseif ($row_sql["list_bill_type_pay_fk"] == "2") {
                                    $typePayment = "ເງິນໂອນ";
                                    $color = "";
                                } elseif ($row_sql["list_bill_type_pay_fk"] == "3") {
                                    $typePayment = "ເງິນສົດ-ໂອນ";
                                    $color = "";
                                } elseif ($row_sql["list_bill_type_pay_fk"] == "4") {
                                    $typePayment = "ຕິດໜີ້";
                                    $color = "red";
                                } else {
                                    $typePayment = "ສັ່ງກັບບ້ານ";
                                    $color = "";
                                }

                        ?>
                                <tr style="color:<?php echo $color; ?>">
                                    <td align="center"><?php echo $total_id++; ?></td>
                                    <td align="center"><?php echo date("d/m/Y", strtotime($row_sql["list_bill_date"])) ?></td>
                                    <td align="center"><?php echo $row_sql["list_bill_no"] ?></td>
                                    <td align="center"><?php echo $row_sql["table_name"] ?></td>
                                    <td align="center"><?php echo @number_format($row_sql["list_rate_bat_kip"]) ?></td>
                                    <td align="center"><?php echo @number_format($row_sql["list_rate_us_kip"]) ?></td>
                                    <td align="center"><?php echo $typePayment; ?></td>
                                    <td align="center"><?php echo @number_format($row_sql["list_bill_qty"] + $row_sql["list_bill_sum_qty_promotion"]) ?></td>
                                    <td align="right"><?php echo @number_format($row_sql["list_bill_amount"]);?></td>
                                    <td align="right" style="color:#f70000"><?php echo @number_format($sumNy); ?></td>
                                    <td align="right">
                                        <?php echo @number_format($row_sql["list_bill_percented_price"]) ?>
                                    </td>
                                    <td align="right">
                                        <?php echo $amountPer; ?>
                                    </td>
                                    <td align="right"><?php echo @number_format($row_sql["list_bill_amount_kip"]);?></td>
                                    <td align="right"><?php echo @number_format($row_sql["list_bill_pay_kip"]) ?></td>
                                    <td align="right"><?php echo @number_format($row_sql["list_bill_pay_bath"]) ?></td>
                                    <td align="right"><?php echo @number_format($row_sql["list_bill_pay_us"]) ?></td>
                                    <td align="right"><?php echo @number_format($row_sql["list_bill_transfer_kip"]) ?></td>
                                    <td align="right"><?php echo @number_format($row_sql["list_bill_transfer_bath"]) ?></td>
                                    <td align="right"><?php echo @number_format($row_sql["list_bill_transfer_us"]) ?></td>
                                    <td align="right"><?php echo @number_format($row_sql["list_bill_return"]) ?></td>
                                    <td align="right"><?php if ($row_sql["list_bill_type_pay_fk"] == "4") {
                                                            echo "0";
                                                        } else {
                                                            echo @number_format($row_sql["list_bill_amount_kip"]);
                                                        } ?></td>
                                </tr>
                            <?php } ?>
                            <tr style="font-weight:bold">
                                <td colspan="7" align="right">ລວມຍອດຂາຍທັງໝົດ</td>
                                <td align="center" style="background:#CFBAA4"><?php echo @number_format($sumQty) ?></td>
                                <td align="right" style="background:#F7BE25"><?php echo @number_format($amount) ?></td>
                                <td align="right" style="background:#D76006;color:white"><?php echo @number_format($totalNy) ?></td>
                                <td align="right" style="background:#2E4D4D;color:white"><?php echo @number_format($sumPerPrice); ?></td>
                                <td align="right" style="background:#2E4D4D;color:white"><?php echo @number_format($sumPer) ?></td>
                                <td align="right" style="background:#F7BE25"><?php echo @number_format($sumTotal1) ?></td>
                                <td align="right" style="background:#D4A020;color:black"><?php echo @number_format($sumPaykip) ?></td>
                                <td align="right" style="background:#D4A020;color:black"><?php echo @number_format($sumPaybath) ?></td>
                                <td align="right" style="background:#D4A020;color:black"><?php echo @number_format($sumPayus) ?></td>
                                <td align="right" style="background:#2E447C;color:white"><?php echo @number_format($sumtransferKip) ?></td>
                                <td align="right" style="background:#2E447C;color:white"><?php echo @number_format($sumtransferBath) ?></td>
                                <td align="right" style="background:#2E447C;color:white"><?php echo @number_format($sumtransferUs) ?></td>
                                <td align="right" style="background:#CA8E78"><?php echo @number_format($sumReturn) ?></td>
                                <td align="right" style="background:#F7BE25;" class="theader"><?php echo @number_format($sumTotal) ?></td>
                            <tr>

                            

                            <?php } else { ?>
                            <tr>
                                <td colspan="21" align="center" style="height:380px;padding:150px;color:red">
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
        <?php } else { ?>
            <link href="style.css" rel="stylesheet" />

            <body onload="window.print()">
                <center>
                    <h4>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</h4>
                    <h4 style="margin-top: -20px;">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h4>
                    <h3><u>ລາຍງານຍອດຂາຍປະຈໍາວັນ</u><br>( ແບບລະອຽດ )</h3>
                </center>
                <h4 style="margin-left: 60px;margin-top: -20px;"><img src="../../assets/img/store/<?php echo $_SESSION["store_img"];?>" style="width:80px;" alt=""></h4>
                <h5 style="margin-top: -20px;">ວັນທີ່ລາຍງານ : <?php echo date("d/m/Y", strtotime($_POST["start_date"])) ?> ຫາ <?php echo date("d/m/Y", strtotime($_POST["end_date"])) ?></h5>
                <table style="border-collapse: collapse;width:100%">
                    <thead style="background-color:#0F253B;color:white">
                        <tr>
                            <td widtd="5%" style="text-align:center !important;">ລໍາດັບ</td>
                            <td style="text-align: center;">ວັນທີ່ຂາຍ</td>
                            <td style="text-align: center;">ເລກບິນ</td>
                            <td style="text-align: center;">ເບີໂຕະ</td>
                            <td style="text-align: center;">ຍອດຂາຍຕົວຈິງ</td>
                            <td>ລາຍການອາຫານ ແລະ ເຄື່ອງດຶ່ມ</td>
                            <td style="text-align: center;">ລາຄາ</td>
                            <td style="text-align: center;">ຈໍານວນ</td>
                            <td style="text-align: center;">ແຖມ</td>
                            <td style="text-align: center;">ສ່ວນຫຼຸດລາຍການ</td>
                            <td align="right">ລວມ</t>
                        </tr>
                    </thead>
                    <tbody class="table-sm display">
                        <?php
                        $i = 1;

                        @$query .= "view_daily_report_group";

                        if ($_POST["start_date"] != "" && $_POST["end_date"] != "") {
                            $query .= " WHERE list_bill_date BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' ";
                        } else {
                            $query .= "";
                        }

                        if ($_POST["search_page"] != "") {
                            $sqlCheck = $db->fn_fetch_rowcount("res_bill WHERE bill_code LIKE '%" . $_POST["search_page"] . "%' ");
                            if ($sqlCheck > 0) {
                                $query .= " AND list_bill_no LIKE '%" . $_POST["search_page"] . "%'";
                            } else {
                                $sqlCheck1 = $db->fn_fetch_rowcount("res_tables WHERE table_name LIKE '%" . $_POST["search_page"] . "%' ");
                                if ($sqlCheck1 > 0) {
                                    $query .= " AND table_name LIKE '%" . $_POST["search_page"] . "%'  ";
                                } else {
                                    $query.="AND table_name='232sdsfeer2222'";
                                }
                            }
                        } else {
                            $query .= "";
                        }

                        if ($_POST["typePayment"] != "") {
                            $query .= "AND list_bill_type_pay_fk='" . $_POST["typePayment"] . "' ";
                        } else {
                            $query .= "";
                        }

                        if ($_POST["search_branch"] != "") {
                            $query .= "AND list_bill_branch_fk='" . $_POST["search_branch"] . "'";
                        } else {
                            $query .= "";
                        }

                        $query.= " AND list_bill_status='1' ORDER BY list_bill_no " . $_POST['order_page'] . " ";

                        if ($_POST["limit_page"] != "") {
                            $filter_query = $query.' LIMIT ' . $start . ', ' . $limit . '';
                        } else {
                            $filter_query = $query ;
                        }


                        $sqlreport = $db->fn_read_all($filter_query);
                        $total_data = $db->fn_fetch_rowcount($query);
                        $total_id = $start + 1;
                        if ($total_data > 0) {
                            foreach ($sqlreport as $rowreport) {
                                @$countData=$rowreport["list_bill_count_order"]+1;
                                @$totalQty+=$rowreport["list_bill_qty"];
                                @$totalPomotion+=$rowreport["list_bill_sum_qty_promotion"];
                                @$totalPer+=$rowreport["list_bill_total_percented_list"];
                                if($rowreport["list_bill_type_pay_fk"]!="4"){
                                    @$totalAmount+=$rowreport["list_bill_amount_kip"];
                                }else{
                                    @$totalAmount+=0;
                                }


                        ?>
                                <tr style="border: 1px solid #FFFFFF;">
                                    <td align="center"><?php echo $i++;?></td>
                                    <td align="center"><?php echo date("d/m/Y",strtotime($rowreport["list_bill_date"]))?></td>
                                    <td align="center" style='mso-number-format:\@;text-align:center'><?php echo $rowreport["list_bill_no"]?></td>
                                    <td align="center"><?php echo $rowreport["table_name"]?></td>
                                    <td align="center"><?php echo @number_format($rowreport["list_bill_amount_kip"])?></td>
                                </tr>
                                <?php
                                $sqlDetail = $db->fn_read_all("view_daily_report_list WHERE check_bill_list_bill_fk='" . $rowreport["list_bill_no"] . "' ");
                                foreach ($sqlDetail as $rowDetail) {
                                ?>
                                    <tr style="border: 1px solid #FFFFFF;">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>- <?php echo $rowDetail["product_name"]?> <?php if($rowDetail["check_bill_list_status_promotion"]=="2"){echo "<span class='text-danger'>( ຊື້ ".$rowDetail['check_bill_list_qty_promotion_all']." ແຖມ ".$rowDetail['check_bill_list_qty_promotion_gif'].")</span>";}?></td>
                                        <td align="center"><?php echo @number_format($rowDetail["check_bill_list_pro_price"])?></td>
                                        <td align="center"><?php echo $rowDetail["check_bill_list_order_qty"]?></td>
                                        <td align="center"><?php echo @number_format($rowDetail["check_bill_list_qty_promotion_total"])?></td>
                                        <td align="center"><?php echo @number_format($rowDetail["check_bill_list_discount_price"])?></td>
                                        <td align="right"><?php echo @number_format($rowDetail["check_bill_list_discount_total"])?></td>
                                        
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="11"></td>
                                </tr>
                                <tr style="background:#eff3f7">
                                    <td colspan="7" align="right">ລວມຍອດຂາຍ : </td>
                                    <td align="center"><?php echo @number_format($rowreport["list_bill_qty"])?></td>
                                    <td align="center"><?php echo @number_format($rowreport["list_bill_sum_qty_promotion"])?></td>
                                    <td align="center"><?php echo @number_format($rowreport["list_bill_total_percented_list"])?></td>
                                    <td align="right"><?php echo @number_format($rowreport["list_bill_amount_kip"])?></td>
                                </tr>
                                <tr style="background:#eff3f7">
                                    <td colspan="7" align="right">ສ່ວນຫຼຸດທ້າຍບິນ : </td>
                                    <td colspan="4" align="right"><?php echo @number_format($rowreport["list_bill_total_percented"])?></td>
                                </tr>
                                <tr style="font-weight: bold;background:#f9f0c5 !important;">
                                    <td colspan="7" align="right">ຍອດຂາຍຕົວຈິງ :</td>
                                    <td colspan="4" align="right" style="font-size: 18px;"><?php echo @number_format($rowreport["list_bill_amount_kip"]-$rowreport["list_bill_total_percented"])?></td>
                                </tr>
                            <?php } ?>
                            <tr style="background-color: #0F253B;color:white">
                                <td colspan="7" align="right">ຍອດຂາຍລວມທັງໝົດ</td>
                                <td align="center" style="font-size: 18px;"><?php echo @number_format($totalQty)?></td>
                                <td align="center" style="font-size: 18px;"><?php echo @number_format($totalPomotion)?></td>
                                <td align="center" style="font-size: 18px;"><?php echo @number_format($totalPer)?></td>
                                <td align="right" style="font-size: 19px;"><?php echo @number_format($totalAmount)?></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td colspan="10" align="center" style="height:380px;padding:150px;color:red">
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
            <?php }
    }
    if (isset($_POST["excel"])) {

        date_default_timezone_set('Asia/Bangkok');
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . rand() . '.xls"');
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">';


        if ($_POST["lookType"] == "1") {
            @$query .= "view_daily_report_group";

            if ($_POST["start_date"] != "" && $_POST["end_date"] != "") {
                $query .= " WHERE list_bill_date BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' ";
            } else {
                $query .= "";
            }

            if ($_POST["search_page"] != "") {
                $sqlCheck = $db->fn_fetch_rowcount("res_bill WHERE bill_code LIKE '%" . $_POST["search_page"] . "%' ");
                if ($sqlCheck > 0) {
                    $query .= " AND list_bill_no LIKE '%" . $_POST["search_page"] . "%'";
                } else {
                    $sqlCheck1 = $db->fn_fetch_rowcount("res_tables WHERE table_name LIKE '%" . $_POST["search_page"] . "%' ");
                    if ($sqlCheck1 > 0) {
                        $query .= " AND table_name LIKE '%" . $_POST["search_page"] . "%'  ";
                    } else {
                        $query.="AND table_name='232sdsfeer2222'";
                    }
                }
            } else {
                $query .= "";
            }

            if ($_POST["typePayment"] != "") {
                $query .= "AND list_bill_type_pay_fk='" . $_POST["typePayment"] . "'";
            } else {
                $query .= "";
            }

            if ($_POST["search_branch"] != "") {
                $query .= "AND list_bill_branch_fk='" . $_POST["search_branch"] . "'";
            } else {
                $query .= "";
            }


            $query.= " AND list_bill_status='1'ORDER BY list_bill_no " . $_POST['order_page'] . " ";
            if ($_POST["limit_page"] != "") {
                $filter_query = $query.' LIMIT ' . $start . ', ' . $limit . '';
            } else {
                $filter_query = $query ;
            }

            $fetch_sql = $db->fn_read_all($filter_query);
            $total_data = $db->fn_fetch_rowcount($query);
            $total_id = $start + 1;
            ?>
                <style>
                    table,tr,td,th,h2,h3,h4{
                        font-family: Phetsarath OT !important;
                    }
                </style>

                <body>
                    <center>
                        <h3>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</h3>
                        <h3 style="margin-top: -20px;">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h3>
                        <h4><u>ລາຍງານຍອດຂາຍປະຈໍາວັນ</u><br>( ແບບລວມ )</h4>
                    </center>
                    <h4>ວັນທີ່ລາຍງານ : <?php echo date("d/m/Y", strtotime($_POST["start_date"])) ?> ຫາ <?php echo date("d/m/Y", strtotime($_POST["end_date"])) ?></h4>

                    <table border="1" style="border-collapse: collapse;width:100%;">
                        <thead>
                            <tr style="font-weight:600;font-size:16px !important">
                                <td rowspan="2" class="theader" widtd="5%" style="text-align:center !important;">ລໍາດັບ</td>
                                <td rowspan="2" class="theader" style="text-align: center;">ວັນທີ່ຂາຍ</td>
                                <td rowspan="2" class="theader" align="center">ເລກບິນ</td>
                                <td rowspan="2" class="theader" align="center">ເບີໂຕະ</td>
                                <td colspan="2" class="theader" align="center">ອັດຕາແລກປ່ຽນ</td>
                                <td rowspan="2" class="theader" align="center">ປະເພດຊໍາລະ</td>
                                <td rowspan="2" class="theader" align="center">ຈ/ນລວມ</td>
                                <td rowspan="2" class="theader" align="center">ຍອດຂາຍລວມ</td>
                                <td rowspan="2" class="theader" align="center">ລູກຄ້າຕິດໜີ້</td>
                                <td rowspan="2" class="theader" align="center">ຍອດຂາຍລວມ</td>
                                <td colspan="2" class="theader" align="center">ສ່ວນຫຼຸດ</td>
                                <td colspan="3" class="theader" align="center" class="bg-primary">ຈ່າຍເງິນສົດ</td>
                                <td colspan="3" class="theader" align="center" class="bg-orange">ຈ່າຍເງິນໂອນ</td>
                                <td rowspan="2" class="theader" align="center">ເງິນທອນ</td>
                                <td rowspan="2" class="theader" align="center">ຍອດຂາຍຕົວຈິງ</td>
                            </tr>
                            <tr style="font-weight:600;font-size:16px !important">
                                <td align="center" class="theader">ບາດ-ກີບ</td>
                                <td align="center" class="theader">ໂດຣາ-ກີບ</td>
                                <td align="center" class="theader">ເປັນເງິນ</td>
                                <td align="center" class="theader">ເປັນ%</td>
                                <td align="center" class="bg-primary theader">ກີບ</td>
                                <td align="center" class="bg-primary theader">ບາດ</td>
                                <td align="center" class="bg-primary theader">ໂດຣາ</td>
                                <td align="center" class="bg-orange theader">ກີບ</td>
                                <td align="center" class="bg-orange theader">ບາດ</td>
                                <td align="center" class="bg-orange theader">ໂດຣາ</td>
                            </tr>
                        </thead>
                        <tbody class="table-bordered-y table-sm display">
                            <?php
                            if ($total_data > 0) {
                                foreach ($fetch_sql as $row_sql) {

                                    @$amount+=$row_sql["list_bill_amount"];
                                @$sumPerPrice+=$row_sql["list_bill_percented_price"];
                                @$sumTotal1+=$row_sql["list_bill_amount_kip"];
                                if($row_sql["list_bill_type_pay_fk"]!="4"){
                                    
                                    @$sumTotal+=$row_sql["list_bill_amount_kip"];
                                    @$sumTotalKang+=$row_sql["list_bill_amount_kip"];
                                    @$sumBill=$row_sql["list_bill_amount"];
                                    @$sumNy=0;
                                    @$totalNy+=0;

                                }else{
                                    // @$amount+=0;
                                    @$sumTotal+=0;
                                    @$sumBill=0;
                                    @$sumNy=$row_sql["list_bill_amount"];
                                    @$totalNy+=$row_sql["list_bill_amount"];
                                }

                                @$sumPaykip += $row_sql["list_bill_pay_kip"];
                                @$sumPaybath += $row_sql["list_bill_pay_bath"];
                                @$sumPayus += $row_sql["list_bill_pay_us"];
                                @$sumReturn += $row_sql["list_bill_return"];
                                @$sumQty += $row_sql["list_bill_qty"] + $row_sql["list_bill_sum_qty_promotion"];
                                if ($row_sql["list_bill_percented"] != "0") {
                                    @$amountPer = $row_sql["list_bill_percented"] . "%";
                                    @$amountPercented = $row_sql["list_bill_total_percented"];
                                } else {
                                    @$amountPer = "0";
                                    @$amountPercented = "0";
                                }

                                @$sumtransferKip += $row_sql["list_bill_transfer_kip"];
                                @$sumtransferBath += $row_sql["list_bill_transfer_bath"];
                                @$sumtransferUs += $row_sql["list_bill_transfer_us"];

                                @$sumPer += $amountPercented;

                                if ($row_sql["list_bill_type_pay_fk"] == "1") {
                                    $typePayment = "ເງິນສົດ";
                                    $color = "";
                                } elseif ($row_sql["list_bill_type_pay_fk"] == "2") {
                                    $typePayment = "ເງິນໂອນ";
                                    $color = "";
                                } elseif ($row_sql["list_bill_type_pay_fk"] == "3") {
                                    $typePayment = "ເງິນສົດ-ໂອນ";
                                    $color = "";
                                } elseif ($row_sql["list_bill_type_pay_fk"] == "4") {
                                    $typePayment = "ຕິດໜີ້";
                                    $color = "red";
                                } else {
                                    $typePayment = "ສັ່ງກັບບ້ານ";
                                    $color = "";
                                }

                            ?>
                                    <tr style="color:<?php echo $color; ?>">
                                        <td align="center"><?php echo $total_id++; ?></td>
                                        <td align="center"><?php echo date("d/m/Y", strtotime($row_sql["list_bill_date"])) ?></td>
                                        <td align="center"><?php echo $row_sql["list_bill_no"] ?></td>
                                        <td align="center"><?php echo $row_sql["table_name"] ?></td>
                                        <td align="center"><?php echo @number_format($row_sql["list_rate_bat_kip"]) ?></td>
                                        <td align="center"><?php echo @number_format($row_sql["list_rate_us_kip"]) ?></td>
                                        <td align="center"><?php echo $typePayment; ?></td>
                                        <td align="center"><?php echo @number_format($row_sql["list_bill_qty"] + $row_sql["list_bill_sum_qty_promotion"]) ?></td>
                                        <td align="right"><?php echo @number_format($row_sql["list_bill_amount"]);?></td>
                                        <td align="right" style="color:#f70000"><?php echo @number_format($sumNy); ?></td>
                                        <td align="right">
                                            <?php echo @number_format($row_sql["list_bill_percented_price"]) ?>
                                        </td>
                                        <td align="right">
                                            <?php echo $amountPer; ?>
                                        </td>
                                        <td align="right"><?php echo @number_format($row_sql["list_bill_amount_kip"]);?></td>
                                        <td align="right"><?php echo @number_format($row_sql["list_bill_pay_kip"]) ?></td>
                                        <td align="right"><?php echo @number_format($row_sql["list_bill_pay_bath"]) ?></td>
                                        <td align="right"><?php echo @number_format($row_sql["list_bill_pay_us"]) ?></td>
                                        <td align="right"><?php echo @number_format($row_sql["list_bill_transfer_kip"]) ?></td>
                                        <td align="right"><?php echo @number_format($row_sql["list_bill_transfer_bath"]) ?></td>
                                        <td align="right"><?php echo @number_format($row_sql["list_bill_transfer_us"]) ?></td>
                                        <td align="right"><?php echo @number_format($row_sql["list_bill_return"]) ?></td>
                                        <td align="right"><?php if ($row_sql["list_bill_type_pay_fk"] == "4") {
                                                                echo "0";
                                                            } else {
                                                                echo @number_format($row_sql["list_bill_amount_kip"]);
                                                            } ?></td>
                                    </tr>
                                <?php } ?>
                                <tr style="font-weight:bold">
                                    <td colspan="7" align="right">ລວມຍອດຂາຍທັງໝົດ</td>
                                    <td align="center"><?php echo @number_format($sumQty) ?></td>
                                    <td align="right"><?php echo @number_format($amount) ?></td>
                                    <td align="right"><?php echo @number_format($totalNy) ?></td>
                                    <td align="right"><?php echo @number_format($sumPerPrice); ?></td>
                                    <td align="right"><?php echo @number_format($sumPer) ?></td>
                                    <td align="right"><?php echo @number_format($sumTotal1) ?></td>
                                    <td align="right"><?php echo @number_format($sumPaykip) ?></td>
                                    <td align="right"><?php echo @number_format($sumPaybath) ?></td>
                                    <td align="right"><?php echo @number_format($sumPayus) ?></td>
                                    <td align="right"><?php echo @number_format($sumtransferKip) ?></td>
                                    <td align="right"><?php echo @number_format($sumtransferBath) ?></td>
                                    <td align="right"><?php echo @number_format($sumtransferUs) ?></td>
                                    <td align="right"><?php echo @number_format($sumReturn) ?></td>
                                    <td align="right" class="theader"><?php echo @number_format($sumTotal) ?></td>
                                <tr>
                                <?php } else { ?>
                                <tr>
                                    <td colspan="20" align="center" style="height:380px;padding:150px;color:red">
                                        <i class="fas fa-times-circle fa-3x"></i><br>
                                        ບໍ່ພົບລາຍການ
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table style="margin-top: 20px;float:right">
                        <tr>
                            <td style="font-size: 14px;"><u>ລາຍງານໂດຍ : </u> &nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table>
                </body>
            <?php } else { ?>
                <style>
                    table,tr,td,th,h2,h3,h4,h5{
                        font-family: Phetsarath OT !important;
                    }
                </style>

                <body>
                    <center>
                        <h3>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</h3>
                        <h3 style="margin-top: -20px;">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h3>
                        <h4><u>ລາຍງານຍອດຂາຍປະຈໍາວັນ</u><br>( ແບບລະອຽດ )</h4>
                    </center>
                    <h5>ວັນທີ່ລາຍງານ : <?php echo date("d/m/Y", strtotime($_POST["start_date"])) ?> ຫາ <?php echo date("d/m/Y", strtotime($_POST["end_date"])) ?></h5>
                    <table style="border-collapse: collapse;width:100%">
                        <thead>
                            <tr style="font-size: 16px;border-bottom: 1px solid black;font-weight:bold">
                                <td widtd="5%" style="text-align:center !important;">ລໍາດັບ</td>
                                <td style="text-align: center;">ວັນທີ່ຂາຍ</td>
                                <td style="text-align: center;">ເລກບິນ</td>
                                <td style="text-align: center;">ເບີໂຕະ</td>
                                <td style="text-align: center;">ຍອດຂາຍຕົວຈິງ</td>
                                <td>ລາຍການອາຫານ ແລະ ເຄື່ອງດຶ່ມ</td>
                                <td style="text-align: center;">ລາຄາ</td>
                                <td style="text-align: center;">ຈໍານວນ</td>
                                <td style="text-align: center;">ແຖມ</td>
                                <td style="text-align: center;">ສ່ວນຫຼຸດລາຍການ</td>
                                <td align="right">ລວມ</t>
                            </tr>
                        </thead>
                        <tbody class="table-sm display">
                            <?php
                            $i = 1;

                            @$query .= "view_daily_report_group";

                            if ($_POST["start_date"] != "" && $_POST["end_date"] != "") {
                                $query .= " WHERE list_bill_date BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' ";
                            } else {
                                $query .= "";
                            }

                            if ($_POST["search_page"] != "") {
                                $sqlCheck = $db->fn_fetch_rowcount("res_bill WHERE bill_code LIKE '%" . $_POST["search_page"] . "%' ");
                                if ($sqlCheck > 0) {
                                    $query .= " AND list_bill_no LIKE '%" . $_POST["search_page"] . "%'";
                                } else {
                                    $sqlCheck1 = $db->fn_fetch_rowcount("res_tables WHERE table_name LIKE '%" . $_POST["search_page"] . "%' ");
                                    if ($sqlCheck1 > 0) {
                                        $query .= " AND table_name LIKE '%" . $_POST["search_page"] . "%'  ";
                                    } else {
                                        $query.="AND table_name='232sdsfeer2222'";
                                    }
                                }
                            } else {
                                $query .= "";
                            }

                            if ($_POST["typePayment"] != "") {
                                $query .= "AND list_bill_type_pay_fk='" . $_POST["typePayment"] . "' ";
                            } else {
                                $query .= "";
                            }

                            if ($_POST["search_branch"] != "") {
                                $query .= "AND list_bill_branch_fk='" . $_POST["search_branch"] . "'";
                            } else {
                                $query .= "";
                            }

                            $query.= " AND list_bill_status='1' ORDER BY list_bill_no " . $_POST['order_page'] . " ";

                            if ($_POST["limit_page"] != "") {
                                $filter_query = $query.' LIMIT ' . $start . ', ' . $limit . '';
                            } else {
                                $filter_query = $query ;
                            }


                            $sqlreport = $db->fn_read_all($filter_query);
                            $total_data = $db->fn_fetch_rowcount($query);
                            $total_id = $start + 1;
                            if ($total_data > 0) {
                                foreach ($sqlreport as $rowreport) {
                                    @$countData=$rowreport["list_bill_count_order"]+1;
                                    @$totalQty+=$rowreport["list_bill_qty"];
                                    @$totalPomotion+=$rowreport["list_bill_sum_qty_promotion"];
                                    @$totalPer+=$rowreport["list_bill_total_percented_list"];
                                    if($rowreport["list_bill_type_pay_fk"]!="4"){
                                        @$totalAmount+=$rowreport["list_bill_amount_kip"];
                                    }else{
                                        @$totalAmount+=0;
                                    }

                            ?>
                                    <tr style="border: 1px solid #FFFFFF;vertical-align: middle">
                                        <td align="center"><?php echo $i++;?></td>
                                        <td align="center"><?php echo date("d/m/Y",strtotime($rowreport["list_bill_date"]))?></td>
                                        <td align="center" style='mso-number-format:\@;text-align:center'><?php echo $rowreport["list_bill_no"]?></td>
                                        <td align="center"><?php echo $rowreport["table_name"]?></td>
                                        <td align="center"><?php echo @number_format($rowreport["list_bill_amount_kip"])?></td>
                                        <td colspan="7" style="color:white"></td>
                                    </tr>
                                    <?php
                                    $sqlDetail = $db->fn_read_all("view_daily_report_list WHERE check_bill_list_bill_fk='" . $rowreport["list_bill_no"] . "' ");
                                    foreach ($sqlDetail as $rowDetail) {
                                    ?>
                                        <tr style="border: 1px solid #FFFFFF;">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>- <?php echo $rowDetail["product_name"]?> <?php if($rowDetail["check_bill_list_status_promotion"]=="2"){echo "<span class='text-danger'>( ຊື້ ".$rowDetail['check_bill_list_qty_promotion_all']." ແຖມ ".$rowDetail['check_bill_list_qty_promotion_gif'].")</span>";}?></td>
                                            <td align="center"><?php echo @number_format($rowDetail["check_bill_list_pro_price"])?></td>
                                            <td align="center"><?php echo $rowDetail["check_bill_list_order_qty"]?></td>
                                            <td align="center"><?php echo @number_format($rowDetail["check_bill_list_qty_promotion_total"])?></td>
                                            <td align="center"><?php echo @number_format($rowDetail["check_bill_list_discount_price"])?></td>
                                            <td align="right"><?php echo @number_format($rowDetail["check_bill_list_discount_total"])?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr style="background:#eff3f7">
                                        <td colspan="7" align="right">ລວມຍອດຂາຍ : </td>
                                        <td align="center"><?php echo @number_format($rowreport["list_bill_qty"])?></td>
                                        <td align="center"><?php echo @number_format($rowreport["list_bill_sum_qty_promotion"])?></td>
                                        <td align="center"><?php echo @number_format($rowreport["list_bill_total_percented_list"])?></td>
                                        <td align="right"><?php echo @number_format($rowreport["list_bill_amount_kip"])?></td>
                                    </tr>
                                    <tr style="background:#eff3f7">
                                        <td colspan="7" align="right">ສ່ວນຫຼຸດທ້າຍບິນ : </td>
                                        <td colspan="4" align="right"><?php echo @number_format($rowreport["list_bill_total_percented"])?></td>
                                    </tr>
                                    <tr style="font-weight: bold;background:#f9f0c5 !important;">
                                        <td colspan="7" align="right">ຍອດຂາຍຕົວຈິງ :</td>
                                        <td colspan="4" align="right" style="font-size: 18px;"><u><?php echo @number_format($rowreport["list_bill_amount_kip"]-$rowreport["list_bill_total_percented"])?></u></td>
                                    </tr>
                                <?php } ?>
                                <tr style="background-color: #0F253B;color:white">
                                    <td colspan="7" align="right">ຍອດຂາຍລວມທັງໝົດ</td>
                                    <td align="center"><?php echo @number_format($totalQty)?></td>
                                    <td align="center"><?php echo @number_format($totalPomotion)?></td>
                                    <td align="center"><?php echo @number_format($totalPer)?></td>
                                    <td align="right" style="font-size: 20px;"><u><?php echo @number_format($totalAmount)?></u></td>
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
            <?php }
    } ?>
                </body>

</html>