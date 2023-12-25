<?php 
// include_once ('server/config/date_all.php');
// $db = new DBConnection();
class packget{
    public function app_css(){
        include_once('app_css.php');
    }
    public function app_loading(){
        include_once('app_loading.php');
    }
    public function app_header(){
        include_once('app_header.php');
    }
    public function app_menu(){
        include_once('app_menu.php');
    }
    public function app_script(){
        include_once('app_script.php');
    }
}

?>