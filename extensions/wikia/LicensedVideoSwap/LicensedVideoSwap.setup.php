<?php

/**
 * LicensedVideoSwap
 * @author Garth Webb, Liz Lee, Saipetch Kongkatong
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'LicensedVideoSwap',
	'author' => array( 'Garth Webb', 'Liz Lee', 'Saipetch Kongkatong' )
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['LicensedVideoSwapSpecialController'] = $dir.'LicensedVideoSwapSpecialController.class.php';
$wgAutoloadClasses['LicensedVideoSwapHelper'] = $dir.'LicensedVideoSwapHelper.class.php';

// i18n mapping
$wgExtensionMessagesFiles['LicensedVideoSwap'] = $dir.'LicensedVideoSwap.i18n.php';

// special pages
$wgSpecialPages['LicensedVideoSwap'] = 'LicensedVideoSwapSpecialController';

// permissions
$wgGroupPermissions['*']['licensedvideoswap'] = false;
$wgGroupPermissions['staff']['licensedvideoswap'] = true;
$wgGroupPermissions['sysop']['licensedvideoswap'] = true;
$wgGroupPermissions['helper']['licensedvideoswap'] = true;
$wgGroupPermissions['vstf']['licensedvideoswap'] = true;