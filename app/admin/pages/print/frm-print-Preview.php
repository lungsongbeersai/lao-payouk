<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
$db = new DBConnection();
$list_bill_no=base64_decode($_GET["list_bill_no"]);
$sqlBranch=$db->fn_fetch_single_all("view_company_title WHERE branch_code='".base64_decode($_GET["branch_code"])."' ");
$sqlRate = $db->fn_fetch_single_all("res_exchange ORDER BY ex_auto DESC LIMIT 1");

$sqlBill=$db->fn_fetch_single_all("view_daily_report_group WHERE list_bill_no='".$list_bill_no."' ");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Invoice</title>
    <style>
        @font-face {
            font-family: 'LAOS';
            src: url('assets/css/fonts/NotoSansLao-Bold.ttf');
        }

        * {
            font-size: 12px;
            font-family: 'LAOS';
            font-weight: bold;
        }

        .tdname,
        .thname,
        .trname,
        .tbname {
            border-top: 1px solid black;
            border-collapse: collapse;
            width: 300px;
        }


        th.description {
            text-align: left;
        }

        th.quantity {
            text-align: right;
        }

        td.quantity {
            word-break: break-all;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 300px;
            max-width: 300px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        .text_light {
            text-align: left !important;
            margin: 0rem;
        }

        .text_left {
            text-align: right !important;
            margin: 0rem;
        }

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }

            .ticket {
                width: 300px;
                max-width: 300px;
            }
        }

        @media print {
            @page { margin: 0; }
        }

    </style>
</head>

