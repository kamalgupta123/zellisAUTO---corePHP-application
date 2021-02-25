<?php include dirname(__FILE__).'/../inc/config.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_start.php'; ?>

<?php include dirname(__FILE__).'/../inc/page_head.php'; ?>

<?php $obj->check_admin_not_login(); 
$page_title='';

	if(isset($_GET['page_id']))
	{
		$page_id = $_GET['page_id'];
		$mselect1	=	"SELECT * FROM `pages_content` WHERE page_id=".$page_id." ORDER BY page_id ASC";
		$mquery1	=	$connect->query($mselect1);	
		if ($mquery1->num_rows > 0) {
			while($mresults1	=	$mquery1->fetch_assoc()){
				$data = $mresults1['page_content'];
				$page_title = $mresults1['page_title'];
			}
		}
	}
?>

<style>td.opener {cursor: pointer;}</style>
<!-- Page content -->
<div id="page-content">
    <!-- Blank Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
            <!--<i><img class="zlogoA" src="<?php //echo SITEURL; ?>img/zlogo.png"></i>  -->
            <?php if(empty($_GET['page_id'])) { echo "Add"; } else{ echo "Edit"; } ?> Page Content<br><small></small></h1>
        </div>
	</div>
	
	<?php 
		if(isset($_GET['page_id'])){
			echo "<ul class='breadcrumb breadcrumb-top'><li>Dashboard</li><li><a href=''>Edit Page Content</a></li></ul>";
		}
		else{
			echo "<ul class='breadcrumb breadcrumb-top'><li>Dashboard</li><li><a href=''>Add Page Content</a></li></ul>";
		}
	?>
	<!-- <ul class="breadcrumb breadcrumb-top">
		<li>Dashboard</li>
		<li><a href="">Add Page Content</a></li>
    </ul> -->
	<!-- END Blank Header -->

    <!-- Example Block -->
    <div class="block">
		<div class="table-responsive">
		<div class="err_msgs"></div>
		<div class="succ_msgs"></div>
		<form id="page_content_form" class="form-horizontal form-bordered">
		<div class="my_full form-group">
			<input type="hidden" name="page_content_id" value="<?php if(!empty($_GET['page_id'])) { echo $_GET['page_id']; } ?>">
			<div class="col-md-6 col-sm-6 col-xs-12 my_left">
				<label class="control-label" for="page_title">Page Title</label>
				<input type="text" id="page_title" name="page_title" class="form-control" value="<?php if(!empty($page_title)) { echo $page_title; } ?>">
				<span class="err err1"></span>
			</div>
			<div class="col-sm-12">
				<label class="control-label">Page Content</label>
				<span class="err err2"></span>
				<textarea name="data" rows="10" cols="10" id="editor"><?php echo htmlspecialchars_decode(stripslashes(trim(str_replace("\n", '', $data)))) ?></textarea>
			</div>
			<div class="col-sm-12">
			<button type="submit" class="btn btn-primary LoaderDiv" id="save-ckeditor-data">Save</button>
			</div>
		</div>		
		
		</form>
	</div>
</div>

<script>
$(document).ready(function(){ 
	
	/* CKEDITOR.replace( 'editor' , {
	  filebrowserUploadUrl: "upload.php?test=1"
	}); */
	CKEDITOR.config.title = false;
 CKEDITOR.config.filebrowserUploadUrl = '<?php echo SITEURL; ?>upload.php?type=Images';
 CKEDITOR.config.baseHref = '<?php echo SITEURL; ?>';
 CKEDITOR.config.extraAllowedContent = 'iframe[*]';
 CKEDITOR.config.toolbar = [
  ['Styles','Format','Font','FontSize'],
  ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],
  ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
  ['Image','Table','-','Link','Flash','Smiley','TextColor','BGColor']
 ] ;
		// if(CKEDITOR.instances['post_content_input'])
		   // delete CKEDITOR.instances['post_content_input'];
		CKEDITOR.replace('editor');
		for (var i in CKEDITOR.instances) {
			CKEDITOR.instances[i].on('change', function() { 
				$(CKEDITOR.instances[i].element.$).val(CKEDITOR.instances[i].getData()).change(); 
			});
        }
	
	$(document).on('submit',"#page_content_form", function() {	
		var data = CKEDITOR.instances.editor.getData();
		var error=0;
		var page_title = $('#page_title').val();
		if(typeof page_title == 'undefined' || page_title == '') {
			error=1;
			$('.err1').html('This field is required*');
		} else{ $('.err1').html(''); }
		if(typeof data == 'undefined' || data == '') {
			error=1;
			$('.err2').html('This field is required*');
		} else{ $('.err2').html(''); }
		if(error==0) {
		var formData = new FormData($("#page_content_form")[0]);
		formData.append("PageContentSubmit", "action");
		formData.append("data", data);
		$.ajax({
			type:'post',
			url:'ckeditor_data_to_db.php',
			data:formData,
			processData: false,
			contentType: false,
			success: function(data){
				console.log(data);
				if(typeof data == 'object'){
					if(data.errors==""){
						$('.err_msgs').html("");
						$(".succ_msgs").html("<div class='alert alert-success'>Successfully Saved.</div>");
						window.location.href = SITE_URL+"_crm/page_content_list.php";
						// window.location.reload();
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
		}
		return false;
	});
});
</script>

<?php include dirname(__FILE__).'/../inc/page_footer.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<!--script src="js/pages/tablesDatatables.js"></script>
<script>$(function(){ TablesDatatables.init(); });</script-->