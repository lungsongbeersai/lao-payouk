<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
function app_sidebar_minified(){
    echo "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Group Larage</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified()?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <ol class="breadcrumb float-xl-end">
                <li class="breadcrumb-item"><a href="javascript:history.back()" class="text-danger"><i class="fas fa-arrow-circle-left"></i> ກັບຄືນ</a></li>
                <li class="breadcrumb-item active">ລາຍການອາຫານກຸ່ມໃຫຍ່</li>
            </ol>

            <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                <i class="fas fa-list"></i> ລາຍການອາຫານກຸ່ມໃຫຍ່
            </h4>

            <div class="row mb-2">
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-orange" onclick="modal_open('modal_large','ເພີ່ມກຸ່ມສິນຄ້າໃໝ່','add_group_large','btn_save','group_name','','','','')">
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
                        <div class="col-md-2 mb-2">
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
                                    <td>ຊື່ສິນຄ້າກຸ່ມໃຫຍ່</td>
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

        <div class="modal fade" id="modal_large" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light" id="modal_title">Modal Without Animation</h4>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="add_group_large">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="" class="mb-2">ສິນຄ້າກຸ່ມໃຫຍ່ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input_color" id="group_name" name="group_name" placeholder="ປ້ອນສິນຄ້າກຸ່ມໃຫຍ່" required autocomplete="off">
                                <input type="text" hidden class="form-control" id="group_code" name="group_code">
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
        <script>
            load_data_setting($("#search_page").val(),$("#limit_page").val(),$("#order_page").val(),pagin="1","service-group-large.php?fetch_data","display");
            service_insert("add_group_large", "service-group-large.php?insert_data", "modal_large",$("#search_page").val(),$("#limit_page").val(),$("#order_page").val(),pagin="1","service-group-large.php?fetch_data","display");
            $(document).on('click', '.page-link', function() {
                var page = $(this).data('page_number');
                if (page != undefined) {
                    load_data_setting($("#search_page").val(),$("#limit_page").val(),$("#order_page").val(),page,"service-group-large.php?fetch_data","display");
                }
            });
            $(".search").click(function(){
                load_data_setting($("#search_page").val(),$("#limit_page").val(),$("#order_page").val(),pagin="1","service-group-large.php?fetch_data","display");
            });
            function edit_function(group_code,group_name){
                $("#modal_large").modal("show");
                $("#modal_title").html("ແກ້ໄຂຂໍ້ມູນ");
                $("#btn_save").html("<i class='fas fa-pen'></i> ແກ້ໄຂ");
                $("#group_name").val(group_name);
                $("#group_code").val(group_code);
                auto_focus("modal_large","group_name");
            }
        </script>
</body>

</html>