<body onload="window.print()">
    <div class="ticket">
        <center>
            <?php 
                if($sqlBranch["store_img"] !=""){
                    $images="assets/img/store/".$sqlBranch["store_img"];
                }else{  
                    $images="assets/img/logo/no_logo.jpg";
                }

                if($sqlBranch["branch_qrcode"] !=""){
                    $imagesQr="assets/img/qr/".$sqlBranch["branch_qrcode"];
                }else{  
                    $imagesQr="assets/img/logo/no_logo.jpg";
                }
            ?>
            <img src="<?php echo $images?>" alt="Logo" style="width: 100px;">
            <p class="centered" style="margin-top: -8px !important;">
                <?php echo $sqlBranch["store_name"];?>
                <br><?php echo $sqlBranch["branch_address"];?>
                <br>
            </p>
        </center>
        <p class="text_light">ສາຂາ : <?php echo $sqlBranch["branch_name"];?></p>
        <p class="text_light">ເບີໂທ: <?php echo $sqlBranch["branch_tel"];?></p>
        <p class="text_light">ຜູ້ໃຊ້ : <?php echo $sqlBill["users_name"];?></p>
        <p class="text_light">ເບີໂຕະ : <?php echo base64_decode($_GET["tableName"])?></p>
        <p class="text_light">ເລກບິນ : <?php echo $list_bill_no;?></p>
        <p class="text_light">ວັນທີ່ : <?php echo date("d/m/Y h:i",strtotime($sqlBill["list_bill_date_time"]));?></p>
        <p class="centered">
            <center>
                <h2 style="font-size: 18px !important;">
                    ໃບຮັບເງິນ
                    <?php 
                        if($sqlBill["list_bill_type_pay_fk"]=="4"){
                            echo "<br>( ບິນຄ້າງຈ່າຍ )";
                            $countRow="5";
                            $fontSize="font-size:17px";
                        }else{
                            $countRow="9";
                            $fontSize="";
                        }
                    ?>
                </h2>
            </center>
        </p>
        <table class="tbname">
            <thead>
                <tr class="trname">
                    <th class="description thname">ລາຍການ</th>
                    <th class="quantity thname">ລວມເປັນເງິນ (ກີບ) &nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sqlPreview=$db->fn_read_all("view_daily_report_list WHERE check_bill_list_bill_fk='".$list_bill_no."'");
                    foreach($sqlPreview AS $rowPreview){
                        @$amount+=$rowPreview["check_bill_list_discount_total"];
                ?>
                    <tr class="trname" style="border-bottom: 1px dotted black;">
                        <td class="tdname" colspan="2">
                            <?php echo $rowPreview["product_name"]?> ( Size:<?php echo $rowPreview["size_name_la"]?> )
                            <br>
                            <span>
                                <?php
                                    if($rowPreview["check_bill_list_discount_status"]=="1"){
                                        echo $rowPreview["check_bill_list_order_qty"];
                                    }else{
                                        @$amountPromo = $rowPreview["check_bill_list_order_qty"] / $rowPreview["check_bill_list_qty_promotion_all"] * $rowPreview["check_bill_list_qty_promotion_gif"];
                                        @$totalPromo = $rowPreview["check_bill_list_order_qty"] + $amountPromo;
                                        echo $rowPreview["check_bill_list_order_qty"]." ແຖມ ".$amountPromo."=".$totalPromo;
                                    }
                                ?>
                                &nbsp; x &nbsp; 
                                <?php echo @number_format($rowPreview["check_bill_list_pro_price"])?>
                            </span>
                            <span style="float:right">
                                <?php 
                                    if($rowPreview["check_bill_list_discount_status"]=="2"){
                                        echo "<s class='text-danger'>".@number_format($rowPreview["order_list_order_total"])."</s> ".@number_format($rowPreview["check_bill_list_discount_total"])."";
                                    }else{
                                        echo @number_format($rowPreview["check_bill_list_discount_total"])."";
                                    }
                                ?>    
                            &nbsp;
                            </span>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>

        <table>
            
            <tr>
                <?php 
                    if($sqlBill["list_bill_type_pay_fk"]=="3"){
                ?>
                    <td style="width:90px">
                        <!-- <img src="<?php echo $imagesQr;?>" alt="Logo" style="width: 100px;"> -->
                    </td>
                <?php }else{?>
                    <td rowspan="<?php echo $countRow?>">
                        <img src="<?php echo $imagesQr;?>" alt="Logo" style="width: 100px;">
                    </td>
                <?php }?>
            </tr>
            
            <tr>
                <td></td>
                <td style="width:110px;text-align:right">ລວມທັງໝົດ : </td>
                <td style="text-align:right;width:80px;<?php echo $fontSize;?>"><?php 
                @$subAmount+=(int)substr($amount,-3);
                if(@$subAmount=="0"){
                    @$subTotal=(@$amount);
                }else{
                    @$subTotal=($amount-$subAmount)+1000;
                }
                echo @number_format($subTotal);?> &nbsp;</td>
            </tr>
            <?php 
                if($sqlBill["list_bill_type_pay_fk"]=="4"){
            ?>
            <tr>
                <td></td>
                <td style="width:100px;text-align:right;color:white !important">.</td>
                <td style="text-align:right;width:80px"></td>
            </tr>
            <tr>
                <td></td>
                <td style="width:100px;text-align:right;color:white !important">.</td>
                <td style="text-align:right;width:80px"></td>
            </tr>
            <tr>
                <td></td>
                <td style="width:100px;text-align:right;color:white !important">.</td>
                <td style="text-align:right;width:80px"></td>
            </tr>
            <?php }else{
            ?>
                <tr>
                    <td></td>
                    <td style="width:100px;text-align:right">ສ່ວນຫຼຸດ ກີບ : </td>
                    <td style="text-align:right;width:80px">
                    <?php if($sqlBill["list_bill_percented_price"] !="0"){echo @number_format($sqlBill["list_bill_total_percented"]);}else{echo "0.0";}?>
                    &nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:100px;text-align:right">ສ່ວນຫຼຸດ % : </td>
                    <td style="text-align:right;width:80px">
                    <?php if($sqlBill["list_bill_percented"] !="0"){echo @number_format($sqlBill["list_bill_total_percented"]);}else{echo "0.0";}?>
                    &nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:100px;text-align:right">ມູນຄ່າຕ້ອງຊໍາລະ : </td>
                    <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_amount_kip"])?> &nbsp;</td>
                </tr>

                <?php if($sqlBill["list_bill_type_pay_fk"]=="2"){?>
                    <tr>
                        <td></td>
                        <td style="width:100px;text-align:right">ຮັບເງິນໂອນ-ກີບ : </td>
                        <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_transfer_kip"])?> &nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width:100px;text-align:right">ຮັບເງິນໂອນ-ບາດ : </td>
                        <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_transfer_bath"])?> &nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width:100px;text-align:right">ຮັບເງິນໂອນ-ໂດຣາ : </td>
                        <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_transfer_us"])?> &nbsp;</td>
                    </tr>
                <?php } else if($sqlBill["list_bill_type_pay_fk"]=="3"){?>
                    <?php 
                        if($sqlBill["list_bill_pay_kip"] !="0"){ 
                    ?>
                    <tr>
                        <td></td>
                        <td style="width:100px;text-align:right">ຮັບເງິນສົດ-ກີບ : </td>
                        <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_pay_kip"])?> &nbsp;</td>
                    </tr>
                    <?php }
                    if($sqlBill["list_bill_pay_bath"] !="0"){ 
                    ?>
                    <tr>
                        <td></td>
                        <td style="width:100px;text-align:right">ຮັບເງິນສົດ-ບາດ : </td>
                        <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_pay_bath"])?> &nbsp;</td>
                    </tr>
                    <?php }
                    if($sqlBill["list_bill_pay_us"] !="0"){ 
                    ?>
                        <tr>
                            <td></td>
                            <td style="width:100px;text-align:right">ຮັບເງິນສົດ-ໂດຣາ : </td>
                            <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_pay_us"])?> &nbsp;</td>
                        </tr>
                    <?php }
                    if($sqlBill["list_bill_transfer_kip"] !="0"){ 
                    ?>
                        <tr>
                            <td></td>
                            <td style="width:100px;text-align:right">ຮັບເງິນໂອນ-ກີບ : </td>
                            <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_transfer_kip"])?> &nbsp;</td>
                        </tr>
                    <?php }
                    if($sqlBill["list_bill_transfer_bath"] !="0"){ 
                    ?>
                    <tr>
                        <td></td>
                        <td style="width:100px;text-align:right">ຮັບເງິນໂອນ-ບາດ : </td>
                        <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_transfer_bath"])?> &nbsp;</td>
                    </tr>
                    <?php }
                    if($sqlBill["list_bill_transfer_us"] !="0"){ 
                    ?>
                    <tr>
                        <td></td>
                        <td style="width:100px;text-align:right">ຮັບເງິນໂອນ-ໂດຣາ : </td>
                        <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_transfer_us"])?> &nbsp;</td>
                    </tr>
                    <?php }?>
                <?php }else{?>
                    <tr>
                        <td></td>
                        <td style="width:100px;text-align:right">ຮັບເງິນສົດ-ກີບ : </td>
                        <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_pay_kip"])?> &nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width:100px;text-align:right">ຮັບເງິນສົດ-ບາດ : </td>
                        <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_pay_bath"])?> &nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width:100px;text-align:right">ຮັບເງິນສົດ-ໂດຣາ : </td>
                        <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_pay_us"])?> &nbsp;</td>
                    </tr>
                <?php }?>
                <tr>
                    <td></td>
                    <td style="width:100px;text-align:right">ເງິນທອນ : </td>
                    <td style="text-align:right;width:80px;font-weight:bold;font-size:17px"><?php echo @number_format($sqlBill["list_bill_return"])?> &nbsp;</td>
                </tr>
                
            <?php }?>
        </table>

        <table style="border-top:1px solid black">
            <tr>
                <td style="width:150px;text-align:left;font-weight:bold">ບາດ-ກີບ / 1THB</td>
                <td style="width:150px;text-align:right;font-weight:bold">ໂດຣ-ກີບ / 1USD &nbsp;</td>
            </tr>
            <tr>
                <td style="width:150px;text-align:left;"><?php echo @number_format($sqlRate["ex_bath_kip"])?> ກີບ</td>
                <td style="width:150px;text-align:right;"><?php echo @number_format($sqlRate["ex_dolar_kip"])?> ກີບ &nbsp;</td>
            </tr>
        </table>
        <center>
        <span class="centered">( ຂອບໃຈລູກຄ້າທຸກໆທ່ານທີ່ມາອຸດໜຸນ )</span>
        </center>
    </div>
</body>

</html>