<?php
	include 'inc/database.php'; 
	
	if(isset($_POST['action']) && $_POST['action']=='Login')
	{
		$obj->Admin_signin($connect);
	}
?>