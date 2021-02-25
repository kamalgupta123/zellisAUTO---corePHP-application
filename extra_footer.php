<!-- Load and execute javascript code used only in this page -->
<script src="<?php echo SITEURL; ?>js/pages/tablesDatatables.js"></script>
<script>$(function(){ TablesDatatables.init(); });</script>

<?php include 'inc/template_end.php'; ?>

<link href="<?php echo SITEURL; ?>css/mb.balloons.css" media="all" rel="stylesheet" type="text/css">
<script src="<?php echo SITEURL; ?>js/jquery.mb.balloon.js"></script>

<script>
var MAX_FILE_SIZE = <?php echo MAX_FILE_SIZE; ?>; // 10 mb size
function loadContent(_href,callback){
	$.ajax({
		type:'post',
		url: _href,
		success: function(data){
			// update sidebar
			var data1 = $(data).filter(".load_Container").html();
			if(typeof(data1)=="undefined"){ data1 = $(".load_Container > *", data); }
			//console.log(data1);
			$(".load_Container").html(data1);
			unsaved=false;
			if(callback && typeof callback == "function"){ 
				callback(data);
			}
		}
	});
}
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Byte';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}
// 10 mb size
function ValidateCSVFile(field){
 return ValidateUpload('csv', MAX_FILE_SIZE, field);
}
function ValidateUpload(ALLOWED_EXTENSIONS, ALLOWED_FILE_SIZE, field){
	var error_msg = "";
	var fuData = field[0];
	var FileUploadPath = fuData.value;
	if (FileUploadPath == '') {
		return "Please upload a csv file.";
	}
	else {
		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
		var arr = ALLOWED_EXTENSIONS;
		if( jQuery.inArray(Extension, ALLOWED_EXTENSIONS) != -1 || Extension == ALLOWED_EXTENSIONS){
		if (fuData.files && fuData.files[0]) {
				var size = fuData.files[0].size;
	//alert(size);
				if(size > ALLOWED_FILE_SIZE){
					return "File size cant be greater than "+bytesToSize(ALLOWED_FILE_SIZE)+".";
				}else{
				   //ok
				}
			}
		} 
		else {
		   if(arr=="csv") {
				return "Only csv files are allowed. ";
			}
			else{
				var array = arr.join(", ");
				return "Only "+array+" files are allowed. ";
			}
		}
	}
	return true;
}
    $(document).ready(function(){ 
		<?php if(strpos($_SERVER['REQUEST_URI'], "/compatible_vehicle.php")){ ?>
		// if($('div.block').hasClass('compatible_vehicle_wrap')) { // when sku row selected
			$('[data-toggle="tooltip"]').tooltip();
			var sku = sessionStorage.getItem('sku');
			var epid = sessionStorage.getItem('epid');
			var brand = sessionStorage.getItem('brand');
			var name = sessionStorage.getItem('name');
			var description = sessionStorage.getItem('description');
			$('.selectedskutable>.table>tbody>tr>td:eq(0)').html(sku);
			$('.selectedskutable>.table>tbody>tr>td:eq(1)').html(epid);
			$('.selectedskutable>.table>tbody>tr>td:eq(2)').html(brand);
			$('.selectedskutable>.table>tbody>tr>td:eq(3)').html(name);
			$('.selectedskutable>.table>tbody>tr>td:eq(4)>.scrollable').html(description);
			$('#skuname>#skufield').html(sku);
			if(name!=''){
				$('#skuname>#descriptionfield').html(name);
			}
			else{
				$('#skuname>#descriptionfield').html('name is not stored');
			}
		// }
		<?php } ?>
		
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
						<?php if(strpos($_SERVER['REQUEST_URI'], "/compatible_vehicle.php")){ ?>
							$('.sg_cpyR').hide();
						<?php } ?>
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
				url:'csv_uploader_ajax.php',
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
					url:'csv_uploader_ajax.php',
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
		
		$(document).on('change','#my_search_table_length select', function() {
			var rows_per_page = $(this).val();
			$.ajax({
				type:'post',
				url:'csv_uploader_ajax.php',
				global:false,
				data:{set_rows_per_page:'action','rows_per_page':rows_per_page},
				success: function(data){ }
			});
		});
	
		$(document).on('click','.showUploadCSVForm',function() {
			$('.NewCSVUploadCont').toggle();
		});
		
		
		$(document).on('submit','#CustomizeFieldsForm',function() {
			var checkC=0;
			if ($('#CustomizeFieldsForm :checkbox:checked').length > 0){
				checkC = 1;
			}
			// console.log(checkC);
			if(checkC==1) {
				var formData = new FormData($("#CustomizeFieldsForm")[0]);
				formData.append("SubmitSelectFields", "action");
				$.ajax({
					type:'post',
					url:'csv_uploader_ajax.php',
					data:formData,
					processData: false,
					contentType: false,
					success: function(data){
						if(data==1) {
							$('#CustomizeFieldsModal').modal('hide');
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
		
		$(document).on('click','.customize_fields',function() {
			$('.err1').html('');
			$('.err_msgs').html("");
			$.ajax({
				type:'post',
				url:'csv_uploader_ajax.php',
				data:{customize_fields:'action'},
				success: function(data){
					$('#CustomizeFieldsModal').modal("show");
					if(data!=''){
						$('#CustomizeFieldsForm').html(data);
					} else {
						$('#CustomizeFieldsForm').html('<div class="alert alert-danger">Columns does not exists.</div>');
					}
				}
			});
			return false;
		});
					
	
		$(document).on("submit","#NeedHelpForm", function() {
			var error=0;
			var name = $('#nameV').val();
			var email = $('#emailV').val();
			var msg = $('#messageV').val();
			if(typeof name == 'undefined' || name == '') {
				error=1;
				$('.err1').html('This field is required*');
			} else{ $('.err1').html(''); }
			if(typeof email == 'undefined' || email == '') {
				error=1;
				$('.err2').html('This field is required*');
			} else{
				pattern =/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				if(!pattern.test(email)) {
					error=1;
					$('.err2').html('Invalid Email address*');
				} else {
					$('.err2').html(''); 
				}
			}
			if(typeof msg == 'undefined' || msg == '') {
				error=1;
				$('.err3').html('This field is required*');
			} else{ $('.err3').html(''); }
			if(error==0) {
				var formData = new FormData($("#NeedHelpForm")[0]);
				formData.append("NeedHelpMail", "action");
				$.ajax({
					type:'post',
					url:'csv_uploader_ajax.php',
					data:formData,
					processData: false,
					contentType: false,
					success: function(data){
						if(data==1) {
							$('.successMsg').html("<div class='alert alert-success'>Message sent. We will be in touch shortly to assist.</div>");
							setTimeout(function(){
								$('#NeedHelpModal').modal('hide');
							}, 5000);
						}
					}
				});
			}
			return false;
		});
		
		$(document).on('click','.help_link',function() {
			$('#NeedHelpModal').modal('show');
			// $('#NeedHelpForm > #hidden').remove();
			$('.formTitle').html('<b>Need Help?</b>');
			$('#hidden_contact').val('');
			$('#emailV').val('');
			$('#messageV').val('');
			$('.successMsg').html('');
		});
		
		$(document).on("submit", "#SearchCSVForm", function(){
				$('.err_msgs').html("");
				$('.search_query_results').html('<div class="col-lg-12"><img src="<?php echo SITEURL;?>/css/images/loader.gif" style="margin:auto;width:50px;"> </div>');
				// import_upload_form
				var formData = new FormData($("#SearchCSVForm")[0]);
				formData.append("SearchCSVSubmit", "action");
				$.ajax({
					type:'post',
					url:'csv_uploader_ajax.php',
					data:formData,
					processData: false,
					contentType: false,
					success: function(data){
						// console.log(data);
						if(typeof data == 'object'){
							$('.search_query_results').html("");
							if(data.errors==""){
								selected_i_id1 = [];
								$('.search_query_results').html(data.html);
								//$('.err_msgs').html("");alert("hi");
								$('#my_search_table').DataTable({
								  "pagingType": "full_numbers" ,
								  "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
								  "pageLength" : data.RowSize,
								  'aoColumnDefs': [{'bSortable': false,'aTargets': ['nosort'] }],
								  responsive: true,
								  autoWidth: false,
								  scrollX: true
								}); 
								
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
			return false;
		});
	
		$(document).on('change','#upload_csv',function(e) {
			var filename = e. target. files[0]. name;
			// console.log("ff",filename);
			$('.csv_filename').html(filename);
		});
		$(document).on("submit", "#UploadCSVform", function(){
			var valid_csv_file = ValidateCSVFile($('#upload_csv'));
			// console.log(valid_csv_file);
			if(valid_csv_file==true){
					$('.err_msgs').html("");
					$('.search_query_results').html('<div class="col-lg-12"><img src="<?php echo SITEURL;?>/css/images/loader.gif" style="margin:auto;width:50px;"> </div>');
					// import_upload_form
					var formData = new FormData($("#UploadCSVform")[0]);
					formData.append("UploadCSVData", "action");
					$.ajax({
						type:'post',
						url:'csv_uploader_ajax.php',
						data:formData,
						processData: false,
						contentType: false,
						success: function(data){
							// console.log(data);
							if(typeof data == 'object'){
								$('.search_query_results').html("");
								if(data.errors==""){
									loadContent(window.location.href);
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
			else{
				$('.err_msgs').html("<div class='alert alert-danger'>"+valid_csv_file+"</div>");
			}
			return false;
		});
		
		var selected_epid1 = []; var selected_ktype1 = []; var selected_i_id1 = [];
		
		$(document).on('click', "#selectallR", function(){ //sgt_chk
			$('input.sgt_chkR').not(this).prop('checked', this.checked);
			var all_epids = '', all_ktypes = '', all_i_ids = '';
			selected_epid1 = []; selected_ktype1 = []; selected_i_id1 = [];
			$('input.sgt_chkR').each(function(){
				// selected_epid1.push($(this).attr('epid'));
				// selected_ktype1.push($(this).attr('ktype'));
				selected_i_id1.push($(this).attr('data-i-id'));
			})
			selected_i_id1= jQuery.unique( selected_i_id1 );
			// console.log(selected_i_id1);
			// all_epids = selected_epid1.join(';');
			// all_ktypes = selected_ktype1.join(';');
			
			all_i_ids = selected_i_id1.join(';');
			
			// console.log(all_epids,all_ktypes);
			if($('#selectallR').prop("checked") == true){
				// $('.get_all_epid').val(all_epids);
				// $('.get_all_ktype').val(all_ktypes);
				$('.get_all_i_id').val(all_i_ids);
				$('.sg_cpyR .btn-info').attr('disabled',false);
			}else{
				// $('.get_all_epid').val('');
				// $('.get_all_ktype').val('');
				$('.get_all_i_id').val('');
				$('.sg_cpyR .btn-info').attr('disabled',true);
				selected_epid1 = []; selected_ktype1 = [];
				all_i_ids1 = []; selected_i_id1 = [];
				// console.log('iii',selected_i_id1);
			}
		});
		
		$(document).on('click', "input.sgt_chkR", function(){
			// console.log('iii',selected_i_id1)
			$(this).each(function() {
				if($(this).prop("checked") == true) {
					// selected_epid1.push($(this).attr('epid'));
					// selected_ktype1.push($(this).attr('ktype'));
					selected_i_id1.push($(this).attr('data-i-id'));
					
					// $('.get_all_epid').val(selected_epid1.join(';'));
					// $('.get_all_ktype').val(selected_ktype1.join(';'));
					
					$('.get_all_i_id').val(selected_i_id1.join(';'));
					
				}else{
					// selected_epid1.splice( $.inArray($(this).attr('epid'),selected_epid1) ,1 );
					// selected_ktype1.splice( $.inArray($(this).attr('ktype'),selected_ktype1) ,1 );
					selected_i_id1.splice( $.inArray($(this).attr('data-i-id'),selected_i_id1) ,1 );
					// console.log('sss',selected_i_id1);
					// $('.get_all_epid').val(selected_epid1.join(';'));
					// $('.get_all_ktype').val(selected_ktype1.join(';'));
					
					$('.get_all_i_id').val(selected_i_id1.join(';'));
					
				}
			});
			
			if($('input.sgt_chkR:checked').length > 0){
				$('.sg_cpyR .btn-info').attr('disabled',false);
			}else{
				$('.sg_cpyR .btn-info').attr('disabled',true);
			}
			//console.log(selected_epid,selected_ktype);
		});
		
		$(document).on('click', "#copy_Internal_id", function(){
			if($('.get_all_i_id').val() !== ''){
				copyToClipboard($('.get_all_i_id'));
			}
		});
		
	
        // $("#sub").click(function(){
		$(document).on('submit','#eBayForm',function(e) {
			e.preventDefault();
			var myversion = $('#myversiontext').val();
			if (myversion != null) {
			}
			
			$('.search_query_results').html('<div class="col-lg-12"><img src="<?php echo SITEURL;?>/css/images/loader.gif" style="margin:auto;width:50px;"> </div>');
			var Make = $("#Make").val();
			var Model = $("#Model").val();
			/* var Model_Code = $("#Model_Code").val();
			var Body = $("#Body").val();
			var Type = $("#Type").val();
			var Engine = $("#Engine").val(); */
			var Submodel = $('#Submodel').val();
			var Variant = $('#Variant').val();
			var mversion = '';
			var year_from = $('#year-from').val();
			var year_to = $('#year-to').val();
          
            $.post("csv_uploader_ajax.php",
			{
				Make:Make,
				Model:Model,
				Submodel:Submodel,
				Variant:Variant,
				year_from:year_from,
				year_to,year_to,
				search_data:'search_data'
			},
			function(response,status){
                if(typeof response == 'object'){
					$('.search_query_results').html("");
					if(response.html!='') {
						$(".search_query_results").append(response.html);
						$('#my_search_table').DataTable( {
						  "pagingType": "full_numbers" ,
						  "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
						  "pageLength" : 25,
						  'aoColumnDefs': [{'bSortable': false,'aTargets': ['nosort'] }],
						  responsive: true,
						  autoWidth: false,
						} );
						<?php if(strpos($_SERVER['REQUEST_URI'], "/compatible_vehicle.php")){ ?>
							$('#EpidWrap').hide();
							$("#Epid").hide();
							$("#K_Type").hide();
							$("#copyEpid").hide();
							$('#KTypeAccess').hide();
						<?php } ?>
						$('#selectall').parent().removeClass('sorting_asc');
					}
				}
			});
			return false;
        });
		
      });

<?php if(strpos($_SERVER['REQUEST_URI'], "/compatible_vehicle.php")){ ?>
var replace = true;
    var append = false;
<?php } ?>
	var all_contentt,current_id;
		/* var myversion = $('#myversiontext').val();
		if (myversion != null) { */
				
			$(document).ready(function(){ 
				$.post("csv_uploader_ajax.php",
				{
					content_search:'content_search',
					// myver: myversion
				},
				function(response,status){
					// console.log(response);
					all_contentt= jQuery.parseJSON(response);
					$("#loader_container").css("display","none");
				 
				});
			});  
		// }	
	
	
	var selected_epid = []; var selected_ktype = []; var selected_content_id = [];
	
	$(document).on('click', "#selectall", function(){ //sgt_chk
	    $('input.sgt_chk').not(this).prop('checked', this.checked);
	    var all_epids = '', all_ktypes = ''; all_content_id = '';
	    selected_epid = []; selected_ktype = []; selected_content_id = [];
	    $('input.sgt_chk').each(function(){
            selected_epid.push($(this).attr('epid'));
            selected_ktype.push($(this).attr('ktype'));
            
            current_id=$(this).attr('epid');
            // selected_content_id.push($(this).attr('epid'));
            if(typeof all_contentt[current_id] === 'undefined'){
                console.log("No Content id found for epid");
                
            }else{
                selected_content_id.push(all_contentt[current_id]);
            }
            
	      
	    })
	   
	    all_epids = selected_epid.join(';');
	    all_ktypes = selected_ktype.join(';');
	    all_content_id = selected_content_id.join(';');
	    
	    if($('#selectall').prop("checked") == true){
	        $('.get_all_epid').val(all_epids);
	        $('.get_all_ktype').val(all_ktypes);
	        $('.get_all_content_id').val(all_content_id);
	        $('.sg_cpyR .btn-info').attr('disabled',false);
	    }else{
	        $('.get_all_epid').val('');
	        $('.get_all_ktype').val('');
	        $('.get_all_content_id').val('');
	        $('.sg_cpyR .btn-info').attr('disabled',true);
	        selected_epid = []; selected_ktype = [];selected_content_id=[];
	    }
	});
	
	$(document).on('click', "input.sgt_chk", function(){
	    $(this).each(function() {
	        if($(this).prop("checked") == true) {
	            selected_epid.push($(this).attr('epid'));
	            selected_ktype.push($(this).attr('ktype'));
	            
	            current_id=$(this).attr('epid');
	            if(typeof all_contentt[current_id] === 'undefined'){
					console.log("No Content id found for epid");
					
				}else{
					selected_content_id.push(all_contentt[current_id]);
				}
			
				$('.get_all_epid').val(selected_epid.join(';'));
    	        $('.get_all_ktype').val(selected_ktype.join(';'));
    	        $('.get_all_content_id').val(selected_content_id.join(';'));
			
	        }else{
	            selected_epid.splice( $.inArray($(this).attr('epid'),selected_epid) ,1 );
	            selected_ktype.splice( $.inArray($(this).attr('ktype'),selected_ktype) ,1 );
	            
	            current_id=$(this).attr('epid');
                
                    if(typeof all_contentt[current_id] === 'undefined'){
						console.log("No Content id found for epid");
						
					}else{
							current_id=all_contentt[current_id];
					}
	            selected_content_id.splice( $.inArray(current_id,selected_content_id) ,1 );
    	        $('.get_all_epid').val(selected_epid.join(';'));
    	        $('.get_all_ktype').val(selected_ktype.join(';'));
    	        $('.get_all_content_id').val(selected_content_id.join(';'));
				
	        }
	    })
	    
	    if($('input.sgt_chk:checked').length > 0){
	        $('.sg_cpyR .btn-info').attr('disabled',false);
	    }else{
	        $('.sg_cpyR .btn-info').attr('disabled',true);
	    }
	    //console.log(selected_epid,selected_ktype);
	})
	
	$(document).on('click', "#copyEpid", function(){
	    if($('.get_all_epid').val() !== ''){
    	    copyToClipboard($('.get_all_epid'));
	    }
	})
	
		$(document).on('click', "#copy_content_id", function(){
	    if($('.get_all_content_id').val() !== ''){
    	    copyToClipboard($('.get_all_content_id'));
	    }
	})
	
	$(document).on('click', "#copyKtype", function(){
	    if($('.get_all_ktype').val() !== ''){
    	    copyToClipboard($('.get_all_ktype'));
	    }
	})
	
	<?php if(strpos($_SERVER['REQUEST_URI'], "/compatible_vehicle.php")){ ?>
    $(document).on('click', "#replace-epids", function(){
		$("#replace-epids").addClass("replaceEpids");
		$("#append-epids").removeClass("appendEpids");
		replace = true;
		append = false;
	});

    $(document).on('click', "#append-epids", function(){
		$("#replace-epids").removeClass("replaceEpids");
		$("#append-epids").addClass("appendEpids");
		append = true; 
		replace = false; 
	})
	
	// on clicking save selected vehicles it replaces the epid column from table if replace id selected else 
	// it appends the epids
	$(document).on('click', "#save_vehicles", function(){
		// console.log($('.hiddenSelectedEpids').val());
		if($('.get_all_epid').val() !== ''){ 
			if(replace == true){
					// copyReplaceEpidsToClipboard($('.get_all_epid'));
					copyReplaceEpidsToClipboard($('.get_all_epid'));
				
			}
			else if(append == true){
					copyAppendEpidsTall_epidsoClipboard($('.get_all_epid'));
				
			}
		} else{
			
		}
	})
	<?php } ?>
	//gets the epids to be replaced
    function copyReplaceEpidsToClipboard(element) {
        var epid_to_send = $(element).val(); //misc
		// console.log(epid_to_send);
		var sku = sessionStorage.getItem('sku'); //filter or id
		$.ajax({
				type: 'POST',
				url: 'api_update.php',
				data:  { epid_to_send:epid_to_send, sku:sku},
				success: function(result) {
					//alert('siuccrss');
					$('#successModal').modal('show');
				},
				error: function() {
					alert('error');
				}
		});
    }
	
	// appends the new string with the old string to get the final appended epids
    function copyAppendEpidsToClipboard(element) {
		var old_epid = sessionStorage.getItem('epid');
		var epidToAppend = $(element).val(); //misc
		var epid_to_send = old_epid+','+epidToAppend;
		// console.log(epid_to_send);
		var sku = sessionStorage.getItem('sku'); //filter or id
		$.ajax({
				type: 'POST',
				url: 'api_update.php',
				data:  { epid_to_send:epid_to_send, sku:sku},
				success: function(result) {
					//alert('siuccrss');
					$('#successModal').modal('show');
					
				},
				error: function() {
					alert('error');
				}
		});
    }
	
	function toggleModal(){
		$('#successModal').modal('toggle');
	}

	// END ------  Changed By Kamal Gupta

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).val()).select();
        if(document.execCommand("copy")== true){ console.log('copied'); }
        $temp.remove();
    }
</script>
