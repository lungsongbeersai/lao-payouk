<?php
include_once('component/app_packget.php');
$packget = new packget();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Bars</title>
    <?php $packget->app_css(); ?>
</head>

<body>
    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="#" class="headerButton logout">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">ບານໍ້າ</div>
    </div>

    <nav class="nav-horizontal-scroll fixed-top" style="z-index:800 !important;">
        <ul style="margin-top:-53px !important;background:#ffffff">
            <li data-page="one" class="nav-active nav_font" id="actives2" onClick="load_orders(2)">
                ✓ ອໍເດີເຂົ້າໃຫມ່ <span class="badge2_" style="font-size:18px;">0</span>
            </li>
            <li data-page="two" class="nav_font" id="actives3" onClick="load_orders(3)">
                ກໍາລັງເຮັດ <span class="badge3_" style="font-size:18px;">0</span>
            </li>
            <li data-page="three" class="nav_font" id="actives4" onClick="load_orders(4)">
                ເສີບສໍາເລັດ <span class="badge4_" style="font-size:18px;">0</span>
            </li>
            <!-- <li data-page="three" class="nav_font" id="actives5" onClick="load_orders(5)">
                ສໍາເລັດແລ້ວ <span class="badge5_" style="font-size:18px;">0</span>
            </li> -->
        </ul>
    </nav>

    <!-- <div id="showAll"></div> -->

    <!-- App Capsule -->
    <div id="appCapsule" class="extra1-header-active" style="margin-top:20px;">
        <div class="section mt-5 px-1 mb-5" id="showAll">

        </div>
    </div>


    <div class="audio1"></div>


    <?php $packget->app_script(); ?>
    <script>

        socket.on('emit_get_barsPY', (response) => {
            if(response.bar_status_sum > 0){
                load_orders(2);
                payAudio_bar(1);
            }
        });

        socket.on('emit_get_edit_deletePY', (response) => {
            load_orders(2);
        });

        load_orders(2)

        function load_orders(idStatus) {
            $('.nav_font').not(this).removeClass('nav-active');
            $("#actives" + idStatus).toggleClass('nav-active');
            $.ajax({
                url: urlApi + "api-bars.php?loadOrders",
                method: "POST",
                data: {
                    idStatus
                },
                dataType: "json",
                success: function(response) {
                    console.log(response)
                    var data = response[0];
                    var html = '';
                    if (response == "201") {
                        html += `
                            <div class="row">
                                    <div class="col-12">
                                        <center>
                                            <div class="mb-2">
                                                <br><br><br><br><br><br><br><br>
                                                <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                                                <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                                                </svg>
                                                </div>
                                                <h5>ບໍ່ມີລາຍການ</h5>
                                            </div>
                                        </center>
                                    </div>
                            </div>
                        `;
                    } else {
                        html += `<div class="session_grid1 mb-1 px-1">`;
                        var i = 1;
                        for (var count = 0; count < data.length; count++) {
                            rowData = data[count];
                            if (rowData.product_images != "") {
                                product_images = `${urlImage}/product_home/${rowData.product_images}`;
                            } else {
                                product_images = `${urlImage}/logo/no_logo.jpg`;
                            }

                            if (rowData.order_list_status_order == "2") {
                                status_cm = "2";
                                button_name = "<i class='fas fa-spinner fa-spin fa-fw'></i> ເລີ່ມເຮັດ";
                                disabled_bt = ""; 
                            } else if (rowData.order_list_status_order == "3") {
                                status_cm = "3";
                                button_name = "<i class='fa fa-check fa-fw fa-shake'></i> ຢືນຢັນເສີບສໍາເລັດ";
                                disabled_bt = "";
                            } else if (rowData.order_list_status_order == "4") {
                                status_cm = "4";
                                button_name = "<i class='fas fa-spinner fa-spin fa-fw'></i> ລໍຖ້າເສີບເຄື່ອງດຶ່ມ";
                                disabled_bt = "disabled";
                            }else {
                                status_cm = "5";
                                button_name = "<i class='fas fa-check fa-fw'></i> ສໍາເລັດແລ້ວ";
                                disabled_bt = "disabled";
                            }

                            if (i++ == "1") {
                                disabled_limit = "";
                            } else {
                                disabled_limit = "disabled";
                            }

                            var s_date = rowData.order_list_date;
                            var formattedDate = new Date(s_date);
                            var hours = formattedDate.getHours().toString().padStart(2, '0');
                            var minutes = formattedDate.getMinutes().toString().padStart(2, '0');
                            var seconds = formattedDate.getSeconds().toString().padStart(2, '0');

                            var formattedTime = hours + ':' + minutes + ':' + seconds;

                            html += `
                                <div class="session_grid_item1 px-0">
                                    <div class="img-hover1">
                                        <span class="badge bg-secondary" style="position: absolute !important;margin-left:10px;margin-top:15px;">
                                            ເບີໂຕະ ${rowData.table_name}
                                        </span>
                                        <div class="session_grid_img1 img-hover1">
                                            <img src="${product_images}" alt="image" class="imaged w-100" style="height:150px;">
                                        </div>
                                        
                                        <div class="session_gird_text1 px-2" style="text-align:left !important">
                                            ${rowData.product_name}
                                            <span style="float:right"> x<span style="font-size:18px;">${rowData.order_list_order_qty}</span></span>
                                        </div>
                                        <div class="session_gird_footer1 px-2" style="margin-top:-10px;font-size:12px;">
                                            ໝາຍເຫດ : <u style="color:red;font-size:16px;">${rowData.order_list_note_remark}</u>
                                        </div>
                                        <div class="session_gird_footer1" style="margin-top:-15px;">
                                            <button type="button" class="btn btn-primary btn-block" ${disabled_bt} onclick="fnConfirm('${rowData.order_list_code}','${status_cm}')">
                                                ${button_name}
                                            </button>
                                        </div>
                                        <p style="font-size:12px;margin-top:-10px;" class="px-2">
                                            <span style="float:left" class="text-secondary"><i class="fas fa-user"></i>&nbsp;${rowData.users_name} </span>
                                            <span style="float:right" class="text-secondary"><i class="fas fa-clock"></i>&nbsp;${formattedTime}</span>
                                            <br>
                                        </p>
                                    </div>
                                </div>
                            `;
                        }
                        html += `</div>`;
                    }
                    $("#showAll").html(html);
                    countData()
                }
            })
        }

        function countData() {
            $.ajax({
                url: urlApi + "api-bars.php?countLabel",
                method: "POST",
                dataType: "json",
                success: function(data) {
                    $(".badge2_").text(data.total2);
                    $(".badge3_").text(data.total3);
                    $(".badge4_").text(data.total4);
                    // $(".badge5_").text(data.total5);
                }
            })
        }

        function fnConfirm(cookID, cookStatus) {
            var branch_id = $("#branch_id").val();
            var info2 = {
                cookID,cookStatus,branch_id,status:2,
            }
            var info3 = {
                cookID,cookStatus,branch_id,status:3,
            }
            var info4 = {
                cookID,cookStatus,branch_id,status:4,
            }
            $.ajax({
                url: urlApi + "api-bars.php?editStatus",
                method: "POST",
                data: {
                    cookID,
                    cookStatus
                },
                success: function(data) {
                    if (cookStatus === "2") {
                        successfuly("ເລີ່ມຄົວ");
                        socket.emit('emit_call_ordersPY', info2);
                    } else if (cookStatus === "3") {
                        successfuly("ເອີ້ນພະນັກງານເສີບ");
                        socket.emit('emit_call_ordersPY', info3)
                    } else {
                        successfuly("ເສີບອາຫານສໍາເລັດແລ້ວ");
                        socket.emit('emit_call_ordersPY', info4)
                    }
                    load_orders(cookStatus)
                    countData()
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