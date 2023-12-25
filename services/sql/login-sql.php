<?php session_start();
    include_once("../../api/db.php");
    $db = new DBConnection();
    $sql="view_users WHERE users_name='".$_POST["users_name"]."' AND users_password='".$_POST["users_password"]."' AND user_status_check_login='on' ";
    $check_login=$db->fn_fetch_single_all($sql);
    if($db->fn_fetch_rowcount($sql)){
        $_SESSION["users_id"]=$check_login["users_id"];
        $_SESSION["users_name"]=$check_login["users_name"];
        $_SESSION["branch_name"]=$check_login["branch_name"];
        $_SESSION["user_store_fk"]=$check_login["user_store_fk"];
        $_SESSION["user_branch"]=$check_login["user_branch_fk"];
        $_SESSION["user_permission_fk"]=$check_login["user_permission_fk"];
        $_SESSION["user_status_check_login"]=$check_login["user_status_check_login"];
        $_SESSION["store_img"]=$check_login["store_img"];
        $_SESSION["store_name"]=$check_login["store_name"];
        $_SESSION['myApp']=1;

        if($check_login["user_permission_fk"]=="202300000003"){
            //ພະນັກງານເສີບ
            echo json_encode(array("statusCode" => 500));
        }else if($check_login["user_permission_fk"]=="202300000004"){
            //ຄົວ
            echo json_encode(array("statusCode" => 501));
        }else if($check_login["user_permission_fk"]=="202300000005"){
            //ບານໍ້າ
            echo json_encode(array("statusCode" => 502));
        }else{
            //Admin
            echo json_encode(array("statusCode" => 200));
        }
    }else{
        $sql1="res_users WHERE users_password='".$_POST["users_password"]."' AND user_status_check_login='off' ";
        $check_login1=$db->fn_fetch_single_all($sql1);
        if($db->fn_fetch_rowcount($sql1)){
            echo json_encode(array("statusCode" => 201));
        }else{
            echo json_encode(array("statusCode" => 202));
        }
    }
?>