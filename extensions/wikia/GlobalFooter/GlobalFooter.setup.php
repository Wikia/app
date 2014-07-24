<?php

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'GlobalFooter',
	'author' => 'Bogna "bognix" Knychala',
	'description' => 'GlobalFooter',
	'version' => 1.0
);

$wgAutoloadClasses['GlobalFooterController'] =  $dir . 'GlobalFooterController.class.php';
$wgAutoloadClasses['GlobalFooterHooks'] =  $dir . 'hooks/GlobalFooterHooks.class.php';

$wgHooks['SkinCopyrightFooter'][] = 'GlobalFooterHooks::onSkinCopyrightFooter';

$wgExtensionMessagesFiles['GlobalFooter'] = $dir . 'GlobalFooter.i18n.php';
