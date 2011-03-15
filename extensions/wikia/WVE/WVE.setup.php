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
	'name' => 'WVE',
	'author' => 'Tomasz Odrobny',
	'url' => '',
	'description' => 'WVE',
	'descriptionmsg' => 'WVE',
	'version' => '0.0.0',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['WVE'] = $dir . 'WVE.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['VWE'] = $dir . 'WVE.i18n.php';
$wgExtensionAliasesFiles['WVE'] = $dir . 'WVE.alias.php';
$wgSpecialPages['WVE'] = 'WVE'; # Let MediaWiki know about your new special page.