<?php
include_once('component/app_packget.php');
$packget = new packget();
?>
<!doctype html>
<html lang="en">

<head>
    <title>frm_table</title>
    <?php $packget->app_css(); ?>
</head>

<body>

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="#" class="headerButton logout">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">ລາຍການໂຕະ</div>
        <div class="right">
            <a href="#" class="headerButton btn_call_help">
                <ion-icon src="api/images/svg/notifications-outline.svg" class="svg_notify"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <div class="extraHeader p-0">
        <ul class="nav nav-tabs lined" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#" role="tab" onclick="fn_active_item('all')">
                    ທັງໝົດ
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#" role="tab" onclick="fn_active_item('emty')">
                    ໂຕະວ່າງ
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#" role="tab" onclick="fn_active_item('full')">
                    ໂຕະບໍ່ວ່າງ
                </a>
            </li>
        </ul>
    </div>

    <div id="appCapsule" class="extra-header-active">
        <div class="tab-content mt-1">
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <div class="section px-1 mt-1">
                    <div class="session_grid" id="showAll">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="draggable" draggable="true" class="draggable">
        <ion-icon src="api/images/svg/cart-outline.svg"></ion-icon>
        <div class="count_notification1" style="margin-top:-2px !important;">
            <div style="margin-top:-6px !important;" class="count_notification">0</div>
        </div>
    </div>

    <div class="modal fade modalbox" id="myCart" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="confirm_orders">
                <div class="modal-content">
                    <div class="appHeader bg-primary text-light">
                        <div class="left">
                            <a href="#" class="headerButton" data-bs-dismiss="modal">
                                <ion-icon src="api/images/svg/chevron-back-outline.svg"></ion-icon>
                            </a>
                        </div>
                        <div class="pageTitle">ລາຍການເສີບຂອງຂ້ອຍ</div>
                    </div>
                    <div class="modal-body px-1">
                        <div class="section mb-5 px-1" id="cart_detail" style="margin-bottom: 4rem !important;">

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade modalbox" id="modal_call_help" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="confirm_orders">
                <div class="modal-content">
                    <div class="appHeader bg-primary text-light">
                        <div class="left">
                            <a href="#" class="headerButton" data-bs-dismiss="modal">
                                <ion-icon src="api/images/svg/chevron-back-outline.svg"></ion-icon>
                            </a>
                        </div>
                        <div class="pageTitle">ລາຍການລູກຄ້າເອີ້ນ</div>
                    </div>
                    <div class="modal-body px-1">
                        <div class="section mb-5 px-1" id="notifi_show" style="margin-bottom: 4rem !important;">
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="notifi_data" class="notification-box">
        <div class="notification-dialog android-style">
            <div class="notification-header">
                <div class="in">
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged w24 rounded">
                    <strong>ເບີໂຕະ <span class="show_tb"></span></strong>
                    <span>just now</span>
                </div>
                <a href="#" class="close-button">
                    <ion-icon name="close"></ion-icon>
                </a>
            </div>
            <div class="notification-content">
                <div class="in">
                    <h3 class="subtitle">ໂຕະເບີ <span class="show_tb"></span></h3>
                    <div class="text">
                        ໂຕະເບີ <span class="show_tb"></span> ຕ້ອງການຄວາມຊ່ວຍເຫຼືອ ?
                    </div>
                </div>
                <div class="icon-box text-success">
                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                </div>
            </div>
        </div>
    </div>

    <div class="audio1"></div>

    <?php $packget->app_script(); ?>
    <script>
        socket.on('emit_get_call_ordersPY', (response) => {
            loadData();
            Count_Orders();
            if (response.status === 3) {
                payAudio_bar(1);
            }
        });

        socket.on('emit_get_call_staffPY', (response) => {
            if(response.user_branch==<?php echo $_SESSION["user_branch"]; ?>){
                $(".show_tb").text(response.table_name);
                notification('notifi_data');
                loadDataNotify();
                Count_notify()
            }
        });


        $(".btn_call_help").click(function() {
            $("#modal_call_help").modal("show");
            loadDataNotify();
        })

        $("#draggable").click(function() {
            $("#myCart").modal("show");
            loadData();
            Count_Orders();
        })
        Count_Orders()

        function Count_Orders() {
            $.ajax({
                url: urlApi + "api-pos.php?countSuccess",
                method: "POST",
                data: {
                    user_branch: <?php echo $_SESSION["user_branch"]; ?>
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
        Count_notify()
        function Count_notify() {
            $.ajax({
                url: urlApi + "api-pos.php?countNotify",
                method: "POST",
                data: {
                    user_branch: <?php echo $_SESSION["user_branch"]; ?>
                },
                dataType: "json",
                success: function(data) {
                    if (data > 0) {
                        $(".btn_call_help").addClass("changeBg1");
                    } else {
                        $(".btn_call_help").removeClass("changeBg1");
                    }
                }
            });
        }

        function loadDataNotify() {
            $.ajax({
                url: urlApi + "api-menu.php?loadNotify",
                data: {
                    user_branch: <?php echo $_SESSION["user_branch"]; ?>
                },
                method: "POST",
                cache: false,
                dataType: "json",
                success: function(response) {
                    var data = response[0];
                    var html = ``;
                    var sub_totoal = 0;
                    if (data.length > 0) {
                        html +=`<div class="listview-title" style="font-size:16px;font-weight:bold;">
                        ເບີໂຕະ <span style="float:right">ຢືນຢັນ</span></div>
                        <ul class="listview image-listview">
                        `;
                        for (var count = 0; count < data.length; count++) {
                            rowData = data[count];
                            html += `
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-primary">
                                            <ion-icon name="laptop-outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>ເບີ ${rowData.table_name}</div>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="fnStatus('${rowData.call_id}')">
                                                <ion-icon src="api/images/svg/checkmark-outline.svg"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            
                            `;
                        }
                        html+=`</ul>`;
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
                                    <h4>ບໍ່ມີລາຍການ</h4>
                                </div>
                            </center>
                        `;
                    }
                    $("#notifi_show").html(html);

                }
            })
        }

        function fnStatus(call_id){
            $.ajax({
                url: urlApi + "api-menu.php?update_status",
                data: {
                    call_id
                },
                method: "POST",
                cache: false,
                dataType: "json",
                success: function(data) {
                    Count_notify()
                    loadDataNotify();

                    Swal.fire({
                        text: "ຢືນຢັນສໍາເລັດແລ້ວ",
                        icon: "success",
                        width: '330',
                        buttons: true,
                        confirmButtonText: "ປິດ"
                    });

                }
            })
        }

        function loadData() {
            $.ajax({
                url: urlApi + "api-menu.php?OrderServ",
                data: {
                    user_branch: <?php echo $_SESSION["user_branch"]; ?>
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
                                            <img src="${product_images}" alt="product" class="imaged" style="height:75px;">
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
                                            </div>
                                        </div>
                                        <div class="cart-item-footer">
                                            <div class="text-dark" style="font-size:18px;">ເບີໂຕະ : ${rowData.table_name}</div>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="function_confirm('${rowData.order_list_code}','${rowData.order_list_status}','${rowData.table_name}')">
                                                <ion-icon name="checkmark-circle-outline"></ion-icon> ຢືນຢັນເສີບ
                                            </button>
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
                    $("#cart_detail").html(html);

                }
            })
        }

        function function_confirm(order_list_code, order_list_status, table_name) {
            Swal.fire({
                text: "ຢືນຢັນເສີບໂຕະເບີ : " + table_name,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ຕົກລົງ",
                cancelButtonText: "ປິດ",
                width: '330'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (order_list_status == "1") {
                        status = "1";
                    } else {
                        status = "2";
                    }
                    var cooks = {
                        status,
                    }
                    $.ajax({
                        url: urlApi + "api-pos.php?update_success",
                        data: {
                            order_list_code
                        },
                        method: "POST",
                        cache: false,
                        dataType: "json",
                        success: function(data) {
                            loadData();
                            Count_Orders();

                            socket.emit('emit_edit_deletePY', cooks);
                        }
                    })
                }
            })
        }

        fn_active_item("all");

        function fn_active_item(active_item) {
            $.ajax({
                url: urlApi + "api-tables.php?load_zone",
                data: {
                    active_item,
                    branchID: '<?php echo $_SESSION["user_branch"]; ?>',
                },
                method: "POST",
                cache: false,
                dataType: "json",
                success: function(response) {
                    var data = response[0];
                    var html = ``;
                    for (var count = 0; count < data.length; count++) {
                        rowData = data[count];
                        if (rowData.table_status == "1") {
                            active_item = '';
                            box_active = '';
                            status = '( ວ່າງ )';
                        } else {
                            active_item = 'active_item';
                            box_active = 'box_active';
                            status = '( ບໍ່ວ່າງ )';
                        }
                        html += `
                            <div class="session_grid_item ${active_item}">
                                <a href="?menus&&table_code=${rowData.table_code}&&table_name=${rowData.table_name_convert}">
                                    <div class="img-hover">
                                        <div class="session_grid_img img-hover">
                                            ເບີໂຕະ
                                        </div>
                                        <div class="session_gird_text">
                                            <p class="box_size ${box_active}">
                                                ${rowData.table_name}
                                            </p>
                                            <p class="box_size_footer">
                                                ${status}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        `;
                    }
                    $("#showAll").html(html);
                }
            })
        }

        $(".logout").click(function() {
            Swal.fire({
                text: "ຕ້ອງການອອກຈາກລະບົບແທ້ ຫຼື ບໍ",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ຕົກລົງ",
                cancelButtonText: "ປິດ",
                width: '330'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "?logout";
                }
            })
        })
    </script>
</body>

</html>