<?php

	if (isset($cannedFilter)) {
		
		switch ($cannedFilter) {
			case "Administrative Group Changes":
				if ( $where == "" ) {
					$where = "WHERE (ObjectClass like '%group%' AND (ObjectAffected like '%domain admins%' OR ObjectAffected like '%Enterprise Admins%' OR ObjectAffected like '%Schema Admins%' OR ObjectAffected like '%Account Operators%' OR ObjectAffected like '%Server Operators%' ObjectAffected like '%Backup Operators%')";
				}
				else {
					$where .= " AND ObjectClass like '%group%' AND (ObjectAffected like '%domain admins%' OR ObjectAffected like '%Enterprise Admins%' OR ObjectAffected like '%Schema Admins%' OR ObjectAffected like '%Account Operators%' OR ObjectAffected like '%Server Operators%' OR ObjectAffected like '%Backup Operators%')";
				}
				break;
			case "All Organizational Unit Changes":
				if ( $where == "" ) {
					$where = "WHERE ObjectClass like '%organizationalUnit%'";
				}
				else {
					$where .= " AND ObjectClass like '%organizationalUnit%'";
				}
				break;
			case "All User Account Status Changes":
				if ( $where == "" ) {
					$where = "WHERE ObjectClass like '%user%' AND (AttributeAffected like '%lockout%' OR AdditionalDetailRegardingSelectedAttributes like '%disabled%')";
				}
				else {
					$where .= " AND ObjectClass like '%user%' AND (AttributeAffected like '%lockout%' OR AdditionalDetailRegardingSelectedAttributes like '%disabled%')";
				}
				break;
			case "All User Account Changes":
				if ( $where == "" ) {
					$where = "WHERE ObjectClass like '%user%'";
				}
				else {
					$where .= " AND ObjectClass like '%user%'";
				}
				break;
			case "All Computer Account Changes":
				if ( $where == "" ) {
					$where = "WHERE ObjectClass like '%computer%'";
				}
				else {
					$where .= " AND ObjectClass like '%computer%'";
				}
				break;
			case "All Contact Changes":
				if ( $where == "" ) {
					$where = "WHERE ObjectClass like '%contact%'";
				}
				else {
					$where .= " AND ObjectClass like '%contact%'";
				}
				break;
			case "Active Directory Security Changes":
				if ( $where == "" ) {
					$where = "WHERE AttributeAffected like '%ntSecurityDescriptor%'";
				}
				else {
					$where .= " AND AttributeAffected like '%ntSecurityDescriptor%'";
				}
				break;
				case "Password Changes":
				if ( $where == "" ) {
					$where = "WHERE AttributeAffected like '%pwdLastSet%'";
				}
				else {
					$where .= " AND AttributeAffected like '%pwdLastSet%'";
				}
				break;
			case "User Accounts Created":
				if ( $where == "" ) {
					$where = "WHERE Action like '%create object%' AND ObjectClass like '%user%'";
				}
				else {
					$where .= " AND Action like '%create object%' AND ObjectClass like '%user%'";
				}
				break;
			case "User Accounts Deleted":
				if ( $where == "" ) {
					$where = "WHERE Action like '%delete object%' AND ObjectClass like '%user%'";
				}
				else {
					$where .= " AND Action like '%delete object%' AND ObjectClass like '%user%'";
				}
				break;
			case "User Accounts Locked Out":
				if ( $where == "" ) {
					$where = "WHERE Action like '%ad add attribute value%' AND ObjectClass like '%user%' AND AttributeAffected like '%lockouttime%'";
				}
				else {
					$where .= " AND Action like '%ad add attribute value%' AND ObjectClass like '%user%' AND AttributeAffected like '%lockouttime%'";
				}
				break;
			case "User Accounts Disabled":
				if ( $where == "" ) {
					$where = "WHERE Action like '%ad add attribute value%' AND ObjectClass like '%user%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%'";
				}
				else {
					$where .= " AND Action like '%ad add attribute value%' AND ObjectClass like '%user%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%'";
				}
				break;
			case "User Accounts Enabled":
				if ( $where == "" ) {
					$where = "WHERE Action like '%ad delete attribute value%' AND ObjectClass like '%user%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%'";
				}
				else {
					$where .= " AND Action like '%ad delete attribute value%' AND ObjectClass like '%user%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%'";
				}
				break;
			case "Computer Accounts Disabled":
				if ( $where == "" ) {
					$where = "WHERE Action like '%ad add attribute value%' AND ObjectClass like '%computer%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%'";
				}
				else {
					$where .= " AND Action like '%ad add attribute value%' AND ObjectClass like '%computer%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%'";
				}
				break;
			case "Computer Accounts Enabled":
				if ( $where == "" ) {
					$where = "WHERE Action like '%ad delete attribute value%' AND ObjectClass like '%computer%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%'";
				}
				else {
					$where .= " AND Action like '%ad delete attribute value%' AND ObjectClass like '%computer%' AND AdditionalDetailRegardingSelectedAttributes like '%disabled%'";
				}
				break;
			case "All Group Changes":
				if ( $where == "" ) {
					$where = "WHERE ObjectClass like '%group%'";
				}
				else {
					$where .= " AND ObjectClass like '%group%'";
				}
				break;
			case "Groups Created":
				if ( $where == "" ) {
					$where = "WHERE Action like '%create object%' AND ObjectClass like '%group%'";
				}
				else {
					$where .= " AND Action like '%create object%' AND ObjectClass like '%group%'";
				}
				break;
			case "Groups Deleted":
				if ( $where == "" ) {
					$where = "WHERE Action like '%delete object%' AND ObjectClass like '%group%'";
				}
				else {
					$where .= " AND Action like '%delete object%' AND ObjectClass like '%group%'";
				}
				break;
			case "Group Membership Changes":
				if ( $where == "" ) {
					$where = "WHERE ObjectClass like '%group%' AND AttributeAffected like 'member'";
				}
				else {
					$where .= " AND ObjectClass like '%group%' AND AttributeAffected like 'member'";
				}
				break;
			case "Computer Accounts Created":
				if ( $where == "" ) {
					$where = "WHERE Action like '%create object%' AND ObjectClass like '%computer%'";
				}
				else {
					$where .= " AND Action like '%create object%' AND ObjectClass like '%computer%'";
				}
				break;
			case "Computer Accounts Deleted":
				if ( $where == "" ) {
					$where = "WHERE Action like '%delete object%' AND ObjectClass like '%computer%'";
				}
				else {
					$where .= " AND Action like '%delete object%' AND ObjectClass like '%computer%'";
				}
				break;
			case "Created Files":
				if ( $where == "" ) {
					$where = "WHERE Action like '%create file%'";
				}
				else {
					$where .= " AND Action like '%create file%'";
				}
				break;
			case "Deleted Files":
				if ( $where == "" ) {
					$where = "WHERE Action like '%delete%' AND isDirectory like '%false%'";
				}
				else {
					$where .= " AND Action like '%delete%' AND isDirectory like '%false%'";
				}
				break;
			case "Renamed Files":
				if ( $where == "" ) {
					$where = "WHERE Action like '%rename%' AND isDirectory like '%false%'";
				}
				else {
					$where .= " AND Action like '%rename%' AND isDirectory like '%false%'";
				}
				break;
			case "Permissions Changes":
				if ( $where == "" ) {
					$where = "WHERE Action like '%ACL%'";
				}
				else {
					$where .= " AND Action like '%ACL%'";
				}
				break;
			case "Created Folders":
				if ( $where == "" ) {
					$where = "WHERE Action like '%create folder%'";
				}
				else {
					$where .= " AND Action like '%create folder%'";
				}
				break;
			case "Created Files and Folders":
				if ( $where == "" ) {
					$where = "WHERE Action like '%create%'";
				}
				else {
					$where .= " AND Action like '%create%'";
				}
				break;
			case "Deleted Files and Folders":
				if ( $where == "" ) {
					$where = "WHERE Action like '%delete%'";
				}
				else {
					$where .= " AND Action like '%delete%'";
				}
				break;
			case "All File Changes":
				if ( $where == "" ) {
					$where = "WHERE isDirectory like '%false%'";
				}
				else {
					$where .= " AND isDirectory like '%false%'";
				}
				break;
			case "All Folder Changes":
				if ( $where == "" ) {
					$where = "WHERE isDirectory like '%true%'";
				}
				else {
					$where .= " AND isDirectory like '%true%'";
				}
				break;
			case "Deleted Folders":
				if ( $where == "" ) {
					$where = "WHERE Action like '%delete%' AND isDirectory like '%true%'";
				}
				else {
					$where .= " AND Action like '%delete%' AND isDirectory like '%true%'";
				}
				break;
			case "Renamed Folders":
				if ( $where == "" ) {
					$where = "WHERE Action like '%rename%' AND isDirectory like '%true%'";
				}
				else {
					$where .= " AND Action like '%rename%' AND isDirectory like '%true%'";
				}
				break;
			case "Files Copied from UNC to Local Device":
				if ( $where == "" ) {
					$where = "WHERE Action like '%copy%unc%'";
				}
				else {
					$where .= " AND Action like '%copy%unc%'";
				}
				break;
			case "Files Copied from Local to Local Device":
				if ( $where == "" ) {
					$where = "WHERE Action like '%copy%local%local%'";
				}
				else {
					$where .= " AND Action like '%copy%local%local%'";
				}
				break;
			case "Files Copied to Removable Device":
				if ( $where == "" ) {
					$where = "WHERE Action like '%copy%removable%'";
				}
				else {
					$where .= " AND Action like '%copy%removable%'";
				}
				break;
			case "Files Created on Removable Device":
				if ( $where == "" ) {
					$where = "WHERE Action like '%create%removable%'";
				}
				else {
					$where .= " AND Action like '%create%removable%'";
				}
				break;
			case "Files Deleted from Removable Device":
				if ( $where == "" ) {
					$where = "WHERE Action like '%delete%removable%'";
				}
				else {
					$where .= " AND Action like '%delete%removable%'";
				}
				break;
			case "Removable Found at Startup":
				if ( $where == "" ) {
					$where = "WHERE Action like '%startup%'";
				}
				else {
					$where .= " AND Action like '%startup%'";
				}
				break;
			case "Removable Connected":
				if ( $where == "" ) {
					$where = "WHERE Action like '%connected%'";
				}
				else {
					$where .= " AND Action like '%connected%'";
				}
				break;
			case "Removable Ejected":
				if ( $where == "" ) {
					$where = "WHERE Action like '%ejected%'";
				}
				else {
					$where .= " AND Action like '%ejected%'";
				}
				break;
			case "Files Accessed By Web Browsers":
				if ( $where == "" ) {
					$where = "WHERE Action like '%unexpected%' AND (ShareName like '%chrome%' OR ShareName like '%firefox%' OR ShareNAme like '%iexplore%' OR ShareName like '%pickerhost%')";
				}
				else {
					$where .= " AND Action like '%unexpected%' AND (ShareName like '%chrome%' OR ShareName like '%firefox%' OR ShareNAme like '%iexplore%' OR ShareName like '%pickerhost%')";
				}
				break;
			case "Processes Accessing Unexpected Files":
				if ( $where == "" ) {
					$where = "WHERE Action like '%unexpected%'";
				}
				else {
					$where .= " AND Action like '%unexpected%'";
				}
				break;
			case "Failed Authentication History":
				if ( $where == "" ) {
					$where = "WHERE Action like '%failed%'";
				}
				else {
					$where .= " AND Action like '%failed%'";
				}
				break;
			case "Failed Authentications - Bad Password":
				if ( $where == "" ) {
					$where = "WHERE Action like '%failed%' AND FailCodeText like '%bad password%'";
				}
				else {
					$where .= " AND Action like '%failed%' AND FailCodeText like '%bad password%'";
				}
				break;
			case "Workstation Locks & Unlocks":
				if ( $where == "" ) {
					$where = "WHERE Action like '%lock%'";
				}
				else {
					$where .= " AND Action like '%lock%'";
				}
				break;
			case "Default Domain Policy Changes":
				if ( $where == "" ) {
					$where = "WHERE GPODisplayName like '%default domain%'";
				}
				else {
					$where .= " AND GPODisplayName like '%default domain%'";
				}
				break;
		}
	}

?>