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
    <title>History Cancel</title>
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
                    <i class="fas fa-user"></i> ລາຍງານປະຫວັດຍົກເລີກບິນຂາຍ
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
                            <div class="col-md-4 mb-2">
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
                                        <?php 
                                           if($_SESSION["user_permission_fk"]=="202300000001" || $_SESSION["user_permission_fk"]=="202300000002"){
                                                  $login=" WHERE users_id !='2022000001' ";
                                                  echo "<option value=''>ພະນັກງານຍົກເລີກ</option>";
                                           }else{
                                                  $login="WHERE users_id='".$_SESSION["users_id"]."' ";
                                           }
                                            $users=$db->fn_read_all("res_users $login ORDER BY users_id ASC");
                                            foreach($users as $rowUser){
                                                echo "<option value='".$rowUser["users_id"]."'>".$rowUser["users_name"]."</option>";
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
                var limit=$("#limit_page").val();
                var order_page=$("#order_page").val();
                var search_page=$("#search_page").val();
                var search_branch=$("#search_branch").val();
                var user_list=$("#user_list").val();
                $.ajax({
                    url:"services/report/history-cancel.php?history",
                    method:"POST",
                    data:{page,start_date,end_date,lookType,limit,order_page,search_page,search_branch,user_list},
                    cache: false,
                    dataType: "json",
                    success: function(data) {       
                        var data= data[0];
                        var i=1;
                        var html=``;
                        html+=`<table>
                            <thead style="border: 1px solid white !important;vertical-align:middle !important;">
                                <tr>
                                    <th widtd="5%" style="text-align:center !important;">ລໍາດັບ</th>
                                    <th align="center" class="th_center">ເລກບິນ</th>
                                    <th>ຂາຍໂດຍ</th>
                                    <th style="text-align: center;">ວັນທີ່ຂາຍ</th>
                                    <th style="text-align: center;">ວັນທີ່ຍົກເລີກ</th>
                                    <th style="text-align: center;">ເບີໂຕະ</th>
                                    <th>ປະເພດຊໍາລະ</th>
                                    <th>ຈໍານວນ</th>
                                    <th>ລາຄາລວມ</th>
                                    <th>ສ່ວນຫຼຸດ</th>
                                    <th>ຍອດຂາຍຕົວຈິງ</th>
                                    <th>ຍົກເລີກໂດຍ</th>
                                    <th>ໝາຍເຫດ</th>
                                </tr>
                            </thead>
                        `;
                        var convert_qty=0;
                        var convert_amount=0;
                        var convert_per=0;
                        var convert_total=0;
                        $.each(data, function(index, value) {
                            var sale_date=value.list_bill_date;
                            var dateObject = new Date(sale_date);
                            var list_bill_date = dateObject.toLocaleDateString('en-GB', { day: 'numeric', month: 'numeric', year: 'numeric' });

                            var cancel_date=value.list_bill_date;
                            var canObject = new Date(cancel_date);
                            var list_bill_cancel_date = canObject.toLocaleDateString('en-GB', { day: 'numeric', month: 'numeric', year: 'numeric' });

                            var list_bill_amount = new Intl.NumberFormat().format(value.list_bill_amount);
                            var list_bill_percented_price= new Intl.NumberFormat().format(value.list_bill_percented_price);
                            var list_bill_amount_kip= new Intl.NumberFormat().format(value.list_bill_amount_kip);

                            convert_qty+=value.list_bill_qty;
                            convert_amount+=value.list_bill_amount;
                            convert_per+=value.list_bill_percented_price;
                            convert_total+=value.list_bill_amount_kip;
                            
                            html += `
                                <tbody>
                                    <tr>
                                        <td align="center">${i++}</td>
                                        <td align="center">${value.list_bill_no}</td>
                                        <td align="center">${value.users_name}</td>
                                        <td align="center">${list_bill_date}</td>
                                        <td align="center">${list_bill_cancel_date}</td>
                                        <td align="center">${value.table_name}</td>
                                        <td align="center">${value.type_name}</td>
                                        <td align="center">${value.list_bill_qty}</td>
                                        <td align="center">${list_bill_amount}</td>
                                        <td align="center">${list_bill_percented_price}</td>
                                        <td align="center">${list_bill_amount_kip}</td>
                                        <td align="center">${value.cancel_name}</td>
                                        <td>${value.list_bill_remark}</td>
                                    </tr>
                                </tbody>
                            `;
                        })
                        BillQty=new Intl.NumberFormat().format(convert_qty);
                        BillAmount=new Intl.NumberFormat().format(convert_amount);
                        BillPer=new Intl.NumberFormat().format(convert_per);
                        BillTotal=new Intl.NumberFormat().format(convert_total);
                        html +=`<tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;">
                            <td colspan="7" align="right">ລວມທັງໝົດ</td>
                            <td align="center">${BillQty}</td>
                            <td align="center">${BillAmount}</td>
                            <td align="center">${BillPer}</td>
                            <td align="center">${BillTotal}</td>
                            <td></td>
                            <td></td>
                        </tr>`;
                        html += '</table>';
                        $('#showData').html(html);
                    }
                })
            }
        </script>
</body>
</html>