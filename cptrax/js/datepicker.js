<script type="text/javascript">
	$(function() {

		$('input[name="datefilter"]').daterangepicker({
			"timePicker": true,
			"timePicker24Hour": true,
			"locale":{ "format": "YYYY-MM-DD HH:mm" },
			"showDropdowns": true,
			"ranges": {
				'Today': [moment().hours(0).minutes(0).seconds(0), moment().hours(23).minutes(59).seconds(59)],
				'Last 7 Days': [moment().hours(0).minutes(0).seconds(0).subtract(6, 'days'), moment().hours(23).minutes(59).seconds(59)], 
				'Last 30 Days': [moment().hours(0).minutes(0).seconds(0).subtract(29, 'days'), moment().hours(23).minutes(59).seconds(59)], 
				'Last 60 Days': [moment().hours(0).minutes(0).seconds(0).subtract(59, 'days'), moment().hours(23).minutes(59).seconds(59)], 
				'Last 90 Days': [moment().hours(0).minutes(0).seconds(0).subtract(89, 'days'), moment().hours(23).minutes(59).seconds(59)], 
				'This Month': [moment().hours(0).minutes(0).seconds(0).startOf('month'), moment().endOf('month')], 
				'Last Month': [moment().hours(0).minutes(0).seconds(0).subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
				'All': [moment().hours(0).minutes(0).seconds(0).subtract(15, 'years'), moment().hours(23).minutes(59).seconds(59)]
			},
		},
		function(start, end, label) {
			console.log("New date range selected: ' + start.format('YYYY-MM-DD HH:mm') + ' to ' + end.format('YYYY-MM-DD HH:mm') + ' (predefined range: ' + label + ')");
		});

	});
</script>