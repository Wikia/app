<?php

if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install our extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/EmergencyDeSysop/EmergencyDeSysop" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path'          => __FILE__,
	'author'	=> 'SQL',
	'name'		=> 'EmergencyDeSysop',
	'url' 		=> 'http://www.mediawiki.org/wiki/Extension:EmergencyDeSysop',
	'descriptionmsg' => 'emergencydesysop-desc',
);

$dir = dirname(__FILE__);

$wgExtensionMessagesFiles['EmergencyDeSysop'] = "$dir/EmergencyDeSysop.i18n.php";
$wgExtensionMessagesFiles['EmergencyDeSysopAlias'] = "$dir/EmergencyDeSysop.alias.php"; 
$wgAutoloadClasses['SpecialEmergencyDeSysop'] = "$dir/SpecialEmergencyDeSysop.php";

$wgSpecialPages['EmergencyDeSysop'] = 'SpecialEmergencyDeSysop';

$wgSpecialPageGroups['EmergencyDeSysop'] = 'users';

$wgAvailableRights[] = 'emergencydesysop';

$wgGroupPermissions['sysop']['emergencydesysop'    ] = true;

//Load Defaults
$wgEmDesysop = array('Requestor' => null, 'Target' => null);

function EmergencyDeSysopLocalizedPageName(&$specialPageArray, $code) {
	
	$text = wfMsg('emergencydesysop');
 
	$title = Title::newFromText($text);
	$specialPageArray['emergencydesysop']['emergencydesysop'] = $title->getDBkey();
	return true;
}

