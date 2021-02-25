<?php
include dirname(__FILE__).'/../inc/config.php';
$obj->check_admin_not_login();
if(isset($_POST['Lock_UnLockSubmit']))
{
	// print_r($_POST); die;
	$data = array(
		"status"=>0,
		"errors"=>array()
	);
	if(!empty($_POST['user_id_lock'])) {
		$user_id_lock = $_POST['user_id_lock'];
		$userD = $connect->query("select * from user where us_id =".$user_id_lock);
		if($userD->num_rows) {
			$d_row = $userD->fetch_assoc();
			if($d_row["us_lock"]==1) { // if lock
				$connect->query("update user set us_lock='0' where us_id=".$user_id_lock);
				$data['status'] =1;
			}
			if($d_row["us_lock"]==0) { // if unlock
				$connect->query("update user set us_lock='1' where us_id=".$user_id_lock);
				$data['status'] =1;
			}
		} else{
			$data['errors'][] = "Data not found!";
		}
			
	} else{
		$data['errors'][] = "Missing Argument!";
	}
	header('Content-type: application/json');
	echo json_encode($data);
}
$connect->close();
?>