<?php

	include dirname(__FILE__).'/../inc/database.php'; 
	if(isset($_POST['action']) && $_POST['action']=='LoginAdmin')
	{
		$obj->LoginAdmin($connect);
	}
	
	
	
?>