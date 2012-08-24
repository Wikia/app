<?php
/**
 * @var WikiaApp
 */
$app = F::app();
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
$app->registerClass('UserProfilePage', $dir . '/UserProfilePage.class.php');
$app->registerClass('UserIdentityBox', $dir . '/UserIdentityBox.class.php');
$app->registerClass('UserProfilePageRailHelper', $dir . '/UserProfilePageRailHelper.class.php');
$app->registerClass('ImageOperationsHelper', $dir . '/ImageOperationsHelper.class.php');

/**
 * controllers
 */
$app->registerClass('UserProfilePageController', $dir . '/UserProfilePageController.class.php');
$app->registerClass('Masthead', $dir . '/Masthead.class.php');

/**
 * helper classes (strategies)
 */
$app->registerClass('UserTagsStrategyBase', $dir . '/strategies/UserTagsStrategyBase.class.php');
$app->registerClass('UserOneTagStrategy', $dir . '/strategies/UserOneTagStrategy.class.php');
$app->registerClass('UserTwoTagsStrategy', $dir . '/strategies/UserTwoTagsStrategy.class.php');

/**
 * special pages
 */

/**
 * hooks
 */
$app->registerHook('SkinTemplateOutputPageBeforeExec', 'UserProfilePageController', 'onSkinTemplateOutputPageBeforeExec');
$app->registerHook('SkinSubPageSubtitleAfterTitle', 'UserProfilePageController', 'onSkinSubPageSubtitleAfterTitle');
$app->registerHook('ArticleSaveComplete', 'UserProfilePageController', 'onArticleSaveComplete');
$app->registerHook('GetRailModuleList', 'UserProfilePageRailHelper', 'onGetRailModuleList');
$app->registerHook('WikiaMobileAssetsPackages', 'UserProfilePageController', 'onWikiaMobileAssetsPackages');
$app->registerHook('BeforeDisplayNoArticleText', 'UserProfilePageController', 'onBeforeDisplayNoArticleText');

$app->registerHook('ArticleSaveComplete', 'Masthead', 'userMastheadInvalidateCache');

/**
 * messages
 */
$app->registerExtensionMessageFile('UserProfilePageV3', $dir . '/UserProfilePage.i18n.php');
//register messages package for JS
//$app->registerExtensionJSMessagePackage('UPP3_modals', array('user-identity-box-about-date-*'));

/**
 * DI setup
 */
F::addClassConstructor( 'UserProfilePage', array( 'app' => $app ) );
F::addClassConstructor( 'UserProfilePageController', array( 'app' => $app ) );

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

$app->getLocalRegistry()->set( 'UserProfilePageNamespaces', $UPPNamespaces );

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
