<?php

	$savedReportName = $_GET['savedreportname'];
			
	include 'savedincludes.php';

	// output headers so that the file is downloaded rather than displayed
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$title.'.csv');

	require 'sqlconnect.php';
	
	if (substr($lastXIncrem, -1) == 's') {
		
		$lastXIncrem = substr($lastXIncrem, 0, -1);
		
	}
	
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
			$where = "WHERE (TimeOccurred >= DATEADD(".$lastXIncrem.",-".$lastXDays.",GETDATE()) AND TimeOccurred <= DATEADD(day,-0,GETDATE()))";
		}
		else {
			$where .= " AND (TimeOccurred >= DATEADD(".$lastXIncrem.",-".$lastXDays.",GETDATE()) AND TimeOccurred <= DATEADD(day,-0,GETDATE()))";
		}
	
	}
	
	/* Canned Reports Switch Statement */

	require 'cannedreports.php';
	
	$sqlQuery = "SELECT ".implode(', ', $selectColumns)." FROM $table $where";
	$sqlResult = sqlsrv_query($conn, $sqlQuery);
	if($sqlResult === false){
		die(sqlsrv_errors(SQLSRV_ERR_ERRORS));
	}
	
	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	
	// loop over the rows, outputting them
	
	fputcsv($output, $selectColumns);
	
	while ($row = sqlsrv_fetch_array($sqlResult, SQLSRV_FETCH_ASSOC)) {
		
		fputcsv($output, array_values($row));
		
	}
	
	fclose($output);

?>