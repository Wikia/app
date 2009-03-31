<?php

if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install our extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/EmergencyDeSysop/EmergencyDeSysop" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'author'	=> 'SQL',
	'name'		=> 'EmergencyDeSysop',
	'svn-date'    => '$LastChangedDate$',
	'svn-revision'    => '$LastChangedRevision$',
	'url' 		=> 'http://www.mediawiki.org/wiki/Extension:EmergencyDeSysop',
	'description'	=> 'Allows a Sysop to sacrifice their own bit, in order to desysop another',
	'descriptionmsg' => 'emergencydesysop-desc',
);

$dir = dirname(__FILE__);

$wgExtensionMessagesFiles['EmergencyDeSysop'] = "$dir/EmergencyDeSysop.i18n.php";
$wgExtensionAliasesFiles['EmergencyDeSysop'] = "$dir/EmergencyDeSysop.alias.php"; 
$wgAutoloadClasses['SpecialEmergencyDeSysop'] = "$dir/SpecialEmergencyDeSysop.php";

$wgSpecialPages['EmergencyDeSysop'] = 'SpecialEmergencyDeSysop';

$wgSpecialPageGroups['EmergencyDeSysop'] = 'users';

$wgAvailableRights[] = 'emergencydesysop';

$wgGroupPermissions['sysop']['emergencydesysop'    ] = true;

//Load Defaults
$wgEmDesysop = array('Requestor' => NULL, 'Target' => NULL);

function EmergencyDeSysopLocalizedPageName(&$specialPageArray, $code) {
	wfLoadExtensionMessages('EmergencyDeSysop');
	$text = wfMsg('emergencydesysop');
 
	$title = Title::newFromText($text);
	$specialPageArray['emergencydesysop']['emergencydesysop'] = $title->getDBKey();
	return true;
}

