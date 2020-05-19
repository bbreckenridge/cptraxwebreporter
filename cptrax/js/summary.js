<script type="text/javascript">

	$(document).ready(function() {

	  $('tr.header').click(function() {
		$(this).find('span').text(function(_, value) {

		});
		
		$(this).nextUntil('tr.header').slideToggle(100, function() {});
	  });
	});

</script>