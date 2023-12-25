<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    require __DIR__ . '../../../vendor/autoload.php';
    use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
    use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
    use Mike42\Escpos\Printer;
    use Mike42\Escpos\EscposImage;

    if(isset($_GET["fetch_data"])){
        $limit = $_POST["limit"];
        $page = 1;
        if (@$_POST['page'] > 1) {
            $start = (($_POST['page'] - 1) * $limit);
            $page = $_POST['page'];
        } else {
            $start = 0;
        }
        $query="";
        @$query.="view_printers";

        if($_POST["search"] !=""){
            $query.=" WHERE group_name LIKE '%".$_POST["search"]."%' OR printer_address LIKE '%".$_POST["search"]."%'  OR branch_name LIKE '%".$_POST["search"]."%' ";
        }else{
            $query.="";
        }
        
        if($_POST["orderby"] !=""){
            $query.=" ORDER BY printer_code ".$_POST["orderby"]." ";
        }else{
            $query.="";
        }

        if ($_POST["limit"] != "") {
            $filter_query = $query . 'LIMIT '.$start.', '.$limit.'';
        } else {
            $filter_query = $query;
        }

        $fetch_sql=$db->fn_read_all($filter_query);
        $total_data = $db->fn_fetch_rowcount($query);
        $total_id = $start + 1;
        $i=1;
        if ($total_data > 0) {
        foreach($fetch_sql as $row_sql){
            if($row_sql['printer_status']=="1"){
                $status="<span class='text-primary'><i class='fas fa-check'></i> ເປີດພິມໂອໂຕ</span>";
                $color="";
                $togle_check="checked";
            }else{
                $status="<i class='fas fa-close'></i> ປິດພິມໂອໂຕ";
                $color="text-danger";
                $togle_check="";
            }

?>
            <tr class="table_hover <?php echo $color;?>" ondblclick="edit_function('<?php echo $row_sql['printer_code']?>','<?php echo $row_sql['printer_group_fk']?>','<?php echo $row_sql['printer_branch_fk']?>','<?php echo $row_sql['printer_type_fk']?>','<?php echo $row_sql['printer_address']?>','<?php echo $row_sql['printer_status']?>')">
                <td>
                    <center>
                        <div class="form-check form-switch ms-auto">
                            <input type="checkbox" class="form-check-input" id="pro_detail_open" name="pro_detail_open" <?php echo @$togle_check;?> onchange="fn_togle_switch('<?php echo $row_sql['printer_code'];?>','<?php echo $row_sql['printer_status'];?>')">
                            <label class="form-check-label" for="pro_detail_open">&nbsp;</label>
                        </div>
                    </center>
                </td>
                <td align="center"><?php echo $total_id++;?></td>
                <td><?php echo $row_sql["printer_address"]?></td>
                <td><?php if($row_sql["printer_group_fk"]=="1"){echo "ເຊັກບິນ ແລະ ພິມບິນຄືນ";}else{echo $row_sql["group_name"];}?></td>
                <td><?php echo $row_sql["branch_name"]?></td>
                <td>
                    <input type="text" class="form-control" id="testing<?php echo $row_sql['printer_code']?>" maxlength="50" value="ເຄື່ອງພິມ<?php echo $i;?> ( Printer <?php echo $i;?> )">
                    <input type="text" class="form-control" hidden id="ip_address<?php echo $row_sql['printer_code']?>" value="<?php echo $row_sql['printer_address']?>">
                </td>
                <td align="center">
                    <button type="button" class="btn btn-primary" onclick="testintBill('<?php echo $row_sql['printer_code']?>','<?php echo $row_sql['printer_type_fk']?>')"><ion-icon name="print-outline"></ion-icon> ທົດລອງພິມ <?php echo $i++;?></button>
                </td>
            </tr>
        <?php }?>
        <tr style="border-top:1px solid #DEE2E6">
            <td colspan="7">
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
                <td colspan="7" align="center" style="height:380px;padding:150px;color:red">
                    <i class="fas fa-times-circle fa-3x"></i><br>
                    ບໍ່ພົບລາຍການ
                </td>
            </tr>
        <?php }?>
<?php }
    if(isset($_GET["insert_data"])){
        $auto_number=$db->fn_autonumber("printer_code","res_printer");
        if(@$_POST["printer_status"]=="1"){
            $printer_status="1";
        }else{
            $printer_status="2";
        }

        if($_POST["printer_code"] !=""){

            $sql="printer_group_fk='".$_POST["product_group_fk"]."',printer_branch_fk='".$_POST["product_branch"]."',printer_type_fk='".$_POST["printer_type_fk"]."',printer_address='".$_POST["printer_address"]."',printer_status='".$printer_status."' WHERE printer_code='".$_POST["printer_code"]."'";
            $edit=$db->fn_edit("res_printer",$sql);
            if($edit){
                echo json_encode(array("statusCode" => 202));
            }else{
                echo json_encode(array("statusCode" => 204));
            }
        }else{
            $sql="'".$auto_number."','".$_POST["product_group_fk"]."','".$_POST["product_branch"]."','".$_POST["printer_type_fk"]."','".$_POST["printer_address"]."','".$printer_status."'";
            $insert=$db->fn_insert("res_printer",$sql);
            if($insert){
                echo json_encode(array("statusCode" => 200));
            }else{
                echo json_encode(array("statusCode" => 204));
            }
        }
    }

    if(isset($_GET["editStatus"])){
        $editData=$db->fn_edit("res_printer","printer_status='".$_POST["status"]."' WHERE printer_code='".$_POST["userID"]."'");
    }

    if(isset($_GET["printer_name"])){
        // $command = 'wmic printer get name';
        // exec($command, $output);
        // $printerNames = [];
        // foreach ($output as $line) {
        //     $printerName = trim($line);
        //     if (!empty($printerName)) {
        //         $printerNames[] = $printerName;
        //     }
        // }
        // header('Content-Type: application/json');
        // echo json_encode($printerNames);

        $command = 'wmic printer get name';
        $output = [];
        $returnValue = null;
        exec($command, $output, $returnValue);

        if ($returnValue !== 0) {
            // Error occurred, handle it accordingly
            echo "Error executing command: $command";
            echo "Return value: $returnValue";
        } else {
            // Process the $output as before
            $printerNames = [];
            foreach ($output as $line) {
                $printerName = trim($line);
                if (!empty($printerName)) {
                    $printerNames[] = $printerName;
                }
            }

            header('Content-Type: application/json');
            echo json_encode($printerNames);
        }

    }

    if(isset($_GET["printing"])){

        try {
            if($_POST["printer_type_fk"]=="20230000001"){
                $connector = new WindowsPrintConnector($_POST["ip_address"]);
            }else{
                $connector = new NetworkPrintConnector($_POST["ip_address"], 9100);
            }
            
            $printer = new Printer($connector);
            $fontFile = '../../assets/css/fonts/Saysettha-Bold.ttf';
            $y = 40;

            $imageHeight = 60;
            $image = imagecreatetruecolor(1000, $imageHeight);
            $backgroundColor = imagecolorallocate($image, 255, 255, 255);
            $textColor = imagecolorallocate($image, 0, 0, 0);
            imagefill($image, 0, 0, $backgroundColor);
        
            // Write the title and subtitle
            imagettftext($image, 24, 0, 0, $y, $textColor, $fontFile, $_POST["testing"]);
        
            // Save the image with a unique filename
            $imagePath = "../../assets/img/ConfirmImage/".$_POST["printer_code"].".png";
            ImagePng($image, $imagePath);
            imagedestroy($image);
            // echo '<img src="MyResize/image'.$i.'.png" alt="Image">';

            $image = EscposImage::load($imagePath);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->bitImage($image);
            $printer->pulse();
            $printer->cut();
            unlink($imagePath);
            $printer->close();
            echo "200";
        } catch (Exception $e) {
            echo "201";
            // echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }

   

?>