<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
function app_sidebar_minified(){
    echo "app-sidebar-minified";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Frm Product List</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified()?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <form action="services/print-excel/download-product-excel.php" method="POST">
                <ol class="breadcrumb float-xl-end">
                    <button type="submit" name="excel" class="btn btn-success btn-xs">
                        <ion-icon name="download-outline" style="font-size: 25px;"></ion-icon>
                    </button>
                </ol>

                <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                    <i class="fas fa-list"></i> ລາຍການອາຫານ ແລະ ເຄື່ອງດຶ່ມ
                </h4>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-2"> ສາຂາ <span class="text-danger">*</span></label>
                                <select name="product_branch" id="product_branch" class="form-select product_branch">
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-2"> ອາຫານກຸ່ມໃຫຍ່ <span class="text-danger">*</span></label>
                                <select name="product_group_fk" id="product_group_fk" class="form-select product_group_fk" onchange="res_categroy('product_group_fk','edit_product_cate_fk')">
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>

                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-2"> ໝວດອາຫານ <span class="text-danger">*</span></label>
                                <select name="product_cate_fk" id="product_cate_fk" class="form-select product_cate_fk">
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-2">ຄົ້ນຫາ</label>
                                <div class="input-group">
                                    <input type="text" id="search_page" name="search_page" class="form-control" style="border:1px solid #9AAAC7;" placeholder="Search...">
                                    <button type="button" class="btn btn-danger search" onclick="loadAll(1)">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <div class="panel-body" style="margin-top:-30px !important;">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="limit_page" id="limit_page" class="select_option">
                                    <option value="30">30</option>
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
                            <table class="table table-borderless table-sm text-nowrap">
                                <thead>
                                    <tr>
                                        <td align="center">ແຈ້ງເຕືອນ</td>
                                        <td width="5%" align="center">ລໍາດັບ</td>
                                        <td align="center">ຮູບ</td>
                                        <td align="center">ໝວດໝູ່</td>
                                        <td align="center">ສາຂາ</td>
                                        <td align="center">ເປີດ/ປິດ-ເມນູ</td>
                                        <td>ຊື່ອາຫານ/ເຄື່ອງດຶ່ມ</td>
                                        <td align="center">ຂະໜາດ/ຫົວໜ່ວຍ</td>
                                        <td align="center">ຈໍານວນ</td>
                                        <td align="center">ລາຄາຊື້</td>
                                        <td align="center">ລາຄາຂາຍ</td>
                                        
                                        <td align="center" width="7%">ສະຖານະ</td>
                                        <td width="10%" align="center">ຈັດການ</td>
                                    </tr>
                                </thead>
                                <tbody class="display">

                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="modal_unite" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light" id="modal_title">Modal Without Animation</h4>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="frm_unite">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="" class="mb-2">ຫົວໜ່ວຍ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input_color" id="unite_name" name="unite_name" placeholder="ປ້ອນຫົວໜ່ວຍ" autocomplete="off">
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
        

        
        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
            res_branch("product_branch");
            res_group("product_group_fk");
            function fn_togle_switch(pro_detail_code,pro_detail_open){
                localStorage.clear();
                $.ajax({
                    url:"services/sql/service-product-list.php?togle_switch",
                    method:"POST",
                    data:{pro_detail_code,pro_detail_open},
                    success:function(data){
                        successfuly("ປະມວນຜົນສໍາເລັດແລ້ວ");
                        loadAll(1);
                    }
                })
            }

            function fn_togle_notify(product_code,proStus){
                localStorage.clear();
                $.ajax({
                    url:"services/sql/service-product-list.php?togle_noti",
                    method:"POST",
                    data:{product_code,proStus},
                    success:function(data){
                        successfuly("ປະມວນຜົນສໍາເລັດແລ້ວ");
                        loadAll(1);
                    }
                })
            }

            loadAll(1);
            function loadAll(page,product_branch=$("#product_branch").val(),
                product_group_fk=$("#product_group_fk").val(),
                product_cate_fk=$("#product_cate_fk").val(),
                search_page=$("#search_page").val(),
                limit=$("#limit_page").val(),
                order_page=$("#order_page").val()){
                $.ajax({
                    url:"services/sql/service-product-list.php?fetch_data",
                    method:"POST",
                    data:{page,product_branch,product_group_fk,product_cate_fk,search_page,limit,order_page},
                    success:function(data){
                        $(".display").html(data)
                    }
                })
            }

            function delete_product(field_id){
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
                            url: "services/sql/service-product-list.php?delete_data",
                            method: "POST",
                            data:{field_id},
                            success: function(data) {
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    successfuly('ລຶບຂໍ້ມູນສໍາເລັດແລ້ວ');
                                    loadAll(1)
                                } else {
                                    Error_data();
                                }
                            }
                        });
                    }
                })
            }

            $(document).on('click', '.page-link', function() {
                var page = $(this).data('page_number');
                if (page != undefined) {
                    loadAll(page)
                }
            });
            $(".search").click(function(){
                loadAll(1)
            });
            function edit_function(unite_code,unite_name){
                $("#modal_unite").modal("show");
                $("#modal_title").html("ແກ້ໄຂຂໍ້ມູນ");
                $("#btn_save").html("<i class='fas fa-pen'></i> ແກ້ໄຂ");
                $('#'+unite_name).focus();
                $("#unite_name").val(unite_name);
                $("#unite_code").val(unite_code);
                auto_focus("modal_unite","unite_name");
            }
            
        </script>
</body>

</html>