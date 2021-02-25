/*
 *  Document   : tablesDatatables.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Tables Datatables page
 */

var TablesDatatables = function() {

    return {
        init: function() {
            /* Initialize Bootstrap Datatables Integration */
            App.datatables();

            /* Initialize Datatables */
            $('#example-datatable').dataTable({
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 1, 5 ] } ],
                "iDisplayLength": 100,
                "aLengthMenu": [[100, 200, 400, -1], [100, 200, 400, "All"]]
            });
			
			 $('#example-datatable1').dataTable({
				"aoColumnDefs": [
					  { 'bSortable': false, 'aTargets': [ 0 ] }
				   ],
                "iDisplayLength": 100,
                "aLengthMenu": [[100, 200, 400, -1], [100, 50, 400, "All"]]
            });
			
		$('#example-datatable2').dataTable({
                "iDisplayLength": 100,
                "aLengthMenu": [[100, 200, 400, -1], [100, 200, 400, "All"]]
            });
			
		$('#datatable1').dataTable({
                "aoColumnDefs": [ { "bSortable": true, "aTargets": [ 1, 5 ] } ],
                "iDisplayLength": 100,
                "aLengthMenu": [[100, 200, 400, -1], [100, 200, 400, "All"]]
            });

		$('#my_datatable').dataTable({
                "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0 ] }  ],
                "iDisplayLength": 100,
                "aLengthMenu": [[100, 200, 400, -1], [100, 200, 400, "All"]]
            });
			$('#my_datatableclients').dataTable({
                "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0 ] }  ],
                "iDisplayLength": 100,
                "aLengthMenu": [[100, 200, 400, -1], [100, 200, 400, "All"]]
            });
			$('#my_datatableprojects').dataTable({
                "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0 ] }  ],
                "iDisplayLength": 100,
                "aLengthMenu": [[100, 200, 400, -1], [100, 200, 400, "All"]]
            });
            $('#my_datatabletaskview').dataTable({
                "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0 ] }  ],
                "iDisplayLength": 100,
                "aLengthMenu": [[100, 200, 400, -1], [100, 200, 400, "All"]]
            });
			$('#my_datatableinvoices').dataTable({
                "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0 ] }  ],
                "iDisplayLength": 100,
                "aLengthMenu": [[100, 200, 400, -1], [100, 200, 400, "All"]]
            });
            $('#my_datatablecontacts').dataTable({
                "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0 ] }  ],
                "iDisplayLength": 100,
                "aLengthMenu": [[100, 200, 400, -1], [100, 200, 400, "All"]]
            });
            $('#my_datatablecontactsview').dataTable({
                "aaSorting": [],
                "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0 ] }  ],
                "iDisplayLength": 100,
                "aLengthMenu": [[100, 200, 400, -1], [100, 200, 400, "All"]]
            });
            
            
			

            /* Add Bootstrap classes to select and input elements added by datatables above the table */
            $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
            $('.dataTables_length select').addClass('form-control');
        }
    };
}();