<?php
include 'inc/database.php';

if(isset($_POST["reset_password"])){

	$str=safe_str($_POST['token']);
	// echo $str;
	$Encryption = new Encryption();
	$id=$Encryption->decode($str);
	$result1 = $connect->query("select * from user where reset_password_token='".$id."'");
	$error=0;
	if(empty($_POST['password12'])) {
		echo "Password is required*";
		$error=1;
	}
	if(!empty($_POST["password12"])){
		if($_POST["password12"] !== $_POST['password2']){
			echo "Password do not match.";
			$error=1;
		}
	} else{
		echo "Confirm Password is required*";
		$error=1;
	}
	if($error==0)
    {	$result = $result1->fetch_assoc();
		$password=md5(safe_str($_POST['password12']));
		$in_fields['us_password']=$password;
		// $in_fields['reset_password_token']='';
		// $in_fields['reset_password_token_created_date']='';
		$up_fields = array();
		foreach($in_fields as $ifield => $ival){
			if((empty($ival) || $ival=="null") && $ival!=0){
				$up_fields[]="`".safe_str($ifield)."` = null";
			}
			else{
				$up_fields[]="`".safe_str($ifield)."` = '".safe_str($ival)."'";
			}
		}
		$up_qry = "UPDATE user SET ".implode(", ", $up_fields)." WHERE us_id = '".$result["us_id"]."'";
		$up_result = $connect->query($up_qry);
		if(!empty($up_result)){
			echo 1;
		} else {
			echo "Something went wrong!";
		}
    }
}

if(isset($_POST["SendResetMail"])) {
	// print_r($_POST); die;
	$Encryption = new Encryption();
	
	$response = array(
		"status" => false,
		"msg" => ''
	);
	if(empty($_POST['email'])) {
		$response['msg'] = "Email is required*";
	} else{
		$checkEmailsql = $connect->query("select * from user where us_email='".safe_str($_POST['email'])."'");
		if($checkEmailsql->num_rows)  {
			$getUser = $checkEmailsql->fetch_assoc();
			//send mail
			$mailTo = safe_str($_POST['email']);
			
			$token_exists=1;
			while($token_exists==1){
				$token = md5(openssl_random_pseudo_bytes(32));
				// check if this token exists in db already 
				$tokenSql = $connect->query("select * from user where reset_password_token='".$token."'");
				if(empty($tokenSql->num_rows)){
					$token_exists=0;
				}
			}
			$token_date = date("Y-m-d H:i:s"); // reset pwd link 
			// echo "update user set reset_password_token='".$token."' where id=".$getUser['id'];
			// echo "update user set reset_password_token='".$token."',reset_password_token_created_date='".$token_date."' where us_id=".$getUser['us_id'];
			$UpdateToken = $connect->query("update user set reset_password_token='".$token."',reset_password_token_created_date='".$token_date."' where us_id=".$getUser['us_id']);
			// echo $token;
			$tokenEnc= $Encryption->encode($token);
			// echo $tokenEnc;
			$verify_link = SITEURL."resetting_password.php?token=".$tokenEnc;
			$mailSub = 'Change Password';
			$mailMsg = "Hi " . $getUser['user_fname'] . "," . PHP_EOL;
			$mailMsg .= "<br>You recently request for change password. Please Click on the link i.e ".$verify_link." to change password.<br>" . PHP_EOL;
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// echo $mailMsg; 
			// $response['msg'] = $mailMsg; 
			/*
			require BASE_DIR .'/vendor/phpAutoLoader.php';
			$addAddress = array(
			array(
				'rEmail'=> $email
			));
			if (sendPhpMailerMail($addAddress, $mailSub, $mailMsg)){ */
			if (mail($mailTo, $mailSub, $mailMsg, $headers)) {
				$response["status"] = true;
			}
			else{
				$response['msg'] = "Something went wrong!";
			}
		} else{
			$response['msg'] = "Email is not registered.";
		}
	}
	header('Content-type: application/json');
	echo json_encode($response);
}
$connect->close();
 ?>