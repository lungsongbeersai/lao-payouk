<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if (isset($_GET["loadTableList"])) {

    if($_POST["pagesLoad"]=="1"){
        $where="WHERE table_status='".$_POST["pagesLoad"]."'";
    }elseif($_POST["pagesLoad"]=="2"){
        $where="WHERE table_status='".$_POST["pagesLoad"]."'";
    }elseif($_POST["pagesLoad"]=="3"){
        $where="";
    }else{
        $where="WHERE table_zone_fk='".$_POST["pagesLoad"]."'";
    }

    $sql="res_tables AS A LEFT JOIN res_zone AS B ON A.table_zone_fk=B.zone_code $where";
    $sqlRow=$db->fn_read_all($sql);
    foreach($sqlRow as $rowCount){
?>
    <div class="table in-use">
        <a href="#" class="table-container" data-toggle="select-table">
            <div class="table-status"></div>
            <div class="table-name">
                <div class="name">Table</div>
                <div class="no">1</div>
                <div class="order"><span>9 orders</span></div>
            </div>
            <div class="table-info-row">
                <div class="table-info-col">
                    <div class="table-info-container">
                        <span class="icon">
                            <i class="far fa-user"></i>
                        </span>
                        <span class="text">4 / 4</span>
                    </div>
                </div>
                <div class="table-info-col">
                    <div class="table-info-container">
                        <span class="icon">
                            <i class="far fa-clock"></i>
                        </span>
                        <span class="text">35:20</span>
                    </div>
                </div>
            </div>
            <div class="table-info-row">
                <div class="table-info-col">
                    <div class="table-info-container">
                        <span class="icon">
                            <i class="fa fa-hand-point-up"></i>
                        </span>
                        <span class="text">$318.20</span>
                    </div>
                </div>
                <div class="table-info-col">
                    <div class="table-info-container">
                        <span class="icon">
                            <i class="fa fa-dollar-sign"></i>
                        </span>
                        <span class="text">Unpaid</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php }?>
<?php }?>