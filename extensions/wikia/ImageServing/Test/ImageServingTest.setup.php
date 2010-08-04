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
	'name' => 'ImageServing test',
	'author' => 'Tomasz Odrobny',
	'url' => '',
	'description' => 'ImageServing testing web pege',
	'descriptionmsg' => 'myextension-desc',
	'version' => '0.0.0',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['ImageServingTest'] = $dir . 'ImageServingTest_body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['ImageServingTest'] = $dir . 'ImageServingTest.i18n.php';
$wgExtensionAliasesFiles['ImageServingTest'] = $dir . 'ImageServingTest.alias.php';
$wgSpecialPages['ImageServingTest'] = 'ImageServingTest'; # Let MediaWiki know about your new special page.
