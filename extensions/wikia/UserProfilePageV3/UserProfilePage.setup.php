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
 * model
 */
$wgAutoloadClasses['UserProfilePage'] =  $dir . '/UserProfilePage.class.php';
$wgAutoloadClasses['UserIdentityBox'] =  $dir . '/UserIdentityBox.class.php';
$wgAutoloadClasses['UserProfilePageRailHelper'] =  $dir . '/UserProfilePageRailHelper.class.php';
$wgAutoloadClasses['ImageOperationsHelper'] =  $dir . '/ImageOperationsHelper.class.php';

$wgAutoloadClasses['UserProfilePageHelper'] =  $dir . '/UserProfilePageHelper.class.php';

/**
 * controllers
 */
$wgAutoloadClasses['UserProfilePageController'] =  $dir . '/UserProfilePageController.class.php';
$wgAutoloadClasses['Masthead'] =  $dir . '/Masthead.class.php';

/**
 * helper classes (strategies)
 */
$wgAutoloadClasses['UserTagsStrategyBase'] =  $dir . '/strategies/UserTagsStrategyBase.class.php';
$wgAutoloadClasses['UserOneTagStrategy'] =  $dir . '/strategies/UserOneTagStrategy.class.php';
$wgAutoloadClasses['UserTwoTagsStrategy'] =  $dir . '/strategies/UserTwoTagsStrategy.class.php';

/**
 * special pages
 */

/**
 * hooks
 */
$wgAutoloadClasses['UserProfilePageHooks'] =  $dir . '/UserProfilePageHooks.class.php';

$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'UserProfilePageHooks::onSkinTemplateOutputPageBeforeExec';
$wgHooks['BeforeDisplayNoArticleText'][] = 'UserProfilePageHooks::onBeforeDisplayNoArticleText';
$wgHooks['SkinSubPageSubtitleAfterTitle'][] = 'UserProfilePageHooks::onSkinSubPageSubtitleAfterTitle';
$wgHooks['ArticleSaveComplete'][] = 'UserProfilePageHooks::onArticleSaveComplete';
$wgHooks['WikiaMobileAssetsPackages'][] = 'UserProfilePageHooks::onWikiaMobileAssetsPackages';

$wgHooks['GetRailModuleList'][] = 'UserProfilePageRailHelper::onGetRailModuleList';

$wgHooks['ArticleSaveComplete'][] = 'Masthead::userMastheadInvalidateCache';

/**
 * messages
 */
$wgExtensionMessagesFiles['UserProfilePageV3'] = $dir . '/UserProfilePage.i18n.php';
//register messages package for JS
//$app->registerExtensionJSMessagePackage('UPP3_modals', array('user-identity-box-about-date-*'));

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
