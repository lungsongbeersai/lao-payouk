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
    <title>Pay-debt</title>
    <?php $packget_all->main_css(); ?>
    <style>
        .font_size {
            font-size: 14px;
        }

        tr,
        td {
            vertical-align: middle !important;
        }

        input[readonly] {
            background-color: #EFEFEF !important;
        }

        label {
            font-size: 15px !important;
        }
    </style>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed app-content-full-height <?php echo app_sidebar_minified() ?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content p-0">

            <div class="mailbox">

                <div class="mailbox-sidebar">
                    <div class="mailbox-sidebar-header d-flex justify-content-center">
                        <h4>ລາຍການບິນຄ້າງຈ່າຍ</h4>
                    </div>
                    <div class="mailbox-sidebar-content collapse d-lg-block" id="emailNav">

                        <div data-scrollbar="true" data-height="100%" data-skip-mobile="true">
                            <ul class="nav nav-inbox" id="showDebt">
                                <?php
                                $sqlBill = "view_daily_report_group WHERE list_bill_type_pay_fk='4' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."' ORDER BY list_bill_no ASC";
                                $billLimit = "view_daily_report_group WHERE list_bill_type_pay_fk='4' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."' ORDER BY list_bill_no ASC LIMIT 1";
                                $fetch_debt = $db->fn_read_all($sqlBill);
                                $total_data = $db->fn_fetch_rowcount($sqlBill);
                                $fetch_sql = $db->fn_fetch_single_all($billLimit);
                                if ($total_data > 0) {
                                    foreach ($fetch_debt as $row_sql) {
                                        if ($row_sql["list_bill_no"] == $fetch_sql["list_bill_no"]) {
                                            $active = "active";
                                        } else {
                                            $active = "";
                                        }
                                        $sqlCount=$db->fn_fetch_rowcount("res_check_bill_list WHERE check_bill_list_bill_fk='".$row_sql["list_bill_no"]."'");
                                ?>
                                        <li class="<?php echo $active; ?> " style="font-size: 14px;" id="<?php echo $row_sql["list_bill_no"] ?>" onclick="loadDebt('<?php echo $row_sql['list_bill_no'] ?>')">
                                            <a href="#">
                                                <ion-icon name="checkmark-circle-outline" class="fa-lg fa-fw me-2"></ion-icon>
                                                <?php echo $row_sql["list_bill_no"] ?>
                                                <span class="badge bg-dark-600 fs-10px rounded-pill ms-auto fw-bolder pt-4px pb-5px px-8px"><?php echo $sqlCount;?></span>
                                            </a>
                                        </li>
                                        <input type="text" hidden id="billNo" value="<?php echo $fetch_sql["list_bill_no"]; ?>">
                                <?php  }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="mailbox-content">
                    <div class="mailbox-content-header">
                        <div class="row">
                            <div class="col-md-1">
                                <a href="?main" class="btn btn-danger"><i class="fa fa-fw fa-reply"></i>
                                    <span class="d-none d-lg-inline">ກັບຄືນ</span>
                                </a>
                            </div>
                            <div class="col-md-9"></div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" id="search_page" name="search_page" class="form-control input_color form-control-sm" placeholder="ຄົ້ນຫາ...">
                                    <button type="button" class="btn btn-primary search" onclick="searchInput()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mailbox-content-body">
                        <div data-scrollbar="true" data-height="100%" data-skip-mobile="true" id="showData">

                        </div>
                    </div>
                    <div class="mailbox-content-footer d-flex align-items-center justify-content-end">
                        <div class="btn-group">
                            <div id="link_a"></div>
                            <button type="button" id="paymentData" class="btn btn-primary manageBill"><i class="fa fa-fw fa-check"></i> ຊໍາລະໜີ້</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalCheckbill" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog" style="max-width:550px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">ສໍາລະໜີ້ຄ້າງຈ່າຍ</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="frmBill">
                        <div class="modal-body">
                            <div class="row">
                                <input type="text" hidden name="bill_no1" id="bill_no1">
                                <input type="text" hidden name="table_code1" id="table_code1" value="<?php echo @$table_name["table_code"]; ?>">
                                <input type="text" hidden name="tableName" id="tableName" value="<?php echo base64_encode(@$table_name["table_name"]); ?>">

                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ຊື່ລູກຄ້າ</label>
                                        <input type="text" class="form-control input_color" id="list_bill_custommer_fk" name="list_bill_custommer_fk" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ປະເພດການຊໍາລະ</label>
                                        <select class="form-control form-select" name="list_bill_type_pay_fk" id="list_bill_type_pay_fk" onchange="changeTypePayment()">
                                            <?php 
                                            $users=$db->fn_read_all("res_type_payment ORDER BY type_id ASC");
                                                foreach($users as $rowUser){
                                                    echo "<option value='".$rowUser["type_id"]."'>".$rowUser["type_name"]."</option>";
                                                }
                                            ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ລວມທັງໝົດ </label>
                                        <input type="text" class="form-control input_color" name="list_bill_amount" id="list_bill_amount" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6" hidden>
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ສ່ວນຫຼຸດ/ກີບ</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData" autocomplete="off" name="per_price" id="per_price" placeholder="0.0" onkeyup="fn_calucator()">
                                    </div>
                                </div>
                                <div class="col-md-6" hidden>
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ສ່ວນຫຼຸດ %</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData" autocomplete="off" maxlength="3" name="per_cented" id="per_cented" placeholder="%" onkeyup="fn_calucatorPercented()">
                                    </div>
                                </div>

                                <input type="text" hidden name="list_rate_bat_kip" id="list_rate_bat_kip" value="10000">
                                <input type="text" hidden name="list_rate_us_kip" id="list_rate_us_kip" value="20000">
                                <input type="text" hidden name="list_bill_qty" id="list_bill_qty">
                                <input type="text" hidden name="list_bill_count_order" id="list_bill_count_order">
                                <input type="text" hidden name="sumTotalPercented" id="sumTotalPercented">
                                <input type="text" hidden id="sumGif_pro" name="sumGif_pro">
                                <input type="text" hidden name="branch_code" id="branch_code" value="<?php echo $_SESSION["user_branch"]; ?>">
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ມູນຄ່າຕ້ອງຊໍາລະ/ກີບ</label>
                                        <input type="text" class="form-control input_color calculator_price" id="list_bill_amount_kip" name="list_bill_amount_kip" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">1 THB=<span class="text-danger" id="rate_bath"></span></label>
                                        <input type="text" class="form-control input_color" id="list_bill_amount_bath" name="list_bill_amount_bath" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">1 USD=<span class="text-danger" id="rate_us"></span></label>
                                        <input type="text" class="form-control input_color" id="list_bill_amount_us" name="list_bill_amount_us" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="mb-2"> ຊໍາລະເງິນສົດ ກີບ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control input_color calculator_price CalculatorData require_cash list_pay_kip" autocomplete="off" id="list_pay_kip" name="list_pay_kip" placeholder="0.0">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ຊໍາລະເງິນສົດ THB</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData require_cash" autocomplete="off" id="list_bill_pay_bath" name="list_bill_pay_bath" placeholder="0.0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ຊໍາລະເງິນສົດ USD</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData require_cash" autocomplete="off" id="list_bill_pay_us" name="list_bill_pay_us" placeholder="0.0">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="" class="mb-2"> ເງິນໂອນກີບ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control input_color calculator_price CalculatorData require_transfer" readonly autocomplete="off" id="transfer_kip" name="transfer_kip" placeholder="0.0">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ໂອນບາດ THB</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData require_transfer" readonly autocomplete="off" id="transfer_bath" name="transfer_bath" placeholder="0.0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ໂອນໂດຣາ USD</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData require_transfer" readonly autocomplete="off" id="transfer_us" name="transfer_us" placeholder="0.0">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ເງິນທອນ ກີບ</label>
                                        <input type="text" class="form-control input_color" id="list_bill_return" name="list_bill_return" placeholder="0.0" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn_payment" disabled><i class="fas fa-save"></i> ຊໍາລະເງິນ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
            SearchData();

            function SearchData(billCode = $("#billNo").val()) {
                $.ajax({
                    url: "services/report/pay-debt-report.php?report",
                    method: "POST",
                    data: {
                        billCode
                    },
                    success: function(data) {
                        $("#showData").html(data);
                        Disabled();
                        $("#list_rate_bat_kip").val($("#list_rate_bat_kip").val());
                        $("#list_rate_us_kip").val($("#list_rate_us_kip").val());
                        $("#rate_bath").text($("#list_rate_bat_kip").val());
                        $("#rate_us").text($("#list_rate_us_kip").val());
                        $("#link_a").html("");
                    }
                })
            }

            function loadDebt(billCode = $("#search_page").val()) {
                $.ajax({
                    url: "services/report/pay-debt-report.php?fetchBill",
                    method: "POST",
                    data: {
                        billCode,
                    },
                    success: function(data) {
                        $("#showDebt").html(data);
                        SearchData(billCode);
                    }
                })
            }

            function searchInput() {
                var billCode = $("#search_page").val();
                    if(billCode !=""){
                        $.ajax({
                            url: "services/report/pay-debt-report.php?fetchSearch",
                            method: "POST",
                            data: {
                                billCode,
                            },
                            success: function(data) {
                                $("#showDebt").html(data);
                                SearchData(billCode);
                            }
                        })
                    }
            }
            Disabled()

            function Disabled() {
                var billNo = $("#billNo").val();
                if (billNo === "") {
                    $("#paymentData").attr("disabled", true);
                } else {
                    $("#paymentData").attr("disabled", false);
                }
            }


            function fn_calucator() {
                var per_price = Number($("#per_price").val().replace(/[^0-9\.-]+/g, ""));
                var per_cented = Number($("#per_cented").val().replace(/[^0-9\.-]+/g, ""));

                var list_bill_amount = Number($("#list_bill_amount").val().replace(/[^0-9\.-]+/g, ""));
                var list_bill_amount_kip1 = Number($("#list_bill_amount_kip").val().replace(/[^0-9\.-]+/g, ""));
                var list_bill_amount_bath1 = Number($("#list_bill_amount_bath").val().replace(/[^0-9\.-]+/g, ""));
                var list_bill_amount_us1 = Number($("#list_bill_amount_us").val().replace(/[^0-9\.-]+/g, ""));
                var list_rate_bat_kip = Number($("#list_rate_bat_kip").val().replace(/[^0-9\.-]+/g, ""));
                var list_rate_us_kip = Number($("#list_rate_us_kip").val().replace(/[^0-9\.-]+/g, ""));


                var totalPercented = list_bill_amount * (per_cented / 100);
                var sumPercentedKip = parseFloat(totalPercented + per_price);
                var sumPercentedbath = parseFloat(totalPercented + per_price);
                var sumPercentedus = parseFloat(totalPercented + per_price);

                var list_bill_amount_kip = parseFloat(list_bill_amount - sumPercentedKip);
                var list_bill_amount_bath = parseFloat(list_bill_amount - sumPercentedbath) / list_rate_bat_kip;
                var list_bill_amount_us = parseFloat(list_bill_amount - sumPercentedus) / list_rate_us_kip;

                $("#list_bill_amount_kip").val(numeral(list_bill_amount_kip).format('0,000'));
                $("#list_bill_amount_bath").val(numeral(list_bill_amount_bath).format('0,000'));

                if (list_bill_amount_us >= 1) {
                    $("#list_bill_amount_us").val(numeral(list_bill_amount_us).format('0,000'));
                } else {
                    $("#list_bill_amount_us").val(1);
                }




                var sliceData = $("#list_bill_amount_kip").val().slice(-3);
                if (sliceData > 0) {
                    if (sliceData === "000") {
                        var showPrice = parseFloat(list_bill_amount_kip);
                        $("#list_bill_amount_kip").val(numeral(showPrice).format('0,000'));
                    } else {
                        var showPrice = parseFloat(list_bill_amount_kip - sliceData + 1000);
                        $("#list_bill_amount_kip").val(numeral(showPrice).format('0,000'));
                    }
                }



                var list_bill_amount_kip2 = Number($("#list_bill_amount_kip").val().replace(/[^0-9\.-]+/g, ""));
                var list_bill_amount_bath2 = Number($("#list_bill_amount_bath").val().replace(/[^0-9\.-]+/g, ""));
                var list_bill_amount_us2 = Number($("#list_bill_amount_us").val().replace(/[^0-9\.-]+/g, ""));
                var list_pay_kip_convert = Number($("#list_pay_kip").val().replace(/[^0-9\.-]+/g, ""));
                var list_bill_pay_bath_convert = Number($("#list_bill_pay_bath").val().replace(/[^0-9\.-]+/g, ""));
                var list_bill_pay_us_convert = Number($("#list_bill_pay_us").val().replace(/[^0-9\.-]+/g, ""));
                var convert_transfer_kip = Number($("#transfer_kip").val().replace(/[^0-9\.-]+/g, ""));
                var convert_transfer_bath = Number($("#transfer_bath").val().replace(/[^0-9\.-]+/g, ""));
                var convert_transfer_us = Number($("#transfer_us").val().replace(/[^0-9\.-]+/g, ""));

                if (per_price != "0") {
                    $("#per_price").val(numeral(per_price).format('0,000'));
                    $("#per_cented").val("");
                }

                $("#list_pay_kip").val(numeral(list_pay_kip_convert).format('0,000'));
                $("#list_bill_pay_bath").val(numeral(list_bill_pay_bath_convert).format('0,000'));
                $("#list_bill_pay_us").val(numeral(list_bill_pay_us_convert).format('0,000'));

                $("#transfer_kip").val(numeral(convert_transfer_kip).format('0,000'));
                $("#transfer_bath").val(numeral(convert_transfer_bath).format('0,000'));
                $("#transfer_us").val(numeral(convert_transfer_us).format('0,000'));


                listKipConvert = numeral(list_pay_kip_convert).format('0,000');
                listthaiConvert = numeral(list_bill_pay_bath_convert).format('0,000');
                listusConvert = numeral(list_bill_pay_us_convert).format('0,000');
                transferKipConvert = numeral(convert_transfer_kip).format('0,000');
                transferBathConvert = numeral(convert_transfer_bath).format('0,000');
                transferusConvert = numeral(convert_transfer_us).format('0,000');

                if (listKipConvert === "0") {
                    $("#list_pay_kip").val("");
                }
                if (listthaiConvert === "0") {
                    $("#list_bill_pay_bath").val("");
                }
                if (listusConvert === "0") {
                    $("#list_bill_pay_us").val("");
                }
                if (transferKipConvert === "0") {
                    $("#transfer_kip").val("");
                }
                if (transferBathConvert === "0") {
                    $("#transfer_bath").val("");
                }
                if (transferusConvert === "0") {
                    $("#transfer_us").val("");
                }

                sumKip = parseFloat(list_pay_kip_convert + convert_transfer_kip - list_bill_amount_kip2);
                sumBath = parseFloat(list_bill_pay_bath_convert + convert_transfer_bath) * list_rate_bat_kip;
                sumUs = parseFloat(list_bill_pay_us_convert + convert_transfer_us) * list_rate_us_kip;


                sumTotal = parseFloat(sumKip) + parseFloat(sumBath) + parseFloat(sumUs);
                $("#list_bill_return").val(numeral(sumTotal).format('0,000'));

                TotalReturn = $("#list_bill_return").val().slice(-3);
                convertBath = parseFloat(list_bill_pay_bath_convert + convert_transfer_bath);
                convertUs = parseFloat(list_bill_pay_us_convert + convert_transfer_us);


                if (convertBath === list_bill_amount_bath2) {
                    $("#list_bill_return").val("0");
                    $("#list_pay_kip").val("");
                    $("#list_bill_pay_us").val("");
                    $("#transfer_us").val("");
                } else if (convertUs === list_bill_amount_us2) {
                    $("#transfer_kip").val("");
                    $("#list_bill_pay_bath").val("");
                    $("#transfer_bath").val("");
                    $("#list_bill_return").val("0");
                } else {
                    if (TotalReturn <= 900) {
                        var showPrice = parseFloat(sumTotal - TotalReturn);
                        $("#list_bill_return").val(numeral(showPrice).format('0,000'));
                    } else {
                        $("#list_bill_return").val(numeral(sumTotal).format('0,000'));
                    }
                }

                $("#btn_payment").attr("disabled", false);


                if (listKipConvert === "0" && listthaiConvert === "0" && listusConvert === "0" && transferKipConvert === "0" && transferBathConvert === "0" && transferusConvert === "0") {
                    $("#btn_payment").attr("disabled", true);
                    $("#list_bill_return").val("0");
                }

                if (listKipConvert === "" && listthaiConvert === "" && listusConvert === "" && transferKipConvert === "" && transferBathConvert === "" && transferusConvert === "") {
                    $("#btn_payment").attr("disabled", true);
                    $("#list_bill_return").val("0");
                }

            }

            function changeTypePayment() {
                var list_bill_type_pay_fk = $("#list_bill_type_pay_fk").val();

                if (list_bill_type_pay_fk === "1") {
                    $('#list_pay_kip').focus();
                    $('#list_pay_kip').prop('readonly', false);
                    $('#list_bill_pay_bath').prop('readonly', false);
                    $('#list_bill_pay_us').prop('readonly', false);

                    $('#transfer_kip').prop('readonly', true);
                    $('#transfer_bath').prop('readonly', true);
                    $('#transfer_us').prop('readonly', true);
                    $("#list_pay_kip").val("");
                    $("#list_bill_pay_bath").val("");
                    $("#list_bill_pay_us").val("");
                    $("#transfer_kip").val("");
                    $("#transfer_bath").val("");
                    $("#transfer_us").val("");
                    $("#list_bill_return").val("");
                    if ($('#list_pay_kip').val() === "" || $('#list_bill_pay_bath').val() === "" || $('#list_bill_pay_us') === "") {
                        $("#btn_payment").attr("disabled", true);
                    } else {
                        $("#btn_payment").attr("disabled", false);
                    }

                } else if (list_bill_type_pay_fk === "2") {
                    $('#transfer_kip').focus();
                    $('#list_pay_kip').prop('readonly', true);
                    $('#list_bill_pay_bath').prop('readonly', true);
                    $('#list_bill_pay_us').prop('readonly', true);
                    $('#transfer_kip').prop('readonly', false);
                    $('#transfer_bath').prop('readonly', false);
                    $('#transfer_us').prop('readonly', false);
                    $("#list_pay_kip").val("");
                    $("#list_bill_pay_bath").val("");
                    $("#list_bill_pay_us").val("");
                    $("#transfer_kip").val("");
                    $("#transfer_bath").val("");
                    $("#transfer_us").val("");
                    $("#list_bill_return").val("");

                    if ($('#transfer_kip').val() === "" || $('#transfer_bath').val() === "" || $('#transfer_us') === "") {
                        $("#btn_payment").attr("disabled", true);
                    } else {
                        $("#btn_payment").attr("disabled", false);
                    }

                } else if (list_bill_type_pay_fk === "3") {
                    $('#list_pay_kip').focus();
                    $('#list_pay_kip').prop('readonly', false);
                    $('#list_bill_pay_bath').prop('readonly', false);
                    $('#list_bill_pay_us').prop('readonly', false);
                    $('#transfer_kip').prop('readonly', false);
                    $('#transfer_bath').prop('readonly', false);
                    $('#transfer_us').prop('readonly', false);

                    // if($('.require_cash').val().length<0){
                    //     $('.require_cash').prop('required',true);
                    // }else if($('.require_transfer').val().length<0){
                    //     $('.require_transfer').prop('required',true);
                    // }else{
                    //     $('.require_cash').prop('required',false);
                    //     $('.require_transfer').prop('required',false);
                    // }
                    $("#btn_payment").attr("disabled", true);
                } else {
                    $('#list_pay_kip').prop('readonly', true);
                    $('#list_bill_pay_bath').prop('readonly', true);
                    $('#list_bill_pay_us').prop('readonly', true);
                    $('#transfer_kip').prop('readonly', true);
                    $('#transfer_bath').prop('readonly', true);
                    $('#transfer_us').prop('readonly', true);
                    $("#list_pay_kip").val("");
                    $("#list_bill_pay_bath").val("");
                    $("#list_bill_pay_us").val("");
                    $("#transfer_kip").val("");
                    $("#transfer_bath").val("");
                    $("#transfer_us").val("");
                    $("#list_bill_return").val("");
                    $("#btn_payment").attr("disabled", false);
                }
            }

            $(document).on("keyup", ".CalculatorData", function() {
                if ($("#per_cented").val() != "") {
                    $("#per_price").val("");
                    fn_calucator()
                } else {
                    $("#per_cented").val("");
                    fn_calucator()
                }
            });

            $(document).on("click", ".manageBill", function() {
                $("#modalCheckbill").modal("show");
                var price_total = $("#price_total").val();
                var totalKip = Number(price_total.replace(/[^0-9\.-]+/g, ""));
                var list_rate_bat_kip = Number($("#list_rate_bat_kip").val().replace(/[^0-9\.-]+/g, ""));
                var list_rate_us_kip = Number($("#list_rate_us_kip").val().replace(/[^0-9\.-]+/g, ""));
                var totalRate_bat_kip = (totalKip / list_rate_bat_kip);
                var totalRate_bat_us = (totalKip / list_rate_us_kip);
                var countOrder = $("#countOrder").val();
                $("#bill_no1").val($("#list_bill_no").val());
                $("#list_bill_custommer_fk").val($("#username").val());
                $("#sumGif_pro").val($("#sumGifTotal").val());
                $("#sumTotalPercented").val($("#sumlistTotal").val());
                $("#list_bill_count_order").val(countOrder);
                $("#list_bill_qty").val($("#sumQty").val());
                $("#list_bill_amount").val(numeral(totalKip).format('0,000'));
                $("#list_bill_amount_kip").val(numeral(totalKip).format('0,000'));
                $("#list_bill_amount_bath").val(numeral(totalRate_bat_kip).format('0,000'));

                if (totalRate_bat_us >= 1) {
                    $("#list_bill_amount_us").val(numeral(totalRate_bat_us).format('0,000'));
                } else {
                    $("#list_bill_amount_us").val(1);
                }

                $("#list_bill_return").val("")
                $("#per_price").val("");
                $("#per_cented").val("");
                $("#list_pay_kip").val("");
                $("#list_bill_pay_bath").val("");
                $("#list_bill_pay_us").val("");
                $("#transfer_kip").val("");
                $("#transfer_bath").val("");
                $("#transfer_us").val("");
                $("#countBill")[0].selectedIndex = 0;
                changeTypePayment()

            });


            $("#frmBill").on("submit", function(event) {
                event.preventDefault();
                var list_bill_return = Number($("#list_bill_return").val().replace(/[^0-9\.-]+/g, ""));
                var bill_no = $("#bill_no1").val();
                var tableName = $("#table_name").val();
                var branch_code=$("#branch_code").val();
                if ($("#list_bill_type_pay_fk").val() === "3") {
                    var countCash = 0;
                    $.each($(".require_cash"), function() {
                        countCash += $(this).val().length;
                    });

                    var counttransfer = 0;
                    $.each($(".require_transfer"), function() {
                        counttransfer += $(this).val().length;
                    });

                    if (countCash === 0 && counttransfer === 0) {
                        $("#list_pay_kip").focus();
                    } else if (countCash != 0 && counttransfer === 0) {
                        $("#transfer_kip").focus();
                    } else {
                        if (list_bill_return >= "0") {
                            $.ajax({
                                url: "services/report/pay-debt-report.php?editStatus",
                                method: "POST",
                                data: new FormData(this),
                                contentType: false,
                                processData: false,
                                success: function(data) {
                                    var dataResult = JSON.parse(data);
                                    if (dataResult.statusCode == 200) {
                                        var openWindow = window.open("?print_debt&&bill_no=" + bill_no + "&&tableName=" + tableName + "&&branch_code=" + branch_code, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=200,width=1000,height=500");
                                        openWindow.document.close();
                                        openWindow.focus();
                                        openWindow.print();
                                        setTimeout(function() {
                                            openWindow.close();
                                            location.href = "?pay_debt";
                                        }, 1000)
                                    }
                                }
                            })
                        } else {
                            ErrorFuntion("ທ່ານປ້ອນຈໍານວນເງິນຍັງບໍ່ຄົບ !");
                            $("#list_pay_kip").focus();
                        }
                    }
                } else {
                    if (list_bill_return >= "0") {
                        $.ajax({
                            url: "services/report/pay-debt-report.php?editStatus",
                            method: "POST",
                            data: new FormData(this),
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    var openWindow = window.open("?print_debt&&bill_no=" + bill_no + "&&tableName=" + tableName + "&&branch_code=" + branch_code, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=200,width=1000,height=500");
                                    openWindow.document.close();
                                    openWindow.focus();
                                    openWindow.print();
                                    setTimeout(function() {
                                        openWindow.close();
                                        location.href = "?pay_debt";
                                    }, 1000)
                                }
                            }
                        })
                    } else {
                        ErrorFuntion("ທ່ານປ້ອນຈໍານວນເງິນຍັງບໍ່ຄົບ !");
                        $("#list_pay_kip").focus();
                    }
                }

            });
        </script>
</body>

</html>