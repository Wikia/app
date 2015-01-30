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
	'name'				=> 'InWikiGame',
	'author'			=> 'Andrzej "nAndy" Łukaszewski, Marcin Maciejewski, Sebastian Marzjan',
	'descriptionmsg'	=> 'inwikigame-desc',
	'version'			=> 1.0,
	'url'				=> 'https://github.com/Wikia/app/tree/dev/extensions/wikia/InWikiGame'
);


$dir = dirname(__FILE__);

// classes
$wgAutoloadClasses['InWikiGameHelper'] =  $dir . '/InWikiGameHelper.class.php';
$wgAutoloadClasses['InWikiGameParserTag'] =  $dir . '/InWikiGameParserTag.class.php';
$wgAutoloadClasses['InWikiGameController'] =  $dir . '/InWikiGameController.class.php';
$wgAutoloadClasses['InWikiGameRailController'] =  $dir . '/InWikiGameRailController.class.php';
$wgAutoloadClasses['InWikiGameHooks'] =  $dir . '/InWikiGameHooks.class.php';

// hooks
$wgHooks['GetRailModuleList'][] = 'InWikiGameHelper::onGetRailModuleList';
$wgHooks['ParserFirstCallInit'][] = 'InWikiGameParserTag::onParserFirstCallInit';
$wgHooks['WikiaAssetsPackages'][] = 'InWikiGameHooks::onWikiaAssetsPackages';

// i18n mapping
$wgExtensionMessagesFiles['InWikiGame'] = $dir . '/InWikiGame.i18n.php';
JSMessages::registerPackage('InWikiGame', array('inwikigame-*'));
