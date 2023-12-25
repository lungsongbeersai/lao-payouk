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
    <title>Expenses</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified() ?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <form action="services/print-excel/print-expenses-report.php" target="_bank" method="POST">
                <ol class="breadcrumb float-xl-end">
                    <li class="breadcrumb-item active">
                        <button type="submit" name="print" class="btn btn-warning btn-xs">
                            <ion-icon name="print-outline" style="font-size: 25px;"></ion-icon>
                        </button>
                        <!-- <button type="submit" name="excel" class="btn btn-success btn-xs">
                            <ion-icon name="download-outline" style="font-size: 25px;"></ion-icon>
                        </button> -->
                    </li>
                </ol>

                <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                    <i class="fas fa-list"></i> ບັນທຶກລາຍຈ່າຍ
                </h4>

                <div class="row mb-2">
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-orange" onclick="modal_open('modalType','ເພີ່ມລາຍຈ່າຍ','add_expenses','btn_save','exp_name','exp_type_fk','zone_branch_fk1','','')">
                            <i class="fas fa-add"></i> ເພີ່ມຂໍ້ມູນ
                        </button>
                    </div>
                    <div class="col-md-10"></div>
                </div>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">

                        <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ວັນທີ່ບັນທຶກ</label>
                                <input type="date" class="form-control input_color" id="start_date" name="start_date" value="<?php echo date("Y-m-d") ?>">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ຫາວັນທີ່</label>
                                <input type="date" class="form-control input_color" id="end_date" name="end_date" value="<?php echo date("Y-m-d") ?>">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ຊື່ສາຂາ</label>
                                <div class="form-group">
                                    <select name="search_branch" id="search_branch" class="form-select zone_branch_fk">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ຄົ້ນຫາ</label>
                                <div class="input-group">
                                    <input type="text" id="search_page" name="search_page" class="form-control input_color" placeholder="ຄົ້ນຫາ...">
                                    <button type="button" class="btn btn-orange" onclick="loadList()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-2 mt-3">
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
                            <div class="col-md-2 mt-3">
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
                                        <td>ສາຂາ</td>
                                        <td>ວັນທີ່ບັນທຶກ</td>
                                        <td>ປະເພດ</td>
                                        <td>ຊື່ລາຍການ</td>
                                        <td>ຫົວໜ່ວຍ</td>
                                        <td align="center">ລາຄາ</td>
                                        <td align="center">ຈໍານວນ</td>
                                        <td align="center">ເປັນເງິນ</td>
                                        <td width="10%" style="text-align:center !important;">ຈັດການ</td>
                                    </tr>
                                </thead>
                                <tbody class="table-bordered-y table-sm display">

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="modalType" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light" id="modal_title">Modal Without Animation</h4>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="add_expenses">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ວັນທີ່ <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control input_color" value="<?php echo date("Y-m-d"); ?>" id="exp_date" name="exp_date" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="mb-2">ສາຂາ <span class="text-danger">*</span></label>
                                    <div class="form-group mb-2">
                                        <select name="zone_branch_fk" id="zone_branch_fk" class="form-select zone_branch_fk zone_branch_fk1" required>
                                            <option value="">ເລືອກ</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ປະເພດ <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="exp_type_fk" id="exp_type_fk" class="form-select exp_type_fk" required>
                                                <option value="">ເລືອກ</option>
                                            </select>
                                            <button type="button" class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#addType">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ຊື່ລາຍການ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" id="exp_name" name="exp_name" placeholder="ປ້ອນລາຍການ" required autocomplete="off">
                                        <input type="text" hidden class="form-control" id="exp_id" name="exp_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ລາຄາ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" id="exp_price" name="exp_price" placeholder="ລາຄາ" required autocomplete="off" onkeyup="calucatorPrice()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ຈໍານວນ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" id="exp_qty" name="exp_qty" value="1" placeholder="ຈໍານວນ" required autocomplete="off" onkeyup="calucatorPrice()">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ຫົວໜ່ວຍ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" id="exp_unite" name="exp_unite" placeholder="ຫົວໜ່ວຍ" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ລວມ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" readonly id="exp_total" name="exp_total" placeholder="ລວມທັງໝົດ" required autocomplete="off" style="background-color: #fff2ce;">
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


        <div class="modal fade" id="addType" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="insertType">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ເພີ່ມປະເພດລາຍຈ່າຍ</h5>
                            <button type="button" class="btn-close close1"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group mb-2">
                                    <label for="" class="mb-2">ປະເພດລາຍຈ່າຍ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control input_color" id="exp_type_name" name="exp_type_name" placeholder="ເພີ່ມປະເພດ" required autocomplete="off">
                                    <input type="text" class="form-control input_color" hidden id="exp_code_edit" name="exp_code_edit">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>ລໍາດັບ</td>
                                            <td>ຊື່ລາຍການ</td>
                                            <td align="center">ຈັດການ</td>
                                        </tr>
                                    </thead>
                                    <tbody class="type_body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">ບັນທຶກ</button>
                            <button type="button" class="btn btn-danger close1">ກັບຄືນ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
            res_branch("zone_branch_fk");
            res_expenses_type("exp_type_fk");

            $(document).on("click", ".close1", function() {
                $("#modalType").modal("show");
                $("#addType").modal("hide");
            });
            loadType()
            function loadType(){
                $.ajax({
                    url: "services/sql/service-expenses.php?loadType",
                    method: "POST",
                    success: function(data) {
                        $(".type_body").html(data);
                    }
                })
            }
            loadList(1)
            function loadList(page,
                start_date=$("#start_date").val(),
                end_date=$("#end_date").val(),
                search_page=$("#search_page").val(),
                limit=$("#limit_page").val(),
                order_page=$("#order_page").val(),
                search_branch=$("#search_branch").val()){
                $.ajax({
                    url: "services/sql/service-expenses.php?loadList1",
                    method: "POST",
                    data:{page,start_date,end_date,search_page,limit,order_page,search_branch},
                    success: function(data) {
                        $(".display").html(data);
                    }
                })
            }
            

            function calucatorPrice(){
                var exp_price=$("#exp_price").val();
                var exp_qty=$("#exp_qty").val();
                let qty =Number(exp_qty.replace(/[^0-9\.-]+/g, ""));
                let price =Number(exp_price.replace(/[^0-9\.-]+/g, ""));
                $('#exp_qty').val(numeral(qty).format('0,000'));
                $('#exp_price').val(numeral(price).format('0,000'));

                total=parseFloat(qty*price);
                $("#exp_total").val(numeral(total).format('0,000'));

            }

            function typeEdit(id_data,id_name){
                $("#exp_code_edit").val(id_data);
                $("#exp_type_name").val(id_name);
                $("#exp_type_name").focus();
            }

            
            
            $("#add_expenses").on("submit", function(event) {
                event.preventDefault();
                $.ajax({
                    url: "services/sql/service-expenses.php?insertList",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode == 200) {
                            successfuly('ບັນທຶກສໍາເລັດແລ້ວ');
                            $("#add_expenses")[0].reset();
                            res_expenses_type("exp_type_fk");
                            loadList(1);

                        }else if (dataResult.statusCode == 202) {
                            $("#modalType").modal("hide");
                            successfuly('ແກ້ໄຂສໍາເລັດແລ້ວ');
                            loadList(1)
                            $("#add_expenses")[0].reset();
                            res_expenses_type("exp_type_fk");
                            loadList();

                        }  else {
                            Error_data();
                        }

                        
                    }
                })
            })

            $("#insertType").on("submit", function(event) {
                event.preventDefault();
                $.ajax({
                    url: "services/sql/service-expenses.php?insertAll",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#insertType")[0].reset();
                        res_expenses_type("exp_type_fk");
                        loadType();
                    }
                })
            })


            function typeDelete(dataID){
                $.ajax({
                    url: "services/sql/service-expenses.php?DeleteTable",
                    method: "POST",
                    data:{dataID},
                    success: function(data) {
                        $("#insertType")[0].reset();
                        res_expenses_type("exp_type_fk");
                        loadType();
                    }
                })
            }


            function delete_function(dataID){
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
                            url: "services/sql/service-expenses.php?DeleteList",
                            method: "POST",
                            data:{dataID},
                            success: function(data) {
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    successfuly('ລຶບຂໍ້ມູນສໍາເລັດແລ້ວ');
                                    loadList(1)
                                } else {
                                    Error_data();
                                }
                            }
                        });
                    }
                })
            }


            // $("#insertType").on("submit", function(event) {
            //     event.preventDefault();
            //     $.ajax({
            //         url: "services/sql/service-expenses.php?insert",
            //         method: "POST",
            //         data: new FormData(this),
            //         contentType: false,
            //         processData: false,
            //         success: function(data) {
            //             $("#insertType")[0].reset();
            //             loadType();
            //         }
            //     })
            // })
            
            // $(".search").click(function() {
            //     load_data_setting($("#search_page").val(), $("#limit_page").val(), $("#order_page").val(), pagin = "1", "service-group-large.php?fetch_data", "display");
            // });

            function edit_function(exp_id, exp_date,exp_type_fk,exp_name,exp_price,exp_qty,exp_unite,exp_total,zone_branch_fk) {
                $("#modalType").modal("show");
                $("#modal_title").html("ແກ້ໄຂຂໍ້ມູນ");
                $("#btn_save").html("<i class='fas fa-pen'></i> ແກ້ໄຂ");
                $("#exp_id").val(exp_id);
                $("#exp_date").val(exp_date);
                $("#exp_type_fk").val(exp_type_fk);
                $("#exp_name").val(exp_name);
                $('#exp_price').val(numeral(exp_price).format('0,000'));
                $('#exp_qty').val(numeral(exp_qty).format('0,000'));
                $("#exp_unite").val(exp_name);
                $("#zone_branch_fk").val(zone_branch_fk);
                $('#exp_total').val(numeral(exp_total).format('0,000'));
                auto_focus("modalType", "group_name");
            }



        </script>
</body>

</html>