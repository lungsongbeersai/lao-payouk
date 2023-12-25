<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    
    if(isset($_GET["bill_list"])){
        $limit = $_POST["limit"];
        $page = 1;
        if (@$_POST['page'] > 1) {
            $start = (($_POST['page'] - 1) * $limit);
            $page = $_POST['page'];
        } else {
            $start = 0;
        }


        @$query.="view_ny_list";

        if($_POST["start_date"] !="" && $_POST["end_date"] !=""){
            $query.=" WHERE ny_create_date BETWEEN '".$_POST["start_date"]."' AND '".$_POST["end_date"]."' ";
        }else{
            $query.="";
        }

        if($_POST["search_page"] !=""){
            $sqlCheck=$db->fn_fetch_rowcount("res_bill WHERE bill_code LIKE '%".$_POST["search_page"]."%' ");
            if($sqlCheck>0){
                $query.=" AND list_bill_no LIKE '%".$_POST["search_page"]."%'";
            }else{
                $sqlCheck1=$db->fn_fetch_rowcount("res_tables WHERE table_name LIKE '%".$_POST["search_page"]."%' ");
                if($sqlCheck1>0){
                    $query.=" AND table_name LIKE '%".$_POST["search_page"]."%'  ";
                }else{
                    $query.="AND table_name='123578lkujjsdfsd' ";
                }
            }
        }else{
            $query.="";
        }

        if($_POST["typePayment"] !=""){
            $query.="AND list_bill_type_pay_fk='".$_POST["typePayment"]."'";
        }else{
            $query.="";
        }

        if($_POST["search_branch"] !=""){
            $query.="AND list_bill_branch_fk='".$_POST["search_branch"]."'";
        }else{
            $query.="";
        }


        $orderBy=" AND list_bill_status='1' ORDER BY list_bill_no ".$_POST['order_page']." ";

        if ($_POST["limit"] != "") {
            $filter_query = $query .$orderBy.' LIMIT '.$start.', '.$limit.'';
        } else {
            $filter_query = $query.$orderBy;
        }

        $fetch_sql=$db->fn_read_all($filter_query);
        $total_data = $db->fn_fetch_rowcount($query);
        $total_id = $start + 1;
?>
    <thead style="border: 1px solid white !important;vertical-align:middle !important">
        <tr>
            <td widtd="5%" style="text-align:center !important;">ຊໍາລະໜີ້</td>
            <td widtd="5%" style="text-align:center !important;">ລໍາດັບ</td>
            <td>ສາຂາ</td>
            <td style="text-align: center;">ວັນທີ່ຂາຍ</td>
            <td align="center">ເລກບິນ</td>
            <td align="center">ເບີໂຕະ</td>
            <td style="text-align: center;">ວັນທີ່ຊໍາລະ</td>
            <td align="center">ຊື່ລູກຄ້າ</td>
            <td align="center">ທີຢູ່</td>
            <td align="center">ເບີໂທ</td>
            <td>ປະເພດຊໍາລະ</td>
            <td>ຈໍານວນ</td>
            <td>ໜີ້ຄ້າງຈ່າຍ</td>
            <td>ສະຖານະ</td>
        </tr>
    </thead>
    <tbody class="table-bordered-y table-sm display">
    <?php
        if ($total_data > 0) {
            foreach($fetch_sql as $row_sql){
                @$sumPerPrice+=$row_sql["list_bill_percented_price"];
            if($row_sql["list_bill_type_pay_fk"]!="4"){
                @$amount+=$row_sql["list_bill_amount"];
                @$sumTotal+=$row_sql["list_bill_amount_kip"];
                @$sumTotalKang+=$row_sql["list_bill_amount_kip"];
                @$sumBill=$row_sql["list_bill_amount"];
                @$sumNy=0;
                @$totalNy+=0;

            }else{
                @$amount+=0;
                @$sumTotal+=0;
                @$sumBill=0;
                @$sumNy=$row_sql["list_bill_amount"];
                @$totalNy+=$row_sql["list_bill_amount"];
            }
            

            if($row_sql["list_bill_type_pay_fk"]=="1"){
                $typePayment="ເງິນສົດ";
                $color="";
            }elseif($row_sql["list_bill_type_pay_fk"]=="2"){
                $typePayment="ເງິນໂອນ";
                $color="";
            }elseif($row_sql["list_bill_type_pay_fk"]=="3"){
                $typePayment="ເງິນສົດ-ໂອນ";
                $color="";
            }elseif($row_sql["list_bill_type_pay_fk"]=="4"){
                $typePayment="ຕິດໜີ້";
                $color="text-danger";
            }else{
                $typePayment="ສັ່ງກັບບ້ານ";
                $color="";
            }

            if($row_sql["ny_status"]=="1"){
                $paymentDate="-";
                $statusPayment="<i class='fas fa-spin fa-spinner'></i> ຄ້າງຈ່າຍ";
                $colorPayment="text-danger";
                $btnPayment="";
            }else{
                $paymentDate=date("d/m/Y",strtotime($row_sql["ny_create_date"]));
                $statusPayment="<span class='text-primary'><i class='fas fa-check-circle'></i> ຈ່າຍແລ້ວ</span>";
                $colorPayment="";
                $btnPayment="disabled";
            }
?>
                <tr class="table_hover <?php echo $colorPayment;?>">
                    <td align="center">
                        <button type="button" class="btn btn-outline-primary btn-sm" <?php echo $btnPayment?> onclick="deleteBill('<?php echo $row_sql['list_bill_no'];?>')">
                            <ion-icon name="wallet-outline" style="font-size: 16px;"></ion-icon> ຊໍາລະໜີ້
                        </button>
                    </td>
                    <td align="center"><?php echo $total_id++;?></td>
                    <td align="center"><?php echo $row_sql["branch_name"];?></td>
                    <td align="center"><?php echo date("d/m/Y",strtotime($row_sql["ny_create_date"]));?></td>
                    <td align="center"><?php echo $row_sql["list_bill_no"];?></td>
                    <td align="center"><?php echo $row_sql["table_name"];?></td>
                    <td align="center"><?php echo $paymentDate;?></td>
                    <td><?php echo $row_sql["cus_name"];?></td>
                    <td><?php echo $row_sql["cus_address"];?></td>
                    <td align="center"><?php echo $row_sql["cus_tel"];?></td>
                    <td align="center"><?php echo $typePayment;?></td>
                    <td align="center"><?php echo @number_format($row_sql["list_bill_qty"]+$row_sql["list_bill_sum_qty_promotion"]);?></td>
                    <td align="right"><?php echo @number_format($sumNy);?></td>
                    <td align="right"><?php echo $statusPayment;?></td>
                </tr>
            <?php } ?>
            <tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;">
                <td colspan="12" align="right">ລວມຍອດໜີ້ຄ້າງທັງໝົດ</td>
                <td align="right"><?php echo @number_format($totalNy);?></td>
                <td></td>
            <tr>
            <tr style="border-top:1px solid #DEE2E6">
                <td colspan="14">
                    <center>
                        <ul class="pagination">
                                <?php
                                if ($limit != "") {
                                    $limit1 = $limit;
                                } else {
                                    $limit1 = $total_data;
                                }
                                $total_links = ceil($total_data / $limit1);
                                $previous_link = '';
                                $next_link = '';
                                $page_link = '';
                                if ($total_links > 4) {
                                    if ($page < 5) {
                                            for ($count = 1; $count <= 5; $count++) {
                                                $page_array[] = $count;
                                            }
                                            $page_array[] = '...';
                                            $page_array[] = $total_links;
                                    } else {
                                            $end_limit = $total_links - 5;
                                            if ($page > $end_limit) {
                                                $page_array[] = 1;
                                                $page_array[] = '...';
                                                for ($count = $end_limit; $count <= $total_links; $count++) {
                                                        $page_array[] = $count;
                                                }
                                            } else {
                                                $page_array[] = 1;
                                                $page_array[] = '...';
                                                for ($count = $page - 1; $count <= $page + 1; $count++) {
                                                        $page_array[] = $count;
                                                }
                                                $page_array[] = '...';
                                                $page_array[] = $total_links;
                                            }
                                    }
                                } else {
                                    for ($count = 1; $count <= $total_links; $count++) {
                                            $page_array[] = $count;
                                    }
                                }

                                for ($count = 0; $count < count($page_array); $count++) {
                                    if ($page == $page_array[$count]) {
                                            $page_link .= '
                                                <li class="page-item active">
                                                <div class="page-link" href="#">' . $page_array[$count] . ' <span class="sr-only">(current)</span></div>
                                                </li>
                                            ';

                                            $previous_id = $page_array[$count] - 1;
                                            if ($previous_id > 0) {
                                                $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $previous_id . '"><i class="fas fa-chevron-left"></i></a></li>';
                                            } else {
                                                $previous_link = '
                                                        <li class="page-item disabled">
                                                        <div class="page-link" href="#"><i class="fas fa-chevron-left"></i></div>
                                                        </li>
                                                ';
                                            }
                                            $next_id = $page_array[$count] + 1;
                                            if ($next_id > $total_links) {
                                                $next_link = '
                                                <li class="page-item disabled">
                                                    <div class="page-link" href="#"><i class="fas fa-chevron-right"></i></div>
                                                </li>
                                                ';
                                            } else {
                                                $next_link = '<li class="page-item"><div class="page-link" href="javascript:void(0)" data-page_number="' . $next_id . '"><i class="fas fa-chevron-right"></i></div></li>';
                                            }
                                    } else {
                                            if ($page_array[$count] == '...') {
                                                $page_link .= '
                                                <li class="page-item disabled">
                                                <div class="page-link" href="#">...</div>
                                                </li>
                                                ';
                                            } else {
                                                $page_link .= '
                                                <li class="page-item"><div class="page-link" href="javascript:void(0)" data-page_number="' . $page_array[$count] . '">' . $page_array[$count] . '</div></li>
                                                ';
                                            }
                                    }
                                }

                                $output = $previous_link . $page_link . $next_link;
                                echo $output;
                                ?>
                        </ul>
                    </center>
                </td>
            </tr>
        <?php }else{?>
            <tr>
                <td colspan="14" align="center" style="height:380px;padding:150px;color:red">
                    <i class="fas fa-times-circle fa-3x"></i><br>
                    ບໍ່ພົບລາຍການ
                </td>
            </tr>
        <?php }?>
    </tbody>
    <?php }?>
