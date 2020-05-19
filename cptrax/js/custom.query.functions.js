// All JS Functions required for the custom query.

// Global Variables for various functions

// Create Arrays for each Activity Type with all applicable columns for the filter column drop down
var filterLists = new Array(6) 
filterLists["empty"] = ["Select an Activity Type"]; 
filterLists["Logon_Logoff_and_Failed_Logon_Profiles"] = ["FromServer", "RecType", "ProfileName", "Action", "FailCodeValue", "FailCodeText", "IPv4From", "IPv6From", "NumberOfSecondsLoggedOn", "UserName", "UserLDAPName", "UserSID", "TSUserName", "TSStation", "TSRemoteAddr", "TSSessionName", "LogonDomain", "LogonZone"]; 
filterLists["File_System_Profiles"] = ["FromServer", "RecType", "ProfileName", "Action", "UserName", "UserLDAPName", "TSStation", "TSRemoteAddr", "UserSID", "IPv4From", "IPv6From", "isDirectory", "wasBlocked", "ACEtype", "FullFilePath", "ShareName", "FileNameOnly", "NewPathName", "SIDOfNewOwner", "ACLObjectLDAPName", "ACLObjectDomain", "ACLObjectName", "ACLMask", "ACLFlags", "ACLObjectType"]; 
filterLists["Active_Directory_Profiles"] = ["FromServer", "RecType", "ProfileName", "Action", "ObjectClass", "ObjectAffected", "ObjectNewName", "AttributeAffected", "WasAttributeRemoved", "AttributeValueAdded", "AdditionalDetailRegardingSelectedAttributes", "AttributeValueRemoved", "PerformedByUserName", "TSStation", "TSRemoteAddr", "IPv4From", "IPv6From"]; 
filterLists["GPO_Active_Directory_Profiles"] = ["FromServer", "RecType", "ProfileName", "Action", "GPODisplayName", "GPOGuid", "ObjectClass", "ObjectAffected", "ObjectNewName", "AttributeAffected", "WasAttributeRemoved", "AttributeValueAdded", "AdditionalDetailRegardingSelectedAttributes", "AttributeValueRemoved", "PerformedByUserName", "TSStation", "TSRemoteAddr", "IPv4From", "IPv6From", "GPOADSectionName", "GPOADChangeAction", "GPOADChangeDetails"];
filterLists["GPO_File_System_Profiles" ]= ["FromServer", "RecType", "ProfileName", "Action", "UserName", "UserLDAPName", "TSStation", "TSRemoteAddr", "UserSID", "IPv4From", "IPv6From", "GPODisplayName", "GPOGuid", "isDirectory", "isGPOCoreFile", "GPOPolicyFilePath", "GPOFullLocalFilePath", "GPOPolicyFileName", "NewFilePathName", "GPOChangeDescription", "ShareName", "GPOFileSectionName", "GPOFileChangeAction", "GPOFileSectionParameterName", "GPOFileSectionOther", "GPOFileSectionValue01", "GPOFileSectionValue02", "GPOFileSectionString", "GPOFileSectionStringSubValue"];

