<?php
/**
 * Entry point for lazy loading TOC for the article
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Rafal Leszczynski
 */
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['other'][] = array(
	'name' => 'TOC',
	'description' => 'Entry point for lazy loading TOC for the article',
	'authors' => array(
		'Andrzej "nAndy" Łukaszewski',
		'Rafal Leszczynski',
	),
	'version' => 1.0
);

// register classes
$wgAutoloadClasses['TOCController'] =  $dir . 'TOCController.class.php';
$wgAutoloadClasses['TOCHooksHelper'] =  $dir . 'TOCHooksHelper.class.php';

// register messages
$wgExtensionMessagesFiles['TOC'] = $dir.'TOC.i18n.php';

// register hooks
$wgHooks['Linker::overwriteTOC'][] = 'TOCHooksHelper::onOverwriteTOC';
$wgHooks['MonobookSkinAssetGroups'][] = 'TOCHooksHelper::onMonobookSkinAssetGroups';
$wgHooks['OasisSkinAssetGroups'][] = 'TOCHooksHelper::onOasisSkinAssetGroups';

