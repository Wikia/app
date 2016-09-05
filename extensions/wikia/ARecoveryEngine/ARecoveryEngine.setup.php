<?php
/**
 * 	Recovery Engine - AdBlock Detection and AD recovery
 */
$wgAutoloadClasses['ResourceLoaderAdEngineSourcePointBase'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineSourcePointBase.php';
$wgAutoloadClasses['ResourceLoaderAdEngineSourcePointDetectionModule'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineSourcePointDetectionModule.php';
$wgAutoloadClasses['ResourceLoaderAdEngineSourcePointCSBootstrap'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineSourcePointCSBootstrap.php';
$wgAutoloadClasses['ResourceLoaderAdEngineSourcePointCSDelivery'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineSourcePointCSDelivery.php';
$wgAutoloadClasses['ARecoveryEngineHooks'] = __DIR__ . '/ARecoveryEngineHooks.class.php';
$wgAutoloadClasses['ARecoveryEngineApiController'] = __DIR__ . '/ARecoveryEngineApiController.class.php';
$wgAutoloadClasses['ARecoveryModule'] = __DIR__ . '/ARecoveryModule.class.php';

$wgAutoloadClasses['ResourceLoaderAdEnginePageFairDetectionModule'] = __DIR__ . '/ResourceLoaders/PageFair/ResourceLoaderAdEnginePageFairDetectionModule.php';

$wgAutoloadClasses['ResourceLoaderUntouchableAdsDetector'] = __DIR__ . '/ResourceLoaders/UntouchableAds/ResourceLoaderAdEngineUntouchableAdsDetector.php';
$wgAutoloadClasses['ResourceLoaderUntouchableAdsDelivery'] = __DIR__ . '/ResourceLoaders/UntouchableAds/ResourceLoaderAdEngineUntouchableAdsDelivery.php';

$wgHooks['InstantGlobalsGetVariables'][] = 'ARecoveryEngineHooks::onInstantGlobalsGetVariables';

// i18n
$wgExtensionMessagesFiles['ARecoveryEngine'] = __DIR__ . '/ARecoveryEngine.i18n.php';
