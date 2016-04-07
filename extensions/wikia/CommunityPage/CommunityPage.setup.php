<?php

/* classes */
$wgAutoloadClasses['CommunityPageSpecialUsersModel'] =  __DIR__ . '/models/CommunityPageSpecialUsersModel.class.php';
$wgAutoloadClasses['CommunityPageSpecialWikiModel'] =  __DIR__ . '/models/CommunityPageSpecialWikiModel.class.php';
$wgAutoloadClasses['CommunityPageSpecialHelper'] =  __DIR__ . '/CommunityPageSpecialHelper.class.php';
$wgAutoloadClasses['CommunityPageSpecialController'] =  __DIR__ . '/CommunityPageSpecialController.class.php';
$wgAutoloadClasses['CommunityPageSpecialHooks'] =  __DIR__ . '/CommunityPageSpecialHooks.class.php';

/* hooks */
$wgHooks['GetHTMLBeforeWikiaPage'][] = 'CommunityPageSpecialHooks::getHTMLBeforeWikiaPage';

/* i18n */
$wgExtensionMessagesFiles['CommunityPage'] = __DIR__ . '/CommunityPage.i18n.php';

/* messages exported to JS */
JSMessages::registerPackage( 'CommunityPageSpecial', [
	'communitypage-modal-title',
	'communitypage-modal-loading',
] );

/* register special page */
$wgSpecialPages['Community'] = 'CommunityPageSpecialController';
