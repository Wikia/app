<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An extension to allow access to APC status with MediaWiki rights
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 */

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Apc',
	'version'        => '2008-07-19',
	'author'         => 'Niklas Laxström',
	'descriptionmsg' => 'viewapc-desc',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['SpecialAPC'] = $dir . 'SpecialAPC.php';
$wgAutoloadClasses['APCImages'] = $dir . 'APCImages.php';
$wgAutoloadClasses['APCUtils'] = $dir . 'APCUtils.php';

$wgAutoloadClasses['APCHostMode'] = $dir . 'APCHostMode.php';
$wgAutoloadClasses['APCCacheMode'] = $dir . 'APCCacheMode.php';

$wgExtensionMessagesFiles['ViewAPC'] = $dir . 'ViewAPC.i18n.php';
$wgSpecialPages['ViewAPC'] = 'SpecialAPC';
$wgSpecialPageGroups['ViewAPC'] = 'wiki';

$wgAvailableRights[] = 'apc';
