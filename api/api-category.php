<?php 
    session_start();
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json; charset=utf-8');
    date_default_timezone_set('Asia/Bangkok');
    $dateTime=date('Y-m-d H:i:s');
    include_once("db.php");
    $db = new DBConnection();
    if(isset($_GET["read_cate"])){
        $sql=$db->fn_read_all("res_category ORDER BY cate_code ASC");
        $query=array();
        foreach($sql as $rowData){
            $query[] = $rowData;
        }
        echo json_encode(array($query));
        exit;
    }
?>

