<?php

include 'inc/database.php';
$obj->admin_not_login();

$us_id = $_SESSION['myuser']['us_id'];
$sqlQry = $connect->query("select api_key,custom_field from user where us_id=".$us_id);
if($sqlQry->num_rows) {
    $d_row = $sqlQry->fetch_assoc();
}

echo json_encode($d_row);

?>