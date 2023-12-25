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
    <title>Frm Permission</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified()?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <ol class="breadcrumb float-xl-end">
                <li class="breadcrumb-item"><a href="javascript:history.back()" class="text-danger"><i class="fas fa-arrow-circle-left"></i> ກັບຄືນ</a></li>
                <li class="breadcrumb-item active">ລາຍການກໍານົດສິດຜູ້ໃຊ້</li>
            </ol>

            <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                <i class="fas fa-list"></i> ລາຍການກໍານົດສິດຜູ້ໃຊ້
            </h4>

            <div class="row mb-2">
                <div class="col-md-2">
                    <?php 
                        if($_SESSION["user_permission_fk"]=="202300000001"){
                    ?>
                    <button type="button" class="btn btn-outline-orange" id="add">
                        <i class="fas fa-add"></i> ເພີ່ມຂໍ້ມູນ
                    </button>
                    <?php }?>
                </div>
                <div class="col-md-8"></div>
                <div class="col-md-2">
                    <div class="input-group">
                        <input type="text" id="search_page" name="search_page" class="form-control" style="border:1px solid #DB4900;" placeholder="ຄົ້ນຫາ...">
                        <button type="button" class="btn btn-orange search" onclick="loadData()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel panel-inverse">

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10"></div>
                        <div class="col-md-2">
                            <label for="">ສະຖານະສິດ</label>
                            <select name="search_user" id="search_user" class="form-select" onchange="loadData()">
                                <?php 
                                    if($_SESSION["user_permission_fk"]=="202300000001"){
                                        $permiss="";
                                    }else{
                                        $permiss="WHERE status_code !='202300000001' AND status_open='1'";
                                    }
                                    $sqlStatus=$db->fn_read_all("res_status $permiss ORDER BY status_code ASC");
                                    foreach($sqlStatus as $rowStauts){
                                        echo "<option value='".$rowStauts["status_code"]."'>".$rowStauts["status_name"]."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="panel-body px-0" style="margin-top:-14px;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead style="background-color:#384047;color:white">
                                <tr>
                                    <td style="text-align:center !important;width:150px !important">ໝວດໝູ່ອາຫານ</td>
                                    <td style="text-align:center !important;width:50px !important">ລໍາດັບ</td>
                                    <td>ຊື່ສິນຄ້າກຸ່ມໃຫຍ່</td>
                                    <td style="text-align:center !important;width:50px !important">ສະຖານະ</td>
                                </tr>
                            </thead>
                            <tbody class="table-bordered-y table-sm display" style="border-bottom: 1px solid #e0e0e0;">

                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>

        </div>


        <div class="modal fade" id="modal_permission" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-light" id="modal_title">Modal Without Animation</h4>
                        <button type="button" class="btn-close text-light close1" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="add_permission">
                        <div class="modal-body" id="loadDataAll">
                            <div class="form-group mb-3">
                                <label for="" class="mb-2">ສະຖານະ <span class="text-danger">*</span></label>
                                <select name="menu_default_code" id="menu_default_code" class="form-select menu_default_code" required>
                                    <option value="">ເລືອກ</option>
                                </select>
                            </div>
                            <table class="table table-sm" style="overflow-y:scroll;height: 100px;">
                                <thead style="background-color:#384047;color:white">
                                    <tr>
                                        <td style="width:100px;">ຫົວຂໍ້ໃຫຍ່</td>
                                        <td>ລໍາດັບ</td>
                                        <td align="center"><input type="checkbox" class="form-check-input selectAll"></td>
                                        <td>ຊື່ລາຍການ</td>
                                    </tr>
                                </thead>
                                <tbody class="table-bordered-y" style="border-bottom: 1px solid #e8e5e5 !important;">
                                    <?php 
                                        $sqlGroup=$db->fn_read_all("res_main_menus WHERE main_code !='202300000001' ORDER BY main_code ASC");
                                        foreach($sqlGroup as $rowGroup){
                                    ?>
                                    <tr style="background-color: #e0dede;">
                                        <td colspan="4">- <?php echo $rowGroup["main_name"]?></td>
                                    </tr>
                                    <?php 
                                        $i=1;
                                        $sqlDefault=$db->fn_read_all("res_sub_menus WHERE sub_main_fk='".$rowGroup["main_code"]."' ORDER BY sub_order_by ASC ");
                                        foreach($sqlDefault as $rowDefault){
                                    ?>
                                        <tr>
                                            <td></td>
                                            <td align="center"><?php echo $i++;?></td>
                                            <td align="center">
                                                <input type="checkbox" class="form-check-input default_menu_sub_fk" name="default_menu_sub_fk[]" id="<?php echo $rowDefault["sub_code"];?>" value="<?php echo $rowDefault["sub_code"];?>">
                                                <input type="text" hidden name="default_menu_main_fk[]" class="default_menu_main_fk" id="default_menu_main_fk<?php echo $rowDefault["sub_code"];?>" value="<?php echo $rowDefault["sub_main_fk"];?>" disabled>
                                            </td>
                                            <td><?php echo $rowDefault["sub_name"];?></td>
                                        </tr>
                                    <?php } }?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary btn_save" id="btn_save" disabled><i class="fas fa-save"></i> ບັນທຶກ</button>
                            <button type="button" class="btn btn-outline-danger close1" data-bs-dismiss="modal"><i class="fas fa-times"></i> ປິດ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
            res_userlogin("menu_default_code");
            
            $("#add_permission").on("submit", function(event) {
                event.preventDefault();
                $.ajax({
                    url: "services/sql/service-permission.php?insert_data" ,
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode == 200) {
                            loadData()
                            successfuly("ບັນທຶກສໍາເລັດ");
                            $("#add_permission")[0].reset();
                           $("#modal_permission").modal("hide");
                        } else if (dataResult.statusCode == 202) {
                            loadData()
                            successfuly("ແກ້ໄຂສໍາເລັດແລ້ວ");
                            $("#add_permission")[0].reset();
                           $("#modal_permission").modal("hide");
                        }else if (dataResult.statusCode == 204) {
                            Error_warning();
                        } else {
                            Error_data();
                        }
                    }
                })
            })
            loadData();
            function loadData(){
                var search_user=$("#search_user").val();
                var search_page=$("#search_page").val();
                $.ajax({
                    url: "services/sql/service-permission.php?fetch_data" ,
                    method: "POST",
                    data:{search_user,search_page},
                    success: function(data) {
                        $(".display").html(data);
                    }
                })
            }

            function fn_togle_switch(codeId,Status){
                if(Status=="2"){
                    stautsID="1";
                    successfuly("ປິດສໍາເລັດ");
                }else{
                    stautsID="2";
                    successfuly("ເປີດສໍາເລັດ");
                }
                $.ajax({
                    url: "services/sql/service-permission.php?editStatus" ,
                    method: "POST",
                    data:{codeId,stautsID},
                    success: function(data) {
                        loadData()
                    }
                })
            }
           
            $(document).on("change", ".selectAll", function() {
                $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
                if($(this).prop('checked')===true){
                    $(".default_menu_main_fk").attr("disabled",false);
                    $('.btn_save').attr('disabled', false);
                }else{
                    $(".default_menu_main_fk").attr("disabled",true);
                    $('.btn_save').attr('disabled', true);
                }
            });

            $(document).on("change", ".default_menu_sub_fk", function() {
                var default_menu_sub_fk=$(this).attr("Id");
                var default_menu_main_fk=$("#default_menu_main_fk"+default_menu_sub_fk).val();
                if ($(this).is(':checked', true)) {
                    $("#default_menu_main_fk"+default_menu_sub_fk).attr("disabled",false);
                }else{
                    $("#default_menu_main_fk"+default_menu_sub_fk).attr("disabled",true);
                }

                if ($(".default_menu_sub_fk:checked").length == 0) {
                     $('.btn_save').attr('disabled', true);
                  } else {
                    $('.btn_save').attr('disabled', false);
                  }
            })

            $("#add").click(function(){
                $("#modal_title").html("ເພີ່ມສິດ");
                $("#default_menu_code").val("");
                // $("input[type=checkbox]").prop('checked', $(this).prop('check'));
                $(':checkbox').prop('checked', false).removeAttr('checked');
                $("#modal_permission").modal("show");
            });


        </script>
        
</body>

</html>