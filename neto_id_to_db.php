<?php

include 'inc/database.php';
$obj->admin_not_login();

$custom_field = $_POST['neto_id'];
$us_id = $_SESSION['myuser']['us_id'];

$connect->query("update user set custom_field='".$custom_field."' where us_id=".$us_id);

?>