<div id="header" class="app-header app-header-inverse">
    <div class="navbar-header">
        <a href="?main" class="navbar-brand">ຮ້ານອາຫານ <?php echo $_SESSION["store_name"]?></a>
        <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>


    <div class="navbar-nav">

        <div class="navbar-item navbar-user dropdown">
            <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                <?php
                    if($_SESSION["store_img"] !=""){
                        $images_store=$_SESSION["store_img"];
                    }else{
                        $images_store="002.png";
                    }
                ?>
                <img src="assets/img/store/<?php echo $images_store;?>" alt="" />
                <span>
                    <span class="d-none d-md-inline"><?php echo $_SESSION["users_name"]?></span>
                    <b class="caret"></b>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end me-1">
                <a href="#" class="dropdown-item">ປ່ຽນລະຫັດຜ່ານ <span class="badge bg-danger rounded-pill ms-auto pb-4px">2</span></a>
                <div class="dropdown-divider"></div>
                <a href="#" id="logout" class="dropdown-item">ອອກຈາກລະບົບ</a>
            </div>
        </div>
    </div>

</div>
