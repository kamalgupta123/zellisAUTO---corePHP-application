<?php 
	include dirname(__FILE__).'/../inc/config.php'; 
	include dirname(__FILE__).'/../inc/template_start.php';
	include dirname(__FILE__).'/../inc/page_head.php';
	$obj->check_admin_not_login(); 
	
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
				<a href="" class="btn btn-secondary customize_fields"  style="float:right;margin:5px;">Customize Fields</a>
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
				<form id="eBayForm" class="form-inline container" style="width:100% !important">
					<div class="col-lg-5">
						<div class="form-group col-lg-12">
							 <label for="usr" class="col-lg-2">Make:</label>
							 <div class="col-lg-10">
							 <input type="text" class="form-control IField" id="Make" name="Make">
							 <div class="IText">BMW, Ford, Holden, Toyota, Volvo etc.</div>
							 </div>
						</div>
						<div class="form-group col-lg-12">
							 <label for="usr" class="col-lg-2">Model:</label>
							 <div class="col-lg-10">
							 <input type="text" class="form-control IField" id="Model"  name="Model">
							 <div class="IText">Camry, Commodore, F150, Falcon, Passat, Golf etc.</div>
							 </div>
						</div>
						<!--div class="form-group col-lg-12">
							 <label for="usr" class="col-lg-6">Plat_Gen(Model Code):</label>
							 <input type="text" class="form-control col-lg-6" id="Model_Code" name="Model_Code">
						</div-->
					</div>
					<div class="col-lg-5">
						<div class="form-group col-lg-12">
							 <label for="usr" class="col-lg-2">Submodel:</label>
							 <div class="col-lg-10">
							 <input type="text" class="form-control IField" id="Submodel"  name="Submodel">
							 <div class="IText">Series (E46, VF, BA), Engine (2.2, 3.6), Body (Sedan, Ute) etc.</div>
							 </div>
						</div>
						<div class="form-group col-lg-12">
							 <label for="usr" class="col-lg-2">Variant:</label>
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