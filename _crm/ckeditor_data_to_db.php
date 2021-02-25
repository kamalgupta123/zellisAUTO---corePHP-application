<?php
include dirname(__FILE__).'/../inc/database.php';
// include '../inc/database.php';
$obj->check_admin_not_login();
function dataready($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
} 
if(isset($_POST['PageContentSubmit']))
{
	// print_r($_POST); die;
	$data = array(
		"status"=>0,
		"errors"=>array()
	);
	$dataC = $_POST['data'];
	$k = dataready($dataC);
	$date_now = date("Y-m-d H:i:s");
	if(!empty($_POST['page_content_id'])) {
		$modified_on = date("Y-m-d H:i:s");
		// update
		// echo "update pages_content set page_title='".strip_tags($_POST['page_title'])."', modified_on='".$modified_on."', page_content='".$k."' where page_id=".$_POST['page_content_id'];
		$qry = $connect->query("update pages_content set page_title='".strip_tags($_POST['page_title'])."', modified_on='".$modified_on."', page_content='".$k."' where page_id=".$_POST['page_content_id']);
		
	} else{
		//insert
		$qry = $connect->query("insert into pages_content(page_title,page_content, created_on, is_active) VALUES ('".strip_tags($_POST['page_title'])."','".$k."','".$date_now."',1)");
	}
	if($qry) {
		$data['status'] = 1;
	} else{
		$data['errors'][] = "Something went wrong!";
	}
	// $connect->query("INSERT INTO pages_content(page_id,page_title,page_content, created_on, is_active, modified_on) VALUES (1,'kamal','".$k."',NOW(),1,NOW()) ON DUPLICATE KEY UPDATE page_content='.$k.'");
	header('Content-type: application/json');
	echo json_encode($data);
}
$connect->close();

?>