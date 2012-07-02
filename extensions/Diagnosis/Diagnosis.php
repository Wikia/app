<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
		echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/Diagnosis/Diagnosis.php" );
EOT;
		exit( 1 );
}
 
$wgExtensionCredits['specialpage'][] = array(
		'path' => __FILE__,
		'name' => 'Diagnosis',
		'author' => '[http://www.dasch-tour.de DaSch]',
		'url' => 'https://www.mediawiki.org/wiki/Extension:Diagnosis',
		'descriptionmsg' => 'diagnosis-desc',
		'version' => '0.0.1',
);
 
$dir = dirname(__FILE__) . '/';

$wgAvailableRights[] = 'diagnosis-access';
$wgGroupPermissions['sysop']['diagnosis-access'] = true;
 
$wgAutoloadClasses['SpecialDiagnosis'] = $dir . 'SpecialDiagnosis.php'; # Location of the SpecialMyExtension class (Tell MediaWiki to load this file)
$wgExtensionMessagesFiles['Diagnosis'] = $dir . 'Diagnosis.i18n.php'; # Location of a messages file (Tell MediaWiki to load this file)
$wgSpecialPages['Diagnosis'] = 'SpecialDiagnosis'; # Tell MediaWiki about the new special page and its class name
$wgSpecialPageGroups['Diagnosis'] = 'other';