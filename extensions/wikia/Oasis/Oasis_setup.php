<?php
/**
 * Oasis
 *
 * Provides an easy way to add hooks for Oasis skin modules
 *
 * @author Maciej Brencz
 */

$wgExtensionCredits['other'][] = [
	'name' => 'Oasis Skin',
	'version' => '1.0',
	'author' => 'Maciej Brencz',
	'descriptionmsg' => 'oasis-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Oasis'
];

// Messages
$wgExtensionMessagesFiles['Oasis'] = __DIR__ . '/Oasis.i18n.php';

$wgExtensionFunctions[] = 'wfOasisSetup';

function wfOasisSetup() {
	global $wgHooks;

	// modules and services
	$wgHooks['ArticleSaveComplete'][] = 'LatestActivityController::onArticleSaveComplete';
	$wgHooks['DoEditSectionLink'][] = 'ContentDisplayController::onDoEditSectionLink';
	$wgHooks['EditPage::showEditForm:initial'][] = 'BodyController::onEditPageRender';
	$wgHooks['MakeHeadline'][] = 'ContentDisplayController::onMakeHeadline';
	$wgHooks['Parser::showEditLink'][] = 'ContentDisplayController::onShowEditLink';

	// notifications
	$wgHooks['AchievementsNotification'][] = 'NotificationsController::addBadgeNotification';
	$wgHooks['CommunityMessages::showMessage'][] = 'NotificationsController::addCommunityMessagesNotification';
	$wgHooks['EditSimilar::showMessage'][] = 'NotificationsController::addEditSimilarNotification';
	$wgHooks['SiteWideMessagesNotification'][] = 'NotificationsController::addSiteWideMessageNotification';
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'NotificationsController::addMessageNotification';

	// misc
	$wgHooks['MakeGlobalVariablesScript'][] = 'OasisController::onMakeGlobalVariablesScript';
	$wgHooks['MakeGlobalVariablesScript'][] = 'ArticleInterlangController::onMakeGlobalVariablesScript';

	// support "noexternals" URL param
	global $wgNoExternals, $wgRequest;
	$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

	//Oasis-navigation-v2 messages
	$jsMessages = new JSMessages();
	$jsMessages->registerPackage('Oasis-navigation-v2', array(
		'oasis-navigation-v2-*'
	));

	$jsMessages->registerPackage('Oasis-mobile-switch', array(
		'oasis-mobile-site'
	));

	// Generic messages that can be used by all extensions such as error messages
	$jsMessages->registerPackage( 'Oasis-generic', [
		'oasis-generic-error',
	] );
	$jsMessages->enqueuePackage( 'Oasis-generic', JSMessages::EXTERNAL );
}


// Mapping of themename to an array of key/value pairs to send to SASS.
// Sean says: Since SASS is used to generate the CSS files, this config is all that's needed for the themes.

global $wgResourceBasePath;

