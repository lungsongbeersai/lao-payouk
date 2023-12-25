<?php session_start();
include_once("../config/db.php");

require __DIR__ . '../../../../../vendor/autoload.php';

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

$db = new DBConnection();


if (isset($_GET["product_list"])) {
    $search = "";
    if (@$_POST["cate_item"] == "Promotion_11") {
        include("../../pages/pos/frm-pos-pomition.php");
    } else {
        if (@$_POST["search_product_list"] != "") {
            @$search .= "WHERE product_branch='" . $_SESSION["user_branch"] . "' AND product_name LIKE '%" . @$_POST["search_product_list"] . "%' ";
        } else {
            if (@$_POST["search_product1"] != "") {
                @$search .= "WHERE pro_detail_code='" . @$_POST["search_product1"] . "' AND product_branch='" . $_SESSION["user_branch"] . "'";
            } else {
                @$search .= "WHERE product_cate_fk='" . @$_POST["cate_item"] . "' AND product_branch='" . $_SESSION["user_branch"] . "'";
            }
        }

        $pro_detail_gif = "";
        $statusPro = "1";



        $sql_product = $db->fn_read_all("view_product_list $search GROUP BY pro_detail_product_fk");
        if (count($sql_product) > 0) {
            foreach ($sql_product as $row_product) {
                $sql_detail = $db->fn_read_all("view_product_list
                WHERE pro_detail_product_fk='" . $row_product["product_code"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' $pro_detail_gif ORDER BY pro_detail_code ASC ");
                if ($row_product["product_images"] != "") {
                    $images = '../../api/images/product_home/' . $row_product["product_images"];
                } else {
                    $images = '../../api/images/logo/no_logo.jpg';
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
                    <div class="product <?php echo $modalId; ?> shadow-md" <?php echo $modalCursor; ?> id="<?php echo $row_product["product_code"] ?>">
                        <input type="text" value="<?php echo $statusPro; ?>" hidden id="status_check_gif" name="status_check_gif">
                        <div class="img" style="background-image: url(<?php echo $images; ?>)"></div>

                        <div class="text mb-2">
                            <div class="title" style="font-size:14px;text-align:center;color:#0e0e0e;font-weight:bold"><?php echo $row_product["product_name"] ?></div>
                            <?php
                            foreach ($sql_detail as $row_detail) {
                                if ($row_detail["product_cut_stock"] == "1") {
                                    $stockQty = "";
                                    $stock_name = "✘ ບໍ່ມີສະຕ໋ອກ";
                                } else {
                                    $stockQty = "[ " . $row_detail["pro_detail_qty"] . " ]";
                                    $stock_name = "✓  ມີສະຕ໋ອກ";
                                }

                            ?>
                                <div class="price" style="font-size:14px !important;">
                                    <?php
                                    if ($row_detail["pro_detail_open"] == "1") {
                                        echo "<span class='text-danger'>✗</span>";
                                        echo "<s>" . $row_detail["size_name_la"] . " <span class='text-danger'>( ໝົດແລ້ວ )</span></s>";
                                        if (@$_POST["cate_item"] == "Promotion_11") {
                                            echo "<span style='float:right' class='text-danger'>" . @number_format($row_detail["pro_detail_promotion_price"]) . "</span>";
                                        } else {
                                            echo "<span style='float:right' class='text-danger'>" . @number_format($row_detail["pro_detail_sprice"]) . "</span>";
                                        }
                                    } else {
                                        echo "" . $stockQty . " ";
                                        echo $row_detail["size_name_la"];
                                        if (@$_POST["cate_item"] == "Promotion_11") {
                                            echo "<span style='float:right'>" . @number_format($row_detail["pro_detail_promotion_price"]) . "</span>";
                                        } else {
                                            echo "<span style='float:right'>" . @number_format($row_detail["pro_detail_sprice"]) . "</span>";
                                        }
                                    }
                                    if (@$_POST["cate_item"] == "Promotion_11") {
                                        $promotion = $db->fn_fetch_single_all("res_promotion WHERE promo_product_fk='" . $row_detail["pro_detail_code"] . "'
                                    AND promo_branch_fk='" . $_SESSION["user_branch"] . "' AND promo_status='1'");
                                        echo "<br>";
                                        echo "<span style='float:right;font-size:11px;color:#005CBF;'>- ຊື້ " . @($promotion["promo_qty"]) .
                                            " ແຖມ " . @($promotion["promo_gif_qty"]) . " = " . @($promotion["promo_qty_total"]) . " " . $row_product["unite_name"] . "</span>";
                                    }
                                    ?>

                                </div>
                                <div class="bottom_top"><?php echo $stock_name; ?></div>
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
}

if (isset($_GET["editPercented"])) {
    $discount_amount = filter_var($_POST["discount_amount"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $percented = filter_var($_POST["percented"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    if($_POST["dis_status"]=="2"){
        $dis_status="2";
        $discount_total = filter_var($_POST["discount_total"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }else{
        $dis_status="1";
        $discount_total = filter_var($_POST["discount_amount"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
    $sqlEdit = "order_list_discount_status='".$dis_status."',
    order_list_discount_percented='" . $_POST["type_discount"] . "',
    order_list_discount_percented_name='" . $percented . "',
    order_list_discount_price='" . $discount_amount . "',
    order_list_discount_total='" . $discount_total . "' WHERE order_list_code='" . $_POST["proID"] . "' ";
    $editData = $db->fn_edit("res_orders_list", $sqlEdit);
    echo json_encode(array("statusCode" => 200));
}

if (isset($_GET["editOldprice"])) {
    $sqlEdit = "order_list_discount_status='1',
    order_list_discount_percented='',
    order_list_discount_percented_name='',
    order_list_discount_price='',
    order_list_discount_total='" . $discount_oldPrice . "' WHERE order_list_code='" . $_POST["proID"] . "' ";
    $editData = $db->fn_edit("res_orders_list", $sqlEdit);
}


if (isset($_GET["product_modal"])) {
    echo "<input type='text' hidden value='1' name='userOrder' id='userOrder'>";
    if ($_POST["status_check_gif"] == "1") {
        $sql_detail = $db->fn_fetch_single_all("res_products_list AS A 
        LEFT JOIN res_products_detail AS B ON A.product_code=B.pro_detail_product_fk
        LEFT JOIN res_unite AS C ON A.product_unite_fk=C.unite_code
        WHERE product_code='" . $_POST["modal_products"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' 
        AND pro_detail_open='2' ORDER BY pro_detail_code ASC LIMIT 1");
        if (@$sql_detail["product_images"] != "") {
            $images_detail = '../../api/images/product_home/' . $sql_detail["product_images"];
        } else {
            $images_detail = '../../api/images/logo/no_logo.jpg';
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
                <label for="">- ໝາຍເຫດ</label>
                <input type="text" class="form-control input_color" autocomplete="off" name="order_list_note_remark" id="order_list_note_remark" placeholder="ໝາຍເຫດ">
            </div>
            <div class="option-row">
                <div class="option-title">- ຂະໜາດ</div>
                <div class="option-list">
                    <?php
                    $sql_detail_pos = $db->fn_read_all("view_product_list
                    WHERE pro_detail_product_fk='" . $sql_detail["product_code"] . "' AND pro_detail_open='2' ORDER BY pro_detail_size_fk ASC ");
                    foreach ($sql_detail_pos as $row_detail_pos) {
                        $sqlLimit = $db->fn_fetch_single_all("res_products_detail 
                        WHERE pro_detail_product_fk='" . $sql_detail["product_code"] . "' AND pro_detail_open='2' ORDER BY pro_detail_size_fk ASC LIMIT 1");
                        if ($row_detail_pos["pro_detail_code"] == $sqlLimit["pro_detail_code"]) {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        }
                    ?>
                        <div class="option">
                            <input type="radio" id="size<?php echo $row_detail_pos["pro_detail_code"]; ?>" <?php echo $checked ?> name="size" class="option-input" onclick="fnChangePrice('<?php echo $row_detail_pos['pro_detail_code']; ?>','<?php echo $row_detail_pos['product_cut_stock']; ?>','1','<?php echo $row_detail_pos['pro_detail_qty'] ?>')" />
                            <label class="option-label" for="size<?php echo $row_detail_pos["pro_detail_code"]; ?>" style="cursor:pointer !important; ">
                                <span class="option-text"><?php echo $row_detail_pos["size_name_la"]; ?></span>
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
        $sql_db = "view_promotion
        WHERE promo_id='" . $_POST["modal_products"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' 
        AND pro_detail_open='2' ORDER BY pro_detail_code ASC LIMIT 1";
        $sql_db1 = "view_promotion
        WHERE promo_id='" . $_POST["modal_products"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' 
        AND pro_detail_open='2' AND pro_detail_qty>=promo_qty_total ORDER BY pro_detail_code ASC LIMIT 1";
        $sql_detail = $db->fn_fetch_single_all($sql_db);
        if (@$sql_detail["product_images"] != "") {
            $images_detail = '../../api/images/product_home/' . $sql_detail["product_images"];
        } else {
            $images_detail = '../../api/images/logo/no_logo.jpg';
        }
    ?>
        <div class="pos-product-img">
            <div class="img" style="background-image: url('<?php echo $images_detail; ?>')"></div>
        </div>

        <div class="pos-product-info">
            <div class="title" style="font-weight:bold"><?php echo @$sql_detail["product_name"]; ?></div>
            <div class="qty">ລາຄາ : <span class="badge bg-dark"><span id="title_price"><?php echo @number_format($sql_detail["promo_price"]); ?></span> ກີບ</span></div>
            <hr />
            <div class="qty">
                <div class="input-group" style="width:110px !important;">
                    <input type="text" hidden class="txtDetailCode" id="txtDetailCode" name="txtDetailCode" value="<?php echo $sql_detail['pro_detail_code'] ?>">
                    <input type="text" hidden class="txtCutStock" id="txtCutStock" name="txtCutStock" value="<?php echo $sql_detail['product_cut_stock'] ?>">
                    <input type="text" hidden class="txtUnite" id="txtUnite" name="txtUnite" value="<?php echo $sql_detail['unite_name'] ?>">
                    <input type="text" hidden class="txtQty" id="txtQty" name="txtQty" value="<?php echo $sql_detail['promo_qty_total'] ?>">
                    <input type="text" hidden class="txtPrice" id="txtPrice" name="txtPrice" value="<?php echo $sql_detail['promo_price'] ?>">
                    <input type="text" hidden class="txtCate" id="txtCate" name="txtCate" value="Promotion_11">
                    <input type="text" hidden class="txtStatusPro" id="txtStatusPro" name="txtStatusPro" value="2">
                    <input type="text" hidden class="txtProJing2" id="txtProJing2" name="txtProJing" value="<?php echo $sql_detail['promo_qty'] ?>">
                    <input type="text" hidden class="txtGifDefault2" id="txtGifDefault2" name="txtGifDefault" value="<?php echo $sql_detail['promo_gif_qty'] ?>">
                    <input type="text" hidden class="txtProGif2" id="txtProGif2" name="txtProGif" value="<?php echo $sql_detail['promo_gif_qty'] ?>">
                    <input type="text" hidden class="start_qty2" id="start_qty2" name="start_qty" value="<?php echo $sql_detail['promo_qty'] ?>">
                    <input type="text" hidden class="stock_qty2" id="stock_qty2" name="stock_qty2" value="<?php echo $sql_detail['pro_detail_qty'] ?>">

                    <button type="button" class="btn btn-danger" id="btn_minus" style="background-color:#BF2C24 !important;color:white" onclick="Plus_fn('minus')"><i class="fa fa-minus"></i></button>
                    <input type="text" autocomplete="off" class="form-control border-0 text-center order_list_pro_qty2 order_list_pro_qty" id="order_list_pro_qty" name="order_list_pro_qty" readonly value="<?php echo @$sql_detail['promo_qty'] ?>">
                    <button type="button" class="btn btn-primary" id="btn_plus" style="background-color:#2470bd !important;color:white" onclick="Plus_fn('plus')"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="price mb-2">
                <label for="">- ໝາຍເຫດ</label>
                <input type="text" class="form-control input_color" autocomplete="off" name="order_list_note_remark" id="order_list_note_remark" placeholder="ໝາຍເຫດ">
            </div>
            <div class="option-row">
                <div class="option-title"><b>- ຂະໜາດ</b></div>
                <div class="option-list">
                    <?php
                    $sql_detail_pos = $db->fn_read_all("view_promotion
                    WHERE promo_id='" . @$sql_detail["promo_id"] . "' AND pro_detail_open='2' ORDER BY pro_detail_size_fk ASC ");
                    foreach ($sql_detail_pos as $row_detail_pos) {
                        $sqlLimit = $db->fn_fetch_single_all("res_products_detail 
                        WHERE pro_detail_product_fk='" . $sql_detail["product_code"] . "' AND pro_detail_open='2' ORDER BY pro_detail_size_fk ASC LIMIT 1");
                        if ($row_detail_pos["pro_detail_code"] == $sqlLimit["pro_detail_code"]) {
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
                                    <?php echo @number_format(@$row_detail_pos["promo_price"]); ?>
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
                <?php
                $sql_detail1 = $db->fn_fetch_single_all($sql_db1);
                if ($sql_detail1) {
                ?>
                    <button type="submit" style="cursor:pointer" class="btn btn-primary">ເພີ່ມ <i class="fa fa-plus fa-fw ms-2"></i></button>
                <?php } else { ?>
                    <button type="button" style="cursor:pointer" disabled class="btn btn-orange">ບໍ່ພໍຂາຍ <i class="fa fa-times fa-fw ms-2"></i></button>
                <?php } ?>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> &nbsp;ປິດ</button>
            </div>
        </div>

    <?php }
}

if (isset($_GET["loadsubMenu"])) { ?>
    <div class="row bg-orange" style="height:53px;">
        <div class="col-md-12">
            <input type="text" class="form-control mt-2 text-center" style="border:none" placeholder="ຄົ້ນຫາ..." id="search_product_list" onchange="fn_search_product()" onkeyup="fn_search_product()">
        </div>
    </div>
<?php }

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

// if (isset($_GET["changOrderQty"])) {
//     $where = "WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' 
//     AND order_list_branch_fk='" . $_SESSION["user_branch"] . "' 
//     AND order_list_pro_code_fk='" . $_POST["txtDetailCode"] . "' 
//     AND order_list_status_promotion='" . $_POST["txtStatusPro"] . "' AND order_list_status_order='1' ";
//     $sqlCount = $db->fn_fetch_rowcount("res_orders_list $where ");
//     if ($_POST["txtCutStock"] == "1") {
//         // ບໍ່ຕັດສະຕ໋ອກ
//         $price = $_POST["txtPrice"];
//         $qty = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
//         $qty_plus = $qty + 1;
//         $total = $price * $qty_plus;

//         if ($sqlCount > 0) {
//             // echo $_POST["order_list_pro_qty"];
//             if ($_POST["dataInput"] == "plus") {
//                 $sqlOrderQty = "order_list_order_qty='" . $qty_plus . "',order_list_order_total='" . $total . "'  $where";
//                 $editOrderQty = $db->fn_edit("res_orders_list", $sqlOrderQty);
//             } else if ($_POST["dataInput"] == "minus") {
//                 if ($qty != "1") {
//                     $qtyInput = $qty - 1;
//                     $totalMinus = $qtyInput * $price;
//                     $sqlOrderQty = "order_list_order_qty='" . $qtyInput . "',order_list_order_total='" . $totalMinus . "'  $where";
//                     $editOrderQty = $db->fn_edit("res_orders_list", $sqlOrderQty);
//                 }
//             }
//         }
//     } else {
//         // ຕັດສະຕ໋ອກ

//         $price = $_POST["txtPrice"];
//         $qty = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) + floatval($_POST["txtProGif"]);
//         $total = $price * filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
//         $sqlStock = $db->fn_fetch_rowcount("res_products_detail WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND pro_detail_qty>=0 ");
//         if ($sqlStock) {
//             if ($_POST["txtCutStock"] == "2") {
//                 // if ($_POST["txtStatusPro"] == "1") {
//                 //     $sql = "pro_detail_qty=pro_detail_qty-'" . $qty . "' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
//                 //     $editQty = $db->fn_edit("res_products_detail", $sql);
//                 // } else {
//                 //     $sql = "pro_detail_qty=pro_detail_qty-'" . $qty . "' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
//                 //     $editQty = $db->fn_edit("res_products_detail", $sql);
//                 // }
//                 $sql = "pro_detail_qty=pro_detail_qty-'" . $qty . "' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
//                 $editQty = $db->fn_edit("res_products_detail", $sql);
//             }

//             $sqlOrderQty = "order_list_order_qty=order_list_order_qty+'" . $qty . "',
//             order_list_order_total='" . $total . "',
//             order_list_discount_total='" . $total . "',
//             order_list_note_remark='" . $_POST["order_list_note_remark"] . "' $where";
//             $editOrderQty = $db->fn_edit("res_orders_list", $sqlOrderQty);

//             $sqlStockEmpty = $db->fn_fetch_rowcount("res_products_detail WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND pro_detail_qty='0' ");
//             if ($sqlStockEmpty) {
//                 if ($_POST["txtCutStock"] == "2") {
//                     $sql = "pro_detail_open='1' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
//                     $editStatus = $db->fn_edit("res_products_detail", $sql);
//                 }
//                 echo json_encode(array("statusCode" => 200, 'Cate' => $_POST["txtCate"]));
//             } else {
//                 echo json_encode(array("statusCode" => 200, 'Cate' => $_POST["txtCate"]));
//             }
//         } else {
//             echo json_encode(array("statusCode" => 201));
//         }
//     }
// }

if (isset($_GET["addProduct"])) {
    $where = "WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' 
    AND order_list_branch_fk='" . $_POST["user_branch"] . "' 
    AND order_list_pro_code_fk='" . $_POST["txtDetailCode"] . "' 
    AND order_list_status_promotion='" . $_POST["txtStatusPro"] . "'
    AND order_list_status_order IN('0','1','2')";

    if ($_POST["order_list_status_order_s"] == "1") {
        $statusOrders = "1";
    } else {
        $statusOrders = "0";
    }

    $sqlCount = $db->fn_fetch_rowcount("res_orders_list $where ");
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
                    $total_qty = $qty + $_POST["txtProGif"];
                    $sql = "pro_detail_qty=pro_detail_qty-'" . $total_qty . "' WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' ";
                    $editQty = $db->fn_edit("res_products_detail", $sql);
                }
            }

            $sqlCheck = $db->fn_fetch_single_all("res_orders_list $where ");

            if ($_POST["txtStatusPro"] == "2") {
                $sqlOrderQty = "order_list_order_qty=order_list_order_qty+'" . $qty . "',order_list_order_total=order_list_order_total+'" . $price . "',
                order_list_discount_total=order_list_discount_total+'" . $price . "'-'" . $sqlCheck["order_list_discount_price"] . "',
                order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["txtProGif"] . "',
                order_list_note_remark='" . $_POST["order_list_note_remark"] . "' $where";
                $editOrderQty = $db->fn_edit("res_orders_list", $sqlOrderQty);
            } else {
                $sqlOrderQty = "order_list_order_qty=order_list_order_qty+'" . $qty . "',order_list_order_total=order_list_order_qty*'" . $price . "',
                order_list_discount_total=order_list_order_qty*'" . $price . "'-'" . $sqlCheck["order_list_discount_price"] . "',
                order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["txtProGif"] . "',
                order_list_note_remark='" . $_POST["order_list_note_remark"] . "' $where";
                $editOrderQty = $db->fn_edit("res_orders_list", $sqlOrderQty);
            }

            $sqlStockEmpty = $db->fn_fetch_rowcount("view_orders WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND product_cut_stock='2' AND pro_detail_qty='0' ");
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
        $sqlCountBill = $db->fn_fetch_rowcount("res_bill WHERE bill_code='" . $_POST["bill_no"] . "' AND bill_q='0' ");
        if ($sqlCountBill == "1") {
            $auto_q = $db->fnNumber("bill_q", "res_bill");
            $sqlQ = "bill_date_create='" . date("Y-m-d") . "',bill_q='" . $auto_q . "' WHERE bill_code='" . $_POST["bill_no"] . "'";
            $editQ = $db->fn_edit("res_bill", $sqlQ);
        }

        $editTAbleStatus = $db->fn_edit("res_tables", "table_status='2' WHERE table_code='" . $_POST["table_no"] . "' AND table_branch_fk='" . $_POST["user_branch"] . "'");

        $auto_number = $db->fn_autonumber("order_list_code", "res_orders_list");

        $price = $_POST["txtPrice"];
        $qty = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $qtyGif = filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) + floatval($_POST["txtProGif"]);
        if ($_POST["txtStatusPro"] == "2") {
            if ($_POST["order_list_pro_qty"] == $_POST["txtProJing"]) {
                $total = ($price);
            } else {
                $total = ($_POST["order_list_pro_qty"] / $_POST["txtProJing"]) * ($price);
            }
        } else {
            $total = $price * filter_var($_POST["order_list_pro_qty"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }
        $sqlStock = $db->fn_fetch_rowcount("res_products_detail WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND pro_detail_qty>=0 ");

        if (@$_POST["product_notify1"] == "2") {
            $notifyStatus = "1";
        } else {
            $notifyStatus = "2";
        }

        if ($_POST["userOrder"] == "1") {
            // ສົ່ງຈາກຫນ້າບ້ານ
            $userid = $_SESSION["users_id"];
        } else {
            // ສົ່ງຈາກແອັບ
            $userid = $_POST["users_id"];
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

            $sql = "'" . $auto_number . "',
            '" . date("Y-m-d h:i:sa") . "',
            '" . date("Y-m-d") . "',
            '" . $_POST["user_branch"] . "',
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
            '" . $statusOrders . "',
            '" . $_POST["order_list_note_remark"] . "','" . $notifyStatus . "','" . $notifyStatus . "','1','" . $userid . "'";
            $insert = $db->fn_insert("res_orders_list", $sql);
            $sqlStockEmpty = $db->fn_fetch_rowcount("view_orders WHERE pro_detail_code='" . $_POST["txtDetailCode"] . "' AND product_cut_stock='2' AND pro_detail_qty='0' ");
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
    $fetchCount = $db->fn_fetch_rowcount("res_orders_list  WHERE order_list_bill_fk='" . $_POST["idBill"] . "'");
    if ($idCount >= $fetchCount) {
        $editStatus = $db->fn_edit("res_tables", "table_status='1' WHERE table_code='" . $_POST["idTb"] . "' ");

        $sqlQ = "bill_q='' WHERE bill_code='" . $_POST["idBill"] . "'";
        $editQ = $db->fn_edit("res_bill", $sqlQ);
    }

    if ($_POST["idStock"] == "2") {
        $sql = "pro_detail_qty=pro_detail_qty+'" . $_POST["totalQty"] . "',pro_detail_open='2' WHERE pro_detail_code='" . $_POST["idProduct"] . "' ";
        $editStock = $db->fn_edit("res_products_detail", $sql);
        $sqlStock = "res_orders_list WHERE order_list_code='" . $_POST["idOrder"] . "'";
        $deleteOrder = $db->fn_delete($sqlStock);
        // $editStatus = $db->fn_edit("res_products_detail", "pro_detail_open='2' WHERE pro_detail_code='" . $_POST["idProduct"] . "'");
        if ($deleteOrder) {
            echo json_encode(array("statusCode" => 200));
        }
    } else {
        $sqlStock = "res_orders_list WHERE order_list_code='" . $_POST["idOrder"] . "'";
        $deleteOrder = $db->fn_delete($sqlStock);
        if ($deleteOrder) {
            echo json_encode(array("statusCode" => 200));
        }
    }
}

if (isset($_GET["changPlusQty"])) {
    $price = $_POST["price"];
    $Qty = $_POST["plusQty"];
    if ($_POST["cutStock"] == "2") {
        if ($_POST["plus"] == "plus") {
            if ($_POST["pro_status"] == "2") {
                $sql = "order_list_order_qty=order_list_order_qty+'" . $Qty . "',
                order_list_order_total=order_list_order_total+'" . $price . "',
                order_list_discount_total=(order_list_discount_total+'" . $price . "'-'" . $_POST["perPrice"] . "'),
                order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["gifQty"] . "'
                WHERE order_list_code='" . $_POST["idOrder"] . "'";
            } else {
                $sql = "order_list_order_qty=order_list_order_qty+'" . $Qty . "',
                order_list_order_total=order_list_order_qty*'" . $price . "',
                order_list_discount_total=(order_list_order_qty*'" . $price . "'-'" . $_POST["perPrice"] . "'),
                order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["gifQty"] . "'
                WHERE order_list_code='" . $_POST["idOrder"] . "'";
            }

            $editOrder = $db->fn_edit("res_orders_list", $sql);

            $sql1 = "pro_detail_qty=pro_detail_qty-'" . $_POST["total_qty"] . "' WHERE pro_detail_code='" . $_POST["proCode"] . "' ";
            $editQty = $db->fn_edit("res_products_detail", $sql1);
            $sqlStockEmpty = $db->fn_fetch_rowcount("res_products_detail WHERE pro_detail_code='" . $_POST["proCode"] . "' AND pro_detail_qty='0' ");
            if ($sqlStockEmpty > 0) {
                $sql2 = "pro_detail_open='1' WHERE pro_detail_code='" . $_POST["proCode"] . "' ";
                $editStatus = $db->fn_edit("res_products_detail", $sql2);
            }
        } else if ($_POST["plus"] == "minus") {
            if ($_POST["pro_status"] == "2") {
                $sql = "order_list_order_qty=order_list_order_qty-'" . $Qty . "',
                order_list_order_total=order_list_order_total-'" . $price . "',
                order_list_discount_total=order_list_discount_total-'" . $price . "'-'" . $_POST["perPrice"] . "',
                order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total-'" . $_POST["gifQty"] . "'
                WHERE order_list_code='" . $_POST["idOrder"] . "'";
            } else {
                $sql = "order_list_order_qty=order_list_order_qty-'" . $Qty . "',
                order_list_order_total=(order_list_order_qty)*'" . $price . "',
                order_list_discount_total=(order_list_order_qty*'" . $price . "'-'" . $_POST["perPrice"] . "'),
                order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total-'" . $_POST["gifQty"] . "'
                WHERE order_list_code='" . $_POST["idOrder"] . "'";
            }
            $editOrder = $db->fn_edit("res_orders_list", $sql);

            $sql1 = "pro_detail_qty=pro_detail_qty+'" . $_POST["total_qty"] . "' WHERE pro_detail_code='" . $_POST["proCode"] . "' ";
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
    } else {
        if ($_POST["plus"] == "plus") {
            $sql = "order_list_order_qty=order_list_order_qty+'" . $Qty . "',
            order_list_order_total=order_list_order_qty*'" . $price . "',
            order_list_discount_total=(order_list_order_qty*'" . $price . "'-'" . $_POST["perPrice"] . "'),
            order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["gifQty"] . "'
            WHERE order_list_code='" . $_POST["idOrder"] . "'";
            $editOrder = $db->fn_edit("res_orders_list", $sql);
        } else if ($_POST["plus"] == "minus") {
            $sql = "order_list_order_qty=order_list_order_qty-'" . $Qty . "',
            order_list_order_total=order_list_order_qty*'" . $price . "',
            order_list_discount_total=(order_list_order_qty*'" . $price . "'-'" . $_POST["perPrice"] . "'),
            order_list_qty_promotion_gif_total=order_list_qty_promotion_gif_total+'" . $_POST["gifQty"] . "'
            WHERE order_list_code='" . $_POST["idOrder"] . "'";
            $editOrder = $db->fn_edit("res_orders_list", $sql);
        }
    }
}
if (isset($_GET["editStatusTable"])) {

    $sql = "order_list_status_order='2',order_list_sound_notify='2' WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' AND  order_list_status_order='1'";
    $sqlEdit = $db->fn_edit("res_orders_list", $sql);

    // $sqlOrderList = $db->fn_fetch_single_all("res_orders_list WHERE order_list_bill_fk='" . $_POST["bill_no"] . "'
    // GROUP BY order_list_pro_code_fk Having COUNT(order_list_pro_code_fk) > 1");
    // if(@$sqlOrderList){
    //     $checkOrder=$db->fn_read_single("SUM(order_list_order_qty)as sum_qty,
    //     SUM(order_list_order_total)as sum_amount,
    //     SUM(order_list_discount_total)as sum_total,
    //     SUM(order_list_qty_promotion_all)as sum_pro_amount,
    //     SUM(order_list_qty_promotion_gif)as sum_pro_gif,
    //     SUM(order_list_qty_promotion_gif_total)as sum_pro_total","res_orders_list WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' AND order_list_pro_code_fk='".$sqlOrderList["order_list_pro_code_fk"]."' ");
    //     foreach($checkOrder as $rowOrder){
    //         $sql = "order_list_order_qty='" . $rowOrder["sum_qty"] . "',
    //         order_list_order_total='" . $rowOrder["sum_amount"] . "',
    //         order_list_discount_total='" . $rowOrder["sum_total"] ."',
    //         order_list_qty_promotion_all='" . $rowOrder["sum_pro_amount"] ."',
    //         order_list_qty_promotion_gif='" . $rowOrder["sum_pro_gif"] ."',
    //         order_list_qty_promotion_gif_total='" . $rowOrder["sum_pro_total"] ."',
    //         order_list_discount_percented='0',
    //         order_list_discount_percented_name='0',
    //         order_list_discount_price='0'
    //         WHERE order_list_bill_fk='" . $_POST["bill_no"] . "'
    //         AND order_list_pro_code_fk='".$sqlOrderList["order_list_pro_code_fk"]."' ";
    //         $editOrder = $db->fn_edit("res_orders_list", $sql);

    //         $limitOrder=$db->fn_fetch_single_all("res_orders_list WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' 
    //         AND order_list_pro_code_fk='".$rowOrder["order_list_pro_code_fk"]."'  ORDER BY order_list_code DESC LIMIT 1");

    //         $deleteOrder=$db->fn_delete("res_orders_list WHERE order_list_code='".$sqlOrderList["order_list_code"]."' AND order_list_status_order='2'");
    //     }
    // }

    $sqlCheck = $db->fn_fetch_rowcount("res_moves WHERE move_bill_fk_old='" . $_POST["bill_no"] . "' ");
    if ($sqlCheck > 0) {
        $editStatusTable = $db->fn_edit("res_tables", "table_status='3' WHERE table_code='" . $_POST["table_no"] . "'");
    } else {
        $editStatusTable = $db->fn_edit("res_tables", "table_status='2' WHERE table_code='" . $_POST["table_no"] . "'");
    }

    echo "200";
    // try {
    //     $sql = "order_list_status_order='2',order_list_sound_notify='2' WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' AND  order_list_status_order='1'";
    //     $sqlEdit = $db->fn_edit("res_orders_list", $sql);

    //     $sqlCheck = $db->fn_fetch_rowcount("res_moves WHERE move_bill_fk_old='" . $_POST["bill_no"] . "' ");
    //     if ($sqlCheck > 0) {
    //         $editStatusTable = $db->fn_edit("res_tables", "table_status='3' WHERE table_code='" . $_POST["table_no"] . "'");
    //     } else {
    //         $editStatusTable = $db->fn_edit("res_tables", "table_status='2' WHERE table_code='" . $_POST["table_no"] . "'");
    //     }

    //     $fontFile = '../../assets/css/fonts/Saysettha-Bold.ttf';
    //     $y = 50;
    //     $sqlPreview=$db->fn_read_all("view_orders WHERE order_list_bill_fk='".$_POST["bill_no"]."' AND order_list_status_order='2' AND printer_status='1' AND printer_branch_fk='".$_SESSION["user_branch"]."' ORDER BY order_list_code ASC ");
    //     if(count($sqlPreview)>0){

    //         foreach($sqlPreview AS $rowPreview){
    //             $connector = new NetworkPrintConnector($rowPreview["printer_address"], 9100);
    //             $printer = new Printer($connector);
    //             if($printer){
    //                 $lineHeight = 40; // Height of each line of text
    //                 $lineHeight1 = 30; // Height of each line of text
    //                 $imageHeight = 230;
    //                 $image = imagecreatetruecolor(1000, $imageHeight);
    //                 $backgroundColor = imagecolorallocate($image, 255, 255, 255);
    //                 $textColor = imagecolorallocate($image, 0, 0, 0);
    //                 imagefill($image, 0, 0, $backgroundColor);

    //                 // Write the title and subtitle
    //                 imagettftext($image, 40, 0, 0, $y, $textColor, $fontFile, "ເບີໂຕະ : " . $rowPreview["table_name"]);
    //                 imagettftext($image, 14, 0, 0, $y+$lineHeight,$textColor, $fontFile, "ວັນທີ : " . date('d/m/Y h:i:s')." ( ຮັບອໍເດີ : ".$rowPreview["users_name"]." )");
    //                 imagettftext($image, 18, 0, 0, $y + $lineHeight+40, $textColor, $fontFile, "--------------------------------------------------------------------------------");
    //                 imagettftext($image, 20, 0, 0, $y + $lineHeight+80, $textColor, $fontFile, "- " . $rowPreview["product_name"] .$rowPreview["size_name_la"]. "   x   ".$rowPreview["order_list_order_qty"]);
    //                 imagettftext($image, 19, 0, 0, $y + $lineHeight+130, $textColor, $fontFile, "ໝາຍເຫດ : " . $rowPreview["order_list_note_remark"]);

    //                 // Save the image with a unique filename
    //                 $imagePath = "../../assets/img/ConfirmImage/".$rowPreview["order_list_code"].".png";
    //                 ImagePng($image, $imagePath);
    //                 imagedestroy($image);
    //                 // echo '<img src="MyResize/image'.$i.'.png" alt="Image">';

    //                 $image = EscposImage::load($imagePath);
    //                 $printer->setJustification(Printer::JUSTIFY_CENTER);
    //                 $printer->bitImage($image);
    //                 $printer->pulse();
    //                 $printer->cut();
    //                 unlink($imagePath);
    //                 $printer->close();
    //             }else{
    //                 echo "201";
    //             }
    //         }

    //         $sqlOrderList = $db->fn_fetch_single_all("res_orders_list WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' GROUP BY order_list_pro_code_fk Having COUNT(order_list_pro_code_fk) > 1");
    //         if (@$sqlOrderList) {
    //             $checkOrder = $db->fn_read_single("SUM(order_list_order_qty)as sum_qty,
    //             SUM(order_list_order_total)as sum_amount,
    //             SUM(order_list_discount_total)as sum_total,
    //             SUM(order_list_qty_promotion_all)as sum_pro_amount,
    //             SUM(order_list_qty_promotion_gif)as sum_pro_gif,
    //             SUM(order_list_qty_promotion_gif_total)as sum_pro_total", "res_orders_list WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' AND order_list_pro_code_fk='" . $sqlOrderList["order_list_pro_code_fk"] . "'");
    //             foreach ($checkOrder as $rowOrder) {
    //                 $sql = "order_list_order_qty='" . $rowOrder["sum_qty"] . "',
    //                 order_list_order_total='" . $rowOrder["sum_amount"] . "',
    //                 order_list_discount_total='" . $rowOrder["sum_total"] . "',
    //                 order_list_qty_promotion_all='" . $rowOrder["sum_pro_amount"] . "',
    //                 order_list_qty_promotion_gif='" . $rowOrder["sum_pro_gif"] . "',
    //                 order_list_qty_promotion_gif_total='" . $rowOrder["sum_pro_total"] . "',
    //                 order_list_discount_percented='0',
    //                 order_list_discount_percented_name='0',
    //                 order_list_discount_price='0'
    //                 WHERE order_list_bill_fk='" . $_POST["bill_no"] . "'
    //                 AND order_list_pro_code_fk='" . $sqlOrderList["order_list_pro_code_fk"] . "'";
    //                 $editOrder = $db->fn_edit("res_orders_list", $sql);

    //                 $limitOrder = $db->fn_fetch_single_all("res_orders_list WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' 
    //                 AND order_list_pro_code_fk='" . $sqlOrderList["order_list_pro_code_fk"] . "' ORDER BY order_list_code DESC LIMIT 1");

    //                 $deleteOrder = $db->fn_delete("res_orders_list WHERE order_list_code='" . $limitOrder["order_list_code"] . "' ");
    //             }
    //         }

    //         $sql = "order_list_status_order='5' WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' AND  order_list_status_order='2'";
    //         $sqlEdit = $db->fn_edit("res_orders_list", $sql);
    //         if($sqlEdit){
    //             echo "200";
    //         }
    //     }else{
    //         echo "201";
    //     }
    // } catch (Exception $e) {
    //     echo "201";
    // }
}
if (isset($_GET["order_list"])) {
    $sqlOrders = $db->fn_read_all("view_orders WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' 
    AND order_list_table_fk='" . $_POST["table_no"] . "' 
    AND order_list_branch_fk='" . $_SESSION["user_branch"] . "' ORDER BY order_list_code DESC");
    $buttonDisble = $db->fn_fetch_single_all("res_orders_list WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' 
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
            <div class="title">ເບີໂຕະ <span style="font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;font-size:20px;color:yellow"><?php echo @$_POST["table_name_list"] ?></span></div>
            <div class="order">ເລກທີ່: <b>#<?php echo @$_POST["bill_no"] ?></b></div>

            <?php
            @$sqlCount_sound = $db->fn_fetch_single_field("count(case when order_list_status='1' AND order_list_sound_notify='1' AND order_list_date='" . DATE("Y-m-d") . "' then 1 end) as count_cook,
                count(case when order_list_status !='1' AND order_list_sound_notify='1' AND order_list_date='" . DATE("Y-m-d") . "' then 1 end) as count_drink", "res_orders_list 
                WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' AND order_list_sound_notify='1' AND order_list_date='" . DATE("Y-m-d") . "'");
            ?>

            <input type="text" id="sum_cook" hidden value="<?php echo @$sqlCount_sound["count_cook"] ?>" style="width:50px;">
            <input type="text" id="sum_drink" hidden value="<?php echo @$sqlCount_sound["count_drink"] ?>" style="width:50px;">
            <input type="text" id="branch_id" hidden value="<?php echo $_SESSION["user_branch"]; ?>" style="width:50px;">

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
                                $images_home = '../../api/images/product_home/' . $rowOrders["product_images"];
                            } else {
                                $images_home = '../../api/images/logo/no_logo.jpg';
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
                            $s_price = "0";
                            if ($rowOrders["order_list_status_promotion"] == "1") {
                                $s_price = $rowOrders['pro_detail_sprice'];
                            } else {
                                $s_price = $rowOrders['pro_detail_promotion_price'];
                            }



                            $sumQtyAll = "0";
                            $sumQtyAll = ($rowOrders['order_list_qty_promotion_gif'] + $rowOrders['order_list_qty_promotion_all']);

                            // if($rowOrders['pro_detail_qty']>$sumQtyAll){
                            //     $disabled_opt="disabled";
                            // }else{
                            //     $disabled_opt="";
                            // }

                            if ($_SESSION["user_permission_fk"] == "202300000002") {
                                if ($rowOrders["pro_detail_gif"] == "1") {
                                    $cateDelete = $rowOrders['product_cate_fk'];
                                } else {
                                    $cateDelete = "Promotion_11";
                                }

                    ?>
                                <div class="row pos-table-row">
                                    <div class="col-9">
                                        <div class="pos-product-thumb" ondblclick="fnDiscount('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['order_list_discount_total'] ?>','<?php echo $rowOrders['order_list_order_total'] ?>')">
                                            <div class="img" style="background-image: url(<?php echo $images_home; ?>);"></div>
                                            <div class="info">
                                                <div class="title"><?php echo $rowOrders["product_name"] ?>
                                                    <?php
                                                    if ($rowOrders["order_list_status_promotion"] == "2") {
                                                        $sql_promotion = $db->fn_fetch_single_all("res_promotion WHERE promo_product_fk='" . $rowOrders['order_list_pro_code_fk'] . "' AND promo_branch_fk='" . $rowOrders['order_list_branch_fk'] . "' ");
                                                        echo "<span class='text-danger' style='font-size:10px'> ( ຊື້ " . $sql_promotion["promo_qty"] . " ແຖມ " . $sql_promotion["promo_gif_qty"] . ") </span>";
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                if ($rowOrders["order_list_status_promotion"] == "1") {
                                                ?>
                                                    <div class="single-price">[ <?php echo $rowOrders["order_list_order_qty"] ?> &nbsp;x &nbsp; <?php echo @number_format($rowOrders["pro_detail_sprice"]) ?> ]</div>
                                                <?php } else { ?>
                                                    <div class="single-price">
                                                        <span class="text-danger">
                                                            [<?php echo $rowOrders["order_list_order_qty"] ?> ແຖມ <?php echo $rowOrders["order_list_qty_promotion_gif_total"] ?>
                                                        </span>
                                                        =
                                                        <?php echo $rowOrders["order_list_order_qty"] + $rowOrders["order_list_qty_promotion_gif_total"] ?>
                                                        &nbsp;x &nbsp;
                                                        <?php
                                                        echo @number_format($sql_promotion["promo_price"]);
                                                        ?>
                                                        ]
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
                                                <div class="desc" style="margin-right:-20px !important">- ໝາຍເຫດ : <?php echo $rowOrders["order_list_note_remark"] ?>

                                                </div>
                                            </div>
                                        </div>
                                        <?php

                                        if ($rowOrders["order_list_status_order"] == "1" || $rowOrders["order_list_status_order"] == "2") {
                                        ?>
                                            <div class="desc" style="margin-top:-22px;">
                                                <select name="plusQty" id="plusQty<?php echo $rowOrders['order_list_code'] ?>" <?php echo $disabledConfirm ?> onchange="fnPlusQty('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $s_price ?>','plus','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_discount_price'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>','<?php echo $rowOrders['order_list_status_promotion'] ?>','<?php echo $sumQtyAll; ?>')">
                                                    <?php
                                                    if ($rowOrders["product_cut_stock"] == "2") {
                                                        if ($rowOrders["order_list_status_promotion"] == "1") {
                                                            if (@$rowOrders["pro_detail_qty"] >= 100) {
                                                                @$orderLimit = "100";
                                                            } else {
                                                                @$orderLimit = $rowOrders["pro_detail_qty"];
                                                            }
                                                            echo "<option value=''>﹢</option>";
                                                            for ($i = 1; $i <= @$orderLimit; $i++) {
                                                                echo "<option value='" . $i . "'>" . $i . "</option>";
                                                            }
                                                        } else {
                                                            $total_pro = ($rowOrders["order_list_qty_promotion_all"] + $rowOrders["order_list_qty_promotion_gif"]);
                                                            if ($rowOrders["pro_detail_qty"] >= $total_pro) {
                                                                echo "<option value=''>﹢</option>";
                                                                echo "<option value='" . $rowOrders["order_list_qty_promotion_all"] . "'>+" . $rowOrders["order_list_qty_promotion_all"] . "</option>";
                                                            } else {
                                                                echo "<option value=''>ໝົດ</option>";
                                                            }
                                                        }
                                                    } else {
                                                        for ($i = 1; $i <= 20; $i++) {
                                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <select name="minusQty" id="minusQty<?php echo $rowOrders['order_list_code'] ?>" <?php echo $disabledConfirm ?> onchange="fnPlusQty('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $s_price ?>','minus','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_discount_price'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>','<?php echo $rowOrders['order_list_status_promotion'] ?>','<?php echo $sumQtyAll; ?>')">
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
                                        <button type="button" class="btn btn-xs btn-danger" onclick="fnDeleteOrder('<?php echo $rowOrders['order_list_table_fk'] ?>','<?php echo $rowOrders['order_list_bill_fk'] ?>','<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_order_qty'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $cateDelete; ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>')">
                                            <i class="fas fa-trash" style="font-size:14px;cursor:pointer"></i>
                                        </button>

                                        <br>
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
                                            <div class="img" style="background-image: url(<?php echo $images_home; ?>);"></div>
                                            <div class="info">
                                                <div class="title"><?php echo $rowOrders["product_name"] ?>
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
                                                <div class="desc" style="margin-right:-20px !important">- ໝາຍເຫດ : <?php echo $rowOrders["order_list_note_remark"] ?>
                                                </div>
                                            </div>
                                        </div>

                                        <?php

                                        if ($rowOrders["order_list_status_order"] == "1") {
                                        ?>
                                            <div class="desc" style="margin-top:-22px;">
                                                <select name="plusQty" id="plusQty<?php echo $rowOrders['order_list_code'] ?>" <?php echo $disabledConfirm ?> onchange="fnPlusQty('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $s_price ?>','plus','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_discount_price'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>','<?php echo $rowOrders['order_list_status_promotion'] ?>','<?php echo $sumQtyAll; ?>')">

                                                    <?php
                                                    if ($rowOrders["product_cut_stock"] == "2") {
                                                        if ($rowOrders["order_list_status_promotion"] == "1") {
                                                            if (@$rowOrders["pro_detail_qty"] >= 100) {
                                                                @$orderLimit = "100";
                                                            } else {
                                                                @$orderLimit = $rowOrders["pro_detail_qty"];
                                                            }
                                                            echo "<option value=''>﹢</option>";
                                                            for ($i = 1; $i <= @$orderLimit; $i++) {
                                                                echo "<option value='" . $i . "'>" . $i . "</option>";
                                                            }
                                                        } else {
                                                            // echo "<option value='" . $rowOrders["order_list_qty_promotion_all"] . "'>+" . $rowOrders["order_list_qty_promotion_all"] . "</option>";
                                                            $total_pro = ($rowOrders["order_list_qty_promotion_all"] + $rowOrders["order_list_qty_promotion_gif"]);
                                                            if ($rowOrders["pro_detail_qty"] >= $total_pro) {
                                                                echo "<option value=''>﹢</option>";
                                                                echo "<option value='" . $rowOrders["order_list_qty_promotion_all"] . "'>+" . $rowOrders["order_list_qty_promotion_all"] . "</option>";
                                                            } else {
                                                                echo "<option value=''>ໝົດ</option>";
                                                            }
                                                        }
                                                    } else {
                                                        for ($i = 1; $i <= 20; $i++) {
                                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <select name="minusQty" id="minusQty<?php echo $rowOrders['order_list_code'] ?>" <?php echo $disabledConfirm ?> onchange="fnPlusQty('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $s_price ?>','minus','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_discount_price'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>','<?php echo $rowOrders['order_list_status_promotion'] ?>','<?php echo $sumQtyAll; ?>')">
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
                                            <button type="button" class="btn btn-xs btn-danger" onclick="fnDeleteOrder('<?php echo $rowOrders['order_list_table_fk'] ?>','<?php echo $rowOrders['order_list_bill_fk'] ?>','<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_order_qty'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $cateDelete; ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>')">
                                                <i class="fas fa-trash" style="font-size:14px;cursor:pointer"></i>
                                            </button>
                                            <br>
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
                <div class="row">

                    <div class="col-md-6 mt-1 px-1">
                        <div class="box_table3" onclick="fnMoveTb('urlfetchtbMove','mdRemove','showRemove')">
                            <i class="fas fa-sync-alt fa-2x"></i><br>
                            ຍ້າຍໂຕະ
                        </div>
                    </div>

                    <div class="col-md-6 mt-1 px-1">
                        <div class="box_table2" data-bs-toggle="offcanvas" href="#communal_table">
                            <i class="far fa-clipboard fa-2x"></i><br>
                            ລວມໂຕະ
                        </div>
                    </div>

                    <!-- <div class="col-md-6 mt-1 px-1">
                        <div class="box_table0" onclick="fnHistoryTb()">
                            <i class="far fa-clipboard fa-2x"></i><br>
                            ປະຫວັດຍ້າຍໂຕະ
                        </div>
                    </div> -->

                    <!-- <div class="col-md-6 mt-1 px-1">
                        <div class="box_table1" data-bs-toggle="offcanvas" href="#offcanvasEndExample">
                            <i class="fas fa-user-friends fa-2x"></i><br>
                            ຕໍ່ໂຕະ
                        </div>
                    </div> -->
                    <!-- 
                    <?php
                    $checkTable = $db->fn_fetch_single_all("res_tables WHERE table_code='" . $_POST["table_no"] . "' AND table_sum !='0'");
                    if ($checkTable) {
                    ?>
                        <div class="col-md-6 mt-1 px-1">
                            <div class="box_table2" id="bokenTb">
                                <i class="fas fa-user-check fa-2x"></i><br>
                                ແຍກໂຕະ
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-6 mt-1 px-1">
                            <div class="box_table2" disabled>
                                <i class="fas fa-user-check fa-2x"></i><br>
                                ແຍກໂຕະ <br><span style='font-size:12px;color:#02ff9e'>( ຍັງບໍ່ມີໂຕະແຍກ )</span>
                            </div>
                        </div>
                    <?php } ?> -->
                    <div class="col-md-12 mt-1 px-1" onclick="fnCut_list('<?php echo $_POST['bill_no'] ?>','<?php echo $_POST['table_no'] ?>','<?php echo $_POST['table_name_list'] ?>')">
                        <div class="box_table4" style="background:#023582">
                            <i class="fas fa-money-bill fa-2x"></i><br>
                            ແຍກຈ່າຍ
                        </div>
                    </div>

                    <!-- <div class="col-md-12 mt-1 px-1">
                        <div class="box_table4">
                            <i class="fas fa-shopping-cart fa-2x"></i><br>
                            ຝາກເຄື່ອງດຶ່ມ
                        </div>
                    </div> -->
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
                <button type="button" class="btn btn-secondary idQrcode" id="idQrcode"><i class="fa fa-qrcode fa-fw fa-lg"></i> ພິມ QR Code</button>
                <button type="button" class="btn btn-success <?php echo @$changeBg; ?>" id="confirm_orders" <?php echo @$disableds; ?>><?php echo @$iconSpin; ?><span id="textConfirm"> ຢືນຢັນອໍເດີ</span></button>
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


    // if ($_POST["list_bill_type_pay_fk"] == "4") {
    //     $auto_number5 = $db->fnBillNumber("ny_code", "res_ny");
    //     $sqlny = "'" . $auto_number5 . "','" . $bill_no . "','','" . date("Y-m-d") . "','1'";
    //     $insertNy = $db->fn_insert("res_ny", $sqlny);
    // }

    if ($_POST["list_bill_type_pay_fk"] == "4") {
        $auto_number5 = $db->fnBillNumber("ny_code", "res_ny");
        $sqlny = "'" . $auto_number5 . "','" . $bill_no . "','','" . date("Y-m-d") . "','1'";
        $insertNy = $db->fn_insert("res_ny", $sqlny);
        $status_ny = '1';
    } else {
        $status_ny = '0';
    }

    $sqlOrderBill = $db->fn_fetch_single_all("res_orders_list WHERE order_list_bill_fk='" . $bill_no . "' ");

    $sqlBill = "'" . $auto_number . "',
    '" . date("Y-m-d") . "',
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
    '" . filter_var($_POST["sumTotalPercented"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "','1','" . date("Y-m-d h:i:sa") . "','','','" . date("Y-m-d h:i:sa") . "','" . $sqlOrderBill["order_list_create_by"] . "','" . $status_ny . "'";
    $insertBill = $db->fn_insert("res_check_bill", $sqlBill);

    $sqlBillDetail = $db->fn_read_all("res_orders_list WHERE order_list_bill_fk='" . $bill_no . "' ");
    foreach ($sqlBillDetail as $rowBill) {
        $auto_number1 = $db->fnBillNumber("check_bill_list_code", "res_check_bill_list");
        $sqlDetailBill = "'" . $auto_number1 . "',
        '" . date("Y-m-d") . "',
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

if (isset($_GET["cutList"])) {
?>

    <div class="row">
        <center>
            <h3 class="font-bold mb-3">ລາຍການແຍກຈ່າຍ<br><span style="font-size:12px;color:#050189">( ສະເພາະໂຕະວ່າງເທົ່ານັ້ນ )</span></h3>
        </center>
        <div class="col-md-4">
            <label for="" class="mb-2">ໂຕະຕົ້ນທາງ <span class="text-danger">*</span></label>
            <input type="text" class="form-control input_color" name="tableStart" readonly value="<?php echo $_POST["tableName"]; ?>">
            <input type="text" class="form-control input_color" hidden name="tableID" id="tableID" readonly value="<?php echo base64_encode($_POST["tableID"]); ?>">
            <input type="text" id="billNo" name="billNo" hidden value="<?php echo $_POST["billNo"]; ?>">
        </div>
        <div class="col-md-4 text-center mt-5">
            <i class="fa-solid fa-chevron-right"></i>
        </div>
        <div class="col-md-4">
            <label for="" class="mb-2">ໂຕະປາຍທາງ <span class="text-danger" style="font-size:12px;">* ( ໂຕະຕ້ອງການແຍກຈ່າຍ )</span></label>
            <select name="tableEnd" id="tableEnd" class="form-select input_color tableEnd" required>
                <option value="">ເລືອກ</option>
                <?php
                $sqlTableEnd = $db->fn_read_all("res_tables WHERE table_status='1' AND table_code !='" . ($_POST["tableID"]) . "' AND table_branch_fk='" . $_SESSION["user_branch"] . "' ");
                foreach ($sqlTableEnd as $rowTableEnd) {
                ?>
                    <option value="<?php echo base64_encode($rowTableEnd["table_code"]) ?>">
                        <?php if ($rowTableEnd["table_status"] == "2") {
                            echo $rowTableEnd["table_name"] . " ( ນັ່ງຢູ່ )";
                        } else {
                            echo $rowTableEnd["table_name"];
                        } ?>
                    </option>
                <?php } ?>
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
                    <th class="text-center">ຈໍານວນລວມ</th>
                    <th class="text-center">ຈໍານວນແຍກຈ່າຍ</th>
                    <th class="text-center">ລາຄາ</th>
                    <th class="text-center">ລາຄາລວມ</th>
                </tr>
                <?php
                $j = 1;
                $sqlCutList = $db->fn_read_all("view_orders WHERE order_list_bill_fk='" . $_POST["billNo"] . "' 
                    AND order_list_table_fk='" . $_POST["tableID"] . "' 
                    AND order_list_branch_fk='" . $_SESSION["user_branch"] . "' AND order_list_status_checkBill='1' ORDER BY order_list_code DESC");
                foreach ($sqlCutList as $rowCutList) {
                    @$totalOrders += $rowCutList["order_list_pro_price"] * $rowCutList["order_list_order_qty"];
                ?>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input check_list" type="checkbox" name="order_list_code[]" value="<?php echo $rowCutList["order_list_code"] ?>" id="<?php echo $rowCutList["order_list_code"] ?>">
                                <label class="form-check-label" for="<?php echo $rowCutList["order_list_code"] ?>"></label>
                            </div>
                        </td>
                        <td><?php echo $j++; ?></td>
                        <td><?php echo $rowCutList["product_name"] ?>-<?php echo $rowCutList["size_name_la"] ?></td>
                        <td align="center"><?php echo $rowCutList["order_list_order_qty"] ?></td>
                        <td align="center">
                            <input type="text" id="broken_qty_old<?php echo $rowCutList["order_list_code"] ?>" class="broken_qty_old" name="broken_qty_old[]" hidden disabled value="<?php echo $rowCutList["order_list_order_qty"] ?>">
                            <select name="broken_qty_new[]" id="broken_qty_new<?php echo $rowCutList["order_list_code"] ?>" class="broken_qty_new" disabled style="width:60px !important">
                                <?php
                                for ($i = 1; $i <= ($rowCutList["order_list_order_qty"]); $i++) {
                                    if ($i == $rowCutList["order_list_order_qty"]) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                ?>
                                    <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td align="center">
                            <?php echo @number_format($rowCutList["order_list_pro_price"]) ?>
                            <input type="text" name="order_price_sale[]" id="order_price_sale<?php echo $rowCutList["order_list_code"] ?>" class="order_price_sale" hidden disabled value="<?php echo $rowCutList["order_list_pro_price"] ?>">
                        </td>
                        <td align="center"><?php echo @number_format($rowCutList["order_list_pro_price"] * $rowCutList["order_list_order_qty"]) ?></td>
                    </tr>
                <?php } ?>
                <tr style="border-top:1px solid black;font-weight:bold;">
                    <td colspan="6" style="font-size:18px">ລວມຍອດ</td>
                    <td align="center" style="font-size:18px"><?php echo @number_format($totalOrders); ?></td>
                </tr>
            </table>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-10">
            <button type="submit" disabled class="btn btn-primary" id="save_payments"><i class="fas fa-sync-alt"></i> ຢືນຢັນແຍກຈ່າຍ</button>
        </div>
        <div class="col-md-2">
            <a href="javascript:;" style="float:right" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> ປິດ</a>
        </div>
    </div>


<?php }

if (isset($_GET["cutlist_url"])) {
    $sqlCount = $db->fn_fetch_rowcount("res_bill WHERE bill_table='" . base64_decode($_POST["tableEnd"]) . "' AND bill_status='1' AND bill_branch='" . $_SESSION["user_branch"] . "' ");
    $fnBill = $db->fn_fetch_single_all("res_bill WHERE bill_table='" . base64_decode($_POST["tableEnd"]) . "' AND bill_status='1' AND bill_branch='" . $_SESSION["user_branch"] . "'");
    if ($sqlCount > 0) {
        $auto_number = $fnBill["bill_code"];
    } else {
        $auto_number = $db->fnBillNumber("bill_code", "res_bill");
        $sqlBill = "'" . $auto_number . "','" . base64_decode($_POST["tableEnd"]) . "','" . $_SESSION["user_branch"] . "','1'";
        $insertBill = $db->fn_insert("res_bill", $sqlBill);
    }
    for ($i = 0; $i < count($_POST["order_list_code"]); $i++) {

        $order_price_sale = filter_var($_POST["order_price_sale"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $order_news = filter_var($_POST["broken_qty_new"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $order_old = filter_var($_POST["broken_qty_old"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $total_price = ($order_price_sale) * ($order_news);
        $old_qty = ($order_old) - ($order_news);
        $total_qty_price = ($old_qty) * ($order_price_sale);
        $fetchData = $db->fn_read_all("res_orders_list WHERE order_list_bill_fk='" . $_POST["billNo"] . "' AND order_list_code='" . $_POST["order_list_code"][$i] . "'");

        if ($_POST["broken_qty_old"][$i] == $_POST["broken_qty_new"][$i]) {
            // echo "bb";
            $edit_orders = $db->fn_edit("res_orders_list", "order_list_bill_fk='" . $auto_number . "',
                    order_list_table_fk='" . base64_decode($_POST["tableEnd"]) . "',
                    order_list_status_promotion='1',
                    order_list_qty_promotion_all='0',
                    order_list_qty_promotion_gif='0',
                    order_list_qty_promotion_gif_total='0',
                    order_list_discount_status='0',
                    order_list_discount_percented='0',
                    order_list_discount_percented_name='0',
                    order_list_discount_price='0'
                    WHERE order_list_bill_fk='" . $_POST["billNo"] . "' AND order_list_code='" . $_POST["order_list_code"][$i] . "' ");
            $editTable = $db->fn_edit("res_tables", "table_status='2' WHERE table_code='" . base64_decode($_POST["tableEnd"]) . "' ");
        } else {
            foreach ($fetchData as $rowData) {
                $auto_number_order = $db->fnBillNumber("order_list_code", "res_orders_list");
                $sqlOrders = "'" . $auto_number_order . "','" . date("Y-m-d H:i:sa") . "','" . date("Y-m-d") . "',
                    '" . $_SESSION["user_branch"] . "',
                    '" . $auto_number . "',
                    '" . base64_decode($_POST["tableEnd"]) . "',
                    '" . base64_decode($_POST["tableID"]) . "',
                    '" . $rowData["order_list_pro_code_fk"] . "',
                    '" . $order_price_sale . "',
                    '" . $order_news . "',
                    '" . $total_price . "',
                    '1',
                    '0',
                    '0',
                    '0',
                    '1',
                    '',
                    '0',
                    '0',
                    '" . $total_price . "',
                    '" . $rowData["order_list_status"] . "',
                    '" . $rowData["order_list_status_order"] . "',
                    '" . $rowData["order_list_note_remark"] . "',
                    '" . $rowData["order_list_sound_notify"] . "',
                    '" . $rowData["order_list_count_cook_drink"] . "',
                    '1',
                    '" . $_SESSION["users_id"] . "'";

                $insertOrder = $db->fn_insert("res_orders_list", $sqlOrders);

                $edit_orders = $db->fn_edit("res_orders_list", "order_list_order_qty='" . $old_qty . "',
                    order_list_order_total='" . $total_qty_price . "',
                    order_list_status_promotion='1',
                    order_list_qty_promotion_all='0',
                    order_list_qty_promotion_gif='0',
                    order_list_qty_promotion_gif_total='0',
                    order_list_discount_status='0',
                    order_list_discount_percented='0',
                    order_list_discount_percented_name='0',
                    order_list_discount_price='0',
                    order_list_discount_total='" . $total_qty_price . "'
                    WHERE order_list_bill_fk='" . $_POST["billNo"] . "' AND order_list_code='" . $_POST["order_list_code"][$i] . "' ");

                $editTable = $db->fn_edit("res_tables", "table_status='2' WHERE table_code='" . base64_decode($_POST["tableEnd"]) . "' ");
            }
        }

        $checkTable = $db->fn_fetch_rowcount("res_orders_list WHERE order_list_table_fk='" . base64_decode($_POST["tableID"]) . "'");
        if ($checkTable == 0) {
            $editTable = $db->fn_edit("res_tables", "table_status='1' WHERE table_code='" . base64_decode($_POST["tableID"]) . "' ");
            $deleteBill = $db->fn_delete("res_bill WHERE bill_table='" . base64_decode($_POST["tableID"]) . "' AND bill_status='1' ");
        }
    }
}

if (isset($_GET["urlfetchtbMove"])) {
?>

    <div class="col-md-12">
        <h3 class="mb-3 text-center">ຍ້າຍໂຕະ</h3>
        <div class="form-group mb-1">
            <label for="" class="mb-2"> 1.ໂຕະປັດຈຸບັນ</label>
            <input type="text" class="form-control text-center input_color" id="startTb" name="startTb" value="<?php echo base64_decode($_POST["tableName"]) ?>" readonly style="background-color: #efefef;font-size:20px !important;font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">
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
            <label for="" class="mb-2" style="font-size:12px"> 2.ເລືອກໂຊນ <span class="text-danger">*</span></label>
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
            <label for="" class="mb-2"> 3.ໂຕະປາຍທາງ <span class="text-danger">*</span></label>
            <select class="form-select select2 form-select-lg" name="endTb" id="endTb" required>
                <option value="">ເລືອກ</option>
            </select>
        </div>
    </div>



<?php }

if (isset($_GET["urlRemoveTb"])) {

    $sqlCountTb = $db->fn_fetch_rowcount("res_bill WHERE bill_table='" . base64_decode($_POST["endTb"]) . "' AND bill_branch='" . $_SESSION["user_branch"] . "' AND bill_status='1' ");
    if ($sqlCountTb > 0) {
        $sqlFetchOrder = $db->fn_fetch_single_all("res_bill WHERE bill_table='" . base64_decode($_POST["endTb"]) . "' AND bill_status='1'");
        $editOrderList = $db->fn_edit("res_orders_list", "order_list_table_fk='" . $editOrderList["bill_table"] . "' WHERE order_list_bill_fk='" . $sqlFetchOrder["bill_code"] . "' ");
        $editBill = $db->fn_edit("res_bill", "bill_table='" . $editOrderList["bill_table"] . "' WHERE bill_code='" . ($sqlFetchOrder["bill_code"]) . "' ");
        if ($editStartTb) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    } else {
        $editOrderList = $db->fn_edit("res_orders_list", "order_list_table_fk='" . base64_decode($_POST["endTb"]) . "' WHERE order_list_bill_fk='" . $_POST["billNo"] . "' ");
        $editBill = $db->fn_edit("res_bill", "bill_table='" . base64_decode($_POST["endTb"]) . "' WHERE bill_code='" . ($_POST["billNo"]) . "' ");
        $sqlStartTb = "table_status='1' WHERE table_code='" . $_POST["tableCode"] . "'";
        $editStartTb = $db->fn_edit("res_tables", $sqlStartTb);
        $sqlEndTb = "table_status='2' WHERE table_code='" . base64_decode($_POST["endTb"]) . "'";
        $editStartTb = $db->fn_edit("res_tables", $sqlEndTb);

        if ($editStartTb) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    }
}

if (isset($_GET["fetchZoneMoves"])) {
    $sqlTable = $db->fn_read_all("res_tables WHERE table_zone_fk='" . $_POST["table_zone_fk"] . "' AND table_branch_fk='" . $_SESSION["user_branch"] . "' AND table_code !='" . $_POST["table_no"] . "' AND table_status='1' ");
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
        $editList = $db->fn_edit("res_orders_list", "order_list_bill_fk='" . $_POST["billCode"] . "',order_list_table_fk='" . $_POST["tableCode"] . "' WHERE order_list_table_fk='" . $_POST["tableID"][$i] . "' ");
    }
}

if (isset($_GET["editBoken"])) {
    $checkBill = $db->fn_read_all("res_orders_list WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' ");
    if (count($checkBill) > 0) {
        foreach ($checkBill as $rowBill) {
            $selectBill = $db->fn_read_all("res_bill WHERE bill_table='" . $rowBill["order_list_old_table_fk"] . "' ORDER BY bill_code ASC");
            foreach ($selectBill as $rowBill) {
                $editBill = $db->fn_edit("res_orders_list", "order_list_bill_fk='" . $rowBill["bill_code"] . "',order_list_table_fk='" . $rowBill["bill_table"] . "' 
                    WHERE order_list_old_table_fk='" . $rowBill["bill_table"] . "'");
                $editTable = $db->fn_edit("res_tables", "table_status='1',table_luck='0',table_sum='0' WHERE table_sum='" . $rowBill["bill_table"] . "'");
                $deleteBill = $db->fn_delete("res_moves WHERE move_bill_fk_old='" . $_POST["bill_no"] . "'");

                $sqlOrders = $db->fn_read_all("res_orders_list WHERE order_list_old_table_fk='" . $rowBill["bill_table"] . "'");
                foreach ($sqlOrders as $rowOrder) {
                    $editTable = $db->fn_edit("res_tables", "table_status='2' WHERE table_code='" . $rowOrder["order_list_old_table_fk"] . "'");
                }
            }
        }
    }
}


if (isset($_GET["url_communal_table"])) {
    $data = [];
    if ($_POST["zone_fk"] != "") {
        $where = "WHERE table_zone_fk='" . $_POST["zone_fk"] . "' AND table_code !='" . $_POST["communal_table_code"] . "' AND table_branch_fk='" . $_SESSION["user_branch"] . "'";
    } else {
        $where = "WHERE table_code !='" . $_POST["communal_table_code"] . "' AND table_branch_fk='" . $_SESSION["user_branch"] . "'";
    }
    $sql = $db->fn_read_all("res_tables $where ORDER BY table_status DESC");
    foreach ($sql as $row) {
        $data[] = $row;
    }
    echo json_encode(array($data));
}

if (isset($_GET["url_insert_communal_table"])) {
    for ($i = 0; $i < count($_POST["checkData"]); $i++) {
        // ອັບເດດໂຕະໃຫ້ເປັນໂຕະປາຍທາງ
        $updateOrder = $db->fn_edit("res_orders_list", " order_list_bill_fk='" . $_POST["communal_table_bill"] . "', order_list_table_fk='" . $_POST["communal_table_code"] . "' ,order_list_old_table_fk='" . $_POST["communal_table_code"] . "' 
        WHERE order_list_table_fk='" . $_POST["checkData"][$i] . "' AND order_list_status_checkBill='1' AND order_list_branch_fk='" . $_SESSION["user_branch"] . "' ");
        // ອັບເດດໂຕະວ່າງ
        $updateTable = $db->fn_edit("res_tables", " table_status='1',table_sum='0',table_luck='0' WHERE table_code='" . $_POST["checkData"][$i] . "' AND table_branch_fk='" . $_SESSION["user_branch"] . "'");
        // ລຶບເລກໂຕະອອກຈາກຕາລາງບິນ
        $deleteBill = $db->fn_delete("res_bill WHERE bill_status='1' AND bill_table='" . $_POST["checkData"][$i] . "' AND bill_branch='" . $_SESSION["user_branch"] . "'");
    }

    $rowCount = $db->fn_fetch_rowcount("res_orders_list WHERE order_list_bill_fk='" . $_POST["communal_table_bill"] . "' AND order_list_status_order!='1' ");
    if ($rowCount) {
        $updateTable = $db->fn_edit("res_tables", " table_status='2'  WHERE table_code='" . $_POST["communal_table_code"] . "' AND table_branch_fk='" . $_SESSION["user_branch"] . "'");
    }
}

?>