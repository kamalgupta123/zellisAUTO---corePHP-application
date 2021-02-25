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
<div class="block compatible_vehicle_wrap">
        <div class="block-title-one pb-10">
            <img src="<?php echo SITEURL; ?>img/eBay_logo2000px.png" class="eBayLogo" alt="eBay">
			<img src="<?php echo SITEURL; ?>img/car.png" class="carLogo" alt="car">
			<?php if(!empty($_GET['search']) && $_GET['search']==2) { ?>
			<a href="<?php echo SITEURL; ?>search_motor.php#get_sku_list" class="btn btn-black return_sku_list">Return To SKU List</a>
			<?php } else{ ?>
				<a href="<?php echo SITEURL; ?>index.php#get_sku_list" class="btn btn-black return_sku_list">Return To SKU List</a>
			<?php } ?>
			<div id="skuname">
				<p>Selected SKU :</p>
					<p id="skufield"></p>
					<p id="skufield2">-</p>
					<p id="descriptionfield"></p>
			</div>
			<?php 
			/* if(isset($_POST['myversion'])) {
				$myversion = $_POST['myversion']; */
				
			?>
				<!-- <a href="" class="btn btn-secondary customize_fields aCustomizeFields">Customize Fields</a> -->
			<?Php // }
			// else { echo '<h2>Search</h2>'; }
			?> 
			<div class="selectedskutable">
				<table class="table table-striped">
					<thead>
						<th>SKU</th>
						<th>ePIDs</th>
						<th>Brand</th>
						<th>Name</th>
						<th>Description</th>
					</thead>
					<tbody>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td class="newWidth"></td>
							<td width="50%"><div class="scrollable"></div></td>
						</tr>
				</tbody>
				</table>
			</div>
			<div class="full_width">
			<?php // if(basename($_SERVER['HTTP_REFERER'])=='search_motor.php'){
				if(!empty($_GET['search']) && $_GET['search']==2) {
				?>
				<div class="col-lg-12"><div class="circularOrangeDot text-center fontSize-1">2</div><label class="text-left mt-5 fontSize">Search below to display compatible motorcycles</label></div>
			<?php } else{?>
				<div class="col-lg-12"><div class="circularOrangeDot text-center fontSize-1">2</div><label class="text-left mt-5 fontSize">Search below to display compatible vehicles</label></div>
			<?php } ?>
			</div>	
        </div>
		
		<div class="container containerStyle">

		<!-- it contains the replace and append toggle button so that if user clicks replace thw whole epid gets replace with new 
		value on clicking save selected vehicles else it gets appended and there is one go back button to go to previous page -->
		
		<div class="row">
			<div class="col-lg-12">
				<div id="saved">


				</div>
			</div>
		</div> 
		<br>
		<?php // if(basename($_SERVER['HTTP_REFERER'])=='search_motor.php'||isset($_GET['clear'])){
			if(!empty($_GET['search']) && $_GET['search']==2) {
			?>
			<form id="motorForm" class="form-inline container" style="width:100% !important">
					<div class="col-lg-5 divfieldWrap">
						<div class="form-group col-lg-12 divfieldWrap">
							 <label for="usr" class="col-lg-3">Make:</label>
							 <div class="col-lg-9">
							 <input type="text" class="form-control IField" id="Make" name="Make">
							 <div class="IText">BMW, Ducati, Honda, Kawasaki, Yamaha etc.</div>
							 </div>
						</div>
						<div class="form-group col-lg-12 divfieldWrap">
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
						<div class="form-group col-lg-12 divfieldWrap">
							 <label for="usr" class="col-lg-3">Submodel:</label>
							 <div class="col-lg-9">
							 <input type="text" class="form-control IField" id="Submodel"  name="Submodel">
							 <div class="IText">ZX-6R, ER650E, Drifter, RP28, JC74, S4R etc.</div>
							 </div>
						</div>
						<div class="form-group col-lg-12 divfieldWrap">
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
						<!--a href="" class="btn btn-default customize_fields_motors aCustomizeFields divfieldWrap fontSize-small space"><i class="fa fa-gear"></i> Customise Search Fields</a-->
						<!--a href="" class="btn btn-primary"  style="float:right;margin:5px;">Clear</a-->
						<!--a href="" class="btn btn-secondary customize_fields_motors"  style="float:right;margin:5px;">Customize Fields</a-->
						<button type="submit" id="sub" class="btn btnSuccess col-lg-12 ebayFormSearchBtn">Search</button>
						<a href="" class="btn btnGrey ebayFormClear1">Clear</a>
					</div>
				</form>
		<?php } else{ ?>
				<form id="eBayForm" class="form-inline container eBayFormStyle">
					<div class="col-lg-5 divfieldWrap">
						<div class="form-group col-lg-12 divfieldWrap">
							 <label for="usr" class="col-lg-2">Make:</label>
							 <div class="col-lg-10">
							 <input type="text" class="form-control IField" id="Make" name="Make">
							 <div class="IText">BMW, Ford, Holden, Toyota, Volvo etc.</div>
							 </div>
						</div>
						<div class="form-group col-lg-12 divfieldWrap">
							 <label for="usr" class="col-lg-2">Model:</label>
							 <div class="col-lg-10">
							 <input type="text" class="form-control IField" id="Model"  name="Model">
							 <div class="IText">Camry, Commodore, F150, Falcon, Passat, Golf etc.</div>
							 </div>
						</div>
						<div class="form-group col-lg-12 divfieldWrap">
							 <label for="usr" class="col-lg-2 yearFrom">Year From:</label>
							 <div class="col-lg-4 ebayFormyearfrom">
							 <input type="text" class="form-control IField" id="year-from"  name="year-from">
							 </div>
							 <div class="col-lg-1 ebayFormyeartolabel">
							 <label for="usr2">to:</label>
							 </div>
							 <div class="col-lg-4">
							 <input type="text" class="form-control IField" id="year-to"  name="year-to">
							 </div>
						</div>
						<!--div class="form-group col-lg-12">
							 <label for="usr" class="col-lg-6">Plat_Gen(Model Code):</label>
							 <input type="text" class="form-control col-lg-6" id="Model_Code" name="Model_Code">
						</div-->
					</div>
					<div class="col-lg-5 divfieldWrap">
						<div class="form-group col-lg-12 divfieldWrap">
							 <label for="usr" class="col-lg-2 divfieldWrap">Submodel:</label>
							 <div class="col-lg-10">
							 <input type="text" class="form-control IField" id="Submodel"  name="Submodel">
							 <div class="IText">Series (E46, VF, BA), Engine (2.2, 3.6), Body (Sedan, Ute) etc.</div>
							 </div>
						</div>
						<div class="form-group col-lg-12 divfieldWrap">
							 <label for="usr" class="col-lg-2 divfieldWrap">Variant:</label>
							 <div class="col-lg-10">
							 <input type="text" class="form-control IField" id="Variant"  name="Variant">
							 <div class="IText">RWD, FWD, AWD, Petrol, Diesel, 4cyl, 6cyl etc.</div>
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
						<!-- <a href="" class="btn btn-default customize_fields aCustomizeFields divfieldWrap fontSize-small space"><i class="fa fa-gear"></i> Customise Search Fields</a> -->
						<button type="submit" id="sub" class="btn col-lg-12 ebayFormSearchBtn btnSuccess">Search</button>
						<a href="" class="btn btnGrey ebayFormClear1">Clear</a>
					</div>
				</form>
		<?php }?>

				<div class="row appendReplaceRow appendReplaceRowmargintop">
					    <div class="col-lg-3"></div>
						<div class="col-lg-6">
							<div class="row">
								<div class="col-lg-5"></div>
								<div class="col-lg-2 text-right"><a href="#" id="anchor-tooltip" data-toggle="tooltip" data-html="true" title="<strong><span class='warningWrap'>WARNING:</span></strong><br> if you have existing vehicles saved to this SKU record in NETO, they will be overwritten and cannot be retrieved"><i class="fa fa-question-circle" aria-hidden="true"></i></a></div>
							</div>
						</div>
						<div class="col-lg-1"></div>
				</div>
				
				<div class="row appendReplaceRow-below">
					<div class="col-lg-3 pd-r-0 align-left">
						<div class="circularOrangeDot text-center fontSize-1">3</div>
						<label class="appendReplaceRowP mt-5 text-left fontSize">Tick compatible vehicles below</label>
					</div>	
					<div class="col-lg-6 pd-r-0 pd-l-0 text-center">
						<div class="toggle-buttons appendReplaceRowContent fontSize">
						<div class="circularOrangeDot text-center fontSize-1">4</div>
							<label class="lh-3">Choose whether to:</label> 
							&nbsp;<button id='append-epids' class="epidsBtn appendEpids">Append</button>&nbsp;<label class="lh-3">or</label>
							&nbsp;<button id='replace-epids' class="epidsBtn">Replace</button>
						    &nbsp;<label class="lh-3">existing fitment in this Neto SKU record</label> 
						</div>
					</div>
					<div class="col-lg-3 pd-r-0 pd-l-0 text-center">
						<div class="circularOrangeDot text-center fontSize-1">5</div>
						<button class='btn btnPrimary' id='save_vehicles'>Save to Neto SKU Record</button>
					</div>
				</div>
				<div class="selectedEpids"><input type="hidden" class="hiddenSelectedEpids" value=""></div>
				<div class ="search_query_results searchQueryResults"></div>
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
				</form>		
			<?php	
			} */	
			?>
		</div>
