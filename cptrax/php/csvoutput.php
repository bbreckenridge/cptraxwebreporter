<?php

	// Get Title from Form
	
	$title = $_GET['title'];

	// output headers so that the file is downloaded rather than displayed
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$title.'.csv');

	require 'sqlconnect.php';
	
	// Get Canned Report Name
	
	if (isset($_GET['adreportname'])) { $cannedFilter = $_GET['adreportname']; }
	if (isset($_GET['fsreportname'])) { $cannedFilter = $_GET['fsreportname']; }
	if (isset($_GET['authreportname'])) { $cannedFilter = $_GET['authreportname']; }
	if (isset($_GET['gpoadreportname'])) { $cannedFilter = $_GET['gpoadreportname']; }
	if (isset($_GET['gpofsreportname'])) { $cannedFilter = $_GET['gpofsreportname']; }
	
	// Get Table from Form
	
	$table = $_GET['table'];
	
	// Bringing in User Selected Columns
	$columns = $_GET['selectedcolumns'];
	
	// Prepare Date/Time from user
		
	$dateArray = explode(" ", $_GET['datefilter']);
	$startDate = ($dateArray[0]." ".$dateArray[1]); 
	$endDate = ($dateArray[3]." ".$dateArray[4]);
	
	$dateExpression = $_GET['dateexpression'];
	$dateLastX = $_GET['datefilter2'];
	
	if (substr($dateExpression, -1) == 's') {
		
		$dateExpression = substr($dateExpression, 0, -1);
		
	}
	
	// Custom Query Custom Column Filters

	$filterColumns = $_GET['filtercolumns'];
	
	$filterExpressions = $_GET['filterexpressions'];
	
	$filterValues = $_GET['filtervalues'];
	
	// Add the custom query custom column filters

	if ( isset($filterColumns[0]) ) {
		
		for ( $x=0 ; $x<count($filterColumns) ; $x++ ) {
			if ( $where == "" ) {
				
				$where = "WHERE ";
				$where .= $filterColumns[$x]." ".$filterExpressions[$x]." '%".$filterValues[$x]."%'";
				
			}
			elseif ((strpos($where, $filterColumns[$x]) == true) && (strpos($filterExpressions[$x], 'not') == false)) {
				$where .= " OR ";
				$where .= $filterColumns[$x]." ".$filterExpressions[$x]." '%".$filterValues[$x]."%'";
			}
			else {
				$where = substr($where, 6);
				$where = "WHERE "."(".$where.")";
				$where .= " AND ";
				$where .= $filterColumns[$x]." ".$filterExpressions[$x]." '%".$filterValues[$x]."%'";
			}
			
			
		}
		
		
	}
	
	// Add the custom Date/Time filter
	
	if (strpos($startDate, ":") == true) {
		
		if ( $where == "" ) {
			$where = "WHERE (TimeOccurred >= "."'".$startDate."'"." AND TimeOccurred <= "."'".$endDate."')";
		}
		else {
			$where .= " AND (TimeOccurred >= "."'".$startDate."'"." AND TimeOccurred <= "."'".$endDate."')";
		}
		
	}
	else {
	
		if ( $where == "" ) {
			$where = "WHERE (TimeOccurred >= DATEADD(".$dateExpression.",-".$dateLastX.",GETDATE()) AND TimeOccurred <= DATEADD(day,-0,GETDATE()))";
		}
		else {
			$where .= " AND (TimeOccurred >= DATEADD(".$dateExpression.",-".$dateLastX.",GETDATE()) AND TimeOccurred <= DATEADD(day,-0,GETDATE()))";
		}
	
	}
	
	/* Canned Reports Switch Statement */

	require 'cannedreports.php';
	
	$sqlQuery = "SELECT ".implode(', ', $columns)." FROM $table $where";
	$sqlResult = sqlsrv_query($conn, $sqlQuery);
	if($sqlResult === false){
		die(sqlsrv_errors(SQLSRV_ERR_ERRORS));
	}
	
	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	
	// loop over the rows, outputting them
	
	fputcsv($output, $columns);
	
	while ($row = sqlsrv_fetch_array($sqlResult, SQLSRV_FETCH_ASSOC)) {
		
		fputcsv($output, array_values($row));
		
	}
	
	fclose($output);

?>