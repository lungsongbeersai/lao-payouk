<?php @session_start();
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
session_unset();     
session_destroy();
?>
<!DOCTYPE html>
<html lang="en" class="dark-mode">

<head>
    <title>Login App</title>
    <?php $packget_all->main_css(); ?>
    <style>
        .btn {
            font-size: 18px;
            font-family: 'Times New Roman', Times, serif;
            padding: 15px !important;
            border-radius: 0px !important;
            outline: none;
            border-color: white !important;
        }
        .form-control:nth-child(1) {
            height: 150px;
        }
        .form-group {
            margin-bottom: 0px;
        }

        .users_password{
            padding: 60px !important;
            border-radius: 0px !important;
            outline: none;
            border-color: white !important;
            font-size: 50px !important;
        }

        .form-control:focus {
            box-shadow:none !important;
        }

        .login{
            width: 100%;
            box-shadow:none !important;
            border-color: white !important;
            height: 100px;
        }

    </style>
</head>

<body class="pace-done">
    <div id="app" class="app">
        <div class="login login-v2 fw-bold">
            <div class="login-cover">
                <div class="login-cover-img" style="background-image: url(assets/img/login-bg/bg16.jpg);" data-id="login-cover-image"></div>
                <div class="login-cover-bg"></div>
            </div>
            <div class="login-container">
                <form id="frm_login">
                    <center>
                        <span style="font-size:14px !important;">ປ້ອນລະຫັດຜ່ານ </span>
                    </center>
                
                <div class="login-content">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12 px-0">
                            <input class="form-control users_password text-center" autofocus inputmode='none' id="users_password" name="users_password" type="password" autocomplete="off" onkeypress="return isNumber(event)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-dark btn-lg d-block btn1" value="7">7</div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-dark btn-lg d-block btn1" value="8">8</div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-dark btn-lg d-block btn1" value="9">9</div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-dark btn-lg d-block btn1" value="4">4</div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-dark btn-lg d-block btn1" value="5">5</div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-dark btn-lg d-block btn1" value="6">6</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-dark btn-lg d-block btn1" value="1">1</div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-dark btn-lg d-block btn1" value="2">2</div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-dark btn-lg d-block btn1" value="3">3</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-dark btn-lg d-block btn1" value="00">00</div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-dark btn-lg d-block btn1" value="0">0</div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-4 px-0">
                            <div class="btn btn-danger btn-lg d-block" onclick="del()">
                                <i class="fa-solid fa-delete-left"></i>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-12 px-0">
                            <button type="submit" class="btn btn-primary login" onclick="service_login('frm_login','service-login.php')">
                                <i class="fas fa-power-off" style="font-size: 30px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php $packget_all->main_script(); ?>

    <script>
        $(document).on("click", ".btn1", function() {
            var id = $(this).attr("value");
            var users_password = $("#users_password").val() + id;
            $(".users_password").val(users_password);
            $(".users_password").focus();
        });

        function del() {
            var currentValue = users_password.value;
            users_password.value = currentValue.substr(0, users_password.value.length - 1);
            $(".users_password").focus();
        }

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        localStorage.clear();
    </script>
</body>

</html>