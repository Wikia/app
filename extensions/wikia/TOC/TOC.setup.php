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
	'descriptionmsg' => 'toc-desc',
	'authors' => array(
		'Andrzej "nAndy" Łukaszewski',
		'Rafal Leszczynski',
	),
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TOC'
);

//i18n
$wgExtensionMessagesFiles['TOC'] = $dir . 'TOC.i18n.php';

// register classes
$wgAutoloadClasses['TOCController'] =  $dir . 'TOCController.class.php';
$wgAutoloadClasses['TOCHooksHelper'] =  $dir . 'TOCHooksHelper.class.php';

// register hooks
$wgHooks['Linker::overwriteTOC'][] = 'TOCHooksHelper::onOverwriteTOC';
$wgHooks['MonobookSkinAssetGroups'][] = 'TOCHooksHelper::onMonobookSkinAssetGroups';
$wgHooks['OasisSkinAssetGroups'][] = 'TOCHooksHelper::onOasisSkinAssetGroups';
