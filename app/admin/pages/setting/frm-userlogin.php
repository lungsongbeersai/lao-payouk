<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
function app_sidebar_minified(){
    echo "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Frm UserLogin</title>
    <?php $packget_all->main_css(); ?>
    <style>
        .form-control:focus {
            border-color: inherit;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        td{
            vertical-align: middle;
        }

    </style>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified()?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <ol class="breadcrumb float-xl-end">
                <li class="breadcrumb-item"><a href="javascript:history.back()" class="text-danger"><i class="fas fa-arrow-circle-left"></i> ກັບຄືນ</a></li>
                <li class="breadcrumb-item active">ລາຍການຜູ້ໃຊ້ລະບົບ</li>
            </ol>

            <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                <i class="fas fa-list"></i> ລາຍການຜູ້ໃຊ້ລະບົບ
            </h4>

            <div class="row mb-2">
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-orange" onclick="modal_open('modal_users','ເພີ່ມຜູ້ດູແລລະບົບ','frm_users','btn_save','users_name','branch_store','branch_code','user_permission_fk','')">
                        <i class="fas fa-add"></i> ເພີ່ມຂໍ້ມູນ
                    </button>

                </div>
            </div>

            <div class="panel panel-inverse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="mb-2">ຊື່ຮ້ານ <span class="text-danger">*</span></label>
                                <select name="search_store" id="search_store" class="form-select search_store" required onchange="res_searchBranch('search_store')">
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="mb-2">ສາຂາ <span class="text-danger">*</span></label>
                                <select name="search_branch" id="search_branch" class="form-select search_branch" required>
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <label for="" class="mb-2">ຄົ້ນຫາ</label>
                            <div class="input-group">
                                <input type="text" id="search_page" name="search_page" class="form-control input_color" placeholder="ຄົ້ນຫາ...">
                                <button type="button" class="btn btn-orange search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
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
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">ສະຖານະ</th>
                                    <th style="text-align:center !important;width:80px">ລໍາດັບ</th>
                                    <th>ຊື່ຮ້ານ</th>
                                    <th>ສາຂາ</th>
                                    <th>ຊື່ໃຊ້ງານ</th>
                                    <th style="width: 150px;">ລະຫັດຜ່ານ</th>
                                    <th style="width: 140px;">ສະຖານະ</th>
                                    <th width="10%" style="text-align:center !important;">ຈັດການ</th>
                                </tr>
                            </thead>
                            <tbody class="table-bordered-y table-sm display">

                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_users" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light" id="modal_title">Modal Without Animation</h4>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="frm_users">
                        <div class="modal-body">
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
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-2">ຊື່ຜູ້ໃຊ້ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" id="users_name" name="users_name" placeholder="ຊື່ຜູ້ໃຊ້" required autocomplete="off">
                                        <input type="text" hidden class="form-control" id="users_id" name="users_id">
                                        <input type="text" hidden class="form-control" id="users_checkPassword" name="users_checkPassword">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-2">ລະຫັດຜ່ານ <span class="text-danger">* <span style="font-size:10px">( ຢ່າງນ້ອຍ 6 ຕົວເລກ )</span></span></label>
                                        <input type="text" class="form-control input_color" maxlength="6" minlength="6" id="users_password" name="users_password" onkeypress="return isNumber(event)" placeholder="ລະຫັດຜ່ານ" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ສະຖານະ <span class="text-danger">*</span></label>
                                        <select name="user_permission_fk" id="user_permission_fk" class="form-select user_permission_fk" required>
                                            <option value="">ເລືອກ</option>
                                        </select>
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
        

        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
            res_storeSearch('search_store');
            res_store('branch_store');
            res_status('user_permission_fk');
            loadUserlogin(1)
            function loadUserlogin(page){
                var search_store=$("#search_store").val();
                var search_branch=$("#search_branch").val();
                var search=$("#search_page").val();
                var limit=$("#limit_page").val();
                var orderby=$("#order_page").val();
                $.ajax({
                    url:"services/sql/service-userlogin.php?fetch_data",
                    method:"POST",
                    data:{page,search_store,search_branch,search,limit,orderby},
                    success:function(data){
                        $(".display").html(data);
                    }
                })
            }

            $("#frm_users").on("submit",function(event){
                event.preventDefault();
                $.ajax({
                    url:"services/sql/service-userlogin.php?insert_data",
                    method:"POST",
                    data:new FormData(this),
                    contentType:false,
                    processData:false,
                    success:function(data){
                        loadUserlogin(1);
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode == 200) {
                            $("#modal_users").modal("hide");
                            successfuly("ບັນທຶກສໍາເລັດ");
                        }else if (dataResult.statusCode == 202){
                            $("#modal_users").modal("hide");
                            successfuly("ແກ້ໄຂສໍາເລັດແລ້ວ");
                        }else if (dataResult.statusCode == 205){
                            ErrorFuntion("ຂໍອະໄພ ! ລະຫັດຜ່ານຂອງທ່ານຊໍ້າກັນ");
                        }else{
                            ErrorFuntion("ຫຼົ້ມເຫຼວ");
                        }
                    }
                })
            });

            function edit_function(users_id,user_store_fk,user_branch_fk,user_permission_fk,users_name,users_password){
                localStorage.clear();
                $("#modal_users").modal("show");
                $("#modal_title").html("ແກ້ໄຂຂໍ້ມູນ");
                $("#btn_save").html("<i class='fas fa-pen'></i> ແກ້ໄຂ");
                $('#'+users_name).focus();
                $("#users_id").val(users_id);
                $("#branch_store").val(user_store_fk);
                $("#branch_code").val(user_branch_fk);
                $("#user_permission_fk").val(user_permission_fk);
                $("#users_name").val(users_name);
                $("#users_password").val(users_password);
                $("#users_checkPassword").val(users_password);
                auto_focus("modal_users","users_name");
            }

            function delete_user(field_id){
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
                            url: "services/sql/service-userlogin.php?delete_data",
                            method: "POST",
                            data:{field_id},
                            success: function(data) {
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    successfuly('ລຶບຂໍ້ມູນສໍາເລັດແລ້ວ');
                                    loadUserlogin(1)
                                } else {
                                    Error_data();
                                }
                            }
                        });
                    }
                })
            }

            function function_showpassword(userID){
                var Inputtype=$("#users_password"+userID).attr("type");
                if( Inputtype === 'password' ){
                    $("#users_password"+userID).attr("type", "text");
                }else{
                    $("#users_password"+userID).attr("type", "password");
                }
            }

            function fn_togle_switch(userID,statasID){
                if(statasID==="on"){
                    status="off";
                }else{
                    status="on";
                }
                $.ajax({
                    url:"services/sql/service-userlogin.php?editStatus",
                    method:"POST",
                    data:{userID,status},
                    success:function(data){
                        load_data_setting($("#search_page").val(),$("#limit_page").val(),$("#order_page").val(),pagin="1","service-userlogin.php?fetch_data","display");
                    }
                })
            }

            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
                }
                return true;
            }

        </script>
</body>

</html>