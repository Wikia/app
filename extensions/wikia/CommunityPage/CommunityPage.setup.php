<?php

/* classes */
$wgAutoloadClasses['CommunityPageSpecialTopAdminsFormatter'] = __DIR__ . '/models/CommunityPageSpecialTopAdminsFormatter.class.php';
$wgAutoloadClasses['CommunityPageSpecialUsersModel'] =  __DIR__ . '/models/CommunityPageSpecialUsersModel.class.php';
$wgAutoloadClasses['CommunityPageSpecialWikiModel'] =  __DIR__ . '/models/CommunityPageSpecialWikiModel.class.php';
$wgAutoloadClasses['CommunityPageSpecialController'] =  __DIR__ . '/CommunityPageSpecialController.class.php';
$wgAutoloadClasses['CommunityPageSpecialHooks'] =  __DIR__ . '/CommunityPageSpecialHooks.class.php';

/* hooks */
$wgHooks['ArticleSaveComplete'][] = 'CommunityPageSpecialHooks::onArticleSaveComplete';

/* i18n */
$wgExtensionMessagesFiles['CommunityPage'] = __DIR__ . '/CommunityPage.i18n.php';

/* messages exported to JS */
JSMessages::registerPackage( 'CommunityPageSpecial', [
	'communitypage-modal-tab-all',
	'communitypage-modal-tab-admins',
	'communitypage-modal-tab-leaderboard',
	'communitypage-modal-title',
	'communitypage-modal-tab-loading',
	'communitypage-modal-tab-loadingerror',
] );

/* register special page */
$wgSpecialPages['Community'] = 'CommunityPageSpecialController';
