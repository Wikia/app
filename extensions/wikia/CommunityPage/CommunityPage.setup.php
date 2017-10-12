<?php

/* models */
$wgAutoloadClasses['CommunityPageDefaultCardsModel'] = __DIR__ . '/models/CommunityPageDefaultCardsModel.class.php';
$wgAutoloadClasses['CommunityPageShortPagesCardModel'] = __DIR__ . '/models/CommunityPageShortPagesCardModel.class.php';
$wgAutoloadClasses['CommunityPageSpecialTopAdminsFormatter'] = __DIR__ . '/models/CommunityPageSpecialTopAdminsFormatter.class.php';
$wgAutoloadClasses['CommunityPageSpecialUsersModel'] =  __DIR__ . '/models/CommunityPageSpecialUsersModel.class.php';
$wgAutoloadClasses['CommunityPageSpecialWikiModel'] =  __DIR__ . '/models/CommunityPageSpecialWikiModel.class.php';
$wgAutoloadClasses['CommunityPageSpecialInsightsModel'] =  __DIR__ . '/models/CommunityPageSpecialInsightsModel.class.php';
$wgAutoloadClasses['CommunityPageSpecialHelpModel'] =  __DIR__ . '/models/CommunityPageSpecialHelpModel.class.php';
$wgAutoloadClasses['CommunityPageSpecialCommunityTodoListModel'] =  __DIR__ . '/models/CommunityPageSpecialCommunityTodoListModel.class.php';

/* controller */
$wgAutoloadClasses['CommunityPageSpecialController'] =  __DIR__ . '/CommunityPageSpecialController.class.php';
$wgAutoloadClasses['CommunityPageSpecialHooks'] =  __DIR__ . '/CommunityPageSpecialHooks.class.php';
$wgAutoloadClasses['CommunityPageEntryPointController'] = $IP . '/skins/oasis/modules/CommunityPageEntryPointController.class.php';

/* helpers */
$wgAutoloadClasses['WikiTopic'] = __DIR__ . '/helpers/WikiTopic.php';
$wgAutoloadClasses['LinkHelper'] = __DIR__ . '/helpers/LinkHelper.php';

/* hooks */
$wgAutoloadClasses['CommunityPageSpecialHooks'] =  __DIR__ . '/CommunityPageSpecialHooks.class.php';
$wgHooks['ArticleSaveComplete'][] = 'CommunityPageSpecialHooks::onArticleSaveComplete';
$wgHooks['UserFirstEditOnLocalWiki'][] = 'CommunityPageSpecialHooks::onUserFirstEditOnLocalWiki';
$wgHooks['BeforePageDisplay'][] = 'CommunityPageSpecialHooks::onBeforePageDisplay';
$wgHooks['UserRights'][] = 'CommunityPageSpecialHooks::onUserRights';
$wgHooks['ResourceLoaderGetConfigVars'][] = 'CommunityPageSpecialHooks::onResourceLoaderGetConfigVars';

/* i18n */

/* messages exported to JS */
JSMessages::registerPackage( 'CommunityPageSpecial', [
	'communitypage-modal-tab-all',
	'communitypage-modal-tab-admins',
	'communitypage-modal-title',
	'communitypage-modal-tab-loading',
	'communitypage-modal-tab-loadingerror',
	'communitypage-top-contributors-week',
] );

JSMessages::registerPackage( 'CommunityPageBenefits', [
	'communitypage-entrypoint-modal-*'
] );

/* register special page */
$wgSpecialPages['Community'] = 'CommunityPageSpecialController';
