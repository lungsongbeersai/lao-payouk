<?php
session_start();
class Page{
    public function mypage(){
        date_default_timezone_set('Asia/Bangkok');
        include_once('services/config/db.php');
        if (@$_SESSION['myApp'] != '1') {
            echo "<script>location.href='../../?logout';</script>";
            exit;
        } else {
            if (isset($_REQUEST['main'])) {
                include_once('pages/main/main.php');
                exit;
            }elseif (isset($_REQUEST['company'])) {
                include_once('pages/setting/frm-companyinfo.php');
                exit;
            }elseif (isset($_REQUEST['branch'])) {
                include_once('pages/setting/frm-branch-list.php');
                exit;
            }elseif (isset($_REQUEST['custommer'])) {
                include_once('pages/setting/frm-custommer-list.php');
                exit;
            }elseif (isset($_REQUEST['rate_exchange'])) {
                include_once('pages/setting/frm-rate-exchange.php');
                exit;
            } elseif (isset($_REQUEST['group-large'])) {
                include_once('pages/setting/frm-group-large.php');
                exit;
            } elseif (isset($_REQUEST['category'])) {
                include_once('pages/setting/frm-category.php');
                exit;
            }elseif (isset($_REQUEST['zone'])) {
                include_once('pages/setting/frm-zone.php');
                exit;
            }elseif (isset($_REQUEST['table-list'])) {
                include_once('pages/setting/frm-table-list.php');
                exit;
            }elseif (isset($_REQUEST['unite'])) {
                include_once('pages/setting/frm-unite.php');
                exit;
            }elseif (isset($_REQUEST['colors'])) {
                include_once('pages/setting/frm-colors.php');
                exit;
            }elseif (isset($_REQUEST['add_product'])) {
                include_once('pages/products/frm-add-product.php');
                exit;
            }elseif (isset($_REQUEST['product_list'])) {
                include_once('pages/products/frm-product-list.php');
                exit;
            }elseif (isset($_REQUEST['table_list'])) {
                include_once('pages/pos/frm-pos-table.php');
                exit;
            }elseif (isset($_REQUEST['pos'])) {
                include_once('pages/pos/frm-pos-sale.php');
                exit;
            }elseif (isset($_REQUEST['cooks'])) {
                include_once('pages/pos/frm-pos-cook.php');
                exit;
            }elseif (isset($_REQUEST['bar'])) {
                include_once('pages/pos/frm-pos-bar.php');
                exit;
            }elseif(isset($_REQUEST['previewBill'])) {
                include_once('pages/print/frm-preview-bill.php');
                exit;
            }elseif(isset($_REQUEST['checkBill'])) {
                include_once('pages/print/frm-check-bill.php');
                exit;
            }elseif(isset($_REQUEST['dailyReport'])) {
                include_once('pages/report/frm-daily-report.php');
                exit;
            }elseif(isset($_REQUEST['monthlyReport'])) {
                include_once('pages/report/frm-monthly-report.php');
                exit;
            }elseif(isset($_REQUEST['bast-sale'])) {
                include_once('pages/report/frm-bast-sale.php');
                exit;
            }elseif(isset($_REQUEST['count-stock'])) {
                include_once('pages/report/frm-count-stock.php');
                exit;
            }elseif(isset($_REQUEST['permission'])) {
                include_once('pages/setting/frm-permission.php');
                exit;
            }elseif(isset($_REQUEST['userlogin'])) {
                include_once('pages/setting/frm-userlogin.php');
                exit;
            }elseif(isset($_REQUEST['order-item'])) {
                include_once('pages/setting/frm-orders-item.php');
                exit;
            }elseif(isset($_REQUEST['receive'])) {
                include_once('pages/setting/frm-receive.php');
                exit;
            }elseif(isset($_REQUEST['ny_list'])) {
                include_once('pages/setting/frm-ny-list.php');
                exit;
            }elseif(isset($_REQUEST['cancel_list'])) {
                include_once('pages/report/frm-cancel-list.php');
                exit;
            }elseif(isset($_REQUEST['promotion'])) {
                include_once('pages/setting/frm-promotion.php');
                exit;
            }elseif(isset($_REQUEST['expenses'])) {
                include_once('pages/setting/frm-expenses.php');
                exit;
            }elseif(isset($_REQUEST['edit_pos'])) {
                include_once('pages/pos/frm-edit-pos-sale.php');
                exit;
            }elseif(isset($_REQUEST['print_edit'])) {
                include_once('pages/print/frm-check-bill-edit.php');
                exit;
            }elseif(isset($_REQUEST['print_debt'])) {
                include_once('pages/print/frm-print-debt.php');
                exit;
            }elseif(isset($_REQUEST['print_Preview'])) {
                include_once('pages/print/frm-print-Preview.php');
                exit;
            }elseif(isset($_REQUEST['pay_debt'])) {
                include_once('pages/setting/frm-pay-debt.php');
                exit;
            }
            elseif(isset($_REQUEST['move_menu'])) {
                include_once('pages/move/frm-move-menu.php');
                exit;
            }elseif(isset($_REQUEST['confirmOrders'])) {
                include_once('pages/print/frm-confirm-orders.php');
                exit;
            }elseif(isset($_REQUEST['printer_setting'])) {
                include_once('pages/setting/frm-printer.php');
                exit;
            }elseif(isset($_REQUEST['printer_setting'])) {
                include_once('pages/setting/frm-printer.php');
                exit;
            }elseif(isset($_REQUEST['bill_edit'])) {
                include_once('pages/setting/frm-edit-bill.php');
                exit;
            } elseif(isset($_REQUEST['cancel'])) {
                include_once('pages/setting/frm-cancel.php');
                exit;
            }elseif(isset($_REQUEST['report_debt'])) {
                include_once('pages/report/frm-pay-debt-list.php');
                exit;
            }elseif(isset($_REQUEST['history_cancel'])) {
                include_once('pages/report/frm-history-cancel.php');
                exit;
            }elseif(isset($_REQUEST['monitor_cus'])) {
                include_once('pages/setting/frm_monitor.php');
                exit;
            }
            elseif(isset($_REQUEST['logout'])) {
                echo "<script>location.href='../../?logout';</script>";
                exit;
            }else {
                echo "<script>location.href='../../?logout';</script>";
                exit;
            }
        }
    }
}?>
