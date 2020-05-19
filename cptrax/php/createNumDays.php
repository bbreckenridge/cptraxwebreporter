<?php

	header("Location: ../../cptrax.php",TRUE,303);

	$numberOfDays = $_GET['numberofdays'];

	$file = fopen("setnumdays.php", "w") or die("Unable to open file!");
	$txt = "<?php \$numOfDays = ".$numberOfDays."; ?>";
	fwrite($file,$txt);
	fclose($file);

?>