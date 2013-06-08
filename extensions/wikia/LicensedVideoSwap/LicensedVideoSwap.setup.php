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
$app = F::app();

//classes
$app->registerClass( 'LicensedVideoSwapSpecialController', $dir.'LicensedVideoSwapSpecialController.class.php' );
$app->registerClass( 'LicensedVideoSwapHelper', $dir.'LicensedVideoSwapHelper.class.php' );

// i18n mapping
$app->registerExtensionMessageFile( 'LicensedVideoSwap', $dir.'LicensedVideoSwap.i18n.php' );

// special pages
$app->registerSpecialPage( 'LicensedVideoSwap', 'LicensedVideoSwapSpecialController' );

// permissions
$wgGroupPermissions['*']['licensedvideoswap'] = false;
$wgGroupPermissions['staff']['licensedvideoswap'] = true;
$wgGroupPermissions['sysop']['licensedvideoswap'] = true;
$wgGroupPermissions['helper']['licensedvideoswap'] = true;
$wgGroupPermissions['vstf']['licensedvideoswap'] = true;

// register messages package for JS
// TODO: once 'back to roots' branch is merged, use JSMessages::registerPackage
F::build('JSMessages')->registerPackage('LVS', array(
	'lvs-confirm-swap-message',
	'lvs-confirm-keep-message',
));
