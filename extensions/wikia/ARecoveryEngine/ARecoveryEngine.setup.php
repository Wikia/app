<?php
/**
 * 	Recovery Engine - AdBlock Detection and AD recovery
 */

$wgAutoloadClasses['ARecoveryEngineHooks'] = __DIR__ . '/ARecoveryEngineHooks.class.php';
$wgAutoloadClasses['ARecoveryBootstrapCode'] = __DIR__ . '/ARecoveryBootstrapCode.class.php';
$wgAutoloadClasses['PageFairBootstrapCode'] = __DIR__ . '/PageFairBootstrapCode.class.php';
$wgAutoloadClasses['ARecoveryEngineApiController'] = __DIR__ . '/ARecoveryEngineApiController.class.php';
$wgAutoloadClasses['ARecoveryModule'] = __DIR__ . '/ARecoveryModule.class.php';

// PageFair
$wgAutoloadClasses['ResourceLoaderAdEnginePageFairDetectionModule'] = __DIR__ . '/ResourceLoaders/PageFair/ResourceLoaderAdEnginePageFairDetectionModule.php';
$wgAutoloadClasses['ResourceLoaderAdEnginePageFairRecoveryModule'] = __DIR__ . '/ResourceLoaders/PageFair/ResourceLoaderAdEnginePageFairRecoveryModule.php';

// Instart Logic
$wgAutoloadClasses['ResourceLoaderAdEngineInstartLogicModule'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineInstartLogicModule.php';

$wgHooks['InstantGlobalsGetVariables'][] = 'ARecoveryEngineHooks::onInstantGlobalsGetVariables';

// i18n
$wgExtensionMessagesFiles['ARecoveryEngine'] = __DIR__ . '/ARecoveryEngine.i18n.php';
