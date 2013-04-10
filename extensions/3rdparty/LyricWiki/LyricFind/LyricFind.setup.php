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

// TODO: move to CommonSettings
$wgLyricFindTrackingNamespaces = array(NS_MAIN);
$wgLyricFindTrackingUrl = '/__lyricfind_tracking';

$dir = __DIR__;

$app->registerClass('LyricFindController', $dir . '/LyricFindController.class.php');
$app->registerClass('LyricFindHooks', $dir . '/LyricFindHooks.class.php');
$app->registerClass('LyricFindTrackingService', $dir . '/LyricFindTrackingService.class.php');
$app->registerHook('OasisSkinAssetGroups', 'LyricFindHooks', 'onOasisSkinAssetGroups');
