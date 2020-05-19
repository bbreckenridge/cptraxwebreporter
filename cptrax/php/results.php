<html>
	<head>
		<?php
		
		// Variables Handled
		
		$title = $_GET['title'];
		$selectColumns = $_GET['selectedcolumns'];
		$filterColumns = $_GET['filtercolumns'];
		$filterExpressions = $_GET['filterexpressions'];
		$filterValues = $_GET['filtervalues'];
		$table = $_GET['table'];
		$dateArray = explode(" ", $_GET['datefilter']);
		$startDate = ($dateArray[0]." ".$dateArray[1]); 
		$endDate = ($dateArray[3]." ".$dateArray[4]);
		$lastXDays = $_GET['datefilter2'];
		$lastXIncrem = $_GET['dateexpression'];
		
		echo "<title>".$title."</title>"; 
		
		?>
		<link type="text/css" rel="stylesheet" href="../css/datatables.min.css">
		<script type="text/javascript" src="../js/datatables.min.js"></script>
		<script type="text/javascript" src="../js/moment.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="../css/bootstrap-theme.min.css" type="text/css">
		<link rel="stylesheet" href="../css/daterangepicker.css" type="text/css">
		<script type="text/javascript" src="../js/daterangepicker.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../css/mainpage.css" type="text/css">
		<?php require '../js/copyURL.js'; ?>
		<?php require '../js/create.datatables.js'; ?>
	</head>
	<div class="wrapper">
	
		<a href="https://www.visualclick.com" target="_blank">
		<img src="../css/DataTables-1.10.15/images/vcs logo.png" alt="Visual Click Software, Inc" height="5%">
		</a>

		<?php echo "<p style=\"font-size:25px; padding-top: 20px;\"><strong>".$title."</strong></p>"; ?>
	
		<hr/>
		<table id="myTable" class="display cell-border" style="width: 100%">
			<thead>
	<?php
		
		//Create Table Headers
			foreach ($selectColumns as &$col) {
				echo '<th>'.$col."</th>";
				unset($col);
			}
			
	?>
			</thead>
			<tfoot>
			
	<?php
		
		//Create Table Headers
		foreach ($selectColumns as &$col) {
		if ($col != "TimeOccurred") {
				echo '<th class="notdatetime">'.$col."</th>";
				unset($col);
			}
		else {
				echo '<th class="datetime">'.$col."</th>";
				unset($col);
		}	
		}
		
	?>
			
			</tfoot>
			<tbody>
			</tbody>
		</table>
	</div>
</html>