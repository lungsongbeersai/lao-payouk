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
    <title>Frm_Cancel</title>
    <?php $packget_all->main_css(); ?>
    <style>
        .no {
            font-size: 16px !important;
            font-family: 'Times New Roman', Times, serif;
            margin: 5px;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        .order {
            margin: 10px;
        }

        .table-container {
            cursor: pointer !important;
        }
    </style>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>

    <div id="app" class="app app-content-full-height app-without-header app-without-sidebar bg-white">

        <div id="content" class="app-content p-0">

            <div class="pos pos-counter" id="pos-counter">

                <div class="pos-counter-header" style="background-color:#DB4900 !important;color:white !important;">
                    <div class="logo">
                        <a href="?main">
                            <div class="logo-img">
                                <i class="fas fa-angle-left text-light"></i>
                            </div>
                            <div class="logo-text text-light">ກັບຄືນ</div>
                        </a>
                    </div>
                    <div class="time" id="time" style="font-size: 20px !important;">ຍົກເລີກບິນຂາຍ</div>
                    <div class="nav">
                        <div class="nav-item">
                            <div class="input-group date mb-0">
                                <input type="text" class="form-control" id="search_page" placeholder="Search..." />
                                <span class="input-group-text input-group-addon border-0" onclick="searchData()">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pos-counter-body">
                    <div class="pos-counter-content">

                        <div class="pos-counter-content-container" data-scrollbar="true" data-height="100%" data-skip-mobile="true">
                            <div class="table-row">

                            </div>
                        </div>
                    </div>


                    <div class="pos-counter-sidebar shadow" id="pos-counter-sidebar">
                        <div class="pos-sidebar-header">
                            <div class="back-btn">
                                <button type="button" data-dismiss-class="pos-mobile-sidebar-toggled" data-target="#pos-counter" class="btn ">
                                    <svg viewBox="0 0 16 16" class="bi bi-chevron-left " fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="icon">
                                <i class="fa fa-fw fa-utensils fa-2x"></i>
                            </div>
                            <div class="title" style="font-size: 20px !important;">ເບີໂຕະ : <span class="title_table no1 text-red" style="font-size: 25px !important;"></span></div>
                            <div class="order">ເລກບິນ:<span class="order_bill"></span></div>
                            <input type="text" hidden id="bill_id">
                            <input type="text" hidden id="table_id">
                        </div>
                        <div class="pos-sidebar-body">
                            <div class="pos-table pos_detail" data-id="pos-table-info">

                            </div>
                        </div>
                        <div class="pos-sidebar-footer" style="margin-top: -30px !important;">
                            <div class="subtotal">
                                <div class="text">ລວມເປັນເງິນ</div>
                                <div class="price amount_price no1" data-id="price-subtotal">0</div>
                            </div>
                            <div class="taxes">
                                <div class="text">ສ່ວນຫຼຸດລາຍການ (%)</div>
                                <div class="price percented_price no1" data-id="price-subtotal">0</div>
                            </div>
                            <div class="total">
                                <div class="text">ລວມເປັນເງິນທັງໝົດ</div>
                                <div class="price total_price no1" data-id="price-subtotal">0</div>
                            </div>
                            <div class="btn-row">
                                <button type="button" class="btn btn-success cancel_modal" style="background-color: #DB4900 !important;border:none">
                                    <div class="icon"><i class="fa fa-trash fa-fw fa-lg"></i></div>
                                    <div>ຍົກເລີກບິນຂາຍ</div>
                                </button>
                                <!-- <button type="button" class="btn btn-success editBill" style="background-color: #005cbf !important;border:none" id="editBill">
                                    <div class="icon"><i class="fa fa-pen fa-fw fa-lg"></i></div>
                                    <div>ແກ້ໄຂບິນ</div>
                                </button> -->
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>


        <div class="modal fade" id="modal_remark" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">ເຫດຜົນທີ່ຍົກເລີກ</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="frmCancelBill">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-2">ເຫດຜົນທີ່ຍົກເລີກ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" id="list_bill_remark" name="list_bill_remark" placeholder="ປ້ອນເຫດຜົນທີ່ຍົກເລີກ" autocomplete="off" required>
                                        <input type="text"  name="bill_no" id="bill_no" hidden>
                                    </div>
                                    <div class="form-group mb-2 mt-2">
                                        <label for="" class="mb-2">ຍົກເລີກບິນໂດຍ</label>
                                        <input type="text" class="form-control input_color" value="<?php echo $_SESSION["users_name"] ?>" autocomplete="off" required readonly style="background:#eff1f2">
                                        <input type="text" class="form-control input_color" hidden  id="list_bill_cancel_by" name="list_bill_cancel_by" value="<?php echo $_SESSION["users_id"] ?>" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="alert alert-orange text-dark" role="alert">
                                        <span class="text-danger">ໝາຍເຫດ</span> : ເມື່ອຍົກເລີກບິນແລ້ວຈະບໍ່ສາມາດກູ້ກັບຄືນມາໄດ້ !
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn_payment"><i class="fas fa-trash"></i> ຢືນຢັນ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>

    </div>

    <?php $packget_all->main_script(); ?>
    <script src="assets/js/service-all.js"></script>
    <script>
        res_storeSearch('search_store');
        res_store('branch_store');

        $(document).on("click", ".cancel_modal", function() {
            $("#modal_remark").modal("show");
        });

        searchData(1);

        function searchData() {
            var search_page = $("#search_page").val();
            $.ajax({
                url: "services/sql/service-edit-bill.php?cancel_bill",
                method: "POST",
                data: {
                    search_page
                },
                dataType: "json",
                success: function(response) {
                    var html = ``;
                    var data = response.data;
                    var selected = "";
                    if (response.rowCount > 0) {
                        for (var count = 0; count < data.length; count++) {
                            console.log("CountData:" + data[count].list_bill_no);
                            html += `
                                <div class="table ${data[count].status_disabled} selected${data[count].list_bill_no} " onclick="activeData('${data[count].list_bill_no} ')">
                                    <div class="table-container" data-toggle="select-table">
                                        <div class="table-status ${data[count].status_color}">
                                        </div>
                                        <div class="table-name shadow-sm">
                                            <div class="name">
                                                ເລກບິນ
                                            </div>
                                            <div class="no">
                                                ${data[count].list_bill_no}
                                            </div>
                                            <div class="order" >
                                                <span> ${data[count].branch_name}</span>
                                            </div>
                                        </div>
                                        <div class="table-info-row">
                                            <div class="table-info-col">
                                                <div class="table-info-container">
                                                    <span class="icon">
                                                    <i class="fas fa-table"></i>
                                                    </span>
                                                    <span class="text">ເບີໂຕະ  ${data[count].table_name}</span>
                                                </div>
                                            </div>
                                            <div class="table-info-col">
                                                <div class="table-info-container">
                                                    <span class="icon">
                                                        <i class="far fa-clock"></i>
                                                    </span>
                                                    <span class="text">${data[count].list_bill_date_time}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-info-row">
                                            <div class="table-info-col">
                                                <div class="table-info-container">
                                                    <span class="icon">
                                                    <i class="fa fa-dollar-sign"></i>
                                                    </span>
                                                    <span class="text">${numeral(data[count].list_bill_amount).format('0,000')}</span>
                                                </div>
                                            </div>
                                            <div class="table-info-col">
                                                <div class="table-info-container">
                                                    <span class="icon">${data[count].status_icon}</span>
                                                    <span class="text" style="color:#E8E4BF">${data[count].status_text}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                        }

                    } else {
                        html += `
                        <div style='width:100%'>
                            <center>
                                <img src='assets/img/logo/emty.png' class="img-fluid w-500px" alt="Responsive image">
                                <p>
                                    <h4 class="text-light">
                                    ( ບໍ່ມີລາຍການ )
                                    </h4>
                                </p>
                            </center>
                        </div>
                        `;
                    }

                    $(".table-row").html(html);
                    activeData(response.limit_row);
                    $(".selected" + response.limit_row).addClass("selected");
                }
            })
        }

        function activeData(billID) {
            $.ajax({
                url: "services/sql/service-edit-bill.php?active_bill",
                method: "POST",
                data: {
                    billID
                },
                dataType: "json",
                success: function(response) {
                    $(".cancel_modal").prop("disabled", true);
                     $(".editBill").prop("disabled", true);
                    var html = ``;
                    var data = response.data;
                    var amount_price = 0;
                    var percented_price = 0;
                    var total_price = 0;
                    var discounted = 0;
                    if (data.length > 0) {
                        $(".selected").removeClass('selected');
                        for (var count = 0; count < data.length; count++) {
                            $(".selected" + data[count].check_bill_list_bill_fk).addClass("selected");
                            if (data[count].check_bill_list_discount_status == "2") {
                                discounted = "<span class='text-danger'>" + numeral(data[count].check_bill_list_discount_price).format('0,000') + " ກີບ</span>";
                            } else {
                                discounted = "_____";
                            }
                            amount_price += data[count].check_bill_list_order_total;
                            percented_price += data[count].check_bill_list_discount_price;
                            total_price += data[count].check_bill_list_discount_total;

                            console.log(data[count].check_bill_list_discount_status)

                            html += `
                            <div class="row pos-table-row">
                                <div class="col-8">
                                    <div class="pos-product-thumb">
                                        <div class="img" style="background-image: url(../../api/images/product_home/${data[count].product_images})"></div>
                                        <div class="info">
                                            <div class="title">${data[count].product_name} ${data[count].size_name_la}</div>
                                            <div class="desc no1">[ ${data[count].check_bill_list_order_qty}  x  ${numeral(data[count].check_bill_list_pro_price).format('0,000')} ]</div>
                                            <div class="desc">- ສ່ວນຫຼຸດ : ${discounted}</div>
                                            <div class="desc">- ໝາຍເຫດ : ${data[count].check_bill_list_note_remark}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 total-price font-bold no1">${numeral(data[count].check_bill_list_order_total).format('0,000')} </div>
                            </div>
                            `;
                            $(".title_table").text(data[count].table_name);
                            $(".order_bill").text(data[count].check_bill_list_bill_fk);
                            $("#bill_id").val(data[count].bill_convert);
                            $("#table_id").val(data[count].table_convert);
                            $("#bill_no").val(data[count].check_bill_list_bill_fk);
                        }
                        $(".amount_price").text(numeral(amount_price).format('0,000'));
                        $(".percented_price").text(numeral(percented_price).format('0,000'));
                        $(".total_price").text(numeral(total_price).format('0,000'));
                        $(".cancel_modal").attr("disabled",false);
                        $(".editBill").attr("disabled",false);
                    } else {
                        html += `
                            <div class="h-100 align-items-center justify-content-center text-center p-20" data-id="pos-table-empty">
                                <div style="margin-top:25% !important">
                                    <div class="mb-3">
                                        <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                                            <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-dark">ບໍ່ມີລາຍການ</h4>
                                </div>
                            </div>
                        `;
                    }

                    $(".pos_detail").html(html);
                }
            })
        }

        $(document).on("click", "#editBill", function() {
            var bill_id = $("#bill_id").val();
            var table_id = $("#table_id").val();
            location.href = `?edit_pos&bill_no=${bill_id}&&table_id=${table_id}`;
        })


        $("#frmCancelBill").on("submit",function(event){
                event.preventDefault();
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
                            url: "services/sql/service-edit-bill.php?edit_bill_list",
                            method: "POST",
                            data:new FormData(this),
                            contentType:false,
                            processData:false,
                            success: function(data) {
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    successfuly('ລຶບຂໍ້ມູນສໍາເລັດແລ້ວ');
                                    $("#frmCancelBill")[0].reset();
                                    $("#modal_remark").modal("hide");
                                } else {
                                    Error_data();
                                }
                            },complete(){
                                location.reload()
                            }
                        });
                    }
                })
            });

    </script>
</body>

</html>