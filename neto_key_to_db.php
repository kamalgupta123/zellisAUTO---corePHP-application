<?php

include 'inc/database.php';
$obj->admin_not_login();

$api_key = $_POST['neto_key'];
$us_id = $_SESSION['myuser']['us_id'];

$connect->query("update user set api_key='".$api_key."' where us_id=".$us_id);

?>