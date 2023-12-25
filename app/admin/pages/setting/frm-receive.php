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
    <title>Frm Receive</title>
    <?php $packget_all->main_css(); ?>
    <style>
        .select2-close-mask{
            z-index: 99999;
        }
        .select2-dropdown{
            z-index: 3051;
        }
        td{
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
                <li class="breadcrumb-item active">ລາຍການຮັບເຂົ້າສິນຄ້າ</li>
            </ol>

            <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                <i class="fas fa-list"></i> ລາຍການຮັບເຂົ້າສິນຄ້າ
            </h4>

            <div class="row mb-2">
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-orange" id="addOrder">
                        <i class="fas fa-add"></i> ເພີ່ມການຮັບເຂົ້າ
                    </button>
                </div>
                <div class="col-md-10"></div>
            </div>

            <div class="panel panel-inverse">

            <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="" class="mb-2">ວັນທີ່ສັ່ງຊື້</label>
                            <input type="date" class="form-control input_color" id="start_date" name="start_date" value="<?php echo date("Y-m-d")?>">
                        </div>
                        <div class="col-md-2">
                            <label for="" class="mb-2">ຫາວັນທີ່</label>
                            <input type="date" class="form-control input_color" id="end_date" name="end_date" value="<?php echo date("Y-m-d")?>">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="" class="mb-2">ຊື່ຮ້ານ <span class="text-danger">*</span></label>
                                <select name="search_store" id="search_store" class="form-select search_store" required onchange="res_searchBranch('search_store')">
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="" class="mb-2">ສາຂາ <span class="text-danger">*</span></label>
                                <select name="search_branch" id="search_branch" class="form-select search_branch" required>
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="" class="mb-2"> ຮູບແບບເບິ່ງ</label>
                            <select name="lookBill" id="lookBill" class="form-select lookBill">
                                <option value="1">ເບິ່ງແບບລວມ</option>
                                <option value="2">ເບິ່ງແບບລະອຽດ</option>
                            </select>
                        </div>
 
                        <div class="col-md-2">
                            <label for="" class="mb-2">ຄົ້ນຫາ</label>
                            <div class="input-group">
                                <input type="text" id="search_page" name="search_page" class="form-control input_color" placeholder="Search...">
                                <button type="button" class="btn btn-danger search" onclick="loadOrderItem(1)">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

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
                    <div class="table-responsive" id="showAll">
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_order_item" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 620px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light" id="modal_title">Modal Without Animation</h4>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>

                    <div class="modal-body" style="max-height: 850px">
                        <div class="row">
                            <form id="searchBill">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group mb-2">
                                    <center> <label for="" class="mb-2 text-center">ເລກທີ່ສັ່ງຊື້</center>
                                        <div class="input-group">
                                            <input type="text" class="form-control input_color text-center" autocomplete="off" id="searchInvoice" name="searchInvoice" placeholder="xxxxxxxx">
                                            <button type="submit" class="btn btn-primary search">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-12 mb-2" id="dateNow"></div>
                            <div class="col-md-12">
                                <table class="table table-bordered-y">
                                    <thead>
                                        <tr>
                                            <td style="width:50px">ລໍາດັບ</td>
                                            <td>ຊື່ສິນຄ້າ</td>
                                            <td style="width:100px;text-align:center">ລາຄາ</td>
                                            <td style="width:70px;text-align:center">ຈໍານວນ</td>
                                            <td style="width:120px;text-align:center">ລວມ</td>
                                        </tr>
                                    </thead>
                                    <tbody id="showItem" class="table-sm showItem">
                                        <tr class="removeTr text-danger text-center" style="border-bottom: 1px solid #e5e0e0;">
                                            <td colspan="6">
                                                <i class="fas fa-times-circle"></i><br>ບໍ່ມີລາຍການ
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" id="btn_save"><i class="fas fa-save"></i> ຮັບເຂົ້າສາງ</button>
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-hidden="true"><i class="fas fa-times"></i> ປິດ</button>
                    </div>
                </div>
            </div>
        </div>



        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
 


            $("#addOrder").click(function(){
                $("#modal_order_item").modal("show");
                $("#modal_title").html("ຮັບເຂົ້າສິນຄ້າ");
                $("#searchBill")[0].reset();
                $("#showItem").html(`
                    <tr class="removeTr text-danger text-center" style="border-bottom: 1px solid #e5e0e0;">
                        <td colspan="6">
                            <br>
                            <i class="fas fa-times-circle"></i><br>ບໍ່ມີລາຍການ
                            <br>
                        </td>
                    </tr>
                `);
            });

            

            $('#order_product_fk').select2({
                dropdownParent: $('#modal_order_item')
            });

            res_storeSearch('search_store');

            $("#btn_save").click(function(){
                var searchInvoice=$("#searchInvoice").val();
                Swal.fire({
                    title: 'ແຈ້ງເຕືອນ?',
                    text: "ຢືນຢັນການຮັບສິນຄ້າເຂົ້າສາງ!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fas fa-save"></i> ລຶບ',
                    cancelButtonText: '<i class="fas fa-times"></i> ປິດ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "services/sql/service-receive-item.php?confirmData",
                            method: "POST",
                            data:{searchInvoice},
                            success: function(data) {
                                $("#modal_order_item").modal("hide");
                                $("#searchBill")[0].reset();
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    successfuly('ຮັບເຂົ້າສາງສໍາເລັດແລ້ວ');
                                    loadOrderItem(1)
                                } else {
                                    Error_data();
                                }
                            }
                        });
                    }
                })
            });

            $("#searchBill").on("submit",function(event){
                event.preventDefault();
                var BillID=$("#searchInvoice").val();
                $.ajax({
                    url:"services/sql/service-receive-item.php?fetchData",
                    method:"POST",
                    data:{BillID},
                    dataType:"json",
                    success:function(data){
                        if(data==="201"){
                            ErrorFuntion("ຂໍອະໄພ ! ເລກທີ່ນີ້ຮັບເຂົ້າສາງແລ້ວ");
                            loadContent(1);
                        }else if(data==="202"){
                            ErrorFuntion("ຂໍອະໄພ ! ບໍ່ພົບເລກທີ່ຄົ້ນຫາ");
                            loadContent(1);
                        }else{
                            var html="";
                            var total1=0;
                            for (var count = 0; count < data.length; count++) {
                                Date_order=data[count].order_date;
                                html+= `
                                    <tr style='border-bottom:1px solid #efefef;' class="itemRow">
                                        <td>${count+1}</td>
                                        <td>${data[count].product_name} ( ${data[count].size_name_la} )<input type="text" hidden value="${data[count].item_order_fk}" name="product_fk[]" id="product_fk"></td>
                                        <td align="center"><input type="text" class="form-control text-center price" style="background:#f2f2f2" readonly autocomplete="off" name="price[]" value="${numeral(data[count].item_order_price).format('0,000')}"></td>
                                        <td align="center">
                                            <input type="text" class="form-control text-center qty" autocomplete="off" style="background:#f2f2f2" readonly name="qty[]" value="${numeral(data[count].item_order_qty).format('0,000')}" autocomp>
                                        </td>
                                        <td align="center"><input type="text" class="form-control text-center total" style="background:#f2f2f2" readonly name="total[]" id="total" value="${numeral(data[count].item_order_total).format('0,000')}"></td>
                                    </tr>
                                `;
                                
                            }
                            html+=`
                                <tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;">
                                    <td colspan="3" align="right">ລວມທັງໝົດ</td>
                                    <td id="showQty" align="center"></td>
                                    <td id="showPrice" align="center"></td>
                                </tr>
                            `;

                            $(function() {
                                var sumQty = 0;
                                var sumTotal = 0;
                                $(".itemRow").each(function() {
                                    sumQty += parseFloat(Number(+$(this).find(".qty").val().replace(/[^0-9\.-]+/g, "")));
                                    sumTotal += parseFloat(Number(+$(this).find(".total").val().replace(/[^0-9\.-]+/g, "")));
                                });
                                $("#showQty").html(numeral(sumQty).format('0,000'));
                                $("#showPrice").html(numeral(sumTotal).format('0,000'));
                            });

                            $(".showItem").html(html);

                            $("#dateNow").html(`
                                <span class='text-center' style='font-size:18px;font-weight:bold'>
                                    <center>ລາຍການສັ່ງຊື້</center>
                                </span><br>
                                <span style='font-size:16px' class='mb-3'>ວັນທີ່ສັ່ງຊື້ : ${Date_order}<br></span>`);
                        }
                    }
                })
            });

            loadOrderItem(1)
            function loadOrderItem(page){
                var start_date=$("#start_date").val();
                var end_date=$("#end_date").val();
                var product_branch=$("#product_branch").val();
                var lookBill=$("#lookBill").val();
                var search_store=$("#search_store").val();
                var search_branch=$("#search_branch").val();
                var search=$("#search_page").val();
                var limit=$("#limit_page").val();
                var orderby=$("#order_page").val();
                $.ajax({
                    url:"services/sql/service-receive-item.php?loatItem",
                    method:"POST",
                    data:{page,start_date,end_date,product_branch,lookBill,search_store,search_branch,search,limit,orderby},
                    success:function(data){
                        $("#showAll").html(data);
                    }
                })
            }

            function fnCancelData(receiveID,orderBill){
                Swal.fire({
                    title: 'ແຈ້ງເຕືອນ?',
                    text: "ຢືນຢັນການຍົກເລີກບິນ!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fas fa-save"></i> ຢືນຢັນ',
                    cancelButtonText: '<i class="fas fa-times"></i> ປິດ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "services/sql/service-receive-item.php?deleteOrder",
                            method: "POST",
                            data:{receiveID,orderBill},
                            success: function(data) {
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    successfuly('ລຶບຂໍ້ມູນສໍາເລັດແລ້ວ');
                                    loadOrderItem(1)
                                } else {
                                    Error_data();
                                }
                            }
                        });
                    }
                })
            }

        </script>
</body>

</html>