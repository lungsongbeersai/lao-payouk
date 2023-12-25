<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if (isset($_GET["debt_list"])) {
    $limit = $_POST["limit"];
    $page = 1;
    if (@$_POST['page'] > 1) {
        $start = (($_POST['page'] - 1) * $limit);
        $page = $_POST['page'];
    } else {
        $start = 0;
    }
    $query = "";


    if ($_POST["lookType"] == "1") {

        $query .= "view_report_ny ";
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
                    $query .= "AND table_name='232sdsfeer2222'";
                }
            }
        } else {
            $query .= "";
        }

        if ($_POST["status_payment"] != "") {
            $query .= "AND list_bill_status_ny='" . $_POST["status_payment"] . "'";
        } else {
            $query .= "AND list_bill_status_ny !='0'";
        }

        if ($_POST["search_branch"] != "") {
            $query .= "AND list_bill_branch_fk='" . $_POST["search_branch"] . "'";
        } else {
            if ($_SESSION["user_permission_fk"] == "202300000002") {
                $query .= "";
            } else {
                $query .= "AND list_bill_branch_fk='" . $_SESSION["user_branch"] . "'";
            }
        }

        if ($_POST["user_list"] != "") {
            $query .= "AND list_bill_custommer_fk='" . $_POST["user_list"] . "'";
        } else {
            $query .= "";
        }

        $query .= "  ORDER BY list_bill_no " . $_POST['order_page'] . " ";

        if ($_POST["limit"] != "") {
            $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit . '';
        } else {
            $filter_query = $query;
        }

