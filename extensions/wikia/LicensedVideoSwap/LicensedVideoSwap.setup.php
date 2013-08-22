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
$wgAutoloadClasses['LicensedVideoSwapHooksHelper'] = $dir.'LicensedVideoSwapHooksHelper.class.php';

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

$wgHooks['PageHeaderIndexExtraButtons'][] = 'LicensedVideoSwapHooksHelper::onPageHeaderIndexExtraButtons';

// register messages package for JS
JSMessages::registerPackage('LVS', array(
	'lvs-confirm-swap-title',
	'lvs-confirm-keep-title',
	'lvs-confirm-undo-swap-title',
	'lvs-confirm-swap-message-different-title',
	'lvs-confirm-swap-message-same-title',
	'lvs-confirm-keep-message',
	'lvs-confirm-undo-swap-message',
	'lvs-confirm-undo-keep-title',
	'lvs-confirm-undo-keep-message',
));
