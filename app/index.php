<?php session_start();
require_once '../api/db.php';
$db = new DBConnection();
@$table_code = base64_decode($_GET["table_code"]);
@$table_name = base64_decode($_GET["table_name"]);
@$users_id = base64_decode($_GET["users_id"]);
@$user_branch = base64_decode($_GET["user_branch"]);
@$bill_code = base64_decode($_GET["bill_code"]);
@$sqlCount = $db->fn_fetch_rowcount("res_bill WHERE bill_code='" . @$bill_code . "' AND bill_status='1'");
if (@$sqlCount > 0) {
?>
    <!doctype html>
    <html lang="en">

    <head>
        <title>frm_custommer</title>
        <?php require_once("../component/stylesheet.php") ?>
    </head>

    <body>

        <div id="loader">
            <div class="spinner-border text-primary" role="status"></div>
        </div>

        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#modal_call_me">
                    <!-- <ion-icon src="../api/images/svg/notifications-outline.svg"></ion-icon> -->
                    <i class="far fa-bell fa-shake" style="font-size:25px;--fa-animation-duration: 5s;"></i>
                </a>
            </div>
            <div class="pageTitle">
                ເບີໂຕະ <?php echo $table_name; ?>
                <input type="text" hidden id="user_branch" name="user_branch" value="<?php echo $user_branch; ?>">
                <input type="text" hidden id="users_id" name="users_id" value="<?php echo $users_id; ?>">
                <input type="text" hidden id="bill_code" name="bill_code">
                <input type="text" hidden id="table_code" name="table_code" value="<?php echo $table_code; ?>">
                <input type="text" hidden id="table_name" name="table_name" value="<?php echo $table_name; ?>">
            </div>
            <div class="right">
                <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#QR_Code">
                    <!-- <ion-icon name="qr-code-outline"></ion-icon> -->
                    <ion-icon src="../api/images/svg/qr-code-outline.svg"></ion-icon>
                </a>
            </div>
        </div>

        <div class="extraHeader px-1">
            <div class="search-form">
                <div class="form-group searchbox">
                    <input type="text" class="form-control form-control-lg text-center" id="search_box" onkeyup="searchData()" autocomplete="off" placeholder="ຄົ້ນຫາ...">
                </div>
            </div>
        </div>


        <nav class="nav-horizontal-scroll fixed-top" style="z-index:800 !important;">
            <ul id="showMenu">

            </ul>
        </nav>

        <!-- App Capsule -->
        <div id="appCapsule" class="extra1-header-active" style="margin-top:85px;">
            <div class="section mt-3 px-1 mb-5" id="showData">

            </div>
            <div id="draggable" draggable="true" class="draggable" onClick="shoppingDetail()">
                <ion-icon src="../api/images/svg/cart-outline.svg"></ion-icon>
                <div class="count_notification1">
                    <div style="margin-top:-6px !important;" class="count_notification">0</div>
                </div>
            </div>
        </div>

        <div class="modal fade modalbox" id="modal_orders" data-bs-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="appHeader bg-primary text-light">
                        <div class="left">
                            <a href="#" class="headerButton" data-bs-dismiss="modal">
                                <ion-icon src="../api/images/svg/chevron-back-outline.svg"></ion-icon>
                            </a>
                        </div>
                        <div class="pageTitle">ລາຍການທີ່ທ່ານເລືອກ</div>
                    </div>

                    <div class="modal-body px-0 showDetail">

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Form -->
        <div class="modal fade modalbox" id="modal_cart" data-bs-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form id="confirm_orders">
                    <div class="modal-content">
                        <div class="appHeader bg-primary text-light">
                            <div class="left">
                                <a href="#" class="headerButton" data-bs-dismiss="modal">
                                    <ion-icon src="../api/images/svg/chevron-back-outline.svg"></ion-icon>
                                </a>
                            </div>
                            <div class="pageTitle">ກະຕ່າຂອງຂ້ອຍ</div>
                        </div>
                        <div class="modal-body px-1">
                            <div class="section mb-5 px-1" id="cart_detail" style="margin-bottom: 4rem !important;">

                            </div>

                            <div id="appBottomMenu3">
                                <div class="row">
                                    <div class="col">
                                        <strong class="text-dark" style="font-size: 16px;margin-left:10px;">ລວມຍອດ</strong>
                                    </div>
                                    <div class="col">
                                        <strong class="text-dark" style="float: right !important;font-size:20px;margin-right:10px !important;">
                                            <span id="cart_total">0.0</span>
                                            <spsn style="font-size:14px">ກີບ</span>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            <div class="section bg-primary">
                                <button type="submit" class="btn btn-primary btn-lg btn-block fixed-bottom square emit_submit_ordersPY">
                                    <ion-icon src="../api/images/svg/print-outline.svg"></ion-icon>
                                    ຢືນຢັນການສັ່ງ
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="toast-12" class="toast-box toast-center" style="z-index:1200 !important;">
            <div class="in">
                <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
                <div class="text">
                    ເພີ່ມເຂົ້າກະຕ໋າສໍາເລັດ
                </div>
            </div>
        </div>
        <div id="toast-121" class="toast-box toast-center" style="z-index:1200 !important;">
            <div class="in">
                <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
                <div class="text">
                    ເພີ່ມຈໍານວນສໍາເລັດແລ້ວ
                </div>
            </div>
        </div>

        <div id="toast_confirm" class="toast-box toast-center" style="z-index:1200 !important;">
            <div class="in">
                <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
                <div class="text">
                    ຢືນຢັນອໍເດີສໍາເລັດ
                </div>
            </div>
        </div>

        <div id="toast_enough" class="toast-box toast-center" style="z-index:1200 !important;">
            <div class="in">
                <ion-icon name="close-circle-outline" class="text-danger"></ion-icon>
                <div class="text">
                    ຂໍອະໄພ ! ຈໍານວນໃນສະຕ໋ອບໍ່ພໍຂາຍ
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-text-light close-button btn-danger">ປິດ</button>
        </div>

        <div id="toast-122" class="toast-box toast-center" style="z-index:1200 !important;">
            <div class="in">
                <ion-icon name="close-circle-outline" class="text-danger"></ion-icon>
                <div class="text">
                    ຂໍອະໄພ ! ສິນຄ້າບໍ່ພໍຂາຍ
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-text-light close-button btn-danger">ປິດ</button>
        </div>

        <div class="modal fade dialogbox" id="empty" data-bs-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-icon">
                        <ion-icon name="close-circle-outline" class="text-danger"></ion-icon>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">ແຈ້ງເຕືອນ</h5>
                    </div>
                    <div class="modal-body">
                        ລາຍການນີ້ໝົດແລ້ວ
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn bg-danger" data-bs-dismiss="modal">
                                ປິດໜ້າຕ່າງ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade dialogbox" id="modal_call_me" data-bs-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-icon text-primary">
                        <ion-icon name="person-circle-outline"></ion-icon>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">ຊ່ວຍເຫຼືອ</h5>
                    </div>
                    <div class="modal-body">
                        ທ່ານຕ້ອງການເອີ້ນພະນັກງານເສີບແມ່ນບໍ່ ?
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">ປິດ</a>
                            <a href="#" class="btn btn-text-primary confirm_call">ແມ່ນແລ້ວ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade dialogbox" id="QR_Code" data-bs-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <input type="text" hidden name="urlCode" id="urlCode" value="<?php include("../assets/js/ip.php"); ?>?bill_code=<?php echo base64_encode($bill_code); ?>&table_code=<?php echo base64_encode($table_code); ?>&table_name=<?php echo @base64_encode($table_name); ?>&users_id=<?php echo base64_encode(@$users_id); ?>&user_branch=<?php echo base64_encode(@$user_branch); ?>" style="width:80%" />
                    <center>
                        <br>
                        <h2>
                            ໂຕະ <?php echo $table_name ?>
                        </h2>
                        <div id="qrcode"></div>
                        <br>
                    </center>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-danger" data-bs-dismiss="modal">ປິດໜ້າຕ່າງ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modalbox" id="histroy_orders" data-bs-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="appHeader bg-primary text-light">
                        <div class="left">
                            <a href="#" class="headerButton" data-bs-dismiss="modal">
                                <ion-icon src="../api/images/svg/chevron-back-outline.svg"></ion-icon>
                            </a>
                        </div>
                        <div class="pageTitle">ປະຫວັດການສັ່ງ</div>
                    </div>

                    <div class="modal-body px-2">
                        <div class="section full" id="shopping_cart" style="margin-bottom:70px !important;">

                        </div>
                        <div class="appBottomMenu1">
                            <div class="row">
                                <div class="col">
                                    <strong class="text-dark" style="font-size: 18px;margin-left:10px;">ລວມເປັນເງິນ</strong>
                                </div>
                                <div class="col">
                                    <strong class="text-dark" style="float: right !important;font-size:20px;margin-right:10px !important;">
                                        <span id="sum_total">0.0</span>
                                        <spsn style="font-size:14px">ກີບ</span>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="appBottomMenu rounded modal_history">
            <a href="#" class="item">
                <div class="col">
                    <ion-icon src="../api/images/svg/reload-outline.svg" class="buttonColor"></ion-icon>
                    <strong class="buttonColor">ປະຫວັດການສັ່ງ</strong>
                </div>
            </a>
        </div>




        <?php require_once('../component/javscript.php'); ?>

        <script>
            socket.on('emit_get_call_ordersPY', (response) => {
                modalHistory()
            });

            socket.on('emit_get_submit_ordersPY', (response) => {
                if(response.bill_no_fk==<?php echo $bill_code;?>){
                    location.href="";
                }
            });

            $(".confirm_call").on("click", function() {
                var bill_code = $("#bill_code").val();
                var table_code = $("#table_code").val();
                var table_code = $("#table_code").val();
                var user_branch = $("#user_branch").val();
                var table_name = $("#table_name").val();
                var info = {
                    user_branch,
                    bill_code,
                    table_code,
                    table_name
                }
                $.ajax({
                    url: urlApi + "api-pos.php?call_me",
                    method: "POST",
                    data: {
                        bill_code,
                        table_code,
                        user_branch
                    },
                    success: function(data) {
                        socket.emit('emit_call_sfaffPY', info);
                        $("#modal_call_me").modal("hide");
                        if (data == "200") {
                            Swal.fire({
                                text: "ເອີ້ນພະນັກງານສໍາເລັດແລ້ວເດີ",
                                icon: "success",
                                width: '330',
                                buttons: true,
                                confirmButtonText: "ປິດ"
                            });
                        } else {
                            Swal.fire({
                                text: "ພະນັກງານກໍາລັງໄປໂຕະຂອງທ່ານເດີ☺",
                                icon: "success",
                                width: '330',
                                buttons: true,
                                confirmButtonText: "ປິດ"
                            });
                        }

                    }
                })
            })

            $(".modal_history").on("click", function() {
                $("#histroy_orders").modal("show");
                modalHistory();
            })

            function modalHistory() {
                var bill_code = $("#bill_code").val();
                $.ajax({
                    url: urlApi + "api-menu.php?read_history",
                    data: {
                        bill_code
                    },
                    method: "POST",
                    cache: false,
                    dataType: "json",
                    success: function(response) {
                        var data = response[0];
                        var html = ``;
                        var sub_totoal = 0;
                        if (data.length > 0) {
                            for (var count = 0; count < data.length; count++) {
                                rowData = data[count];
                                if (rowData.product_images != "") {
                                    product_images = `${urlImage}/product_home/${rowData.product_images}`;
                                } else {
                                    product_images = `${urlImage}/logo/no_logo.jpg`;
                                }

                                if (rowData.order_list_status == "1") {
                                    if (rowData.order_list_status_order == "2") {
                                        cook_status = `<i class="fas fa-spinner fa-spin"></i> ສົ່ງຄົວແລ້ວ`;
                                        colors = 'text-dark';
                                    } else if (rowData.order_list_status_order == "3") {
                                        cook_status = `<img src="../api/images/logo/chef-cooking.gif" style="width:35px;"> ກໍາລັງຄົວ...`;
                                        colors = 'text-danger';
                                    } else if (rowData.order_list_status_order == "4") {
                                        cook_status = `ພ້ອມເສີບແລ້ວ`;
                                        colors = 'text-success';
                                    } else if (rowData.order_list_status_order == "5") {
                                        cook_status = `<i class="fas fa-check-circle"></i> ສໍາເລັດ`;
                                        colors = 'text-success';
                                    }
                                } else {
                                    if (rowData.order_list_status_order == "2") {
                                        cook_status = `<i class="fas fa-spinner fa-spin"></i> ສົ່ງບານໍ້າແລ້ວ`;
                                        colors = 'text-dark';
                                    } else if (rowData.order_list_status_order == "3") {
                                        cook_status = `<img src="../api/images/logo/chef-cooking.gif" style="width:35px;"> ກໍາເຮັດ...`;
                                        colors = 'text-danger';
                                    } else if (rowData.order_list_status_order == "4") {
                                        cook_status = `ພ້ອມເສີບແລ້ວ`;
                                        colors = 'text-success';
                                    } else if (rowData.order_list_status_order == "5") {
                                        cook_status = `<i class="fas fa-check-circle"></i> ສໍາເລັດ`;
                                        colors = 'text-success';
                                    }
                                }

                                if (rowData.pro_detail_gif == "1") {
                                    cateDelete = rowData.product_cate_fk;
                                } else {
                                    cateDelete = "Promotion_11";
                                }
                                var qtyPro = 1;
                                if (rowData.order_list_status_promotion == "1") {
                                    price_detail = rowData.pro_detail_sprice;
                                    qtyPro = 1;
                                } else {
                                    price_detail = rowData.pro_detail_promotion_price;
                                    qtyPro = rowData.order_list_qty_promotion_gif;
                                }
                                sub_totoal += rowData.order_list_discount_total;
                                var sumQtyAll = 0;
                                sumQtyAll = parseFloat(rowData.order_list_qty_promotion_gif) + parseFloat(rowData.order_list_qty_promotion_all);



                                html += `
                        <div class="card cart-item mb-1">
                            <div class="card-body">
                                <div class="in">
                                    <img src="${product_images}" alt="product" class="imaged">
                                    <div class="text" style="width:100%;">
                                        <h3 class="title">${rowData.fullnameUnite}</h3>
                                        <strong class="price">
                                            [ ${numeral(rowData.order_list_pro_price).format('0,000')} x ${numeral(rowData.order_list_order_qty).format('0,000')} ] 
                                            <span style="float:right !important;font-size:18px">${numeral(rowData.order_list_discount_total).format('0,000')}</span>
                                        </strong>
                                        <p style="font-size:12px;">
                                            ໝາຍເຫດ : ${rowData.order_list_note_remark}
                                            <span style="float:right">ໂດຍ:${rowData.users_name}</span>
                                        </p>
                                        <input type="text" hidden name="order_list_code[]" value="${rowData.order_list_code}">
                                        <input type="text" hidden name="order_list_pro_code_fk[]" value="${rowData.order_list_pro_code_fk}">
                                        <input type="text" hidden name="order_list_pro_price[]" value="${rowData.order_list_pro_price}">
                                        <input type="text" hidden name="order_list_discount_total[]" value="${rowData.order_list_discount_total}">
                                        <input type="text" hidden name="order_status[]" value="${rowData.order_list_status}">
                                        
                                    </div>
                                </div>
                                <div class="cart-item-footer">
                                    <div class="text-secondary"><i class="fas fa-tv"></i> ສະຖານະ : </div>

                                    <div class="${colors}">
                                        ${cook_status}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                            }
                            $(".emit_submit_ordersPY").attr("disabled", false);
                        } else {
                            $(".emit_submit_ordersPY").attr("disabled", true);
                            sub_totoal += 0;
                            html += `
                    <center>
                        <div class="mb-2">
                            <br><br><br><br>
                            <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                            <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                            </svg>
                            </div>
                            <h4>ບໍ່ມີລາຍການ</h4>
                        </div>
                    </center>
                `;
                        }
                        $("#sum_total").text(numeral(sub_totoal).format('0,000'));
                        $("#shopping_cart").html(html);

                    }
                })
            }



            $("#confirm_orders").on("submit", function(e) {
                e.preventDefault();
                Swal.fire({
                    text: "ຢືນຢັນສັ່ງອໍເດີ",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "ຕົກລົງ",
                    cancelButtonText: "ປິດ",
                    width: '330'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var bill_no = $("#bill_code").val();
                        var cook_status_sum = $("#cook_status_sum").val();
                        var bar_status_sum = $("#bar_status_sum").val();
                        var cooks = {
                            bill_no,
                            cook_status_sum
                        }
                        var bars = {
                            bill_no,
                            bar_status_sum
                        }
                        $.ajax({
                            url: urlApi + "api-pos.php?confirmData",
                            method: "POST",
                            data: new FormData(this),
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                $("#modal_cart").modal("hide");
                                fn_menus(0);
                                socket.emit('emit_orders_laoPY', cooks);
                                socket.emit('emit_barPY', bars);
                                Swal.fire({
                                    text: "ສັ່ງອໍເດີສໍາເລັດແລ້ວ",
                                    icon: "success",
                                    width: '330',
                                    buttons: true,
                                    confirmButtonText: "ປິດ"
                                });
                            }
                        })
                    }
                });
            })

            function Count_Orders(bill_code) {
                $.ajax({
                    url: urlApi + "api-pos.php?countQty",
                    method: "POST",
                    data: {
                        bill_code
                    },
                    dataType: "json",
                    success: function(data) {
                        $(".count_notification").text(data);
                        if (data > 0) {
                            $(".draggable").addClass("changeBg");
                        } else {
                            $(".draggable").removeClass("changeBg");
                        }
                    }
                });
            }


            function shoppingDetail() {
                var bill_code = $("#bill_code").val();
                $.ajax({
                    url: urlApi + "api-menu.php?read_detail",
                    data: {
                        bill_code
                    },
                    method: "POST",
                    cache: false,
                    dataType: "json",
                    success: function(response) {
                        $("#modal_cart").modal("show");
                        var data = response[0];
                        var html = ``;
                        var sub_totoal = 0;
                        var cook_status_sum = 0;
                        var bar_status_sum = 0;
                        if (data.length > 0) {
                            for (var count = 0; count < data.length; count++) {
                                rowData = data[count];

                                if (rowData.order_list_status == "1") {
                                    cook_status_sum += 1;
                                }

                                if (rowData.order_list_status == "2" || rowData.order_list_status == "3") {
                                    bar_status_sum += 1;
                                }

                                // if (rowData.order_list_status == "3") {
                                //     bar_status_no_stock += 1;
                                // }

                                if (rowData.product_images != "") {
                                    product_images = `${urlImage}/product_home/${rowData.product_images}`;
                                } else {
                                    product_images = `${urlImage}/logo/no_logo.jpg`;
                                }

                                if (rowData.pro_detail_gif == "1") {
                                    cateDelete = rowData.product_cate_fk;
                                } else {
                                    cateDelete = "Promotion_11";
                                }
                                var qtyPro = 1;
                                if (rowData.order_list_status_promotion == "1") {
                                    price_detail = rowData.pro_detail_sprice;
                                    qtyPro = 1;
                                } else {
                                    price_detail = rowData.pro_detail_promotion_price;
                                    qtyPro = rowData.order_list_qty_promotion_gif;
                                }
                                sub_totoal += rowData.order_list_discount_total;
                                var sumQtyAll = 0;
                                sumQtyAll = parseFloat(rowData.order_list_qty_promotion_gif) + parseFloat(rowData.order_list_qty_promotion_all);


                                html += `
                        <div class="card cart-item mb-1">
                            <div class="card-body">
                                <div class="in">
                                    <img src="${product_images}" alt="product" class="imaged">
                                    <div class="text" style="width:100%;">
                                        <h3 class="title">${rowData.fullnameUnite}</h3>
                                        <strong class="price">
                                            [ ${numeral(rowData.order_list_pro_price).format('0,000')} x ${numeral(rowData.order_list_order_qty).format('0,000')} ] 
                                            <span style="float:right !important;font-size:18px">${numeral(rowData.order_list_discount_total).format('0,000')}</span>
                                        </strong>
                                        <p style="font-size:12px;">
                                            ໝາຍເຫດ : ${rowData.order_list_note_remark}
                                            <span style="float:right">ໂດຍ:${rowData.users_name}</span>
                                        </p>
                                        <input type="text" hidden name="order_list_code[]" value="${rowData.order_list_code}">
                                        <input type="text" hidden name="order_list_pro_code_fk[]" value="${rowData.order_list_pro_code_fk}">
                                        <input type="text" hidden name="order_list_pro_price[]" value="${rowData.order_list_pro_price}">
                                        <input type="text" hidden name="order_list_discount_total[]" value="${rowData.order_list_discount_total}">
                                        <input type="text" hidden name="order_status[]" value="${rowData.order_list_status}">
                                    </div>
                                </div>
                                <div class="cart-item-footer">
                                    <div class="stepper stepper-sm stepper-primary">
                                        <button type="button" class="stepper-button stepper-down" onclick="fn_calcutator_edit('minus','${rowData.order_list_code}','${rowData.product_cut_stock}','${rowData.price_detail}','${rowData.order_list_pro_code_fk}','${rowData.order_list_discount_price}','${rowData.order_list_qty_promotion_gif}','${rowData.order_list_qty_promotion_gif_total}','${rowData.order_list_status_promotion}','${rowData.sumQtyAll}','${qtyPro}')">-</button>
                                        <input type="text" class="form-control" value="${rowData.order_list_order_qty}" name="order_list_pro_qty[]" readonly maxlength="4" pattern="\d*" id="order_list_pro_qty${rowData.order_list_code}" onkeyup="fn_calcutator_edit('value_1','${rowData.order_list_code}','${rowData.product_cut_stock}','${rowData.price_detail}','${rowData.order_list_pro_code_fk}','${rowData.order_list_discount_price}','${rowData.order_list_qty_promotion_gif}','${rowData.order_list_qty_promotion_gif_total}','${rowData.order_list_status_promotion}','${rowData.sumQtyAll}','${qtyPro}')" onchange="fn_calcutator_edit('value_1','${rowData.order_list_code}','${rowData.product_cut_stock}','${rowData.price_detail}','${rowData.order_list_pro_code_fk}','${rowData.order_list_discount_price}','${rowData.order_list_qty_promotion_gif}','${rowData.order_list_qty_promotion_gif_total}','${rowData.order_list_status_promotion}','${rowData.sumQtyAll}','${qtyPro}')" />
                                        <button type="button" class="stepper-button stepper-up" onclick="fn_calcutator_edit('plus','${rowData.order_list_code}','${rowData.product_cut_stock}','${rowData.price_detail}','${rowData.order_list_pro_code_fk}','${rowData.order_list_discount_price}','${rowData.order_list_qty_promotion_gif}','${rowData.order_list_qty_promotion_gif_total}','${rowData.order_list_status_promotion}','${rowData.sumQtyAll}','${qtyPro}')">+</button>
                                    </div>

                                    <button type="button" class="btn btn-danger btn-sm" onClick="fnDeleteOrder('${rowData.order_list_table_fk}','${rowData.order_list_bill_fk}','${rowData.order_list_code}','${rowData.order_list_pro_code_fk}','${rowData.order_list_order_qty}','${rowData.product_cut_stock}','${rowData.cateDelete}','${rowData.order_list_qty_promotion_gif_total}')">
                                        <ion-icon src="../api/images/svg/trash-outline.svg"></ion-icon>
                                        ລິບ
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                            }
                            html += `
                    <input type="text" hidden id="cook_status_sum"  value="${cook_status_sum}" value="0">
                    <input type="text" hidden id="bar_status_sum"  value="${bar_status_sum}" value="0">
                `;
                            $(".emit_submit_ordersPY").attr("disabled", false);

                        } else {
                            $(".emit_submit_ordersPY").attr("disabled", true);
                            sub_totoal += 0;
                            html += `
                    <center>
                        <div class="mb-2">
                            <br><br><br><br>
                            <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                            <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                            </svg>
                            </div>
                            <h4>ບໍ່ມີລາຍການ</h4>
                        </div>
                    </center>
                `;
                        }
                        $("#cart_total").text(numeral(sub_totoal).format('0,000'));
                        $("#cart_detail").html(html);

                    }
                })
            }

            function fn_calcutator_edit(plus_, order_id, stock_status, price, proID, discount_price, qty_promotion_gif, gif_total, status_promotion, sumQtyAll, plusQty) {
                $.ajax({
                    url: urlApi + "api-pos.php?chang_qty",
                    method: "POST",
                    data: {
                        plus_,
                        order_id,
                        stock_status,
                        price,
                        proID,
                        discount_price,
                        qty_promotion_gif,
                        gif_total,
                        status_promotion,
                        sumQtyAll,
                        plusQty
                    },
                    success: function(data) {
                        shoppingDetail()
                    }
                });

            }

            function fnDeleteOrder(idTb, idBill, idOrder, idProduct, idQty, idStock, idCate, gifAmount, qty_orders) {
                var totalQty = parseFloat(idQty) + parseFloat(gifAmount);
                $.ajax({
                    url: urlApi + "api-pos.php?deleteOrder",
                    method: "POST",
                    data: {
                        idTb,
                        idBill,
                        idOrder,
                        idProduct,
                        idQty,
                        idStock,
                        gifAmount,
                        totalQty,
                        qty_orders
                    },
                    success: function(data) {
                        if (data == 200) {
                            shoppingDetail();
                            fn_menus(0);
                        } else {
                            Error_data();
                        }
                    }
                });
            }

            fn_menus(0);

            function fn_menus(active_item) {
                var user_branch = $("#user_branch").val();
                var table_code = $("#table_code").val();
                $.ajax({
                    url: urlApi + "api-category.php?read_cate",
                    data: {
                        active_item
                    },
                    method: "POST",
                    cache: false,
                    dataType: "json",
                    success: function(response) {
                        product_list(active_item, user_branch, table_code);
                        var data = response[0];
                        var html = ``;
                        html += `
                <li data-page="one" class="nav-active" id="actives" onClick="fn_menus(0)">
                    <span>ທັງໝົດ</span>
                </li>
            `;
                        for (var count = 0; count < data.length; count++) {
                            rowData = data[count];
                            if (active_item == rowData.cate_code) {
                                nav_active = "nav-active";
                            } else {
                                nav_active = "";
                            }
                            html += `
                    <li data-page="two" class="${nav_active}" onClick="fn_menus(${rowData.cate_code})">
                        <span>${rowData.cate_name}</span>
                    </li>
                `;
                        }
                        $("#showMenu").html(html);
                        if (active_item == "0") {
                            $("#actives").addClass("nav-active");
                        } else {
                            $("#actives").removeClass("nav-active");
                        }
                    }
                })
            }


            function product_list(cate_id, user_branch, table_code) {
                $.ajax({
                    url: urlApi + "api-menu.php?menu_list",
                    data: {
                        cate_id,
                        user_branch,
                        table_code
                    },
                    method: "POST",
                    cache: false,
                    dataType: "json",
                    success: function(response) {
                        var html = ``;
                        if (response != "201") {
                            var data = response[0];
                            var data1 = response[1];
                            var data2 = response[2];
                            $("#bill_code").val(data2.bill_code);
                            for (var count = 0; count < data.length; count++) {
                                rowData = data[count];
                                html += `
                        <h3>${rowData.cate_name}</h3>
                        <div class="session_grid1 mb-1">
                    `;
                                for (var count1 = 0; count1 < data1.length; count1++) {
                                    rowData1 = data1[count1];
                                    if (rowData1.product_cate_fk === rowData.cate_code) {
                                        if (rowData1.product_images != "") {
                                            product_images = `${urlImage}/product_home/${rowData1.product_images}`;
                                        } else {
                                            product_images = `${urlImage}/logo/no_logo.jpg`;
                                        }


                                        if (rowData1.product_cut_stock == "1") {
                                            if (rowData1.pro_detail_open == "1") {
                                                checkAvilable = `data-bs-toggle="modal" data-bs-target="#empty" `;
                                                badge_text = "ໝົດແລ້ວ";
                                                badge_bg = "bg-danger";
                                                btn_box = 'btn-danger';
                                                cardAvilable = "cardAvilable";
                                            } else {
                                                checkAvilable = `onClick="fn_menu_detail(${rowData1.pro_detail_code})"`;
                                                badge_text = "ບໍ່ຈໍາກັດ";
                                                badge_bg = "bg-success";
                                                btn_box = 'btn-primary';
                                                cardAvilable = "";
                                            }
                                        } else {
                                            if (rowData1.pro_detail_open == "1") {
                                                checkAvilable = `data-bs-toggle="modal" data-bs-target="#empty" `;
                                                badge_text = "ໝົດແລ້ວ";
                                                badge_bg = "bg-danger";
                                                btn_box = 'btn-danger';
                                                cardAvilable = "cardAvilable";
                                            } else {
                                                if (rowData1.pro_detail_qty > 0) {
                                                    checkAvilable = `onClick="fn_menu_detail(${rowData1.pro_detail_code})"`;
                                                    badge_text = rowData1.pro_detail_qty;
                                                    badge_bg = "bg-success";
                                                    btn_box = 'btn-primary';
                                                    cardAvilable = "";
                                                } else {
                                                    checkAvilable = `data-bs-toggle="modal" data-bs-target="#empty" `;
                                                    badge_text = "ໝົດແລ້ວ";
                                                    badge_bg = "bg-danger";
                                                    btn_box = 'btn-danger';
                                                    cardAvilable = "cardAvilable";
                                                }
                                            }
                                        }

                                        html += `
                                <div class="session_grid_item1 ${cardAvilable} px-0" ${checkAvilable}>
                                    <div class="img-hover1">
                                        <span class="badge ${badge_bg}" style="position: absolute !important;margin-left:34px;margin-top:15px;width:50px;">
                                            ${badge_text}
                                        </span>
                                        <div class="session_grid_img1 img-hover1">
                                            <img src="${product_images}" alt="image" class="imaged w-100" style="height:140px;">
                                        </div>
                                        
                                        <div class="session_gird_text1">
                                        ${rowData1.fullnameSize}
                                        </div>
                                        <div class="session_gird_footer1">
                                            ${numeral(rowData1.pro_detail_sprice).format('0,000')}₭ 
                                            <button type="button" class="btn btn-sm ${btn_box}" style="float:right">
                                                <ion-icon src="../api/images/svg/cart-outline.svg"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                                    }
                                }
                                html += `</div>`;
                            }
                        } else {
                            html += `
                    <center>
                        <div class="mb-2">
                            <br><br><br><br>
                            <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                            <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                            </svg>
                            </div>
                            <h4>ບໍ່ພົບລາຍການທີ່ທ່ານຄົ້ນຫາ</h4>
                        </div>
                    </center>
                `;
                        }
                        $("#showData").html(html);
                        Count_Orders(data2.bill_code)
                    }
                })
            }

            function searchData() {
                var search_box = $("#search_box").val();
                var user_branch = $("#user_branch").val();
                if (search_box == "") {
                    fn_menus(0);
                    return;
                } else {
                    $.ajax({
                        url: urlApi + "api-menu.php?menu_search",
                        data: {
                            search_box,
                            user_branch
                        },
                        method: "POST",
                        cache: false,
                        dataType: "json",
                        success: function(response) {
                            var html = ``;
                            if (response != "201") {
                                var data1 = response[0];
                                html += `<div class="session_grid1 mb-1">`;
                                for (var count1 = 0; count1 < data1.length; count1++) {
                                    rowData1 = data1[count1];
                                    if (rowData1.product_images != "") {
                                        product_images = `${urlImage}/product_home/${rowData1.product_images}`;
                                    } else {
                                        product_images = `${urlImage}/logo/no_logo.jpg`;
                                    }

                                    if (rowData1.product_cut_stock == "1") {
                                        if (rowData1.pro_detail_open == "1") {
                                            checkAvilable = `data-bs-toggle="modal" data-bs-target="#empty" `;
                                            badge_text = "ໝົດແລ້ວ";
                                            badge_bg = "bg-danger";
                                            btn_box = 'btn-danger';
                                            cardAvilable = "cardAvilable";
                                        } else {
                                            checkAvilable = `onClick="fn_menu_detail(${rowData1.pro_detail_code})"`;
                                            badge_text = "ບໍ່ຈໍາກັດ";
                                            badge_bg = "bg-success";
                                            btn_box = 'btn-primary';
                                            cardAvilable = "";
                                        }
                                    } else {
                                        if (rowData1.pro_detail_open == "1") {
                                            checkAvilable = `data-bs-toggle="modal" data-bs-target="#empty" `;
                                            badge_text = "ໝົດແລ້ວ";
                                            badge_bg = "bg-danger";
                                            btn_box = 'btn-danger';
                                            cardAvilable = "cardAvilable";
                                        } else {
                                            if (rowData1.pro_detail_qty > 0) {
                                                checkAvilable = `onClick="fn_menu_detail(${rowData1.pro_detail_code})"`;
                                                badge_text = rowData1.pro_detail_qty;
                                                badge_bg = "bg-success";
                                                btn_box = 'btn-primary';
                                                cardAvilable = "";
                                            } else {
                                                checkAvilable = `data-bs-toggle="modal" data-bs-target="#empty" `;
                                                badge_text = "ໝົດແລ້ວ";
                                                badge_bg = "bg-danger";
                                                btn_box = 'btn-danger';
                                                cardAvilable = "cardAvilable";
                                            }
                                        }
                                    }

                                    html += `
                                <div class="session_grid_item1 ${cardAvilable} px-0" ${checkAvilable}>
                                    <div class="img-hover1">
                                        <span class="badge ${badge_bg}" style="position: absolute !important;margin-left:34px;margin-top:15px;width:50px;">
                                            ${badge_text}
                                        </span>
                                        <div class="session_grid_img1 img-hover1">
                                            <img src="${product_images}" alt="image" class="imaged w-100" style="height:145px;">
                                        </div>
                                        
                                        <div class="session_gird_text1">
                                        ${rowData1.fullnameSize}
                                        </div>
                                        <div class="session_gird_footer1">
                                            ${numeral(rowData1.pro_detail_sprice).format('0,000')}₭ 
                                            <button type="button" class="btn btn-sm ${btn_box}" style="float:right">
                                                <ion-icon src="../api/images/svg/cart-outline.svg"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                                }
                                html += `</div>`;
                            } else {
                                html += `
                        <center>
                            <div class="mb-2">
                                <br><br><br><br>
                                <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                                <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                                </svg>
                                </div>
                                <h4>ບໍ່ພົບລາຍການທີ່ທ່ານຄົ້ນຫາ</h4>
                            </div>
                        </center>`;
                            }
                            $("#showData").html(html);
                        }
                    })
                }
            }

            function fn_menu_detail(proID) {
                $.ajax({
                    url: urlApi + "api-menu.php?menu_detail",
                    data: {
                        proID
                    },
                    method: "POST",
                    cache: false,
                    dataType: "json",
                    success: function(response) {
                        $("#modal_orders").modal("show");
                        var data = response[0];
                        var html = ``;
                        for (var count = 0; count < data.length; count++) {
                            rowData = data[count];
                            if (rowData.product_images != "") {
                                product_images = `${urlImage}/product_home/${rowData.product_images}`;
                            } else {
                                product_images = `${urlImage}/logo/no_logo.jpg`;
                            }
                            html += `
                    <img src="${product_images}" alt="alt" class="imaged w-100 square" style="margin-top:-20px;height:300px;image-rendering: -webkit-optimize-contrast;">
                    <div class="section px-2">
                        <div class="pt-2 pb-2 product-detail-header">
                            <h1 class="title">${rowData.fullnameSize}</h1>
                            <div class="detail-footer">
                                <div class="price">
                                    <!-- <div class="old-price">0</div> -->
                                    <div class="current-price">${numeral(rowData.pro_detail_sprice).format('0,000')} ₭</div>
                                </div>
                                <div class="amount">
                                    <div class="stepper stepper-primary">
                                        <button type="button" class="stepper-button stepper-down" onclick="fn_calcutator('minus','${rowData.pro_detail_code}')">-</button>
                                        <input type="number" class="form-control" value="1" maxlength="4" id="order_list_pro_qty${rowData.pro_detail_code}" onkeyup="fn_calcutator('value_1','${rowData.pro_detail_code}')" onchange="fn_calcutator('value_1','${rowData.pro_detail_code}')" />
                                        <button type="button" class="stepper-button stepper-up" onclick="fn_calcutator('plus','${rowData.pro_detail_code}')">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-footer">
                                <div class="form-group boxed">
                                    <div class="input-wrapper">
                                        <label class="form-label" for="address5">ໝາຍເຫດ</label>
                                        <textarea rows="3" class="form-control border-primary" id="order_list_note_remark" placeholder="ເຜັດ,ບໍ່ເຜັດ,ຫວານ,ນົວ....."></textarea>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-lg btn-block fixed-bottom square addData" id="${rowData.pro_detail_code}">
                                <ion-icon src=".../api/images/svg/cart-outline.svg"></ion-icon>
                                ເພີ່ມເຂົ້າກະຕ໋າ
                            </button>
                        </div>
                    </div>

                    <input type="text" hidden class="txtDetailCode" id="txtDetailCode${rowData.pro_detail_code}" name="txtDetailCode" value="${rowData.pro_detail_code}">
                    <input type="text" hidden class="txtCutStock" id="txtCutStock${rowData.pro_detail_code}" name="txtCutStock" value="${rowData.product_cut_stock}">
                    <input type="text" hidden class="txtUnite" id="txtUnite${rowData.pro_detail_code}" name="txtUnite" value="${rowData.unite_name}">
                    <input type="text" hidden class="txtQty" id="txtQty${rowData.pro_detail_code}" name="txtQty" value="${rowData.pro_detail_qty}">
                    <input type="text" hidden class="txtPrice" id="txtPrice${rowData.pro_detail_code}" name="txtPrice" value="${rowData.pro_detail_sprice}">
                    <input type="text" hidden class="txtCate" id="txtCate${rowData.pro_detail_code}" name="txtCate" value="${rowData.product_cate_fk}">
                    <input type="text" hidden class="txtStatusPro" id="txtStatusPro${rowData.pro_detail_code}" name="txtStatusPro" value="1">
                    <input type="text" hidden class="txtProJing1" id="txtProJing1${rowData.pro_detail_code}" name="txtProJing" value="0">
                    <input type="text" hidden class="txtProGif1" id="txtProGif1${rowData.pro_detail_code}" name="txtProGif" value="0">
                    <input type="text" hidden class="txtGifDefault1" id="txtGifDefault1${rowData.pro_detail_code}" name="txtGifDefault" value="0">
                    <input type="text" hidden class="start_qty1" id="start_qty1${rowData.pro_detail_code}" name="start_qty" value="1">
                    <input type="text" hidden class="stock_qty1" id="stock_qty1${rowData.pro_detail_code}" name="stock_qty2" value="0">

                `;
                        }
                        $(".showDetail").html(html);
                    }
                });
            }

            $(document).on("click", ".addData", function() {
                var pro_detail_code = $(this).attr("Id");
                var bill_no = $("#bill_code").val();
                var table_no = $("#table_code").val();
                var txtDetailCode = $("#txtDetailCode" + pro_detail_code).val();
                var txtCutStock = $("#txtCutStock" + pro_detail_code).val();
                var txtUnite = $("#txtUnite" + pro_detail_code).val();
                var txtQty = $("#txtQty" + pro_detail_code).val();
                var txtPrice = $("#txtPrice" + pro_detail_code).val();
                var txtCate = $("#txtCate" + pro_detail_code).val();
                var txtStatusPro = $("#txtStatusPro" + pro_detail_code).val();
                var txtProJing = $("#txtProJing1" + pro_detail_code).val();
                var txtProGif = $("#txtProGif1" + pro_detail_code).val();
                var txtGifDefault = $("#txtGifDefault1" + pro_detail_code).val();
                var start_qty = $("#start_qty1" + pro_detail_code).val();
                var user_branch = $("#user_branch").val();
                var product_notify1 = "2";
                var order_list_pro_qty = $("#order_list_pro_qty" + pro_detail_code).val();
                var order_list_note_remark = $("#order_list_note_remark").val();
                var order_list_status_order_s = "0";
                var users_id = $("#users_id").val();
                var userOrder = "2";
                $.ajax({
                    url: urlApi + "api-pos.php?addProduct",
                    data: {
                        bill_no,
                        table_no,
                        txtDetailCode,
                        txtCutStock,
                        txtUnite,
                        txtQty,
                        txtPrice,
                        txtCate,
                        txtStatusPro,
                        txtProJing,
                        txtProGif,
                        txtGifDefault,
                        start_qty,
                        order_list_pro_qty,
                        order_list_note_remark,
                        order_list_status_order_s,
                        product_notify1,
                        user_branch,
                        users_id,
                        userOrder
                    },
                    method: "POST",
                    cache: false,
                    dataType: "json",
                    success: function(data) {
                        Count_Orders(bill_no)
                        if (data == 200) {
                            $("#modal_orders").modal("hide");
                            toastbox('toast-12', 2000);
                        } else if (data == 300) {
                            $("#modal_orders").modal("hide");
                            toastbox('toast-121', 2000);
                        } else {
                            $("#modal_orders").modal("hide");
                            // loadContent(1)
                        }

                    }
                })
            })


            function fn_calcutator(plus, proID) {
                var order_list_pro_qty = $("#order_list_pro_qty" + proID).val();
                var numberOne = "1";

                if (plus == "plus") {
                    var qty_plus = (parseInt(order_list_pro_qty) + parseInt(numberOne));
                    $("#order_list_pro_qty" + proID).val(parseInt(qty_plus));
                } else if (plus == "minus") {
                    var qty_plus = (parseInt(order_list_pro_qty) - parseInt(numberOne));
                    if (qty_plus == "0") {
                        return;
                    } else {
                        $("#order_list_pro_qty" + proID).val(parseInt(qty_plus));
                    }
                } else {
                    if (order_list_pro_qty <= "0") {
                        $("#order_list_pro_qty" + proID).val(numberOne);
                        return;
                    } else {
                        $("#order_list_pro_qty" + proID).val(parseFloat(order_list_pro_qty));
                    }
                }

            }





            var draggable = document.getElementById('draggable');
            var isDragging = false;
            var initialX, initialY;
            var offsetX = 0;
            var offsetY = 0;

            // Browser Drag Events
            draggable.addEventListener('dragstart', function(event) {
                event.dataTransfer.setData('text/plain', null);
                initialX = event.clientX - offsetX;
                initialY = event.clientY - offsetY;
                isDragging = true;
            });

            draggable.addEventListener('drag', function(event) {
                if (isDragging) {
                    var x = event.clientX - initialX;
                    var y = event.clientY - initialY;
                    draggable.style.transform = `translate(${x}px, ${y}px)`;
                }
            });

            draggable.addEventListener('dragend', function() {
                isDragging = false;
                offsetX = event.clientX - initialX;
                offsetY = event.clientY - initialY;
            });

            // Mobile Touch Events
            draggable.addEventListener('touchstart', function(event) {
                initialX = event.touches[0].clientX - offsetX;
                initialY = event.touches[0].clientY - offsetY;
            });

            draggable.addEventListener('touchmove', function(event) {
                var x = event.touches[0].clientX - initialX;
                var y = event.touches[0].clientY - initialY;
                draggable.style.transform = `translate(${x}px, ${y}px)`;
                event.preventDefault();
            });

            draggable.addEventListener('touchend', function() {
                offsetX = event.changedTouches[0].clientX - initialX;
                offsetY = event.changedTouches[0].clientY - initialY;
            });



            var qrcode = new QRCode(document.getElementById("qrcode"), {
                width: 200,
                height: 200
            });

            function makeCode() {
                var elText = document.getElementById("urlCode");

                if (!elText.value) {
                    alert("Input a text");
                    elText.focus();
                    return;
                }

                qrcode.makeCode(elText.value);
            }

            makeCode();

            $("#urlCode").
            on("blur", function() {
                makeCode();
            }).
            on("keydown", function(e) {
                if (e.keyCode == 13) {
                    makeCode();
                }
            });


        </script>

    </body>

    </html>
<?php } else { ?>
    <!doctype html>
    <html lang="en">

    <head>
        <title>Scucess</title>
        <?php require_once("../component/stylesheet.php") ?>
    </head>

    <body>
        <div class="appHeader bg-primary text-light">
            <div class="pageTitle">ພີແອວຊີ</div>
            <div class="right">
                <a href="tel:+2099461542" class="headerButton">
                    <ion-icon name="call-outline" class="text-light"></ion-icon>
                </a>
            </div>
        </div>
        <div id="appCapsule">

            <div class="section full">
                <center>
                    <div>
                        <img src="../api/images/logo/002.png" alt="alt" class="imaged square w200">
                        <br>
                        <h3 style="margin-top:-20px;">ພີແອວຊີ ລາວ ດີເວວລົບເມັ້ນ</h3>
                    </div>
                </center>

                <div class="section full mt-4">
                    <div class="section-title">ສົນໃຈໂປຣແກຣມຮ້ານອາຫານສາມາດຕິດຕໍ່ໄດ້ທີ່ນີ້ *</div>
                </div>
                <ul class="listview image-listview">
                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="home-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>ບໍລິສັດ ພີແອວຊີ ລາວ ດີເວວລົບເມັ້ນ ຈໍາກັດ</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="tel:2099461542" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="call-outline"></ion-icon>
                            </div>
                            <div class="in">
                                +85620 9946 1542
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="bookmarks-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>ບ.ທາດຫຼວງກາງ ນະຄອນຫຼວງວຽງຈັນ</div>
                            </div>
                        </a>
                    </li>
                </ul>

            </div>
            
        </div>
    </body>
    <?php require_once('../component/javscript.php'); ?>
<?php } ?>