<?php

	require 'sqlserver.php';
	
	$database = array("Database" => "CPTRAX_For_Windows", "ReturnDatesAsStrings" => true);
	$conn = sqlsrv_connect($server, $database); 
	if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));

?>