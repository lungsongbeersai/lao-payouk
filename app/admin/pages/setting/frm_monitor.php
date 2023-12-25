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
    <title>Frm_Cancel</title>
    <?php $packget_all->main_css(); ?>
    <style>
        .no {
            font-size: 16px !important;
            font-family: 'Times New Roman', Times, serif;
            margin: 5px;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        .order {
            margin: 10px;
        }

        .table-container {
            cursor: pointer !important;
        }

        .text {
            font-size: 18px !important;
        }

        img {
            width: 100%;
            min-height: 100%;
        }
    </style>
</head>

<body class="pace-done theme-dark">
    <div id="app" class="app app-content-full-height app-without-header app-without-sidebar bg-white">

        <div id="content" class="app-content p-0">

            <div class="pos pos-counter" id="pos-counter">

                <div class="pos-counter-body" style="margin-top: -50px !important;">
                    <div class="pos-counter-content">
                        <div class="pos-counter-content-container" data-scrollbar="true" data-height="100%" data-skip-mobile="true" style="background-color: white !important;">
                            <div class="splide">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <li class="splide__slide"><img src="https://media.timeout.com/images/105411691/image.jpg" alt=""></li>
                                        <li class="splide__slide"><img src="https://media.istockphoto.com/id/1162326322/vector/identity-business-corporate-souvenir-promotion-stationery-items-uniform-badges-packages-pen.jpg?s=1024x1024&w=is&k=20&c=L3DuVBrHuHkCOXvOzFHnhYV13vjEaapO37s1t45Jv7c=" alt=""></li>
                                    </ul>
                                </div>
                                <div class="my-slider-progress">
                                    <div class="my-slider-progress-bar"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pos-counter-sidebar shadow" id="pos-counter-sidebar">
                        <div class="pos-sidebar-header">
                            <div class="back-btn">
                                <button type="button" data-dismiss-class="pos-mobile-sidebar-toggled" data-target="#pos-counter" class="btn ">
                                    <svg viewBox="0 0 16 16" class="bi bi-chevron-left " fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="icon">
                                <i class="fa fa-fw fa-utensils fa-2x"></i>
                            </div>
                            <div class="title" style="font-size: 20px !important;">ເບີໂຕະ : <span class="title_table no1 text-red" style="font-size: 25px !important;"></span></div>
                            <div class="order">ເລກບິນ:<span class="order_bill"></span></div>
                        </div>
                        <div class="pos-sidebar-body">
                            <div class="pos-table pos_detail" data-id="pos-table-info">
                                <div style='width:100%'>
                                    <center>
                                        <img src='assets/img/logo/cart_empty.png' class="img-fluid w-500px" alt="Responsive image">
                                        <p>
                                        <h4 class="text-dark">
                                            ( ບໍ່ມີລາຍການ )
                                        </h4>
                                        </p>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="pos-sidebar-footer" style="margin-top: -30px !important;">
                            <div class="subtotal">
                                <div class="text">ລວມເປັນເງິນ : </div>
                                <div class="price amount_price no1" data-id="price-subtotal">0</div>
                            </div>
                            <div class="taxes">
                                <div class="text">ສ່ວນຫຼຸດລາຍການ : </div>
                                <div class="price percented_price no1" data-id="price-subtotal">0</div>
                            </div>
                            <div class="total">
                                <div class="text">ລວມເປັນເງິນທັງໝົດ : </div>
                                <div class="price total_price no1" data-id="price-subtotal">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    </div>

    <?php $packget_all->main_script(); ?>
    <script src="assets/js/service-all.js"></script>
    <script>
        socket.on('emit_get_monitorPY', (response) => {
            var table_no = response.table_no;
            var bill_no = response.bill_no;
            var usersid = response.usersid;
            var user_branch = response.user_branch;
            searchData();
        });

        function searchData() {
            $.ajax({
                url: "services/sql/service-monitor.php?fetch_monitor",
                method: "POST",
                dataType: "json",
                success: function(response) {
                    var html = ``;
                    var data = response.data;
                    var amount_price = 0;
                    var percented_price = 0;
                    var total_price = 0;
                    var discounted = 0;
                    var percenteds = "";
                    if (response.rowCount > 0) {
                        for (var count = 0; count < data.length; count++) {
                            if (data[count].order_list_discount_percented == "1") {
                                percenteds = data[count].order_list_discount_percented_name + "%=";
                            } else if (data[count].order_list_discount_percented == "2") {
                                percenteds = data[count].order_list_discount_price;
                            } else {
                                percenteds = "";
                            }

                            if (data[count].order_list_discount_status == "2") {
                                discounted = "<span class='text-danger'><u> " + percenteds + numeral(data[count].order_list_discount_price).format('0,000') + " ກີບ</u></span>";
                                totals = "<s class='text-danger'>" + numeral(data[count].order_list_order_total).format('0,000') + "</s><br>" + numeral(data[count].order_list_discount_total).format('0,000');
                            } else {
                                discounted = "_____";
                                totals = numeral(data[count].order_list_discount_total).format('0,000');
                            }
                            amount_price += data[count].order_list_order_total;
                            percented_price += data[count].order_list_discount_price;
                            total_price += data[count].order_list_discount_total;


                            html += `
                            <div class="row pos-table-row">
                                <div class="col-8">
                                    <div class="pos-product-thumb">
                                        <div class="img" style="background-image: url(../../api/images/product_home/${data[count].product_images})"></div>
                                        <div class="info">
                                            <div class="title">${data[count].product_name} ${data[count].size_name_la}</div>
                                            <div class="desc no1">[ ${data[count].order_list_order_qty}  x  ${numeral(data[count].order_list_pro_price).format('0,000')} ]</div>
                                            <div class="desc">- ສ່ວນຫຼຸດ : ${discounted}</div>
                                            <div class="desc">- ໝາຍເຫດ : ${data[count].order_list_note_remark}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 total-price font-bold no1">${totals} ₭</div>
                            </div>
                            `;
                            $(".title_table").text(data[count].table_name);
                            $(".order_bill").text(data[count].order_list_bill_fk);
                            // $("#bill_id").val(data[count].bill_convert);
                            // $("#table_id").val(data[count].table_convert);
                            // $("#bill_no").val(data[count].order_list_bill_fk);
                        }
                        $(".amount_price").text(numeral(amount_price).format('0,000'));
                        $(".percented_price").text(numeral(percented_price).format('0,000'));
                        $(".total_price").text(numeral(total_price).format('0,000'));
                    } else {
                        html += `
                            <div class="h-100 align-items-center justify-content-center text-center p-20" data-id="pos-table-empty">
                                <div style="margin-top:25% !important">
                                    <div class="mb-3">
                                        <svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                                            <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-dark">ບໍ່ມີລາຍການ</h4>
                                </div>
                            </div>
                        `;
                        $(".title_table").text("");
                        $(".order_bill").text("");
                        $(".amount_price").text("0");
                        $(".percented_price").text("0");
                        $(".total_price").text("0");
                    }

                    $(".pos_detail").html(html);
                }
            })
        }

        // document.addEventListener('DOMContentLoaded', function() {
        //     const splide = new Splide('#splide01', {
        //         isNavigation: true,
        //         fixedWidth: 100,
        //         pagination: false,
        //     });

        //     splide.mount();
        // });


        // var splide = new Splide('.splide');
        const splide = new Splide('.splide', {
            type: 'loop',
            drag: 'free',
            focus: 'center',
            autoplay: true,
            perPage: 1,
        });
        var bar = splide.root.querySelector('.my-carousel-progress-bar');

        // Updates the bar width whenever the carousel moves:
        splide.on('mounted move', function() {
            var end = splide.Components.Controller.getEnd() + 1;
            var rate = Math.min((splide.index + 1) / end, 1);
            bar.style.width = String(100 * rate) + '%';
        });

        splide.mount();
    </script>
</body>

</html>