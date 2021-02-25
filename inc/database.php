<?php 
error_reporting(0);
session_start();
ob_start();
define('DB_HOSTNAME','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','k@m@l1997');
define('DB_DATABASENAME','zellis');

#define('DB_USERNAME','root');
#define('DB_PASSWORD','');
#define('DB_DATABASENAME','crm');

function base_url(){
    $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
    $base_url .= '://'. $_SERVER['HTTP_HOST'];
    return $base_url;
}
define('SUB_FOLDER', "/staging/"); // without trailing slash
define('SITEURL', base_url().SUB_FOLDER);
define('FRONTSITEURL',base_url().SUB_FOLDER);
// define('SITEURL','http://zellisauto.com/');
// define('FRONTSITEURL','http://zellisauto.com/');
define('ADMINURL',base_url().SUB_FOLDER.'admin/');
// define('ADMINURL','http://zellisauto.com/admin/');

/* define('SITEURL','http://localhost/zellis/');
define('FRONTSITEURL','http://localhost/zellis'); */

define('MAX_FILE_SIZE', '1024 * 1024 * 10'); // 10 mb size
define('IMAGE_EXTENSIONS', json_encode(array("jpg","jpeg","png","gif")));

define('ROWS_PER_PAGE', '10'); // 10

$connect	=	mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASENAME);
if(!$connect)
{
	die('Could Not Connect to Database') or die(mysqli_error($connect));
}
// mysql_select_db(DB_DATABASENAME,$connect); 

class Encryption {
	public $skey;
	public function __construct($skey = "A&L^A&P)T(A*W)3K4EY*&BBA") {
		$this->skey	= $skey;
	}
	public function safe_b64encode($string) {
		$data = base64_encode($string);
		$data = str_replace(array('+','/','='),array('-','_',''),$data);
		return $data;
	}
	public function safe_b64decode($string) {
		$data = str_replace(array('-','_'),array('+','/'),$string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return base64_decode($data);
	}
	public function encode($value){
		if(!$value){return false;}
		/* $text = $value;
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);*/
		$crypttext = openssl_encrypt($value,"AES-128-ECB",$this->skey);
		return trim($this->safe_b64encode($crypttext));	
	}
	public function decode($value){
		if(!$value){return false;}
		$crypttext = $this->safe_b64decode($value);
		/*$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); */
		$decrypttext = openssl_decrypt($crypttext,"AES-128-ECB",$this->skey);
		return trim($decrypttext);
	}
}
$Encryption = new Encryption();

function safe_str($str){
	global $connect;
	return $connect->real_escape_string(trim($str));
}


include('classes.php');
$obj	=	new model();
?>
