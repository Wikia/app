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
//we'll implement interview later
//$app->registerClass('Interview', $dir . '/Interview.class.php');
//$app->registerClass('InterviewQuestion', $dir . '/InterviewQuestion.class.php');
$app->registerClass('UserProfilePageRailHelper', $dir . '/UserProfilePageRailHelper.class.php');
$app->registerClass('ImageOperationsHelper', $dir . '/ImageOperationsHelper.class.php');
$app->registerClass('UserAvatarRemovePage', $dir . '/UserAvatarRemovePage.class.php');



/**
 * controllers
 */
$app->registerClass('UserProfilePageController', $dir . '/UserProfilePageController.class.php');
$app->registerClass('Masthead', $dir . '/Masthead.class.php');

//we'll implement interview later
//$app->registerClass('InterviewSpecialPageController', $dir . '/InterviewSpecialPageController.class.php');

/**
 * special pages
 */
//we'll implement interview later
//$app->registerSpecialPage('Interview', 'InterviewSpecialPageController');

/**
 * hooks
 */
$app->registerHook('SkinTemplateOutputPageBeforeExec', 'UserProfilePageController', 'onSkinTemplateOutputPageBeforeExec');
$app->registerHook('SkinSubPageSubtitleAfterTitle', 'UserProfilePageController', 'onSkinSubPageSubtitleAfterTitle');
$app->registerHook('ArticleSaveComplete', 'UserProfilePageController', 'onArticleSaveComplete');
//we'll implement interview later
//$app->registerHook('GetRailModuleSpecialPageList', 'InterviewSpecialPageController', 'onGetRailModuleSpecialPageList' );
$app->registerHook('GetRailModuleList', 'UserProfilePageRailHelper', 'onGetRailModuleList');
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
//we'll implement interview later
//F::addClassConstructor( 'Interview', array( 'app' => $app ) );
//F::addClassConstructor( 'InterviewQuestion', array( 'app' => $app ) );
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

$wgLogTypes[] = 'usermasthead';
$wgLogHeaders['usermasthead'] = 'usermasthead-log-alt';
$wgLogNames['usermasthead'] = 'usermasthead-log';

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

$wgSpecialPages['RemoveUserAvatar'] = 'UserAvatarRemovePage'; # Let MediaWiki know about your new special page.
	
$wgSpecialPageGroups['RemoveUserAvatar'] = 'users';
