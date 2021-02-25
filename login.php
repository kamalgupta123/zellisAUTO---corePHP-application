<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php $obj->admin_login(); ?>
<!-- Login Background -->
<div id="login-background">
    <!-- For best results use an image with a resolution of 2560x400 pixels (prefer a blurred image for smaller file size) -->
    <!-- <img src="img/placeholders/headers/profile_header.jpg" alt="Login Background" class="animation-pulseSlow"> -->
</div>
<!-- END Login Background -->

<!-- Login Container -->
<div id="login-container" class="animation-fadeIn">
    <!-- Login Title -->
	 
        
   
    <div class="login-title text-center">
		<h1><!-- <strong>Zellis Crm</strong> --><img src="<?php echo SITEURL; ?>img/ZellisAUTO.png" style="width: 200px;"/></h1>
        <!--<h1><i class="gi gi-flash"></i> <strong><?php echo $template['name']; ?> Login</strong></h1>-->
    </div>
    <!-- END Login Title -->

    <!-- Login Block -->
    <div class="block remove-margin">
        <!-- Login Form -->
        <form action="process.php" method="post" id="form-login" class="form-horizontal form-bordered form-control-borderless">
		<input type="hidden" name="action" value="Login">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                        <input type="text" id="admin_username" name="admin_username" class="form-control input-lg" placeholder="Username">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                        <input type="password" id="admin_password" name="admin_password" class="form-control input-lg" placeholder="Password">
                    </div>
                </div>
            </div>
			<div class="form-group">
                <div class="col-xs-12 text-right">
					<a href="javascript:void(0);" class="forgot_pwd_link">Forgot Password?</a>
				</div>
			</div>
            <div class="form-group form-actions">
                
                <div class="col-xs-8 text-right">
                    <button type="submit" class="btn btn-sm btn-primary"> Login to Dashboard <i class="fa fa-angle-right"></i></button>
                </div>
            </div>
            <!--div class="form-group">
                <div class="col-xs-12">
                    <p class="text-center remove-margin"><small>Don't have an account?</small> <a href="javascript:void(0)" id="link-login"><small>Create one for free!</small></a></p>
                </div>
            </div-->
        </form>
        <!-- END Login Form -->
	
        
    </div>
    <!-- END Login Block -->
</div>
<!-- END Login Container -->

<div class="modal fade" tabindex="-1"  id="EnterEmailModal" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
	<!-- Modal content-->
		<div class="modal-content" style="float:left;width:100%;">
			<div class="modal-header">
				<button type="button" class="close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 style="color:#000;" class="modal-title"><b>Forgot your Password?</b></h4>
				<span>Please enter your registered email address. We will send a link in your email.</span>
			</div>
			<div class="modal-body" style="float:left;width:100%;">
				<form id="EnterEmailForm" style="width:100% !important">
					<div class="form-group col-lg-12">
						 <label for="email">Email*:</label>
						 <input type="text" class="form-control IField" id="emailV" name="email">
						 <span class="err err1"></span>
					</div>
					<br>
					<div class="col-lg-12">
						<button type="submit" class="btn btn-primary" class="send_forgot_email">Send Email</button>
					</div>
				</form>
				<div class="err-msgs" style=""></div>
				<div class="success-msgs"></div>
			</div>
		</div>
	</div>
</div>


<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/login.js"></script>
<script>$(function(){ Login.init(); });</script>

<?php include 'inc/template_end.php'; ?>
<script>
$(document).ready(function(){
    $('#login-background').css('height', $(window).height());
	$(document).on('click','.forgot_pwd_link',function() {
		$('.err-msgs').html('');
		$('.success-msgs').html('');
		$('#emailV').val('');
		$('#EnterEmailModal').modal('show');
	});
	$(document).on("submit","#EnterEmailForm",function() {
		$('.err-msgs').html('');
		$('.success-msgs').html('');
		var error=0;
		var email = $('#emailV').val();
		if(typeof email == 'undefined' || email == '') {
			error=1;
			$('.err1').html('This field is required*');
		} else{
			pattern =/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(!pattern.test(email)) {
				error=1;
				$('.err1').html('Invalid Email address*');
			} else {
				$('.err1').html(''); 
			}
		}
		if(error==0) {
			var formData = new FormData($("#EnterEmailForm")[0]);
			formData.append("SendResetMail", "action");
			$.ajax({
				type:'post',
				url:'forgot_ajax.php',
				data:formData,
				processData: false,
				contentType: false,
				success: function(r){
					// console.log('r',r);
					if(typeof r == 'object'){
						if(r.status==1){
							$('.err-msgs').html('');
							// $('.success-msgs').html('<div class="alert alert-success">We have sent the link to the registered email address. Please click on the link to change the password.</div>');
							alert("We have sent the link to the registered email address. Please click on the link to change the password.");
							$('#EnterEmailModal').modal('hide');
						}
						else{
							$('.success-msgs').html('');
							$('.err-msgs').html('<div class="alert alert-danger">'+r.msg+'</div>');
						}
					}
					else{
						$('.success-msgs').html('');
						// UIkit.notification(data, "danger");
						$('.err-msgs').html('<div class="alert alert-danger">'+r+'</div>');
					}
				}
			});
		}
		return false;
	});
});
$(window).resize(function(){
    $('#login-background').css('height', $(window).height());
});
</script>