<?php
include_once('component/app_packget.php');
$packget = new packget();

?>
<!doctype html>
<html lang="en">

<head>
    <!-- <title>frm_login</title> -->
    <title>login</title>
    <?php $packget->app_css(); ?>
</head>

<body style="background-color: #1e5dc9;">
    <div id="appCapsule">
        <div class="section">
            <form id="login_form">
                <div class="card px-0">
                    <div class="card-body pb-1 mb-3">
                        <center>
                            <img src="api/images/logo/002.png" alt="" class="imaged w160 mb-3">
                        </center>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label" for="users_name" style="font-size: 14px;">ຊື່ເຂົ້າລະບົບ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control border-primary" id="users_name" name="users_name" placeholder="" value="Staff" autofocus autocomplete="off">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label" for="users_password" style="font-size: 14px;">ລະຫັດຜ່ານ <span class="text-danger">*</span></label>
                                <input type="password" class="form-control border-primary" name="users_password" id="users_password" value="000147" autocomplete="off" placeholder="">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-check form-check-inline mt-1 mb-5">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" onclick="myFunction('users_password')">
                            <label class="form-check-label" for="inlineCheckbox1"></label>
                        </div>
                        <span class="text-dark">ສະແດງລະຫັດຜ່ານ</span>
                    </div>
                </div>

                <div class="form-button-group transparent" style="background-color: #1e5dc9;">
                    <button type="submit" class="btn btn-block btn-lg btn_login">ເຂົ້າສູ່ລະບົບ</button>
                </div>
            </form>
        </div>
    </div>

    <div id="frm_notification" class="notification-box">
        <div class="notification-dialog ios-style bg-danger">
            <div class="notification-header">
                <div class="in">
                    <strong>ແຈ້ງເຕືອນ</strong>
                </div>
                <div class="right">
                    <a href="#" class="close-button">
                        <ion-icon name="close-circle"></ion-icon>
                    </a>
                </div>
            </div>
            <div class="notification-content">
                <div class="in">
                    <h3 class="subtitle text-light">
                        ຊື່ຜູ້ໃຊ້ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- ========= JS Files =========  -->
    <?php $packget->app_script(); ?>
    <script>
        login("login_form","users_name","users_password", "frm_notification");
        // $(function() { 
        //     $(this).bind("contextmenu", function(e) { 
        //         e.preventDefault(); 
        //     }); 
        // }); 
    </script>
</body>

</html>