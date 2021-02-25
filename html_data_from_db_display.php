<?php 
    include 'inc/config.php';  
	include 'inc/template_start.php';
	include 'inc/page_head.php';
	$obj->admin_not_login();
	if(!empty($_GET['page_id'])) {
		$result=$connect->query("SELECT page_content FROM pages_content WHERE page_id=".$_GET['page_id']);
		
		if ($result->num_rows > 0) {
				// output data of each row
				$row = $result->fetch_assoc();
		} 
	} else{
		// echo "<div class='alert alert-danger'>Data not found!</div>";
	}
	echo $_SERVER['DOCUMENT_ROOT'];	
?>
<div id="page-content" style="background:#fff;">
	<div class="" >
    <?php
		if(!empty($row["page_content"])) {
			echo  htmlspecialchars_decode(stripslashes($row["page_content"]));
		}	else{
			echo "<div class='alert alert-danger'>Data not found!</div>";
		}	
			
    ?>
	</div>
</div>
<?php 
	include 'inc/page_footer.php';
	include 'inc/template_scripts.php'; 
	include 'extra_footer.php';
?>
