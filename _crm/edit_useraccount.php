<?php include dirname(__FILE__).'/../inc/config.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_start.php'; ?>

<?php include dirname(__FILE__).'/../inc/page_head.php'; ?>

<style>#my_pchange_form .hideforua { display: none; } #my_pchange_form .hideforua + fieldset legend { display: none; } </style>

<?php $obj->check_admin_not_login(); 
		
$my_error = 0;
$current_userid = $_SESSION['admin']['id'];
$curuser_level = $_SESSION['admin']['user_level'];

if($curuser_level != 1){
	if($current_userid != $_GET['user_id'])
	{
		if(isset($_POST['edit_user_sub'])) {
			$myuser_id = strip_tags($_POST['my_userid']);
			if($myuser_id != $_GET['user_id']) {
				header('location: user_accounts.php');
				exit;
			}	
		}
		else {
			header('location: user_accounts.php');
			exit;
		}
	}
}

if(isset($_POST['edit_user_sub']))
{
	$fname = strip_tags($_POST['user_name']);
	$memail = strip_tags($_POST['user_first_name']);
	$memail1 = strip_tags($_POST['user_last_name']);
	$memail2 = strip_tags($_POST['user_email']);
	$memail3 = strip_tags($_POST['user_address']);
	$memail4 = strip_tags($_POST['user_suburb']);
	$memail5 = strip_tags($_POST['user_state']);
	$postcode = strip_tags($_POST['postcode']);
	$memail6 = strip_tags($_POST['user_country']);
	$myuser_id = strip_tags($_POST['my_userid']);
	$api_key = strip_tags($_POST['api_key']);
	$custom_field = strip_tags($_POST['custom_field']);

	if($fname == '')
	{
		$my_error = 1;
	}
	else
	{
		$minsert = "UPDATE `user` SET `us_username`='$fname', `us_first_name` = '$memail', `us_last_name` = '$memail1', `us_email` = '$memail2', `us_address` = '$memail3', `us_suburb` = '$memail4', `us_state` = '$memail5', `postcode` = '$postcode', `us_country` = '$memail6', api_key = '$api_key', custom_field = '$custom_field' where us_id = '$myuser_id'";
		$mqueryi	=	$connect->query($minsert);
		if($mqueryi)
		{
			$my_error = 2;
			
		}
	}	
}

if(isset($_POST['my_passchange_btn']))
{
	$myuser_id2 = $_POST['my_pchange_id'];

	$my_npass = strip_tags($_POST['my_unpass']);
	
	$minsert2 = "UPDATE `user` SET `us_password`=MD5('$my_npass') where us_id = '$myuser_id2'";
	$mqueryi2	=	$connect->query($minsert2);
	if($mqueryi2)
	{
		$my_error = 4;
	}			
}
?>

<!-- Page content -->

