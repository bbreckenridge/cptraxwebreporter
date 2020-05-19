<?php

	require 'sqlconnect.php';
	
	// Get Canned Report Name
	
	if (isset($_GET['adreportname'])) { $cannedFilter = $_GET['adreportname']; }
	if (isset($_GET['fsreportname'])) { $cannedFilter = $_GET['fsreportname']; }
	if (isset($_GET['authreportname'])) { $cannedFilter = $_GET['authreportname']; }
	if (isset($_GET['gpoadreportname'])) { $cannedFilter = $_GET['gpoadreportname']; }
	if (isset($_GET['gpofsreportname'])) { $cannedFilter = $_GET['gpofsreportname']; }
	if (isset($_GET['title'])) { $pdfTitle = $_GET['title']; }
	
	// Get Table from Form
	
	$table = $_GET['table'];
	
	// Bringing in User Selected Columns
	$columns = $_GET['selectedcolumns'];
	
	// Declare Where statement variable
	
	$where = "";
	
	// Prepare Date/Time from user
		
	if (isset($_GET['datefilter'])) { 
	
		$dateArray = explode(" ", $_GET['datefilter']);
		$startDate = ($dateArray[0]." ".$dateArray[1]); 
		$endDate = ($dateArray[3]." ".$dateArray[4]);
		
	}
	
	if (isset($_GET['dateexpression'])) { 
		
		$dateExpression = $_GET['dateexpression'];
		
		if (substr($dateExpression, -1) == 's') {
		
			$dateExpression = substr($dateExpression, 0, -1);
		
		}
		
	}
	
	if (isset($_GET['datefilter2'])) { $dateLastX = $_GET['datefilter2']; }
	
	// Custom Query Custom Column Filters

	if (isset($_GET['filtercolumns'])) { $filterColumns = $_GET['filtercolumns']; }
	
	if (isset($_GET['filterexpressions'])) { $filterExpressions = $_GET['filterexpressions']; }
	
	if (isset($_GET['filterexpressions'])) { 
	
		$filterValues = $_GET['filtervalues'];
	
		// Add the custom query custom column filters

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
	
	$sqlQuery = "SELECT TOP 30000 ".implode(', ', $columns)." FROM $table $where";
	$sqlResult = sqlsrv_query($conn, $sqlQuery);
	if($sqlResult === false){
		die(sqlsrv_errors(SQLSRV_ERR_ERRORS));
	}
	
	require('fpdf.php');
	
	class PDF extends FPDF {
		
		// Apply VCS Logo , Title, and Columns Names to all Headers
		function Header() {
			
				$headerColumns = $_GET['selectedcolumns'];
				if (isset($_GET['title'])) { $title = $_GET['title']; }
		
				// Colors, line width and bold font
				$this->Image('../css/DataTables-1.10.15/images/VCS Logo.png',10,6,50,0);
				$this->SetFillColor(39,77,165);
				$this->SetTextColor(0);
				$this->SetDrawColor(0);
				$this->SetFont('Arial','B',20);
				$this->Cell(0,10,$title,0,0,'C');
				$this->Ln();
				$this->Ln();
				$this->SetFont('Arial','B',10);
				$this->SetTextColor(255);
				
				// Header
				for($i=0;$i<count($headerColumns);$i++)
					
					$this->Cell(45,8,$headerColumns[$i],1,0,'J',true,true);
					$this->Ln();
				
		}
		
		// Apply Page Number to all Footers
		function Footer() {
		
			$this->SetY(-15);
			$this->SetFont('Arial','I','8');
			//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		
		}
		
		function sqlTable($columns, $sqlResult) {
			
			$width = 45;
		
			//$this->Header($columns,$width);
			
			while ($row = sqlsrv_fetch_array($sqlResult, SQLSRV_FETCH_ASSOC)) {
				
				for ( $x=0 ; $x<count($columns) ; $x++ ) {
					
					// Declare Variables
					$fontSize = 8;
					
					// Color and font restoration
					$this->SetFillColor(224,235,255);
					$this->SetTextColor(0);
					$this->SetFont('');
					$this->SetFont('Arial','',$fontSize);
					
					// Adjust font size to fit cell width
					while ($this->GetStringWidth($row[$columns[$x]]) > $width) {
					
						$fontSize--;
						$this->SetFont('Arial','',$fontSize);
					
					}
					
					// Fill with data
					$this->Cell($width,10,$row[$columns[$x]],1);
					$pageHeight = $pageHeight - 10;
				
				}
					
				$this->Ln();
			
			}
			
		}
	
	}
	
	$pageSizeH = (count($columns) * 45)+20;
	$pageSizeW = $pageSizeH * .6666666666;
	$pageArray = array($pageSizeH,$pageSizeW);
	
	if ($pageSizeH < 420) {
		
		$pdf = new PDF('L','mm','A3');
		
	}
	
	else {
		
		$pdf = new PDF('L','mm',$pageArray);
		
	}
	
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->sqlTable($columns, $sqlResult);
	$pdf->Output('D', $pdfTitle.'.pdf');

?>