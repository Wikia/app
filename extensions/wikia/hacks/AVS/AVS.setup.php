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
	'name' => 'AVS',
	'author' => 'Tomasz Odrobny && Wojtek Szela',
	'url' => '',
	'description' => 'AVS',
	'descriptionmsg' => 'AVS',
	'version' => '0.0.0',
);

$dir = dirname(__FILE__) . '/';


require_once $dir.'Amazon/DataMapper.php';
require_once $dir.'Amazon/Item.php';
require_once $dir.'Amazon/CustomerReview.php';
require_once $dir.'Amazon/EditorialReview.php';
require_once $dir.'Amazon/Image.php';
require_once $dir.'Amazon/ListmaniaList.php';
require_once $dir.'Amazon/AApiClient.php';
require_once $dir.'Amazon/ApiClient/Soap.php';


$wgAutoloadClasses['AVS'] = $dir . 'AVS.body.php'; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['AVSSpecialPage'] = $dir . 'AVS.body.php'; # Tell MediaWiki to load the extension body.

$wgExtensionMessagesFiles['AVS'] = $dir . 'AVS.i18n.php';
$wgExtensionMessagesFiles['AVSAliases'] = $dir . 'AVS.alias.php';
$wgHooks['ParserFirstCallInit'][] = 'AVS::initHooks';


$wgSpecialPages['AVS'] = 'AVSSpecialPage';
