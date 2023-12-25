<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
function app_sidebar_minified()
{
    echo "app-sidebar-minified";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Report Count Stock</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified() ?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <form action="services/print-excel/print-count-stock.php" target="_bank" method="POST">
                <ol class="breadcrumb float-xl-end mb-2">
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
                    <i class="fas fa-file-alt"></i> ລາຍງານສະຕ໋ອກ
                </h4>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ວັນທີ່</label>
                                <input type="date" class="form-control input_color" id="start_date" name="start_date" value="<?php echo date("Y-m-d") ?>">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ຫາວັນ</label>
                                <input type="date" class="form-control input_color" id="end_date" name="end_date" value="<?php echo date("Y-m-d") ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <div class="form-group">
                                    <label for="" class="mb-1">ຊື່ຮ້ານ <span class="text-danger">*</span></label>
                                    <select name="search_store" id="search_store" class="form-select search_store" onchange="res_searchBranch('search_store')">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <div class="form-group">
                                    <label for="" class="mb-1">ສາຂາ <span class="text-danger">*</span></label>
                                    <select name="search_branch" id="search_branch" class="form-select search_branch">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ລະຫັດສິນຄ້າ</label>
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
                                    <option value="100">90</option>
                                    <option value="150">150</option>
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
                        <div class="table-responsive table-responsive1">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ລໍາດັບ</th>
                                        <th>ຊື່ຮ້ານ</th>
                                        <th>ສາຂາ</th>
                                        <th>ລະຫັດສິນຄ້າ</th>
                                        <th>ຊື່ສິນຄ້າ</th>
                                        <th align="center">ຮັບເຂົ້າ</th>
                                        <th align="center">ຂາຍອອກ</th>
                                        <th align="center">ຄົງເຫຼືອ</th>
                                    </tr>
                                </thead>
                                <tbody id="showDataAll" class="table-bordered-y table-sm">

                                </tbody>
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

            function SearchData(page = "1") {
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();
                var search_store = $("#search_store").val();
                var search_branch = $("#search_branch").val();
                var limit = $("#limit_page").val();
                var order_page = $("#order_page").val();
                var search_page = $("#search_page").val();
                $.ajax({
                    url: "services/report/count-stock-report.php?report",
                    method: "POST",
                    data: {
                        page,
                        start_date,
                        end_date,
                        search_store,
                        limit,
                        order_page,
                        search_page,
                        search_branch
                    },
                    success: function(data) {
                        $("#showDataAll").html(data);
                    }
                })
            }

            // $(document).on('click', '.page-link', function() {
            //     var page = $(this).data('page_number');
            //     if (page != undefined) {
            //         SearchData(page);
            //     }
            // });
        </script>
</body>

</html>