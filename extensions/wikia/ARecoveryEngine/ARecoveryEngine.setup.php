<?php
/**
 * 	Recovery Engine - AdBlock Detection and AD recovery
 */

$wgAutoloadClasses['ResourceLoaderAdEngineSourcePointCSBootstrap'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineSourcePointCSBootstrap.php';
$wgAutoloadClasses['ResourceLoaderAdEngineSourcePointCSDelivery'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineSourcePointCSDelivery.php';
$wgAutoloadClasses['ARecoveryEngineHooks'] = __DIR__ . '/ARecoveryEngineHooks.class.php';
$wgAutoloadClasses['ARecoveryEngineApiController'] = __DIR__ . '/ARecoveryEngineApiController.class.php';
$wgAutoloadClasses['ARecoveryUnlockCSS'] = __DIR__ . '/ARecoveryUnlockCSS.class.php';


$wgHooks['WikiaSkinTopScripts'][] = 'ARecoveryEngineHooks::onWikiaSkinTopScripts';
$wgHooks['BeforePageDisplay'][] = 'ARecoveryEngineHooks::onBeforePageDisplay';
