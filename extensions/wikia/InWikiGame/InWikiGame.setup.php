<?php

/**
 * In Wiki Game
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$wgExtensionCredits['other'][] = array(
	'name'			=> 'InWikiGame',
	'author'		=> 'Andrzej "nAndy" Łukaszewski, Marcin Maciejewski, Sebastian Marzjan',
	'description'	=> 'In Wiki Game enables to put an interactive game (i.e. in an iframe) to the wiki page',
	'version'		=> 1.0
);


$dir = dirname(__FILE__);
$app = F::app();

// classes
$wgAutoloadClasses['InWikiGameHelper'] =  $dir . '/InWikiGameHelper.class.php';
$wgAutoloadClasses['InWikiGameParserTag'] =  $dir . '/InWikiGameParserTag.class.php';
$wgAutoloadClasses['InWikiGameController'] =  $dir . '/InWikiGameController.class.php';
$wgAutoloadClasses['InWikiGameRailController'] =  $dir . '/InWikiGameRailController.class.php';
$wgAutoloadClasses['InWikiGameHooks'] =  $dir . '/InWikiGameHooks.class.php';

// hooks
$app->registerHook('GetRailModuleList', 'InWikiGameHelper', 'onGetRailModuleList');
$app->registerHook('ParserFirstCallInit', 'InWikiGameParserTag', 'onParserFirstCallInit');
$app->registerHook('WikiaAssetsPackages', 'InWikiGameHooks', 'onWikiaAssetsPackages');

// i18n mapping
$app->registerExtensionMessageFile('InWikiGame', $dir . '/InWikiGame.i18n.php');
JSMessages::registerPackage('InWikiGame', array('inwikigame-*'));
