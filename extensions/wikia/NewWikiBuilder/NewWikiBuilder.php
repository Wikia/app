<?php
// TODO extension credits

// New user right, required to use the extension.
$wgAvailableRights[] = 'newwikibuilder';
$wgGroupPermissions['*']['newwikibuilder'] = false;
$wgGroupPermissions['sysop']['newwikibuilder'] = true;
$wgGroupPermissions['bureaucrat']['newwikibuilder'] = true;
$wgGroupPermissions['staff']['newwikibuilder'] = true;

$wgAutoloadClasses['ApiUploadLogo'] = dirname(__FILE__) . '/ApiUploadLogo.php';
$wgAPIModules['uploadlogo'] = 'ApiUploadLogo';

$wgAutoloadClasses['ApiFounderSettings'] = dirname(__FILE__) . '/ApiFounderSettings.php';
$wgAPIModules['foundersettings'] = 'ApiFounderSettings';
