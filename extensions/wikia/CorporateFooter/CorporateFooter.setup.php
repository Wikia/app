<?php

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
		'name' => 'CorporateFooter',
		'author' => 'Mateusz "Warkot" Warkocki',
		'description' => 'CorporateFooter',
		'version' => 1.0
		);

$wgAutoloadClasses['CorporateFooterController'] =  $dir . 'CorporateFooterController.class.php';
$wgAutoloadClasses['CorporateFooterHooks'] =  $dir . 'hooks/CorporateFooterHooks.class.php';

$wgHooks['OasisSkinAssetGroups'][] = 'CorporateFooterHooks::onOasisSkinAssetGroups';

$wgExtensionMessagesFiles['CorporateFooter'] = $dir . 'CorporateFooter.i18n.php';
