<?php
$sqlPro = $db->fn_fetch_single_all("view_promotion WHERE promo_status='1' AND promo_branch_fk='" . $_SESSION["user_branch"] . "'");
if (@$_POST["search_product1"] != "") {
    @$search .= "WHERE pro_detail_code='" . @$_POST["search_product1"] . "' AND promo_branch_fk='" . $_SESSION["user_branch"] . "'";
} else {
    @$search .= "WHERE pro_detail_gif='2' AND TIME(promo_end_time)>TIME(NOW()) AND promo_branch_fk='" . $_SESSION["user_branch"] . "'";
}

$statusPro = "2";
$sql_product = $db->fn_read_all("view_promotion $search");
if (count($sql_product) > 0) {
    foreach ($sql_product as $row_product) {
        $sql_detail = $db->fn_read_all("view_promotion
        WHERE promo_id='" . $row_product["promo_id"] . "' AND promo_branch_fk='" . $_SESSION["user_branch"] . "' AND pro_detail_gif='2' GROUP BY promo_product_fk");
        if ($row_product["product_images"] != "") {
            $images = 'assets/img/product_home/' . $row_product["product_images"];
        } else {
            $images = 'assets/img/logo/259987.png';
        }
        $checkAvilable = $db->fn_fetch_rowcount("view_product_list WHERE pro_detail_product_fk='" . $row_product["promo_product_fk"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' AND pro_detail_open='2'  ");
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
            <div class="product <?php echo $modalId; ?> shadow-md" <?php echo $modalCursor; ?> id="<?php echo $row_product["promo_id"] ?>">
                <input type="text" value="2" hidden id="status_check_gif" name="status_check_gif">
                <div class="img" style="background-image: url(<?php echo $images; ?>)"> </div>

                <div class="text mb-2">
                    <div class="title" style="font-size:14px;text-align:center;color:#0e0e0e;font-weight:bold"><?php echo $row_product["product_name"] ?></div>
                    <?php
                    foreach ($sql_detail as $row_detail) {
                        $stockQty = "[ " . $row_detail["pro_detail_qty"] . " ]";
                        $stock_name = "✓  ມີສະຕ໋ອກ";

                    ?>
                        <div class="price" style="font-size:14px !important;">
                            <?php
                            if ($row_detail["pro_detail_open"] == "1") {
                                echo "<span class='text-danger'>✗</span>";
                                echo "<s>" . $row_detail["size_name_la"] . " <span class='text-danger'>( ໝົດແລ້ວ )</span></s>";
                                echo "<span style='float:right' class='text-danger'>" . @number_format($row_detail["promo_price"]) . "</span>";
                            } else {
                                echo "" . $stockQty . " ";
                                echo $row_detail["size_name_la"];
                                echo "<span style='float:right'>" . @number_format($row_detail["promo_price"]) . "</span>";
                            }
                            if (@$_POST["cate_item"] == "Promotion_11") {
                                echo "<br>";
                                echo "<span style='float:right;font-size:11px;color:#005CBF;'>- ຊື້ " . @($row_detail["promo_qty"]) .
                                    " ແຖມ " . @($row_detail["promo_gif_qty"]) . " = " . @($row_detail["promo_qty_total"]) . " " . $row_product["unite_name"] . "</span>";
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
<?php } ?>