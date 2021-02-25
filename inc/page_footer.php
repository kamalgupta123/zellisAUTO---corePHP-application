<?php
$user_name='';
if(!empty($_SESSION['myuser']['us_id'])) {
	$us_id = $_SESSION['myuser']['us_id'];
	$sqlQry = $connect->query("select * from user where us_id=".$us_id);
	if($sqlQry->num_rows) {
		$d_row = $sqlQry->fetch_assoc();
		$user_name=$d_row['us_username']; 
	}
}
/**
 * page_footer.php
 *
 * Author: pixelcave
 *
 * The footer of each page
 *
 */
?>
        <!-- Footer -->
        <footer class="clearfix">
            <div class="pull-right" style="color:#000;">
				<ul class="footLinks" style="font-size: 14px;">
                <!--li>Crafted with <i class="fa fa-heart text-danger"></i> by <a href="http://satgurutechnologies.com/" target="_blank">satgurutechnologies</a></li-->
				<li>Copyright &copy; <?php echo date('Y'); ?> – Unified Commerce Solutions Pty Ltd ABN: 92 642 452 926</li>
				</ul>
            </div>
            <?php if(strpos($_SERVER['REQUEST_URI'], "/_crm/") === false){ ?>
            <a href="javascript:void(0)" title="Help" class="help_link"><img src="<?php echo SITEURL; ?>img/help2.png"></a>
			<?php } ?>
        </footer>
        <!-- END Footer -->
    </div>
    <!-- END Main Container -->
</div>
<!-- END Page Container -->

<!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
<a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>

<div class="modal fade" tabindex="-1"  id="CustomizeFieldsModal" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
	<!-- Modal content-->
		<div class="modal-content full_width">
			<div class="modal-header ">
				<button type="button" class="close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 style="color:#000;" class="modal-title"><b>Select Fields for search result</b></h4>
			</div>
			<div class="modal-body CustomizeFieldsBody full_width">
				<form id="CustomizeFieldsForm" ></form>
				<div class="err_msgs"></div>
			</div>
		</div>
	</div>
</div>




<div class="modal fade" tabindex="-1"  id="CustomizeFieldsMotorModal" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
	<!-- Modal content-->
		<div class="modal-content full_width">
			<div class="modal-header ">
				<button type="button" class="close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 style="color:#000;" class="modal-title"><b>Select Fields for search result</b></h4>
			</div>
			<div class="modal-body CustomizeFieldsBody full_width">
				<form id="CustomizeFieldsMotorForm" ></form>
				<div class="err_msgs"></div>
			</div>
		</div>
	</div>
</div>




<div class="modal fade" tabindex="-1"  id="NeedHelpModal" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
	<!-- Modal content-->
		<div class="modal-content" style="float:left;">
			<div class="modal-header ">
				<button type="button" class="close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 style="color:#000;" class="modal-title formTitle"><b>Need Help?</b></h4>
				<span>Send a message and we’ll reply as quickly as possible</span>
			</div>
			<div class="modal-body" style="float:left;">
				<div class="successMsg">
				</div>
				<form id="NeedHelpForm" style="width:100% !important">
					<input type="hidden" id="hidden_contact" name="contact" value="">
					<div class="form-group col-lg-6">
						 <label for="name">Name*:</label>
						 <input type="text" class="form-control IField" value="<?php echo $user_name; ?>" id="nameV" name="name">
						 <span class="err err1"></span>
					</div>
					<div class="form-group col-lg-6">
						 <label for="email">Email*:</label>
						 <input type="text" class="form-control IField" id="emailV" name="email">
						 <span class="err err2"></span>
					</div>
					<div class="form-group col-lg-12">
						 <label for="message">Message*:</label>
						 <textarea class="form-control txtAreaField" name="msg" id="messageV"></textarea>
						 <span class="err err3"></span>
					</div>
					<br>
					<div class="col-lg-12">
						<button type="submit" class="btn btn-primary" class="send_email">Send Email</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?Php
if(isset($_GET['user_id']))
{
	$current_userid = $_SESSION['admin']['id'];
	$curuser_level = $_SESSION['admin']['user_level'];
	if($current_userid == 1 || $curuser_level == 1 || $_GET['user_id'] == $current_userid){
		?>
		<!-- User Settings, modal which opens from Settings link (found in top right user menu) and the Cog link (found in sidebar user info) -->
		<div id="modal-user-settings" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header text-center">
						<h2 class="modal-title"><i class="fa fa-pencil"></i> Change Password</h2>
					</div>
					<!-- END Modal Header -->

					<!-- Modal Body -->
					<?php
						$user_id = $_GET['user_id'];
						$mselect1	=	"SELECT * FROM `admin` where id='$user_id'";
						$mquery1	=	$connect->query($mselect1);
						if ($mquery1->num_rows > 0) 
						{
							while($mresults1	=	$mquery1->fetch_assoc())
							{
								$my_user1 = $mresults1['name'];
								$my_user2 = $mresults1['email'];
							}
						}
					
						
					?>
					<div class="modal-body">
						<form action="?user_id=<?php echo $user_id; ?>&pchange=1" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" id="my_pchange_form">
							<fieldset>
								<div class="form-group">
									<div class="col-md-6">
										<label class="col-md-3 control-label">Name</label>
										<div class="col-md-9" style=" padding-left: 0;">
											<input type="text" id="my_unname" name="my_unname" class="form-control" disabled="disable" value="<?php echo $my_user1; ?>"> 
											<input type="hidden" id="my_unnamejjj" name="my_unnamejjj" class="form-control" value="<?php echo $my_user1; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<label class="col-md-3 control-label" for="my_unemail">Email</label>
										<div class="col-md-9" style=" padding-left: 0;">
											<input type="email" id="my_unemail" name="my_unemail" class="form-control" disabled="disable" value="<?php echo $my_user2; ?>">
											 <input type="hidden" id="my_unemailjjj" name="my_unemailjjj" class="form-control"  value="<?php echo $my_user2; ?>">
										</div>
									</div>
								</div>
								
								<!-- <div class="form-group">
									<label class="col-md-4 control-label" for="my_unemail_noti">Email Notifications</label>
									<div class="col-md-8">
										<label class="switch switch-primary">
											<input type="checkbox" id="my_unemail_noti" name="my_unemail_noti" value="1" checked>
											<span></span>
										</label>
									</div>
								</div> -->
							</fieldset>
							<fieldset>
								<legend>Password Update</legend>
								<div class="form-group">
									<label class="col-md-4 control-label" for="my_unpass">New Password</label>
									<div class="col-md-8">
										<input type="hidden" name="my_pchange_id" value="<?php echo $user_id; ?>"/>
										<input type="password" id="my_unpass" name="my_unpass" class="form-control" placeholder="Please choose a complex one..">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="my_unpass1">Confirm New Password</label>
									<div class="col-md-8">
										<input type="password" id="my_unpass1" name="my_unpass1" class="form-control" placeholder="..and confirm it!">
									</div>
								</div>
							</fieldset>
							<div class="form-group form-actions">
								<div class="col-xs-12 text-right">
									<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
									<button type="submit" id="my_passchange_btn" name="my_passchange_btn" class="btn btn-sm btn-primary">Save Changes</button>
								</div>
							</div>
						</form>
					</div>
					
					<!-- END Modal Body -->
				</div>
			</div>
		</div>
<!-- END User Settings -->
	<?php
	}	
} ?>