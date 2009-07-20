<?php
// TODO extension credits

// New user right, required to use the extension.
$wgAvailableRights[] = 'newwikibuilder';
$wgGroupPermissions['*']['newwikibuilder'] = false;
$wgGroupPermissions['sysop']['newwikibuilder'] = true;
$wgGroupPermissions['bureaucrat']['newwikibuilder'] = true;
$wgGroupPermissions['staff']['newwikibuilder'] = true;

$NWBApiExtensions = array(
	'uploadlogo' => 'ApiUploadLogo',
	'foundersettings' => 'ApiFounderSettings',
	'createmultiplepages' => 'ApiCreateMultiplePages',
);

foreach ($NWBApiExtensions as $action => $classname){
	$wgAutoloadClasses[$classname] = dirname(__FILE__) . '/' . $classname . '.php';
	$wgAPIModules[$action] = $classname;
}
