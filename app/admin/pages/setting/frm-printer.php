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
    <title>Frm Printer</title>
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
                <li class="breadcrumb-item active">ຕັ້ງຄ່າປິ່ນເຕີ</li>
            </ol>

            <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                <ion-icon name="settings-outline"></ion-icon> ຕັ້ງຄ່າປິ່ນເຕີ ( ອາຫານ ແລະ ເຄື່ອງດຶ່ມ )
                
            </h4>

            <div class="row mb-2">
                <div class="col-md-2 mb-2">
                    <button type="button" class="btn btn-outline-orange" onclick="modal_open('modal_printer','ເພີ່ມໄອພີປີ້ນເຕີ','add_printer','btn_save','printer_address','product_group_fk','product_branch','printer_type_fk','')">
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
                        <div class="col-sm-2 mb-2">
                            <select name="limit_page" id="limit_page" class="select_option">
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="90">90</option>
                                <option value="150">150</option>
                                <option value="1000">1000</option>
                                <option value="">ທັງໝົດ</option>
                            </select>
                        </div>
                        <div class="col-sm-9"></div>
                        <div class="col-sm-1">
                            <select name="order_page" id="order_page" class="select_option">
                                <option value="ASC">ນ້ອຍຫາໃຫຍ່</option>
                                <option value="DESC">ໃຫຍ່ຫານ້ອຍ</option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="panel-body px-0" style="margin-top:-14px;">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead style="background-color:#384047;color:white">
                                <tr>
                                    <td width="5%">ສະຖານະ</td>
                                    <td width="5%" style="text-align:center !important;">ລໍາດັບ</td>
                                    <td>ໄອພີປຣີ້ນເຕີ</td>
                                    <td>ຊື່ສິນຄ້າກຸ່ມໃຫຍ່</td>
                                    <td>ສາຂາ</td>
                                    <td>ຄໍາສັ່ງພິມທົດລອງ * ບໍ່ເກີນ 50 ຕົວອັກສອນ</td>
                                    <td width="10%" style="text-align:center !important;">ທົດລອງພິມ</td>
                                </tr>
                            </thead>
                            
                            <tbody class="table-bordered-y table-sm display">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


        <div class="modal fade" id="modal_printer" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light" id="modal_title">Modal Without Animation</h4>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="add_printer">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="" class="mb-2"> ສາຂາ <span class="text-danger">*</span></label>
                                <select name="product_branch" id="product_branch" class="form-select product_branch" required>
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="" class="mb-2">ສິນຄ້າກຸ່ມໃຫຍ່ <span class="text-danger">*</span></label>
                                <select name="product_group_fk" id="product_group_fk" class="form-select product_group_fk" required>
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="" class="mb-2">ປະເພດເຄື່ອງພິມ <span class="text-danger">*</span></label>
                                <select name="printer_type_fk" id="printer_type_fk" class="form-select printer_type_fk" required onchange="change_type_printer('printer_type_fk')">
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>

                            <div class="form-group mb-3" id="showPrinter">
                                
                            </div>

                            <input type="text" hidden class="form-control" id="printer_code" name="printer_code">
                            <!-- <div class="form-group mb-3">
                                <label for="" class="mb-2">ໄອພີປິ້ນເຕີ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input_color" id="printer_address" name="printer_address" placeholder="192.168.0.0" required autocomplete="off">
                            </div> -->
                            <div class="form-group mb-3">
                                <div class="form-check mt-2 mb-2">
                                    <input class="form-check-input" type="checkbox" id="printer_status" name="printer_status" value="1" checked>
                                    <label class="form-check-label" for="printer_status" style="margin-top: -18px !important;">
                                        ສະຖານະ ( ເປີດ / ປິດໃຊ້ງານ )
                                    </label>
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
            res_branch("product_branch");
            res_group("product_group_fk");
            res_type_Printer("printer_type_fk");
            

            load_data_setting($("#search_page").val(), $("#limit_page").val(), $("#order_page").val(), pagin = "1", "service-printer.php?fetch_data", "display");
            service_insert("add_printer", "service-printer.php?insert_data", "modal_printer", $("#search_page").val(), $("#limit_page").val(), $("#order_page").val(), pagin = "1", "service-printer.php?fetch_data", "display");
            $(document).on('click', '.page-link', function() {
                var page = $(this).data('page_number');
                if (page != undefined) {
                    load_data_setting($("#search_page").val(), $("#limit_page").val(), $("#order_page").val(), page, "service-printer.php?fetch_data", "display");
                }
            });
            $(".search").click(function() {
                load_data_setting($("#search_page").val(), $("#limit_page").val(), $("#order_page").val(), pagin = "1", "service-printer.php?fetch_data", "display");
            });

            function edit_function(printer_code, product_group_fk, printer_branch_fk, printer_type_fk,printer_address, printer_status) {
                $("#modal_printer").modal("show");
                $("#modal_title").html("ແກ້ໄຂຂໍ້ມູນ");
                $("#btn_save").html("<i class='fas fa-pen'></i> ແກ້ໄຂ");
                localStorage.clear();
                $("#printer_code").val(printer_code);
                $("#product_group_fk").val(product_group_fk);
                $("#product_branch").val(printer_branch_fk);
                $("#printer_type_fk").val(printer_type_fk);
                // $("#printer_address").val(printer_address);
                if (printer_status == "1") {
                    $("#printer_status").attr("checked", true);
                } else {
                    $("#printer_status").attr("checked", false);
                }
                auto_focus("modal_printer", "printer_address");


                if(printer_type_fk==="20230000001"){
                    $.ajax({
                        url: 'services/sql/service-printer.php?printer_name',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            var html=``;
                            html+=`<label for="" class="mb-2">ຊື່ປຣີ້ນເຕີ <span class="text-danger">*</span></label>
                            <select name="printer_address" id="print_name" class="form-select print_name" required>`;
                            response.forEach(function(printerName) {
                                console.log(printerName);
                                alert(printerName)
                                if(printerName===printer_address){
                                    html+=(`<option value="${printerName}" selected>${printerName}</option>`);
                                }else{
                                    html+=(`<option value="${printerName}">${printerName}</option>`);
                                }
                            });
                            html+=`</select>`;
                            $("#showPrinter").html(html);
                        },
                        error: function(xhr, status, error) {
                        console.log('AJAX request failed:', error);
                        }
                    });
            }else{
                if(printer_type_fk===""){
                    disabled="disabled";
                }else{
                    disabled="";
                }
                $("#showPrinter").html(`<label for="" class="mb-2">ໄອພີປິ້ນເຕີ <span class="text-danger">*</span></label>
                <input type="text" class="form-control input_color" id="printer_address" ${disabled} name="printer_address" placeholder="192.168.x.x" value='${printer_address}' required autocomplete="off">`);
                $("#printer_address").focus();
            }


            }

            function fn_togle_switch(userID, statasID) {
                if (statasID === "1") {
                    status = "2";
                } else {
                    status = "1";
                }
                $.ajax({
                    url: "services/sql/service-printer.php?editStatus",
                    method: "POST",
                    data: {
                        userID,
                        status
                    },
                    success: function(data) {
                        successfuly('ປະມວນຜົນສໍາເລັດ');
                        load_data_setting($("#search_page").val(), $("#limit_page").val(), $("#order_page").val(), pagin = "1", "service-printer.php?fetch_data", "display");
                    }
                })
            }

            function testintBill(printer_code,printer_type_fk){
                var testing=$("#testing"+printer_code).val();
                var ip_address=$("#ip_address"+printer_code).val();
                $.ajax({
                    url:"services/sql/service-printer.php?printing",
                    method:"POST",
                    data:{printer_code,testing,ip_address,printer_type_fk},
                    success:function(data){
                        if(data==="200"){
                            successfuly('ກໍາລັງພິມ');
                        }else{
                            ErrorFuntion("ກະລຸນາກວດສອບປີ້ນເຕີໃຫ້ຖືກຕ້ອງ");
                        }
                    }
                })
            }

        </script>
</body>

</html>