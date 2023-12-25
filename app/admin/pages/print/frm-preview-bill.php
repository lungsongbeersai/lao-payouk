<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
$db = new DBConnection();

$sqlBranch=$db->fn_fetch_single_all("view_company_title WHERE branch_code='".$_GET["branch_code"]."' ");
$sqlRate = $db->fn_fetch_single_all("res_exchange ORDER BY ex_auto DESC LIMIT 1");
$sqlQ=$db->fn_fetch_single_all("res_bill WHERE bill_code='".base64_decode($_GET["bill_no"])."' ");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>
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
            height: auto !important;
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

<body>

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
                ສາຂາ : <?php echo $sqlBranch["branch_name"];?>
            </p>
        </center>
        <p class="text_light" style="margin-top: -10px !important;">ວັນທີ່ : <?php echo date("d/m/Y h:i",strtotime(date("Y-m-d h:i")));?></p>
        <p class="text_light">ເລກບິນ : <?php echo base64_decode($_GET["bill_no"]);?><span style="float:right"># ຄິວທີ : <?php echo $sqlQ["bill_q"];?>&nbsp;</span></p>
        <p class="text_light">ເບີໂຕະ : <?php echo base64_decode($_GET["tableName"])?> <span style="float:right">ຜູ້ຮັບເງິນ : <?php echo $_SESSION["users_name"];?>&nbsp;</span></p>
        <p class="text_light">ເບີໂທຮ້ານ: <?php echo $sqlBranch["branch_tel"];?></p>
        <p class="centered">
            <center>
                <h2 style="font-size: 18px !important;">ໃບເກັບເງິນ </h2>
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
                    $sqlPreview=$db->fn_read_all("view_orders WHERE order_list_bill_fk='".base64_decode($_GET["bill_no"])."'");
                    foreach($sqlPreview AS $rowPreview){
                        @$amount+=$rowPreview["order_list_discount_total"];
                ?>
                    <tr class="trname" style="border-bottom: 1px dotted black;">
                        <td class="tdname" colspan="2">
                            <?php echo $rowPreview["product_name"]?>
                            <?php
                                    if($rowPreview["order_list_status_promotion"]=="2"){
                                        echo " ( ໂປຣຊື້ ".$rowPreview["order_list_qty_promotion_all"]." ແຖມ ".$rowPreview["order_list_qty_promotion_gif"]." ) ";
                                    }
                                ?>
                            <!-- <br> -->
                            <span>
                                [
                                <?php
                                    if($rowPreview["order_list_status_promotion"]=="1"){
                                        echo $rowPreview["order_list_order_qty"];
                                    }else{
                                        $gif=$rowPreview["order_list_order_qty"]-$rowPreview["order_list_qty_promotion_gif_total"];
                                        echo "ຊື້ ".$gif." ແຖມ ".$rowPreview["order_list_qty_promotion_gif_total"]." = ".$rowPreview["order_list_order_qty"];
                                    }
                                ?>
                                x
                                <?php echo @number_format($rowPreview["order_list_pro_price"])?>
                                ]
                            </span>
                            <span style="float:right">
                                <?php 
                                    if($rowPreview["order_list_discount_status"]=="2"){
                                        echo "<s class='text-danger'>".@number_format($rowPreview["order_list_order_total"])."</s> ".@number_format($rowPreview["order_list_discount_total"])."";
                                    }else{
                                        echo @number_format($rowPreview["order_list_discount_total"])."";
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
                <td rowspan="5">
                    <img src="<?php echo $imagesQr;?>" alt="Logo" style="width: 100px;">
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="width:110px;text-align:right">ລວມທັງໝົດ : </td>
                <td style="text-align:right;width:80px"><?php 
                @$subAmount+=(int)substr($amount,-3);
                if(@$subAmount=="0"){
                    @$subTotal=(@$amount);
                }else{
                    @$subTotal=($amount-$subAmount)+1000;
                }
                echo @number_format($subTotal);?> &nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td style="width:100px;text-align:right">ສ່ວນຫຼຸດ ກີບ : </td>
                <td style="text-align:right;width:80px">
                <?php if($_GET["per_price"] !=""){echo @number_format($_GET["per_price"]);}else{echo "0.0";}?>
                &nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td style="width:100px;text-align:right">ສ່ວນຫຼຸດ % : </td>
                <td style="text-align:right;width:80px">
                <?php if($_GET["per_cented"] !=""){echo @number_format($_GET["per_cented"]);}else{echo "0.0";}?>
                &nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td style="width:100px;text-align:right">ມູນຄ່າຕ້ອງຊໍາລະ : </td>
                <td style="text-align:right;width:80px;font-weight:bold;font-size:17px;"><?php if($_GET["total"] !=""){echo @number_format($_GET["total"]);}else{echo "0.0";}?> &nbsp;</td>
            </tr>
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