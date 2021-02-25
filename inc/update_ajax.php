<?php include 'config.php';
$sql = "Select * from client_meta";
$result = $connect->query($sql);
$mdata = array();
while($results = $result->fetch_assoc()){
    $mdata[] = $results['cid'];
}
//print_r($mdata); die;
if(isset($_POST['action']) && $_POST['action'] == 'update_pos'){
    $data = $_POST['data'];
    $mn = 0;
    foreach($data as $k => $v){
        if (in_array($k,$mdata)){
            $sql1 = "UPDATE `client_meta` SET `position` = $v where `cid` = $k";
            $result1 = $connect->query($sql1);
            if($result){
            	$mn++;
            }
        }else{
        	$sql2 = "INSERT into `client_meta` (`cid`,`position`,`img_name`) values ($k,$v,'')";
        	$result2 = $connect->query($sql2);
        	if($result){
        		$mn++;
        	}
        }
    }
    if($mn > 0){
    	echo 1;
    }
}
?>