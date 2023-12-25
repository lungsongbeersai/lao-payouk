<?php
session_start();
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');
$dateTime = date('Y-m-d H:i:s');
include_once("db.php");
$db = new DBConnection();
if (isset($_GET["addProduct"])) {

    if ($_POST["order_list_status_order_s"] == "1") {
        $statusOrders = "1";
    } else {
        $statusOrders = "0";
    }

    $price = $_POST["txtPrice"];
    $qty = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $qtyGif = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) + floatval($_POST["txtProGif"]);

    // $checkOrders=$db->fn_fetch_single_all("res_orders_list WHERE order_list_pro_code_fk='".$_POST["txtDetailCode"]."' AND order_list_status='2'");
    // $sumQty_compare=($qtyGif+@$checkOrders["order_list_order_qty"]);
    // $check_detail=$db->fn_fetch_single_all("view_product_list WHERE pro_detail_code='".$_POST["txtDetailCode"]."' AND product_cut_stock='2'");

    // if($sumQty_compare>$check_detail["pro_detail_qty"]){
    //     echo json_encode(400);
    //     exit;
    // }


    $where = "WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' 
    AND order_list_branch_fk='" . $_POST["user_branch"] . "' 
    AND order_list_pro_code_fk='" . $_POST["txtDetailCode"] . "' 
    AND order_list_status_promotion='" . $_POST["txtStatusPro"] . "'
    AND order_list_status_order='0'";
    $sqlCount = $db->fn_fetch_rowcount("res_orders_list $where ");
    if ($sqlCount > 0) {
        $sqlCheck = $db->fn_fetch_single_all("res_orders_list $where ");
        if ($_POST["txtStatusPro"] == "2") {
            $sqlOrderQty = "order_list_order_qty=order_list_order_qty+'" . $qty . "',order_list_order_total=order_list_order_total+'" . $price . "',
            order_list_discount_total=order_list_discount_total+'" . $price . "'-'" . $sqlCheck["order_list_discount_price"] . "',
            order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["txtProGif"] . "',
            order_list_note_remark='" . $_POST["order_list_note_remark"] . "' $where";
            $editOrderQty = $db->fn_edit("res_orders_list", $sqlOrderQty);
        } else {
            $sqlOrderQty = "order_list_order_qty=order_list_order_qty+'" . $qty . "',order_list_order_total=order_list_order_qty*'" . $price . "',
            order_list_discount_total=order_list_order_qty*'" . $price . "'-'" . $sqlCheck["order_list_discount_price"] . "',
            order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["txtProGif"] . "',
            order_list_note_remark='" . $_POST["order_list_note_remark"] . "' $where";
            $editOrderQty = $db->fn_edit("res_orders_list", $sqlOrderQty);
        }

        echo json_encode(300);
    } else {
        $sqlCountBill = $db->fn_fetch_rowcount("res_bill WHERE bill_code='" . $_POST["bill_no"] . "' AND bill_q='0' ");
        if ($sqlCountBill == "1") {
            $auto_q = $db->fnNumber("bill_q", "res_bill");
            $sqlQ = "bill_date_create='" . date("Y-m-d") . "',bill_q='" . $auto_q . "' WHERE bill_code='" . $_POST["bill_no"] . "'";
            $editQ = $db->fn_edit("res_bill", $sqlQ);
        }

        $editTAbleStatus = $db->fn_edit("res_tables", "table_status='2' WHERE table_code='" . $_POST["table_no"] . "' AND table_branch_fk='" . $_POST["user_branch"] . "'");

        $auto_number = $db->fn_autonumber("order_list_code", "res_orders_list");

        
        if ($_POST["txtStatusPro"] == "2") {
            if ($_POST["order_list_pro_qty"] == $_POST["txtProJing"]) {
                $total = ($price);
            } else {
                $total = ($_POST["order_list_pro_qty"] / $_POST["txtProJing"]) * ($price);
            }
        } else {
            $total = $price * filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }


        if (@$_POST["product_notify1"] == "2") {
            $notifyStatus = "1";
        } else {
            $notifyStatus = "2";
        }

        if ($_POST["userOrder"] == "1") {
            // ສົ່ງຈາກຫນ້າບ້ານ
            $userid = $_SESSION["users_id"];
        } else {
            // ສົ່ງຈາກແອັບ
            $userid = $_POST["users_id"];
        }

        $sqlStock = $db->fn_fetch_rowcount("res_products_detail WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND pro_detail_qty>=0 ");
        if ($sqlStock) {
            $sql = "'" . $auto_number . "',
                '" . date("Y-m-d h:i:sa") . "',
                '" . date("Y-m-d") . "',
                '" . $_POST["user_branch"] . "',
                '" . $_POST["bill_no"] . "',
                '" . $_POST["table_no"] . "',
                '" . $_POST["table_no"] . "',
                '" . $_POST["txtDetailCode"] . "',
                '" . $price . "',
                '" . $qty . "',
                '" . $total . "',
                '" . $_POST["txtStatusPro"] . "',
                '" . $_POST["txtProJing"] . "',
                '" . $_POST["txtGifDefault"] . "',
                '" . $_POST["txtProGif"] . "',
                '1',
                '',
                '',
                '',
                '" . $total . "',
                '" . $_POST["txtCutStock"] . "',
                '" . $statusOrders . "',
                '" . $_POST["order_list_note_remark"] . "','" . $notifyStatus . "','" . $notifyStatus . "','1','" . $userid . "'";
            $insert = $db->fn_insert("res_orders_list", $sql);
            if ($insert) {
                echo json_encode(200);
            } else {
                echo json_encode(201);
            }
        } else {
            echo json_encode(201);
        }
    }
}

