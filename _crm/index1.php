<?php 
include  dirname(__FILE__).'/../inc/config.php'; 
include  dirname(__FILE__).'/../inc/template_start.php';
include  dirname(__FILE__).'/../inc/page_head.php';
// print_r($_SESSION);
// $obj->check_admin_not_login(); 
if(isset($_SESSION['admin'])){
	// ok
}else{
	header("Location: ".SITEURL."_crm/login.php");
 }
?>