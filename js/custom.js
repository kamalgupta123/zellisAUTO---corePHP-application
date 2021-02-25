$(document).ready(function()
{
	$('#example-datatable').DataTable();
	$(".maker").change(function()
		{
		var id=$(this).val();
		var dataString = 'id='+ id+'&action=model';

		$.ajax
			({
			type: "POST",
			url: "get_model.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$(".model").html(html);
			} 
			});

	});
	$(".model").on('change', function()
		{
		var id=$(this).val();
		var dataString = 'id='+ id+'&action=sub_model';

		$.ajax
			({
			type: "POST",
			url: "get_model.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$(".sub_model").html(html);
			} 
			});

	});
	
	
    jQuery('#if_install').change(function(){
        initdatepicker();
        if(jQuery('#if_install').is(':checked')){
            jQuery('.ins_outer, .ins_outer_edt').show();
            jQuery('.ins_price, .ins_invoice_date').attr('required', true);
		    sgtech_set_installment_prices();
        }else{
            jQuery('.ins_outer, .ins_outer_edt').hide();
            jQuery('.ins_price, .ins_invoice_date').attr('required', false);
        }
    });
    
	function initdatepicker(){
        $( ".ins_invoice_date, .ins_inv_date, .paid_date" ).datepicker({
            dateFormat: 'dd-mm-yy'
        });
	}
});


