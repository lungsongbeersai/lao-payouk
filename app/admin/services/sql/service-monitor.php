<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if (isset($_GET["fetch_monitor"])) {
    $data = [];
    $query="view_orders WHERE order_list_bill_fk='".$_SESSION["bill_code"]."' 
    AND order_list_branch_fk='".$_SESSION["user_branch"]."'";
    $total_data = $db->fn_fetch_rowcount($query);
    if($total_data>0){
        $fetch_sql = $db->fn_read_all($query);
        foreach ($fetch_sql as $row) {
            $data[] = [
                "product_images" => $row["product_images"],
                "order_list_bill_fk" => $row["order_list_bill_fk"],
                "order_list_discount_status" => $row["order_list_discount_status"],
                "order_list_discount_percented" => $row["order_list_discount_percented"],
                "order_list_discount_percented_name" => $row["order_list_discount_percented_name"],
                "order_list_discount_price" => $row["order_list_discount_price"],
                "order_list_order_total" => $row["order_list_order_total"],
                "order_list_pro_price" => $row["order_list_pro_price"],
                "order_list_discount_total" => $row["order_list_discount_total"],
                "order_list_order_qty" => $row["order_list_order_qty"],
                "product_name" => $row["product_name"],
                "size_name_la" => $row["size_name_la"],
                "order_list_note_remark" => $row["order_list_note_remark"],
                "table_name" => $row["table_name"],
                "order_list_table_fk" => $row["order_list_table_fk"],
                "table_convert" => base64_encode($row["order_list_table_fk"]),
                "bill_convert" => base64_encode($row["order_list_bill_fk"]),
            ];
        }
        echo json_encode(["data" => $data,"rowCount"=>$total_data]);
    }else{
        echo json_encode("201");
    }
}
?>