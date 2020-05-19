<?php

	require 'sqlconnect.php';
	require 'setnumdays.php';

	// Total Row Count for Each SQL Table - Controls whether queries for appropriate charts/summary are ran.

	$getQueryADRowCount = "SELECT Count(GUID) FROM [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles]";
	$GetSumADRowCountResult = sqlsrv_query($conn, $getQueryADRowCount );
	if ($GetSumADRowCountResult === false){
		die( print_r( sqlsrv_errors(), true));
	}
	while( $row = sqlsrv_fetch_array($GetSumADRowCountResult,SQLSRV_FETCH_NUMERIC) ) {
		$sumADRowCountResults[] = $row;
	}
		
	$getQueryFSRowCount = "SELECT Count(GUID) FROM [CPTRAX_for_Windows].[dbo].[File_System_Profiles]";
	$GetSumFSRowCountResult = sqlsrv_query($conn, $getQueryFSRowCount );
	if ($GetSumFSRowCountResult === false){
		die( print_r( sqlsrv_errors(), true));
	}
	while( $row = sqlsrv_fetch_array($GetSumFSRowCountResult,SQLSRV_FETCH_NUMERIC) ) {
		$sumFSRowCountResults[] = $row;
	}
	
	$getQueryGPOADRowCount = "SELECT Count(GUID) FROM [CPTRAX_for_Windows].[dbo].[GPO_Active_Directory_Profiles]";
	$GetSumGPOADRowCountResult = sqlsrv_query($conn, $getQueryGPOADRowCount );
	if ($GetSumGPOADRowCountResult === false){
		die( print_r( sqlsrv_errors(), true));
	}
	while( $row = sqlsrv_fetch_array($GetSumGPOADRowCountResult,SQLSRV_FETCH_NUMERIC) ) {
		$sumGPOADRowCountResults[] = $row;
	}
	
	$getQueryLLRowCount = "SELECT Count(GUID) FROM [CPTRAX_for_Windows].[dbo].[Logon_Logoff_and_Failed_Logon_Profiles]";
	$GetSumLLRowCountResult = sqlsrv_query($conn, $getQueryLLRowCount );
	if ($GetSumLLRowCountResult === false){
		die( print_r( sqlsrv_errors(), true));
	}
	while( $row = sqlsrv_fetch_array($GetSumLLRowCountResult,SQLSRV_FETCH_NUMERIC) ) {
		$sumLLRowCountResults[] = $row;
	}

	// Set Charts to be visible or invisible
	
	if ($sumADRowCountResults[0][0] > 0) {
	
		$setADChartActive = 'active';
	
	}
	
	elseif (($sumADRowCountResults[0][0] <= 0) && ($sumFSRowCountResults[0][0] > 0)) {
	
		$setFSChartActive = 'active';
	
	}
	
	elseif (($sumFSRowCountResults[0][0] <= 0) && ($sumLLRowCountResults[0][0] > 0)) {
	
		$setLLChartActive = 'active';
	
	}
	
	elseif (($sumLLRowCountResults[0][0] <= 0) && ($sumGPOADRowCountResults[0][0] > 0)) {
	
		$setGPOADChartActive = 'active';
	
	}

	if ($sumLLRowCountResults[0][0] <= 0) {
	
		$setLLSumDisplay = 'style="display: none;"';

	}
	
	// All Authentication Queries
	
	if ($sumLLRowCountResults[0][0] > 0) {

		// Get Data for Last 30 Days Authentications Line Chart
			
		$lineQueryFailedAuths = "select TimeOccurred = d.Date, Count(Action) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[Logon_Logoff_and_Failed_Logon_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.Action like '%failed%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$lineFailedAuthsQueryResult = sqlsrv_query($conn, $lineQueryFailedAuths );
		if($lineFailedAuthsQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($lineFailedAuthsQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$lineFailedAuthsResults[] = $row;
		}

		$lineQuerySuccAuths = "select TimeOccurred = d.Date, Count(Action) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[Logon_Logoff_and_Failed_Logon_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.Action like '%logon (%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$lineSuccAuthsQueryResult = sqlsrv_query($conn, $lineQuerySuccAuths );
		if($lineSuccAuthsQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($lineSuccAuthsQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$lineSuccAuthsResults[] = $row;
		}

		$lineQueryLockouts = "select TimeOccurred = d.Date, Count(Action) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.Action like '%add attribute%' and l.AttributeAffected like '%lockout%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0)) and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$lineLockoutsQueryResult = sqlsrv_query($conn, $lineQueryLockouts );
		if($lineLockoutsQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($lineLockoutsQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$lineLockoutsResults[] = $row;
		}

		// Get Data for Top Authentication Bar Chart

		$barQueryAuths = "SELECT UserName, Count(UserName) FROM [CPTRAX_for_Windows].[dbo].[Logon_Logoff_and_Failed_Logon_Profiles] WHERE UserName not like '%$%' AND Action like '%logon (%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE())) Group By UserName Order By Count(UserName) desc";
		$barAuthsQueryResult = sqlsrv_query($conn, $barQueryAuths );
		if($barAuthsQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($barAuthsQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$barAuthsResults[] = $row;
		}

		// Get Data for Top 5 Logon Failures for Last 30 Days (Side Bar Chart) (LL-BAR-2)

		$llHBarQuery = "SELECT UserName, Count(UserName) FROM [CPTRAX_for_Windows].[dbo].[Logon_Logoff_and_Failed_Logon_Profiles] WHERE UserName not like '%$%' AND Action like '%failed%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE())) Group By UserName Order By Count(UserName) desc";
		$llHBarQueryResult = sqlsrv_query($conn, $llHBarQuery );
		if($llHBarQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($llHBarQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$llHBarQueryResults[] = $row;
		}

		// Get Data for Authentication Events by Server Last 30 Days (TOP 5) (Pie Chart) (LL-PIE)

		$llPieTop5Query = "SELECT FromServer, Count(FromServer) FROM [CPTRAX_for_Windows].[dbo].[Logon_Logoff_and_Failed_Logon_Profiles] WHERE (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE())) Group By FromServer Order By Count(FromServer) desc";
		$llPieTop5QueryResult = sqlsrv_query($conn, $llPieTop5Query );
		if($llPieTop5QueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($llPieTop5QueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$llPieTop5QueryResults[] = $row;
		}

		// Total Auth Failures/Successes & Locks/Unlocks Last 30 Days Summary Report
			
		$sumQueryTotalFails = "SELECT Count(UserName) FROM [dbo].[Logon_Logoff_and_Failed_Logon_Profiles] WHERE UserName not like '%$%' AND Action like '%failed%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumQueryTotalFailsResult = sqlsrv_query($conn, $sumQueryTotalFails );
		if($sumQueryTotalFailsResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumQueryTotalFailsResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumQueryTotalFailsResults[] = $row;
		}

		$sumQueryTotalSucc = "SELECT Count(UserName) FROM [dbo].[Logon_Logoff_and_Failed_Logon_Profiles] WHERE UserName not like '%$%' AND Action like '%logon (%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumQueryTotalSuccResult = sqlsrv_query($conn, $sumQueryTotalSucc );
		if($sumQueryTotalSuccResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumQueryTotalSuccResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumQueryTotalSuccResults[] = $row;
		}

		$sumQueryTotalLocks = "SELECT Count(UserName) FROM [dbo].[Logon_Logoff_and_Failed_Logon_Profiles] WHERE UserName not like '%$%' AND Action like '%lock%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumQueryTotalLocksResult = sqlsrv_query($conn, $sumQueryTotalLocks );
		if($sumQueryTotalLocksResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumQueryTotalLocksResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumQueryTotalLocksResults[] = $row;
		}

		$sumQueryUnlocked = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%delete attribute%' AND AttributeAffected like '%lockout%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumUnlockedQueryResult = sqlsrv_query($conn, $sumQueryUnlocked );
		if($sumUnlockedQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumUnlockedQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumUnlockedResults[] = $row;
		}

		$sumQueryPwdLastSet = "SELECT Count(Action) FROM [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] Where AttributeAffected like '%pwdlastset%' AND Action like '%ad add attribute%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumPwdLastSetQueryResult = sqlsrv_query($conn, $sumQueryPwdLastSet );
		if($sumPwdLastSetQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumPwdLastSetQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumPwdLastSetResults[] = $row;
		}

		$sumQueryUserMods = "SELECT Count(Action) FROM [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] Where ObjectClass like '%user%' AND Action not like '%object%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumUserModsQueryResult = sqlsrv_query($conn, $sumQueryUserMods );
		if($sumUserModsQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumUserModsQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumUserModsResults[] = $row;
		}

	
	}

	// All Active Directory Queries
	
	if ($sumADRowCountResults[0][0] <= 0) {
	
		$setADSumDisplay = 'style="display: none;"';

	}

	if ($sumADRowCountResults[0][0] > 0) {

		// Get Data for Top 5 Active Directory Changes by Domain Controller (AD-BAR-1)
			
		$adBar1Query = "SELECT FromServer, Count(FromServer) FROM [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] WHERE (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE())) Group By FromServer Order By Count(FromServer) desc";
		$adBar1QueryResult = sqlsrv_query($conn, $adBar1Query);
		if($adBar1QueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adBar1QueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$adBar1QueryResults[] = $row;
		}

		// Get Data for All User, Group, Computer Changes (Line Chart) (AD-LINE)

		$adLineGroupQuery = "select TimeOccurred = d.Date, Count(ObjectClass) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.ObjectClass like 'group' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$adLineGroupQueryResult = sqlsrv_query($conn, $adLineGroupQuery );
		if($adLineGroupQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adLineGroupQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$adLineGroupQueryResults[] = $row;
		}

		$adLineUserQuery = "select TimeOccurred = d.Date, Count(ObjectClass) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.ObjectClass like 'user' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$adLineUserQueryResult = sqlsrv_query($conn, $adLineUserQuery );
		if($adLineUserQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adLineUserQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$adLineUserQueryResults[] = $row;
		}

		$adLineCompQuery = "select TimeOccurred = d.Date, Count(Action) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.Action like '%add attribute%' and l.AttributeAffected like '%lockout%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0)) and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$adLineCompQueryResult = sqlsrv_query($conn, $adLineCompQuery );
		if($adLineCompQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adLineCompQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$adLineCompQueryResults[] = $row;
		}

		// Get Data for User Status Changes Last 30 Days (Side Bar Chart) (AD-BAR-2)

		$adHBarQueryCreated = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%create object%' AND ObjectClass like '%user%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$adHBarQueryCreatedResult = sqlsrv_query($conn, $adHBarQueryCreated);
		if($adHBarQueryCreatedResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adHBarQueryCreatedResult,SQLSRV_FETCH_NUMERIC) ) {
			$adHBarQueryCreatedResults[] = $row;
		}

		$adHBarQueryDeleted = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%delete object%' AND ObjectClass like '%user%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$adHBarQueryDeletedResult = sqlsrv_query($conn, $adHBarQueryDeleted );
		if($adHBarQueryDeletedResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adHBarQueryDeletedResult,SQLSRV_FETCH_NUMERIC) ) {
			$adHBarQueryDeletedResults[] = $row;
		}

		$adHBarQueryDisabled = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%add attribute%' AND ObjectClass like '%user%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$adHBarQueryDisabledResult = sqlsrv_query($conn, $adHBarQueryDisabled );
		if($adHBarQueryDisabledResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adHBarQueryDisabledResult,SQLSRV_FETCH_NUMERIC) ) {
			$adHBarQueryDisabledResults[] = $row;
		}

		$adHBarQueryEnabled = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%delete attribute%' AND ObjectClass like '%user%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$adHBarQueryEnabledResult = sqlsrv_query($conn, $adHBarQueryEnabled );
		if($adHBarQueryEnabledResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adHBarQueryEnabledResult,SQLSRV_FETCH_NUMERIC) ) {
			$adHBarQueryEnabledResults[] = $row;
		}

		$adHBarQueryLocked = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%add attribute%' AND AttributeAffected like '%lockout%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$adHBarQueryLockedResult = sqlsrv_query($conn, $adHBarQueryLocked );
		if($adHBarQueryLockedResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adHBarQueryLockedResult,SQLSRV_FETCH_NUMERIC) ) {
			$adHBarQueryLockedResults[] = $row;
		}

		// Get Data for Group Changes Last 30 Days (Pie Chart) (AD-PIE)

		$adPieQueryGroupCreates = "SELECT Count(Action) FROM [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] Where Action like '%create object%' AND ObjectClass like '%group%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$adPieQueryGroupCreatesResult = sqlsrv_query($conn, $adPieQueryGroupCreates );
		if($adPieQueryGroupCreatesResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adPieQueryGroupCreatesResult,SQLSRV_FETCH_NUMERIC) ) {
			$adPieQueryGroupCreatesResults[] = $row;
		}

		$adPieQueryGroupDeletes = "SELECT Count(Action) FROM [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] Where Action like '%delete object%' AND ObjectClass like '%group%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$adPieQueryGroupDeletesResult = sqlsrv_query($conn, $adPieQueryGroupDeletes );
		if($adPieQueryGroupDeletesResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adPieQueryGroupDeletesResult,SQLSRV_FETCH_NUMERIC) ) {
			$adPieQueryGroupDeletesResults[] = $row;
		}

		$adPieQueryGroupMemAdd = "SELECT Count(Action) FROM [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] Where Action like '%ad add attribute%' AND ObjectClass like '%group%' AND AttributeAffected like '%member%' AND AttributeAffected not like '%memberof%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$adPieQueryGroupMemAddResult = sqlsrv_query($conn, $adPieQueryGroupMemAdd);
		if($adPieQueryGroupMemAddResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adPieQueryGroupMemAddResult,SQLSRV_FETCH_NUMERIC) ) {
			$adPieQueryGroupMemAddResults[] = $row;
		}

		$adPieQueryGroupMemRem = "SELECT Count(Action) FROM [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] Where Action like '%ad delete attribute%' AND ObjectClass like '%group%' AND AttributeAffected like '%member%' AND AttributeAffected not like '%memberof%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$adPieQueryGroupMemRemResult = sqlsrv_query($conn, $adPieQueryGroupMemRem );
		if($adPieQueryGroupMemRemResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($adPieQueryGroupMemRemResult,SQLSRV_FETCH_NUMERIC) ) {
			$adPieQueryGroupMemRemResults[] = $row;
		}

		// Total Computer Counts Last 30 Days Summary Report
			
		$sumQueryCompCreated = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%create object%' AND ObjectClass like '%computer%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumCompCreatedQueryResult = sqlsrv_query($conn, $sumQueryCompCreated );
		if($sumCompCreatedQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumCompCreatedQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumCompCreatedResults[] = $row;
		}

		$sumQueryCompDeleted = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%delete object%' AND ObjectClass like '%computer%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumCompDeletedQueryResult = sqlsrv_query($conn, $sumQueryCompDeleted );
		if($sumCompDeletedQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumCompDeletedQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumCompDeletedResults[] = $row;
		}

		$sumQueryCompDisabled = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%add attribute%' AND ObjectClass like '%computer%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumCompDisabledQueryResult = sqlsrv_query($conn, $sumQueryCompDisabled );
		if($sumCompDisabledQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumCompDisabledQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumCompDisabledResults[] = $row;
		}

		$sumQueryCompEnabled = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%delete attribute%' AND ObjectClass like '%computer%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumCompEnabledQueryResult = sqlsrv_query($conn, $sumQueryCompEnabled );
		if($sumCompEnabledQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumCompEnabledQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumCompEnabledResults[] = $row;
		}

		$sumQueryCompMods = "SELECT Count(Action) FROM [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] Where ObjectClass like '%Computer%' AND Action not like '%object%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumCompModsQueryResult = sqlsrv_query($conn, $sumQueryCompMods );
		if($sumCompModsQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumCompModsQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumCompModsResults[] = $row;
		}

		// Total OU Counts Last 30 Days Summary Report

		$sumQueryOUCreated = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%create object%' AND ObjectClass like '%organization%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumOUCreatedQueryResult = sqlsrv_query($conn, $sumQueryOUCreated );
		if($sumOUCreatedQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumOUCreatedQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumOUCreatedResults[] = $row;
		}

		$sumQueryOUDeleted = "SELECT Count(Action) FROM dbo.Active_Directory_Profiles WHERE Action like '%delete object%' AND ObjectClass like '%organization%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumOUDeletedQueryResult = sqlsrv_query($conn, $sumQueryOUDeleted );
		if($sumOUDeletedQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumOUDeletedQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumOUDeletedResults[] = $row;
		}

		$sumQueryOUMods = "SELECT Count(Action) FROM [CPTRAX_for_Windows].[dbo].[Active_Directory_Profiles] Where ObjectClass like '%organization%' AND Action not like '%object%'";
		$sumOUModsQueryResult = sqlsrv_query($conn, $sumQueryOUMods );
		if($sumOUModsQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumOUModsQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumOUModsResults[] = $row;
		}
	
	}

	// All File System Queries
	
	if ($sumFSRowCountResults[0][0] <= 0) {
	
		$setFSSumDisplay = 'style="display: none;"';

	}

	if ($sumFSRowCountResults[0][0] > 0) {

		// Get Data for All File System Activity Last 30 Days (Line Chart) (Creates,Deletes,Renames/Moves,Permissions Changes) (FS-LINE)
			
		$fsLineCreateQuery = "select TimeOccurred = d.Date, Count(Action) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[File_System_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.Action like '%create%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$fsLineCreateQueryResult = sqlsrv_query($conn, $fsLineCreateQuery );
		if($fsLineCreateQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($fsLineCreateQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$fsLineCreateQueryResults[] = $row;
		}

		$fsLineDeleteQuery = "select TimeOccurred = d.Date, Count(Action) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[File_System_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.Action like '%delete%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$fsLineDeleteQueryResult = sqlsrv_query($conn, $fsLineDeleteQuery );
		if($fsLineDeleteQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($fsLineDeleteQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$fsLineDeleteQueryResults[] = $row;
		}

		$fsLineRenameQuery = "select TimeOccurred = d.Date, Count(Action) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[File_System_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.Action like '%rename%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$fsLineRenameQueryResult = sqlsrv_query($conn, $fsLineRenameQuery );
		if($fsLineRenameQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($fsLineRenameQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$fsLineRenameQueryResults[] = $row;
		}

		$fsLinePermQuery = "select TimeOccurred = d.Date, Count(Action) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[File_System_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.Action like '%ACL%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$fsLinePermQueryResult = sqlsrv_query($conn, $fsLinePermQuery );
		if($fsLinePermQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($fsLinePermQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$fsLinePermQueryResults[] = $row;
		}

		// Get Data for Top 5 File System Users (Up Bar Chart) (FS-BAR-1)

		$fsBarTop5Query = "SELECT UserName, Count(UserName) FROM [CPTRAX_for_Windows].[dbo].[File_System_Profiles] WHERE UserName not like '%$%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE())) Group By UserName Order By Count(UserName) desc";
		$fsBarTop5QueryResult = sqlsrv_query($conn, $fsBarTop5Query );
		if($fsBarTop5QueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($fsBarTop5QueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$fsBarTop5QueryResults[] = $row;
		}

		// Get Data for Top 5 File System Events per Server (Side Bar Chart) (FS-BAR-2)

		$fsHBarTop5Query = "SELECT FromServer, Count(FromServer) FROM [CPTRAX_for_Windows].[dbo].[File_System_Profiles] WHERE (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE())) Group By FromServer Order By Count(FromServer) desc";
		$fsHBarTop5QueryResult = sqlsrv_query($conn, $fsHBarTop5Query);
		if($fsHBarTop5QueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($fsHBarTop5QueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$fsHBarTop5QueryResults[] = $row;
		}

		// Get Data for File System Events Pie Chart

		$pieQueryWrites = "SELECT Count(Action) FROM dbo.File_System_Profiles WHERE Action like '%write%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$pieWritesQueryResult = sqlsrv_query($conn, $pieQueryWrites );
		if($pieWritesQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($pieWritesQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$pieWritesResults[] = $row;
		}

		$pieQueryRenames = "SELECT Count(Action) FROM dbo.File_System_Profiles WHERE Action like '%rename%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$pieRenamesQueryResult = sqlsrv_query($conn, $pieQueryRenames );
		if($pieRenamesQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($pieRenamesQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$pieRenamesResults[] = $row;
		}

		$pieQueryCreates = "SELECT Count(Action) FROM dbo.File_System_Profiles WHERE Action like '%create%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$pieCreatesQueryResult = sqlsrv_query($conn, $pieQueryCreates );
		if($pieCreatesQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($pieCreatesQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$pieCreatesResults[] = $row;
		}

		$pieQueryDeletes = "SELECT Count(Action) FROM dbo.File_System_Profiles WHERE Action like '%delete%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$pieDeletesQueryResult = sqlsrv_query($conn, $pieQueryDeletes );
		if($pieDeletesQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($pieDeletesQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$pieDeletesResults[] = $row;
		}

		$pieQueryPerms = "SELECT Count(Action) FROM dbo.File_System_Profiles WHERE Action like '%acl%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$piePermsQueryResult = sqlsrv_query($conn, $pieQueryPerms );
		if($piePermsQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($piePermsQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$piePermsResults[] = $row;
		}

		// Total Workstation File System Counts Last 30 Days Summary Report
			
		$sumQueryCopyRemove = "SELECT Count(Action) FROM dbo.File_System_Profiles WHERE Action like '%removable%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumCopyRemoveQueryResult = sqlsrv_query($conn, $sumQueryCopyRemove );
		if($sumCopyRemoveQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumCopyRemoveQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumCopyRemoveResults[] = $row;
		}

		$sumQueryBrowserAccess = "SELECT Count(Action) FROM dbo.File_System_Profiles WHERE (ShareName like '%chrome%' OR ShareName like '%firefox%' OR ShareName like '%iexplore%' OR ShareName like '%pickerhost%') AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumBrowserAccessQueryResult = sqlsrv_query($conn, $sumQueryBrowserAccess );
		if($sumBrowserAccessQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumBrowserAccessQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumBrowserAccessResults[] = $row;
		}

		$sumQueryBlocked = "SELECT Count(Action) FROM dbo.File_System_Profiles WHERE (Action like '%blocked Copy%' OR Action like '%block delete%') AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumBlockedQueryResult = sqlsrv_query($conn, $sumQueryBlocked );
		if($sumBlockedQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumBlockedQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumBlockedResults[] = $row;
		}

		$sumQueryCopyLocal = "SELECT Count(Action) FROM dbo.File_System_Profiles WHERE Action like '%Copy from Unc to Local%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumCopyLocalQueryResult = sqlsrv_query($conn, $sumQueryCopyLocal );
		if($sumCopyLocalQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumCopyLocalQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumCopyLocalResults[] = $row;
		}
	
	}

	// All Group Policy Queries
	
	if ($sumGPOADRowCountResults[0][0] <= 0) {
	
		$setGPOADSumDisplay = 'style="display: none;"';

	}

	if ($sumGPOADRowCountResults[0][0] > 0) {

		// Get Data for All GPO Changes for Last 30 Days (Line Chart) (GPO-LINE)
			
		$gpoLineCreateQuery = "select TimeOccurred = d.Date, Count(Action) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[GPO_Active_Directory_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.Action like '%create object%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$gpoLineCreateQueryResult = sqlsrv_query($conn, $gpoLineCreateQuery );
		if($gpoLineCreateQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($gpoLineCreateQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$gpoLineCreateQueryResults[] = $row;
		}

		$gpoLineDeleteQuery = "select TimeOccurred = d.Date, Count(Action) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[GPO_Active_Directory_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.Action like '%delete object%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$gpoLineDeleteQueryResult = sqlsrv_query($conn, $gpoLineDeleteQuery );
		if($adLineUserQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($gpoLineDeleteQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$gpoLineDeleteQueryResults[] = $row;
		}

		$gpoLineLinkQuery = "select TimeOccurred = d.Date, Count(AttributeAffected) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[GPO_Active_Directory_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.AttributeAffected like '%gplink%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$gpoLineLinkQueryResult = sqlsrv_query($conn, $gpoLineLinkQuery );
		if($adLineCompQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($gpoLineLinkQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$gpoLineLinkQueryResults[] = $row;
		}

		$gpoLineModifyQuery = "select TimeOccurred = d.Date, Count(Action) from CPTRAX_DB_Dates d left join [CPTRAX_for_Windows].[dbo].[GPO_Active_Directory_Profiles] l on d.Date = convert(date,l.TimeOccurred) and l.Action not like '%create object%' and l.Action not like '%delete object%' where d.Date >= dateadd(day, -".$numOfDays.", dateadd(day, datediff(day, 0, getdate()), 0))  and d.Date <= dateadd(day, 0, getdate()) group by d.Date order by d.Date";
		$gpoLineModifyQueryResult = sqlsrv_query($conn, $gpoLineModifyQuery );
		if($gpoLineModifyQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($gpoLineModifyQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$gpoLineModifyQueryResults[] = $row;
		}

		// Get Data for GPO Events by DC (Up Bar Chart) (GPO-BAR-1)

		$gpoBarPerDCQuery = "SELECT FromServer, Count(FromServer) FROM [CPTRAX_for_Windows].[dbo].[GPO_Active_Directory_Profiles] WHERE (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE())) Group By FromServer Order By Count(FromServer) desc";
		$gpoBarPerDCQueryResult = sqlsrv_query($conn, $gpoBarPerDCQuery);
		if($gpoBarPerDCQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($gpoBarPerDCQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$gpoBarPerDCQueryResults[] = $row;
		}

		// Get Data for GPO Events by User (Side Bar Chart) (GPO-BAR-2)

		$gpoBar2PerUserQuery = "SELECT PerformedByUserName, Count(PerformedByUserName) FROM [CPTRAX_for_Windows].[dbo].[GPO_Active_Directory_Profiles] WHERE (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE())) Group By PerformedByUserName Order By Count(PerformedByUserName) desc";
		$gpoBar2PerUserQueryResult = sqlsrv_query($conn, $gpoBar2PerUserQuery);
		if($gpoBar2PerUserQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($gpoBar2PerUserQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$gpoBar2PerUserQueryResults[] = $row;
		}

		// Total GPO Counts Last 30 Days Summary Report
			
		$sumQueryGPOCreated = "SELECT Count(Action) FROM dbo.GPO_Active_Directory_Profiles WHERE Action like '%create object%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumGPOCreatedQueryResult = sqlsrv_query($conn, $sumQueryGPOCreated );
		if($sumGPOCreatedQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumGPOCreatedQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumGPOCreatedResults[] = $row;
		}

		$sumQueryGPODeleted = "SELECT Count(Action) FROM dbo.GPO_Active_Directory_Profiles WHERE Action like '%delete object%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumGPODeletedQueryResult = sqlsrv_query($conn, $sumQueryGPODeleted );
		if($sumGPODeletedQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumGPODeletedQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumGPODeletedResults[] = $row;
		}

		$sumQueryGPOMods = "SELECT Count(Action) FROM dbo.GPO_Active_Directory_Profiles WHERE Action not like '%delete object%' AND Action not like '%create object%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumGPOModsQueryResult = sqlsrv_query($conn, $sumQueryGPOMods );
		if($sumGPOModsQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumGPOModsQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumGPOModsResults[] = $row;
		}

		$sumQueryGPOLinks = "SELECT Count(Action) FROM Active_Directory_Profiles WHERE AttributeAffected like '%gplink%' AND (TimeOccurred >= DATEADD(DAY,-".$numOfDays.",GETDATE()) AND TimeOccurred <= DATEADD(DAY,0,GETDATE()))";
		$sumGPOLinksQueryResult = sqlsrv_query($conn, $sumQueryGPOLinks );
		if($sumGPOLinksQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumGPOLinksQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumGPOLinksResults[] = $row;
		}

		$sumQueryGPODGPO = "SELECT Count(dbo.GPO_File_System_Profiles.GPODisplayName) FROM dbo.GPO_File_System_Profiles JOIN dbo.GPO_Active_Directory_Profiles ON (dbo.GPO_File_System_Profiles.GPODisplayName = dbo.GPO_Active_Directory_Profiles.GPODisplayName) WHERE dbo.GPO_File_System_Profiles.GPODisplayName like '%default domain%' AND (DATEDIFF(day,dbo.GPO_File_System_Profiles.TimeOccurred,getdate()) between 0 and 30)";
		$sumGPODGPOQueryResult = sqlsrv_query($conn, $sumQueryGPODGPO );
		if($sumGPODGPOQueryResult === false){
			die( print_r( sqlsrv_errors(), true));
		}
		while( $row = sqlsrv_fetch_array($sumGPODGPOQueryResult,SQLSRV_FETCH_NUMERIC) ) {
			$sumGPODGPOResults[] = $row;
		}
	
	}

?>