$wgOasisThemes = array(
	'oasis' => array(
		'color-body' => '#BACDD8',
		'color-page' => '#FFFFFF',
		'color-buttons' => '#006CB0',
		'color-community-header' => '#006CB0',
		'color-links' => '#006CB0',
		'color-header' => '#3A5766',
		'background-image' => $wgResourceBasePath . '/skins/oasis/images/themes/oasis.png',
		'background-align' => 'center',
		'background-fixed' => 'false',
		'background-tiled' => 'true',
		'page-opacity' => '100'
	),
	'jade' => array(
		'color-body' => '#003816',
		'color-page' => '#FFFFFF',
		'color-buttons' => '#25883D',
		'color-community-header' => '#25883D',
		'color-links' => '#2B54B5',
		'color-header' => '#002C11',
		'background-image' => '',
		'background-align' => 'center',
		'background-fixed' => 'false',
		'background-tiled' => 'false',
		'page-opacity' => '100'
	),
	'babygirl' => array(
		'color-body' => '#000000',
		'color-page' => '#FFFFFF',
		'color-buttons' => '#6F027C',
		'color-community-header' => '#6F027C',
		'color-links' => '#6F027C',
		'color-header' => '#2A1124',
		'background-image' => $wgResourceBasePath . '/skins/oasis/images/themes/babygirl.jpg',
		'background-align' => 'center',
		'background-fixed' => 'false',
		'background-tiled' => 'false',
		'page-opacity' => '100'
	),
	'carbon' => array(
		'color-body' => '#1A1A1A',
		'color-page' => '#474646',
		'color-buttons' => '#012E59',
		'color-community-header' => '#012E59',
		'color-links' => '#70B8FF',
		'color-header' => '#012E59',
		'background-image' => $wgResourceBasePath . '/skins/oasis/images/themes/carbon.png',
		'background-align' => 'center',
		'background-tiled' => 'false',
		'page-opacity' => '100'
	),
	'rockgarden' => array(
		'color-body' => '#525833',
		'color-page' => '#DFDBC3',
		'color-buttons' => '#1F5D04',
		'color-community-header' => '#1F5D04',
		'color-links' => '#1F5D04',
		'color-header' => '#04180C',
		'background-image' => $wgResourceBasePath . '/skins/oasis/images/themes/rockgarden.jpg',
		'background-align' => 'center',
		'background-fixed' => 'false',
		'background-tiled' => 'false',
		'page-opacity' => '100'
	),
	'opulence' => array(
		'color-body' => '#AD3479',
		'color-page' => '#FFFFFF',
		'color-buttons' => '#DE1C4E',
		'color-community-header' => '#DE1C4E',
		'color-links' => '#810484',
		'color-header' => '#610038',
		'background-image' => $wgResourceBasePath . '/skins/oasis/images/themes/opulence.png',
		'background-align' => 'center',
		'background-fixed' => 'false',
		'background-tiled' => 'true',
		'page-opacity' => '100'
	),
	'bluesteel' => array(
		'color-body' => '#303641',
		'color-page' => '#FFFFFF',
		'color-buttons' => '#0A3073',
		'color-community-header' => '#0A3073',
		'color-links' => '#0A3073',
		'color-header' => '#0A3073',
		'background-image' => $wgResourceBasePath . '/skins/oasis/images/themes/bluesteel.jpg',
		'background-align' => 'center',
		'background-fixed' => 'false',
		'background-tiled' => 'false',
		'page-opacity' => '100'
	),
	'creamsicle' => array(
		'color-body' => '#F8E9AE',
		'color-page' => '#FBE7B5',
		'color-buttons' => '#FE7E03',
		'color-community-header' => '#FE7E03',
		'color-links' => '#AF4200',
		'color-header' => '#A1774F',
		'background-image' => $wgResourceBasePath . '/skins/oasis/images/themes/creamsicle.jpg',
		'background-align' => 'center',
		'background-fixed' => 'false',
		'background-tiled' => 'false',
		'page-opacity' => '100'
	),
	'plated' => array(
		'color-body' => '#060606',
		'color-page' => '#474646',
		'color-buttons' => '#092F71',
		'color-community-header' => '#092F71',
		'color-links' => '#FFD500',
		'color-header' => '#000000',
		'background-image' => $wgResourceBasePath . '/skins/oasis/images/themes/plated.jpg',
		'background-align' => 'center',
		'background-fixed' => 'false',
		'background-tiled' => 'false',
		'page-opacity' => '100'
	),
	'police' => array(
		'color-body' => '#000000',
		'color-page' => '#0F142F',
		'color-buttons' => '#1A52AC',
		'color-community-header' => '#1A52AC',
		'color-links' => '#D6AD0B',
		'color-header' => '#181010',
		'background-image' => $wgResourceBasePath . '/skins/oasis/images/themes/lights.jpg',
		'background-align' => 'center',
		'background-fixed' => 'false',
		'background-tiled' => 'false',
		'page-opacity' => '100'
	),
	'aliencrate' => array(
		'color-body' => '#484534',
		'color-page' => '#DAD5CB',
		'color-buttons' => '#653F03',
		'color-community-header' => '#653F03',
		'color-links' => '#02899D',
		'color-header' => '#433E1F',
		'background-image' => $wgResourceBasePath . '/skins/oasis/images/themes/aliencrate.jpg',
		'background-align' => 'center',
		'background-fixed' => 'false',
		'background-tiled' => 'false',
		'page-opacity' => '100'
	),
);
