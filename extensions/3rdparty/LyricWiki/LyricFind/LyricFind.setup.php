<?php

/**
 * Provides page views counter for LyricFind namespace
 *
 * @author macbre
 * @var $app WikiaApp
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'LyricFind tracking',
	'author' => array('Maciej Brencz')
);

$dir = __DIR__;

// TODO: move to CommonSettings
$wgLyricFindTrackingNamespaces = array(NS_MAIN);

// common code
$app->registerClass('LyricFindHooks', $dir . '/LyricFindHooks.class.php');
$app->registerExtensionMessageFile('LyricFind', $dir . '/LyricFind.i18n.php');

// LyricFind page views tracking
$app->registerClass('LyricFindController', $dir . '/LyricFindController.class.php');
$app->registerClass('LyricFindTrackingService', $dir . '/LyricFindTrackingService.class.php');
$app->registerHook('OasisSkinAssetGroups', 'LyricFindHooks', 'onOasisSkinAssetGroups');

// parser hhok
$app->registerHook('ParserFirstCallInit', 'LyricFindHooks', 'onParserFirstCallInit');
$app->registerClass('LyricFindParserController', $dir . '/LyricFindParserController.class.php');
