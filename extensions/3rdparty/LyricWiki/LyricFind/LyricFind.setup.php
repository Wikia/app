<?php

/**
 * Provides page views counter for LyricFind namespace
 *
 * @author macbre
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'LyricFind tracking',
	'author' => array('Maciej Brencz')
);

$dir = __DIR__;

// TODO: move to CommonSettings
$wgLyricFindTrackingNamespaces = array(NS_MAIN);

// LyricFind page views tracking
$app->registerClass('LyricFindController', $dir . '/LyricFindController.class.php');
$app->registerClass('LyricFindHooks', $dir . '/LyricFindHooks.class.php');
$app->registerClass('LyricFindTrackingService', $dir . '/LyricFindTrackingService.class.php');
$app->registerHook('OasisSkinAssetGroups', 'LyricFindHooks', 'onOasisSkinAssetGroups');
