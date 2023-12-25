<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
date_default_timezone_set('Asia/Bangkok');
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="' . rand() . '.xls"');
echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">';
@$query .= "view_product_titel ";

if ($_POST["product_branch"] != "" && $_POST["product_group_fk"] != "" && $_POST["product_cate_fk"] != "" && $_POST["search_page"] != "") {
    $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%" . $_POST["search_page"] . "%' ");
    if ($rowCount > 0) {
        $query .= " WHERE product_branch='" . $_POST["product_branch"] . "' 
                AND product_group_fk='" . $_POST["product_group_fk"] . "' 
                AND product_cate_fk='" . $_POST["product_cate_fk"] . "' ";
        $query .= " AND product_name LIKE '%" . $_POST["search_page"] . "%'";
    } else {
        $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%" . $_POST["search_page"] . "%' ");
        if ($rowCount > 0) {
            $query .= " WHERE product_branch='" . $_POST["product_branch"] . "' 
                    AND product_group_fk='" . $_POST["product_group_fk"] . "' 
                    AND product_cate_fk='" . $_POST["product_cate_fk"] . "' ";
            $query .= " AND product_name LIKE '%" . $_POST["search_page"] . "%'";
        } else {
            $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%" . $_POST["search_page"] . "%' ");
            if ($rowCount > 0) {
                $query .= " WHERE product_branch='" . $_POST["product_branch"] . "' 
                        AND product_group_fk='" . $_POST["product_group_fk"] . "' 
                        AND product_cate_fk='" . $_POST["product_cate_fk"] . "' ";
                $query .= " AND cate_name LIKE '%" . $_POST["search_page"] . "%'";
            } else {
                $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%" . $_POST["search_page"] . "%' ");
                if ($rowCount > 0) {
                    $query .= " WHERE product_branch='" . $_POST["product_branch"] . "' 
                            AND product_group_fk='" . $_POST["product_group_fk"] . "' 
                            AND product_cate_fk='" . $_POST["product_cate_fk"] . "' ";
                    $query .= " AND group_name LIKE '%" . $_POST["search_page"] . "%'";
                } else {
                    $query .= "WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                }
            }
        }
    }
} else if ($_POST["product_branch"] != "" && $_POST["product_group_fk"] != "" && $_POST["product_cate_fk"] != "" && $_POST["search_page"] == "") {
    $query .= " WHERE product_branch='" . $_POST["product_branch"] . "' 
                AND product_group_fk='" . $_POST["product_group_fk"] . "' 
                AND product_cate_fk='" . $_POST["product_cate_fk"] . "' ";
} else if ($_POST["product_branch"] != "" && $_POST["product_group_fk"] == "" && $_POST["product_cate_fk"] == "" && $_POST["search_page"] == "") {
    $query .= " WHERE product_branch='" . $_POST["product_branch"] . "'";
} else if ($_POST["product_branch"] == "" && $_POST["product_group_fk"] != "" && $_POST["product_cate_fk"] != "" && $_POST["search_page"] == "") {
    $query .= " WHERE product_group_fk='" . $_POST["product_group_fk"] . "' AND product_cate_fk='" . $_POST["product_cate_fk"] . "' ";
} else if ($_POST["product_branch"] == "" && $_POST["product_group_fk"] != "" && $_POST["product_cate_fk"] != "" && $_POST["search_page"] != "") {
    $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%" . $_POST["search_page"] . "%' ");
    if ($rowCount > 0) {
        $query .= " WHERE product_group_fk='" . $_POST["product_group_fk"] . "' AND product_cate_fk='" . $_POST["product_cate_fk"] . "' ";
        $query .= " AND product_name LIKE '%" . $_POST["search_page"] . "%'";
    } else {
        $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%" . $_POST["search_page"] . "%' ");
        if ($rowCount > 0) {
            $query .= " WHERE product_group_fk='" . $_POST["product_group_fk"] . "' AND product_cate_fk='" . $_POST["product_cate_fk"] . "' ";
            $query .= " AND product_name LIKE '%" . $_POST["search_page"] . "%'";
        } else {
            $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%" . $_POST["search_page"] . "%' ");
            if ($rowCount > 0) {
                $query .= " WHERE product_group_fk='" . $_POST["product_group_fk"] . "' AND product_cate_fk='" . $_POST["product_cate_fk"] . "' ";
                $query .= " AND cate_name LIKE '%" . $_POST["search_page"] . "%'";
            } else {
                $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%" . $_POST["search_page"] . "%' ");
                if ($rowCount > 0) {
                    $query .= " WHERE product_group_fk='" . $_POST["product_group_fk"] . "' AND product_cate_fk='" . $_POST["product_cate_fk"] . "' ";
                    $query .= " AND group_name LIKE '%" . $_POST["search_page"] . "%'";
                } else {
                    $query .= "WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                }
            }
        }
    }
} else if ($_POST["product_branch"] == "" && $_POST["product_group_fk"] == "" && $_POST["product_cate_fk"] == "" && $_POST["search_page"] != "") {
    $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%" . $_POST["search_page"] . "%' ");
    if ($rowCount > 0) {
        $query .= " WHERE product_name LIKE '%" . $_POST["search_page"] . "%'";
    } else {
        $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%" . $_POST["search_page"] . "%' ");
        if ($rowCount > 0) {
            $query .= " WHERE product_name LIKE '%" . $_POST["search_page"] . "%'";
        } else {
            $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%" . $_POST["search_page"] . "%' ");
            if ($rowCount > 0) {
                $query .= " WHERE cate_name LIKE '%" . $_POST["search_page"] . "%'";
            } else {
                $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%" . $_POST["search_page"] . "%' ");
                if ($rowCount > 0) {
                    $query .= " WHERE group_name LIKE '%" . $_POST["search_page"] . "%'";
                } else {
                    $query .= "WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                }
            }
        }
    }
} else if ($_POST["product_branch"] != "" && $_POST["product_group_fk"] == "" && $_POST["product_cate_fk"] == "" && $_POST["search_page"] != "") {
    $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%" . $_POST["search_page"] . "%' ");
    if ($rowCount > 0) {
        $query .= " WHERE product_name LIKE '%" . $_POST["search_page"] . "%'";
    } else {
        $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%" . $_POST["search_page"] . "%' ");
        if ($rowCount > 0) {
            $query .= " WHERE product_name LIKE '%" . $_POST["search_page"] . "%'";
        } else {
            $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%" . $_POST["search_page"] . "%' ");
            if ($rowCount > 0) {
                $query .= " WHERE cate_name LIKE '%" . $_POST["search_page"] . "%'";
            } else {
                $rowCount = $db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%" . $_POST["search_page"] . "%' ");
                if ($rowCount > 0) {
                    $query .= " WHERE group_name LIKE '%" . $_POST["search_page"] . "%'";
                } else {
                    $query .= "WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                }
            }
        }
    }
} else {
    $query .= "";
}


if ($_POST["order_page"] != "") {
    $query .= " ORDER BY product_code " . $_POST["order_page"] . " ";
} else {
    $query .= "";
}




$fetch_sql = $db->fn_read_all($query);
$total_data = $db->fn_fetch_rowcount($query);
$total_id =1;

?>
<style>
    table,tr,td,th,h2,h3,h4{
        font-family: Phetsarath OT !important;
    }
</style>

<body>
    <center>
        <h3>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</h3>
        <h3 style="margin-top: -20px;">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h3>
        <h2>ລາຍການອາຫານ</h2>
    </center>
    <table border="0" style="border-collapse: collapse;width:100%;">
        <thead>
            <tr style="font-weight:600;font-size:18px !important;height:40px;vertical-align:middle;border-bottom:1px solid black">
                <td width="5%" align="center">ລໍາດັບ</td>
                <td>ໝວດໝູ່</td>
                <td>ສາຂາ</td>
                <td width="7%">ສະຖານະ</td>
                <td align="center">ລະຫັດອາຫານ</td>
                <td>ຊື່ອາຫານ/ເຄື່ອງດຶ່ມ</td>
                <td align="center">ຂະໜາດ</td>
                <td align="center">ຫົວໜ່ວຍ</td>
                <td align="center">ຈໍານວນ</td>
                <td align="center">ລາຄາຊື້</td>
                <td align="center">ລາຄາຂາຍ</td>
                
            </tr>
        </thead>
        <tbody>
            <?php
            if ($total_data > 0) {
                foreach ($fetch_sql as $row_sql) {
                    if ($row_sql["product_images"]) {
                        $img = "assets/img/product_home/" . $row_sql["product_images"];
                    } else {
                        $img = "assets/img/logo/no_image.png";
                    }

                    if ($row_sql["product_notify"] == "1") {
                        $togle_check1 = "";
                        $notify1 = "<span class='text-danger'>ບໍ່ແຈ້ງເຕືອນ</span>";
                    } else {
                        $togle_check1 = "checked";
                        $notify1 = "ແຈ້ງເຕືອນ";
                    }
            ?>
                    <tr style="vertical-align:middle;<?php echo $bg2 ?>;height:40px">
                        <td align="center"><?php echo $total_id++; ?></td>
                        <td><?php echo $row_sql["cate_name"] ?></td>
                        <td><?php echo $row_sql["branch_name"] ?></td>
                        <td>
                            <?php if ($row_sql["product_cut_stock"] == "1") {
                                echo "<span class='text-danger'>ບໍ່ຕັດສະຕ໋ອກ</span>";
                            } else if ($row_sql["product_cut_stock"] == "2") {
                                echo "<span class='text-primary'>ຕັດສະຕ໋ອກ</span>";
                            } else if ($row_sql["product_cut_stock"] == "3") {
                                echo "<span class='text-danger'>ບໍ່ຕັດສະຕ໋ອກ</span>";
                            } ?>
                        </td>
                    </tr>
                    <?php
                    $j = 1;
                    $sqlDetail = $db->fn_read_all("view_product_list WHERE pro_detail_product_fk='" . $row_sql["product_code"] . "'");
                    foreach ($sqlDetail as $rowDetail) {
                        if ($rowDetail["pro_detail_open"] == "1") {
                            $togle_check = "";
                            $bg = "color:red !important;text-decoration: line-through";
                            $open = "<span class='text-danger'>ປິດ</span>";
                        } else {
                            $togle_check = "checked";
                            $bg = "";
                            $open = "<span class='text-blue'>ເປິດ</span>";
                        }
                    ?>
                        <tr style="<?php echo $bg ?>;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="center"><?php echo $rowDetail["pro_detail_code"] ?></td>
                            <td><?php echo $rowDetail["product_name"] ?></td>
                            <td align="center"><?php echo $rowDetail["size_name_la"] ?></td>
                            <td align="center"><?php echo $rowDetail["unite_name"] ?></td>
                            <td align="center"><?php echo @number_format($rowDetail["pro_detail_qty"]) ?></td>
                            <td align="center"><?php echo @number_format($rowDetail["pro_detail_bprice"]) ?></td>
                            <td align="center"><?php echo @number_format($rowDetail["pro_detail_sprice"]) ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="11" style="border-bottom:1px solid black"></td>
                    </tr>

            <?php }
            } ?>
        </tbody>
    </table>
</body>