<?php include dirname(__FILE__).'/../inc/config.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_start.php'; ?>

<?php include dirname(__FILE__).'/../inc/page_head.php'; ?>

<?php $obj->check_admin_not_login(); ?>
<style>td.opener {cursor: pointer;}</style>
<!-- Page content -->
<?php

$current_userid = $_SESSION['admin']['id'];
$user_level = $_SESSION['admin']['user_level'];
if($current_userid == 1 || $user_level == 1)
{
	$my_error = 0;	
	$my_cuserc = '';
	if(isset($_GET['user_id']))
	{
		$muser_id = $_GET['user_id'];
		$muser_id2 = 0;
		
		if($muser_id != 1)
		{
			$msel = "DELETE FROM `user` WHERE `us_id`='$muser_id'"; 
			$mqueryuisel	=	$connect->query($msel);
			if($mqueryuisel)
			{
				$my_error = 1;
			}
		}
	}
}
?>
<div id="page-content">
    <!-- Blank Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
            <!--<i><img class="zlogoA" src="<?php //echo SITEURL; ?>img/zlogo.png"></i>  -->
            All Users Accounts<br><small></small></h1>
        </div>
    </div>
	<ul class="breadcrumb breadcrumb-top">
		<li>Dashboard</li>
		<li><a href="">Users Accounts</a></li>
    </ul>
    <!-- END Blank Header -->

    <!-- Example Block -->
    <div class="block">
        <!-- Example Title -->
        <div class="block-title">
            <h2>Users</h2>
        </div>
        <!-- END Example Title -->

        <!-- Example Content -->
		<div class="table-responsive">
			<?php if($my_error == 1)
			{
				echo '<p class="error my_error no_padd">User Account Deleted Successfully</p>';
			}
			if($my_error == 2)
			{
				echo '<p class="success my_success no_padd">User <b>'.$my_cuserc.'</b> Activate Successfully</p>';
			}
			if($_GET['newid'])
			{
				echo '<p class="success my_success no_padd">New User Account Added Successfully</p>';
			}
			
			if($current_userid == 1 || $user_level == 1) {
			?>		
			<div class="table-options clearfix">
				<a href="new_useraccount.php">
					<div class="btn-group btn-group-sm pull-left">
						<label id="style-default" class="btn btn-primary active" data-toggle="tooltip" title="Add User">Add New User</label>
					</div>
				</a>	
			</div>
			<?php
			}
				$mi = 1;
				$mselect1	=	"SELECT * FROM `user` ORDER BY us_id ASC";
				$mquery1	=	$connect->query($mselect1);
				if ($mquery1->num_rows > 0) 
				{
					?>
					<div class="table-responsive">
						<div class="err_msgs"></div>
						<table id="example-datatable1" class="table table-hover table-vcenter table-condensed table-bordered userWrapTable">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th>Username</th>
									<th>Name</th>
									<th>Email</th>
									<th>State</th>
									<th>Country</th>
									<th>Neto Connected</th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php
								while($mresults1	=	$mquery1->fetch_assoc())
								{
									?> 
									<tr>
										<td class="text-center"><?php echo $mi; ?></td>
										<td><a href="edit_useraccount.php?user_id=<?php echo $mresults1['us_id']; ?>"><?php echo $mresults1['us_username']; ?></a></td>
										<td><?php echo $mresults1['us_first_name']." ".$mresults1['us_last_name']; ?></td>
										<td><?php echo $mresults1['us_email']; ?></td>
										<td><?php echo $mresults1['us_state']; ?></td>
										<td><?php echo $mresults1['us_country']; ?></td>
										<td><?php if(!empty($mresults1['api_key']) && !empty($mresults1['custom_field'])) { echo '<i class="fa fa-check" aria-hidden="true"></i>'; } ?></td>
										<td class="text-center">
											<div class="btn-group">
												<button title="Lock" class="btn btn-sm btn-primary lock-unlock <?php if(!empty($mresults1['us_lock'])) { echo "UnlockWrap"; }else{ echo "LockWrap"; } ?>" data-id="<?php echo $mresults1['us_id']; ?>"><?php if(!empty($mresults1['us_lock'])) { echo "Unlock"; }else{ echo "Lock"; } ?> &nbsp;<i class="fa fa-lock"></i></button>

												<a href="edit_useraccount.php?user_id=<?php echo $mresults1['us_id']; ?>"  title="Edit" class="btn btn-sm btn-success">Edit &nbsp;<i class="fa fa-pencil"></i></a>
												 
												<a href="?user_id=<?php echo $mresults1['us_id']; ?>" class="btn btn-sm btn-danger" title="Delete User"
												onclick="return confirm('Are you sure, you want to Delete this user?')">Delete &nbsp;<i class="fa fa-times"></i></a>
												
											</div>
										</td>
									</tr>
									<?php
									$mi++;
									
								}
								?>
							</tbody>
						</table>
					</div>
						<?php
				}
				else
				{
					echo 'No User Found';
				}
			?>
        </div>
        <!-- END Example Content -->
    </div>
    <!-- END Example Block -->
</div>

<!-- END Page Content -->
<script>
$(document).ready(function(){ 
	// $lock = 1;
	$(document).on('click', '.lock-unlock', function(e) {
			var user_id_lock = $(this).attr('data-id');
			$.ajax({
				type: "POST",
				url: "lock.php",
				// data:{user_id_lock:user_id_lock, "Lock_UnLockSubmit":'action'},
				data: "user_id_lock="+user_id_lock+"&Lock_UnLockSubmit=action",
				success: function(data) {
					// console.log('success');	
					if(typeof data == 'object'){
						if(data.errors==""){
							$('.err_msgs').html("");
							// $(".succ_msgs").html("<div class='alert alert-success'>Successfully Saved.</div>");
							// window.location.href = SITE_URL+"_crm/page_content_list.php";
							window.location.reload();
						}
						else{
							var error_msg = "";
							$.each(data.errors, function( index, error ) {
								error_msg += "<li>"+error+"</li>";
							});
							if(data.errors!="") {
								$('.err_msgs').html("<div class='alert alert-danger'>"+error_msg+"</div>");
							}
						}
					}
					else{
						// UIkit.notification(data, "danger");
						$('.err_msgs').html("<div class='alert alert-danger'>"+data+"</div>");
					}
				}
			});
		return false;	
	});
});
</script>



<?php include dirname(__FILE__).'/../inc/page_footer.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<!--script src="js/pages/tablesDatatables.js"></script>
<script>$(function(){ TablesDatatables.init(); });</script-->