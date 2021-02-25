<?php 
	include 'inc/database.php';
	$obj->admin_not_login();
	
	if(isset($_POST['set_rows_per_page']))
	{
		$_SESSION['rows_per_page'] = $_POST['rows_per_page'];
		// print_r($_SESSION);
	}
	
	if(isset($_POST['SubmitSelectFields']))
	{
		// print_r($_POST);  die;
		if(!empty($_SESSION['myuser']['us_id'])) {
			$user_id = $_SESSION['myuser']['us_id'];
			if(!empty($_POST['Fnames'])) {
				$selectArr = array(); $i=0;
				foreach($_POST['Fnames'] as $key => $val) {
					
					$selectArr['sel_'.$i] = $key;
					$i++;
				} 
				//echo $i+1;
				//$selectArr['sel_'.$i+1]='ePID';
				//$selectArr['sel_'.$i+2]='Ktype';
				if(!empty($selectArr)) {
					$JEselectArr = json_encode($selectArr);
					$connect->query("update user set show_customise_fields='".$JEselectArr."' where us_id=".$user_id);
					echo "1";
				}
			} else{
				echo "Please select one field to show in search result.";
			}
		}
		else{
			echo "Please login to upload csv file.";
		}
	}
	
	
	if(isset($_POST['customize_fields']))
	{
		if(!empty($_SESSION['myuser']['us_id'])) {
			$user_id = $_SESSION['myuser']['us_id'];
			$sqlQry =  $connect->query("select * from user where us_id=".$user_id);
			if($sqlQry->num_rows) {
				$d_row = $sqlQry->fetch_assoc();
			$sel="SHOW COLUMNS from data";
			$result = $connect->query($sel);
			// echo $result->num_rows;
			if($result->num_rows>0) { 
				
				$checked=json_decode($d_row['show_customise_fields'],true);
				
			?>
			<span class="err err1"></span>
			<?php
			while($row = $result->fetch_assoc()){
				if($row['Field']=='ePID' || $row['Field']=='Ktype')
				{
				}
				else
				{
				?>
				<div class="form-group">
				<input type="checkbox" class="checkboxField" id="<?php echo $row['Field']; ?>1" name="Fnames[<?php echo $row['Field']; ?>]" value="1" <?php if(in_array($row['Field'],$checked)) echo "checked";?>><label for="<?php echo $row['Field']; ?>1" class="Lnames"><b><?php echo $row['Field']; ?></b></label>
			</div>
			<?php
				}
			}			
			?>
			<button type="submit" class="btn btn-primary">Submit</button>
			<?php
			}
			} else{
				echo "<div class='alert alert-danger'>User does not exist.</div>";
			}
		} else {
			echo "<div class='alert alert-danger'>Please login to select field.</div>";
		} 
	}


	if(isset($_POST['UploadCSVData'])) {
		$data = array(
			"status"=>0,
			"errors"=>array(),
			"id"=>0,
			"html" => ''
		);
		// print_r($_SESSION); die;
		if(!empty($_SESSION['myuser']['us_id'])) {
		$user_id = $_SESSION['myuser']['us_id'];
		$cDate = date("Y-m-d H:i:s");
		$allowed_extentions = array('csv');
		// print_r($_FILES); die;
		if(isset($_FILES["upload_csv"])&&$_FILES["upload_csv"]["name"]!=""){
			$target_dir1 = BASE_DIR."/uploads/files_path/";
			$name1 = pathinfo($_FILES["upload_csv"]["name"], PATHINFO_FILENAME);
			$extension1 = pathinfo($_FILES["upload_csv"]["name"], PATHINFO_EXTENSION);
			$name1 = (strlen($name1) > 150) ? substr($name1,0,150) : $name1;
			$increment1 = "";
			$new_name1 = $name1.$increment1.".".$extension1;

			$target_file1 = $target_dir1 . $new_name1;
			$imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
			
			// Check file size
			if ($_FILES["photo_input"]["size"] > MAX_FILE_SIZE) {
				$data["errors"][] = "Sorry, Photo file size can't be greater than ".bytesToSize(MAX_FILE_SIZE).".";
			}
			// Allow certain file formats
			// $allowed_extentions = json_decode($allowed_extentions);
			if(!in_array(strtolower($imageFileType),$allowed_extentions)) {
				$allowed_extensions_string = implode(" , ",$allowed_extentions);
				$data["errors"][] = "Sorry, only ".$allowed_extensions_string." files are allowed for File.\n";
			}
		}
		if(empty($data["errors"])){
			// check file is uploaded or not
			$Usql = $connect->query("select * from zl_user_csv_info where user_id=".$user_id." and user_type=2");
			if($Usql->num_rows>0) {
				// if user already uploads csv then delete the table
				$connect->query("delete from zl_user_csv_info where user_id=".$user_id." and user_type=2");
				$connect->query("drop table zl_csv_".$user_id);
			}
			$file = fopen($_FILES["upload_csv"]["tmp_name"],"r");

			if ($file !== FALSE) {
				$i=0;$str='';
				$error=0;$row_arr=array();
				while(($data_f = fgetcsv($file,  0, ",","'")) !== FALSE)
				{
					if($i==0) {
						$arr = array(); $valSqlArr=array();
						foreach($data_f as $key => $values) {
							$arr["col_".$key] = safe_str($values);
						}
						if(!empty($arr)) {
							$json_str = json_encode($arr);
							$sql = "insert into zl_user_csv_info (user_id,user_type,csv_name,fields_name,created_on) VALUES ('".$user_id."','2','".$new_name1."','".$json_str."','".$cDate."')";
							// echo $sql;
							$aresult = $connect->query($sql);
							// create table as csv file uploaded
							$Csql = "CREATE TABLE zl_csv_".$user_id." (";
							$j=1; $count = count($arr);$tt='';
							foreach($arr as $ColNames => $v) {
								$Csql .= $ColNames.' varchar(255) COMMENT "'.safe_str($v).'"';
								if($j<$count) {
									$Csql .= ",";
								}
								$j++;
							}
							$Csql .= ")";
							// echo $Csql;
							$rr = $connect->query($Csql);
							$valSql = "insert into zl_csv_".$user_id." (`".implode("`, `", array_keys($arr))."`) VALUES";
						} 
					} else {
						
						/* // insert enteries in newly created table
						$valSql = "insert into zl_csv_".$user_id." (`".implode("`, `", array_keys($arr))."`) VALUES ('".implode("', '", $data_f)."')";
						// echo $valSql;
						$rr11 = $connect->query($valSql); */
						
						$valSqlArr[] = " ('".implode("', '", $data_f)."')";
						
					} 
					$i++;
				}
				$valSql = $valSql.implode(",",$valSqlArr);
				// echo $valSql;
				$rr11 = $connect->query($valSql);
			}
		}
		} else{
			$data['errors'][] = "Please login to upload csv file.";
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}
	
	if(isset($_POST['SearchCSVSubmit'])) {
		if(!empty($_SESSION['rows_per_page'])) { $rr = $_SESSION['rows_per_page']; }else{ $rr= ROWS_PER_PAGE; }
		$data = array(
			"RowSize"=>$rr,
			"errors"=>array(),
			"id"=>0,
			"html" => ''
		);
		$str='';
		if(!empty($_SESSION['myuser']['us_id'])) {
			$user_id = $_SESSION['myuser']['us_id'];
			$Usql = $connect->query("select * from zl_user_csv_info where user_id=".$user_id." and user_type=2");
			$d_row = array(); $colsNames = array();
			if($Usql->num_rows>0) {
				$d_row = $Usql->fetch_assoc();
				$colsNames = json_decode($d_row['fields_name']);
			}//print_r($colsNames);
			if(!empty($colsNames)) {
				 $count=count($colsNames);
				foreach($colsNames as $key => $val) {
					if(!empty($_POST[$key])) {
						$str .= $key." LIKE '%".safe_str($_POST[$key])."%'";
						    
							$str=$str.' AND '; 
						
					}
					
				}
				$str=rtrim($str," AND ");
				
			}
		}
		 //echo $str;
		if(!empty($str)) {
			
			$asql = "SELECT * FROM zl_csv_".$user_id."  WHERE ".$str;
			$aresult = $connect->query($asql);
			$data["count"] = $aresult->num_rows;
			if ($aresult->num_rows > 0) {
				// output data of each row
				if(empty($data['html'])) {
					// only if $data['html'] is empty
									
					$data['html'] .= '<div class="row sg_cpyR">
							<div class="col-md-12">
								<label class="col-md-2">Internal ID</label>
								<div class="col-md-8">
									<input type="text" class="form-control get_all_i_id" />
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-info" id="copy_Internal_id" disabled>Copy Internal ID</button>
								</div>
							</div>
						</div>';
					$data['html'] .= '<div class="table-responsive"><table class="display table-striped nowrap responsive" style="width:100%" id="my_search_table">
					<thead>
					  <tr><th class="nosort"><input type="checkbox" id="selectallR" title="Select all"></th>';
						 foreach($colsNames as $key => $val) {
							$data['html'] .= '<th>'.$val.'</th>';
						} 
					$data['html'] .= '</tr></thead><tbody>';
				}
				
				while($row = $aresult->fetch_assoc()) {
					//echo "hi";
					$data['html'].='<tr>';
					//echo "<pre>";
					$data['html'].='<td><input type="checkbox" name="select[]" class="sgt_chkR" 
					data-i-id="'.$row[col_0].'" ></td>';
					foreach($row as $k=>$v)
					{
						$data['html'].='<td>'.$v."</td>";
					}
					$data['html'].='</tr>';
				}
				//$data['html'].='</tbody>';
			}
		}
		if(empty($data['html'])) {
			$data['html'] = '<div class="alert alert-danger">No data found!</div>';
		} else {
			// close tbody and table tag
			$data['html'] .= '</tbody></table></div>';
		}
		header('Content-type: application/json');
		echo json_encode($data);
	} 
	



	
	if(isset($_POST["search_data"]))
	{
		if(!empty($_SESSION['rows_per_page'])) { $rr = $_SESSION['rows_per_page']; }else{ $rr= ROWS_PER_PAGE; }
		$data = array(
			"RowSize"=>$rr,
			"html" => ''
		);
		// print_r($_POST);
		$Make = $_POST["Make"];
		$Model = $_POST["Model"];
		$Submodel = $_POST['Submodel'];
		$Year = $_POST['Year'];
		
		$str='';
		
		if($Make!=''){ 
			$str=$str." AUM_Make='".$Make."' "; 
		}
		if($Model!=''){ 
			if($str!=''){ 
				$str=$str.' AND '; 
			}
			$str=$str." AUM_Model='".$Model."' ";
		}
		if($Submodel!=''){ 
			if($str!=''){ 
				$str=$str.' AND '; 
			}
			$str=$str." AUM_Submodel Like '%".$Submodel."%' ";
		}
		if($Year!=''){ 
			if($str!=''){ 
				$str=$str.' AND '; 
			}
			$str=$str." Year Like '%".$Year."%' ";
		}
		
		$asql = "SELECT * FROM motercycle  WHERE ".$str.";";
		$aresult = $connect->query($asql);
		
		/*-----*/
		if(!empty($_SESSION['myuser']['us_id'])) {
			$user_id = $_SESSION['myuser']['us_id'];
			$sqlQry =  $connect->query("select * from user where us_id=".$user_id);
			if($sqlQry->num_rows) {
				$d_row = $sqlQry->fetch_assoc();
			   // print_r($d_row);
			}
			$fields=json_decode($d_row['show_customise_motor_fields'],true);
		}
		/*-----*/
		
		if ($aresult->num_rows > 0) {
			// output data of each row
			$data['html'].= '<div class="row sg_cpyR"><div class="col-md-12"><label class="col-md-2">ePID</label>
			<div class="col-md-8"><input type="text" class="form-control get_all_epid" /></div>
			<div class="col-md-2"><button type="button" class="btn btn-info" id="copyEpid" disabled>Copy ePids</button></div></div></div>';
			
			$data['html'].= '<div class="row sg_cpyR"><div class="col-md-12"><label class="col-md-2">K-Type</label>
			<div class="col-md-8"><input type="text" class="form-control get_all_ktype" /></div>
			<div class="col-md-2"><button type="button" class="btn btn-info" id="copyKtype" disabled>Copy K-Types</button></div></div></div>';
			
			$data['html'].= '<table class="table table-striped" id="my_search_table">
			<thead>
			  <tr><th class="nosort"><input type="checkbox" id="selectall" title="Select all"></th>';
			 //  	$data['html'].= '<th>ePID</th>';
				// $data['html'].= '<th>Power</th>';
				// $data['html'].= '<th>Make</th>';
				// $data['html'].= '<th>Model</th>';
				// $data['html'].= '<th>Sub-Model</th>';
				// $data['html'].= '<th>Year</th>';
				// $data['html'].= '<th>Ktype</th>';
				// $data['html'].= '<th>Ktype</th>';
			  if(!empty($fields)){
				  foreach($fields as $k=>$v)
				  {		
				  		if (strpos($v, 'AUM_') !== false) {
							$v= str_replace("AUM_", "",$v);
						}else{
							
						}
					 $data['html'].= '<th>'.$v.'</th>';
					 
				  }
				  
			  }
			  $data['html'].= '<th>ePID</th>';
			  $data['html'].= '<th>Ktype</th>';
			  $data['html'].= '</tr></thead><tbody>';
			while($row = $aresult->fetch_assoc())
			{
				//print_r($row);
				$mepid = $row["ePID"];  $mktype = $row["Ktype"];  
				$data['html'].= "<tr>
				<td><input type='checkbox' name='select[]' class='sgt_chk' epid='".$row['ePID']."' ktype='".$row['Ktype']."' > </td>";

				// $data['html'].= '<td>'.$row['ePID'].'</td>';
				// $data['html'].= '<td>'.$row['AUM_Power'].'</td>';
				// $data['html'].= '<td>'.$row['AUM_Make'].'</td>';
				// $data['html'].= '<td>'.$row['AUM_Model'].'</td>';
				// $data['html'].= '<td>'.$row['AUM_Submodel'].'</td>';
				// $data['html'].= '<td>'.$row['Year'].'</td>';
				// $data['html'].= '<td>'.$row['mlv'].'</td>';
				// $data['html'].= '<td>'.$row['Ktype'].'</td>';
					
				foreach($row as $k=>$v)
				{
					if(in_array($k,$fields))
					{
						$data['html'].= '<td>'.$row[$k].'</td>';
					}
				}
				
				$data['html'].= '<td>'.$mepid.'</td>';
				$data['html'].= '<td>'.$mktype.'</td>';
				$data['html'].= '</tr>';
			}	
			
			$data['html'].= '</tbody></table>';
		} else {
			$data['html'].= "<div class='col-lg-offset-4 col-lg-4'>Sorry, No Result found...!!!<div>";
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}
	

	if(isset($_POST["content_search"]))
	{
		 $bsql = "SELECT Content_ID,External_Reference FROM content_table";
		 $bresult = $connect->query($bsql);
		 if ($bresult->num_rows > 0) {
				 while($row = $bresult->fetch_assoc()) {
					  
					  $content[$row["Content_ID"]] =$row["External_Reference"];
				 }
				  $data = json_encode($content);
				 echo $data;
		 } else {
			echo "<div class='col-lg-offset-4 col-lg-4'>Sorry, No Result found...!!!<div>";
		}
	}
	
	if(isset($_POST["NeedHelpMail"])) {
		$to = 'tim@zellis.com.au';
		// $to = 'payal@satgurutechnologies.com';
		$msg = "<div style='border: 2px solid #6ad2eb; padding: 20px; box-sizing: border-box; width: 100%; max-width: 600px; margin: auto;background:white;color: black;font-size: 16px;'>";
		$subject = $_POST['name'].' Need Help?';
		$msg .= "Hi Admin,<br><br><b>User's Name:</b> ".$_POST['name']."<br><b>User's Email:</b> ".$_POST['email']."<br><b>User's Message:</b><br>".$_POST['msg'];
		$msg .= "<div style='margin-top: 30px;padding-top: 10px;border-top: 1px solid;'>Thank You</div>";
		$msg .= "</div>";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		mail($to, $subject, $msg,$headers);
		echo 1;
	}
	$connect->close();
?>