<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();

    if(isset($_GET["uniteType"])){
        $sql=$db->fn_read_all("res_expenses_type ORDER BY exp_code DESC");
        echo "<option value=''>ເລືອກ</option>"; 
        foreach($sql as $rowSql){
            echo "<option value='".$rowSql["exp_code"]."'>".$rowSql["exp_type_name"]."</option>";
        }
    }


    if(isset($_GET["loadNotify"])){
        $sqlCount2=$db->fn_fetch_single_field("count(case when order_list_status_order='4' then 1 end) as total4",
        "res_orders_list WHERE order_list_branch_fk='" . $_SESSION["user_branch"] . "'
        AND order_list_status_order='4' ORDER BY order_list_code ASC");
        if($sqlCount2["total4"]>0){
            echo '<h4 class="offline">
                <span style="background:red !important;font-size:10px;" class="badge fa-beat-fade" style="--fa-beat-fade-opacity: 0.67; --fa-beat-fade-scale: 1.075;">
                <i class="fa fa-envelope"></i> '.$sqlCount2["total4"].'
                </span> &nbsp; <span style="font-size:16px;" class="badge fa-beat-fade" style="--fa-beat-fade-opacity: 0.67; --fa-beat-fade-scale: 1.075;">ແຈ້ງເຕືອນເສີບອາຫານ</span>
                <span style="float: right !important;" class="closeID"><i class="fas fa-times"></i></span>
            </h4>';
        }else{
            echo '<h4 class="offline" >
                <span style="background:red !important;font-size:10px;" class="badge">
                <i class="fa fa-envelope"></i> 0
                </span> &nbsp; <span style="font-size:16px;">ແຈ້ງເຕືອນເສີບອາຫານ</span>
                <span style="float: right !important;" class="closeID"><i class="fas fa-times"></i></span>
            </h4>';
        }
    }

    if(isset($_GET["fetchProduct"])){
        $resDetail=$db->fn_fetch_single_all("res_products_detail WHERE pro_detail_code='".$_POST["promo_product_fk"]."' "); 
        echo json_encode($resDetail);
    }

    if(isset($_GET["large_group"])){
        $res_group=$db->fn_read_all("res_group ORDER BY group_code ASC");
        echo "<option value=''>ເລືອກ</option>";
        // echo "<option value='1'>ເຊັກບິນ ແລະ ພິມບິນຄືນ</option>";
        if(count($res_group)>0){
            foreach($res_group as $row_group){
                if(@$_POST["selectID"]==$row_group["group_code"]){
                    $selected="selected";
                }else{
                    $selected="";
                }
                echo "<option value='".$row_group["group_code"]."' $selected>".$row_group["group_name"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }

    if(isset($_GET["table_list"])){
        $res_group=$db->fn_read_all("res_zone ORDER BY zone_code ASC");
        echo "<option value=''>ເລືອກ</option>";
        if(count($res_group)>0){
            foreach($res_group as $row_group){
                echo "<option value='".$row_group["zone_code"]."'>".$row_group["zone_name"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }

    if(isset($_GET["permission"])){
        if($_SESSION["user_permission_fk"]=="202300000001"){
            $adminPer=" ORDER BY status_code ASC";
        }else{
            $adminPer=" WHERE status_code !='202300000001' AND status_open='1' ORDER BY status_code ASC";
        }

        $sqlStatus=$db->fn_read_all("res_status $adminPer");
        if(count($sqlStatus)>0){
            echo "<option value=''>ເລືອກ</option>";
            foreach($sqlStatus as $rowStatus){
                echo "<option value='".$rowStatus["status_code"]."'>".$rowStatus["status_name"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }

    if(isset($_GET["store"])){

        if($_SESSION["user_permission_fk"]=="202300000001"){
            $res_group=$db->fn_read_all("res_store ORDER BY store_id ASC");
            if(count($res_group)>0){
                echo "<option value=''>ທັງໝົດ</option>";
                foreach($res_group as $row_group){
                    echo "<option value='".$row_group["store_id"]."'>".$row_group["store_name"]."</option>";
                }
            }else{
                echo "<option value=''>ເລືອກ</option>";
            }
        }else{
            $res_group=$db->fn_read_all("res_store WHERE store_id='".$_SESSION["user_store_fk"]."' ORDER BY store_id ASC");
            if(count($res_group)>0){
                foreach($res_group as $row_group){
                    echo "<option value='".$row_group["store_id"]."'>".$row_group["store_name"]."</option>";
                }
            }else{
                echo "<option value=''>ເລືອກ</option>";
            }
        }
    }

    if(isset($_GET["branchUrl"])){
        if($_SESSION["user_permission_fk"]=="202300000001"){
            $branch="branch_com_fk='".$_POST["storeCode"]."'";
        }else{
            $branch="branch_code='".$_SESSION["user_branch"]."'";
        }
        $res_branchGroup=$db->fn_read_all("res_branch WHERE $branch ORDER BY branch_code ASC");
        if(count($res_branchGroup)>0){
            if($_SESSION["user_permission_fk"]=="202300000002"){
                echo "<option value=''>ທັງໝົດ</option>";
            }
            foreach($res_branchGroup as $row_branchGroup){
                echo "<option value='".$row_branchGroup["branch_code"]."'>".$row_branchGroup["branch_name"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }

    if(isset($_GET["type_printer"])){
        $res_printer=$db->fn_read_all("res_type_printer ORDER BY print_type_code ASC");
        if(count($res_printer)>0){
            if($_SESSION["user_permission_fk"]=="202300000002"){
                echo "<option value=''>ເລືອກ</option>";
            }
            foreach($res_printer as $row_printer){
                echo "<option value='".$row_printer["print_type_code"]."'>- ".$row_printer["print_type_name"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }


    if(isset($_GET["productUrl"])){
        $res_products=$db->fn_read_all("view_product_list WHERE product_branch='".$_POST["branch_code"]."' AND product_cut_stock='2' ORDER BY pro_detail_code ASC");
        if(count($res_products)>0){
            foreach($res_products as $row_products){
                echo "<option value='".$row_products["pro_detail_code"]."'>".$row_products["fullnameSize"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }




    if(isset($_GET["branch"])){

        if($_SESSION["user_permission_fk"]=="202300000001"){
            $res_branch=$db->fn_read_all("res_branch ORDER BY branch_code ASC");
            if(count($res_branch)>0){
                echo "<option value=''>ເລືອກ</option>";
                foreach($res_branch as $row_branch){
                    if($_POST["selectID"]==$row_branch["branch_code"]){
                        $selected="selected";
                    }else{
                        $selected="";
                    }
                    echo "<option value='".$row_branch["branch_code"]."' $selected>".$row_branch["branch_name"]."</option>";
                }
            }else{
                echo "<option value=''>ເລືອກ</option>";
            }
        }else{
            if($_SESSION["user_permission_fk"]=="202300000002"){
                $where="WHERE branch_com_fk='".$_SESSION["user_store_fk"]."' ";
            }else{
                $where="WHERE branch_code='".$_SESSION["user_branch"]."' ";
            }

            $res_branch=$db->fn_read_all("res_branch $where ORDER BY branch_code ASC");
            if(count($res_branch)>0){
                echo "<option value=''>ເລືອກ</option>";
                foreach($res_branch as $row_branch){
                    if($_POST["selectID"]==$row_branch["branch_code"]){
                        $selected="selected";
                    }else{
                        $selected="";
                    }
                    echo "<option value='".$row_branch["branch_code"]."' $selected>".$row_branch["branch_name"]."</option>";
                }
            }else{
                echo "<option value=''>ເລືອກ</option>";
            }

        }

        
    }

    if(isset($_GET["categroy"])){
        $res_cate=$db->fn_read_all("res_category WHERE cate_group='".$_POST["cate_group"]."' ORDER BY cate_code ASC");
        if(count($res_cate)>0){
            foreach($res_cate as $row_cate){
                if($_POST["selectID"]==$row_cate["cate_code"]){
                    $selected="selected";
                }else{
                    $selected="";
                }
                echo "<option value='".$row_cate["cate_code"]."' $selected>".$row_cate["cate_name"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }

    if(isset($_GET["getloginID"])){
        $sqlStatus=$db->fn_read_all("res_status ORDER BY status_code ASC");
        if(count($sqlStatus)>0){
            foreach($sqlStatus as $rowStauts){
                echo "<option value='".$rowStauts["status_code"]."'>".$rowStauts["status_name"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }

    if(isset($_GET["unite"])){
        $sql_unite=$db->fn_read_all("res_unite ORDER BY unite_code ASC");
        if(count($sql_unite)>0){
            foreach($sql_unite as $row_unite){
                if($_POST["selectID"]==$row_unite["unite_code"]){
                    $selected="selected";
                }else{
                    $selected="";
                }
                echo "<option value='".$row_unite["unite_code"]."' $selected>".$row_unite["unite_name"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }

    if(isset($_GET["size"])){
        $res_size=$db->fn_read_all("res_size ORDER BY size_code ASC");
        if(count($res_size)>0){
            foreach($res_size as $row_size){
                if($_POST["selectID"]==$row_size["size_code"]){
                    $selected="selected";
                }else{
                    $selected="";
                }
                echo "<option value='".$row_size["size_code"]."' $selected>".$row_size["size_name_la"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }

    // if(isset($_GET["colors"])){
    //     $res_colors=$db->fn_read_all("res_colors ORDER BY color_code ASC");
    //     if(count($res_colors)>0){
    //         foreach($res_colors as $row_colors){
    //             if($_POST["selectID"]==$row_colors["color_code"]){
    //                 $selected="selected";
    //             }else{
    //                 $selected="";
    //             }
    //             echo "<option value='".$row_colors["color_code"]."' $selected>".$row_colors["color_name"]."</option>";
    //         }
    //     }else{
    //         echo "<option value=''>ເລືອກ</option>";
    //     }
    // }

    if(isset($_GET["reorder_point"])){
        $res_point=$db->fn_read_all("res_reorder_point ORDER BY reorder_point_code ASC");
        if(count($res_point)>0){
            foreach($res_point as $row_point){
                if($_POST["selectID"]==$row_point["reorder_point_code"]){
                    $selected="selected";
                }else{
                    $selected="";
                }
                echo "<option value='".$row_point["reorder_point_code"]."' $selected>".$row_point["reorder_point_name"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }

    

    if(isset($_GET["products"])){
        $res_products=$db->fn_read_all("res_products_list ORDER BY product_code ASC");
        echo "<option value=''>ເລືອກ</option>";
        if(count($res_products)>0){
            foreach($res_products as $row_size){
                echo "<option value='".$row_size["product_code"]."'>".$row_size["product_name"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }

    if(isset($_GET["products_search"])){
        $res_pro=$db->fn_fetch_single_all("res_products_list WHERE product_code='".$_POST["show_id1"]."'");
        echo json_encode($res_pro);
    }

    if(isset($_GET["categroy_check"])){
        $res_cate=$db->fn_read_all("res_category WHERE cate_group='".$_POST["product_group_fk"]."' ORDER BY cate_code ASC");
        if(count($res_cate)>0){
            foreach($res_cate as $row_cate){
                if($_POST["product_cate_fk"]==$row_cate["cate_code"]){
                    $selected="selected";
                }else{
                    $selected="";
                }
                echo "<option value='".$row_cate["cate_code"]."' $selected>".$row_cate["cate_name"]."</option>";
            }
        }else{
            echo "<option value=''>ເລືອກ</option>";
        }
    }

    

    if(isset($_GET["products_search_detail"])){
        $res_detail=$db->fn_read_all("view_product_list WHERE pro_detail_product_fk='".$_POST["show_id1"]."'");
        foreach($res_detail as $row_detail){
            if($row_detail["pro_detail_location"]==""){
                $images="assets/img/logo/no_logo.jpg";
            }else{
                $images="assets/img/product_detail/".$row_detail["pro_detail_location"];
            }
            echo '<tr>
            <td id="1" class="upload_file">
                <center>
                <div class="avatar-preview">
                    <label for="pro_detail_location" style="cursor:pointer" id="upload_image" class="upload_image">
                        <img src="'.$images.'" id="display_images1" name="display_images" class="display_images" alt="" style="max-width: 50%;max-height:80px">
                        <input type="file" id="pro_detail_location" name="pro_detail_location1" class="pro_detail_location" accept=".png, .jpg, .jpeg" style="display: none;">
                    </label>
                </div>
                </center>
            </td>
            <td>
                <div class="form-check form-switch ms-auto">
                    <input type="checkbox" class="form-check-input" id="pro_detail_open" name="pro_detail_open[]" checked>
                    <label class="form-check-label" for="pro_detail_open">&nbsp;</label>
                </div>
            </td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm input_color pro_detail_barcode1" value="'.$row_detail["pro_detail_barcode"].'" disabled name="pro_detail_barcode[]" id="pro_detail_barcode" autocomplete="off">
                    <button type="button" class="btn btn-primary"><i class="fas fa-barcode"></i></button>
                </div>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input_color" value="'.$row_detail["size_name_la"].'" disabled name="pro_detail_size_fk[]" id="pro_detail_size_fk" autocomplete="off">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input_color" value="'.@number_format($row_detail["pro_detail_bprice"]).'" disabled name="pro_detail_bprice[]" id="pro_detail_bprice" placeholder="0.0" autocomplete="off" style="width:120px">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input_color" value="'.@number_format($row_detail["pro_detail_sprice"]).'" disabled name="pro_detail_sprice[]" id="pro_detail_sprice" placeholder="0.0" autocomplete="off" required style="width:120px">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input_color" value="'.@number_format($row_detail["pro_detail_qty"]).'" disabled name="pro_detail_qty[]" id="pro_detail_qty" placeholder="0.0" autocomplete="off" style="width:120px">
            </td>
            <td>
                <button class="btn btn-danger" disabled><i class="fas fa-trash"></i></button>
            </td>
        </tr>';
        }
    }

    if(isset($_GET["insert_unite"])){
        $auto_number=$db->fn_autonumber("unite_code","res_unite");
        $sql="'".$auto_number."','".$_POST["unite_name"]."'";
        $insert=$db->fn_insert("res_unite",$sql);
        if($insert){
            echo json_encode(array("statusCode" => 200));
        }else{
            echo json_encode(array("statusCode" => 204));
        }
    }

    if(isset($_GET["load_zone"])){
        if($_POST["active_item"]=="1"){
            $where="AND table_status='".$_POST["active_item"]."'";
        }elseif($_POST["active_item"]=="2"){
            $where="AND table_status='".$_POST["active_item"]."'";
        }elseif($_POST["active_item"]=="3"){
            $where="";
        }else{
            $where="AND table_zone_fk='".$_POST["active_item"]."'";
        }

        $sql="res_tables AS A 
        LEFT JOIN res_zone AS B ON A.table_zone_fk=B.zone_code
        WHERE table_branch_fk='".$_SESSION["user_branch"]."' 
        $where ORDER BY table_sum,table_luck ASC";
        $sql=$db->fn_read_all($sql);
        foreach($sql as $row_table){
            if($row_table["table_status"]=="1"){
                $status_table="<span class='text'>ໂຕະວ່າງ</span>";
            }else if($row_table["table_status"]=="2"){
                $status_table="<span class='text'>ບໍ່ວ່າງ</span>";
            }else if($row_table["table_status"]=="4"){
                $status_table="<span class='text text-success'>ຈ່າຍກ່ອນກິນ</span>";
            }

            // $fetchRow=$db->fn_fetch_single_field("SUM(CASE WHEN order_list_status_order != '5' THEN 1 ELSE 0 END) as Order_waiting,
            // SUM(CASE WHEN order_list_status_order = '5' THEN 1 ELSE 0 END) as Order_success,
            // COUNT(*) as amount,format(SUM(order_list_discount_total),0)AS totals",
            // "res_orders_list WHERE order_list_table_fk='".$row_table["table_code"]."' AND order_list_branch_fk='".$_SESSION["user_branch"]."'");

        if($row_table["table_status"]=="1"){
    ?>
        <div class="table available">
            <a href="?pos&table_id=<?php echo base64_encode($row_table["table_code"]);?>" class="table-container" style="cursor:pointer">
                <div class="table-status bg-light"></div>
                <div class="table-name shadow">
                    <div class="name">ເບີໂຕະ</div>
                    <div class="no" ><?php echo $row_table["table_name"]; ?></div>
                    <div class="order"><span>ວ່າງ</span></div>
                </div>
                <div class="table-info-row">
                    <div class="table-info-col">
                        <div class="table-info-container">
                            <span class="icon">
                                <!-- <i class="fa fa-hand-point-up"></i> -->
                            </span>
                            <span class="text" style="font-size:20px;color:#595959">.</span>
                        </div>
                    </div>
                    <div class="table-info-col">
                        <div class="table-info-container">
                            <span class="icon">
                                <!-- <i class="fa fa-dollar-sign"></i> -->
                            </span>
                            <span class="text text-white"></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php }else if($row_table["table_status"]=="2"){
        $sqlBill=$db->fn_fetch_single_all("res_bill WHERE bill_table='".$row_table["table_code"]."' AND bill_status='1'");
        $sqlOrders=$db->fn_fetch_rowcount("res_orders_list WHERE order_list_table_fk='".$row_table["table_code"]."' AND order_list_status_order='1' ");
        if($sqlOrders>0){
            $notify="mydiv";
        }else{
            $notify="";
        }
    ?>
        <!-- <div class="table in-use">
            <a href="?pos&table_id=<?php echo base64_encode($row_table["table_code"]);?>" class="table-container" data-toggle="select-table">
                <div class="table-status bg-success"></div>
                <div class="table-name shadow <?php echo $notify?>">
                    <div class="name text-light">ເບີໂຕະ</div>
                    <div class="no text-light" ><?php echo $row_table["table_name"]; ?></div>
                    <div class="order text-info"><?php echo $status_table;?></div>
                </div>
                <div class="table-info-row">
                    <div class="table-info-col">
                        <div class="table-info-container">
                            <span class="icon" style="font-size:17px;">
                                #
                            </span>
                            <span class="text" style="font-size:14px;">
                                ຄິວ 
                                <span style="font-family:'Times New Roman', Times, serif;font-weight:bold;font-size:20px;">
                                    <?php echo $sqlBill["bill_q"]?>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="table-info-col">
                        <div class="table-info-container">
                            <span class="icon">#</span>
                            <span>ບໍ່ວ່າງ</span>
                        </div>
                    </div>
                </div>
            </a>
        </div> -->
        <div class="table in-use">
            <a href="?pos&table_id=<?php echo base64_encode($row_table["table_code"]);?>" class="table-container" data-toggle="select-table">
                <div class="table-status"></div>
                <div class="table-name <?php echo $notify?>">
                    <div class="name">ເບີໂຕະ</div>
                    <div class="no" style="text-shadow: 1px 1px 2px black;"><?php echo $row_table["table_name"]; ?></div>
                    <div class="order text-success"><?php echo $status_table;?></div>
                </div>
                <div class="table-info-row">
                    <div class="table-info-col">
                        <div class="table-info-container">
                            <span class="icon">
                            <i class="fa fa-hand-point-up"></i>
                            </span>
                            <span class="text" style="font-size:14px;">
                                ຄິວ 
                                <span style="font-family:'Times New Roman', Times, serif;font-weight:bold;text-shadow: 1px 1px 2px black;font-size:20px;">
                                    <?php echo $sqlBill["bill_q"]?>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="table-info-col">
                        <div class="table-info-container">
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <span>ບໍ່ວ່າງ</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php }else if($row_table["table_status"]=="4"){?>
        <div class="table">
            <a href="?pos&table_id=<?php echo base64_encode($row_table["table_code"]);?>" class="table-container" data-toggle="select-table">
                <div class="table-status bg-success"></div>
                <div class="table-name shadow">
                    <div class="name">ເບີໂຕະ</div>
                    <div class="no"><?php echo $row_table["table_name"]; ?></div>
                    <div class="order text-green"><span>( ນັ່ງຢູ່ )</span></div>
                </div>
            </a>
            <div class="table-container" data-toggle="select-table">
                <div class="table-info-row">
                    
                    <div class="table-info-col">
                        <a href="?pos&table_id=<?php echo base64_encode($row_table["table_code"]);?>" style="text-decoration:none">
                            <div class="table-info-container bg-green">
                                <span class="icon">
                                    <i class="fas fa-check text-white"></i>
                                </span>
                                <span class="text text-white">ສັ່ງໃຫມ່</span>
                            </div>
                        </a>
                    </div>
                    
                    <div class="table-info-col">
                        <div class="table-info-container bg-danger text-light">
                            <span class="icon">
                                <i class="fas fa-times text-white"></i>
                            </span>    
                            ປິດໂຕະ
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


    <?php }else{
        $sqlCheckTb=$db->fn_fetch_single_all("res_tables WHERE table_sum='".$row_table["table_sum"]."' AND table_luck='1' AND table_branch_fk='".$_SESSION["user_branch"]."'");
        
        $fetchRow1=$db->fn_fetch_single_field("SUM(CASE WHEN order_list_status_order != '5' THEN 1 ELSE 0 END) as Order_waiting,
        SUM(CASE WHEN order_list_status_order = '5' THEN 1 ELSE 0 END) as Order_success,
        COUNT(*) as amount,format(SUM(order_list_discount_total),0)AS totals",
        "res_orders_list WHERE order_list_table_fk='".$row_table["table_sum"]."' AND order_list_branch_fk='".$_SESSION["user_branch"]."'");

        // if($sqlCheckTb["table_code"]==$row_table["table_sum"]){
        //     $tbName=$sqlCheckTb["table_name"];
        // }else{
        //     $tbName=$sqlCheckTb["table_name"];
        // }

        if($row_table["table_luck"]=="1"){
            $brg="bg-orange";
            @$tbName="ໂຕະຫຼັກ ".$row_table["table_name"];
        }else{
            $brg="bg-warning";
            @$tbName=$row_table["table_name"]." ລວມ ".$sqlCheckTb["table_name"];
        }

        $sqlBill2=$db->fn_fetch_single_all("res_bill WHERE bill_table='".$row_table["table_code"]."' AND bill_status='1'");

        ?>
        <div class="table in-use" >
            <a href="?pos&table_id=<?php echo base64_encode($row_table["table_sum"]);?>" class="table-container" data-toggle="select-table">
                <div class="table-status <?php echo $brg;?>" style="width: 70px;height:35px;border-radius:0px !important;">
                    <?php echo $tbName;?>
                </div>
                <div class="table-name shadow">
                    <div class="name">ເບີໂຕະ</div>
                    <div class="no"><?php echo $row_table["table_name"]; ?></div>
                    <div class="order text-green"><span>ລວມໂຕະ</span></div>
                </div>
                <div class="table-info-row" style="font-size:14px;">
                    <div class="table-info-col">
                        <div class="table-info-container">
                            <span class="icon" style="font-size:17px;">
                                #
                            </span>
                            <span class="text" style="font-size:14px;">
                                ຄິວ
                                <span style="font-family:'Times New Roman', Times, serif;font-weight:bold;text-shadow: 1px 1px 2px black;font-size:20px;">
                                    <?php echo @$sqlBill2["bill_q"]?>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="table-info-col">
                        <div class="table-info-container">
                            <span class="icon">
                            <i class="fa fa-hand-point-up"></i>
                            </span>
                            ລວມໂຕະ
                        </div>
                    </div>
                </div>
            </a>
        </div>
    
    <?php }?>
<?php } }
if(isset($_GET["NotiOrders"])){
    $selectCook=$db->fn_read_all("view_orders WHERE order_list_branch_fk='" . $_SESSION["user_branch"] . "' 
    AND order_list_status_order='4' ORDER BY order_list_code ASC");
    if(count($selectCook)>0){
    foreach($selectCook as $rowCook){
        if ($rowCook["product_images"] != "") {
            $images = 'assets/img/product_home/' . $rowCook["product_images"];
        } else {
            $images = 'assets/img/logo/259987.png';
        }
?>

    <tr style="font-size: 14px !important;" class="table_hover" onclick="fnConfirm('<?php echo $rowCook['order_list_code']?>','<?php echo $rowCook['order_list_pro_code_fk']?>','<?php echo $rowCook['order_list_status_promotion']?>','<?php echo $rowCook['order_list_bill_fk']?>','<?php echo $rowCook['order_list_branch_fk']?>')">
        <td style="width:80px;vertical-align:middle"><img src="<?php echo $images;?>" alt="" class="card-img-top img"></td>
        <td>
            <?php echo $rowCook["product_name"]?>
            <br>-ເບີໂຕະ : <?php echo $rowCook["table_name"]?> 
            <br>-ໝາຍເຫດ : <?php echo $rowCook["order_list_note_remark"]?> 
        </td>
        <td style="width:60px" align="center">
            x <?php echo $rowCook["order_list_order_qty"]?>
            <br><button type="button" class="btn btn-xs btn-primary mt-1">✔ ຢືນຢັນ</button>
        </td>
    </tr>
<?php } }else{?>
    <tr style="background-color:#0F253B !important;border-bottom:1px solid #0F253B">
        <td colspan="3" align="center">
            <br><br><br><br><br>
            <div>
                <div class="mb-2 mt-n5">
                    <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-orange-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                        <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                    </svg>
                </div>
                <h4 class="text-orange">( ບໍ່ມີລາຍການ )</h4>
            </div>
        </td>
    </tr>
<?php } }
if(isset($_GET["editStatus"])){

    $checkGroup=$db->fn_fetch_rowcount("res_orders_list WHERE order_list_bill_fk='".$_POST["bill_no"]."' 
    AND order_list_branch_fk='".$_POST["branch_no"]."' AND order_list_pro_code_fk='".$_POST["proID"]."' 
    AND order_list_status_promotion='".$_POST["promotinID"]."' AND order_list_status_order='5' ");
    if($checkGroup>0){

        $checkOrder=$db->fn_fetch_single_all("res_orders_list WHERE order_list_code='".$_POST["dataID"]."' 
        AND order_list_bill_fk='".$_POST["bill_no"]."' AND order_list_branch_fk='".$_POST["branch_no"]."'");
        if($checkOrder){
            $updateGroup=$db->fn_edit("res_orders_list","order_list_order_qty=order_list_order_qty+'".$checkOrder["order_list_order_qty"]."',
            order_list_order_total=order_list_order_qty*'".$checkOrder["order_list_pro_price"]."',
            order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'".$checkOrder["order_list_qty_promotion_gif_total"]."',
            order_list_discount_status='1',
            order_list_discount_percented='0',
            order_list_discount_percented_name='0',
            order_list_discount_price='0',
            order_list_discount_total=order_list_order_qty*'".$checkOrder["order_list_pro_price"]."'
            WHERE order_list_pro_code_fk='".$_POST["proID"]."'
            AND order_list_bill_fk='".$_POST["bill_no"]."' 
            AND order_list_branch_fk='".$_POST["branch_no"]."' 
            AND order_list_status_order='5' ");
            $deleteOrder=$db->fn_delete("res_orders_list WHERE order_list_code='".$_POST["dataID"]."' 
            AND order_list_bill_fk='".$_POST["bill_no"]."' AND order_list_branch_fk='".$_POST["branch_no"]."' ");
        }

        

    }else{
        $editStatus=$db->fn_edit("res_orders_list","order_list_status_order='5' WHERE order_list_code='".$_POST["dataID"]."' 
        AND order_list_bill_fk='".$_POST["bill_no"]."' AND order_list_branch_fk='".$_POST["branch_no"]."' ");
    }
}

if(isset($_GET["active_menu"])){
    $_SESSION["menuID"]=$_POST["menuID"];
    $_SESSION["mainID"]=$_POST["mainID"];
    $_SESSION["subID"]=$_POST["subID"];
}
if(isset($_GET["insert_size"])){
    $auto_number=$db->fn_autonumber("size_code","res_size");
    if($_POST["size_code"] !=""){
        $sql="size_name_la='".$_POST["size_name_la"]."',size_name_eng='".$_POST["size_name_eng"]."' WHERE size_code='".$_POST["size_code"]."'";
        $edit=$db->fn_edit("res_size",$sql);
        if($edit){
            echo json_encode(array("statusCode" => 202));
        }else{
            echo json_encode(array("statusCode" => 204));
        }
    }else{
        $insert=$db->fn_insert("res_size","'".$auto_number."','".$_POST["size_name_la"]."','".$_POST["size_name_la"]."'");
        if($insert){
            echo json_encode(array("statusCode" => 200));
        }else{
            echo json_encode(array("statusCode" => 202));
        }
    }
}
if(isset($_GET["loadAll"])){
    $i=1;
    $sqlProductList=$db->fn_read_all("res_size ORDER BY size_code ASC");
    foreach($sqlProductList as $rowList){
        $sql_check=$db->fn_fetch_single_field("size_code,size_name_la","res_check_bill_list AS A 
        LEFT JOIN res_products_detail AS B ON A.check_bill_list_pro_code_fk=B.pro_detail_code
        LEFT JOIN res_size AS C ON B.pro_detail_size_fk=C.size_code WHERE size_code='".$rowList['size_code']."' GROUP BY size_code");
        if(@$sql_check["size_code"]==$rowList['size_code']){
            $disabled="disabled";
        }else{
            $disabled="";
        }
?>
    <tr>
        <td align="center"><?php echo $i++;?></td>
        <td><?php echo $rowList["size_name_la"];?></td>
        <td><?php echo $rowList["size_name_eng"];?></td>
        <td align="center">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="sizeEdit('<?php echo $rowList['size_code'];?>','<?php echo $rowList['size_name_la'];?>','<?php echo $rowList['size_name_eng'];?>')">
                <i class="fas fa-pen"></i> ແກ້ໄຂ
            </button>
            <button type="button" <?php echo $disabled;?> class="btn btn-outline-danger btn-sm" onclick="deleteSize('<?php echo $rowList['size_code'];?>')">
                <i class="fas fa-trash"></i> ລຶບ
            </button>
        </td>
    </tr>
<?php } }
if(isset($_GET["delete_size"])){
    $delete=$db->fn_delete("res_size WHERE size_code='".$_POST["size_code"]."' ");
    if($delete){
        echo json_encode(array("statusCode" => 200));
    }else{
        echo json_encode(array("statusCode" => 202));
    }
}
?>