<div id="page-content">
    <!-- Blank Header -->
    <!-- END Blank Header -->
	    <div class="content-header">
			<div class="header-section">
				<h1><i><img class="zlogoA" src="<?php echo SITEURL; ?>img/zlogo.png"></i>Edit User Account<br><small></small></h1>
			</div>
		</div>
	    <ul class="breadcrumb breadcrumb-top">
			<li>Dashboard</li>
			<li>Users</li>
			<li><a href="">Edit User</a></li>
		</ul>

    <!-- Example Block -->
    <div class="block">
        <!-- Example Title -->
        <div class="block-title">
            <h2><i class="fa fa-pencil"></i> User Detail</h2>
        </div>
        <!-- END Example Title -->

		<?Php
			$user_id = $_GET['user_id'];
			$mselect1 = "SELECT * FROM `user` where us_id='$user_id'";
			
			$mquery1	=	$connect->query($mselect1);
			if ($mquery1->num_rows > 0) 
			{
				while($mresults1	=	$mquery1->fetch_assoc())
				{
					$my_user1 = $mresults1['us_username'];
					$my_user2 = $mresults1['us_first_name'];
					$my_user3 = $mresults1['us_last_name'];
					$my_user4 = $mresults1['us_email'];
					$my_user5 = $mresults1['us_address'];
					$my_user6 = $mresults1['us_suburb'];
					$my_user7 = $mresults1['us_state'];
					$my_user11 = $mresults1['postcode'];
					$my_user8 = $mresults1['us_country'];
					$my_user9 = $mresults1['api_key'];
					$my_user10 = $mresults1['custom_field'];
				}
				?>
				<!-- Example Content -->
				<div class="table-responsive">
					<form action="" method="POST" id="regform" class="form-horizontal form-bordered">
						<?php if($my_error == 1)
						{
							echo '<p class="error my_error">Name field is required</p>';
						}
						if($my_error == 2)
						{
							echo '<p class="success my_success">Information saved successfully</p>';
						}
						if($my_error == 4)
						{
							echo '<p class="success my_success">Password changed successfully</p>';
						}
						?>
						<div class="my_full form-group">
							<input type="hidden" value="<?Php echo $user_id; ?>" name="my_userid"/>
							<div class="col-md-6 col-sm-6 col-xs-12 my_left">
								<label class="col-md-3 control-label noPadd" for="user_name">User Name</label>
								<div class="col-md-5">
									<input type="text" id="user_name" name="user_name" class="form-control" value="<?php echo $my_user1; ?>">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 my_right">
								<label class="col-md-3 control-label noPadd" for="user_address">Address</label>
								<div class="col-md-9">
									<input type="text" id="user_address" name="user_address" class="form-control" value="<?php echo $my_user5; ?>">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 my_right">
								<label class="col-md-3 control-label noPadd" for="user_first_name">First Name</label>
								<div class="col-md-5">
									<input type="text" id="user_first_name" name="user_first_name" class="form-control" value="<?php echo $my_user2; ?>">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 my_right">
								<label class="col-md-3 control-label noPadd" for="user_suburb">Suburb</label>
								<div class="col-md-9">
									<input type="text" id="user_suburb" name="user_suburb" class="form-control" value="<?php echo $my_user6; ?>">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 my_right">
								<label class="col-md-3 control-label noPadd" for="user_last_name">Last Name</label>
								<div class="col-md-5">
									<input type="text" id="user_last_name" name="user_last_name" class="form-control" value="<?php echo $my_user3; ?>">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 my_right">
								<div>
								<label class="col-md-3 control-label noPadd" for="user_state">State</label>
								<div class="col-md-4">
									<input type="text" id="user_state" name="user_state" class="form-control" value="<?php echo $my_user7; ?>">
								</div>
								</div>
								<div>
								<label class="col-md-2 control-label noPadd" for="postcode">Postcode</label>
								<div class="col-md-3">
									<input type="text" id="postcode" name="postcode" class="form-control" value="<?php echo $my_user11; ?>">
								</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 my_right">
								<label class="col-md-3 control-label noPadd" for="user_email">Email</label>
								<div class="col-md-9">
									<input type="text" id="user_email" name="user_email" class="form-control" value="<?php echo $my_user4; ?>">
							</div>
							</div>
							
							<div class="col-md-6 col-sm-6 col-xs-12 my_right">
								<label class="col-md-3 control-label noPadd" for="user_country">Country</label>
								<div class="col-md-9">
									<input type="text" id="user_country" name="user_country" class="form-control" value="<?php echo $my_user8; ?>">
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 my_left grey-background">
								<div class="row APIKWrap">							
									<label class="col-md-3 control-label noPadd" for="api_key">Neto API Key</label>
									<div class="col-md-9">
										<input type="text" id="api_key" name="api_key" class="form-control" value="<?php if(!empty($my_user9)) { echo $my_user9; } ?>">
									</div>
								</div>
								<div class="row">
									<label class="col-md-3 control-label noPadd" for="custom_field">ePIDs Custom Field</label>
									<div class="col-md-4">
										<select class="form-control" name='custom_field' id='custom_field'>
											<?php for($i=1; $i<=52; $i++) { 
											if($i>=1 && $i<10){ ?>
													<option <?php if(!empty($my_user10) && $my_user10 == "Misc0".$i ) { echo "selected"; } ?> value="Misc0<?php echo $i; ?>">Misc0<?php echo $i; ?></option>
											<?php	}
												else{ ?>
													<option <?php if(!empty($my_user10) && $my_user10 == "Misc".$i ) { echo "selected"; } ?> value="Misc<?php echo $i; ?>">Misc<?php echo $i; ?></option>
											<?php	}   
											} ?>
										</select>
									</div>
								</div>
							</div>
						</div>	
						
						
						
						<?php // if($current_userid == 1){ ?>
							<div class="my_full form-group">
								<div class="col-md-6 col-sm-6 my_right">
									<div class="col-md-3"></div>
									<div class="col-md-6 col-sm-8 text_align_left">
										<button type="submit" class="btn btn-sm btn-primary" id="edit_user_sub" name="edit_user_sub"><i class="fa fa-floppy-o"></i> Save</button>
										<!-- <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button> -->
										
										<a id="my_cpassid" style="float: right;" href="javascript:void(0)" class="enable-tooltip btn btn-sm btn-danger" data-placement="bottom" title="" onclick="$('#modal-user-settings').modal('show');" data-original-title="Settings"><i class="gi gi-cogwheel" style="margin-right: 10px;"></i>Change Password</a>
									</div>
								</div>
							</div>
						<?php // }  ?>	
					</form>
					
				</div>
        <!-- END Example Content -->
		<?Php
			}
			else
			{
				echo '<p>Sorry No user Found!</p>';
			}
		?>
    </div>
		
</div>

<!-- END Page Content -->



<?php include dirname(__FILE__).'/../inc/page_footer.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_scripts.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_end.php'; ?>

<script>
	jQuery().ready(function() {	
		// validate signup form on keyup and submit
		jQuery("#my_pchange_form").validate({
			rules: {
				my_unpass: {
					required: true,
					minlength: 5
				},
				my_unpass1: {
					required: true,
					minlength: 5,
					equalTo: "#my_unpass"
				},
				
			},
			messages: {
				my_unpass: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				my_unpass1: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				
			}
		});
		jQuery("#regform").validate({
			rules: {
				user_name: "required",
			},
			messages: {
				user_name: "Please enter your name",
			}
		});
	});
</script>