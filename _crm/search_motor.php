<?php 
	include dirname(__FILE__).'/../inc/config.php'; 
	include dirname(__FILE__).'/../inc/template_start.php';
	include dirname(__FILE__).'/../inc/page_head.php';
	$obj->check_admin_not_login(); 
	
	// print_r(phpinfo());die;
?>
	
<!--div id="loader_container"></div-->
<div id="page-content">
    <!-- Blank Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i><img class="zlogo" src="<?php echo SITEURL; ?>img/zlogo.png"></i>Automotive Parts Fitment System<br><small></small>
            </h1>
        </div>
    </div>
	<ul class="breadcrumb breadcrumb-top">
        <li>Dashboard</li>
        <li><a href="">eBay Fitment</a></li>
    </ul>

    <div class="block">
        <div class="block-title" style="padding-bottom: 10px;">
            <img src="<?php echo SITEURL; ?>img/eBay_logo2000px.png" class="eBay_logo" alt="eBay">
			<?php 
			/* if(isset($_POST['myversion'])) {
				$myversion = $_POST['myversion']; */
				
			?>
				<a href="" class="btn btn-primary"  style="float:right;margin:5px;">Clear</a>
				<a href="" class="btn btn-secondary customize_fields_motors"  style="float:right;margin:5px;">Customize Fields</a>
			<?Php // }
			// else { echo '<h2>Search</h2>'; }
			?> 
        </div>

		<div class="container" style="margin-top:20px;margin-bottom:20px;width:100% !important">
			<?php /*  if(isset($myversion)) { 
			if($myversion == '') {
				    echo '<p class="myversion">eBay Master Vehicle List Version: <i>All Versions</i></p>';
				}
				else {
    				echo '<p class="myversion">eBay Master Vehicle List Version: <i>'.$myversion.'</i></p>';
				}
				echo '<input type="hidden" name="myversiontext" id="myversiontext" value="'.$myversion.'"/>'; */
			?>
				<form id="motorForm" class="form-inline container" style="width:100% !important">
					<div class="col-lg-5">
						<div class="form-group col-lg-12">
							 <label for="usr" class="col-lg-3">Make:</label>
							 <div class="col-lg-9">
							 <input type="text" class="form-control IField" id="Make" name="Make">
							 <div class="IText">BMW, Ducati, Honda, Kawasaki, Yamaha etc.</div>
							 </div>
						</div>
						<div class="form-group col-lg-12">
							 <label for="usr" class="col-lg-3">Model:</label>
							 <div class="col-lg-9">
							 <input type="text" class="form-control IField" id="Model"  name="Model">
							 <div class="IText">K 650, R 1200, Diavel, CB, Hornet, Ninja etc.</div>
							 </div>
						</div>
						<!--div class="form-group col-lg-12">
							 <label for="usr" class="col-lg-6">Plat_Gen(Model Code):</label>
							 <input type="text" class="form-control col-lg-6" id="Model_Code" name="Model_Code">
						</div-->
					</div>
					<div class="col-lg-5">
						<div class="form-group col-lg-12">
							 <label for="usr" class="col-lg-3">Submodel:</label>
							 <div class="col-lg-9">
							 <input type="text" class="form-control IField" id="Submodel"  name="Submodel">
							 <div class="IText">ZX-6R, ER650E, Drifter, RP28, JC74, S4R etc.</div>
							 </div>
						</div>
						<div class="form-group col-lg-12">
							 <label for="usr" class="col-lg-3">Year:</label>
							 <div class="col-lg-9">
							 <input type="text" class="form-control IField" id="Year"  name="Year">
							 </div>
						</div>
						<!--div class="form-group col-lg-12">
							<label for="usr" class="col-lg-6">Body:</label>
							<input type="text" class="form-control col-lg-6" id="Body" name="Body">
						</div>
						<div class="form-group col-lg-12">
							<label for="usr" class="col-lg-6">Type:</label>
							<input type="text" class="form-control col-lg-6" id="Type" name="Type">
						</div>
						<div class="form-group col-lg-12">
							<label for="usr" class="col-lg-6">Engine:</label>
							<input type="text" class="form-control col-lg-6" id="Engine" name="Engine">
						</div-->
					</div>
					<div class="col-lg-2">
						<button type="submit" id="sub" class="btn btn-primary col-lg-12">Search</button>
					</div>
				</form>
				<div class ="search_query_results" style="margin:20px;"></div>
			<?php /* }
			 else { ?>
				<form method="POST" class="form-inline myconfo container" style="width:100% !important">
					<div class="form-group col-lg-12">
						<label for="usr">Load eBay Master Vehicle List:</label>
						<select required name="myversion" class="form-control" id="myversion">
							<option value="">Select version</option>
							<option value="">All Versions</option>
							<?php while($mrow = $aresult->fetch_assoc()) {
							    if(!$mrow['version'] == ''){
    								echo '<option value="'.$mrow['version'].'">'.$mrow['version'].'</option>';
							    }
							}
							?>
						</select>
					</div>
					<div class="form-group col-lg-12">
						<button type="submit" id="myver_sub" class="btn btn-primary">Search</button>
					</div>
				</div>		
			<?php	
			} */	
			?>
		</div>
	</div>
