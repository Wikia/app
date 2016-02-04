<?php

/**
 * LicensedVideoSwap
 * @author Garth Webb, Liz Lee, Saipetch Kongkatong
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'LicensedVideoSwap',
	'author' => array( 'Garth Webb', 'Liz Lee', 'Saipetch Kongkatong' ),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/LicensedVideoSwap',
	'descriptionmsg' => 'licensedvideoswap-desc'
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['LicensedVideoSwapSpecialController'] = $dir.'LicensedVideoSwapSpecialController.class.php';
$wgAutoloadClasses['LicensedVideoSwapHelper'] = $dir.'LicensedVideoSwapHelper.class.php';
$wgAutoloadClasses['LicensedVideoSwapHooksHelper'] = $dir.'LicensedVideoSwapHooksHelper.class.php';

// i18n mapping
$wgExtensionMessagesFiles['LicensedVideoSwap'] = $dir.'LicensedVideoSwap.i18n.php';

// Aliases
$wgExtensionMessagesFiles['LicensedVideoSwapAliases'] = __DIR__ . '/LicensedVideoSwap.aliases.php';

// special pages
$wgSpecialPages['LicensedVideoSwap'] = 'LicensedVideoSwapSpecialController';

$wgSpecialPageGroups['LicensedVideoSwap'] = 'media';

// hooks
$wgHooks['PageHeaderIndexExtraButtons'][] = 'LicensedVideoSwapHooksHelper::onPageHeaderIndexExtraButtons';
$wgHooks['OasisAddPageDeletedConfirmationMessage'][] = 'LicensedVideoSwapHooksHelper::onOasisAddPageDeletedConfirmationMessage';

// register messages package for JS
JSMessages::registerPackage('LVS', array(
	'lvs-confirm-keep-title',
	'lvs-confirm-keep-message',
	'lvs-confirm-undo-swap-title',
	'lvs-confirm-undo-swap-message',
	'lvs-confirm-undo-keep-title',
	'lvs-confirm-undo-keep-message',
	'lvs-button-yes',
	'lvs-button-no'
));