</div>

</div>

	<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog alterDialog" role="document">
		<div class="modal-content">
		<div class="modal-body">
			<div class="jumbotron">
				<div class="row">
					<div class="col-lg-12 text-center"><p class="text-primary saved-sucessfully-modal-text"><strong>Saved successfully!</strong></p><p class="sPtext"><small>The selected vehicles were added to your Neto SKU record.</small></p></div>
				</div>
				<div class="row">
					<div class="col-lg-12 text-center"><p class="sPtext"><small>What's next?</small></p></div>
				</div>
				<div class="row btngroup">
					<div class="col-lg-4">
						<button onclick="window.open(document.referrer,'_self');" class="btn DiffSKUWrap modalbtn">Select different SKU</button>
					</div>
					<div class="col-lg-4 pd-l-0">
						<button onclick="toggleModal();"class="btn MoreSKU modalbtn">Add more vehicles to SKU</button>
					</div>
					<div class="col-lg-4">
						<a href="<?php echo SITEURL."html_data_from_db_display.php?page_id=1"; ?>" class="btn PushFEbay modalbtn">Push fitment to eBay</a>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
	</div>

	<?php 
	
    
	include 'inc/template_scripts.php'; 
	include 'inc/page_footer.php';
    // include 'csv_epids.php';
	include 'extra_footer.php';
    ?>
	