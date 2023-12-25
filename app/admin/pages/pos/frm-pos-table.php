<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
$db = new DBConnection();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Table List</title>
    <?php $packget_all->main_css(); ?>
    <?php include("style_table.php"); ?>
    <style>
        .mydiv {
            animation: myanimation 3s infinite;
        }

        @keyframes myanimation {
            0% {background-color: #AD5457;}
            5%{background-color:#AD5457;}
        }
    </style>
</head>

<body class="pace-done bg-light">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-content-full-height app-without-header app-without-sidebar bg-white">
        <div id="content" class="app-content p-0">
            <div class="pos pos-counter" id="pos-counter">
                <div class="pos-counter-header" style="background-color:#DB4900 !important;color:white !important;">
                    <div class="logo">
                        <div>
                            
                            <?php
                        if (@$_SESSION["user_permission_fk"] === "202300000003") {
                        ?>
                            <div class="nav-item" style="font-size: 16px;">
                                <a href="?login" class="nav-link text-white">
                                    <i class="fas fa-angle-left"></i> ກັບຄືນ
                                </a>
                            </div>
                        <?php
                        } else if (@$_SESSION["user_permission_fk"] === "202300000004") {
                        ?>
                            <div class="nav-item" style="font-size: 16px;">
                                <a href="?login" class="nav-link text-white">
                                    <i class="fas fa-angle-left"></i> ກັບຄືນ
                                </a>
                            </div>
                        <?php } else if (@$_SESSION["user_permission_fk"] === "202300000005") { ?>
                            <div class="nav-item" style="font-size: 16px;">
                                <a href="?login" class="nav-link text-white">
                                    <i class="fas fa-angle-left"></i> ກັບຄືນ
                                </a>
                            </div>
                        <?php } else { ?>
                            <div class="nav-item" style="font-size: 16px;">
                                <a href="?main" class="nav-link text-white">
                                    <i class="fas fa-angle-left"></i> ກັບຄືນ
                                </a>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="time" id="server_time" style="font-size:20px;font-weight:bold !important;"><?php echo date("H:i:s"); ?></div>
                    <div class="nav">
                    <div class="text-light" style="font-size: 20px;">ລາຍການໂຕະທັງໝົດ</div>
                    </div>
                </div>

                <div id="top-menu" class="app-top-menu" style="background-color:#0F253B !important;color:white !important;">
                    <div class="menu">
                        <div class="menu-item active_item active" id="3" onclick="fn_active_item('3')">
                            <div class="menu-link">
                                <div class="menu-icon">
                                    <ion-icon name="checkmark-circle-outline" class="bg-blue"></ion-icon>
                                </div>
                                <div class="menu-text">ທັງໝົດ</div>
                            </div>
                        </div>

                        <div class="menu-item active_item" id="1" onclick="fn_active_item('1')">
                            <div class="menu-link">
                                <div class="menu-icon">
                                    <ion-icon name="checkmark-circle-outline" class="bg-blue"></ion-icon>
                                </div>
                                <div class="menu-text">ໂຕະວ່າງ</div>
                            </div>
                        </div>
                        <div class="menu-item active_item" id="2" onclick="fn_active_item('2')">
                            <div class="menu-link">
                                <div class="menu-icon">
                                    <ion-icon name="checkmark-circle-outline" class="bg-blue"></ion-icon>
                                </div>
                                <div class="menu-text">ໂຕະບໍ່ວ່າງ</div>
                            </div>
                        </div>

                        <?php
                        $sql_zone = $db->fn_read_all("res_zone WHERE zone_branch_fk='".$_SESSION["user_branch"]."' ");
                        foreach ($sql_zone as $row_zone) {
                        ?>
                            <div class="menu-item active_item" id="<?php echo $row_zone['zone_code'] ?>" onclick="fn_active_item('<?php echo $row_zone['zone_code'] ?>')">
                                <div class="menu-link">
                                    <div class="menu-icon">
                                        <ion-icon name="checkmark-circle-outline" class="bg-blue"></ion-icon>
                                    </div>
                                    <div class="menu-text"><?php echo $row_zone["zone_name"] ?></div>
                                </div>
                            </div>
                        <?php } ?>



                        <div class="menu-item menu-control menu-control-start">
                            <a href="javascript:;" class="menu-link" data-toggle="app-top-menu-prev"><i class="fa fa-angle-left"></i></a>
                        </div>
                        <div class="menu-item menu-control menu-control-end">
                            <a href="javascript:;" class="menu-link" data-toggle="app-top-menu-next"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>

                <?php
                if (@$_SESSION["user_permission_fk"] === "202300000003") {
                    $marginTop = "margin-top:-12px !important;overflow-y: hidden !important;";
                } else {
                    $marginTop = "margin-top:38px !important;";
                }
                ?>

                <div class="pos-counter-body" style="<?php echo $marginTop; ?>">
                    <div class="pos-counter-content">
                        <div class="pos-counter-content-container" data-scrollbar="true" data-height="100%" data-skip-mobile="true">
                            <div class="table-row mb-2">

                            </div>
                            <br><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="branch_id" hidden value="<?php echo $_SESSION["user_branch"]; ?>">
    <input type="text" id="audio" hidden>
    <?php
    $packget_all->main_script();
    $current_server_time = date("Y") . "/" . date("m") . "/" . date("d") . " " . date("H:i:s");
    ?>
    <script>

        var misicAudio = new Audio();
        misicAudio.src = "assets/audio/i_phone_ding.mp3";

        function payAudio_cook(num) {
            misicAudio.play();
            var audio = document.getElementById("audio");
            audio.innerHTML = "" + num;
        }

        socket.on('emit_get_submit_ordersPY', (response) => {
            payAudio_cook(1);
            fn_active_item("3");
        })

        fn_active_item("3")
        function fn_active_item(active_item) {
            $('.active').not(this).removeClass('active');
            $("#" + active_item).toggleClass('active');
            $.ajax({
                url: "services/sql/service-all.php?load_zone",
                method: "POST",
                data: {
                    active_item
                },
                success: function(data) {
                    $(".table-row").html(data);
                }
            })
        }

        function server_date(now_time) {
            current_time1 = new Date(now_time);
            current_time2 = current_time1.getTime() + 1000;
            current_time = new Date(current_time2);

            server_time.innerHTML = current_time.getHours() + ":" + current_time.getMinutes() + ":" + current_time.getSeconds();

            setTimeout("server_date(current_time.getTime())", 1000);
        }
        setTimeout("server_date('<?= $current_server_time ?>')", 1000);

    </script>
</body>

</html>