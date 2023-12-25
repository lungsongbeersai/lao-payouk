<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if (isset($_GET["fetch_data"])) {
    $limit = $_POST["limit"];
    $page = 1;
    if (@$_POST['page'] > 1) {
        $start = (($_POST['page'] - 1) * $limit);
        $page = $_POST['page'];
    } else {
        $start = 0;
    }

    @$query .= "res_tables AS A LEFT JOIN res_zone AS B ON A.table_zone_fk=B.zone_code ";

    if ($_POST["search"] != "") {
        $query .= " WHERE table_name LIKE '%" . $_POST["search"] . "%' OR table_name LIKE '%" . $_POST["search"] . "%'  ";
    } else {
        $query .= "";
    }

    if ($_POST["orderby"] != "") {
        $query .= " ORDER BY table_code " . $_POST["orderby"] . " ";
    } else {
        $query .= "";
    }

    if ($_POST["limit"] != "") {
        $filter_query = $query . 'LIMIT ' . $start . ', ' . $limit . '';
    } else {
        $filter_query = $query;
    }

    $fetch_sql = $db->fn_read_all($filter_query);
    $total_data = $db->fn_fetch_rowcount($query);
    $total_id = $start + 1;
    if ($total_data > 0) {
        foreach ($fetch_sql as $row_sql) {
?>
            <tr class="table_hover" ondblclick="edit_function('<?php echo $row_sql['table_code'] ?>','<?php echo $row_sql['table_name'] ?>','<?php echo $row_sql['table_zone_fk'] ?>')">
                <td align="center"><?php echo $total_id++; ?></td>
                <td><?php echo $row_sql["table_name"] ?></td>
                <td><?php echo $row_sql["zone_name"] ?></td>
                <td align="center">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="edit_function('<?php echo $row_sql['table_code'] ?>','<?php echo $row_sql['table_name'] ?>','<?php echo $row_sql['table_zone_fk'] ?>')">
                        <i class="fas fa-pen"></i> ແກ້ໄຂ
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="delete_data('<?php echo $row_sql['table_code']; ?>','service-table-list.php?delete','','','','','service-table-list.php?fetch_data','display')">
                        <i class="fas fa-trash"></i> ລຶບ
                    </button>
                </td>
            </tr>
        <?php } ?>
        <tr style="border-top:1px solid #DEE2E6">
            <td colspan="4">
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
            <td colspan="4" align="center" style="height:380px;padding:150px;color:red">
                <i class="fas fa-times-circle fa-3x"></i><br>
                ບໍ່ພົບລາຍການ
            </td>
        </tr>
    <?php } ?>
<?php }
if (isset($_GET["insert"])) {
    $auto_number = $db->fn_autonumber("product_code", "res_products_list");
    if (@$_POST["product_notify"] == "on") {
        $notify = "2";
    } else {
        $notify = "1";
    }
    if ($_POST["product_code"] != "") {

        if ($_FILES['product_images']['name'] != "") {
            // $fileinfo = PATHINFO($_FILES['product_images']['name']);
            // $newfilename = rand() . "_" . $auto_number . "_" . time() . "." . $fileinfo['extension'];
            // $location = "../../assets/img/product_home/" . $newfilename;
            // $path_info = $newfilename;
            // move_uploaded_file($_FILES['product_images']['tmp_name'], $location);

            $unlink_file=$db->fn_fetch_single_all("res_products_list WHERE product_code='" . $_POST["product_code"] . "' ");
            if($unlink_file){
                unlink("../../../../api/images/product_home/".$unlink_file["product_images"]);
            }

            $fileinfo = pathinfo($_FILES['product_images']['name']);
            $images = $_FILES["product_images"]["tmp_name"];
            $path_info = rand() . time() . "." . $fileinfo['extension'];

            // Determine image type
            $image_type = strtolower($fileinfo['extension']);
            if ($image_type == 'jpg' || $image_type == 'jpeg') {
                $images_orig = imagecreatefromjpeg($images);
            } elseif ($image_type == 'png') {
                $images_orig = imagecreatefrompng($images);
            } elseif ($image_type == 'gif') {
                $images_orig = imagecreatefromgif($images);
            } else {
                exit('Unsupported image type');
            }

            $width = 400;
            $size = getimagesize($images);
            $height = round($width * $size[1] / $size[0]);

            $images_fin = imagecreatetruecolor($width, $height);
            imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $size[0], $size[1]);

            if ($image_type == 'jpg' || $image_type == 'jpeg') {
                imagejpeg($images_fin, "../../../../api/images/product_home/" . $path_info);
            } elseif ($image_type == 'png') {
                imagepng($images_fin, "../../../../api/images/product_home/" . $path_info);
            } elseif ($image_type == 'gif') {
                imagegif($images_fin, "../../../../api/images/product_home/" . $path_info);
            }

            imagedestroy($images_orig);
            imagedestroy($images_fin);

            $sql = "product_branch='" . $_POST["product_branch"] . "',
                product_group_fk='" . $_POST["product_group_fk"] . "',
                product_cate_fk='" . $_POST["product_cate_fk"] . "',
                product_unite_fk='" . $_POST["product_unite_fk"] . "',
                product_name='" . $_POST["product_name"] . "',
                product_cut_stock='" . $_POST["product_cut_stock"] . "',
                product_reorder_point_fk='" . $_POST["product_reorder_point_fk"] . "',product_images='" . $path_info . "',product_notify='" . $notify . "' WHERE product_code='" . $_POST["product_code"] . "' ";
            $insert = $db->fn_edit("res_products_list", $sql);
        } else {
            $sql = "product_branch='" . $_POST["product_branch"] . "',
                product_group_fk='" . $_POST["product_group_fk"] . "',
                product_cate_fk='" . $_POST["product_cate_fk"] . "',
                product_unite_fk='" . $_POST["product_unite_fk"] . "',
                product_name='" . $_POST["product_name"] . "',
                product_cut_stock='" . $_POST["product_cut_stock"] . "',
                product_reorder_point_fk='" . $_POST["product_reorder_point_fk"] . "',product_notify='" . $notify . "'  WHERE product_code='" . $_POST["product_code"] . "' ";
            $insert = $db->fn_edit("res_products_list", $sql);
        }

        for ($i = 0; $i < count($_POST["pro_detail_size_fk1"]); $i++) {
            $auto_detail = $db->fn_autonumber("pro_detail_code", "res_products_detail");

            if (@$_POST["pro_detail_open1"][$i] == "") {
                $show = "1";
            } else {
                $show = "2";
            }

            if ($_FILES['pro_detail_location1']['name'][$i] != "") {
                // $fileinfo = PATHINFO($_FILES['pro_detail_location1']['name'][$i]);
                // $newfilename = rand() . "_" . $auto_number . "_" . time() . "." . $fileinfo['extension'];
                // $location = "../../../../api/images/product_home/" . $newfilename;
                // $path = $newfilename;
                // move_uploaded_file($_FILES['pro_detail_location1']['tmp_name'][$i], $location);

                if ($_FILES['pro_detail_location']['name'][$i] != "") {

                    $fileinfo = pathinfo($_FILES['pro_detail_location']['name'][$i]);
                    $images = $_FILES["pro_detail_location"]["tmp_name"][$i];
                    $path = rand() . time() . "." . $fileinfo['extension'];

                    // Determine image type
                    $image_type = strtolower($fileinfo['extension']);
                    if ($image_type == 'jpg' || $image_type == 'jpeg') {
                        $images_orig = imagecreatefromjpeg($images);
                    } elseif ($image_type == 'png') {
                        $images_orig = imagecreatefrompng($images);
                    } elseif ($image_type == 'gif') {
                        $images_orig = imagecreatefromgif($images);
                    } else {
                        // Unsupported image type
                        exit('Unsupported image type');
                    }

                    $width = 400;
                    $size = getimagesize($images);
                    $height = round($width * $size[1] / $size[0]);

                    $images_fin = imagecreatetruecolor($width, $height);
                    imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $size[0], $size[1]);

                    // Save the image based on its type
                    if ($image_type == 'jpg' || $image_type == 'jpeg') {
                        imagejpeg($images_fin, "../../../../api/images/product_detail/" . $path);
                    } elseif ($image_type == 'png') {
                        imagepng($images_fin, "../../../../api/images/product_detail/" . $path);
                    } elseif ($image_type == 'gif') {
                        imagegif($images_fin, "../../../../api/images/product_detail/" . $path);
                    }

                    imagedestroy($images_orig);
                    imagedestroy($images_fin);
                } else {
                    $path = "";
                }

                $pro_detail_bprice = filter_var($_POST["pro_detail_bprice1"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $pro_detail_sprice = filter_var($_POST["pro_detail_sprice1"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $pro_detail_qty = filter_var($_POST["pro_detail_qty1"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $sql = "pro_detail_barcode='" . $_POST["pro_detail_barcode1"][$i] . "',
                    pro_detail_size_fk='" . $_POST["pro_detail_size_fk1"][$i] . "',
                    pro_detail_bprice='" . $pro_detail_bprice . "',
                    pro_detail_sprice='" . $pro_detail_sprice . "',
                    pro_detail_qty='" . $pro_detail_qty . "',
                    pro_detail_open='" . $show . "',
                    pro_detail_create_date='" . date("Y-m-d") . "',pro_detail_location='" . $path . "' WHERE pro_detail_code='" . $_POST["productCode"][$i] . "' ";
                $insert_detail = $db->fn_edit("res_products_detail", $sql);
            } else {
                $pro_detail_bprice = filter_var($_POST["pro_detail_bprice1"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $pro_detail_sprice = filter_var($_POST["pro_detail_sprice1"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $pro_detail_qty = filter_var($_POST["pro_detail_qty1"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $sql = "pro_detail_barcode='" . $_POST["pro_detail_barcode1"][$i] . "',
                    pro_detail_size_fk='" . $_POST["pro_detail_size_fk1"][$i] . "',
                    pro_detail_bprice='" . $pro_detail_bprice . "',
                    pro_detail_sprice='" . $pro_detail_sprice . "',
                    pro_detail_qty='" . $pro_detail_qty . "',
                    pro_detail_open='" . $show . "',
                    pro_detail_create_date='" . date("Y-m-d") . "' WHERE pro_detail_code='" . $_POST["productCode"][$i] . "' ";
                $insert_detail = $db->fn_edit("res_products_detail", $sql);
            }
        }

        if ($insert) {
            echo json_encode(array("statusCode" => 202));
        } else {
            echo json_encode(array("statusCode" => 204));
        }
    } else {

        if ($_POST["search_products"] != "") {
            $check_product = $db->fn_fetch_single_all("res_products_detail WHERE pro_detail_product_fk='" . $_POST["search_products"] . "' ");
            for ($i = 0; $i < count($_POST["pro_detail_size_fk"]); $i++) {
                $auto_detail = $db->fn_autonumber("pro_detail_code", "res_products_detail");
                // if ($_FILES['pro_detail_location']['name'][$i] != "") {
                //     $fileinfo = PATHINFO($_FILES['pro_detail_location']['name'][$i]);
                //     $newfilename = rand() . "_" . $auto_number . "_" . time() . "." . $fileinfo['extension'];
                //     $location = "../../../../api/images/product_home/" . $newfilename;
                //     $path = $newfilename;
                //     move_uploaded_file($_FILES['pro_detail_location']['tmp_name'][$i], $location);
                // } else {
                //     $path = "";
                // }

                if ($_FILES['pro_detail_location']['name'][$i] != "") {

                    $fileinfo = pathinfo($_FILES['pro_detail_location']['name'][$i]);
                    $images = $_FILES["pro_detail_location"]["tmp_name"][$i];
                    $path = rand() . time() . "." . $fileinfo['extension'];

                    // Determine image type
                    $image_type = strtolower($fileinfo['extension']);
                    if ($image_type == 'jpg' || $image_type == 'jpeg') {
                        $images_orig = imagecreatefromjpeg($images);
                    } elseif ($image_type == 'png') {
                        $images_orig = imagecreatefrompng($images);
                    } elseif ($image_type == 'gif') {
                        $images_orig = imagecreatefromgif($images);
                    } else {
                        // Unsupported image type
                        exit('Unsupported image type');
                    }

                    $width = 400;
                    $size = getimagesize($images);
                    $height = round($width * $size[1] / $size[0]);

                    $images_fin = imagecreatetruecolor($width, $height);
                    imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $size[0], $size[1]);

                    // Save the image based on its type
                    if ($image_type == 'jpg' || $image_type == 'jpeg') {
                        imagejpeg($images_fin, "../../../../api/images/product_detail/" . $path);
                    } elseif ($image_type == 'png') {
                        imagepng($images_fin, "../../../../api/images/product_detail/" . $path);
                    } elseif ($image_type == 'gif') {
                        imagegif($images_fin, "../../../../api/images/product_detail/" . $path);
                    }

                    imagedestroy($images_orig);
                    imagedestroy($images_fin);
                } else {
                    $path = "";
                }

                if (@$_POST["pro_detail_open"][$i] == "") {
                    $show = "1";
                } else {
                    $show = "2";
                }
                $pro_detail_bprice = filter_var($_POST["pro_detail_bprice"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $pro_detail_sprice = filter_var($_POST["pro_detail_sprice"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $pro_detail_qty = filter_var($_POST["pro_detail_qty"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $sql = "'" . $auto_detail . "','" . $_POST["search_products"] . "','" . $_POST["pro_detail_barcode"][$i] . "',
                    '" . $_POST["pro_detail_size_fk"][$i] . "','" . $pro_detail_bprice . "',
                    '" . $pro_detail_sprice . "','" . $pro_detail_qty . "','1','" . $show . "',
                    '" . date("Y-m-d") . "','" . $_SESSION["users_id"] . "','" . $path . "','0','" . DATE("Y-m-d") . "','" . date("h:i") . "'";
                $insert_detail = $db->fn_insert("res_products_detail", $sql);
            }

            echo json_encode(array("statusCode" => 203));
            exit;
        } else {

            for ($i = 0; $i < count($_POST["pro_detail_size_fk"]); $i++) {
                $auto_detail = $db->fn_autonumber("pro_detail_code", "res_products_detail");

                if ($_FILES['pro_detail_location']['name'][$i] != "") {

                    $fileinfo = pathinfo($_FILES['pro_detail_location']['name'][$i]);
                    $images = $_FILES["pro_detail_location"]["tmp_name"][$i];
                    $path = rand() . time() . "." . $fileinfo['extension'];

                    // Determine image type
                    $image_type = strtolower($fileinfo['extension']);
                    if ($image_type == 'jpg' || $image_type == 'jpeg') {
                        $images_orig = imagecreatefromjpeg($images);
                    } elseif ($image_type == 'png') {
                        $images_orig = imagecreatefrompng($images);
                    } elseif ($image_type == 'gif') {
                        $images_orig = imagecreatefromgif($images);
                    } else {
                        // Unsupported image type
                        exit('Unsupported image type');
                    }

                    $width = 400;
                    $size = getimagesize($images);
                    $height = round($width * $size[1] / $size[0]);

                    $images_fin = imagecreatetruecolor($width, $height);
                    imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $size[0], $size[1]);

                    // Save the image based on its type
                    if ($image_type == 'jpg' || $image_type == 'jpeg') {
                        imagejpeg($images_fin, "../../../../api/images/product_detail/" . $path);
                    } elseif ($image_type == 'png') {
                        imagepng($images_fin, "../../../../api/images/product_detail/" . $path);
                    } elseif ($image_type == 'gif') {
                        imagegif($images_fin, "../../../../api/images/product_detail/" . $path);
                    }

                    imagedestroy($images_orig);
                    imagedestroy($images_fin);
                } else {
                    $path = "";
                }

                if (@$_POST["pro_detail_open"][$i] == "") {
                    $show = "1";
                } else {
                    $show = "2";
                }
                $pro_detail_bprice = filter_var($_POST["pro_detail_bprice"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $pro_detail_sprice = filter_var($_POST["pro_detail_sprice"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $pro_detail_qty = filter_var($_POST["pro_detail_qty"][$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $sql = "'" . $auto_detail . "','" . $auto_number . "','" . $_POST["pro_detail_barcode"][$i] . "',
                    '" . $_POST["pro_detail_size_fk"][$i] . "','" . $pro_detail_bprice . "','" . $pro_detail_sprice . "','" . $pro_detail_qty . "','1',
                    '" . $show . "','" . date("Y-m-d") . "','" . $_SESSION["users_id"] . "','" . $path . "','0','" . DATE("Y-m-d") . "','" . date("h:i") . "'";
                $insert_detail = $db->fn_insert("res_products_detail", $sql);
            }

            if ($_FILES['product_images']['name'] != "") {

                $fileinfo = pathinfo($_FILES['product_images']['name']);
                $images = $_FILES["product_images"]["tmp_name"];
                $path_info = rand() . time() . "." . $fileinfo['extension'];

                // Determine image type
                $image_type = strtolower($fileinfo['extension']);
                if ($image_type == 'jpg' || $image_type == 'jpeg') {
                    $images_orig = imagecreatefromjpeg($images);
                } elseif ($image_type == 'png') {
                    $images_orig = imagecreatefrompng($images);
                } elseif ($image_type == 'gif') {
                    $images_orig = imagecreatefromgif($images);
                } else {
                    exit('Unsupported image type');
                }

                $width = 400;
                $size = getimagesize($images);
                $height = round($width * $size[1] / $size[0]);

                $images_fin = imagecreatetruecolor($width, $height);
                imagecopyresampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $size[0], $size[1]);

                if ($image_type == 'jpg' || $image_type == 'jpeg') {
                    imagejpeg($images_fin, "../../../../api/images/product_home/" . $path_info);
                } elseif ($image_type == 'png') {
                    imagepng($images_fin, "../../../../api/images/product_home/" . $path_info);
                } elseif ($image_type == 'gif') {
                    imagegif($images_fin, "../../../../api/images/product_home/" . $path_info);
                }

                imagedestroy($images_orig);
                imagedestroy($images_fin);
            } else {
                $path_info = "";
            }

            $sql = "'" . $auto_number . "','" . $_POST["product_branch"] . "','" . $_POST["product_group_fk"] . "','" . $_POST["product_cate_fk"] . "','" . $_POST["product_unite_fk"] . "','" . $_POST["product_name"] . "','" . $_POST["product_cut_stock"] . "','" . $_POST["product_reorder_point_fk"] . "','" . $path_info . "','" . $notify . "'";
            $insert = $db->fn_insert("res_products_list", $sql);
            if ($insert) {
                echo json_encode(array("statusCode" => 200));
            } else {
                echo json_encode(array("statusCode" => 204));
            }
        }
    }
}
if (isset($_GET["delete"])) {
    $delete = $db->fn_delete("res_tables WHERE table_code='" . $_POST["field_id"] . "' ");
    if ($delete) {
        echo json_encode(array("statusCode" => 200));
    } else {
        echo json_encode(array("statusCode" => 201));
    }
}

if (isset($_GET['deleteList'])) {
    $delete = $db->fn_delete("res_products_detail WHERE pro_detail_code='" . $_POST["productID"] . "' ");
    if ($delete) {
        echo json_encode(array("statusCode" => 200));
    } else {
        echo json_encode(array("statusCode" => 201));
    }
}

?>