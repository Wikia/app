<?php

/**
 * 	SP ads recovery
 * proof of concept / experiment
 */

$wgAutoloadClasses['ResourceLoaderAdEngineSourcePointCSBootstrap'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineSourcePointCSBootstrap.php';
$wgAutoloadClasses['ResourceLoaderAdEngineSourcePointCSDelivery'] = __DIR__ . '/ResourceLoaders/ResourceLoaderAdEngineSourcePointCSDelivery.php';
$wgAutoloadClasses['ARecoveryEngineHooks'] = __DIR__ . '/ARecoveryEngineHooks.class.php';
$wgAutoloadClasses['ARecoveryEngineApiController'] = __DIR__ . '/ARecoveryEngineApiController.class.php';


$wgHooks['WikiaSkinTopScripts'][] = 'ARecoveryEngineHooks::onWikiaSkinTopScripts';



