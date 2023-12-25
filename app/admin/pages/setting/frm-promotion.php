<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
function app_sidebar_minified()
{
    echo "app_sidebar_minified";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Frm Promotion</title>
    <?php $packget_all->main_css(); ?>
    <style>
        .form-control:focus {
            border-color: inherit;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        td {
            vertical-align: middle;
        }
    </style>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified() ?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <ol class="breadcrumb float-xl-end">
                <li class="breadcrumb-item"><a href="javascript:history.back()" class="text-danger"><i class="fas fa-arrow-circle-left"></i> ກັບຄືນ</a></li>
                <li class="breadcrumb-item active">ລາຍການໂປຣໂມຊັນ</li>
            </ol>

            <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                <i class="fas fa-list"></i> ລາຍການໂປຣໂມຊັນ
            </h4>

            <div class="row mb-2">
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-orange" onclick="modal_open('modal_promotion','ເພີ່ມໂປຣໂມຊັນ','frm_promotion','btn_save','users_name','branch_store','branch_code','promo_product_fk','')">
                        <i class="fas fa-add"></i> ເພີ່ມຂໍ້ມູນ
                    </button>

                </div>
            </div>

            <div class="panel panel-inverse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="mb-2">ຊື່ຮ້ານ <span class="text-danger">*</span></label>
                                <select name="search_store" id="search_store" class="form-select search_store" required onchange="res_searchBranch('search_store')">
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="mb-2">ສາຂາ <span class="text-danger">*</span></label>
                                <select name="search_branch" id="search_branch" class="form-select search_branch" required>
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <label for="" class="mb-2">ຄົ້ນຫາ</label>
                            <div class="input-group">
                                <input type="text" id="search_page" name="search_page" class="form-control input_color" placeholder="ຄົ້ນຫາ...">
                                <button type="button" class="btn btn-orange search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <td style="width: 70px;">ສະຖານະ</td>
                                    <td style="text-align:center !important;width:80px">ລໍາດັບ</td>
                                    <td>ຊື່ຮ້ານ</td>
                                    <td>ສາຂາ</td>
                                    <td align="center">ວັນທີ່ເລີ່ມໂປຣ</td>
                                    <td align="center">ວັນທີ່ໝົດໂປຣ</td>
                                    <td align="center">ຊື່ສິນຄ້າ</td>
                                    <td align="center">ຈໍານວນຊື້</td>
                                    <td align="center">ຈໍານວນແຖມ</td>
                                    <td align="center">ລວມທັງໝົດ</td>
                                    <td align="center">ລວມເປັນເງິນ</td>
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

        <div class="modal fade" id="modal_promotion" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light" id="modal_title">Modal Without Animation</h4>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="frm_promotion">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">ຊື່ຮ້ານ <span class="text-danger">*</span></label>
                                        <select name="branch_store" id="branch_store" class="form-select branch_store" required onchange="res_store('branch_store')">
                                            <option value="">ເລືອກ</option>
                                        </select>
                                    </div>
                                    <input type="text" hidden class="form-control" id="promo_id" name="promo_id">
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="form-group">
                                        <label for="" class="mb-1">ສາຂາ <span class="text-danger">*</span></label>
                                        <select name="branch_code" id="branch_code" class="form-select branch_code" onchange="changeProduct('branch_code')" required>
                                            <option value="">ເລືອກ</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-1">ວັນທີ່ເລີ່ມໂປຼ <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control input_color" id="promo_start_date" name="promo_start_date" value="<?php echo date("Y-m-d") ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="mb-1">ເວລາເລີ່ມໂປຼ <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select name="promo_start_time" id="promo_start_time" class="form-select promo_start_time" required>
                                                <?php
                                                for ($j = 1; $j <= 24; $j++) {
                                                    if($j<10){
                                                        $startTime="0".$j;
                                                    }else{
                                                        $startTime=$j;
                                                    }
                                                ?>
                                                    <option value="<?php echo $startTime; ?>"><?php echo $startTime; ?></option>
                                                <?php } ?>
                                            </select>
                                        <select name="promo_start_time_sa" id="promo_start_time_sa" class="form-select promo_start_time_sa" required>
                                            <?php
                                            for ($k = 0; $k <= 60; $k++) {
                                                if($k<10){
                                                    $startTime_sa="0".$k;
                                                }else{
                                                    $startTime_sa=$k;
                                                }
                                            ?>
                                            <option value="<?php echo $startTime_sa; ?>"><?php echo $startTime_sa; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-1">ວັນທີ່ໝົດໂປຼ <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control input_color" id="promo_end_date" name="promo_end_date" value="<?php echo date("Y-m-d") ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="mb-1">ເວລາໝົດໂປຼ <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select name="promo_end_time" id="promo_end_time" class="form-select promo_end_time" required>
                                                <?php
                                                for ($l = 1; $l <= 24; $l++) {
                                                    if($l<10){
                                                        $end_h="0".$l;
                                                    }else{
                                                        $end_h=$l;
                                                    }
                                                ?>
                                                    <option value="<?php echo $end_h; ?>"><?php echo $end_h; ?></option>
                                                <?php } ?>
                                            </select>
                                        <select name="promo_end_time_sa" id="promo_end_time_sa" class="form-select promo_end_time_sa" required>
                                            <?php
                                            for ($m = 0; $m <= 60; $m++) {
                                                if($m<10){
                                                    $end_sa="0".$m;
                                                }else{
                                                    $end_sa=$m;
                                                }
                                            ?>
                                            <option value="<?php echo $end_sa; ?>"><?php echo $end_sa; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-1">
                                    <label for="" class="mb-1"> ຊື່ສິນຄ້າ <span class="text-danger">*</span></label>
                                    <select name="promo_product_fk" id="promo_product_fk" class="form-select promo_product_fk" required>
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-1">ຈໍານວນຊື້ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color promo_qty" id="promo_qty" name="promo_qty" placeholder="0.0" required onkeyup="calculator()" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-1">ຈໍານວນແຖມ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color promo_gif_qty" id="promo_gif_qty" name="promo_gif_qty" placeholder="0.0" required onkeyup="calculator()" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-1">ລວມຈໍານວນຊື້+ແຖມ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" id="promo_qty_total" name="promo_qty_total" readonly placeholder="0.0" style="background-color:#f0f2cb ;">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-1">ລາຄາໂປຼ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color promo_price" id="promo_price" name="promo_price" required placeholder="0.0" onkeyup="format('promo_price')" autocomplete="off">
                                    </div>
                                </div>
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
            res_storeSearch('search_store');
            res_store('branch_store');
            loadPromotion(1)

            function calculator() {
                var promo_qty = Number($("#promo_qty").val().replace(/[^0-9\.-]+/g, ""));
                var promo_gif_qty = Number($("#promo_gif_qty").val().replace(/[^0-9\.-]+/g, ""));

                if (promo_qty != "") {
                    $('#promo_qty').val(numeral(promo_qty).format('0,000'));
                } else {
                    $('#promo_qty').val("");
                }

                if (promo_gif_qty != "") {
                    $('#promo_gif_qty').val(numeral(promo_gif_qty).format('0,000'));
                } else {
                    $('#promo_gif_qty').val("");
                }

                total = parseFloat(promo_qty + promo_gif_qty);
                $("#promo_qty_total").val(numeral(total).format('0,000'));

            }


            function loadPromotion(page) {
                var search_store = $("#search_store").val();
                var search_branch = $("#search_branch").val();
                var search = $("#search_page").val();
                var limit = $("#limit_page").val();
                var orderby = $("#order_page").val();
                $.ajax({
                    url: "services/sql/service-promotion.php?fetch_data",
                    method: "POST",
                    data: {
                        page,
                        search_store,
                        search_branch,
                        search,
                        limit,
                        orderby
                    },
                    success: function(data) {
                        $(".display").html(data);
                    }
                })
            }

            $("#frm_promotion").on("submit", function(event) {
                event.preventDefault();
                $.ajax({
                    url: "services/sql/service-promotion.php?insert_data",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        loadPromotion(1);
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode == 200) {
                            $("#modal_promotion").modal("hide");
                            successfuly("ບັນທຶກສໍາເລັດ");
                        } else if (dataResult.statusCode == 202) {
                            $("#modal_promotion").modal("hide");
                            successfuly("ແກ້ໄຂສໍາເລັດແລ້ວ");
                        } else if (dataResult.statusCode == 205) {
                            ErrorFuntion("ຂໍອະໄພ ! ລະຫັດຜ່ານຂອງທ່ານຊໍ້າກັນ");
                        } else {
                            ErrorFuntion("ຫຼົ້ມເຫຼວ");
                        }
                    }
                })
            });

            function edit_function(promo_id, promo_store_fk, promo_branch_fk, promo_start_date,promo_start_time,promo_start_time_sa,promo_end_date,promo_end_time,promo_end_time_sa,promo_product_fk, promo_qty, promo_gif_qty, promo_qty_total,promo_price) {
                localStorage.clear();
                $("#modal_promotion").modal("show");
                $("#modal_title").html("ແກ້ໄຂຂໍ້ມູນ");
                $("#btn_save").html("<i class='fas fa-pen'></i> ແກ້ໄຂ");
                $("#promo_id").val(promo_id);
                $(".branch_store").val(promo_store_fk);
                $(".branch_code").val(promo_branch_fk);
                $("#promo_start_date").val(promo_start_date);
                $("#promo_start_time").val(promo_start_time);
                $("#promo_start_time_sa").val(promo_start_time_sa);
                $("#promo_end_date").val(promo_end_date);
                $("#promo_end_time").val(promo_end_time);
                $("#promo_end_time_sa").val(promo_end_time_sa);
                $("#promo_qty").val(promo_qty);
                $("#promo_gif_qty").val(promo_gif_qty);
                $("#promo_qty_total").val(promo_qty_total);
                $("#promo_price").val(numeral(promo_price).format('0,000'));
                changeProduct('branch_code');
                $.ajax({
                    url: "services/sql/service-all.php?fetchProduct",
                    method: "POST",
                    data: {
                        promo_product_fk
                    },
                    dataType: "json",
                    success: function(data) {
                        $(".promo_product_fk").val(data.pro_detail_code);
                    }
                })


            }

            function delete_user(field_id, proID) {
                Swal.fire({
                    title: 'ແຈ້ງເຕືອນ?',
                    text: "ຢືນຢັນການລຶບຂໍ້ມູນ!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fas fa-save"></i> ລຶບ',
                    cancelButtonText: '<i class="fas fa-times"></i> ປິດ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "services/sql/service-promotion.php?delete_data",
                            method: "POST",
                            data: {
                                field_id,
                                proID
                            },
                            success: function(data) {
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    successfuly('ລຶບຂໍ້ມູນສໍາເລັດແລ້ວ');
                                    loadPromotion(1)
                                } else {
                                    Error_data();
                                }
                            }
                        });
                    }
                })
            }


            function fn_togle_switch(userID, statasID) {
                if (statasID === "1") {
                    status = "2";
                } else {
                    status = "1";
                }
                $.ajax({
                    url: "services/sql/service-promotion.php?editStatus",
                    method: "POST",
                    data: {
                        userID,
                        status
                    },
                    success: function(data) {
                        loadPromotion(1)
                    }
                })
            }

            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
        </script>
</body>

</html>