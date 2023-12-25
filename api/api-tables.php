<?php 
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json; charset=utf-8');
    date_default_timezone_set('Asia/Bangkok');
    $dateTime=date('Y-m-d H:i:s');
    include_once("db.php");
    $db = new DBConnection();
    $branch_id=$_POST["branchID"];
    if (isset($_GET["load_zone"])) {
        if ($_POST["active_item"] == "all") {
            $where = "WHERE table_branch_fk='".$branch_id."'";
        } else {
            if($_POST["active_item"]=="emty"){
                $status="1";
            }else{
                $status="2";
            }
            $where = "WHERE table_status='" . $status . "' AND table_branch_fk='".$branch_id."'";
        } 
        $sql = "res_tables AS A LEFT JOIN res_zone AS B ON A.table_zone_fk=B.zone_code $where ORDER BY table_code ASC";
        $sql = $db->fn_read_all($sql);
        $data=array();
        foreach ($sql as $row_table) {
            $data[]=["table_status"=>$row_table['table_status'],"table_code"=>base64_encode($row_table['table_code']),"table_name_convert"=>base64_encode($row_table['table_name']),"table_name"=>$row_table['table_name']];
        }
        echo json_encode(array($data));
    }
?>