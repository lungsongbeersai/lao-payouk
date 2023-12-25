<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();

if(isset($_GET["fetch"])){
    $sql=$db->fn_fetch_single_field("list_bill_date,
    (SELECT SUM(list_bill_amount_kip) FROM res_check_bill WHERE list_bill_date='".date("Y-m-d")."' AND list_bill_type_pay_fk !='4' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."')AS total,
    (SELECT SUM(list_bill_pay_kip) FROM res_check_bill WHERE list_bill_date='".date("Y-m-d")."' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."')AS amount_cash_kip,
    (SELECT SUM(list_bill_pay_bath) FROM res_check_bill WHERE list_bill_date='".date("Y-m-d")."' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."')AS amount_cash_bath,
    (SELECT SUM(list_bill_pay_us) FROM res_check_bill WHERE list_bill_date='".date("Y-m-d")."' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."')AS amount_cash_us,
    (SELECT SUM(list_bill_transfer_kip) FROM res_check_bill WHERE  list_bill_date='".date("Y-m-d")."' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."')AS amount_transfer_kip,
    (SELECT SUM(list_bill_transfer_bath) FROM res_check_bill WHERE list_bill_date='".date("Y-m-d")."' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."')AS amount_transfer_bath,
    (SELECT SUM(list_bill_transfer_us) FROM res_check_bill WHERE list_bill_date='".date("Y-m-d")."' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."')AS amount_transfer_us,
    (SELECT SUM(list_bill_return) FROM res_check_bill WHERE list_bill_date='".date("Y-m-d")."' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."')AS return_all,
    (SELECT SUM(list_bill_amount_kip) FROM res_check_bill WHERE list_bill_date='".date("Y-m-d")."' AND list_bill_type_pay_fk='4' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."')AS amount_ny",
    "res_check_bill WHERE list_bill_date='".date("Y-m-d")."' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."' GROUP BY list_bill_date");
    echo json_encode($sql);
}

if(isset($_GET["fetch_list"])){
    $sql=$db->fn_read_single("list_bill_date,
    list_bill_branch_fk,
    COUNT(list_bill_code)AS count_bill,
    SUM(list_bill_pay_kip)AS amount_kip,
    SUM(list_bill_pay_bath)AS amount_bath,
    SUM(list_bill_pay_us)AS amount_us","res_check_bill 
    WHERE DATE_FORMAT(list_bill_date, '%m/%Y')='".$_POST["sort_date"]."' 
    AND list_bill_branch_fk='".$_SESSION["user_branch"]."' GROUP BY list_bill_date ORDER BY list_bill_date DESC");
    $data = array();
    foreach($sql as $row_sql){  
        $data[]=$row_sql;
    }
    echo json_encode($data);
    
}

?>