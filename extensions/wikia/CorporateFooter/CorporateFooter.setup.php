<?php

$wgExtensionCredits[ 'specialpage' ][] = array(
	'name' => 'CorporateFooter',
	'author' => array('Mateusz "Warkot" Warkocki', 'Bogna "bognix" Knychala'),
	'descriptionmsg' => 'corporate-footer-desc',
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CorporateFooter'
);

$wgAutoloadClasses[ 'CorporateFooterController' ] = __DIR__ . '/CorporateFooterController.class.php';
$wgAutoloadClasses[ 'CorporateFooterHooks' ] = __DIR__ . '/hooks/CorporateFooterHooks.class.php';

$wgHooks[ 'OasisSkinAssetGroups' ][] = 'CorporateFooterHooks::onOasisSkinAssetGroups';

$wgExtensionMessagesFiles[ 'CorporateFooter' ] = __DIR__ . '/CorporateFooter.i18n.php';
