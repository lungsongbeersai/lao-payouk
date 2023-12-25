<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
function app_sidebar_minified()
{
    echo "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Frm Branch</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified() ?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <ol class="breadcrumb float-xl-end">
                <li class="breadcrumb-item"><a href="javascript:history.back()" class="text-danger"><i class="fas fa-arrow-circle-left"></i> ກັບຄືນ</a></li>
                <li class="breadcrumb-item active">ລາຍການສາຂາ</li>
            </ol>

            <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                <i class="fas fa-list"></i> ລາຍການສາຂາ
            </h4>

            <div class="row mb-2">
                <div class="col-md-2 mb-2">
                    <button type="button" class="btn btn-outline-orange" onclick="modal_open('modal_branch','ເພີ່ມສາຂາໃໝ່','frm_branch','btn_save','branch_name','branch_com_fk','branch_status','','')">
                        <i class="fas fa-add"></i> ເພີ່ມຂໍ້ມູນ
                    </button>
                </div>
                <div class="col-md-8"></div>
                <div class="col-md-2">
                    <div class="input-group">
                        <input type="text" id="search_page" name="search_page" class="form-control" style="border:1px solid #DB4900;" placeholder="ຄົ້ນຫາ...">
                        <button type="button" class="btn btn-orange search">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel panel-inverse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="limit_page" id="limit_page" class="select_option">
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="90">90</option>
                                <option value="150">150</option>
                                <option value="1000">1000</option>
                                <option value="">ທັງໝົດ</option>
                            </select>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="col-md-2">
                            <select name="order_page" id="order_page" class="select_option" style="float:right !important;">
                                <option value="ASC">ນ້ອຍຫາໃຫຍ່</option>
                                <option value="DESC">ໃຫຍ່ຫານ້ອຍ</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="panel-body px-0" style="margin-top:-14px;">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <td width="5%" style="text-align:center !important;">ລໍາດັບ</td>
                                    <td>ສະຖານະ</td>
                                    <td>ຊື່ຮ້ານ</td>
                                    <td>ຊື່ສາຂາ</td>
                                    <td>ເບີໂທ</td>
                                    <td>ອີເມວ</td>
                                    <td>ທີ່ຢູ່</td>
                                    <td width="10%" style="text-align:center !important;">ຈັດການ</td>
                                </tr>
                            </thead>
                            <tbody class="table-bordered-y table-sm display">

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_branch" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light" id="modal_title">Modal Without Animation</h4>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="frm_branch">
                        <div class="modal-body">

                            <center>
                                <!-- <div class="avatar-upload" style="margin-top:-10px;">
                                    <div class="avatar-preview" style="cursor:pointer" onchange="load_image('display_images')">
                                        <div for="store_img">
                                            <img src="../../api/images/logo/no_logo.jpg" id="display_images" name="display_images" class="display_images" alt="" style="max-width: 100%;max-height:185px">
                                            <input type='file' id="store_img" name="store_img" accept=".png, .jpg, .jpeg" style="display: none;">
                                        </div>
                                    </div>
                                    <label for="">QR Code</label>
                                    <input type="text" class="form-control" hidden id="store_img_file" name="store_img_file">
                                </div> -->

                                <div class="avatar-wrapper" style="margin-top:-5px;">
                                    <img class="profile-pic" src="" />
                                    <div class="upload-button">
                                        <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                    </div>
                                    <input class="file-upload" type="file" name="store_img" accept="image/*" />
                                </div>
                                <input type="text" class="form-control" hidden id="store_img_file" name="store_img_file">
                            </center>

                            <div class="form-group mb-2" style="margin-top:-60px !important;">
                                <label for="" class="mb-2">ຊື່ຮ້ານ <span class="text-danger">*</span></label>
                                <select name="branch_com_fk" id="branch_com_fk" class="form-select branch_com_fk" required>
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">ຊື່ສາຂາ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input_color" id="branch_name" name="branch_name" placeholder="ປ້ອນຊື່ສາຂາ" required autocomplete="off">
                                <input type="text" hidden class="form-control" id="branch_code" name="branch_code">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">ເບີໂທ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input_color" id="branch_tel" name="branch_tel" placeholder="ປ້ອນເບີໂທ" required autocomplete="off">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">ອີເມວ </label>
                                <input type="text" class="form-control input_color" id="branch_email" name="branch_email" placeholder="ປ້ອນອີເມວ" autocomplete="off">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">ທີ່ຢູ່ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input_color" id="branch_address" name="branch_address" placeholder="ປ້ອນທີ່ຢູ່" required autocomplete="off">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">ສະຖານະ <span class="text-danger">*</span></label>
                                <select name="branch_status" id="branch_status" class="form-select branch_status" required>
                                    <option value="1">ຮ້ານຫຼັກ</option>
                                    <option value="2">ສາຂາຍ່ອຍ</option>
                                </select>
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



        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
            res_store('branch_com_fk');

            load_data_setting($("#search_page").val(), $("#limit_page").val(), $("#order_page").val(), pagin = "1", "service-branch-list.php?fetch_data", "display");
            service_insert("frm_branch", "service-branch-list.php?insert_data", "modal_branch", $("#search_page").val(), $("#limit_page").val(), $("#order_page").val(), pagin = "1", "service-branch-list.php?fetch_data", "display");
            $(document).on('click', '.page-link', function() {
                var page = $(this).data('page_number');
                if (page != undefined) {
                    load_data_setting($("#search_page").val(), $("#limit_page").val(), $("#order_page").val(), page, "service-branch-list.php?fetch_data", "display");
                }
            });
            $(".search").click(function() {
                load_data_setting($("#search_page").val(), $("#limit_page").val(), $("#order_page").val(), pagin = "1", "service-branch-list.php?fetch_data", "display");
            });

            function edit_function(branch_code, branch_name, branch_tel, branch_email, branch_address, branch_com_fk, branch_status, branch_qrcode) {
                $("#modal_branch").modal("show");
                $("#modal_title").html("ແກ້ໄຂຂໍ້ມູນ");
                $("#btn_save").html("<i class='fas fa-pen'></i> ແກ້ໄຂ");
                localStorage.clear();
                $("#branch_code").val(branch_code);
                $("#branch_name").val(branch_name);
                $("#branch_tel").val(branch_tel);
                $("#branch_email").val(branch_email);
                $("#branch_address").val(branch_address);
                $("#branch_com_fk").val(branch_com_fk);
                $("#branch_status").val(branch_status);

                if (branch_qrcode != "") {
                    $("#store_img_file").val(branch_qrcode);
                    $(".profile-pic").attr("src", "../../api/images/qr/" + branch_qrcode);
                } else {
                    $(".profile-pic").attr("src", "../../api/images/logo/no_logo.jpg");
                }

                auto_focus("modal_branch", "branch_name");
            }


            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('.profile-pic').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".file-upload").on('change', function() {
                readURL(this);
            });

            $(".upload-button").on('click', function() {
                $(".file-upload").click();
            });

        </script>
</body>

</html>