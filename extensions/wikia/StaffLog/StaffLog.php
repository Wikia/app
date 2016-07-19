<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/MyExtension/MyExtension.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'StaffLog',
	'author' => 'Tomasz Odrobny',
	'descriptionmsg' => 'stafflog-desc',
	'version' => '0.0.1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/StaffLog'
);

$dir = __DIR__ . '/';

$wgAutoloadClasses['StaffLog'] = $dir . 'StaffLog_body.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['StaffLogger'] = $dir . 'StaffLog.events.php';
$wgExtensionMessagesFiles['StaffLog'] = $dir . 'StaffLog.i18n.php';
$wgExtensionMessagesFiles['StaffLogAliases'] = $dir . 'StaffLog.alias.php';

if ( !empty( $wgEnableStaffLogSpecialPage ) ) {
	$wgSpecialPages['StaffLog'] = 'StaffLog'; # Let MediaWiki know about your new special page.
}

$wgLogRestrictions['StaffLog'] = 'StaffLog';

$wgStaffLogType = array(1 => "Block");
$wgSpecialPageGroups['stafflog'] = 'changes';

require_once $dir."StaffLog.events.php";
