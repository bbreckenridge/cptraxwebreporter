<?php

	header("Location: ../../../cptrax.php",TRUE,303);
	
	$dateArray = explode(" ", $_GET['datefilter']);
	$startDate = ($dateArray[0]." ".$dateArray[1]); 
	$endDate = ($dateArray[3]." ".$dateArray[4]);
	
	
	$phpBegin = '<?php';
	$phpEnd = '?>';
	
	function add_quotes($str) {
		return sprintf("'%s'", $str);
	}

	$file = fopen("savedqueries/".$_GET['title'].".php", "w") or die("Unable to open file!");
	fwrite($file,$phpBegin);
	fwrite($file,PHP_EOL);
	fwrite($file,'if ($savedReportName == "'.$_GET['title'].'") {');
	fwrite($file,PHP_EOL);
	fwrite($file,'$title = "'.$_GET['title'].'";');
	fwrite($file,PHP_EOL);
	fwrite($file,'$selectColumns = array('.implode(',', $_GET['selectedcolumns']).');');
	fwrite($file,PHP_EOL);
	fwrite($file,'$filterColumns = array('.implode(',', $_GET['filtercolumns']).');');
	fwrite($file,PHP_EOL);
	fwrite($file,'$filterExpressions = array('.implode(',', $_GET['filterexpressions']).');');
	fwrite($file,PHP_EOL);
	fwrite($file,'$filterValues = array('.implode(',', array_map('add_quotes', $_GET['filtervalues'])).');');
	fwrite($file,PHP_EOL);
	fwrite($file,'$table = "'.$_GET['table'].'";');
	fwrite($file,PHP_EOL);
	fwrite($file,'$startDate = "'.$startDate.'";');
	fwrite($file,PHP_EOL);
	fwrite($file,'$endDate = "'.$endDate.'";');
	fwrite($file,PHP_EOL);
	fwrite($file,'$lastXDays = "'.$_GET['datefilter2'].'";');
	fwrite($file,PHP_EOL);
	fwrite($file,'$lastXIncrem = "'.$_GET['dateexpression'].'";');
	fwrite($file,PHP_EOL);
	fwrite($file,'}');
	fwrite($file,PHP_EOL);
	fwrite($file,$phpEnd);
	fclose($file);
	
	$myDir = './savedqueries'; 
	$myFiles = scandir($myDir,0); 
	array_shift($myFiles); 
	array_shift($myFiles);
	
	$includeFile = fopen('savedincludes.php', 'w');
	fwrite($includeFile,$phpBegin);
	fwrite($includeFile,PHP_EOL);
	foreach ($myFiles as $file) { 
		
		$newInclude = 'include \'./savedqueries/'.$file.'\';';
		fwrite($includeFile,$newInclude);
		fwrite($includeFile,PHP_EOL);
			
	}
	fwrite($includeFile,PHP_EOL);
	fwrite($includeFile,$phpEnd);
	fclose($includeFile);
	
	?>