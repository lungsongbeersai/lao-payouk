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
    <title>Frm Order</title>
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
                <li class="breadcrumb-item active">ລາຍການສັ່ງຊື້</li>
            </ol>

            <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                <i class="fas fa-list"></i> ລາຍການສັ່ງຊື້
            </h4>

            <div class="row mb-2">
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-orange" id="addOrder">
                        <i class="fas fa-add"></i> ສ້າງໃບສັ່ງຊື້
                    </button>
                </div>
                <div class="col-md-10"></div>
            </div>

            <div class="panel panel-inverse">

            <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <label for="" class="mb-2">ວັນທີ່ສັ່ງຊື້</label>
                            <input type="date" class="form-control input_color" id="start_date" name="start_date" value="<?php echo date("Y-m-d")?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="" class="mb-2">ຫາວັນທີ່</label>
                            <input type="date" class="form-control input_color" id="end_date" name="end_date" value="<?php echo date("Y-m-d")?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="form-group">
                                <label for="" class="mb-2">ຊື່ຮ້ານ <span class="text-danger">*</span></label>
                                <select name="search_store" id="search_store" class="form-select search_store" required onchange="res_searchBranch('search_store')">
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="form-group">
                                <label for="" class="mb-2">ສາຂາ <span class="text-danger">*</span></label>
                                <select name="search_branch" id="search_branch" class="form-select search_branch" required>
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="" class="mb-2"> ຮູບແບບເບິ່ງ</label>
                            <select name="lookBill" id="lookBill" class="form-select lookBill">
                                <option value="1">ເບິ່ງແບບລວມ</option>
                                <option value="2">ເບິ່ງແບບລະອຽດ</option>
                            </select>
                        </div>
 
                        <div class="col-md-2">
                            <label for="" class="mb-2">ຄົ້ນຫາ</label>
                            <div class="input-group">
                                <input type="text" id="search_page" name="search_page" class="form-control" style="border:1px solid #9AAAC7;" placeholder="Search...">
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
            <div class="modal-dialog" style="max-width: 700px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light" id="modal_title">Modal Without Animation</h4>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="frm_order_item">
                        <div class="modal-body" style="max-height: 850px">
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ຊື່ຮ້ານ <span class="text-danger">*</span></label>
                                        <select name="branch_store" id="branch_store" class="form-select branch_store" required onchange="res_store('branch_store')">
                                            <option value="">ເລືອກ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ສາຂາ <span class="text-danger">*</span></label>
                                        <select name="branch_code" id="branch_code" class="form-select branch_code" required>
                                            <option value="">ເລືອກ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ວັນທີ່ສັ່ງຊື້ <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control input_color" name="order_date" value="<?php echo date("Y-m-d")?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ຊື່ສິນຄ້າ <span class="text-danger">*</span></label>
                                        <select name="order_product_fk" id="order_product_fk" class="form-control order_product_fk" style="width:100% !important" required>
                                            <option value="">ເລືອກ</option>
                                            <?php 
                                                $sqlProduct=$db->fn_read_all("view_product_list WHERE product_branch='" . $_SESSION["user_branch"] . "' AND product_cut_stock='2' ");
                                                foreach($sqlProduct as $rowProduct){
                                                    echo "<option value='".$rowProduct["pro_detail_code"]."'>".$rowProduct["product_name"]." ( ".$rowProduct["size_name_la"]." )</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ຈໍານວນ</label>
                                        <input type="text" class="form-control input_color order_qty" autocomplete="off" placeholder="ປ້ອນຈໍານວນ" name="order_qty" id="order_qty" onkeyup="format('order_qty')">
                                        <input type="text" id="order_code" hidden name="order_code">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="mb-2">ລາຄາ</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control input_color order_price" autocomplete="off" placeholder="ປ້ອນລາຄາ" name="order_price" id="order_price" onkeyup="format('order_price')">
                                        <button type="button" class="btn btn-primary addRow">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered-y">
                                        <thead>
                                            <tr>
                                                <td style="width:50px">ລໍາດັບ</td>
                                                <td>ຊື່ສິນຄ້າ</td>
                                                <td style="width:70px;text-align:center">ຈໍານວນ</td>
                                                <td style="width:100px;text-align:center">ລາຄາ</td>
                                                <td style="width:120px;text-align:center">ລວມ</td>
                                                <td style="width:20px">ລຶບ</td>
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
                            <button type="submit" class="btn btn-outline-primary" id="btn_save" disabled><i class="fas fa-save"></i> ບັນທຶກ</button>
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-hidden="true"><i class="fas fa-times"></i> ປິດ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>

            $("#addOrder").click(function(){
                $("#modal_order_item").modal("show");
                $("#modal_title").html("ສ້າງໃບສັ່ງຊື້ໃໝ່");
                $("#frm_order_item")[0].reset();
                $("#showItem").html(`
                    <tr class="removeTr text-danger text-center" style="border-bottom: 1px solid #e5e0e0;">
                        <td colspan="6">
                            <i class="fas fa-times-circle"></i><br>ບໍ່ມີລາຍການ
                        </td>
                    </tr>
                `);
            });

            $('#order_product_fk').select2({
                dropdownParent: $('#modal_order_item')
            });

            res_storeSearch('search_store');
            res_store('branch_store');

            $("#frm_order_item").on("submit",function(event){
                event.preventDefault();
                $.ajax({
                    url:"services/sql/service-order-item.php?insert_data",
                    method:"POST",
                    data:new FormData(this),
                    contentType:false,
                    processData:false,
                    success:function(data){
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode == 200) {
                            successfuly("ບັນທຶກສໍາເລັດ");
                            $("#modal_order_item").modal("hide");
                            loadOrderItem(1)
                        }else if(dataResult.statusCode == 201){
                            successfuly("ແກ້ໄຂສໍາເລັດແລ້ວ");
                            $("#modal_order_item").modal("hide");
                            loadOrderItem(1)
                        }else{
                            ErrorFuntion("ຫຼົ້ມເຫຼວ");
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
                    url:"services/sql/service-order-item.php?loatItem",
                    method:"POST",
                    data:{page,start_date,end_date,product_branch,lookBill,search_store,search_branch,search,limit,orderby},
                    success:function(data){
                        $("#showAll").html(data);
                    }
                })
            }

            

        </script>
        <script>
            var count_id = 0;
              $(document).ready(function() {
                $(document).on('click', '.addRow', function() {
                    if($("#order_product_fk").val()==="" && $("#order_qty").val()==="" && $("#order_price").val()===""){
                        $(".order_product_fk")[0].focus();
                        $('.order_product_fk').prop('focus', true);
                    }else if($("#order_product_fk").val()===""){
                        $("#order_product_fk").focus();
                    }else if($("#order_qty").val()===""){
                        $("#order_qty").focus();
                    }else if($("#order_price").val()===""){
                        $("#order_price").focus();
                    }else{

                        $(".removeTr").remove();
                        count_id++;
                        var qty=Number($("#order_qty").val().replace(/[^0-9\.-]+/g, ""));
                        var price=Number($("#order_price").val().replace(/[^0-9\.-]+/g, ""));
                        var total=parseFloat(qty*price);
                        var html='';
                            html+= `
                            <tr style='border-bottom:1px solid #efefef;' id='re${count_id}' class="itemRow">
                                <td>${count_id}</td>
                                <td>${$("#order_product_fk").find(":selected").text()}<input type="text" hidden value="${$("#order_product_fk").val()}" name="product_fk[]" id="product_fk"></td>
                                <td align="center">
                                    <input type="text" class="form-control text-center qty" name="qty[]" autocomplete="off" id="${count_id}" value="${numeral(qty).format('0,000')}">
                                </td>
                                <td align="center"><input type="text" class="form-control text-center price" autocomplete="off" name="price[]" id="${count_id}" value="${numeral(price).format('0,000')}"></td>
                                <td align="center"><input type="text" class="form-control text-center total" style="background:#f2f2f2" readonly name="total[]" id="total${count_id}" value="${numeral(total).format('0,000')}"></td>
                                <td class="text-center text-danger remove" style='cursor: pointer' id='${count_id}'><i class="fas fa-trash"></i></td>
                            </tr>
                        `;
                        $('.showItem').append(html);
                        $("#order_qty").val("");
                        $("#order_price").val("");
                        $("#order_qty").focus();
                        $("#btn_save").attr("disabled",false);
                    }
                });
                $(document).on('click', '.remove', function() {
                    var removes=$(this).attr("Id");
                    $("#re"+removes).remove();
                    countID=(count_id--);
                    if(countID>1){
                        $("#btn_save").attr("disabled",false);
                    }else{
                        $("#btn_save").attr("disabled",true);
                    }
                });
            });

            $(document).on("keyup",".itemRow",function(){
                $("tr.itemRow").each(function() {
                    let qty =Number($('.qty', this).val().replace(/[^0-9\.-]+/g, ""));
                    let price =Number($('.price', this).val().replace(/[^0-9\.-]+/g, ""));
                    $('.qty', this).val(numeral(qty).format('0,000'));
                    $('.price', this).val(numeral(price).format('0,000'));
                    total=parseFloat(qty*price);
                    $(".total",this).val(numeral(total).format('0,000'));
                });
            });

            function edit_function(BillID,dateID,storeID,branchID){
                $("#modal_order_item").modal("show");
                $("#modal_title").html("ແກ້ໄຂການສັ່ງຊື້");
                $("#order_code").val(BillID);
                $("#order_date").val(dateID);
                $("#branch_store").val(storeID);
                $("#branch_code").val(branchID);
                $.ajax({
                    url:"services/sql/service-order-item.php?fetchData",
                    method:"POST",
                    data:{BillID},
                    dataType:"json",
                    success:function(data){
                        var html="";
                        for (var count = 0; count < data.length; count++) {
                            count_id++;
                            html+= `
                                <tr style='border-bottom:1px solid #efefef;' id='re${count_id}' class="itemRow">
                                    <td>${count+1}</td>
                                    <td>${data[count].product_name} ( ${data[count].size_name_la} )<input type="text" hidden value="${data[count].item_order_fk}" name="product_fk[]" id="product_fk"></td>
                                    <td align="center">
                                        <input type="text" class="form-control text-center qty" autocomplete="off" name="qty[]" id="" value="${numeral(data[count].item_order_qty).format('0,000')}" autocomp>
                                    </td>
                                    <td align="center"><input type="text" class="form-control text-center price" autocomplete="off" name="price[]" id="" value="${numeral(data[count].item_order_price).format('0,000')}"></td>
                                    <td align="center"><input type="text" class="form-control text-center total" style="background:#f2f2f2" readonly name="total[]" id="total" value="${numeral(data[count].item_order_total).format('0,000')}"></td>
                                    <td class="text-center text-danger remove" style='cursor: pointer' id='${count_id}'><i class="fas fa-trash"></i></td>
                                </tr>
                            `;
                        }
                        $(".showItem").html(html);
                    }
                })
            }

            function delete_Orders(field_id){
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
                            url: "services/sql/service-order-item.php?deleteOrder",
                            method: "POST",
                            data:{field_id},
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