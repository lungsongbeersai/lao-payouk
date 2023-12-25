<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    if(isset($_GET["fetchData"])){
        if($_POST["monthID"]==""){
            $month=" YEAR(list_bill_date)='".$_POST["yearID"]."' AND ";
            $groupby=" GROUP BY YEAR(list_bill_date)";
        }else{
            $month=" MONTH(list_bill_date)='".$_POST["monthID"]."' AND YEAR(list_bill_date)='".$_POST["yearID"]."' AND ";
            $groupby=" GROUP BY MONTH(list_bill_date),YEAR(list_bill_date)";
        }
        $sql=$db->fn_fetch_single_field("MONTH(list_bill_date) AS list_bill_date,
        (SELECT SUM(list_bill_amount_kip) FROM res_check_bill WHERE $month list_bill_type_pay_fk !='4' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."' $groupby)AS total,
        (SELECT SUM(list_bill_amount_kip) FROM res_check_bill WHERE $month list_bill_type_pay_fk='4' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."' $groupby)AS amount_ny",
        "res_check_bill WHERE $month list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."' $groupby");
        echo json_encode($sql);
    }

    if(isset($_GET["fetch_chart"])){
        if($_POST["monthID"]==""){
            $month=" YEAR(list_bill_date)='".$_POST["yearID"]."' AND ";
            $groupby=" GROUP BY MONTH(list_bill_date)";
        }else{
            $month=" MONTH(list_bill_date)='".$_POST["monthID"]."' AND YEAR(list_bill_date)='".$_POST["yearID"]."' AND ";
            $groupby=" GROUP BY MONTH(list_bill_date)";
        }
        $sql="MONTH(list_bill_date) AS monthData,
        SUM(list_bill_amount_kip) AS sumTotal";
        $table="res_check_bill WHERE $month list_bill_status='1' AND list_bill_type_pay_fk !='4' AND list_bill_branch_fk='".$_SESSION["user_branch"]."' $groupby";
        
        $rowCount=$db->fn_fetch_rowcount_single($sql,$table);
        $sqlChart=$db->fn_read_single($sql,$table);
        if($rowCount>0){
            foreach($sqlChart as $row){
                $data[]=$row;
            }
            echo json_encode($data);
        }else{
            echo json_encode($rowCount);
        }
    }

?>