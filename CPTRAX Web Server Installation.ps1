#Change PowerShell Terminal Colors
$HOST.UI.RawUI.BackgroundColor = "Black"
$HOST.UI.RawUI.ForegroundColor = "Yellow"
clear-host

#Begin installation
Write-Host "`n******************************************************************************`nWelcome to the CPTRAX Web Reporter Installer.`n******************************************************************************"

$SQLServer = Read-Host -Prompt "`nPlease enter your SQL Server Instance. Example: DEMOFS2016\SQLEXPRESS"
$defaultURL = "CPTRAXWEB"
$url = Read-Host -Prompt "What URL would you like to use to access the CPTRAX Web Reporter? Press enter to accept the default [$($defaultURL)]"
$defaultPort = "80"
$port = Read-Host -Prompt "What Port would you like to use to access the CPTRAX Web Reporter? Press enter to accept the default [$($defaultPort)]"

Write-Host "`nCPTRAX Web Reporter Installation could take several minutes please wait..."

#Paths for installation
$phpUnzipPath = (Get-Item -Path ".\" -Verbose).FullName
$phpInstallMedia = "dependencies\php-5.3"
$php_version = "5.3"
$php_install = "C:\Program Files (x86)\Visual Click Software, Inc\CPTRAX\php"
$php_log = "C:\Program Files (x86)\Visual Click Software, Inc\CPTRAX\phplog"
$php_temp = "C:\Program Files (x86)\Visual Click Software, Inc\CPTRAX\phptemp"
$web_root = "C:\Program Files (x86)\Visual Click Software, Inc\CPTRAX\wwwroot"
$web_log = "C:\Program Files (x86)\Visual Click Software, Inc\CPTRAX\wwwlogs"
$windowsVersion = (Get-WmiObject Win32_OperatingSystem).Name

#Extract PHP-FastCGI-CPTRAX
if (Test-Path -path 'Dependencies\php-5.3') {

	Remove-Item 'Dependencies\php-5.3' -recurse
	
}

Write-Host "`n- Extracting PHP..."
Add-Type -assembly "system.io.compression.filesystem"
[io.compression.zipfile]::ExtractToDirectory("$phpUnzipPath\Dependencies\php-5.3.zip", "$phpUnzipPath\Dependencies\")

#Set Web URL
if ($url -eq "") {} else { $defaultURL = $url }

#Install Microsoft Visual C++ 2008 Redistributable Package (x86) if Server 2008 or 2008R2 detectd
if ($windowsVersion -match [regex]::Escape(2008)) {
    
    #Install Microsoft Visual C++ 2008 Redistributable Package (x86)
	Write-Host "- Installing Microsoft Visual C++ 2008 Redistributable Package (x86)"
    start-process "Dependencies\2008prep\vcredist_x86.exe" -Wait -ArgumentList "/q"

}

if (Test-Path -path 'C:\Program Files\Microsoft SQL Server') {

    Write-Host "- SQL or Native SQL Client Already Installed."

}

else { 

	Write-Host "- Installing SQL Native Client..."
	start-process msiexec.exe -Wait -ArgumentList "/passive /i Dependencies\sqlncli.msi IACCEPTSQLNCLILICENSETERMS=YES"
}

#Install IIS and all required Sub Components
Write-Host "- Installing IIS and required sub components..."
start-process "$env:windir\system32\pkgmgr.exe" -ArgumentList "/iu:IIS-WebServerRole;IIS-WebServer;IIS-CommonHttpFeatures;IIS-StaticContent;IIS-DefaultDocument;IIS-DirectoryBrowsing;IIS-HttpErrors;IIS-HealthAndDiagnostics;IIS-HttpLogging;IIS-LoggingLibraries;IIS-RequestMonitor;IIS-Security;IIS-RequestFiltering;IIS-HttpCompressionStatic;IIS-WebServerManagementTools;IIS-ManagementConsole;WAS-WindowsActivationService;WAS-ProcessModel;WAS-NetFxEnvironment;WAS-ConfigurationAPI;IIS-CGI" -Wait

Write-Host "- Creating Folder structure for CPTRAX Web Reporter..."

#Set Permissions on paths for IIS/PHP to function
if ((Test-Path -path $php_install) -ne $True) {

    new-item -type directory -path $php_install
    $acl = get-acl $php_install
    $ar = new-object system.security.accesscontrol.filesystemaccessrule("IIS AppPool\DefaultAppPool", "ReadAndExecute", "ContainerInherit, ObjectInherit", "None","Allow")
    $acl.setaccessrule($ar)
    $ar = new-object system.security.accesscontrol.filesystemaccessrule("Users", "ReadAndExecute", "ContainerInherit, ObjectInherit", "None","Allow")
    $acl.setaccessrule($ar)
    set-acl $php_install $acl
	
}

copy-item $phpInstallMedia -destination "$php_install\$php_version" -recurse -force
if ((Test-Path -path $php_log) -ne $True) {

    new-item -type directory -path $php_log
    $acl = get-acl $php_log
    $ar = new-object system.security.accesscontrol.filesystemaccessrule("Users","Modify","Allow")
    $acl.setaccessrule($ar)
    $ar = new-object system.security.accesscontrol.filesystemaccessrule("IIS AppPool\DefaultAppPool", "Modify", "ContainerInherit, ObjectInherit", "None","Allow")
    $acl.setaccessrule($ar)
    set-acl $php_log $acl
	
}

if ((Test-Path -path $php_temp) -ne $True) {

    new-item -type directory -path $php_temp
    $acl = get-acl $php_temp
    $ar = new-object system.security.accesscontrol.filesystemaccessrule("Users","Modify","Allow")
    $acl.setaccessrule($ar)
    $ar = new-object system.security.accesscontrol.filesystemaccessrule("IIS AppPool\DefaultAppPool", "Modify", "ContainerInherit, ObjectInherit", "None","Allow")
    $acl.setaccessrule($ar)
    set-acl $php_temp $acl
	
}

if ((Test-Path -path $web_root) -ne $True) {

    new-item -type directory -path $web_root
    $acl = get-acl $web_root
    $ar = new-object system.security.accesscontrol.filesystemaccessrule("Users", "ReadAndExecute", "ContainerInherit, ObjectInherit", "None","Allow") 
    $acl.setaccessrule($ar)
    set-acl $web_root $acl
	
}
if ((Test-Path -path $web_log) -ne $True) {

    new-item -type directory -path $web_log
    $acl = get-acl $web_log
    $ar = new-object system.security.accesscontrol.filesystemaccessrule("Users", "ReadAndExecute", "ContainerInherit, ObjectInherit", "None","Allow")
    $acl.setaccessrule($ar)
    set-acl $web_log $acl
	
}

if (Test-Path -path 'C:\Program Files (x86)\Visual Click Software, Inc\CPTRAX\wwwroot\cptrax') {

    Remove-Item 'C:\Program Files (x86)\Visual Click Software, Inc\CPTRAX\wwwroot\cptrax' -recurse -force

}

#Copy necessary files to temp directory
Copy-Item "cptrax.php" -destination $web_root -force
Copy-Item "cptrax" -destination $web_root\cptrax\ -recurse -force

#Create SQL Connection PHP with user's SQL Instance
if (Test-Path -path 'C:\Program Files (x86)\Visual Click Software, Inc\CPTRAX\wwwroot\cptrax\php\sqlserver.php') {

	Remove-Item 'C:\Program Files (x86)\Visual Click Software, Inc\CPTRAX\wwwroot\cptrax\php\sqlserver.php'
	
}

Add-Content 'C:\Program Files (x86)\Visual Click Software, Inc\CPTRAX\wwwroot\cptrax\php\sqlserver.php' "<?php `$server = `"$SQLServer`"; ?>"

#Configure IIS to use the appropriate PHP installation for the CPTRAX Site.
Write-Host "`n- Configuring IIS to use appropriate version of PHP..."
start-process $env:windir\System32\inetsrv\appcmd.exe "set config -section:system.webServer/fastCgi /+`"[fullPath='$php_install\$php_version\php-cgi.exe',arguments='',maxInstances='4',idleTimeout='300',activityTimeout='30',requestTimeout='90',instanceMaxRequests='10000',protocol='NamedPipe',flushNamedPipe='False']`" /commit:apphost"
start-process $env:windir\System32\inetsrv\appcmd.exe "set config -section:system.webServer/fastCgi /+`"[fullPath='$php_install\$php_version\php-cgi.exe'].environmentVariables.[name='PHP_FCGI_MAX_REQUESTS',value='10000']`" /commit:apphost"
Start-Sleep -m 1000
start-process $env:windir\System32\inetsrv\appcmd.exe "set config -section:system.webServer/handlers /+`"[name='PHP-FastCGI-CPTRAX',path='*.php',verb='GET,HEAD,POST',modules='FastCgiModule',scriptProcessor='$php_install\$php_version\php-cgi.exe',resourceType='Either',requireAccess='Script']`" /commit:apphost"

#Finalize CPTRAX Web Reporter IIS Site creation and configuration
Write-Host "`n- Finalizing IIS Configuration..."
import-module WebAdministration
import-module ServerManager
$currentBinding = get-webbinding -name 'CPTRAXWEB' | select bindingInformation

#If the binding for the URL provided earlier already exists, don't try to recreate it.
if ($currentBinding -match [regex]::escape($url)) {

	Add-WindowsFeature -name Web-Url-Auth -IncludeAllSubFeature
	Add-WindowsFeature -name Web-Windows-Auth -IncludeAllSubFeature
	Add-WindowsFeature -name Web-Basic-Auth -IncludeAllSubFeature
	Add-WindowsFeature -name Web-Net-Ext -IncludeallSubFeature
	New-WebAppPool CPTRAX
	Set-WebConfigurationProperty -filter /system.webServer/security/authentication/AnonymousAuthentication -name enabled -value false -PSPath IIS:\
	Set-WebConfigurationProperty -filter /system.webServer/security/authentication/windowsAuthentication -name enabled -value true -PSPath IIS:\
	Set-WebConfigurationProperty -filter /system.webServer/security/authentication/basicAuthentication -name enabled -value false -PSPath IIS:\
	set-ItemProperty 'IIS:\Sites\CPTRAXWEB\' -name logFile.directory -value $web_log
	Set-ItemProperty 'IIS:\Sites\CPTRAXWEB\' -name applicationPool -value CPTRAX
	stop-website 'CPTRAXWEB' 
	start-website 'CPTRAXWEB'
	
	Write-Host "`n****************************************************************************************`nUpdate Process Completed.  Press any key to continue ...`n****************************************************************************************"

	$x = $host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
	
}
else {

	Add-WindowsFeature -name Web-Url-Auth -IncludeAllSubFeature
	Add-WindowsFeature -name Web-Windows-Auth -IncludeAllSubFeature
	Add-WindowsFeature -name Web-Basic-Auth -IncludeAllSubFeature
	Add-WindowsFeature -name Web-Net-Ext -IncludeallSubFeature
	New-WebAppPool CPTRAX
	New-Item 'IIS:\Sites\CPTRAXWEB' -bindings @{protocol="http";bindingInformation=":$defaultPort`:$defaulturl"} -physicalPath $web_root
	Add-WebConfiguration system.webserver/defaultdocument/files IIS:\sites\CPTRAXWEB\ -atIndex 0 -Value @{value="cptrax.php"}
	Start-Sleep -m 1000
	Set-WebConfigurationProperty -filter /system.webServer/security/authentication/AnonymousAuthentication -name enabled -value false -PSPath IIS:\
	Set-WebConfigurationProperty -filter /system.webServer/security/authentication/windowsAuthentication -name enabled -value true -PSPath IIS:\
	Set-WebConfigurationProperty -filter /system.webServer/security/authentication/basicAuthentication -name enabled -value false -PSPath IIS:\
	set-ItemProperty 'IIS:\Sites\CPTRAXWEB\' -name logFile.directory -value $web_log
	Set-ItemProperty 'IIS:\Sites\CPTRAXWEB\'	-name applicationPool -value CPTRAX
	stop-website 'CPTRAXWEB' 
	start-website 'CPTRAXWEB'

	Write-Host "`n****************************************************************************************`nInstallation Process Completed.  Please continue with Domain Name Service Configuration`n on Page 4 of the Web Reporter Installation Guide.  Press any key to continue ...`n****************************************************************************************"

	$x = $host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
	
}