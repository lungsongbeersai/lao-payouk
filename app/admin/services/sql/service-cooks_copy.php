<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if(isset($_GET["loadOrders"])){
?>
    <div class="pos pos-stock" id="pos-stock">
        <div class="pos-stock-body">
            <div class="pos-stock-content">
                <div class="pos-stock-content-container">
                    <div class="row gx-0">
                        <?php 
                            $i=1;
                            if($_POST["idStatus"]=="4"){
                                $status="AND order_list_status_order IN('4','5')";
                            }else{
                                $status="AND order_list_status_order='".$_POST["idStatus"]."'";
                            }
                            $selectCook=$db->fn_read_all("view_orders WHERE order_list_branch_fk='" . @$_SESSION["user_branch"] . "' 
                            $status AND order_list_status='1' AND product_notify='2' ORDER BY order_list_code ASC");
                            if(count($selectCook) >0){
                            foreach($selectCook as $selectCook){
                                if ($selectCook["product_images"] != "") {
                                    $images = '../../api/images/product_home/' . $selectCook["product_images"];
                                } else {
                                    $images = '../../api/images/logo/no_image.png';
                                }
                        ?>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            <div class="pos-stock-product">
                                <div class="pos-stock-product-container">
                                    <div class="product">
                                        <div class="product-img">
                                            <div class="img" style="background-image: url(<?php echo $images;?>);">
                                                <span style="background-color: #000000;color:white;padding:4px;"> # ຄິວທີ : <span style="font-size:14px;"><?php echo $selectCook["bill_q"]?> </span> </span>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="title">
                                                <?php echo $selectCook["product_name"]?><?php echo $selectCook["size_name_la"]?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; x &nbsp;&nbsp;<?php echo $selectCook["order_list_order_qty"]?>
                                            </div>
                                            <div class="desc">
                                                ໝາຍເຫດ : <span class="text-danger"><?php echo $selectCook["order_list_note_remark"]?></span>
                                            </div>
                                            <div class="product-option">
                                                <div class="option">
                                                    <div class="option-label">✔ ເບີໂຕະ:</div>
                                                    <div style="font-weight:bold;text-align:right !important;width:100%;font-size:16px;">
                                                        <?php echo $selectCook["table_name"]?>
                                                    </div>
                                                </div>
                                                <div class="option" style="margin-top: -10px;">
                                                    <div class="option-label">✔ ລໍາດັບ:</div>
                                                    <div class="b" style="font-weight:bold;text-align:right !important;width:100%;font-size:16px;">
                                                        <span class="badge bg-primary text-light"><?php echo $i++;?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-action">
                                            
                                            <?php 
                                                if($selectCook["order_list_status_order"]=="2"){
                                            ?>
                                                <!-- <button type="button" class="btn btn-orange"><i class="fa fa-times fa-fw"></i> ຍົກເລີກອໍເດີ</button> -->
                                                <button type="button" class="btn btn-primary" onclick="fnConfirm('<?php echo $selectCook['order_list_code']?>','2')"><i class="fas fa-spinner fa-spin fa-fw"></i> ເລີ່ມຄົວ</button>
                                            <?php }else if($selectCook["order_list_status_order"]=="3"){?>
                                                <!-- <button type="button" class="btn btn-default" disabled><i class="fa fa-times fa-fw"></i> ຍົກເລີກອໍເດີ</button> -->
                                                <button type="button" class="btn btn-primary" onclick="fnConfirm('<?php echo $selectCook['order_list_code']?>','3')"><i class="fa fa-check fa-fw fa-shake"></i> ເສີບອາຫານ</button>
                                            <?php }else if($selectCook["order_list_status_order"]=="4"){  
                                            ?>
                                                <!-- <button type="button" class="btn btn-default text-danger" onclick="fnConfirm('<?php echo $selectCook['order_list_code']?>','4')">
                                                    <i class="fa fa-check fa-fw"></i> ກົດຢືນຢັນອໍເດີ
                                                </button> -->
                                                <button type="button" class="btn btn-orange"><i class="fa fa-check fa-fw"></i> ລໍຖ້າຢືນຢັນເສີບ</button>
                                                
                                            <?php }else if($selectCook["order_list_status_order"]=="5"){?>
                                                <!-- <button type="button" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> ສໍາເລັດແລ້ວ</button> -->
                                                <center>
                                                    <div class="pe-1 text-success">
                                                        <svg width="4em" height="4em" viewBox="0 0 16 16" class="bi bi-check2-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                                            <path fill-rule="evenodd" d="M8 2.5A5.5 5.5 0 1 0 13.5 8a.5.5 0 0 1 1 0 6.5 6.5 0 1 1-3.25-5.63.5.5 0 1 1-.5.865A5.472 5.472 0 0 0 8 2.5z" />
                                                        </svg>
                                                    </div>
                                                </center>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } }else{?>
                            <div class="col-md-12" style="padding: 15%;">
                                <center>
                                    <div>
                                        <div class="mb-3 mt-n5">
                                            <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                                                <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-danger">ບໍ່ມີລາຍການ</h4>
                                    </div>
                                </center>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php }

if(isset($_GET["editStatus"])){
    if($_POST["cookStatus"]=="2"){
        $status="3";
    }elseif($_POST["cookStatus"]=="3"){
        $status="4";
    }elseif($_POST["cookStatus"]=="4"){
        $status="5";
    }
    $editStauts=$db->fn_edit("res_orders_list","order_list_status_order='".$status."' WHERE order_list_branch_fk='" . @$_SESSION["user_branch"] . "' AND order_list_code='".$_POST["cookID"]."' ");
}

if(isset($_GET["countLabel"])){
    $sqlCount2=$db->fn_fetch_single_field("count(case when order_list_status_order='2' AND order_list_status='1' then 1 end) as total2,
    count(case when order_list_status_order='3' AND order_list_status='1' then 1 end) as total3,
    count(case when order_list_status_order IN ('4','5') AND order_list_status='1' then 1 end) as total4","res_orders_list 
    WHERE order_list_branch_fk='" . @$_SESSION["user_branch"] . "' AND order_list_status='1'");
    echo json_encode($sqlCount2);
}

?>