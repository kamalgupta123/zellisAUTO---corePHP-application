<?php 
	include 'inc/config.php'; 
	include 'inc/template_start.php';
	include 'inc/page_head.php';
	$obj->admin_not_login(); 
	$d_row = array();
	$us_id = $_SESSION['myuser']['us_id'];
	$sqlQry = $connect->query("select * from user where us_id=".$us_id);
	if($sqlQry->num_rows) {
		$d_row = $sqlQry->fetch_assoc();
		if(!empty($d_row['us_lock'])) {
			header("Location: ".SITEURL."dashboard.php");
		}
	}	
?>
	
<div id="page-content">
    <!-- Blank Header -->
	<?php if(!empty($_SESSION['myuser']['us_id'])) {
		$user_id = $_SESSION['myuser']['us_id'];
		$Usql = $connect->query("select * from zl_user_csv_info where user_id=".$user_id." and user_type=2");
		$d_row = array();
		if($Usql->num_rows>0) {
			$d_row = $Usql->fetch_assoc();
		}
	?>
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i><img class="zlogo" src="<?php echo SITEURL; ?>img/zlogo.png"></i>Automotive Parts Fitment System<br><small></small>
            </h1>
        </div>
    </div>
	<ul class="breadcrumb breadcrumb-top">
        <li>Dashboard</li>
        <li><a href="">Website Fitment</a></li>
    </ul>

    <div class="block">
        <div class="block-title" style="padding-bottom: 10px;">
            <img src="<?php echo SITEURL; ?>img/globe2.png" class="wf_logo" alt="eBay">
        </div>
		
		<div class="container" style="margin-top:20px;margin-bottom:20px;width:100% !important">
			<div class="full_width NewCSVUploadCont" style="display:<?php if(!empty($d_row)) { echo "none"; } else { echo "block"; } ?>">
				<div class="col-sm-6">
					<form method="POST" id="UploadCSVform">
						<div class="form-group">
							<p><b>Load Parts Finder Model List:</b></p>
							<label for="upload_csv" class="btn btn-default">Select CSV file</label>
							<input style="display:none;" id="upload_csv" type="file" name="upload_csv" class="">
							<span class="csv_filename"></span>
						</div>
						<p class="err_msgs"></p>
						<div class="form-group">
							<button type="submit" id="fileUplaod" class="btn btn-primary">Load</button>
						</div>
					</form>		
				</div>
				<div class="col-sm-6">
					<span><b>INSTRUCTIONS</b></span>
					<p>Our parts fitment system will show all vehicles where the entered field <br>values all match.  The first column of your CSV file must contain the codes <br>you want returned for each vehicle you lookup, and can have up to a <br>maximum of additional 16 columns for various attributes such as Make, <br>Model, Submodel, Year, Engine, Transmission etc.</p>
				</div>
			</div>
			<?php  if(!empty($d_row)) {
				$colsNames = json_decode($d_row['fields_name']);
				if(!empty($colsNames)) {
					$i=0;
			?>
			<div class="search_fields_form full_width">
				<div class="col-lg-12 FFnameCont"><span>Working in Fitment filename:</span><div> <?php if(!empty($d_row)) { echo $d_row['csv_name']; } ?>
					<a href="javascript:void(0);" class="full_width showUploadCSVForm">Load new CSV file</a></div>
				</div>
				<form id="SearchCSVForm">
				<?php
				foreach($colsNames as $key => $val) {
					if($i!=0) {
				?>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="<?php echo $key; ?>"><?php echo $val; ?></label>
							<input type="text" class="form-control" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="">
						</div>
					</div>
				<?php }
				$i++;
				} ?>
				<div class="full_width text-right">
				<button type="submit" class="btn btn-primary" id="searchSubmit">Search</button>
				</div>
				</form>
			</div>
			<div class ="search_query_results full_width" style="margin:20px;"></div>
			<?php }
			} 
			?>			
		</div>
	</div>
	<?php } else{
		echo "<div class='alert alert-danger'>Please login to select CSV file.</div>";
	}
	?>
</div>

<?php 
	include 'inc/page_footer.php';
	include 'inc/template_scripts.php'; 
	include 'extra_footer.php';
?>