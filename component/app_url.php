<?php
session_start();
class App{
    public function myapp(){
        date_default_timezone_set('Asia/Bangkok');
        if(@$_SESSION['myApp'] !='1'){
            include_once('login.php');        
        }else{
            if(isset($_REQUEST['main'])){
                include_once('app/staff/frm_main.php');
                exit;
            }elseif(isset($_REQUEST['menus'])){
                include_once('app/staff/frm_orders.php');
                exit;
            }elseif(isset($_REQUEST['cooks'])){
                include_once('app/staff/frm_cook.php');
                exit;
            }elseif(isset($_REQUEST['bars'])){
                include_once('app/staff/frm_bar.php');
                exit;
            }elseif(isset($_REQUEST['logout'])){
                include_once('logout.php');
                exit;
            }else{
                include_once('login.php');
                exit;
            }
        }
    }
}
?>