// Create Arrays for each Activity Type with the available columns
var availableColumnsList = new Array(6) 
availableColumnsList["empty"] = ["Select an Activity Type"]; 
availableColumnsList["Logon_Logoff_and_Failed_Logon_Profiles"] = ["RecType", "ProfileName", "FailCodeValue", "IPv6From", "LogonTime", "LogoffTime", "NumberOfSecondsLoggedOn", "UserLDAPName", "UserSID", "TSUserName", "TSStation", "TSRemoteAddr", "TSSessionName", "LogonDomain", "LogonZone"]; 
availableColumnsList["File_System_Profiles"] = ["RecType", "ProfileName", "UserLDAPName", "TSStation", "TSRemoteAddr", "UserSID", "IPv6From", "isDirectory", "wasBlocked", "ACEtype", "SIDOfNewOwner", "ACLObjectLDAPName", "ACLObjectDomain", "ACLObjectName", "ACLMask", "ACLFlags", "ACLObjectType"]; 
availableColumnsList["Active_Directory_Profiles"] = ["RecType", "ProfileName", "ObjectNewName", "WasAttributeRemoved", "TSStation", "TSRemoteAddr", "IPv6From"]; 
availableColumnsList["GPO_Active_Directory_Profiles"] = ["RecType", "ProfileName", "GPOGuid", "ObjectClass", "ObjectAffected", "ObjectNewName", "AttributeAffected", "WasAttributeRemoved", "AttributeValueAdded", "AdditionalDetailRegardingSelectedAttributes", "AttributeValueRemoved", "TSStation", "TSRemoteAddr", "IPv6From", "GPOADSectionName", "GPOADChangeAction"];
availableColumnsList["GPO_File_System_Profiles"] = ["RecType", "ProfileName", "UserLDAPName", "TSStation", "TSRemoteAddr", "UserSID", "IPv6From", "GPOGuid", "isDirectory", "isGPOCoreFile", "GPOPolicyFilePath", "GPOFullLocalFilePath", "GPOPolicyFileName", "NewFilePathName", "GPOChangeDescription", "ShareName", "GPOFileSectionName", "GPOFileSectionOther", "GPOFileSectionValue01", "GPOFileSectionValue02", "GPOFileSectionString", "GPOFileSectionStringSubValue"];

//Create Arrays for each Activity Type with the selected columns
var selectedColumnsList = new Array(6) 
selectedColumnsList["empty"] = ["Select an Activity Type"]; 
selectedColumnsList["Logon_Logoff_and_Failed_Logon_Profiles"] = ["Action", "TimeOccurred", "FailCodeText", "UserName", "IPv4From", "FromServer"]; 
selectedColumnsList["File_System_Profiles"] = ["Action", "TimeOccurred", "UserName", "IPv4From", "ShareName", "FullFilePath", "FileNameOnly", "NewPathName", "FromServer"]; 
selectedColumnsList["Active_Directory_Profiles"] = ["Action", "TimeOccurred", "PerformedByUserName", "IPv4From", "ObjectAffected", "ObjectClass", "AttributeAffected", "AttributeValueAdded", "AttributeValueRemoved", "AdditionalDetailRegardingSelectedAttributes", "FromServer"]; 
selectedColumnsList["GPO_Active_Directory_Profiles"] = ["Action", "TimeOccurred", "PerformedByUserName", "IPv4From", "GPODisplayName", "GPOADChangeDetails", "FromServer"];
selectedColumnsList["GPO_File_System_Profiles"] = ["Action", "TimeOccurred", "UserName", "IPv4From", "GPODisplayName", "GPOFileChangeAction", "GPOFileSectionParameterName", "FromServer"];

// Function to create the list of available columns for the custom query - Based on Activity Type
function buildSelectedColumns(selectObj) {
				
	var index = selectObj.selectIndex;
				
	var index = selectObj.selectedIndex;  
	var whichIndex = selectObj.options[index].value; 

	cList = selectedColumnsList[whichIndex]; 

	var cSelect = document.getElementById("selectedcolumns"); 
	var len=cSelect.options.length; 
 
	while (cSelect.options.length > 0) { cSelect.remove(0); } 
 
	var newOption; 

	for (var i=0; i<cList.length; i++) { 
		newOption = document.createElement("option"); 
		newOption.value = cList[i];
		newOption.text=cList[i];

		try { cSelect.add(newOption); } 
		catch (e) { cSelect.appendChild(newOption); } 
	}
}

// Function to create the list of available columns for the custom query - Based on Activity Type
function buildAvailableColumns(selectObj) {
				
	var index = selectObj.selectIndex;
				
	var index = selectObj.selectedIndex;  
	var whichIndex = selectObj.options[index].value;

	cList = availableColumnsList[whichIndex]; 

	var cSelect = document.getElementById("availablecolumns"); 
	var len=cSelect.options.length; 
 
	while (cSelect.options.length > 0) { cSelect.remove(0); } 
 
	var newOption; 

	for (var i=0; i<cList.length; i++) { 
		newOption = document.createElement("option"); 
		newOption.value = cList[i];
		newOption.text=cList[i]; 

		try { cSelect.add(newOption); } 
		catch (e) { cSelect.appendChild(newOption); } 
	}
}

