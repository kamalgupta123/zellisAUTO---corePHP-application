<?php 
	include 'inc/config.php'; 
	include 'inc/template_start.php';
	include 'inc/page_head.php';
	$obj->admin_not_login(); 
	$us_id = $_SESSION['myuser']['us_id'];
	$sqlQry = $connect->query("select api_key,custom_field from user where us_id=".$us_id);
	if($sqlQry->num_rows) {
		$d_row = $sqlQry->fetch_assoc();
	}
	$Apikey = $d_row['api_key'];
	$Apiskufield = $d_row['custom_field'];
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
	<div class="row">
		<div class="col-lg-12">
			<span class="select">
				<label>Please choose:</label>
				<span class="one">
					<input id="349" type="radio" class="radio-one" name="toggle">
					<label for="349">Connect to my Neto account</label>
				</span>
				<span class="two">
					<input id="348" type="radio" class="radio-two" name="toggle">
					<label for="348">Search manually</label >
				</span>
			</span>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div id="content">
			</div>
		</div>
	</div>
    
	<!-- Neto api radio selector -->
</div>



<div id="check" class="checkbox" style="
    position: absolute;
    top: 480px;
	left: 218px;
	display:none;
">
  <label><input id="c" type="checkbox" value="">Empty ePIDs</label>
</div>

<table id="apiDataTable" data-page-length='10'>
<thead>
	<tr>
		<th>SKU</th>
		<th>ePIDs</th>
		<th>Brand</th>
		<th>Name</th>
		<th>Description</th>
	</tr>
</thead>
<tbody></tbody>
<tfoot>
	<tr>
		<th>SKU</th>
		<th>ePIDs</th>
		<th>Brand</th>
		<th>Name</th>
		<th>Description</th>
	</tr>
</tfoot>
</table>


<?php 
	include 'inc/page_footer.php';
	include 'inc/template_scripts.php'; 
	include 'extra_footer.php';
?>

