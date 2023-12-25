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
    <title>Daily Report</title>
    <?php $packget_all->main_css(); ?>
    <style>
        td {
            vertical-align: middle;
        }
        .txt_month{
            font-size: 13px !important;
        }

        .txt_month:hover{
            color:white !important;
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

        <div id="content" class="app-content px-3">
            <!-- <form action="services/print-excel/print-monthly-report.php" target="_bank" method="POST"> -->
            <form action="#" target="_bank" method="POST">
                <ol class="breadcrumb float-xl-end mb-2">
                    <li class="breadcrumb-item active">
                        <button type="submit" name="print" class="btn btn-warning btn-xs">
                            <ion-icon name="print-outline" style="font-size: 25px;"></ion-icon>
                        </button>
                        <button type="submit" name="excel" class="btn btn-success btn-xs">
                            <ion-icon name="download-outline" style="font-size: 25px;"></ion-icon>
                        </button>
                    </li>
                </ol>

                <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                    <i class="fas fa-file-pdf"></i> ລາຍງານການຂາຍປະຈໍາເດືອນ
                </h4>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-11">
                                <label for="" class="mb-1"> ເລືອກເດືອນ</label><br>
                                <button type="button" class="btn btn btn-outline-orange txt_month" id="txt_month" name="txt_month" onclick="SearchData('')">ທັງໝົດ</button>
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    if ($i < 10) {
                                        $value = str_pad($i, 2, "0", STR_PAD_LEFT);
                                    }else{
                                        $value =$i;
                                    }
                                ?>
                                    <button type="button" class="btn btn btn-outline-orange  txt_month" id="txt_month<?php echo $value;?>" onclick="SearchData('<?php echo $value;?>')">ເດືອນ <?php echo $value; ?></button>
                                <?php } ?>
                            </div>
                            <div class="col-md-1">
                                <label for="" class="mb-1"> ເລືອກປີ</label>
                                <select name="txt_years" id="txt_years" class="form-select form-select-sm txt_years" onchange="SearchData('<?php echo date('m')?>')" style="border-radius:5px !important;border:1px solid #DB4900 !important">
                                    <?php
                                    for ($year = 2022; $year <= date("Y"); $year++) {
                                    ?>
                                        <option value="<?php echo $year; ?>" <?php if($year==date("Y")){echo "selected";}else{echo "";}?>><?php echo $year; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="widget widget-stats bg-light shadow-sm">
                                    <div class="stats-icon text-dark"><ion-icon name="wallet-outline"></ion-icon></div>
                                    <div class="stats-info mb-2">
                                        <h3 class="mb-4 text-dark" style="font-size:18px;">✓ ຍອດຂາຍຕົວຈິງ</h3>
                                        <p class="text-dark" style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">&nbsp;&nbsp;&nbsp; <span id="totals">0.0</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="widget widget-stats bg-light shadow-sm">
                                    <div class="stats-icon text-dark"><ion-icon name="wallet-outline"></ion-icon></div>
                                    <div class="stats-info mb-2">
                                        <h3 class="mb-4 text-dark" style="font-size:18px;">✓ ຍອດຂາຍຕິດໜີ້</h3>
                                        <p class="text-dark" style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">&nbsp;&nbsp;&nbsp; <span id="total_ny">0.0</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="widget widget-stats bg-light shadow-sm">
                                    <div class="stats-icon text-dark"><ion-icon name="wallet-outline"></ion-icon></div>
                                    <div class="stats-info mb-2">
                                        <h3 class="mb-4 text-dark" style="font-size:18px;">✓ ຍອດຂາຍ Foodpanda</h3>
                                        <p class="text-dark" style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">&nbsp;&nbsp;&nbsp; 0.0</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 mx-auto">
                                <div class="card" style="border:1px solid #DB4900">
                                    <div class="card-body">
                                        <div id="chart44"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>


        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
            SearchData('');
            var options;
            function SearchData(monthID) {
                var yearID = $("#txt_years").val();
                $(".txt_month").removeClass("active");
                $(".txt_month").css("color","#DB4900"); 
                $("#txt_month"+monthID).css("color","white"); 
                $("#txt_month"+monthID).addClass("active"); 
                if(monthID===""){
                    month_name="( ທັງໝົດ )";
                }else{
                    month_name=monthID;
                }
                
                $.ajax({
                    url: "services/report/monly-report.php?fetchData",
                    method: "POST",
                    data: {monthID,yearID},
                    dataType: "json",
                    success: function(data) {
                            if(data.total!="undefined"){
                                $("#totals").html(numeral(data.total).format('0,000'));
                                $("#total_ny").html(numeral(data.amount_ny).format('0,000'));
                            }
 
                            $.ajax({
                                    url: "services/report/monly-report.php?fetch_chart",
                                    method: "POST",
                                    data: {monthID,yearID},
                                    dataType: "json",
                                    success: function(data1) {
                                        var amount_total=[];
                                        var rowMonth=[];
                                        var monthData=[];
                                        for (var count1 = 0; count1 < data1.length; count1++) {
                                            amount_total.push(parseFloat(data1[count1].sumTotal));
                                            rowMonth.push(parseFloat(data1[count1].list_bill_date));
                                            monthData.push(parseFloat(data1[count1].monthData));
                                        }
                                        // console.log(amount_total)
                                        var options = {
                                            series: [{
                                                name: 'ຍອດຂາຍ',
                                                data:amount_total,
                                            }],

                                            chart: {
                                                foreColor: '#000000',
                                                type: 'bar',
                                                height: 400
                                            },
                                            plotOptions: {
                                                bar: {
                                                    horizontal: false,
                                                    columnWidth: '20%',
                                                    endingShape: 'rounded'
                                                },
                                            },


                                            dataLabels: {
                                                enabled: true,
                                                formatter: function (val, opts) {
                                                    return numeral(val).format('0,00');
                                                },
                                                style: {
                                                    fontSize: '12px',
                                                    fontFamily: "LAOS",
                                                }
                                            },
                                            stroke: {
                                                show: true,
                                                width: 2,
                                                colors: ['transparent']
                                            },
                                            title: {
                                                text: 'ຍອດຂາຍປະຈໍາເດືອນ '+month_name,
                                                align: 'left',
                                                style: {
                                                    fontSize: '18px',
                                                    fontFamily: "LAOS",
                                                },
                                            },
                                            colors: ['#DB4900'],
                                            xaxis: {
                                                categories:monthData,
                                            },

                                            yaxis: {
                                                labels: {
                                                    show: true,
                                                    formatter: function(val) {
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
                                                    fontFamily: "LAOS",
                                                }
                                            },

                                        };
                                        
                                        var chart = new ApexCharts(document.querySelector("#chart44"), options);
                                        try{
                                            chart.destroy();
                                        }catch{
                                            chart = new ApexCharts(document.querySelector("#chart44"), options);
                                            chart.render();
                                        }
                                    }
                            });

                        }
                    })
                }
        </script>
</body>

</html>