// Function to modify the columns that appear in the filter column drop down for the custom query - Based on Activity Type
function buildFilterColumns(selectObj) { 
	var index = selectObj.selectedIndex;  
	var whichIndex = selectObj.options[index].value; 

	cList = filterLists[whichIndex]; 

	var cSelect = document.getElementById("filtercolumn"); 
	var len=cSelect.options.length; 
 
	while (cSelect.options.length > 0) { cSelect.remove(0); } 
 
	var newOption; 

	for (var i=0; i<cList.length; i++) { 
		newOption = document.createElement("option"); 
		newOption.value = cList[i];
		newOption.text=cList[i]; 

		try { cSelect.add(newOption); } 
		catch (e) { cSelect.appendChild(newOption); } 
	} 
}

// Function to add all columns to the Selected Columns list for the custom query
function addalltoselectedcolumns() {
	var availableColumnsElement = document.getElementById('availablecolumns');
	var length = availableColumnsElement.length;
	var selectedColumnsElement = document.getElementById('selectedcolumns');
	for (var i=0; i<length; i++) {
		if (availableColumnsElement[i]) {
			var oneUse = availableColumnsElement.options[i].text;
			var oneUse1 = availableColumnsElement.options[i].value;
			availableColumnsElement.remove(i);i--;
			var optionElement = document.createElement('option');
			optionElement.text=oneUse;
			try {selectedColumnsElement.add(optionElement,null);}
			catch (ex) { selectedColumnsElement.add(optionElement); }
		}
	}
}

// Function to remove all columns from the Selected Columns list for the custom query	
function remallfromselectcolumns(){
	var availableColumnsElement = document.getElementById('availablecolumns');
	var selectedColumnsElement = document.getElementById('selectedcolumns');
	var length = selectedColumnsElement.length;
	for (var i=0; i<length; i++) {
		if (selectedColumnsElement[i]) {
			var oneUse = selectedColumnsElement.options[i].text;
			var oneUse1 = selectedColumnsElement.options[i].value;
			selectedColumnsElement.remove(i); i--;
			var optionElement = document.createElement('option');
			optionElement.text=oneUse;
			try	{ availableColumnsElement.add(optionElement,null); }
			catch (ex) { availableColumnsElement.add(optionElement); }
		}
	}
}

// Function to add columns to the Selected Columns list for the custom query
function addtoselectedcolumns() {
	var availableColumnsElement = document.getElementById('availablecolumns');
	var length = availableColumnsElement.length;
	var selectedColumnsElement = document.getElementById('selectedcolumns');
	for (var i=0; i<length; i++) {
		if (availableColumnsElement[i].selected) {
			var oneUse = availableColumnsElement.options[i].text;
			var oneUse1 = availableColumnsElement.options[i].value;
			availableColumnsElement.remove(i);i--;
			var optionElement = document.createElement('option');
			optionElement.text=oneUse;
			try {selectedColumnsElement.add(optionElement,null);}
			catch (ex) { selectedColumnsElement.add(optionElement); }
		}
	}
}

// Function to remove columns from the Selected Columns list for the custom query	
function remfromselectcolumns(){
	
	var availableColumnsElement = document.getElementById('availablecolumns');
	var selectedColumnsElement = document.getElementById('selectedcolumns');
	var length = selectedColumnsElement.length;
	for (var i=0; i<length; i++) {
		if (selectedColumnsElement[i].selected) {
			var oneUse = selectedColumnsElement.options[i].text;
			var oneUse1 = selectedColumnsElement.options[i].value;
			selectedColumnsElement.remove(i); i--;
			var optionElement = document.createElement('option');
			optionElement.text=oneUse;
			try	{ availableColumnsElement.add(optionElement,null); }
			catch (ex) { availableColumnsElement.add(optionElement); }
		}
	}
}

