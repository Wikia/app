<?php

$wgExtensionCredits[ 'specialpage' ][] = array(
	'name' => 'CorporateFooter',
	'author' => 'Mateusz "Warkot" Warkocki, Bogna "bognix" Knychala',
	'description' => 'CorporateFooter',
	'version' => 1.0
);

$wgAutoloadClasses[ 'CorporateFooterController' ] = __DIR__ . '/CorporateFooterController.class.php';
$wgAutoloadClasses[ 'CorporateFooterHooks' ] = __DIR__ . '/hooks/CorporateFooterHooks.class.php';

$wgHooks[ 'OasisSkinAssetGroups' ][] = 'CorporateFooterHooks::onOasisSkinAssetGroups';

$wgExtensionMessagesFiles[ 'CorporateFooter' ] = __DIR__ . '/CorporateFooter.i18n.php';
