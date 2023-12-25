<?php 
    session_start();
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json; charset=utf-8');
    date_default_timezone_set('Asia/Bangkok');
    $dateTime=date('Y-m-d H:i:s');
    include_once("db.php");
    $db = new DBConnection();
    if(isset($_GET["menu_list"])){
        // $sqlCount = $db->fn_fetch_rowcount("res_bill WHERE bill_branch='" . $_POST["user_branch"] . "' AND bill_table='" . $_POST["table_code"] . "' AND bill_status='1'");
        // if ($sqlCount == 0) {
        //     $auto_number = $db->fn_autonumber("bill_code", "res_bill");
        //     $auto_q = $db->fnNumber("bill_q", "res_bill");
        //     $sqlAuto = "'" . $auto_number . "','" . $_POST["table_code"] . "','" . $_POST["user_branch"] . "','1','".date("Y-m-d")."','".$auto_q."'";
        //     $insertBill = $db->fn_insert("res_bill", $sqlAuto);
        // }

        if($_POST["cate_id"] !="0"){
            $cate_id=" WHERE cate_code='".$_POST["cate_id"]."'";
        }else{
            $cate_id="";
        }

        $sqlBill=array();
        $sqlBill = $db->fn_fetch_single_all("res_bill WHERE bill_table='" . $_POST["table_code"] . "' AND bill_status='1' ");

        $query=array();
        $sql=$db->fn_read_all("res_category $cate_id ORDER BY cate_code ASC");
        if(count($sql)>0){
            foreach($sql as $rowData){
                $query[] = $rowData;
                $sql=$db->fn_read_all("view_product_list WHERE product_branch='".$_POST["user_branch"]."' 
                AND product_cate_fk='".$rowData["cate_code"]."' ORDER BY pro_detail_code ASC");
                foreach($sql as $rowData1){
                    $query1[] = $rowData1;
                }
            }
            echo json_encode(array($query,$query1,$sqlBill));
            exit;
        }else{
            echo json_encode(201);
            exit;
        }
    }

    if(isset($_GET["menu_search"])){
        
        if($_POST["search_box"] !="0"){
            $search_box=" AND fullnameSize LIKE '%".$_POST["search_box"]."%'";
        }else{
            $search_box="";
        }

        $query=array();
        $sql=$db->fn_read_all("view_product_list WHERE product_branch='".$_POST["user_branch"]."' $search_box ORDER BY pro_detail_code ASC");
        if(count($sql)>0){
            foreach($sql as $rowData1){
                $query[] = $rowData1;
            }
            echo json_encode(array($query));
        }else{
            echo json_encode(201);
            exit;
        }
    }
        

    if(isset($_GET["menu_detail"])){
        $query=array();
        $sql=$db->fn_read_all("view_product_list WHERE pro_detail_code='".$_POST["proID"]."' ORDER BY pro_detail_code ASC");
        foreach($sql as $rowData){
            $query[] = $rowData;
        }
        echo json_encode(array($query));
        exit;
    }

    if(isset($_GET["read_detail"])){
        $query=array();
        $sql=$db->fn_read_all("view_orders WHERE order_list_bill_fk='".$_POST["bill_code"]."' AND order_list_status_order='0' ORDER BY order_list_code DESC");
        $query=array();
        foreach($sql as $rowData){
            $query[] = $rowData;
        }
        echo json_encode(array($query));
        exit;
    }

    if(isset($_GET["read_history"])){
        $query=array();
        $sql=$db->fn_read_all("view_orders WHERE order_list_bill_fk='".$_POST["bill_code"]."' AND order_list_status_order !='0' ORDER BY order_list_code ASC");
        $query=array();
        foreach($sql as $rowData){
            $query[] = $rowData;
        }
        echo json_encode(array($query));
        exit;
    }

    if(isset($_GET["OrderServ"])){
        $query=array();
        $sql=$db->fn_read_all("view_orders WHERE order_list_branch_fk='".$_POST["user_branch"]."' AND order_list_status_order='4' ORDER BY order_list_code ASC");
        $query=array();
        foreach($sql as $rowData){
            $query[] = $rowData;
        }
        echo json_encode(array($query));
        exit;
    }
    

    if(isset($_GET["loadNotify"])){
        $query=array();
        $sql=$db->fn_read_all("view_call WHERE call_branch_fk='".$_POST["user_branch"]."' AND call_status='1' ORDER BY call_id ASC");
        $query=array();
        foreach($sql as $rowData){
            $query[] = $rowData;
        }
        echo json_encode(array($query));
        exit;
    }

    if(isset($_GET["update_status"])){
        $edit=$db->fn_edit("res_call","call_status='2' WHERE call_id='".$_POST["call_id"]."' ");
        echo json_encode(200);
        exit;
    }
