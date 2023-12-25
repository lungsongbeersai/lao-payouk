<?php 
// session_start();
$db = new DBConnection();
class packget_all{
    public function main_css(){
        include_once('main_css.php');
    }
    public function main_header(){
        include_once('main_header.php');
    }
    public function main_sidebar(){
        include_once('main_sidebar.php');
    }
    public function main_loadding(){
        include_once('main_loading.php');
    }
    public function main_script(){
        include_once('main_script.php');
    }
}

?>