<script>
var neto_key = '';
var neto_id = '';
var sku;
var epid;
$(document).ready(function(){
	$('#apiDataTable').css('display','none');
	$('#check').css('display','none');
	$(".radio-two").on('change',function(e){
			$("#content").html('');
			$('.neto-connect').remove();
			$('.neto-id').remove(); 
			$('#content').append('<div class="row" style="margin-top:15px;"><div class="loader"><div class="col-lg-12"><img src="<?php echo SITEURL;?>/css/images/loader.gif" style="margin:auto;width:50px;"> </div></div></div>'); 
			$("#c").prop("checked", false);
			$('#apiDataTable > thead').remove();
			$('#apiDataTable').css('display','none');
			$('#apiDataTable_wrapper').css('display','none');
			$('#check').css('display','none');
			$('#btn-gp1').remove();
			$('#btn-gp2').remove();
			$('#api-call').remove();
			$('br').remove();
			$.ajax({
			url: "manual_search.php",
			method: "GET",
			success: function(result){
				$('.loader').html('');
				$('.neto-connect').remove();
				$('.neto-id').remove();
				$("#content").append(result);
			}});
	});
	$(".radio-one").on('change',function(e){
				$("#content").html('');
				neto_key = '<?php echo $Apikey ;?>';
				neto_id = '<?php echo $Apiskufield ;?>';
				console.log(neto_key);
				console.log(neto_id);
				$('.block').remove();
				if(neto_key !== '' && neto_id !== '') {
					$("#content").html('');
					$("#content").append("<span class='neto-connect' id='neto-c'><div class='row' style='margin-left:1px;'><p style='font-weight:bold;color:#000;'>Please enter your Neto API Key:</p></div><div class='row'><div class='col-lg-3'><input type='text' style='width: auto' class='form-control' width='20px' id='connect-key' value='"+neto_key+"'></div><div class='col-lg-1'><button id='api-key' class='btn btn-primary'  style='float:left;margin-left:-78px;'>Save</button></div></div></span>");
					$("#content").append("<br><span class='neto-id'><div class='row' style='margin-left:1px;'><p  style='font-weight:bold;color:#000;'>What is the custom SKU filed in Neto you are using for eBay ePIDs:</p></div><div class='row'><div class='col-lg-3'><select style='width: 196px' class='form-control' name='connect-id' id='connect-id'><option selected='selected'>"+neto_id+"</option><option value='Misc01'>Misc01</option><option value='Misc02'>Misc02</option> <option value='Misc03'>Misc03</option><option value='Misc04'>Misc04</option><option value='Misc05'>Misc05</option><option value='Misc06'>Misc06</option><option value='Misc07'>Misc07</option><option value='Misc08'>Misc08</option><option value='Misc09'>Misc09</option><option value='Misc10'>Misc10</option><option value='Misc11'>Misc11</option><option value='Misc12'>Misc12</option><option value='Misc13'>Misc13</option><option value='Misc14'>Misc14</option><option value='Misc15'>Misc15</option><option value='Misc16'>Misc16</option><option value='Misc17'>Misc17</option><option value='Misc18'>Misc18</option><option value='Misc19'>Misc19</option><option value='Misc20'>Misc20</option><option value='Misc21'>Misc21</option><option value='Misc22'>Misc22</option><option value='Misc23'>Misc23</option><option value='Misc24'>Misc24</option><option value='Misc25'>Misc25</option><option value='Misc26'>Misc26</option><option value='Misc27'>Misc27</option><option value='Misc28'>Misc28</option><option value='Misc29'>Misc29</option><option value='Misc30'>Misc30</option><option value='Misc31'>Misc31</option><option value='Misc32'>Misc32</option><option value='Misc33'>Misc33</option><option value='Misc34'>Misc34</option><option value='Misc35'>Misc35</option><option value='Misc36'>Misc36</option><option value='Misc37'>Misc37</option><option value='Misc38'>Misc38</option><option value='Misc39'>Misc39</option><option value='Misc40'>Misc40</option><option value='Misc41'>Misc41</option><option value='Misc42'>Misc42</option><option value='Misc43'>Misc43</option><option value='Misc44'>Misc44</option><option value='Misc45'>Misc45</option><option value='Misc46'>Misc46</option><option value='Misc47'>Misc47</option><option value='Misc48'>Misc48</option><option value='Misc49'>Misc49</option><option value='Misc50'>Misc50</option><option value='Misc51'>Misc51</option><option value='Misc52'>Misc52</option></select></div><div class='col-lg-1'><button id='api-id' class='btn btn-primary'  style='float:left;margin-left:-78px;'>Save</button></div></div></span>");
					$("#content").append("<br><button class='btn btn-default' style='margin-left:5px;' id='btn-gp1'>Change Neto Key</button><button class='btn btn-default' style='margin-left:5px;' id='btn-gp2'>Change Neto SKU Field</button><button class='btn btn-success' style='margin-left:5px;' id='api-call'>Load Neto SKUs</button>");
					$("#connect-key").attr("disabled", "disabled"); 
					$("#api-key").prop('disabled', true);
					$("#connect-id").prop('disabled', true);  
					$("#api-id").prop('disabled', true);  
					$('#api-call').one('click', function (){
						$('#content').append('<div class="row" style="margin-top:15px;"><div class="loader"><div class="col-lg-12"><img src="<?php echo SITEURL;?>/css/images/loader.gif" style="margin:auto;width:50px;"> </div></div></div>');
						saveNetoIdKeyToDb();
						apiCallToGetList();						
					})
				}
				else{
					$("#content").html('');
					$("#content").append("<span class='neto-connect' id='neto-c'><div class='row' style='margin-left:1px;'><p style='font-weight:bold;color:#000;'>Please enter your Neto API Key:</p></div><div class='row'><div class='col-lg-3'><input type='text' style='width: auto' class='form-control' width='20px' id='connect-key'></div><div class='col-lg-1'><button id='api-key' class='btn btn-primary'  style='float:left;margin-left:-78px;'>Save</button></div></div></span>");
					$('#api-key').one('click', function (){
						$("#content").append("<br><span class='neto-id'><div class='row' style='margin-left:1px;'><p  style='font-weight:bold;color:#000;'>What is the custom SKU filed in Neto you are using for eBay ePIDs:</p></div><div class='row'><div class='col-lg-3'><select style='width: 196px' class='form-control' name='connect-id' id='connect-id'><option value='Misc01'>Misc01</option><option value='Misc02'>Misc02</option> <option value='Misc03'>Misc03</option><option value='Misc04'>Misc04</option><option value='Misc05'>Misc05</option><option value='Misc06'>Misc06</option><option value='Misc07'>Misc07</option><option value='Misc08'>Misc08</option><option value='Misc09'>Misc09</option><option value='Misc10'>Misc10</option><option value='Misc11'>Misc11</option><option value='Misc12'>Misc12</option><option value='Misc13'>Misc13</option><option value='Misc14'>Misc14</option><option value='Misc15'>Misc15</option><option value='Misc16'>Misc16</option><option value='Misc17'>Misc17</option><option value='Misc18'>Misc18</option><option value='Misc19'>Misc19</option><option value='Misc20'>Misc20</option><option value='Misc21'>Misc21</option><option value='Misc22'>Misc22</option><option value='Misc23'>Misc23</option><option value='Misc24'>Misc24</option><option value='Misc25'>Misc25</option><option value='Misc26'>Misc26</option><option value='Misc27'>Misc27</option><option value='Misc28'>Misc28</option><option value='Misc29'>Misc29</option><option value='Misc30'>Misc30</option><option value='Misc31'>Misc31</option><option value='Misc32'>Misc32</option><option value='Misc33'>Misc33</option><option value='Misc34'>Misc34</option><option value='Misc35'>Misc35</option><option value='Misc36'>Misc36</option><option value='Misc37'>Misc37</option><option value='Misc38'>Misc38</option><option value='Misc39'>Misc39</option><option value='Misc40'>Misc40</option><option value='Misc41'>Misc41</option><option value='Misc42'>Misc42</option><option value='Misc43'>Misc43</option><option value='Misc44'>Misc44</option><option value='Misc45'>Misc45</option><option value='Misc46'>Misc46</option><option value='Misc47'>Misc47</option><option value='Misc48'>Misc48</option><option value='Misc49'>Misc49</option><option value='Misc50'>Misc50</option><option value='Misc51'>Misc51</option><option value='Misc52'>Misc52</option></select></div><div class='col-lg-1'><button id='api-id' class='btn btn-primary'  style='float:left;margin-left:-78px;'>Save</button></div></div></span>");
						$('#api-id').one('click', function (){
						$("#content").append("<br><button class='btn btn-default' style='margin-left:5px;' id='btn-gp1'>Change Neto Key</button><button class='btn btn-default' style='margin-left:5px;' id='btn-gp2'>Change Neto SKU Field</button><button class='btn btn-success' style='margin-left:5px;' id='api-call'>Load Neto SKUs</button>");
							$('#api-call').one('click', function (){
							$('#content').append('<div class="row" style="margin-top:15px;"><div class="loader"><div class="col-lg-12"><img src="<?php echo SITEURL;?>/css/images/loader.gif" style="margin:auto;width:50px;"> </div></div></div>');
							saveNetoIdKeyToDb();
							apiCallToGetList();					
							})
						})
					}) 
				}

				function saveNetoIdKeyToDb(){
					neto_key = $('#connect-key').val();
					neto_id = $('#connect-id').val();
					$.ajax({
								type: 'POST',
								url: 'neto_id-key_to_db.php',
								data:  { neto_key:neto_key, neto_id:neto_id},
								success: function(result) {
									//alert('siuccrss');
									
								},
								error: function() {
									$('.loader').html('');
									$("#content").append("<div class='alert alert-warning'><strong>Warning!</strong> Unable to put id and key into the database Please refresh the page </div>");
								}
					});
				}

				function apiCallToGetList(){
					$.ajax({
						url: 'api.php',
						success: function(result) {
								$('.loader').html('');
								var data = JSON.parse(result);
								if(data.Ack == "Error"){
								// $('#apiDataTable_wrapper').css('display','none');
								// $('.dataTables_scrollBody #apiDataTable thead').html("");
								// $('#apiDataTable > tbody').html(" ");
								$("#content").append("<div class='row'><div class='col-lg-12'><div class='jumbotron' style='margin-top:99px;margin-left:450px;'><p class='text-danger'>Invalid API Key</p></div></div></div>");
								}
								var d = data["Item"];
								var api_data = '';
								$.each(d, function(i, item) {
									api_data += '<tr>';
									api_data += '<td>'+d[i].SKU+'</td>';
									api_data += '<td>'+d[i][neto_id]+'</td>';
									api_data += '<td>'+d[i].Brand+'</td>';
									api_data += '<td>'+d[i].Name+'</td>';
									var $div = $(d[i].Description);
									var str = "";
									$div.find("font[face=Arial]").each(function(){
									str += $(this).text() + "<br>";
									})
									api_data += '<td>'+str.substr(0,100);+'</td>';
									api_data += '</tr>';
								});	
							//  $('.dataTables_scrollBody #apiDataTable thead').html("");
							//  $('#apiDataTable > tbody').html(" ");						 
								$('#apiDataTable > tbody').append(api_data);
								$('#apiDataTable').css('display','block');
								$('#check').css('display','block');
								$('#apiDataTable_wrapper').css('display','block');
								$('#apiDataTable tr > td:nth-child(2)').each(function () {
										if ($(this).html() !== '') {
											$(this).parent().show();
										}
							});

							$('#apiDataTable thead tr').clone(true).appendTo( '#apiDataTable thead' );
							$('#apiDataTable thead tr:eq(1) th').not(":eq(1),:eq(4)").each( function (i) {
								var title = $(this).text();
								$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
						
								$( 'input', this ).on( 'keyup change', function () {
									if ( table.column(i).search() !== this.value ) {
										table
											.column(i)
											.search( this.value )
											.draw();
									}
								} );
							} );
						
							var table;

							if ( $.fn.dataTable.isDataTable( '#apiDataTable' ) ) {
								 $('#apiDataTable').DataTable();
							}
							else {
								 $('#apiDataTable').DataTable( {
									"pagingType": "full_numbers",
									orderCellsTop: true,
									fixedHeader: true,
									"scrollY": 200
								} );
							}

							$('#apiDataTable tbody').on('click','tr', function () {
									$(this).css('color', 'blue');
									sku = $(this).find('td:eq(0)').text();
									epid = $(this).find('td:eq(1)').text();
									sessionStorage.setItem("sku", sku);
									sessionStorage.setItem("epid", epid);
									window.open("compatible_vehicle.php");
							});
							
							$('#c').click(function (){
								if($('#c').is(":checked")){
									$('#apiDataTable tr > td:nth-child(2)').each(function () {
										if ($(this).html() !== '') {
											$(this).parent().hide();
										}
									});
								}
							})												
						},
						error: function() {
							$('.loader').html('');
							$("#content").append("<div class='alert alert-warning'><strong>Warning!</strong> Unable to get the data for table from the database Please refresh the page </div>");
						}
					});
				}

				$(document).on('click', "#api-key", function(){
					$("#connect-key").attr("disabled", "disabled"); 
					$("#api-key").prop('disabled', true); 
				})
				
				$(document).on('click', "#api-id", function(){
					$("#connect-id").prop('disabled', true); 
					$("#api-id").prop('disabled', true);
				})

				$(document).on('click', "#btn-gp1", function(){
					$("#connect-key").removeAttr("disabled"); 
					$("#api-key").prop('disabled', false); 

				})	

				$(document).on('click', "#btn-gp2", function(){
					$("#connect-id").prop('disabled', false); 
					$("#api-id").prop('disabled', false);
				})		
	});

});
</script>