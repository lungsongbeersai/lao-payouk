<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
function app_sidebar_minified(){
    // echo "app-sidebar-minified";
    echo "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Main app</title>
    <?php $packget_all->main_css(); ?>
    <style>
        h3,
        p {
            color: #383838;
            /* font-weight: normal; */
        }

        .widget {
            border: 1px solid #DB4900;
            cursor: pointer;
        }
    </style>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified() ?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>
        <div id="content" class="app-content">
            <div class="row">
                <div class="col-sm-4">
                    <div class="widget widget-stats bg-light shadow-sm">
                        <div class="stats-icon text-dark"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-info mb-2">
                            <h3 class="mb-4" style="font-size:18px;">✓ ຍອດຂາຍຕົວຈິງ</h3>
                            <p style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">&nbsp;&nbsp;&nbsp; <span id="totals"></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget widget-stats bg-light shadow-sm">
                        <div class="stats-icon text-dark"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-info mb-2">
                            <h3 class="mb-4" style="font-size:18px;">✓ ຍອດຂາຍຕິດໜີ້</h3>
                            <p style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">&nbsp;&nbsp;&nbsp; <span id="total_ny">0.0</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget widget-stats bg-light shadow-sm">
                        <div class="stats-icon text-dark"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-info mb-2">
                            <h3 class="mb-4" style="font-size:18px;">✓ ຍອດຂາຍ Foodpanda</h3>
                            <p style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">&nbsp;&nbsp;&nbsp; 0.0</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 mx-auto">
                    <div class="card" style="border:1px solid #DB4900">
                        <div class="card-body">
                            <div id="chart4" style="font-family:phetsarath OT !important;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 mx-auto mt-2">
                    <div class="card">
                        <h3 class="mt-2">&nbsp;&nbsp;<i class="fas fa-shopping-cart"></i> ເມນູຂາຍປະຈໍາວັນ</h3>
                        <div class="row mt-2">
                            <div class="col-md-2 mb-2 px-3">
                                <select name="limit_page" id="limit_page" class="select_option">
                                    <option value="">ທັງໝົດ</option>
                                    <option value="50">ເຄື່ອງດຶ່ມ</option>
                                    <option value="50">ອາຫານ</option>
                                </select>
                            </div>
                            <div class="col-md-9"></div>
                            <div class="col-md-1 mb-2">
                                <select name="order_page" id="order_page" class="select_option">
                                    <option value="ASC">ຕາມລາຄາ</option>
                                    <option value="DESC">ຕາມຈໍານວນ</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <td align="center">ລໍາດັບ</td>
                                        <td>ຊື່ລາຍການ</td>
                                        <td align="center">ຈໍານວນ</td>
                                        <td align="center">ລາຄາຂາຍ</td>
                                        <td align="center">ສ່ວນຫຼຸດ</td>
                                        <td align="center">ລວມເປັນເງິນ</td>
                                    </tr>
                                </thead>
                                <tbody class="table-bordered-y table-sm">
                                    <?php 
                                        $sqlRow=$db->fn_read_all("view_sum_orders WHERE check_bill_list_branch_fk='".$_SESSION["user_branch"]."'");
                                        $rowCount=array();
                                        if(count($sqlRow)>0){
                                            foreach($sqlRow as $rowData){
                                                $rowCount[]=$rowData;
                                            }
                                            json_encode($rowCount);
                                            foreach ($rowCount as $fetchData) {
                                                @$sumQty+=$fetchData['sum_qty'];
                                                @$sumPrice+=$fetchData['check_bill_list_pro_price'];
                                                @$sumDiscount+=$fetchData['sum_discount'];
                                                @$sumTotal+=$fetchData['sum_total'];
                                                echo 
                                                '<tr>
                                                    <td align="center">'.$fetchData['auto_id'].'</td>
                                                    <td>'.$fetchData['product_name'].'</td>
                                                    <td align="center">'.@number_format($fetchData['sum_qty']).'</td>
                                                    <td align="center">'.@number_format($fetchData['check_bill_list_pro_price']).'</td>
                                                    <td align="center">'.@number_format($fetchData['sum_discount']).'</td>
                                                    <td align="center">'.@number_format($fetchData['sum_total']).'</td>
                                                </tr>';
                                            }
                                            echo 
                                            '<tr style="border-top:1px solid #DEE2E6;background:#0F253B !important;color:white !important">
                                                <td colspan="2" align="right">ລວມຍອດ</td>
                                                <td align="center">'.@number_format($sumQty).'</td>
                                                <td align="center">'.@number_format($sumPrice).'</td>
                                                <td align="center">'.@number_format($sumDiscount).'</td>
                                                <td align="center">'.@number_format($sumTotal).'</td>
                                            </tr>';
                                        }else{
                                            echo '
                                            <tr>
                                                <td colspan="6">
                                                    <br><br><br><br>
                                                    <center>
                                                        <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                                                            <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                                                        </svg>
                                                        <h5 class="mt-3">ຍັງບໍ່ມີການຂາຍ</h5>
                                                    </center>
                                                    
                                                    <br><br><br><br>
                                                </td>
                                            </tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="modalPreview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form action="services/print-excel/print-deshboard.php" method="POST" target="_bank">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">
                                            <h3><ion-icon name="print-outline" style="font-size: 25px;"></ion-icon> ເລືອກພິມລາຍງານ</h3>
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="printAll" name="printData" value="1" checked />
                                                    <label class="form-check-label" for="printAll">ພິມລາຍງານແບບລວມ</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="printList" name="printData" value="2" />
                                                    <label class="form-check-label" for="printList">ພິມລາຍງານແບບລະອຽດ</label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-warning"><ion-icon name="print-outline" style="font-size: 25px;"></ion-icon><br>ພິມຂໍ້ມູນ</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><ion-icon name="close-outline" style="font-size: 25px;"></ion-icon><br>ປິດໜ້າຕ່າງ</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php $packget_all->main_script(); ?>
        <script>
            load_Dashboard()
            function load_Dashboard() {
                $.ajax({
                    url: "services/sql/service-dashboard.php?fetch",
                    method: "POST",
                    dataType: "json",
                    success: function(data) {
                        $("#totals").html(numeral(data.total).format('0,000'));
                        $("#total_ny").html(numeral(data.amount_ny).format('0,000'));
                    }
                })
            }

            var options = {
                series: [{
                    name: 'ຍອດຂາຍ',
                    data: [
                        <?php
                            for ($i = 1; $i <= 31; $i++) {
                                $dateBill=date("Y-m-".str_pad($i, 2, "0", STR_PAD_LEFT));
                                $sqlBill=$db->fn_fetch_single_field("list_bill_date,
                                (SELECT SUM(list_bill_amount_kip) FROM res_check_bill WHERE list_bill_date='".$dateBill."' AND list_bill_type_pay_fk !='4' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."')AS total",
                                "res_check_bill WHERE list_bill_date='".$dateBill."' AND list_bill_status='1' AND list_bill_branch_fk='".$_SESSION["user_branch"]."' GROUP BY list_bill_date");
                                if(@$sqlBill["total"] !=""){echo $sqlBill['total'];}else{echo "0";};
                                echo ",";
                            }

                        ?>
                    ]
                }],

                chart: {
                    foreColor: '#000000',
                    type: 'bar',
                    height: 400
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '80%',
                        endingShape: 'rounded'
                    },
                },


                dataLabels: {
                    enabled: false,
                    style: {
                        fontSize: '10px',
                        fontFamily:"LAOS",
                    }
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                title: {
                    text: 'ຍອດຂາຍປະຈໍາເດືອນ <?php echo date("m/Y")?>',
                    align: 'left',
                    style: {
                        fontSize: '18px',
                        fontFamily:"LAOS",
                    },
                },
                colors: ['#DB4900'],
                xaxis: {
                    categories: [
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            echo str_pad($i, 2, "0", STR_PAD_LEFT);
                            echo ",";
                        }
                        ?>
                    ],
                },

                yaxis: {
                    labels: {
                        show: true,
                        formatter: function (val) {
                        return numeral(val).format('0,00');
                        }
                    }
                    
                },

                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return numeral(val).format('0,00') + " ກີບ"
                        }
                    },
                    style: {
                        fontFamily:"LAOS",
                    }
                },

            };
            var chart = new ApexCharts(document.querySelector("#chart4"), options);
            chart.render();
        </script>

</body>

</html>