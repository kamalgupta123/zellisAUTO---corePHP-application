
<?php include dirname(__FILE__).'/../inc/config.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_start.php'; ?>

<?php include dirname(__FILE__).'/../inc/page_head.php'; ?>

<?php $obj->check_admin_not_login(); ?>
<style>td.opener {cursor: pointer;}</style>
<!-- Page content -->
<?Php
 

	$my_error = 0;
	$my_cuserc = '';

	if(isset($_POST['my_userdelete_submit'])){
		$my_con = $_POST['my_userdelete'];
		$my_arr = explode(',',$my_con);
		foreach($my_arr as $my_id)
		{
			$minsert = "Delete from client_detail where id = '".strip_tags($my_id)."'";
			$mqueryi	=	$connect->query($minsert);
		}

	}
	if(isset($_GET['action']) && $_GET['action'] === 'deletec'){
		$minsert = "Delete from client_detail where id = '".strip_tags($_GET['client_id'])."'";
		$mqueryi	=	$connect->query($minsert);

	}
?>
<div id="page-content">

    <!-- Blank Header -->

    <div class="content-header">

        <div class="header-section">

            <h1>

                <!--i><img class="zlogo" src="img/zlogo.png"></i>eBay Vehicle Compatibility Generator<br><small></small-->
                <!--<i><img class="zlogoA" src="<?php //echo SITEURL; ?>img/zlogo.png"></i>  -->
                	ZELLIS Auto Setup<br><small></small>

            </h1>

        </div>

    </div>

	    <ul class="breadcrumb breadcrumb-top">

        <li>Dashboard</li>

        <li><a href="">CSV Uploader</a></li>

    </ul>

    <!-- END Blank Header -->



    <!-- Example Block -->

    <div class="block">

        <!-- Example Title -->

        <!--div class="block-title">

            <h2>CSV Uploader</h2>
						<button class="btn btn-success btn-primary" id="search_redirect"  style="margin:10px;">Search for a vehicle</button>
        </div-->

        <!-- END Example Title -->



        <!-- Example Content -->



       <div class="table-responsive">
<?php
$msg='';$msg1='';

