<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
$db = new DBConnection();
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
            .page-break { page-break-inside: avoid; page-break-before: always; }
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
    <?php 
        $sqlPreview=$db->fn_read_all("view_orders WHERE order_list_bill_fk='".base64_decode($_GET["bill_no"])."' AND order_list_status_order='2'");
        foreach($sqlPreview AS $rowPreview){
    ?>
        <div class="ticket page-break">
            <p class="text_light" style="font-size: 28px !important;">ເບີໂຕະ : <?php echo $rowPreview["table_name"]?></p>
            <p class="text_light" style="font-size: 14px !important;">ວັນທີ່ຄົວ : <?php echo date("d/m/Y h:i")?></p>
            <table class="tbname">
                <!-- <thead>
                    <tr class="trname" style="font-size: 14px !important;">
                        <th class="description thname">#ລາຍການ</th>
                    </tr>
                </thead> -->
                <tbody>
                    <tr class="trname" style="border-bottom: 1px dotted black;page-break-after: always;break-inside: avoid !important;page-break-inside: avoid !important;">
                        <td class="tdname" style="font-size: 18px !important;">
                            <?php echo $rowPreview["product_name"]?> <?php echo $rowPreview["size_name_la"]?> &nbsp;&nbsp; x &nbsp; &nbsp;<?php echo $rowPreview["order_list_order_qty"]?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php }
        $sqlOrderList = $db->fn_read_all("res_orders_list WHERE order_list_bill_fk='" . base64_decode($_GET["bill_no"]) . "'
        GROUP BY order_list_pro_code_fk Having COUNT(order_list_pro_code_fk) > 1");
        if(COUNT($sqlOrderList)>0){
            foreach($sqlOrderList as $OrderList){
                $checkOrder=$db->fn_read_single("order_list_pro_code_fk,SUM(order_list_order_qty)as sum_qty,
                SUM(order_list_order_total)as sum_amount,
                SUM(order_list_discount_total)as sum_total,
                SUM(order_list_qty_promotion_all)as sum_pro_amount,
                SUM(order_list_qty_promotion_gif)as sum_pro_gif,
                SUM(order_list_qty_promotion_gif_total)as sum_pro_total","res_orders_list 
                WHERE order_list_bill_fk='" . base64_decode($_GET["bill_no"]) . "' 
                AND order_list_pro_code_fk='".$OrderList["order_list_pro_code_fk"]."'");
                foreach($checkOrder as $rowOrder){
                    $sql = "order_list_order_qty='" . $rowOrder["sum_qty"] . "',
                    order_list_order_total='" . $rowOrder["sum_amount"] . "',
                    order_list_discount_total='" . $rowOrder["sum_total"] ."',
                    order_list_qty_promotion_all='" . $rowOrder["sum_pro_amount"] ."',
                    order_list_qty_promotion_gif='" . $rowOrder["sum_pro_gif"] ."',
                    order_list_qty_promotion_gif_total='" . $rowOrder["sum_pro_total"] ."',
                    order_list_discount_percented='0',
                    order_list_discount_percented_name='0',
                    order_list_discount_price='0'
                    WHERE order_list_bill_fk='" . base64_decode($_GET["bill_no"]) . "'
                    AND order_list_pro_code_fk='".$rowOrder["order_list_pro_code_fk"]."'";
                    $editOrder = $db->fn_edit("res_orders_list", $sql);
                    
                    $sqlDelete=$db->fn_delete("res_orders_list WHERE order_list_bill_fk='".base64_decode($_GET["bill_no"])."' 
                    AND order_list_pro_code_fk='".$rowOrder["order_list_pro_code_fk"]."' AND order_list_status_order='2' ");

                }
            }
        }
        $sql = "order_list_status_order='5' WHERE order_list_bill_fk='" . base64_decode($_GET["bill_no"]) . "' AND  order_list_status_order='2'";
        $sqlEdit = $db->fn_edit("res_orders_list", $sql);
    ?>
    
</body>

</html>