<?php 
    include_once('component/main_packget_all.php');
    $packget_all = new packget_all();
?>
<!DOCTYPE html>
<html lang="en" class="dark-mode">
<head>
    <title>Error Page</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app">
        <div class="error">
			<div class="error-code">404</div>
			<div class="error-content">
				<div class="error-message">ຜິດພາດ...</div>
				<div class="error-desc mb-4">
					ບໍ່ພົບໜ້າຕ່າງທີ່ທ່ານພະຍາຍາມຄົ້ນຫາ. <br />
				</div>
				<div>
					<a href="?main" class="btn btn-danger px-3"><i class="fas fa-arrow-alt-circle-left"></i> ກັບຄືນ</a>
				</div>
			</div>
		</div>
    </div>
    <?php $packget_all->main_script(); ?>
</body>

</html>