if(isset($_POST["Import"])){
	$filename=$_FILES["file"]["tmp_name"];
	$ebay_mvl = $_POST['ebay_mvl'];
	$flag=0;
	if($_FILES["file"]["size"] > 0)
	{
		$file = fopen($filename, "r");
		
		// $mypidarr = array();
		// $sql1 = "SELECT ePID FROM motercycle";
		// $result1 = $connect->query($sql1);
		// if ($result1->num_rows > 0) {
		// 	while($res = $result1->fetch_assoc()) {	
		// 		$mypidarr[] = $res['ePID'];
		// 	}
		// }

		// echo "<pre>"; print_r($mypidarr); echo "</pre>";die;

		$sql2 = "INSERT IGNORE INTO motercycle (ePID, AUM_Power, AUM_Make, AUM_Model, AUM_Submodel, Year,Ktype,mlv) VALUES ";
		$mfl = 0;
		while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		{
			if($flag==0){
				//th
			 $flag=1;
			}else{
				// $id=$getData[0];
				// if(in_array($id,$mypidarr)) {
					/* $sql3 = "UPDATE data SET Make='".$getData[1]."',Model='".$getData[2]."',Year='".$getData[3]."',Submodel='".$getData[4]."', Variant='".$getData[5]."',Plat_Gen='".$getData[6]."',Engine='".$getData[7]."' ,Body='".$getData[8]."',Type='".$getData[9]."',Ktype='".$getData[10]."',Relationship='".$getData[11]."', RelationshipDetails='".$getData[12]."', version='".$ebay_mvl."' WHERE ePID=".$id;
					
					if ($connect->query($sql3) !== TRUE) {
						echo "Error updating record: " . $connect->error;
					} */

				// }
				// else
				// {
					// $mdata = ' ("'.$getData[0].'","'.$getData[1].'","'.$getData[2].'","'.$getData[3].'","'.addslashes($getData[4]).'","'.$getData[5].'","'.$getData[6].'","'.$ebay_mvl.'"),';
					$mdata = ' ("'.safe_str($getData[0]).'","'.safe_str($getData[1]).'","'.safe_str($getData[2]).'","'.safe_str($getData[3]).'","'.safe_str($getData[4]).'","'.safe_str($getData[5]).'","'.safe_str($getData[6]).'","'.safe_str($ebay_mvl).'"),';
					$sql2 .= $mdata;
					$mfl = 1;
				// }
			}
		}
		if($mfl == 1) {
			$sql2 = substr($sql2, 0, strlen($sql2) - 1);
			if ($connect->query($sql2) !== TRUE) {
				echo "Error: " . $sql2 . "<br>" . $connect->error;
			}
		}
		
		fclose($file);
		$msg='Your file is successfully uploaded';
	}
}
else if(isset($_POST["Import_content"])){
	$filename=$_FILES["file"]["tmp_name"];
	$flag=0;	
	if($_FILES["file"]["size"] > 0)
	{
		$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		{	   
			if($flag==0){
			//th
				$flag=$flag+1;
			}else{
				$sqll = "INSERT INTO content_table (External_Reference, Content_ID)
				 VALUES (".$getData[0].",".$getData[1].")";
				
				 if ($connect->query($sqll) !== TRUE) {
						echo "Error: " . $sqll . "<br>" . $connect->error;
				 }$flag=2;
			}
		}
		fclose($file);
		$msg1='Your file is successfully uploaded';
	}
}
?>
						 <div id="wrap">
						     	<p class="uploader_heading">Load eBay Master Motercycle List</p>
								 <div class="container">
										 <div class="row">

												 <form class="form-horizontal" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" name="upload_excel" enctype="multipart/form-data">
														 <fieldset>

																 <div class="form-group" style="margin:20px;">
																		 <label class="col-md-4 control-label" for="filebutton">Select CSV file</label>
																		 <div class="col-md-4">
																				 <input type="file" name="file" id="file" class="input-large">
																		 </div>
																 </div>
																 
																  <div class="form-group" style="margin:20px;">
																		 <label class="col-md-4 control-label" for="ebay_mvl">eBay MVL Version</label>
																		 <div class="col-md-4">
																				 <input type="text" required name="ebay_mvl" id="ebay_mvl" class="form-control input-large">
																		 </div>
																 </div>

																 <!-- Button -->
																 <div class="form-group"  style="margin: 0 20px;">
																		 <label class="col-md-4 control-label" for="singlebutton">Import data</label>
																		 <div class="col-md-4">
																				 <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
																		 </div>
																 </div>
														 </fieldset>
												 </form>
												 		<p style="text-align:center;color:green;"><?php echo $msg; ?></p>
										 </div>


								 </div>
						 </div>
						 <!--hr style="border-top: 5px solid #8a8989;">
						 <div id="wrap">
						     <p class="uploader_heading">Neto ContentMapping CSV</p>
								 <div class="container">
										 <div class="row">

												 <form class="form-horizontal" action=<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" name="upload_excel" enctype="multipart/form-data">
														 <fieldset>

																 <div class="form-group" style="margin:20px;">
																		 <label class="col-md-4 control-label" for="filebutton">Select File</label>
																		 <div class="col-md-4">
																				 <input type="file" name="file" id="file" class="input-large">
																		 </div>
																 </div>

																
																 <div class="form-group">
																		 <label class="col-md-4 control-label" for="singlebutton">Import Content data</label>
																		 <div class="col-md-4">
																				 <button type="submit" id="submit" name="Import_content" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
																		 </div>
																 </div>
														 </fieldset>
												 </form>
												 		<p style="text-align:center;color:green;"><?php // echo $msg1; ?></p>
										 </div>


								 </div>
						 </div-->


        </div>
        <!-- END Example Content -->



    </div>

    <!-- END Example Block -->

</div>

<!-- END Page Content -->



<?php include dirname(__FILE__).'/../inc/page_footer.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<!--script src="js/pages/tablesDatatables.js"></script>
<script>$(function(){ TablesDatatables.init(); });</script-->

