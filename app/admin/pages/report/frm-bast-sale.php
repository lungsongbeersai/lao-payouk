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
    <title>Bast sale</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified() ?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <form action="services/print-excel/print-bast-sale-report.php" target="_bank" method="POST">
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
                    <i class="fas fa-file-alt"></i> ລາຍງານສິນຄ້າຂາຍດີ
                </h4>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ວັນທີ່ຂາຍ ວ/ດ/ປ</label>
                                <input type="date" class="form-control input_color" id="start_date" name="start_date" value="<?php echo date("Y-m-d") ?>">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ຫາວັນທີ່ ວ/ດ/ປ</label>
                                <input type="date" class="form-control input_color" id="end_date" name="end_date" value="<?php echo date("Y-m-d") ?>">
                            </div>
                            <div class="col-md-2 mb-2" hidden>
                                <label for="" class="mb-1">ຊື່ຮ້ານ</label>
                                <div class="form-group">
                                    <select name="search_store" id="search_store" class="form-select search_store" required onchange="res_searchBranch('search_store')">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ຊື່ສາຂາ</label>
                                <div class="form-group">
                                    <select name="search_branch" id="search_branch" class="form-select search_branch">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ປະເພດສິນຄ້າ</label>
                                <select name="type_cate" id="type_cate" class="form-select type_cate">
                                    <option value="">ທັງໝົດ</option>
                                    <option value="1">ອາຫານ</option>
                                    <option value="2">ເຄື່ອງດຶ່ມ</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="" class="mb-1">ລຽງຕາມ</label>
                                <select name="orderBy" id="orderBy" class="form-select orderBy">
                                    <option value="1">ຈໍານວນ</option>
                                    <option value="2">ຍອດເງິນ</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="" class="mb-1">ເລກບິນ/ເບີໂຕະ</label>
                                <div class="input-group">
                                    <input type="text" id="search_page" name="search_page" class="form-control input_color" placeholder="Search...">
                                    <button type="button" class="btn btn-primary search" onclick="SearchData()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-inverse">
                    <div class="panel-body px-0" style="margin-top:-16px;">

                        <!-- <table>
                            <thead>
                                <tr class="red">
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Job</th>
                                    <th>Color</th>
                                    <th>URL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Lorem.</td>
                                    <td>Ullam.</td>
                                    <td>Vel.</td>
                                    <td>At.</td>
                                    <td>Quis.</td>
                                </tr>
                                <tr>
                                    <td>Quas!</td>
                                    <td>Velit.</td>
                                    <td>Quisquam?</td>
                                    <td>Rerum?</td>
                                    <td>Iusto?</td>
                                </tr>
                                <tr>
                                    <td>Voluptates!</td>
                                    <td>Fugiat?</td>
                                    <td>Alias.</td>
                                    <td>Doloribus.</td>
                                    <td>Veritatis.</td>
                                </tr>
                                <tr>
                                    <td>Maiores.</td>
                                    <td>Ab.</td>
                                    <td>Accusantium.</td>
                                    <td>Ullam!</td>
                                    <td>Eveniet.</td>
                                </tr>
                                <tr>
                                    <td>Hic.</td>
                                    <td>Id!</td>
                                    <td>Officiis.</td>
                                    <td>Modi!</td>
                                    <td>Obcaecati.</td>
                                </tr>
                                <tr>
                                    <td>Soluta.</td>
                                    <td>Ad!</td>
                                    <td>Impedit.</td>
                                    <td>Alias!</td>
                                    <td>Ad.</td>
                                </tr>
                                <tr>
                                    <td>Expedita.</td>
                                    <td>Quo.</td>
                                    <td>Exercitationem!</td>
                                    <td>Optio?</td>
                                    <td>Ipsum?</td>
                                </tr>
                                <tr>
                                    <td>Commodi!</td>
                                    <td>Rem.</td>
                                    <td>Aspernatur.</td>
                                    <td>Accusantium!</td>
                                    <td>Maiores.</td>
                                </tr>
                                <tr>
                                    <td>Omnis.</td>
                                    <td>Cumque?</td>
                                    <td>Eveniet!</td>
                                    <td>Mollitia?</td>
                                    <td>Vero.</td>
                                </tr>
                                <tr>
                                    <td>Error!</td>
                                    <td>Inventore.</td>
                                    <td>Quasi!</td>
                                    <td>Ducimus.</td>
                                    <td>Repudiandae!</td>
                                </tr>
                                <tr>
                                    <td>Dolores!</td>
                                    <td>Necessitatibus.</td>
                                    <td>Corrupti!</td>
                                    <td>Eum.</td>
                                    <td>Sunt!</td>
                                </tr>
                                <tr>
                                    <td>Ea.</td>
                                    <td>Culpa?</td>
                                    <td>Quam?</td>
                                    <td>Nemo!</td>
                                    <td>Sit!</td>
                                </tr>
                                <tr>
                                    <td>Veritatis!</td>
                                    <td>Facilis.</td>
                                    <td>Expedita?</td>
                                    <td>Ipsam!</td>
                                    <td>Omnis!</td>
                                </tr>
                                <tr>
                                    <td>Vitae.</td>
                                    <td>Cumque.</td>
                                    <td>Repudiandae.</td>
                                    <td>Ut?</td>
                                    <td>Sed!</td>
                                </tr>
                                <tr>
                                    <td>Accusantium.</td>
                                    <td>Adipisci.</td>
                                    <td>Sit.</td>
                                    <td>Maxime.</td>
                                    <td>Harum.</td>
                                </tr>
                                <tr class="green">
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Job</th>
                                    <th>Color</th>
                                    <th>URL</th>
                                </tr>
                                <tr>
                                    <td>Qui!</td>
                                    <td>Accusamus?</td>
                                    <td>Minima?</td>
                                    <td>Dolorum.</td>
                                    <td>Molestiae.</td>
                                </tr>
                                <tr>
                                    <td>Vero!</td>
                                    <td>Voluptatum?</td>
                                    <td>Ea?</td>
                                    <td>Odit!</td>
                                    <td>A.</td>
                                </tr>
                                <tr>
                                    <td>Debitis.</td>
                                    <td>Veniam.</td>
                                    <td>Fuga.</td>
                                    <td>Alias!</td>
                                    <td>Recusandae!</td>
                                </tr>
                                <tr>
                                    <td>Aperiam!</td>
                                    <td>Dolorum.</td>
                                    <td>Enim.</td>
                                    <td>Sapiente!</td>
                                    <td>Suscipit?</td>
                                </tr>
                                <tr>
                                    <td>Consequuntur.</td>
                                    <td>Doloremque.</td>
                                    <td>Illum!</td>
                                    <td>Iste!</td>
                                    <td>Sint!</td>
                                </tr>
                                <tr>
                                    <td>Facilis.</td>
                                    <td>Error.</td>
                                    <td>Fugiat.</td>
                                    <td>At.</td>
                                    <td>Modi?</td>
                                </tr>
                                <tr>
                                    <td>Voluptatibus!</td>
                                    <td>Alias.</td>
                                    <td>Eaque.</td>
                                    <td>Cum.</td>
                                    <td>Ducimus!</td>
                                </tr>
                                <tr>
                                    <td>Nihil.</td>
                                    <td>Enim.</td>
                                    <td>Earum?</td>
                                    <td>Nobis?</td>
                                    <td>Eveniet.</td>
                                </tr>
                                <tr>
                                    <td>Eum!</td>
                                    <td>Id?</td>
                                    <td>Molestiae.</td>
                                    <td>Velit.</td>
                                    <td>Minima.</td>
                                </tr>
                                <tr>
                                    <td>Sapiente?</td>
                                    <td>Neque.</td>
                                    <td>Obcaecati!</td>
                                    <td>Earum.</td>
                                    <td>Esse.</td>
                                </tr>
                                <tr>
                                    <td>Nam?</td>
                                    <td>Ipsam!</td>
                                    <td>Provident.</td>
                                    <td>Ullam.</td>
                                    <td>Quae?</td>
                                </tr>
                                <tr>
                                    <td>Amet!</td>
                                    <td>In.</td>
                                    <td>Officia!</td>
                                    <td>Natus?</td>
                                    <td>Tempore?</td>
                                </tr>
                                <tr>
                                    <td>Consequatur.</td>
                                    <td>Hic.</td>
                                    <td>Officia.</td>
                                    <td>Itaque?</td>
                                    <td>Quasi.</td>
                                </tr>
                                <tr>
                                    <td>Enim.</td>
                                    <td>Tenetur.</td>
                                    <td>Asperiores?</td>
                                    <td>Eos!</td>
                                    <td>Libero.</td>
                                </tr>
                                <tr>
                                    <td>Exercitationem.</td>
                                    <td>Quidem!</td>
                                    <td>Beatae?</td>
                                    <td>Adipisci?</td>
                                    <td>Accusamus.</td>
                                </tr>
                                <tr>
                                    <td>Omnis.</td>
                                    <td>Accusamus?</td>
                                    <td>Eius!</td>
                                    <td>Recusandae!</td>
                                    <td>Dolor.</td>
                                </tr>
                                <tr>
                                    <td>Magni.</td>
                                    <td>Temporibus!</td>
                                    <td>Odio!</td>
                                    <td>Odit!</td>
                                    <td>Voluptatum?</td>
                                </tr>
                                <tr>
                                    <td>Eum.</td>
                                    <td>Animi!</td>
                                    <td>Labore.</td>
                                    <td>Alias!</td>
                                    <td>Fuga.</td>
                                </tr>
                                <tr>
                                    <td>Quia!</td>
                                    <td>Quis.</td>
                                    <td>Neque?</td>
                                    <td>Illo.</td>
                                    <td>Ad.</td>
                                </tr>
                                <tr>
                                    <td>Officiis.</td>
                                    <td>Exercitationem!</td>
                                    <td>Adipisci?</td>
                                    <td>Officiis?</td>
                                    <td>In?</td>
                                </tr>
                                <tr>
                                    <td>Voluptates?</td>
                                    <td>Voluptatum.</td>
                                    <td>Nihil.</td>
                                    <td>Totam?</td>
                                    <td>Quisquam!</td>
                                </tr>
                                <tr>
                                    <td>Soluta.</td>
                                    <td>Tempore!</td>
                                    <td>Cupiditate.</td>
                                    <td>Beatae.</td>
                                    <td>Perspiciatis.</td>
                                </tr>
                                <tr>
                                    <td>Porro.</td>
                                    <td>Officia?</td>
                                    <td>Error.</td>
                                    <td>Culpa?</td>
                                    <td>Fugit.</td>
                                </tr>
                                <tr>
                                    <td>Et?</td>
                                    <td>Nemo.</td>
                                    <td>Nisi?</td>
                                    <td>Totam!</td>
                                    <td>Voluptate.</td>
                                </tr>
                                <tr>
                                    <td>Saepe?</td>
                                    <td>Vero.</td>
                                    <td>Amet?</td>
                                    <td>Illo!</td>
                                    <td>Laborum!</td>
                                </tr>
                                <tr class="purple">
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Job</th>
                                    <th>Color</th>
                                    <th>URL</th>
                                </tr>
                                <tr>
                                    <td>Atque!</td>
                                    <td>Tenetur.</td>
                                    <td>Optio.</td>
                                    <td>Iure.</td>
                                    <td>Porro.</td>
                                </tr>
                                <tr>
                                    <td>Atque.</td>
                                    <td>Alias.</td>
                                    <td>Doloremque.</td>
                                    <td>Velit.</td>
                                    <td>Culpa.</td>
                                </tr>
                                <tr>
                                    <td>Placeat?</td>
                                    <td>Necessitatibus.</td>
                                    <td>Voluptate!</td>
                                    <td>Possimus.</td>
                                    <td>Nam?</td>
                                </tr>
                                <tr>
                                    <td>Illum!</td>
                                    <td>Quae.</td>
                                    <td>Expedita!</td>
                                    <td>Omnis.</td>
                                    <td>Nam.</td>
                                </tr>
                                <tr>
                                    <td>Consequuntur!</td>
                                    <td>Consectetur!</td>
                                    <td>Provident!</td>
                                    <td>Consequuntur!</td>
                                    <td>Distinctio.</td>
                                </tr>
                                <tr>
                                    <td>Aperiam!</td>
                                    <td>Voluptatem.</td>
                                    <td>Cupiditate!</td>
                                    <td>Quae.</td>
                                    <td>Praesentium.</td>
                                </tr>
                                <tr>
                                    <td>Possimus?</td>
                                    <td>Qui.</td>
                                    <td>Consequuntur.</td>
                                    <td>Deleniti.</td>
                                    <td>Voluptas.</td>
                                </tr>
                                <tr>
                                    <td>Hic?</td>
                                    <td>Ab.</td>
                                    <td>Asperiores?</td>
                                    <td>Omnis.</td>
                                    <td>Animi!</td>
                                </tr>
                                <tr>
                                    <td>Cupiditate.</td>
                                    <td>Velit.</td>
                                    <td>Libero.</td>
                                    <td>Iste.</td>
                                    <td>Dicta?</td>
                                </tr>
                                <tr>
                                    <td>Consequatur!</td>
                                    <td>Nobis.</td>
                                    <td>Aperiam!</td>
                                    <td>Odio.</td>
                                    <td>Nemo!</td>
                                </tr>
                                <tr>
                                    <td>Dolorem.</td>
                                    <td>Distinctio?</td>
                                    <td>Provident?</td>
                                    <td>Nisi!</td>
                                    <td>Impedit?</td>
                                </tr>
                                <tr>
                                    <td>Accusantium?</td>
                                    <td>Ea.</td>
                                    <td>Doloribus.</td>
                                    <td>Nobis.</td>
                                    <td>Maxime?</td>
                                </tr>
                                <tr>
                                    <td>Molestiae.</td>
                                    <td>Rem?</td>
                                    <td>Enim!</td>
                                    <td>Maxime?</td>
                                    <td>Reiciendis!</td>
                                </tr>
                                <tr>
                                    <td>Commodi.</td>
                                    <td>At.</td>
                                    <td>Earum?</td>
                                    <td>Fugit.</td>
                                    <td>Maxime?</td>
                                </tr>
                                <tr>
                                    <td>Eligendi?</td>
                                    <td>Quis.</td>
                                    <td>Error?</td>
                                    <td>Atque.</td>
                                    <td>Perferendis.</td>
                                </tr>
                                <tr>
                                    <td>Quidem.</td>
                                    <td>Odit!</td>
                                    <td>Tempore.</td>
                                    <td>Voluptates.</td>
                                    <td>Facere!</td>
                                </tr>
                                <tr>
                                    <td>Repudiandae!</td>
                                    <td>Accusamus?</td>
                                    <td>Soluta.</td>
                                    <td>Incidunt.</td>
                                    <td>Aliquid?</td>
                                </tr>
                                <tr>
                                    <td>Quisquam?</td>
                                    <td>Eius.</td>
                                    <td>Obcaecati?</td>
                                    <td>Maxime.</td>
                                    <td>Nihil.</td>
                                </tr>
                                <tr>
                                    <td>Minus.</td>
                                    <td>Magni?</td>
                                    <td>Necessitatibus?</td>
                                    <td>Asperiores.</td>
                                    <td>Iure.</td>
                                </tr>
                                <tr>
                                    <td>Ipsa!</td>
                                    <td>Temporibus.</td>
                                    <td>Non!</td>
                                    <td>Dolore.</td>
                                    <td>Veritatis.</td>
                                </tr>
                                <tr>
                                    <td>Ea!</td>
                                    <td>Officia?</td>
                                    <td>Doloribus?</td>
                                    <td>Deleniti?</td>
                                    <td>Dolorem!</td>
                                </tr>
                                <tr>
                                    <td>Sequi?</td>
                                    <td>Molestias!</td>
                                    <td>Nesciunt.</td>
                                    <td>Qui.</td>
                                    <td>Doloribus?</td>
                                </tr>
                                <tr>
                                    <td>Id.</td>
                                    <td>Enim?</td>
                                    <td>Quam!</td>
                                    <td>Sunt!</td>
                                    <td>Consequuntur.</td>
                                </tr>
                                <tr>
                                    <td>Reprehenderit?</td>
                                    <td>Ut?</td>
                                    <td>Veritatis!</td>
                                    <td>Corporis!</td>
                                    <td>Ipsa.</td>
                                </tr>
                                <tr>
                                    <td>Blanditiis!</td>
                                    <td>Veniam!</td>
                                    <td>Tenetur.</td>
                                    <td>Eos?</td>
                                    <td>Repellat!</td>
                                </tr>
                                <tr>
                                    <td>Enim?</td>
                                    <td>Atque!</td>
                                    <td>Aspernatur?</td>
                                    <td>Fugit.</td>
                                    <td>Voluptatibus!</td>
                                </tr>
                                <tr>
                                    <td>Nihil.</td>
                                    <td>Distinctio!</td>
                                    <td>Aut!</td>
                                    <td>Rerum!</td>
                                    <td>Dolorem?</td>
                                </tr>
                                <tr>
                                    <td>Inventore!</td>
                                    <td>Hic.</td>
                                    <td>Explicabo.</td>
                                    <td>Sit.</td>
                                    <td>A.</td>
                                </tr>
                                <tr>
                                    <td>Inventore.</td>
                                    <td>A.</td>
                                    <td>Nam.</td>
                                    <td>Beatae.</td>
                                    <td>Consequatur.</td>
                                </tr>
                                <tr>
                                    <td>Eligendi.</td>
                                    <td>Illum.</td>
                                    <td>Enim?</td>
                                    <td>Dignissimos!</td>
                                    <td>Ducimus?</td>
                                </tr>
                                <tr>
                                    <td>Eligendi!</td>
                                    <td>Fugiat?</td>
                                    <td>Deleniti!</td>
                                    <td>Rerum?</td>
                                    <td>Delectus?</td>
                                </tr>
                                <tr>
                                    <td>Sit.</td>
                                    <td>Nam.</td>
                                    <td>Eveniet?</td>
                                    <td>Veritatis.</td>
                                    <td>Adipisci!</td>
                                </tr>
                                <tr>
                                    <td>Nostrum?</td>
                                    <td>Totam?</td>
                                    <td>Voluptates!</td>
                                    <td>Ab!</td>
                                    <td>Consequatur.</td>
                                </tr>
                                <tr>
                                    <td>Error!</td>
                                    <td>Dicta?</td>
                                    <td>Voluptatum?</td>
                                    <td>Corporis!</td>
                                    <td>Ea.</td>
                                </tr>
                                <tr>
                                    <td>Vel.</td>
                                    <td>Asperiores.</td>
                                    <td>Facere.</td>
                                    <td>Quae.</td>
                                    <td>Fugiat.</td>
                                </tr>
                                <tr>
                                    <td>Libero?</td>
                                    <td>Molestias.</td>
                                    <td>Praesentium!</td>
                                    <td>Accusantium!</td>
                                    <td>Tenetur.</td>
                                </tr>
                                <tr>
                                    <td>Eveniet.</td>
                                    <td>Quam.</td>
                                    <td>Quibusdam.</td>
                                    <td>Eaque?</td>
                                    <td>Dolore!</td>
                                </tr>
                                <tr>
                                    <td>Asperiores.</td>
                                    <td>Impedit.</td>
                                    <td>Ullam?</td>
                                    <td>Quod.</td>
                                    <td>Placeat.</td>
                                </tr>
                                <tr>
                                    <td>In?</td>
                                    <td>Aliquid.</td>
                                    <td>Voluptatum!</td>
                                    <td>Omnis?</td>
                                    <td>Magni.</td>
                                </tr>
                                <tr>
                                    <td>Autem.</td>
                                    <td>Earum!</td>
                                    <td>Debitis!</td>
                                    <td>Eius.</td>
                                    <td>Incidunt.</td>
                                </tr>
                                <tr>
                                    <td>Blanditiis?</td>
                                    <td>Impedit.</td>
                                    <td>Libero?</td>
                                    <td>Reiciendis!</td>
                                    <td>Tempore.</td>
                                </tr>
                                <tr>
                                    <td>Quasi.</td>
                                    <td>Reiciendis.</td>
                                    <td>Aut?</td>
                                    <td>Architecto?</td>
                                    <td>Vero!</td>
                                </tr>
                                <tr>
                                    <td>Fuga!</td>
                                    <td>Illum!</td>
                                    <td>Tenetur!</td>
                                    <td>Vitae.</td>
                                    <td>Natus.</td>
                                </tr>
                                <tr>
                                    <td>Dolorem?</td>
                                    <td>Eaque!</td>
                                    <td>Vero?</td>
                                    <td>Quibusdam.</td>
                                    <td>Deleniti?</td>
                                </tr>
                                <tr>
                                    <td>Minus.</td>
                                    <td>Accusantium?</td>
                                    <td>Ab.</td>
                                    <td>Cupiditate.</td>
                                    <td>Atque?</td>
                                </tr>
                                <tr>
                                    <td>Hic.</td>
                                    <td>Eligendi.</td>
                                    <td>Sit?</td>
                                    <td>Nihil.</td>
                                    <td>Dolor.</td>
                                </tr>
                                <tr>
                                    <td>Quidem.</td>
                                    <td>In?</td>
                                    <td>Nesciunt?</td>
                                    <td>Adipisci.</td>
                                    <td>Neque.</td>
                                </tr>
                                <tr>
                                    <td>Eos.</td>
                                    <td>Incidunt!</td>
                                    <td>Quis?</td>
                                    <td>Quod?</td>
                                    <td>Vitae!</td>
                                </tr>
                                <tr>
                                    <td>Ullam!</td>
                                    <td>Facilis.</td>
                                    <td>Tempora!</td>
                                    <td>Accusantium.</td>
                                    <td>Consequuntur?</td>
                                </tr>
                                <tr>
                                    <td>Numquam?</td>
                                    <td>At.</td>
                                    <td>Incidunt.</td>
                                    <td>Tenetur?</td>
                                    <td>Voluptatem.</td>
                                </tr>
                                <tr>
                                    <td>Iusto?</td>
                                    <td>Inventore.</td>
                                    <td>Molestias.</td>
                                    <td>Accusantium.</td>
                                    <td>Sunt.</td>
                                </tr>
                                <tr>
                                    <td>Repellendus!</td>
                                    <td>Ex.</td>
                                    <td>Magnam.</td>
                                    <td>Odit!</td>
                                    <td>Iste?</td>
                                </tr>
                                <tr>
                                    <td>Id!</td>
                                    <td>Reiciendis?</td>
                                    <td>Rem.</td>
                                    <td>Quae!</td>
                                    <td>Laborum?</td>
                                </tr>
                                <tr>
                                    <td>Exercitationem?</td>
                                    <td>Maiores.</td>
                                    <td>Minima.</td>
                                    <td>Nemo!</td>
                                    <td>Sequi.</td>
                                </tr>
                                <tr>
                                    <td>Qui.</td>
                                    <td>Impedit?</td>
                                    <td>Reprehenderit.</td>
                                    <td>Distinctio.</td>
                                    <td>Natus?</td>
                                </tr>
                                <tr>
                                    <td>Suscipit!</td>
                                    <td>Tenetur.</td>
                                    <td>Cumque!</td>
                                    <td>Molestiae.</td>
                                    <td>Fugiat?</td>
                                </tr>
                                <tr>
                                    <td>Sunt?</td>
                                    <td>Quis?</td>
                                    <td>Officia.</td>
                                    <td>Incidunt.</td>
                                    <td>Voluptate.</td>
                                </tr>
                                <tr>
                                    <td>Possimus.</td>
                                    <td>Mollitia!</td>
                                    <td>Eveniet!</td>
                                    <td>Temporibus.</td>
                                    <td>Mollitia!</td>
                                </tr>
                                <tr>
                                    <td>Incidunt.</td>
                                    <td>Fugiat.</td>
                                    <td>Error.</td>
                                    <td>Odit.</td>
                                    <td>Cumque?</td>
                                </tr>
                                <tr>
                                    <td>Maxime?</td>
                                    <td>Qui!</td>
                                    <td>Sapiente!</td>
                                    <td>Natus.</td>
                                    <td>Soluta?</td>
                                </tr>
                            </tbody>
                        </table> -->

                        <div class="table-responsive table-responsive1">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="th_center" style="width:80px">ລໍາດັບ</th>
                                        <th>ສາຂາ</th>
                                        <th>ປະເພດ</th>
                                        <th>ຊື່ອາຫານ ຫຼື ເຄື່ອງດຶ່ມ</th>
                                        <th class="th_center">ລາຄາ</th>
                                        <th class="th_center">ຈໍານວນ</th>
                                        <th class="th_center">ຍອດລວມ</th>
                                    </tr>
                                </thead>
                                <tbody class="table-bordered-y text-nowrap">

                                </tbody>
                            </table>
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
        res_storeSearch('search_store');
        res_store('branch_store');
        SearchData(1);

        function SearchData(page = "1") {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var type_cate = $("#type_cate").val();
            var search_branch = $("#search_branch").val();
            var search_page = $("#search_page").val();
            var orderBy = $("#orderBy").val();
            $.ajax({
                url: "services/report/bast-sale-report.php?report",
                method: "POST",
                data: {
                    page,
                    start_date,
                    end_date,
                    type_cate,
                    search_page,
                    orderBy,
                    search_branch
                },
                dataType:"json",
                success: function(response) {
                    console.log("rowCount:",response.rowCount);
                    var rowCount = response.rowCount;
                    var html=``;
                    var totalQty=0;
                    var totalPrice=0;
                    i=1;
                    if(rowCount>0){
                        for (var count = 0; count < response.data.length; count++) {
                            var rowData = response.data[count];
                            totalQty+=parseFloat(rowData.sumQty);
                            totalPrice+=parseFloat(rowData.amounts);
                            html +=`
                                <tr>
                                    <td align="center">${i++}</td>
                                    <td>${rowData.branch_name}</td>
                                    <td>${rowData.group_name}</td>
                                    <td>${rowData.fullProname}</td>
                                    <td align="right">${numeral(rowData.check_bill_list_pro_price).format('0,000')}</td>
                                    <td align="right">${numeral(rowData.sumQty).format('0,000')}</td>
                                    <td align="right">${numeral(rowData.amounts).format('0,000')}</td>
                                </tr>
                            `;
                        }
                        html+=`
                            <tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;position:sticky;bottom: 0;width: 94%">
                                <td colspan="5" align="right" style="width:1140px">ລວມທັງໝົດ</td>
                                <td align="right" style="width:124px">${numeral(totalQty).format('0,000')}</td>
                                <td align="right" style="width:180px">${numeral(totalPrice).format('0,000')}</td>
                            <tr>
                        `;
                    }else{
                       html+=`
                       <tr>
                            <td colspan="7" align="center" style="padding:140px;color:red">
                                <i class="fas fa-times-circle fa-3x"></i><br>
                                ບໍ່ພົບລາຍການ
                            </td>
                        </tr>
                       `;
                    }

                    $("tbody").html(html);
                }
            })
        }
    </script>
</body>

</html>