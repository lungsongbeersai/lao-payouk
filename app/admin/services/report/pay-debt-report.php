<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if (isset($_GET["report"])) {
    @$query .= "view_daily_report_group ";

    if(@$_POST["billCode"] !=""){
        $query.="WHERE list_bill_type_pay_fk='4' AND list_bill_status='1' AND list_bill_no='".@$_POST["billCode"]."' AND branch_code='".@$_SESSION["user_branch"]."'";
    }else{
        $query.="WHERE list_bill_type_pay_fk='4' AND list_bill_status='1' AND branch_code='".@$_SESSION["user_branch"]."'";
    }
    $fetch_sql = $db->fn_fetch_single_all($query);
    $total_data = $db->fn_fetch_rowcount($query);
    if($total_data>0){
?>
        <div class="p-3">
            <center>
                <h2 class="mb-3 text-danger"> ☞ ບິນຄ້າງຈ່າຍ ☜</h2>
                <a class="btn btn-warning text-light" style="color:white !important" href="?print_Preview&&list_bill_no=<?php echo base64_encode($_POST["billCode"])?>&&tableName=<?php echo base64_encode( $fetch_sql["table_name"])?>&&branch_code=<?php echo base64_encode($fetch_sql["branch_code"])?>" target="_bank" style="text-decoration:none;color:#825b00 !important">
                    <ion-icon name="print-outline" style="font-size: 20px !important;"></ion-icon><br> ພີມບິນຄືນ
                </a>
            </center>

           

            <h3 class="mb-3">ເລກບິນ : <?php echo $fetch_sql["list_bill_no"]?></h3>
           

            <div class="row">
                <div class="col-sm-8 font_size">
                    <b>ຊື່ລູກຄ້າ</b> : <?php echo $fetch_sql["cus_name"]?> <br>
                    <b>ທີ່ຢູ່ </b>: <?php echo $fetch_sql["cus_address"]?><br>
                    <b>ເບີໂທ </b>: <?php echo $fetch_sql["cus_tel"]?>
                    <input type="text" hidden name="username" id="username" value="<?php echo $fetch_sql["cus_name"]?>">
                    <input type="text" hidden name="list_bill_no" id="list_bill_no" value="<?php echo $fetch_sql["list_bill_no"]?>">
                    <input type="text" hidden name="table_name" id="table_name" value="<?php echo $fetch_sql["table_name"]?>">
                    <input type="text" hidden name="branch_code" id="branch_code" value="<?php echo $fetch_sql["branch_code"]?>">
                    <input type="text" hidden name="list_rate_bat_kip" id="list_rate_bat_kip" value="<?php echo @number_format($fetch_sql["list_rate_bat_kip"])?>">
                    <input type="text" hidden name="list_rate_us_kip" id="list_rate_us_kip" value="<?php echo @number_format($fetch_sql["list_rate_us_kip"])?>">

                </div>
                <div class="col-sm-4 font_size" style="text-align: right;">
                    <b>ພະນັກງານຂາຍ</b> : <?php echo $fetch_sql["users_name"]?><br>
                    <b>ເບີໂຕະ</b> : <?php echo $fetch_sql["table_name"]?><br>
                    <b>ວັນທີ່ຂາຍ</b> : <?php echo date("d/m/Y",strtotime($fetch_sql["list_bill_date"]))?> 
                    <span class="text-danger">( ຄ້າງຈ່າຍ <?php echo round(abs(strtotime(date("Y-m-d")) - strtotime($fetch_sql["list_bill_date"]))/60/60/24);?> ວັນ)</span>
                </div>
            </div>
            <hr class="bg-gray-500" />
            <table class="table text-nowrap table-borderless table-hover">
                <thead>
                    <tr>
                        <td style="width: 50px;" class="text-center">ລໍາດັບ</td>
                        <td style="width: 70px;" class="text-center">ຮູບ</td>
                        <td>ຊື່ລາຍການ</td>
                        <td class="text-center">ລາຄາ</td>
                        <td class="text-center">ຈໍານວນ</td>
                        <td class="text-center">ສ່ວນຫຼຸດ</td>
                        <td class="text-center">ລວມຍອດ</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=1;
                    $sqlDetail=$db->fn_read_all("view_daily_report_list WHERE check_bill_list_bill_fk='".@$_POST["billCode"]."'");
                    foreach($sqlDetail AS $rowDetail){
                        if ($rowDetail["product_images"] != "") {
                            $images = 'assets/img/product_home/' . $rowDetail["product_images"];
                        } else {
                            $images = 'assets/img/logo/259987.png';
                        }
                        @$amount+=$rowDetail["check_bill_list_discount_total"];
                    ?>
                        <tr>
                            <td align="center"><?php echo $i++; ?></td>
                            <td align="center">
                                <img src="<?php echo $images;?>" class="rounded img-fluid" alt="Responsive image">
                            </td>
                            <td><?php echo $rowDetail["product_name"];?> - <?php echo $rowDetail["size_name_la"];?></td>
                            <td align="center"><?php echo @number_format($rowDetail["pro_detail_sprice"]);?> </td>
                            <td align="center"><?php echo @number_format($rowDetail["check_bill_list_order_qty"]);?></td>
                            <td align="center"><?php echo @number_format($rowDetail["check_bill_list_discount_price"]);?></td>
                            <td align="center"><?php echo @number_format($rowDetail["check_bill_list_discount_total"]);?></td>
                        </tr>
                    <?php } ?>
                    <tr style="background-color: #F9F0C5;font-size:18px !important;">
                        <td colspan="6" align="right">ມູນຄ່າຕ້ອງຊໍາລະ</td>
                        <td align="center"><?php echo @number_format($amount);?></td>
                        <input type="text" hidden value="<?php echo ($amount) ?>" id="price_total" name="price_total">
                    </tr>
                </tbody>
            </table>

        </div>
<?php }else{?>
    <center>
        <tr>
            <td>
                <br><br><br><br><br><br>
                <br><br><br><br><br><br>
                <div class="h-100 d-flex align-items-center justify-content-center text-center p-20">
                    <div>
                        <div class="mb-3 mt-n5">
                            <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-danger-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                                <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                            </svg>
                        </div>
                        <h4>ຍັງບໍ່ມີລາຍການ</h4>
                    </div>
                </div>
            </td>
        </tr>
    </center>
<?php } }
    if(isset($_GET["fetchBill"])){
        if(@$_POST["billCode"] !=""){
            $sqlBill="view_daily_report_group WHERE list_bill_type_pay_fk='4' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."' ORDER BY list_bill_no ASC";
            $billLimit="view_daily_report_group WHERE list_bill_type_pay_fk='4' AND list_bill_status='1' AND list_bill_no='".@$_POST["billCode"]."' AND branch_code='".@$_SESSION["user_branch"]."'  ORDER BY list_bill_no ASC";
        }else{
            $sqlBill="";
            $billLimit="view_daily_report_group WHERE list_bill_type_pay_fk='4' AND list_bill_status='1' ORDER BY list_bill_no ASC LIMIT 1";
        }
        $fetch_debt = $db->fn_read_all($sqlBill);
        $total_data = $db->fn_fetch_rowcount($sqlBill);
        $fetch_sql = $db->fn_fetch_single_all($billLimit);
        if($total_data>0){
            foreach($fetch_debt as $row_sql){
                if($row_sql["list_bill_no"]==$fetch_sql["list_bill_no"]){
                    $active="active";
                }else{
                    $active="";
                }
                $sqlCount=$db->fn_fetch_rowcount("res_check_bill_list WHERE check_bill_list_bill_fk='".$row_sql["list_bill_no"]."'");
?>
    <li class="<?php echo $active;?> list_bill_no" style="font-size: 14px;" id="<?php echo $row_sql["list_bill_no"]?>" onclick="loadDebt('<?php echo $row_sql['list_bill_no']?>')">
        <a href="#">
            <ion-icon name="checkmark-circle-outline" class="fa-lg fa-fw me-2"></ion-icon> <?php echo $row_sql["list_bill_no"]?>
            <span class="badge bg-dark-600 fs-10px rounded-pill ms-auto fw-bolder pt-4px pb-5px px-8px"><?php echo $sqlCount?></span>
        </a>
    </li>
<?php } } echo "<br>";}
    if(isset($_GET["fetchSearch"])){
        if(@$_POST["billCode"] !=""){
            $sqlBill="view_daily_report_group WHERE list_bill_type_pay_fk='4' AND list_bill_status='1' AND list_bill_no='".@$_POST["billCode"]."' AND branch_code='".@$_SESSION["user_branch"]."' ORDER BY list_bill_no ASC";
            $billLimit="view_daily_report_group WHERE list_bill_type_pay_fk='4' AND list_bill_status='1' AND list_bill_no='".@$_POST["billCode"]."' AND branch_code='".@$_SESSION["user_branch"]."' ORDER BY list_bill_no ASC";
        }else{
            $sqlBill="view_daily_report_group WHERE list_bill_type_pay_fk='4' AND list_bill_status='1' AND list_bill_no='".@$_POST["billCode"]."' AND branch_code='".@$_SESSION["user_branch"]."' ORDER BY list_bill_no ASC";
            $billLimit="view_daily_report_group WHERE list_bill_type_pay_fk='4' AND list_bill_status='1' ORDER BY list_bill_no ASC LIMIT 1";
        }
        $fetch_debt = $db->fn_read_all($sqlBill);
        $total_data = $db->fn_fetch_rowcount($sqlBill);
        $fetch_sql = $db->fn_fetch_single_all($billLimit);
        if($total_data>0){
            foreach($fetch_debt as $row_sql){
                if($row_sql["list_bill_no"]==$fetch_sql["list_bill_no"]){
                    $active="active";
                }else{
                    $active="";
                }
                $sqlCount=$db->fn_fetch_rowcount("res_check_bill_list WHERE check_bill_list_bill_fk='".$row_sql["list_bill_no"]."'");
?>
    <li class="<?php echo $active;?> list_bill_no" style="font-size: 14px;" id="<?php echo $row_sql["list_bill_no"]?>" onclick="loadDebt('<?php echo $row_sql['list_bill_no']?>')">
        <a href="#">
            <ion-icon name="checkmark-circle-outline" class="fa-lg fa-fw me-2"></ion-icon>
            <?php echo $row_sql["list_bill_no"]?>
            <span class="badge bg-dark-600 fs-10px rounded-pill ms-auto fw-bolder pt-4px pb-5px px-8px"><?php echo $sqlCount?></span>
        </a>
    </li>
<?php } } echo "<br>";}
    if(isset($_GET["editStatus"])){
        $edit_bill=$db->fn_edit("res_check_bill",
        "list_bill_type_pay_fk='".$_POST["list_bill_type_pay_fk"]."',
        list_bill_pay_kip='".filter_var($_POST["list_pay_kip"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)."',
        list_bill_pay_bath='".filter_var($_POST["list_bill_pay_bath"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)."',
        list_bill_pay_us='".filter_var($_POST["list_bill_pay_us"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)."',
        list_bill_transfer_kip='".filter_var($_POST["transfer_kip"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)."',
        list_bill_transfer_bath='".filter_var($_POST["transfer_bath"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)."',
        list_bill_transfer_us='".filter_var($_POST["transfer_us"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)."',
        list_bill_return='".filter_var($_POST["list_bill_return"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)."',
        list_bill_status='1',list_bill_status_ny='2' WHERE list_bill_no='".$_POST["bill_no1"]."' ");
        
        $edit_status=$db->fn_edit("res_ny","ny_user_fk='".$_SESSION["users_id"]."',ny_payment_date='".date("Y-m-d")."',ny_status='2' WHERE ny_bill_fk='".$_POST["bill_no1"]."' ");
        // $autoid = $db->fnBillNumber("ny_code", "res_ny");
        // $insert=$db->fn_insert("res_ny","'".$autoid."','".$_POST["bill_no1"]."','".$_SESSION["users_id"]."','".date("Y-m-d")."','1'");

        if($edit_status){
            echo json_encode(array("statusCode"=>200));
        }
        
    }
?>