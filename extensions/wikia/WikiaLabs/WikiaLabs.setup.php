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
	'name' => 'WikiaLabs',
	'author' => 'Tomasz Odrobny Adi Wieczorek',
	'url' => '',
	'description' => '',
	'descriptionmsg' => 'myextension-desc',
	'version' => '0.0.0',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['WikiaLabs'] = $dir . 'WikiaLabs.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['WikiaLabs'] = $dir . 'WikiaLabs.i18n.php';
$wgExtensionAliasesFiles['WikiaLabs'] = $dir . 'WikiaLabs.alias.php';
$wgSpecialPages['WikiaLabs'] = 'WikiaLabs'; # Let MediaWiki know about your new special page.
