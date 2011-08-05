<?php
/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname( __FILE__ );

/**
 * model
 */
$app->registerClass('UserProfilePage', $dir . '/UserProfilePage.class.php');
$app->registerClass('UserIdentityBox', $dir . '/UserIdentityBox.class.php');
//we'll implement interview later
//$app->registerClass('Interview', $dir . '/Interview.class.php');
//$app->registerClass('InterviewQuestion', $dir . '/InterviewQuestion.class.php');
$app->registerClass('ImageOperationsHelper', $dir . '/ImageOperationsHelper.class.php');

/**
 * controllers
 */
$app->registerClass('UserProfilePageController', $dir . '/UserProfilePageController.class.php');
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
//we'll implement interview later
//$app->registerHook('GetRailModuleSpecialPageList', 'InterviewSpecialPageController', 'onGetRailModuleSpecialPageList' );

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

if( defined('NS_BLOG_ARTICLE') ) {
	$UPPNamespaces[] = NS_BLOG_ARTICLE;
}

$app->getLocalRegistry()->set( 'UserProfilePageNamespaces', $UPPNamespaces );

$wgLogTypes[] = 'usermasthead';
$wgLogHeaders['usermasthead'] = 'usermasthead-log-alt';
$wgLogNames['usermasthead'] = 'usermasthead-log';