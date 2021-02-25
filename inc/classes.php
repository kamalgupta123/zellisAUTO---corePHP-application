
<?php
class model{

	function escape_string($value)
	{
		return trim(mysqli_real_escape_String(stripslashes($value)));
	}
	function setdate($date)
	{
		return date('m-d-y',strtotime($date));
	}
	function Executequery($connect,$query)
	{
		$result	=	mysqli_query($connect,$query) or die(mysqli_error($connect));
		return $result;
	}
		
	function locate($url)
	{
		header('location:'.$url.'');
		exit;
	}
	
	function LoginAdmin($connect)
	{
		print_r($_POST);
		// $admin_username	=	$this->escape_string($_POST['admin_username']);
		$admin_username	=	$_POST['admin_username'];
		// $admin_password	=	$this->escape_string($_POST['admin_password']);
		$admin_password	=	$_POST['admin_password'];
		$select			=	"select * from admin where `name`='".$admin_username."' AND `password`=md5('".$admin_password."')";
		
		$query			=	$this->Executequery($connect,$select);
		$rows			=	mysqli_num_rows($query);
		if($rows>0)
		{
				$_SESSION['admin']		=	mysqli_fetch_assoc($query);
				$this->locate('index.php');
		}else{
				$_SESSION['invalid']	=	"Invalid Credential";
				$this->locate('login.php');
		}
	}
	
	function check_admin_not_login()
	{
		if(!isset($_SESSION['admin']['name']))
		{
			$this->locate('login.php');
		}
	}
	
	function check_admin_login()
	{
		if(isset($_SESSION['admin']['name']))
		{
			$this->locate('csv_uploader.php');
		}
	}
	
	function adminlogout()
	{
			unset($_SESSION['admin']);
			$this->locate('login.php');
	}
	
	function Admin_signin($connect)
	{
		// $admin_username	=	$this->escape_string($_POST['admin_username']);
		$admin_username	=	$_POST['admin_username'];
		// $admin_password	=	$this->escape_string($_POST['admin_password']);
		$admin_password	=	$_POST['admin_password'];
		$select			=	"select * from user where ( `us_username`='".$admin_username."' OR `us_email`='".$admin_username."') AND `us_password`=md5('".$admin_password."')";
		
		$query			=	$this->Executequery($connect,$select);
		$rows			=	mysqli_num_rows($query);
		if($rows>0)
		{
				$_SESSION['myuser'] =	mysqli_fetch_assoc($query);
				// $this->locate('index.php');
				$this->locate('dashboard.php');
		}else{
				$_SESSION['invalid']	=	"Invalid Credential";
				$this->locate('login.php');
		}
	}
	
	function admin_not_login()
	{
		if(!isset($_SESSION['myuser']['us_username']))
		{
			$this->locate('login.php');
		}
	}
	
	function admin_login()
	{
		if(isset($_SESSION['myuser']['us_username']))
		{
			// $this->locate('index.php');
			$this->locate('dashboard.php');
		}
	}
	
	function logout()
	{
			unset($_SESSION['myuser']);
			$this->locate('login.php');
	}
}

?>