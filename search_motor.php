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
	
	// ;echo "</pre>";print_r($_SESSION);echo "</pre>";
?>
	
<!--div id="loader_container"></div-->
<div id="page-content">
    <!-- Blank Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i><img class="zlogo" src="<?php echo SITEURL; ?>img/zlogo.png"></i>eBay Motorcycle Fitment Tagging<br><small></small>
            </h1>
        </div>
    </div>
	<ul class="breadcrumb breadcrumb-top">
        <li>Dashboard</li>
        <li><a href="">eBay Motorcycle Fitment</a></li>
    </ul>
	<div class="row">
		<div class="col-lg-12">
		    <div class="row">
				<img src="<?php echo SITEURL; ?>img/eBay_logo2000px.png" class="eBayLogo" alt="eBay">
				<img src="<?php echo SITEURL; ?>img/bike133.png" class="carLogo bikeLogo" alt="car">
				<div class="col-lg-2 ButtonConnectToNeto">
					<button class="btn btnPrimary Neto" id="btn-one">Load my Neto SKUs</button>
				</div>
				<span class="orTextNeto">or</span>
				<div class="col-lg-2 ButtonConnectToNeto">			
					<button class="btn searchManuallyButton" id="btn-two" >Search Manually</button>
				</div>
			</div>
		</div>
	</div>
	<div class="api_credentials_error"></div>
	<div id="contentdata" class="contentData"> 
		<div id="buttonsForEpids" class="lh-3">
			<label> Show SKUs with ePIDs : </label>
			<button id="yestoggle" data-show="2" class="btn defaultBtn get_list_from_api">Yes</button>
			<button id="notoggle" data-show="3" class="btn defaultBtn get_list_from_api">No</button>
			<button id="alltoggle" data-show="1" class="btn defaultBtn get_list_from_api">All</button>
			<span class="space"></span>
			<div class="circularOrangeDot text-center lh-1 fontSize-1">1</div>
			<label class="text-left mt-5">Search for the product you wish to apply fitment to and click it</label>
		</div>	
		<div class="row LoaderDiv">
			<div class="col-lg-12">
				<div id = "loader">
					<img class="LoaderImg" />
				</div>
			</div>
		</div>
		<div id="apitable">
			
		</div>
		<div id="error">
			
		</div>
		<div class="pagination-div">
			<a href="#" class="prev">❮</a>
			<a href="#" class="next">❯</a>
		</div>
		<div class="row">
			<div class="col-lg-12"></div>
		</div>
	</div>    
    <div class="block blockStyle" style="display:none;">
        <!--div class="block-title" style="padding-bottom: 10px;">
            <img src="<?php // echo SITEURL; ?>img/eBay_logo2000px.png" class="eBay_logo" alt="eBay">
			<?php 
			/* if(isset($_POST['myversion'])) {
				$myversion = $_POST['myversion']; */
				
			?>
				
			<?Php // }
			// else { echo '<h2>Search</h2>'; }
			?> 
        </div-->

		<div class="container blockContainer" style="margin-top:20px;margin-bottom:20px;width:100% !important">
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
						<a href="" class="btn btn-default customize_fields_motors aCustomizeFields divfieldWrap fontSize-small space"><i class="fa fa-gear"></i> Customise Search Fields</a>
						<!--a href="" class="btn btn-primary"  style="float:right;margin:5px;">Clear</a-->
						<!--a href="" class="btn btn-secondary customize_fields_motors"  style="float:right;margin:5px;">Customize Fields</a-->
						<button type="submit" id="sub" class="btn btnSuccess col-lg-12 ebayFormSearchBtn">Search</button>
						<a href="" class="btn btnGrey ebayFormClear1">Clear</a>
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
<script>
// to access SITE_URL in the javascript page 
var neto_key;
var neto_id;
var search =2;
 $(document).ready(function(){
	 neto_key = '<?php if(!empty($d_row['api_key'])) { echo $d_row['api_key']; } else { echo ""; } ?>';
	 neto_id = '<?php if(!empty($d_row['api_key'])) { echo $d_row['custom_field']; } else { echo ""; } ?>';
	 
 });
</script>
<?php 
	include 'inc/page_footer.php';
	include 'inc/template_scripts.php'; 
	include 'extra_footer.php';
?>
<script>
</script>