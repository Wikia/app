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
);

$dir = dirname( __FILE__ ) . '/';

/**
 * classes
 */
$wgAutoloadClasses['FacebookClient'] =  $dir . 'FacebookClient.class.php';
$wgAutoloadClasses['FacebookClientHelper'] =  $dir . 'FacebookClientHelper.class.php';
$wgAutoloadClasses['FacebookClientController'] =  $dir . 'FacebookClientController.class.php';
$wgAutoloadClasses['FacebookClientLocale'] =  $dir . 'FacebookClientLocale.class.php';
$wgAutoloadClasses['FacebookMapModel'] =  $dir . 'FacebookMapModel.class.php';
$wgAutoloadClasses['SpecialFacebookConnectController'] =  $dir . 'SpecialFacebookConnectController.class.php';
$wgAutoloadClasses['FacebookClientXFBML'] = $dir . 'FacebookClientXFBML.php';

/**
 * hooks
 */
$wgAutoloadClasses['FacebookClientHooks'] =  $dir . 'FacebookClientHooks.class.php';
$wgHooks['MakeGlobalVariablesScript'][] = 'FacebookClientHooks::MakeGlobalVariablesScript';
$wgHooks['SkinAfterBottomScripts'][] = 'FacebookClientHooks::SkinAfterBottomScripts';
$wgHooks['GetPreferences'][] = 'FacebookClientHooks::GetPreferences';
$wgHooks['OasisSkinAssetGroups'][] = 'FacebookClientHooks::onSkinAssetGroups';
$wgHooks['MonobookSkinAssetGroups'][] = 'FacebookClientHooks::onSkinAssetGroups';
$wgHooks['ParserFirstCallInit'][] = 'FacebookClientHooks::setupParserHook';

// special pages
$wgSpecialPages[ 'FacebookConnect' ] =  'SpecialFacebookConnectController';

/**
 * messages
 */
$wgExtensionMessagesFiles['FacebookClient'] = $dir . 'FacebookClient.i18n.php';

/**
 * ResourceLoader modules
 */
$wgResourceModules['ext.wikia.FacebookClient.XFBML'] = [
	'scripts' => 'scripts/FacebookClient.XFBML.js',
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/FacebookClient',
];

JSMessages::registerPackage( 'FacebookClient', [
	'fbconnect-logout-confirm',
	'fbconnect-preferences-connected',
	'fbconnect-preferences-connected-error',
	'fbconnect-disconnect-info-existing',
	'fbconnect-disconnect-info',
] );

