<?php include dirname(__FILE__).'/../inc/config.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_start.php'; ?>

<?php include dirname(__FILE__).'/../inc/page_head.php'; ?>

<?php $obj->check_admin_not_login(); 
		
$my_error = 0;

$current_userid = $_SESSION['admin']['id'];
$curuser_level = $_SESSION['admin']['user_level'];

if($curuser_level != 1){
	header('location: users.php');
	exit;
}

if(isset($_POST['add_user_sub'])) {
	$fname = $_POST['user_name'];
	$first_name = $_POST['user_first_name'];
	$last_name = $_POST['user_last_name'];
	$uemail = $_POST['user_email'];
	$address = $_POST['user_address'];
	$suburb = $_POST['user_suburb'];
	$state = $_POST['user_state'];
	$postcode = $_POST['postcode'];
	$country = $_POST['user_country'];
    $mypinfo = $_POST['user_pass'];
	$api_key = strip_tags($_POST['api_key']);
	$custom_field = strip_tags($_POST['custom_field']);
	
	$msql = "INSERT into `user` (`us_username`,`us_first_name`, `us_last_name`,`us_email`, `us_address`, `us_suburb`, `us_state`, postcode, `us_country`,  `us_password`,api_key,custom_field) VALUES ('$fname','$first_name','$last_name', '$uemail','$address','$suburb','$state','$postcode','$country', MD5('$mypinfo'), '$api_key', '$custom_field')";

	echo $msql;
	
	if ($connect->query($msql) === TRUE ) 
	{
		$last_id = $connect->insert_id;
		header("Location: new_useraccount.php?newid=".$last_id);
		die();
	}
	else 
	{
		echo "Error: " . $msql . "<br>" . $connect->error;
	}		
}
if( $_GET['newid'] && $_GET['newid'] != '' ){
	$mselect1	=	"SELECT * FROM `user` ORDER BY us_id DESC LIMIT 1";
	$mqueryi	=	$connect->query($mselect1);
	$res_first	=	$mqueryi->fetch_assoc();
	$my_error = 1; 
}
?>

<!-- Page content -->

