<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if (isset($_GET["insert_data"])) {
    $checkData = $db->fn_fetch_rowcount("tb_default_menu WHERE default_menu_user_fk='" . $_POST["menu_default_code"] . "'");
    if ($checkData > 0) {
        $delete = $db->fn_delete("tb_default_menu WHERE default_menu_user_fk='" . $_POST["menu_default_code"] . "' ");
    }
    for ($i = 0; $i < count($_POST["default_menu_sub_fk"]); $i++) {
        $auto_number = $db->fn_autonumber("default_menu_code", "tb_default_menu");
        $sql = "'" . $auto_number . "','" . $_POST["default_menu_main_fk"][$i] . "','" . $_POST["default_menu_sub_fk"][$i] . "','" . $_POST["menu_default_code"] . "','2'";
        $insert = $db->fn_insert("tb_default_menu", $sql);
    }
    if ($insert) {
        echo json_encode(array("statusCode" => 200));
    } else {
        echo json_encode(array("statusCode" => 204));
    }
}

if (isset($_GET["fetch_data"])) {
    $sqlUsers=$db->fn_fetch_single_all("res_status WHERE status_code='".$_POST["search_user"]."' ");
?>
    <tr style="background-color: #000000;">
        <td colspan="4" class="text-white" align="center" style="font-size: 18px;"><i class="fas fa-user"></i>  ສິດນໍາໃຊ້ : <?php echo $sqlUsers["status_name"]?></td>
    </tr>
<?php 
    $i = 1;
    $groupUser = $db->fn_read_all("view_sub_menus WHERE default_menu_user_fk='" . $_POST["search_user"] . "' GROUP BY default_menu_main_fk ");
    foreach ($groupUser as $rowUser) {
?>
        <tr style="background-color: #1e3a56;">
            <td colspan="4" class="text-light"><?php echo $i++; ?>./ <?php echo $rowUser["main_name"] ?></td>
        </tr>
        <?php
        $j = 1;
        if($_POST["search_page"] !=""){
            
            $checkData = $db->fn_fetch_rowcount("view_sub_menus WHERE default_menu_user_fk='" . $rowUser["default_menu_user_fk"] . "' AND main_name LIKE '%".$_POST["search_page"]."%'");
            if($checkData>0){
                $search="AND main_name LIKE '%".$_POST["search_page"]."%'";
            }else{
                $checkData1 = $db->fn_fetch_rowcount("view_sub_menus WHERE default_menu_user_fk='" . $rowUser["default_menu_user_fk"] . "' AND sub_name LIKE '%".$_POST["search_page"]."%'");
                if($checkData1>0){
                    $search="AND sub_name LIKE '%".$_POST["search_page"]."%'";
                }else{
                    $search="4545DFDFDVVBGHHHH";
                }
            }
        }else{
            $search="";
        }
        $groupSubmenu = $db->fn_read_all("view_sub_menus WHERE default_menu_main_fk='" . $rowUser["default_menu_main_fk"] . "' AND default_menu_user_fk='" . $rowUser["default_menu_user_fk"] . "' $search");
        foreach ($groupSubmenu as $rowSubmenu) {
            if($rowSubmenu["default_menu_status"]=="2"){
                $checked="checked";
                $colors="";
            }else{
                $checked="";
                $colors="text-danger";
            }
        ?>
            <tr class="<?php echo $colors;?>">
                <td></td>
                <td align="center"><?php echo $j++; ?></td>
                <td><?php echo $rowSubmenu["sub_name"] ?></td>
                <td>
                    <center>
                        <div class="form-check form-switch ms-auto">
                            <input type="checkbox" class="form-check-input" id="checkStatus" name="checkStatus" <?php echo $checked;?> onchange="fn_togle_switch('<?php echo $rowSubmenu['default_menu_code'];?>','<?php echo $rowSubmenu['default_menu_status'];?>')">
                            <label class="form-check-label" for="checkStatus">&nbsp;</label>
                        </div>
                    </center>
                </td>
            </tr>
        <?php }
    }
}
if(isset($_GET["editStatus"])){
    $edit=$db->fn_edit("tb_default_menu","default_menu_status='".$_POST["stautsID"]."' WHERE default_menu_code='".$_POST["codeId"]."'");
}
?>