<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if(isset($_GET["loadOrders"])){
    if($_POST["idStatus"]=="4"){
        $status="AND order_list_status_order IN('4','5') AND order_list_status='1' AND product_notify='2' ORDER BY order_list_code ASC";
    }else{
        $status="AND order_list_status_order='".$_POST["idStatus"]."' AND order_list_status='1' AND product_notify='2' ORDER BY order_list_code ASC";
    }
    $selectCook=$db->fn_read_all("view_orders WHERE order_list_branch_fk='" . @$_SESSION["user_branch"] . "' $status ");
    if(count($selectCook)>0){
        $data=array();
        foreach($selectCook as $rowCook){
            $data[] = $rowCook;
        }
        echo json_encode(array($data));
    }else{
        echo json_encode(201);
    }
}

if(isset($_GET["editStatus"])){
    if($_POST["cookStatus"]=="2"){
        $status="3";
    }elseif($_POST["cookStatus"]=="3"){
        $status="4";
    }elseif($_POST["cookStatus"]=="4"){
        $status="5";
    }
    $editStauts=$db->fn_edit("res_orders_list","order_list_status_order='".$status."' WHERE order_list_branch_fk='" . @$_SESSION["user_branch"] . "' AND order_list_code='".$_POST["cookID"]."' ");
}

if(isset($_GET["countLabel"])){
    $sqlCount2=$db->fn_fetch_single_field("count(case when order_list_status_order='2' AND order_list_status='1' then 1 end) as total2,
    count(case when order_list_status_order='3' AND order_list_status='1' then 1 end) as total3,
    count(case when order_list_status_order IN ('4','5') AND order_list_status='1' then 1 end) as total4","res_orders_list 
    WHERE order_list_branch_fk='" . @$_SESSION["user_branch"] . "' AND order_list_status='1'");
    echo json_encode($sqlCount2);
}

?>