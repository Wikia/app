<?php

/**
 * FacebookClient
 *
 * @author James Sutterfield
 * @author Liz Lee
 * @author Garth Webb
 * @author Armon Rabiyan
 *
 * @date 2014-10-21
 */

$wgExtensionCredits['facebookclient'][] = array(
	'name' => 'FacebookClient',
	'author' => array(
		"James Sutterfield <james@wikia-inc.com>",
		"Liz Lee <liz@wikia-inc.com>",
		"Garth Webb <garth@wikia-inc.com>",
		"Armon Rabiyan <armon@wikia-inc.com>",
	),
	'descriptionmsg' => 'fbconnect-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FacebookClient'
);

$dir = dirname( __FILE__ ) . '/';

/**
 * classes
 */
$wgAutoloadClasses['FacebookClient'] =  $dir . 'FacebookClient.class.php';
$wgAutoloadClasses['FacebookClientHelper'] =  $dir . 'FacebookClientHelper.class.php';
$wgAutoloadClasses['FacebookClientLocale'] =  $dir . 'FacebookClientLocale.class.php';
$wgAutoloadClasses['FacebookMapModel'] =  $dir . 'FacebookMapModel.class.php';
$wgAutoloadClasses['FacebookClientFactory'] =  $dir . 'FacebookClientFactory.php';
$wgAutoloadClasses['FacebookClientController'] =  $dir . 'FacebookClientController.class.php';
$wgAutoloadClasses['FacebookClientXFBML'] = $dir . 'FacebookClientXFBML.php';

/**
 * hooks
 */
$wgAutoloadClasses['FacebookClientHooks'] =  $dir . 'FacebookClientHooks.class.php';
$wgHooks['MakeGlobalVariablesScript'][] = 'FacebookClientHooks::MakeGlobalVariablesScript';
$wgHooks['GetHTMLAfterBody'][] = 'FacebookClientHooks::onGetHTMLAfterBody';
$wgHooks['GetPreferences'][] = 'FacebookClientHooks::GetPreferences';
$wgHooks['OasisSkinAssetGroups'][] = 'FacebookClientHooks::onSkinAssetGroups';
$wgHooks['MonobookSkinAssetGroups'][] = 'FacebookClientHooks::onSkinAssetGroups';
$wgHooks['ParserFirstCallInit'][] = 'FacebookClientHooks::setupParserHook';
$wgHooks['SkinTemplatePageBeforeUserMsg'][] = 'FacebookClientHooks::onSkinTemplatePageBeforeUserMsg';
$wgHooks['BeforePageDisplay'][] = 'FacebookClientHooks::onBeforePageDisplay';
$wgHooks['UserLogout'][] = 'FacebookClientHooks::onUserLogout';

/**
 * messages
 */
$wgExtensionMessagesFiles['FacebookClient'] = $dir . 'FacebookClient.i18n.php';

JSMessages::registerPackage( 'FacebookClient', [
	'fbconnect-preferences-connected',
	'fbconnect-disconnect-info-existing',
	'fbconnect-disconnect-info',
	'fbconnect-error-fb-unavailable-title',
	'fbconnect-error-fb-unavailable-text',
] );