?>
        <thead style="vertical-align:middle !important">
            <tr>
                <td align="center">ພິມຄືນ</td>
                <td widtd="5%" style="text-align:center !important;">ລໍາດັບ</td>
                <td>ຊື່ລູກຄ້າ</td>
                <td align="center">ເບີໂທ</td>
                <td align="center">ສາຂາ</td>
                <td align="center">ເລກບິນ</td>
                <td align="center">ວັນທີ່ຕິດໜີ້</td>
                <td align="center">ວັນທີ່ຊໍາລະໜີ້</td>
                <td align="center">ເບີໂຕະ</td>
                <td align="center">ປະເພດຊໍາລະ</td>
                <td align="center">ຈໍານວນ</td>
                <td align="center">ລວມຍອດ</td>
                <td align="center">ສະຖານະ</td>
            </tr>
        </thead>
        <tbody class="table-bordered-y table-sm display">
            <?php
            $j = 1;
            $totalQty = "0";
            $totalPrice = "0";
            $total_id = $start + 1;
            $total_data = $db->fn_fetch_rowcount($query);
            $sqlGroup = $db->fn_read_all($filter_query);
            if (count($sqlGroup) > 0) {
                foreach ($sqlGroup as $rowGroup) {
                    $totalQty += $rowGroup["list_bill_qty"];
                    $totalPrice += $rowGroup["list_bill_amount_kip"];
                    if ($rowGroup["list_bill_status_ny"] == "1") {
                        $ny = "<i class='fas fa-spinner fa-spin'></i> ຄ້າງຈ່າຍ";
                        $pay_date = "ຄ້າງ " . round(abs(strtotime(date("Y-m-d")) - strtotime($rowGroup["list_bill_date"])) / 60 / 60 / 24) . " ມື້";
                        $colors = "text-danger";
                    } else {
                        $ny = "<i class='fas fa-check'></i>  ຈ່າຍແລ້ວ";
                        $pay_date = date("d/m/Y", strtotime($rowGroup["ny_payment_date"]));
                        $colors = "";
                    }
            ?>
                    <tr class="<?php echo $colors ?> table_hover">
                        <td align="center">
                            <a class="btn btn-warning" href="?print_Preview&&list_bill_no=<?php echo base64_encode($rowGroup["list_bill_no"]) ?>&&tableName=<?php echo base64_encode($rowGroup['table_name']) ?>&&branch_code=<?php echo base64_encode($rowGroup['list_bill_branch_fk']) ?>" target="_bank" style="text-decoration:none;">
                                <ion-icon name="print-outline"></ion-icon> ພີມ
                            </a>
                        </td>
                        <td align="center"><?php echo $total_id++; ?></td>
                        <td><?php echo $rowGroup["cus_name"] ?></td>
                        <td><?php echo $rowGroup["cus_tel"] ?></td>
                        <td><?php echo $rowGroup["branch_name"] ?></td>
                        <td align="center"><?php echo $rowGroup["list_bill_no"] ?> </td>
                        <td align="center"><?php echo date("d/m/Y", strtotime($rowGroup["list_bill_date"])) ?></td>
                        <td align="center"><?php echo $pay_date ?></td>
                        <td align="center"><?php echo $rowGroup["table_name"] ?></td>
                        <td align="center"><?php echo $rowGroup["type_name"] ?></td>
                        <td align="center"><?php echo $rowGroup["list_bill_qty"] ?></td>
                        <td align="center"><?php echo @number_format($rowGroup["list_bill_amount_kip"]) ?></td>
                        <td align="center"><?php echo $ny; ?></td>
                    </tr>
                <?php } ?>
                <tr style="background-color: #0F253B;color:white">
                    <td align="right" colspan="10">ລວມຍອດ</td>
                    <td align="center"><?php echo @number_format($totalQty); ?></td>
                    <td align="center"><?php echo @number_format($totalPrice); ?></td>
                    <td></td>
                </tr>

                <tr style="border-top:1px solid #DEE2E6">
                    <td colspan="14">
                        <center>
                            <ul class="pagination">
                                <?php
                                if ($limit != "") {
                                    $limit1 = $limit;
                                } else {
                                    $limit1 = $total_data;
                                }
                                $total_links = ceil($total_data / $limit1);
                                $previous_link = '';
                                $next_link = '';
                                $page_link = '';
                                if ($total_links > 4) {
                                    if ($page < 5) {
                                        for ($count = 1; $count <= 5; $count++) {
                                            $page_array[] = $count;
                                        }
                                        $page_array[] = '...';
                                        $page_array[] = $total_links;
                                    } else {
                                        $end_limit = $total_links - 5;
                                        if ($page > $end_limit) {
                                            $page_array[] = 1;
                                            $page_array[] = '...';
                                            for ($count = $end_limit; $count <= $total_links; $count++) {
                                                $page_array[] = $count;
                                            }
                                        } else {
                                            $page_array[] = 1;
                                            $page_array[] = '...';
                                            for ($count = $page - 1; $count <= $page + 1; $count++) {
                                                $page_array[] = $count;
                                            }
                                            $page_array[] = '...';
                                            $page_array[] = $total_links;
                                        }
                                    }
                                } else {
                                    for ($count = 1; $count <= $total_links; $count++) {
                                        $page_array[] = $count;
                                    }
                                }

                                for ($count = 0; $count < count($page_array); $count++) {
                                    if ($page == $page_array[$count]) {
                                        $page_link .= '
                                            <li class="page-item active">
                                            <div class="page-link" href="#">' . $page_array[$count] . ' <span class="sr-only">(current)</span></div>
                                            </li>
                                        ';

                                        $previous_id = $page_array[$count] - 1;
                                        if ($previous_id > 0) {
                                            $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $previous_id . '"><i class="fas fa-chevron-left"></i></a></li>';
                                        } else {
                                            $previous_link = '
                                                    <li class="page-item disabled">
                                                    <div class="page-link" href="#"><i class="fas fa-chevron-left"></i></div>
                                                    </li>
                                            ';
                                        }
                                        $next_id = $page_array[$count] + 1;
                                        if ($next_id > $total_links) {
                                            $next_link = '
                                            <li class="page-item disabled">
                                                <div class="page-link" href="#"><i class="fas fa-chevron-right"></i></div>
                                            </li>
                                            ';
                                        } else {
                                            $next_link = '<li class="page-item"><div class="page-link" href="javascript:void(0)" data-page_number="' . $next_id . '"><i class="fas fa-chevron-right"></i></div></li>';
                                        }
                                    } else {
                                        if ($page_array[$count] == '...') {
                                            $page_link .= '
                                            <li class="page-item disabled">
                                            <div class="page-link" href="#">...</div>
                                            </li>
                                            ';
                                        } else {
                                            $page_link .= '
                                            <li class="page-item"><div class="page-link" href="javascript:void(0)" data-page_number="' . $page_array[$count] . '">' . $page_array[$count] . '</div></li>
                                            ';
                                        }
                                    }
                                }

                                $output = $previous_link . $page_link . $next_link;
                                echo $output;
                                ?>
                            </ul>
                        </center>
                    </td>
                </tr>

            <?php } else { ?>
                <tr>
                    <td colspan="14" align="center" style="height:380px;padding:150px;color:red">
                        <i class="fas fa-times-circle fa-3x"></i><br>
                        ບໍ່ພົບລາຍການ
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    <?php } else {
    ?>
        <thead style="background-color:#0F253B;color:white">
            <tr>
                <td widtd="5%" style="text-align:center !important;">ລໍາດັບ</td>
                <td style="text-align: center;">ວັນທີ່ຂາຍ</td>
                <td style="text-align: center;">ເລກບິນ</td>
                <td style="text-align: center;">ເບີໂຕະ</td>
                <td style="text-align: center;">ຍອດຂາຍຕົວຈິງ</td>
                <td>ລາຍການອາຫານ ແລະ ເຄື່ອງດຶ່ມ</td>
                <td style="text-align: center;">ລາຄາ</td>
                <td style="text-align: center;">ຈໍານວນ</td>
                <td style="text-align: center;">ແຖມ</td>
                <td style="text-align: center;">ສ່ວນຫຼຸດລາຍການ</td>
                <td align="right">ລວມ</t>
            </tr>
        </thead>
        <tbody class="table-sm display">
            <?php
            $i = 1;

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
                        $query .= "AND table_name='232sdsfeer2222'";
                    }
                }
            } else {
                $query .= "";
            }

            if ($_POST["status_payment"] != "") {
                $query .= "AND list_bill_status_ny='" . $_POST["status_payment"] . "'";
            } else {
                $query .= "AND list_bill_status_ny !='0'";
            }

            if ($_POST["search_branch"] != "") {
                $query .= "AND list_bill_branch_fk='" . $_POST["search_branch"] . "'";
            } else {
                $query .= "";
            }

            if ($_POST["user_list"] != "") {
                $query .= "AND list_bill_custommer_fk='" . $_POST["user_list"] . "'";
            } else {
                $query .= "";
            }

            $query .= " AND list_bill_status = '1'  ORDER BY list_bill_no " . $_POST['order_page'] . " ";

            if ($_POST["limit"] != "") {
                $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit . '';
            } else {
                $filter_query = $query;
            }


            $sqlreport = $db->fn_read_all($filter_query);
            $total_data = $db->fn_fetch_rowcount($query);
            $total_id = $start + 1;
            if ($total_data > 0) {
                foreach ($sqlreport as $rowreport) {
                    @$countData = $rowreport["list_bill_count_order"] + 1;
                    @$totalQty1 += $rowreport["list_bill_qty"];
                    @$totalPomotion1 += $rowreport["list_bill_sum_qty_promotion"];
                    @$totalPer1 += $rowreport["list_bill_total_percented_list"];
                    @$totalAmount += $rowreport["list_bill_amount_kip"];


            ?>
                    <tr style="border: 1px solid #FFFFFF;">
                        <td align="center"><?php echo $i++; ?></td>
                        <td align="center"><?php echo date("d/m/Y", strtotime($rowreport["list_bill_date"])) ?></td>
                        <td align="center" style='mso-number-format:\@;text-align:center'><?php echo $rowreport["list_bill_no"] ?></td>
                        <td align="center"><?php echo $rowreport["table_name"] ?></td>
                        <td align="center"><?php echo @number_format($rowreport["list_bill_amount_kip"]) ?></td>
                        <td colspan="7" style="color:white"></td>
                    </tr>
                    <?php
                    $sqlDetail = $db->fn_read_all("view_daily_report_list WHERE check_bill_list_bill_fk='" . $rowreport["list_bill_no"] . "' ");
                    foreach ($sqlDetail as $rowDetail) {
                    ?>
                        <tr style="border: 1px solid #FFFFFF;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>- <?php echo $rowDetail["product_name"] ?> <?php if ($rowDetail["check_bill_list_status_promotion"] == "2") {
                                                                                echo "<span class='text-danger'>( ຊື້ " . $rowDetail['check_bill_list_qty_promotion_all'] . " ແຖມ " . $rowDetail['check_bill_list_qty_promotion_gif'] . ")</span>";
                                                                            } ?></td>
                            <td align="center"><?php echo @number_format($rowDetail["check_bill_list_pro_price"]) ?></td>
                            <td align="center"><?php echo $rowDetail["check_bill_list_order_qty"] ?></td>
                            <td align="center"><?php echo @number_format($rowDetail["check_bill_list_qty_promotion_total"]) ?></td>
                            <td align="center"><?php echo @number_format($rowDetail["check_bill_list_discount_price"]) ?></td>
                            <td align="right"><?php echo @number_format($rowDetail["check_bill_list_discount_total"]) ?></td>

                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="11"></td>
                    </tr>
                    <tr style="background:#eff3f7">
                        <td colspan="7" align="right">ລວມຍອດຂາຍ : </td>
                        <td align="center"><?php echo @number_format($rowreport["list_bill_qty"]) ?></td>
                        <td align="center"><?php echo @number_format($rowreport["list_bill_sum_qty_promotion"]) ?></td>
                        <td align="center"><?php echo @number_format($rowreport["list_bill_total_percented_list"]) ?></td>
                        <td align="right"><?php echo @number_format($rowreport["list_bill_amount"]) ?></td>
                    </tr>
                    <tr style="background:#eff3f7">
                        <td colspan="7" align="right">ສ່ວນຫຼຸດທ້າຍບິນ : </td>
                        <td colspan="4" align="right"><?php echo @number_format($rowreport["list_bill_total_percented"]) ?></td>
                    </tr>
                    <tr style="font-weight: bold;background:#f9f0c5 !important;">
                        <td colspan="7" align="right">ຍອດຂາຍຕົວຈິງ :</td>
                        <td colspan="4" align="right" style="font-size: 18px;"><u><?php echo @number_format($rowreport["list_bill_amount_kip"]) ?></u></td>
                    </tr>
                <?php } ?>
                <tr style="background-color: #0F253B;color:white">
                    <td colspan="7" align="right">ຍອດຂາຍລວມທັງໝົດ</td>
                    <td align="center"><?php echo @number_format($totalQty1) ?></td>
                    <td align="center"><?php echo @number_format($totalPomotion1) ?></td>
                    <td align="center"><?php echo @number_format($totalPer1) ?></td>
                    <td align="right" style="font-size: 20px;"><u><?php echo @number_format($totalAmount) ?></u></td>
                </tr>
                <tr style="border-top:1px solid #DEE2E6">
                    <td colspan="11">
                        <center>
                            <ul class="pagination">
                                <?php
                                if ($limit != "") {
                                    $limit1 = $limit;
                                } else {
                                    $limit1 = $total_data;
                                }
                                $total_links = ceil($total_data / $limit1);
                                $previous_link = '';
                                $next_link = '';
                                $page_link = '';
                                if ($total_links > 4) {
                                    if ($page < 5) {
                                        for ($count = 1; $count <= 5; $count++) {
                                            $page_array[] = $count;
                                        }
                                        $page_array[] = '...';
                                        $page_array[] = $total_links;
                                    } else {
                                        $end_limit = $total_links - 5;
                                        if ($page > $end_limit) {
                                            $page_array[] = 1;
                                            $page_array[] = '...';
                                            for ($count = $end_limit; $count <= $total_links; $count++) {
                                                $page_array[] = $count;
                                            }
                                        } else {
                                            $page_array[] = 1;
                                            $page_array[] = '...';
                                            for ($count = $page - 1; $count <= $page + 1; $count++) {
                                                $page_array[] = $count;
                                            }
                                            $page_array[] = '...';
                                            $page_array[] = $total_links;
                                        }
                                    }
                                } else {
                                    for ($count = 1; $count <= $total_links; $count++) {
                                        $page_array[] = $count;
                                    }
                                }

                                for ($count = 0; $count < count($page_array); $count++) {
                                    if ($page == $page_array[$count]) {
                                        $page_link .= '
                                            <li class="page-item active">
                                            <div class="page-link" href="#">' . $page_array[$count] . ' <span class="sr-only">(current)</span></div>
                                            </li>
                                        ';

                                        $previous_id = $page_array[$count] - 1;
                                        if ($previous_id > 0) {
                                            $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $previous_id . '"><i class="fas fa-chevron-left"></i></a></li>';
                                        } else {
                                            $previous_link = '
                                                    <li class="page-item disabled">
                                                    <div class="page-link" href="#"><i class="fas fa-chevron-left"></i></div>
                                                    </li>
                                            ';
                                        }
                                        $next_id = $page_array[$count] + 1;
                                        if ($next_id > $total_links) {
                                            $next_link = '
                                            <li class="page-item disabled">
                                                <div class="page-link" href="#"><i class="fas fa-chevron-right"></i></div>
                                            </li>
                                            ';
                                        } else {
                                            $next_link = '<li class="page-item"><div class="page-link" href="javascript:void(0)" data-page_number="' . $next_id . '"><i class="fas fa-chevron-right"></i></div></li>';
                                        }
                                    } else {
                                        if ($page_array[$count] == '...') {
                                            $page_link .= '
                                            <li class="page-item disabled">
                                            <div class="page-link" href="#">...</div>
                                            </li>
                                            ';
                                        } else {
                                            $page_link .= '
                                            <li class="page-item"><div class="page-link" href="javascript:void(0)" data-page_number="' . $page_array[$count] . '">' . $page_array[$count] . '</div></li>
                                            ';
                                        }
                                    }
                                }

                                $output = $previous_link . $page_link . $next_link;
                                echo $output;
                                ?>
                            </ul>
                        </center>
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td colspan="11" align="center" style="height:380px;padding:150px;color:red">
                        <i class="fas fa-times-circle fa-3x"></i><br>
                        ບໍ່ພົບລາຍການ
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    <?php } ?>
<?php } ?>