<?php include dirname(__FILE__).'/../inc/template_end.php'; ?>

<link href="<?php echo SITEURL; ?>css/mb.balloons.css" media="all" rel="stylesheet" type="text/css">
<script src="<?php echo SITEURL; ?>js/jquery.mb.balloon.js"></script>

<script>
jQuery(document).ready(function(){
	$("#search_redirect").click(function(){
	    window.location.replace("csv_file_search.php");
	});
	 jQuery('.my_tall').click(function(){
            if(jQuery(this).prop("checked")) {
                jQuery(".my_all").prop("checked", true);

            } else {
                jQuery(".my_all").prop("checked", false);
            }
        });


        jQuery('.my_all').click(function(){
            if(jQuery(".my_all").length == jQuery(".my_all:checked").length) {
                jQuery(".my_tall").prop("checked", true);
            }else {
                jQuery(".my_tall").prop("checked", false);
            }
        });
    jQuery("#csv_download").click(function ()
	{
		 var my_ids = '';
        jQuery(".my_all:checked").each(function ()
		{
          my_ids = my_ids+jQuery(this).attr("id")+',';
        });
		my_ids1 = my_ids.slice(0, -1)

		 // Get from elements values
		 var values = my_ids1;

		/* jQuery.ajax({
				url: "csv.php",
				type: "POST",
				data: 'my_data='+values ,
				success: function (response)
				{
					console.log(response);
					alert(response);
				   // you will get response from your php page (what you echo or print)

				}

			});
			*/
                if(values != '')
               {
		jQuery('#my_data').val(values);
		jQuery('#my_data_submit').trigger('click');
                 }
               else { alert('Please Check atleast one user to download csv'); }
    });

	jQuery("#survey_download").click(function ()
	{
		 var my_ids = '';
        jQuery(".my_all:checked").each(function ()
		{
          my_ids = my_ids+jQuery(this).attr("id")+',';
        });
		my_ids1 = my_ids.slice(0, -1)

		 // Get from elements values
		 var values = my_ids1;
        if(values != '')
               {
				   if(confirm("Are you sure you want to send Survey Result?"))
				   {
						jQuery('#my_survey_download').val(values);
						jQuery('#my_survey_download_submit').trigger('click');
					}
					else
					{
						return false;
					}
                 }
               else { alert('Please Check atleast one user to send Survey Result'); }
    });

	jQuery("#mail_download").click(function ()
	{
		 var my_ids = '';
        jQuery(".my_all:checked").each(function ()
		{
          my_ids = my_ids+jQuery(this).attr("id")+',';
        });
		my_ids1 = my_ids.slice(0, -1)

		 // Get from elements values
		 var values = my_ids1;

		/* jQuery.ajax({
				url: "csv.php",
				type: "POST",
				data: 'my_data='+values ,
				success: function (response)
				{
					console.log(response);
					alert(response);
				   // you will get response from your php page (what you echo or print)

				}

			});
			*/
        if(values != '')
               {
				   if(confirm("Are you sure you want to send invitation?"))
				   {
						jQuery('#my_maildata').val(values);
						jQuery('#my_maildata_submit').trigger('click');
					}
					else
					{
						return false;
					}
                 }
               else { alert('Please Check atleast one user to send invitation mail'); }
    });

	jQuery("#users_delete").click(function ()
	{
		 var my_ids = '';
        jQuery(".my_all:checked").each(function ()
		{
          my_ids = my_ids+jQuery(this).attr("id")+',';
        });
		my_ids1 = my_ids.slice(0, -1)

		 var values = my_ids1;

        if(values != '')
               {
				   if(confirm("Are you sure you want to delete?"))
				   {
						jQuery('#my_userdelete').val(values);
						jQuery('#my_userdelete_submit').trigger('click');
					}
					else
					{
						return false;
					}
                 }
               else { alert('Please Check atleast one user to delete'); }
    });
})
</script>

<script>

	$(function () {

		jQuery.balloon.init();
		$(".opener").each(function(){
			var el = $(this);
			el.showCode(el);
		});
	});
</script>