</div>

<?php 
	include dirname(__FILE__).'/../inc/page_footer.php';
	include dirname(__FILE__).'/../inc/template_scripts.php'; 
	include dirname(__FILE__).'/../extra_footer.php';
?>

<script>
		$(document).on('submit','#motorForm',function(e) {
			e.preventDefault();
			
			$('.search_query_results').html('<div class="col-lg-12"><img src="<?php echo SITEURL;?>/css/images/loader.gif" style="margin:auto;width:50px;"> </div>');
			var Make = $("#Make").val();
			var Model = $("#Model").val();
			var Submodel = $('#Submodel').val();
			var Year = $('#Year').val();
 			var mversion = '';
          
            $.post("motor_ajax.php",
			{
				Make:Make,
				Model:Model,
				Submodel:Submodel,
				Year:Year,
				search_data:'search_data'
			},
			function(response,status){
                if(typeof response == 'object'){
					$('.search_query_results').html("");
					if(response.html!='') {
						$(".search_query_results").append(response.html);
						$('#my_search_table').DataTable( {
						  "pagingType": "full_numbers" ,
						  "aLengthMenu": [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]],
						  "pageLength" : response.RowSize,
						  'aoColumnDefs': [{'bSortable': false,'aTargets': ['nosort'] }],
						  responsive: true,
						  autoWidth: false,
						} );
					}
				}
			});
			return false;
        });


        $(document).on('click','.customize_fields_motors',function() {
			$('.err1').html('');
			$('.err_msgs').html("");
			$.ajax({
				type:'post',
				url:'motor_ajax.php',
				data:{customize_fields_motors:'action'},
				success: function(data){
					$('#CustomizeFieldsMotorModal').modal("show");
					if(data!=''){
						$('#CustomizeFieldsMotorForm').html(data);
					} else {
						$('#CustomizeFieldsMotorForm').html('<div class="alert alert-danger">Columns does not exists.</div>');
					}
				}
			});
			return false;
		});


		$(document).on('submit','#CustomizeFieldsMotorForm',function() {
			var checkC=0;
			if ($('#CustomizeFieldsMotorForm :checkbox:checked').length > 0){
				checkC = 1;
			}
			// console.log(checkC);
			if(checkC==1) {
				var formData = new FormData($("#CustomizeFieldsMotorForm")[0]);
				formData.append("SubmitSelectMotorFields", "action");
				$.ajax({
					type:'post',
					url:'motor_ajax.php',
					data:formData,
					processData: false,
					contentType: false,
					success: function(data){
						if(data==1) {
							$('#CustomizeFieldsMotorModal').modal('hide');
						}else{
							$('.err_msgs').html("<div class='alert alert-danger'>"+data+"</div>");
						}
					}
				});
			} else{
				$('.err1').html('Please select one field to show in search result.');
			}
			return false;
		});
</script>