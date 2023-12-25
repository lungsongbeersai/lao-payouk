<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
$query="";
if (isset($_GET["edit_bill_list"])) {
    $delete_list = $db->fn_edit("res_check_bill", "list_bill_status='2',list_bill_remark='" . $_POST["list_bill_remark"] . "',list_bill_cancel_by='" . $_POST["list_bill_cancel_by"] . "',list_bill_cancel_date='" . date("Y-m-d h:i:sa") . "' WHERE list_bill_no='" . $_POST["bill_no"] . "'");
    if ($delete_list) {
        echo json_encode(array("statusCode" => 200));
    } else {
        echo json_encode(array("statusCode" => 201));
    }
    exit;
}

if (isset($_GET["edit_bill"])) {
    @$query .= "view_daily_report_group";

    if ($_POST["start_date"] != "" && $_POST["end_date"] != "") {
        $query .= " WHERE list_bill_date BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' ";
    } else {
        $query .= "";
    }

    if ($_POST["search_page"] != "") {
        $sqlCheck = $db->fn_fetch_rowcount("res_bill WHERE bill_code LIKE '%" . $_POST["search_page"] . "%' ");
        if ($sqlCheck > 0) {
            $query .= " AND list_bill_no LIKE '%" . $_POST["search_page"] . "%'";
        } else {
            $sqlCheck1 = $db->fn_fetch_rowcount("res_tables WHERE table_name LIKE '%" . $_POST["search_page"] . "%' ");
            if ($sqlCheck1 > 0) {
                $query .= " AND table_name LIKE '%" . $_POST["search_page"] . "%'  ";
            } else {
                $query .= "AND table_name='123578lkujjsdfsd' ";
            }
        }
    } else {
        $query .= "";
    }


    if ($_POST["search_branch"] != "") {
        $query .= "AND list_bill_branch_fk='" . $_POST["search_branch"] . "'";
    } else {
        $query .= "";
    }


    $query .= " AND list_bill_status='1' ORDER BY list_bill_date DESC ";


    $fetch_sql = $db->fn_read_all($query);
    $total_data = $db->fn_fetch_rowcount($query);
    if($total_data>0){
        $data=[];
        foreach($fetch_sql as $row){
            if (date("Y-m-d", strtotime("-2 day"))>=$row['list_bill_date']) {
                $color_text="text-dark";
                $disabled = "selected";
                $colors="bg-danger";
                $icon='<i class="fa fa-times"></i>';
                $text_icon='ແກ້ໄຂບໍ່ໄດ້';
            } else {
                $color_text="text-light";
                $disabled = "in-use";
                $colors="bg-success";
                $icon='<i class="fa fa-check"></i>';
                $text_icon='ແກ້ໄຂໄດ້';
            }
            $data[]=[
                "list_bill_no"=>$row['list_bill_no'],
                "bill_no"=>base64_encode($row['list_bill_no']),
                "table_id"=>base64_encode($row['table_code']),
                "table_code"=>$row['table_code'],
                "list_bill_qty"=>$row['list_bill_qty'],
                "list_bill_amount"=>$row['list_bill_amount'],
                "table_name"=>$row['table_name'],
                "list_bill_date_time"=>$row['list_bill_date_time'],
                "branch_name"=>$row['branch_name'],
                "color_text"=>$color_text,
                "status_disabled"=> $disabled,
                "status_color"=> $colors,
                "status_icon"=> $icon,
                "status_text"=> $text_icon,
            ];
        }
        echo json_encode(["rowCount"=>$total_data,"data"=> $data]);
    }else{
        echo json_encode(["rowCount"=>$total_data]);
    }
    exit;
}

if (isset($_GET["cancel_bill"])) {
    $query="";
    @$query .= "view_daily_report_group WHERE list_bill_branch_fk='" . $_SESSION["user_branch"] . "' AND list_bill_date > DATE(NOW()) - INTERVAL 2 DAY";
    if ($_POST["search_page"] != "") {
        $sqlCheck = $db->fn_fetch_rowcount("res_bill WHERE bill_code LIKE '%" . $_POST["search_page"] . "%' ");
        if ($sqlCheck > 0) {
            $query .= " AND list_bill_no LIKE '%" . $_POST["search_page"] . "%'";
        } else {
            $query .= "AND list_bill_no='123578lkujjsdfsd' ";
        }
    } else {
        $query .= "";
    }

    $query .= " AND list_bill_status='1' ORDER BY list_bill_no DESC ";

    $fetch_sql = $db->fn_read_all($query);
    $total_data = $db->fn_fetch_rowcount($query);
    $sqlLimit=$db->fn_fetch_single_all($query);
    if($total_data>0){
        $data=[];
        foreach($fetch_sql as $row){
            $color_text="text-light";
            $disabled = "in-use";
            $colors="bg-success";
            $icon='<i class="fa fa-check"></i>';
            $text_icon='ຍົກເລີກໄດ້';
            $data[]=[
                "list_bill_no"=>$row['list_bill_no'],
                "bill_no"=>base64_encode($row['list_bill_no']),
                "table_id"=>base64_encode($row['table_code']),
                "table_code"=>$row['table_code'],
                "list_bill_qty"=>$row['list_bill_qty'],
                "list_bill_amount"=>$row['list_bill_amount'],
                "table_name"=>$row['table_name'],
                "list_bill_date_time"=>$row['list_bill_date'],
                "branch_name"=>$row['branch_name'],
                "color_text"=>$color_text,
                "status_disabled"=> $disabled,
                "status_color"=> $colors,
                "status_icon"=> $icon,
                "status_text"=> $text_icon,
            ];
        }
        echo json_encode(["rowCount"=>$total_data,"data"=> $data,"limit_row"=>$sqlLimit["list_bill_no"]]);
    }else{
        echo json_encode(["rowCount"=>$total_data]);
    }
    exit;
}

if(isset($_GET["active_bill"])){
    $data=[];
    $fetch_sql=$db->fn_read_all("view_daily_report_list WHERE check_bill_list_bill_fk='".$_POST["billID"]."' ");
    foreach($fetch_sql as $row){
        $data[]=[
            "product_images"=>$row["product_images"],
            "check_bill_list_bill_fk"=>$row["check_bill_list_bill_fk"],
            "check_bill_list_discount_status"=>$row["check_bill_list_discount_status"],
            "check_bill_list_discount_price"=>$row["check_bill_list_discount_price"],
            "check_bill_list_order_total"=>$row["check_bill_list_order_total"],
            "check_bill_list_pro_price"=>$row["check_bill_list_pro_price"],
            "check_bill_list_discount_total"=>$row["check_bill_list_discount_total"],
            "check_bill_list_order_qty"=>$row["check_bill_list_order_qty"],
            "product_name"=>$row["product_name"],
            "size_name_la"=>$row["size_name_la"],
            "check_bill_list_note_remark"=>$row["check_bill_list_note_remark"],
            "table_name"=>($row["table_name"]),
            "check_bill_list_table_fk"=>$row["check_bill_list_table_fk"],
            "table_convert"=>base64_encode($row["check_bill_list_table_fk"]),
            "bill_convert"=>base64_encode($row["check_bill_list_bill_fk"]),
        ];
    }
    echo json_encode(["data"=>$data]);
}

?>