if (isset($_GET["chang_qty"])) {
    //check Stock
    $Qty = $_POST["plusQty"];
    if ($_POST["plus_"] == "plus") {
        $sqlPlus = "order_list_order_qty=order_list_order_qty+'" . $Qty . "',
        order_list_order_total=order_list_order_qty*order_list_pro_price,
        order_list_discount_total=(order_list_order_qty*order_list_pro_price-'" . $_POST["discount_price"] . "'),
        order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["qty_promotion_gif"] . "'
        WHERE order_list_code='" . $_POST["order_id"] . "' AND order_list_status_order='0'";
        $editOrder = $db->fn_edit("res_orders_list", $sqlPlus);
    }else{
        $sqlMinus = "order_list_order_qty=order_list_order_qty-'" . $Qty . "',
        order_list_order_total=order_list_order_qty*order_list_pro_price,
        order_list_discount_total=(order_list_order_qty*order_list_pro_price-'" . $_POST["discount_price"] . "'),
        order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["qty_promotion_gif"] . "'
        WHERE order_list_code='" . $_POST["order_id"] . "' AND order_list_status_order='0'";
        $editOrder = $db->fn_edit("res_orders_list", $sqlMinus);
    }

    $sqlOrder=$db->fn_fetch_single_all("res_orders_list WHERE order_list_code='" . $_POST["order_id"] . "' AND order_list_order_qty=0");
    if($sqlOrder){
        $deleteOrder=$db->fn_delete("res_orders_list WHERE order_list_code='" . $_POST["order_id"] . "'");   
    }
    echo json_encode(200);
}

if(isset($_GET["countQty"])){
    $sqlOrder=$db->fn_fetch_single_field("COUNT(order_list_code)AS countQty","res_orders_list WHERE order_list_bill_fk='" . $_POST["bill_code"] . "' AND order_list_status_order='0'");
    echo json_encode($sqlOrder["countQty"]);
}

if(isset($_GET["countSuccess"])){
    $sqlOrder=$db->fn_fetch_single_field("COUNT(order_list_code)AS countQty","res_orders_list WHERE order_list_branch_fk='".$_POST["user_branch"]."' AND order_list_status_order='4'");
    echo json_encode($sqlOrder["countQty"]);
}

