<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    if(isset($_GET["report"])){
        $query="";
        if($_POST["start_date"] !="" && $_POST["end_date"] !=""){
            @$query.=" WHERE check_bill_list_date BETWEEN '".$_POST["start_date"]."' AND '".$_POST["end_date"]."' ";
        }else{
            @$query.="";
        }

        if($_POST["search_branch"] !=""){
            @$query.="AND check_bill_list_branch_fk='".$_POST["search_branch"]."' ";
        }else{
            if($_SESSION["user_permission_fk"]=="202300000002"){
                $query.="";
            }else{
                $query.="AND check_bill_list_branch_fk='".$_SESSION["user_branch"]."'";
            }
        }

        if($_POST["type_cate"] !=""){
            @$query.=" AND check_bill_list_status='".$_POST["type_cate"]."'";
        }else{
            @$query.="";
            
        }

        if($_POST["orderBy"]=="1"){
            $query.=" ORDER BY sumQty DESC";
        }else{
            $query.=" ORDER BY amounts DESC";
        }


        $sql=$db->fn_read_all("view_bast_sale $query");
        $i=1;
        $sumQty=0;
        $sumTotal=0;
        $data = array();
            if(count($sql)>0){
                foreach($sql as $rowSql){
                    $data[] = $rowSql;
                }
            }

            $response = array('rowCount' =>count($sql), 'data' => $data);
            echo json_encode($response);
        }
?>