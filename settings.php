<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Visual Click Web Reporter</title>
		<link rel="stylesheet" href="../cptrax/css/bootstrap.min.css">
		<link rel="stylesheet" href="../cptrax/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="../cptrax/css/daterangepicker.css"/>
		<link rel="stylesheet" href="../cptrax/css/mainpage.css" type="text/css">
		<?php require '/cptrax/php/setnumdays.php'; ?>
	</head>
	<body>
		<div class="wrapper">
			<a href="https://www.visualclick.com" target="_blank">
			<img src="../cptrax/css/DataTables-1.10.15/images/vcs logo.png" alt="Visual Click Software, Inc" height="5%">
			</a>
			<ul class="nav nav-tabs addpaddingtop">
				<li class="active"><a data-toggle="tab" href="#settings">Settings</a></li>
			</ul>
			<div class="tab-content">
				<div id="settings" class="tab-pane fade in active col-sm-12">
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
	</body>
</html>