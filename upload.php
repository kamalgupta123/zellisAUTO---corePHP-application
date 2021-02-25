<?php
include dirname(__FILE__).'/inc/config.php';
//upload.php
// print_r($_FILES); die;
if(isset($_FILES['upload'])){
	$url = "";
	if(isset($_FILES["upload"]) && $_FILES["upload"]["name"]!=""){
		$user_id = $beautifier_id; // please change 0 with actual user id.
		$target_dir1 = dirname(__FILE__)."/img/ck-files/";
		$name1 = pathinfo($_FILES["upload"]["name"], PATHINFO_FILENAME);
		$extension1 = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);
		$name1 = (strlen($name1) > 150) ? substr($name1,0,150) : $name1; 
		$increment1 = "";
		while(file_exists($target_dir1.$name1.$increment1.".".$extension1)) {
			$increment1++;
		}
		$new_name1 = $name1.$increment1.".".$extension1;
		
		$target_file1_url1 = "/img/ck-files/".$new_name1;
		$target_file1 = $target_dir1 . $new_name1;
		$imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
		// Check file size
	/* 	if ($_FILES["upload"]["size"] > MAX_FILE_SIZE) {
			$data["errors"][] = "Sorry, image file size can't be greater than ".bytesToSize(MAX_FILE_SIZE).".";
		} */
		// Allow certain file formats
		$allowed_extentions = array("jpg","jpeg","png","gif");
		$allowed_extensions_string = implode(" , ",$allowed_extentions);
		if(!in_array(strtolower($imageFileType),$allowed_extentions)) {
			$data["errors"][] = "Sorry, only ".$allowed_extensions_string." files are allowed for image file.";
		}
		if (!is_dir($target_dir1) && !mkdir($target_dir1, 0777, true)){
			$data["errors"][] = "Error creating folder $target_dir1";
		}
		// $upload="'".safe_str($target_file1_url1)."'";
		if(empty($data["errors"])){
			$file = $_FILES["upload"]["tmp_name"];
			/* list($width, $height) = getimagesize($file);
			$max_img_size = 1000;
			if(($width > $max_img_size)||($height > $max_img_size)){
				smart_resize_image($file , null, $max_img_size , $max_img_size , true , $target_file1, false,false,80);
			}
			else { */
				move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file1);
				//file uploaded
			// }
			$url = trim($target_file1_url1,"/");
		}
	}
	
	if(empty($data["errors"]) && !empty($url)){
		$message = '';
	}
	else{
		$message = addslashes(strip_tags(implode(',',$data["errors"])));
	}
	$funcNum = $_GET['CKEditorFuncNum'] ;
	
	echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum,'$url','$message');</script>";
}


?>