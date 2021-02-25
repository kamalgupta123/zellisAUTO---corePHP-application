<?php 
	include 'inc/config.php'; 
	include 'inc/template_start.php';
	include 'inc/page_head.php';
	$obj->admin_not_login();
	$d_row = array();
	$us_id = $_SESSION['myuser']['us_id'];
	$sqlQry = $connect->query("select us_lock from user where us_id=".$us_id);
	if($sqlQry->num_rows) {
		$d_row = $sqlQry->fetch_assoc();
	}
	if($d_row['us_lock']){
		include 'inc/user_locked.php';
	}
	else{
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
    </ul>

    <div class="block">

		<div class="container" style="margin-top:20px;margin-bottom:20px;width:100% !important">
			<div class="m_block ebay_fitment_wrap width-42">
			<a href="<?php echo SITEURL; ?>index.php">
				<img src="<?php echo SITEURL; ?>img/eBay_logo2000px.png" alt="eBay">
				<p>Vehicle Compatibility</p>
			</a>
			</div>
			<div class="m_block ebay_fitment_wrap width-42">
			<a href="<?php echo SITEURL; ?>search_motor.php">
				<img src="<?php echo SITEURL; ?>img/eBay_logo2000px.png" alt="motercycle">
				<p>Motorcycle Compatibility</p>
			</a>
			</div>
			<div class="m_block website_fitment_wrap width-42">
			<a href="<?php echo SITEURL; ?>website-fitment.php">
				<img src="<?php echo SITEURL; ?>img/globe2.png" alt="eBay">
				<p>Website Parts Fitment</p>
			</a>
			</div>

			

		</div>		
			
	</div>
</div>

<?php }
include 'inc/template_scripts.php';
include 'extra_footer.php';
include 'inc/page_footer.php';
?>