<div id="page-content">

    <!-- Blank Header -->

    

    <!-- END Blank Header -->

	    <div class="content-header">

        <div class="header-section">

            <h1>

                <i><img class="zlogoA" src="<?php echo SITEURL; ?>img/zlogo.png"></i>Add User Account<br><small></small>

            </h1>

        </div>

    </div>
	
	    <ul class="breadcrumb breadcrumb-top">

        <li>Dashboard</li>

        <li>Users</li>

        <li><a href="">Add User</a></li>

    </ul>


    <!-- Example Block -->

    <div class="block">

        <!-- Example Title -->

        <div class="block-title">

            <h2><i class="fa fa-pencil"></i> User Detail</h2>

        </div>

        <!-- END Example Title -->

        <!-- Example Content -->

       <div class="table-responsive">
			<form action="" method="POST" id="regform" class="form-horizontal form-bordered">
				<?php if($my_error == 1)
				{
					$res_name = $res_first['us_username'];
					echo '<p class="success my_success">User '.$res_name.' created successfully.</p>';
				}
				?>
				<div class="my_full form-group">
					<div class="col-md-6 col-sm-6 col-xs-12 my_left">
						<label class="col-md-3 control-label noPadd" for="user_name">User Name</label>
						<div class="col-md-5">
							<input type="text" id="user_name" name="user_name" class="form-control" placeholder="User Name">
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 my_right">
						<label class="col-md-3 control-label noPadd" for="user_address">Address</label>
						<div class="col-md-9">
							<input type="text" id="user_address" name="user_address" class="form-control" placeholder="Address">
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 my_right">
						<label class="col-md-3 control-label noPadd" for="user_first_name">First Name</label>
						<div class="col-md-5">
							<input type="text" id="user_first_name" name="user_first_name" class="form-control" placeholder="First Name">
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 my_right">
						<label class="col-md-3 control-label noPadd" for="user_suburb">Suburb</label>
						<div class="col-md-9">
							<input type="text" id="user_suburb" name="user_suburb" class="form-control" placeholder="Suburb">
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 my_right">
						<label class="col-md-3 control-label noPadd" for="user_last_name">Last Name</label>
						<div class="col-md-5">
							<input type="text" id="user_last_name" name="user_last_name" class="form-control" placeholder="Last Name">
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 my_right">
						<div>
						<label class="col-md-3 control-label noPadd" for="user_state">State</label>
						<div class="col-md-4">
							<input type="text" id="user_state" name="user_state" class="form-control" placeholder="State">
						</div>
						</div>
						<div>
						<label class="col-md-2 control-label noPadd" for="postcode">Postcode</label>
						<div class="col-md-3">
							<input type="text" id="postcode" name="postcode" class="form-control" placeholder="Postcode">
						</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 my_right">
						<label class="col-md-3 control-label noPadd" for="user_email">Email</label>
						<div class="col-md-9">
							<input type="text" id="user_email" name="user_email" class="form-control" placeholder="Email">
						</div>
					</div>
					
					<div class="col-md-6 col-sm-6 col-xs-12 my_right">
						<label class="col-md-3 control-label noPadd" for="user_country">Country</label>
						<div class="col-md-9">
							<input type="text" id="user_country" name="user_country" class="form-control" placeholder="Country">
						</div>
					</div>
					
				</div>	
				
				
				<div class="my_full form-group">
					<div class="col-md-6 my_left">
						<label class="col-md-3 control-label" for="user_pass">Password</label>
						<div class="col-md-9">
							<input type="password" id="user_pass" name="user_pass" class="form-control" placeholder="Password">
						</div>
					</div>
					
					<div class="col-md-6 my_right">
						<label class="col-md-3 control-label" for="user_cpass">Confirm Password</label>
						<div class="col-md-9">
							<input type="password" id="user_cpass" name="user_cpass" class="form-control" placeholder="Password">
						</div>
					</div>
					
					<div class="col-md-6 col-sm-6 col-xs-12 my_left grey-background">
						<div class="row APIKWrap">							
							<label class="col-md-3 control-label noPadd" for="api_key">Neto API Key</label>
							<div class="col-md-9">
								<input type="text" id="api_key" name="api_key" class="form-control" placeholder="Neto API Key">
							</div>
						</div>
						<div class="row">
							<label class="col-md-3 control-label noPadd" for="custom_field">ePIDs Custom Field</label>
							<div class="col-md-4">
								<select class="form-control" name='custom_field' id='custom_field'>
									<?php for($i=1; $i<=52; $i++) { 
									if($i>=1 && $i<10){ ?>
											<option value="Misc0<?php echo $i; ?>">Misc0<?php echo $i; ?></option>
									<?php	}
										else{ ?>
											<option value="Misc<?php echo $i; ?>">Misc<?php echo $i; ?></option>
									<?php	}   
									} ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			
				<div class="my_full form-group">
					<div class="col-md-6 my_right">
						<label class="col-md-3 control-label" for="user_status">&nbsp;</label>
						<div class="col-md-9 text_align_left">
							<button type="submit" class="btn btn-sm btn-primary" id="add_user_sub" name="add_user_sub"><i class="fa fa-floppy-o"></i> Save</button>
							<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
						</div>
					</div>
				</div>
			</form>
            
        </div>
        <!-- END Example Content -->

    </div>
		
</div>

<!-- END Page Content -->



<?php include dirname(__FILE__).'/../inc/page_footer.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_scripts.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_end.php'; ?>

<script>
	

	$().ready(function() {
		
		// validate signup form on keyup and submit
		$("#regform").validate({
			rules: {
				user_name: "required",
				user_pass: {
					required: true,
					minlength: 5
				},
				user_cpass: {
					required: true,
					minlength: 5,
					equalTo: "#user_pass"
				},
			},
			messages: {
				user_name: "Please enter your name",
				user_pass: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				user_cpass: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
			}
		});

	});
	</script>