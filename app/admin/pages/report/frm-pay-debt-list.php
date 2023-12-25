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
    <title>Debt List</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified()?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <form action="services/print-excel/print-daily-debt.php" target="_bank" method="POST">
                <ol class="breadcrumb float-xl-end mb-2">
                    <li class="breadcrumb-item active">
                        <button type="submit" name="print" class="btn btn-warning btn-xs" id="showPrint">
                            <ion-icon name="print-outline" style="font-size: 25px;"></ion-icon>
                        </button>
                        <button type="submit" name="excel" class="btn btn-success btn-xs">
                            <ion-icon name="download-outline" style="font-size: 25px;"></ion-icon>
                        </button>
                    </li>
                </ol>

                <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                    <i class="fas fa-user"></i> ລາຍງານລູກຄ້າຕິດໜີ້
                </h4>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ວັນທີ່ຂາຍ ວ/ດ/ປ</label>
                                <input type="date" class="form-control input_color" id="start_date" name="start_date" value="<?php echo date("Y-m-d", strtotime("first day of this month"))?>">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ຫາວັນທີ່ ວ/ດ/ປ</label>
                                <input type="date" class="form-control input_color" id="end_date" name="end_date" value="<?php echo date("Y-m-d")?>">
                            </div>
                            
                            <!-- <div class="col-md-2 mb-2">
                                <div class="form-group">
                                    <label for="" class="mb-1">ຊື່ຮ້ານ <span class="text-danger">*</span></label>
                                    <select name="search_store" id="search_store" class="form-select search_store" onchange="res_searchBranch('search_store')">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div> -->

                            <select name="search_store" id="search_store" class="form-select search_store" hidden onchange="res_searchBranch('search_store')">
                                <option value="">ເລືອກ</option>
                            </select>

                            <div class="col-md-2 mb-2">
                                <div class="form-group">
                                    <label for="" class="mb-1">ສາຂາ <span class="text-danger">*</span></label>
                                    <select name="search_branch" id="search_branch" class="form-select search_branch">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ຮູບແບບເບິ່ງ</label>
                                <select name="lookType" id="lookType" class="form-select lookType">
                                    <option value="1">ເບິ່ງແບບລວມ</option>
                                    <option value="2">ເບິ່ງແບບລະອຽດ</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ສະຖານະ ຊໍາລະ</label>
                                <select name="status_payment" id="status_payment" class="form-select status_payment">
                                    <option value="">ທັງໝົດ</option>
                                    <option value="1">ຄ້າງຈ່າຍ</option>
                                    <option value="2">ຈ່າຍແລ້ວ</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ເລກບິນ/ເບີໂຕະ</label>
                                <div class="input-group">
                                    <input type="text" id="search_page" name="search_page" class="form-control input_color" placeholder="Search...">
                                    <button type="button" class="btn btn-primary search" onclick="SearchData()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <select name="limit_page" id="limit_page" class="select_option">
                                    <option value="100">100</option>
                                    <option value="150">150</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="">ທັງໝົດ</option>
                                </select>
                                <select name="order_page" id="order_page" class="select_option">
                                    <option value="ASC">ນ້ອຍຫາໃຫຍ່</option>
                                    <option value="DESC">ໃຫຍ່ຫານ້ອຍ</option>
                                </select>
                            </div>
                            <div class="col-md-8"></div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="user_list" id="user_list" class="form-select select2">
                                        <option value="">ລູກຄ້າທັງໝົດ</option>
                                        <?php 
                                            $users=$db->fn_read_all("res_custommer ORDER BY cus_code ASC");
                                            foreach($users as $rowUser){
                                                echo "<option value='".$rowUser["cus_code"]."'>".$rowUser["cus_name"]."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body px-0" style="margin-top:-14px;">
                        <div class="table-responsive">
                            <table class="table text-nowrap" id="showData">
                                
                            </table>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>

        
        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
            res_storeSearch('search_store');
            res_store('branch_store');
            SearchData(1);
            $('#user_list').select2({});
            function SearchData(page="1"){
                var start_date=$("#start_date").val();
                var end_date=$("#end_date").val();
                var lookType=$("#lookType").val();
                var status_payment=$("#status_payment").val();
                var limit=$("#limit_page").val();
                var order_page=$("#order_page").val();
                var search_page=$("#search_page").val();
                var search_branch=$("#search_branch").val();
                var user_list=$("#user_list").val();
                $.ajax({
                    url:"services/report/pay-debt-list.php?debt_list",
                    method:"POST",
                    data:{page,start_date,end_date,lookType,limit,order_page,search_page,status_payment,search_branch,user_list},
                    success:function(data){
                        $("#showData").html(data);
                    }
                })
            }

            $(document).on('click', '.page-link', function() {
                var page = $(this).data('page_number');
                if (page != undefined) {
                    SearchData(page);
                }
            });

            // $(document).on("click",".checkAll",function(){
            //     $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
            //     if ($('input:checkbox').filter(':checked').length < 1){
            //         $("#showPrint").attr("disabled",true);
            //     }else{
            //         $("#showPrint").attr("disabled",false);
            //     }
            // });

            // $(document).on("click",".checkOne",function(){
            //     if ($('input:checkbox').filter(':checked').length < 1){
            //         $("#showPrint").attr("disabled",true);
            //     }else{
            //         $("#showPrint").attr("disabled",false);
            //     }
            // });

        </script>
</body>

</html>