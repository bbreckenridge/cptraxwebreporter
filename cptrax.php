<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Visual Click Web Reporter</title>
		<link rel="stylesheet" href="../cptrax/css/bootstrap.min.css">
		<link rel="stylesheet" href="../cptrax/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="../cptrax/css/daterangepicker.css"/>
		<link rel="stylesheet" href="../cptrax/css/mainpage.css" type="text/css">
		<?php require '/cptrax/php/chartbuilder.php'; ?>
	</head>
	<body>
		<div class="wrapper">
			<a href="https://www.visualclick.com" target="_blank">
			<img src="../cptrax/css/DataTables-1.10.15/images/vcs logo.png" alt="Visual Click Software, Inc" height="5%">
			</a>
			<ul class="nav nav-tabs addpaddingtop">
				<li class="active"><a data-toggle="tab" href="#dashboard">Dashboard</a></li>
				<li><a data-toggle="tab" href="#reports">Reports</a></li>
				<li><a data-toggle="tab" href="#customquery">Custom Query</a></li>
				<li><a data-toggle="tab" href="#savedqueries">Saved Queries</a></li>
			</ul>
			<div class="tab-content">
				<div id="dashboard" class="tab-pane fade in active col-sm-12">
					<div class="col-sm-1 addpaddingtop">
						<nav class="nav flex-column">
							<?php if ($sumADRowCountResults[0][0] > 0) { echo "<a class=\"nav-link ".$setADChartActive."\" data-toggle=\"tab\" href=\"#chartsad\">Active Directory Graphs</a><br><br>"; } ?>
							<?php if ($sumFSRowCountResults[0][0] > 0) { echo "<a class=\"nav-link ".$setFSChartActive."\" data-toggle=\"tab\" href=\"#chartsfs\">File System Graphs</a><br><br>"; } ?>
							<?php if ($sumLLRowCountResults[0][0] > 0) { echo "<a class=\"nav-link ".$setLLChartActive."\" data-toggle=\"tab\" href=\"#chartsauth\">Authentication Graphs</a><br><br>"; } ?>
							<?php if ($sumGPOADRowCountResults[0][0] > 0) { echo "<a class=\"nav-link ".$setGPOADChartActive."\" data-toggle=\"tab\" href=\"#chartsgpo\">Group Policy Graphs</a><br><br>"; } ?>
							<a class="nav-link" data-toggle="tab" href="#summaryreport">Summary</a><br><br>
							<a class="nav-link" data-toggle="tab" href="#settings">Dashboard Settings</a><br><br>
						</nav>
					</div>
					<div class="tab-content">
						<div id="chartsad" class="form-group row marginleft tab-pane fade in <?php echo $setADChartActive; ?>" <?php echo $setADSumDisplay; ?>>
							<div class="addpaddingleft addpaddingtop chartsize col-sm-2">
								<canvas id="ad-line"></canvas>
							</div>
							<div class="addpaddingleft addpaddingtop chartsize col-sm-2">
								<canvas id="ad-bar-1"></canvas>
							</div>
							<div class="addpaddingleft addpaddingtop chartsize col-sm-2">
								<canvas id="ad-bar-2"></canvas>
							</div>
							<div class="addpaddingleft addpaddingbottom piesize col-sm-2">
								<canvas id="ad-pie"></canvas>
							</div>
						</div>
						<div id="chartsfs" class="form-group row marginleft tab-pane fade in <?php echo $setFSChartActive; ?>" <?php echo $setFSSumDisplay; ?>>
							<div class="addpaddingleft addpaddingtop chartsize col-sm-1">
								<canvas id="fs-line"></canvas>
							</div>
							<div class="addpaddingleft addpaddingtop chartsize col-sm-1">
								<canvas id="fs-bar-1"></canvas>
							</div>
							<div class="addpaddingleft addpaddingtop chartsize col-sm-1">
								<canvas id="fs-bar-2"></canvas>
							</div>
							<div class="addpaddingleft addpaddingbottom piesize col-sm-1">
								<canvas id="fs-pie"></canvas>
							</div>
						</div>
						<div id="chartsauth" class="form-group row marginleft tab-pane fade in <?php echo $setLLChartActive; ?>" <?php echo $setLLSumDisplay; ?>>
							<div class="addpaddingleft addpaddingtop chartsize col-sm-1">
								<canvas id="ll-line"></canvas>
							</div>
							<div class="addpaddingleft addpaddingtop chartsize col-sm-1">
								<canvas id="ll-bar-1"></canvas>
							</div>
							<div class="addpaddingleft addpaddingtop chartsize col-sm-1">
								<canvas id="ll-bar-2"></canvas>
							</div>
							<div class="addpaddingleft addpaddingbottom piesize col-sm-1">
								<canvas id="ll-pie"></canvas>
							</div>
						</div>
						<div id="chartsgpo" class="form-group row marginleft tab-pane fade in <?php echo $setGPOADChartActive; ?> <?php echo $setGPOADSumDisplay; ?>">
							<div class="addpaddingleft addpaddingtop chartsize col-sm-1">
								<canvas id="gpo-line"></canvas>
							</div>
							<div class="addpaddingleft addpaddingtop chartsize col-sm-1">
								<canvas id="gpo-bar-1"></canvas>
							</div>
							<div class="addpaddingleft addpaddingtop chartsize col-sm-1">
								<canvas id="gpo-bar-2"></canvas>
							</div>
							<div class="addpaddingleft addpaddingbottom piesize col-sm-1">
								<canvas id="gpo-pie"></canvas>
							</div>
						</div>
						<div id="summaryreport" class="container marginleft addpaddingtop tab-pane fade">
							<table class="table table-hover table-striped table-sm" <?php echo $setLLSumDisplay; ?>>
								<tr class="header">
									<th class="sumtableheader" colspan="4">User Logon Summary Last <?php echo $numOfDays ?> Days <span></span></th>
								</tr>	
								<tr>
									<th class="thead-default" colspan="1">Logon Activity</th>
									<th class="thead-default" colspan="1">Top 5 Logon Failures</th>
									<th class="thead-default" colspan="1">Top 5 Authenticators</th>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Failed+Authentication+Activity+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=failed&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer">Failures: <?php echo $sumQueryTotalFailsResults[0][0] ?></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=<?php echo $llHBarQueryResults[0][0] ?>+Logon+Failures+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=fail&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=<?php echo $llHBarQueryResults[0][0] ?>&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer"><?php echo $llHBarQueryResults[0][0] ?> (<?php echo $llHBarQueryResults[0][1] ?>)</a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=<?php echo $barAuthsResults[0][0] ?>+Successful+Authentications+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=logon+%28&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=<?php echo $barAuthsResults[0][0] ?>&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer"><?php echo $barAuthsResults[0][0] ?> (<?php echo $barAuthsResults[0][1] ?>)</a></td>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Successful+Authentication+Activity+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=logon+%28&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer">Success: <?php echo $sumQueryTotalSuccResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=<?php echo $llHBarQueryResults[1][0] ?>+Logon+Failures+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=fail&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=<?php echo $llHBarQueryResults[1][0] ?>&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer"><?php echo $llHBarQueryResults[1][0] ?> (<?php echo $llHBarQueryResults[1][1] ?>)</a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=<?php echo $barAuthsResults[1][0] ?>+Successful+Authentications+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=logon+%28&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=<?php echo $barAuthsResults[1][0] ?>&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer"><?php echo $barAuthsResults[1][0] ?> (<?php echo $barAuthsResults[1][1] ?>)</a></td>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Workstation+Locks+%26+Unlocks+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=lock&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer">Locks & Unlocks: <?php echo $sumQueryTotalLocksResults[0][0] ?></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=<?php echo $llHBarQueryResults[2][0] ?>+Logon+Failures+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=fail&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=<?php echo $llHBarQueryResults[2][0] ?>&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer"><?php echo $llHBarQueryResults[2][0] ?> (<?php echo $llHBarQueryResults[2][1] ?>)</a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=<?php echo $barAuthsResults[2][0] ?>+Successful+Authentications+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=logon+%28&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=<?php echo $barAuthsResults[2][0] ?>&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer"><?php echo $barAuthsResults[2][0] ?> (<?php echo $barAuthsResults[2][1] ?>)</a></td>
								</tr>
								<tr>
									<td></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=<?php echo $llHBarQueryResults[3][0] ?>+Logon+Failures+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=fail&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=<?php echo $llHBarQueryResults[3][0] ?>&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer"><?php echo $llHBarQueryResults[3][0] ?> (<?php echo $llHBarQueryResults[3][1] ?>)</a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=<?php echo $barAuthsResults[3][0] ?>+Successful+Authentications+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=logon+%28&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=<?php echo $barAuthsResults[3][0] ?>&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer"><?php echo $barAuthsResults[3][0] ?> (<?php echo $barAuthsResults[3][1] ?>)</a></td>
								</tr>
								<tr>
									<td></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=<?php echo $llHBarQueryResults[4][0] ?>+Logon+Failures+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=fail&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=<?php echo $llHBarQueryResults[4][0] ?>&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer"><?php echo $llHBarQueryResults[4][0] ?> (<?php echo $llHBarQueryResults[4][1] ?>)</a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=<?php echo $barAuthsResults[4][0] ?>+Successful+Authentications+Last+<?php echo $numOfDays ?>+Days&table=Logon_Logoff_and_Failed_Logon_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=logon+%28&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=<?php echo $barAuthsResults[4][0] ?>&filtercolumns%5B%5D=UserName&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=%24&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=FailCodeText&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=FromServer"><?php echo $barAuthsResults[4][0] ?> (<?php echo $barAuthsResults[4][1] ?>)</a></td>
								</tr>
							</table>
							<table class="table table-hover table-striped table-sm" <?php echo $setFSSumDisplay; ?>>
								<tr class="header">
									<th class="sumtableheader" colspan="3">File System Summary Last <?php echo $numOfDays ?> Days<span></span></th>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=File+and+Folder+Creations+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&fsreportname=Created+Files+and+Folders&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ShareName&selectedcolumns%5B%5D=FullFilePath&selectedcolumns%5B%5D=FileNameOnly&selectedcolumns%5B%5D=NewPathName&selectedcolumns%5B%5D=FromServer&table=File_System_Profiles">File/Folder Creation: <?php echo $pieCreatesResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=File+and+Folder+Deletions+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&fsreportname=Deleted+Files+and+Folders&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ShareName&selectedcolumns%5B%5D=FullFilePath&selectedcolumns%5B%5D=FileNameOnly&selectedcolumns%5B%5D=NewPathName&selectedcolumns%5B%5D=FromServer&table=File_System_Profiles">File/Folder Deletion: <?php echo $pieDeletesResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=Permissions+Changes+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&fsreportname=Permissions+Changes&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ShareName&selectedcolumns%5B%5D=FullFilePath&selectedcolumns%5B%5D=FileNameOnly&selectedcolumns%5B%5D=NewPathName&selectedcolumns%5B%5D=FromServer&table=File_System_Profiles">File/Folder ACL Changes: <?php echo $piePermsResults[0][0] ?></a></td>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=File+and+Folder+Writes+Last+<?php echo $numOfDays ?>+Days&table=File_System_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=write&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ShareName&selectedcolumns%5B%5D=FullFilePath&selectedcolumns%5B%5D=FileNameOnly&selectedcolumns%5B%5D=NewPathName&selectedcolumns%5B%5D=FromServer">File/Folder Write: <?php echo $pieWritesResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Renames+%26+Moves+Last+<?php echo $numOfDays ?>+Days&table=File_System_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=rename&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ShareName&selectedcolumns%5B%5D=FullFilePath&selectedcolumns%5B%5D=FileNameOnly&selectedcolumns%5B%5D=NewPathName&selectedcolumns%5B%5D=FromServer">File/Folder Rename/Move: <?php echo $pieRenamesResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Blocked+Actions+Last+<?php echo $numOfDays ?>+Days&table=File_System_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=blocked+copy&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=block+delete&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ShareName&selectedcolumns%5B%5D=FullFilePath&selectedcolumns%5B%5D=FileNameOnly&selectedcolumns%5B%5D=NewPathName&selectedcolumns%5B%5D=FromServer">Blocked Actions: <?php echo $sumBlockedResults[0][0] ?></a></td>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Copy+to+Local+Last+<?php echo $numOfDays ?>+Days&table=File_System_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=Copy+from+UNC+to+Local&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ShareName&selectedcolumns%5B%5D=FullFilePath&selectedcolumns%5B%5D=FileNameOnly&selectedcolumns%5B%5D=NewPathName&selectedcolumns%5B%5D=FromServer">Copy to Local: <?php echo $sumCopyLocalResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Copy+To+Removable+Last+<?php echo $numOfDays ?>+Days&table=File_System_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=Removable&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ShareName&selectedcolumns%5B%5D=FullFilePath&selectedcolumns%5B%5D=FileNameOnly&selectedcolumns%5B%5D=NewPathName&selectedcolumns%5B%5D=FromServer">Copy to Removable: <?php echo $sumCopyRemoveResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Files+Access+by+Web+Browser+Last+<?php echo $numOfDays ?>+Days&table=File_System_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=ShareName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=iexplore&filtercolumns%5B%5D=ShareName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=chrome&filtercolumns%5B%5D=ShareName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=firefox&filtercolumns%5B%5D=ShareName&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=pickerhost&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=UserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ShareName&selectedcolumns%5B%5D=FullFilePath&selectedcolumns%5B%5D=FileNameOnly&selectedcolumns%5B%5D=NewPathName&selectedcolumns%5B%5D=FromServer">Accessed by Browser: <?php echo $sumBrowserAccessResults[0][0] ?></a></td>
								</tr>
							</table>
							<table class="table table-hover table-striped table-sm" <?php echo $setADSumDisplay; ?>>
								<tr class="header">
									<th class="sumtableheader" colspan="3">User Status Summary Last <?php echo $numOfDays ?> Days<span></span></th>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=User+Accounts+Created+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&adreportname=User+Accounts+Created&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer&table=Active_Directory_Profiles">User Creation: <?php echo $adHBarQueryCreatedResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=User+Accounts+Deleted+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&adreportname=User+Accounts+Deleted&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer&table=Active_Directory_Profiles">User Deletion: <?php echo $adHBarQueryDeletedResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=User+Account+Modifications+Last+<?php echo $numOfDays ?>+Days&table=Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=ObjectClass&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=user&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=object&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer">User Modification: <?php echo $sumUserModsResults[0][0] ?></a></td>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=User+Accounts+Enabled+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&adreportname=User+Accounts+Enabled&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer&table=Active_Directory_Profiles">User Enabled: <?php echo $adHBarQueryEnabledResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=User+Accounts+Disabled+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&adreportname=User+Accounts+Disabled&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer&table=Active_Directory_Profiles">User Disabled: <?php echo $adHBarQueryDisabledResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=User+Account+Password+Reset+Last+<?php echo $numOfDays ?>+Days&table=Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=AttributeAffected&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=pwdlastset&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=ad+add+attribute&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer">User Password Reset: <?php echo $sumPwdLastSetResults[0][0] ?></a></td>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=User+Accounts+Locked+Last+<?php echo $numOfDays ?>+Days&table=Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=add+attribute&filtercolumns%5B%5D=AttributeAffected&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=lockout&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer">User Locked Out: <?php echo $adHBarQueryLockedResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=User+Accounts+Unlocked+Last+<?php echo $numOfDays ?>+Days&table=Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=delete+attribute&filtercolumns%5B%5D=AttributeAffected&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=lockout&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer">User Unlocked: <?php echo $sumUnlockedResults[0][0] ?></a></td>
									<td></td>
								</tr>
							</table>
							<table class="table table-hover table-striped table-sm" <?php echo $setADSumDisplay; ?>>
								<tr class="header">
									<th class="sumtableheader" colspan="4">Group Status Summary Last <?php echo $numOfDays ?> Days<span></span></th>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=Group+Creations+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&adreportname=Groups+Created&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer&table=Active_Directory_Profiles">Group Creation: <?php echo $adPieQueryGroupCreatesResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=Group+Deletions+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&adreportname=Groups+Deleted&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer&table=Active_Directory_Profiles">Group Deletion: <?php echo $adPieQueryGroupDeletesResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Users+Added+to+Groups+Last+<?php echo $numOfDays ?>+Days&table=Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=ad+add+attribute&filtercolumns%5B%5D=ObjectClass&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=group&filtercolumns%5B%5D=AttributeAffected&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=member&filtercolumns%5B%5D=AttributeAffected&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=memberof&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer">Member Added To Group: <?php echo $adPieQueryGroupMemAddResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Users+Removed+from+Groups+Last+<?php echo $numOfDays ?>+Days&table=Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=ObjectClass&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=group&filtercolumns%5B%5D=AttributeAffected&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=member&filtercolumns%5B%5D=AttributeAffected&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=memberof&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=ad+delete+attribute&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer">Member Removed From Group: <?php echo $adPieQueryGroupMemRemResults[0][0] ?></a></td>
								</tr>
							</table>
							<table class="table table-hover table-striped table-sm" <?php echo $setADSumDisplay; ?>>
								<tr class="header">
									<th class="sumtableheader" colspan="3">Computer Status Summary Last <?php echo $numOfDays ?> Days<span></span></th>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=Computer+Accounts+Created+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&adreportname=Computer+Accounts+Created&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer&table=Active_Directory_Profiles">Computer Creation: <?php echo $sumCompCreatedResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=Computer+Accounts+Deleted+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&adreportname=Computer+Accounts+Deleted&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer&table=Active_Directory_Profiles">Computer Deletion: <?php echo $sumCompDeletedResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Computer+Accounts+Modified+Last+<?php echo $numOfDays ?>+Days&table=Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=ObjectClass&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=computer&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=object&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer">Computer Modification: <?php echo $sumCompModsResults[0][0] ?></a></td>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=Computer+Accounts+Enabled+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&adreportname=Computer+Accounts+Enabled&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer&table=Active_Directory_Profiles">Computer Enabled: <?php echo $sumCompEnabledResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/cannedresults.php?formSubmit=HTML&title=Computer+Accounts+Disabled+Last+<?php echo $numOfDays ?>+Days&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&adreportname=Computer+Accounts+Disabled&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer&table=Active_Directory_Profiles">Computer Disabled: <?php echo $sumCompDisabledResults[0][0] ?></a></td>
									<td></td>
								</tr>
							</table>
							<table class="table table-hover table-striped table-sm" <?php echo $setADSumDisplay; ?>>
								<tr class="header">
									<th class="sumtableheader" colspan="3">OU Status Summary Last <?php echo $numOfDays ?> Days<span></span></th>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Organizational+Units+Created+Last+<?php echo $numOfDays ?>+Days&table=Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=create+object&filtercolumns%5B%5D=ObjectClass&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=organization&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer">OU Creation: <?php echo $sumOUCreatedResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Organizational+Units+Deleted+Last+<?php echo $numOfDays ?>+Days&table=Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=ObjectClass&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=organization&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=delete+object&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer">OU Deletion: <?php echo $sumOUDeletedResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Organizational+Units+Modified+Last+<?php echo $numOfDays ?>+Days&table=Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=ObjectClass&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=organization&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=object&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer">OU Modification: <?php echo $sumOUModsResults[0][0] ?></a></td>
								</tr>
							</table>
							<table class="table table-hover table-striped table-sm" <?php echo $setGPOADSumDisplay; ?>>
								<tr class="header">
									<th class="sumtableheader" colspan="4">GPO Status Summary Last <?php echo $numOfDays ?> Days<span></span></th>
								</tr>
								<tr>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Group+Policy+Objects+Created+Last+<?php echo $numOfDays ?>+Days&table=GPO_Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=create+object&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=GPODisplayName&selectedcolumns%5B%5D=GPOADChangeDetails&selectedcolumns%5B%5D=FromServer">GPO Creation: <?php echo $sumGPOCreatedResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Group+Policy+Objects+Deleted+Last+<?php echo $numOfDays ?>+Days&table=GPO_Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=delete+object&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=GPODisplayName&selectedcolumns%5B%5D=GPOADChangeDetails&selectedcolumns%5B%5D=FromServer">GPO Deletion: <?php echo $sumGPODeletedResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Group+Policy+Objects+Linked+Last+<?php echo $numOfDays ?>+Days&table=Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=AttributeAffected&filterexpressions%5B%5D=LIKE&filtervalues%5B%5D=gplink&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=ObjectAffected&selectedcolumns%5B%5D=ObjectClass&selectedcolumns%5B%5D=AttributeAffected&selectedcolumns%5B%5D=AttributeValueAdded&selectedcolumns%5B%5D=AttributeValueRemoved&selectedcolumns%5B%5D=AdditionalDetailRegardingSelectedAttributes&selectedcolumns%5B%5D=FromServer">GPO Link Changes: <?php echo $sumGPOLinksResults[0][0] ?></a></td>
									<td><a target="_blank" href="./cptrax/php/results.php?formSubmit=HTML&title=Group+Policy+Objects+Modified+Last+<?php echo $numOfDays ?>+Days&table=GPO_Active_Directory_Profiles&dateradio=on&datefilter2=<?php echo $numOfDays ?>&dateexpression=days&filtervalue=&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=create+object&filtercolumns%5B%5D=Action&filterexpressions%5B%5D=NOT+LIKE&filtervalues%5B%5D=delete+object&selectedcolumns%5B%5D=Action&selectedcolumns%5B%5D=TimeOccurred&selectedcolumns%5B%5D=PerformedByUserName&selectedcolumns%5B%5D=IPv4From&selectedcolumns%5B%5D=GPODisplayName&selectedcolumns%5B%5D=GPOADChangeDetails&selectedcolumns%5B%5D=FromServer">GPO Modification: <?php echo $sumGPOModsResults[0][0] ?></a></td>
								</tr>
							</table>
						</div>
						<div id="settings" class="form-group row marginleft tab-pane fade">
							<div class="addpaddingleft addpaddingtop chartsize col-sm-1">
								<form class="form-horizontal" method="get">
									<div class="form-group row btn-group">
											<input type="submit" class="btn btn-default" formtarget="_self" name="formSubmit" value="Apply Changes" formaction="./cptrax/php/createNumDays.php">
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Number of Days:</label>
										<div class="col-sm-4">
											<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="<?php echo $numOfDays ?>" name="numberofdays" onkeypress="return isNumber(event)">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div id="customquery" class="container addpaddingtop tab-pane fade">
					<div class="marginleft">
						<form class="form-horizontal" method="get" action="./cptrax/php/results.php">
							<div class="form-group row btn-group">
								<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmit" value="HTML" onclick="selectAllOptions()">
								<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="CSV" formaction="./cptrax/php/csvoutput.php" onclick="selectAllOptions()">
							    <input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="PDF" formaction="./cptrax/php/pdfoutput.php" onclick="selectAllOptions()">
								<input type="submit" class="btn btn-default" formtarget="_self" name="formSubmitSavedQuery" value="Save Query" formaction="./cptrax/php/createSavedQuery.php" onclick="selectAllOptions()">
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Report Title:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="Enter Report Name" name="title">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Type of Activity:</label>
								<div class="col-sm-4">
									<select class="form-control" id="table" name="table" onchange="buildFilterColumns(this);buildAvailableColumns(this);buildSelectedColumns(this);">
										<option value="empty">Select an Activity Type</option>
										<option value="Logon_Logoff_and_Failed_Logon_Profiles" <?php echo $setLLSumDisplay; ?>>Authentication</option>
										<option value="File_System_Profiles" <?php echo $setFSSumDisplay; ?>>File System</option>
										<option value="Active_Directory_Profiles" <?php echo $setADSumDisplay; ?>>Active Directory</option>
										<option value="GPO_Active_Directory_Profiles" <?php echo $setGPOADSumDisplay; ?>>GPO AD Changes</option>
										<option value="GPO_File_System_Profiles" <?php echo $setGPOADSumDisplay; ?>>GPO FS Changes</option>										
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Date Range:</label>
								<div class="col-sm-4">
									<div class="input-group">
										<span class="input-group-addon">
											<input onclick="document.getElementById('daterange').disabled = false; document.getElementById('daterange2').disabled = true; document.getElementById('dateexpression').disabled = true;" type="radio" name="dateradio" checked="checked">
										</span>
										<input class="form-control" id="daterange" type="text" name="datefilter" value="" readonly>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">During the Last X:</label>
								<div class="col-sm-4">
									<div class="input-group">
										<span class="input-group-addon">
											<input onclick="document.getElementById('daterange').disabled = true; document.getElementById('daterange2').disabled = false; document.getElementById('dateexpression').disabled = false;" type="radio" name="dateradio">
										</span>
										<input class="form-control" disabled="true" id="daterange2" type="text" name="datefilter2" placeholder="Enter Amount" onkeypress="return isNumber(event)">
										<select class="form-control" disabled="true" id="dateexpression" name="dateexpression">
											<option value="minutes">Minutes</option>
											<option value="hours">Hours</option>
											<option value="days">Days</option>
											<option value="weeks">Weeks</option>
											<option value="months">Months</option>
											<option value="years">Years</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="col-form-label">Columns:</label>
									<select class="form-control-columnselect form-control" id="filtercolumn" name="filtercolumn[]">
										<option value="0">Select an Activity Type</option>
									</select>
								</div>
								<div class="col-sm-2">
									<label class="col-form-label">Expressions:</label>
									<select class="form-control" id="filterexpression" name="filterexpression">    
										<option value="LIKE">contains</option>
										<option value="NOT LIKE">does not contain</option>
									</select>
								</div>
								<div class="col-sm-3">
									<label class="col-form-label">Value:</label>
									<div class="input-group">
										<input class="form-control" type="text" id="filtervalue" name="filtervalue" placeholder="Enter Value">
										<div class="input-group-btn">
											<button class="btn btn-success" type="button"  onclick="filter_fields();"> &zwnj;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
										</div>
									</div>
								</div>
							</div>
							<div id="filter_fields">
							</div>
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="col-form-label">Available Columns</label>
									<select class="form-control form-control-columnselect" id="availablecolumns" name="availablecolumns[]" multiple="multiple" size="10">
										<option value="empty">Select an Activity Type</option>
										<script type="text/javascript">for(var i=0;i<availableColumnsArray.length;i++) {document.write('<option>'+availableColumnsArray[i]+'</option>');}</script>
									</select>
								</div>
								<div class="row col-sm-1 addpaddingtop btn-group-vertical">
									<button type="button" class="btn btn-default" onclick="addalltoselectedcolumns()"><i class="glyphicon glyphicon-forward"></i></button>
									<button type="button" class="btn btn-default" onclick="addtoselectedcolumns()"><i class="glyphicon glyphicon-chevron-right"></i></button>
									<button type="button" class="btn btn-default"  onclick="remfromselectcolumns()"><i class="glyphicon glyphicon-chevron-left"></i></button>
									<button type="button" class="btn btn-default" onclick="remallfromselectcolumns()"><i class="glyphicon glyphicon-backward"></i></button>
								</div>
								<div class="col-sm-4">
									<label class="col-form-label">Selected Columns</label>
									<select class="form-control form-control-columnselect" id="selectedcolumns" name="selectedcolumns[]" multiple="multiple" size="10">
										<option value="empty">Select an Activity Type</option>
										<script type="text/javascript">for(var j=0;j<selectedColumnsArray.length;j++){document.write('<option>'+selectedColumnsArray[j]+'</option>');}</script>
									</select>
								</div>
								<div class="row col-sm-1 addpaddingtop btn-group-vertical">
									<button type="button" id="multiselect_move_up" class="btn btn-default" onclick="moveupselectedcolumns(); return false;"><i class="glyphicon glyphicon-arrow-up"></i></button>
									<button type="button" id="multiselect_move_down" class="btn btn-default" onclick="movedownselectedcolumns(); return false;"><i class="glyphicon glyphicon-arrow-down"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div id="reports" class="tab-pane fade">
					<div class="col-sm-2">
						<nav class="nav flex-column addpaddingtop addpaddingbottom" style="padding-bottom: 150px;">
							<?php if ($sumADRowCountResults[0][0] > 0) { echo "<a class=\"nav-link ".$setADChartActive."\" data-toggle=\"tab\" href=\"#activedirectory\">Active Directory Reports</a><br><br>"; } ?>
							<?php if ($sumFSRowCountResults[0][0] > 0) { echo "<a class=\"nav-link ".$setFSChartActive."\" data-toggle=\"tab\" href=\"#filesystem\">File System Reports</a><br><br>"; } ?>
							<?php if ($sumLLRowCountResults[0][0] > 0) { echo "<a class=\"nav-link ".$setLLChartActive."\" data-toggle=\"tab\" href=\"#authentication\">Authentication Reports</a><br><br>"; } ?>
							<?php if ($sumGPOADRowCountResults[0][0] > 0) { echo "<a class=\"nav-link ".$setGPOADChartActive."\" data-toggle=\"tab\" href=\"#gpoad\">Group AD Reports</a><br><br>"; } ?>
							<?php if ($sumGPOADRowCountResults[0][0] > 0) { echo "<a class=\"nav-link ".$setGPOADChartActive."\" data-toggle=\"tab\" href=\"#gpofs\">Group FS Reports</a><br><br>"; } ?>
							<a class="nav-link" data-toggle="tab" ></a><br><br>
							<a class="nav-link" data-toggle="tab" ></a><br><br>
						</nav>
					</div>
					<div class="tab-content">
						<div id="activedirectory" class="marginleft addpaddingtop tab-pane fade in <?php echo $setADChartActive; ?>" <?php echo $setADSumDisplay; ?>">
							<form class="form-horizontal" method="get" action="./cptrax/php/cannedresults.php">
								<div class="form-group row btn-group">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmit" value="HTML" onclick="selectAllOptionsad()">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="CSV" formaction="./cptrax/php/csvoutput.php" onclick="selectAllOptionsad()">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="PDF" formaction="./cptrax/php/pdfoutput.php" onclick="selectAllOptionsad()">
								</div>
								<div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">Report Title:</label>
										<div class="col-sm-3">
												<input class="form-control col-sm-4" name="title" type="text" placeholder="Enter Report Name">
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">Date Range:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">
													<input onclick="document.getElementById('daterangecannedad').disabled = false; document.getElementById('daterange2cannedad').disabled = true; document.getElementById('dateexpressioncannedad').disabled = true;" type="radio" name="dateradio" checked="checked">
												</span>
												<input class="form-control" id="daterangecannedad" type="text" name="datefilter" value="" readonly>
											</div>
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">During the Last X:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">
													<input onclick="document.getElementById('daterangecannedad').disabled = true; document.getElementById('daterange2cannedad').disabled = false; document.getElementById('dateexpressioncannedad').disabled = false;" type="radio" name="dateradio">
												</span>
												<input class="form-control" disabled="true" id="daterange2cannedad" type="text" name="datefilter2" placeholder="Enter Amount" onkeypress="return isNumber(event)">
												<select class="form-control" disabled="true" id="dateexpressioncannedad" name="dateexpression">
													<option value="minutes">Minutes</option>
													<option value="hours">Hours</option>
													<option value="days">Days</option>
													<option value="weeks">Weeks</option>
													<option value="months">Months</option>
													<option value="years">Years</option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">Reports:</label>
										<div class="col-sm-3">
											<input class="form-control" type="text" id="findItemAD" placeholder="Search...">
											<select class="form-control form-control-columnselect" id="adreportname" name="adreportname" size="23">
												<option value="Active Directory Security Changes">Active Directory Security Changes</option>
												<option value="Administrative Group Changes">Administrative Group Changes</option>
												<option value="All Active Directory Changes">All Active Directory Changes</option>
												<option value="All Computer Account Changes">All Computer Account Changes</option>
												<option value="All Contact Changes">All Contact Changes</option>
												<option value="All Group Changes">All Group Changes</option>
												<option value="All Organizational Unit Changes">All Organizational Unit Changes</option>
												<option value="All User Account Changes">All User Account Changes</option>
												<option value="All User Account Status Changes">All User Account Status Changes</option>
												<option value="Computer Accounts Created">Computer Accounts Created</option>
												<option value="Computer Accounts Deleted">Computer Accounts Deleted</option>
												<option value="Computer Accounts Disabled">Computer Accounts Disabled</option>
												<option value="Computer Accounts Enabled">Computer Accounts Enabled</option>
												<option value="Groups Created">Groups Created</option>
												<option value="Groups Deleted">Groups Deleted</option>
												<option value="Group Membership Changes">Group Membership Changes</option>
												<option value="Password Changes">Passsword Changes</option>
												<option value="User Accounts Created">User Accounts Created</option>
												<option value="User Accounts Deleted">User Accounts Deleted</option>
												<option value="User Accounts Disabled">User Accounts Disabled</option>
												<option value="User Accounts Enabled">User Accounts Enabled</option>
												<option value="User Accounts Locked Out">User Accounts Locked Out</option>
											</select>
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<div class="col-sm-4" style="display: none;">
											<label class="col-form-label">Selected Columns</label>
											<select class="form-control form-control-columnselect" id="selectedcolumnsad" name="selectedcolumns[]" multiple="multiple" size="10">
												<option value="Action">Action</option>
												<option value="TimeOccurred">TimeOccurred</option>
												<option value="PerformedByUserName">PerformedByUserName</option>
												<option value="IPv4From">IPv4From</option>
												<option value="ObjectAffected">ObjectAffected</option>
												<option value="ObjectClass">ObjectClass</option>
												<option value="AttributeAffected">AttributeAffected</option>
												<option value="AttributeValueAdded">AttributeValueAdded</option>
												<option value="AttributeValueRemoved">AttributeValueRemoved</option>
												<option value="AdditionalDetailRegardingSelectedAttributes">AdditionalDetailRegardingSelectedAttributes</option>
												<option value="FromServer">FromServer</option>
											</select>
										</div>
										<div class="col-sm-4" style="display: none;">
											<label class="col-form-label">Table</label>
											<input id="table" type="text" name="table" value="Active_Directory_Profiles">
										</div>
									</div>
								</div>
							</form>
						</div>
						<div id="filesystem" class="marginleft addpaddingtop tab-pane fade in <?php echo $setFSChartActive; ?>" <?php echo $setFSSumDisplay; ?>">
							<form class="form-horizontal" method="get" action="./cptrax/php/cannedresults.php">
								<div class="form-group row btn-group">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmit" value="HTML" onclick="selectAllOptionsfs()">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="CSV" formaction="./cptrax/php/csvoutput.php" onclick="selectAllOptionsfs()">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="PDF" formaction="./cptrax/php/pdfoutput.php" onclick="selectAllOptionsfs()">
								</div>
								<div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">Report Title:</label>
										<div class="col-sm-3">
												<input class="form-control col-sm-4" name="title" type="text" placeholder="Enter Report Name">
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">Date Range:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">
													<input onclick="document.getElementById('daterangecannedfs').disabled = false; document.getElementById('daterange2cannedfs').disabled = true; document.getElementById('dateexpressioncannedfs').disabled = true;" type="radio" name="dateradio" checked="checked">
												</span>
												<input class="form-control" id="daterangecannedfs" type="text" name="datefilter" value="" readonly>
											</div>
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">During the Last X:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">
													<input onclick="document.getElementById('daterangecannedfs').disabled = true; document.getElementById('daterange2cannedfs').disabled = false; document.getElementById('dateexpressioncannedfs').disabled = false;" type="radio" name="dateradio">
												</span>
												<input class="form-control" disabled="true" id="daterange2cannedfs" type="text" name="datefilter2" placeholder="Enter Amount" onkeypress="return isNumber(event)">
												<select class="form-control" disabled="true" id="dateexpressioncannedfs" name="dateexpression">
													<option value="minutes">Minutes</option>
													<option value="hours">Hours</option>
													<option value="days">Days</option>
													<option value="weeks">Weeks</option>
													<option value="months">Months</option>
													<option value="years">Years</option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group row col-sm-11">
											<label class="col-sm-1 col-form-label">Reports:</label>
										<div class="col-sm-3">
											<input class="form-control" type="text" id="findItemFS" placeholder="Search...">
											<select class="form-control form-control-columnselect" id="fsreportname" name="fsreportname" size="23">
												<option value="All File Changes">All File Changes</option>
												<option value="All File System Changes">All File System Changes</option>
												<option value="All Folder Changes">All Folder Changes</option>
												<option value="Created Files">Created Files</option>
												<option value="Created Files and Folders">Created Files and Folders</option>
												<option value="Created Folders">Created Folders</option>
												<option value="Deleted Files">Deleted Files</option>
												<option value="Deleted Files and Folders">Deleted Files and Folders</option>
												<option value="Deleted Folders">Deleted Folders</option>
												<option value="Renamed Files">Renamed Files</option>
												<option value="Renamed Folders">Renamed Folders</option>
												<option value="Permissions Changes">Permissions Changes</option>
												<option value="Files Copied from UNC to Local Device">Files Copied UNC to Local (Workstation Agent)</option>
												<option value="Files Copied from Local to Local Device">Files Copied Local to Local (Workstation Agent)</option>
												<option value="Files Copied to Removable Device">Files Copied to Removable (Workstation Agent)</option>
												<option value="Files Created on Removable Device">Files Created on Removable (Workstation Agent)</option>
												<option value="Files Deleted from Removable Device">Files Deleted from Removable (Workstation Agent)</option>
												<option value="Removable Found at Startup">Removable Found at Startup (Workstation Agent)</option>
												<option value="Removable Connected">Removable Connected (Workstation Agent)</option>
												<option value="Removable Ejected">Removable Ejected (Workstation Agent)</option>
												<option value="Files Accessed By Web Browsers">Files Accessed By Web Browsers (Workstation Agent)</option>
												<option value="Processes Accessing Unexpected Files">Process Accessed Unexpected File (Workstation Agent)</option>
											</select>
										</div>
										<div class="col-sm-4" style="display: none;">
											<label class="col-form-label">Selected Columns</label>
											<select class="form-control form-control-columnselect" id="selectedcolumnsfs" name="selectedcolumns[]" multiple="multiple" size="10">
												<option value="Action">Action</option>
												<option value="TimeOccurred">TimeOccurred</option>
												<option value="UserName">UserName</option>
												<option value="IPv4From">IPv4From</option>
												<option value="ShareName">ShareName</option>
												<option value="FullFilePath">FullFilePath</option>
												<option value="FileNameOnly">FileNameOnly</option>
												<option value="NewPathName">NewPathName</option>
												<option value="FromServer">FromServer</option>
											</select>
										</div>
										<div class="col-sm-4" style="display: none;">
											<label class="col-form-label">Table</label>
											<input id="table" type="text" name="table" value="File_System_Profiles">
										</div>
									</div>
								</div>
							</form>
						</div>
						<div id="authentication" class="marginleft addpaddingtop tab-pane fade in <?php echo $setLLChartActive; ?>" <?php echo $setLLSumDisplay; ?>">
							<form class="form-horizontal" method="get" action="./cptrax/php/cannedresults.php">
								<div class="form-group row btn-group">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmit" value="HTML" onclick="selectAllOptionsauth()">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="CSV" formaction="./cptrax/php/csvoutput.php" onclick="selectAllOptionsauth()">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="PDF" formaction="./cptrax/php/pdfoutput.php" onclick="selectAllOptionsauth()">
								</div>
								<div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">Report Title:</label>
										<div class="col-sm-3">
												<input class="form-control col-sm-4" name="title" type="text" placeholder="Enter Report Name">
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">Date Range:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">
													<input onclick="document.getElementById('daterangecannedauth').disabled = false; document.getElementById('daterange2cannedauth').disabled = true; document.getElementById('dateexpressioncannedauth').disabled = true;" type="radio" name="dateradio" checked="checked">
												</span>
												<input class="form-control" id="daterangecannedauth" type="text" name="datefilter" value="" readonly>
											</div>
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">During the Last X:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">
													<input onclick="document.getElementById('daterangecannedauth').disabled = true; document.getElementById('daterange2cannedauth').disabled = false; document.getElementById('dateexpressioncannedauth').disabled = false;" type="radio" name="dateradio">
												</span>
												<input class="form-control" disabled="true" id="daterange2cannedauth" type="text" name="datefilter2" placeholder="Enter Amount" onkeypress="return isNumber(event)">
												<select class="form-control" disabled="true" id="dateexpressioncannedauth" name="dateexpression">
													<option value="minutes">Minutes</option>
													<option value="hours">Hours</option>
													<option value="days">Days</option>
													<option value="weeks">Weeks</option>
													<option value="months">Months</option>
													<option value="years">Years</option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group row col-sm-11">
											<label class="col-sm-1 col-form-label">Reports:</label>
										<div class="col-sm-3">
											<input class="form-control" type="text" id="findItemAUTH" placeholder="Search...">
											<select class="form-control form-control-columnselect" id="authreportname" name="authreportname" size="10">
												<option value="Authentication History">Authentication History</option>
												<option value="Failed Authentication History">Failed Authentication History</option>
												<option value="Failed Authentications - Bad Account Name">Failed Authentications - Bad Account Name</option>
												<option value="Failed Authentications - Bad Password">Failed Authentications - Bad Password</option>
												<option value="Workstation Locks & Unlocks">Workstation Locks & Unlocks (Workstation Agent)</option>
											</select>
										</div>
										<div class="col-sm-4" style="display: none;">
											<label class="col-form-label">Selected Columns</label>
											<select class="form-control form-control-columnselect" id="selectedcolumnsauth" name="selectedcolumns[]" multiple="multiple" size="10">
												<option value="Action">Action</option>
												<option value="TimeOccurred">TimeOccurred</option>
												<option value="FailCodeText">FailCodeText</option>
												<option value="UserName">UserName</option>
												<option value="IPv4From">IPv4From</option>
												<option value="FromServer">FromServer</option>
											</select>
										</div>
										<div class="col-sm-4" style="display: none;">
											<label class="col-form-label">Table</label>
											<input id="table" type="text" name="table" value="Logon_Logoff_and_Failed_Logon_Profiles">
										</div>
									</div>
								</div>
							</form>
						</div>
						<div id="gpoad" class="marginleft addpaddingtop tab-pane fade in <?php echo $setGPOADChartActive; ?> <?php echo $setGPOADSumDisplay; ?>">
							<form class="form-horizontal" method="get" action="./cptrax/php/cannedresults.php">
								<div class="form-group row btn-group">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmit" value="HTML" onclick="selectAllOptionsgpoad()">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="CSV" formaction="./cptrax/php/csvoutput.php" onclick="selectAllOptionsgpoad()">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="PDF" formaction="./cptrax/php/pdfoutput.php" onclick="selectAllOptionsgpoad()">
								</div>
								<div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">Report Title:</label>
										<div class="col-sm-3">
												<input class="form-control col-sm-4" name="title" type="text" placeholder="Enter Report Name">
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">Date Range:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">
													<input onclick="document.getElementById('daterangecannedgpoad').disabled = false; document.getElementById('daterange2cannedgpoad').disabled = true; document.getElementById('dateexpressioncannedgpoad').disabled = true;" type="radio" name="dateradio" checked="checked">
												</span>
												<input class="form-control" id="daterangecannedgpoad" type="text" name="datefilter" value="" readonly>
											</div>
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">During the Last X:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">
													<input onclick="document.getElementById('daterangecannedgpoad').disabled = true; document.getElementById('daterange2cannedgpoad').disabled = false; document.getElementById('dateexpressioncannedgpoad').disabled = false;" type="radio" name="dateradio">
												</span>
												<input class="form-control" disabled="true" id="daterange2cannedgpoad" type="text" name="datefilter2" placeholder="Enter Amount" onkeypress="return isNumber(event)">
												<select class="form-control" disabled="true" id="dateexpressioncannedgpoad" name="dateexpression">
													<option value="minutes">Minutes</option>
													<option value="hours">Hours</option>
													<option value="days">Days</option>
													<option value="weeks">Weeks</option>
													<option value="months">Months</option>
													<option value="years">Years</option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group row col-sm-11">
											<label class="col-sm-1 col-form-label">Reports:</label>
										<div class="col-sm-3">
											<input class="form-control" type="text" id="findItemGPOAD" placeholder="Search...">
											<select class="form-control form-control-columnselect" id="gpoadreportname" name="gpoadreportname" size="10">
												<option value="GPO Changes">GPO Changes</option>
												<option value="Default Domain Policy Changes">Default Domain Policy Changes</option>
											</select>
										</div>
										<div class="col-sm-4" style="display: none;">
											<label class="col-form-label">Selected Columns</label>
											<select class="form-control form-control-columnselect" id="selectedcolumnsgpoad" name="selectedcolumns[]" multiple="multiple" size="10">
												<option value="Action">Action</option>
												<option value="TimeOccurred">TimeOccurred</option>
												<option value="PerformedByUserName">PerformedByUserName</option>
												<option value="IPv4From">IPv4From</option>
												<option value="GPODisplayName">GPODisplayName</option>
												<option value="GPOADChangeDetails">GPOADChangeDetails</option>
												<option value="FromServer">FromServer</option>
											</select>
										</div>
										<div class="col-sm-4" style="display: none;">
											<label class="col-form-label">Table</label>
											<input id="table" type="text" name="table" value="GPO_Active_Directory_Profiles">
										</div>
									</div>
								</div>
							</form>
						</div>
						<div id="gpofs" class="marginleft addpaddingtop tab-pane fade in <?php echo $setGPOADChartActive; ?> <?php echo $setGPOADSumDisplay; ?>">
							<form class="form-horizontal" method="get" action="./cptrax/php/cannedresults.php">
								<div class="form-group row btn-group">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmit" value="HTML" onclick="selectAllOptionsgpofs()">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="CSV" formaction="./cptrax/php/csvoutput.php" onclick="selectAllOptionsgpofs()">
									<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitPDF" value="PDF" formaction="./cptrax/php/pdfoutput.php" onclick="selectAllOptionsgpofs()">
								</div>
								<div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">Report Title:</label>
										<div class="col-sm-3">
												<input class="form-control col-sm-4" name="title" type="text" placeholder="Enter Report Name">
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">Date Range:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">
													<input onclick="document.getElementById('daterangecannedgpofs').disabled = false; document.getElementById('daterange2cannedgpofs').disabled = true; document.getElementById('dateexpressioncannedgpofs').disabled = true;" type="radio" name="dateradio" checked="checked">
												</span>
												<input class="form-control" id="daterangecannedgpofs" type="text" name="datefilter" value="" readonly>
											</div>
										</div>
									</div>
									<div class="form-group row col-sm-11">
										<label class="col-sm-1 col-form-label">During the Last X:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">
													<input onclick="document.getElementById('daterangecannedgpofs').disabled = true; document.getElementById('daterange2cannedgpofs').disabled = false; document.getElementById('dateexpressioncannedgpofs').disabled = false;" type="radio" name="dateradio">
												</span>
												<input class="form-control" disabled="true" id="daterange2cannedgpofs" type="text" name="datefilter2" placeholder="Enter Amount" onkeypress="return isNumber(event)">
												<select class="form-control" disabled="true" id="dateexpressioncannedgpofs" name="dateexpression">
													<option value="minutes">Minutes</option>
													<option value="hours">Hours</option>
													<option value="days">Days</option>
													<option value="weeks">Weeks</option>
													<option value="months">Months</option>
													<option value="years">Years</option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group row col-sm-11">
											<label class="col-sm-1 col-form-label">Reports:</label>
										<div class="col-sm-3">
											<input class="form-control" type="text" id="findItemGPOFS" placeholder="Search...">
											<select class="form-control form-control-columnselect" id="gpofsreportname" name="gpofsreportname" size="10">
												<option value="GPO Changes">GPO Changes</option>
												<option value="Default Domain Policy Changes">Default Domain Policy Changes</option>
											</select>
										</div>
										<div class="col-sm-4" style="display: none;">
											<label class="col-form-label">Selected Columns</label>
											<select class="form-control form-control-columnselect" id="selectedcolumnsgpofs" name="selectedcolumns[]" multiple="multiple" size="10">
												<option value="Action">Action</option>
												<option value="TimeOccurred">TimeOccurred</option>
												<option value="UserName">UserName</option>
												<option value="IPv4From">IPv4From</option>
												<option value="GPODisplayName">GPODisplayName</option>
												<option value="GPOFileChangeAction">GPOFileChangeAction</option>
												<option value="GPOFileSectionParameterName">GPOFileSectionParameterName</option>
												<option value="FromServer">FromServer</option>
											</select>
										</div>
										<div class="col-sm-4" style="display: none;">
											<label class="col-form-label">Table</label>
											<input id="table" type="text" name="table" value="GPO_File_System_Profiles">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div id="savedqueries" class="container addpaddingtop tab-pane fade">
					<div class="marginleft">
						<form class="form-horizontal" method="get" action="./cptrax/php/savedresults.php">
							<div class="form-group row btn-group">
								<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmit" value="HTML">
								<input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitCSV" value="CSV" formaction="./cptrax/php/savedcsvoutput.php">
							    <input type="submit" class="btn btn-default" formtarget="_blank" name="formSubmitPDF" value="PDF" formaction="./cptrax/php/savedpdfoutput.php">
								<input type="submit" class="btn btn-default" formtarget="_self" name="formSubmitDeleteQuery" value="Delete Query" formaction="./cptrax/php/deleteSavedQuery.php">
							</div>
							<div class="form-group row">
								<label class="col-sm-1 col-form-label">Reports:</label>
								<div class="col-sm-6">
									<select class="form-control form-control-columnselect" id="savedreportname" name="savedreportname" size="23">
										<?php $myDir = './cptrax/php/savedqueries'; $myFiles = scandir($myDir,0); array_shift($myFiles); array_shift($myFiles); foreach ($myFiles as $file) { $file = rtrim($file,'.php'); echo '<option value="'.$file.'">'.$file.'</option>';} ?>
									</select>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div id="settings" class="tab-pane fade" style="display: none;">
					<div class="col-sm-2">
						<nav class="nav flex-column addpaddingtop">
							<a class="nav-link active" data-toggle="tab" href="#emailsettings">E-mail Settings</a><br><br>
							<a class="nav-link" data-toggle="tab" href="#sqlsettings">SQL Settings</a><br><br>
							<a class="nav-link" data-toggle="tab" href="#logsettings">Log Settings</a><br><br>
							<a class="nav-link" data-toggle="tab" href="#licensing">Licensing</a><br><br>
							<a class="nav-link" data-toggle="tab" href="#globalalerts">Global Alerts</a><br><br>
						</nav>
					</div>
					<div class="tab-content">
						<div id="emailsettings" class="form-group row marginleft addpaddingtop tab-pane fade in active">
							<div class="form-group row">
								<label class="col-sm-1 col-form-label">Dept Hosted:</label>
								<div class="col-sm-2">
									<?php
										exec('reg query "HKEY_LOCAL_MACHINE\SOFTWARE\Visual Click Software, Inc.\CPTRAX" /v DepartmentHosted /reg:64',$proxyenable,$proxyenable_status);
										$departmentHosted = preg_split("/[\s,]+/", $proxyenable[2], 4);
										echo '<input type="text" class="form-control" id="inlineFormInput" placeholder="'.$departmentHosted[3].'" name="title">'
									?>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</body>
	<script type="text/javascript" src="/cptrax/js/jquery.min.js"></script>
	<script type="text/javascript" src="/cptrax/js/Chart.min.js"></script>
	<script type="text/javascript" src="/cptrax/js/moment.min.js"></script>
	<script type="text/javascript" src="/cptrax/js/daterangepicker.js"></script>
	<script type="text/javascript" src="/cptrax/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/cptrax/js/custom.query.functions.js"></script>
	<script type="text/javascript" src="/cptrax/js/canned.query.functions.js"></script>
	<?php require '/cptrax/js/charts.js'; ?>
	<?php require '/cptrax/js/datepicker.js'; ?>
	<?php require '/cptrax/js/summary.js'; ?>
</html>