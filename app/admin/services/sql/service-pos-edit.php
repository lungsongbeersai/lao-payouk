<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if (isset($_GET["product_list"])) {

    if (@$_POST["cate_item"] == "Promotion_11") {
        $sqlPro = $db->fn_fetch_single_all("view_promotion WHERE promo_status='1' AND promo_branch_fk='" . $_SESSION["user_branch"] . "'");
        if (@$_POST["search_product1"] != "") {
            @$search .= "WHERE product_name LIKE '%" . @$_POST["search_product1"] . "%' AND product_branch='" . $_SESSION["user_branch"] . "'";
        } else {
            @$search .= "WHERE product_cate_fk='" . $sqlPro["cate_code"] . "' AND product_branch='" . $sqlPro["promo_branch_fk"] . "' AND pro_detail_gif='2'";
        }
        $pro_detail_gif = "AND pro_detail_gif='2'";
        $statusPro = "2";
    } else {
        if (@$_POST["search_product1"] != "") {
            @$search .= "WHERE product_name LIKE '%" . @$_POST["search_product1"] . "%' AND product_branch='" . $_SESSION["user_branch"] . "'";
        } else {
            @$search .= "WHERE product_cate_fk='" . @$_POST["cate_item"] . "' AND product_branch='" . $_SESSION["user_branch"] . "'";
        }
        $pro_detail_gif = "";
        $statusPro = "1";
    }


    $sql_product = $db->fn_read_all("view_product_list $search GROUP BY pro_detail_product_fk");
    if (count($sql_product) > 0) {
        foreach ($sql_product as $row_product) {
            $sql_detail = $db->fn_read_all("view_product_list
            WHERE pro_detail_product_fk='" . $row_product["product_code"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' $pro_detail_gif ORDER BY pro_detail_size_fk ASC ");
            if ($row_product["product_images"] != "") {
                $images = 'assets/img/product_home/' . $row_product["product_images"];
            } else {
                $images = 'assets/img/logo/259987.png';
            }
            $checkAvilable = $db->fn_fetch_rowcount("view_product_list WHERE pro_detail_product_fk='" . $row_product["product_code"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' AND pro_detail_open='2'  ");
?>
            <div class="product-container px-2">
                <?php
                if ($checkAvilable > 0) {
                    $modalId = ' modal_products';
                    $available = '';
                    $modalCursor = 'style=cursor:pointer;';
                } else {
                    $modalId = ' not-available';
                    $available = '<div class="not-available-text"><div>ລາຍການນີ້ໝົດແລ້ວ</div></div>';
                    $modalCursor = '';
                }
                ?>
                <div class="product <?php echo $modalId; ?>" <?php echo $modalCursor; ?> id="<?php echo $row_product["product_code"] ?>">
                    <input type="text" value="<?php echo $statusPro; ?>" hidden id="status_check_gif" name="status_check_gif">
                    <div class="img" style="background-image: url(<?php echo $images; ?>)"></div>
                    <div class="text mb-2">
                        <div class="title" style="font-size:18px;text-align:center;color:#DB4900;font-weight:bold"><?php echo $row_product["product_name"] ?></div>
                        <div class="price">
                            <center>
                                ( <span style="font-size:16px;color:red"><?php echo count($sql_detail); ?></span> ຂະໜາດ )
                            </center>
                            <br>
                        </div>
                        <?php
                        foreach ($sql_detail as $row_detail) {
                            if ($row_detail["product_cut_stock"] == "1") {
                                $stockQty = "";
                            } else {
                                $stockQty = "[ " . $row_detail["pro_detail_qty"] . " ]";
                            }

                        ?>
                            <div class="price">
                                <?php
                                if ($row_detail["pro_detail_open"] == "1") {
                                    echo "<span class='text-danger'>✗</span>";
                                    echo "<s>" . $row_product["unite_name"] . $row_detail["size_name_la"] . " <span class='text-danger'>( ໝົດແລ້ວ )</span></s>";
                                    echo "<span style='float:right' class='text-danger'>
                                                <s>" . @number_format($row_detail["pro_detail_sprice"]) . " ກີບ" . "</s>
                                            </span>";
                                } else {
                                    echo "☛ " . $stockQty . " ";
                                    echo $row_product["unite_name"] . $row_detail["size_name_la"];
                                    echo "<span style='float:right'>
                                                " . @number_format($row_detail["pro_detail_sprice"]) . " ກີບ" . "
                                            </span>";
                                }
                                if (@$_POST["cate_item"] == "Promotion_11") {
                                    $promotion = $db->fn_fetch_single_all("res_promotion WHERE promo_product_fk='" . $row_detail["pro_detail_code"] . "'
                                    AND promo_branch_fk='" . $_SESSION["user_branch"] . "' AND promo_status='1'");
                                    echo "<br>";
                                    echo "<span style='float:right;font-size:11px;color:#cc004e;'>- ຊື້ " . @($promotion["promo_qty"]) .
                                        " ແຖມ " . @($promotion["promo_gif_qty"]) . " = " . @($promotion["promo_qty_total"]) . " " . $row_product["unite_name"] . "</span>";
                                }
                                ?>

                            </div>
                        <?php } ?>
                    </div>
                    <?php echo $available; ?>
                </div>
            </div>
        <?php }
    } else { ?>
        <div class="col-md-12" style="padding: 25%;">
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
    <?php }
}

if (isset($_GET["editPercented"])) {
    $discount_total = filter_var($_POST["discount_total"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $discount_amount = filter_var($_POST["discount_amount"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $percented = filter_var($_POST["percented"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $sqlEdit = "order_list_discount_status='2',
    order_list_discount_percented='" . $_POST["type_discount"] . "',
    order_list_discount_percented_name='" . $percented . "',
    order_list_discount_price='" . $discount_amount . "',
    order_list_discount_total='" . $discount_total . "' WHERE order_list_code='" . $_POST["proID"] . "' ";
    $editData = $db->fn_edit("res_orders_list_edit", $sqlEdit);
    echo json_encode(array("statusCode" => 200));
}

if (isset($_GET["editOldprice"])) {
    $sqlEdit = "order_list_discount_status='1',
    order_list_discount_percented='',
    order_list_discount_percented_name='',
    order_list_discount_price='',
    order_list_discount_total='" . $discount_oldPrice . "' WHERE order_list_code='" . $_POST["proID"] . "' ";
    $editData = $db->fn_edit("res_orders_list_edit", $sqlEdit);
}

if (isset($_GET["product_modal"])) {

    if ($_POST["status_check_gif"] == "1") {
        $sql_detail = $db->fn_fetch_single_all("res_products_list AS A 
        LEFT JOIN res_products_detail AS B ON A.product_code=B.pro_detail_product_fk
        LEFT JOIN res_unite AS C ON A.product_unite_fk=C.unite_code
        WHERE product_code='" . $_POST["modal_products"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' 
        AND pro_detail_open='2' ORDER BY pro_detail_code ASC LIMIT 1");
        if (@$sql_detail["product_images"] != "") {
            $images_detail = 'assets/img/product_home/' . $sql_detail["product_images"];
        } else {
            $images_detail = 'assets/img/logo/259987.png';
        }
    ?>

        <div class="pos-product-img">
            <div class="img" style="background-image: url('<?php echo $images_detail; ?>')"></div>
        </div>
        <div class="pos-product-info">
            <div class="title" style="font-weight:bold"><?php echo $sql_detail["product_name"]; ?></div>
            <div class="qty">ລາຄາ : <span class="badge bg-dark"><span id="title_price"><?php echo @number_format($sql_detail["pro_detail_sprice"]); ?></span> ກີບ</span></div>
            <hr />
            <div class="qty">
                <div class="input-group" style="width:110px !important;">
                    <input type="text" hidden class="txtDetailCode" id="txtDetailCode" name="txtDetailCode" value="<?php echo $sql_detail['pro_detail_code'] ?>">
                    <input type="text" hidden class="txtCutStock" id="txtCutStock" name="txtCutStock" value="<?php echo $sql_detail['product_cut_stock'] ?>">
                    <input type="text" hidden class="txtUnite" id="txtUnite" name="txtUnite" value="<?php echo $sql_detail['unite_name'] ?>">
                    <input type="text" hidden class="txtQty" id="txtQty" name="txtQty" value="<?php echo $sql_detail['pro_detail_qty'] ?>">
                    <input type="text" hidden class="txtPrice" id="txtPrice" name="txtPrice" value="<?php echo $sql_detail['pro_detail_sprice'] ?>">
                    <input type="text" hidden class="txtCate" id="txtCate" name="txtCate" value="<?php echo $sql_detail['product_cate_fk'] ?>">
                    <input type="text" hidden class="txtStatusPro" id="txtStatusPro" name="txtStatusPro" value="1">
                    <input type="text" hidden class="txtProJing1" id="txtProJing1" name="txtProJing" value="0">
                    <input type="text" hidden class="txtProGif1" id="txtProGif1" name="txtProGif" value="0">
                    <input type="text" hidden class="txtGifDefault1" id="txtGifDefault1" name="txtGifDefault" value="0">
                    <input type="text" hidden class="start_qty1" id="start_qty1" name="start_qty" value="1">
                    <input type="text" hidden class="stock_qty1" id="stock_qty1" name="stock_qty2" value="0">

                    <input type="text" hidden class="product_notify1" id="product_notify1" name="product_notify1" value="<?php echo $sql_detail['product_notify'] ?>">

                    <button type="button" class="btn btn-danger" id="btn_minus" style="background-color:#BF2C24 !important;color:white" onclick="Plus_fn('minus')"><i class="fa fa-minus"></i></button>
                    <input type="text" autocomplete="off" class="form-control border-0 text-center order_list_pro_qty" id="order_list_pro_qty" name="order_list_pro_qty" value="1" onkeyup="Plus_fn('qtyAll')" onmouseout="Plus_fn('qtyAll')" onmousemove="Plus_fn('qtyAll')">
                    <button type="button" class="btn btn-primary" id="btn_plus" style="background-color:#2470bd !important;color:white" onclick="Plus_fn('plus')"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="price mb-2">
                <label for="">ໝາຍເຫດ</label>
                <input type="text" class="form-control input_color" autocomplete="off" name="order_list_note_remark" id="order_list_note_remark" placeholder="ໝາຍເຫດ">
            </div>
            <div class="option-row">
                <div class="option-title">ຂະໜາດ</div>
                <div class="option-list">
                    <?php
                    $sql_detail_pos = $db->fn_read_all("view_product_list
                    WHERE pro_detail_product_fk='" . $sql_detail["product_code"] . "' AND pro_detail_open='2' ORDER BY pro_detail_size_fk ASC ");
                    foreach ($sql_detail_pos as $row_detail_pos) {
                        if ($row_detail_pos["pro_detail_code"] == $sql_detail["pro_detail_code"]) {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        }
                    ?>
                        <div class="option">
                            <input type="radio" id="size<?php echo $row_detail_pos["pro_detail_code"]; ?>" name="size" class="option-input" <?php echo $checked ?> onclick="fnChangePrice('<?php echo $row_detail_pos['pro_detail_code']; ?>','<?php echo $row_detail_pos['product_cut_stock']; ?>','1','<?php echo $row_detail_pos['pro_detail_qty'] ?>')" />
                            <label class="option-label" for="size<?php echo $row_detail_pos["pro_detail_code"]; ?>" style="cursor:pointer !important; ">
                                <span class="option-text"><?php echo $row_detail_pos["unite_name"]; ?><?php echo $row_detail_pos["size_name_la"]; ?></span>
                                <span class="option-price"><?php echo @number_format($row_detail_pos["pro_detail_sprice"]); ?></span>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="btn-row" onmouseover="Plus_fn('qtyAll')">
                <button type="submit" style="cursor:pointer" class="btn btn-primary">ເພີ່ມ <i class="fa fa-plus fa-fw ms-2"></i></button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> &nbsp;ປິດ</button>
            </div>
        </div>

    <?php } else {
        $sql_detail = $db->fn_fetch_single_all("view_promotion
        WHERE product_code='" . $_POST["modal_products"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' 
        AND pro_detail_open='2' AND pro_detail_qty>=promo_qty_total ORDER BY pro_detail_code ASC LIMIT 1");
        if (@$sql_detail["product_images"] != "") {
            $images_detail = 'assets/img/product_home/' . $sql_detail["product_images"];
        } else {
            $images_detail = 'assets/img/logo/259987.png';
        }
    ?>
        <div class="pos-product-img">
            <div class="img" style="background-image: url('<?php echo $images_detail; ?>')"></div>
        </div>

        <div class="pos-product-info">
            <div class="title" style="font-weight:bold"><?php echo @$sql_detail["product_name"]; ?></div>
            <div class="qty">ລາຄາ : <span class="badge bg-dark"><span id="title_price"><?php echo @number_format($sql_detail["pro_detail_sprice"]); ?></span> ກີບ</span></div>
            <hr />
            <div class="qty">
                <div class="input-group" style="width:110px !important;">
                    <input type="text" hidden class="txtDetailCode" id="txtDetailCode" name="txtDetailCode" value="<?php echo $sql_detail['pro_detail_code'] ?>">
                    <input type="text" hidden class="txtCutStock" id="txtCutStock" name="txtCutStock" value="<?php echo $sql_detail['product_cut_stock'] ?>">
                    <input type="text" hidden class="txtUnite" id="txtUnite" name="txtUnite" value="<?php echo $sql_detail['unite_name'] ?>">
                    <input type="text" hidden class="txtQty" id="txtQty" name="txtQty" value="<?php echo $sql_detail['promo_qty_total'] ?>">
                    <input type="text" hidden class="txtPrice" id="txtPrice" name="txtPrice" value="<?php echo $sql_detail['pro_detail_sprice'] ?>">
                    <input type="text" hidden class="txtCate" id="txtCate" name="txtCate" value="Promotion_11">
                    <input type="text" hidden class="txtStatusPro" id="txtStatusPro" name="txtStatusPro" value="2">
                    <input type="text" hidden class="txtProJing2" id="txtProJing2" name="txtProJing" value="<?php echo $sql_detail['promo_qty'] ?>">
                    <input type="text" hidden class="txtGifDefault2" id="txtGifDefault2" name="txtGifDefault" value="<?php echo $sql_detail['promo_gif_qty'] ?>">
                    <input type="text" hidden class="txtProGif2" id="txtProGif2" name="txtProGif" value="<?php echo $sql_detail['promo_gif_qty'] ?>">
                    <input type="text" hidden class="start_qty2" id="start_qty2" name="start_qty" value="<?php echo $sql_detail['promo_qty'] ?>">
                    <input type="text" hidden class="stock_qty2" id="stock_qty2" name="stock_qty2" value="<?php echo $sql_detail['pro_detail_qty'] ?>">

                    <button type="button" class="btn btn-danger" id="btn_minus" style="background-color:#BF2C24 !important;color:white" onclick="Plus_fn('minus')"><i class="fa fa-minus"></i></button>
                    <input type="text" autocomplete="off" class="form-control border-0 text-center order_list_pro_qty2 order_list_pro_qty" id="order_list_pro_qty" name="order_list_pro_qty" readonly value="<?php echo $sql_detail['promo_qty'] ?>">
                    <button type="button" class="btn btn-primary" id="btn_plus" style="background-color:#2470bd !important;color:white" onclick="Plus_fn('plus')"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="price mb-2">
                <label for="">ໝາຍເຫດ</label>
                <input type="text" class="form-control input_color" autocomplete="off" name="order_list_note_remark" id="order_list_note_remark" placeholder="ໝາຍເຫດ">
            </div>
            <div class="option-row">
                <div class="option-title"><b>-ຂະໜາດ</b></div>
                <div class="option-list">
                    <?php
                    $sql_detail_pos = $db->fn_read_all("view_promotion
                    WHERE pro_detail_product_fk='" . @$sql_detail["product_code"] . "' AND pro_detail_open='2' ORDER BY pro_detail_size_fk ASC ");
                    foreach ($sql_detail_pos as $row_detail_pos) {
                        if ($row_detail_pos["pro_detail_code"] == $sql_detail["pro_detail_code"]) {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        }

                        if ($row_detail_pos['pro_detail_qty'] >= $row_detail_pos["promo_qty_total"]) {
                            $hidenRadios = "";
                        } else {
                            $hidenRadios = "hidden";
                        }

                    ?>
                        <div class="option" <?php echo $hidenRadios ?>>
                            <input type="radio" id="size<?php echo @$row_detail_pos["pro_detail_code"]; ?>" name="size" class="option-input" <?php echo $checked ?> onclick="fnChangePrice('<?php echo $row_detail_pos['pro_detail_code']; ?>','<?php echo $row_detail_pos['product_cut_stock']; ?>','<?php echo $row_detail_pos['promo_qty'] ?>','<?php echo $row_detail_pos['promo_gif_qty'] ?>','<?php echo $row_detail_pos['pro_detail_qty'] ?>')" />
                            <label class="option-label" for="size<?php echo @$row_detail_pos["pro_detail_code"]; ?>" style="cursor:pointer !important; ">
                                <span class="option-text"><?php echo @$row_detail_pos["unite_name"]; ?><?php echo @$row_detail_pos["size_name_la"]; ?></span>
                                <span class="option-price">
                                    <?php echo @number_format(@$row_detail_pos["pro_detail_sprice"]); ?>
                                </span>
                                <span class="option-price text-primary">
                                    ຊື້ <?php echo @number_format($row_detail_pos["promo_qty"]); ?> ແຖມ <?php echo @number_format($row_detail_pos["promo_gif_qty"]); ?>
                                </span>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="btn-row">
                <button type="submit" style="cursor:pointer" class="btn btn-primary">ເພີ່ມ <i class="fa fa-plus fa-fw ms-2"></i></button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> &nbsp;ປິດ</button>
            </div>
        </div>

    <?php }
}
if (isset($_GET["changePrice"])) {
    $sqlDetail = $db->fn_fetch_single_all("res_products_list AS A 
    LEFT JOIN res_products_detail AS B ON A.product_code=B.pro_detail_product_fk 
    WHERE pro_detail_code='" . $_POST["pro_detail_code"] . "' AND product_branch='" . $_SESSION["user_branch"] . "'");
    echo json_encode($sqlDetail);
}

if (isset($_GET["changeQty"])) {
    if ($_POST["txtCutStock"] == "1" && $_POST["txtCutStock"] == "3") {
        // ບໍ່ຕັດສະຕ໋ອກ
    } else {
        // ຕັດສະຕ໋ອກ
        $sqlCount = $db->fn_fetch_single_all("view_product_list WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND pro_detail_qty !='0' AND product_branch='" . $_SESSION["user_branch"] . "' ");
        if ($sqlCount) {
            if ($_POST["dataInput"] == "plus") {
                if ($sqlCount["pro_detail_qty"] > $_POST["order_list_pro_qty"]) {
                    if ($_POST["txtStatusPro"] == "1") {
                        $qtyInput = $_POST["order_list_pro_qty"] + $_POST["start_qty"];
                        echo json_encode(array("statusCode" => $qtyInput));
                    } else {
                        $sumQty = $_POST["order_list_pro_qty"] + $_POST["start_qty"] + $_POST["txtProGif"];
                        if ($_POST["stock_qty2"] >= $sumQty) {
                            $qtyInput = $_POST["order_list_pro_qty"] + $_POST["start_qty"];
                            echo json_encode(array("statusCode" => $qtyInput));
                        } else {
                            $gifPro = $_POST["start_qty"] - $_POST["txtGifDefault"];
                            echo json_encode(array("statusCode" => 203, "qtyStock" => $_POST["order_list_pro_qty"], "qtyAmount" => $gifPro));
                        }
                    }
                } else {
                    echo json_encode(array("statusCode" => 201, "qtyStock" => $sqlCount["pro_detail_qty"]));
                }
            } else if ($_POST["dataInput"] == "minus") {
                if ($_POST["order_list_pro_qty"] != "1") {
                    $qtyInput = $_POST["order_list_pro_qty"] - $_POST["start_qty"];
                    echo json_encode(array("statusCode" => $qtyInput));
                }
            } else if ($_POST["dataInput"] == "qtyAll") {
                if ($sqlCount["pro_detail_qty"] >= $_POST["order_list_pro_qty"]) {
                    $qtyInput = $_POST["order_list_pro_qty"];
                    echo json_encode(array("statusCode" => $qtyInput));
                } else {
                    echo json_encode(array("statusCode" => 201, "qtyStock" => $sqlCount["pro_detail_qty"]));
                }
            }
        } else {
            echo json_encode(array("statusCode" => 202));
        }
    }
}

if (isset($_GET["changOrderQty"])) {
    $where = "WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' 
    AND order_list_branch_fk='" . $_SESSION["user_branch"] . "' 
    AND order_list_pro_code_fk='" . $_POST["txtDetailCode"] . "' 
    AND order_list_status_promotion='" . $_POST["txtStatusPro"] . "' AND order_list_status_order='1' ";
    $sqlCount = $db->fn_fetch_rowcount("res_orders_list_edit $where ");
    if ($_POST["txtCutStock"] == "1") {
        // ບໍ່ຕັດສະຕ໋ອກ
        $price = $_POST["txtPrice"];
        $qty = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $qty_plus = $qty + 1;
        $total = $price * $qty_plus;

        if ($sqlCount > 0) {
            // echo $_POST["order_list_pro_qty"];
            if ($_POST["dataInput"] == "plus") {
                $sqlOrderQty = "order_list_order_qty='" . $qty_plus . "',order_list_order_total='" . $total . "'  $where";
                $editOrderQty = $db->fn_edit("res_orders_list_edit", $sqlOrderQty);
            } else if ($_POST["dataInput"] == "minus") {
                if ($qty != "1") {
                    $qtyInput = $qty - 1;
                    $totalMinus = $qtyInput * $price;
                    $sqlOrderQty = "order_list_order_qty='" . $qtyInput . "',order_list_order_total='" . $totalMinus . "'  $where";
                    $editOrderQty = $db->fn_edit("res_orders_list_edit", $sqlOrderQty);
                }
            }
        }
    } else {
        // ຕັດສະຕ໋ອກ

        $price = $_POST["txtPrice"];
        $qty = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) + floatval($_POST["txtProGif"]);
        $total = $price * filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $sqlStock = $db->fn_fetch_rowcount("res_products_detail WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND pro_detail_qty>=0 ");
        if ($sqlStock) {
            if ($_POST["txtCutStock"] == "2") {
                // $sql = "pro_detail_qty=pro_detail_qty-'" . $qty . "' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
                // $editQty = $db->fn_edit("res_products_detail", $sql);

                if ($_POST["txtStatusPro"] == "1") {
                    $sql = "pro_detail_qty=pro_detail_qty-'" . $qty . "' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
                    $editQty = $db->fn_edit("res_products_detail", $sql);
                } else {
                    $sql = "pro_detail_qty=pro_detail_qty-'" . $qty . "' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
                    $editQty = $db->fn_edit("res_products_detail", $sql);
                }
            }

            $sqlOrderQty = "order_list_order_qty=order_list_order_qty+'" . $qty . "',order_list_order_total='" . $total . "',
            order_list_note_remark='" . $_POST["order_list_note_remark"] . "' $where";
            $editOrderQty = $db->fn_edit("res_orders_list_edit", $sqlOrderQty);

            $sqlStockEmpty = $db->fn_fetch_rowcount("res_products_detail WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND pro_detail_qty='0' ");
            if ($sqlStockEmpty) {
                if ($_POST["txtCutStock"] == "2") {
                    $sql = "pro_detail_open='1' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
                    $editStatus = $db->fn_edit("res_products_detail", $sql);
                }
                echo json_encode(array("statusCode" => 200, 'Cate' => $_POST["txtCate"]));
            } else {
                echo json_encode(array("statusCode" => 200, 'Cate' => $_POST["txtCate"]));
            }
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    }
}

if (isset($_GET["addProduct"])) {
    $where = "WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' 
    AND order_list_branch_fk='" . $_SESSION["user_branch"] . "' 
    AND order_list_pro_code_fk='" . $_POST["txtDetailCode"] . "' 
    AND order_list_status_promotion='" . $_POST["txtStatusPro"] . "'
    AND order_list_status_promotion='" . $_POST["txtStatusPro"] . "' 
    AND order_list_status_order IN('1','2')";
    $sqlCount = $db->fn_fetch_rowcount("res_orders_list_edit $where ");
    if ($sqlCount > 0) {

        $price = $_POST["txtPrice"];
        // $qty = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)+floatval($_POST["txtProGif"]);
        $qty = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $total = $price * filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $sqlStock = $db->fn_fetch_rowcount("res_products_detail WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND pro_detail_qty>=0 ");
        if ($sqlStock) {
            if ($_POST["txtCutStock"] == "2") {
                if ($_POST["txtStatusPro"] == "1") {
                    $sql = "pro_detail_qty=pro_detail_qty-'" . $qty . "' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
                    $editQty = $db->fn_edit("res_products_detail", $sql);
                } else {
                    $sql = "pro_detail_qty=pro_detail_qty-'" . $qty . "' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
                    $editQty = $db->fn_edit("res_products_detail", $sql);
                }
            }

            $sqlCheck = $db->fn_fetch_single_all("res_orders_list_edit $where ");


            $sqlOrderQty = "order_list_order_qty=order_list_order_qty+'" . $qty . "',order_list_order_total=order_list_order_qty*'" . $price . "',
            order_list_discount_total=order_list_order_qty*'" . $price . "'-'" . $sqlCheck["order_list_discount_price"] . "',
            order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["txtProGif"] . "',
            order_list_note_remark='" . $_POST["order_list_note_remark"] . "' $where";
            $editOrderQty = $db->fn_edit("res_orders_list_edit", $sqlOrderQty);


            $sqlStockEmpty = $db->fn_fetch_rowcount("view_orders_edit WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND product_cut_stock='2' AND pro_detail_qty='0' ");
            if ($sqlStockEmpty) {
                if ($_POST["txtCutStock"] == "2") {
                    $sql = "pro_detail_open='1' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
                    $editStatus = $db->fn_edit("res_products_detail", $sql);
                }
                echo json_encode(array("statusCode" => 300, 'Cate' => $_POST["txtCate"]));
            } else {
                echo json_encode(array("statusCode" => 300, 'Cate' => $_POST["txtCate"]));
            }
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    } else {
        $auto_number = $db->fn_autonumber("order_list_code", "res_orders_list_edit");
        $price = $_POST["txtPrice"];
        $qty = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $qtyGif = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) + floatval($_POST["txtProGif"]);
        $total = $price * filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $sqlStock = $db->fn_fetch_rowcount("res_products_detail WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND pro_detail_qty>=0 ");

        if (@$_POST["product_notify1"] == "2") {
            $notifyStatus = "1";
        } else {
            $notifyStatus = "2";
        }

        if ($sqlStock) {
            if ($_POST["txtCutStock"] == "2") {
                if ($_POST["txtStatusPro"] == "1") {
                    $sql = "pro_detail_qty=pro_detail_qty-'" . $qtyGif . "' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
                    $editQty = $db->fn_edit("res_products_detail", $sql);
                } else {
                    $sql = "pro_detail_qty=pro_detail_qty-'" . $qtyGif . "' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
                    $editQty = $db->fn_edit("res_products_detail", $sql);
                }
            }

            $sql = "'" . $auto_number . "','" . date("Y-m-d") . "',
            '" . $_SESSION["user_branch"] . "',
            '" . $_POST["bill_no"] . "',
            '" . $_POST["table_no"] . "',
            '" . $_POST["table_no"] . "',
            '" . $_POST["txtDetailCode"] . "',
            '" . $price . "',
            '" . $qty . "',
            '" . $total . "',
            '" . $_POST["txtStatusPro"] . "',
            '" . $_POST["txtProJing"] . "',
            '" . $_POST["txtGifDefault"] . "',
            '" . $_POST["txtProGif"] . "',
            '1',
            '',
            '',
            '',
            '" . $total . "',
            '" . $_POST["txtCutStock"] . "',
            '1',
            '" . $_POST["order_list_note_remark"] . "','" . $notifyStatus . "','" . $notifyStatus . "'";
            $insert = $db->fn_insert("res_orders_list_edit", $sql);
            $sqlStockEmpty = $db->fn_fetch_rowcount("view_orders_edit WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND product_cut_stock='2' AND pro_detail_qty='0' ");
            if ($sqlStockEmpty) {
                if ($_POST["txtCutStock"] == "2") {
                    $sql = "pro_detail_open='1' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
                    $editStatus = $db->fn_edit("res_products_detail", $sql);
                }
                echo json_encode(array("statusCode" => 200, 'Cate' => $_POST["txtCate"]));
            } else {
                echo json_encode(array("statusCode" => 200, 'Cate' => $_POST["txtCate"]));
            }
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    }
}

if (isset($_GET["deleteOrder"])) {
    $idCount = "1";
    $fetchCount = $db->fn_fetch_rowcount("res_orders_list_edit  WHERE order_list_bill_fk='" . $_POST["idBill"] . "'");
    if ($idCount >= $fetchCount) {
        $editStatus = $db->fn_edit("res_tables", "table_status='1' WHERE table_code='" . $_POST["idTb"] . "' ");
    }

    if ($_POST["idStock"] == "2") {
        $sql = "pro_detail_qty=pro_detail_qty+'" . $_POST["totalQty"] . "' WHERE pro_detail_code='" . $_POST["idProduct"] . "' ";
        $editStock = $db->fn_edit("res_products_detail", $sql);
        $sqlStock = "res_orders_list_edit WHERE order_list_code='" . $_POST["idOrder"] . "'";
        $deleteOrder = $db->fn_delete($sqlStock);
        $editStatus = $db->fn_edit("res_products_detail", "pro_detail_open='2' WHERE pro_detail_code='" . $_POST["idProduct"] . "'");
        if ($deleteOrder) {
            echo json_encode(array("statusCode" => 200));
        }
    } else {
        $sqlStock = "res_orders_list_edit WHERE order_list_code='" . $_POST["idOrder"] . "'";
        $deleteOrder = $db->fn_delete($sqlStock);
        if ($deleteOrder) {
            echo json_encode(array("statusCode" => 200));
        }
    }
}

if (isset($_GET["changPlusQty"])) {
    if ($_POST["cutStock"] == "1") {
        $price = $_POST["price"];
        $Qty = $_POST["plusQty"];
        if ($_POST["plus"] == "plus") {
            $sql = "order_list_order_qty=order_list_order_qty+'" . $Qty . "',
            order_list_order_total=order_list_order_qty*'" . $price . "',
            order_list_discount_total=(order_list_order_qty*'" . $price . "'-'" . $_POST["perPrice"] . "'),
            order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["gifQty"] . "'
            WHERE order_list_code='" . $_POST["idOrder"] . "'";
            $editOrder = $db->fn_edit("res_orders_list_edit", $sql);
        } else if ($_POST["plus"] == "minus") {
            $sql = "order_list_order_qty=order_list_order_qty-'" . $Qty . "',
            order_list_order_total=order_list_order_qty*'" . $price . "',
            order_list_discount_total=(order_list_order_qty*'" . $price . "'-'" . $_POST["perPrice"] . "'),
            order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["gifQty"] . "'
            WHERE order_list_code='" . $_POST["idOrder"] . "'";
            $editOrder = $db->fn_edit("res_orders_list_edit", $sql);
        }
    } else {
        $price = $_POST["price"];
        $Qty = $_POST["plusQty"];
        if ($_POST["plus"] == "plus") {
            $sql = "order_list_order_qty=order_list_order_qty+'" . $Qty . "',
            order_list_order_total=order_list_order_qty*'" . $price . "',
            order_list_discount_total=(order_list_order_qty*'" . $price . "'-'" . $_POST["perPrice"] . "'),
            order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["gifQty"] . "'
            WHERE order_list_code='" . $_POST["idOrder"] . "'";
            $editOrder = $db->fn_edit("res_orders_list_edit", $sql);

            $sql1 = "pro_detail_qty=pro_detail_qty-'" . $Qty . "' WHERE pro_detail_code='" . $_POST["proCode"] . "' ";
            $editQty = $db->fn_edit("res_products_detail", $sql1);
            $sqlStockEmpty = $db->fn_fetch_rowcount("res_products_detail WHERE pro_detail_code='" . $_POST["proCode"] . "' AND pro_detail_qty='0' ");
            if ($sqlStockEmpty > 0) {
                $sql2 = "pro_detail_open='1' WHERE pro_detail_code='" . $_POST["proCode"] . "' ";
                $editStatus = $db->fn_edit("res_products_detail", $sql2);
            }
        } else if ($_POST["plus"] == "minus") {
            $sql = "order_list_order_qty=order_list_order_qty-'" . $Qty . "',
            order_list_order_total=(order_list_order_qty)*'" . $price . "',
            order_list_discount_total=(order_list_order_qty*'" . $price . "'-'" . $_POST["perPrice"] . "'),
            order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total-'" . $_POST["gifQty"] . "'
            WHERE order_list_code='" . $_POST["idOrder"] . "'";
            $editOrder = $db->fn_edit("res_orders_list_edit", $sql);

            $sql1 = "pro_detail_qty=pro_detail_qty+'" . $Qty . "' WHERE pro_detail_code='" . $_POST["proCode"] . "' ";
            $editQty = $db->fn_edit("res_products_detail", $sql1);

            $sqlStockEmpty = $db->fn_fetch_rowcount("res_products_detail WHERE pro_detail_code='" . $_POST["proCode"] . "' AND pro_detail_qty='0' ");
            if ($sqlStockEmpty > 0) {
                $sql2 = "pro_detail_open='1' WHERE pro_detail_code='" . $_POST["proCode"] . "' ";
                $editStatus = $db->fn_edit("res_products_detail", $sql2);
            } else {
                $sql3 = "pro_detail_open='2' WHERE pro_detail_code='" . $_POST["proCode"] . "' ";
                $editStatus = $db->fn_edit("res_products_detail", $sql3);
            }
        }
    }
}
if (isset($_GET["editStatusTable"])) {
    $sql = "order_list_status_order='2',order_list_sound_notify='2' WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' AND  order_list_status_order='1'";
    $sqlEdit = $db->fn_edit("res_orders_list_edit", $sql);

    $sqlCheck = $db->fn_fetch_rowcount("res_moves WHERE move_bill_fk_old='" . $_POST["bill_no"] . "' ");
    if ($sqlCheck > 0) {
        $editStatusTable = $db->fn_edit("res_tables", "table_status='3' WHERE table_code='" . $_POST["table_no"] . "'");
    } else {
        $editStatusTable = $db->fn_edit("res_tables", "table_status='2' WHERE table_code='" . $_POST["table_no"] . "'");
    }
}
if (isset($_GET["order_list"])) {
    $sqlOrders = $db->fn_read_all("view_orders_edit WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' 
    AND order_list_table_fk='" . $_POST["table_no"] . "' 
    AND order_list_branch_fk='" . $_SESSION["user_branch"] . "' ORDER BY order_list_code DESC");
    $buttonDisble = $db->fn_fetch_single_all("res_orders_list_edit WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' 
    AND order_list_branch_fk='" . $_SESSION["user_branch"] . "' AND order_list_status_order='1'");
    if ($buttonDisble > 0) {
        $disableds = "";
        $changeBg = "mydiv";
        $iconSpin = "<i class='fa fa-spinner fa-spin fa-fw fa-lg'></i>";
    } else {
        $disableds = "disabled";
        $changeBg = "";
        $iconSpin = "<i class='fa fa-check fa-fw fa-lg'></i>";
    }
    ?>
    <div class="pos-sidebar" id="pos-sidebar">
        <div class="pos-sidebar-header" style="background-color:#db4900;">
            <div class="back-btn">
                <button type="button" data-dismiss-class="pos-mobile-sidebar-toggled" data-target="#pos-customer" class="btn">
                    <svg viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                    </svg>
                </button>
            </div>
            <div class="icon"><img src="https://seantheme.com/color-admin/admin/assets/img/pos/icon-table.svg" /></div>
            <div class="title">ເບີໂຕ <?php echo @$_POST["table_name_list"] ?></div>
            <div class="order">ເລກທີ່: <b>#<?php echo @$_POST["bill_no"] ?></b></div>

            <?php
            @$sqlCount_sound = $db->fn_fetch_single_field("count(case when order_list_status='1' AND order_list_sound_notify='1' then 1 end) as count_cook,
                count(case when order_list_status !='1' AND order_list_sound_notify='1' then 1 end) as count_drink", "res_orders_list_edit 
                WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' AND order_list_sound_notify='1'");
            ?>

            <input type="text" id="sum_cook" hidden value="<?php echo @$sqlCount_sound["count_cook"] ?>">
            <input type="text" id="sum_drink" hidden value="<?php echo @$sqlCount_sound["count_drink"] ?>">
            <input type="text" id="bill_no1" name="bill_no1" hidden value="<?php echo @$_POST["bill_no"] ?>">

        </div>
        <div class="pos-sidebar-nav">
            <ul class="nav nav-tabs nav-fill">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-bs-toggle="tab" data-bs-target="#newOrderTab"><i class="fas fa-bell"></i> ອໍເດີໃໝ່</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="tab" data-bs-target="#orderHistoryTab"> <i class="fas fa-table"></i> ຈັດການໂຕະ</a>
                </li>
            </ul>
        </div>
        <div class="pos-sidebar-body tab-content" style="overflow-x:hidden !important;" data-scrollbar="true" data-height="100%">
            <div class="tab-pane fade h-100 show active" id="newOrderTab">
                <div class="pos-table">
                    <?php
                    if (count($sqlOrders) > 0) {
                        foreach ($sqlOrders as $rowOrders) {

                            if ($rowOrders["product_images"] != "") {
                                $images = 'assets/img/product_home/' . $rowOrders["product_images"];
                            } else {
                                $images = 'assets/img/logo/259987.png';
                            }

                            if ($rowOrders["order_list_status_order"] == "1" || $rowOrders["order_list_status_order"] == "2") {

                                $disabledDelete = "disabled";
                                $disabledConfirm = "";
                            } else {

                                $disabledDelete = "";
                                $disabledConfirm = "disabled";
                            }
                            @$amount1 += $rowOrders["order_list_discount_total"];
                            @$sumQty += $rowOrders["order_list_order_qty"];
                            @$sumpercented += $rowOrders["order_list_discount_price"];
                            @$gif_total += $rowOrders["order_list_qty_promotion_gif_total"];

                            if ($_SESSION["user_permission_fk"] == "202300000002") {
                                if ($rowOrders["product_cut_stock"] == "1") {
                                    $cateDelete = $rowOrders['product_cate_fk'];
                                } else {
                                    $cateDelete = "Promotion_11";
                                }

                    ?>
                                <div class="row pos-table-row">
                                    <div class="col-9">
                                        <div class="pos-product-thumb" ondblclick="fnDiscount('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['order_list_discount_total'] ?>','<?php echo $rowOrders['order_list_order_total'] ?>')">
                                            <div class="img" style="background-image: url(<?php echo $images; ?>);"></div>
                                            <div class="info">
                                                <div class="title"><?php echo $rowOrders["product_name"] ?><?php echo $rowOrders["size_name_la"] ?>
                                                    <?php
                                                    if ($rowOrders["order_list_status_promotion"] == "2") {
                                                        echo "<span class='text-danger' style='font-size:10px'> ( ໂປຣ ) </span>";
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                if ($rowOrders["order_list_status_promotion"] == "1") {
                                                ?>
                                                    <div class="single-price">[ <?php echo $rowOrders["order_list_order_qty"] ?> &nbsp;x &nbsp; <?php echo @number_format($rowOrders["pro_detail_sprice"]) ?> ]</div>
                                                <?php } else { ?>
                                                    <div class="single-price">
                                                        <span class="text-danger">[
                                                            ແຖມ <?php echo $rowOrders["order_list_qty_promotion_gif_total"] ?> ]
                                                        </span>
                                                        [ <?php echo $rowOrders["order_list_order_qty"] ?>
                                                        &nbsp;x &nbsp;
                                                        <?php echo @number_format($rowOrders["pro_detail_sprice"]) ?> ]
                                                    </div>
                                                <?php } ?>
                                                <div class="desc">- ຂະໜາດ : <?php echo $rowOrders["size_name_la"] ?></div>
                                                <div class="desc">- ສ່ວນຫຼຸດ :
                                                    <?php
                                                    if ($rowOrders["order_list_discount_status"] == "2") {
                                                        if ($rowOrders["order_list_discount_percented"] == "1") {
                                                            echo "<span style='border-bottom:1px solid black'>" . $rowOrders["order_list_discount_percented_name"] . " % = ( " . @number_format($rowOrders["order_list_discount_price"]) . " )</span>";
                                                        } else {
                                                            echo "<span style='border-bottom:1px solid black;font-size:12px'>" . @number_format($rowOrders["order_list_discount_price"]) . " ກີບ</span>";
                                                        }
                                                    } else {
                                                        echo "_____";
                                                    }
                                                    ?>
                                                </div>
                                                <div class="desc" style="margin-right:-20px !important">- ໝາຍເຫດ : <?php echo $rowOrders["order_list_note_remark"] ?></div>
                                            </div>
                                        </div>
                                        <?php
                                        if ($rowOrders["order_list_status_order"] == "1" || $rowOrders["order_list_status_order"] == "2") {
                                        ?>
                                            <div class="desc" style="margin-top:-22px;">
                                                <select name="plusQty" id="plusQty<?php echo $rowOrders['order_list_code'] ?>" <?php echo $disabledConfirm ?> onchange="fnPlusQty('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $rowOrders['pro_detail_sprice'] ?>','plus','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_discount_price'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>')">
                                                    <option value="">﹢</option>
                                                    <?php
                                                    if ($rowOrders["product_cut_stock"] == "2") {
                                                        if ($rowOrders["order_list_status_promotion"] == "1") {
                                                            if (@$rowOrders["pro_detail_qty"] >= 100) {
                                                                @$orderLimit = "100";
                                                            } else {
                                                                @$orderLimit = $rowOrders["pro_detail_qty"];
                                                            }
                                                            for ($i = 1; $i <= @$orderLimit; $i++) {
                                                                echo "<option value='" . $i . "'>" . $i . "</option>";
                                                            }
                                                        } else {
                                                            echo "<option value='" . $rowOrders["order_list_qty_promotion_all"] . "'>+" . $rowOrders["order_list_qty_promotion_all"] . "</option>";
                                                        }
                                                    } else {
                                                        for ($i = 1; $i <= 20; $i++) {
                                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <select name="minusQty" id="minusQty<?php echo $rowOrders['order_list_code'] ?>" <?php echo $disabledConfirm ?> onchange="fnPlusQty('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $rowOrders['pro_detail_sprice'] ?>','minus','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_discount_price'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>')">
                                                    <option value="">﹣</option>
                                                    <?php
                                                    $totalQty = $rowOrders["order_list_order_qty"] - 1;
                                                    if ($rowOrders["product_cut_stock"] == "2") {
                                                        if ($rowOrders["order_list_status_promotion"] == "1") {
                                                            for ($i = 1; $i <= ($totalQty); $i++) {
                                                                echo "<option value='" . $i . "'>" . $i . "</option>";
                                                            }
                                                        } else {
                                                            if ($rowOrders["order_list_qty_promotion_gif"] != $rowOrders["order_list_qty_promotion_gif_total"]) {
                                                                echo "<option value='" . $rowOrders["order_list_qty_promotion_all"] . "'>-" . $rowOrders["order_list_qty_promotion_all"] . "</option>";
                                                            } else {
                                                                echo "";
                                                            }
                                                        }
                                                    } else {
                                                        for ($i = 1; $i <= ($totalQty); $i++) {
                                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-3 total-price">
                                    <i class="fas fa-trash text-danger" onclick="fnDeleteOrder('<?php echo $rowOrders['order_list_table_fk'] ?>','<?php echo $rowOrders['order_list_bill_fk'] ?>','<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_order_qty'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $cateDelete; ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>')" style="font-size:14px;cursor:pointer"></i><br>

                                        <span style="font-size:13px !important;">
                                            <?php
                                            if ($rowOrders["order_list_discount_status"] == "2") {
                                                echo "<s class='text-danger'>" . @number_format($rowOrders["order_list_order_total"]) . " ກີບ" . "</s><br>" . @number_format($rowOrders["order_list_discount_total"]) . " ກີບ";
                                            } else {
                                                echo @number_format($rowOrders["order_list_discount_total"]) . " ກີບ";
                                            }
                                            ?>
                                        </span>
                                        <br>
                                        <span class="text-white">.</span>
                                        <br>
                                    </div>
                                </div>

                            <?php } else { ?>
                                <div class="row pos-table-row">
                                    <div class="col-9">
                                        <div class="pos-product-thumb" ondblclick="fnDiscount('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['order_list_discount_total'] ?>','<?php echo $rowOrders['order_list_order_total'] ?>')">
                                            <div class="img" style="background-image: url(<?php echo $images; ?>);"></div>
                                            <div class="info">
                                                <div class="title"><?php echo $rowOrders["product_name"] ?><?php echo $rowOrders["size_name_la"] ?>
                                                    <?php
                                                    if ($rowOrders["order_list_status_promotion"] == "2") {
                                                        echo "<span class='text-danger' style='font-size:10px'> ( ໂປຣ ) </span>";
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                if ($rowOrders["order_list_status_promotion"] == "1") {
                                                ?>
                                                    <div class="single-price">[ <?php echo $rowOrders["order_list_order_qty"] ?> &nbsp;x &nbsp; <?php echo @number_format($rowOrders["pro_detail_sprice"]) ?> ]</div>
                                                <?php } else { ?>
                                                    <div class="single-price">
                                                        <span class="text-danger">[
                                                            ແຖມ <?php echo $rowOrders["order_list_qty_promotion_gif_total"] ?> ]
                                                        </span>
                                                        [ <?php echo $rowOrders["order_list_order_qty"] ?>
                                                        &nbsp;x &nbsp;
                                                        <?php echo @number_format($rowOrders["pro_detail_sprice"]) ?> ]
                                                    </div>
                                                <?php } ?>
                                                <div class="desc">- ຂະໜາດ : <?php echo $rowOrders["size_name_la"] ?></div>
                                                <div class="desc">- ສ່ວນຫຼຸດ :
                                                    <?php
                                                    if ($rowOrders["order_list_discount_status"] == "2") {
                                                        if ($rowOrders["order_list_discount_percented"] == "1") {
                                                            echo "<span style='border-bottom:1px solid black'>" . $rowOrders["order_list_discount_percented_name"] . " % = ( " . @number_format($rowOrders["order_list_discount_price"]) . " )</span>";
                                                        } else {
                                                            echo "<span style='border-bottom:1px solid black;font-size:12px'>" . @number_format($rowOrders["order_list_discount_price"]) . " ກີບ</span>";
                                                        }
                                                    } else {
                                                        echo "_____";
                                                    }
                                                    ?>
                                                </div>
                                                <div class="desc" style="margin-right:-20px !important">- ໝາຍເຫດ : <?php echo $rowOrders["order_list_note_remark"] ?></div>
                                            </div>
                                        </div>
                                        <?php
                                        if ($rowOrders["order_list_status_order"] == "1") {
                                        ?>
                                            <div class="desc" style="margin-top:-22px;">
                                                <select name="plusQty" id="plusQty<?php echo $rowOrders['order_list_code'] ?>" <?php echo $disabledConfirm ?> onchange="fnPlusQty('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $rowOrders['pro_detail_sprice'] ?>','plus','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_discount_price'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>')">
                                                    <option value="">﹢</option>
                                                    <?php
                                                    if ($rowOrders["product_cut_stock"] == "2") {
                                                        if ($rowOrders["order_list_status_promotion"] == "1") {
                                                            if (@$rowOrders["pro_detail_qty"] >= 100) {
                                                                @$orderLimit = "100";
                                                            } else {
                                                                @$orderLimit = $rowOrders["pro_detail_qty"];
                                                            }
                                                            for ($i = 1; $i <= @$orderLimit; $i++) {
                                                                echo "<option value='" . $i . "'>" . $i . "</option>";
                                                            }
                                                        } else {
                                                            echo "<option value='" . $rowOrders["order_list_qty_promotion_all"] . "'>+" . $rowOrders["order_list_qty_promotion_all"] . "</option>";
                                                        }
                                                    } else {
                                                        for ($i = 1; $i <= 20; $i++) {
                                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <select name="minusQty" id="minusQty<?php echo $rowOrders['order_list_code'] ?>" <?php echo $disabledConfirm ?> onchange="fnPlusQty('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $rowOrders['pro_detail_sprice'] ?>','minus','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_discount_price'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>')">
                                                    <option value="">﹣</option>
                                                    <?php
                                                    $totalQty = $rowOrders["order_list_order_qty"] - 1;
                                                    if ($rowOrders["product_cut_stock"] == "2") {
                                                        if ($rowOrders["order_list_status_promotion"] == "1") {
                                                            for ($i = 1; $i <= ($totalQty); $i++) {
                                                                echo "<option value='" . $i . "'>" . $i . "</option>";
                                                            }
                                                        } else {
                                                            if ($rowOrders["order_list_qty_promotion_gif"] != $rowOrders["order_list_qty_promotion_gif_total"]) {
                                                                echo "<option value='" . $rowOrders["order_list_qty_promotion_all"] . "'>-" . $rowOrders["order_list_qty_promotion_all"] . "</option>";
                                                            } else {
                                                                echo "";
                                                            }
                                                        }
                                                    } else {
                                                        for ($i = 1; $i <= ($totalQty); $i++) {
                                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-3 total-price">
                                        <?php
                                        if ($rowOrders["order_list_status_order"] == "1") {
                                            if ($rowOrders["product_cut_stock"] == "1") {
                                                $cateDelete = $rowOrders['product_cate_fk'];
                                            } else {
                                                $cateDelete = "Promotion_11";
                                            }
                                        ?>
                                            <i class="fas fa-trash text-danger" onclick="fnDeleteOrder('<?php echo $rowOrders['order_list_table_fk'] ?>','<?php echo $rowOrders['order_list_bill_fk'] ?>','<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_order_qty'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $cateDelete; ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>')" <?php echo $disabledDelete ?> style="font-size:14px;cursor:pointer"></i><br>
                                        <?php } else { ?>
                                            <i class="fa fa-check text-primary" style="font-size:14px;cursor:pointer"></i><br>
                                        <?php } ?>
                                        <span style="font-size:13px !important;">
                                            <?php
                                            if ($rowOrders["order_list_discount_status"] == "2") {
                                                echo "<s class='text-danger'>" . @number_format($rowOrders["order_list_order_total"]) . " ກີບ" . "</s><br>" . @number_format($rowOrders["order_list_discount_total"]) . " ກີບ";
                                            } else {
                                                echo @number_format($rowOrders["order_list_discount_total"]) . " ກີບ";
                                            }
                                            ?>
                                        </span>
                                        <br>
                                        <span class="text-white">.</span>
                                        <br>
                                    </div>
                                </div>

                        <?php }
                        }
                    } else {
                        $iconSpin = "<i class='fa fa-check fa-fw fa-lg'></i>";
                        $disabledConfirm = "disabled";
                        ?>

                        <div style="height:400px !important;">
                            <div class="h-100 d-flex align-items-center justify-content-center text-center p-20">
                                <div>
                                    <div class="mb-3 mt-n5">
                                        <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                                            <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                                        </svg>
                                    </div>
                                    <h4>ຍັງບໍ່ມີລາຍການ</h4>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>
            <div class="tab-pane fade h-100" id="orderHistoryTab">
                <!-- <div class="row">

                    <div class="col-md-12 mt-1 px-1">
                        <div class="box_table3" onclick="fnMoveTb('urlfetchtbMove','mdRemove','showRemove')">
                            <i class="fas fa-sync-alt fa-2x"></i><br>
                            ຍ້າຍໂຕະ
                        </div>
                    </div>
            
                    <div class="col-md-12 mt-1 px-1" onclick="fnCut_list('<?php echo $_POST['bill_no']?>','<?php echo $_POST['table_no']?>','<?php echo $_POST['table_name_list']?>')">
                        <div class="box_table4" style="background:#023582">
                            <i class="fas fa-money-bill fa-2x"></i><br>
                            ແຍກຈ່າຍ
                        </div>
                    </div>

                </div> -->

                <div style="height:400px !important;">
                    <div class="h-100 d-flex align-items-center justify-content-center text-center p-20">
                        <div>
                            <div class="mb-3 mt-n5">
                                <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                                </svg>
                            </div>
                            <h4>ຍັງບໍ່ມີລາຍການ</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="pos-sidebar-footer" style="font-weight:bold !important;">
            <div class="subtotal">
                <?php
                @$subAmount += (int)substr($amount1, -3);
                if (@$subAmount == "0") {
                    @$subTotal = (@$amount1);
                } else {
                    @$subTotal = ($amount1 - $subAmount) + 1000;
                }
                ?>
                <div class="text">ລວມທັງໝົດ</div>
                <div class="price"><?php echo @number_format($amount1) ?> ກີບ</div>
            </div>
            <div class="taxes">
                <div class="text">ສ່ວນຫຼຸດລາຍການ (%)</div>
                <div class="price">
                    <?php
                    @$subAmount1 += (int)substr($sumpercented, -3);
                    if (@$subAmount1 == "0") {
                        @$subTotal1 = (@$sumpercented);
                    } else {
                        @$subTotal1 = ($sumpercented - $subAmount1) + 1000;
                    }
                    echo @number_format($subTotal1);
                    ?>
                    ກີບ
                </div>
            </div>
            <div class="total">
                <div class="text">ມູນຄ່າຕ້ອງຊໍາລະ</div>
                <div class="price"><?php echo @number_format($subTotal) ?> ກີບ</div>
                <input type="text" hidden value="<?php echo ($subTotal) ?>" id="price_total" name="price_total">
                <input type="text" hidden id="sumQty" name="sumQty" value="<?php echo $sumQty; ?>">
                <input type="text" hidden name="countOrder" id="countOrder" value="<?php echo count($sqlOrders); ?>">
                <input type="text" hidden id="sumlistTotal" name="sumlistTotal" value="<?php echo $subTotal1; ?>">
                <input type="text" hidden id="sumGifTotal" name="sumGifTotal" value="<?php echo $gif_total; ?>">
            </div>
            <div class="btn-row">
                <button type="button" class="btn btn-primary manageBill" id="manageBill"><i class="fa fa-file-invoice-dollar fa-fw fa-lg"></i>ເຊັກບິນ</button>
            </div>
        </div>
    </div>


<?php }

if (isset($_GET["insertCustommer"])) {
    $auto_number = $db->fnBillNumber("cus_code", "res_custommer");
    $sql = "'" . $auto_number . "','" . $_POST["cus_name"] . "','" . $_POST["cus_address"] . "','" . $_POST["cus_tel"] . "'";
    $insert = $db->fn_insert("res_custommer", $sql);

    $cusFull = $db->fn_read_all("res_custommer ORDER BY cus_code DESC");
    foreach ($cusFull as $rowFull) {
        echo "<option value='" . $rowFull["cus_code"] . "'>" . $rowFull["cus_name"] . "</option>";
    }
}
if (isset($_GET["insertAll"])) {

    

    $auto_number = $db->fnBillNumber("list_bill_code", "res_check_bill");
    $bill_no = base64_decode($_POST["bill_no1"]);
    $table_code = ($_POST["table_code1"]);

    $kip = $_POST["list_pay_kip"];
    $bth = $_POST["list_bill_pay_bath"];
    $us = $_POST["list_bill_pay_us"];
    $t_kip = $_POST["transfer_kip"];
    $t_bath = $_POST["transfer_bath"];
    $t_us = $_POST["transfer_us"];

    $deleteBill=$db->fn_delete("res_check_bill WHERE list_bill_no='".$bill_no."' ");
    $deleteBill_list=$db->fn_delete("res_check_bill_list WHERE check_bill_list_bill_fk='".$bill_no."' ");

    if ($_POST["per_price"] != "") {
        $perPrice = filter_var($_POST["per_price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    } else {
        if ($_POST["per_cented"] != "") {
            $percented = filter_var($_POST["per_cented"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $sumPercented = filter_var($_POST["list_bill_amount"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $sliceData = ($sumPercented) * ($percented / 100);

            $sub = substr($sliceData, -3);
            if ($sub == "000") {
                $perPrice = $sliceData;
            } else {
                $perPrice = $sliceData - $sub + 1000;
            }
        } else {
            $perPrice = "";
        }
    }


    if ($_POST["list_bill_type_pay_fk"] == "4") {
        $delete=$db->fn_delete("res_ny","WHERE ny_bill_fk='".$bill_no."' ");
        $auto_number5 = $db->fnBillNumber("ny_code", "res_ny");
        $sqlny = "'" . $auto_number5 . "','" . $bill_no . "','','" . date("Y-m-d") . "','1'";
        $insertNy = $db->fn_insert("res_ny", $sqlny);
        $status_ny='1';
    }else{
        $status_ny='0';
    }


    $sqlBill = "'" . $auto_number . "',
    '" . $_POST["list_bill_date"] . "',
    '" . $_SESSION["users_id"] . "',
    '" . $bill_no . "',
    '" . $_SESSION["user_branch"] . "',
    '" . $table_code . "',
    '" . $_POST["list_rate_bat_kip"] . "',
    '" . $_POST["list_rate_us_kip"] . "',
    '" . $_POST["list_bill_custommer_fk"] . "',
    '" . $_POST["list_bill_type_pay_fk"] . "',
    '" . $_POST["list_bill_qty"] . "',
    '" . $_POST["sumGif_pro"] . "',
    '" . filter_var($_POST["list_bill_amount"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . filter_var($_POST["list_bill_amount_kip"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . filter_var($_POST["list_bill_amount_bath"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . filter_var($_POST["list_bill_amount_us"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . filter_var($_POST["list_pay_kip"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . filter_var($_POST["list_bill_pay_bath"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . filter_var($_POST["list_bill_pay_us"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . filter_var($_POST["transfer_kip"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . filter_var($_POST["transfer_bath"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . filter_var($_POST["transfer_us"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . filter_var($_POST["per_cented"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . filter_var($_POST["per_price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . $perPrice . "',
    '" . filter_var($_POST["list_bill_return"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
    '" . $_POST["list_bill_count_order"] . "',
    '" . filter_var($_POST["sumTotalPercented"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "','1','".date("Y-m-d h:i:sa")."','','','".date("Y-m-d h:i:sa")."','".$_SESSION["users_id"]."','".$status_ny."'";
    $insertBill = $db->fn_insert("res_check_bill", $sqlBill);

    $sqlBillDetail = $db->fn_read_all("res_orders_list_edit WHERE order_list_bill_fk='" . $bill_no . "' ");
    foreach ($sqlBillDetail as $rowBill) {
        $auto_number1 = $db->fnBillNumber("check_bill_list_code", "res_check_bill_list");
        $sqlDetailBill = "'" . $auto_number1 . "',
        '" . $_POST["list_bill_date"] . "',
        '" . $rowBill["order_list_branch_fk"] . "',
        '" . $rowBill["order_list_bill_fk"] . "',
        '" . $rowBill["order_list_table_fk"] . "',
        '" . $rowBill["order_list_pro_code_fk"] . "',
        '" . filter_var($rowBill["order_list_pro_price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
        '" . $rowBill["order_list_order_qty"] . "',
        '" . filter_var($rowBill["order_list_order_total"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
        '" . $rowBill["order_list_status_promotion"] . "',
        '" . $rowBill["order_list_qty_promotion_all"] . "',
        '" . $rowBill["order_list_qty_promotion_gif"] . "',
        '" . $rowBill["order_list_qty_promotion_gif_total"] . "',
        '" . $rowBill["order_list_discount_status"] . "',
        '" . $rowBill["order_list_discount_percented"] . "',
        '" . filter_var($rowBill["order_list_discount_percented_name"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
        '" . filter_var($rowBill["order_list_discount_price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
        '" . filter_var($rowBill["order_list_discount_total"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "',
        '" . $rowBill["order_list_status"] . "',
        '" . $rowBill["order_list_status_order"] . "',
        '" . $rowBill["order_list_note_remark"] . "'";
        $insertBillDetail = $db->fn_insert("res_check_bill_list", $sqlDetailBill);
    }

    echo json_encode(array("statusCode" => 200));
}

if(isset($_GET["cutList"])){
?>

    <div class="row">
        <center>
            <h3 class="font-bold mb-3">ລາຍການແຍກຈ່າຍ<br><span style="font-size:12px;color:#050189">( ສະເພາະໂຕະວ່າງເທົ່ານັ້ນ )</span></h3>
        </center>
        <div class="col-md-4">
            <label for="" class="mb-2">ໂຕະຕົ້ນທາງ <span class="text-danger">*</span></label>
            <input type="text" class="form-control input_color" name="tableStart" readonly value="<?php echo $_POST["tableName"];?>">
            <input type="text" class="form-control input_color" hidden name="tableID" id="tableID" readonly value="<?php echo base64_encode($_POST["tableID"]);?>">
        </div>
        <div class="col-md-4 text-center mt-5">
            <i class="fa-solid fa-chevron-right"></i>
        </div>
        <div class="col-md-4">
            <label for="" class="mb-2">ໂຕະປາຍທາງ <span class="text-danger" style="font-size:12px;">* ( ໂຕະຕ້ອງການແຍກຈ່າຍ )</span></label>
            <select name="tableEnd" id="tableEnd" class="form-select input_color tableEnd" required>
                <option value="">ເລືອກ</option>
                <?php 
                    $sqlTableEnd=$db->fn_read_all("res_tables WHERE table_status !='3' AND table_code !='".($_POST["tableID"])."' ");
                    foreach($sqlTableEnd as $rowTableEnd){
                ?>
                    <option value="<?php echo base64_encode($rowTableEnd["table_code"])?>"><?php if($rowTableEnd["table_status"]=="2"){echo $rowTableEnd["table_name"]." ( ນັ່ງຢູ່ )";}else{echo $rowTableEnd["table_name"];}?></option>
                <?php }?>
            </select>
        </div>
        <div class="col-md-12 mt-4">
            <h3><i class="fas fa-list"></i> ລາຍການອາຫານ</h3>
            <table class="table table-borderless">
                <tr style="border-bottom:1px solid black;">
                    <th>
                        <div class="form-check">
                        <input class="form-check-input checkAll" type="checkbox" value="" id="checkAll">
                        <label class="form-check-label" for="checkAll"></label>
                        </div>
                    </th>
                    <th>ລໍາດັບ</th>
                    <th>ຊື່ລາຍການ</th>
                    <th class="text-center">ຈໍານວນ</th>
                    <th class="text-center">ລາຄາ</th>
                    <th class="text-center">ລາຄາລວມ</th>
                </tr>
                <?php 
                    $i=1;
                    $sqlCutList = $db->fn_read_all("view_orders_edit WHERE order_list_bill_fk='" . $_POST["billNo"] . "' 
                    AND order_list_table_fk='" . $_POST["tableID"] . "' 
                    AND order_list_branch_fk='" . $_SESSION["user_branch"] . "' ORDER BY order_list_code DESC");
                    foreach($sqlCutList as $rowCutList){
                        @$totalOrders+=$rowCutList["order_list_order_total"];
                ?>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input check_list" type="checkbox" name="order_list_code[]" value="<?php echo $rowCutList["order_list_code"]?>" id="<?php echo $rowCutList["order_list_code"]?>">
                                <label class="form-check-label" for="<?php echo $rowCutList["order_list_code"]?>"></label>
                            </div>
                        </td>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $rowCutList["product_name"]?></td>
                        <td align="center"><?php echo $rowCutList["order_list_order_qty"]?></td>
                        <td align="center"><?php echo @number_format($rowCutList["order_list_pro_price"])?></td>
                        <td align="center"><?php echo @number_format($rowCutList["order_list_order_total"])?></td>
                    </tr>
                <?php }?>
                    <tr style="border-top:1px solid black;font-weight:bold;">
                        <td colspan="5" style="font-size:18px">ລວມຍອດ</td>
                        <td align="center" style="font-size:18px"><?php echo @number_format($totalOrders);?></td>
                    </tr>
            </table>
        </div>
        <div class="col-md-12"><hr></div>
        <div class="col-md-10">
            <button type="submit" disabled class="btn btn-primary" id="save_payments"><i class="fas fa-sync-alt"></i> ຢືນຢັນແຍກຈ່າຍ</button>
        </div>
        <div class="col-md-2">
            <a href="javascript:;" style="float:right" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> ປິດ</a>
        </div>
    </div>


<?php }

if (isset($_GET["urlfetchtbMove"])) {
?>

    <div class="col-md-12">
        <h3 class="mb-3 text-center">ຍ້າຍໂຕະ</h3>
        <div class="form-group mb-1">
            <label for="" class="mb-2"><ion-icon name="pricetag-outline"></ion-icon> ໂຕະປັດຈຸບັນ</label>
            <input type="text" class="form-control text-center input_color" id="startTb" name="startTb" value="<?php echo base64_decode($_POST["tableName"]) ?>" readonly style="background-color: #efefef;font-size:20px !important">
            <input type="text" hidden name="billNo" id="billNo" value="<?php echo base64_decode($_POST["billNo"]); ?>">
            <input type="text" hidden name="tableCode" id="tableCode" value="<?php echo $_POST["tableCode"]; ?>">
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <center>
            <ion-icon name="reload-outline" style="font-size:40px"></ion-icon>
        </center>
    </div>
    <div class="col-md-12 mb-2 mt-3">
        <div class="form-group">
            <label for="" class="mb-2" style="font-size:12px"><ion-icon name="pricetags-outline"></ion-icon> 1.ເລືອກໂຊນ <span class="text-danger">*</span></label>
            <select name="table_zone_fk" id="table_zone_fk" class="form-select form-select-lg" required onchange="ChangeZoneMove()">
                <?php
                $res_group = $db->fn_read_all("res_zone ORDER BY zone_code ASC");
                echo "<option value=''>ເລືອກ</option>";
                if (count($res_group) > 0) {
                    foreach ($res_group as $row_group) {
                        echo "<option value='" . $row_group["zone_code"] . "'>" . $row_group["zone_name"] . "</option>";
                    }
                } else {
                    echo "<option value=''>ເລືອກ</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-md-12 mt-2 mb-3 mt-3">
        <div class="form-group mb-1">
            <label for="" class="mb-2"><ion-icon name="pricetags-outline"></ion-icon> 2.ໂຕະປາຍທາງ <span class="text-danger">*</span></label>
            <select class="form-select select2 form-select-lg" name="endTb" id="endTb" required>
                <option value="">ເລືອກ</option>
            </select>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="alert alert-orange text-dark" role="alert">
            <span class="text-danger">ໝາຍເຫດ</span> : ສາມາດຍ້າຍລວມໄດ້ກັບທຸກໂຕະ !
        </div>
    </div>

    

<?php }

if (isset($_GET["urlRemoveTb"])) {

    $sqlStartTb = "table_status='1' WHERE table_code='" . $_POST["tableCode"] . "'";
    $editStartTb = $db->fn_edit("res_tables", $sqlStartTb);
    $sqlEndTb = "table_status='2' WHERE table_code='" . base64_decode($_POST["endTb"]) . "'";
    $editStartTb = $db->fn_edit("res_tables", $sqlEndTb);

    $deleteBill=$db->fn_delete("res_bill WHERE bill_table='".$_POST["tableCode"]."' AND bill_status='1' ");

    $sqlCountTb = $db->fn_fetch_rowcount("res_bill WHERE bill_table='" . base64_decode($_POST["endTb"]) . "' AND bill_status='1' ");
    if ($sqlCountTb == 0) {
        $auto_number1 = $db->fnBillNumber("bill_code", "res_bill");
        $sql = "'" . $auto_number1 . "','" . base64_decode($_POST["endTb"]) . "','" . $_SESSION["user_branch"] . "','1'";
        $insertBill = $db->fn_insert("res_bill", $sql);
    }
    

    $sqlOrder_list_bill1=$db->fn_fetch_single_all("res_bill WHERE bill_table='".base64_decode($_POST["endTb"])."' AND bill_status='1' ");
    $editOrderList=$db->fn_edit("res_orders_list_edit","order_list_bill_fk='".$sqlOrder_list_bill1["bill_code"]."',order_list_table_fk='".base64_decode($_POST["endTb"])."' WHERE order_list_table_fk='".$_POST["tableCode"]."' ");
    
     

}

if (isset($_GET["fetchZoneMoves"])) {
    $sqlTable = $db->fn_read_all("res_tables WHERE table_zone_fk='" . $_POST["table_zone_fk"] . "' AND table_branch_fk='" . $_SESSION["user_branch"] . "' AND table_code !='" . $_POST["table_no"] . "' AND table_status !='3' ");
    if (count($sqlTable) > 0) {
        foreach ($sqlTable as $rowTable) {
            echo "<option value='" . base64_encode($rowTable["table_code"]) . "'>" . $rowTable["table_name"] . "</option>";
        }
    } else {
        echo "<option value=''>ບໍ່ມີລາຍການ</option>";
    }
}

if (isset($_GET["fetchTable"])) {
    $sql = $db->fn_read_all("res_tables WHERE table_zone_fk='" . $_POST["table_zone_fk"] . "' 
        AND table_code !='" . $_POST["table_no"] . "' AND table_branch_fk='" . $_SESSION["user_branch"] . "' AND table_status !='3' ");
    if (count($sql) > 0) {
        foreach ($sql as $row_table) {
            echo "<option id='" . $row_table["table_name"] . "' value='" . $row_table["table_code"] . "'>" . $row_table["table_name"] . "</option>";
        }
    } else {
        echo "<option value=''>ບໍ່ມີລາຍການ</option>";
    }
}

if (isset($_GET["sumTable"])) {
?>
    <input type="text" hidden name="tableCode" id="tableCode" value="<?php echo $_POST["table_no"] ?>">
    <input type="text" hidden name="billCode" id="billCode" value="<?php echo $_POST["bill_no"] ?>">
    <div class="col-md-12 px-0">
        <label for="" class="mb-2">&nbsp;3.ລາຍການໂຕະທີ່ຈະລວມ</label>
        <table class="table">
            <thead class="bg-primary">
                <tr>
                    <th>ເບີໂຕະ</th>
                    <th style="width:40px">ລຶບ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlMove = $db->fn_read_all("res_moves AS A 
                    LEFT JOIN res_tables AS B ON A.move_table_fk=B.table_code 
                    WHERE move_bill_fk_old='" . $_POST["bill_no"] . "' ORDER BY move_code ASC");
                if (count($sqlMove) > 0) {
                    foreach ($sqlMove as $rowMove) {
                        if ($rowMove["move_table_fk"] == $_POST["table_no"]) {
                            $tbName = " ( ໂຕະຫຼັກ )";
                            $disabledMove = "disabled";
                            $bg_text = "text-danger";
                        } else {
                            $tbName = " ( ໂຕະລວມ )";
                            $disabledMove = "";
                            $bg_text = "";
                        }

                        if ($rowMove["move_status_fk"] != "1") {
                            $disabledBtn = "disabled";
                            $changeBackground = "disabled";
                            $disabledSubmit = "";
                        } else {
                            $disabledBtn = "";
                            $changeBackground = "mydiv";
                            $disabledSubmit = "";
                        }

                ?>
                        <tr class="<?php echo $bg_text; ?>">
                            <td>
                                ໂຕະ <?php echo $rowMove["table_name"] . $tbName ?>
                                <input type="text" name="tableID[]" id="tableID" hidden value="<?php echo $rowMove["move_table_fk"] ?>">
                                <input type="text" name="move_table_old_fk" id="move_table_old_fk" hidden value="<?php echo $rowMove["move_table_old_fk"] ?>">
                            </td>
                            <td><button type="button" class="btn btn-danger btn-xs" <?php echo $disabledBtn ?> <?php echo $disabledMove; ?> onclick="fnDelete('<?php echo $rowMove['move_code'] ?>','<?php echo $rowMove['move_table_old_fk'] ?>','<?php echo $rowMove['move_table_fk'] ?>')"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    <?php }
                } else {
                    $disabledSubmit = "disabled";
                    $changeBackground = "";
                    ?>
                    <tr style="border-bottom: 1px solid #ededed !important;color:red;text-align:center">
                        <td colspan="2">ບໍ່ມີລາຍການ</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div style="position: fixed;text-align:left;bottom: 0;width: 100%;">
        <button type="submit" class="btn btn-primary btn-lg <?php echo $changeBackground ?>" <?php echo $disabledSubmit ?> style="width:372px;border-radius: 0px;border:none;"><i class="fas fa-sync-alt"></i> ຢືນຢັນ</button>
    </div>
<?php }
if (isset($_GET["insertMove"])) {
    $autoid = $db->fnBillNumber("move_code", "res_moves");
    $sqlCheck = $db->fn_fetch_rowcount("res_moves WHERE move_table_fk='" . $_POST["tbList"] . "' AND move_status_fk='1'");
    if ($sqlCheck > 0) {
        $checkCount = $db->fn_fetch_rowcount("res_moves WHERE move_bill_fk_old='" . $_POST["bill_no"] . "' AND move_table_old_fk='" . $_POST["tbList"] . "' ");
        if ($checkCount > 0) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo json_encode(array("statusCode" => 201));
        }
        exit;
    } else {
        $sqlID = "'" . $autoid . "','" . $_POST["bill_no"] . "','" . $_POST["table_no"] . "','" . $_POST["tbList"] . "','" . $_SESSION["user_branch"] . "','" . $_SESSION["users_id"] . "','1','" . date("Y-m-d") . "'";
        $sqlInsert = $db->fn_insert("res_moves", $sqlID);
        echo json_encode(array("statusCode" => 200));
    }
}

if (isset($_GET["deleteData"])) {
    $delete = $db->fn_delete("res_moves WHERE move_code='" . $_POST["dataID"] . "'");
    $checkSql = $db->fn_fetch_rowcount("res_tables WHERE table_sum='" . $_POST["oldTable"] . "' AND table_code='" . $_POST["Newtable"] . "' ");
    if ($checkSql > 0) {
        $delete = $db->fn_edit("res_tables", "res_moves WHERE move_code='" . $_POST["dataID"] . "'");
    }
}

if (isset($_GET["editStatusTb"])) {
    $editStatu = $db->fn_edit("res_tables", "table_status='3',table_luck='1',table_sum='" . $_POST["tableCode"] . "' WHERE table_code='" . $_POST["tableCode"] . "'");
    for ($i = 0; $i < count($_POST["tableID"]); $i++) {
        $editStatus = $db->fn_edit("res_moves", "move_status_fk='2' WHERE move_table_fk='" . $_POST["tableID"][$i] . "' ");
        $editStatusTB = $db->fn_edit("res_tables", "table_status='3',table_sum='" . $_POST["move_table_old_fk"] . "' WHERE table_code='" . $_POST["tableID"][$i] . "' ");
        $editList = $db->fn_edit("res_orders_list_edit", "order_list_bill_fk='" . $_POST["billCode"] . "',order_list_table_fk='" . $_POST["tableCode"] . "' WHERE order_list_table_fk='" . $_POST["tableID"][$i] . "' ");
    }
}

if (isset($_GET["editBoken"])) {
    $checkBill = $db->fn_read_all("res_orders_list_edit WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' ");
    if (count($checkBill) > 0) {
        foreach ($checkBill as $rowBill) {
            $selectBill = $db->fn_read_all("res_bill WHERE bill_table='" . $rowBill["order_list_old_table_fk"] . "' ORDER BY bill_code ASC");
            foreach ($selectBill as $rowBill) {
                $editBill = $db->fn_edit("res_orders_list_edit", "order_list_bill_fk='" . $rowBill["bill_code"] . "',order_list_table_fk='" . $rowBill["bill_table"] . "' 
                    WHERE order_list_old_table_fk='" . $rowBill["bill_table"] . "'");
                $editTable = $db->fn_edit("res_tables", "table_status='1',table_luck='0',table_sum='0' WHERE table_sum='" . $rowBill["bill_table"] . "'");
                $deleteBill = $db->fn_delete("res_moves WHERE move_bill_fk_old='" . $_POST["bill_no"] . "'");

                $sqlOrders = $db->fn_read_all("res_orders_list_edit WHERE order_list_old_table_fk='" . $rowBill["bill_table"] . "'");
                foreach ($sqlOrders as $rowOrder) {
                    $editTable = $db->fn_edit("res_tables", "table_status='2' WHERE table_code='" . $rowOrder["order_list_old_table_fk"] . "'");
                }
            }
        }
    }
}

if(isset($_GET["cutlist_url"])){
    $sqlCount = $db->fn_fetch_rowcount("res_bill WHERE bill_table='" . base64_decode($_POST["tableEnd"]) . "' AND bill_status='1' AND bill_branch='" . $_SESSION["user_branch"] . "' ");
    if ($sqlCount>0) {
        $fetchData=$db->fn_fetch_single_all("res_bill WHERE bill_table='" . base64_decode($_POST["tableEnd"]) . "' AND bill_status='1'");
        for($i=0;$i<count($_POST["order_list_code"]);$i++){
            $edit=$db->fn_edit("res_orders_list_edit","order_list_bill_fk='".$fetchData["bill_code"]."',order_list_table_fk='".base64_decode($_POST["tableEnd"])."' WHERE order_list_code='".$_POST["order_list_code"][$i]."' ");
        }
    }else{
        $auto_number = $db->fnBillNumber("bill_code", "res_bill");
        $sql = "'" . $auto_number . "','" . base64_decode($_POST["tableEnd"]) . "','" . $_SESSION["user_branch"] . "','1'";
        $insertBill = $db->fn_insert("res_bill", $sql);
        for($i=0;$i<count($_POST["order_list_code"]);$i++){
            $edit=$db->fn_edit("res_orders_list_edit","order_list_bill_fk='".$auto_number."',order_list_table_fk='".base64_decode($_POST["tableEnd"])."' WHERE order_list_code='".$_POST["order_list_code"][$i]."' ");
        }
    }

    $editTable=$db->fn_edit("res_tables","table_status='2' WHERE table_code='".base64_decode($_POST["tableEnd"])."' ");

    $checkTable = $db->fn_fetch_rowcount("res_orders_list_edit WHERE order_list_table_fk='" . base64_decode($_POST["tableID"]) . "'");
    if($checkTable==0){
        $editTable=$db->fn_edit("res_tables","table_status='1' WHERE table_code='".base64_decode($_POST["tableID"])."' ");
        $deleteBill=$db->fn_delete("res_bill WHERE bill_table='".base64_decode($_POST["tableID"])."' AND bill_status='1' ");
    }

}

?>