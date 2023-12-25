<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    if(isset($_GET["fetch_data"])){
        $limit = $_POST["limit"];
        $page = 1;
        if (@$_POST['page'] > 1) {
            $start = (($_POST['page'] - 1) * $limit);
            $page = $_POST['page'];
        } else {
            $start = 0;
        }

        @$query.="view_product_titel ";

        if($_POST["product_branch"] !="" && $_POST["product_group_fk"] !="" && $_POST["product_cate_fk"] !="" && $_POST["search_page"] !=""){
            $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
            if($rowCount>0){
                $query.=" WHERE product_branch='".$_POST["product_branch"]."' 
                AND product_group_fk='".$_POST["product_group_fk"]."' 
                AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                $query.=" AND product_name LIKE '%".$_POST["search_page"]."%'";
            }else{
                $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
                if($rowCount>0){
                    $query.=" WHERE product_branch='".$_POST["product_branch"]."' 
                    AND product_group_fk='".$_POST["product_group_fk"]."' 
                    AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                    $query.=" AND product_name LIKE '%".$_POST["search_page"]."%'";
                }else{
                    $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%".$_POST["search_page"]."%' ");
                    if($rowCount>0){
                        $query.=" WHERE product_branch='".$_POST["product_branch"]."' 
                        AND product_group_fk='".$_POST["product_group_fk"]."' 
                        AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                        $query.=" AND cate_name LIKE '%".$_POST["search_page"]."%'";
                    }else{
                        $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%".$_POST["search_page"]."%' ");
                        if($rowCount>0){
                            $query.=" WHERE product_branch='".$_POST["product_branch"]."' 
                            AND product_group_fk='".$_POST["product_group_fk"]."' 
                            AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                            $query.=" AND group_name LIKE '%".$_POST["search_page"]."%'";
                        }else{
                            $query.="WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                        }
                    }
                }
            }
        }else if($_POST["product_branch"] !="" && $_POST["product_group_fk"] !="" && $_POST["product_cate_fk"]!="" && $_POST["search_page"]==""){
            $query.=" WHERE product_branch='".$_POST["product_branch"]."' 
                AND product_group_fk='".$_POST["product_group_fk"]."' 
                AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
        }else if($_POST["product_branch"] !="" && $_POST["product_group_fk"]=="" && $_POST["product_cate_fk"]=="" && $_POST["search_page"]==""){
            $query.=" WHERE product_branch='".$_POST["product_branch"]."'";
        }else if($_POST["product_branch"]=="" && $_POST["product_group_fk"]!="" && $_POST["product_cate_fk"]!="" && $_POST["search_page"]==""){
            $query.=" WHERE product_group_fk='".$_POST["product_group_fk"]."' AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
        }else if($_POST["product_branch"]=="" && $_POST["product_group_fk"]!="" && $_POST["product_cate_fk"]!="" && $_POST["search_page"]!=""){
            $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
            if($rowCount>0){
                $query.=" WHERE product_group_fk='".$_POST["product_group_fk"]."' AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                $query.=" AND product_name LIKE '%".$_POST["search_page"]."%'";
            }else{
                $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
                if($rowCount>0){
                    $query.=" WHERE product_group_fk='".$_POST["product_group_fk"]."' AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                    $query.=" AND product_name LIKE '%".$_POST["search_page"]."%'";
                }else{
                    $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%".$_POST["search_page"]."%' ");
                    if($rowCount>0){
                        $query.=" WHERE product_group_fk='".$_POST["product_group_fk"]."' AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                        $query.=" AND cate_name LIKE '%".$_POST["search_page"]."%'";
                    }else{
                        $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%".$_POST["search_page"]."%' ");
                        if($rowCount>0){
                            $query.=" WHERE product_group_fk='".$_POST["product_group_fk"]."' AND product_cate_fk='".$_POST["product_cate_fk"]."' ";
                            $query.=" AND group_name LIKE '%".$_POST["search_page"]."%'";
                        }else{
                            $query.="WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                        }
                    }
                }
            }
        }else if($_POST["product_branch"]=="" && $_POST["product_group_fk"]=="" && $_POST["product_cate_fk"]=="" && $_POST["search_page"]!=""){
            $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
            if($rowCount>0){
                $query.=" WHERE product_name LIKE '%".$_POST["search_page"]."%'";
            }else{
                $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
                if($rowCount>0){
                    $query.=" WHERE product_name LIKE '%".$_POST["search_page"]."%'";
                }else{
                    $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%".$_POST["search_page"]."%' ");
                    if($rowCount>0){
                        $query.=" WHERE cate_name LIKE '%".$_POST["search_page"]."%'";
                    }else{
                        $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%".$_POST["search_page"]."%' ");
                        if($rowCount>0){
                            $query.=" WHERE group_name LIKE '%".$_POST["search_page"]."%'";
                        }else{
                            $query.="WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                        }
                    }
                }
            }
        }else if($_POST["product_branch"]!="" && $_POST["product_group_fk"]=="" && $_POST["product_cate_fk"]=="" && $_POST["search_page"]!=""){
            $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
            if($rowCount>0){
                $query.=" WHERE product_name LIKE '%".$_POST["search_page"]."%'";
            }else{
                $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE product_name LIKE '%".$_POST["search_page"]."%' ");
                if($rowCount>0){
                    $query.=" WHERE product_name LIKE '%".$_POST["search_page"]."%'";
                }else{
                    $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE cate_name LIKE '%".$_POST["search_page"]."%' ");
                    if($rowCount>0){
                        $query.=" WHERE cate_name LIKE '%".$_POST["search_page"]."%'";
                    }else{
                        $rowCount=$db->fn_fetch_rowcount("view_product_titel WHERE group_name LIKE '%".$_POST["search_page"]."%' ");
                        if($rowCount>0){
                            $query.=" WHERE group_name LIKE '%".$_POST["search_page"]."%'";
                        }else{
                            $query.="WHERE group_name='232SSSDSXCVDFD223SEDFR'";
                        }
                    }
                }
            }
        }else{
            $query.="";
        }
        

        if($_POST["order_page"] !=""){
            $query.=" ORDER BY product_code ".$_POST["order_page"]." ";
        }else{
            $query.="";
        }

        

        // if ($_POST["limit"] != "") {
        //     $filter_query = $query . 'LIMIT '.$start.', '.$limit.'';
        // } else {
        //     $filter_query = $query;
        // }


        $fetch_sql=$db->fn_read_all($query);
        $total_data = $db->fn_fetch_rowcount($query);
        $total_id = $start + 1;
        if ($total_data > 0) {
        foreach($fetch_sql as $row_sql){
            // if($row_sql["pro_detail_location"]!=""){
            //     $img="assets/img/product_detail/".$row_sql["pro_detail_location"];
            // }else{
            //     if($row_sql["product_images"]){
            //         $img="assets/img/product_home/".$row_sql["product_images"];
            //     }else{
            //         $img="assets/img/logo/no_image.png";
            //     }
                
            // }

            if($row_sql["product_images"]){
                $img="assets/img/product_home/".$row_sql["product_images"];
            }else{
                $img="assets/img/logo/no_image.png";
            }


            // if($row_sql["pro_detail_open"]=="1"){
            //     $bg2="color:red !important;text-decoration: line-through";
            // }else{
            //     $bg2="";
            // }

            if($row_sql["product_notify"]=="1"){
                $togle_check1="";
                $notify1="<span class='text-danger'>ບໍ່ແຈ້ງເຕືອນ</span>";
            }else{
                $togle_check1="checked";
                $notify1="ແຈ້ງເຕືອນ";
            }


            
?>
            <tr style="vertical-align:middle;<?php echo $bg2?>;">
                <td align="center"><?php echo $total_id++;?></td>
                <td><center><img src='<?php echo $img;?>' width="40px" height="35px"></center></td>
                <td><?php echo $row_sql["cate_name"]?></td>
                <td><?php echo $row_sql["branch_name"]?></td>
                <td colspan="6">
                </td>
            </tr>
            <?php 
                $j=1;
                $sqlDetail=$db->fn_read_all("view_product_list WHERE pro_detail_product_fk='".$row_sql["product_code"]."' ORDER BY pro_detail_code ASC");
                foreach($sqlDetail as $rowDetail){
                    if($rowDetail["pro_detail_open"]=="1"){
                        $togle_check="";
                        $bg="color:red !important;text-decoration: line-through";
                        $open="<span class='text-danger'>ປິດ</span>";
                    }else{
                        $togle_check="checked";
                        $bg="";
                        $open="<span class='text-blue'>ເປິດ</span>";
                    }
            ?>
                <tr style="<?php echo $bg?>;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $j++;?>. <?php echo $rowDetail["product_name"]?><?php echo $rowDetail["size_name_la"]?></td>
                    <td align="center"><?php echo $rowDetail["unite_name"]?></td>
                    <td align="center"><?php echo @number_format($rowDetail["pro_detail_qty"])?></td>
                    <td align="center"><?php echo @number_format($rowDetail["pro_detail_bprice"])?></td>
                    <td align="center"><?php echo @number_format($rowDetail["pro_detail_sprice"])?></td>
                </tr>
            <?php }?>
            <tr style="border-top:1px dotted #7a7979">
                <td colspan="13"></td>
            </tr>
        <?php }?>
        <?php }else{?>
            <tr>
                <td colspan="13" align="center" style="height:380px;padding:150px;color:red">
                    <i class="fas fa-times-circle fa-3x"></i><br>
                    ບໍ່ພົບລາຍການ
                </td>
            </tr>
        <?php }?>
<?php }

if(isset($_GET["insertMove"])){
    // $sqlInsertmove=$db->fn_insert("res_products_list","");
    // echo $_POST["start_branch"];
    // echo $_POST["end_branch"];
    
    $fetch_sql=$db->fn_read_all("res_products_list WHERE product_branch='".$_POST["start_branch"]."'");
    foreach($fetch_sql as $rowBranch){
        $auto_number=$db->fn_autonumber("product_code","res_products_list");
        $sql="'".$auto_number."','".$_POST["end_branch"]."','".$rowBranch["product_group_fk"]."','".$rowBranch["product_cate_fk"]."','".$rowBranch["product_unite_fk"]."','".$rowBranch["product_name"]."','".$rowBranch["product_cut_stock"]."','".$rowBranch["product_reorder_point_fk"]."','".$rowBranch["product_images"]."','".$rowBranch["product_notify"]."'";
        $insert=$db->fn_insert("res_products_list",$sql);
        if($insert){
            $sql_detail=$db->fn_read_all("res_products_detail AS A 
            LEFT JOIN res_products_list AS B ON A.pro_detail_product_fk=B.product_code 
            WHERE pro_detail_product_fk='".$rowBranch["product_code"]."' AND product_branch='".$rowBranch["product_branch"]."' ORDER BY pro_detail_code ASC");
            foreach($sql_detail as $rowDetail){
                $auto_detail=$db->fn_autonumber("pro_detail_code","res_products_detail");
                $sql="'".$auto_detail."','".$auto_number."','".$rowDetail["pro_detail_barcode"]."','".$rowDetail["pro_detail_size_fk"]."','".$rowDetail["pro_detail_bprice"]."','".$rowDetail["pro_detail_sprice"]."','".$rowDetail["pro_detail_qty"]."','".$rowDetail["pro_detail_gif"]."','".$rowDetail["pro_detail_open"]."','".date("Y-m-d")."','".$_SESSION["users_id"]."','".$rowDetail["pro_detail_location"]."'";
                $insert_detail=$db->fn_insert("res_products_detail",$sql);
            }
            // echo json_encode(array("statusCode" => 200));
        }
    }
}

?>