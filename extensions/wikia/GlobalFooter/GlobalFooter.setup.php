<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'GlobalFooter',
	'author' => 'Bogna "bognix" Knychala',
	'description' => 'GlobalFooter',
	'version' => 1.0
);

$wgAutoloadClasses['GlobalFooterController'] =  __DIR__ . '/GlobalFooterController.class.php';
$wgAutoloadClasses['GlobalFooterHooks'] =  __DIR__ . '/hooks/GlobalFooterHooks.class.php';

$wgHooks['SkinCopyrightFooter'][] = 'GlobalFooterHooks::onSkinCopyrightFooter';
$wgHooks['OasisSkinAssetGroups'][] = 'GlobalFooterHooks::onOasisSkinAssetGroups';

$wgExtensionMessagesFiles['GlobalFooter'] = __DIR__ . '/GlobalFooter.i18n.php';
