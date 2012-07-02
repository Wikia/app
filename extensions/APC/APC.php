<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * An extension to allow access to APC status with MediaWiki rights
 *
 * @file
 * @ingroup Extensions
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 */

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Apc',
	'version'        => '2010-04-18',
	'author'         => 'Niklas Laxström',
	'descriptionmsg' => 'apc-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:APC',
);

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['SpecialAPC'] = $dir . 'SpecialAPC.php';
$wgAutoloadClasses['APCImages'] = $dir . 'APCImages.php';
$wgAutoloadClasses['APCUtils'] = $dir . 'APCUtils.php';

$wgAutoloadClasses['APCHostMode'] = $dir . 'APCHostMode.php';
$wgAutoloadClasses['APCCacheMode'] = $dir . 'APCCacheMode.php';

$wgExtensionMessagesFiles['APC'] = $dir . 'APC.i18n.php';
$wgExtensionMessagesFiles['APCAlias'] = $dir . 'APC.alias.php';
$wgSpecialPages['APC'] = 'SpecialAPC';
$wgSpecialPageGroups['APC'] = 'wiki';

$wgAvailableRights[] = 'apc';

$wgResourceModules['ext.apc'] = array(
	'styles' => 'apc.css',
	'localBasePath' => dirname(__FILE__),
	'remoteExtPath' => 'APC'
);
