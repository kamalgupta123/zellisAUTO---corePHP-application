<?php include dirname(__FILE__).'/../inc/config.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_start.php'; ?>

<?php include dirname(__FILE__).'/../inc/page_head.php'; ?>

<?php $obj->check_admin_not_login(); ?>
<style>td.opener {cursor: pointer;}</style>
<!-- Page content -->
<?Php
$current_userid = $_SESSION['admin']['id'];
$user_level = $_SESSION['admin']['user_level'];
if($current_userid == 1 || $user_level == 1)
{
	$my_error = 0;	
	$my_cuserc = '';
	if(isset($_GET['page_id']))
	{
		$mpage_id = $_GET['page_id'];
		$mpage_id2 = 0;
			$msel = "DELETE FROM `pages_content` WHERE `page_id`='$mpage_id'"; 
			$mqueryuisel	=	$connect->query($msel);
			if($mqueryuisel)
			{
				$my_error = 1;
			}
	}
}	
?>
<div id="page-content">
    <!-- Blank Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
            <!--<i><img class="zlogoA" src="<?php //echo SITEURL; ?>img/zlogo.png"></i>  -->
            Page Content<br><small></small></h1>
        </div>
    </div>
	<ul class="breadcrumb breadcrumb-top">
		<li>Dashboard</li>
		<li><a href="">Page Content</a></li>
    </ul>
    <!-- END Blank Header -->

	<!-- END Page Content -->
	<div class="block">
	<a href="page_content.php" class="mb-20"><button class="btn btn-primary">Add Page Content</button></a>
	<br>
	<br>
	<div class="table-responsive">
			<?php if($my_error == 1)
			{
				echo '<p class="error my_error no_padd">Content Deleted Successfully</p>';
			}
			
			if($current_userid == 1 || $user_level == 1) {
			?>		
			<?php
			}
				$mi = 1;
				$mselect1	=	"SELECT page_id,page_title, DATE_FORMAT(created_on, '%m/%d/%Y %h:%i %p') as created_on,is_active FROM `pages_content` ORDER BY page_id ASC";
				$mquery1	=	$connect->query($mselect1);
				if ($mquery1->num_rows > 0) 
				{
					?>
					<div class="table-responsive">
						<table id="example-datatable1" class="table table-hover table-vcenter table-condensed table-bordered">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th>Page Title</th>
									<th>Active</th>
									<th>Created On</th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php
								while($mresults1	=	$mquery1->fetch_assoc())
								{
                                    $active_class = ($mresults1['is_active'] == 1) ? 'success' : 'danger';
                                    $active_text = ($mresults1['is_active'] == 1) ? 'Active' : 'In-active';
                                    $active = '<b class="text text-'.$active_class.'">'.$active_text.'</b>';
									?> 
									<tr>
										<td class="text-center"><?php echo $mi; ?></td>
										<td><a href="page_content.php?page_id=<?php echo $mresults1['page_id']; ?>"><?php echo $mresults1['page_title']; ?></a></td>
										<td><?php echo $active; ?></td><td><?php echo $mresults1['created_on']; ?></td>
								
										<td class="text-center">
											<div class="btn-group">
												<a href="page_content.php?page_id=<?php echo $mresults1['page_id']; ?>"  title="Edit" class="btn btn-sm btn-success">Edit &nbsp;<i class="fa fa-pencil"></i></a>
												 
												<a href="?page_id=<?php echo $mresults1['page_id']; ?>" class="btn btn-sm btn-danger" title="Delete User"
	                                            onclick="return confirm('Are you sure, you want to Delete this user?')">Delete &nbsp;<i class="fa fa-times"></i></a>
												
											</div>
										</td>
									</tr>
									<?php
									$mi++;
									
								}
								?>
							</tbody>
						</table>
					</div>
						<?php
				}
				else
				{
					echo 'No Content Found';
				}
			?>
        </div>
        <!-- END Example Content -->
	
	</div>

<?php include dirname(__FILE__).'/../inc/page_footer.php'; ?>

<?php include dirname(__FILE__).'/../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<!--script src="js/pages/tablesDatatables.js"></script>
<script>$(function(){ TablesDatatables.init(); });</script-->