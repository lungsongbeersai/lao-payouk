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
    <title>Report Cancel list</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified()?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <form action="services/print-excel/print-cancel-report.php" target="_bank" method="POST">
                <ol class="breadcrumb float-xl-end">
                    <li class="breadcrumb-item active">
                        <button type="submit" name="print" class="btn btn-warning btn-xs">
                            <ion-icon name="print-outline" style="font-size: 25px;"></ion-icon>
                        </button>
                        <button type="submit" name="excel" class="btn btn-success btn-xs">
                            <ion-icon name="download-outline" style="font-size: 25px;"></ion-icon>
                        </button>
                    </li>
                </ol>
                <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                    <i class="fas fa-file-alt"></i> ລາຍງານບິນຍົກເລີກ
                </h4>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                        <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ວັນທີ່ຂາຍ ວ/ດ/ປ</label>
                                <input type="date" class="form-control input_color" id="start_date" name="start_date" value="<?php echo date("Y-m-d")?>">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ຫາວັນທີ່ ວ/ດ/ປ</label>
                                <input type="date" class="form-control input_color" id="end_date" name="end_date" value="<?php echo date("Y-m-d")?>">
                            </div>

                            <div class="col-md-2 mb-2">
                                <div class="form-group">
                                    <label for="" class="mb-1">ຊື່ຮ້ານ <span class="text-danger">*</span></label>
                                    <select name="search_store" id="search_store" class="form-select search_store" onchange="res_searchBranch('search_store')">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <div class="form-group">
                                    <label for="" class="mb-1">ສາຂາ <span class="text-danger">*</span></label>
                                    <select name="search_branch" id="search_branch" class="form-select search_branch">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1 mb-2">
                                <label for="" class="mb-1">ຮູບແບບເບິ່ງ</label>
                                <select name="lookType" id="lookType" class="form-select lookType">
                                    <option value="1">ເບິ່ງແບບລວມ</option>
                                    <option value="2">ເບິ່ງແບບລະອຽດ</option>
                                </select>
                            </div>
                            <div class="col-md-1 mb-2">
                                <label for="" class="mb-1">ປະເພດຊໍາລະ</label>
                                <select name="typePayment" id="typePayment" class="form-select typePayment">
                                    <option value="">ທັງໝົດ</option>
                                    <option value="1">ເງິນສົດ</option>
                                    <option value="2">ເງິນໂອນ</option>
                                    <option value="3">ເງິນສົດ-ໂອນ</option>
                                    <option value="4">ບິນຕິດໜີ້</option>
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
                    <div class="panel-body px-1">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <select name="limit_page" id="limit_page" class="select_option">
                                    <option value="100">100</option>
                                    <option value="150">150</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="">ທັງໝົດ</option>
                                </select>
                            </div>
                            <div class="col-md-9"></div>
                            <div class="col-md-1">
                                <select name="order_page" id="order_page" class="select_option">
                                    <option value="ASC">ນ້ອຍຫາໃຫຍ່</option>
                                    <option value="DESC">ໃຫຍ່ຫານ້ອຍ</option>
                                    
                                </select>
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

            $(document).on("click",".editBill_no",function(){
                $("#modalCheckbill").modal("show");
            });

            SearchData(1);
            function SearchData(page="1"){
                var start_date=$("#start_date").val();
                var end_date=$("#end_date").val();
                var lookType=$("#lookType").val();
                var limit=$("#limit_page").val();
                var order_page=$("#order_page").val();
                var search_page=$("#search_page").val();
                var typePayment=$("#typePayment").val();
                var search_branch=$("#search_branch").val();
                $.ajax({
                    url:"services/report/service-cancel-list-bill.php?report",
                    method:"POST",
                    data:{page,start_date,end_date,lookType,limit,order_page,search_page,typePayment,search_branch},
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



        </script>
        
</body>

</html>