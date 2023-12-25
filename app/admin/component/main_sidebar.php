<?php 
    if(@$_SESSION["user_permission_fk"]==="202300000003"){
        include_once('pages/pos/frm-pos-table.php');
        exit;
    }else if(@$_SESSION["user_permission_fk"]==="202300000004"){
        echo "<script>window.location.replace('?cooks');</script>";
        exit;
    }else if(@$_SESSION["user_permission_fk"]==="202300000005"){
        echo "<script>window.location.replace('?bar');</script>";
        exit;
    }else{
?>
<div id="sidebar" class="app-sidebar">
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <div class="menu">
            <div class="menu-profile">
                <a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile" data-target="#appSidebarProfileMenu">
                    <div class="menu-profile-cover with-shadow"></div>
                    <div class="menu-profile-image">
                        <?php 
                            if($_SESSION["store_img"] !=""){
                                $images_store1=$_SESSION["store_img"];
                            }else{
                                $images_store1="002.png";
                            }
                        ?>
                        <img src="assets/img/store/<?php echo $images_store1;?>" alt="" />
                    </div>
                    <div class="menu-profile-info">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">ສາຂາລ໋ອກອິນ</div>
                        </div>
                        <small><?php echo $_SESSION["branch_name"]?></small>
                    </div>
                </a>
            </div>
            <?php 
                if(@$_SESSION["menuID"]==""){
                    $homeAcitve="active";
                }else{
                    if(@$_SESSION["menuID"]=="11"){
                        $homeAcitve="active";
                    }else{
                        $homeAcitve="";
                    }
                }
            ?>
            <div class="menu-item <?php echo $homeAcitve?>" onclick="functionActive('11','11','11')">
                <a href="?main" class="menu-link">
                    <div class="menu-icon">
                        <ion-icon name="home"></ion-icon>
                    </div>
                    <div class="menu-text">
                        ໜ້າຫຼັກ
                    </div>
                </a>
            </div>
            <div class="menu-item">
                <a href="#" onclick="window.open('?monitor_cus', 'mywindow', 'location=0,status=0,scrollbars=0,width=1200,height=800');" class="menu-link">
                    <div class="menu-icon">
                    <ion-icon name="desktop-outline"></ion-icon>
                    </div>
                    <div class="menu-text">
                        ໜ້າຈໍລູກຄ້າ
                    </div>
                </a>
            </div>
            <?php 
                $db = new DBConnection();
                $sqlmain=$db->fn_read_all("view_login_menus WHERE default_menu_user_fk='".$_SESSION["user_permission_fk"]."' AND default_menu_status='2' GROUP BY default_menu_main_fk ORDER BY main_order_by ASC ");
                foreach($sqlmain as $rowmain){
                    if(@$_SESSION["mainID"]==$rowmain["default_menu_main_fk"]){
                        $mainActive="active";
                    }else{
                        $mainActive="";
                    }
            ?>
                <div class="menu-item has-sub <?php echo $mainActive?>">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon">
                            <?php echo $rowmain["main_icon"];?>
                        </div>
                        <div class="menu-text">
                            <?php echo $rowmain["main_name"];?>
                        </div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <?php 
                            $sqlsub=$db->fn_read_all("view_login_menus WHERE default_menu_main_fk='".$rowmain["default_menu_main_fk"]."' AND default_menu_user_fk='".$rowmain["default_menu_user_fk"]."' AND default_menu_status='2' ORDER BY sub_order_by ASC ");
                            foreach($sqlsub as $rowsub){
                                if(@$_SESSION["menuID"]==$rowsub["default_menu_code"]){
                                    $subActive="active";
                                }else{
                                    $subActive="";
                                }
                        ?>
                        <div class="menu-item menu-active <?php echo $subActive?>" onclick="functionActive('<?php echo $rowsub['default_menu_code']?>','<?php echo $rowsub['default_menu_main_fk']?>','<?php echo $rowsub['default_menu_sub_fk']?>')">
                            <a href="<?php echo $rowsub["sub_link"]?>" class="menu-link">
                                <div class="menu-text"><?php echo $rowsub["sub_name"]?></div>
                            </a>
                        </div>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
            <div class="menu-item d-flex">
                <a href="javascript:;" class="app-sidebar-minify-btn ms-auto d-flex align-items-center text-decoration-none" data-toggle="app-sidebar-minify">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </div>
            <!-- <div class="menu-item">
                <a href="?move_menu" class="menu-link">
                    <div class="menu-icon">
                        <ion-icon name="home"></ion-icon>
                    </div>
                    <div class="menu-text">
                        ຍ້າຍມູນູອາຫານ
                    </div>
                </a>
            </div> -->

        </div>
    </div>
</div>
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop">
    <a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a>
</div>

<?php }?>

<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
