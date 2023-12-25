<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
function app_sidebar_minified()
{
    echo "app-sidebar-minified";
}
// @$edit_data = base64_decode($_GET["edit_data"]);
@$proID = base64_decode($_GET["proID"]);

if (@$proID != "") {
    @$disabled = "1";
    @$text_name = "( <span class='text-danger'>ບໍ່ສາມາດເລືອກໄດ້ </span>)";
    @$edit_sql = $db->fn_fetch_single_all("view_product_list WHERE product_code='" . @$proID . "' ");
    // if ($edit_sql["pro_detail_location"] == "") {
    //     $image_edit = "../../../api/images/logo/no_logo.jpg";
    // } else {
    //     $image_edit = "../../../api/images/product/" . $edit_sql["pro_detail_location"];
    // }

    if ($edit_sql["product_images"] == "") {
        @$image_edit_home = "../../api/images/logo/no_logo.jpg";
    } else {
        @$image_edit_home = "../../api/images/product_home/" . $edit_sql["product_images"];
    }

    // if ($edit_sql["pro_detail_open"] == "1") {
    //     $check_edit = "";
    // } else {
    //     $check_edit = "checked";
    // }

    if (@$edit_sql["product_notify"] == "1") {
        @$notify_edit = "";
    } else {
        @$notify_edit = "checked";
    }


    if ($edit_sql["product_cut_stock"] == "1") {
        @$cut_edit = "1";
    } else if ($edit_sql["product_cut_stock"] == "2") {
        @$cut_edit = "2";
    } else {
        @$cut_edit = "3";
    }

    @$btn_edit = '<i class="fas fa-pen"></i> ແກ້ໄຂ';


    echo "<script>localStorage.clear()</script>";
} else {
    @$notify_edit = "checked";
    @$disabled = "";
    @$text_name = "";
    @$image_edit = "../../../api/images/logo/no_logo.jpg";
    @$check_edit = "checked";
    @$cut_edit = "1";
    @$btn_edit = '<i class="fas fa-save"></i> ບັນທຶກ';
    @$image_edit_home = "../../../api/images/logo/no_logo.jpg";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Products</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified() ?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>
        <form id="insertProduct">
        <div id="content" class="app-content">
            <ol class="breadcrumb float-xl-end">
                <li class="breadcrumb-item"><a href="javascript:history.back()" class="text-danger"><i class="fas fa-arrow-circle-left"></i> ກັບຄືນ</a></li>
                <li class="breadcrumb-item active">ເພີ່ມອາຫານ/ເຄື່ອງດຶ່ມ</li>
            </ol>

            <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                <ion-icon name="fast-food-outline"></ion-icon> ເພີ່ມອາຫານ/ເຄື່ອງດຶ່ມ
            </h4>
            
                <input type="text" hidden name="edit_product_branch" id="edit_product_branch" class="edit_product_branch" value="<?php echo @$edit_sql["product_branch"] ?>">
                <input type="text" hidden name="edit_product_group_fk" id="edit_product_group_fk" class="edit_product_group_fk" value="<?php echo @$edit_sql["product_group_fk"] ?>">
                <input type="text" hidden name="edit_product_cate_fk" id="edit_product_cate_fk" class="edit_product_cate_fk" value="<?php echo @$edit_sql["product_cate_fk"] ?>">
                <input type="text" hidden name="edit_product_unite_fk" id="edit_product_unite_fk" class="edit_product_unite_fk" value="<?php echo @$edit_sql["product_unite_fk"] ?>">
                <input type="text" hidden name="edit_pro_detail_size_fk" id="edit_pro_detail_size_fk" class="edit_pro_detail_size_fk" value="<?php echo @$edit_sql["pro_detail_size_fk"] ?>">
                <input type="text" hidden name="product_code" id="product_code" value="<?php echo @$edit_sql["pro_detail_product_fk"] ?>">
                <input type="text" hidden name="edit_product_code" id="edit_product_code" value="<?php echo @$edit_sql["pro_detail_code"] ?>">

                <?php if ($disabled == "") { ?>
                    <div class="panel panel-inverse" hidden>
                        <div class="panel-body">
                            <div class="col-md-12 mb-2">
                                <label for="" class="mb-2"> ຄົ້ນຫາ <span class="text-danger">*</span><?php echo $text_name ?></label>
                                <select class="multiple-select2 form-control search_products" id="search_products" name="search_products" onchange="res_products_search('search_products')" style="width:100%">
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 mb-5">
                                <center>
                                    <div class="avatar-preview">
                                        <label style="cursor:pointer" onchange="load_image('display_product')">
                                            <img src="<?php echo $image_edit_home; ?>" id="display_product" class="display_product" alt="" style="max-width: 100%;max-height:120px">
                                            <input type="file" id="product_images" name="product_images" class="product_images" style="display: none;" accept=".png, .jpg, .jpeg">
                                        </label>
                                    </div>
                                    <label for="">( ຮູບອາຫານ )</label>
                                </center>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="mb-2"> ສາຂາ <span class="text-danger">*</span></label>
                                <select name="product_branch" id="product_branch" class="form-select product_branch" required>
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="mb-2"> ອາຫານກຸ່ມໃຫຍ່ <span class="text-danger">*</span></label>
                                <select name="product_group_fk" id="product_group_fk" class="form-select product_group_fk" required onchange="res_categroy('product_group_fk','edit_product_cate_fk')">
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="" class="mb-2"> ໝວດອາຫານ <span class="text-danger">*</span></label>
                                <select name="product_cate_fk" id="product_cate_fk" class="form-select product_cate_fk" required>
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="mb-2"> ຊື່ອາຫານ/ເຄື່ອງດຶ່ມ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input_color product_name" name="product_name" id="product_name" value="<?php echo @$edit_sql["product_name"] ?>" placeholder="ປ້ອນອາຫານ ແລະ ເຄື່ອງດຶ່ມ" autocomplete="off" required>
                            </div>

                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label for="" class="mb-2"> ຫົວໜ່ວຍ <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <select name="product_unite_fk" id="product_unite_fk" class="form-select product_unite_fk" required>
                                            <option value="">ເລືອກ</option>
                                        </select>
                                        <button type="button" class="btn btn-primary" onclick="modal_open('modal_unite','modal_title','frm_unite','btn_save','unite_name','','')">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-10 mb-2">
                                <h3>ເລືອກຂະໜາດ</h3>
                            </div>
                            <div class="col-md-2 mb-2">
                                <?php if ($disabled == "") { ?>
                                    <button class="btn btn-primary btn-block add" style="float:right !important;" type="button">
                                        <i class="fas fa-plus"></i> ເພີ່ມແຖວໃໝ່
                                    </button>
                                <?php } ?>
                            </div>

                            <div class="col-md-12">
                                <table class="table">
                                    <thead style="background-color:#DB4900 !important">
                                        <tr>
                                            <th style="text-align:center !important;">ຮູບ</th>
                                            <th style="text-align:center !important;">ສະແດງ</th>
                                            <th style="text-align:center !important;">ບາໂຄດ</th>
                                            <th style="text-align:center !important;">ຂະໜາດ</th>
                                            <th style="text-align:center !important;">ລາຄາຊື້</th>
                                            <th style="text-align:center !important;">ລາຄາຂາຍ</th>
                                            <th style="text-align:center !important;">ຈໍານວນ</th>
                                            <th style="text-align:center !important;">ລຶບ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_first">
                                        <?php
                                        if ($disabled != "") {
                                            $sqlDetail = $db->fn_read_all("view_product_list WHERE pro_detail_product_fk='" . $proID . "' ORDER BY pro_detail_code ASC");
                                            foreach($sqlDetail as $rowDetail){
                                                if ($rowDetail["pro_detail_location"] == "") {
                                                    $image_logo_edit = "../../../api/images/logo/no_logo.jpg";
                                                } else {
                                                    $image_logo_edit = "../../../api/images/product/" . $rowDetail["pro_detail_location"];
                                                }

                                                if ($rowDetail["pro_detail_open"] == "1") {
                                                    $check_open_edit = "";
                                                } else {
                                                    $check_open_edit = "checked";
                                                }

                                                $sqlCount=$db->fn_fetch_single_all("res_products_detail WHERE pro_detail_product_fk='".$rowDetail["pro_detail_product_fk"]."' ORDER BY pro_detail_code ASC LIMIT 1");

                                                if($sqlCount["pro_detail_code"]==$rowDetail["pro_detail_code"]){
                                                    $checkDisabeld="disabled";
                                                }else{
                                                    $checkDisabeld="";
                                                }

                                        ?>
                                            <tr>
                                                <input type="text" hidden name="productCode[]" id="productCode" value="<?php echo @$rowDetail["pro_detail_code"] ?>">
                                                <td id="1" class="upload_file">
                                                    <center>
                                                        <div class="avatar-preview">
                                                            <label for="pro_detail_location" style="cursor:pointer" id="upload_image" class="upload_image">
                                                                <img src="<?php echo $image_logo_edit; ?>" id="display_images1" name="display_images" class="display_images" alt="" style="max-width: 50%;max-height:80px">
                                                                <input type="file" id="pro_detail_location" name="pro_detail_location1[]" class="pro_detail_location" accept=".png, .jpg, .jpeg" style="display: none;">
                                                            </label>
                                                        </div>
                                                    </center>
                                                </td>

                                                <td>
                                                    <div class="form-check form-switch ms-auto">
                                                        <input type="checkbox" class="form-check-input" id="pro_detail_open" name="pro_detail_open1[]" <?php echo @$check_open_edit; ?>>
                                                        <label class="form-check-label" for="pro_detail_open">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm input_color pro_detail_barcode" name="pro_detail_barcode1[]" id="pro_detail_barcode" value="<?php echo @($rowDetail["pro_detail_barcode"]) ?>" autocomplete="off">
                                                        <button type="button" class="btn btn-primary" onclick="gen_code('pro_detail_barcode')">
                                                            <i class="fas fa-barcode"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    
                                                    <div class="input-group">
                                                        <select name="pro_detail_size_fk1[]" id="pro_detail_size_fk" class="form-select form-select-sm" required>
                                                            <?php 
                                                                $res_size=$db->fn_read_all("res_size ORDER BY size_code ASC");
                                                                if(count($res_size)>0){
                                                                    foreach($res_size as $row_size){
                                                                        if($rowDetail["pro_detail_size_fk"]==$row_size["size_code"]){
                                                                            $selected="selected";
                                                                        }else{
                                                                            $selected="";
                                                                        }
                                                                        echo "<option value='".$row_size["size_code"]."' $selected>".$row_size["size_name_la"]."</option>";
                                                                    }
                                                                }else{
                                                                    echo "<option value=''>ເລືອກ</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                        <button type="button" class="btn btn-primary">
                                                            <i class="fas fa-barcode"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm input_color pro_detail_bprice1" name="pro_detail_bprice1[]" id="pro_detail_bprice" value="<?php echo @number_format($rowDetail["pro_detail_bprice"]) ?>" placeholder="0.0" onkeyup="format('pro_detail_bprice1')" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm input_color pro_detail_sprice1" name="pro_detail_sprice1[]" id="pro_detail_sprice" value="<?php echo @number_format($rowDetail["pro_detail_sprice"]) ?>" placeholder="0.0" onkeyup="format('pro_detail_sprice1')" autocomplete="off" required>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm input_color pro_detail_qty1" name="pro_detail_qty1[]" id="pro_detail_qty" value="<?php echo @number_format($rowDetail["pro_detail_qty"]) ?>" placeholder="0.0" onkeyup="format('pro_detail_qty1')" autocomplete="off">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger" <?php echo $checkDisabeld;?> onclick="editFuntion(<?php echo $rowDetail['pro_detail_code']?>)"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php } } else { ?>
                                            <tr>
                                                <td id="1" class="upload_file">
                                                    <center>
                                                        <div class="avatar-preview">
                                                            <label for="pro_detail_location" style="cursor:pointer" id="upload_image" class="upload_image">
                                                                <img src="<?php echo $image_edit; ?>" id="display_images1" name="display_images" class="display_images" alt="" style="max-width: 50%;max-height:80px">
                                                                <input type="file" id="pro_detail_location" name="pro_detail_location[]" class="pro_detail_location" accept=".png, .jpg, .jpeg" style="display: none;">
                                                            </label>
                                                        </div>
                                                    </center>
                                                </td>

                                                <td>
                                                    <div class="form-check form-switch ms-auto">
                                                        <input type="checkbox" class="form-check-input" id="pro_detail_open" name="pro_detail_open[]" <?php echo @$check_edit; ?>>
                                                        <label class="form-check-label" for="pro_detail_open">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm input_color pro_detail_barcode1" name="pro_detail_barcode[]" id="pro_detail_barcode" autocomplete="off">
                                                        <button type="button" class="btn btn-primary" onclick="gen_code('pro_detail_barcode1')">
                                                            <i class="fas fa-barcode"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <select name="pro_detail_size_fk[]" id="pro_detail_size_fk" class="form-select form-select-sm pro_detail_size_fk1" required></select>
                                                        <button type="button" class="btn btn-primary" onclick="modal_open('modal_size','modal_title1','frm_size','btn_save','size_name_la','','')">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm input_color pro_detail_bprice1" name="pro_detail_bprice[]" id="pro_detail_bprice" value="<?php echo @number_format($edit_sql["pro_detail_bprice"]) ?>" placeholder="0.0" onkeyup="format('pro_detail_bprice1')" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm input_color pro_detail_sprice1" name="pro_detail_sprice[]" id="pro_detail_sprice" value="<?php echo @number_format($edit_sql["pro_detail_sprice"]) ?>" placeholder="0.0" onkeyup="format('pro_detail_sprice1')" autocomplete="off" required>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm input_color pro_detail_qty1" name="pro_detail_qty[]" id="pro_detail_qty" value="<?php echo @number_format($edit_sql["pro_detail_qty"]) ?>" placeholder="0.0" onkeyup="format('pro_detail_qty1')" autocomplete="off">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger" disabled><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tbody id="show_data"></tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="panel-body bg-light rounded-bottom">
                        <div class="form-group mb-0">
                            <label class="form-label">ຈັດການສະຖານະ</label>
                            <div class="shipping-container">
                                <hr class="mt-2 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-6 pt-1 pb-1" style="font-size:14px !important;">✔ ຈຸດສັ່ງຊື້</div>
                                    <div class="col-6 d-flex align-items-center">
                                        <div class="form-check form-switch ms-auto">
                                            <select name="product_reorder_point_fk" id="pro_detail_order" class="form-select form-select-sm pro_detail_order" required style="font-size: 14px !important;">
                                                <option value="">ເລືອກ</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shipping-container">
                                <hr class="mt-2 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-6 pt-1 pb-1" style="font-size:14px !important;">✔ ສະຕ໋ອກ</div>
                                    <div class="col-6 d-flex align-items-center">
                                        <div class="form-check form-switch ms-auto">
                                            <select name="product_cut_stock" id="product_cut_stock" class="form-select form-select-sm product_cut_stock" style="font-size: 14px !important;">
                                                <option value="1" <?php if ($cut_edit == "1") {
                                                                        echo "selected";
                                                                    } ?>>- ບໍ່ຕັດສະຕ໋ອກ</option>
                                                <option value="2" <?php if ($cut_edit == "2") {
                                                                        echo "selected";
                                                                    } ?>>- ຕັດສະຕ໋ອກ</option>
                                                <option value="3" <?php if ($cut_edit == "3") {
                                                                        echo "selected";
                                                                    } ?>>- ເຄື່ອງດຶ່ມແຕ່ບໍ່ຕັດສະຕ໋ອກ</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="shipping-container">
                                <hr class="mt-2 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-6 pt-1 pb-1" style="font-size:14px !important;">✔ ແຈ້ງເຕືອນ / ຄົວ ແລະ ບານໍ້າ <span class="text-danger"> (ປະເພດ Cafe ບໍ່ແຈ້ງເຕືອນເຂົ້າຄົວ,ບານໍ້າ)</span></div>
                                    <div class="col-6 d-flex align-items-center">
                                        <div class="form-check form-switch ms-auto">
                                            <input type="checkbox" class="form-check-input" id="product_notify" name="product_notify" <?php echo $notify_edit ?>>
                                            <label class="form-check-label" for="product_notify">&nbsp;</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary" id="showSubmit">
                            <?php echo $btn_edit; ?>
                        </button>
                        
                    </div>
                </div>
            
                <div class="alert alert-orange text-dark mt-3" role="alert" style="background-color: #fff3d6 !important;border:1px solid #d69704;font-size:14px;">
                    <span class="text-primary">- ເຄື່ອງດຶ່ມແຕ່ບໍ່ຕັດສະຕ໋ອກ</span> : ໝາຍເຖິງປະເພດນໍ້າເຊັ່ນ : ອາເມຊ້ອນ,ລາເຕ້... ທີ່ບໍ່ສາມາດນັບສະຕ໋ອກໄດ້ແຕ່ເປັນປະເພດເຄື່ອງດຶ່ມ
                </div>
        </div>
        </form>

        <div class="modal fade" id="modal_unite" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light">ເພີ່ມຫົວໜ່ວຍ</h4>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="frm_unite">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="" class="mb-2">ຫົວໜ່ວຍ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input_color" id="unite_name" name="unite_name" placeholder="ປ້ອນຫົວໜ່ວຍ" required autocomplete="off">
                                <input type="text" hidden class="form-control" id="unite_code" name="unite_code">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary" id="btn_save"><i class="fas fa-save"></i> ບັນທຶກ</button>
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-hidden="true"><i class="fas fa-times"></i> ປິດ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_size" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light">ເພີ່ມຂະໜາດ</h4>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="frm_size">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-2">ຂະໜາດ ( ລາວ ) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" id="size_name_la" name="size_name_la" placeholder="ປ້ອນຂະໜາດພາສາລາວ" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-2">ຂະໜາດ ( ອັງກິດ )<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" id="size_name_eng" name="size_name_eng" placeholder="ປ້ອນຂະໜາດພາສາອັງກິດ" required autocomplete="off">
                                        <input type="text" hidden class="form-control" id="size_code" name="size_code">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary" id="btn_save"><i class="fas fa-save"></i> ບັນທຶກ</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-hidden="true"><i class="fas fa-times"></i> ປິດ</button>
                                    <hr>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <h4>✔ ລາຍການຂະໜາດ</h4>
                                    <table class="table table-borderless">
                                        <tr style="border-bottom: 1px solid black;">
                                            <th class="text-center">ລໍາດັບ</th>
                                            <th>ຊື່ພາສາລາວ</th>
                                            <th>ຊື່ພາສາອັງກິດ</th>
                                            <th class="text-center">ຈັດການ</th>
                                        </tr>
                                        <tbody id="show_size" class="table-sm">
                                            
                                        </tbody>
                                    </table>               
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
            $("#insertProduct").on("submit", function(event) {
                event.preventDefault();
                $.ajax({
                    url: "services/sql/service-products.php?insert",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode == 200) {
                            successfuly("ບັນທຶກສໍາເລັດ");
                            $("#insertProduct")[0].reset();
                            $("#show_data").find("tr").remove()
                            res_products("search_products");
                            res_group("product_group_fk", "edit_product_group_fk", "edit_product_cate_fk");
                            res_branch("product_branch", "edit_product_branch");
                            res_unite("product_unite_fk", "edit_product_unite_fk");
                            res_size("pro_detail_size_fk1", "edit_pro_detail_size_fk");
                            res_reorder_point("pro_detail_order", "edit_pro_detail_order");
                            gen_code('pro_detail_barcode1');
                            $("#display_images1").attr("src", "../../../api/images/logo/no_logo.jpg");
                            $("#display_product").attr("src", "../../../api/images/logo/no_logo.jpg");
                            $("#product_name").focus();

                            if (localStorage.getItem('product_cut_stock')) {
                                $(".product_cut_stock option").eq(localStorage.getItem('product_cut_stock')).prop('selected', true);
                            }

                            $(".product_cut_stock").on('change', function() {
                                localStorage.setItem('product_cut_stock', $('option:selected', this).index());
                            });

                            // $("#show_first").empty();
                        } else if (dataResult.statusCode == 202) {
                            successfuly("ແກ້ໄຂສໍາເລັດແລ້ວ");
                            // history.back();
                        } else if (dataResult.statusCode == 203) {
                            // location.reload();
                            successfuly("ບັນທຶກສໍາເລັດ");
                            $("#insertProduct")[0].reset();
                            $("#show_first").empty();
                            res_products("search_products");
                            res_group("product_group_fk", "edit_product_group_fk", "edit_product_cate_fk");
                            res_branch("product_branch", "edit_product_branch");
                            res_unite("product_unite_fk", "edit_product_unite_fk");
                            res_size("pro_detail_size_fk1", "edit_pro_detail_size_fk");
                            res_reorder_point("pro_detail_order", "edit_pro_detail_order");
                            gen_code('pro_detail_barcode1');
                            $("#display_images1").attr("src", "../../../api/images/logo/no_logo.jpg");
                            $("#display_product").attr("src", "../../../api/images/logo/no_logo.jpg");
                            $("#product_name").focus();

                            if (localStorage.getItem('product_cut_stock')) {
                                $(".product_cut_stock option").eq(localStorage.getItem('product_cut_stock')).prop('selected', true);
                            }

                            $(".product_cut_stock").on('change', function() {
                                localStorage.setItem('product_cut_stock', $('option:selected', this).index());
                            });

                        } else if (dataResult.statusCode == 204) {
                            Error_warning();
                        } else {
                            Error_data();
                        }
                    }
                })
            })

            $("#frm_unite").on("submit", function(event) {
                event.preventDefault();
                $.ajax({
                    url: "services/sql/service-all.php?insert_unite",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode == 200) {
                            successfuly("ບັນທຶກສໍາເລັດ");
                            $("#frm_unite")[0].reset();
                            $("#modal_unite").modal("hide");
                            res_unite("product_unite_fk")
                        } else if (dataResult.statusCode == 202) {
                            alert("aa")
                        }
                    }
                })
            })

            function deleteSize(size_code){

                Swal.fire({
                    title: 'ແຈ້ງເຕືອນ?',
                    text: "ຢືນຢັນການລຶບ!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fas fa-save"></i> ຢືນຢັນ',
                    cancelButtonText: '<i class="fas fa-times"></i> ປິດ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "services/sql/service-all.php?delete_size",
                            method: "POST",
                            data:{size_code},
                            success: function(data) {
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    successfuly("ລຶບສໍາເລັດແລ້ວ");
                                    loadSize();
                                }else{
                                    successfuly("ລຶບຫຼົ້ມເຫຼວ");
                                }
                            }
                        })
                    }
                })
            }

            function sizeEdit(size_code,size_name_la,size_name_eng){
                $("#size_code").val(size_code);
                $("#size_name_la").val(size_name_la);
                $("#size_name_eng").val(size_name_eng);
                $("#size_name_la").focus();
            }

            $("#frm_size").on("submit", function(event) {
                event.preventDefault();
                $.ajax({
                    url: "services/sql/service-all.php?insert_size",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode == 200) {
                            successfuly("ບັນທຶກສໍາເລັດ");
                            $("#frm_size")[0].reset();
                            $("#modal_size").modal("hide");
                            loadSize();
                            res_size("pro_detail_size_fk1", "edit_pro_detail_size_fk");
                        } else if (dataResult.statusCode == 202) {
                            successfuly("ແກ້ໄຂສໍາເລັດ");
                            $("#frm_size")[0].reset();
                            $("#modal_size").modal("hide");
                            loadSize();
                            res_size("pro_detail_size_fk1", "edit_pro_detail_size_fk");
                        }
                    }
                })
            })
            loadSize();
            function loadSize(){
                $.ajax({
                    url: "services/sql/service-all.php?loadAll",
                    method: "POST",
                    success:function(data){
                        $("#show_size").html(data);
                    }
                })
            }

            function editFuntion(productID){
                Swal.fire({
                    title: 'ແຈ້ງເຕືອນ?',
                    text: "ຢືນຢັນການລຶບ!",
                    icon: 'warning',
                    width: 400,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fas fa-save"></i> ຢືນຢັນ',
                    cancelButtonText: '<i class="fas fa-times"></i> ປິດ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "services/sql/service-products.php?deleteList",
                            method: "POST",
                            data:{productID},
                            success: function(data) {
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    location.reload();
                                } else {
                                    Error_data();
                                }
                            }
                        });
                    }
                })
            }


            $(document).ready(function() {
                var count = 2;
                $(document).on('click', '.add', function() {
                    count++;
                    var html = '';
                    html += '<tr>';
                    html += '<td id="' + count + '" class="upload_file">';
                    html += ' <center>';
                    html += '    <div class="avatar-preview">';
                    html += '        <label style="cursor:pointer">';
                    html += '            <img src="../../../api/images/logo/no_logo.jpg" id="display_images' + count + '" name="display_images" alt="" style="max-width: 50%;max-height:80px">';
                    html += '            <input type="file" id="pro_detail_location" name="pro_detail_location[]" class="pro_detail_location" style="display: none;" accept=".png, .jpg, .jpeg">';
                    html += '        </label>';
                    html += '    </div>';
                    html += '</center>';
                    html += '</td>';
                    html += '<td>';
                    html += '<div class="form-check form-switch ms-auto">';
                    html += '<input type="checkbox" class="form-check-input" id="pro_detail_open" name="pro_detail_open[]" checked>';
                    html += '<label class="form-check-label" for="pro_detail_open">&nbsp;</label>';
                    html += '</div>';
                    html += '<td>';
                    html += '<div class="input-group">';
                    html += '<input type="text" class="form-control form-control-sm input_color pro_detail_barcode' + count + '" name="pro_detail_barcode[]" id="pro_detail_barcode" autocomplete="off">';
                    html += '<button type="button" class="btn btn-primary" onclick=gen_code("pro_detail_barcode' + count + '")>';
                    html += '<i class="fas fa-barcode"></i>';
                    html += '</button>';
                    html += '</div>';
                    html += '</td>';
                    html += '<td>';
                    html += '<select name="pro_detail_size_fk[]" id="pro_detail_size_fk" class="form-select form-select-sm pro_detail_size_fk' + count + '" required></select>';
                    html += '</td>';
                    html += '<td>';
                    html += '<input type="text" class="form-control form-control-sm input_color pro_detail_bprice' + count + '" name="pro_detail_bprice[]" id="pro_detail_bprice" placeholder="0.0" onkeyup=format("pro_detail_bprice' + count + '") autocomplete="off">';
                    html += '</td>';
                    html += '<td>';
                    html += '<input type="text" class="form-control form-control-sm input_color pro_detail_sprice' + count + '" name="pro_detail_sprice[]" id="pro_detail_sprice" placeholder="0.0" onkeyup=format("pro_detail_sprice' + count + '") autocomplete="off" required>';
                    html += '</td>';
                    html += '<td>';
                    html += '<input type="text" class="form-control form-control-sm input_color pro_detail_qty' + count + '" name="pro_detail_qty[]" id="pro_detail_qty" placeholder="0.0" onkeyup=format("pro_detail_qty' + count + '") autocomplete="off">';
                    html += '</td>';
                    html += '<td>';
                    html += '<button type="button" class="btn btn-danger remove" type="button" id="remove"><i class="fas fa-trash"></i></button>';
                    html += '</td>';
                    html += '</td>';
                    $('#show_data').append(html);
                    gen_code('pro_detail_barcode' + count + '', 'edit_pro_detail_barcode');
                    res_size('pro_detail_size_fk' + count + '', 'edit_pro_detail_size_fk');
                    res_reorder_point('pro_detail_order' + count + '', 'edit_pro_detail_order');
                });
                $(document).on('click', '.remove', function() {
                    $(this).closest('tr').remove();
                });
            });

            res_products("search_products");
            res_group("product_group_fk", "edit_product_group_fk", "edit_product_cate_fk");
            res_branch("product_branch", "edit_product_branch");
            res_unite("product_unite_fk", "edit_product_unite_fk");
            res_size("pro_detail_size_fk1", "edit_pro_detail_size_fk");
            res_reorder_point("pro_detail_order", "edit_pro_detail_order");
            gen_code('pro_detail_barcode1');

            $(document).on("change", ".upload_file", function() {
                var display_images1 = $(this).attr("Id");
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('display_images' + display_images1);
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            });


            if (localStorage.getItem('product_cut_stock')) {
                $(".product_cut_stock option").eq(localStorage.getItem('product_cut_stock')).prop('selected', true);
            }

            $(".product_cut_stock").on('change', function() {
                localStorage.setItem('product_cut_stock', $('option:selected', this).index());
            });
        </script>
</body>

</html>