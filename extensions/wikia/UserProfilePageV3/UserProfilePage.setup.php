<?php
/**
 * @var WikiaApp
 */
$dir = dirname( __FILE__ );

define ('AVATAR_DEFAULT_WIDTH', 200);
define ('AVATAR_DEFAULT_HEIGHT', 200);
define ('AVATAR_LOG_NAME', 'useravatar');
define ('AVATAR_USER_OPTION_NAME', 'avatar');
define ('AVATAR_MAX_SIZE', 512000 );
define ('AVATAR_UPLOAD_FIELD', 'wkUserAvatar');

/**
 * models
 */
$wgAutoloadClasses['UserProfilePage'] =  $dir . '/UserProfilePage.class.php';
$wgAutoloadClasses['UserIdentityBox'] =  $dir . '/UserIdentityBox.class.php';
$wgAutoloadClasses['UserProfilePageRailHelper'] =  $dir . '/UserProfilePageRailHelper.class.php';
$wgAutoloadClasses['ImageOperationsHelper'] =  $dir . '/ImageOperationsHelper.class.php';
$wgAutoloadClasses['FavoriteWikisModel'] =  $dir . '/models/FavoriteWikisModel.class.php';

$wgAutoloadClasses['UserProfilePageHelper'] =  $dir . '/UserProfilePageHelper.class.php';

/**
 * controllers
 */
$wgAutoloadClasses['UserProfilePageController'] =  $dir . '/UserProfilePageController.class.php';
$wgAutoloadClasses['Masthead'] =  $dir . '/Masthead.class.php';

/**
 * helper classes (strategies)
 */
$wgAutoloadClasses['UserTagsStrategyBase'] = $dir . '/strategies/UserTagsStrategyBase.class.php';
$wgAutoloadClasses['UserOneTagStrategy'] = $dir . '/strategies/UserOneTagStrategy.class.php';
$wgAutoloadClasses['UserTwoTagsStrategy'] = $dir . '/strategies/UserTwoTagsStrategy.class.php';

/**
 * helpers
 */
$wgAutoloadClasses['UserWikisFilter'] = $dir . '/filters/UserWikisFilter.class.php';
$wgAutoloadClasses['HiddenWikisFilter'] = $dir . '/filters/HiddenWikisFilter.class.php';
$wgAutoloadClasses['UserWikisFilterDecorator'] = $dir . '/filters/UserWikisFilterDecorator.class.php';
$wgAutoloadClasses['UserWikisFilterUniqueDecorator'] = $dir . '/filters/UserWikisFilterUniqueDecorator.class.php';
$wgAutoloadClasses['UserWikisFilterRestrictedDecorator'] = $dir . '/filters/UserWikisFilterRestrictedDecorator.class.php';
$wgAutoloadClasses['UserWikisFilterPrivateDecorator'] = $dir . '/filters/UserWikisFilterPrivateDecorator.class.php';

/**
 * hooks
 */
$wgAutoloadClasses['UserProfilePageHooks'] =  $dir . '/UserProfilePageHooks.class.php';

$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'UserProfilePageHooks::onSkinTemplateOutputPageBeforeExec';
$wgHooks['SkinSubPageSubtitleAfterTitle'][] = 'UserProfilePageHooks::onSkinSubPageSubtitleAfterTitle';
$wgHooks['ArticleSaveComplete'][] = 'UserProfilePageHooks::onArticleSaveComplete';
$wgHooks['WikiaMobileAssetsPackages'][] = 'UserProfilePageHooks::onWikiaMobileAssetsPackages';

$wgHooks['WikiFactoryChanged'][] = 'UserProfilePageHooks::onWikiFactoryChanged';
$wgHooks['WikiFactoryVariableRemoved'][] = 'UserProfilePageHooks::onWikiFactoryVariableRemoved';

$wgHooks['GetRailModuleList'][] = 'UserProfilePageRailHelper::onGetRailModuleList';

$wgHooks['ArticleSaveComplete'][] = 'Masthead::userMastheadInvalidateCache';

/**
 * messages
 */
$wgExtensionMessagesFiles['UserProfilePageV3'] = $dir . '/UserProfilePage.i18n.php';

//register messages package for JS
JSMessages::registerPackage( 'UserProfilePageV3', array(
	'userprofilepage-edit-modal-header',
	'user-identity-box-avatar-cancel',
	'user-identity-box-avatar-save',
	'userprofilepage-closing-popup-header',
	'userprofilepage-closing-popup-save-and-quit',
	'userprofilepage-closing-popup-discard-and-quit',
	'userprofilepage-closing-popup-cancel',
	'userprofilepage-edit-modal-error'
) );
/**
 * extension related configuration
 */
$UPPNamespaces = array();
$UPPNamespaces[] = NS_USER;
$UPPNamespaces[] = NS_USER_TALK;

if( defined('NS_USER_WALL') ) {
	$UPPNamespaces[] = NS_USER_WALL;
}

if( defined('NS_BLOG_ARTICLE') ) {
	$UPPNamespaces[] = NS_BLOG_ARTICLE;
}

$wgLogTypes[] = AVATAR_LOG_NAME;
$wgLogHeaders[AVATAR_LOG_NAME] = 'blog-avatar-alt';
$wgLogNames[AVATAR_LOG_NAME] = "useravatar-log";
$wgLogActions[AVATAR_LOG_NAME . '/avatar_chn'] = 'blog-avatar-changed-log';
$wgLogActions[AVATAR_LOG_NAME . '/avatar_rem'] = 'blog-avatar-removed-log';

#--- permissions
$wgAvailableRights[] = 'removeavatar';
$wgGroupPermissions['staff']['removeavatar'] = true;
#$wgGroupPermissions['sysop']['removeavatar'] = true;
$wgGroupPermissions['helper']['removeavatar'] = true;


//new right for dropdown menu of action button
$wgGroupPermissions['sysop']['renameprofilev3'] = true;
$wgGroupPermissions['vstf']['renameprofilev3'] = true;
$wgGroupPermissions['staff']['renameprofilev3'] = true;
$wgGroupPermissions['helper']['renameprofilev3'] = true;

$wgGroupPermissions['sysop']['deleteprofilev3'] = true;
$wgGroupPermissions['vstf']['deleteprofilev3'] = true;
$wgGroupPermissions['staff']['deleteprofilev3'] = true;
$wgGroupPermissions['helper']['deleteprofilev3'] = true;

//new right to edit profile v3
$wgGroupPermissions['staff']['editprofilev3'] = true;
$wgGroupPermissions['vstf']['editprofilev3'] = true;
$wgGroupPermissions['helper']['editprofilev3'] = true;

$wgSpecialPageGroups['RemoveUserAvatar'] = 'users';
