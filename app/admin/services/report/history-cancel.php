<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    if(isset($_GET["history"])){
        $limit = $_POST["limit"];
        $page = 1;
        if (@$_POST['page'] > 1) {
            $start = (($_POST['page'] - 1) * $limit);
            $page = $_POST['page'];
        } else {
            $start = 0;
        }

        @$query.="view_daily_report_group";

        if($_POST["start_date"] !="" && $_POST["end_date"] !=""){
            $query.=" WHERE list_bill_date BETWEEN '".$_POST["start_date"]."' AND '".$_POST["end_date"]."' ";
        }else{
            $query.="";
        }

        if($_POST["search_page"] !=""){
            $sqlCheck=$db->fn_fetch_rowcount("res_bill WHERE bill_code LIKE '%".$_POST["search_page"]."%' ");
            if($sqlCheck>0){
                $query.=" AND list_bill_no LIKE '%".$_POST["search_page"]."%'";
            }else{
                $sqlCheck1=$db->fn_fetch_rowcount("res_tables WHERE table_name LIKE '%".$_POST["search_page"]."%' ");
                if($sqlCheck1>0){
                    $query.=" AND table_name LIKE '%".$_POST["search_page"]."%'  ";
                }else{
                    $query.="AND table_name='232sdsfeer2222'";
                }
            }
        }else{
            $query.="";
        }

        if($_POST["search_branch"] !=""){
            $query.="AND list_bill_branch_fk='".$_POST["search_branch"]."'";
        }else{
            if($_SESSION["user_permission_fk"]=="202300000002"){
                $query.="";
            }else{
                $query.="AND list_bill_branch_fk='".$_SESSION["user_branch"]."'";
            }
            
        }


        $query.=" AND list_bill_status='2' ORDER BY list_bill_no ".$_POST['order_page']." ";

        if ($_POST["limit"] != "") {
            $filter_query = $query.' LIMIT '.$start.', '.$limit.'';
        } else {
            $filter_query = $query;
        }

        $fetch_sql=$db->fn_read_all($filter_query);
        $array=[];
        foreach($fetch_sql as $row_sql){
            $array[]=$row_sql;
        }

        echo json_encode(array($array));
    }
?>