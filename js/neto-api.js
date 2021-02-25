$(document).ready(function(){
    $('#loader > img').attr('src', SITE_URL+'/css/images/loader.gif');
    var table;
	$('#apitable').hide();
	$('.pagination-div').hide();
	var page=0;
	if (window.location.href === '#get_sku_list') {
		$('#apiDataTable thead tr').not(":eq(0)").each( function (i) {
			$(this).remove();
		} );  
		if($('.btnPrimary.active').length==0) {
			$('#btn-one').addClass('active');
			$('#btn-two').removeClass('active');
		} 
		$("#contentdata").show();
		apiCallToGetList(1); 
		// $('#btn-one').trigger('click');
	}

	$(document).on('click','.contact-zellis',function() {
		$('#NeedHelpModal').modal('show');
		// $('#NeedHelpForm').append("<input type='hidden' id='hidden' name='contact' value='contact'></input>");
		$('.formTitle').html('<b>Locked ZELLIS Auto account</b>');
		$('#hidden_contact').val('1');
		$('#emailV').val('');
		$('#messageV').val('');
		$('.successMsg').html('');
	});

	$(document).on('click','#ktype-checked',function() {
		var checked = 0;
		if(this.checked){ 
			checked=1;
		}
		else{
			checked=0;
		}
		$.ajax({
			url: 'csv_uploader_ajax.php',
			method: 'post',
			data:{checked:checked,actioncheck:'checked'},
			success: function(result) {
				// console.log(checked);
				if(result!='') {
					if(result==1) {
						$('#K_Type').css({'display':'block'}); 
					} else{
						$('#K_Type').css({'display':'none'}); 
					}
				}
			}
		});
	});
	
    // on clicking second radio button you will see the old functionality
    $(document).on('click', "#btn-two", function(){
		$('.customize_fields').show();
		$("#contentdata").hide();
		$(".api_credentials_error").html("");
		if($('.searchManuallyButton.active').length==0) {
			$(this).addClass('active');
			$('#btn-one').removeClass('active');
		} 
		$(".block").show();
    });

    // on clicking first radio you can enter the api key and sku to get the list if api key is already stored it would be shown within textboxes automatically you just need to call the api to see list
    $(document).on('click', "#btn-one", function(){
		
		$(".block").hide();
		if(neto_key !== '' && typeof neto_key !== 'undefined' && neto_id !== '' && typeof neto_id !== 'undefined') {
			$('#apiDataTable thead tr').not(":eq(0)").each( function (i) {
				$(this).remove();
			} );  
			$("#contentdata").show();
			
			if($('.btnPrimary.active').length==0) {
				$(this).addClass('active');
				$('#btn-two').removeClass('active');
			} 
			apiCallToGetList(1);	
		} else{
			$(".api_credentials_error").html("<div class='alert alert-danger'>Your API Credentials are not saved. Please contact admin!</div>");
		}
            
    });
	
	
	$(document).on('click','#apiDataTable tbody tr', function () {
		// alert('xss');
		$(this).css('color', 'blue');
		sku = $(this).find('td:eq(0)').text();
		epid = $(this).find('td:eq(1)').html();
		brand = $(this).find('td:eq(2)').text();
		name = $(this).find('td:eq(3)').text();
		description = $(this).find('td:eq(4)').text();
		sessionStorage.setItem("sku", sku);
		sessionStorage.setItem("epid", epid);
		sessionStorage.setItem("brand", brand);
		sessionStorage.setItem("name", name);
		sessionStorage.setItem("description", description);
		window.open("compatible_vehicle.php?search="+search,'_self');
		// console.log(search);
		// if(typeof search!=='undefined' && search!='') {
			// window.location.href = SITE_URL+'/compatible_vehicle.php?search='+search;
		// } 
		
	});
	
	$(document).on('click', '#api-call', function (){
		$('.neto-textboxes').hide();
		$('#apitable').hide();
		$('#loader').show(); 
		// $('#buttonsForEpids').hide();
		// $('#helpText').hide();
		apiCallToGetList();	
		// $(".block").hide();					
	});

	$(document).on('click', ".paginate_button", function(){
		$('#apiDataTable tbody tr').find('td:eq(4)').hide();
	});

	$(document).on('click', ".next", function(){
		page++;
		$('#apitable').hide();
		$('.pagination-div').hide();
		apiCallToGetList();
	});
	$(document).on('click', ".prev", function(){
		page--;
		$('#apitable').hide();
		$('.pagination-div').hide();
		apiCallToGetList();
	});

	//function to call the api get the list and put that list into a jquery datatable
	function apiCallToGetList(show_all_list=1){
		$(".api_credentials_error").html("");
		$('#loader').show(); 
		$('#contentdata').removeClass('changeBackground'); 
		$.ajax({
			url: 'api.php',
			method: 'post',
			data:{page:page},
			success: function(result) {
					$('#loader').hide();
					$('#contentdata').addClass('changeBackground'); 
					var data = JSON.parse(result);
					if(data.Ack == "Error"){
						// $('.loader').hide();
						// $("#error").show();
						$("#error").html('<div class="alert alert-warning"><strong>Warning!</strong> Unable to access the data. Please refresh the page</div>');
					}
					var d = data["Item"];
					var api_data = '';
					$.each(d, function(i, item) {
						api_data += '<tr>';
						api_data += '<td>'+d[i].SKU+'</td>';
						if(d[i][neto_id]!=''){
							// api_data += '<td><img src="'+SITE_URL+'img/greenTick.png" class="tick" alt="tick"></td>';
							api_data += '<td><i class="fa fa-check" aria-hidden="true"></i></td>';
						}
						else{
							api_data += '<td></td>';
						}
						api_data += '<td>'+d[i].Brand+'</td>';
						api_data += '<td>'+d[i].Name+'</td>';
						var div = $($.parseHTML(d[i].Description));
						var str = "";
						div.find("font[face=Arial]").each(function(){
						str += $(this).text() + "<br>";
						})
						api_data += '<td>'+str.substr(0,100);+'</td>';
						api_data += '</tr>';
					});	
					
					$('#apitable').html('<table id="apiDataTable" class="table-striped"><thead><tr><th>SKU</th><th>ePIDs</th><th>Brand</th><th>Name</th><th>Description</th></tr></thead><tbody></tbody><tfoot><tr><th>SKU</th><th>ePIDs</th><th>Brand</th><th>Name</th><th>Description</th></tr></tfoot></table>');

					$('#apiDataTable > tbody').html(api_data);

				
					if ( !$.fn.dataTable.isDataTable( '#apiDataTable' ) ) {
						table = $('#apiDataTable').DataTable( {
							dom : 'l<"#add">frtip',
							"paging": false,
							orderCellsTop: true,
							fixedHeader: true,
							pageLength : 10,
							"info":false
						} );
					}

					$('#add').addClass('row');
					// $('.dataTables_length');
					// $('#buttonsForEpids');
					// $('#apiDataTable_filter');
					$('.dataTables_length').clone(true).addClass('col-lg-1').addClass('newClass').removeClass('dataTables_length').appendTo('#add');
					$('#buttonsForEpids').clone(true).addClass('col-lg-8').removeAttr("id").addClass('newClass2 fontSize-small').appendTo('#add');
					$('#apiDataTable_filter').clone(true).addClass('col-lg-3').addClass('newClass3').removeAttr("id").appendTo('#add');
					$('.newClass3>label>.input-group>input').addClass('changeInputWidth');
					
					// $('#add1').addClass('row');   
					
					$('.dataTables_length').hide();
					$('#apiDataTable_filter').hide();
					
					// $('#add').append($('.dataTables_length').html());
					// $('#add').append($('#buttonsForEpids').html());
					// $('#add').append($('#apiDataTable_filter').html());

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
					});

					$('#apiDataTable thead tr:eq(1) th:eq(0)').removeClass('sorting_asc');
					$('#apiDataTable thead tr:eq(1) th:eq(0) input').click(function(){event.stopPropagation();});
					$('#apiDataTable thead tr:eq(1) th:eq(1)').removeClass('sorting');
					$('#apiDataTable thead tr:eq(1) th:eq(1)').text('');
					$('#apiDataTable thead tr:eq(1) th:eq(2)').removeClass('sorting');
					$('#apiDataTable thead tr:eq(1) th:eq(2) input').click(function(){event.stopPropagation();});
					$('#apiDataTable thead tr:eq(1) th:eq(3)').removeClass('sorting');
					$('#apiDataTable thead tr:eq(1) th:eq(3) input').click(function(){event.stopPropagation();});
					$('#apiDataTable thead tr:eq(1) th:eq(4)').removeClass('sorting');
					$('#apiDataTable thead tr:eq(1) th:eq(4)').text('');
					$('#apiDataTable thead tr:eq(1) th:eq(0) input').addClass('searchBorder');
					$('#apiDataTable thead tr:eq(1) th:eq(2) input').addClass('searchBorder');
					$('#apiDataTable thead tr:eq(1) th:eq(3) input').addClass('searchBorder');
					$('#apiDataTable thead tr th:eq(4)').text('');
					$('#apiDataTable tfoot tr th:eq(4)').text('');
					$('#apiDataTable tbody tr').find('td:eq(4)').hide();
					$('#apitable').show();
					$('.pagination-div').show();
					// $('#buttonsForEpids').show();
					// $('#helpText').show();

					var filteredData;
					if(show_all_list==2) {
						filteredData = table.rows().indexes().filter( function ( value, index ) {
							return table.row(value).data()[1] == ''; 
							} );
						table.rows( filteredData )
						.remove()
						.draw();
					}
					if(show_all_list==3) {
						filteredData = table
							.rows()
							.indexes()
							.filter( function ( value, index ) {
							return table.row(value).data()[1] != ''; 
							} );
						table.rows( filteredData )
						.remove()
						.draw();
					}
			},
			error: function() {
				$('.loader').hide();
				// $("#error").show();
				$("#error").html('<div class="alert alert-warning"><strong>Warning!</strong> Unable to access the data. Please refresh the page</div>');
			}
		});
	}
	
	// deletes rows which have empty epid value
	$(document).on('click', '.get_list_from_api', function() {
		var data_show = $(this).attr('data-show');
		if(data_show!== '' && typeof data_show !== 'undefined') {
			$('#apitable').hide();
			$('#apiDataTable thead tr').not(":eq(0)").each( function (i) {
				$(this).remove();	
			} ); 
			if(data_show==1) {
				$("#yestoggle").removeClass("greenColorBtn");
				$("#alltoggle").addClass("blueColorBtn");
				$("#notoggle").removeClass("redColorBtn");
				$('#loader').show();
				apiCallToGetList(1);
			} 
			if(data_show==2) {
				$("#yestoggle").addClass("greenColorBtn");
				$("#alltoggle").removeClass("blueColorBtn");
				$("#notoggle").removeClass("redColorBtn");
				apiCallToGetList(2);
			}
			if(data_show==3) {
				$("#yestoggle").removeClass("greenColorBtn");
				$("#alltoggle").removeClass("blueColorBtn");
				$("#notoggle").addClass("redColorBtn");
				apiCallToGetList(3);
			}
		}
	});
});
