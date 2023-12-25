<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
$db = new DBConnection();
// $table_id = base64_decode($_GET["table_id"]);
// $sqlCount = $db->fn_fetch_rowcount("res_bill WHERE bill_table='" . $table_id . "' AND bill_status='1' AND bill_branch='" . $_SESSION["user_branch"] . "' ");
// if ($sqlCount == 0) {
//     $auto_number = $db->fnBillNumber("bill_code", "res_bill");
//     $sql = "'" . $auto_number . "','" . $table_id . "','" . $_SESSION["user_branch"] . "','1'";
//     $insertBill = $db->fn_insert("res_bill", $sql);
// }
// $table_name = $db->fn_fetch_single_all("res_tables WHERE table_code='" . $table_id . "' ");
// $billName = $db->fn_fetch_single_all("res_bill WHERE bill_table='" . $table_id . "' AND bill_status='1' ");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>POS</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class='pace-top'>
    <?php $packget_all->main_loadding(); ?>

    <div id="app" class="app app-content-full-height app-without-sidebar app-without-header bg-white">
        <div id="content" class="app-content p-0">
            <div class="pos pos-kitchen" id="pos-kitchen">
                <div class="pos-kitchen-header" style="background-color:#DB4900 !important;color:white !important;">
                    <div class="logo">
                        <div class="logo-text text-light" style="font-size:20px;">ຫ້ອງຄົວຮັບອໍເດີລູກຄ້າ</div>
                    </div>
                    <div class="time" id="server_time" style="font-size:20px;font-weight:bold !important;"><?php echo date("H:i:s"); ?></div>
                    <div class="nav">
                        <?php
                        if (@$_SESSION["user_permission_fk"] === "202300000004") {
                        ?>
                            <div class="nav-item">
                                <a href="?login" class="nav-link text-white">
                                    <ion-icon name="power-outline" style="font-size:25px;font-weight:bold"></ion-icon>
                                </a>
                            </div>
                        <?php } else if (@$_SESSION["user_permission_fk"] === "202300000005") { ?>
                            <div class="nav-item">
                                <a href="?login" class="nav-link text-white">
                                    <ion-icon name="power-outline" style="font-size:25px;font-weight:bold"></ion-icon>
                                </a>
                            </div>
                        <?php } else { ?>
                            <div class="nav-item">
                                <a href="?main" class="nav-link text-white">
                                    <ion-icon name="power-outline" style="font-size:25px;font-weight:bold"></ion-icon>
                                </a>
                            </div>
                        <?php } ?>
                    </div>

                    <div id="top-menu" class="app-top-menu" style="background-color:#0F253B !important;color:white !important;">
                    <div class="menu">
                        <div class="menu-item active_item2 active" style="cursor:pointer" onclick="load_orders('2')">
                            <div class="menu-link">
                                <div class="menu-icon">
                                    <ion-icon name="checkmark-circle-outline" class="bg-blue"></ion-icon>
                                </div>
                                <div class="menu-text">ຮັບອໍເດີ <span class='labelCount2 fa-beat-fade text-success'>0</span></div>
                            </div>
                        </div>

                        <div class="menu-item active_item3" style="cursor:pointer" onclick="load_orders('3')">
                            <div class="menu-link">
                                <div class="menu-icon">
                                    <ion-icon name="checkmark-circle-outline" class="bg-blue"></ion-icon>
                                </div>
                                <div class="menu-text">ກໍາລັງຄົວ <span class='labelCount3 fa-beat-fade text-success'>0</span></div>
                            </div>
                        </div>
                        <div class="menu-item active_item4" style="cursor:pointer" onclick="load_orders('4')">
                            <div class="menu-link">
                                <div class="menu-icon">
                                    <ion-icon name="checkmark-circle-outline" class="bg-blue"></ion-icon>
                                </div>
                                <div class="menu-text">ສໍາເລັດແລ້ວ <span class='labelCount4 fa-beat-fade text-danger'>0</span></div>
                            </div>
                        </div>

                        <div class="menu-item menu-control menu-control-start">
                            <a href="javascript:;" class="menu-link" data-toggle="app-top-menu-prev"><i class="fa fa-angle-left"></i></a>
                        </div>
                        <div class="menu-item menu-control menu-control-end">
                            <a href="javascript:;" class="menu-link" data-toggle="app-top-menu-next"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>

                </div>
                <input type="text" id="branch_id" hidden value="<?php echo $_SESSION["user_branch"]; ?>">

                <div id="showAll"></div>

            </div>
        </div>

        <a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    </div>

    <div id="notification"></div>
    <?php
    $packget_all->main_script();
    $current_server_time = date("Y") . "/" . date("m") . "/" . date("d") . " " . date("H:i:s");
    ?>


    <script>
        // const socket = io.connect('http://localhost:3000')

        socket.on('emit_get_cookingPY', (response) => {
            load_orders(2)
            // if (response.sum_cook === "0") {
            //     load_orders(2)
            // } else {
            //     if (response.status_submit_edit_qty === "1") {
            //         if(response.branch_id===$("#branch_id").val()){
            //             load_orders(2)
            //             loadContent1(1)
            //         }
            //     } else {
            //         load_orders(2)
            //     }
            // }
        })
        load_orders(2)

        function load_orders(idStatus) {
            $('.active').not(this).removeClass('active');
            $(".active_item" + idStatus).toggleClass('active');
            $.ajax({
                url: "services/sql/service-cooks_copy.php?loadOrders",
                method: "POST",
                data: {
                    idStatus
                },
                success: function(data) {
                    $("#showAll").html(data);
                    countData()
                }
            })
        }

        function countData() {
            $.ajax({
                url: "services/sql/service-cooks_copy.php?countLabel",
                method: "POST",
                dataType: "json",
                success: function(data) {
                    $(".labelCount2").text(data.total2);
                    $(".labelCount3").text(data.total3);
                    $(".labelCount4").text(data.total4);
                }
            })
        }

        function fnConfirm(cookID, cookStatus) {
            var branch_id=$("#branch_id").val();
            var info1 = {
                cookID: cookID,
                cookStatus: cookStatus,
                branch_id:branch_id,
            }
            $.ajax({
                url: "services/sql/service-cooks_copy.php?editStatus",
                method: "POST",
                data: {
                    cookID,
                    cookStatus
                },
                success: function(data) {
                    if (cookStatus === "2") {
                        successfuly("ເລີ່ມຄົວ");
                        socket.emit('emit_call_ordersPY', info1);
                    } else if (cookStatus === "3") {
                        successfuly("ເອີ້ນພະນັກງານເສີບ");
                        socket.emit('emit_call_ordersPY', info1)
                    } else {
                        successfuly("ເສີບອາຫານສໍາເລັດແລ້ວ");
                        socket.emit('emit_call_ordersPY', info1)
                    }
                    load_orders(cookStatus)
                    countData()
                }
            })
        }


        setTimeout("server_date('<?= $current_server_time ?>')", 1000);

        function server_date(now_time) {
            current_time1 = new Date(now_time);
            current_time2 = current_time1.getTime() + 1000;
            current_time = new Date(current_time2);

            server_time.innerHTML = current_time.getHours() + ":" + current_time.getMinutes() + ":" + current_time.getSeconds();

            setTimeout("server_date(current_time.getTime())", 1000);
        }
    </script>
</body>

</html>