// Function to move items up in the Selected Columns List
function moveupselectedcolumns() {
	
	var ddl = document.getElementById('selectedcolumns');
	var selectedItems = new Array();
	var temp = {innerHTML:null, value:null};
	for(var i = 0; i < ddl.length; i++)
		if(ddl.options[i].selected)             
			selectedItems.push(i);

	if(selectedItems.length > 0)    
		if(selectedItems[0] != 0)
			for(var i = 0; i < selectedItems.length; i++)
			{
				temp.innerHTML = ddl.options[selectedItems[i]].innerHTML;
				temp.value = ddl.options[selectedItems[i]].value;
				ddl.options[selectedItems[i]].innerHTML = ddl.options[selectedItems[i] - 1].innerHTML;
				ddl.options[selectedItems[i]].value = ddl.options[selectedItems[i] - 1].value;
				ddl.options[selectedItems[i] - 1].innerHTML = temp.innerHTML; 
				ddl.options[selectedItems[i] - 1].value = temp.value; 
				ddl.options[selectedItems[i] - 1].selected = true;
				ddl.options[selectedItems[i]].selected = false;
			}
			
}

// Function to move items down in the Selected Columns List
function movedownselectedcolumns() {
	
	var ddl = document.getElementById('selectedcolumns');
	//var size = ddl.length;
	//var index = ddl.selectedIndex;
	var selectedItems = new Array();
	var temp = {innerHTML:null, value:null};
	for(var i = 0; i < ddl.length; i++)
		if(ddl.options[i].selected)             
			selectedItems.push(i);

	if(selectedItems.length > 0)    
		if(selectedItems[selectedItems.length - 1] != ddl.length - 1)
			for(var i = selectedItems.length - 1; i >= 0; i--)
			{
				temp.innerHTML = ddl.options[selectedItems[i]].innerHTML;
				temp.value = ddl.options[selectedItems[i]].value;
				ddl.options[selectedItems[i]].innerHTML = ddl.options[selectedItems[i] + 1].innerHTML;
				ddl.options[selectedItems[i]].value = ddl.options[selectedItems[i] + 1].value;
				ddl.options[selectedItems[i] + 1].innerHTML = temp.innerHTML; 
				ddl.options[selectedItems[i] + 1].value = temp.value; 
				ddl.options[selectedItems[i] + 1].selected = true;
				ddl.options[selectedItems[i]].selected = false;
			}
			
}

// Function to select everything in the Selected Columns before submitting
function selectAllOptions() {
	
	var selObj = document.getElementById('selectedcolumns');
	for (var i=0; i<selObj.options.length; i++) {
		selObj.options[i].selected = true;
	}
	
}

// Function to add additional filters to the custom query

var filternumber = 1;
function filter_fields() {
 
    filternumber++;
    var objTo = document.getElementById('filter_fields');
    var divtest = document.createElement("div");
	divtest.setAttribute("class", "form-group row removeclass"+filternumber);
	var rdiv = 'removeclass'+filternumber;
    divtest.innerHTML = '<div class="col-sm-4"> <input class="form-control-columnselect form-control" id="filtercolumns[]'+ filternumber +'" name="filtercolumns[]" readonly></div> <div class="col-sm-2"> <input class="form-control" id="filterexpressions[]'+ filternumber +'" name="filterexpressions[]" readonly> </div> <div class="col-sm-3"> <div class="input-group"> <input class="form-control" type="text" id="filtervalues[]'+ filternumber +'" name="filtervalues[]" readonly> <div class="input-group-btn"> <button class="btn btn-danger" type="button"  onclick="remove_filter_fields('+ filternumber +');"> &zwnj;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button> </div> </div> </div> </div>';
    
    objTo.appendChild(divtest)
	
	var filtervaluetext = document.getElementById('filtervalue').value;
	document.getElementById('filtervalues[]'+filternumber).value = filtervaluetext;
	
	var filterexpressiontext = document.getElementById('filterexpression').value;
	document.getElementById('filterexpressions[]'+filternumber).value = filterexpressiontext;
	
	var filtercolumntext = document.getElementById('filtercolumn').value;
	document.getElementById('filtercolumns[]'+filternumber).value = filtercolumntext;
	
	document.getElementById('filtervalue').value = "";
	document.getElementById('filterexpression').value = "";
	document.getElementById('filtercolumn').value = "";
	
}

function remove_filter_fields(rid) {
	$('.removeclass'+rid).remove();
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}