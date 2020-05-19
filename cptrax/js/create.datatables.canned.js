	<script type="text/javascript">
		$(document).ready(function() {
				  
			$('#myTable tfoot th.notdatetime').each( function () {
				var title = $(this).text();
				$(this).html( '<input class="form-control" type="text" placeholder="Search '+title+'" />' );
			} );
			
			$('#myTable tfoot th.datetime').each( function () {
				var title = $(this).text();
				$(this).html( '<input class="form-control" id="daterange" type="text" name="datefilterresults" value="" style="cursor: pointer;" readonly>' );
			} );
			
			$('#myTable tfoot th.logontime').each( function () {
				var title = $(this).text();
				$(this).html( '<input class="form-control" id="logondaterange" type="text" name="logondatefilterresults" value="" style="cursor: pointer;" readonly>' );
			} );
			
			$('#myTable tfoot th.logofftime').each( function () {
				var title = $(this).text();
				$(this).html( '<input class="form-control" id="logoffdaterange" type="text" name="logoffdatefilterresults" value="" style="cursor: pointer;" readonly>' );
			} );
			
			var table = $('#myTable').DataTable( {
				dom: 'Brti',
				buttons: [
					{	
						extend: 'colvis',
						text: 'Show/Hide Columns'
					},
					{	
						extend: 'collection',
						text: 'Share',
						buttons: [
							{
								text: 'Get Link',
								action: function ( e, dt, node, config ) {
									CopyLink();
								}
							},
							{
								text: 'CSV',
								action: function ( e, dt, node, config ) {
									$.ajax({
										"url": "../php/csvqueryresults.php",
										"type": "POST",
										"data": table.ajax.params(),
										"success": function(res, status, xhr) {
											var csvData = new Blob([res], {type: 'text/csv;charset=utf-8;'});
											var csvURL = window.URL.createObjectURL(csvData);
											var tempLink = document.createElement('a');
											tempLink.href = csvURL;
											tempLink.setAttribute('download', '<?php echo $title.".csv"; ?>');
											tempLink.click();
											}
									});
								}
							}
						]
					}
				],
				deferRender: true,
				select: true,
				colReorder: true,
				scroller: { loadingIndicator: true },
				scrollX: true,
				scrollY: 650,
				processing: true,
				serverSide: true,
				ajax: {
					url: '../php/cannedqueryresults.php',
					type: 'POST',
					data: 
					{ 
						table: '<?php echo $table; ?>',
						datestart: '<?php echo $startDate; ?>',
						dateend: '<?php echo $endDate; ?>',
						datestart2: moment().subtract('<?php echo $lastXDays; ?>', '<?php echo $lastXIncrem; ?>').format('YYYY-MM-DD HH:mm'),
						dateend2: moment().format('YYYY-MM-DD HH:mm'),
						selcolumns: '<?php foreach ($selectColumns as $col) { $selColumns .= $col.","; } echo addslashes($selColumns); ?>',
						cannedfilter: '<?php echo $cannedFilter; ?>'
					},
				},
				<?php
				echo "columns: [";
				foreach ($selectColumns as $col) {
					//if ($col == "TimeOccurred") {
					//	$col = "TimeOccurred.date.";
					//}
					if ($col == "LogonTime") {
						$col = "LogonTime.date.";
					}
					if ($col == "LogoffTime") {
						$col = "LogoffTime.date.";
					}
					echo '{ "data": "'.$col.'" },';
					unset($col);
				}
				echo "]";
				?>
			} );
			
			$('input[name="datefilterresults"]').daterangepicker({
				"drops": "up",
				"timePicker": true,
				"timePicker24Hour": true,
				"locale":{ "format": "YYYY-MM-DD HH:mm" , "cancelLabel": 'Clear' },
				"showDropdowns": true,
				"ranges": {
					'Today': [moment().hours(0).minutes(0).seconds(0), moment().hours(23).minutes(59).seconds(59)],
					'Last 7 Days': [moment().hours(0).minutes(0).seconds(0).subtract(6, 'days'), moment()], 
					'Last 30 Days': [moment().hours(0).minutes(0).seconds(0).subtract(29, 'days'), moment()], 
					'Last 60 Days': [moment().hours(0).minutes(0).seconds(0).subtract(59, 'days'), moment()], 
					'Last 90 Days': [moment().hours(0).minutes(0).seconds(0).subtract(89, 'days'), moment()], 
					'This Month': [moment().hours(0).minutes(0).seconds(0).startOf('month'), moment().endOf('month')], 
					'Last Month': [moment().hours(0).minutes(0).seconds(0).subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
					'All': [moment().hours(0).minutes(0).seconds(0).subtract(15, 'years'), moment()]
				},
			});
			  
			$('input[name="datefilterresults"]').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('YYYY-MM-DD HH:mm') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm'));
			});

			$('input[name="datefilterresults"]').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val('');
				$(this).change();
				$(this).val('Search TimeOccurred');
			});
			
			$('input[name="datefilterresults"]').val('Search TimeOccurred');
			
			$('input[name="logondatefilterresults"]').daterangepicker({
				"drops": "up",
				"timePicker": true,
				"timePicker24Hour": true,
				"locale":{ "format": "YYYY-MM-DD HH:mm" , "cancelLabel": 'Clear' },
				"showDropdowns": true,
				"ranges": {
					'Today': [moment().hours(0).minutes(0).seconds(0), moment().hours(23).minutes(59).seconds(59)],
					'Last 7 Days': [moment().hours(0).minutes(0).seconds(0).subtract(6, 'days'), moment()], 
					'Last 30 Days': [moment().hours(0).minutes(0).seconds(0).subtract(29, 'days'), moment()], 
					'Last 60 Days': [moment().hours(0).minutes(0).seconds(0).subtract(59, 'days'), moment()], 
					'Last 90 Days': [moment().hours(0).minutes(0).seconds(0).subtract(89, 'days'), moment()], 
					'This Month': [moment().hours(0).minutes(0).seconds(0).startOf('month'), moment().endOf('month')], 
					'Last Month': [moment().hours(0).minutes(0).seconds(0).subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
					'All': [moment().hours(0).minutes(0).seconds(0).subtract(15, 'years'), moment()]
				},
			});
			  
			$('input[name="logondatefilterresults"]').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('YYYY-MM-DD HH:mm') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm'));
			});

			$('input[name="logondatefilterresults"]').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val('');
				$(this).change();
				$(this).val('Search TimeOccurred');
			});
			
			$('input[name="logondatefilterresults"]').val('Search LogonTime');
			
			
			$('input[name="logoffdatefilterresults"]').daterangepicker({
				"drops": "up",
				"timePicker": true,
				"timePicker24Hour": true,
				"locale":{ "format": "YYYY-MM-DD HH:mm" , "cancelLabel": 'Clear' },
				"showDropdowns": true,
				"ranges": {
					'Today': [moment().hours(0).minutes(0).seconds(0), moment().hours(23).minutes(59).seconds(59)],
					'Last 7 Days': [moment().hours(0).minutes(0).seconds(0).subtract(6, 'days'), moment()], 
					'Last 30 Days': [moment().hours(0).minutes(0).seconds(0).subtract(29, 'days'), moment()], 
					'Last 60 Days': [moment().hours(0).minutes(0).seconds(0).subtract(59, 'days'), moment()], 
					'Last 90 Days': [moment().hours(0).minutes(0).seconds(0).subtract(89, 'days'), moment()], 
					'This Month': [moment().hours(0).minutes(0).seconds(0).startOf('month'), moment().endOf('month')], 
					'Last Month': [moment().hours(0).minutes(0).seconds(0).subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
					'All': [moment().hours(0).minutes(0).seconds(0).subtract(15, 'years'), moment()]
				},
			});
			  
			$('input[name="logoffdatefilterresults"]').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('YYYY-MM-DD HH:mm') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm'));
			});

			$('input[name="logoffdatefilterresults"]').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val('');
				$(this).change();
				$(this).val('Search TimeOccurred');
			});
			
			$('input[name="logoffdatefilterresults"]').val('Search LogoffTime');
			
			table.columns().every( function () {
				var that = this;
		 
				$( 'input', this.footer() ).on( 'keyup change', function () {
					if ( that.search() !== this.value ) {
						that
							.search( this.value )
							.draw();
					}
				} );
			} );
				  
		} );
	</script>