if(isset($_GET["countNotify"])){
    $sqlOrder=$db->fn_fetch_single_field("COUNT(call_id)AS countQty","res_call WHERE call_branch_fk='".$_POST["user_branch"]."' AND call_status='1'");
    echo json_encode($sqlOrder["countQty"]);
}


if(isset($_GET["deleteOrder"])){
    $idCount = "1";
    $fetchCount = $db->fn_fetch_rowcount("res_orders_list  WHERE order_list_bill_fk='" . $_POST["idBill"] . "'");
    if ($idCount >= $fetchCount) {
        $editStatus = $db->fn_edit("res_tables", "table_status='1' WHERE table_code='" . $_POST["idTb"] . "' ");

        $sqlQ = "bill_q='' WHERE bill_code='" . $_POST["idBill"] . "'";
        $editQ = $db->fn_edit("res_bill", $sqlQ);
    }

    $sqlStock = "res_orders_list WHERE order_list_code='" . $_POST["idOrder"] . "'";
    $deleteOrder = $db->fn_delete($sqlStock);
    if ($deleteOrder) {
        echo json_encode(200);
    }
}

if(isset($_GET["confirmData"])){
    for($j=0;$j<count($_POST["order_list_code"]);$j++){
        $proid=$_POST["order_list_pro_code_fk"][$j];
        $qty=$_POST["order_list_pro_qty"][$j];
        $price=$_POST["order_list_pro_price"][$j];
        $price_total=$_POST["order_list_discount_total"][$j];
        
        if($_POST["order_status"][$j]=="2"){
            $rowData=$db->fn_fetch_single_all("view_product_list WHERE pro_detail_code='".$proid."' AND product_cut_stock='".$_POST["order_status"][$j]."' ");
            if($rowData["pro_detail_qty"]>=$qty){
                $editStock=$db->fn_edit("res_products_detail","pro_detail_qty=pro_detail_qty-'".$qty."' WHERE pro_detail_code='".$proid."' ");
                $orders=$db->fn_edit("res_orders_list","order_list_status_order='2' WHERE order_list_code='".$_POST["order_list_code"][$j]."' ");
                echo json_encode(200);
            }else{
                $totalQty=($rowData["pro_detail_qty"]);
                if($rowData["pro_detail_qty"]>="1"){
                    $editStock=$db->fn_edit("res_products_detail","pro_detail_qty='0',pro_detail_open='1' WHERE pro_detail_code='".$proid."' ");
                    $orders=$db->fn_edit("res_orders_list","order_list_order_qty='".$totalQty."',
                    order_list_order_total=order_list_pro_price*'".$totalQty."',
                    order_list_discount_total=order_list_pro_price*'".$totalQty."',
                    order_list_status_order='2' WHERE order_list_code='".$_POST["order_list_code"][$j]."' ");
                    echo json_encode(202);
                }else{
                    //ໝົດແລ້ວ
                    echo json_encode(300);
                }
            }
        }else{
            $orders=$db->fn_edit("res_orders_list","order_list_status_order='2' WHERE order_list_code='".$_POST["order_list_code"][$j]."' ");
            echo json_encode(200);
        }
    }
}
if(isset($_GET["update_success"])){
    $orders=$db->fn_edit("res_orders_list","order_list_status_order='5' WHERE order_list_code='".$_POST["order_list_code"]."' ");
    echo json_encode(200);
}

if(isset($_GET["call_me"])){
    $rowCount=$db->fn_fetch_rowcount("res_call WHERE call_bill_fk='".$_POST["bill_code"]."' AND call_status='1' ");
    if($rowCount>0){
        $orders=$db->fn_edit("res_call","call_count=call_count+1 WHERE call_bill_fk='".$_POST["bill_code"]."' AND call_status='1' ");
        echo json_encode(201);
    }else{
        $auto_number = $db->fn_autonumber("call_id", "res_call");
        $insert=$db->fn_insert("res_call","'".$auto_number."','".date("Y-m-d")."','".$_POST["user_branch"]."','".$_POST["bill_code"]."','".$_POST["table_code"]."','','1','1',''");
        echo json_encode(200);
    }
}