<?php
ini_set('max_execution_time', 600);
include 'inc/database.php';
$obj->admin_not_login();

$d_row = '';
$us_id = $_SESSION['myuser']['us_id'];

$sqlQry = $connect->query("SELECT api_key,custom_field FROM `user` WHERE us_id =".$us_id);

if($sqlQry->num_rows) {
  $d_row = $sqlQry->fetch_assoc();
}

//echo $d_row['api_key'];


$body = array (
  'Filter' => 
  array (
    'IsActive' => 'True',
    "Page" => $_POST['page'],
    'Limit' => '200',
    "OrderBy" => "DateAdded",
    "OrderDirection" => "DESC",
    'OutputSelector' => 
    array (
      0 => 'ParentSKU',
      1 => 'SKU',
      2 => 'Brand',
      3 => 'Model',
      4 => 'Name',
      5 => 'Description',
      6 => $d_row['custom_field']
    ),
  ),
);

$bodyJSON = json_encode($body);
$url = "https://zellis.neto.com.au/do/WS/NetoAPI";

$method = "POST";
$headers = array(
    "Content-Type: application/json",
    "NETOAPI_ACTION: GetItem",
    "NETOAPI_KEY: ".$d_row['api_key'],
    "Accept: application/json"    
);    

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyJSON);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
$err = curl_error($ch);

curl_close($ch);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}

?>